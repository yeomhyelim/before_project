	<div class="contentTop">
		<h2>추가페이지 관리</h2>
	</div>
	<br>

	<!-- ******** 컨텐츠 ********* -->	
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:50px;"/>
				<col style="width:150px;"/>
				<col/>
				<col/>
				<col/>
				<col/>
			</colgroup>
			<tr>
				<th>번호</th>
				<th>메뉴그룹</th>
				<th>페이지명</th>
				<th>접근권한</th>
				<th>링크</th>
				<th>관리</th>
			</tr>
			<!-- (1) -->
			<?if($intTotal=="0"){?>
				<tr>
					<td colspan="9">등록된 데이터가 없습니다.</td>
				</tr>		
			<?}?>
			<?
				while($row = mysql_fetch_array($result)){
					
			?>
			<tr>
				<td><?=$intListNum--?></td>
				<td></td>
				<td>{{<?=$row[CP_PAGE_NAME]?>}}</td>
				<td></td>
				<td><?=$row[CP_PAGE_URL]?></td>
				<td>
					 <a class="btn_blue_sml" href="javascript:goMoveUrl('contentModify',<?=$row[CP_NO]?>)" id="menu_auth_m" ><strong>수정</strong></a> 
					 <a class="btn_sml" href="javascript:goMoveUrl('contentDelete',<?=$row[CP_NO]?>);" id="menu_auth_d"><strong>삭제</strong></a> 
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

	<div class="buttonWrap">
		<a class="btn_blue_big" href="./?menuType=design&mode=contentWrite" id="menu_auth_m"><strong>페이지 추가</strong></a>
	</div>
	