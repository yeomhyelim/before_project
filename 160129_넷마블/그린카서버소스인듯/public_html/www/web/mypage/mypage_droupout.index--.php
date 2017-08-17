<?
	## 설정
	$intPoint		= NUMBER_FORMAT($memberRow['M_POINT']);				// 보유하고 있는 포인트 점수
	$intDuring		= $settingRow['J_RE_DAY'];							// 재가입 할 수 없는 기간(일 단위)
?>

회원 탈퇴 

<br>

회원 탈퇴 신청 하기

<br>


회원 탈퇴 신청하시면 보유하고 계시는  <?=$intPoint?> 포인트는 자동 소멸 됩니다. <br>
탈퇴 신청 후  <?=$intDuring?> 일 동안은 재가입을 할 수 없습니다. <br>

> 재가입 후에도 소멸된 포인트는 복구 되지 않습니다. <br>
> 탈퇴 신청 방법<br>
    1. 탈퇴를 신청하게 된 사유를 입력합니다. <br>
    2. 비밀번호 확인란에 본인 재확인을 위해 비밀번호를 입력 합니다<br>
    3. 탈퇴신청 버튼을 누르면  탈퇴 신청이 완료 됩니다. <br>


<br>
<br>

탈퇴 사유		<input type="text"      name="out_txt"/> <br>
비밀번호 확인	<input type="password"  name="pass"/> <br><br>

<a href="javascript:goMypageDroupoutActEvent()">탈퇴신청</a>

