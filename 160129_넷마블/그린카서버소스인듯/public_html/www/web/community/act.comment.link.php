<?
	/* 메시지 정의 */
	$STR_MSG['commentWrite']				= "등록되었습니다.";
	$STR_MSG['commentDelete']				= "삭제되었습니다.";

	/* 링크 정의 */
	$strCommonLink							= "&page=$intPage";
	$STR_URL['commentWrite']				= "./?menuType={$strMenuType}&mode=dataView&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['commentDelete']				= "./?menuType={$strMenuType}&mode=dataView&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";

?>