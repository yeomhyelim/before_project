<?
	## STEP 1.
	## includeFile 설정
	$mode		= $_REQUEST['mode'];

	$includeFile = "layout/group/basic.1.0/{$mode}.layout.php";

	## STEP 2.
	## WWW 의 GROUOP 관련 CONF 정보(COMMON, DEFAULT CONFIG 설정)
	include MALL_HOME . "/config/community/group.conf.inc.php";

	## STEP 3.
	## SHOP 의 BOARD 관련 CONF 정보 호출(USER CONFIG 설정)
	include $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/conf/community/group.conf.inc.php";

?>

