<?
	$intCartPrice	= $intCartPriceTotal		= $intCartPointTotal	= $intCartDeliveryPriceTotal = 0;
	$arrCartRow		= "";

	// 링크프라이스 관련 기본 설정 값 및 개별 쇼핑몰에 들어가야될 설정값들.
	// 각종 키값들은 /public_html/conf/shop/manual.inc.php 에 설정되어 있음
	// 스크립트를 생성하고 해당 스크립트의 출력은 /public_html/layout/html/order_body_orderEnd.inc.php 에서 출력.
	$linkprice_tag	= '' ;
	$linkPriceSql	= '' ;
	$linkYmd		= date ( 'Ymd' ) ;
	$linkHis		= date ( 'H:i:s' ) ;
	$linkPrice_order = empty ( $_SESSION['member_id'] ) ? 'GUEST' : $_SESSION['member_id']  ;
	$linkprice_id	= empty ( $S_LINKPRICE_ID )		? '' : $S_LINKPRICE_ID ;
	$linkprice_code = empty ( $S_LINKPRICE_CODE )	? '' : $S_LINKPRICE_CODE ;
	$linkprice_pad	= empty ( $S_LINKPRICE_PAD )	? '' : $S_LINKPRICE_PAD ;

	$linkPriceCode	= array
	(
		'p_cd_ar'	=> array () ,
		'it_cnt_ar' => array () ,
		'c_cd_ar'	=> array () ,
		'sales_ar'	=> array () ,
		'p_nm_ar'	=> array ()
	) ;


	while ($cartRow = mysql_fetch_array($cartResult))
	{

		## 입점형일때 배송비관련 ROWSPAN 수
		if ($S_MALL_TYPE != "R")
		{
			$intRowSpan		= 0;
			if (($intShopNo != "0" && !$intShopNo) || ($intShopNo != $cartRow['P_SHOP_NO'])) {
				$intShopNo	= ($cartRow['P_SHOP_NO'])?$cartRow['P_SHOP_NO']:"0";
				$intRowSpan = $aryProdCartShopList[$intShopNo]['CART_CNT'];
			}
		}

		## 상품 가격(할인가격)
		$intProdPrice					= $cartRow['OC_CUR_PRICE'];								//기준통화
		$intProdPriceCur				= $cartRow['OC_PRICE'];									//결제한 통화
		$intProdPriceOrg				= getCurToPriceSave($cartRow['OC_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);			//사용 통화

		## 상품 총 합계(금액 * 수량)
		$intCartPrice					= ($intProdPrice * $cartRow['OC_QTY']) + $cartRow['OC_OPT_ADD_CUR_PRICE'];

		##기준통화에서 현재 언어 통화로 변경시 환율 오차가 발생하여 상품금액을 현재통화로 변경 후 계산 */
		$strPriceCurLeftMark			= getCurMark($orderRow['O_USE_CUR']);
		$strPriceCurRightMark			= getCurMark2($orderRow['O_USE_CUR']);

		$strProdPriceCurText			= $strPriceCurLeftMark." ".getFormatPrice($intProdPriceCur,2).$strPriceCurRightMark;
		$strProdAddPriceCurText			= "";
		if ($cartRow['OC_OPT_ADD_PRICE'] > 0){
			$strProdAddPriceCurText		= $strPriceCurLeftMark." ".getFormatPrice($cartRow['OC_OPT_ADD_PRICE'],2).$strPriceCurRightMark;
		}

		$intCartPriceCur				= ($intProdPriceCur * $cartRow['OC_QTY']) + $cartRow['OC_OPT_ADD_PRICE'];
		$strCartPriceCurText			= $strPriceCurLeftMark." ".getFormatPrice($intCartPriceCur,2).$strPriceCurRightMark;

		$strProdPriceOrgText			= "";
		$strProdAddPriceOrgText			= "";
		$strCartPriceOrgText			= "";

		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")
		{
			$strPriceCurLeftMark		= getCurMark("USD");
			$strPriceCurRightMark		= getCurMark2("USD");

			$strPriceOrgLeftMark		= getCurLeftMark($orderRow['O_USE_LNG']);
			$strPriceOrgRightMark		= "";

			$strProdPriceCurText		= $strPriceCurLeftMark.getFormatPrice($intProdPriceCur,2,"USD").$strPriceCurRightMark;
			$strProdPriceOrgText		= "(".$strPriceOrgLeftMark.getCurToPrice($intProdPrice,$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']).")";

			$strProdAddPriceCurText		= "";
			if ($cartRow['OC_OPT_ADD_PRICE'] > 0){
				$strProdAddPriceCurText = $strPriceCurLeftMark.getFormatPrice($cartRow['OC_OPT_ADD_PRICE'],2,"USD").$strPriceCurRightMark;
				$strProdAddPriceOrgText = "(".$strPriceOrgLeftMark.getCurToPrice($cartRow['OC_OPT_ADD_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']).")";
			}

			$intCartPriceCur			= ($intProdPriceCur * $cartRow['OC_QTY']) + $cartRow['OC_OPT_ADD_PRICE'];
			$strCartPriceCurText		= $strPriceCurLeftMark.getFormatPrice($intCartPriceCur,2,"USD").$strPriceCurRightMark;

			$intCartPriceOrg			= ($intProdPriceOrg * $cartRow['OC_QTY']) + getCurToPriceSave($cartRow['OC_OPT_ADD_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$intCartPriceTotalOrg      += $intCartPriceOrg;

			$strCartPriceOrgText		= "(".$strPriceOrgLeftMark.getFormatPrice($intCartPriceOrg,2,$S_ARY_NAT_USER_CUR[$orderRow['O_USE_LNG']]).")";
		}

		## 배송비설정

		$strDeliveryPriceText	= "";
		if($S_SITE_LNG == "KR")
		{
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
		}


		## 상품옵션리스트
		$strCartOptAttrVal = "";
		for($kk=1;$kk<=10;$kk++){
			if ($cartRow["OC_OPT_ATTR".$kk]){
				$strCartOptAttrVal .= "/".$cartRow["OC_OPT_ATTR".$kk];
			}
		}
		$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

		## 상품추가옵션
		$orderMgr->setOC_NO($cartRow['OC_NO']);
		$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);
		$strCartAddOptAttrVal	= "";
		if (is_array($aryProdCartAddOptList)){
			for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
				$strCartAddOptAttrVal .= "<li>".$LNG_TRANS_CHAR['OW00006'].":".$aryProdCartAddOptList[$k]['OCA_OPT_NM']."</li>";
			}
		}

		## 상품추가항목사용
		$aryProdCartItemList	 = "";
		$strCartItemVal			= "";
		if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
			$aryProdCartItemList = $orderMgr->getOrderCartItemList($db);
			if (is_array($aryProdCartItemList)){
				for($k=0;$k<sizeof($aryProdCartItemList);$k++){
					$strCartItemVal .= "<li>".$aryProdCartItemList[$k]['OCI_ITEM_NM'].":".$aryProdCartItemList[$k]['OCI_ITEM_VAL']."</li>";
				}
			}
		}

		## 몰인몰 상점별 배송비
		$strProdShopDeliveryText		= "";
		if ($S_MALL_TYPE != "R" && ($intRowSpan >= 1 && $S_SITE_LNG == "KR")){
			$strProdShopDeliveryText	= getCurMark($orderRow['O_USE_CUR'])." ".getCurToPrice($aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE]).getCurMark2($orderRow["O_USE_CUR"]);
			if ($intRowSpan == $aryProdCartShopList[$cartRow['P_SHOP_NO']]['AFTER_CHARGE_CNT'] && $aryProdCartShopList[$cartRow['P_SHOP_NO']]['SO_TOT_DELIVERY_CUR_PRICE'] == 0) {
				$strProdShopDeliveryText= $LNG_TRANS_CHAR["PW00049"]; //착불
			}
		}

		## html 배열 생성
		$arrRowHtml						= "";								//html 리스트 row 배열
		$arrRowHtml['OC_NO']			= $cartRow['OC_NO'];				//장바구니번호
		$arrRowHtml['PM_REAL_NAME']		= $cartRow['PM_REAL_NAME'];			//상품이미지URL
		$arrRowHtml['P_CODE']			= $cartRow['P_CODE'];				//상품코드
		$arrRowHtml['P_NAME']			= $cartRow['P_NAME'];				//상품명
		$arrRowHtml['P_OPT']			= $strCartOptAttrVal;				//상품옵션
		$arrRowHtml['P_ADD_OPT']		= $strCartAddOptAttrVal;			//상품추가옵션
		$arrRowHtml['P_ITEM']			= $strCartItemVal;					//상품항목
		$arrRowHtml['P_DELIVERY_INFO']	= $strDeliveryPriceText;			//상품배송정보
		$arrRowHtml['P_PRICE']			= $strProdPriceCurText;				//상품가격
		$arrRowHtml['P_PRICE_ORG']		= $strProdPriceOrgText;				//상품가격
		$arrRowHtml['P_ADD_PRICE']		= $strProdAddPriceCurText;			//상품추가옵션가격
		$arrRowHtml['P_ADD_PRICE_ORG']	= $strProdAddPriceOrgText;
		$arrRowHtml['P_QTY']			= $cartRow['OC_QTY'];				//상품수량
		$arrRowHtml['CART_PRICE']		= $strCartPriceCurText;				//상품총합계
		$arrRowHtml['CART_PRICE_ORG']	= $strCartPriceOrgText;
		$arrRowHtml['P_SHOP_DELIVERY']	= $strProdShopDeliveryText;			//상품입점사별 배송비
		$arrRowHtml['ROWSPAN']			= $intRowSpan;						//상품입점사별 배송비 로우수

		$arrCartRow[]					= $arrRowHtml;


		// linkprice (링크프라이스) 통한 주문일 경우
		if ( isset ( $_COOKIE["LPINFO"] ) )
		{
			array_push ( $linkPriceCode['p_cd_ar']		, $cartRow['P_CODE'] ) ;
			array_push ( $linkPriceCode['it_cnt_ar']	, $cartRow['OC_QTY'] ) ;
			array_push ( $linkPriceCode['c_cd_ar']		, 'WEB' ) ;
			array_push ( $linkPriceCode['sales_ar']		, floor ( $cartRow['OC_PRICE'] * $cartRow['OC_QTY'] ) ) ;
			array_push ( $linkPriceCode['p_nm_ar']		, urlencode ( $cartRow['P_NAME'] ) ) ;

			// unique 한 값을 만들기 위해 주문키 , 상품코드 , 옵션번호 조합
			$linkUniqueId = $cartRow['O_NO'] . '_' . $cartRow['P_CODE'] . '_' . $cartRow['OC_OPT_NO'] ;
			//$linkUniqueId = $orderRow['O_KEY'] ;
			$linkPriceSql .= '(\'' . $_COOKIE['LPINFO'] . '\' , \'' . $linkYmd . '\', \'' . $linkHis . '\' ,	\'' . $linkUniqueId . '\', \'' . $cartRow['P_CODE'] . '\' , ' . $cartRow['OC_QTY'] . ' , ' ;
			$linkPriceSql .= floor ( $cartRow['OC_PRICE'] * $cartRow['OC_QTY'] ) . ', \'' . $cartRow['P_NAME'] . '\' , \'WEB\' , \'' . $linkPrice_order	. '\' , \'' . $orderRow['O_J_NAME'] . '\' , \'' . ClientInfo::getClientIP() . '\' ) ,' ;


		}
	}

	## 총상품금액(현재통화)
	$strPriceLeftMark					= getCurMark($orderRow['O_USE_CUR']);
	$strPriceRightMark					= getCurMark2($orderRow['O_USE_CUR']);
	$strCartPriceTotalText				= getFormatPrice($orderRow['O_TOT_PRICE'],2);

	## 총부과세(현재통화)
	$strCartPriceTotalTaxText			= getFormatPrice($orderRow['O_TAX_PRICE'],2);

	## 총수수료
	$strCartPricePgCommissionText	= "";
	if ($S_PG_COMMISSION == "Y" && $orderRow['O_TOT_PG_COMMISSION'] > 0){
		$strCartPricePgCommissionText	= getFormatPrice($orderRow['O_TOT_PG_COMMISSION']);
	}

	## 배송비(주문시 배송정보를 사용할때)
	$strCartDeliveryTotalText	= "";
	if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){
		$strCartDeliveryTotalText		= "0";
		if ($orderRow['O_TOT_DELIVERY_CUR_PRICE'] > 0){
			$strCartDeliveryTotalText	= getFormatPrice($orderRow['O_TOT_DELIVERY_PRICE'],2);
		}
	}

	## 추가할인금액
	$strCartMemberDiscountPriceText		= "";
	if ($orderRow['O_TOT_MEM_DISCOUNT_CUR_PRICE'] > 0){
		$strCartMemberDiscountPriceText	= getFormatPrice($orderRow['O_TOT_MEM_DISCOUNT_PRICE'],2);
	}

	## 사용포인트
	$strCartUsePointPriceText			= "";
	if ($orderRow['O_USE_POINT'] > 0){
		$strCartUsePointPriceText		= getFormatPrice($orderRow['O_USE_POINT'],2);
	}

	## 사용쿠폰
	$strCartUseCouponPriceText			= "";
	if ($orderRow['O_USE_COUPON'] > 0){
		$strCartUseCouponPriceText		= getFormatPrice($orderRow['O_USE_COUPON'],2);
	}

	## 최종결제금액
	$strCartPriceEndTotalText			= getFormatPrice($orderRow['O_TOT_SPRICE'],2);

	if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){

		## 총상품금액(현재통화)
		$strPriceLeftMark					= getCurMark("USD");
		$strPriceRightMark					= getCurMark2("USD");
		$strCartPriceTotalText				= getFormatPrice($orderRow['O_TOT_PRICE'],2);
		$intCartPriceTotalOrg				= $intCartPriceTotalOrg;
		$strCartPriceTotalOrgText			= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartPriceTotalOrg.")";

		## 총부과세(현재통화)
		$strCartPriceTotalTaxText			= getFormatPrice($orderRow['O_TAX_PRICE'],2);
		$intCartPriceTotalTaxOrg			= getCurToPrice($orderRow['O_TAX_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
		$strCartPriceTotalTaxOrgText		= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartPriceTotalTaxOrg.")";

		## 총수수료
		$strCartPricePgCommissionText		= "";
		$strCartPricePgCommissionOrgText	= "";
		$intCartPricePgCommissionOrg		= 0;
		if ($S_PG_COMMISSION == "Y" && $orderRow['O_TOT_PG_COMMISSION'] > 0){
			$strCartPricePgCommissionText	= getFormatPrice($orderRow['O_TOT_PG_COMMISSION']);
			$intCartPricePgCommissionOrg	= getCurToPrice($orderRow['O_TOT_PG_CUR_COMMISSION'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$strCartPricePgCommissionOrgText= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartPricePgCommissionOrg.")";
		}

		## 배송비(주문시 배송정보를 사용할때)
		$strCartDeliveryTotalText			= "";
		$strCartDeliveryTotalOrgText		= "";
		$intCartDeliveryTotalOrg			= 0;
		if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){
			if ($orderRow['O_TOT_DELIVERY_PRICE'] > 0){
				$strCartDeliveryTotalText	= getFormatPrice($orderRow['O_TOT_DELIVERY_PRICE'],2);
				$intCartDeliveryTotalOrg	= getCurToPrice($orderRow['O_TOT_DELIVERY_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
				$strCartDeliveryTotalOrgText= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartDeliveryTotalOrg.")";
			}
		}

		## 추가할인금액
		$strCartMemberDiscountPriceText		= "";
		$strCartMemberDiscountPriceOrgText	= "";
		$intCartMemberDiscountPriceOrg		= 0;
		if ($orderRow['O_TOT_MEM_DISCOUNT_CUR_PRICE'] > 0){
			$strCartMemberDiscountPriceText		= getFormatPrice($orderRow['O_TOT_MEM_DISCOUNT_PRICE'],2);
			$intCartMemberDiscountPriceOrg		= getCurToPrice($orderRow['O_TOT_MEM_DISCOUNT_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$strCartMemberDiscountPriceOrgText	= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartMemberDiscountPriceOrg.")";
		}

		## 사용포인트
		$strCartUsePointPriceText			= "";
		$intCartUsePointPriceOrg			= 0;
		if ($orderRow['O_USE_POINT'] > 0){
			$strCartUsePointPriceText		= getFormatPrice($orderRow['O_USE_POINT'],2);
			$intCartUsePointPriceOrg		= getCurToPrice($orderRow['O_USE_CUR_POINT'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
		}

		## 사용쿠폰
		$strCartUseCouponPriceText			= "";
		$strCartUseCouponPriceOrgText		= "";
		$intCartUseCouponPriceOrg			= 0;
		if ($orderRow['O_USE_COUPON'] > 0){
			$strCartUseCouponPriceText		= getFormatPrice($orderRow['O_USE_COUPON'],2);
			$intCartUseCouponPriceOrg		= getCurToPrice($orderRow['O_USE_CUR_COUPON'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$strCartUseCouponPriceOrgText	= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartUseCouponPriceOrg.")";
		}

		## 최종결제금액
		$strCartPriceEndTotalText			= getFormatPrice($orderRow['O_TOT_SPRICE'],2);
		if ($orderRow['O_TOT_SPRICE'] == 0) $intCartPriceEndTotalOrg = 0;
		else {
			$intCartPriceEndTotalOrg			= ($intCartPriceTotalOrg + $intCartPriceTotalTaxOrg + $intCartDeliveryTotalOrg + $intCartPricePgCommissionOrg) - $intCartMemberDiscountPriceOrg - $intCartUsePointPriceOrg - $intCartUseCouponPriceOrg;
		}
		$strCartPriceEndTotalOrgText		= "(".getCurLeftMark($orderRow['O_USE_LNG']).getFormatPrice($intCartPriceEndTotalOrg,2,"USD").")";
	}

	// linkprice (링크프라이스) 통한 주문일 경우
	if ( isset ( $_COOKIE["LPINFO"] ) )
	{
		$linkprice_url = "http://service.linkprice.com/lppurchase.php" ;     // 수정하시면 안됩니다.
		$linkprice_url.= "?a_id="	. $_COOKIE["LPINFO"] ;                       // 수정하시면 안됩니다.
		$linkprice_url.= "&m_id="	. $linkprice_id ;									// 수정하시면 안됩니다.
		// $id = 사용자 ID값, $name = 사용자 이름값, 만약 둘 중 없는 값이 있다면 존재하는 값만을 넣어주시기 바랍니다.
		$linkprice_url.= "&mbr_id=" . ( empty ( $_SESSION['member_id'] ) ? 'GUEST' : $_SESSION['member_id'] ) . "(" . $orderRow['O_J_NAME'] . ")" ;
		$linkprice_url.= "&o_cd="	. $linkUniqueId ;                              // $order_code = 주문번호값 입니다.
		$linkprice_url.= "&p_cd="	. implode ( "||" , $linkPriceCode['p_cd_ar'] ) ;                  // 수정하시면 안됩니다. $p_cd_ar은 위의 장바구니 처리 부분에서 생성된 값입니다.
		$linkprice_url.= "&it_cnt=" . implode ( "||" , $linkPriceCode['it_cnt_ar'] ) ;              // 수정하시면 안됩니다. $it_cnt_ar은 위의 장바구니 처리 부분에서 생성된 값입니다.
		$linkprice_url.= "&sales="	. implode ( "||" , $linkPriceCode['sales_ar'] ) ;                // 수정하시면 안됩니다. $sales_ar은 위의 장바구니 처리 부분에서 생성된 값입니다.
		$linkprice_url.= "&c_cd="	. implode ( "||" , $linkPriceCode['c_cd_ar'] ) ;                  // 수정하시면 안됩니다. $c_cd_ar은 위의 장바구니 처리 부분에서 생성된 값입니다.
		$linkprice_url.= "&p_nm="	. implode ( "||" , $linkPriceCode['p_nm_ar'] ) ;                  // 수정하시면 안됩니다. $p_nm_ar은 위의 장바구니 처리 부분에서 생성된 값입니다.

		function lp_encode($src, $code, $pad)
		{
			$r1 = mt_rand(0, 63);
			$r2 = substr($pad, $r1, 1);
			$pad = substr($pad, $r1).substr($pad, 0, $r1);

			for ($i = 0 ; $i < strlen($src) / 3; $i++)
			{
				$s1 = ord($src[$i * 3 + 0]);
				$s2 = ord($src[$i * 3 + 1]);
				$s3 = ord($src[$i * 3 + 2]);

				$c1 = substr($pad, (($s1 >> 2) ^  ($i & 0x3f)) & 0x3f, 1);
				$c2 = substr($pad, (((($s1 & 0x03) << 4) | ($s2 >> 4)) ^ ($i & 0x3f)) & 0x3f, 1);
				$c3 = substr($pad, (((($s2 & 0x0f) << 2) | ($s3 >> 6)) ^ ($i & 0x3f)) & 0x3f, 1);
				$c4 = substr($pad, (($s3 & 0x3f) ^ ($i & 0x3f)) & 0x3f, 1);

				$v1 = (($v1 + ord($c1)) & 0x3f);
				$v2 = (($v2 + ord($c2)) & 0x3f);
				$v3 = (($v3 + ord($c3)) & 0x3f);
				$v4 = (($v4 + ord($c4)) & 0x3f);

				$rst .= $c4.$c2.$c3.$c1;
			}

			$v = substr($pad, $v1, 1).substr($pad, $v2, 1).substr($pad, $v3, 1).substr($pad, $v4, 1);

			return $r2.$rst.$v.$code;
		}

		function lp_url_trt($url, $code, $pad)
		{
			return substr($url, 0, strpos($url, "?") + 1)."lpev=".lp_encode(substr($url, strpos($url, "?") + 1), $code, $pad);
		}

		$linkprice_url = lp_url_trt($linkprice_url, $linkprice_code, $linkprice_pad);
		$linkprice_tag = "<script type=\"text/javascript\" src=\"".$linkprice_url."\"> </script>";

		// 이미 입력된 주문건에 대해 재 입력 금지
		$isSql = $db->getSelect( 'SELECT COUNT(*) AS cnt FROM TLINKPRICE WHERE ORDER_CODE = \'' .  $linkUniqueId . '\'' ) ;
		if ( $isSql['cnt'] > 0 )
			$linkprice_tag = '' ;
		else
		{
			$lpSql = 'INSERT INTO TLINKPRICE ( lpinfo , yyyymmdd , hhmiss , order_code , product_code , item_count , price , product_name , category_code , ' ;
			$lpSql .= 'id, name, remote_addr ) values ' . substr ( $linkPriceSql , 0 , -1 ) ;
			$db->getExecSql ( $lpSql ) ;
		}
	}

?>