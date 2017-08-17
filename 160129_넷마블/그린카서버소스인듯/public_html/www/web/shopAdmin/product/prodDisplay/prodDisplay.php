
<div id="contentArea">
	<!-- 상품수정 스크룰 메뉴 -->
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00092"] //상품진열장?></h2>
		<div class="clr"></div>
	</div>
	<br>
	<div class="tableListWrapBox">
		<div class="leftBox_50">
			<h3><?=$LNG_TRANS_CHAR["PW00027"] //메인 진열정보?></h3>
			<table class="tableList">
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00093"] //진열장?></th>
					<th><?=$LNG_TRANS_CHAR["PW00094"] //사용여부?></th>
				</tr>
				<?for($i=0;$i<sizeof($aryProdMainList);$i++){?>
				<tr>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="displayName_<?=$aryProdMainList[$i][IC_NO]?>" name="displayName_<?=$aryProdMainList[$i][IC_NO]?>" value="<?=$aryProdMainList[$i][IC_NAME]?>"/>
					</td>
					<td>
						<input type="checkbox" id="displayUseYN_<?=$aryProdMainList[$i][IC_NO]?>" name="displayUseYN_<?=$aryProdMainList[$i][IC_NO]?>" value="Y" <?=($aryProdMainList[$i][IC_USE]=="Y")?"checked":"";?>/>
					</td>
				</tr>
				<?}?>
			</table>
		</div>
		<div class="rightBox_50">
			<h3><?=$LNG_TRANS_CHAR["PW00028"] //서브 진열정보?></h3>
			<table class="tableList">
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00093"] //진열장?></th>
					<th><?=$LNG_TRANS_CHAR["PW00094"] //사용여부?></th>
				</tr>
				<?for($i=0;$i<sizeof($aryProdSubList);$i++){?>
				<tr>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="displayName_<?=$aryProdSubList[$i][IC_NO]?>" name="displayName_<?=$aryProdSubList[$i][IC_NO]?>" value="<?=$aryProdSubList[$i][IC_NAME]?>"/>
					</td>
					<td>
						<input type="checkbox" id="displayUseYN_<?=$aryProdSubList[$i][IC_NO]?>" name="displayUseYN_<?=$aryProdSubList[$i][IC_NO]?>" value="Y" <?=($aryProdSubList[$i][IC_USE]=="Y")?"checked":"";?>/>
					</td>
				</tr>
				<?}?>
			</table>
		</div>
		<div class="clr"></div>		
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goProdDisplay();" id="menu_auth_m" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00016"] //저장?></strong></a>
	</div>

	<div class="tableListWrap">
		<h3><?=$LNG_TRANS_CHAR["PW00095"] //아이콘정보?></h3>
		<table id="tabIconList" class="tableList">
			<input type="hidden" id="prodIconNo" name="prodIconNo" value="">
			<?for($i=0;$i<sizeof($aryProdIconList);$i++){?>
			<tr>
				<input type="hidden" id="iconNo[]" name="iconNo[]" value="<?=$aryProdIconList[$i][IC_NO]?>">
				<input type="hidden" id="iconName[]" name="iconName[]" value="<?=$aryProdIconList[$i][IC_NAME]?>">
				<td>
					<?=($aryProdIconList[$i][IC_NAME])?>
					<img src="<?=$aryProdIconList[$i][IC_IMG]?>">
				</td>
				<td>
					<input type="file" name="iconFile[]" <?=$nBox?>  style="width:300px;"/>
				</td>
				<td>
					<?if ($aryProdIconList[$i][IC_NAME] == "사용자정의"){?>
					<a class="btn_sml" href="javascript:goProdIconDel(<?=$aryProdIconList[$i][IC_NO]?>)";><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					<?}else{?>
					<a class="btn_sml" href="javascript:goProdIconRecovery(<?=$aryProdIconList[$i][IC_NO]?>);" id="menu_auth_e1" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00005"] //복원?></strong></a>
					<?}?>
				</td>
			</tr>
			<?}?>
		</table>
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goProdIconAdd();" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
		<a class="btn_new_gray" href="javascript:goProdIconDel();" id="menu_auth_d" style="display:none"><strong class="ico_del"><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
	</div>

</div>
		
	