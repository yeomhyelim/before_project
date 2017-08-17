<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00105"] //공통관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00106"] //제목?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?> name="searchKey" id="searchKey" style="width:180px;" value="<?=$strSearchKey?>">
					<a class="btn_big" href="javascript:goSearch();"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col style="width:50px;"/>
				<col />
				<col style="width:150px;"/>
				<col style="width:150px;"/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["PW00106"] //제목?></th>
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
				<td><a href="javascript:goMoveUrl('siteCommView','<?=$row[SC_NO]?>')" ><?=$row[SC_TITLE]?></a></td>
				<td><?=$row[SC_REG_DT]?></td>
				<td>
					 <a class="btn_sml" href="javascript:goMoveUrl('siteCommModify','<?=$row[SC_NO]?>')" id="menu_auth_m" style="display:none:"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a> 
					 <a class="btn_sml" href="javascript:goMoveUrl('siteCommDelete','<?=$row[SC_NO]?>');" id="menu_auth_d" style="display:none:"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a> 
				</td>
			</tr>
			<?
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
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goMoveUrl('siteCommWrite');" id="menu_auth_w" style="display:none:"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
	</div>

</div>
