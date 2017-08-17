
<h3>커뮤니티 첨부파일 옵션</h3>
<table>
	<tr>
		<th>첨부파일 사용</th>
		<td>
			<select name="bi_attachedfile_use" id="bi_attachedfile_use">
				<option value="0"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="0"){echo " selected";}?>>사용 안함</option>
				<option value="1"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="1"){echo " selected";}?>>1개 첨부파일 사용</option>
				<option value="2"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="2"){echo " selected";}?>>2개 첨부파일 사용</option>
				<option value="3"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="3"){echo " selected";}?>>3개 첨부파일 사용</option>
				<option value="4"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="4"){echo " selected";}?>>4개 첨부파일 사용</option>
				<option value="5"<?if($boardInfoAry['BI_ATTACHEDFILE_USE']=="5"){echo " selected";}?>>5개 첨부파일 사용</option>
			</select>
		</td>
	</tr>
</table>

<br>

<table>
	<?for($i=0;$i<5;$i++):?>
	<tr>
		<th>첨부파일<?=$i+1?> 이름</th>
		<td>
			<input type="text" name="bi_attachedfile_name[<?=$i?>]" id="" value="<?=$boardInfoAry["BI_ATTACHEDFILE_NAME_{$i}"]?>" style="width:200px" />
		</td>
	</tr>
	<tr>
		<th>첨부파일<?=$i+1?> 형식</th>
		<td>
			<select name="bi_attachedfile_key[<?=$i?>]" id="" style="width:200px">
				<option value="file"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="file"){echo " selected";}?>>설정없음</option>
				<option value="listImage"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="listImage"){echo " selected";}?>>리스트이미지</option>
				<option value="bigImage"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="bigImage"){echo " selected";}?>>큰이미지</option>
				<option value="image"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="image"){echo " selected";}?>>이미지</option>
				<option value="movie"<?if($boardInfoAry["BI_ATTACHEDFILE_KEY_{$i}"]=="movie"){echo " selected";}?>>동영상</option>
			</select>
		</td>
	</tr>
	<?endfor;?>
</table>

