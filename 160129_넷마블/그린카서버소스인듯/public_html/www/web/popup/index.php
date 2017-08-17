<?
require_once MALL_CONF_LIB."ProductMgr.php";
$productMgr = new ProductMgr();

/*##################################### Parameter 셋팅 #####################################*/
$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];


$intNo			= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
$strGubun		= $_POST["gb"]				? $_POST["gb"]				: $_REQUEST["gb"];

/*##################################### Parameter 셋팅 #####################################*/

/*##################################### Act Page 이동 #####################################*/
if ($strMode == "act" || $strMode == "json"){
	if ($strMode == "act"){
		include WEB_FRWORK_ACT."Popup.php";
		exit;
	}

	if ($strMode == "json"){
		include WEB_FRWORK_JSON."Popup.php";
		exit;
	}

}

if ($strMode == "prodFileDown"){
	include "prodFileDown.php";
	exit;
}
/*##################################### Act Page 이동 #####################################*/


/*-- *********** Header Area *********** --*/

include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT);

include WEB_FRWORK_HELP."popup.php";

/*-- *********** Header Area *********** --*/

//	include "./layout/html/config.inc.php";
//	include "./layout/html/sub_html.inc.php";

?>

<!-- *********** Content Wrap ************  -->
<? include sprintf ( "%s%s/layout/html/sub_body.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
<!-- *********** Content Wrap ************  -->
