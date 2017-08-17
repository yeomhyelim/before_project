
<input type="hidden" name="receive_name" value="<?=$strRECEIVE_NAME?>">
<input type="hidden" name="receive_no" value="<?=$strRECEIVE_NO?>">
<input type="hidden" name="send_name" value="<?=$strSEND_NAME?>">
<input type="hidden" name="send_no" value="<?=$strSEND_NO?>">

<div class="autoSmsWrap">
	<div class='sendSmsWrap'>
		<div class='smsFormWrap'>
			<textarea name='ps_text' id='ps_text'></textarea>
			<p><strong>25/80</strong> Byte</p>
		</div>
		<div>
			보내는사람 : <input type="text" name="send_hp" value="<?=$strSEND_HP?>"> <br>
			받는사람 : <input type="text" name="receive_hp" value="<?=$strRECEIVE_HP?>">
		</div>
		<div class="buttonBoxWrap">
			<a class="btn_new_blue" href="javascript:postSmsSendActClickEvent()" id="btn_postSms_insert"><strong  class="ico_sms">발송</strong></a>
			<a class="btn_new_gray" href="javascript:postSmsCloseClickEvent()" id="btn_postSms_Cancel"><strong  class="ico_cancel">닫기</strong></a>
		</div>
	</div>
</div>

