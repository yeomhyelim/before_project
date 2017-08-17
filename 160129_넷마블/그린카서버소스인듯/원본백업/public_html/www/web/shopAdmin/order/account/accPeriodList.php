<div id="contentArea">
	<div class="contentTop">
		<h2><?=$strTitle?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goInitMoveUrl('accList','<?=$strSearchAccStatus?>');"><?=$LNG_TRANS_CHAR["OW00103"] //상품별?></a>	
		<a href="javascript:javascript:goInitMoveUrl('accPeriodList','<?=$strSearchAccStatus?>');"  class="selected"><?=$LNG_TRANS_CHAR["OW00104"] //주문기간별?></a>
		<?if($S_SHOP_ORDER_VERSION=="V2.0"){?>
		<a href="javascript:javascript:goInitMoveUrl('accDateList','<?=$strSearchAccStatus?>');" <?=($strMode=="accDateList")?"class=\"selected\"":"";?>>구매일자별</a>
		<?}?>

	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00005"] //주문일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
				</td>
			</tr>
			<tr>
				<th><?="구매확정일자" //구매확정일자?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchOrderEndStartDt" name="searchOrderEndStartDt" maxlength="10" value="<?=$strSearchOrderEndStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchOrderEndEndDt" name="searchOrderEndEndDt" maxlength="10" value="<?=$strSearchOrderEndEndDt?>"//>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchOrderEndStartDt','searchOrderEndEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchOrderEndStartDt','searchOrderEndEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchOrderEndStartDt','searchOrderEndEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchOrderEndStartDt','searchOrderEndEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchOrderEndStartDt','searchOrderEndEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchOrderEndStartDt','searchOrderEndEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
				</td>
			</tr>
			<?if ($strSearchAccStatus == "Y"){?>
			<tr>
				<th><?="정산일자" //정산일자?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchOrderAccStartDt" name="searchOrderAccStartDt" maxlength="10" value="<?=$strSearchOrderAccStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchOrderAccEndDt" name="searchOrderAccEndDt" maxlength="10" value="<?=$strSearchOrderAccEndDt?>"//>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchOrderAccStartDt','searchOrderAccEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchOrderAccStartDt','searchOrderAccEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchOrderAccStartDt','searchOrderAccEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchOrderAccStartDt','searchOrderAccEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchOrderAccStartDt','searchOrderAccEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchOrderAccStartDt','searchOrderAccEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
				</td>
			</tr>
			<?}?>
			<?if ($a_admin_type == "A"){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00096"] //업체명?></th>
				<td>
					<?=drawSelectBoxMore("searchCompany",$aryShopList,$strSearchCompany,$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["OW00100"],$html="N")?>
					
				</td>
			</tr>
			<?}?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></th>
				<td>
					<?foreach($S_ARY_SETTLE_TYPE as $key => $value):
						if (in_array($key,$arySiteSettle) || in_array($key,$arySiteForSettle) || in_array($key,array("B","P"))){ 
					?>
					<input type="checkbox" id="searchSettleType" name="searchSettleType[]" value="<?=$key?>"<?if(in_array($key, $arySearchSettleType)){echo " checked";}?>><?=$value?> 
					<?	}?>
					<?endforeach;?>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-top:10px;text-align:center;">
					<a class="btn_search" href="javascript:goSearch('accPeriodList');" style="width:400px;"><strong class="ico_search"><?=$LNG_TRANS_CHAR["CW00027"]?></strong></a>
					<a class="btn_excel_big" href="javascript:goExcel('excelAccPeriodList');" id="menu_auth_e" style="display:none:"><strong>Excel Download</strong></a>
				</td>
			</tr>
		</table>
	</div>
	<div class="tableFormWrap mt10">
		<table class="tableForm">
			<colgroup>
				<col width="100">
				<col/>
				<col width="100">
				<col/>
				<col width="100">
				<col/>
				<col width="100">
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00110"]?></th>
				<td><?=getFormatPrice($accSumRow[TOT_SPRICE])?></td>
				<th>총배송비</th>
				<td><?=getFormatPrice($accSumRow[TOT_BPRICE])?></td>
				<th>총입고가</th>
				<td><?=getFormatPrice($accSumRow[TOT_PRICE])?></td>
				<th>총정산금액</th>
				<td><?=getFormatPrice($accSumRow[TOT_APRICE]+$accSumRow[TOT_BPRICE])?></td>
				<th><?=$LNG_TRANS_CHAR["OW00111"]?></th>
				<td><?=getFormatPrice($accSumRow[TOT_ACC_PRICE])?></td>
			</tr>
		</table>
	</div>	
	<?if ($a_admin_type == "A"){?>
	<div class="buttonBoxWrap">
		<select id="accStatus" name="accStatus">
				<option value="">:::<?=$LNG_TRANS_CHAR["CW00041"] //선택?>:::</option>
				<option value="Y"><?=$LNG_TRANS_CHAR["OW00101"] //정산승인?></option>
				<option value="N"><?=$LNG_TRANS_CHAR["OW00102"] //정산취소?></option>
		 </select> 
		<a class="btn_big" href="javascript:goAccStatusUpdate('D');"><strong><?=$LNG_TRANS_CHAR["OS00018"] //선택하신 업체 모두 변경?></strong></a>

		<div class="selectedSort">
			<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["MW00063"] //목록수?>:</span>
			<select name="pageLine" style="vertical-align:middle;" onchange="javascript:goSearch('accPeriodList');">
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
	<?}?>
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=40/>
				<col />
				<col width=100/>
				<col width=100/>
				<col width=150/>
				<col width=150/>
				<col width=150/>
				<col width=100/>
				<col width=100/>
				<col width=100/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00096"] //업체명?></th>
				<th><?=$LNG_TRANS_CHAR["OW00105"] //판매건수?></th>
				<th><?=$LNG_TRANS_CHAR["OW00106"] //판매수량?></th>
				<th><?="총입고가" //입고가격?></th>
				<th><?="총판매가" //판매가격?></th>
				<th><?="총배송비" //배송비?></th>
				<th><?="총정산금액" //정산금액?></th>
				<th><?="총수수료" //정수수료?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
					
					if (!$row['SH_COM_NAME']) $row['SH_COM_NAME'] = "본사";
					
					#총수수료
					$intTotOrderAccFeePrice = $row[TOT_SPRICE] - $row[TOT_APRICE];

				?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[SH_NO]?>"></td>
				<td><?=$intListNum?></td>
				<td><?=$row[SH_COM_NAME]?></td>
				<td><?=NUMBER_FORMAT($row[TOT_CNT])?></td>
				<td><?=NUMBER_FORMAT($row[TOT_QTY])?></td>
				<td><?=getFormatPrice($row[TOT_PRICE])?></td>
				<td><?=getFormatPrice($row[TOT_SPRICE])?></td>
				<td><?=getFormatPrice($row[TOT_BPRICE])?></td>
				<td><?=getFormatPrice($row[TOT_APRICE]+$row[TOT_BPRICE])?></td>
				<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
				<td><a class="btn_sml" href="javascript:goAccPeriodDetailList(<?=$row[SH_NO]?>);" id="" style=""><strong><?=$LNG_TRANS_CHAR["OW00107"] //정산?></strong></a></td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate mt10">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object --> 

</div>
