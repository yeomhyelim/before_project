<?php
	/**
	 * eumshop app - bannerList 
	 *
	 * 배너 리스트 앱입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/bannerList/bannerList.php
	 * @manual		mode=bannerSlider&code=TRAVEL_BANNER&itemCnt=1
	 * @history
	 *				2014.06.11 kim hee sung - 개발 완료
	 */

	/**
	 * 스킨 설정
	 */
	if(!$strAppSkin) { $strAppSkin		= "defaultSkin"; }

	/**
	 * 이동
	 */
	include MALL_HOME . "/web/app/{$strAppMode}/{$strAppMode}.{$strAppSkin}.php";