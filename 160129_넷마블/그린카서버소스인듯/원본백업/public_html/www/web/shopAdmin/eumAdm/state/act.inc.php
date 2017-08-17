<?
	require_once MALL_CONF_LIB."EumMgr.php";

	$eumMgr = new EumMgr();
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchCountryCode	= $_POST["searchCountryCode"]		? $_POST["searchCountryCode"]		: $_REQUEST["searchCountryCode"];
	/*##################################### Parameter 셋팅 #####################################*/

	$intCountryStateNo	= $_POST["no"];

	$param["ct_code"]	= strTrim($strSearchCountryCode,2);
	$param["cs_code"]	= strTrim($_POST["countryStateCode"],2);
	$param["cs_name"]	= strTrim($_POST["countryStateName"],100);
	$param["cs_area"]	= strTrim($_POST["countryStateArea"],2);
	$param["cs_reg_no"] = $a_admin_no;
	
	$strLinkPage  = "searchCountryCode=$strSearchCountryCode";
	
	switch ($strAct) {
		case "countryStateWrite":
			
			$eumMgr->getCountryStateWrite($db,$param);
			
			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=countryStateList&".$strLinkPage;
			
		break;

		case "countryStateModify":
			
	
			if ($intCountryStateNo > 0){
				$param				= "";
				
				$param["cs_no"]		= $intCountryStateNo;
				$param["ct_code"]	= strTrim($strSearchCountryCode,2);
				$param["cs_code"]	= strTrim($_POST["countryStateCode_".$intCountryStateNo],2);
				$param["cs_name"]	= strTrim($_POST["countryStateName_".$intCountryStateNo],100);
				$param["cs_area"]	= strTrim($_POST["countryStateArea_".$intCountryStateNo],2);
				
				$eumMgr->getCountryStateModify($db,$param);
			}

			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=countryStateList&".$strLinkPage;

		break;

		case "countryStateDelete":

			$param["cs_no"]		= $intCountryStateNo;

			$eumMgr->getCountryStateDelete($db,$param);

			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=countryStateList&".$strLinkPage;

		break;

	}
?>