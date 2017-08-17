<?
	require_once "../config.inc.php";	
	require_once "../conf/shop.inc.php";
	require_once "../conf/layout.inc.php";
	require_once "../conf/site.cur.inc.php";

	require_once "../conf/category.us.inc.php";
	require_once "../conf/site_skin.conf.inc.php";
	require_once "../conf/site_skin_main.conf.inc.php";
	require_once "../conf/site_skin_etc.conf.inc.php";
	require_once "../conf/shop.manual.inc.php";

	require_once MALL_CONF_LANG_US;
	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;
	require_once MALL_CONF_SESS;
	require_once MALL_CONF_COOKIE;
	
	$strMenuType	= $_POST["menuType"]	? $_POST["menuType"]	: $_REQUEST["menuType"];
	$strMode		= $_POST["mode"]		? $_POST["mode"]		: $_REQUEST["mode"];	
	$strAct			= $_POST["act"]			? $_POST["act"]		: $_REQUEST["act"];	
	$strOpenUrl		= $_POST["openUrl"]		? $_POST["openUrl"]		: $_REQUEST["openUrl"];	
	
	$strMenuType	= IM_IsBlank($strMenuType,"main");	
	$strMode		= IM_IsBlank($strMode,"list");	

	$db->connect();

	$strIncludePath		= sprintf ( "%swww/web/%s/", $S_DOCUMENT_ROOT, $strMenuType );

	include $strIncludePath."index.php";

	$db->disConnect();
?>