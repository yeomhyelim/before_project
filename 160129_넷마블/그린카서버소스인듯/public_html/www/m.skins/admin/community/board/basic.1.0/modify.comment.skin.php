<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 코멘트 옵션</h3>
	<table>
		<tr>
			<th>코멘트 사용</th>
			<td>
				<input type="radio" name="bi_comment_use" value="B"<?if($boardInfoAry['BI_COMMENT_USE']=="B"){echo " checked";}?>> 일반 코멘트
				<input type="radio" name="bi_comment_use" value="S"<?if($boardInfoAry['BI_COMMENT_USE']=="S"){echo " checked";}?>> 소셜 코멘트
				<input type="radio" name="bi_comment_use" value="N"<?if($boardInfoAry['BI_COMMENT_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>사용 권한</th>
			<td>
				<input type="checkbox" name="bi_comment_nonmember_use" value="Y"<?if($boardInfoAry['BI_COMMENT_NONMEMBER_USE']=="Y"){echo " checked";}?>> 비회원 사용
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->