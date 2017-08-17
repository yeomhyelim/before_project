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
	$intC_LEVEL			= $_POST["cateLevel"]	? $_POST["cateLevel"]			: $_REQUEST["cateLevel"];
	$strC_HCODE			= $_POST["cateHCode"]	? $_POST["cateHCode"]			: $_REQUEST["cateHCode"];
	$strC_VIEW_YN		= $_POST["cateView"]	? $_POST["cateView"]			: $_REQUEST["cateView"];
	$strC_LNG			= $_POST["cateLng"]		? $_POST["cateLng"]				: $_REQUEST["cateLng"];

	$strC_TYPE			= $_POST["cateType"]	? $_POST["cateType"]			: $_REQUEST["cateType"];
	/*##################################### Parameter 셋팅 #####################################*/

	$intC_LEVEL			= IM_IsBlank($intC_LEVEL,"1");
	$strC_VIEW_YN		= IM_IsBlank($strC_VIEW_YN,"N");

	switch ($strJsonMode){
		case "cateLevelList":
			$cateMgr->setCL_LNG($strC_LNG);
			$cateMgr->setC_LEVEL($intC_LEVEL);
			$cateMgr->setC_HCODE($strC_HCODE);
			$cateMgr->setC_VIEW_YN($strC_VIEW_YN);
			$cateMgr->setC_TYPE($strCateType); //기획전 구분값(나중에 다른 카테고리 종류가 필요할때 값을 따로 주면 됨

			$array = $cateMgr->getCateLevelAry($db);
			$result_array = json_encode($array);
			echo $result_array;
		break;
	}



?>