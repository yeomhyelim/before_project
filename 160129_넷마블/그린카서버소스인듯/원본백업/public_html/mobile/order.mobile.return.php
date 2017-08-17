<?php
	/**
	 *
	 * site index
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/mobile/index.php
	 * @manual		
	 * @history
	 *				2014.04.06 Kim Hee-Sung - 개발 완료
	 */

	require_once "../config.inc.php";	
	require_once "../conf/shop.inc.php";

	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;
	require_once MALL_CONF_SESS;
	require_once MALL_CONF_COOKIE;

	$db->connect();

	/**
	 * 공통 파라미터 설정
	 */
	$strMenuType	= $_POST["menuType"]	? $_POST["menuType"]	: $_REQUEST["menuType"];
	$strMode		= $_POST["mode"]		? $_POST["mode"]		: $_REQUEST["mode"];	
	$strAct			= $_POST["act"]			? $_POST["act"]			: $_REQUEST["act"];	
	$strLang		= $_POST["lang"]		? $_POST["lang"]		: $_REQUEST["lang"];

	/**
	 * 공통 파라미터 체크
	 */
	if(!$strDevice)		{ $strDevice		= "mobile";		}
	if(!$strMenuType)	{ $strMenuType		= "order";		}
	if(!$strMode)		{ $strMode			= "orderStep1";	}
	if(!$strLang)		{ $strLang			= strtolower($S_ST_LNG); }

	/**
	 * 언어설정
	 */
	$S_JS_LNG = "";
	$S_SITE_LNG = "KR";
	$S_SITE_LNG_PATH = strtolower($S_SITE_LNG);

	define("S_SITE_LNG", $S_SITE_LNG);
	define("S_ST_LNG", $S_ST_LNG);

	/**
	 * 언어팩 설정
	 */
	require_once MALL_HOME . "/lang/lang.{$S_SITE_LNG_PATH}.inc.php";
	require_once MALL_SHOP . "/conf/site.cur.inc.php";

	/**
	 * 설정파일
	 */
	require_once MALL_SHOP . "/conf/site_skin.conf.inc.php";

	/**
	 * 액션 모드 
	 */
	if(in_array($strMode, array("act", "json", "excel","pg","download"))) {
		include_once MALL_HOME . "/web/{$strMenuType}/index.php";
		$db->disConnect();
		exit;
	}

	/**
	 * app 설정
	 */
	$strConfigFile = MALL_SHOP . "/{$strDevice}/layout/html-c/{$strLang}/{$strMenuType}/config-{$strMode}.php";

	if(is_file($strConfigFile)) { include_once $strConfigFile; }
	if(!$layout) { $layout = "layout/layout-default.php"; }

	/**
	 * 레이아웃 설정
	 */
	$strLayoutFile = MALL_SHOP . "/{$strDevice}/layout/html-c/{$strLang}/{$layout}";
	if(is_file($strLayoutFile)) { include_once $strLayoutFile; }
