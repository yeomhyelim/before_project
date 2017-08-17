<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 쓰기/수정 옵션</h3>
	<table>
		<tr>
			<th>쓰기/수정 사용</th>
			<td>
				<input type="radio" name="bi_datawrite_use" value="Y"<?if($boardInfoAry['BI_DATAWRITE_USE']=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_datawrite_use" value="N"<?if($boardInfoAry['BI_DATAWRITE_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>사용 권한</th>
			<td>
				<input type="checkbox" name="bi_datawrite_nonmember_use" value="Y"<?if($boardInfoAry['BI_DATAWRITE_NONMEMBER_USE']=="Y"){echo " checked";}?>> 비회원 사용
			</td>
		</tr>
		<tr>
			<th>공지글 사용</th>
			<td>
				<input type="radio" name="bi_datawrite_notice_use" value="Y"<?if($boardInfoAry['BI_DATAWRITE_NOTICE_USE']=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_datawrite_notice_use" value="N"<?if($boardInfoAry['BI_DATAWRITE_NOTICE_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>비밀글 사용</th>
			<td>
				<input type="radio" name="bi_datawrite_lock_use" value="C"<?if($boardInfoAry['BI_DATAWRITE_LOCK_USE']=="C"){echo " checked";}?>> 사용(사용자 선택)
				<input type="radio" name="bi_datawrite_lock_use" value="E"<?if($boardInfoAry['BI_DATAWRITE_LOCK_USE']=="E"){echo " checked";}?>> 사용(무조건)
				<input type="radio" name="bi_datawrite_lock_use" value="N"<?if($boardInfoAry['BI_DATAWRITE_LOCK_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>아이콘 사용</th>
			<td>
				<input type="radio" name="bi_datawrite_icon_use" value="Y"<?if($boardInfoAry['BI_DATAWRITE_ICON_USE']=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_datawrite_icon_use" value="N"<?if($boardInfoAry['BI_DATAWRITE_ICON_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>글쓰기 폼</th>
			<td>
				<select name="bi_datawrite_form">
					<option value="textWrite"<?if($boardInfoAry['BI_DATAWRITE_FORM']=="textWrite"){echo " selected";}?>>텍스트 글쓰기</option>
					<option value="higheditor_full"<?if($boardInfoAry['BI_DATAWRITE_FORM']=="higheditor_full"){echo " selected";}?>>에디터 글쓰기</option>
				</select>
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->