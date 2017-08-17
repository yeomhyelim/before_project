
<div id="contentArea">
	<div class="contentTop">
		<h2>수기주문등록</h2>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList">
		<h3>주문상품</h3>
		<table id="prodOrderList" style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=100/>
				<col width=100/>
				<col />
				<col width=100/>
				<col width=100/>
				<col width=150/>
				<col width=150/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th>번호</th>
				<th>상품사진</th>
				<th>상품명</th>
				<th>적립금</th>
				<th>수량</th>
				<th>판매가</th>
				<th>관리</th>
			</tr>
			<textarea id="template" style="display:none;">
			<tr>
				<td><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(tdis.checked)"/></td>
				<td>번호<!--번호--></td>
				<td>상품사진<!--상품사진--></td>
				<td style="text-align:left;padding:0 0 0 10px;"><input type="text" style="width:300px" name="op_p_name[]" id="op_p_name" readonly><!--상품명--></td>
				<td><input type="text" style="width:50px" name="op_p_point[]" id="op_p_point" readonly><!--적립금--></td>
				<td><input type="text" style="width:50px" name="op_p_qty[]" id="op_p_qty"><!--수량--></td>
				<td><input type="text" style="width:50px" name="op_p_sale_price[]" id="op_p_sale_price" readonly><!--판매가--></td>
				<td>
					<input type="hidden" name="op_p_code[]" id="prodOrderPCode"/>
					<a class="btn_sml" onClick="javascript:goProdOrderOptionListPopMove(this);"><strong>옵션변경</strong></a>
					<a class="btn_sml" onClick="goProdOrderDeleteScript(this);"><strong>삭제</strong></a>
				</td>
			</tr>
			</textarea>
		</table><br>
		<a class="btn_big" href="javascript:goProdOrderListPopMove();"><strong>상품선택/추가</strong></a>
	</div>
	

	<div class="tableForm">
		<h3>주문자정보</h3>
		<h3>수령자정보</h3>
		<table style="border-left:1px solid #D2D0D0">
			<tr>
				<td>	
					<table style="border-left:1px solid #D2D0D0">
						<tr>
							<th>회원구분</th>
							<td>
								<input type="radio" name="om_member_type" value="Y" checked> 회원
								<input type="radio" name="om_member_type" value="N" > 비회원
							</td>
						</tr>
						<tr>
							<th>회원 ID</th>
							<td>
								<input type="text"  name="om_o_id"> 
								<a class="btn_sml" href="javascript:goMemberListPopMove();"><strong>회원검색</strong></a>
							</td>
						</tr>
						<tr>
							<th>주문자 이름</th>
							<td>
								<input type="text"  name="om_o_name" id="om_o_name" value="홍길동">
							</td>
						</tr>
						<tr>
							<th>이메일</th>
							<td>
								<input type="text" name="om_o_email_1" id="om_o_email_1" value="thav" style=""> @ 
								<input type="text" name="om_o_email_2" id="om_o_email_2" value="naver.com" style="">
							</td>
						</tr>
						<tr>
							<th>연락처</th>
							<td>
								<input type="text" name="om_o_phone_1" id="om_o_phone_1" value="123" style="width:50px"> - 
								<input type="text" name="om_o_phone_2" id="om_o_phone_2" value="456" style="width:50px"> - 
								<input type="text" name="om_o_phone_3" id="om_o_phone_3" value="789" style="width:50px">
							</td>
						</tr>
						<tr>
							<th>핸드폰</th>
							<td>
								<input type="text" name="om_o_hp_1" id="om_o_hp_1" value="111" style="width:50px"> - 
								<input type="text" name="om_o_hp_2" id="om_o_hp_2" value="222" style="width:50px"> - 
								<input type="text" name="om_o_hp_3" id="om_o_hp_3" value="333" style="width:50px">
							</td>
						</tr>
						<tr>
							<th>주소</th>
							<td>
								<input type="text" name="om_o_zip_1" id="om_o_zip_1" value="123" style="width:50px">-
								<input type="text" name="om_o_zip_2" id="om_o_zip_2" value="456" style="width:50px">
								<a class="btn_sml" href="javascript:goZipCodeListPopMove(1);"><strong>우편번호</strong></a><br><br>
								<input type="text" name="om_o_addr1" id="om_o_addr1" value="서울시 가산동 금천구 IT타워" style="width:400px"><br><br>
								<input type="text" name="om_o_addr2" id="om_o_addr2" value="156-1번지 가동 1001호" style="width:400px">
							</td>
						</tr>
					</table>
				</td>
				<td>
					<table style="border-left:1px solid #D2D0D0">
						<tr>
							<th>배송지 확인</th>
							<td>
								<input type="checkbox" id="orderInfoCopy"> 주문자 정보와 동일함.
							</td>
						</tr>
						<tr>
							<th>배송방법</th>
							<td>
								<select>
									<option>일반택배</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>받는사람 이름</th>
							<td>
								<input type="text" name="om_r_name" id="om_r_name" value="홍길동">
							</td>
						</tr>
						<tr>
							<th>메모</th>
							<td>
								<input type="text" name="om_memo" value="문앞에 두세요." style="width:400px">
							</td>
						</tr>
						<tr>
							<th>연락처</th>
							<td>
								<input type="text" name="om_r_phone_1" id="om_r_phone_1" value="123" style="width:50px"> - 
								<input type="text" name="om_r_phone_2" id="om_r_phone_2" value="456" style="width:50px"> - 
								<input type="text" name="om_r_phone_3" id="om_r_phone_3" value="789" style="width:50px">
							</td>
						</tr>
						<tr>
							<th>핸드폰</th>
							<td>
								<input type="text" name="om_r_hp_1" id="om_r_hp_1" value="111" style="width:50px"> - 
								<input type="text" name="om_r_hp_2" id="om_r_hp_2" value="222" style="width:50px"> - 
								<input type="text" name="om_r_hp_3" id="om_r_hp_3" value="333" style="width:50px">
							</td>
						</tr>
						<tr>
							<th>주소</th>
							<td>
								<input type="text" name="om_r_zip_1" id="om_r_zip_1" value="123" style="width:50px">-
								<input type="text" name="om_r_zip_2" id="om_r_zip_2" value="456" style="width:50px">
								<a class="btn_sml" href="javascript:goZipCodeListPopMove(2);"><strong>우편번호</strong></a>
								<a class="btn_sml" href="javascript:goAddressListPopMove(2);"><strong>주소록</strong></a><br><br>
								<input type="text" name="om_r_addr1" id="om_r_addr1" value="서울시 가산동 금천구 IT타워" style="width:400px"><br><br>
								<input type="text" name="om_r_addr2" id="om_r_addr2" value="156-1번지 가동 1001호" style="width:400px">
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<div class="tableForm">
		<h3>결제정보</h3>
		<table style="border-left:1px solid #D2D0D0">
			<tr>
				<th>상품합계 금액</th>
				<td>
					0 원
				</td>
			</tr>
			<tr>
				<th>배송비</th>
				<td>
					0 원
				</td>
			</tr>
			<tr>
				<th>적립금</th>
				<td>
					0 원
				</td>
			</tr>
			<tr>
				<th>총 결제금액</th>
				<td>
					0 원
				</td>
			</tr>
		</table>
	</div><br>

	<div class="tableForm">
		<h3>결제수단</h3>
		<table style="border-left:1px solid #D2D0D0">
			<tr>
				<th>무통장</th>
				<td>
					주문 수기접수는 무통장 결제만 가능합니다.
				</td>
			</tr>
			<tr>
				<th>입금계좌 선택</th>
				<td>
					<?=drawSelectBoxMore("settle_bank_code",$arySiteSettleBank,"",$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['OW00036']."::",$html="N")?>
				</td>
			</tr>
			<tr>
				<th>입금자명</th>
				<td>
					<input type="input" id="input_bank_name" name="input_bank_name" class="defInput _w100" maxlength="20" value=""/>
				</td>
			</tr>
		</table>
	</div><br>

	<!-- Pagenate object --> 
	<center>
	<a class="btn_big" href="javascript:goProdOrderWriteAct();"><strong>등록</strong></a>
	</center>
</div>
