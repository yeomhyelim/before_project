		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value=""><?=$LNG_TRANS_CHAR["CW00041"] //선택?></option>
				<option value="I" <?=($strSearchField=="I")?"selected":"";?>><?=$LNG_TRANS_CHAR["EW00038"] //회원ID?></option>
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["EW00039"] //회원명?></option>
			</select>
			<input type="text" name="searchKey" id="searchKey" value="<?=$strSearchKey?>" <?=$nBox?>/>
			<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchTableWrap -->
		<table>
			<tr>
				<th>포인트 등록일</th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>" readOnly />
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
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
				<th>포인트 소멸일</th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchExpStartDt" name="searchExpStartDt" maxlength="10" value="<?=$strSearchExpStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchExpEndDt" name="searchExpEndDt" maxlength="10" value="<?=$strSearchExpEndDt?>"//>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchExpStartDt','searchExpEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00069"] //성별?></th>
				<td>
					<input type="radio" id="searchSex" name="searchSex" value="T" <?=($strSearchSex == "T") ? "checked":"";?>><?=$LNG_TRANS_CHAR["CW00022"] //전체?>
					<input type="radio" id="searchSex" name="searchSex" value="M" <?=($strSearchSex == "M") ? "checked":"";?>>남
					<input type="radio" id="searchSex" name="searchSex" value="W" <?=($strSearchSex == "W") ? "checked":"";?>>여
				</td>
			</tr>
			<tr>
				<th>적립금</th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchPointStart" name="searchPointStart" maxlength="10" value="<?=$strSearchPointStart?>"//> 원
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchPointEnd" name="searchPointEnd" maxlength="10" value="<?=$strSearchPointEnd?>"//> 원
				</td>
			</tr>
			<tr>
				<th>생년월일</th>
				<td>
					<?=drawSelectBoxDate("searchBirthMonth", 1, 12, 1, $strSearchBirthMonth, "", $LNG_TRANS_CHAR["CW00022"],"")?>월
					<?=drawSelectBoxDate("searchBirthDay", 1, 31, 1, $strSearchBirthDay, "", $LNG_TRANS_CHAR["CW00022"],"")?>일
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00040"] //포인트 종류?></th>
				<td>
					<?=drawSelectBoxMore("searchPointType",$aryPointTypeList,$strSearchPointType,$design ="",$onchange="",$etc="",$firstItem=$LNG_TRANS_CHAR["CW00041"],$html="N")?>
				</td>
			</tr>
		</table>