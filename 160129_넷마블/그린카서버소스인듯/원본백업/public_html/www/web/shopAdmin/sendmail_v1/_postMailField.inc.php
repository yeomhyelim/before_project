<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."EmailMgr.php";
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."PostMailMgr.php";
	require_once MALL_CONF_LIB."PostMailLogMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	
	$boardMgr		= new BoardMgr();
	$emailMgr		= new EmailMgr();
	$siteMgr		= new SiteMgr();
	$postMailMgr	= new PostMailMgr();
	$postMailLogMgr	= new PostMailLogMgr();
	$memberMgr		= new MemberMgr();

	// 공통
	$strSearchField			= $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$strMailLng				= $_POST["mailLng"]			? $_POST["mailLng"]			: $_REQUEST["mailLng"];
	$arySelfCheck			= $_POST['selfCheck']		? $_POST['selfCheck']		: $_REQUEST['selfCheck'];	// 선택된 글 리스트 

	// sendMail
	$intS_NO				= $_POST["s_no"]			? $_POST["s_no"]			: $_REQUEST["s_no"];
	$intEM_NO				= $_POST["em_no"]			? $_POST["em_no"]			: $_REQUEST["em_no"];
	$strEM_AUTO				= $_POST["em_auto"]			? $_POST["em_auto"]			: $_REQUEST["em_auto"];
	$strEM_TITLE			= $_POST["em_title"]		? $_POST["em_title"]		: $_REQUEST["em_title"];
	$strEM_TEXT				= $_POST["em_text"]			? $_POST["em_text"]			: $_REQUEST["em_text"];
	$strEM_SENDER			= $_POST["em_sender"]		? $_POST["em_sender"]		: $_REQUEST["em_sender"];
	$strS_EMAIL_USE			= $_POST["s_emailUse"]		? $_POST["s_emailUse"]		: $_REQUEST["s_emailUse"];
	$strEM_SEND_CODE		= $_POST["em_send_code"]	? $_POST["em_send_code"]	: $_REQUEST["em_send_code"];

	// postMail
	$intPM_NO				= $_POST["pm_no"]			? $_POST["pm_no"]			: $_REQUEST["pm_no"];
	$strPM_TITLE			= $_POST["pm_title"]		? $_POST["pm_title"]		: $_REQUEST["pm_title"];
	$strPM_TEXT				= $_POST["pm_text"]			? $_POST["pm_text"]			: $_REQUEST["pm_text"];
	$intPM_TOTAL_CNT		= $_POST["pm_total_cnt"]	? $_POST["pm_total_cnt"]	: $_REQUEST["pm_total_cnt"];
	$intPM_REG_DT			= $_POST["pm_reg_dt"]		? $_POST["pm_reg_dt"]		: $_REQUEST["pm_reg_dt"];
	$intPM_REG_NO			= $_POST["pm_reg_no"]		? $_POST["pm_reg_no"]		: $_REQUEST["pm_reg_no"];
	$intPM_MOD_DT			= $_POST["pm_mod_dt"]		? $_POST["pm_mod_dt"]		: $_REQUEST["pm_mod_dt"];
	$intPM_MOD_NO			= $_POST["pm_mod_no"]		? $_POST["pm_mod_no"]		: $_REQUEST["pm_mod_no"];
	$strSendType			= $_POST['sendType']		? $_POST['sendType']		: $_REQUEST['sendType'];	// 선택된 회원에게 메일을 보냅니다. : A, 	검색된 회원에게 메일을 보냅니다. : B

	// 테스트 메일
	$setSEND_NAME			= $_POST["send_name"]		? $_POST["send_name"]		: $_REQUEST["send_name"];
	$setSEND_EMAIL			= $_POST["send_email"]		? $_POST["send_email"]		: $_REQUEST["send_email"];
	$setRECEIVE_NAME		= $_POST["receive_name"]	? $_POST["receive_name"]	: $_REQUEST["receive_name"];
	$setRECEIVE_MAIL		= $_POST["receive_mail"]	? $_POST["receive_mail"]	: $_REQUEST["receive_mail"];

	// 회원관리(MEMBER_MGR)
	$intM_NO				= $_POST["memberNo"]		? $_POST["memberNo"]		: $_REQUEST["memberNo"];


	$strS_EMAIL_USE			= strTrim($strS_EMAIL_USE,1);
	$strPM_TITLE			= strTrim($strPM_TITLE,500);
	$strPM_TEXT				= strTrim($strPM_TEXT,65535);

	/* 각 그룹 NO 값 가져오기 */
	$boardMgr->setCG_CODE("EMAIL");
	$arrGrpNo = $boardMgr->getCommGrpList($db);

	$boardMgr->setCG_CODE("EMAIL_SEND");
	$arrSendNo = $boardMgr->getCommGrpList($db);
	/* 각 그룹 NO 값 가져오기 */

	$emailMgr->setCG_NO_GRP($arrGrpNo[0][CG_NO]);
	$emailMgr->setCG_NO_SEND($arrSendNo[0][CG_NO]);

	$emailMgr->setEM_NO($intEM_NO);
	$emailMgr->setEM_AUTO($strEM_AUTO);
	$emailMgr->setEM_TITLE($strEM_TITLE);
	$emailMgr->setEM_TEXT($strEM_TEXT);
	$emailMgr->setEM_SENDER($strEM_SENDER);

	$siteMgr->setS_EMAIL_USE($strS_EMAIL_USE);

	// postMail
	$postMailMgr->setPM_NO($intPM_NO);
	$postMailMgr->setPM_TITLE($strPM_TITLE);
	$postMailMgr->setPM_TEXT($strPM_TEXT);
	$postMailMgr->setPM_TOTAL_CNT($intPM_TOTAL_CNT);
	$postMailMgr->setPM_REG_DT($intPM_REG_DT);
	$postMailMgr->setPM_REG_NO($intPM_REG_NO);
	$postMailMgr->setPM_MOD_DT($intPM_MOD_DT);
	$postMailMgr->setPM_MOD_NO($intPM_MOD_NO);

	/* 회원 검색 */
	$strSearchRegStartDt		= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt			= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchLastLoginStartDt	= $_POST["searchLastLoginStartDt"]		? $_POST["searchLastLoginStartDt"]		: $_REQUEST["searchLastLoginStartDt"];
	$strSearchLastLoginEndDt	= $_POST["searchLastLoginEndDt"]		? $_POST["searchLastLoginEndDt"]		: $_REQUEST["searchLastLoginEndDt"];
	$strSearchVisitStartCnt		= $_POST["searchVisitStartCnt"]			? $_POST["searchVisitStartCnt"]			: $_REQUEST["searchVisitStartCnt"];
	$strSearchVisitEndCnt		= $_POST["searchVisitEndCnt"]			? $_POST["searchVisitEndCnt"]			: $_REQUEST["searchVisitEndCnt"];
	$strSearchSex				= $_POST["searchSex"]					? $_POST["searchSex"]					: $_REQUEST["searchSex"];
	$strSearchMailYN			= $_POST["searchMailYN"]				? $_POST["searchMailYN"]				: $_REQUEST["searchMailYN"];
	$strSearchSmsYN				= $_POST["searchSmsYN"]					? $_POST["searchSmsYN"]					: $_REQUEST["searchSmsYN"];
	$strSearchBirthMonth		= $_POST["searchBirthMonth"]			? $_POST["searchBirthMonth"]			: $_REQUEST["searchBirthMonth"];
	$strSearchBirthDay			= $_POST["searchBirthDay"]				? $_POST["searchBirthDay"]				: $_REQUEST["searchBirthDay"];
	$strSearchRecId				= $_POST["searchRecId"]					? $_POST["searchRecId"]					: $_REQUEST["searchRecId"];
	$arySearchGroup				= $_POST["searchGroup"]					? $_POST["searchGroup"]					: $_REQUEST["searchGroup"];

	/* 회원그룹 */
	$aryMemberGroup = $memberMgr->getGroupList($db);

	if (!$strSearchSex) $strSearchSex = "T";
	if (!$strSearchMailYN) $strSearchMailYN = "Y";
	if (!$strSearchSmsYN) $strSearchSmsYN = "T";
	if ($strSearchBirthMonth && $strSearchBirthDay) $strSearchBirth = $strSearchBirthMonth."-".$strSearchBirthDay;
	if (is_array($arySearchGroup)){
		$strSearchGroup = "";
		for($i=0;$i<sizeof($arySearchGroup);$i++){
			$strSearchGroup .= "'".$arySearchGroup[$i]."',";
		}

		if ($strSearchGroup) $strSearchGroup = SUBSTR($strSearchGroup,0,STRLEN($strSearchGroup)-1);		
	}

?>