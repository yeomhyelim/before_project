<?


	## STEP 1.
	## includeFile 설정
	$aryIncludeFile['basic']			= "{$S_DOCUMENT_ROOT}www/web/community/layout/{$_REQUEST['BOARD_INFO']['b_kind']}/{$_REQUEST['BOARD_INFO']['b_skin']}.1.0/{$_REQUEST['mode']}.layout.php";
	$aryIncludeFile['password']			= "{$S_DOCUMENT_ROOT}www/web/community/layout/{$_REQUEST['BOARD_INFO']['b_kind']}/{$_REQUEST['BOARD_INFO']['b_skin']}.1.0/dataPassword.layout.php";
	$aryIncludeFile['lock']				= "{$S_DOCUMENT_ROOT}www/web/community/layout/{$_REQUEST['BOARD_INFO']['b_kind']}/{$_REQUEST['BOARD_INFO']['b_skin']}.1.0/lock.layout.php";


	/* 메시지 정의 */
	$STR_MSG['dataModify']				= "잘못된 경로로 접속되었습니다.";
	$STR_MSG['dataModifyX']				= "수정권한이 없습니다.";
//	$STR_MSG['dataDeleteX']				= "삭제할수 없습니다.";

	/* 링크 정의 */
	$strCommonLink						= "&page=$intPage";
	$STR_URL['dataModify']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_REQUEST['b_code']}&$strCommonLink";
	$STR_URL['dataModifyX']				= "./?menuType={$strMenuType}&mode=dataView&b_code={$_REQUEST['b_code']}&ub_no={$_REQUEST['ub_no']}&$strCommonLink";
//	$STR_URL['dataDeleteX']				= "./?menuType={$strMenuType}&mode=dataView&b_code={$_REQUEST['b_code']}&ub_no={$_REQUEST['ub_no']}&$strCommonLink";


?>