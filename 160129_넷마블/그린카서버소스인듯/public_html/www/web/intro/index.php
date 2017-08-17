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
	 
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 

	include WEB_FRWORK_HELP."intro.php";
	 
	/*-- *********** Header Area *********** --*/

//	include "../layout/html/main_html.inc.php";

	include MALL_WEB_PATH."intro/intro.php";

?>


