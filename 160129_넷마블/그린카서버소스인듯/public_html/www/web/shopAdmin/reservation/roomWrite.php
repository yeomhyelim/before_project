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
		<h3>객실기본정보</h3>
		<table class="tableForm">
			<tr>
				<th>객실명</th>
				<td><input type="text" name=""></td>
			</tr>
			<tr>
				<th>객실유형</th>
				<td>
					<select name="">
						<option>:: 객실유형 ::</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>객실면적</th>
				<td>
					<input type="text" name="" class="_w50"> ㎡ ≒ <input type="text" name="" class="_w50"> 평
					<p>하나만 입력해 주세요.</p>
				</td>
			</tr>
			<tr>
				<th>기준/최대인원</th>
				<td>기준 <input type="text" name="" class="_w50"> 명 / 최대 <input type="text" name="" class="_w50"> 명</td>
			</tr>
			<tr>
				<th>출력여부</th>
				<td>
					<input type="radio" name="">출력함
					<input type="radio" name="">출력안함
				</td>
			</tr>
		</table>

		<h3 class="mt30">객실요금설정</h3>
		<table class="tableList">
			<tr>
				<th rowspan="2">단위(원)</th>
				<th colspan="3">비수기</th>
				<th colspan="3">준성수기</th>
				<th colspan="3">성수기</th>
			</tr>
			<tr>
				<th>주중</th>
				<th>주말</th>
				<th>휴일</th>
				<th>주중</th>
				<th>주말</th>
				<th>휴일</th>
				<th>주중</th>
				<th>주말</th>
				<th>휴일</th>
			</tr>
			<tr>
				<td>객실이용요금</td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
				<td><input type="text" name="" class="_w50"></td>
			</tr>
			<tr>
				<td>인원추가요금</td>
				<td colspan="3">1인추가시 <input type="text" name="" class="_w50"></td>
				<td colspan="3">1인추가시 <input type="text" name="" class="_w50"></td>
				<td colspan="3">1인추가시 <input type="text" name="" class="_w50"></td>
			</tr>
		</table>


		<h3 class="mt30">객실시설설정</h3>
		<table class="tableForm">
			<tr>
				<th>객실</th>
				<td>
					<input type="checkbox" name=""> 침대
					<input type="checkbox" name=""> 협탁
					<input type="checkbox" name=""> 스탠드
					<input type="checkbox" name=""> TV
					<input type="checkbox" name=""> 에어컨
					<input type="checkbox" name=""> 화장대
					<input type="checkbox" name=""> 옷걸이
					<input type="checkbox" name=""> 테이블
					<input type="checkbox" name=""> 헤어드라이어
				</td>
			</tr>
			<tr>
				<th>주방</th>
				<td>
					<input type="checkbox" name=""> 전기밥솥
					<input type="checkbox" name=""> 전자렌지
					<input type="checkbox" name=""> 식기일체
					<input type="checkbox" name=""> 조리기구일체
					<input type="checkbox" name=""> 식탁
					<input type="checkbox" name=""> 무선전기주전자
				</td>
			</tr>
			<tr>
				<th>욕실</th>
				<td>
					<input type="checkbox" name=""> 삼프
					<input type="checkbox" name=""> 린스
					<input type="checkbox" name=""> 바디클렌저
					<input type="checkbox" name=""> 목용용품일체
					<input type="checkbox" name=""> 비누
					<input type="checkbox" name=""> 치약
					<input type="checkbox" name=""> 월풀욕조
					<input type="checkbox" name=""> 사우나
				</td>
			</tr>
			<tr>
				<th>추가설명문구</th>
				<td>
					<textarea name="" style="width:100%;height:60px;"></textarea>
				</td>
			</tr>
		</table>

	<h3 class="mt30">객실이미지 등록</h3>
		<table class="tableForm">
			<tr>
				<th>이미지등록</th>
				<td>
					<textarea name="" style="width:100%;height:150px;"></textarea>
				</td>
			</tr>
		</table>
	</div>


	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="#"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
			<a class="btn_new_gray" href="javascript:goMoveUrl('bannerList');"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
		</div>
</div>
