	
	
<!-- 디자인관리의 : 디자인명과 디자인코드 hidden으로 전달 -->
<input type="hidden" name="sb_design_code" value="">
<input type="hidden" name="sb_banner_name" value="">
<input type="hidden" name="pv_page" value="<?=$row[PV_PAGE]?>"/>
<input type="hidden" name="pv_modul_type" value="<?=$row[PV_MODUL_TYPE]?>"/>
<input type="hidden" name="pv_modul_name" value="<?=$row[PV_MODUL_NAME]?>"/>
<input type="hidden" name="pv_design_no"  value="<?=$row[PV_DESIGN_NO]?>"/>
<input type="hidden" name="dm_design_type"  value="<?=$row[DM_DESIGN_TYPE]?>"/>
<input type="hidden" name="dm_design_code"  value="<?=$row[DM_DESIGN_CODE]?>"/>
	
	
<div class="contentTop">
	<h2>음직이는 배너 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm mt20">
	<table class="mt20" id="tabSlideBanner">
		<tr>
			<th>디자인타입</th>
			<td>
				type <span id="design_type"> - </span><span id="design_code"></span><a href="javascript:goImageGroupPopup('slider')" class="btn_sml ml10"><span>디자인선택</span></a>
			</td>
		</tr>
		<tr>
			<th>예약어</th>
			<td><strong id="userTag"></strong></td>
		</tr>
		<tr>
			<th>슬라이딩 이미지 수</th>
			<td> <input type="hidden" name="sb_images_cnt" id="sb_images_cnt" <?=$nBox?>/>   <a href="javascript:goAddSlideBanner();" class="btn_blue_sml ml10"><span>이미지 추가하기</span></a></td>
		</tr>
		<tr>
			<th>이미지사이즈</th>
			<td>
				<span class="spanTitle">가로사이즈</span> <input type="text" name="sb_image_w" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
				<span class="spanTitle">세로사이즈</span> <input type="text" name="sb_image_h" <?=$nBox?>  style="width:40px;"/> px
			</td>
		</tr>
		<tr>
			<th><span class="numberOrange_1 mr5"></span> 적용이미지 </th>
			<td>
				<dl class="tdListUl">
					<dd><span class="spanTitle">이미지</span><input type="file" name="sb_image_file_1" id="sb_image_file_1" <?=$nBox?>  style="height:22px;"/></dd>
					<dd><span class="spanTitle">링크</span><input type="text" name="sb_image_link_1" id="sb_image_link_1" <?=$nBox?> style="width:400px;"/></dd>
					<dd><span class="spanTitle">카피문구</span><input type="text" name="sb_images_txt_1" id="sb_images_txt_1" <?=$nBox?> style="width:400px;"/></dd>
					<dd>
						<span class="spanTitle">링크적용</span>
						<input type="radio" name="sb_link_target" id="sb_link_target" value="M" checked/>현제 페이지 열기
						<input type="radio" name="sb_link_target" id="sb_link_target" value="B" class="ml10"/>새창으로 열기 						
						<input type="radio" name="sb_link_target" id="sb_link_target" value="N" class="ml10"/>열결 없음
					</dd>
				</dl>
			</td>
		</tr>		
	</table>
</div>
	

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goSliderbannerAct('sliderbannerWrite');" id="menu_auth_m"><strong>슬라이딩 배너 저장</strong></a>
</div>