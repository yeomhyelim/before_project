<?
	## STEP 1.
	## 커뮤니티 버튼 보안 설정
	include "{$S_DOCUMENT_ROOT}www/web/shopAdmin/basic/communityMakeFile.php";


	$_POST['S_MEMBER_GROUP']			= $S_MEMBER_GROUP;

	$STR_MSG['boardWrite']				= "등록되었습니다.";
	$STR_MSG['boardWriteAlready']		= "사용중인게시판입니다.";
	$STR_MSG['boardModifyBasic']		= "수정되었습니다.";
	$STR_MSG['boardModifyScript']		= "수정되었습니다.";
	$STR_MSG['boardModifyCategory']		= "수정되었습니다.";
	$STR_MSG['boardModifyPoint']		= "수정되었습니다.";
	$STR_MSG['boardModifyList']			= "수정되었습니다.";
	$STR_MSG['boardModifyView']			= "수정되었습니다.";
	$STR_MSG['boardModifyWrite']		= "수정되었습니다.";
	$STR_MSG['boardModifyDelete']		= "수정되었습니다.";
	$STR_MSG['boardModifyComment']		= "수정되었습니다.";
	$STR_MSG['boardModifyUserfield']	= "수정되었습니다.";
	$STR_MSG['boardModifyAttachedfile']	= "수정되었습니다.";
	$STR_MSG['boardModifyScriptWidget']	= "수정되었습니다.";
	
	$STR_MSG['boardStop']				= "커뮤니티 상태를 정지로 변경하였습니다.";
	$STR_MSG['boardUse']				= "커뮤니티 상태를 사용으로 변경하였습니다.";
	$STR_MSG['boardDrop']				= "삭제되었습니다.";
	$STR_MSG['boardDropCount']			= "1개 이상의 데이터가 존재합니다. 모든 데이터를 삭제 후, 게시판을 삭제할 수 있습니다.";


	$strCommonLink						= "&lang={$_POST['lang']}&page=$intPage";

	$STR_URL['boardWrite']				= "./?menuType={$strMenuType}&mode=boardList&b_code=&$strCommonLink";
	$STR_URL['boardWriteAlready']		= "./?menuType={$strMenuType}&mode=boardList&b_code=&$strCommonLink";
	$STR_URL['boardModifyBasic']		= "./?menuType={$strMenuType}&mode=boardModifyBasic&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyScript']		= "./?menuType={$strMenuType}&mode=boardModifyScript&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyCategory']		= "./?menuType={$strMenuType}&mode=boardModifyCategory&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyPoint']		= "./?menuType={$strMenuType}&mode=boardModifyPoint&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyList']			= "./?menuType={$strMenuType}&mode=boardModifyList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyView']			= "./?menuType={$strMenuType}&mode=boardModifyView&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyWrite']		= "./?menuType={$strMenuType}&mode=boardModifyWrite&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyDelete']		= "./?menuType={$strMenuType}&mode=boardModifyDelete&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyComment']		= "./?menuType={$strMenuType}&mode=boardModifyComment&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyUserfield']	= "./?menuType={$strMenuType}&mode=boardModifyUserfield&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardModifyAttachedfile'] = "./?menuType={$strMenuType}&mode=boardModifyAttachedfile&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardStop']				= "./?menuType={$strMenuType}&mode=boardList&b_code=&b_use=$strCommonLink";
	$STR_URL['boardUse']				= "./?menuType={$strMenuType}&mode=boardList&b_code=&b_use=N&$strCommonLink";
	$STR_URL['boardModifyScriptWidget']	= "./?menuType={$strMenuType}&mode=boardModifyScriptWidget&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['boardDrop']				= "./?menuType={$strMenuType}&mode=boardNonList&b_code=&$strCommonLink&b_use=N&$strCommonLink";
	$STR_URL['boardDropCount']			= "./?menuType={$strMenuType}&mode=boardNonList&b_code=&$strCommonLink&b_use=N&$strCommonLink";
?>