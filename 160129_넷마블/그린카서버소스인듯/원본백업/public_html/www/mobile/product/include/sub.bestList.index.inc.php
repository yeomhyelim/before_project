<?
//	$no				= 1;
	$strUse			= $S_ARY_SUB_PRODLIST_USE[$no];
	$strTitle		= ${"S_SUB_PRODLIST_TIT_{$no}"};

	if($strUse == "Y" && ($strTitle)) :
		// 베스트 상품
		
		/* 정의 */
		$intWSize 			= ${"S_SUB_PRODLIST_IMG_SIZE_W_{$no}"};
		$intHSize			= ${"S_SUB_PRODLIST_IMG_SIZE_H_{$no}"};
		$intWList 			= ${"S_SUB_PRODLIST_IMG_VIEW_W_{$no}"};
		$intHList			= ${"S_SUB_PRODLIST_IMG_VIEW_H_{$no}"};
		$strWAlign			= ${"S_SUB_BEST_LIST{$no}_WORD_ALIGN"};
		$strMoney			= ${"S_SUB_BEST_LIST{$no}_MONEY_TYPE"};
		$strMoneyIcon		= ${"S_SUB_BEST_LIST{$no}_MONEY_ICON"};
		$strShow1			= ${"S_SUB_BEST_LIST{$no}_SHOW_1"};
		$strShow2			= ${"S_SUB_BEST_LIST{$no}_SHOW_2"};
		$strShow3			= ${"S_SUB_BEST_LIST{$no}_SHOW_3"};
		$strShow4			= ${"S_SUB_BEST_LIST{$no}_SHOW_4"};
		$strShow5			= ${"S_SUB_BEST_LIST{$no}_SHOW_5"};
		$strColor1			= ${"S_SUB_BEST_LIST{$no}_COLOR_1"};
		$strColor2			= ${"S_SUB_BEST_LIST{$no}_COLOR_2"};
		$strColor3			= ${"S_SUB_BEST_LIST{$no}_COLOR_3"};
		$strColor4			= ${"S_SUB_BEST_LIST{$no}_COLOR_4"};
		$strColor5			= ${"S_SUB_BEST_LIST{$no}_COLOR_5"};
		$strTitleShow		= ${"S_SUB_BEST_LIST{$no}_TITLE_SHOW_USE"};
		$strTitleFile		= ${"S_SUB_BEST_LIST{$no}_TITLE_FILE_NAME"};

		/* 통화 */
		$strMoneyIconL		= "";
		$strMoneyIconR		= "";
		if($strMoney =="sign")		{ $strMoneyIconL = " ￦"; } 
		else if($strMoney =="won")	{ $strMoneyIconR = " 원"; } 
		else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); } 
		else						{ $strMoneyIcon = ""; }

		/* 타이틀 */
		$strTitleCode		= "";
		if($strTitleShow == "style") { $strTitleCode = $strTitle; }
		else if($strTitleShow == "image") { $strTitleCode = sprintf("<img src='%s'/>", $strTitleFile); }

		/* 기존에 등록된 데이터 삭제 */
//		$productMgr->setSearchHCode1("");
		$productMgr->setSearchHCode2("");
		$productMgr->setSearchHCode3("");
		$productMgr->setSearchHCode4("");

		$productMgr->setSearchField("");
		$productMgr->setSearchKey("");
		$productMgr->setSearchWebView("");
		$productMgr->setSearchMobileView("Y");
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

		/* 상품 호출 개수 */
		$intPageLine 		= $intWList * $intHList;

		/* 베스트 상품 그룹(아이콘) 설정 */
		if( $no == 6 ) :
			$productMgr->setSearchIcon6("Y");
		elseif ($no == 7) :
			$productMgr->setSearchIcon7("Y");	
		elseif ($no == 8) :
			$productMgr->setSearchIcon8("Y");	
		elseif ($no == 9) :
			$productMgr->setSearchIcon9("Y");	
		elseif ($no == 10) :
			$productMgr->setSearchIcon10("Y");	
		endif;

		$productMgr->setPageLine($intPageLine);
		$intProdRowCnt 	= $productMgr->getProdTotal($db);
		$aryProdRow 	= $productMgr->getProdList($db);

	//	echo $db->query;
		// 스킨
		if($intProdRowCnt == 0) :
			echo "<div class=\"noListWrap\">";
			echo "등록된 상품이 없습니다.";	// 차후 페이지 제작
			echo "</div>";
		else :
			include "bestList." . ${"S_SUB_BEST_LIST{$no}_DESIGN"} . ".skin.html.php";
		endif;

	endif;
?>