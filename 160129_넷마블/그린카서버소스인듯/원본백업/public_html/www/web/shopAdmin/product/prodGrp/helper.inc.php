<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."DesignSetMgr.php";

	require_once "../conf/site_skin_product.conf.inc.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	$siteMgr = new SiteMgr();		
	$memberMgr = new MemberMgr();
	$designSetMgr = new DesignSetMgr();	

	switch($strMode){


		case "prodGrpList":
			/* 관리자 Sub Menu 권한 설정 */
			
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */
			
			/* 언어 선택 */
			$productMgr->setP_LNG($strStLng);

			/* 검색부분 */
			$productMgr->setSearchHCode1($strSearchHCode1);
			$productMgr->setSearchHCode2($strSearchHCode2);
			$productMgr->setSearchHCode3($strSearchHCode3);
			$productMgr->setSearchHCode4($strSearchHCode4);

			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setSearchLaunchStartDt($strSearchLaunchStartDt);
			$productMgr->setSearchLaunchEndDt($strSearchLaunchEndDt);
			$productMgr->setSearchRepStartDt($strSearchRepStartDt);
			$productMgr->setSearchRepEndDt($strSearchRepEndDt);
			$productMgr->setSearchWebView($strSearchWebView);
			$productMgr->setSearchMobileView($strSearchMobileView);
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

			if ($a_admin_type == "S") $productMgr->setSearchShopNo($a_admin_shop_no);

			/* 검색부분 */

			$intPageBlock	= 10;
//			$intPageLine	= 10;
			if(!$intPageLine) $intPageLine = 10;			
			$productMgr->setPageLine($intPageLine);
	
			$intTotal	= $productMgr->getProdTotal($db);
			$intTotPage	= ceil($intTotal / $productMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$productMgr->setLimitFirst($intFirst);

			$result = $productMgr->getProdList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
			
			/* 진열장 */
			$cateMgr->setIC_TYPE("MAIN");
			$aryProdMainDisplayList = $cateMgr->getProdDisplayList($db);

			$cateMgr->setIC_TYPE("SUB");
			$aryProdSubDisplayList = $cateMgr->getProdDisplayList($db);

			$linkPage  = "?menuType=$strMenuType&mode=$strMode&searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
			$linkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$linkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$linkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$linkPage .= "&searchIcon1=$strSearchIcon1";
			$linkPage .= "&searchIcon2=$strSearchIcon2";
			$linkPage .= "&searchIcon3=$strSearchIcon3";
			$linkPage .= "&searchIcon4=$strSearchIcon4";
			$linkPage .= "&searchIcon5=$strSearchIcon5";
			$linkPage .= "&searchIcon6=$strSearchIcon6";
			$linkPage .= "&searchIcon7=$strSearchIcon7";
			$linkPage .= "&searchIcon8=$strSearchIcon8";
			$linkPage .= "&searchIcon9=$strSearchIcon9";
			$linkPage .= "&searchIcon10=$strSearchIcon10&page=";
		break;


	}

?>
