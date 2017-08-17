<?
//	$no				= 1;
	$strUse			= $S_ARY_SUB_PRODLIST_USE[$no];
	$strTitle		= ${"S_SUB_PRODLIST_TIT_{$no}"};
	
	## 2014.08.26 kim hee sung 진열장관리와 디자인관리/세부페이지 통합으로 설정 부분 변경
	## 사용을 원하시는 경우. $S_PRODUCT_ICON_WITH_DESIGN 옵션 추가 후, 진열장 관리 다시 저장
	if($S_PRODUCT_ICON_WITH_DESIGN == "Y"):
		include MALL_SHOP . "/conf/conf/product.inc.php";
		if($S_ARY_PRODUCT_LIST_SUB):
			if($S_ARY_PRODUCT_LIST_SUB[$no]):
				## 기본설정
				$strUse = $S_ARY_PRODUCT_LIST_SUB[$no]['USE'];
				$strTitle = $S_ARY_PRODUCT_LIST_SUB[$no]['NAME'];
			endif;
		endif;
	endif;
	
	if(($strUse == "Y" && ($strTitle)) || ($strSubMainYN == "Y")) :
		// 베스트 상품
		
		/* 정의 */
		if (!$intWSize)		{ $intWSize 	= ${"S_SUB_PRODLIST_IMG_SIZE_W_{$no}"}; }
		if (!$intHSize)		{ $intHSize		= ${"S_SUB_PRODLIST_IMG_SIZE_H_{$no}"}; }
		if (!$intWList)		{ $intWList		= ${"S_SUB_PRODLIST_IMG_VIEW_W_{$no}"}; }
		if (!$intHList)		{ $intHList		= ${"S_SUB_PRODLIST_IMG_VIEW_H_{$no}"}; }
		if (!$strWAlign)	{ $strWAlign	= ${"S_SUB_BEST_LIST{$no}_WORD_ALIGN"}; }
		if (!$strMoney)		{ $strMoney		= ${"S_SUB_BEST_LIST{$no}_MONEY_TYPE"}; }

		$strMoneyIcon		= ${"S_SUB_BEST_LIST{$no}_MONEY_ICON"};
		$strShow1			= ${"S_SUB_BEST_LIST{$no}_SHOW_1"};
		$strShow2			= ${"S_SUB_BEST_LIST{$no}_SHOW_2"};
		$strShow3			= ${"S_SUB_BEST_LIST{$no}_SHOW_3"};
		$strShow4			= ${"S_SUB_BEST_LIST{$no}_SHOW_4"};
		$strShow5			= ${"S_SUB_BEST_LIST{$no}_SHOW_5"};
		$strShow6			= ${"S_SUB_BEST_LIST{$no}_SHOW_6"};
		$strShow7			= ${"S_SUB_BEST_LIST{$no}_SHOW_7"};
		$strShow8			= ${"S_SUB_BEST_LIST{$no}_SHOW_8"};
		$strColor1			= ${"S_SUB_BEST_LIST{$no}_COLOR_1"};
		$strColor2			= ${"S_SUB_BEST_LIST{$no}_COLOR_2"};
		$strColor3			= ${"S_SUB_BEST_LIST{$no}_COLOR_3"};
		$strColor4			= ${"S_SUB_BEST_LIST{$no}_COLOR_4"};
		$strColor5			= ${"S_SUB_BEST_LIST{$no}_COLOR_5"};
		$strTitleShow		= ${"S_SUB_BEST_LIST{$no}_TITLE_SHOW_USE"};
		$strTitleFile		= ${"S_SUB_BEST_LIST{$no}_TITLE_FILE_NAME"};
		$intTitleMaxsize	= ${"S_SUB_BEST_LIST{$no}_TITLE_MAXSIZE"};

		/* 통화 */
		$strMoneyIconL		= "";
		$strMoneyIconR		= "";
		if($strMoney == "sign" || $strMoney == "won"){ 
			if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){
				if ($S_SITE_LNG == "ES" || $S_SITE_LNG == "MX") $strMoneyIconL = $S_SITE_CUR_MARK1;
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

		$pCate = $_REQUEST['lcate'] . $_REQUEST['mcate'] . $_REQUEST['scate'] . $_REQUEST['fcate'];

		/* 기존에 등록된 데이터 삭제 */
//		$productMgr->setSearchHCode1("");
		$productMgr->setSearchHCode2("");
		$productMgr->setSearchHCode3("");
		$productMgr->setSearchHCode4("");

		$productMgr->setSearchField("");
		$productMgr->setSearchKey("");

		$productMgr->setSearchWebView("Y");
		$productMgr->setSearchPriceView("");
		$productMgr->setSearchSort("");
		$productMgr->setSearchIcon1("");
		$productMgr->setSearchIcon2("");
		$productMgr->setSearchIcon3("");
		$productMgr->setSearchIcon4("");
		$productMgr->setSearchIcon5("");
		$productMgr->setSearchIcon6("");
		$productMgr->setSearchIcon7("");
		$productMgr->setSearchIcon8("");
		$productMgr->setSearchIcon9("");
		$productMgr->setSearchIcon10("");	
		$productMgr->setLimitFirst(0);
		$productMgr->setP_CATE($pCate);

		if ($S_FIX_PROD_SEARCH_PRICE_ST_CUR == "Y"){		
			$productMgr->setSearchStartPrice($strSearchStartPrice);
			$productMgr->setSearchEndPrice($strSearchEndPrice);
		} else {
			$productMgr->setSearchStartPrice(getPriceToCur($strSearchStartPrice));
			$productMgr->setSearchEndPrice(getPriceToCur($strSearchEndPrice));
		}

		$productMgr->setSearchListIcon($strSearchListIcon);

		/* 상품 호출 개수 */
		$intPageLine 		= $intWList * $intHList;

		/* 베스트 상품 그룹(아이콘) 설정 */
		if( $no == 1 ) :
			$productMgr->setSearchIcon6("Y");
		elseif ($no == 2) :
			$productMgr->setSearchIcon7("Y");	
		elseif ($no == 3) :
			$productMgr->setSearchIcon8("Y");	
		elseif ($no == 4) :
			$productMgr->setSearchIcon9("Y");	
		elseif ($no == 5) :
			$productMgr->setSearchIcon10("Y");	
		endif;

		$productMgr->setPageLine($intPageLine);
		$intProdRowCnt 	= $productMgr->getProdTotal($db);	
		$aryProdRow 	= $productMgr->getProdList($db);
		//echo $db->query;

		
		// 스킨
		if($intProdRowCnt == 0) :
		else :
			if ($strSubMainYN == "Y") include "bestList.all.skin.html.php";
			else include "bestList." . ${"S_SUB_BEST_LIST{$no}_DESIGN"} . ".skin.html.php";
		endif;

		## 초기화
		$intWSize 			= "";
		$intHSize			= "";
		$intWList 			= "";
		$intHList			= "";
		$productMgr->setP_CATE("");
	endif;
?>