<?
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || $strMode == "userJson" || $strMode == "pg" || SUBSTR($strMode,0,3) == "pop"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Mypage.php";
			exit;
		}

		if ($strMode == "userJson"){
			include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/html/json/mypage.php";
			exit;
		}

		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Mypage.php";
			exit;
		}

		if (SUBSTR($strMode,0,3) == "pop") {
			include "{$strIncludePath}mypage_{$strMode}.php";
			exit;
		}

	}
	/*##################################### Act Page 이동 #####################################*/

	
	/*-- *********** Header Area *********** --*/
	
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 

	include WEB_FRWORK_HELP."mypage.php";
	
	include "../layout/html/mypage_html.inc.php";	
?>

