<?

	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Main.php";
			exit;
		}
		
		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Main.php";
			exit;
		}
	}
	/*##################################### Act Page 이동 #####################################*/

	/*-- *********** Header Area *********** --*/
	 
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 
	 
	include WEB_FRWORK_HELP."main.php";
	 
	/*-- *********** Header Area *********** --*/

	include "../layout/html/main_html.inc.php";
	
?>


