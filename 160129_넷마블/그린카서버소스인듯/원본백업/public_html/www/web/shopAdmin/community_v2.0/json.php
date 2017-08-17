<?php
	/**
	 * eumshop - community_v2.0 - json
	 *
	 * eumshop app application development framework for PHP 5.1.6 or newer
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/shopAdmin/community_v2.0/json.php
	 * @history
	 *				2014.06.21 kim hee sung - dev
	 */


	## 페이지 분류
	$aryIncludeFolder = array(   "groupWrite"					=> "group",	
								 "groupModify"					=> "group",
								 "groupData"					=> "group",
								 "groupDelete"					=> "group",
								 "groupFileMake"				=> "group",
								 "boardWrite"					=> "board",
								 "boardStop"					=> "board",
								 "boardModifyBasic"				=> "board",
								 "boardModifyUserfield"			=> "board",
								 "boardModifyCategory"			=> "board",
								 "boardModifyScript"			=> "board",
								 "boardFileMake"				=> "board",
								 "categoryWrite"				=> "category",
								 "categorySelect"				=> "category",
								 "categoryModify"				=> "category",
								 "categoryDelete"				=> "category",
								 "atcWrite"						=> "data",
								 "atcDelete"					=> "data",
								 "dataWrite"					=> "data",
								 "dataModify"					=> "data",
								 "dataDelete"					=> "data",
								 "dataAnswer"					=> "data",
							 );

	## hepler 설정
	include_once MALL_ADMIN . "/{$strMenuType}/{$aryIncludeFolder[$strAct]}/json.inc.php";

	## 체크
	if(!$result) { $result = print_r($_POST, true); }

	## 출력
	echo json_encode($result);

