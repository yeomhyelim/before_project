<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["EW00001"] //팝업관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<input type="checkbox" name="searchStatusY" id="searchStatusY" value="Y" <?=($strSearchStatusY=="Y")?"checked":"";?>> <?=$LNG_TRANS_CHAR["EW00002"] //진행중?>
			<input type="checkbox" name="searchStatusN" id="searchStatusN" value="N" <?=($strSearchStatusN=="N")?"checked":"";?> style="margin-left:10px;"> <?=$LNG_TRANS_CHAR["EW00003"] //종료?>
			<input type="text" name="searchKey" id="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> style="width:440px;"/>
			<a class="btn_blue_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchTableWrap -->
	</div>

	<br>
	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col style="width:8%;">
				<col style="width:8%;">
				<col />
				<col style="width:34%;">
				<col style="width:18%;">
				<col style="width:18%;">
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["EW00004"] //상태?></th>
				<th><?=$LNG_TRANS_CHAR["EW00005"] //제목?></th>
				<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
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
					<span><em><?=($row[PO_STATUS]=="Y")?$LNG_TRANS_CHAR["EW00002"]:$LNG_TRANS_CHAR["EW00003"]; //"진행중":"종료";?></em></span>
				</td>
				<td><?=$row[PO_TITLE]?></td>
				<td><?=$row[PO_REG_DT]?></td>
				<td>
					<a class="btn_blue_sml" href="javascript:goMoveUrl('popupModify',<?=$row[PO_NO]?>)" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
					<a class="btn_sml" href="javascript:goMoveUrl('popupDelete',<?=$row[PO_NO]?>);" id="menu_auth_d" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<?
				}
			?>
		</table>
	</div>
	<!-- tableList -->
	<div style="padding: 10px 0;">
		<div style="float:left;margin-top:3px;">
			<a class="btn_blue_big" href="javascript:goMoveUrl('popupWrite');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00028"] //팝업추가?></strong></a>
		</div>

		<!-- Pagenate object --> 
			<div class="paginate" style="float:right;width:400px;padding:0px 5px;text-align:right;">  
				<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
			</div>  
		<!-- Pagenate object -->
		<div class="clr"></div>
	</div>

</div>
