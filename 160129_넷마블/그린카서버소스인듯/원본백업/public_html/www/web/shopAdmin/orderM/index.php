<?
	require_once "../conf/order.inc.php";
	require_once MALL_PROD_FUNC;
	require_once MALL_ORDER_FUNC;

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;		

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "005";
	/* 관리자 권한 설정 */
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "list"							=> "list"
								,"popOrderPartCancel"			=> "list"
								,"popOrderCancel"				=> "list"
								,"popOrderCancelInfo"			=> "list"
								,"popOrderHistoryList"			=> "list"
								,"popOrderDeliveryAddr"			=> "list"
								,"popOrderStatusMemo"			=> "list"


								,"deliveryFastInput"			=> "delivery"
								,"deliveryList"					=> "delivery"
								,"popOrderDelvieryExcelUpload"	=> "delivery"
								,"popExcelFileUpload"			=> "delivery"
								

								,"popOrderDeliveryInput"		=> "list"
								,"popOrderView"					=> "list"
								,"popOrderReturn"				=> "list"
								,"addressList"					=> "selfOrder"
								,"addressWrite"					=> "selfOrder"
								,"addressModify"				=> "selfOrder"
								,"selfOrderList"				=> "selfOrder"
								,"selfOrderWrite"				=> "selfOrder"
								,"popProdOrderList"				=> "selfOrder"
								,"popZipCodeList"				=> "selfOrder"
								,"popAddressList"				=> "selfOrder"
								,"popProdOptionList"			=> "selfOrder"
								,"popMemberList"				=> "selfOrder"

								,"accList"						=> "account"
								,"accPeriodList"				=> "account"
								,"accPeriodDetailList"			=> "account"

								,"userAddList1"					=> "userAdd"
							 );

	/* 페이지 분류 */

	## 스크립트 리스트 설정
	$aryScript				= "";
	$aryScript[]			= "./common/js/order/{$strMode}.js";
	$aryScript[]			= "./common/js/order/order.js";
	$aryScript[]			= "./common/js/common2.js";	

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
						<input type="hidden" name="page" value="<?=$intPage?>">
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
