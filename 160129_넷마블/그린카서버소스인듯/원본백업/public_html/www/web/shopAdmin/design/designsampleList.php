	<div class="contentTop">
		<h2>디자인 샘플 관리</h2>
	</div>
	<br>

	<!-- ******** 컨텐츠 ********* -->	
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col style="width:50px;"/>
				<col style="width:100px;"/>
				<col style="width:100px;"/>
				<col style="width:100px;"/>
				<col/>
				<col/>
				<col/>
			</colgroup>
			<tr>
				<th>번호</th>
				<th>디자인그룹</th>
				<th>디자인타입</th>
				<th>디자인코드</th>
				<th>페이지명</th>
				<th>디자인</th>
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
				<td><?=$row[DM_DESIGN_GROUP]?></td>
				<td><?=$row[DM_DESIGN_TYPE]?></td>
				<td><?=$row[DM_DESIGN_CODE]?></td>
				<td><?=$row[DM_DESIGN_TITLE]?></td>
				<td></td>
				<td>
					 <a class="btn_blue_sml" href="javascript:goMoveUrl('designsampleModify',<?=$row[DM_NO]?>)" id="menu_auth_m" ><strong>수정</strong></a>  
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
		<a class="btn_blue_big" href="./?menuType=design&mode=designsampleWrite" id="menu_auth_m"><strong>페이지 추가</strong></a>
	</div>
	