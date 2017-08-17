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
			<th style="width:50px"><input type="checkbox"></th>
			<th style="width:100px">이름</th>
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
			<td style="text-align:left"><ul>
											<li>
												<div class="left" style=width:100px;">필드 종류</div>
												<div  class="left">
													:	<select name="bi_userfield_kind[<?=$s?>]">
															<option value="phone"<?if($boardInfoAry["BI_USERFIELD_KIND_$s"]=="phone"){echo " selected";}?>>연락처</option>
														</select>
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">관리자 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_onlyadmin[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ONLYADMIN_$s"]=="Y"){echo " checked";}?>> 관리자 전용
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필수 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_essential[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ESSENTIAL_$s"]=="Y"){echo " checked";}?>> 필수 입력 받음
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필드명</div>
												<div  class="left">
													: <input type="text" name="bi_userfield_name[<?=$s?>]" style="width:100px" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>">
												</div>
												<div class="clr"></div>
											</li>
										</ul></td>
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
			<td style="text-align:left"><ul>
											<li>
												<div class="left" style=width:100px;">필드 종류</div>
												<div  class="left">
													:	<select name="bi_userfield_kind[<?=$s?>]">
															<option value="address"<?if($boardInfoAry["BI_USERFIELD_KIND_$s"]=="address"){echo " selected";}?>>주소</option>
														</select>
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">관리자 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_onlyadmin[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ONLYADMIN_$s"]=="Y"){echo " checked";}?>> 관리자 전용
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필수 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_essential[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ESSENTIAL_$s"]=="Y"){echo " checked";}?>> 필수 입력 받음
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필드명</div>
												<div  class="left">
													: <input type="text" name="bi_userfield_name[<?=$s?>]" style="width:100px" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>">
												</div>
												<div class="clr"></div>
											</li>
										</ul></td>
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
			<td style="text-align:left"><ul>
											<li>
												<div class="left" style=width:100px;">필드 종류</div>
												<div  class="left">
													:	<select name="bi_userfield_kind[<?=$s?>]">
															<option value="companyName"<?if($boardInfoAry["BI_USERFIELD_KIND_$s"]=="companyName"){echo " selected";}?>>회사이름</option>
														</select>
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">관리자 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_onlyadmin[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ONLYADMIN_$s"]=="Y"){echo " checked";}?>> 관리자 전용
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필수 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_essential[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ESSENTIAL_$s"]=="Y"){echo " checked";}?>> 필수 입력 받음
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필드명</div>
												<div  class="left">
													: <input type="text" name="bi_userfield_name[<?=$s?>]" style="width:100px" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>">
												</div>
												<div class="clr"></div>
											</li>
										</ul></td>
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
			<td style="text-align:left"><ul>
											<li>
												<div class="left" style=width:100px;">필드 종류</div>
												<div  class="left">
													:	<select name="bi_userfield_kind[<?=$s?>]">
															<option value="text"<?if($boardInfoAry["BI_USERFIELD_KIND_$s"]=="text"){echo " selected";}?>>입력박스</option>
															<option value="select"<?if($boardInfoAry["BI_USERFIELD_KIND_$s"]=="select"){echo " selected";}?>>선택박스</option>
														</select>
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">관리자 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_onlyadmin[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ONLYADMIN_$s"]=="Y"){echo " checked";}?>> 관리자 전용
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필수 옵션</div>
												<div  class="left">
													: <input type="checkbox" name="bi_userfield_essential[<?=$s?>]" value="Y"<?if($boardInfoAry["BI_USERFIELD_ESSENTIAL_$s"]=="Y"){echo " checked";}?>> 필수 입력 받음
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필드명</div>
												<div  class="left">
													: <input type="text" name="bi_userfield_name[<?=$s?>]" style="width:100px;" value="<?=$boardInfoAry["BI_USERFIELD_NAME_$s"]?>">
												</div>
												<div class="clr"></div>
											</li>
											<li>
												<div class="left" style=width:100px;">필드 데이터</div>
												<div  class="left">
													: <input type="text" name="bi_userfield_kind_name[<?=$s?>]" style="width:400px" value="<?=$boardInfoAry["BI_USERFIELD_KIND_NAME_$s"]?>">
												</div>
												<div class="clr"></div>
											</li>
										</ul></td>
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