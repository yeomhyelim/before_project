<?

	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$pointMgr = new PointMgr();
	$orderMgr = new OrderMgr();

	require_once "basic.param.inc.php";

	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Parameter 셋팅 #####################################*/

	$strSearchKey	= $_POST["q"]			? $_POST["q"]			: $_GET["q"];
	$strCallBack	= $_POST["callback"]	? $_POST["callback"]	: $_GET["callback"];
	$strM_ID		= $_POST["id"]			? $_POST["id"]			: $_REQUEST["id"];

	switch ($strAct) {
	case "resultStateChange":
		// 관리자 상담관리 결과상태 변경

		## 모듈 설정
		require_once MALL_HOME . "/module2/BoardAddField.module.php";
		$boardAddField				= new BoardAddFieldModule($db);

		## 기본 설정
		$bCode						= $_POST['b_code'];
		$adUbNo						= $_POST['no'];
//		$adTemp13					= $_POST['resultState']; // 2014.03.31 kim hee sung 잘못된듯...
		$adTemp1					= $_POST['resultState'];

		## 기본 설정 체크
		if(!$bCode):
			$result['__STATE__']	= "NO_CODE";
			break;
		endif;
		if(!$adUbNo):
			$result['__STATE__']	= "NO_NO";
			break;
		endif;

		## 추가필드 데이터 불러오기
		$param						= "";
		$param['B_CODE']			= $bCode;
		$param['AD_UB_NO']			= $adUbNo;
		$boardAddFieldRow			= $boardAddField->getBoardAddFieldSelectEx("OP_SELECT", $param);

		## 추가필드가 등록되어 있으면 삭제
		if($boardAddFieldRow):
			## 내용 추가
			$param					= "";
			$param['B_CODE']		= $bCode;
			$param['AD_UB_NO']		= $adUbNo;
			$boardAddField->getBoardAddFieldDeleteEx($param);
		endif;

		## 내용 등록
		$param					= "";
		$param['B_CODE']		= $bCode;
		$param['AD_UB_NO']		= $adUbNo;
		$param['AD_PHONE1']		= $boardAddFieldRow['AD_PHONE1'];
		$param['AD_PHONE2']		= $boardAddFieldRow['AD_PHONE2'];
		$param['AD_PHONE3']		= $boardAddFieldRow['AD_PHONE3'];
		$param['AD_ZIP']		= $boardAddFieldRow['AD_ZIP'];
		$param['AD_ADDR1']		= $boardAddFieldRow['AD_ADDR1'];
		$param['AD_ADDR2']		= $boardAddFieldRow['AD_ADDR2'];
		$param['AD_COMPANY']	= $boardAddFieldRow['AD_COMPANY'];
		$param['AD_TEMP1']		= $adTemp1;
		$param['AD_TEMP2']		= $boardAddFieldRow['AD_TEMP2'];
		$param['AD_TEMP3']		= $boardAddFieldRow['AD_TEMP3'];
		$param['AD_TEMP4']		= $boardAddFieldRow['AD_TEMP4'];
		$param['AD_TEMP5']		= $boardAddFieldRow['AD_TEMP5'];
		$param['AD_TEMP6']		= $boardAddFieldRow['AD_TEMP6'];
		$param['AD_TEMP7']		= $boardAddFieldRow['AD_TEMP7'];
		$param['AD_TEMP8']		= $boardAddFieldRow['AD_TEMP8'];
		$param['AD_TEMP9']		= $boardAddFieldRow['AD_TEMP9'];
		$param['AD_TEMP10']		= $boardAddFieldRow['AD_TEMP10'];
		$param['AD_TEMP11']		= $boardAddFieldRow['AD_TEMP11'];
		$param['AD_TEMP12']		= $boardAddFieldRow['AD_TEMP12'];
		$param['AD_TEMP13']		= $boardAddFieldRow['AD_TEMP13'];
		$param['AD_TEMP14']		= $boardAddFieldRow['AD_TEMP14'];
		$param['AD_TEMP15']		= $boardAddFieldRow['AD_TEMP15'];
		$param['AD_TEMP16']		= $boardAddFieldRow['AD_TEMP16'];
		$param['AD_TEMP17']		= $boardAddFieldRow['AD_TEMP17'];
		$param['AD_TEMP18']		= $boardAddFieldRow['AD_TEMP18'];
		$param['AD_TEMP19']		= $boardAddFieldRow['AD_TEMP19'];
		$param['AD_TEMP20']		= $boardAddFieldRow['AD_TEMP20'];
		$boardAddField->getBoardAddFieldInsertEx($param);

		## 마무리
		$result['__STATE__']		= "SUCCESS";

	break;

	case "memberSendEmail":
		// Email	전송

		// 모듈 설정
		require_once MALL_HOME . "/classes/client/ClientInfo.class.php";
		require_once MALL_HOME . "/classes/email/EmailInfo.class.php";
		require_once MALL_HOME . "/module2/PostEmailLog.module.php";
		$emailInfo					= new EmailInfo();
		$postEmailLog				= new PostEmailLogModule($db);

		## 기본 설정
		$memberNo					= $_POST['memberNo'];
		$sendName					= $_POST['sendName'];
		$sendEmail					= $_POST['sendEmail'];
		$receiveName				= $_POST['receiveName'];
		$receiveEmail				= $_POST['receiveEmail'];
		$title						= $_POST['title'];
		$text						= $_POST['text'];
		$ip							= ClientInfo::getClientIP();
		$regNo						= $_SESSION['ADMIN_NO'];

		## 기본 설정 체크
		if(!$sendName):
			$result['__STATE__']	= "NO_SEND_NAME";
			$result['__MSG__']		= "보내는 사람 이름 정보가 필요합니다.";
			break;
		endif;
		if(!$sendEmail):
			$result['__STATE__']	= "NO_SEND_EMAIL";
			$result['__MSG__']		= "보내는 사람 메일 정보가 필요합니다.";
			break;
		endif;
		if(!$receiveName):
			$result['__STATE__']	= "NO_RECEIVE_NAME";
			$result['__MSG__']		= "받는 사람 이름 정보가 필요합니다.";
			break;
		endif;
		if(!$receiveEmail):
			$result['__STATE__']	= "NO_RECEIVE_EMAIL";
			$result['__MSG__']		= "받는 사람 메일 정보가 필요합니다.";
			break;
		endif;
		if(!$title):
			$result['__STATE__']	= "NO_TITLE";
			$result['__MSG__']		= "제목 정보가 필요합니다.";
			break;
		endif;
		if(!$text):
			$result['__STATE__']	= "NO_TEXT";
			$result['__MSG__']		= "내용 정보가 필요합니다.";
			break;
		endif;

		## html 사용 체크
		if($html != "Y"):
			$text		= str_replace("\r", "", $text);
			 $text		= str_replace("\n", "<br>", $text);
		endif;

		## 메일 발송
		$param							= "";
		$param['SEND_NAME']				= $sendName;
		$param['SEND_EMAIL']			= $sendEmail;
		$param['RECEIVE_NAME']			= $receiveName;
		$param['RECEIVE_EMAIL']			= $receiveEmail;
		$param['TITLE']					= $title;
		$param['TEXT']					= $text;
		$re								= $emailInfo->goSendEmail($param);

		## 메일 발송 로그 생성
		$param							= "";
//		$param['PL_NO']					= "";
		$param['PL_PM_NO']				= -20;					// 고정값 : -20 은 CRM 전송이라는것을 의미
		$param['PL_TO_M_NO']			= $memberNo;
		$param['PL_TO_M_MAIL']			= $receiveEmail;
		$param['PL_TO_M_NAME']			= $receiveName;
		$param['PL_FROM_M_NO']			= $regNo;
		$param['PL_FROM_M_MAIL']		= $sendEmail;
		$param['PL_FROM_M_NAME']		= $sendName;
		$param['PL_TITLE']				= $title;
		$param['PL_TEXT']				= $text;
		$param['PL_IP']					= $ip;
		$param['PL_SEND_DATE']			= "NOW()";
		$param['PL_SEND_RESULT']		= $re;
		$param['PL_REG_DT']				= "NOW()";
		$param['PL_REG_NO']				= $regNo;
		$postEmailLog->getPostEmailLogInsertEx($param);

		## 마무리
		$result['__STATE__']		= "SUCCESS";

	break;

	case "memberSendEmail2":
		// Email	전송

		// 모듈 설정
		require_once MALL_HOME . "/classes/client/ClientInfo.class.php";
		require_once MALL_HOME . "/classes/email/email.class.php";
		require_once MALL_HOME . "/module2/PostEmailLog.module.php";
		$emailInfo					= new EmailInfo ;
		$postEmailLog				= new PostEmailLogModule($db);

		## 기본 설정
		$memberNo					= $_POST['memberNo'];
		$sendName					= $_POST['sendName'];
		$sendEmail					= $_POST['sendEmail'];
		$receiveName				= $_POST['receiveName'];
		$receiveEmail				= $_POST['receiveEmail'];
		$title						= $_POST['title'];
		$text						= $_POST['text'];
		$ip							= ClientInfo::getClientIP();
		$regNo						= $_SESSION['ADMIN_NO'];

		## 기본 설정 체크
		if(!$sendName):
			$result['__STATE__']	= "NO_SEND_NAME";
			$result['__MSG__']		= "보내는 사람 이름 정보가 필요합니다.";
			break;
		endif;
		if(!$sendEmail):
			$result['__STATE__']	= "NO_SEND_EMAIL";
			$result['__MSG__']		= "보내는 사람 메일 정보가 필요합니다.";
			break;
		endif;
		if(!$receiveName):
			$result['__STATE__']	= "NO_RECEIVE_NAME";
			$result['__MSG__']		= "받는 사람 이름 정보가 필요합니다.";
			break;
		endif;
		if(!$receiveEmail):
			$result['__STATE__']	= "NO_RECEIVE_EMAIL";
			$result['__MSG__']		= "받는 사람 메일 정보가 필요합니다.";
			break;
		endif;
		if(!$title):
			$result['__STATE__']	= "NO_TITLE";
			$result['__MSG__']		= "제목 정보가 필요합니다.";
			break;
		endif;
		if(!$text):
			$result['__STATE__']	= "NO_TEXT";
			$result['__MSG__']		= "내용 정보가 필요합니다.";
			break;
		endif;

		## html 사용 체크
		if($html != "Y"):
			$text		= str_replace("\r", "", $text);
			 $text		= str_replace("\n", "<br>", $text);
		endif;

		## 메일 발송
		$param							= "";
		$param['SEND_NAME']				= $sendName;
		$param['SEND_EMAIL']			= $sendEmail;
		$param['RECEIVE_NAME']			= $receiveName;
		$param['RECEIVE_EMAIL']			= $receiveEmail;
		$param['TITLE']					= $title;
		$param['TEXT']					= $text;
		$re								= $emailInfo->goSendEmail($param);

		## 메일 발송 로그 생성
		$param							= "";
//		$param['PL_NO']					= "";
		$param['PL_PM_NO']				= -20;					// 고정값 : -20 은 CRM 전송이라는것을 의미
		$param['PL_TO_M_NO']			= $memberNo;
		$param['PL_TO_M_MAIL']			= $receiveEmail;
		$param['PL_TO_M_NAME']			= $receiveName;
		$param['PL_FROM_M_NO']			= $regNo;
		$param['PL_FROM_M_MAIL']		= $sendEmail;
		$param['PL_FROM_M_NAME']		= $sendName;
		$param['PL_TITLE']				= $title;
		$param['PL_TEXT']				= $text;
		$param['PL_IP']					= $ip;
		$param['PL_SEND_DATE']			= "NOW()";
		$param['PL_SEND_RESULT']		= $re;
		$param['PL_REG_DT']				= "NOW()";
		$param['PL_REG_NO']				= $regNo;
		$postEmailLog->getPostEmailLogInsertEx($param);

		## 마무리
		$result['__STATE__']		= "SUCCESS";

	break;

	case "memberSendSms":
		// SMS 전송

		## 모듈 설정
		require_once MALL_HOME . "/classes/sms/sms2.func.class.php";
		require_once MALL_HOME . "/module2/SiteInfo.module.php";
		require_once MALL_HOME . "/module2/PostSmsLog.module.php";
		$smsFunc					= new SmsFunc2();
		$siteInfo					= new SiteInfoModule($db);
		$postSmsLog					= new PostSmsLogModule($db);

		## 기본 설정
		$sendNo						= $_POST['sendNo'];
		$sendName					= $_POST['sendName'];
		$sendHp						= $_POST['sendHp'];
		$receiveHp					= $_POST['receiveHp'];
		$smsText					= $_POST['smsText'];
		$memberNo					= $_SESSION['ADMIN_NO'];
		$memberName					= $_SESSION['ADMIN_NAME'];
		$siteName					= $S_SITE_NM;

		## 기본 설정 체크
		if(!$sendHp):
			$result['__STATE__']	= "NO_SEND_HP";
			break;
		endif;
		if(!$receiveHp):
			$result['__STATE__']	= "NO_RECEIVE_HP";
			break;
		endif;
		if(!$smsText):
			$result['__STATE__']	= "NO_SMS_TEXT";
			break;
		endif;

		## 문자 발송 가능 여부 체크
		$param						= "";
		$param['COL']				= "S_SMS_USE";
		$siteInfoRow				= $siteInfo->getSiteInfoSelectEx("OP_SELECT", $param);
		$strSmsUse					= $siteInfoRow['VAL'];
		if($strSmsUse != "Y"):
			$result['__STATE__']	= "NO_SMS_USE";
			break;
		endif;

		## 문자 발송 남은 개수 체크
		$param						= "";
		$param['COL']				= "S_SMS_MONEY";
		$siteInfoRow				= $siteInfo->getSiteInfoSelectEx("OP_SELECT", $param);
		$intSmsMoney				= $siteInfoRow['VAL'];
		$intSmsView					= $siteInfoRow['VIEW'];
		$intSmsMemo					= $siteInfoRow['MEMO'];
		if($intSmsMoney <= 0):
			$result['__STATE__']	= "NO_SMS_MONEY";
			break;
		endif;

		## 문자 전송
		$param						= "";
		$param['phone']				= $receiveHp;
		$param['callBack']			= $sendHp;
		$param['msg']				= $smsText;
		$param['siteName']			= $siteName;
		$re							= $smsFunc->goSendSms($param);
		$sendSmsNo					= $smsFunc->getLastInsertID();

		## 문자 전송 체크
		if($re):
			$result['__STATE__']	= "FAIL";
			break;
		endif;

		## 문자 발송 결과 가져오기
		$param						= "";
		$param['ym']				= date("Ym");
		$param['tran_pr']			= $sendSmsNo;
		$logRow						= $smsFunc->getLogSelectEx("OP_SELECT", $param);

		## 문자 발송 결과 설정
		$tranRslt					= $logRow['tran_rslt'];
		if(!$tranRslt) { $tranRslt = "0"; }

		## 문자 발송 로그 남기기
		$param						= "";
		$param['PL_PS_NO']			= -20;		// 고정값 : -20 은 CRM 전송이라는것을 의미
		$param['PL_TO_M_NO']		= $sendNo;
		$param['PL_TO_M_HP']		= $receiveHp;
		$param['PL_TO_M_NAME']		= $sendName;
		$param['PL_FROM_M_NO']		= $memberNo;
		$param['PL_FROM_M_HP']		= $sendHp;
		$param['PL_FROM_M_NAME']	= $memberName;
		$param['PL_TEXT']			= $smsText;
		$param['PL_IP']				= getClientIP();
		$param['PL_SEND_DATE']		= "NOW()";
		$param['PL_SEND_RESULT']	= $tranRslt;
		$param['PL_REG_DT']			= "NOW";
		$param['PL_REG_NO']			= $memberNo;
		$postSmsLog->getPostSmsLogInsertEx($param);

		## 문자 발송 결과 체크
		if($tranRslt):
			$result['__STATE__']	= "FAIL";
			break;
		endif;

		## 문자 발송 건수 차감.
		$param						= "";
		$param['COL']				= "S_SMS_MONEY";
		$param['VAL']				= $intSmsMoney - 1;
		$param['VIEW']				= $intSmsView;
		$param['MEMO']				= $intSmsMemo;
		$param['MOD_DT']			= "NOW()";
		$param['MOD_NO']			= $memberNo;
		$siteInfoRow				= $siteInfo->getSiteInfoUpdateEx($param);

		## 마무리
		$result['__STATE__']		= "SUCCESS";
	break;

	case "memberReportWrite":
		// 상담등록

		## 모듈 설정
		require_once MALL_HOME . "/module2/BoardData.module.php";
		require_once MALL_HOME . "/module2/MemberMgr.module.php";
		$boardData						= new BoardDataModule($db);
		$memberMgr						= new MemberMgrModule($db);

		## 기본 설정
		$memberLogin					= $_SESSION['member_login'];
		$bCode							= "USER_REPORT";
		$memberNo						= $_POST['mNo'];
		$title							= "상담관리 등록";
		$lng							= $S_SITE_LNG;
		$bcNo							= $_POST['ub_bc_no'];
		$text							= $_POST['ub_text'];
		$regDt							= "NOW()";
		$regNo							= $_SESSION['ADMIN_NO'];
		$modDt							= "NOW()";
		$modNo							= $_SESSION['ADMIN_NO'];
		$ansMemberNo					= $_POST['mNo'];

		## 기본 설정 체크
		if(!$memberNo):
			$result['__STATE__']	= "NO_MEMBER_NO";
			break;
		endif;
		if(!$text):
			$result['__STATE__']	= "NO_TEXT";
			break;
		endif;


		## 회원 정보 불러오기
		$param							= "";
		$param['M_NO']					= $memberNo;
		$memberMgrRow					= $memberMgr->getMemberMgrSelectEx("OP_SELECT", $param);

		## 회원 정보 체크
		if(!$memberMgrRow):
			$result['__STATE__']	= "NO_MEMBER";
			break;
		endif;

		## 회원 정보 설정
		$fName						= $memberMgrRow['M_F_NAME'];
		$lName						= $memberMgrRow['M_L_NAME'];
		$memberId					= $memberMgrRow['M_ID'];
		$email						= $memberMgrRow['M_MAIL'];

		## 이름 만들기
		$name						= "";
		if($fName):
			$name					= $fName;
		endif;

		if($lName):
			if(!$name) {	$name	.= " ";			}
							$name	.= $lName;
		endif;

		## 데이터 등록
		$param							= "";
		$param['B_CODE']				= $bCode;
//		$param['UB_NO']					= "";
		$param['UB_NAME']				= $name;
		$param['UB_M_NO']				= $memberNo;
		$param['UB_M_ID']				= $memberId;
		$param['UB_PASS']				= $pass;
		$param['UB_MAIL']				= $email;
		$param['UB_URL']				= $url;
		$param['UB_TITLE']				= $title;
		$param['UB_TEXT']				= $text;
		$param['UB_TEXT_MOBILE']		= $textMobile;
		$param['UB_FUNC']				= $func;
		$param['UB_IP']					= $ip;
		$param['UB_READ']				= $read;
		$param['UB_BC_NO']				= $bcNo;
		$param['UB_LNG']				= $lng;
		$param['UB_ANS_NO']				= $ansNo;
		$param['UB_ANS_STEP']			= $ansStep;
		$param['UB_ANS_M_NO']			= $ansMemberNo;
		$param['UB_PT_NO']				= $ptNo;
		$param['UB_CI_NO']				= $ciNo;
		$param['UB_WINNER']				= $winner;
		$param['UB_P_CODE']				= $pCode;
		$param['UB_P_GRADE']			= $pGrade;
		$param['UB_REG_DT']				= $regDt;
		$param['UB_REG_NO']				= $regNo;
		$param['UB_MOD_DT']				= $modDt;
		$param['UB_MOD_NO']				= $modNo;
		$re								= $boardData->getBoardDataInsertEx($param);

		## 데이터 등록 체크
		if(!$re):
			$result['__STATE__']		= "FAIL";
			break;
		endif;

		## 답변형 컬럼 업데이트
		$param							= "";
		$param['B_CODE']				= $bCode;
		$param['UB_NO']					= $re;
		$param['UB_ANS_NO']				= $re;
		$boardData->getBoardDataAnsUpdateEx($param);

		## 마무리
		$result['__STATE__']			= "SUCCESS";
	break;

	case "memberCrmSearch":
		// 회원정보관리(CRM) 검색

		## 모듈 설정
		require_once MALL_HOME . "/module2/MemberMgr.module.php";
		$memberMgr						= new MemberMgrModule($db);

		## 기본 설정
		$searchField					= $_POST['searchField'];
		$searchKey						= $_POST['searchKey'];

		## 기본 설정 체크
		if(!$searchKey):
			$result['__STATE__']		= "NO_SEARCH_KEY";
			break;
		endif;

		## 검색
		$param							= "";
		$param['searchKey']				= $searchKey;
		$param['searchField']			= $searchField;
		$memberMgrArray					= $memberMgr->getMemberMgrSelectEx("OP_ARYTOTAL", $param);

		## 검색 체크
		if(!$memberMgrArray):
			$result['__STATE__']		= "NO_DATA";
			break;
		endif;

		## 데이터 만들기
		$resultData						= "";
		foreach($memberMgrArray as $key => $data):
			$fName						= $data['M_F_NAME'];
			$lName						= $data['M_L_NAME'];

			## 이름 만들기
			$name						= "";
			if($fName):
				$name					= $fName;
			endif;

			if($lName):
				if(!$name) {	$name	.= " ";			}
								$name	.= $lName;
			endif;

			$resultData[$key]['no']		= $data['M_NO'];
			$resultData[$key]['id']		= $data['M_ID'];
			$resultData[$key]['name']	= $name;
		endforeach;

		## 마무리
		$result['__STATE__']			= "SUCCESS";
		$result['DATA']					= $resultData;
	break;
// 2013.11.11 kim hee sung old version
//		case "memberCrmSearch":
//
//			$intNo			= 0;
//
//			$strSearchField = $_REQUEST["searchField"];
//			$strSearchKey	= $_REQUEST["searchKey"];
//
//			$memberMgr->setSearchKey($strSearchKey);
//			$memberMgr->setSearchField($strSearchField);
//			if ($strSearchKey && $strSearchField){
//				$result = $memberMgr->getMemberCrmSearchList($db);
//				//$result_array = array();
//
//				if ($result[cnt] == 1){
//					$row	= mysql_fetch_array($result[result]);
//					$intNo	= $row['id'];
//				}
//			}
//
//			$result[0][CNT]		= $result[cnt];
//			$result[0][M_NO]	= $intNo;
//
//			$result_array		= json_encode($result);
//			$db->disConnect();
//
//			echo $result_array;
//
//			exit;
//
//		break;

		case "idChk":

			/*$memberMgr->setM_ID($strM_ID);
			$intCount = $memberMgr->getMemberIdCheck($db);

			if ($intCount > 0) {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00071"]; //"이미 등록된 아이디가 존재합니다.";
				$result[0][RET] = "N";
			} else {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00070"]; //"사용가능한 아이디입니다.";
				$result[0][RET] = "Y";
			}*/

/*
			$memberMgr->setM_ID($strM_ID);
			$intTotalCount = $memberMgr->getMemberIdCheck($db);

			$intCount = $memberMgr->getMemberValidIdCheck($db);
			
			$intValidCount = 0;
			if($intTotalCount == $intCount){
				$intValidCount = $intCount;
			}

			if ($intValidCount > 0) {
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00071"]; //"이미 등록된 아이디가 존재합니다.";
				$result[0][RET] = "N";
			} else {

				$arySetting = $memberMgr->getSettingView($db);

				$aryMemberReJoinCheck = $memberMgr->getMemberReJoinCheck($db);
				$intCountCheck=0;
				if(is_array($aryMemberReJoinCheck)){
					foreach($aryMemberReJoinCheck as $key => $val)
					{
						$strMemberOutDate = explode(" ",$aryMemberReJoinCheck[$key]['M_OUT_DT']);
						$intOutDt = strtotime($strMemberOutDate[0]);
						$intNowDt = strtotime(date('Y-m-d'));
						$intLastDt = $intNowDt - $intOutDt;
						$intReJoinTime = 60*60*24*$arySetting[J_RE_DAY];//초단위로계산
						//echo $intLastDt.":".$intReJoinTime;
						if($intReJoinTime != 0)
						{
							if($intLastDt < $intReJoinTime)
							{
								$intCountCheck ++;
							}
						}
					}
				}

				if($intCountCheck > 0){
					$result[0][MSG] = '등록할수 없는 아이디 입니다.';//등록할수 없는 아이디 입니다.;
					$result[0][RET] = "N";
				}else{
					$result[0][MSG] = $LNG_TRANS_CHAR["MS00070"]; //"사용가능한 아이디입니다.";
					$result[0][RET] = "Y";
				}
			}
*/


				$memberMgr->setM_ID($strM_ID);
				$result[0][MSG] = $LNG_TRANS_CHAR["MS00070"]; //"사용가능한 아이디입니다.";
				$result[0][RET] = "Y";
					
				$intCount = $memberMgr->getMemberIdCheck($db);
				if ($intCount > 0){
						$result[0][MSG] = $LNG_TRANS_CHAR['MS00024']; //"중복된 아이디가 존재합니다."
						$result[0][RET] = "N";
				}

				if ($S_JOIN_NICK_NAME_USE == "Y"){
					$intCount = $memberMgr->getMemberNickNameCheck($db);
					if ($intCount > 0){
						$result[0][MSG] = $LNG_TRANS_CHAR["MS00025"]; //"중복된 닉네임이 존재합니다."
						$result[0][RET] = "N";
					}
				}

				/* 불가 ID 체크*/
				$settingRow = $memberMgr->getSettingView($db);
				$aryRegNoIdList = explode(",",$settingRow[J_NO_ID]);
				for($i=0;$i<sizeof($aryRegNoIdList);$i++){
					if ($aryRegNoIdList[$i] == $strM_ID){
						$result[0][MSG] = $LNG_TRANS_CHAR['MS00026']; //등록할수 없는 아이디 입니다.;
						$result[0][RET] = "N";
						break;
					}
				}


			$result_array = json_encode($result);
			$db->disConnect();

			echo $result_array;

			exit;
		break;

		case "memberPointMove":
			/* 포인트 이동 */

			$intM_NO		= $_POST["no"];
			$aryMoveMemList = $_POST["chkMemMoveNo"];

			$strPT_TYPE		= $_POST["pointType"];
			$intPT_POINT	= $_POST["pointPrice"];
			$strPT_MEMO		= $_POST["pointMemo"];
			$strPT_END_DT	= $_POST["pointEndDt"];
			$strPT_ETC		= $_POST["pointEtc"];

			if (!is_array($aryMoveMemList)){
				$result[0][MSG] = "포인트를 이동하실 회원이 존재하지 않습니다."; //"포인트를 이동하실 회원이 존재하지 않습니다.";
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				$db->disConnect();

				echo $result_array;

				exit;
			}

			$memberMgr->setM_NO($intM_NO);
			$memberRow = $memberMgr->getMemberView($db);

			if ($memberRow['M_POINT'] <= 0){
				$result[0][MSG] = "이동할 포인트가 존재하지 않습니다."; //"이동할 포인트가 존재하지 않습니다.";
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				$db->disConnect();

				echo $result_array;
				exit;
			}

			$intMoveMemCnt = 0;
			if (is_array($aryMoveMemList)){
				for($i=0;$i<sizeof($aryMoveMemList);$i++){
					$intMoveMemNo  = $aryMoveMemList[$i];
					if ($intM_NO != $intMoveMemNo){
						$memberMgr->setM_NO($intM_NO);
						$memberRow = $memberMgr->getMemberView($db);

						if ($memberRow['M_POINT'] < $intPT_POINT){
							$result[0][MSG] = "보유한 포인트가 이동할 포인트보다 크지 않습니다."; //"보유한 포인트가 이동할 포인트보다 크지 않습니다.";
							$result[0][RET] = "N";
							$result_array = json_encode($result);
							$db->disConnect();

							echo $result_array;

							exit;
						}

						/* 포인트 이동 */
						$orderMgr->setM_NO($intMoveMemNo);
						$orderMgr->setB_NO(0);
						$orderMgr->setO_NO(0);
						$orderMgr->setPT_TYPE($strPT_TYPE);
						$orderMgr->setPT_POINT($intPT_POINT);
						$orderMgr->setPT_MEMO($strPT_MEMO);
						$orderMgr->setPT_START_DT(date("Y-m-d"));
						$orderMgr->setPT_END_DT($strPT_END_DT);
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
						$orderMgr->setPT_MEMO("포인트이동으로인한차감");
						$orderMgr->setPT_START_DT(date("Y-m-d"));
						$orderMgr->setPT_END_DT(date("Y-m-d"));
						$orderMgr->setPT_REG_IP($S_REMOTE_ADDR);
						$orderMgr->setPT_ETC($strPT_ETC);
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
				$result[0][MSG] = "총 ".$intMoveMemCnt."명에게 포인트 이동이 되었습니다."; //"총 10명에게 포인트 이동이 되었습니다."";
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

		case "dataModify":
			// 커뮤니티 관련 글 수정

			## 모듈 설정
			require_once MALL_HOME . "/module2/BoardData.module.php";
			$boardData						= new BoardDataModule($db);

			## 기본 설정
			$bCode							= $_POST['b_code'];
			$no								= $_POST['no'];
			$email1							= $_POST['ub_mail1'];
			$email2							= $_POST['ub_mail2'];
			$title							= $_POST['ub_title'];
			$text							= $_POST['ub_text'];
			$url							= $_POST['ub_url'];
			$ip								= getClientIP();
			$pGrade							= $_POST['ub_p_grade'];
			$modDt							= "NOW()";
			$modNo							= $_SESSION['ADMIN_NO'];

			## 기본 체크
			if(!$bCode):
				$result['__STATE__']		= "NO_B_CODE";
				break;
			endif;

			if(!$title):
				$result['__STATE__']		= "NO_TITLE";
				break;
			endif;

			if(!$text):
				$result['__STATE__']		= "NO_TEXT";
				break;
			endif;

			## 이메일 설정
			$email							= "";
			if($email1 && $email2):
				$email						= "{$email1}@{$email2}";
			endif;

			## 데이터 불러오기
			$param							= "";
			$param['B_CODE']				= $bCode;
			$param['UB_NO']					= $no;
			$boardDataRow					= $boardData->getBoardDataSelectEx("OP_SELECT", $param);

			## 데이터 설정
			$name							= $boardDataRow['UB_NAME'];
			$memberNo						= $boardDataRow['UB_M_NO'];
			$memberId						= $boardDataRow['UB_M_ID'];
			$pass							= $boardDataRow['UB_PASS'];
			$textMobile						= $boardDataRow['UB_TEXT_MOBILE'];
			$read							= $boardDataRow['UB_READ'];
			$lng							= $boardDataRow['UB_LNG'];
			$bcNo							= $boardDataRow['UB_BC_NO'];
			$ansNo							= $boardDataRow['UB_ANS_NO'];
			$ansStep						= $boardDataRow['UB_ANS_STEP'];
			$ansMemberNo					= $boardDataRow['UB_ANS_M_NO'];
			$ptNo							= $boardDataRow['UB_PT_NO'];
			$ciNo							= $boardDataRow['UB_CI_NO'];
			$winner							= $boardDataRow['UB_WINNER'];
			$pCode							= $boardDataRow['UB_P_CODE'];

			## 데이터 수정
			$param							= "";
			$param['B_CODE']				= $bCode;
			$param['UB_NO']					= $no;
			$param['UB_NAME']				= $name;
			$param['UB_M_NO']				= $memberNo;
			$param['UB_M_ID']				= $memberId;
			$param['UB_PASS']				= $pass;
			$param['UB_MAIL']				= $email;
			$param['UB_URL']				= $url;
			$param['UB_TITLE']				= $title;
			$param['UB_TEXT']				= $text;
			$param['UB_TEXT_MOBILE']		= $textMobile;
			$param['UB_FUNC']				= $func;
			$param['UB_IP']					= $ip;
			$param['UB_READ']				= $read;
			$param['UB_BC_NO']				= $bcNo;
			$param['UB_LNG']				= $lng;
			$param['UB_ANS_NO']				= $ansNo;
			$param['UB_ANS_STEP']			= $ansStep;
			$param['UB_ANS_M_NO']			= $ansMemberNo;
			$param['UB_PT_NO']				= $ptNo;
			$param['UB_CI_NO']				= $ciNo;
			$param['UB_WINNER']				= $winner;
			$param['UB_P_CODE']				= $pCode;
			$param['UB_P_GRADE']			= $pGrade;
	//		$param['UB_REG_DT']				= $regDt;
	//		$param['UB_REG_NO']				= $regNo;
			$param['UB_MOD_DT']				= $modDt;
			$param['UB_MOD_NO']				= $modNo;
			$re								= $boardData->getBoardDataUpdateEx($param);

			## 마무리
			$result['__STATE__']			= "SUCCESS";


		break;

		case "dataDelete":
			## 커뮤니티 관련 글 삭제

			## 모듈 설정
			require_once MALL_HOME . "/module2/BoardData.module.php";
			$boardData						= new BoardDataModule($db);

			## 기본 설정
			$ubNo							= $_POST['ub_no'];
			$bCode							= $_POST['b_code'];

			## 기본 설정 체크
			if(!$bCode):
				$result['__STATE__']		= "NO_B_CODE";
				break;
			endif;

			if(!$ubNo):
				$result['__STATE__']		= "NO_B_NO";
				break;
			endif;


			## 데이터 불러오기
			$param							= "";
			$param['B_CODE']				= $bCode;
			$param['UB_NO']					= $ubNo;
			$boardDataRow					= $boardData->getBoardDataSelectEx("OP_SELECT", $param);

			if(!$boardDataRow):
				$result['__STATE__']		= "NO_DATA";
				break;
			endif;

			## 데이터 설정
			$ansNo							= $boardDataRow['UB_ANS_NO'];
			$ansStep						= $boardDataRow['UB_ANS_STEP'];

			## 데이터 체크
			if(!$ansNo):
				$result['__STATE__']		= "NO_ANS_NO";
				break;
			endif;

			## 답변글 갯수 불러오기
			$param							= "";
			$param['B_CODE']				= $bCode;
			$param['UB_ANS_NO']				= $ansNo;
			$param['UB_ANS_STEP_LIKE_R']	= $ansStep;
			$boardDataAnsCnt				= $boardData->getBoardDataSelectEx("OP_COUNT", $param);

			## 답변글 개수 체크
			if($boardDataAnsCnt > 1):
				$result['__STATE__']		= "HAVE_ANS";
				break;
			endif;

			if($boardDataAnsCnt < 0):
				$result['__STATE__']		= "FAIL";
				break;
			endif;

			## 데이터 삭제
			$param							= "";
			$param['B_CODE']				= $bCode;
			$param['UB_NO']					= $ubNo;
			$boardData->getBoardDataDeleteEx($param);

			## 마무리
			$result['__STATE__']			= "SUCCESS";


		break;

		case "dataAnswerWrite":
			// 답변쓰기

			## 모듈 설정
			require_once MALL_HOME . "/module2/BoardData.module.php";
			$boardData						= new BoardDataModule($db);

			## 기본 설정
			$ubNo							= $_POST['no'];
			$bCode							= $_POST['b_code'];
			$title							= $_POST['ub_title'];
			$text							= $_POST['ub_text'];
			$name							= $_SESSION['ADMIN_NAME'];
			$memberNo						= $_SESSION['ADMIN_NO'];
			$memberId						= $_SESSION['ADMIN_ID'];
			$email							= $_SESSION['ADMIN_MAIL'];
			$ip								= getClientIP();
			$regDt							= "NOW()";
			$regNo							= $_SESSION['ADMIN_NO'];
			$modDt							= "NOW()";
			$modNo							= $_SESSION['ADMIN_NO'];


			## 기본 설정 체크
			if(!$bCode):
				$result['__STATE__']		= "NO_B_CODE";
				break;
			endif;

			if(!$ubNo):
				$result['__STATE__']		= "NO_B_NO";
				break;
			endif;


			## 데이터 불러오기
			$param							= "";
			$param['B_CODE']				= $bCode;
			$param['UB_NO']					= $ubNo;
			$boardDataRow					= $boardData->getBoardDataSelectEx("OP_SELECT", $param);

			if(!$boardDataRow):
				$result['__STATE__']		= "NO_DATA";
				break;
			endif;

			## 데이터 설정
			$ansMemberNo					= $boardDataRow['UB_ANS_M_NO'];
			$bcNo							= $boardDataRow['UB_BC_NO'];
			$lng							= $boardDataRow['UB_LNG'];
			$ansNo							= $boardDataRow['UB_ANS_NO'];
			$ansStep						= $boardDataRow['UB_ANS_STEP'];
			$pCode							= $boardDataRow['UB_P_CODE'];
			$shopNo							= $boardDataRow['UB_SHOP_NO'];

			## 스텝 구하기
			$param							= "";
			$param['B_CODE']				= $bCode;
			$param['UB_ANS_NO']				= $ansNo;
			$param['UB_ANS_STEP_LIKE_R']	= $ansStep;
			$ansStepMax						= $boardData->getBoardDataAnsStepMaxSelect($param);

			if($ansStep == $ansStepMax):
				if($ansStep) { $ansStep .= ","; }
				$ansStep .= "100";
			else:
				$aryTemp		= explode(",", $ansStepMax);
				if(!is_array($aryTemp)) { $aryTemp[] = $aryTemp; }
				$aryTemp[sizeof($aryTemp) - 1]++;
				$ansStep		= implode(",", $aryTemp);
			endif;

			## 데이터 등록
			$param							= "";
			$param['B_CODE']				= $bCode;				//
//			$param['UB_NO']					= "";
			$param['UB_NAME']				= $name;				//
			$param['UB_M_NO']				= $memberNo;			//
			$param['UB_M_ID']				= $memberId;			//
			$param['UB_PASS']				= $pass;				///
			$param['UB_MAIL']				= $email;				//
			$param['UB_URL']				= $url;					///
			$param['UB_TITLE']				= $title;				//
			$param['UB_TEXT']				= $text;				//
			$param['UB_TEXT_MOBILE']		= $textMobile;			///
			$param['UB_FUNC']				= $func;				// -> 작업 순서 뒤로
			$param['UB_IP']					= $ip;					//
			$param['UB_READ']				= $read;				///
			$param['UB_BC_NO']				= $bcNo;				//
			$param['UB_LNG']				= $lng;					//
			$param['UB_ANS_NO']				= $ansNo;				//
			$param['UB_ANS_STEP']			= $ansStep;
			$param['UB_ANS_M_NO']			= $ansMemberNo;			//
			$param['UB_PT_NO']				= $ptNo;				///
			$param['UB_CI_NO']				= $ciNo;				///
			$param['UB_WINNER']				= $winner;				///
			$param['UB_P_CODE']				= $pCode;				//
			$param['UB_P_GRADE']			= $pGrade;				//
			$param['UB_REG_DT']				= $regDt;				//
			$param['UB_REG_NO']				= $regNo;				//
			$param['UB_MOD_DT']				= $modDt;				//
			$param['UB_MOD_NO']				= $modNo;				//
			$param['UB_SHOP_NO']			= $shopNo;				//답변에 샵번호 추가. 남덕희
			$re								= $boardData->getBoardDataInsertEx($param);

			## 마무리
			$result['__STATE__']			= "SUCCESS";

		break;
	}

?>

