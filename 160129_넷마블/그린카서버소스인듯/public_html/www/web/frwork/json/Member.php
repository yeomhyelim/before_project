<?
//	require_once MALL_CLASS_SMS;
	require_once MALL_CONF_LIB."MemberMgr.php";	
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."SmsMgr.php";

	$memberMgr		= new MemberMgr();
	$productMgr		= new ProductMgr();
	$siteMgr		= new SiteMgr();
	$smsMgr			= new SmsMgr();

	$strM_ID		= $_POST["id"]			? $_POST["id"]			: $_REQUEST["id"];
	$strM_NICK_NAME = $_POST["nickname"]	? $_POST["nickname"]	: $_REQUEST["nickname"];
	$strM_MAIL		= $_POST["mail"]		? $_POST["mail"]		: $_REQUEST["mail"];
	$strM_COM_NM	= $_POST["comName"]		? $_POST["comName"]		: $_REQUEST["comName"];

	/* SearchID & SearchPWD */
	$strM_L_ID_NAME	= $_POST["searchId_L_Name"]	? $_POST["searchId_L_Name"]	: $_REQUEST["searchId_L_Name"];
	$strM_F_ID_NAME	= $_POST["searchId_F_Name"]	? $_POST["searchId_F_Name"]	: $_REQUEST["searchId_F_Name"];
	$strM_ID_MAIL1	= $_POST["searchId_Mail1"]	? $_POST["searchId_Mail1"]	: $_REQUEST["searchId_Mail1"];
	$strM_ID_MAIL2	= $_POST["searchId_Mail2"]	? $_POST["searchId_Mail2"]	: $_REQUEST["searchId_Mail2"];

	$strM_PASS_ID		= $_POST["searchPass_Id"]		? $_POST["searchPass_Id"]		: $_REQUEST["searchPass_Id"];
	$strM_L_PASS_NAME	= $_POST["searchPass_L_Name"]	? $_POST["searchPass_L_Name"]	: $_REQUEST["searchPass_L_Name"];
	$strM_F_PASS_NAME	= $_POST["searchPass_F_Name"]	? $_POST["searchPass_F_Name"]	: $_REQUEST["searchPass_F_Name"];
	$strM_PASS_MAIL1	= $_POST["searchPass_Mail1"]	? $_POST["searchPass_Mail1"]	: $_REQUEST["searchPass_Mail1"];
	$strM_PASS_MAIL2	= $_POST["searchPass_Mail2"]	? $_POST["searchPass_Mail2"]	: $_REQUEST["searchPass_Mail2"];

	$strM_PASS_HP1		= $_POST["searchPass_Hp1"]		? $_POST["searchPass_Hp1"]		: $_REQUEST["searchPass_Hp1"];
	$strM_PASS_HP2		= $_POST["searchPass_Hp2"]		? $_POST["searchPass_Hp2"]		: $_REQUEST["searchPass_Hp2"];
	$strM_PASS_HP3		= $_POST["searchPass_Hp3"]		? $_POST["searchPass_Hp3"]		: $_REQUEST["searchPass_Hp3"];
	/* SearchID & SearchPWD */
	

	/* 주소록관리 */
	$intMA_NO				= $_POST["addrNo"]			? $_POST["addrNo"]			: $_REQUEST["addrNo"];
	$strMA_TYPE				= $_POST["baddrType"]		? $_POST["baddrType"]		: $_REQUEST["baddrType"];

	$strO_B_NAME			= $_POST["bname"]			? $_POST["bname"]			: $_REQUEST["bname"];

	$strO_B_PHONE1			= $_POST["bphone1"]			? $_POST["bphone1"]			: $_REQUEST["bphone1"];
	$strO_B_PHONE2			= $_POST["bphone2"]			? $_POST["bphone2"]			: $_REQUEST["bphone2"];
	$strO_B_PHONE3			= $_POST["bphone3"]			? $_POST["bphone3"]			: $_REQUEST["bphone3"];
	$strO_B_PHONE			= $strO_B_PHONE1;
	if ($strO_B_PHONE2) $strO_B_PHONE .= "-".$strO_B_PHONE2;
	if ($strO_B_PHONE3) $strO_B_PHONE .= "-".$strO_B_PHONE3;

	$strO_B_HP1				= $_POST["bhp1"]			? $_POST["bhp1"]			: $_REQUEST["bhp1"];
	$strO_B_HP2				= $_POST["bhp2"]			? $_POST["bhp2"]			: $_REQUEST["bhp2"];
	$strO_B_HP3				= $_POST["bhp3"]			? $_POST["bhp3"]			: $_REQUEST["bhp3"];
	$strO_B_HP				= $strO_B_HP1;
	if ($strO_B_HP2) $strO_B_HP .= "-".$strO_B_HP2;
	if ($strO_B_HP3) $strO_B_HP .= "-".$strO_B_HP3;
	
	$strO_B_ZIP1			= $_POST["bzip1"]			? $_POST["bzip1"]			: $_REQUEST["bzip1"];
	$strO_B_ZIP2			= $_POST["bzip2"]			? $_POST["bzip2"]			: $_REQUEST["bzip2"];
	$strO_B_ZIP				= $strO_B_ZIP1;
	if ($strO_B_ZIP2) $strO_B_ZIP .= "-".$strO_B_ZIP2;
	
	$strO_B_COUNTRY			= $_POST["bcountry"]			? $_POST["bcountry"]			: $_REQUEST["bcountry"];
	$strO_B_CITY			= $_POST["bcity"]				? $_POST["bcity"]				: $_REQUEST["bcity"];
	$strO_B_STATE1			= $_POST["bstate_1"]			? $_POST["bstate_1"]			: $_REQUEST["bstate_1"];
	$strO_B_STATE2			= $_POST["bstate_2"]			? $_POST["bstate_2"]			: $_REQUEST["bstate_2"];
	$strO_B_STATE			= $strO_B_STATE1;
	if ($strO_B_COUNTRY == "US") $strO_B_STATE = $strO_B_STATE2;

	$strO_B_ADDR1			= $_POST["baddr1"]				? $_POST["baddr1"]				: $_REQUEST["baddr1"];
	$strO_B_ADDR2			= $_POST["baddr2"]				? $_POST["baddr2"]				: $_REQUEST["baddr2"];

	if (!$strMA_TYPE) $strMA_TYPE = "2";
	/* 주소록관리 */

	$result_array = array();

	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	/* 여기에 추가되어야 함(메일관련) */

	/** 2013.04.18 여기에 추가되어야 함(문자관련) **/
// 2015.01.15 kim hee sung sms v2.0 에서는 사용을 안합니다.
//	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
//	if(is_file($smsConfFile)):
//		require_once $smsConfFile;
//		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
//		$smsFunc = new SmsFunc();
//	endif;
	/** 2013.04.18 여기에 추가되어야 함(문자관련) **/

	switch ($strAct){

		case "findKoreaPwd":
			// 한국어 비밀번호 찾기
			// $S_MEM_CERITY == 2
			// $S_SITE_LNG == KR
			//
			// findGlobalPwd 와 함께 사용합니다.
			// break 문 사용 금지.
		case "findGlobalPwd":
			// 다국어 비밀번호 찾기
			// $S_MEM_CERITY == 2
			// $S_SITE_LNG != KR

			## 모듈 설정
			$objMemberMgrModule = new MemberMgrModule($db);

			## 기본 설정
			$strFirstName	= $_POST['firstName'];
			$strLastName	= $_POST['lastName'];
			$strEmail1		= $_POST['email1'];
			$strEmail2		= $_POST['email2'];
			$strEmailCode	= "003"; // 메일폼 번호
			$strLang		= $S_SITE_LNG;
			$strLangLower	= strtolower($strLang);
			$strMailDir		= MALL_SHOP . "/layout/mail";
			$strMailFile	= "mailContents_{$strLangLower}_{$strEmailCode}.html";

			## 공백제거
			$strFirstName = trim($strFirstName);
			$strLastName = trim($strLastName);
			$strEmail1 = trim($strEmail1);
			$strEmail2 = trim($strEmail2);

			## 임시 비밀번호 생성
			$strTmpPass		= getCode(8);
			$strTmpPass		= strtoupper($strTmpPass);

			## 메일 설정파일
			include_once "{$strMailDir}/_config.inc.php";

			## 메일 설정
			$strMailUse			= $EM_SETTING_USE;
			$strMailDataAuto	= $EM_SETTING_DATA[$strLang][$strEmailCode]['EM_AUTO'];
			$strMailDataSender	= $EM_SETTING_DATA[$strLang][$strEmailCode]['EM_SENDER'];
			$strMailDataTitle	= $EM_SETTING_DATA[$strLang][$strEmailCode]['EM_TITLE'];
			$strMailDataText	= FileDevice::getContents("{$strMailDir}/{$strMailFile}");

			## 기본 설정 체크
			if(!$strFirstName):
				$result['__STATE__']	= "NO_FIRST_NAME";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00052"]; // 이름을 입력하세요.
				break;
			endif;
			if(!$strLastName && $strAct == "findGlobalPwd"):
				$result['__STATE__']	= "NO_LAST_NAME";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00053"]; // 성명을 입력하세요.
				break;
			endif;
			if(!$strEmail1):
				$result['__STATE__']	= "NO_EMAIL1";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00055"]; // 이메일을 입력하세요.
				break;
			endif;
			if(!$strEmail2):
				$result['__STATE__']	= "NO_EMAIL2";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00055"]; // 이메일을 입력하세요.
				break;
			endif;
			if($strMailUse != "Y" || $strMailDataAuto != "Y"):
				$result['__STATE__']	= "NO_SEND_OPTION";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00060"]; // 비밀번호 찾기 기능을 지원하지 않습니다. 고객센터에 문의하세요.
				break;
			endif;

			## 이름 정의(미국이름형식)
			## 박영미 팀장님 지시사항
			## 공백을 제거하고, 성+이름을 모두 합치고, 공백을 제거하고, 소문자로 만든다음 비교
			$strName		= $strFirstName . $strLastName;
			$strName		= str_replace(" ", "", $strName);
			$strName		= strtolower($strName);

			## 이메일 정의
			$strEmail		= "{$strEmail1}@{$strEmail2}";
			if(!StringInfo::isEmailCheck($strEmail)):
				$result['__STATE__']	= "WRONG_EMAIL";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00059"]; // 잘못된 이메일 형식입니다.
				break;
			endif;

			## 데이터 불러오기
			$param = "";
			$param['M_MAIL'] = $strEmail;
			$aryMemberList = $objMemberMgrModule->getMemberMgrSelectEx("OP_ARYTOTAL", $param);

			## 이름 체크
			## 이메일 정보가 2개 이상 저장될수 있으므로 배열 형태로 체크
			$aryMemberRow = "";
			if($aryMemberList):
				foreach($aryMemberList as $key => $row):
					
					## 기본 설정
					$strM_F_NAME = $row['M_F_NAME'];
					$strM_L_NAME = $row['M_L_NAME'];

					## 이름 정의(미국이름형식)
					## 박영미 팀장님 지시사항
					## 공백을 제거하고, 성+이름을 모두 합치고, 공백을 제거하고, 소문자로 만든다음 비교
					$strM_NAME		= $strM_F_NAME . $strM_L_NAME;
					$strM_NAME		= str_replace(" ", "", $strM_NAME);
					$strM_NAME		= strtolower($strM_NAME);

					## 같은 이름인 회원 저장
					if($strM_NAME == $strName) { $aryMemberRow[] = $row; }

				endforeach;
			endif;

			## 체크
			if(!$aryMemberRow):
				$result['__STATE__']	= "NO_HAVE_MEMBER";
				$result['__MSG__']		= $LNG_TRANS_CHAR['MS00057']; // 등록된 회원 정보가 없습니다.
				break;
			endif;
			if(sizeof($aryMemberRow) > 1):
				$result['__STATE__']	= "HAVE_MORE_MEMBER";
				$result['__MSG__']		= $LNG_TRANS_CHAR['MS00062']; // 1개 이상의 중복 회원이 있습니다. 관리자에게 문의하세요.
				break;
			endif;

			## 기본 설정
			$aryMemberRow = $aryMemberRow[0];
			$intM_NO = $aryMemberRow['M_NO'];
			$strM_F_NAME = $aryMemberRow['M_F_NAME'];
			$strM_L_NAME = $aryMemberRow['M_L_NAME'];
			$intM_VISIT_CNT = $aryMemberRow['M_VISIT_CNT'];

			## 비밀번호 변경
			$param = "";
			$param['M_NO'] = $intM_NO;
			$param['M_PASS'] = $strTmpPass;
			$objMemberMgrModule->getMemberPwdUpdate($param);

			## 첫방문자 방문횟수 증가.
			## 이전 암호화 비밀번호인경우 방문자수를 update 해야 함.
			if(!$intM_VISIT_CNT):
				$param = "";
				$param['M_NO'] = $intM_NO;
				$objMemberMgrModule->getMemberVisitUpdate($param);
			endif;

			## 받는사람 이름 설정
			if($strM_F_NAME && $strM_L_NAME) { $strReceiveName = "{$strM_F_NAME} {$strM_L_NAME}"; }
			else if($strM_F_NAME) { $strReceiveName = $strM_F_NAME; }
			else { $strReceiveName = $strM_L_NAME; }

			## 메일 코드 설정
			$aryTag['{{__사이트이름__}}'] = $S_SITE_NM;
			$aryTag['{{__임시비밀번호__}}'] = $strTmpPass;
			$aryTag['{{__회사명__}}'] = $S_COM_NM;
			$aryTag['{{__회사주소__}}'] = "[{$S_COM_ZIP}] {$S_COM_ADDR}";
			$aryTag['{{__대표자명__}}'] = $S_REP_NM;
			$aryTag['{{__사업자번호__}}'] = $S_COM_NUM1;
			$aryTag['{{__통신번호__}}'] = $S_COM_NUM2;
			$aryTag['{{__전화번호__}}'] = $S_COM_PHONE;
			$aryTag['{{__개인정보_담당자__}}'] = $S_PIM_NAM;
			$aryTag['{{__개인정보_이메일__}}'] = $S_PIM_MAIL;
			$aryTag['{{__사이트주소__}}'] = $S_SITE_URL;
			$aryTag['{{__회원명__}}'] = $strReceiveName;


			## 메일 TEXT 만들기
			foreach($aryTag as $key => $data):
				$strMailDataTitle = str_replace($key, $data, $strMailDataTitle);
				$strMailDataText = str_replace($key, $data, $strMailDataText);
			endforeach;
	
			## 이메일 전송
			$param = "";
			$param['SEND_NAME'] = $S_SITE_NM;
			$param['SEND_EMAIL'] = $strMailDataSender;
			$param['RECEIVE_NAME'] = $strReceiveName;
			$param['RECEIVE_EMAIL'] = $strEmail;
			$param['TITLE'] = $strMailDataTitle;
			$param['TEXT'] = $strMailDataText;
			EmailInfo::goSendEmail($param);

			## 마무리
			$result['__STATE__']		= "SUCCESS";
			$result['__MSG__']			= $LNG_TRANS_CHAR['MS00061']; // 임시 비밀번호가 고객님의 메일로 발송되었습니다. 메일 발송이 지연되는 경우 고객센터로 문의 하시기 바랍니다.

		break;

		case "findKoreaId":
			// 한국어 아이디 찾기
			// $S_MEM_CERITY == 1
			// $S_SITE_LNG == KR
			//
			// findGlobalEmail 와 함께 사용합니다.
			// break 문 사용 금지.

		case "findKoreaEmail":
			// 한국어 이메일 찾기
			// $S_MEM_CERITY == 2
			// $S_SITE_LNG == KR
			//
			// findGlobalEmail 와 함께 사용합니다.
			// break 문 사용 금지.
		case "findGlobalEmail":
			// 다국어 이메일 찾기
			// $S_MEM_CERITY == 2
			// $S_SITE_LNG != KR

		case "findGlobalId":

			## 모듈 설정
			$objMemberMgrModule = new MemberMgrModule($db);
			
			## 기본 설정
			$strFirstName	= $_POST['firstName'];
			$strLastName	= $_POST['lastName'];
			//$strPhone		= $_POST['phone'];
			$strEmail1		= $_POST['email1'];
			$strEmail2		= $_POST['email2'];

			## 공백제거
			$strFirstName = trim($strFirstName);
			$strLastName = trim($strLastName);
			//$strPhone = trim($strPhone);
			$strEmail1 = trim($strEmail1);
			$strEmail2 = trim($strEmail2);

			## 이름 정의(미국이름형식)
			## 박영미 팀장님 지시사항
			## 공백을 제거하고, 성+이름을 모두 합치고, 공백을 제거하고, 소문자로 만든다음 비교
			$strName		= $strFirstName . $strLastName;
			$strName		= str_replace(" ", "", $strName);
			$strName		= strtolower($strName);

			## 기본 설정 체크
			if(!$strFirstName):
				$result['__STATE__']	= "NO_FIRST_NAME";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00052"]; // 이름을 입력하세요.
				break;
			endif;
			if(!$strLastName && $strAct == "findGlobalEmail"):
				$result['__STATE__']	= "NO_LAST_NAME";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00053"]; // 성명을 입력하세요.
				break;
			endif;
			//if(!$strPhone):
			//	$result['__STATE__']	= "NO_PHONE";
			//	$result['__MSG__']		= $LNG_TRANS_CHAR["MS00054"]; // 휴대폰을 입력하세요.
			//	break;
			//endif;
			if(!$strEmail1):
				$result['__STATE__']	= "NO_EMAIL1";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00055"]; // 이메일을 입력하세요.
				break;
			endif;
			if(!$strEmail2):
				$result['__STATE__']	= "NO_EMAIL2";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00055"]; // 이메일을 입력하세요.
				break;
			endif;


			## 이메일 정의
			$strEmail		= "{$strEmail1}@{$strEmail2}";
			if(!StringInfo::isEmailCheck($strEmail)):
				$result['__STATE__']	= "WRONG_EMAIL";
				$result['__MSG__']		= $LNG_TRANS_CHAR["MS00059"]; // 잘못된 이메일 형식입니다.
				break;
			endif;

			## 데이터 불러오기
			$param = "";
			//$param['M_HP'] = $strPhone;
			$param['M_MAIL'] = $strEmail;
			$aryMemberList = $objMemberMgrModule->getMemberMgrSelectEx("OP_ARYTOTAL", $param);

			## 이름 체크
			## 전화번호가 2개 이상 저장될수 있으므로 배열 형태로 체크
			$aryMemberRow = "";
			if($aryMemberList):
				foreach($aryMemberList as $key => $row):
					
					## 기본 설정
					$strM_F_NAME = $row['M_F_NAME'];
					$strM_L_NAME = $row['M_L_NAME'];	

					## 이름 정의(미국이름형식)
					## 박영미 팀장님 지시사항
					## 공백을 제거하고, 성+이름을 모두 합치고, 공백을 제거하고, 소문자로 만든다음 비교
					$strM_NAME		= $strM_F_NAME . $strM_L_NAME;
					$strM_NAME		= str_replace(" ", "", $strM_NAME);
					$strM_NAME		= strtolower($strM_NAME);

					## 이름이 같은 회원 정보 저장
					if($strM_NAME == $strName) { $aryMemberRow[] = $row; }

				endforeach;
			endif;

			## 체크
			if(!$aryMemberRow):
				$result['__STATE__']	= "NO_HAVE_MEMBER";
				$result['__MSG__']		= $LNG_TRANS_CHAR['MS00057']; // 등록된 회원 정보가 없습니다.
				break;
			endif;
			if(sizeof($aryMemberRow) > 1):
				$result['__STATE__']	= "HAVE_MORE_MEMBER";
				$result['__MSG__']		= $LNG_TRANS_CHAR['MS00062']; // 1개 이상의 중복 회원이 있습니다. 관리자에게 문의하세요.
				break;
			endif;

			## 기본 설정
			$aryMemberRow = $aryMemberRow[0];
			$strM_MAIL = $aryMemberRow['M_MAIL'];	
		 	$strM_ID = $aryMemberRow['M_ID'];	

			## 마무리
			if($strAct == 'findKoreaId' || $strAct == 'findGlobalId'):
				$result['__STATE__']		= "SUCCESS";
				$result['__MSG__']			= callLangTrans($LNG_TRANS_CHAR['MS00063'], array($strM_ID)); // 고객님의 아이디는 {{단어1}}입니다.//
			else:
				$result['__STATE__']		= "SUCCESS";
				$result['__MSG__']			= callLangTrans($LNG_TRANS_CHAR['MS00058'], array($strM_MAIL)); // 고객님의 이메일는 {{단어1}}입니다.
			endif;

		break;

		case "login":
			// 로그인

			## 모듈 설정
			require_once MALL_HOME . "/module2/MemberMgr.module.php";
			$memberMgr		= new MemberMgrModule($db);

			## 기본 설정
			$strID			= $_POST['id'];
			$strPW			= $_POST['pw'];
			$strSaveID		= $_POST['saveID'];
			$intLoginType	= $S_MEM_CERITY;
		
			## 기본 설정 체크
			if(!$strID):
				$result['__STATE__']	= "NO_ID";
				$result['__MSG__']		= "아이디를 입력하세요.";
				break;
			endif;
			if(!$strPW):
				$result['__STATE__']	= "NO_PW";
				$result['__MSG__']		= "비밀번호를 입력하세요.";
				break;
			endif;

			## 데이터 불러오기
			if($intLoginType == 1):
				// 아이디 방식
				$param					="";
				$param['M_ID']			= $strID;
				$param['M_PASS']		= $strPW;
			elseif($intLoginType == 2):
				/// 이메일 방식
				$param					="";
				$param['M_MAIL']		= $strID;
				$param['M_PASS']		= $strPW;
			endif;		
			$aryMemberRow				= $memberMgr->getMemberMgrSelectEx("OP_SELECT", $param);

			## 로그인 체크
			if(!$aryMemberRow):
				$result['__STATE__']	= "NO_LOGIN";
				$result['__MSG__']		= "아이디 혹은 비밀번호가 틀렸습니다.";
				break;
			endif;
			if($aryMemberRow['M_OUT'] == "Y"):
				$result['__STATE__']	= "OUT_MEMBER";
				$result['__MSG__']		= "탈퇴한 회원입니다.";
				break;
			endif;

			## 로그인 정보 설정
			if ($intLoginType == "1")	{ $_SESSION[SESS_MEMBER_ID]		= $aryMemberRow['M_ID'];		}
			else						{ $_SESSION[SESS_MEMBER_ID]		= $aryMemberRow['M_MAIL'];		}

			$_SESSION[SESS_MEMBER_LOGIN]				= true;
			$_SESSION[SESS_MEMBER_NAME]					= $aryMemberRow['M_F_NAME'];
			$_SESSION[SESS_MEMBER_LAST_NAME]			= $aryMemberRow['M_L_NAME'];		
			$_SESSION[SESS_MEMBER_GROUP]				= $aryMemberRow['M_GROUP'];
			$_SESSION[SESS_MEMBER_GROUP_NAME]			= $aryMemberRow['G_NAME'];
			$_SESSION[SESS_MEMBER_LEVEL]				= $aryMemberRow['G_LEVEL'];
			$_SESSION[SESS_MEMBER_NO]					= $aryMemberRow['M_NO'];
			$_SESSION[SESS_MEMBER_EMAIL]				= $aryMemberRow['M_MAIL'];
			$_SESSION[SESS_MEMBER_IPADDR]				= $S_REOMTE_ADDR;
			$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]		= false;
			$_SESSION[SESS_MEMBER_NICKNAME]				= $aryMemberRow['M_NICK_NAME'];

		
			## 방문 횟수 업데이트
			$param					= "";
			$param['M_NO']			= $aryMemberRow['M_NO'];
			$memberMgr->getMemberVisitUpdate($param);

			## ID 저장 설정
			setCookie("COOKIE_SAVE_ID", "", 0, "/");
			if($strSaveID == "Y"):
				setCookie("COOKIE_SAVE_ID", $_SESSION[SESS_MEMBER_ID], time()+(86400 * 30), "/");					
			endif;

			## 마무리
			$result['__STATE__']			= "SUCCESS";
			
		break;

		case "logout":
			// 로그아웃

			$_SESSION['SESS_MEMBER_LOGIN']				= false;
			$_SESSION['SESS_MEMBER_NAME']				= "";
			$_SESSION['SESS_MEMBER_LAST_NAME']			= "";	
			$_SESSION['SESS_MEMBER_GROUP']				= "";
			$_SESSION['SESS_MEMBER_GROUP_NAME']			= "";
			$_SESSION['SESS_MEMBER_LEVEL']				= "";
			$_SESSION['SESS_MEMBER_NO']					= "";
			$_SESSION['SESS_MEMBER_EMAIL']				= "";
			$_SESSION['SESS_MEMBER_IPADDR']				= "";
			$_SESSION['SESS_MEMBER_FACEBOOK_LOGIN']		= "";
			$_SESSION['SESS_MEMBER_NICKNAME']			= "";

			setCookie("COOKIE_CART_PRIKEY", "", 0, "/");

			session_destroy();

			## 마무리
			$result['__STATE__']						= "SUCCESS";

		break;

		case "searchId":
			/* 유효성 체크 */
			$strParamValidCheck = "Y";
			if (!$strM_L_ID_NAME || $strM_ID_MAIL1 || $strM_ID_MAIL2){
				$strParamValidCheck = "N";
				$result[0][MSG]		= $LNG_TRANS_CHAR["MS00022"]; //"입력하신 정보와 일치하는 회원정보가 없습니다.";
				$result[0][RET]		= "N";
			}
			
			if ($strParamValidCheck) 
			{
				$memberMgr->setM_L_ID_NAME($strM_L_ID_NAME);	/* 이름		*/
				$memberMgr->setM_F_ID_NAME($strM_F_ID_NAME);	/* 성		*/
				$memberMgr->setM_ID_MAIL1($strM_ID_MAIL1);		/* 구분 @ (front)  */
				$memberMgr->setM_ID_MAIL2($strM_ID_MAIL2);		/* 구분 @ (behind) */

				$row = $memberMgr->getMemberFindId($db);

				if ($row){
					$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR['OS00066'],array($row[M_ID]));//"아이디 : ". $row[M_ID]." 입니다.";
					$result[0][RET] = "Y";
				}else {
					$result[0][MSG] = $LNG_TRANS_CHAR["MS00022"]; //"입력하신 정보와 일치하는 회원정보가 없습니다.";
					$result[0][RET] = "N";
				}
			}

			$result_array = json_encode($result);
		break;
		case "searchPwdSms":
			$memberMgr->setM_PASS_ID($strM_PASS_ID);			/* 아이디  */
			$memberMgr->setM_L_PASS_NAME($strM_L_PASS_NAME);	/* 이름    */
			$memberMgr->setM_F_PASS_NAME($strM_F_PASS_NAME);	/* 이름    */
			$memberMgr->setM_PASS_HP1($strM_PASS_HP1);			/* 구분 - (front)  */
			$memberMgr->setM_PASS_HP2($strM_PASS_HP2);			/* 구분 - (center) */
			$memberMgr->setM_PASS_HP3($strM_PASS_HP3);			/* 구분 - (behind) */

			$row = $memberMgr->getMemberFindPwdSms($db);

			if ($row){
				
				/*  임시 비밀번호 생성 */
				$strTmpPass = STRTOUPPER(getCode(8));
				$memberMgr->setM_PASS($strTmpPass);
				
				$memberMgr->setM_NO($row[M_NO]);
				$memberMgr->getMemberPwdUpdate($db);	
				/*  임시 비밀번호 생성 */

				/* 이전 암호화 비밀번호인경우 방문자수를 update 해야 함 */
				if (!$row["M_VISIT_CNT"]){
					$memberMgr->setM_NO($row["M_NO"]);
					$memberMgr->getMemberVisitUpdate($db);
				}

				## 2015.01.15 kim hee sung SMS 모듈 V2.0
				## 한국어 전용
				## 관리자페이지에서 SMS 사용함 설정된 경우

				## 설정파일 불러오기
				include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';
	
				if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

					## 사용자 SMS
					## 모듈 설정
					$objSmsInfo = new SmsInfo($db);

					## 코드 설정
					$strSmsCode = "005"; // 비밀번호 찾기(고객용)

					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
						$strSmsMsg			= str_replace("{{고객명}}", $row['M_L_NAME'], $strSmsMsg);
						$strSmsMsg			= str_replace("{{변경된비밀번호}}", $strTmpPass, $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $row['M_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;

					## 관리자 SMS
					## 필요시 추가하세요..

				endif;					

				/* SMS 비밀번호 찾기(고객용) */
// 2013.04.19 모듈 변경
//				$strSmsMode			= $strAct;
//				$msg				= $LNG_TRANS_CHAR["MS00023"]; //"입력하신 정보로 임시 비밀번호가 발송되었습니다.";
//				include WEB_FRWORK_ACT."Sms.php";
				/* SMS 비밀번호 찾기(고객용) */
				
				/** 2013.04.18 SMS 전송 모듈 추가 **/
				## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
// 2015.01.15 kim hee sung 소스 정리 및 sms 작동 오류 수정
//				if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						$smsCode			= "005";
//						$smsPhone			= $row['M_HP'];		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{고객명}}", $row['M_L_NAME'], $smsMsg);
//						$smsMsg				= str_replace("{{변경된비밀번호}}", $strTmpPass, $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO']=="Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//				endif;
				/** 2013.04.18 SMS 전송 모듈 추가 **/
				
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00023"]; //"입력하신 정보로 임시 비밀번호가 발송되었습니다.";
				$result[0][RET] = "Y";
			

			}else {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00022"]; //"입력하신 정보와 일치하는 회원정보가 없습니다.";
				$result[0][RET] = "N";
			}
	
			$result_array = json_encode($result);

		break;
		case "searchPwd":
			$memberMgr->setM_PASS_ID($strM_PASS_ID);			/* 아이디  */
			$memberMgr->setM_F_PASS_NAME($strM_F_PASS_NAME);	/* 성    */
			$memberMgr->setM_L_PASS_NAME($strM_L_PASS_NAME);	/* 이름    */
			$memberMgr->setM_PASS_MAIL1($strM_PASS_MAIL1);		/* 구분 @ (front)  */
			$memberMgr->setM_PASS_MAIL2($strM_PASS_MAIL2);		/* 구분 @ (behind) */

			$row = $memberMgr->getMemberFindPwd($db);

//$result[0]['MSG'] = $db->query;
//$result_array = json_encode($result);
//break;
			if ($row){
				
				/*  임시 비밀번호 생성 */
				$strTmpPass = STRTOUPPER(getCode(8));
				$memberMgr->setM_PASS($strTmpPass);
				
				$memberMgr->setM_NO($row[M_NO]);
				$memberMgr->getMemberPwdUpdate($db);

				/* 이전 암호화 비밀번호인경우 방문자수를 update 해야 함 */
				if (!$row["M_VISIT_CNT"]){
					$memberMgr->setM_NO($row["M_NO"]);
					$memberMgr->getMemberVisitUpdate($db);
				}
				
				/* 임시 비밀번호 이메일 발송 */
//				$strPostMailName = $row[M_NAME];
//				$strPostMailAddr = $row[M_MAIL];
//				$strMailMode = $strAct;
//				include WEB_FRWORK_ACT."Mail.php";
				/* 임시 비밀번호 이메일 발송 */
				/*  임시 비밀번호 생성 */

				/** 메일 전송 **/
				$aryTAG_LIST['{{__받는사람이름__}}']	= $row['M_L_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $row['M_MAIL'];
				$aryTAG_LIST['{{__임시비밀번호__}}']	= $strTmpPass;
				$aryTAG_LIST['{{__회원명__}}']			= $row['M_L_NAME'];

//				if ($S_SHOP_HOME != "demo2"){
//					goSendMail("003");
//				} else {
//					goSendMail2("003");
//				}
				goSendMail("003");
//				exit;
				/** 메일 전송 **/

				/** 2013.04.18 SMS 전송 모듈 추가 **/
				/** 2013.04.18 SMS 전송 모듈로 이동 **/
				## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//				if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						$smsCode			= "005";
//						$smsPhone			= $row['M_HP'];		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{고객명}}", $row['M_L_NAME'], $smsMsg);
//						$smsMsg				= str_replace("{{변경된비밀번호}}", $strTmpPass, $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO']=="Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//				endif;
				/** 2013.04.18 SMS 전송 모듈 추가 **/

				$result[0][MSG] = $LNG_TRANS_CHAR["MS00023"]; //"입력하신 정보로 임시 비밀번호가 발송되었습니다.";
				$result[0][RET] = "Y";

				
			}else {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00022"]; //"입력하신 정보와 일치하는 회원정보가 없습니다.";
				$result[0][RET] = "N";
			}
	
			$result_array = json_encode($result);
		break;
		case "idChk":
			
			$memberMgr->setM_ID($strM_ID);
			$intTotalCount = $memberMgr->getMemberIdCheck($db);

			$intCount = $memberMgr->getMemberValidIdCheck($db);

			$intValidCount = 0;
			if($intTotalCount == $intCount){
				$intValidCount = $intCount;
			}

			if ($intValidCount > 0) {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00017"]; //"이미 등록된 아이디가 존재합니다.";
				$result[0][RET] = "N";
			} else {

				$arySetting = $memberMgr->getSettingView($db);

				$aryMemberReJoinCheck = $memberMgr->getMemberReJoinCheck($db);
				$intCountCheck = 0;

				if (is_array($aryMemberReJoinCheck)) {
					foreach ($aryMemberReJoinCheck as $key => $val) {
						$strMemberOutDate = explode(" ", $aryMemberReJoinCheck[$key]['M_OUT_DT']);
						$intOutDt = strtotime($strMemberOutDate[0]);
						$intNowDt = strtotime(date('Y-m-d'));
						$intLastDt = $intNowDt - $intOutDt;
						$intReJoinTime = 60 * 60 * 24 * $arySetting[J_RE_DAY];//초단위로계산
						//echo $intLastDt.":".$intReJoinTime;
						if ($intReJoinTime != 0) {
							if ($intLastDt < $intReJoinTime) {
								$intCountCheck++;
							}
						}
					}
				}

				if($intCountCheck > 0){
					$result[0][MSG] = '등록할수 없는 아이디 입니다.';//등록할수 없는 아이디 입니다.;
					$result[0][RET] = "N";
				}else{
					$result[0][MSG] = $LNG_TRANS_CHAR["MS00035"]; //"사용가능한 아이디입니다.";
					$result[0][RET] = "Y";
				}
			}

			$result_array = json_encode($result);
		break;

		case "nickNameChk":
			
			$memberMgr->setM_NICK_NAME($strM_NICK_NAME);
			$intCount = $memberMgr->getMemberNickNameCheck($db);

			if ($intCount > 0) {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00033"]; //"이미 등록된 닉네임이 존재합니다.";
				$result[0][RET] = "N";
			} else {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00036"]; //"사용가능한 닉네임입니다.";
				$result[0][RET] = "Y";
			}

			$result_array = json_encode($result);
		break;


		case "mailChk":
			
			$memberMgr->setM_MAIL($strM_MAIL);
			$intCount = $memberMgr->getMemberMailCheck($db);
			
			if ($intCount > 0){
				if ($g_member_login && $g_member_no){
					$memberMgr->setM_NO($g_member_no);
					$memberRow = $memberMgr->getMemberView($db);
					if ($memberRow['M_MAIL'] == $strM_MAIL) {
						$intCount = 0;
					}
				}
			}

			if ($intCount > 0) {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00012"]; //이미 등록된 이메일이 존재합니다.
				$result[0][RET] = "N";

			} else {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00016"]; //사용가능한 이메일입니다.
				$result[0][RET] = "Y";
			}

			$result_array = json_encode($result);
		break;

		case "comChk":

			$memberMgr->setM_COM_NM($strM_COM_NM);
			$intCount = $memberMgr->getMemberCompanyCheck($db);

			if ($intCount > 0) {
				$result[0][MSG] = "등록가능한 기업코드입니다."; //이미 등록된 이메일이 존재합니다.
				$result[0][RET] = "Y";
			} else {
				$result[0][MSG] = "등록되어있지 않은 기업코드입니다."; //사용가능한 이메일입니다.
				$result[0][RET] = "N";
			}

			$result_array = json_encode($result);

		
		break;

		case "facebook":
			
			$result[0][MSG] = "";
			$result[0][RET] = "N";					
			
			if ($strFaceBookUserId) { 
		
				try {
			
					$_facebook_user_profile = $facebook->api('/me'); // 유저 프로필을 가져 옵니다.
					if (is_array($_facebook_user_profile)){
						$memberMgr->setM_FACEBOOK_ID($_SESSION[$_facebook_user_id]);
						$memberMgr->setM_FACEBOOK_TOKEN($_SESSION[$_facebook_access_token]);
						$facebookRow = $memberMgr->getFaceBookLogin($db);
						
						if (is_array($facebookRow)){
														
							$_SESSION[SESS_MEMBER_LOGIN]			= true;
							$_SESSION[SESS_MEMBER_ID]				= $facebookRow[M_MAIL];
							$_SESSION[SESS_MEMBER_NAME]				= $facebookRow[M_F_NAME];
							$_SESSION[SESS_MEMBER_LAST_NAME]		= $facebookRow[M_L_NAME];
							$_SESSION[SESS_MEMBER_GROUP]			= $facebookRow[M_GROUP];
							$_SESSION[SESS_MEMBER_LEVEL]			= $facebookRow[G_LEVEL];
							$_SESSION[SESS_MEMBER_NO]				= $facebookRow[M_NO];
							$_SESSION[SESS_MEMBER_IPADDR]			= $S_REOMTE_ADDR;
							$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]	= true;
							
							/* 로그인시 장바구니 회원번호 update */
							$productMgr->setM_NO($facebookRow[M_NO]);
							$productMgr->setPB_KEY($g_cart_prikey);
							$productMgr->getProdBasketLoginUpdate($db);
							
							/* 방문수(로그인) UPDATE */
							$memberMgr->setM_NO($facebookRow[M_NO]);
							$memberMgr->getMemberVisitUpdate($db);

							/* 페이스북 ID,TOKEN UPDATE */
							
							$memberMgr->getMemberFaceBookUpdate($db);

							$result[0][MSG] = ""; //자동로그인 성공
							$result[0][RET] = "Y";
						}
					}
					
				}  catch (FacebookApiException $e) {
					$result[0][MSG] = "";
					$result[0][RET] = "N";			
				}
			} 

			$result_array = json_encode($result);
		break;
		
		case "memberBasicAddr":
			$memberMgr->setM_NO($g_member_no);
			$intBasicAddrCnt = $memberMgr->getMemberBasicAddrCount($db);
			
			$result[0][RET] = $intBasicAddrCnt;
			$result_array = json_encode($result);
		break;
		case "memberAddr":
			
			$memberMgr->setMA_NO($intMA_NO);
			$memberMgr->setM_NO($g_member_no);
			$memberMgr->setMA_TYPE($strMA_TYPE);
			$memberMgr->setMA_NAME($strO_B_NAME);
			$memberMgr->setMA_PHONE($strO_B_PHONE);
			$memberMgr->setMA_HP($strO_B_HP);
			$memberMgr->setMA_ZIP($strO_B_ZIP);
			$memberMgr->setMA_COUNTRY($strO_B_COUNTRY);
			$memberMgr->setMA_ADDR1($strO_B_ADDR1);
			$memberMgr->setMA_ADDR2($strO_B_ADDR2);
			$memberMgr->setMA_CITY($strO_B_CITY);
			$memberMgr->setMA_STATE($strO_B_STATE);

			if ($intMA_NO > 0) $memberMgr->getMemberAddrUpdate($db);
			else {
				$memberMgr->getMemberAddrInsert($db);
			}
			$result[0][MSG] = "";
			$result[0][RET] = "Y";

			$result_array = json_encode($result);
		break;

		case "memberAddrDelete":
			$intMA_NO				= $_POST["no"]			? $_POST["no"]			: $_REQUEST["no"];
			
			$memberMgr->setMA_NO($intMA_NO);
			$row = $memberMgr->getMemberAddrView($db);
			
			$result[0][MSG] = "";
			$result[0][RET] = "N";

			if ($row[M_NO] == $g_member_no){
				$memberMgr->getMemberAddrDelete($db);
				$result[0][MSG] = "";
				$result[0][RET] = "Y";
			}
			$result_array = json_encode($result);
			
		break;

		case "memberAddrList":
			$memberMgr->setM_NO($g_member_no);
			$aryMemberAddrList = $memberMgr->getMemberAddrList($db);

			## 2015.01.20 kim hee sung, 회원가입후, 배송지 정보가 없는 경우 가입정보가 출력되도록 추가함.
			## 2015.01.20 kim hee sung, '주문고객 정보와 동일합니다' 옵션으로 변경함.
//			if(!$aryMemberAddrList):
//				$memberMgr->setM_NO($g_member_no);
//				$memberRow	= $memberMgr->getMemberView($db);
//
//				$aryMemberAddrList[0]['MA_TYPE'] = '1';
//				$aryMemberAddrList[0]['MA_NAME'] = $memberRow['M_NAME'];
//				$aryMemberAddrList[0]['MA_PHONE'] = $memberRow['M_PHONE'];
//				$aryMemberAddrList[0]['MA_HP'] = $memberRow['M_HP'];
//				$aryMemberAddrList[0]['MA_ZIP'] = $memberRow['M_ZIP'];
//				$aryMemberAddrList[0]['MA_ADDR1'] = $memberRow['M_ADDR'];
//				$aryMemberAddrList[0]['MA_ADDR2'] = $memberRow['M_ADDR2'];
//				$aryMemberAddrList[0]['MA_COUNTRY'] = $memberRow['M_COUNTRY'];
//				$aryMemberAddrList[0]['MA_CITY'] = $memberRow['M_CITY'];
//				$aryMemberAddrList[0]['MA_STATE'] = $memberRow['M_STATE'];
//			endif;
			
			if (is_array($aryMemberAddrList)){
				for($i=0;$i<sizeof($aryMemberAddrList);$i++){
					
					$aryZip		= explode("-",$aryMemberAddrList[$i][MA_ZIP]);
					$aryPhone	= explode("-",$aryMemberAddrList[$i][MA_PHONE]);
					$aryHp		= explode("-",$aryMemberAddrList[$i][MA_HP]);

					$result[$aryMemberAddrList[$i][MA_NO]]["MA_TYPE"]		= $aryMemberAddrList[$i][MA_TYPE];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_ZIP"]		= $aryMemberAddrList[$i][MA_ZIP];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_ZIP1"]		= $aryZip[0];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_ZIP2"]		= $aryZip[1];

					$result[$aryMemberAddrList[$i][MA_NO]]["MA_PHONE1"]	= $aryPhone[0];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_PHONE2"]	= $aryPhone[1];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_PHONE3"]	= $aryPhone[2];

					$result[$aryMemberAddrList[$i][MA_NO]]["MA_HP1"]		= $aryHp[0];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_HP2"]		= $aryHp[1];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_HP3"]		= $aryHp[2];

					$result[$aryMemberAddrList[$i][MA_NO]]["MA_ADDR1"]	= $aryMemberAddrList[$i][MA_ADDR1];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_ADDR2"]	= $aryMemberAddrList[$i][MA_ADDR2];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_COUNTRY"]	= $aryMemberAddrList[$i][MA_COUNTRY];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_CITY"]		= $aryMemberAddrList[$i][MA_CITY];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_STATE"]	= $aryMemberAddrList[$i][MA_STATE];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_PHONE"]	= $aryMemberAddrList[$i][MA_PHONE];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_HP"]		= $aryMemberAddrList[$i][MA_HP];
					$result[$aryMemberAddrList[$i][MA_NO]]["MA_NAME"]		= $aryMemberAddrList[$i][MA_NAME];
					
				}
			}

			$result_array = json_encode($result);

		break;

		case "memberFamily":
			
			if ($S_MEM_FAMILY == "Y"){
				$memberMgr->setM_NO($g_member_no);
				$aryMemberFamilyList = $memberMgr->getMemberFamilyList($db);
				
				 include sprintf ( "%s%s/layout/member/member_family.html.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  );
			}

			$db->disConnect();
			exit;
		break;

		case "memberPointMove":
			/* 포인트 이동 */
			
			if (!$g_member_no){
				$result[0][MSG]		= "로그인을 해주세요."; //"로그인을 해주세요.";
				$result[0][RET]		= "N";
				$result[0][CODE]	= "9999";

				$result_array = json_encode($result);		
				$db->disConnect();

				echo $result_array;
				exit;
			}
			
			/** 파라미터 설정 **/
			$intM_NO			= $g_member_no;
			$strPointGiveType	= $_POST["pointGiveType"];
			$intPT_POINT		= $_POST["pointMark"];
			$strPT_MEMO			= $_POST["pointMemo"];

			$memberMgr->setM_NO($intM_NO);
			$memberRow = $memberMgr->getMemberView($db);
			
			if ($memberRow['M_POINT'] <= 0){
				$result[0][MSG]		= "이동하실 포인트가 없습니다."; //"이동하실 포인트가 없습니다.";
				$result[0][RET]		= "N";
				$result[0][CODE]	= "";

				$result_array = json_encode($result);		
				$db->disConnect();

				echo $result_array;
				exit;			
			}

			if ($strPointGiveType == "C"){
				
				$aryMoveMemCateList = $_POST["pointGiveCode"];
				if (!is_array($aryMoveMemCateList)){
					$result[0][MSG]		= "이동하실 소속이 없습니다."; //"이동하실 소속이 없습니다.";
					$result[0][RET]		= "N";
					$result[0][CODE]	= "";

					$result_array = json_encode($result);		
					$db->disConnect();

					echo $result_array;
					exit;					
				}

				$aryMoveMemList = "";
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr	= new MemberCateMgr();
				$i = 0;
				foreach($aryMoveMemCateList as $key => $val){
					$param = "";
					$param['C_CODE'] = $val;
					$memberCateRow = $memberCateMgr->getMemberCateListEx($db,"OP_SELECT",$param);
					if ($memberCateRow['C_M_NO'] > 0){
						$aryMoveMemList[$i] = $memberCateRow['C_M_NO'];
						$i++;
					}
				}
			} else {
				$aryMoveMemList = $_POST["chkMemMoveNo"];
			}
		
			if (!is_array($aryMoveMemList)){
				$result[0][MSG]		= "포인트를 이동하실 회원이 존재하지 않습니다."; //"포인트를 이동하실 회원이 존재하지 않습니다.";
				$result[0][RET]		= "N";
				$result[0][CODE]	= "";
				$result_array = json_encode($result);		
				$db->disConnect();

				echo $result_array;

				exit;
			}
			
			/** 주문 클래스 */
			require_once MALL_CONF_LIB."OrderMgr.php";
			$orderMgr = new OrderMgr();
			/** 주문 클래스 */

			$intMoveMemCnt = 0;
			if (is_array($aryMoveMemList)){
				for($i=0;$i<sizeof($aryMoveMemList);$i++){
					$intMoveMemNo  = $aryMoveMemList[$i]; 
					if ($intM_NO != $intMoveMemNo){
						$memberMgr->setM_NO($intM_NO);
						$memberRow = $memberMgr->getMemberView($db);

						if ($memberRow['M_POINT'] < $intPT_POINT){
							$result[0][MSG] = "보유한 포인트가 이동할 포인트가 부족합니다."; //"보유한 포인트가 이동할 포인트보다 크지 않습니다.";
							$result[0][RET] = "N";
							$result[0][CODE]	= "";

							$result_array = json_encode($result);		
							$db->disConnect();

							echo $result_array;

							exit;
						}

						/* 포인트 이동 */
						$orderMgr->setM_NO($intMoveMemNo);
						$orderMgr->setB_NO(0);
						$orderMgr->setO_NO(0);
						$orderMgr->setPT_TYPE("010");
						$orderMgr->setPT_POINT($intPT_POINT);
						$orderMgr->setPT_MEMO($strPT_MEMO);
						$orderMgr->setPT_START_DT(date("Y-m-d"));
						$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
						$orderMgr->setPT_REG_IP($S_REMOTE_ADDR);
						$orderMgr->setPT_ETC($strPT_ETC);
						$orderMgr->setPT_REG_NO($intM_NO);
						$orderMgr->getOrderPointInsert($db);

						$memberMgr->setM_POINT($intPT_POINT);
						$memberMgr->setM_NO($intMoveMemNo);
						$memberMgr->getMemberPointUpdate($db);

						/* 포인트 이동으로 인한 차감 */
						$orderMgr->setM_NO($intM_NO);
						$orderMgr->setB_NO(0);
						$orderMgr->setO_NO(0);
						$orderMgr->setPT_TYPE("011");
						$orderMgr->setPT_POINT(-$intPT_POINT);
						$orderMgr->setPT_MEMO($strPT_MEMO);
						$orderMgr->setPT_START_DT(date("Y-m-d"));
						$orderMgr->setPT_END_DT(date("Y-m-d"));
						$orderMgr->setPT_REG_IP($S_REMOTE_ADDR);
						$orderMgr->setPT_ETC($intMoveMemNo); //준회원
						$orderMgr->setPT_REG_NO($a_admin_no);
						$orderMgr->getOrderPointInsert($db);

						$memberMgr->setM_POINT(-$intPT_POINT);
						$memberMgr->setM_NO($intM_NO);
						$memberMgr->getMemberPointUpdate($db);

						$intMoveMemCnt++;
					}
				}
			}
			
			if ($intMoveMemCnt > 0){
				if ($strPointGiveType == "C"){
					$result[0][MSG] = "총 ".$intMoveMemCnt." 소속에게 포인트 이동이 되었습니다."; //"총 10명에게 포인트 이동이 되었습니다."";
				} else {
					$result[0][MSG] = "총 ".$intMoveMemCnt."명에게 포인트 이동이 되었습니다."; //"총 10명에게 포인트 이동이 되었습니다."";
				}
				$result[0][RET] = "Y";

			} else {
				$result[0][MSG] = "포인트 이동이 되지 않았습니다.";
				$result[0][RET] = "N";
			}
			
			$result_array = json_encode($result);		
			$db->disConnect();

			echo $result_array;

			exit;
		break;
		case "findEmail":
			// 이메일 찾기

			## 모듈 설정
			$objMemberMgrModule = new MemberMgrModule($db);

			## 기본 설정
			$strName = $_POST['name'];
			$strHp1 = $_POST['hp1'];
			$strHp2 = $_POST['hp2'];
			$strHp3 = $_POST['hp3'];
			$strHp = "{$strHp1}-{$strHp2}-{$strHp3}";

			## 기본 설정 체크
			if(!$strName):
				$result['__STATE__']	= "NO_NAME";
				$result['__MSG__']		= "성명 값이 없습니다.";
				break;
			endif;
			if(!$strHp1):
				$result['__STATE__']	= "NO_HP1";
				$result['__MSG__']		= "휴대폰 값이 없습니다.";
				break;
			endif;
			if(!$strHp2):
				$result['__STATE__']	= "NO_HP2";
				$result['__MSG__']		= "휴대폰 값이 없습니다.";
				break;
			endif;
			if(!$strHp3):
				$result['__STATE__']	= "NO_HP3";
				$result['__MSG__']		= "휴대폰 값이 없습니다.";
				break;
			endif;

			## 휴대폰 회원 검색
			$param = "";
			$param['M_HP'] = $strHp;
			$aryMemberList = $objMemberMgrModule->getMemberMgrSelectEx("OP_ARYTOTAL", $param);
			if(!$aryMemberList):
				$result['__STATE__']	= "NO_DATA";
				$result['__MSG__']		= "휴대폰 정보를 찾지 못했습니다.";
				break;
			endif;

			## 이름 비교하여, 이메일 찾기
			$strEMail = "";
			foreach($aryMemberList as $key => $data):
				## 기본 정보
				$strM_NAME = $data['M_NAME'];
				$strM_MAIL = $data['M_MAIL'];

				## 이름 비교
				if($strM_NAME == $strName):
					$strEMail = $strM_MAIL;	
				endif;				
			endforeach;

			## 체크
			if(!$strEMail):
				$result['__STATE__']	= "NO_DATA";
				$result['__MSG__']		= "회원 정보를 찾지 못했습니다.";
				break;
			endif;

			## 전달 데이터 만들기
			$data['email']				= $strEMail;

			## 마무리
			$result['__STATE__']		= "SUCCESS";
			$result['__DATA__']			= $data;

		break;
	}


	if(in_array($strAct, array("login", "logout", "findEmail", "findGlobalEmail","findKoreaEmail", "findGlobalPwd", "findKoreaPwd", "findGlobalId", "findKoreaId"))):
		$db->disConnect();
		if(!$result) { $result = print_r($_POST, true); }
		echo json_encode($result);
		exit;
	endif;

	$db->disConnect();
	
	echo $result_array;

?>