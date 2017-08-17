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

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strGb			= $_POST["gb"]				? $_POST["gb"]				: $_REQUEST["gb"];
	
	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strMode){
		case "prodEvent":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";			
			/* 관리자 Sub Menu 권한 설정 */
			
			/* 언어 선택 */
			$productMgr->setP_LNG($strStLng);

			if (!$strGb) $strGb = "2";	
			$productMgr->setSE_LIST_GUBUN($strGb);			
			$arySiteEventList = $productMgr->getSiteEventList($db);
			
		break;

	}
?>
