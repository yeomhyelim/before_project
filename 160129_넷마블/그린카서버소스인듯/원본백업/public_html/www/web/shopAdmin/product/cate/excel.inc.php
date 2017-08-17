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

	switch($strAct){
		case "excelCateList":
			
			/* 1차 카테고리 불러오기 */
			$cateMgr->setCL_LNG($strStLng);
			$cateMgr->setC_LEVEL(1);
			$cateMgr->setC_HCODE("");
			$cateMgr->setC_VIEW_YN("");
			$cateMgr->setC_TYPE($strCateType); //기획전 구분값(나중에 다른 카테고리 종류가 필요할때 값을 따로 주면 됨
			$aryCate01 = $cateMgr->getCateLevelAry($db);

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

			$dateYMD			= date("Ymd");
			$strExcelFileName	= "{$dateYMD}_상품카테고리리스트.xls"; 

		break;

	}

?>