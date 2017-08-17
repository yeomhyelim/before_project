<?php
	/**
	 * eumshop app - popup
	 *
	 * 팝업 앱입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/popup/popup.php
	 * @manual		&mode=popup
	 * @history
	 *				2014.06.10 kim hee sung - 개발 완료
	 */

	/**
	 * 스킨 설정
	 */
	if(!$strAppSkin) { $strAppSkin		= "defaultSkin"; }
	if($strAct):
		include MALL_HOME . "/web/app/{$strAppMode}/{$strAct}.php";
		return;
	endif;

	/**
	 * 이동
	 */
	include MALL_HOME . "/web/app/{$strAppMode}/{$strAppMode}.{$strAppSkin}.php";