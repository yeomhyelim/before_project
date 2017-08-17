<?
	require_once MALL_CONF_LIB."CateMgr.php";
	$cateMgr = new CateMgr();


	switch($strMode){

		case "prodStockList":

			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$intPageLine){
				$intPageLine = $_COOKIE["COOKIE_ADM_PROD_STOCK_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_PROD_STOCK_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_PROD_STOCK_LIST_LINE",$intPageLine,time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */


			include $strIncludePath.$aryIncludeFolder[$strMode]."/help.prodStock.".$strProductVersion.".inc.php";


//			/* 검색부분 */
//			$productMgr->setSearchHCode1($strSearchHCode1);
//			$productMgr->setSearchHCode2($strSearchHCode2);
//			$productMgr->setSearchHCode3($strSearchHCode3);
//			$productMgr->setSearchHCode4($strSearchHCode4);
//
//			$productMgr->setSearchField($strSearchField);
//			$productMgr->setSearchKey($strSearchKey);
//			$productMgr->setSearchStock1($strSearchStock1);
//			$productMgr->setSearchStock2($strSearchStock2);
//			$productMgr->setSearchStock3($strSearchStock3);
//
//			if ($a_admin_type == "S") $productMgr->setSearchShopNo($a_admin_shop_no);
//
//			/* 검색부분 */
//
//			$intPageBlock	= 10;
////			$intPageLine	= 10;
//			if(!$intPageLine) $intPageLine = 10;
//			$productMgr->setPageLine($intPageLine);
//
//			$intTotal	= $productMgr->getProdTotal($db);
//			$intTotPage	= ceil($intTotal / $productMgr->getPageLine());
//
//			if(!$intPage)	$intPage =1;
//
//			if ($intTotal==0) {
//				$intFirst	= 1;
//				$intLast	= 0;
//			} else {
//				$intFirst	= $intPageLine *($intPage -1);
//				$intLast	= $intPageLine * $intPage;
//			}
//			$productMgr->setLimitFirst($intFirst);
//
//			$result = $productMgr->getProdList($db);
//			$intListNum = $intTotal - ($intPageLine *($intPage-1));

			/* 진열장 */
//			$cateMgr->setIC_TYPE("MAIN");
//			$aryProdMainDisplayList = $cateMgr->getProdDisplayList($db);

//			$cateMgr->setIC_TYPE("SUB");
//			$aryProdSubDisplayList = $cateMgr->getProdDisplayList($db);
//
//			$linkPage  = "?menuType=$strMenuType&mode=$strMode&searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
//			$linkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
//			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
//			$linkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
//			$linkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
//			$linkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
//			$linkPage .= "&searchIcon1=$strSearchIcon1";
//			$linkPage .= "&searchIcon2=$strSearchIcon2";
//			$linkPage .= "&searchIcon3=$strSearchIcon3";
//			$linkPage .= "&searchIcon4=$strSearchIcon4";
//			$linkPage .= "&searchIcon5=$strSearchIcon5";
//			$linkPage .= "&searchIcon6=$strSearchIcon6";
//			$linkPage .= "&searchIcon7=$strSearchIcon7";
//			$linkPage .= "&searchIcon8=$strSearchIcon8";
//			$linkPage .= "&searchIcon9=$strSearchIcon9";
//			$linkPage .= "&searchIcon10=$strSearchIcon10&pageLine=$intPageLine&page=";
		break;
	}
?>
