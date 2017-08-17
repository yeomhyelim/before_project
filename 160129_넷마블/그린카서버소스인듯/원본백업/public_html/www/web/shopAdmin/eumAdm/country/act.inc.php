<?
	require_once MALL_CONF_LIB."EumMgr.php";

	$eumMgr = new EumMgr();
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
		
	$strSearchDeliveryMth		= $_POST["searchDeliveryMth"]		? $_POST["searchDeliveryMth"]		: $_REQUEST["searchDeliveryMth"];
	$strSearchCountryZone		= $_POST["searchCountryZone"]		? $_POST["searchCountryZone"]		: $_REQUEST["searchCountryZone"];
	
	$intPage					= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];
	$intPageLine				= $_POST["pageLine"]				? $_POST["pageLine"]				: $_REQUEST["pageLine"];	
	/*##################################### Parameter 셋팅 #####################################*/


	$intCZ_NO		= $_POST["no"]			? $_POST["no"]			: $_REQUEST["no"];
	$intCZ_ZONE		= $_POST["countryZone"];
	$strCT_CODE		= $_POST["countryCode"];

	$strCT_CODE		= strTrim($strCT_CODE,10);
	
	$eumMgr->setCZ_NO($intCZ_NO);
	$eumMgr->setCT_CODE($strCT_CODE);
	$eumMgr->setCZ_MTH($strSearchDeliveryMth);
	$eumMgr->setCZ_ZONE($intCZ_ZONE);

	$strLinkPage  = "searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchDeliveryMth=$strSearchDeliveryMth";
	$strLinkPage .= "&searchCountryZone=$strSearchCountryZone";
	$strLinkPage .= "&pageLine=$intPageLine&page=$intPage";

	switch ($strAct) {
		case "countryZoneWrite":

			## 2015.03.02 kim hee sung
			## 등록이 안되는 경우 컬럼 값 체크 
			## ALTER TABLE `COUNTRY_ZONE` MODIFY COLUMN `CZ_MTH` VARCHAR(3) COLLATE utf8_general_ci COMMENT '배송방법';
			
			$eumMgr->getCountryZoneInsert($db);
			
			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=countryList&".$strLinkPage;

		break;

		case "countryZoneModify":

			$intCZ_ZONE		= $_POST["countryZone_".$intCZ_NO];
			$strCT_CODE		= $_POST["countryCode_".$intCZ_NO];

			$eumMgr->setCT_CODE($strCT_CODE);
			$eumMgr->setCZ_MTH($strSearchDeliveryMth);
			$eumMgr->setCZ_ZONE($intCZ_ZONE);

			$eumMgr->getCountryZoneUpdate($db);

			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=countryList&".$strLinkPage;

		break;

		case "countryZoneDelete":

			$eumMgr->getCountryZoneDelete($db);

			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=countryList&".$strLinkPage;

		break;
	}
?>