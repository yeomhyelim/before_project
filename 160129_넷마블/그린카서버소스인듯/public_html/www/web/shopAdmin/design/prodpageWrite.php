<div class="contentTop">
	<h2>메인상품 진열방식 관리</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm mt20">
	<table class="mt20">
		<tr>
			<th>적용위치</th>
			<td>
				<input type="radio" name="pv_page" value="main"/> 메인페이지 
				<input type="radio" name="pv_page" value="submain"/> 서브메인
				<input type="radio" name="pv_page" value="subpage"/> 서브페이지 
				<input type="radio" name="pv_page" value="prodlist"/> 상품리스트
				<input type="radio" name="pv_page" value="prodview"/> 상품상세보기
			</td>
		</tr>
		<tr>
			<th>적용모듈</th>
			<td>
				<input type="radio" name="pv_modul_type" value="new"/> 신상품 
				<input type="radio" name="pv_modul_type" value="best" class="ml10"/> 베스트상품
				<input type="radio" name="pv_modul_type" value="md" class="ml10"/> MD추천상품
				<input type="radio" name="pv_modul_type" value="recommend" class="ml10"/> 추천상품
			</td>
		</tr>
		<tr>
			<th>모듈명</th>
			<td><input type="text" name="pv_modul_name" <?=$nBox?>/></td>
		</tr>
		<tr>
			<th>디자인타입</th>
			<td>
				<input type="hidden" name="pv_design_no" value="11"/>
				메인 리스트형 Type - A <a href="#" class="btn_sml ml10"><span>디자인선택</span></a>
			</td>
		</tr>
		<tr>
			<th>예약어</th>
			<td><strong>{{메인신상품}}</strong></td>
		</tr>
		<tr>
			<th>노출순위</th>
			<td>메인 추천상품 그룹의 <input type="text" name="pv_order" value="1" <?=$nBox?> style="width:40px;text-align:right;"/> 째로 노출</td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="pv_image_size_w" id="pv_image_size_w" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="pv_image_size_h" id="pv_image_size_h" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th>이미지 노출수량</th>
			<td>
				<span class="spanTitle">가로</span> <input type="text" name="pv_image_cnt_w" id="pv_image_cnt_w" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
				<span class="spanTitle">세로</span> <input type="text" name="pv_image_cnt_h" id="pv_image_cnt_h" <?=$nBox?>  style="width:40px;"/> 개
			</td>
		</tr>
	</table>
</div>
<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goProdpageAct('prodpageWrite');" id="menu_auth_m"><strong>설정 저장</strong></a>
	<a class="btn_big" href="javascript:C_getMoveUrl('prodpageList','get','<?=$PHP_SELF?>');"><strong>목록</strong></a>
</div>