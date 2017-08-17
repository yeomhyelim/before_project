<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."SmsMgr.php";
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."PostSmsMgr.php";
	require_once MALL_CONF_LIB."PostSmsLogMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_SMS;
	require_once MALL_CONF_LIB."EmTranMgr.eum.php";

	$boardMgr				= new BoardMgr();
	$smsMgr					= new SmsMgr();
	$siteMgr				= new SiteMgr();		
	$postSmsMgr				= new PostSmsMgr();
	$postSmsLogMgr			= new PostSmsLogMgr();
	$memberMgr				= new MemberMgr();
	$emTranMgr				= new EmTranMgr();


	// 공통
	$strSearchField			= $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$arySelfCheck			= $_POST['selfCheck']		? $_POST['selfCheck']		: $_REQUEST['selfCheck'];	// 선택된 글 리스트 

	// SMS_MGR
	$intS_NO				= $_POST["s_no"]			? $_POST["s_no"]			: $_REQUEST["s_no"];
	$arrSM_NO				= $_POST["sm_no"]			? $_POST["sm_no"]			: $_REQUEST["sm_no"];
	$arrSM_TEXT				= $_POST["sm_text"]			? $_POST["sm_text"]			: $_REQUEST["sm_text"];
	$arrSM_AUTO				= $_POST["sm_auto"]			? $_POST["sm_auto"]			: $_REQUEST["sm_auto"];
	$strS_SMS_USE			= $_POST["s_smsUse"]		? $_POST["s_smsUse"]		: $_REQUEST["s_smsUse"];

	// POST_SMS
	$intPS_NO				= $_POST["ps_no"]			? $_POST["ps_no"]			: $_REQUEST["ps_no"];
	$strPS_TEXT				= $_POST["ps_text"]			? $_POST["ps_text"]			: $_REQUEST["ps_text"];
	$intPS_TOTAL_CNT		= $_POST["ps_total_cnt"]	? $_POST["ps_total_cnt"]	: $_REQUEST["ps_total_cnt"];
	$intPS_REG_DT			= $_POST["ps_reg_dt"]		? $_POST["ps_reg_dt"]		: $_REQUEST["ps_reg_dt"];
	$intPS_REG_NO			= $_POST["ps_reg_no"]		? $_POST["ps_reg_no"]		: $_REQUEST["ps_reg_no"];
	$intPS_MOD_DT			= $_POST["ps_mod_dt"]		? $_POST["ps_mod_dt"]		: $_REQUEST["ps_mod_dt"];
	$intPS_MOD_NO			= $_POST["ps_mod_no"]		? $_POST["ps_mod_no"]		: $_REQUEST["ps_mod_no"];
	$strSendType			= $_POST['sendType']		? $_POST['sendType']		: $_REQUEST['sendType'];	// 선택된 회원에게 문자을 보냅니다. : A, 	검색된 회원에게 문자을 보냅니다. : B
 
	// 문자발송
	$setSEND_NAME			= $_POST["send_name"]		? $_POST["send_name"]		: $_REQUEST["send_name"];
	$setSEND_HP				= $_POST["send_hp"]			? $_POST["send_hp"]			: $_REQUEST["send_hp"];
	$setSEND_NO				= $_POST["send_no"]			? $_POST["send_no"]			: $_REQUEST["send_no"];
	$setRECEIVE_NAME		= $_POST["receive_name"]	? $_POST["receive_name"]	: $_REQUEST["receive_name"];
	$setRECEIVE_HP			= $_POST["receive_hp"]		? $_POST["receive_hp"]		: $_REQUEST["receive_hp"];
	$setRECEIVE_NO			= $_POST["receive_no"]		? $_POST["receive_no"]		: $_REQUEST["receive_no"];

	// 회원관리(MEMBER_MGR)
	$intM_NO				= $_POST["memberNo"]		? $_POST["memberNo"]		: $_REQUEST["memberNo"];

	// SMS_MGR
	$strS_SMS_USE			= strTrim($strS_SMS_USE,1);
//	$strSM_GRP_CODE			= strTrim($strSM_GRP_CODE,10);
//	$strSM_SEND_CODE		= strTrim($strSM_SEND_CODE,10);
//	$strSM_TEXT				= strTrim($strSM_TEXT,65535);
//	$strSM_AUTO				= strTrim($strSM_AUTO,1);

	// POST_SMS
	$strPS_TEXT = strTrim($strPS_TEXT,65535);

	// SMS_MGR
	$siteMgr->setS_SMS_USE($strS_SMS_USE);
	/* no use, 배열로 정보를 받음
	$smsMgr->setSM_NO($intSM_NO);
	$smsMgr->setSM_GRP_CODE($strSM_GRP_CODE);
	$smsMgr->setSM_SEND_CODE($strSM_SEND_CODE);
	$smsMgr->setSM_TEXT($strSM_TEXT);
	$smsMgr->setSM_AUTO($strSM_AUTO);
	$smsMgr->setSM_REG_DT($intSM_REG_DT);
	$smsMgr->setSM_REG_NO($intSM_REG_NO);
	$smsMgr->setSM_MOD_DT($intSM_MOD_DT);
	$smsMgr->setSM_MOD_NO($intSM_MOD_NO);
	*/

	// POST_SMS
	$postSmsMgr->setPS_NO($intPS_NO);
	$postSmsMgr->setPS_TEXT($strPS_TEXT);
	$postSmsMgr->setPS_TOTAL_CNT($intPS_TOTAL_CNT);
	$postSmsMgr->setPS_REG_DT($intPS_REG_DT);
	$postSmsMgr->setPS_REG_NO($intPS_REG_NO);
	$postSmsMgr->setPS_MOD_DT($intPS_MOD_DT);
	$postSmsMgr->setPS_MOD_NO($intPS_MOD_NO);
?>