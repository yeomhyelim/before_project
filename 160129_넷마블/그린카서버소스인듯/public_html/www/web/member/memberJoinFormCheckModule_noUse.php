<?
	## 회원휴대폰인증여부 설정

	if($_REQUEST['PHPSESSID'] == "e11osl7g20vmpenm5je1rh2ui7"):
	
		## 설정
		$phoneCheck = "Y";

		## STEP 1. 
		## 회원휴대폰인증여부 체크
		require_once MALL_CONF_LIB."MemberMgr.php";	
		$memberMgr		= new MemberMgr();
		$settingRow		= $memberMgr->getSettingView($db);
		if($settingRow['J_PHONE'] != "Y"):
			$phoneCheck = "";
		endif;
		
		## STEP 2.
		## 한국어 사이트 체크(한국어 사이트만 인증 가능함).
		if($S_SITE_LNG != "KR"):
			$phoneCheck = "";
		endif;

		## STEP 3.
		## 문자 발송 가능 건수 체크
		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
		$smsFunc		= new SmsFunc();
		$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
		if($smsMoney['VAL'] <= 0):
			$phoneCheck = "";
		endif;

		if($_REQUEST['joinMode'] == "SEND_KEY"):
			## STEP 4.
			## 인증키 생성
			require_once "{$S_DOCUMENT_ROOT}www/classes/string/string.func.class.php";
			$stringFunc							= new StringFunc();
			$key								= $stringFunc->getCode(6, "OP_INTEGER");
			$_SESSION['SESS_MEMBER_JOIN_CNT']	= $_SESSION['SESS_MEMBER_JOIN_CNT'] + 1;	// 요청 건수
			$_SESSION['SESS_MEMBER_JOIN_TIME']	= time();									// 요청 시간
			$_SESSION['SESS_MEMBER_JOIN_KEY']	= $key;										// 인증 키

			## STEP 5.
			## 인증키 전송
			$smsCode			= "001";
			$smsPhone			= "{$_REQUEST['hp']}";		
			$smsCallBackPhone	= $S_COM_PHONE;
			$smsMsg				= "[{$S_COM_NM }]본인인증번호는 {$key} 입니다. 정확히 입력해주세요.";
	//		$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
		elseif($_REQUEST['joinMode'] == "SEND_OK"):
			// 인증 완료
			$joinMode = $_SESSION['SESS_MEMBER_JOIN_MODE'];
		endif;

	endif;
?>

