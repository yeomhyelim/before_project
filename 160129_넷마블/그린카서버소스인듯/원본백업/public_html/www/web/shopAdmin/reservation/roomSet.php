<div id="contentArea">
	<div class="contentTop">
		<h2>환경설정</h2>
		<div class="clr"></div>
	</div>
	<br>


	<div class="tabRevNav">
		<a href="./?menuType=reservation&mode=roomSet" class="selected">기본환경설정</a>
		<a href="./?menuType=reservation&mode=roomSetEtc">부대시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetFix">객실시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetPolicy">예약규정설정</a>
	</div>
	<!-- ******** 컨텐츠 ********* -->

	
	
	<div class="tableFo,rWrap">
		<h3>예약환경설정</h3>
		<table class="tableForm">
			<tr>
				<th>예약중지 설정</th>
				<td>
					<input type="radio" name="" > 예약중
					<input type="radio" name="" > 예약중지
				</td>
			</tr>
			<tr>
				<th>예약자동취소</th>
				<td><input type="ckeckbox" name="" > 사용함 - 예약대기 상태에서 <input type="text" name="" class="_w30" value="24">시간이 지나면 자동으로 예약 취소</td>
			</tr>
			<tr>
				<th>계약금 결제</th>
				<td><input type="ckeckbox" name="" > 사용함 - 결제금액의 <input type="text" name="" class="_w30" value="40">% 를 계약금으로 결제</td>
			</tr>
			<tr>
				<th>입퇴실 시간</th>
				<td>
					예약당일
					<select name="">
						<option>오후</option>
					</select>
					<input type="text" name="" class="_w30" value="03"> 시 부터 ~ 
					<select name="">
						<option>오후</option>
					</select>
					<input type="text" name="" class="_w30" value="12"> 시 까지
				</td>
			</tr>
		</table>

		<h3 class="mt30">예약기간설정</h3>
		<table class="tableForm">
			<tr>
				<th>예약가능 개월수</th>
				<td></td>
			</tr>
			<tr>
				<th>예약가능 일수</th>
				<td></td>
			</tr>
			<tr>
				<th>주말적용 설정</th>
				<td></td>
			</tr>
			<tr>
				<th>준성수기 설정</th>
				<td></td>
			</tr>
			<tr>
				<th>준성수기기간 <a href="#" class="btn_sml"><span>추가</span></a></th>
				<td>
					<input type="text" name="" class="_w100"> ~ <input type="text" name="" class="_w100"> /
					<input type="text" name="" class="_w100"> ~ <input type="text" name="" class="_w100">
				</td>
			</tr>
			<tr>
				<th>성수기기간 <a href="#" class="btn_sml"><span>추가</span></a></th>
				<td>
					<input type="text" name="" class="_w100"> ~ <input type="text" name="" class="_w100"> /
					<input type="text" name="" class="_w100"> ~ <input type="text" name="" class="_w100">
				</td>
			</tr>
		</table>
	</div>


	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="#"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
			<a class="btn_new_gray" href="javascript:goMoveUrl('bannerList');"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
		</div>
</div>
