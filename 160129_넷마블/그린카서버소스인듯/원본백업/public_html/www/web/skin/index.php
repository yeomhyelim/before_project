<?php
	/**
	 * eumshop skin
	 *
	 * eumshop app application development framework for PHP 5.1.6 or newer
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/skin/index.php
	 * @history
	 *				2014.07.01 kim hee sung - dev
	 */

	## 기본설정
	$strSkinName = $_GET['name'];

	## 체크
	if(!$strSkinName) { return; }

	$aryCss[] = "/_skin/{$strSkinName}/layout/css/layout_style.css";
	$aryCss[] = "/_skin/{$strSkinName}/layout/css/main.css";
?>

<?php include MALL_HOME . "/include/header.inc.php"; ?>

<?php include MALL_SHOP . "/_skin/{$strSkinName}/layout/html/main_html.inc.php";?>

</html>