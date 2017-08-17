<?

	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Shop.php";
			exit;
		}
		
		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Shop.php";
			exit;
		}

	}
	/*##################################### Act Page 이동 #####################################*/

	## 스크립트 리스트 설정
	$aryScript				= "";
	$aryScript[]			= "/common/js/common2.js";
	
	/*-- *********** Header Area *********** --*/	
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 

	include WEB_FRWORK_HELP."shop.php";

	include "../layout/html/shop_html.inc.php";	
	


?>

