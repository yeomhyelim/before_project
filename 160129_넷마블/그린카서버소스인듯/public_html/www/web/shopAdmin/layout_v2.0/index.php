<?php
	/**
	 * eumshop layout
	 *
	 * eumshop app application development framework for PHP 5.1.6 or newer
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/shopAdmin/layout_v2.0/index.php
 	 * @note		1. 소스를 정리한다.
	 *				2. 다국어 버전을 지원한다.
	 * @history
	 *				2014.06.22 kim hee sung - dev
	 */

	## 액션
	if($strMode == "act" || $strMode == "json"):
		include dirname(__FILE__) . "/{$strMode}.php";
		exit;
	endif;

	## 페이지 분류
	$aryIncludeFolder = array(   "sliderBannerList"				=> "sliderBanner",
								 "sliderBannerWrite"			=> "sliderBanner",
								 "sliderBannerModify"			=> "sliderBanner",
								 "skinList"						=> "skin"

							 );

	## 기본 설정
	$strLayoutVersion = $S_LAYOUT_VERSION;
	$strLayoutVersionLower = strtolower($strLayoutVersion);
	$includeFile = MALL_ADMIN . "/{$strMenuType}_{$strLayoutVersionLower}/{$aryIncludeFolder[$strMode]}/{$strMode}.php";

	## hepler 설정
	include_once MALL_ADMIN . "/{$strMenuType}_{$strLayoutVersionLower}/{$aryIncludeFolder[$strMode]}/helper.inc.php";
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

	<!-- 권한 설정 //-->
	<script>
		C_CallMenuAuthBtn("<?php echo $a_admin_no;?>","<?php echo $strTopMenuCode;?>","<?php echo $strLeftMenuCode01;?>","<?php echo $strLeftMenuCode02;?>");
	</script>
	<!-- 권한 설정 //-->
</body>
</html>