<?include "{$S_DOCUMENT_ROOT}www/include/header.inc.php"?>

<script language="javascript" type="text/javascript" src="../common/js/kkcountdown.js"></script>

<?include "memberJoinFormCheckModule.php";?>

<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode"     value="<?=$strMode?>">
<input type="hidden" name="act"      value="<?=$strAct?>">

<?if($_REQUEST['joinMode'] == "SEND_KEY"):?>

휴대폰(<?=$_REQUEST['hp']?>)으로 전송된 인증번호를 입력하여 주시기 바랍니다.<br><br>
인증번호 <input type="text" name="key"/> <br>

남은 시간 : <span class="kkcount-down" data-time="1369028091"></span>

<a href="javascript:goMemberPhoneKeyCheckActEvent()"> 확인 </a>

<?elseif($_REQUEST['joinMode'] == "SEND_OK"):?>

휴대폰 인증이 완료되었습니다. <br>
<input type="text" name="key" value="<?=$_REQUEST['key']?>"/> 
<a href="javascript:goMemberPhoneKeyCheckOkEvent()"> 확인 </a>

<?endif;?>


</form>
