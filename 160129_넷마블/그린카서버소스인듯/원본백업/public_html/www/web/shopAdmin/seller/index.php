<?
	require_once "../conf/order.inc.php";
	require_once MALL_PROD_FUNC;
	
	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;	

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "009";
	if ($a_admin_type == "S") $strTopMenuCode = "011";

	/* 관리자 권한 설정 */

	/* 페이지 분류 */
	$aryIncludeFolder = array(   "main"								=> "main"
								,"shopList"							=> "shop"
								,"notice"							=> "notice"
								,"qna"								=> "qna"
								,"shopWrite"						=> "shop"
								,"shopModify"						=> "shop"
								,"shopSetting"						=> "shop"
								,"shopProduct"						=> "shop"
								,"shopGrade"						=> "shop"
								,"shopNotOk"						=> "shop"
								,"popShopUserList"					=> "shop"
								,"shopUser"							=> "shop"
								,"shopUserWrite"					=> "shop"
								,"shopUserModify"					=> "shop"
								,"shopSite"							=> "shop"
								,"shopProdList"						=> "shop"
								,"shopOrderList"					=> "shop"
								,"shopPolicy"						=> "shop"
								,"orderList"						=> "order"

							 );

	/* 페이지 분류 */
	if($a_admin_type == "S"): // 입점몰 사용자
		if($strMode == "shopList") { $strMode = "shopModify"; }
	endif;

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || SUBSTR($strMode,0,3) == "pop" || $strMode == "excel"){
		if (SUBSTR($strMode,0,3) == "pop") include $strIncludePath.$aryIncludeFolder[$strMode]."/".$strMode.".php";
		else include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/
	
	include $strIncludePath.$aryIncludeFolder[$strMode]."/helper.inc.php";

?>

<? include "./include/header.inc.php"?>
<?
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
