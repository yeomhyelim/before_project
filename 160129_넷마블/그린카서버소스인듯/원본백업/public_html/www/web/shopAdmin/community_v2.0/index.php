<?php
	/**
	 * eumshop community
	 *
	 * eumshop app application development framework for PHP 5.1.6 or newer
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 2.0
	 * @filesource	/www/web/shopAdmin/community_v2.0/index.php
 	 * @note		1. 소스를 정리한다.
	 *				2. 다국어 버전을 지원한다.
	 * @history
	 *				2014.06.21 kim hee sung - dev
	 */

	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";
	/* 여기에 추가되어야 함(메일관련) */

	## 관리자 Top 메뉴 권한 설정
	$strTopMenuCode = "006";

	## 액션
	if($strMode == "act" || $strMode == "json"):
		include dirname(__FILE__) . "/{$strMode}.php";
		exit;
	endif;

	## 페이지 분류
	$aryIncludeFolder = array(   "groupList"				=> "group",
								 "boardList"				=> "board",
								 "boardWrite"				=> "board",
								 "boardModifyBasic"			=> "board",
								 "boardModifyUserfield"		=> "board",
								 "boardModifyCategory"		=> "board",
								 "boardModifyScript"		=> "board",
								 "boardNonList"				=> "board",
								 "boardMain"				=> "boardMain",
								 "dataList"					=> "data",
								 "dataWrite"				=> "data",
								 "dataView"					=> "data",
								 "dataModify"				=> "data",
								 "dataAnswer"				=> "data",
							 );

	## 기본 설정
	$strCommunityVersion = $S_COMMUNITY_VERSION;
	$strCommunityVersionLower = strtolower($strCommunityVersion);
	$includeFile = MALL_ADMIN . "/{$strMenuType}_{$strCommunityVersionLower}/{$aryIncludeFolder[$strMode]}/{$strMode}.php";
	
	## hepler 설정
	include_once MALL_ADMIN . "/{$strMenuType}_{$strCommunityVersionLower}/{$aryIncludeFolder[$strMode]}/helper.inc.php";
?>
	<?php include_once MALL_ADMIN . "/include/header.inc.php";?>
	<?php include_once MALL_ADMIN . "/include/top.inc.php"?>

	<div id="contentArea">
		<table style="width:100%;">
			<tr>
				<td class="leftWrap">
					<?php include_once MALL_ADMIN . "/include/left.inc.php";?>
				</td>
				<td class="contentWrap">
					<div class="bodyTopLine"></div>
					<div class="layoutWrap">
						<?php include_once $includeFile;?>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<?php include_once MALL_ADMIN . "/include/bottom.inc.php";?>

</body>
</html>