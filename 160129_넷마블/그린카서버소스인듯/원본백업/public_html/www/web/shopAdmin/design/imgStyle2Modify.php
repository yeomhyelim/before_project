<? 
	if($row['BI_IMAGE_FILE_1']) :
		$strBI_IMAGE_FILE_1 = "<img src='"  . "/upload/designbtnimg/" . $row['BI_IMAGE_FILE_1'] . "' />";
	endif;
?>
<input type="text" name="bi_group" 		value="<?= $strBI_GROUP ?>" />
<input type="text" name="bi_image_cate" 	value="<?= $designRow['DM_DESIGN_GROUP'] ?>" />
<input type="text" name="bi_atatch_type" 	value="I" />
<input type="text" name="bi_image_file_1" 	value="<?= $row['BI_IMAGE_FILE_1'] ?>" />

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
					<option <?= $row['BI_IMAGE_GUBUN'] == "버튼" 		? "selected" : "" ?>>버튼</option>
					<option <?= $row['BI_IMAGE_GUBUN'] == "아이콘" 	? "selected" : "" ?> >아이콘</option>
					<option <?= $row['BI_IMAGE_GUBUN'] == "기타" 		? "selected" : "" ?> >기타</option>
				</select>
			</td>
		<tr>
			<th>이미지</th>
			<td><input type="file" name="bi_image_file_1_new" /><div class="attachImg"><?= $strBI_IMAGE_FILE_1 ?></div></td>
		</tr>
	</table>
	<div class="buttonWrap">
		<a class="btn_big" href="javascript:goImgStyle2Act('imgStyle2Update');" id="menu_auth_m"><strong>등록</strong></a>
		<a class="btn_big" href="?menuType=design&mode=imgstyle2&bi_image_cate=<?= $designRow['DM_DESIGN_GROUP'] ?>" id="menu_auth_m"><strong>목록</strong></a>
	</div>
</div>
