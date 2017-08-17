<h3>커뮤니티 카테고리 등록</h3>
<table>
	<tr>
		<th>이름</th>
		<td>
			<input type="text" name="bc_name" id="bc_name" value="<?=$categoryListRow['BC_NAME']?>" style="width:300px"/>
		</td>
	</tr>
	<tr>
		<th>정렬</th>
		<td>
			<input type="text" name="bc_sort" id="bc_sort" value="<?=$categoryListRow['BC_SORT']?>" style="width:150px"/>
		</td>
	</tr>
	<tr>
		<th>이미지1</th>
		<td>
			<input type="file" name="bc_image_1" id="bc_image_1"/>
			<? if($categoryListRow['BC_IMAGE_1']): ?>
			<input type="checkbox" id="bc_image_1_del" name="bc_image_1_del" value="Y"/> 기존 이미지 삭제
			<img src="<?=$_REQUEST['bc_image_1_wpath'].$categoryListRow['BC_IMAGE_1']?>" style="height:50px"/>
			<? endif;?>
		</td>
	</tr>
	<tr>
		<th>이미지2</th>
		<td>
			<input type="file" name="bc_image_2" id="bc_image_2"/>
			<? if($categoryListRow['BC_IMAGE_2']): ?>
			<input type="checkbox" id="bc_image_2_del" name="bc_image_2_del" value="Y"/> 기존 이미지 삭제
			<img src="<?=$_REQUEST['bc_image_2_wpath'].$categoryListRow['BC_IMAGE_2']?>" style="height:50px"/>
			<? endif;?>
		</td>
	</tr>
</table>