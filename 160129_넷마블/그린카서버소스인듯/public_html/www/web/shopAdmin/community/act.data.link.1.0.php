<?
	/* 메시지 정의 */
	$STR_MSG['dataWrite']				= "등록되었습니다.";
	$STR_MSG['dataAnswer']				= "등록되었습니다.";
	$STR_MSG['dataWPointGive']			= "발급되었습니다.";
	$STR_MSG['dataWCouponGive']			= "발급되었습니다.";
	$STR_MSG['dataModify']				= "수정되었습니다.";
	$STR_MSG['dataDelete']				= "삭제되었습니다.";
	$STR_MSG['dataDeleteMulti']			= "삭제되었습니다.";
	$STR_MSG['dataTransfer']			= "이동되었습니다.";
	$STR_MSG['noData']					= "내용이 없습니다.";
	$STR_MSG['diffShopNo']				= "권한이 없습니다..";
	$STR_MSG['diffMember']				= "권한이 없습니다.";

	/* 링크 정의 */
	$strCommonLink						= "&page=$intPage";
	$STR_URL['dataWrite']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['dataAnswer']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['dataModify']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['dataWPointGive']			= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['dataWCouponGive']			= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&ub_no={$_POST['ub_no']}&$strCommonLink";
	$STR_URL['dataDelete']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['dataDeleteMulti']			= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['dataTransfer']			= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['noData']					= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['diffShopNo']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
	$STR_URL['diffMember']				= "./?menuType={$strMenuType}&mode=dataList&b_code={$_POST['b_code']}&$strCommonLink";
?>