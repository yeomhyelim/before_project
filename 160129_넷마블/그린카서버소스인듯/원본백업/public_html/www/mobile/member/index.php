<?
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Member.php";
			exit;
		}

		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Member.php";
			exit;
		}
	}
	/*##################################### Act Page 이동 #####################################*/


	/*-- *********** Header Area *********** --*/

	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT);

	include WEB_FRWORK_HELP."member.php";

	/*-- *********** Header Area *********** --*/

	include (!$strPageTarget) ? "../layout/html/member_html.inc.php" : "../layout/member/member_html.{$strPageTarget}.inc.php";
?>

