<?php
	/**
	 *
	 * common index
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/index.php
	 * @manual
	 * @history
	 *				2014.04.06 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * shop info
	 */
	require_once MALL_SHOP . "/conf/shop.inc.php";

	/**
	 * setting info
	 */
	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;
	require_once MALL_CONF_SESS;
	require_once MALL_CONF_COOKIE;

	/**
	 * database connect
	 */
	$db->connect();


	/**
	 * 요청 언어별 페이지 설정
	 */
	$strIncludePath = strtolower($S_ST_LNG);
	$strIncludePath = "/{$strIncludePath}";

	/**
	 * 웹/모바일 설정
	 */
	$strHttpHost = $_SERVER['HTTP_HOST'];
	$aryHttpHost = explode(".", $strHttpHost);
	$strHostType = "web";
	if($aryHttpHost[0] == "m") { $strHostType = "mobile"; }
	$mobilechk = '/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/i';
	if(preg_match($mobilechk, $_SERVER['HTTP_USER_AGENT'])) { $strHostType = "mobile"; }
	if($_SESSION['HOST_TYPE']) { $strHostType = $_SESSION['HOST_TYPE']; }
//	$_SESSION['HOST_TYPE'] = "";
	if($strHostType == "mobile"):
		include_once "mobile/index.php";
		$db->disConnect();
		exit;
	endif;

	/**
	 * database disconnect
	 */
	$db->disConnect();

	/**
	 * page move
	 */

	 header("location:{$strIncludePath}");