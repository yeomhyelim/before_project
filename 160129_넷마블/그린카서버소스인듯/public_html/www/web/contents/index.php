<?
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/
	$strMyTarget				= $_GET['myTarget'];

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Contents.php";
			exit;
		}

		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Contents.php";
			exit;
		}
	}
	/*##################################### Act Page 이동 #####################################*/

	

	if($strMyTarget == "pop") {
		$strID = $_GET['id'];
		include sprintf("%s%s/layout/contents/%s/contents_%s.html.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, $strID); 
		exit;
	}


	/*-- *********** Header Area *********** --*/
	
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 

	include WEB_FRWORK_HELP."contents.php";


	/*-- *********** Header Area *********** --*/

	include "../layout/html/sub_html.inc.php";	
	
?>

