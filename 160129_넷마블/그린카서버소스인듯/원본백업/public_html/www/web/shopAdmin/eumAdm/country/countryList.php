<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00013"] //배송국가관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList">
		<div class="tableListTopWrap">
			<span class="listCntNum">
				<?=drawSelectBoxMore("searchDeliveryMth",$arrForDeliveryMthList,$strSearchDeliveryMth,$design ="",$onchange="javascript:document.form.submit();",$etc="",$firstItem=":::".$LNG_TRANS_CHAR["CW00041"].":::",$html="N")?>

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
				<col />
				<col />
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"]	 //번호?></th>
				<th>국가</th>
				<th>ZONE</th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="4"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
				?>
			<tr>
				<td><?=$intListNum?></td>
				<td>
					<?=drawSelectBoxMore("countryCode_".$row[CZ_NO],$aryCountrySelectList,$row[CT_CODE],$design ="",$onchange="",$etc="",$firstItem="",$html="N")?>
				</td>
				<td><input type="text" name="countryZone_<?=$row[CZ_NO]?>" id="countryZone_<?=$row[CZ_NO]?>" value="<?=$row[CZ_ZONE]?>"></td>
				<td>
					<a class="btn_sml" href="javascript:goAct('countryZoneModify','<?=$row[CZ_NO]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goAct('countryZoneDelete','<?=$row[CZ_NO]?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					
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
					<?=drawSelectBoxMore("countryCode",$aryCountrySelectList,"",$design ="",$onchange="",$etc="",$firstItem="",$html="N")?>
				</td>
				<td>
					<input type="text" name="countryZone" id="countryZone" value="">
				</td>
				<td>
					<a class="btn_sml" href="javascript:goAct('countryZoneWrite','');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
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
