<?php
	/**
	 * eumshop app - include - defaultSkin
	 *
	 * include 설정
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/include/include.defaultSkin.php
	 * @manual		&mode=include&skin=defaultSkin&group=19
	 * @history
	 *				2014.06.11 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "INCLUDE_{$intAppID}";
	endif;

	## 기본 설정
	$strAppHome				= $EUMSHOP_APP_INFO['home'];
	$strAppPath				= $EUMSHOP_APP_INFO['path']; 
	$strAppHomeLang			= $EUMSHOP_APP_INFO['homeLang'];
	$strAppSiteLang			= $EUMSHOP_APP_INFO['siteLang'];
	if(!$strAppHome) { return; }
	if(!$strAppPath) { return; }
	if(!$strAppSiteLang) { $strAppSiteLang = $S_SITE_LNG; }
	if(!$strAppHomeLang) { $strAppHomeLang = $S_ST_LNG; }
	$strAppSiteLangLower	= strtolower($strAppSiteLang);
	$strAppHomeLangLower	= strtolower($strAppHomeLang);	
	$strAppPath				= str_replace("{@siteLang@}", $strAppSiteLangLower, $strAppPath);
	if($strAppPath[0] != "/") { $strAppPath = "/{$strAppPath}"; }	
	## home 경로 설정
	if($strAppHome == "mobile") { $strAppHome = MALL_SHOP . "/mobile/layout/html-c/{$strAppHomeLangLower}"; }
	else { return; }

?>
<!-- eumshop app - include - defaultSkin (<?php echo $strAppID?>) -->
<?php if(!is_file($strAppHome . $strAppPath)):?>
<?php echo $strAppHome . $strAppPath;?>
<?php else:?>
<?php include $strAppHome . $strAppPath;?>
<?php endif;?>
<!-- eumshop app - include - defaultSkin (<?php echo $strAppID?>) -->
