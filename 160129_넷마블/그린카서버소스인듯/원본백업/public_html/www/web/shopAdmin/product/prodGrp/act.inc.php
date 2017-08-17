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
	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	
	/*##################################### Parameter 셋팅 #####################################*/

	$strP_CODE			= strTrim($strP_CODE,25);

	$strLinkPage = "";

	switch ($strAct) {
		case "prodGrpSave":
			
			$productMgr->setP_CODE($strP_CODE);
			
			$aryProdGrpCode			= $_POST["prodGrpCode"]			? $_POST["prodGrpCode"]			: $_REQUEST["prodGrpCode"];
			if (is_array($aryProdGrpCode)){
				
				$strProdGrpCodeNoList = "";
				for($i=0;$i<sizeof($aryProdGrpCode);$i++){
					$productMgr->setPG_P_CODE($aryProdGrpCode[$i]);
					if ($productMgr->getProdGrpDupCount($db) == 0){
						$productMgr->getProdGrpInsert($db);
						$intPG_NO = $db->getLastInsertID();
					} else {
						$intPG_NO = $productMgr->getProdGrpNo($db);
					}
					$strProdGrpCodeNoList .= $intPG_NO.",";
				};

				if ($strProdGrpCodeNoList){
					$productMgr->setPG_NO_ALL(SUBSTR($strProdGrpCodeNoList,0,STRLEN($strProdGrpCodeNoList)-1));
					$productMgr->getProdGrpAllDelete($db);
				}
			}
			
			$strUrl = "./?menuType=product&mode=popProdGrpList&prodCode=".$strP_CODE;
		break;

	}	
?>