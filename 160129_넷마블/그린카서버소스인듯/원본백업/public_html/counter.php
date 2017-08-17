<?
	require_once "./config.inc.php";	
	require_once "./conf/shop.inc.php";
	
	require_once MALL_CONF_MYSQL;

	$db->connect();
	
	include WEB_FRWORK_ACT."Counter.php";
	
	$db->disConnect();
?>