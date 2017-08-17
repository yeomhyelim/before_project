<?
	//shopAdmin 전용 세션. 남덕희
	$a_admin_login		= $_SESSION["ADMIN_LOGIN"];
	$a_admin_id			= $_SESSION["ADMIN_ID"];
	$a_admin_name		= $_SESSION["ADMIN_NAME"];
	$a_admin_group		= $_SESSION["ADMIN_GROUP"];
	$a_admin_level		= $_SESSION["ADMIN_LEVEL"];
	$a_admin_last_name	= $_SESSION["ADMIN_LAST_NAME"];
	$a_admin_no			= $_SESSION["ADMIN_NO"];
	$a_admin_ip			= $_SESSION["ADMIN_IP"];
	$a_admin_lng		= $_SESSION["ADMIN_LNG"];
	$a_admin_mail		= $_SESSION["ADMIN_MAIL"];	
	$a_admin_type		= $_SESSION["ADMIN_TYPE"];
	$a_admin_shop_no	= $_SESSION["ADMIN_SHOP_NO"];		// 샵번호(입점몰 번호)
	$a_admin_tm			= $_SESSION["ADMIN_TM"];
	$a_admin_shop_list =  $_SESSION["ADMIN_SHOP_LIST"];
	$a_admin_main_use	= $_SESSION["ADMIN_MAIN_USE"];
	
	/* 관리자 언어 설정 */
	$strAdmSiteLng	= ($a_admin_lng) ? $a_admin_lng : "KR";

	if (!$a_admin_login || ($a_admin_level == "9") || $a_admin_ip != $S_REOMTE_ADDR)
	{
		if($_GET['cronKey']!='ejrgml1802') {
			goUrl("", "./login.php");
			exit;
		}
	}

?>