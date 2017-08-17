<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00011"] //배송요율관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList mt20">
		<div class="tableListTopWrap">
			<span class="listCntNum">
				<?=drawSelectBoxMore("searchDeliveryMth",$arrForDeliveryMthList,$strSearchDeliveryMth,$design ="",$onchange="javascript:document.form.submit();",$etc="",$firstItem=":::".$LNG_TRANS_CHAR["CW00041"]."	:::",$html="N")?>

				<?=drawSelectBoxMore("searchCountryZone",$aryCountryZoneSelectList,$strSearchCountryZone,$design ="",$onchange="javascript:document.form.submit();",$etc="",$firstItem=":::".$LNG_TRANS_CHAR["CW00041"].":::",$html="N")?>
			</span>
			<div class="selectedSort">
				<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["MW00063"] //목록수?>:</span>
				<select name="pageLine" style="vertical-align:middle;" onchange="javascript:C_getMoveUrl('<?=$strMode?>','get','<?=$PHP_SELF?>');">
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
		<div class="clear"></div>
	</div>

	<div>
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=30/>
				<col width=80/>
				<col width=50/>
				<col width=100/>
				<col width=200>
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"]	 //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00135"] //배송방법?></th>
				<th>ZONE</th>
				<th>WEIGHT</th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="7"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
				?>
			<tr>
				<td><?=$intListNum?></td>
				<td>
					<?=drawSelectBoxMore("deliveryMth_".$row[DA_NO],$S_ARY_DELIVERY_METHOD,$row[DA_MTH],$design ="",$onchange="",$etc="",$firstItem="",$html="N")?></td>
				<td><input type="text" name="deliveryZone_<?=$row[DA_NO]?>" id="deliveryZone_<?=$row[DA_NO]?>" value="<?=$row[DA_AREA]?>"></td>
				<td><input type="text" name="deliveryWeight_<?=$row[DA_NO]?>" id="deliveryWeight_<?=$row[DA_NO]?>" value="<?=$row[DA_WEIGHT]?>"></td>
				<td><input type="text" name="deliveryPrice_<?=$row[DA_NO]?>" id="deliveryPrice_<?=$row[DA_NO]?>" value="<?=$row[DA_PRICE]?>"></td>
				<td>
					<a class="btn_sml" href="javascript:goAct('deliveryModify','<?=$row[DA_NO]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goAct('deliveryDelete','<?=$row[DA_NO]?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
			<tr>
				<td></td>
				<td>
					<?=drawSelectBoxMore("deliveryMth",$arrForDeliveryMthList,$strSearchDeliveryMth,$design ="",$onchange="",$etc="",$firstItem="",$html="N")?>
				</td>
				<td>
					<input type="text" name="deliveryZone" id="deliveryZone" value="">
				</td>
				<td>
					<input type="text" name="deliveryWeight" id="deliveryWeight" value="">
				</td>
				<td>
					<input type="text" name="deliveryPrice" id="deliveryPrice" value="">
				</td>
				<td>
					<a class="btn_sml" href="javascript:goAct('deliveryWrite','');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
				</td>
			</tr>
		</table>
	</div>
	<!-- tableList -->
	<br>
	<!-- Pagenate object --> 
	<div class="paginate">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>
</div>
