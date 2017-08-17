<?
	require_once MALL_CONF_LIB."EumMgr.php";

	$eumMgr = new EumMgr();


	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchDeliveryMth		= $_POST["searchDeliveryMth"]		? $_POST["searchDeliveryMth"]		: $_REQUEST["searchDeliveryMth"];
	$strSearchCountryZone		= $_POST["searchCountryZone"]		? $_POST["searchCountryZone"]		: $_REQUEST["searchCountryZone"];
	$strSearchCountryCode		= $_POST["searchCountryCode"]		? $_POST["searchCountryCode"]		: $_REQUEST["searchCountryCode"];

	
	$intPage					= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];
	$intPageLine				= $_POST["pageLine"]				? $_POST["pageLine"]				: $_REQUEST["pageLine"];
	
	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strMode){
		case "countryStateList":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */

			//if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-10,date("Y")));
			//if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			
			/* 검색부분 */
			if (!$strSearchCountryCode) $strSearchCountryCode = "US";

			$eumMgr->setSearchField($strSearchField);
			$eumMgr->setSearchKey($strSearchKey);
			$eumMgr->setSearchCountryCode($strSearchCountryCode);

			
			$intTotal	= $eumMgr->getCountryStateList($db,"countryStateCount");

			$result = $eumMgr->getCountryStateList($db,"countryStateList");

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchCountryCode=$strSearchCountryCode";
			$linkPage .= "&page=";


	
		break;

	}
?>