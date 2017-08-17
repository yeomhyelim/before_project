<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>커뮤니티 추가필드 옵션</h3>
	<table>
		<tr>
			<th>추가필드 사용 유무</th>
			<td>
				<input type="radio" name="bi_userfield_use" value="Y"<?if($boardInfoAry['BI_USERFIELD_USE']=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="bi_userfield_use" value="N"<?if($boardInfoAry['BI_USERFIELD_USE']=="N"){echo " checked";}?>> 사용안함
			</td>
		</tr>
	</table>
	<br>
</div>

<div class="tableList">
	<table>
		<tr>
			<th><input type="checkbox"></th>
			<th>이름</th>
			<th>필드이름</th>
			<th>정렬</th>
			<th>설명</th>
			<th>설정</th>
		</tr>
		<?$sort = 1000;$s=0;?>
		<?for($i=1;$i<=3;$i++):?>
		<tr>
			<td><input type="checkbox"></td>
			<td>연락처<?=$i?></td>
			<td><input type="text" style="width:200px" name="bi_userfield_name[<?=$s?>]" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>"></td>
			<td><input type="text" style="width:50px" name="bi_userfield_sort[<?=$s?>]" value="<?=$boardInfoAry["BI_USERFIELD_SORT_$s"]?>"></td>
			<td>연락처 폼으로 사용 가능합니다.</td>
			<td>
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="Y"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="N"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="N"){echo " checked";}?>> 사용안함				
			</td>
		</tr>
		<?$s++;?>
		<?endfor;?>
		<tr>
			<td><input type="checkbox"></td>
			<td>주소</td>
			<td><input type="text" name="bi_userfield_name[<?=$s?>]" style="width:200px" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>"></td>
			<td><input type="text" name="bi_userfield_sort[<?=$s?>]" style="width:50px" value="<?=$boardInfoAry["BI_USERFIELD_SORT_$s"]?>"></td>
			<td>주소 폼으로 사용 가능합니다.</td>
			<td>
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="Y"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="N"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="N"){echo " checked";}?>> 사용안함				
			</td>
		</tr>
		<?$s++;?>
		<tr>
			<td><input type="checkbox"></td>
			<td>회사이름</td>
			<td><input type="text" name="bi_userfield_name[<?=$s?>]" style="width:200px" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>"></td>
			<td><input type="text" name="bi_userfield_sort[<?=$s?>]" style="width:50px" value="<?=$boardInfoAry["BI_USERFIELD_SORT_$s"]?>"></td>
			<td>회사 폼으로 사용 가능합니다.</td>
			<td>
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="Y"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="N"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="N"){echo " checked";}?>> 사용안함				
			</td>
		</tr>
		<?$s++;?>
		<?for($i=1;$i<=20;$i++):?>
		<tr>
			<td><input type="checkbox"></td>
			<td>임시필드<?=$i?></td>
			<td><input type="text" name="bi_userfield_name[<?=$s?>]" style="width:200px" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>"></td>
			<td><input type="text" name="bi_userfield_sort[<?=$s?>]" style="width:50px" value="<?=$boardInfoAry["BI_USERFIELD_SORT_$s"]?>"></td>
			<td>임시필드 폼으로 사용 가능합니다.</td>
			<td>
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="Y"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="Y"){echo " checked";}?>> 사용
				<input type="radio" name="userfield_field_use[<?=$s?>]" value="N"<?if($boardInfoAry['BI_USERFIELD_FIELD_USE'][$s]=="N"){echo " checked";}?>> 사용안함				
			</td>
		</tr>
		<?$s++;?>
		<?endfor;?>
	</table>
</div>
<!-- ******** 컨텐츠 ********* -->