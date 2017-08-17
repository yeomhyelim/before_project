
<?
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || $strMode == "open"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Product.php";
			exit;
		}
		
		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Product.php";
			exit;
		}

		if ($strMode == "open") {
			include "include/{$strOpenUrl}.OpenWindow.index.inc.php";
			exit;
		}
	}

	/*##################################### Act Page 이동 #####################################*/

	
	/*-- *********** Header Area *********** --*/
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 
	/*-- *********** Header Area *********** --*/

	include WEB_FRWORK_HELP."product.php";

	if($strMode == "view") :
		include "../layout/html/productView_html.inc.php";
	elseif($strMode == "brandMain" || $strMode == "brandList") :
		include "../layout/html/brand_html.inc.php";
	else :
		include "../layout/html/productList_html.inc.php";
	endif;
	

?>

