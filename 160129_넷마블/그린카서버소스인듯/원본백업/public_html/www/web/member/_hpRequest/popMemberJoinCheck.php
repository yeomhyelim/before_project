<?
	## 설정
	## 세션 정보 초기화.
	if(!$_REQUEST['START']):
		$_SESSION['SESS_MEMBER_JOIN_MODE']		= "";
		$_SESSION['SESS_MEMBER_JOIN_CNT']		= "";
		$_SESSION['SESS_MEMBER_JOIN_TIME']		= "";
		$_SESSION['SESS_MEMBER_JOIN_KEY']		= "";
	endif;
?>

<?include "{$S_DOCUMENT_ROOT}www/include/header.inc.php"?>

<?include "memberJoinFormCheckModule.php";?>

<form name="form" method="post" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode"     value="<?=$strMode?>">
<input type="hidden" name="act"      value="<?=$strAct?>">


<?if($joinMode == "REQUEST_MODE"): // 인증키 요청 모드 ?>

휴대폰 번호 
	<select name="hp1">
		<option>010</option>
		<option>011</option>
		<option>016</option>
		<option>017</option>
		<option>018</option>
		<option>019</option>
	</select>
	-
	<input type="text" name="hp2">
	-
	<input type="text" name="hp3">

	<a href="javascript:goMemberJoinKeyRequestActEvent()">인증키 요청<a>


<?elseif($joinMode == "INPUT_MODE"): // 인증키 입력 모드 ?>

휴대폰으로 전송된 인증번호를 입력하여 주시기 바랍니다.<br><br>

인증번호 <input type="text" name="key"/> 

<a href="javascript:goMemberJoinKeyInputActEvent()"> 확인 </a>

<?elseif($joinMode == "REQUEST_OK"): // 인증키 확인 완료 ?>

휴대폰 인증이 완료되었습니다. <br><br>

<a href="javascript:goMemberJoinKeyOkCloseEvent()">닫기</a>


<?endif;?>


</form>
