<?
	require_once MALL_CONF_LIB."MemberMgr.php";	
	require_once MALL_SHOP."/conf/member.inc.php";
	require_once MALL_SHOP."/conf/site_skin_member.conf.inc.php";

	$memberMgr	= new MemberMgr();
	
	/* 입점사 번호 확인 */
	if (!$_GET['shopNo']){
		goErrMsg($LNG_TRANS_CHAR["SS00001"]); //입점사번호 체크
		exit;
	}
	
	$intShopNo = $_GET['shopNo'];
	/* 회원가입항목 코드 */
	$strMemberJoinType = $_REQUEST["joinType"];
	$settingRow = $memberMgr->getSettingView($db);
	
	if ($S_SITE_LNG == "KR"){

		if ($settingRow[J_JUMIN] == "Y" || $settingRow[J_IPIN] == "Y"){

			$strRequestEncType	= $_POST["enc_type"];

			if (!$strRequestEncType){
				/* NAME CHECK */
				$strRequestName		= $_POST["sRequestName"];
				$strRequestNo		= $_POST["sRequestNO"];
				$strRequestSafeId	= $_POST["sSafeId"];
				
				$strBirth1			= (SUBSTR($strRequestSafeId,6,1) == "1" || SUBSTR($strRequestSafeId,6,1) == "2") ? "19":"20";
				$strBirth1		   .= SUBSTR($strRequestSafeId,0,2);	// 생년월일 (YYYYMMDD)
				$strBirth2			= SUBSTR($strRequestSafeId,2,2);	// 생년월일 (YYYYMMDD)
				$strBirth3			= SUBSTR($strRequestSafeId,4,2);	// 생년월일 (YYYYMMDD)

				$strSex				= (SUBSTR($strRequestSafeId,6,1) == "2" || SUBSTR($strRequestSafeId,6,1) == "4") ? "W":"M";	// 성별 코드 (개발 가이드 참조)
				/* NAME CHECK */

				if ($_SESSION['REQ_SEQ'] != $strRequestNo){
					goErrMsg("요청번호가 불일치 합니다. 다시 시도해주세요.");
					exit;
				}
			}

			if ($strRequestEncType == "I"){
				include MALL_HOME."/web/frwork/cerity/nice.ipinCheck.result.php";					
			}
			
			if (!$strRequestSafeId){
				goErrMsg("회원가입 인증을 받지 않으셨습니다.");
				exit;
			}

		}
	}

	$aryHp					= getCommCodeList("HP");
	$aryPhone				= getCommCodeList("PHONE");
	$aryJob					= getCommCodeList("JOB");
	$aryConcern				= getCommCodeList("CONCERN");

	/* 국가 리스트 */
	if ($S_SITE_LNG != "KR"){
		$aryCountryList		= getCountryList();			
		$aryCountryState	= getCommCodeList("STATE","");
	}

	/** 휴대폰 인증 모듈(사용 가능 여부 체크) **/

	## STEP 1.
	## 휴대폰 인증 모듈(세션 초기화)
	$_SESSION['SESS_MEMBER_JOIN_MODE']		= "";
	$_SESSION['SESS_MEMBER_JOIN_KEY']		= "";
	$phoneCheck								= "Y";

	## STEP 2. 
	## 휴대폰 인증 모듈(사용 유무 체크)
	$settingRow		= $memberMgr->getSettingView($db);
	if($settingRow['J_PHONE'] != "Y") { $phoneCheck = ""; }

	## STEP 3.
	## 휴대폰 인증 모듈(한국어 사이트 체크).
	if($S_SITE_LNG != "KR") { $phoneCheck = ""; }

	## STEP 4.
	## 휴대폰 인증 모듈(문자 발송 가능 건수 체크)
	require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
	$smsFunc		= new SmsFunc();
	$smsMoney		= $smsFunc->getSmsMoneySelect($db); // 머니 체크
	if($smsMoney['VAL'] <= 0) { $phoneCheck = ""; }
	
	/** 휴대폰 인증 모듈(사용 가능 여부 체크) **/
?>