<div id="contentArea">
	<div class="contentTop">
		<h2>국가주관리</h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList mt20">
		<div class="tableListTopWrap">
			<span class="listCntNum">
				<select name="searchCountryCode" id="searchCountryCode" onchange="document.form.submit();">
					<option value="US" <?=($strSearchCountryCode=="US")?"selected":"";?>>미국</option>
					<option value="CN" <?=($strSearchCountryCode=="CN")?"selected":"";?>>중국</option>
				</select>
			</span>
		<div class="clear"></div>
	</div>

	<div class="tableList mt20">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=30/>
				<col />
				<col />
				<col/>
			</colgroup>
			<tr>
				<th>번호</th>
				<th>주 코드</th>
				<th>주</th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="4"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				$intListNum = 1;
				while($row = mysql_fetch_array($result)){
				?>
			<tr>
				<td><?=$intListNum?></td>
				<td>
					<input type="text" name="countryStateCode_<?=$row[CS_NO]?>" id="countryStateCode_<?=$row[CS_NO]?>" value="<?=$row[CS_CODE]?>">
				</td>
				<td>
					<input type="text" name="countryStateName_<?=$row[CS_NO]?>" id="countryStateName_<?=$row[CS_NO]?>" value="<?=$row[CS_NAME]?>" style="width:300px">
					<select name="countryStateArea_<?=$row[CS_NO]?>" id="countryStateArea_<?=$row[CS_NO]?>">
						<option value="">선택</option>
						<option value="W" <?=($row['CS_AREA']=="W")?"selected":"";?>>West</option>
						<option value="E" <?=($row['CS_AREA']=="E")?"selected":"";?>>East</option>
						<option value="S" <?=($row['CS_AREA']=="S")?"selected":"";?>>South</option>
						<option value="N" <?=($row['CS_AREA']=="N")?"selected":"";?>>North</option>
					</select>
				</td>
				<td>
					<a class="btn_sml" href="javascript:goAct('countryStateModify','<?=$row[CS_NO]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goAct('countryStateDelete','<?=$row[CS_NO]?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					
				</td>
			</tr>
			<?
					$intListNum++;
				}
			}
			?>
			<tr>
				<td></td>
				<td>
					<input type="text" name="countryStateCode" id="countryStateCode" value="">
				</td>
				<td>
					<input type="text" name="countryStateName" id="countryStateName" value=""  style="width:300px">
					<select name="countryStateArea" id="countryStateArea">
						<option value="">선택</option>
						<option value="W">West</option>
						<option value="E">East</option>
						<option value="S">South</option>
						<option value="N">North</option>
					</select>
				</td>
				<td>
					<a class="btn_sml" href="javascript:goAct('countryStateWrite','');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
				</td>
			</tr>
		</table>
	</div>
	<!-- tableList -->
	<br>
	<!-- Pagenate object --> 
</div>
