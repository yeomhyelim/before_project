<!-- ******** 컨텐츠 ********* -->
<h3>커뮤니티 카테고리 옵션</h3>
<table>
	<tr>
		<th>카테고리 사용</th>
		<td>
			<input type="radio" name="bi_category_use" value="Y"<?if($boardInfoAry['BI_CATEGORY_USE']=="Y"){echo " checked";}?>> 사용
			<input type="radio" name="bi_category_use" value="N"<?if($boardInfoAry['BI_CATEGORY_USE']=="N"){echo " checked";}?>> 사용안함
		</td>
	</tr>
	<tr>
		<th>카테고리 노출</th>
		<td>
			<input type="radio" name="bi_category_skin" value="combobox"<?if($boardInfoAry['BI_CATEGORY_SKIN']=="combobox"){echo " checked";}?>/>콤보박스
			<input type="radio" name="bi_category_skin" value="text"<?if($boardInfoAry['BI_CATEGORY_SKIN']=="text"){echo " checked";}?>/>텍스트
			<input type="radio" name="bi_category_skin" value="image"<?if($boardInfoAry['BI_CATEGORY_SKIN']=="image"){echo " checked";}?>/>이미지
		</td>
	</tr>
	<tr>
		<th>카테고리 표시</th>
		<td>
			<input type="checkbox" name="bi_category_list_use" value="Y"<?if($boardInfoAry['BI_CATEGORY_LIST_USE']=="Y"){echo " checked";}?>/> 리스트 화면 상단에 카테고리 사용
		</td>
	</tr>
</table>
<!-- ******** 컨텐츠 ********* -->