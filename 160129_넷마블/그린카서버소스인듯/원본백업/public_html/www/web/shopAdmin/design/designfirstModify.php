<div class="contentTop">
	<h2>첫화면 설정</h2>
</div>

<!-- ******** 컨텐츠 ********* -->
<input type="hidden" name="dl_no" value="<?=$row[DL_NO]?>"/>
<input type="hidden" name="dl_code" value="<?=$row[DL_CODE]?>"/>
<input type="hidden" name="dl_design_code" value="<?=$row[DL_DESIGN_CODE]?>"/>
<input type="hidden" name="dl_bg_image_old" value="<?=$row[DL_BG_IMAGE]?>"/>


<div class="tableForm mt20">
	<h3>사이트 배경설정</h3>
	<table>
		<!-- tr>
			<th>배경종류</th>
			<td>
				<input type="radio" name="dl_bg_type" value="C" <?=$row[DL_BG_TYPE] == "C" ? " checked" : ""?> />배경색
				<input type="radio" name="dl_bg_type" value="I" <?=$row[DL_BG_TYPE] == "I" ? " checked" : ""?> class="ml10"/>배경이미지
			</td>
		</tr -->
		<tr>
			<th>배경색</th>
			<td><input type="text" name="dl_bg_color" value="<?=$row[DL_BG_COLOR]?>" <?=$nBox?>  style="width:100px;"/></td>
		</tr>
		<tr>
			<th>배경이미지</th>
			<td>
				<input type="file" name="dl_bg_image" <?=$nBox?>  style="width:200px;height:20px;"/>
				<div class="attachImg"><?= "<img src='../upload/layout/".$row[DL_BG_IMAGE]."'/>" ?>
				</div>
			</td>
		</tr>
		<tr>
			<th>배경 적용위치</th>
			<td>
				<span class="spanTitle" style="width:30px;">수평</span>
					<select name="dl_bg_img_dir_h">
						<option value="left" <?=$row[DL_BG_IMG_DIR_H] == "left" ? " selected" : ""?>>left</option>
						<option value="center" <?=$row[DL_BG_IMG_DIR_H] == "center" ? " selected" : ""?>>center</option>
						<option value="right" <?=$row[DL_BG_IMG_DIR_H] == "right" ? " selected" : ""?>>right</option>
					</select>
				<span class="spanTitle ml30" style="width:30px;">수직</span>
					<select name="dl_bg_img_dir_v">
						<option value="top" <?=$row[DL_BG_IMG_DIR_V] == "top" ? " selected" : ""?>>top</option>
						<option value="middle" <?=$row[DL_BG_IMG_DIR_V] == "middle" ? " selected" : ""?>>middle</option>
						<option value="bottom" <?=$row[DL_BG_IMG_DIR_V] == "bottom" ? " selected" : ""?>>bottom</option>
					</select>
				<span class="spanTitle ml30">적용방식</span>
					<input type="radio" name="dl_bg_repeat" value="no" <?=$row[DL_BG_REPEAT] == "no" ? " checked" : ""?> /> 반복안함
					<input type="radio" name="dl_bg_repeat" value="x" <?=$row[DL_BG_REPEAT] == "x" ? " checked" : ""?> class="ml10"/> 수평방향으로 반복
					<input type="radio" name="dl_bg_repeat" value="y" <?=$row[DL_BG_REPEAT] == "y" ? " checked" : ""?> class="ml10"/> 수직방향으로 반복
					<input type="radio" name="dl_bg_repeat" value="" <?=$row[DL_BG_REPEAT] == "" ? " checked" : ""?> class="ml10"/> 전체적용
			</td>
		</tr>
	</table>


	<!-- 사이트정렬 -->
	<h3 class="mt40">시작화면 정렬</h3>
	<table>
		<tr>
			<td style="width:500px;">
				<div class="alignImg">
				<img src="/shopAdmin/himg/common/align_left_img.gif"/>
				<input type="radio" name="dl_bg_align" value="left" <?=$row[DL_BG_ALIGN] == "left" ? " checked" : ""?>/> 좌측정렬
				</div>
			</td>
			<td>
				<div class="alignImg">
				<img src="/shopAdmin/himg/common/align_center_img.gif"/>
				<input type="radio" name="dl_bg_align" value="center" <?=$row[DL_BG_ALIGN] == "center" ? " checked" : ""?>/> 중앙정렬
				</div>
			</td>
		</tr>								
	</table>
	<!-- 사이트정렬 -->
</div>

<!-- ******** 컨텐츠 ********* -->
<div class="tableList mt40">
	<table>
		<colgroup>
			<col style="width:200px;"/>
			<col/>
			<col style="width:250px;"/>
			<col style="width:250px;"/>
		</colgroup>
		<tr>
			<th>운영방식</th>
			<th>화면설정</th>
			<th>접근인증</th>
			<th>구매권한</th>
		</tr>
		<tr>
			<td class="title"><input type="radio" name="dl_first_page" value="I" <?=$row[DL_FIRST_PAGE] == "I" ? "checked" : ""?> /> 일반 쇼핑몰</td>
			<td class="title">
				<img src="/shopAdmin/himg/common/intro_ico_intro.gif"/>
				<ul>
					<li>인트로페이지 설정</li>
					<li><input type="radio" name="dl_first_use" value="Y" <?=$row[DL_FIRST_USE] == "Y" ? " checked" : ""?>/> 인트로페이지 사용안함</li>
					<li><input type="radio" name="dl_first_use" value="N" <?=$row[DL_FIRST_USE] == "N" ? " checked" : ""?>/> 인트로페이지 사용</li>
				</ul>
				<div class="clear"></div>
			</td>
			<td>회원, 비회원</td>
			<td>회원, 비회원</td>			
		</tr>	
		<tr>
			<td class="title"><input type="radio" name="dl_first_page" value="M" <?=$row[DL_FIRST_PAGE] == "M" ? "checked" : ""?>/> 회원전용 쇼핑몰(폐쇠몰)</td>
			<td class="title">
				<img src="/shopAdmin/himg/common/intro_ico_login.gif"/>
				<!-- ul>
					<li>인트로페이지 설정</li>
					<li><input type="radio" name="" checked/> 운영중</li>
					<li><input type="radio" name=""/> 인트로페이지 사용</li>
				</ul>
				<div class="clear"></div -->			
			</td>
			<td>회원전용</td>
			<td>회원전용</td>
		</tr>	
		<tr>
			<td class="title"><input type="radio" name="dl_first_page" value="S" <?=$row[DL_FIRST_PAGE] == "S" ? "checked" : ""?>/> 성인전용 쇼핑몰</td>
			<td class="title">
				<img src="/shopAdmin/himg/common/intro_ico_19.gif"/>
				<!-- ul>
					<li>인트로페이지 설정</li>
					<li><input type="radio" name="" checked/> 운영중</li>
					<li><input type="radio" name=""/> 인트로페이지 사용</li>
				</ul>
				<div class="clear"></div -->			
			</td>
			<td>회원, 비회원</td>
			<td>회원, 비회원</td>
		</tr>				
	</table>


<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goDesignfirstAct('designfirstModify');" id="menu_auth_m"><strong>설정 저장</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->
