<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["EW00016"] //배너관리?> </h2>
	<div class="clr"></div>
</div>


<!-- ******** 컨텐츠 ********* -->

	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00005"] //배너제목?></th>
				<td><input type="text" <?=$nBox?> id="b_title" name="b_title"  style="width:500px;"/></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00006"] //보여주기?></th>
				<td>
					<input type="radio" id="b_view" name="b_view" value="Y" checked/>예
					<input type="radio" id="b_view" name="b_view" value="N"/>아니오
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00021"] //메인 배너위치?></th>
				<td>
					<?=$sboxBannerGrp?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00019"] //배너타입?></th>
				<td>
					<input type="radio" id="b_type" name="b_type" value="I" checked onClick="eventBType()"/>Image &nbsp;&nbsp;&nbsp;&nbsp;
					<input type="radio" id="b_type" name="b_type" value="F" onClick="eventBType()"/>Flash <br>
					<div id="flashOptionDiv" style="display:none;">
						<?=$LNG_TRANS_CHAR["EW00022"] //가로?> : <input type="text" <?=$nBox?> id="b_width" name="b_width" style="width:40px;"/>
						<?=$LNG_TRANS_CHAR["EW00023"] //세로?> : <input type="text" <?=$nBox?> id="b_height" name="b_height" style="width:40px;"/>
					</div>
				</td>
			</tr>
			<!--tr>
				<th><?=$LNG_TRANS_CHAR["EW00007"] //배너기간?></th>
				<td>
					<input type="text" <?=$nBox?> id="b_start_dt" name="b_start_dt" style="width:100px;"/>
					~
					<input type="text" <?=$nBox?> id="b_end_dt" name="b_end_dt" style="width:100px;"/>
				</td>
			</tr-->
			<?/** 2013.04.26 다국어 버전으로 변경 **/
			  $aryUseLng = explode("/", $S_USE_LNG);
			  foreach($aryUseLng as $lng):
			?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00008"] //링크페이지?></th>
				<td><input type="text" <?=$nBox?> id="b_link_url" name="b_link_url_<?=strtolower($lng)?>" style="width:500px;" value="http://"/></td>
			</tr>
			<?endforeach;?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00009"] //링크열기?></th>
				<td>
					<input type="radio" id="b_link_type" name="b_link_type" value="1" checked/><?=$LNG_TRANS_CHAR["EW00010"] //새창에서열기?>
					<input type="radio" id="b_link_type" name="b_link_type" value="2"/><?=$LNG_TRANS_CHAR["EW00024"] //현재창에서열기?>
					<input type="radio" id="b_link_type" name="b_link_type" value="3"/><?=$LNG_TRANS_CHAR["EW00025"] //팝업으로 열기?>
					<input type="radio" id="b_link_type" name="b_link_type" value="4"/><?=$LNG_TRANS_CHAR["EW00012"] //링크 없음?>
				</td>
			</tr>
			<?/** 2013.04.26 다국어 버전으로 변경 **/
			  $aryUseLng = explode("/", $S_USE_LNG);
			  foreach($aryUseLng as $lng):
			  if(!$row["B_FILE_{$lng}"] && $lng == $S_ST_LNG) { $row["B_FILE_{$lng}"] = $row["B_FILE"]; }
			?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00020"] //배너이미지?> (<?=$lng?>)</th>
				<td>
					<input type="file" <?=$nBox?> id="b_file_<?=strtolower($lng)?>" name="b_file_<?=strtolower($lng)?>" style="width:300px;height:20px;"/>							
				</td>
			</tr>
			<?endforeach;?>
		</table>
	</div><!-- tableList -->

    <div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goBannerAct('bannerWrite');" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		<a class="btn_new_gray" href="javascript:goMoveUrl('bannerList');"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
	</div>

	<!-- 기능 공지 시작 -->
		<div class="noticeWrap">
			<div class="titleNotice"><img src="/shopAdmin/himg/common/tit_notice.gif"/></div>
			* <?=$LNG_TRANS_CHAR["ES00004"] //배너타입이 FLASH인 경우 반드시 가로세로의 크기를 pixel 단위로 입력해 주세요.?><br/>
			* <?=$LNG_TRANS_CHAR["ES00005"] //배너의 등록 기간을 설정하시면 종료날자에 자동으로 사라집니다.?><br/>
			* <?=$LNG_TRANS_CHAR["ES00006"] //배너의 등록 기간을 별도로 설정하지 않으시려면 시작일과 종료일을 0으로 세팅하세요.?>
		</div>
	<!-- 기능 공지 끝 -->
<!-- ******** 컨텐츠 ********* -->