<?
	## STEP 2-1.
	## WWW 의 BOARD 관련 CONF 정보(COMMON, DEFAULT CONFIG 설정)
	include MALL_HOME . "/config/board.conf.inc.php";

	## STEP 2-2.
	## SHOP 의 BOARD 관련 CONF 정보 호출(USER CONFIG 설정)
	include $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/conf/board.conf.inc.php";

	$I_SKIN_HOME			= $SKIN_HOME[$I_MODE];
	$I_SKIN_DEFAULT_ROOT	= $SKIN_DEFAULT_ROOT[$I_MODE];

	## STEP 6.
	## includeFile 설정
	$includeFile = "layout/{$I_MODE}/basic.2.0/{$strMode}.layout.php";


?>

