<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00037"] //포인트관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
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
	</div>
	<!-- 포인트 내역 및 목록수 설정 -->
	<div class="tableList">
		<div class="tableListTopWrap">
			<span class="listCntNum">* 총 <?=$intTotal?>건의 <?=NUMBER_FORMAT($pointSumRow['PT_POINT'])?> 포인트 내역이 있습니다.</span>
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
		<div class="clr"></div>
	</div>
	<!-- 포인트 내역 및 목록수 설정 -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:8%;">
				<col style="width:20%;">
				<col style="width:20%;">
				<col style="width:18%;">
				<col />
				<col style="width:18%;">
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["EW00040"] //포인트종류?></th>
				<th><?=$LNG_TRANS_CHAR["EW00038"] //회원ID?>(<?=$LNG_TRANS_CHAR["EW00039"] //회원명?>)</th>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
				<th><?=$LNG_TRANS_CHAR["EW00032"] //포인트설명?></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="6"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
			</tr>		
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){
			?>
			<tr>
				<td><?=$intListNum--?></td>
				<td style="width:45px;margin:0 auto;">
					<span><em><?=$row[POINT_TYPE_NM]?></em></span>
				</td>
				<td>
					<a href="javascript:goMemberModify('<?=$row[M_NO]?>');"><?=$row[M_ID]?>(<?=$row[M_NAME]?>)</a>
					<?if ($row[O_NO] > 0){?>
						<a class="btn_sml" href="javascript:goMemberOrderView('<?=$row[O_NO]?>');"><strong>구매</strong></a>
					<?}?>
				</td>
				<td><?=NUMBER_FORMAT($row[PT_POINT])?></td>
				<td><?=$row[PT_MEMO]?></td>
				<td><?=$row[PT_REG_DT]?></td>
			</tr>
			<?
				}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate" style="width:400px;padding:0px 5px;">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->
</div>
