<?
	if(!$S_PRODUCT_VIEW_IMAGE_DESIGN) :
		$S_PRODUCT_VIEW_IMAGE_DESIGN = "PI0001";
	endif;

	$strSnsUse			= $S_PRODUCT_VIEW_SNS_USE;			/* sns 사용 유무 */
	if($strSnsUse == "Y") :
		$strSnsLink				= sprintf("%s/%s/?menuType=product&mode=view&prodCode=%s", $S_SITE_URL, $S_SITE_LNG_PATH, $strP_CODE);
		$strSnsName				= $prodRow['P_NAME'];
		if($prodImgRow):
			$strSnsImg			= sprintf("%s", $prodImgRow[0]['PM_REAL_NAME']);
			if(substr($strSnsImg,0,4) != "http") { $strSnsImg = "{$S_SITE_URL}{$strSnsImg}"; }
		endif;
		$arySns['facebook']		= $S_PRODUCT_VIEW_SNS_FACEBOOK;
		$arySns['twitter']		= $S_PRODUCT_VIEW_SNS_TWITTER;
		$arySns['m2day']		= $S_PRODUCT_VIEW_SNS_M2DAY;
	endif;

	/* 통화 */
	$strMoney			= $S_PRODLIST_MONEY_TYPE;
	$strMoneyIcon		= $S_PRODLIST_MONEY_ICON;
	$strMoneyIconL		= "";
	$strMoneyIconR		= "";
	if($strMoney == "sign" || $strMoney == "won"){
		if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){
			if ($S_SITE_LNG == "ES") $strMoneyIconL = $S_SITE_CUR_MARK1;
			else $strMoneyIconL = $S_SITE_CUR_MARK2." ";
		} else {
			if ($S_SITE_LNG == "JP") $strMoneyIconR = $S_SITE_CUR_MARK1;
			else if ($S_SITE_LNG == "RU") $strMoneyIconR = $S_SITE_CUR_MARK1;
			else $strMoneyIconR = $S_SITE_CUR_MARK2;
		}
	}
	else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); }
	else						{ $strMoneyIcon = ""; }

	/* 기타 설정 */
	$strShow2			= $S_PRODLIST_SHOW_2;		// 한줄설명


	## 판매가 할인율
	$intProdDiscountRate	= 0;
	if ($S_FIX_PRODUCT_DISCOUNT_RATE_SHOW == "Y"){
		if($row[$key]['P_CONSUMER_PRICE'] > 0.00001){
		$intProdDiscountRate= getRoundUp((($prodRow['P_CONSUMER_PRICE'] - $prodRow['P_SALE_PRICE'])/$prodRow['P_CONSUMER_PRICE']) * 100,0);
		$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
		}
	}

	/* 상품 포인트 보여줄때 특정 그룹만 보여주는지에 대한 처리 */
	$strProdPointViewSpecGroupYN = "N";
	if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
		if ($g_member_login && in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
			$strProdPointViewSpecGroupYN = "Y";
		}
	} else {
		$strProdPointViewSpecGroupYN = "Y";
	}



	/* 사용자 상세보기를 사용 */
	if ($S_FIX_PROD_VIEW_USER_FLAG == "Y"){
		include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/userAdd/user.prodView.topDetailInfo.skin.php";
	} else {
		if ($strProdAuctionUseYN == "Y") include "prodView.topDetailInfo.Auction.skin.html.php";
		else include "prodView.topDetailInfo.{$S_PRODUCT_VIEW_IMAGE_DESIGN}.skin.html.php";
	}

?>