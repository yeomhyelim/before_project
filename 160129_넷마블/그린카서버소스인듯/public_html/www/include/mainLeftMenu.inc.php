

<?
	if($strMenuType == "order") : 
		// ORDER 페이지 인 경우 표시.
		include MALL_WEB_PATH."navi/sub_navi_A0001_mypage.inc.php";
	elseif($strMenuType == "member") : 
		// MEMBER 페이지 인 경우 표시.
		include MALL_WEB_PATH."navi/sub_navi_A0001_member.inc.php";
	endif;

	include MALL_WEB_PATH."navi/sub_navi_A0001_leftMenu.inc.php";

?>
