<?
	/* 메시지 정의 */
	$STR_MSG['dataWrite']				= $LNG_TRANS_CHAR["BS00001"]; // 등록되었습니다.
	$STR_MSG['dataAnswer']				= $LNG_TRANS_CHAR["BS00001"]; // 등록되었습니다.
	$STR_MSG['dataModify']				= $LNG_TRANS_CHAR["BS00002"]; // 수정되었습니다.
	$STR_MSG['dataModifyX']				= $LNG_TRANS_CHAR["BS00003"]; // 수정권한이 없습니다.
	$STR_MSG['dataDelete']				= $LNG_TRANS_CHAR["BS00002"]; // 수정되었습니다.
	$STR_MSG['dataMPassword']			= $LNG_TRANS_CHAR["BS00004"]; // 수정가능합니다.
	$STR_MSG['dataDPassword']			= $LNG_TRANS_CHAR["BS00002"]; // 수정되었습니다.
	/* 링크 정의 */
	$strCommonLink						= "&bodyClass={$_POST['bodyClass']}&ub_p_code={$_POST['ub_p_code']}&myTarget={$_POST['myTarget']}&page=$intPage";
	$STR_URL['dataWrite']				= "./?menuType={$strMenuType}&mode={$_POST['BOARD_INFO']['bi_datawrite_end_move']}&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['dataAnswer']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['dataModify']				= "./?menuType={$strMenuType}&mode={$_POST['BOARD_INFO']['bi_datawrite_end_move']}&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['dataModifyX']				= "./?menuType={$strMenuType}&mode={$_POST['BOARD_INFO']['bi_datawrite_end_move']}&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['dataDelete']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['dataMPassword']			= "./?menuType={$strMenuType}&mode=dataModify&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['dataDPassword']			= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";

	if($_POST['menuType'] == "minishop"):
	$STR_URL['dataModify']				= "./?menuType={$strMenuType}&mode=sellerProdReviewView&sh_no={$_POST['sh_no']}&ub_no={$_POST['ub_no']}";
	$STR_URL['dataDelete']				= "./?menuType={$strMenuType}&mode=sellerProdReviewList&sh_no={$_POST['sh_no']}&ub_no={$_POST['ub_no']}";
	endif;

?>