<div id="contentArea">
	<div class="contentTop">
		<h2>주소록 등록</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table style="border-left:1px solid #D2D0D0">
			<tr>
				<th>그룹</th>
				<td>
					<input type="text" name="ha_ag_name" id="ha_ag_name" value="<?=$orderHandAddrRow['AG_NAME']?>" style="">
					<select id="ha_ag_name_select">
						<option>그룹 선택</option>
						<? foreach($aryOrderHandAddrGrpList as $aryGroup): ?>
						<option value='<?=$aryGroup['AG_NAME']?>'><?=$aryGroup['AG_NAME']?></option>
						<? endforeach; ?>
					</select>
					<a class="btn_sml" href="javascript:goAddressGroupList();"><strong>그룹관리</strong></a>
				</td>
			</tr>
			<tr>
				<th>이름</th>
				<td>
					<input type="text" name="ha_name" id="ha_name" value="<?=$orderHandAddrRow['HA_NAME']?>" style="">
				</td>
			</tr>
			<tr>
				<th>주소</th>
				<td>
					<input type="text" name="ha_zip_1" id="ha_zip_1" value="<?=$orderHandAddrRow['HA_ZIP'][0]?>" style="width:50px">-
					<input type="text" name="ha_zip_2" id="ha_zip_2" value="<?=$orderHandAddrRow['HA_ZIP'][1]?>" style="width:50px">
					<a class="btn_sml" href="javascript:goZipCodeList();"><strong>우편번호</strong></a><br><br>
					<input type="text" name="ha_addr1" id="ha_addr1" value="<?=$orderHandAddrRow['HA_ADDR1']?>" style="width:500px"><br><br>
					<input type="text" name="ha_addr2" id="ha_addr2" value="<?=$orderHandAddrRow['HA_ADDR2']?>" style="width:500px">
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td>
					<input type="text" name="ha_email_1" id="ha_email_1" value="<?=$orderHandAddrRow['HA_EMAIL'][0]?>" style=""> @ 
					<input type="text" name="ha_email_2" id="ha_email_2" value="<?=$orderHandAddrRow['HA_EMAIL'][1]?>" style="">
				</td>
			</tr>
			<tr>
				<th>연락처</th>
				<td>
					<input type="text" name="ha_phone1_1" id="ha_phone1_1" value="<?=$orderHandAddrRow['HA_PHONE1'][0]?>" style="width:50px"> - 
					<input type="text" name="ha_phone1_2" id="ha_phone1_2" value="<?=$orderHandAddrRow['HA_PHONE1'][1]?>" style="width:50px"> - 
					<input type="text" name="ha_phone1_3" id="ha_phone1_3" value="<?=$orderHandAddrRow['HA_PHONE1'][2]?>" style="width:50px">
				</td>
			</tr>
			<tr>
				<th>휴대폰</th>
				<td>
					<input type="text" name="ha_phone2_1" id="ha_phone2_1" value="<?=$orderHandAddrRow['HA_PHONE2'][0]?>" style="width:50px"> - 
					<input type="text" name="ha_phone2_2" id="ha_phone2_2" value="<?=$orderHandAddrRow['HA_PHONE2'][1]?>" style="width:50px"> - 
					<input type="text" name="ha_phone2_3" id="ha_phone2_3" value="<?=$orderHandAddrRow['HA_PHONE2'][2]?>" style="width:50px">
				</td>
			</tr>
			<tr>
				<th>메모</th>
				<td>
					<textarea name="ha_memo" style="width:500px;height:100px;"><?=$orderHandAddrRow['HA_MEMO']?></textarea>
				</td>
			</tr>
		</table>
	</div>
	<!-- tableList -->


	<!-- Pagenate object --> 
	<a class="btn_big" href="javascript:goAddressModifyAct();"><strong>주소록 수정</strong></a>
	<a class="btn_big" href="javascript:goAddressListMove();"><strong>목록</strong></a>
</div>
