<?php
	/**
	 * eumshop - layout_v2 - json
	 *
	 * eumshop app application development framework for PHP 5.1.6 or newer
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/shopAdmin/layout_v2.0/json.php
	 * @history
	 *				2014.06.22 kim hee sung - dev
	 */


	## 페이지 분류
	$aryIncludeFolder = array(   "sliderBannerModify"		=> "sliderBanner",
								 "sliderBannerWrite"		=> "sliderBanner",
								 "sliderBannerDelete"		=> "sliderBanner",
								 "skinModify"				=> "skin",
								 "skinRestore"				=> "skin"

							 );

	## hepler 설정
	include_once MALL_ADMIN . "/{$strMenuType}/{$aryIncludeFolder[$strAct]}/json.inc.php";

	## 체크
	if(!$result) { $result = print_r($_POST, true); }

	## 출력
	echo json_encode($result);

