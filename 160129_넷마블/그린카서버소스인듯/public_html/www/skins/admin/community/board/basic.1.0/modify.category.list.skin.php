	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col />
			<col width=200/>
			<col width=200/>
			<col width=100/>
			<col width=200/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>이름</th>
			<th>이미지1</th>
			<th>이미지2</th>
			<th>정렬</th>
			<th>설정</th>
		</tr>
		<? if($boardView->field['list_total'] <= 0) : ?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($categoryListResult)) : ?>
		<tr>
			<td><?=$_REQUEST['list_total']['CategoryMgr']--?></td>
			<td><?=$row['BC_NAME']?></td>
			<td>
				<?if($row['BC_IMAGE_1']):?>
				<img src="<?=$_REQUEST['bc_image_1_wpath'].$row['BC_IMAGE_1']?>" style="width:100px" />
				<?endif;?>
			</td>
			<td>
				<?if($row['BC_IMAGE_2']):?>
				<img src="<?=$_REQUEST['bc_image_2_wpath'].$row['BC_IMAGE_2']?>" style="width:100px" />
				<?endif;?>
			</td>
			<td><?=$row['BC_SORT']?></td>
			<td><a href="javascript:goCategoryModifyMoveEvent('<?=$row['BC_NO']?>')" class="btn_blue_sml" id="menu_auth_m" style="display:none"><strong>수정</strong></a>
				<a href="javascript:goCategoryDeleteActEvent('<?=$row['BC_NO']?>')" class="btn_blue_sml" id="menu_auth_d" style="display:none"><strong>삭제</strong></a></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>
