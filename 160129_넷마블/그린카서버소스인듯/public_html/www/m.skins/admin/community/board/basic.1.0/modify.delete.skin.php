<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 삭제/기타 옵션</h3>
	<table>
		<tr>
			<th>삭제/기타 사용</th>
			<td>
				<input type="radio" name="bi_datadelete_use" value="Y"<?if($boardInfoAry['BI_DATADELETE_USE']=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_datadelete_use" value="N"<?if($boardInfoAry['BI_DATADELETE_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>사용 권한</th>
			<td>
				<input type="checkbox" name="bi_datadelete_nonmember_use" value="Y"<?if($boardInfoAry['BI_DATADELETE_NONMEMBER_USE']=="Y"){echo " checked";}?>> 비회원 사용
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->