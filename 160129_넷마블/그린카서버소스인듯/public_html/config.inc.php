<?
	session_start();

	// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
	@header("Expires: 0"); 
	@header("Last-Modified: " . gmdate("D, d M Y H:i:s"));
	@header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	@header("Cache-Control: pre-check=0, post-check=0, max-age=0"); // HTTP/1.1
	@header("Pragma: no-cache"); // HTTP/1.0		

	@header ("P3P : CP=\"ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC\"");	
	@header("Content-Type: text/html; charset=UTF-8");

	if (!isset($set_time_limit)) $set_time_limit = 0;
	@set_time_limit($set_time_limit);

	// register_globals_on일때
	if (isset($HTTP_POST_VARS) && !isset($_POST)) {
		$_POST   = &$HTTP_POST_VARS;
		$_GET    = &$HTTP_GET_VARS;
		$_SERVER = &$HTTP_SERVER_VARS;
		$_COOKIE = &$HTTP_COOKIE_VARS;
		$_ENV    = &$HTTP_ENV_VARS;
		$_FILES  = &$HTTP_POST_FILES;

		if (!isset($_SESSION))
			$_SESSION = &$HTTP_SESSION_VARS;
	}

	// 환경 변수 설정
	$S_DOCUMENT_ROOT	= $_SERVER["DOCUMENT_ROOT"];		//사이트 서버 위치
	$S_REMOTE_ADDR		= $_SERVER["REMOTE_ADDR"];			//사이트 접속 사용자 IP
	$S_USER_AGENT		= $_SERVER["HTTP_USER_AGENT"];		//사이트 접속 사용자 환경
	$S_HTTP_REFERER		= $_SERVER["HTTP_REFERER"];			//현재 페이지로 오기전의 페이지 주소값
	$S_SERVER_NAME		= $_SERVER["SERVER_NAME"];			//사이트 도메인 => www.test.com (버추얼 호스트에 지정한 도메인)
	$S_HTTP_HOST		= $_SERVER["HTTP_HOST"];			//사이트 도메인 => www.test.com (접속할 때 사용한 도메인)
	$S_REQUEST_URI		= $_SERVER["REQUEST_URI"];			//현재페이지의 주소에서 도메인 제외 =>  /index.php?user=???&name=??? 
	$S_PHP_SELF			= $_SERVER["PHP_SELF"];				//현재페이지의 주소에서 도메인과 넘겨지는 값 제외 = /default/index.php 	
	$S_PHYSICAL_PATH	= $_SERVER["APPL_PHYSICAL_PATH"];	//현재페이지의 실제 파일 주소 => D:\webapp/ 
	$S_PAGE_NAME		= basename($S_PHP_SELF);
	$S_NOW_FILE			= $_SERVER["SCRIPT_FILENAME"];		//실행되고 있는 위치와 파일명

	$S_NOW_TIME_FORMAT1	= time();
	$S_NOW_TIME_FORMAT2	= date("Y-m-d H:i:s");

	$S_SHOP_ID			= "copy_shop";
	$S_SHOP_HOME		= "";

	$S_DOCUMENT_ROOT	= $S_DOCUMENT_ROOT."/";
	require_once $S_DOCUMENT_ROOT."www/mall.inc.php";	
		
	DEFINE("WEB_UPLOAD_PATH",$S_DOCUMENT_ROOT.$S_SHOP_HOME."/upload",true);	
	DEFINE("WEB_CONF_DB",$S_DOCUMENT_ROOT.$S_SHOP_HOME."/config/db.php",true);
	DEFINE("WEB_GROUP_PATH","../upload/data/group",true);
	DEFINE("WEB_LOG_PATH",$S_DOCUMENT_ROOT.$S_SHOP_HOME."/logs",true);
	DEFINE("WEB_CONF_DB_SMS",$S_DOCUMENT_ROOT.$S_SHOP_HOME."/config/db.sms.php",true);

	//DB 설정 파일 경로
	$DB_PATH		= WEB_CONF_DB;
	$DB_SMS_PATH	= WEB_CONF_DB_SMS;
?>