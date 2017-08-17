<input type="text" name="bi_group" 		value="<?= $strBI_GROUP ?>" />
<input type="text" name="bi_image_cate" 	value="<?= $strBI_IMAGE_CATE ?>" />
<input type="text" name="bi_atatch_type" 	value="I" />

<div class="contentTop">
	<h2>커뮤니티 등록</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>이미지 그룹</th>
			<td><?= $designRow['DM_DESIGN_TITLE'] ?></td>
		</tr>
		<tr>
			<th>타입</th>
			<td>
				<select name="bi_image_gubun" >
					<option>버튼</option>
					<option>아이콘</option>
					<option>기타</option>
				</select>
			</td>
		<tr>
			<th>이미지</th>
			<td><input type="file" name="bi_image_file_1_new" />
		</tr>
	</table>
	<div class="buttonWrap">
		<a class="btn_big" href="javascript:goImgStyle2Act('imgStyle2Write');" id="menu_auth_m"><strong>등록</strong></a>
		<a class="btn_big" href="javascript:history.back()" id="menu_auth_m"><strong>취소</strong></a>
	</div>
</div>
