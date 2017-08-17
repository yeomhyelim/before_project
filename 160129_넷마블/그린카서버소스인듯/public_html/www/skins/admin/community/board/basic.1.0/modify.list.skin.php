<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 리스트 옵션</h3>
	<table>
		<tr>
			<th>리스트 사용</th>
			<td>
				<input type="radio" name="bi_datalist_use" value="Y"<?if($boardInfoAry['BI_DATALIST_USE']=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_datalist_use" value="N"<?if($boardInfoAry['BI_DATALIST_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
		<tr>
			<th>사용 권한</th>
			<td>
				<input type="checkbox" name="bi_datalist_nonmember_use" value="Y"<?if($boardInfoAry['BI_DATALIST_NONMEMBER_USE']=="Y"){echo " checked";}?>> 비회원 사용
			
			</td>
		</tr>
		<tr>
			<th>세로줄 수</th>
			<td>
				<input type="text" name="bi_column_default" value="<?=$boardInfoAry['BI_COLUMN_DEFAULT']?>" style="width:50px;"> 개
			</td>
		</tr>
		<tr>
			<th>리스트 수</th>
			<td>
				<input type="text" name="bi_list_default" value="<?=$boardInfoAry['BI_LIST_DEFAULT']?>" style="width:50px;"> 개
			</td>
		</tr>
		<tr>
			<th>페이지 수</th>
			<td>
				<input type="text" name="bi_page_default" value="<?=$boardInfoAry['BI_PAGE_DEFAULT']?>" style="width:50px;"> 개
			</td>
		</tr>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->