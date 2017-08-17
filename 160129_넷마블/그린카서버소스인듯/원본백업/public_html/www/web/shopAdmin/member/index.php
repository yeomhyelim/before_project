<?
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/member.inc.php";

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;
	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "003";
	if ($a_admin_type == "S") $strTopMenuCode = "003";
	/* 관리자 권한 설정 */

	/* 페이지 분류 */
	$aryIncludeFolder = array(   "memberList"					=> "member"
								,"popMemberCrmView"					=> "member"
								,"popMemberAddr"							=> "member"
								,"popMemberCouponList"				=> "member"
								,"popMemberOrderList"					=> "member"
								,"popMemberPointList"					=> "member"
								,"popMemberPointWrite"					=> "member"
								,"popMemberSearch"						=> "member"

								,"memberInsertWrite"						=> "memberInsert"
								,"memberInsertExcelWrite"				=> "memberExcelUpload"

								,"group"											=> "memberGroup"
								,"popGroupProdSearch"					=> "memberGroup"

								,"setting"											=> "memberJoin"
								,"joinItem"										=> "memberJoin"

								,"memberEvent"								=> "memberEvent"

								,"pointList"										=> "point"
								,"memberPointExcelWrite"				=> "point"
								,"pointSample"									=> "point"

								,"couponList"									=> "coupon"
								,"couponModify"								=> "coupon"
								,"couponView"									=> "coupon"
								,"couponWrite"								=> "coupon"
								,"popCouponMemberSearch"			=> "coupon"
								,"popCouponProdSearch"				=> "coupon"

								,"dataEdit"										=> "smartQuery"
								,"popDataEditSms"							=> "smartQuery"
								,"popDataEditEmail"							=> "smartQuery"
								,"popDataEditSearch"						=> "smartQuery"
								,"popProductSearch"						=> "smartQuery"
								,"dataEditNew"								=> "smartQueryNew"
								,"popDataEditSmsNew"					=> "smartQueryNew"
								,"popDataEditEmailNew"					=> "smartQueryNew"
								,"popDataEditSearchNew"				=> "smartQueryNew"
								,"popProductSearchNew"					=> "smartQueryNew"
								,"popDataEditRec"							=> "smartQueryNew"

								,"memberCateList"							=> "memberCate"
								,"popMemberCateWrite"					=> "memberCate"
								,"popMemberCateModify"				=> "memberCate"
								,"popMemberCateOrderList"			=> "memberCate"

							 );

	/* 페이지 분류 */

	## 스크립트 리스트 설정
	$aryScript				= "";
	$aryScript[]			= "./common/js/member/{$strMode}.js";
	$aryScript[]			= "./common/js/member/member.js";
	$aryScript[]			= "./common/js/common2.js";

	if($strMode == "popMemberCrmView" && in_array($_GET['tab'], array("dataModify","dataView"))):
		$aryScript[]		= "/common/eumEditor/highgardenEditor.js";
	endif;

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || SUBSTR($strMode,0,3) == "pop" || $strMode == "excel"){
		if (SUBSTR($strMode,0,3) == "pop") include $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".php";
		else include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/


	include $strIncludePath.$aryIncludeFolder[$strMode]."/helper.inc.php";

	include "./include/header.inc.php";

	include $strIncludePath.$aryIncludeFolder[$strMode]."/script.inc.php";

	if (!$includeFile){
		$includeFile = $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".php";
	}
?>
<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="leftWrap">
				<!-- ******************** leftArea ********************** -->
					<?include "./include/left.inc.php"?>
				<!-- ******************** leftArea ********************** -->
			</td>
			<td class="contentWrap">
				<div class="bodyTopLine"></div>
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="jsonMode" value="">
						<?
							include $strIncludePath.$aryIncludeFolder[$strMode]."/param.inc.php";

							include $includeFile;
						?>
					</form>
					</div>
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
	</div>
<!-- ******************** footerArea ********************** -->
	<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ********************** -->
</body>
</html>
