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

	$strCATE_CODE	= $_POST["cateCode"]		? $_POST["cateCode"]		: $_REQUEST["cateCode"];
	$strC_HCODE1	= $_POST["cateHCode1"]		? $_POST["cateHCode1"]		: $_REQUEST["cateHCode1"];
	$strC_HCODE2	= $_POST["cateHCode2"]		? $_POST["cateHCode2"]		: $_REQUEST["cateHCode2"];
	$strC_HCODE3	= $_POST["cateHCode3"]		? $_POST["cateHCode3"]		: $_REQUEST["cateHCode3"];
	$strC_HCODE4	= $_POST["cateHCode4"]		? $_POST["cateHCode4"]		: $_REQUEST["cateHCode4"];
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "cateList":
		case "catePlanList":
		case "excelCateList":

			/* 관리자 Sub Menu 권한 설정 */
			if ($strMode == "catePlanList") {

				/* 기획전 카테고리 구분 여부 */
				$strCateType = "P";

				$strLeftMenuCode01 = "003";
				$strLeftMenuCode02 = "001";

			} else {
				$strLeftMenuCode01 = "003";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */


			/* 1차 카테고리 불러오기 */
			$cateMgr->setCL_LNG($strStLng);
			$cateMgr->setC_LEVEL(1);
			$cateMgr->setC_HCODE("");
			$cateMgr->setC_VIEW_YN("");
			$cateMgr->setC_TYPE($strCateType); //기획전 구분값(나중에 다른 카테고리 종류가 필요할때 값을 따로 주면 됨
			$aryCate01 = $cateMgr->getCateLevelAry($db);
//			echo $db->query;

			/* 접근 그룹 */
			$aryMemberGroup = $memberMgr->getGroupList($db);

			$aryUseLng = explode("/",$S_USE_LNG);
			for($i=0;$i<sizeof($aryUseLng);$i++){
				if ($aryUseLng[$i] == "KR") $strUseLngKr = "Y";
				if ($aryUseLng[$i] == "US") $strUseLngUs = "Y";
				if ($aryUseLng[$i] == "ID") $strUseLngId = "Y";
				if ($aryUseLng[$i] == "CN") $strUseLngCn = "Y";
				if ($aryUseLng[$i] == "JP") $strUseLngJp = "Y";
				if ($aryUseLng[$i] == "FR") $strUseLngFr = "Y";
			}

		break;
	}
?>