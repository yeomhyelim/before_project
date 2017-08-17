<div id="contentArea">
	<div class="contentTop">
		<h2>환경설정</h2>
		<div class="clr"></div>
	</div>
	<br>


	<div class="tabRevNav">
		<a href="./?menuType=reservation&mode=roomSet">기본환경설정</a>
		<a href="./?menuType=reservation&mode=roomSetEtc" class="selected">부대시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetFix">객실시설설정</a>
		<a href="./?menuType=reservation&mode=roomSetPolicy">예약규정설정</a>
	</div>
	<!-- ******** 컨텐츠 ********* -->

	
	
	<div class="tableFo,rWrap">
		<h3>부대시설설정</h3>
		<table class="tableList">
			<tr>
				<th><input type="checkbox" name=""></th>
				<th>순서</th>
				<th>시설명</th>
				<th>이용요금</th>
				<th>단위</th>
				<th>비고</th>
				<th>관리</th>
			</tr>
			<tr>
				<td><input type="checkbox" name=""></td>
				<td><input type="text" name="" value="1" class="_w30"></td>
				<td><input type="text" name="" class="_w300" value="바베큐통대여 및 숫불"></td>
				<td><input type="text" name="" value="30000">원</td>
				<td><input type="text" name="" value="개"></td>
				<td><input type="text" name="" vlaue="테이블 및 의자포함"></td>
				<td><a href="" class="btn_sml"><span>삭제</span></a></td>
			</tr>
			<tr>
				<td><input type="checkbox" name=""></td>
				<td><input type="text" name="" value="1" class="_w30"></td>
				<td><input type="text" name="" class="_w300" value="바베큐통대여 및 숫불"></td>
				<td><input type="text" name="" value="30000">원</td>
				<td><input type="text" name="" value="개"></td>
				<td><input type="text" name="" vlaue="테이블 및 의자포함"></td>
				<td><a href="" class="btn_sml"><span>삭제</span></a></td>
			</tr>
		</table>
	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="#"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		</div>

		<h3 class="mt30">객실유형설정</h3>
		<table class="tableList">
			<tr>
				<th><input type="checkbox" name=""></th>
				<th>순서</th>
				<th>객실유형</th>
				<th>관리</th>
			</tr>
			<tr>
				<td><input type="checkbox" name=""></td>
				<td><input type="text" name="" value="1" class="_w30"></td>
				<td><input type="text" name="" class="_w500" value="바베큐통대여 및 숫불"></td>
				<td><a href="" class="btn_sml"><span>삭제</span></a></td>
			</tr>
		</table>
	</div>


	    <div class="buttonBoxWrap">
			<a class="btn_new_blue" href="#"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		</div>
</div>
