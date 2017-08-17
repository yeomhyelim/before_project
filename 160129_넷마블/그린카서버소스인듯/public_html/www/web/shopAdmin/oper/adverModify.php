<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["EW00026"] //배너 그룹 관리?></h2>
	<div class="clr"></div>
</div>


<!-- ******** 컨텐츠 ********* -->

	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00028"] //배너그룹명?></th>
				<td>
					<input type="text" <?=$nBox?> name="a_name" id="a_name" style="width:300px;" value="<?=$row["A_NAME"]?>">
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00032"] //배너그룹 설명?></th>
				<td>
					<input type="text" <?=$nBox?> name="a_loca" id="a_loca" style="width:300px;" value="<?=$row["A_LOCA"]?>">
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00029"] //배너 배열 구성?></th>
				<td>
					<span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00022"] //가로?></span>: <input type="text" <?=$nBox?> name="a_table_w" id="a_table_w" style="width:30px;" maxlength="2" value="<?=$row["A_TABLE_W"]?>"> <?=$LNG_TRANS_CHAR["EW00034"] //개?>
					<span class="spanTitle" style="margin-left:35px;"><?=$LNG_TRANS_CHAR["EW00023"] //세로?></span>: <input type="text" <?=$nBox?> name="a_table_h" id="a_table_h" style="width:30px;" maxlength="2" value="<?=$row["A_TABLE_H"]?>"> <?=$LNG_TRANS_CHAR["EW00035"] //줄?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00030"] //배너 이미지 크기?></th>
				<td>
					<span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00022"] //가로?></span>: <input type="text" <?=$nBox?> name="a_size_w" id="a_size_w" style="width:30px;" maxlength="4" value="<?=$row["A_SIZE_W"]?>"> pixel
					<span class="spanTitle ml20"><?=$LNG_TRANS_CHAR["EW00023"] //세로?></span>: <input type="text" <?=$nBox?> name="a_size_h" id="a_size_h" style="width:30px;" maxlength="4" value="<?=$row["A_SIZE_H"]?>"> pixel
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00031"] //배너 간격?></th>
				<td>
					<span class="spanTitle"><?=$LNG_TRANS_CHAR["EW00022"] //가로?></span>: <input type="text" <?=$nBox?> name="a_margin_w" id="a_margin_w" style="width:30px;" maxlength="2" value="<?=$row["A_MARGIN_W"]?>"> pixel
					<span class="spanTitle ml20"><?=$LNG_TRANS_CHAR["EW00023"] //세로?></span>: <input type="text" <?=$nBox?> name="a_margin_h" id="a_margin_h" style="width:30px;" maxlength="2" value="<?=$row["A_MARGIN_H"]?>"> pixel
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00015"] //사용유무?></th>
				<td>
				<input type="radio" id="a_use" name="a_use" value="Y" <?= ($row["A_USE"] == "Y") ? "checked" : "" ?> ><?=$LNG_TRANS_CHAR["CW00010"] //사용함?>
				<input type="radio" id="a_use" name="a_use" value="N" <?= ($row["A_USE"] != "Y") ? "checked" : "" ?> ><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

    <div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goAdverAct('adverModify');" id="menu_auth_m" style="display:none"><strong class="ico_modify"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a class="btn_new_gray" href="javascript:goMoveUrl('adverList');"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
	</div>

	<!-- 기능 공지 시작 -->
		<div class="noticeWrap">
			<div class="titleNotice"><img src="/shopAdmin/himg/common/tit_notice.gif"/></div>
			* <?=$LNG_TRANS_CHAR["ES00009"] //배너그룹명은 예약어 코드로 사용됩니다.  간단명료하게 입력해 주시고, 자세한 설명은 설명부분에 입력하시면 됩니다.?><br/>
			  <span class="blank ml10"></span><?=$LNG_TRANS_CHAR["ES00010"] //등록하신 그룹명이 <strong>배너등록 화면에서 위치명</strong>으로 보여집니다?>.<br/>
			* <?=$LNG_TRANS_CHAR["ES00011"] //배너 배열 구성은 배너를 몇개씩 정렬할것인지 결정합니다.  가로3개 세로 1개로 설정한경우 해당영역에 1줄의 배너가 생성됩니다.?><br/>
			  <span class="blank ml10"></span><?=$LNG_TRANS_CHAR["ES00012"] //배너를 3개 입력하고 4개째 등록하게 등록순(우선순위가 있는경우 우선순위 순)으로 이전 배너가 빠지게 됩니다.?>
		</div>
	<!-- 기능 공지 끝 -->
<!-- ******** 컨텐츠 ********* -->