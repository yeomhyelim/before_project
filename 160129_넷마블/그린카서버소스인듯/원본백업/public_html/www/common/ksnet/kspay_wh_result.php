<? 
 	require_once $_SERVER["DOCUMENT_ROOT"]."/config.inc.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/conf/shop.inc.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/conf/layout.inc.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/conf/site.cur.inc.php";
	
	require_once MALL_CONF_LANG_KR;

	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;
	require_once MALL_CONF_SESS;
	require_once MALL_CONF_COOKIE;
	
	$strMode	= "pg";
	$strAct		= "pg";

	$db->connect();
   
   if (function_exists("mb_http_input")) mb_http_input("utf-8"); 
   if (function_exists("mb_http_output")) mb_http_output("utf-8");

	include WEB_FRWORK_ACT."OrderPgPay.php";

	$db->disConnect();

	exit;  
   
   
?>
