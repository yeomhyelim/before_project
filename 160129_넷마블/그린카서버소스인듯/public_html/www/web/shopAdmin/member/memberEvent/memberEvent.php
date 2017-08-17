<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["MW00197"] //생일/기념일 관리?></h2>
	<div class="clr"></div>
</div>

<!-- ******** 컨텐츠 ********* -->
<div class="titInfoTxt mt20">
	* <?=$LNG_TRANS_CHAR["MS00055"] //생일/기념일에 적립금/SMS 발송을 설정합니다.?>
</div>

<div class="tableFormWrap">
	<table class="tableForm">
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00198"] //생일 포인트?></th>
			<td>
				<input type="text" name="birth_point" id="birth_point" value="<?=$row[S_SITE_BIRTH_SEND_POINT]?>" style="width:50px"> <?=$LNG_TRANS_CHAR["MW00200"] //지급?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00199"] //생일 SMS?></th>
			<td>
				<textarea name="birth_sms" id="birth_sms" style="width:500px;height50px"><?=$row[S_SITE_BIRTH_SEND_SMS]?></textarea>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00201"] //지급기준일?></th>
			<td>
				<select name="birth_send" id="birth_send">
					<option value="1" <?=($row[S_SITE_BIRTH_SEND_DAY] == "1")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00202"] //당일?></option>
					<option value="2" <?=($row[S_SITE_BIRTH_SEND_DAY] == "2")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00203"] //생일1일전?></option>
					<option value="3" <?=($row[S_SITE_BIRTH_SEND_DAY] == "3")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00204"] //생일2일전?></option>
					<option value="4" <?=($row[S_SITE_BIRTH_SEND_DAY] == "4")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00205"] //생일3일전?></option>
					<option value="5" <?=($row[S_SITE_BIRTH_SEND_DAY] == "5")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00206"] //생일4일전?></option>
					<option value="6" <?=($row[S_SITE_BIRTH_SEND_DAY] == "6")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00207"] //생일5일전?></option>
					<option value="7" <?=($row[S_SITE_BIRTH_SEND_DAY] == "7")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00208"] //생일6일전?></option>
					<option value="8" <?=($row[S_SITE_BIRTH_SEND_DAY] == "8")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00209"] //생일7일전?></option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="tableFormWrap mt20">
	<table class="tableForm">
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00210"] //결혼기념일 포인트?></th>
			<td>
				<input type="text" name="wed_point" id="wed_point" value="<?=$row[S_SITE_WED_SEND_POINT]?>" style="width:50px"> <?=$LNG_TRANS_CHAR["MW00200"] //지급?>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00211"] //결혼기념일 SMS?></th>
			<td>
				<textarea name="wed_sms" id="wed_sms" style="width:500px;height50px"><?=$row[S_SITE_WED_SEND_SMS]?></textarea>
			</td>
		</tr>
		<tr>
			<th><?=$LNG_TRANS_CHAR["MW00201"] //지급기준일?></th>
			<td>
				<select name="wed_send" id="wed_send">
					<option value="1" <?=($row[S_SITE_WED_SEND_DAY] == "1")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00202"] //당일?></option>
					<option value="2" <?=($row[S_SITE_WED_SEND_DAY] == "2")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00212"] //기념일1일전?></option>
					<option value="3" <?=($row[S_SITE_WED_SEND_DAY] == "3")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00213"] //기념일2일전?></option>
					<option value="4" <?=($row[S_SITE_WED_SEND_DAY] == "4")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00214"] //기념일3일전?></option>
					<option value="5" <?=($row[S_SITE_WED_SEND_DAY] == "5")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00215"] //기념일4일전?></option>
					<option value="6" <?=($row[S_SITE_WED_SEND_DAY] == "6")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00216"] //기념일5일전?></option>
					<option value="7" <?=($row[S_SITE_WED_SEND_DAY] == "7")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00217"] //기념일6일전?></option>
					<option value="8" <?=($row[S_SITE_WED_SEND_DAY] == "8")?"selected":"";?>><?=$LNG_TRANS_CHAR["MW00218"] //기념일7일전?></option>
				</select>
			</td>
		</tr>
	</table>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:javascript:goMemberEventSave();" id="menu_auth_m" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	<a class="btn_new_gray" href="#"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->