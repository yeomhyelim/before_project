<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 보기 옵션</h3>
	<table>
		<tr>
			<th>보기 사용</th>
			<td>
				<input type="radio" name="bi_dataview_use" value="Y"<?if($boardInfoAry['BI_DATAVIEW_USE']=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_dataview_use" value="N"<?if($boardInfoAry['BI_DATAVIEW_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>사용 권한</th>
			<td>
				<input type="checkbox" name="bi_dataview_nonmember_use" value="Y"<?if($boardInfoAry['BI_DATAVIEW_NONMEMBER_USE']=="Y"){echo " checked";}?>> 비회원 사용
			</td>
		</tr>
		<tr>
			<th>SNS 사용</th>
			<td>
				<input type="checkbox" name="bi_dataview_twitter_use"  value="Y"<?if($boardInfoAry['BI_DATAVIEW_TWITTER_USE']=="Y"){echo " checked";}?>> 트위터 사용
				<input type="checkbox" name="bi_dataview_facebook_use" value="Y"<?if($boardInfoAry['BI_DATAVIEW_FACEBOOK_USE']=="Y"){echo " checked";}?>> 페이스북 사용
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->