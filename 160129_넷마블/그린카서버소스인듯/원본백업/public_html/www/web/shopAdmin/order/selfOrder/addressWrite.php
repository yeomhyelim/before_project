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
					<input type="text" name="ha_ag_name" id="ha_ag_name" value="이음샵" style="">
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
					<input type="text" name="ha_name" id="ha_name" value="홍길동" style="">
				</td>
			</tr>
			<tr>
				<th>주소</th>
				<td>
					<input type="text" name="ha_zip_1" id="ha_zip_1" value="123" style="width:50px">-
					<input type="text" name="ha_zip_2" id="ha_zip_2" value="456" style="width:50px">
					<a class="btn_sml" href="javascript:goZipCodeList();"><strong>우편번호</strong></a><br><br>
					<input type="text" name="ha_addr1" id="ha_addr1" value="서울시 가산동 금천구 IT타워" style="width:500px"><br><br>
					<input type="text" name="ha_addr2" id="ha_addr2" value="156-1번지 가동 1001호" style="width:500px">
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td>
					<input type="text" name="ha_email_1" id="ha_email_1" value="thav" style=""> @ 
					<input type="text" name="ha_email_2" id="ha_email_2" value="naver.com" style="">
				</td>
			</tr>
			<tr>
				<th>연락처</th>
				<td>
					<input type="text" name="ha_phone1_1" id="ha_phone1_1" value="123" style="width:50px"> - 
					<input type="text" name="ha_phone1_2" id="ha_phone1_2" value="456" style="width:50px"> - 
					<input type="text" name="ha_phone1_3" id="ha_phone1_3" value="789" style="width:50px">
				</td>
			</tr>
			<tr>
				<th>휴대폰</th>
				<td>
					<input type="text" name="ha_phone2_1" id="ha_phone2_1" value="111" style="width:50px"> - 
					<input type="text" name="ha_phone2_2" id="ha_phone2_2" value="222" style="width:50px"> - 
					<input type="text" name="ha_phone2_3" id="ha_phone2_3" value="333" style="width:50px">
				</td>
			</tr>
			<tr>
				<th>메모</th>
				<td>
					<textarea name="ha_memo" style="width:500px;height:100px;">지금은 테스트 중입니다.</textarea>
				</td>
			</tr>
		</table>
	</div>
	<!-- tableList -->


	<!-- Pagenate object --> 
	<a class="btn_big" href="javascript:goAddressWriteAct();"><strong>주소록 등록</strong></a>
	<a class="btn_big" href="javascript:goAddressListMove();"><strong>목록</strong></a>
</div>
