<?
	$no				= 1;
	// 상품 리스트

	/* 정의 */
	if (!$intWSize) $intWSize 			= $S_PRODLIST_IMG_SIZE_W;
	if (!$intHSize) $intHSize			= $S_PRODLIST_IMG_SIZE_H;
	if (!$intWList) $intWList 			= $S_PRODLIST_IMG_VIEW_W;
	if (!$intHList) $intHList			= $S_PRODLIST_IMG_VIEW_H;
	$strWAlign							= $S_PRODLIST_WORD_ALIGN;
	$strMoney							= $S_PRODLIST_MONEY_TYPE;
	$strMoneyIcon						= $S_PRODLIST_MONEY_ICON;
	$strShow1							= $S_PRODLIST_SHOW_1;
	$strShow2							= $S_PRODLIST_SHOW_2;
	$strShow3							= $S_PRODLIST_SHOW_3;
	$strShow4							= $S_PRODLIST_SHOW_4;
	$strShow5							= $S_PRODLIST_SHOW_5;
	$strShow6							= $S_PRODLIST_SHOW_6;
	$strShow7							= $S_PRODLIST_SHOW_7;
	$strShow8							= $S_PRODLIST_SHOW_8;
	$strColor1							= $S_PRODLIST_COLOR_1;
	$strColor2							= $S_PRODLIST_COLOR_2;
	$strColor3							= $S_PRODLIST_COLOR_3;
	$strColor4							= $S_PRODLIST_COLOR_4;
	$strColor5							= $S_PRODLIST_COLOR_5;
	$strTitleShow						= $S_PRODLIST_TITLE_SHOW_USE;
	$strTitleFile						= $S_PRODLIST_TITLE_FILE_NAME;
	$strNaviUse							= $S_PRODUCT_NAVI_USE_OP;
	$intTitleMaxsize					= $S_PRODLIST_TITLE_MAXSIZE;



	/* 통화 */
	$strMoneyIconL		= "";
	$strMoneyIconR		= "";
	if($strMoney == "sign" || $strMoney == "won"){
		if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){
			if ($S_SITE_LNG == "ES" || $S_SITE_LNG == "TW") $strMoneyIconL = $S_SITE_CUR_MARK1;
			else $strMoneyIconL = $S_SITE_CUR_MARK2."";
		} else {
			if ($S_SITE_LNG == "JP") $strMoneyIconR = $S_SITE_CUR_MARK1;
			else if ($S_SITE_LNG == "RU") $strMoneyIconR = $S_SITE_CUR_MARK1;
			else $strMoneyIconR = $S_SITE_CUR_MARK2;
		}
	}
	else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); }
	else						{ $strMoneyIcon = ""; }

	/* 타이틀 */
	$strTitleCode		= "";
	if($strTitleShow == "style") { $strTitleCode = $strTitle; }
	else if($strTitleShow == "image") { $strTitleCode = sprintf("<img src='%s'/>", $strTitleFile); }

	/* 정보 세팅 */
	$listDataParam	 = "";


	

	$productMgr->setP_CATE("");
	$productMgr->setSearchHCode1($strSearchHCode1);
	$productMgr->setSearchHCode2($strSearchHCode2);
	$productMgr->setSearchHCode3($strSearchHCode3);
	$productMgr->setSearchHCode4($strSearchHCode4);

	$productMgr->setSearchField($strSearchField);
	$productMgr->setSearchKey($strSearchKey);

	$productMgr->setSearchWebView("Y");
	$productMgr->setSearchPriceView("Y");
	$productMgr->setSearchSort($strSearchSort);
	$productMgr->setSearchIcon1($strSearchIcon1);
	$productMgr->setSearchIcon2($strSearchIcon2);
	$productMgr->setSearchIcon3($strSearchIcon3);
	$productMgr->setSearchIcon4($strSearchIcon4);
	$productMgr->setSearchIcon5($strSearchIcon5);
	$productMgr->setSearchIcon6($strSearchIcon6);
	$productMgr->setSearchIcon7($strSearchIcon7);
	$productMgr->setSearchIcon8($strSearchIcon8);
	$productMgr->setSearchIcon9($strSearchIcon9);
	$productMgr->setSearchIcon10($strSearchIcon10);
	$productMgr->setP_BRAND($strSearchBrand);
	$productMgr->setP_SHOP_NO($intProductShopNo);



	$productMgr->setSearchLCate($arySearchLCate[0]);
	$productMgr->setSearchOrigin($arySearchOrigin[0]);
	$productMgr->setSearchType($arySearchType[0]);
	$productMgr->setSearchPriceFilter($arySearchPriceFilter[0]);
	$productMgr->setSearchCreditGrade($arySearchCreditGrade[0]);
	$productMgr->setSearchSaleGrade($arySearchSaleGrade[0]);
	$productMgr->setSearchLocusGrade($arySearchLocusGrade[0]);


	if ($S_FIX_PROD_SEARCH_PRICE_ST_CUR == "Y"){
		$productMgr->setSearchStartPrice($strSearchStartPrice);
		$productMgr->setSearchEndPrice($strSearchEndPrice);
	} else {
		$productMgr->setSearchStartPrice(getPriceToCur($strSearchStartPrice));
		$productMgr->setSearchEndPrice(getPriceToCur($strSearchEndPrice));
	}
	$productMgr->setSearchListIcon($strSearchListIcon);

	$productMgr->setSearchSubKey($strSearchSubKey);

	/* 상품 좋아요 출력여부 */
	if ($S_FIX_PRODUCT_LIST_LIKE_USE == "Y" && ($g_member_no && $g_member_login)){
		$productMgr->setM_NO($g_member_no);
		if (!$strSearchProdLikeType) $strSearchProdLikeType = "prodList";
		$productMgr->setSearchProdLike($strSearchProdLikeType);
	}

	/* 경매상품 여부 */
	if ($S_PRODUCT_AUCTION_USE == "Y"){
		if ($strSearchAuction == "Y"){
			$listDataParam['P_AUC_LIST'] = "Y";
		}
	}

	$productMgr->setP_WEB_VIEW('Y');

	/* 데이터 리스트 */

	$intTotal	= $productMgr->getProdTotal($db,$strMode,$listDataParam);

	
	//echo $db->query;
	//$intPageLine							= $intWList * $intHList;															// 리스트 개수
	$intPageLine = 20; //리스트개수

	if ($strProdListAllView == "Y"){
		$productMgr->setPageLine( $intTotal );
	}else{ 
		if($intSearchPageLine){
			$productMgr->setPageLine($intSearchPageLine);
			$intPageLine = $intSearchPageLine;
		}else{
			$productMgr->setPageLine( $intPageLine );
		}
	}

	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
	$productMgr->setLimitFirst( $intFirst );

	$result = $productMgr->getProdList($db,$strMode,$listDataParam);


		//echo $db->query;


	$intPageBlock					= 10;															// 블럭 개수
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );				// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );
	/* 데이터 리스트 */


	/* 상품 포인트 보여줄때 특정 그룹만 보여주는지에 대한 처리 */
	$strProdPointViewSpecGroupYN = "N";
	if ($strShow3 == "Y"){
		if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
			if ($g_member_login && in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
				$strProdPointViewSpecGroupYN = "Y";
			}
		} else {
			$strProdPointViewSpecGroupYN = "Y";
		}
	}

	/* 전체 카테고리 */
	$cateMgr -> setC_LEVEL('1');
	$cateMgr -> setCL_VIEW_YN('Y'); //사용유무
	$aryCategorys = $cateMgr -> getCateLevelAry($db);

	for($i = 0; $i < sizeof($aryCategorys); $i++){
		$aryCateNames[$aryCategorys[$i][CATE_CODE]] = $aryCategorys[$i][CATE_NAME];
	}


	/* 카테고리별 상품수 */
	$aryProdShopCateCount = $productMgr -> getProdShopCateGroup($db);

	$aryProdCount = array();
	$intProdCountTotal = 0;
	for($i = 0; $i < sizeof($aryProdShopCateCount); $i++){
		$aryProdCount[$aryProdShopCateCount[$i][P_LCATE]] = $aryProdShopCateCount[$i][P_CATE_COUNT];
		$intProdCountTotal += $aryProdShopCateCount[$i][P_CATE_COUNT];
	}

	/* 사용자 리스트를 사용하고 선언된 카테고리외에서만 사용하고 싶을때 */
	if ($S_FIX_PROD_LIST_USER_FLAG == "Y" && (!in_array($strSearchHCode1,$S_FIX_PROD_LIST_USER_CATE_NOT_LIST))){
		include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/userAdd/user.prodList.skin.php";
	} else {
		include "prodList." . $S_PRODLIST_DESIGN . ".skin.html.php";
	}
?>