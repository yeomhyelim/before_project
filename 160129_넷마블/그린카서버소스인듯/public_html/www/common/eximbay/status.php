<?	
	require_once $_SERVER["DOCUMENT_ROOT"]."/config.inc.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/conf/shop.inc.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/conf/layout.inc.php";
	require_once $_SERVER["DOCUMENT_ROOT"]."/conf/site.cur.inc.php";
	
	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;
	require_once MALL_CONF_SESS;
	require_once MALL_CONF_COOKIE;
	
	$strMode	= "pg";
	$strAct		= "eximbayStatus";

	$db->connect();

	include WEB_FRWORK_ACT."OrderPgPay.php";
	$db->disConnect();

	exit;
?>