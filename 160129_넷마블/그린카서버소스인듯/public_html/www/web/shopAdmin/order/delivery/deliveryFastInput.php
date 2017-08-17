<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["OW00091"] //빠른송장입력?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="K" <?=($strSearchField=="K")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></option>
				<option value="J" <?=($strSearchField=="J")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00003"] //주문자?></option>
				<option value="M" <?=($strSearchField=="M")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00004"] //회원ID?></option>
				<option value="B" <?=($strSearchField=="B")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00040"] //받는사람?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?>/>
			<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"]?></strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00070"] //회원구분?></th>
				<td>
					<input type="radio" name="searchMemberType" value="all" checked> <?=$LNG_TRANS_CHAR["CW00022"] //전체?>
					<input type="radio" name="searchMemberType" value="member"<?=($strSearchMemberType=="member") ? "checked" : ""?>> <?=$LNG_TRANS_CHAR["OW00071"] //회원?>
					<input type="radio" name="searchMemberType" value="nonmember"<?=($strSearchMemberType=="nonmember") ? "checked" : ""?>> <?=$LNG_TRANS_CHAR["OW00072"] //비회원?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00073"] //택배회사?></th>
				<td>
					<?=drawCheckBox("searchDeliveryCom[]", $aryDeliveryComAll, $strSearchDeliveryCom, $design="", $readonly=false, $gap="&nbsp;", $colCnt=0, $onclick="")?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00005"] //주문일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
					<span class="searchWrapImg">
						<a href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><?=$LNG_TRANS_CHAR["CW00017"]?></a>
						<a href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><?=$LNG_TRANS_CHAR["CW00018"]?></a>
						<a href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><?=$LNG_TRANS_CHAR["CW00019"]?></a>
						<a href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><?=$LNG_TRANS_CHAR["CW00020"]?></a>
						<a href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><?=$LNG_TRANS_CHAR["CW00021"]?></a>
						<a href="#"><?=$LNG_TRANS_CHAR["CW00022"]?></a>
					</span>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></th>
				<td>
					<?if ($intSiteSettleC == "Y"){?>
					<input type="checkbox" id="searchSettleC" name="searchSettleC" value="Y" <?=($strSearchSettleC=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["C"]?>
					<?}?>
					<?if ($intSiteSettleA == "Y"){?>
					<input type="checkbox" id="searchSettleA" name="searchSettleA" value="Y" <?=($strSearchSettleA=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["A"]?>
					<?}?>
					<?if ($intSiteSettleT == "Y"){?>
					<input type="checkbox" id="searchSettleT" name="searchSettleT" value="Y" <?=($strSearchSettleT=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["T"]?>
					<?}?>
					<?if ($intSiteSettleB == "Y"){?>
					<input type="checkbox" id="searchSettleB" name="searchSettleB" value="Y"<?=($strSearchSettleB=="Y")?"checked":"";?>><?=$S_ARY_SETTLE_TYPE["B"]?>
					<?}?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00010"] //주문상태?></th>
				<td>
					<?=drawSelectBoxMore("searchOrderStatus",$S_ARY_SETTLE_STATUS,$strSearchOrderStatus,$design ="defSelect",$onchange="",$etc="",$firstItem="주문상태선택",$html="N")?>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><a class="btn_excel_big" href="javascript:goExcel('excelDeliveryFastList');" id="menu_auth_e" style="display:none:"><strong>Excel Download</strong></a></td>
			</tr>
		</table>
	</div>
	<br>
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=40/>
				<col width=150/>
				<col width=150/>
				<col width=150/>
				<col width=150/>
				<col width=120/>	
				<col />
				<col width=100/>
				<col width=100/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
				<th><?=$LNG_TRANS_CHAR["OW00075"] //총주문금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00027"] //배송비?></th>
				<th><?=$LNG_TRANS_CHAR["OW00073"] //배송회사?></th>
				<th><?=$LNG_TRANS_CHAR["OW00090"] //송장번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00038"] //결제상태?></th>
				<th><?=$LNG_TRANS_CHAR["OW00010"] //주문상태?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
					$strOrderSettle = $btnOrderCancel = $brnOrderCalOff = $brnOrderAccClear = "";
					if ($row[O_SETTLE] == "C") $strOrderSettle = $S_ARY_SETTLE_TYPE["C"]; //"신용카드";
					else if ($row[O_SETTLE] == "A") $strOrderSettle = $S_ARY_SETTLE_TYPE["A"]; //"계좌이체";
					else if ($row[O_SETTLE] == "T") $strOrderSettle = $S_ARY_SETTLE_TYPE["T"]; //"가상계좌";
					else if ($row[O_SETTLE] == "B") $strOrderSettle = $S_ARY_SETTLE_TYPE["B"]; //"무통장입금";
					else if ($row[O_SETTLE] == "P") $strOrderSettle = $S_ARY_SETTLE_TYPE["P"]; //"포인트/쿠폰";
				
					/* 결제 상태 */
					$strOrderSettleStatusText = "";
					if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
						$strOrderSettleStatusText = $LNG_TRANS_CHAR["OW00079"]; //"입금확인전";
					} else {
						$strOrderSettleStatusText = $LNG_TRANS_CHAR["OW00080"]; //"결제완료";
					}
				?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[O_NO]?>"></td>
				<td><?=$intListNum?></td>
				<td>
					<span><?=$row[O_KEY]?></span>
					<a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>');"><span><?=$LNG_TRANS_CHAR["OW00012"] //상세보기?></span></a>
				</td>
				<td><span class="orderDate">[<?=$row[O_REG_DT]?>]</span></td>
				<td><span><?=$S_ST_CUR_MARK1?></span> <strong><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"] // 원?> <?=getFormatPrice($row[O_TOT_CUR_SPRICE],2)?> <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"] // 원?></strong></td>
				<td><?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"] // 원?> <?=getFormatPrice($row[O_TOT_DELIVERY_CUR_PRICE],2)?> <?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"] // 원?></td>
				<td>
					<?=drawSelectBoxMore("deliveryCom_".$row[O_NO],$aryDeliveryComAll,$row[O_DELIVERY_COM],"","",$firstItem="",$LNG_TRANS_CHAR["CW00041"])?>
				</td>
				<td>
					<input type="text" <?=$nBox?>  style="width:120px;" id="deliveryComNum_<?=$row[O_NO]?>" name="deliveryComNum_<?=$row[O_NO]?>" maxlength="20" value="<?=$row[O_DELIVERY_NUM]?>"//>
				</td>
				<td><?=$strOrderSettleStatusText?></td>
				<td>
					<?=$S_ARY_SETTLE_STATUS[$row[O_STATUS]];?>
				</td>
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
	<div class="paginate">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object --> 
	<div style="text-align:left;margin-top:3px;">
		<a class="btn_big" href="javascript:goOrderDeliveryUpdate();"><strong><?=$LNG_TRANS_CHAR["CW00049"] //일괄변경?></strong></a>
		<a class="btn_big" href="javascript:goOrderDelvieryExcelUpdate();"><strong>Excel Upload</strong></a>
	</div>
</div>
