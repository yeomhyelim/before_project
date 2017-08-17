<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["MM00026"]//회원가입항목관리?></h2>
	<div class="clr"></div>
</div>

<!-- ******** 컨텐츠 ********* -->
<div class="titInfoTxt mt20">
	* <?=$LNG_TRANS_CHAR['MS00084']//회원 등급에 체크를 하지 않으면 모든 등급에 적용됩니다.?>
</div>
<div class="tableListWrap">
	<table class="tableList">
		<colgroup>
			<col width="200px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col/>
		</colgroup>
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00062"]//항목?></th>
			<th><?=$LNG_TRANS_CHAR["PW00094"]//사용여부?></th>
			<!--<th>순서</th>//-->
			<th><?=$LNG_TRANS_CHAR["MW00257"]//필수체크사항?></th>
			<th><?=$LNG_TRANS_CHAR["MW00258"]//회원가입?></th>
			<th><?=$LNG_TRANS_CHAR["MW00259"]//마이페이지?></th>
			<th><?=$LNG_TRANS_CHAR["MW00260"]//회원등급?></th>
		</tr>
		<?
		for($k=0;$k<sizeof($aryUserItemList);$k++){
			$intNo = $aryUserItemList[$k][JI_NO];
			
			$strDisabled = ($aryUserItemList[$k][JI_USE] == "A") ? "disabled":"";
			$aryGroup = explode("/",$aryUserItemList[$k][JI_GRADE]);
		?>
		<tr>
			<td><?=$aryUserItemList[$k][JI_NAME_KR]?></td>
			<td><input type="checkbox" name="item_use_<?=$intNo?>" id="item_use_<?=$intNo?>" value="Y" <?=($aryUserItemList[$k][JI_USE] == "N") ? "":"checked";?> <?=$strDisabled?>></td>
			<!--<td>
				<input type="text" name="item_order_<?=$intNo?>" id="item_order_<?=$intNo?>" value="<?=$aryUserItemList[$k][JI_ORDER]?>" style="width:50px" <?=$strDisabled?>>
			</td>//-->
			<td><input type="checkbox" name="item_nes_<?=$intNo?>" id="item_nes_<?=$intNo?>" value="Y" <?=($aryUserItemList[$k][JI_NES] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_join_<?=$intNo?>" id="item_join_<?=$intNo?>" value="Y" <?=($aryUserItemList[$k][JI_JOIN] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_mypage_<?=$intNo?>" id="item_mypage_<?=$intNo?>" value="Y" <?=($aryUserItemList[$k][JI_MYPAGE] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td>
			<?
				if (is_array($aryMemberGroup)){
					for($i=0;$i<sizeof($aryMemberGroup);$i++){
						$strChecked = "";
						if (is_array($aryGroup)){
							for($j=0;$j<sizeof($aryGroup);$j++){
								if ($aryGroup[$j] == $aryMemberGroup[$i][G_CODE]) {
									$strChecked = "checked";
									break;
								}
							}
						}
						
						echo "&nbsp;&nbsp;<input type=\"checkbox\" name=\"item_grade_".$intNo."[]\" id=\"item_grade_".$intNo."[]\" value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strChecked." ".$strDisabled.">".$aryMemberGroup[$i][G_NAME];
					}
				}
			?>
			</td>
		</tr>
		<?}?>
	</table>

	<table class="tableList mt20">
		<colgroup>
			<col width="200px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col/>
		</colgroup>
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00062"]//항목?></th>
			<th><?=$LNG_TRANS_CHAR["PW00094"]//사용여부?></th>
			<!--<th>순서</th>//-->
			<th><?=$LNG_TRANS_CHAR["MW00257"]//필수체크사항?></th>
			<th><?=$LNG_TRANS_CHAR["MW00258"]//회원가입?></th>
			<th><?=$LNG_TRANS_CHAR["MW00259"]//마이페이지?></th>
			<th><?=$LNG_TRANS_CHAR["MW00260"]//회원등급?></th>
		</tr>
		<?
		for($k=0;$k<sizeof($aryBusiItemList);$k++){
			$intNo = $aryBusiItemList[$k][JI_NO];
			
			$strDisabled = ($aryBusiItemList[$k][JI_USE] == "A") ? "disabled":"";
			$aryGroup = explode("/",$aryBusiItemList[$k][JI_GRADE]);
		?>
		<tr>
			<td><?=$aryBusiItemList[$k][JI_NAME_KR]?></td>
			<td><input type="checkbox" name="item_use_<?=$intNo?>" id="item_use_<?=$intNo?>" value="Y" <?=($aryBusiItemList[$k][JI_USE] == "N") ? "":"checked";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_nes_<?=$intNo?>" id="item_nes_<?=$intNo?>" value="Y" <?=($aryBusiItemList[$k][JI_NES] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_join_<?=$intNo?>" id="item_join_<?=$intNo?>" value="Y" <?=($aryBusiItemList[$k][JI_JOIN] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_mypage_<?=$intNo?>" id="item_mypage_<?=$intNo?>" value="Y" <?=($aryBusiItemList[$k][JI_MYPAGE] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td>
			<?
				if (is_array($aryMemberGroup)){
					for($i=0;$i<sizeof($aryMemberGroup);$i++){
						$strChecked = "";
						if (is_array($aryGroup)){
							for($j=0;$j<sizeof($aryGroup);$j++){
								if ($aryGroup[$j] == $aryMemberGroup[$i][G_CODE]) {
									$strChecked = "checked";
									break;
								}
							}
						}
						
						echo "&nbsp;&nbsp;<input type=\"checkbox\" name=\"item_grade_".$intNo."[]\" id=\"item_grade_".$intNo."[]\" value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strChecked." ".$strDisabled.">".$aryMemberGroup[$i][G_NAME];
					}
				}
			?>
			</td>
		</tr>
		<?}?>
	</table>


	<table class="tableList">
		<colgroup>
			<col width="200px"/>
			<col width="100px"/>
			<col/>
			<col width="100px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col/>
		</colgroup>
			<th><?=$LNG_TRANS_CHAR["PW00062"]//항목?></th>
			<th><?=$LNG_TRANS_CHAR["PW00094"]//사용여부?></th>
			<!--<th>순서</th>//-->
			<th><?=$LNG_TRANS_CHAR["MW00261"]//입력형식?></th>
			<th><?=$LNG_TRANS_CHAR["MW00257"]//필수체크사항?></th>
			<th><?=$LNG_TRANS_CHAR["MW00258"]//회원가입?></th>
			<th><?=$LNG_TRANS_CHAR["MW00259"]//마이페이지?></th>
			<th><?=$LNG_TRANS_CHAR["MW00260"]//회원등급?></th>
		</tr>
		<?
		for($k=0;$k<sizeof($aryAddItemList);$k++){
			$intNo = $aryAddItemList[$k][JI_NO];
			
			$strDisabled = ($aryAddItemList[$k][JI_USE] == "A") ? "disabled":"";
			$aryGroup = explode("/",$aryAddItemList[$k][JI_GRADE]);
		?>
		<tr>
			<td><?=$aryAddItemList[$k][JI_NAME_KR]?></td>
			<td><input type="checkbox" name="item_use_<?=$intNo?>" id="item_use_<?=$intNo?>" value="Y" <?=($aryAddItemList[$k][JI_USE] == "N") ? "":"checked";?> <?=$strDisabled?>></td>
			<td>
				<?if ($aryAddItemList[$k][JI_CODE] == "ADD_CONCERN"){?>
				<input type="radio" name="item_type_<?=$intNo?>" id="item_type_<?=$intNo?>" value="T" <?=($aryAddItemList[$k][JI_TYPE] == "T") ? "checked":"";?>><?=$LNG_TRANS_CHAR["GW00002"]//입력필드?>
				<input type="radio" name="item_type_<?=$intNo?>" id="item_type_<?=$intNo?>" value="R" <?=($aryAddItemList[$k][JI_TYPE] == "R") ? "checked":"";?>><?=$LNG_TRANS_CHAR["GW00003"]//라디오박스?>
				<input type="radio" name="item_type_<?=$intNo?>" id="item_type_<?=$intNo?>" value="C" <?=($aryAddItemList[$k][JI_TYPE] == "C") ? "checked":"";?>><?=$LNG_TRANS_CHAR["GW00004"]//체크박스?>
				<input type="radio" name="item_type_<?=$intNo?>" id="item_type_<?=$intNo?>" value="S" <?=($aryAddItemList[$k][JI_TYPE] == "S") ? "checked":"";?>><?=$LNG_TRANS_CHAR["GW00005"]//콤보박스?>
				<?}?>
			</td>
			<td><input type="checkbox" name="item_nes_<?=$intNo?>" id="item_nes_<?=$intNo?>" value="Y" <?=($aryAddItemList[$k][JI_NES] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_join_<?=$intNo?>" id="item_join_<?=$intNo?>" value="Y" <?=($aryAddItemList[$k][JI_JOIN] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_mypage_<?=$intNo?>" id="item_mypage_<?=$intNo?>" value="Y" <?=($aryAddItemList[$k][JI_MYPAGE] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td>
			<?
				if (is_array($aryMemberGroup)){
					for($i=0;$i<sizeof($aryMemberGroup);$i++){
						$strChecked = "";
						if (is_array($aryGroup)){
							for($j=0;$j<sizeof($aryGroup);$j++){
								if ($aryGroup[$j] == $aryMemberGroup[$i][G_CODE]) {
									$strChecked = "checked";
									break;
								}
							}
						}
						
						echo "&nbsp;&nbsp;<input type=\"checkbox\" name=\"item_grade_".$intNo."[]\" id=\"item_grade_".$intNo."[]\" value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strChecked." ".$strDisabled.">".$aryMemberGroup[$i][G_NAME];
					}
				}
			?>
			</td>
		</tr>
		<?}?>
	</table>

	<table class="tableList">
		<colgroup>
			<col width="200px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col width="100px"/>
			<col/>
		</colgroup>
		<tr>
			<th><?=$LNG_TRANS_CHAR["PW00062"]//항목?></th>
			<th><?=$LNG_TRANS_CHAR["PW00094"]//사용여부?></th>
			<!--<th>순서</th>//-->
			<th><?=$LNG_TRANS_CHAR["MW00257"]//필수체크사항?></th>
			<th><?=$LNG_TRANS_CHAR["MW00258"]//회원가입?></th>
			<th><?=$LNG_TRANS_CHAR["MW00259"]//마이페이지?></th>
			<th><?=$LNG_TRANS_CHAR["MW00260"]//회원등급?></th>
		</tr>
		<?
		for($k=0;$k<sizeof($aryTempItemList);$k++){
			$intNo = $aryTempItemList[$k][JI_NO];
			
			$strDisabled = ($aryTempItemList[$k][JI_USE] == "A") ? "disabled":"";
			$aryGroup = explode("/",$aryTempItemList[$k][JI_GRADE]);
		?>
		<tr>
			<td class="alignLeft">
				<ul>
					<?for($i=0;$i<sizeof($aryUseLng);$i++){?>
							<li>
							<?=$S_ARY_COUNTRY[$aryUseLng[$i]]?> : <input type="text" name="item_name_<?=$aryUseLng[$i]?>_<?=$intNo?>" id="item_name_<?=$aryUseLng[$i]?>_<?=$intNo?>" value="<?=$aryTempItemList[$k]["JI_NAME_".$aryUseLng[$i]]?>">
							</li>
					<?}?>
				</ul>
			</td>
			<td><input type="checkbox" name="item_use_<?=$intNo?>" id="item_use_<?=$intNo?>" value="Y" <?=($aryTempItemList[$k][JI_USE] == "N") ? "":"checked";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_nes_<?=$intNo?>" id="item_nes_<?=$intNo?>" value="Y" <?=($aryTempItemList[$k][JI_NES] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_join_<?=$intNo?>" id="item_join_<?=$intNo?>" value="Y" <?=($aryTempItemList[$k][JI_JOIN] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td><input type="checkbox" name="item_mypage_<?=$intNo?>" id="item_mypage_<?=$intNo?>" value="Y" <?=($aryTempItemList[$k][JI_MYPAGE] == "Y") ? "checked":"";?> <?=$strDisabled?>></td>
			<td>
			<?
				if (is_array($aryMemberGroup)){
					for($i=0;$i<sizeof($aryMemberGroup);$i++){
						$strChecked = "";
						if (is_array($aryGroup)){
							for($j=0;$j<sizeof($aryGroup);$j++){
								if ($aryGroup[$j] == $aryMemberGroup[$i][G_CODE]) {
									$strChecked = "checked";
									break;
								}
							}
						}
						
						echo "&nbsp;&nbsp;<input type=\"checkbox\" name=\"item_grade_".$intNo."[]\" id=\"item_grade_".$intNo."[]\" value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strChecked." ".$strDisabled.">".$aryMemberGroup[$i][G_NAME];
					}
				}
			?>
			</td>
		</tr>
		<?}?>
	</table>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:javascript:goJoinItemSave();" id="menu_auth_m" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	<a class="btn_new_gray" href="#"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->