<?
	$no				= 1;
	$strUse			= $S_PRODUCT_VIEW_BEST_LIST1_USE;

	if(in_array($strUse, array("A","B","C"))) :
		// 관련 상품

		/* 정의 */
		$intWSize 			= $S_PRODUCT_VIEW_BEST_LIST1_SIZE_W;
		$intHSize			= $S_PRODUCT_VIEW_BEST_LIST1_SIZE_H;
		$intWList 			= $S_PRODUCT_VIEW_BEST_LIST1_VIEW_W;
		$intHList			= $S_PRODUCT_VIEW_BEST_LIST1_VIEW_H;
		$strWAlign			= $S_PRODUCT_VIEW_BEST_LIST1_WORD_ALIGN;
		$strMoney			= $S_PRODUCT_VIEW_BEST_LIST1_MONEY_TYPE;
		$strMoneyIcon		= $S_PRODUCT_VIEW_BEST_LIST1_MONEY_ICON;
		$strColor1			= $S_PRODUCT_VIEW_BEST_LIST1_COLOR_1;
		$strColor2			= $S_PRODUCT_VIEW_BEST_LIST1_COLOR_2;
		$strColor3			= $S_PRODUCT_VIEW_BEST_LIST1_COLOR_3;
		$strColor4			= $S_PRODUCT_VIEW_BEST_LIST1_COLOR_4;
		$strColor5			= $S_PRODUCT_VIEW_BEST_LIST1_COLOR_5;
		$strShow1			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_1;
		$strShow2			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_2;
		$strShow3			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_3;
		$strShow4			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_4;
		$strShow5			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_5;
		$strShow6			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_6;
		$strShow7			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_7;
		$strShow8			= $S_PRODUCT_VIEW_BEST_LIST1_SHOW_8;
		$strTitleShow		= $S_PRODUCT_VIEW_BEST_LIST1_TITLE_SHOW_USE;
		$strTitleFile		= $S_PRODUCT_VIEW_BEST_LIST1_TITLE_FILE_NAME;


		/* 통화 */
		$strMoneyIconL		= "";
		$strMoneyIconR		= "";
		if($strMoney == "sign" || $strMoney == "won"){
			if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){
				if ($S_SITE_LNG == "ES") $strMoneyIconL = $S_SITE_CUR_MARK1;
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


		/* 기존에 등록된 데이터 삭제 */
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



		$productMgr->setPageLine($intPageLine);
		$productMgr->setP_CODE($strP_CODE);
		$productMgr->setP_LNG($S_SITE_LNG); /** 2013.06.13 kim hee sung, 언어 구분 추가 **/
		$intProdRowCnt 	= $productMgr->getProdGrpList($db, "OP_COUNT");
		$aryProdRow 	= $productMgr->getProdGrpList($db, "OP_LIST");


		// 스킨
		if($intProdRowCnt == 0) :

		else :
			include "relationList.skin.html.php";
		endif;

	endif;
?>