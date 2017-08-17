<div id="contentArea">
	<div class="contentTop">
		<h2>공통관리</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th>광고명</th>
				<td colspan="3">
					<input type="text" <?=$nBox?> name="searchKey" id="searchKey" style="width:180px;" value="<?=$strSearchKey?>">
					<a class="btn_big" href="javascript:goSearch();"><strong>검색</strong></a>
				</td>
			</tr>
		</table>
	</div>
	<br>
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:50px;"/>
				<col />
				<col style="width:150px;"/>
				<col style="width:150px;"/>
			</colgroup>
			<tr>
				<th>번호</th>
				<th>제목</th>
				<th>등록일</th>
				<th>관리</th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
			<tr>
				<td colspan="6">등록된 데이터가 없습니다.</td>
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
					 <a class="btn_sml" href="javascript:goMoveUrl('siteCommModify','<?=$row[SC_NO]?>')" id="menu_auth_m" ><strong>수정</strong></a> 
					 <a class="btn_sml" href="javascript:goMoveUrl('siteCommDelete','<?=$row[SC_NO]?>');" id="menu_auth_d"><strong>삭제</strong></a> 
				</td>
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
	<div style="text-align:left;margin-top:3px;">
		<a class="btn_blue_big" href="javascript:goMoveUrl('siteCommWrite');" id="menu_auth_w"><strong>내용추가</strong></a>
	</div>

</div>
