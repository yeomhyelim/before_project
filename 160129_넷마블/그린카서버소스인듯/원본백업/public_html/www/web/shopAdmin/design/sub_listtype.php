<div class="contentTop">
	<h2>서브상품 진열방식 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<?include "./include/tab_shopListType.inc.php";?>
<div class="tableForm mt20">
	<h3>서브페이지 상단 추천상품 설정</h3>
	<table>
		<tr>
			<th>사용항목</th>
			<td>
				<input type="checkbox" name=""/> 신상품 
				<input type="checkbox" name="" class="ml10"/> 베스트상품
				<input type="checkbox" name="" class="ml10"/> MD추천상품
				<input type="checkbox" name="" class="ml10"/> 추천상품
			</td>
		</tr>
	</table>

	<table class="mt20">
		<tr>
			<th>예약어</th>
			<td><strong>{{서브페이지 신상품}}</strong></td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>리스트형 <a href="#" class="btn_sml ml10"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>노출순위</th>
			<td>메인 추천상품 그룹의 <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 째로 노출</td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개
			</td>
		</tr>
	</table>

	<table class="mt5">
		<tr>
			<th>예약어</th>
			<td><strong>{{서브페이지 베스트상품}}</strong></td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>리스트형 <a href="#" class="btn_sml ml10"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>노출순위</th>
			<td>메인 추천상품 그룹의 <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 째로 노출</td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개
			</td>
		</tr>
	</table>

	<table class="mt5">
		<tr>
			<th>예약어</th>
			<td><strong>{{서브페이지 MD추천상품}}</strong></td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>리스트형 <a href="#" class="btn_sml ml10"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>노출순위</th>
			<td>메인 추천상품 그룹의 <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 째로 노출</td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개
			</td>
		</tr>
	</table>

	<table class="mt5">
		<tr>
			<th>예약어</th>
			<td><strong>{{서브페이지 추천상품}}</strong></td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>리스트형 <a href="#" class="btn_sml ml10"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>노출순위</th>
			<td>메인 추천상품 그룹의 <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 째로 노출</td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개
			</td>
		</tr>
	</table>
</div>

<div class="tableForm mt20">
	<h3>상품리스트 설정</h3>
	<table class="mt5">
		<tr>
			<th>리스트 타입</th>
			<td>
				<input type="radio" name=""/>이미지형 
				<input type="radio" name="" class="ml10"/>리스트형 
				<input type="radio" name="" class="ml10"/>이미지+리스트형
			</td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>이미지리스트 디폴트 <a href="#" class="btn_sml ml10"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>목록상단 서브카테고리</th>
			<td>
				<input type="radio" name=""/>사용
				<input type="radio" name="" class="ml10"/>사용안함
			</td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개
			</td>
		</tr>
	</table>
</div><!-- tableForm -->

<div class="tableForm mt20">
	<h3>상품상세페이지</h3>
	<table class="mt5">
		<tr>
			<th>화면타입</th>
			<td>
				<input type="radio" name=""/>기본형
				<input type="radio" name="" class="ml10"/>썸네일 노출형
			</td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>상세정보 디폴트 <a href="#" class="btn_sml ml10"><span>디자인선택</span></a></td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="" <?=$nBox?>  style="width:40px;"/> 개
			</td>
		</tr>
	</table>
</div><!-- tableForm -->

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goInfoModify();" id="menu_auth_m"><strong>설정 저장</strong></a>
</div>