<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["OW00001"] //주문관리?></h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap mt20">
		<?include $strIncludePath."list/search.inc.php";?>
	</div>
	
	<div style="text-align:left;margin-top:10px;">
		
		<a class="btn_big" href="javascript:goOrderCartDeliveryAllUpdate();"><strong>배송정보변경</strong></a>
		<?if ($_REQUEST["searchOrderStatus"] == "B"){?>
		<a class="btn_big" href="javascript:goExcel('excelOrderDeliveryDown');"><strong>송장엑셀파일다운로드</strong></a>
		<a class="btn_big" href="javascript:goExcelUpload();"><strong>송장엑셀파일업로드</strong></a>
		<?}?>
		<?if ($_REQUEST["searchOrderStatus"] == "D"){?>
		<a class="btn_big" href="javascript:goOrderStatusUpdate(0);"><strong>구매확정변경</strong></a>
		<?}?>

		<a class="btn_excel_big" href="javascript:goExcel('excelOrderDeliveryList');" id="menu_auth_e" style="display:none:"><strong>Download</strong></a>

		<div class="selectedSort">
			<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["MW00063"] //목록수?>:</span>
			<select name="pageLine" style="vertical-align:middle;" onchange="javascript:goSearch();">
				<option value="10" <? if($intPageLine==10) echo 'selected';?>>10</option>
				<option value="20" <? if($intPageLine==20) echo 'selected';?>>20</option>
				<option value="30" <? if($intPageLine==30) echo 'selected';?>>30</option>
				<option value="40" <? if($intPageLine==40) echo 'selected';?>>40</option>
				<option value="50" <? if($intPageLine==50) echo 'selected';?>>50</option>
				<option value="60" <? if($intPageLine==60) echo 'selected';?>>60</option>
				<option value="70" <? if($intPageLine==70) echo 'selected';?>>70</option>
				<option value="80" <? if($intPageLine==80) echo 'selected';?>>80</option>
				<option value="90" <? if($intPageLine==90) echo 'selected';?>>90</option>
				<option value="100" <? if($intPageLine==100) echo 'selected';?>>100</option>
				<option value="200" <? if($intPageLine==200) echo 'selected';?>>200</option>
			</select>
		</div>

	</div>
	<!-- tableList -->
	<? include "deliveryList.skin.php";?>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate mt10">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object --> 
</div>
