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
					<?=drawSelectBoxMore("searchOrderStatus",$S_ARY_SETTLE_STATUS,$strSearchOrderStatus,$design ="defSelect",$onchange="",$etc="",$firstItem=$LNG_TRANS_CHAR['PW00282'],$html="N")?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00185"]//주문경로?></th>
				<td>
					<input type="radio" name="searchOrderPath" id="searchOrderPath" value="all" <?=(!$strSearchOrderPath || $strSearchOrderPath=="all")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?>
					<input type="radio" name="searchOrderPath" id="searchOrderPath" value="w" <?=($strSearchOrderPath=="w")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00011"]//웹?>
					<input type="radio" name="searchOrderPath" id="searchOrderPath" value="m" <?=($strSearchOrderPath=="m")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00012"]//모바일?>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<a class="btn_excel_big" href="javascript:goExcel('excelOrderList');" id="menu_auth_e" style="display:none:"><strong>Excel Download</strong></a>
					<?
						if (is_array($aryDeliveryComAll)){
							while(list($key,$val) = each($aryDeliveryComAll)){
								if ($key == "008" || $key == "012"){ 
								?>
					<a class="btn_excel_big" href="javascript:goExcel('excelOrderList_<?=$key?>');"><strong><?=$val?></strong></a>
								<?
								}
							}
						}
					?>
				</td>
			</tr>
		</table>