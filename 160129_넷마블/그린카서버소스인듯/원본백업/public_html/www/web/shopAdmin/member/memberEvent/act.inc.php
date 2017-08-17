<?
	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$cateMgr = new CateMgr();	

	require_once "basic.param.inc.php";
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strBIRTH_POINT			= $_POST["birth_point"]		? $_POST["birth_point"]				: $_REQUEST["birth_point"];
	$strBIRTH_SMS			= $_POST["birth_sms"]		? $_POST["birth_sms"]				: $_REQUEST["birth_sms"];
	$strBIRTH_SEND_DAY		= $_POST["birth_send"]		? $_POST["birth_send"]				: $_REQUEST["birth_send"];

	$strWED_POINT			= $_POST["wed_point"]		? $_POST["wed_point"]				: $_REQUEST["wed_point"];
	$strWED_SMS				= $_POST["wed_sms"]			? $_POST["wed_sms"]					: $_REQUEST["wed_sms"];
	$strWED_SEND_DAY		= $_POST["wed_send"]		? $_POST["wed_send"]				: $_REQUEST["wed_send"];
	/*##################################### Parameter 셋팅 #####################################*/


			
	switch ($strAct) {

		case "memberEvent":
			/* 회원 생일/기념일관리 */			

			$aryData[0]["column"]	= "S_SITE_BIRTH_SEND_POINT";
			$aryData[0]["value"]	= $strBIRTH_POINT;

			$aryData[1]["column"]	= "S_SITE_BIRTH_SEND_SMS";
			$aryData[1]["value"]	= $strBIRTH_SMS;

			$aryData[2]["column"]	= "S_SITE_BIRTH_SEND_DAY";
			$aryData[2]["value"]	= $strBIRTH_SEND_DAY;

			$aryData[3]["column"]	= "S_SITE_WED_SEND_POINT";
			$aryData[3]["value"]	= $strWED_POINT;
			
			$aryData[4]["column"]	= "S_SITE_WED_SEND_SMS";
			$aryData[4]["value"]	= $strWED_SMS;
			
			$aryData[5]["column"]	= "S_SITE_WED_SEND_DAY";
			$aryData[5]["value"]	= $strWED_SEND_DAY;
			
			shopInfoInsertUpdate($siteMgr,$aryData,"N");						
			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";

			$strUrl = "./?menuType=".$strMenuType."&mode=memberEvent";
		break;
	}

?>