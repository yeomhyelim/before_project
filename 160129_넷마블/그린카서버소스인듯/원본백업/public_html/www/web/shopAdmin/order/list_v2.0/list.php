<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["OW00001"] //주문관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<?include "search.inc.php";?>
	</div>

	<div class="buttonBoxWrap mt20">
		<a class="btn_new_blue" href="javascript:goOrderCartDeliveryAllUpdate();"><strong class="allChkDlv"><?= $LNG_TRANS_CHAR["OW00143"]; //배송정보변경 ?></strong></a>
		<a class="btn_new_blue" href="javascript:goOrderStatusUpdate(0);"><strong class="allChkBuy"><?= $LNG_TRANS_CHAR["OW00131"]; //구매상태변경 ?></strong></a>
		<?if ($a_admin_type != "S"){?>
			<a class="btn_new_gray" href="javascript:goOrderInfoListAllDisplay('block');"><strong><?=$LNG_TRANS_CHAR["OW00144"]; //주문상품정보 모두 펼치기?></strong></a>
			<a class="btn_new_gray" href="javascript:goOrderInfoListAllDisplay('none');"><strong><?=$LNG_TRANS_CHAR["OW00145"]; //주문상품정보 모두 닥기?></strong></a>
			<a class="btn_excel_big" href="javascript:goExcel('excelOrderList');" id="menu_auth_e" style="display:none:"><strong>Download</strong></a>
		<?}?>

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




	</div>
	<!-- tableList -->
	<? include "list.skin.".$a_admin_type.".php";?>
	<!-- tableList -->

	<!-- Pagenate object -->
	<div class="paginate">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<!-- Pagenate object -->
	<?if ($a_admin_type != "S"){?>
	<div class="buttonBoxWrap">
		<a class="btn_new_gray" href="javascript:goOrderSettleStatusUpdate(0);"><strong><?=$LNG_TRANS_CHAR["OS00010"]; //선택하신 주문정보를 모두 [결제완료]로 변경?></strong></a>
		<!-- (<?=$LNG_TRANS_CHAR["OS00011"] //주문상태가 [주문완료]일때만 변경됨?>) -->
		<!--* <a class="btn_big" href="javascript:goOrderStatusUpdate(0);"><strong><?=$LNG_TRANS_CHAR["OS00030"] //변경하신 주문상태로 모두 변경?></strong></a>//-->
	</div>
	<?}?>
</div>
