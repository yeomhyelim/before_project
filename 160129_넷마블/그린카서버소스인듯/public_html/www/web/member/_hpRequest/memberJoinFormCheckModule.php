<?
	## 회원휴대폰인증여부 설정
	if($_REQUEST['PHPSESSID'] == "dlg1ugo62c01u92rqukn356ur5"):
	
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

		## STEP 4.
		## 인증키 정보
		$joinMode   = $_SESSION['SESS_MEMBER_JOIN_MODE'];
		$joinCnt	= $_SESSION['SESS_MEMBER_JOIN_CNT'];
		$joinTime	= $_SESSION['SESS_MEMBER_JOIN_TIME'];
		$joinKey	= $_SESSION['SESS_MEMBER_JOIN_KEY'];

		
		if(!$joinMode) { $joinMode = "REQUEST_MODE"; /* 인증키 요청 모드 */ }

	endif;
?>

<script type="text/javascript">
<!--
	$(document).ready(function(){

	});

	function goMemberJoinMoveEvent()			{ goMemberJoinMove();				} // 휴대폰인증
	function goMemberJoinKeyRequestActEvent()	{ goMemberJoinKeyRequestAct();		} // 인증키 요청
	function goMemberJoinKeyInputActEvent()		{ goMemberJoinKeyInputAct();		} // 인증키 확인
	function goMemberJoinKeyOkCloseEvent()		{ goMemberJoinKeyOkClose();			} // 인증키 완료


	function goMemberJoinKeyOkClose() {
		self.close();
	}

	function goMemberJoinMove() {
		var url = "./?menuType=member&mode=popMemberJoinCheck";
		window.open(url ,"", "width=300px,height=300px;");
	}

	function goMemberJoinKeyRequestAct() {
		var mode = "memberJoinKeyRequest";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goMemberJoinKeyInputAct() {
		var mode = "memberJoinKeyInput";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

//-->
</script>