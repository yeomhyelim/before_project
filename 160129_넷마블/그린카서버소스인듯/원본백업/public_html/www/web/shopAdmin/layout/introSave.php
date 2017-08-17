<script type="text/javascript">
	var strBGImagePath = "<?=$row[DL_BG_IMAGE]?>";

	function goBgImageDel() {
		document.form.dl_bg_image_del.value = strBGImagePath;
		$(".attachImg").html("");
	}
</script>

<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["BW00116"] //첫화면 설정?></h2>
	<div class="clr"></div>
</div>


<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3 class="mt40"><?=$LNG_TRANS_CHAR["BW00142"] //로고관리?></h3>
		<table>
			<tr>
				<th rowspan="2"><?=$LNG_TRANS_CHAR["BW00143"] //WEB용 로고?></th>
				<td colspan="3">
					<input type="radio" name="web_log_type" value="I" <?= $row['WEB_LOGO_TYPE'] != "F" ? "checked" : "" ?>/><?=$LNG_TRANS_CHAR["BW00144"] //이미지?> 
					<!-- input type="radio" name="web_log_type" value="F" <?= $row['WEB_LOGO_TYPE'] == "F" ? "checked" : "" ?> style="margin-left:10px;"/>플래시 -->
				</td>
			</tr>
			<tr>
				<td>
					<input type="file" name="web_log_img"  <?=$nBox?> style="height:22px;"/>
					<div class="attachImg"><?= $strWebLogoImg ?></div>
					<div class="helpTxtGray mt10">
						* <?=$LNG_TRANS_CHAR["BS00071"] //이미지(플래시 포함)의 크기는 가로 최대 <strong>450pixel</strong> 세로 최대 <strong>200pixel</strong> 입니다.?><br/>
						* <?=$LNG_TRANS_CHAR["BS00072"] //<strong>gif, jpg, png</strong>형식의 이미지파일을 사용하실 수 있습니다.?>
					</div>
				</td>
				<th><?=$LNG_TRANS_CHAR["BW00146"] //MOBILE용 로고?></th>
				<td>
					<input type="file" name="mob_log_img"  <?=$nBox?> style="height:22px;"/>
					<div class="attachImg"><?= $strMobLogoImg ?></div>
					<div class="helpTxtGray mt10">
						* <?=$LNG_TRANS_CHAR["BS00072"] //이미지의 크기는 가로 최대 <strong>300pixel</strong> 세로 최대 <strong>100pixel</strong> 입니다.?><br/>
						* <?=$LNG_TRANS_CHAR["BS00073"] //<strong>gif, jpg, png</strong> 형식의 이미지파일을 사용하실 수 있습니다.?><br/>
						* <?=$LNG_TRANS_CHAR["BS00075"] //모바일용 로고는 플래시 파일을 사용할 수 없습니다.?>
					</div>
				</td>
			</tr>
		</table>


	<!-- 사이트정렬 -->
	<h3 class="mt40"><?=$LNG_TRANS_CHAR["BW00128"] //시작화면 정렬?></h3>
	<!-- table>
		<tr>
			<td style="width:500px;">
				<div class="alignImg">
				<img src="/shopAdmin/himg/common/align_left_img.gif"/>
				<input type="radio" name="dl_bg_align" value="left" <?=$row[DL_BG_ALIGN] == "left" ? " checked" : ""?>/> <?=$LNG_TRANS_CHAR["BW00129"] //좌측정렬?>
				</div>
			</td>
			<td>
				<div class="alignImg">
				<img src="/shopAdmin/himg/common/align_center_img.gif"/>
				<input type="radio" name="dl_bg_align" value="center" <?=$row[DL_BG_ALIGN] == "center" ? " checked" : ""?>/> <?=$LNG_TRANS_CHAR["BW00130"] //중앙정렬?>
				</div>
			</td>
		</tr>								
	</table -->
	<!-- 사이트정렬 -->
	<table>
		<colgroup>
			<col style="width:200px;"/>
			<col/>
			<col style="width:250px;"/>
			<col style="width:250px;"/>
		</colgroup>
		<tr>
			<th><?=$LNG_TRANS_CHAR["BW00131"] //운영방식?></th>
			<th><?=$LNG_TRANS_CHAR["BW00132"] //화면설정?></th>
			<th><?=$LNG_TRANS_CHAR["BW00133"] //접근인증?></th>
			<th><?=$LNG_TRANS_CHAR["BW00134"] //구매권한?></th>
		</tr>
		<tr>
			<td class="title"><input type="radio" name="dl_first_page" value="I" <?=$row[DL_FIRST_PAGE] == "I" ? "checked" : ""?> /> <?=$LNG_TRANS_CHAR["BW00135"] //일반 쇼핑몰?></td>
			<td class="title">
				<img src="/shopAdmin/himg/common/intro_ico_intro.gif"/>
				<ul>
					<li><?=$LNG_TRANS_CHAR["BW00136"] //인트로페이지 설정?></li>
					<li><input type="radio" name="dl_first_use" value="N" <?=$row[DL_FIRST_USE] == "N" ? " checked" : ""?>/> <?=$LNG_TRANS_CHAR["BW00137"] //인트로페이지 사용안함?></li>
					<li><input type="radio" name="dl_first_use" value="Y" <?=$row[DL_FIRST_USE] == "Y" ? " checked" : ""?>/> <?=$LNG_TRANS_CHAR["BW00138"] //인트로페이지 사용?></li>
				</ul>
				<div class="clear"></div>
			</td>
			<td><?=$LNG_TRANS_CHAR["BW00139"] //회원, 비회원?></td>
			<td><?=$LNG_TRANS_CHAR["BW00139"] //회원, 비회원?></td>			
		</tr>	
		<tr>
			<td class="title"><input type="radio" name="dl_first_page" value="M" <?=$row[DL_FIRST_PAGE] == "M" ? "checked" : ""?>/> <?=$LNG_TRANS_CHAR["BW00140"] //회원전용 쇼핑몰(폐쇠몰)?></td>
			<td class="title">
				<img src="/shopAdmin/himg/common/intro_ico_login.gif"/>
				<!-- ul>
					<li>인트로페이지 설정</li>
					<li><input type="radio" name="" checked/> <?=$LNG_TRANS_CHAR["BW00118"] //운영중?></li>
					<li><input type="radio" name=""/> <?=$LNG_TRANS_CHAR["BW00118"] //인트로페이지 사용?></li>
				</ul>
				<div class="clear"></div -->			
			</td>
			<td><?=$LNG_TRANS_CHAR["BW00141"] //회원전용?></td>
			<td><?=$LNG_TRANS_CHAR["BW00141"] //회원전용?></td>
		</tr>	
		<!--<tr>
			<td class="title"><input type="radio" name="dl_first_page" value="S" <?=$row[DL_FIRST_PAGE] == "S" ? "checked" : ""?>/> 성인전용 쇼핑몰</td>
			<td class="title">
				<img src="/shopAdmin/himg/common/intro_ico_19.gif"/>
				<!-- ul>
					<li>인트로페이지 설정</li>
					<li><input type="radio" name="" checked/> 운영중</li>
					<li><input type="radio" name=""/> 인트로페이지 사용</li>
				</ul>
				<div class="clear"></div>			
			</td>
			<td>회원, 비회원</td>
			<td>회원, 비회원</td>
		</tr>//-->				
	</table>
</div>	
	

<!-- ******** 컨텐츠 ********* -->

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goIntroAct();" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00067"] //설정 저장?></strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->
