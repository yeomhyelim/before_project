<?
	$productMgr->setM_NO($g_member_no);
	$productMgr->setSearchField($strSearchField);
	$productMgr->setSearchKey($strSearchKey);
	$productMgr->setPB_KEY($g_cart_prikey);

	$intPageBlock	= 10;
	$intPageLine	= 5;
	
	$productMgr->setPageLine($intPageLine);
	
	$intCartTotal	= $productMgr->getProdBasketTotal($db);

	$intCartTotPage	= ceil($intCartTotal / $productMgr->getPageLine());
	$productMgr->setPageLine($intCartTotal);
	
	if(!$intCartPage)	$intCartPage =1;

	if ($intCartTotal==0) {
		$intCartFirst	= 1;
		$intCartLast	= 0;			
	} else {
		$intCartFirst	= $intPageLine *($intCartPage -1);
		$intCartLast	= $intPageLine * $intCartPage;
	}

	$productMgr->setLimitFirst($intCartFirst);
	
	$cartResult = $productMgr->getProdBasketList($db);
	$intCartListNum = $intCartTotal - ($intPageLine *($intCartPage-1));		
	
	$linkCartPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkCartPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkCartPage .= "&wishPage=$intWishPage&cartPage=";
	/* 입점몰/프랜차이즈 KR(장바구니에 담기 상품을 기준으로 입점몰번호로 배송비를 구한다 */
	if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){	
		$aryProdBasketShopList = $productMgr->getProdBasketShopList($db);
		
		if (is_array($aryProdBasketShopList)){
			$intProdBasketDeliveryTotal = 0;

			foreach ($aryProdBasketShopList as $key => $value){
				for($i=1;$i<=5;$i++){
					$aryDeliveryPrice[$i] = 0;
				}
				
				$aryProdShopRow = $value;					
				$productMgr->setP_SHOP_NO($key);
				$productMgr->setLimitFirst(0);
				$productMgr->setPageLine($aryProdShopRow[BASKET_CNT]);
				$prodBasketRet = $productMgr->getProdBasketList($db);
				
				$intProdBasketDeliveryPrice = 0;
				$aryDeliveryPrice = null;
				while($prodBasketRow = mysql_fetch_array($prodBasketRet)){
					
					/* 2013.06.12 할인가격 보여주기 */
					$prodBasketRow[PB_PRICE] = getProdDiscountPrice($prodBasketRow,"2",$prodBasketRow['PB_PRICE']);
					/* 2013.06.12 할인가격 보여주기 */

					$intProdBasketPrice = ($prodBasketRow[PB_PRICE] * $prodBasketRow[PB_QTY]) + $prodBasketRow[PB_ADD_OPT_PRICE];
					$intProdBasketDeliveryPrice = getProdDeliveryPrice($prodBasketRow,$SHOP_ARY_DELIVERY,$intProdBasketPrice,$prodBasketRow[PB_QTY],$value);
					if($S_SITE_LNG == "KR"){
						/* 고정배송비일경우 옵션/수량/금액에 상관없이 무조건 고정배송비 */
						if ($prodBasketRow['P_BAESONG_TYPE'] == "3"){
							if (is_array($aryDeliveryFixProduct)) {
								 if (!in_array($prodBasketRow[P_CODE],$aryDeliveryFixProduct)) {
									$aryDeliveryFixProduct = array_push($aryDeliveryFixProduct, $prodBasketRow[P_CODE]);
								 } else {
									$intProdBasketDeliveryPrice = 0;
								 }
							} else $aryDeliveryFixProduct = array($prodBasketRow[P_CODE]);
						}
					}
					
					
					$aryDeliveryPrice[$prodBasketRow[P_BAESONG_TYPE]] += $intProdBasketDeliveryPrice;

					/* 착불배송비 설정 (14.09.03)*/
					if ($prodBasketRow['P_BAESONG_TYPE'] == "5") {
						$aryProdBasketShopList[$key]['AFTER_CHARGE_CNT'] += 1;
					}
				}
								
				$intProdBasketShopDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$value[BASKET_PRICE],$SHOP_ARY_DELIVERY,$value);
				$aryProdBasketShopList[$key][DELIVERY_PRICE] = $intProdBasketShopDeliveryTotal;
				$intProdBasketDeliveryTotal = $intProdBasketDeliveryTotal + $intProdBasketShopDeliveryTotal; 

			}
		}
	}
	
	## 통합수량할인 설정
	if($S_ALL_DISCOUNT_USE == "Y"):
		$strProdAllDiscount		= $S_ALL_DISCOUNT_VAL;
		$aryProdAllDiscount		= "";
		$aryTemp				= explode("/", $strProdAllDiscount);
		foreach($aryTemp as $key => $data):
			list($strVal1, $strPrice)	= explode(":", $data);
			list($strStart, $strEnd)	= explode("~", $strVal1);
			
			if(!$strStart)	{ $strStart	= 0;		}
			if(!$strEnd)	{ $strEnd	= 9999999;	}

			$aryProdAllDiscount[$key]['rate']	= $strPrice;
			$aryProdAllDiscount[$key]['start']	= $strStart;
			$aryProdAllDiscount[$key]['end']	= $strEnd;
		endforeach;
	endif;

	/* wish 리스트 */
	$intPageLine	= 10;
	$productMgr->setPageLine($intPageLine);

	if ($g_member_no){		
		$intWishTotal	= $productMgr->getProdWishTotal($db);
		$intWishTotPage	= ceil($intWishTotal / $productMgr->getPageLine());

		if(!$intWishPage)	$intWishPage =1;

		if ($intWishTotal==0) {
			$intWishFirst	= 1;
			$intWishLast	= 0;			
		} else {
			$intWishFirst	= $intPageLine *($intWishPage -1);
			$intWishLast	= $intPageLine * $intWishPage;
		}
		$productMgr->setLimitFirst($intWishFirst);

		$wishResult = $productMgr->getProdWishList($db);
		$intWishListNum = $intWishTotal - ($intPageLine *($intWishPage-1));	
		
		$linkWishPage  = "?menuType=$strMenuType&mode=$strMode";
		$linkWishPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
		$linkWishPage .= "&lcate=$strSearchHCode1&mcate=$strSearchHCode2";			
		$linkWishPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4";		
		$linkWishPage .= "&cartPage=$intCartPage&wishPage=";
	}
	
	## 화면관련
	$intCartCount = 0;
	$intCartPrice = $intCartPriceTotal = $intCartDeliveryPriceTotal = 0;
	for($i=1;$i<=5;$i++){
		$aryDeliveryPrice[$i] = 0;
	}
	
	$aryDeliveryFixProduct = "";
	$arrCartRow			   = "";	
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
		
		## 상품 가격(할인가격)
		$intProdPrice					= $cartRow['PB_PRICE'];
		$cartRow['PB_PRICE']			= getProdDiscountPrice($cartRow,"2",$intProdPrice);
		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") {
			$cartRow['PB_PRICE']		= getProdDiscountPrice($cartRow,"2",$intProdPrice,"US");
			$cartRow['PB_PRICE_ORG']	= getProdDiscountPrice($cartRow,"2",$intProdPrice); 
		} 

		## 상품가격(통합수량할인)
		if ($S_ALL_DISCOUNT_USE == "Y"){
			$cartRow['PB_PRICE']		= getProdAllDiscount($cartRow['PB_PRICE'],$cartRow['PB_QTY']);
			$cartRow['PB_PRICE_ORG']	= getProdAllDiscount($cartRow['PB_PRICE_ORG'],$cartRow['PB_QTY']);
		}
		
		## 상품 총 합계(금액 * 수량)
		$intCartPrice					= ($cartRow['PB_PRICE'] * $cartRow['PB_QTY']) + $cartRow['PB_ADD_OPT_PRICE'];
		$intCartPriceTotal			   += $intCartPrice;

		##기준통화에서 현재 언어 통화로 변경시 환율 오차가 발생하여 상품금액을 현재통화로 변경 후 계산 */		
		$strPriceCurLeftMark			= getCurMark();
		$strPriceCurRightMark			= getCurMark2();

		
		$strProdPriceCurText			= $strPriceCurLeftMark." ".getFormatPrice($cartRow['PB_PRICE'],2).$strPriceCurRightMark; 
		$strProdAddPriceCurText			= "";
		if ($cartRow['PB_ADD_OPT_PRICE'] > 0){
			$strProdAddPriceCurText		= $strPriceCurLeftMark." ".getCurToPrice($cartRow['PB_ADD_OPT_PRICE']).$strPriceCurRightMark; 
		}
									
		$intCartPriceCur				= ($cartRow['PB_PRICE'] * $cartRow[PB_QTY]) + getCurToPriceSave($cartRow['PB_ADD_OPT_PRICE']);
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
			
			$strProdPriceCurText		= $strPriceCurLeftMark.getFormatPrice($cartRow['PB_PRICE'],2).$strPriceCurRightMark;
			$strProdPriceOrgText		= "(".$strPriceOrgLeftMark.getFormatPrice($cartRow['PB_PRICE_ORG'],2).")";

			$strProdAddPriceCurText		= "";
			if ($cartRow['PB_ADD_OPT_PRICE'] > 0){
				$strProdAddPriceCurText = $strPriceCurLeftMark.getCurToPrice($cartRow['PB_ADD_OPT_PRICE'],"US").$strPriceCurRightMark;
				$strProdAddPriceOrgText = "(".$strPriceOrgLeftMark.getCurToPrice($cartRow['PB_ADD_OPT_PRICE']).")";
			}

			$intCartPriceCur			= ($cartRow['PB_PRICE'] * $cartRow['PB_QTY']) + getCurToPriceSave($cartRow['PB_ADD_OPT_PRICE'],"US");
			$strCartPriceCurText		= $strPriceCurLeftMark.getFormatPrice($intCartPriceCur,2,"USD").$strPriceCurRightMark;
				
			$intCartPriceOrg			= ($cartRow['PB_PRICE_ORG'] * $cartRow['PB_QTY']) + getCurToPriceSave($cartRow['PB_ADD_OPT_PRICE']);
			$intCartPriceTotalOrg      += $intCartPriceOrg;
			
			$strCartPriceOrgText		= "(".$strPriceOrgLeftMark.getFormatPrice($intCartPriceOrg,2).")";
		}
		$intCartPriceTotalCur += $intCartPriceCur;
		if ($S_DELIVERY_MTH == "G" && $cartRow['P_BAESONG_TYPE'] != "2"){
			$intCartDeliveryPriceTotal    += $intCartPrice;
			$intCartDeliveryPriceTotalCur += $intCartPriceCur;
		}
				
		## 해외배송 : 수량별배송을 사용할 경우 맨처음 주문 상품의 배송비에 기본배송비를 더하기 위해 CART_COUNT를 배열 삽입 */
		if ($S_SITE_LNG != "KR"){
			if ($S_DELIVERY_FOR_MTH == "B"){
				if ($cartRow['P_BAESONG_TYPE'] == "4"){
					$cartRow['CART_COUNT'] = $intCartCount + 1;		
				}
			}
		}
		
		## 배송비설정
		$strDeliveryPriceText	= "";
		$intDeliveryPrice		= getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice,$cartRow['PB_QTY'],$aryProdBasketShopList[$cartRow['P_SHOP_NO']]);				
		
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
					$strDeliveryPriceText = $LNG_TRANS_CHAR["PW00012"].":".getCurMark()." ".getCurToPrice($intDeliveryPrice).getCurMark2();
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

			if (is_array($aryProdOptAttr)){
				$intProdPoint = ($aryProdOptAttr[0]['POA_POINT']) ? $aryProdOptAttr[0]['POA_POINT'] : $cartRow['P_POINT'];
				$intCartPoint = getProdPoint($cartRow['PB_PRICE'], $intProdPoint, $cartRow['P_POINT_TYPE'], $cartRow['P_POINT_OFF1'], $cartRow['P_POINT_OFF2']);
			}
		} else {
			$intCartPoint = getProdPoint($cartRow['PB_PRICE'], $cartRow['P_POINT'], $cartRow['P_POINT_TYPE'], $cartRow['P_POINT_OFF1'], $cartRow['P_POINT_OFF2']);
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
		
		## 상품이벤트표시
		$strProdEventText = "";							
		if ($cartRow['P_EVENT_UNIT'] && $cartRow['P_EVENT']){
			if ($cartRow['P_EVENT_UNIT'] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow['P_EVENT'],"%")).")";
			else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow['P_EVENT'],"")).")";
		}

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

		## 품절표시(2014.04.21)
		$strProdSoldOutText = "";
		$strProdSoldOutYN	= "N";
		if ($cartRow['P_STOCK_OUT'] == "Y"){
			## 품절여부체크
			$strProdSoldOutYN	= "Y";
			$strProdSoldOutText = "<strong class=\"prodRed\">".$LNG_TRANS_CHAR["PW00041"]."</strong>";
		} else {
			## 무제한이 아니면
			if ($cartRow['P_STOCK_LIMIT']!= "Y"){
				
				$intProdStockQty = $cartRow['P_QTY'];
				## 옵션수량체크
				if ($cartRow['PB_OPT_NO'] > 0) {
					$productMgr->setP_CODE($cartRow['P_CODE']);
					$productMgr->setP_LNG($S_SITE_LNG);
					$productMgr->setPOA_NO($cartRow['PB_OPT_NO']);
					$arrProdOptInfo = $productMgr->getProdOptAttr($db);

					if (is_array($arrProdOptInfo)){
						$intProdStockQty = $arrProdOptInfo[0]['POA_STOCK_QTY']; 
					}
				}

				if ($intProdStockQty == 0) {
					$strProdSoldOutYN	= "Y";
					$strProdSoldOutText = "<strong class=\"prodRed\">".$LNG_TRANS_CHAR["PW00041"]."</strong>";
				}
			}
		}
		$intCartCount++;
		
		## 상품수량별 할인 표시
		$strProdQtyDiscountText	= "";
		if ($S_ALL_DISCOUNT_USE == "Y"){
			foreach($aryProdAllDiscount as $key => $data){
				if ($cartRow[PB_QTY] >= $data['start'] && $cartRow[PB_QTY] <= $data['end']){
					$strProdQtyDiscountText .= "<br>({$data['rate']}% OFF)";
					break;
				}
			}
		}

		## html 배열 생성
		$arrRowHtml							= "";								//html 리스트 row 배열
		$arrRowHtml['PB_NO']				= $cartRow['PB_NO'];				//장바구니번호
		$arrRowHtml['PM_REAL_NAME']			= $cartRow['PM_REAL_NAME'];			//상품이미지URL
		$arrRowHtml['P_NAME']				= $cartRow['P_NAME'];				//상품명
		$arrRowHtml['P_OPT']				= $strCartOptAttrVal;				//상품옵션
		$arrRowHtml['P_ADD_OPT']			= $strCartAddOptAttrVal;			//상품추가옵션
		$arrRowHtml['P_ITEM']				= $strCartItemVal;					//상품항목
		$arrRowHtml['P_DELIVERY_INFO']		= $strDeliveryPriceText;			//상품배송정보
		$arrRowHtml['P_PRICE']				= $strProdPriceCurText;				//상품가격
		$arrRowHtml['P_PRICE_ORG']			= $strProdPriceOrgText;				//상품가격
		$arrRowHtml['P_ADD_PRICE']			= $strProdAddPriceCurText;			//상품추가옵션가격
		$arrRowHtml['P_ADD_PRICE_ORG']		= $strProdAddPriceOrgText;
		$arrRowHtml['P_QTY']				= $cartRow['PB_QTY'];				//상품수량
		$arrRowHtml['CART_PRICE']			= $strCartPriceCurText;				//상품총합계
		$arrRowHtml['CART_PRICE_ORG']		= $strCartPriceOrgText;				
		$arrRowHtml['P_SHOP_DELIVERY']		= $strProdShopDeliveryText;			//상품입점사별 배송비
		$arrRowHtml['ROWSPAN']				= $intRowSpan;						//상품입점사별 배송비 로우수
		
		$arrRowHtml['P_EVENT_TEXT']			= $strProdEventText;				//상품이벤트표시
		$arrRowHtml['P_STOCK_OUT']			= $strProdSoldOutYN;				//상품품절여부
		$arrRowHtml['P_STOCK_OUT_TEXT']		= $strProdSoldOutText;				//상품품절여부
		
		$arrRowHtml['P_CODE']				= $cartRow['P_CODE'];
		$arrRowHtml['P_LINK_URL']			= "./?menuType=product&mode=view&prodCode={$cartRow['P_CODE']}";
		$arrRowHtml['P_QTY_DISCOUNT_TEXT']	= $strProdQtyDiscountText;

		$arrCartRow[]						= $arrRowHtml;

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
	}
	
	##총합계에 배송비포함
	$intCartPriceEndTotal						= $intCartPriceEndTotal		+ $intDeliveryTotal;
		
	if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
		$intCartPriceEndTotalCur				= $intCartPriceEndTotalCur  + getCurToPriceSave($intDeliveryTotal,"US");
		$intCartPriceEndTotalOrg				= $intCartPriceEndTotalOrg  + getCurToPriceSave($intDeliveryTotal);
	} else {
		$intCartPriceEndTotalCur				= $intCartPriceEndTotalCur  + getCurToPriceSave($intDeliveryTotal);		
	}

	/*부과세포함*/	
	if ($S_SITE_TAX == "Y"){
		$intCartPriceEndTotal		= $intCartPriceEndTotal    + ($intCartPriceTotal*0.1);
		$intCartPriceEndTotalCur	= $intCartPriceEndTotalCur + (getPriceCal($intCartPriceTotalCur*0.1));
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
		if (($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH))  || ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "B")){
			$strCartDeliveryTotalText		= "0";
			if ($intDeliveryTotal > 0){
				$strCartDeliveryTotalText	= getCurToPrice($intDeliveryTotal);
			}
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
			
			if (($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)) || ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "B")){
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