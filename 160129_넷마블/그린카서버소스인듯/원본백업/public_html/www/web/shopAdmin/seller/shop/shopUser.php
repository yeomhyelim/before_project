
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["SW00046"] //상점 사용자?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["BW00006"]; //회사정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopProduct','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopGrade','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00082"]; //등급 심사 정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSU_NO?>');"><?= $LNG_TRANS_CHAR["SW00083"]; //거래/배송정보 ?></a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSU_NO?>');" class="selected"><?= $LNG_TRANS_CHAR["SW00084"]; //관리자정보 ?></a>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableListWrap mt10">
		<table class="tableList">
			<tr>
				<th><?= $LNG_TRANS_CHAR["CW00009"]; //번호?></th>
				<th><?= $LNG_TRANS_CHAR["SW00026"]; //사용자 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00048"]; //최고관리자여부 ?></th>
				<th><?= $LNG_TRANS_CHAR["CW00026"]; //등록일?></th>
				<th><?= $LNG_TRANS_CHAR["CW00007"]; //관리?></th>
			</tr>
			<?if (is_array($aryShopUserList)){
				for($i=0;$i<sizeof($aryShopUserList);$i++){
					$strM_ID =  ($S_MEM_CERITY == "1") ? $aryShopUserList[$i][M_ID] : $aryShopUserList[$i][M_MAIL]; 
			?>
			<tr>
				<td><?=($i+1)?></td>
				<td><?=$strM_ID?>(<?=$aryShopUserList[$i][M_NAME]?>)</td>
				<td><?=($aryShopUserList[$i][SU_TYPE]=="A")? $LNG_TRANS_CHAR["SW00049"] : $LNG_TRANS_CHAR["SW00050"];?></td>
				<td><?=$aryShopUserList[$i][SU_REG_DT]?></td>
				<td>
					<a class="btn_sml" href="javascript:goMoveUrl('shopUserModify','<?=$aryShopUserList[$i][SU_NO]?>');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goShopUserDelete('<?=$aryShopUserList[$i][SU_NO]?>');" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>

				</td>
			</tr>
			<?
				}
				?>
			
			<?}?>
		</table>
		
	</div>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goMoveUrl('shopUserWrite');" id="menu_auth_w"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	</div>

	
</div>
<!-- ******** 컨텐츠 ********* -->