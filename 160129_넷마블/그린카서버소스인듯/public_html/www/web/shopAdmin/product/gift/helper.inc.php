<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	$siteMgr = new SiteMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	
	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strMode){
		case "gift":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";			
			/* 관리자 Sub Menu 권한 설정 */
			
			/* 언어 선택 */
			$siteRow = $siteMgr->getSiteInfoView($db);
			$aryUseLng = explode("/",$siteRow[S_USE_LNG]);

			$productMgr->setCG_LNG($strStLng);

			/* 검색부분 */
			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			/* 검색부분 */

			$intPageBlock	= 10;
//			$intPageLine	= 10;
			if(!$intPageLine) $intPageLine = 10;			
			$productMgr->setPageLine($intPageLine);
	
			$intTotal	= $productMgr->getGiftTotal($db);
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

			$result = $productMgr->getGiftList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&page=";

		break;

	}
?>
