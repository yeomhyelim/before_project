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

	/**
	 * 공통 파라미터 설정
	 */
	$strMenuType	= $_POST["menuType"]	? $_POST["menuType"]	: $_REQUEST["menuType"];
	$strMode		= $_POST["mode"]		? $_POST["mode"]		: $_REQUEST["mode"];
	$strAct			= $_POST["act"]			? $_POST["act"]			: $_REQUEST["act"];
	$strLang		= $_POST["lang"]		? $_POST["lang"]		: $_REQUEST["lang"];

	/**
	 * 언어 설정
	 */
	if($strLang) { setcookie('ck_lang', $strLang); }
	else if($_COOKIE['ck_lang']) { $strLang = $_COOKIE['ck_lang']; }

	/**
	 * 공통 파라미터 체크
	 */
	if(!$strDevice)		{ $strDevice		= "mobile";		}
	if(!$strMenuType)	{ $strMenuType		= "main";		}
	if(!$strMode)		{ $strMode			= "index";		}
	if(!$strLang)		{ $strLang			= $S_ST_LNG;	}

	/**
	 * 언어설정
	 */
	$S_JS_LNG = "";
	$S_SITE_LNG = strtoupper($strLang);
	$S_SITE_LNG_PATH = strtolower($strLang);
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
	require_once MALL_SHOP . "/conf/shop.manual.inc.php";

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
	$strConfigFile = MALL_SHOP . "/{$strDevice}/layout/html-c/{lang}/{$strMenuType}/config-{$strMode}.php";
	$strConfigFile = getFileLang($strConfigFile);
	if($strConfigFile) { include_once $strConfigFile; }
	if(!$layout) { $layout = "layout/layout-default.php"; }

	/**
	 * 레이아웃 설정
	 */
	$strLayoutFile = MALL_SHOP . "/{$strDevice}/layout/html-c/{lang}/{$layout}";
	$strLayoutFile = getFileLang($strLayoutFile);
	if($strLayoutFile) { include_once $strLayoutFile; }
