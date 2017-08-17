<?
	$intCartPrice				= $intCartPriceTotal		= $intCartPointTotal	= $intCartDeliveryPriceTotal = 0;
	$intCartProdCouponUsePriceTotal	= $intCartProdCouponUsePriceUsdTotal = 0; //해당 상품이 이벤트 상품일 경우 쿠폰 결제를 사용하지 않을 경우 쿠폰금액 제외

	$intCartPointUsePrice		= $intCartPointNoUsePrice	= $intCartPointNoUseCnt = 0;
	$intForDeliveryPriceProdCnt = 0; //해외결제시 배송비가 있는 상품수
	$intDeliveryPriceProdCnt	= 0; //국내결제시 배송비가 있는 상품수

	$aryDeliveryFixProduct		= "";
	for($i=1;$i<=5;$i++){
		$aryDeliveryPrice[$i] = 0;
	}

	$intCartCount				= 0;
	$arrCartRow					= "";
	while ($cartRow = mysql_fetch_array($cartResult))
	{
		## 입점형일때 배송비관련 ROWSPAN 수
		if ($S_MALL_TYPE != "R")
		{
			$intRowSpan		= 0;
			if (($intShopNo != "0" && !$intShopNo) || ($intShopNo != $cartRow[P_SHOP_NO])) {
				$intShopNo	= ($cartRow[P_SHOP_NO])?$cartRow[P_SHOP_NO]:"0";
				$intRowSpan = $aryProdBasketShopList[$intShopNo][BASKET_CNT];
			}
		}

		## 이벤트 상품 확인
		$strCartProdEventYN				= getProdEventInfo($cartRow);

		## 상품 가격(할인가격)
		$cartRow['PB_PRICE']			= getProdDiscountPrice($cartRow,"3",$cartRow['PB_PRICE']);

		## 상품가격(통합수량할인)
		if ($S_ALL_DISCOUNT_USE == "Y"){
			$cartRow['PB_PRICE']		= getProdAllDiscount($cartRow['PB_PRICE'],$cartRow['PB_QTY']);
		}

		$intProdPrice					= getCurToPriceSave($cartRow['PB_PRICE']);
		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") {
			$intProdPrice				= getCurToPriceSave($cartRow['PB_PRICE'],"US");
			$intProdPriceOrg			= getCurToPriceSave($cartRow['PB_PRICE']);
		}

		## 상품 총 합계(금액 * 수량)
		$intCartPrice					= ($cartRow['PB_PRICE'] * $cartRow['PB_QTY']) + $cartRow['PB_ADD_OPT_PRICE'];
		$intCartPriceTotal			   += $intCartPrice;

		##기준통화에서 현재 언어 통화로 변경시 환율 오차가 발생하여 상품금액을 현재통화로 변경 후 계산 */
		$strPriceCurLeftMark			= getCurMark();
		$strPriceCurRightMark			= getCurMark2();

		$strProdPriceCurText			= $strPriceCurLeftMark." ".getFormatPrice($intProdPrice,2).$strPriceCurRightMark;
		$strProdAddPriceCurText			= "";
		if ($cartRow['PB_ADD_OPT_PRICE'] > 0){
			$strProdAddPriceCurText		= $strPriceCurLeftMark." ".getCurToPrice($cartRow['PB_ADD_OPT_PRICE']).$strPriceCurRightMark;
		}

		$intCartPriceCur				= ($intProdPrice * $cartRow['PB_QTY']) + getCurToPriceSave($cartRow['PB_ADD_OPT_PRICE']);
		$strCartPriceCurText			= $strPriceCurLeftMark." ".getFormatPrice($intCartPriceCur,2).$strPriceCurRightMark;

		$strProdPriceOrgText			= "";
		$strProdAddPriceOrgText			= "";
		$strCartPriceOrgText			= "";

		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")
		{
			$strPriceCurLeftMark		= getCurMark("USD");
			$strPriceCurRightMark		= getCurMark2("USD");

			$strPriceOrgLeftMark		= $S_SITE_CUR_MARK1;
			$strPriceOrgRightMark		= "";

			$strProdPriceCurText		= $strPriceCurLeftMark.getFormatPrice($intProdPrice,2).$strPriceCurRightMark;
			$strProdPriceOrgText		= "(".$strPriceOrgLeftMark.getFormatPrice($intProdPriceOrg,2).")";

			$strProdAddPriceCurText		= "";
			if ($cartRow['PB_ADD_OPT_PRICE'] > 0){
				$strProdAddPriceCurText = $strPriceCurLeftMark.getCurToPrice($cartRow['PB_ADD_OPT_PRICE'],"US").$strPriceCurRightMark;
				$strProdAddPriceOrgText = "(".$strPriceOrgLeftMark.getCurToPrice($cartRow['PB_ADD_OPT_PRICE']).")";
			}

			$intCartPriceCur			= ($intProdPrice * $cartRow['PB_QTY']) + getCurToPriceSave($cartRow['PB_ADD_OPT_PRICE'],"US");
			$strCartPriceCurText		= $strPriceCurLeftMark.getFormatPrice($intCartPriceCur,2,"USD").$strPriceCurRightMark;

			$intCartPriceOrg			= ($intProdPriceOrg * $cartRow['PB_QTY']) + getCurToPriceSave($cartRow['PB_ADD_OPT_PRICE']);
			$intCartPriceTotalOrg      += $intCartPriceOrg;

			$strCartPriceOrgText		= "(".$strPriceOrgLeftMark.getFormatPrice($intCartPriceOrg,2).")";
		}
		$intCartPriceTotalCur += $intCartPriceCur;

		## 배송비설정

		$strDeliveryPriceText	= "";
		$intDeliveryPrice		= getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice,$cartRow['PB_QTY']);
		if($S_SITE_LNG == "KR")
		{
			/* 고정배송비일경우 옵션/수량/금액에 상관없이 무조건 고정배송비 */
			if ($cartRow['P_BAESONG_TYPE'] == "3"){
				if (is_array($aryDeliveryFixProduct)) {
					 if (!in_array($cartRow['P_CODE'],$aryDeliveryFixProduct)) {
						$aryDeliveryFixProduct = array_push($aryDeliveryFixProduct, $cartRow['P_CODE']);
					 } else {
						$intDeliveryPrice = 0;
					 }
				} else $aryDeliveryFixProduct = array($cartRow['P_CODE']);
			}

			$strDeliveryPriceText			= "";
			switch($cartRow['P_BAESONG_TYPE']){
				case "3":
					$strDeliveryPriceText	= "(고정배송비:".getCurToPrice($cartRow['P_BAESONG_PRICE']).getCurMark2().")";
				break;
				case "4":
					$strDeliveryPriceText	= "(수량별배송비:".getCurToPrice($cartRow['P_BAESONG_PRICE']).getCurMark2().")";
				break;
				case "5":
					$strDeliveryPriceText	= "(착불:".getCurToPrice($cartRow['P_BAESONG_PRICE']).getCurMark2().")";
				break;
			}

		} else {
			## 해외배송 : 수량별 배송
			if ($S_DELIVERY_FOR_MTH == "B"){
				if ($cartRow['P_BAESONG_TYPE'] == "4"){

					if ($cartRow['P_BAESONG_TYPE'] == "4"){
						$cartRow['CART_COUNT'] = $intCartCount + 1;
					}
					$intDeliveryPrice		= getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice,$cartRow['PB_QTY']);
					$strDeliveryPriceText	= $LNG_TRANS_CHAR["PW00012"].":".getCurMark()." ".getCurToPrice($intDeliveryPrice).getCurMark2();
				}
			}
		}
		$aryDeliveryPrice[$cartRow['P_BAESONG_TYPE']] += $intDeliveryPrice;


		## 상품구매시 적립포인트
		if ($cartRow['PB_OPT_NO']){
			$productMgr->setP_LNG($S_ST_LNG);
			$productMgr->setP_CODE($cartRow['P_CODE']);
			$productMgr->setPOA_NO($cartRow['PB_OPT_NO']);
			$aryProdOptAttr = $productMgr->getProdOptAttr($db);
			$intProdPoint = ($aryProdOptAttr[0]['POA_POINT']) ? $aryProdOptAttr[0]['POA_POINT'] : $cartRow['P_POINT'];
			$intCartPoint = getProdPoint($cartRow['PB_PRICE'], $intProdPoint, $cartRow['P_POINT_TYPE'], $cartRow['P_POINT_OFF1'], $cartRow['P_POINT_OFF2']);
		} else {
			$intCartPoint = getProdPoint($cartRow['PB_PRICE'], $cartRow['P_POINT'], $cartRow['P_POINT_TYPE'], $cartRow['P_POINT_OFF1'], $cartRow['P_POINT_OFF2']);
		}

		## 이벤트 상품시 적립포인트 지급 여부 확인
		if ($strCartProdEventYN == "Y"){
			if ($S_EVENT_INFO[$cartRow['P_EVENT']]['GIVE_POINT'] == "N"){
				$intCartPoint = 0;
			}

			if ($S_EVENT_INFO[$cartRow['P_EVENT']]['SE_COUPON_USE'] == "Y"){
				$intCartProdCouponUsePriceTotal		= $intCartProdCouponUsePriceTotal	 + $intCartPrice;
				if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
					$intCartProdCouponUsePriceUsdTotal	= $intCartProdCouponUsePriceUsdTotal + $intCartPriceCur;
				}
			}
		} else {
			$intCartProdCouponUsePriceTotal = $intCartProdCouponUsePriceTotal + $intCartPrice;
			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$intCartProdCouponUsePriceUsdTotal	= $intCartProdCouponUsePriceUsdTotal + $intCartPriceCur;
			}
		}

		$intCartPointTotal += ($intCartPoint * $cartRow['PB_QTY']);
		## 상품옵션리스트
		$strCartOptAttrVal = "";
		for($kk=1;$kk<=10;$kk++){
			if ($cartRow["PB_OPT_ATTR".$kk]){
				$strCartOptAttrVal .= "/".$cartRow["PB_OPT_ATTR".$kk];
			}
		}
		$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

		## 포인트 사용불가 상품
		if ($cartRow['P_POINT_NO_USE'] == "Y") {
			$intCartPointNoUsePrice += $intCartPrice;
			$intCartPointNoUseCnt++;
		}

		/* 해외 결제일때 배송비를 내는 상품인지 확인 */
		if ($S_SITE_LNG != "KR" || in_array($S_SITE_LNG,$S_FIX_ORDER_DELIVERY_USE_LNG)){
			/* 프리스타일 사용 */
			if (is_array($S_FIX_ORDER_DELIVERY_PROD_CATE)){
				if (in_array(substr($cartRow['P_CATE'],0,3),$S_FIX_ORDER_DELIVERY_PROD_CATE)){
					$intForDeliveryPriceProdCnt++;
					$intDeliveryPriceProdCnt++;
				}
			}
		}

		/* 배송비 (무게) 설정 */
		$intProdWeight      = ($cartRow['P_WEIGHT'] > 0) ? $cartRow['P_WEIGHT'] : "0";
		$intCartProdWeight += ($intProdWeight * $cartRow['PB_QTY']);
		/* 배송비 (무게) 설정 */

		## 옵션 리스트
		$strCartOptAttrVal = "";
		for($kk=1;$kk<=10;$kk++){
			if ($cartRow["PB_OPT_ATTR".$kk]){
				$strCartOptAttrVal .= "/".$cartRow["PB_OPT_ATTR".$kk];
			}
		}
		$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

		## 상품추가옵션
		$productMgr->setPB_NO($cartRow['PB_NO']);
		$aryProdCartAddOptList = $productMgr->getProdBasketAddList($db);
		$strCartAddOptAttrVal	= "";
		if (is_array($aryProdCartAddOptList)){
			for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
				$strCartAddOptAttrVal .= "<li>".$LNG_TRANS_CHAR['OW00006'].":".$aryProdCartAddOptList[$k]['PBA_OPT_NM']."</li>";
			}
		}

		## 상품추가항목사용
		$aryProdCartItemList	 = "";
		$strCartItemVal			= "";
		if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
			$aryProdCartItemList = $productMgr->getProdBasketItemList($db);
			if (is_array($aryProdCartItemList)){
				for($k=0;$k<sizeof($aryProdCartItemList);$k++){
					$strCartItemVal .= "<li>".$aryProdCartItemList[$k]['PBI_ITEM_NM'].":".$aryProdCartItemList[$k]['PBI_ITEM_VAL']."</li>";
				}
			}
		}

		## 몰인몰 상점별 배송비
		$strProdShopDeliveryText		= "";
		if ($S_MALL_TYPE != "R" && ($intRowSpan >= 1 && $S_SITE_LNG == "KR")){
			$strProdShopDeliveryText	= getCurMark()." ".getCurToPrice($aryProdBasketShopList[$cartRow[P_SHOP_NO]][DELIVERY_PRICE]).getCurMark2();
			if ($intRowSpan == $aryProdBasketShopList[$cartRow['P_SHOP_NO']]['AFTER_CHARGE_CNT'] && $aryProdBasketShopList[$cartRow['P_SHOP_NO']]['DELIVERY_PRICE'] == 0) {
				$strProdShopDeliveryText= $LNG_TRANS_CHAR["PW00049"]; //착불
			}
		}

		## html 배열 생성
		$arrRowHtml						= "";								//html 리스트 row 배열
		$arrRowHtml['PB_NO']			= $cartRow['PB_NO'];				//장바구니번호
		$arrRowHtml['PM_REAL_NAME']		= $cartRow['PM_REAL_NAME'];			//상품이미지URL
		$arrRowHtml['P_NAME']			= $cartRow['P_NAME'];				//상품명
		$arrRowHtml['P_OPT']			= $strCartOptAttrVal;				//상품옵션
		$arrRowHtml['P_ADD_OPT']		= $strCartAddOptAttrVal;			//상품추가옵션
		$arrRowHtml['P_ITEM']			= $strCartItemVal;					//상품항목
		$arrRowHtml['P_DELIVERY_INFO']	= $strDeliveryPriceText;			//상품배송정보
		$arrRowHtml['P_PRICE']			= $strProdPriceCurText;				//상품가격
		$arrRowHtml['P_PRICE_ORG']		= $strProdPriceOrgText;				//상품가격
		$arrRowHtml['P_ADD_PRICE']		= $strProdAddPriceCurText;			//상품추가옵션가격
		$arrRowHtml['P_ADD_PRICE_ORG']	= $strProdAddPriceOrgText;
		$arrRowHtml['P_QTY']			= $cartRow['PB_QTY'];				//상품수량
		$arrRowHtml['CART_PRICE']		= $strCartPriceCurText;				//상품총합계
		$arrRowHtml['CART_PRICE_ORG']	= $strCartPriceOrgText;
		$arrRowHtml['P_SHOP_DELIVERY']	= $strProdShopDeliveryText;			//상품입점사별 배송비
		$arrRowHtml['ROWSPAN']			= $intRowSpan;						//상품입점사별 배송비 로우수

		$arrRowHtml['P_CODE']			= $cartRow['P_CODE'];

		$arrCartRow[]					= $arrRowHtml;

		$intCartCount++;
	}


	/* 총주문의 상품가격합의 DISCOUNT 설정(bejewel)*/
	if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
		$param									= "";
		$param['PROD_TOTAL_PRICE']				= $intCartPriceTotal;
		$intCartPriceDiscountRate				= $productMgr->getProdTotalPriceMaxDiscountRate($db,$param);
		$intCartPriceDiscountPrice				= getProdTotalPriceAllDiscount($intCartPriceTotal,$intCartPriceDiscountRate);

		$param									= "";
		$param['PROD_TOTAL_DISCOUNT_RDATE']		= $intCartPriceDiscountRate;
		$prodTotalNextDiscountInfoRow			= $productMgr->getProdTotalPriceMaxNextDiscountInfo($db,$param);

		if ($prodTotalNextDiscountInfoRow){
			$intProdTotalMaxNextAddPrice		= $prodTotalNextDiscountInfoRow['SD_ST_PRICE'] - $intCartPriceTotal;
			$intProdTotalMaxNextAddRate			= $prodTotalNextDiscountInfoRow['SD_RATE'];
		}

		if ($intCartPriceDiscountPrice > 0){
			$intCartPriceTotal					= $intCartPriceTotal - $intCartPriceDiscountPrice;
			$intCartPriceTotalCur				= $intCartPriceTotal - getCurToPriceSave($intCartPriceDiscountPrice); //현재통화
		}
	}


	## 총합계(기준통화/현재통화)
	$intCartPriceEndTotal						= $intCartPriceTotal;
	$intCartPriceEndTotalCur					= $intCartPriceTotalCur;
	$intCartPriceEndTotalOrg					= $intCartPriceTotalOrg;

	## 배송비설정
	$intDeliveryTotal							= getCartDeliveryPrice($aryDeliveryPrice,$intCartPriceTotal,$SHOP_ARY_DELIVERY);
	if ($S_SITE_LNG == "KR") {
		##1. 그룹배송일때
		if ($S_DELIVERY_MTH == "G") $intDeliveryTotal = 0;

		##2. 입점사몰이면 배송비정책 상점 정책에 따라 설정
		if ($S_MALL_TYPE != "R") $intDeliveryTotal = $intProdBasketDeliveryTotal;

		##3. 총합계에 배송비포함
		if (($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){
			$intCartPriceEndTotal		= $intCartPriceEndTotal		+ $intDeliveryTotal;

			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$intCartPriceEndTotalCur	= $intCartPriceEndTotalCur  + getCurToPriceSave($intDeliveryTotal,"US");
				$intCartPriceEndTotalOrg	= $intCartPriceEndTotalOrg  + getCurToPriceSave($intDeliveryTotal);
			} else {
				$intCartPriceEndTotalCur	= $intCartPriceEndTotalCur  + getCurToPriceSave($intDeliveryTotal);
			}
		}

	}else{
		## 수량별 배송/배송사용하지 않음/기본배송(해외=국내)가 아닐 경우
		if (!in_array($S_DELIVERY_FOR_MTH,array("B","N","A"))){
			$intDeliveryTotal = 0;

			/* 해외/무게배송일때 해당 총무게의 합보다 큰 MIN PRICE 추출 */
			if (!$S_DELIVERY_FOR_WEIGHT) $S_DELIVERY_FOR_WEIGHT = 500;
			$intCartProdWeight = ceil($intCartProdWeight / $S_DELIVERY_FOR_WEIGHT) * $S_DELIVERY_FOR_WEIGHT;
		}
	}


	/* 적립금 지급 기준에 따른 포인트 */
	if ($S_POINT_ST == "P") {
		/* 판매가 기준 */
		if ($intCartPriceTotal < $S_POINT_ST_PRICE){
			$intCartPointTotal = 0;
		}
	} else {
		/* 결제가격 기준 */
		if (($intCartPriceTotal+$intDeliveryTotal) < $S_POINT_ST_PRICE){
			$intCartPointTotal = 0;
		}
	}

	/*부과세포함*/
	if ($S_SITE_TAX == "Y"){
		$intCartPriceEndTotal		= $intCartPriceEndTotal    + ($intCartPriceTotal*0.1);
		$intCartPriceEndTotalCur	= $intCartPriceEndTotalCur + (getPriceCal($intCartPriceTotalCur*0.1));
	}

	/* 포인트 사용 가능금액 계산 */
	/* 포인트 불가 상품일지라도 배송비가 존재할 경우는 배송비를 포인트로 결제할 수 있다.*/
	if ($intCartPointNoUseCnt > 0){
		$intCartPointUsePrice		= $intCartPriceEndTotal - $intCartPointNoUsePrice;
	}

	/* 해외 결제일때 배송비를 내는 상품인지 확인 */
	if ($S_SITE_LNG != "KR"){
		/* 프리스타일 사용 */
		if (!is_array($S_FIX_ORDER_DELIVERY_PROD_CATE)){
			$intForDeliveryPriceProdCnt = $intCartTotal;
		}
	}

	## 총상품금액(현재통화)
	$strPriceLeftMark			= getCurMark();
	$strPriceRightMark			= getCurMark2();
	$strCartPriceTotalText		= getFormatPrice($intCartPriceTotalCur,2);

	## 총부과세(현재통화)
	$strCartPriceTotalTaxText	= getFormatPrice(getPriceCal($intCartPriceTotalCur*0.1),2);

	## 배송비(주문시 배송정보를 사용할때)
	$strCartDeliveryTotalText	= "";
	if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){
		if ($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){
			$strCartDeliveryTotalText		= "0";
			if ($intDeliveryTotal > 0){
				$strCartDeliveryTotalText	= getCurToPrice($intDeliveryTotal);
			}
		} else {
			$strCartDeliveryTotalText		= "0";
		}
	}

	## 최종결제금액
	$strCartPriceEndTotalText	= getFormatPrice($intCartPriceEndTotalCur,2);

	if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){

		## 총상품금액
		$strPriceLeftMark			= getCurMark("USD");
		$strPriceRightMark			= getCurMark2("USD");
		$strCartPriceTotalText		= getFormatPrice($intCartPriceTotalCur,2,"USD");

		$strCartPriceTotalOrgText	= "(".$S_SITE_CUR_MARK1.getFormatPrice($intCartPriceTotalOrg,2).")";

		## 총부과세
		$strCartPriceTotalTaxText	= getFormatPrice(getPriceCal($intCartPriceTotalCur*0.1),2,"USD");
		$strCartPriceTotalTaxOrgText= "(".$S_SITE_CUR_MARK1.getFormatPrice(getPriceCal($intCartPriceTotalOrg*0.1),2).")";

		## 배송비
		$strCartDeliveryTotalText	= "";
		$strCartDeliveryTotalOrgText= "";
		if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){

			$strCartDeliveryTotalText		= 0;
			$strCartDeliveryTotalOrgText	= 0;

			if ($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){
				if ($intDeliveryTotal > 0){
					$strCartDeliveryTotalText		= getCurToPrice($intDeliveryTotal,"US");
					$strCartDeliveryTotalOrgText	= getCurToPrice($intDeliveryTotal);
				}
			}
		}

		## 최종결제금액
		$strCartPriceEndTotalText					= getFormatPrice($intCartPriceEndTotalCur,2,"USD");
		$strCartPriceEndTotalOrgText				= getFormatPrice($intCartPriceEndTotalOrg,2);
	}

	$strOrderTotalDiscountText		= "";
	$strOrderTotalDiscountRateText	= "";
	$strOrderTotalDiscountPriceText	= "";
	if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
		if ($intCartPriceDiscountPrice > 0 || $intProdTotalMaxNextAddPrice > 0){
			$strOrderTotalDiscountText = callLangTrans($LNG_TRANS_CHAR["OS00087"],array(getCurMark()." ".getCurToPrice($intProdTotalMaxNextAddPrice).getCurMark2(),$intProdTotalMaxNextAddRate,""));
			$strOrderTotalDiscountRateText	= callLangTrans($LNG_TRANS_CHAR["OW00114"],array($intCartPriceDiscountRate));
			$strOrderTotalDiscountPriceText	= getCurMark()." ".getCurToPrice($intCartPriceDiscountPrice).getCurMark2();
		}
	}

?>