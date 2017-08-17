<?
	## 기본 설정
	$phone1			= $S_COM_PHONE;
	$phone2			= $memberRow['M_HP'];	
	$fName			= $memberRow['M_F_NAME'];	
	$lName			= $memberRow['M_L_NAME'];	
	$no				= $memberRow['M_NO'];

	## 이름 정의
	$name			= "";
	if($fName):
		$name		= $fName; 
	endif;
	if($lName):
		if($name) { $name = "{$name} "; }
		$name = "{$name}{$lName}"; 
	endif;


?>
<input type="hidden" name="send_name" value="<?=$name?>">
<input type="hidden" name="send_no" value="<?=$no?>">
<div id="contentArea" style="margin:0 20px 0 10px;">
	<div class="sendSmsWrap" style="width:100%;">
		<div class="smsFormWrap left">
			<textarea name="sms_text" onkeydown="goSmsLengthCheckEvent(this, 80)"></textarea>
			<p><strong id="smsLeng">0/80</strong> Byte</p>
			<p><strong>&nbsp;</strong></p>
		</div>
		<div class="left" style="margin-left:15px;width:150px;">
			<div>
				<ul>
					<li>보내는사람 : <input type="text" name="send_hp" value="<?=$phone1?>"></li>
					<li class="mt10">받는사람 : <input type="text" name="receive_hp" value="<?=$phone2?>"></li>
				</ul>				
			</div>
			<div class="mt10">
				<a class="btn_big right" href="javascript:goSendSmsActEvent()" id="btn_postSms_insert" style="margin-right:20px;"><strong>발송</strong></a>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<div class="clr"></div>
</div>

<br>

<?include "memberSmsSendList.inc.php";?>