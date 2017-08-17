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


	$intDA_NO		= $_POST["no"]			? $_POST["no"]			: $_REQUEST["no"];
	$strDA_AREA		= $_POST["deliveryZone"];
	$strDA_WEIGHT	= $_POST["deliveryWeight"];
	$strDA_MTH		= $_POST["deliveryMth"];
	$intDA_PRICE	= $_POST["deliveryPrice"];

	$strDA_TYPE		= "W";
	$strDA_AREA		= strTrim($strDA_AREA,10);
	$strDA_WEIGHT	= strTrim($strDA_WEIGHT,50);
	$strDA_MTH		= strTrim($strDA_MTH,50);
	
	$eumMgr->setDA_NO($intDA_NO);
	$eumMgr->setDA_TYPE($strDA_TYPE);
	$eumMgr->setDA_NAME_KR($strDA_NAME_KR);
	$eumMgr->setDA_NAME_US($strDA_NAME_US);
	$eumMgr->setDA_NAME_CN($strDA_NAME_CN);
	$eumMgr->setDA_NAME_JP($strDA_NAME_JP);
	$eumMgr->setDA_NAME_ID($strDA_NAME_ID);
	$eumMgr->setDA_NAME_FR($strDA_NAME_FR);
	$eumMgr->setDA_AREA($strDA_AREA);
	$eumMgr->setDA_WEIGHT($strDA_WEIGHT);
	$eumMgr->setDA_MTH($strDA_MTH);
	$eumMgr->setDA_PRICE($intDA_PRICE);
	$eumMgr->setDA_REG_NO($a_admin_no);
	$eumMgr->setDA_MOD_NO($a_admin_no);

	$strLinkPage  = "searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchDeliveryMth=$strSearchDeliveryMth&searchCountryZone=$strSearchCountryZone";
	$strLinkPage .= "&pageLine=$intPageLine&page=$intPage";


	switch ($strAct) {
		case "deliveryWrite":
			
			$eumMgr->getDeliveryInsert($db);

			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=deliveryList&".$strLinkPage;

		break;

		case "deliveryModify":

			$strDA_TYPE		= "W";
			$strDA_AREA		= $_POST["deliveryZone_".$intDA_NO];
			$strDA_WEIGHT	= $_POST["deliveryWeight_".$intDA_NO];
			$strDA_MTH		= $_POST["deliveryMth_".$intDA_NO];
			$intDA_PRICE	= $_POST["deliveryPrice_".$intDA_NO];

			$eumMgr->setDA_TYPE($strDA_TYPE);
			$eumMgr->setDA_NAME_KR($strDA_NAME_KR);
			$eumMgr->setDA_NAME_US($strDA_NAME_US);
			$eumMgr->setDA_NAME_CN($strDA_NAME_CN);
			$eumMgr->setDA_NAME_JP($strDA_NAME_JP);
			$eumMgr->setDA_NAME_ID($strDA_NAME_ID);
			$eumMgr->setDA_NAME_FR($strDA_NAME_FR);
			$eumMgr->setDA_AREA($strDA_AREA);
			$eumMgr->setDA_WEIGHT($strDA_WEIGHT);
			$eumMgr->setDA_MTH($strDA_MTH);
			$eumMgr->setDA_PRICE($intDA_PRICE);

			$eumMgr->getDeliveryUpdate($db);

			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=deliveryList&".$strLinkPage;

		break;

		case "deliveryDelete":

			$eumMgr->getDeliveryDelete($db);

			$strMsg = "";
			$strUrl = "./?menuType=eumAdm&mode=deliveryList&".$strLinkPage;

		break;
	}
?>