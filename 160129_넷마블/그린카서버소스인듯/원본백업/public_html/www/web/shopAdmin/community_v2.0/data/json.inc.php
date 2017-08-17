<?php
	switch($strAct):

	case "dataAnswer":
		// 답변 등록

		## 모듈설정
		$objBoardFileModule = new BoardFileModule($db);
		$objBoardDataModule = new BoardDataModule($db);
		$objBoardAddFieldModule = new BoardAddFieldModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];
		$intUbNo = $_POST['ub_no'];
		$strUbLng = $_POST['ub_lng'];
		$strUbName = $_POST['ub_name'];		
		$strUbTitle = $_POST['ub_title'];	// 필수
		$strUbPCode = $_POST['ub_p_code'];
		$intUbPGrade = $_POST['ub_p_grade'];
		$strUbMail = $_POST['ub_mail'];
		$strUbText = $_POST['ub_text'];		// 필수
		$strUbPass = $_POST['ub_pass'];		// 비회원인경우 필수
		$intMemberNo = $a_admin_no;
		$strMemberID = $a_admin_id;
		$strMemberGroup = $a_admin_group;
		$strClientIP = ClientInfo::getClientIP();
		$strLang = $strUbLng;
		$strLangS = $S_ST_LNG;
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 
		$strCommunityTempWebDir = "/upload/community/temp";
		$strCommunityDataWebDir = "/upload/community/data/{$strBCode}/" . date("Ym");
		$strCommunityTempDefaultDir = MALL_SHOP . $strCommunityTempWebDir;
		$strCommunityDataDefaultDir = MALL_SHOP . $strCommunityDataWebDir;
		$arySessionFileList = $_SESSION["FILE"];


		## APP PUSH
		if($strBCode == 'MY_QNA' || $strBCode == 'PROD_QNA')
		{
			//모바일 App관련 설정 하나로 묶음
	 		include_once	MALL_HOME."/include/mobileApp.inc.php";

			$strUbTitle = strHanCut($strUbTitle,90);

			if($strBCode == 'MY_QNA')
			{
				$message = "[1:1답변]".$strUbTitle."@@@http://222.122.20.23/$strLang/?menuType=community&mode=dataView&b_code=MY_QNA&myTarget=mypage&layout=mypage&ubNo=".$intUbNo;
			}

			if($strBCode == 'PROD_QNA')
			{
				$message = "[상품답변]".$strUbTitle."@@@http://222.122.20.23/$strLang/?menuType=community&mode=dataView&b_code=PROD_QNA&ubNo=".$intUbNo;
			}

			$message = urlencode($message);

			$MobileMgr	= new MobileMgr();
			$IOSPush	= new IOSPushMessage();

//
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['UB_NO'] = $intUbNo;
			$param['JOIN_MM'] = "Y";
			$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
			$intUB_ANS_M_NO = $aryBoardDataRow['UB_ANS_M_NO'];
			$strUB_M_ID = $aryBoardDataRow['UB_M_ID'];
//
			//$MobileMgr->setM_NO($intMemberNo);
			//$MobileMgr->setM_NO($intUB_ANS_M_NO);
			$MobileMgr->setM_ID($strUB_M_ID);
			$apiKey= $MobileMgr->getMobileKey($db);
			
			error_log("IOS PUSH MOBILE_DEVICE_OS::".$apiKey[MOBILE_DEVICE_OS]);
				
			if($apiKey[MOBILE_DEVICE_OS] == 'G')
			{
				//$devices[] = $apiKey[$i][MOBILE_DEVICE_KEY];
				$AndPush = new GCMPushMessage($strAndroidApiKey);
				$AndPush->setDevices($apiKey[MOBILE_DEVICE_KEY]);
				//$AndPush->setDevices("APA91bENxy3q6VSG3ApZsHh-nwOT5lpoZq_iQjCIOv8KdUrjYmr7SLawK0gpUN5_79z7GZO9uXqE3Xi312nJKhQsq6hJfus5UIW60RuHOZ_HvnYKAVm-QbXYPzT01J_Shw4ZxijbcdMI");
				//$AndPush->setDevices("APA91bEm_dyNbddeFlu8AcVI2R7i9bDB3PmbPiTSHrjOjKLcpk3Dlw4xLo8NS_49kcUyXlEoQN04qK3fYn87ZE9jCsjeV-djgZTykGyaQuZn6DJtlCn1f5sxwnBJJDmK8vbJhGh4caJU");
				
				$response = $AndPush->send($message);
				//print_r($apiKey[MOBILE_DEVICE_OS]);
				//print_r($apiKey[MOBILE_DEVICE_KEY]);
			}
			else if($apiKey[MOBILE_DEVICE_OS] == 'A')
			{
				error_log("IOS PUSH strBCode::".$strBCode);
				
				if($strBCode == 'MY_QNA')
				{
					$iosMessage = "[1:1답변]".$strUbTitle;
					$iosUrl =	"http://222.122.20.23/$strLang/?menuType=community&mode=dataView&b_code=NOTICE&ubNo=".$intUB_NO;
				}
	
				if($strBCode == 'PROD_QNA')
				{
					$iosMessage = "[상품답변]".$strUbTitle;
					$iosUrl =	"http://222.122.20.23/$strLang/?menuType=community&mode=dataView&b_code=NOTICE&ubNo=".$intUB_NO;
				}
				
				error_log("IOS PUSH iosMessage::".$iosMessage);
				error_log("IOS PUSH iosUrl::".$iosUrl);
				
				$num = 1;
				// $IOSPush->send($apiKey[MOBILE_DEVICE_KEY], $message, $num, "default");
				$IOSPush->send($apiKey[MOBILE_DEVICE_KEY], $iosMessage, $iosUrl, $num, "default");
			}
			//PRINT_R($devices);
			//exit;
			//$AndPush = new GCMPushMessage($strAndroidApiKey);
			//$AndPush->setDevices($devices);
			//$response = $AndPush->send($message);
			//exit;
//$txt = urlencode('test');
//$text = iconv("euc-kr","UTF-8",$txt);
//$num = 1;
//$code = "1111";
//$deviceToken = 'b09da1c10fe8d1000b9351406e7944c9832f84618dabd416de5921965dc364ac'; // 앱실행후 로그로 찍힌 디바이스 토큰 정보 입력
//send("휴대폰 토큰값", $text, $num, "default", $code, "custom", "custom data");

		}

		## 커뮤니티 설정 파일
		if(is_file("{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}")) include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		if(is_file("{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}")) include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
		$aryBoardInfoS = $BOARD_INFO[$strBCode];
		foreach($aryBoardInfoS as $key => $data):
			$strTemp = $aryBoardInfo[$key];
			if($strTemp) { continue; }
			$aryBoardInfo[$key] = $data;
		endforeach;
		$intBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 파일 사용시 사용 개수

		## 공백제거
		$strUbTitle =trim($strUbTitle);

		$result['__STATE__'] = "SUCCESS";
		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_B_CODE";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00104"])); // 커뮤니티 코드이(가) 없습니다.
			break;
		endif;
		if(!$intUbNo):
			$result['__STATE__'] = "NO_UB_NO";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00106"])); // 게시글 번호이(가) 없습니다.
			break;
		endif;
		if(!$strUbLng):
			$result['__STATE__'] = "NO_B_LNG";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00105"])); // 언어 코드이(가) 없습니다.
			break;
		endif;
		if(!$strUbName):
			$result['__STATE__'] = "NO_UB_NAME";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00004"])); // 이름이(가) 없습니다.
			break;
		endif;
		if(!$strUbTitle):
			$result['__STATE__'] = "NO_UB_TITLE";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["CW00062"])); // 제목이(가) 없습니다.
			break;
		endif;
		if(!$strUbText):
			$result['__STATE__'] = "NO_UB_TEXT";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["CW00063"])); // 내용이(가) 없습니다.
			break;
		endif;

		## 이메일이 있다면 체크
		if($strUbMail):
			$isEmail = StringInfo::isEmailCheck($strUbMail);
			if(!$isEmail):
				$result['__STATE__'] = "WRONG_UB_MAIL_WRITE";
				$result['__MSG__'] = $LNG_TRANS_CHAR["BS00100"]; // 이메일 형식이 아닙니다.
				break;
			endif;
		endif;

		## 그룹 폴더 만들기
		if($intBI_ATTACHEDFILE_USE && !FileDevice::makeFolder($strCommunityDataDefaultDir)):
			$result['__STATE__'] = "NO_DIR";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00124"]; // 업로드 폴더를 생성할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;

		## 질문글 불러오기
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['UB_NO'] = $intUbNo;
		$param['JOIN_MM'] = "Y";
		$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
//		$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
//		$strUB_NAME = $aryBoardDataRow['UB_NAME'];
//		$strUB_M_ID = $aryBoardDataRow['UB_M_ID'];
//		$strUB_PASS = $aryBoardDataRow['UB_PASS'];
//		$intUB_READ = $aryBoardDataRow['UB_READ'];
		$strUB_LNG = $aryBoardDataRow['UB_LNG'];
		$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];
		$intUB_ANS_DEPTH = $aryBoardDataRow['UB_ANS_DEPTH'];
		$strUB_ANS_STEP = $aryBoardDataRow['UB_ANS_STEP'];
		$intUB_ANS_M_NO = $aryBoardDataRow['UB_ANS_M_NO'];
		$strUB_P_CODE = $aryBoardDataRow['UB_P_CODE'];
		$intUB_BC_NO = $aryBoardDataRow['UB_BC_NO'];
		$strUB_FUNC = $aryBoardDataRow['UB_FUNC'];

		## UB_FUNC 설정
		$aryFunc = "";
		$strFuncNotice = $strUB_FUNC[0]; // 공지글
		$strFuncLock = $strUB_FUNC[1]; // 비밀글
//		$aryFunc[] = $strUB_FUNC[3]; // 대기
//		$aryFunc[] = $strUB_FUNC[4]; // 대기
//		$aryFunc[] = $strUB_FUNC[5]; // 대기
//		$aryFunc[] = $strUB_FUNC[6]; // 대기
//		$aryFunc[] = $strUB_FUNC[7]; // 대기
//		$aryFunc[] = $strUB_FUNC[8]; // 대기
//		$aryFunc[] = $strUB_FUNC[9]; // 대기

		## 질문글이 공지글이면 답변을 달 수 없습니다.
		if($strFuncNotice == "Y"):
			$result['__STATE__'] = "CAN_NOT_ANSWER";
			$result['__MSG__'] = "공지글은 답변을 달 수 없습니다.";
			break;
		endif;

		## 커뮤니티 등록
		$param['B_CODE']			= $strBCode;
		$param['UB_NAME']			= $strUbName;
		$param['UB_M_NO']			= $intMemberNo;
		$param['UB_M_ID']			= $strMemberID;
		$param['UB_PASS']			= $strUbPass;
		$param['UB_MAIL']			= $strUbMail;
		$param['UB_URL']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_TITLE']			= $strUbTitle;
		$param['UB_TEXT']			= $strUbText;
		$param['UB_TEXT_MOBILE']	= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_FUNC']			= $strUB_FUNC;  // 0=공지글,1=비밀글
		$param['UB_IP']				= $strClientIP;
		$param['UB_READ']			= 0;
		$param['UB_BC_NO']			= $intUB_BC_NO;
		$param['UB_LNG']			= $strUbLng;
		$param['UB_ANS_NO']			= "";
		$param['UB_ANS_STEP']		= "";
		$param['UB_ANS_M_NO']		= "";
		$param['UB_PT_NO']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_CI_NO']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_WINNER']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_P_CODE']			= $strUB_P_CODE;
		$param['UB_P_GRADE']		= "";
		$param['UB_REG_DT']			= "NOW()";
		$param['UB_REG_NO']			= $intMemberNo;
		$param['UB_MOD_DT']			= "NOW()";
		$param['UB_MOD_NO']			= $intMemberNo;
		$param['UB_SHOP_NO']		= $_SESSION['ADMIN_SHOP_NO'];
		$intUB_NO					= $objBoardDataModule->getBoardDataInsertEx($param);

		## 체크
		if(!$intUB_NO && $intUB_NO < 0):
			$result['__STATE__'] = "NO_INSERT_DATA";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00106"]; // 내용을 등록할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;

		## 답변글 depth +1
		$intUB_ANS_DEPTH = $intUB_ANS_DEPTH + 1;

		## 답변 STEP 구하기
		$param							= "";
		$param['B_CODE']				= $strBCode;
		$param['UB_ANS_NO']				= $intUB_ANS_NO;
		$param['UB_ANS_DEPTH']			= $intUB_ANS_DEPTH;
		$param['UB_ANS_STEP']			= $strUB_ANS_STEP;
		$strAnsStep						= $objBoardDataModule->getBoardDataAnsStepNextSelectEx($param);

		## 커뮤니티 계층형 컬럼 업데이트
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['UB_NO'] = $intUB_NO;
		$param['UB_ANS_NO'] = $intUB_ANS_NO;
		$param['UB_ANS_DEPTH'] = $intUB_ANS_DEPTH;
		$param['UB_ANS_STEP'] = $strAnsStep;
		$param['UB_ANS_M_NO'] = $intUB_ANS_M_NO;
		$objBoardDataModule->getBoardDataAnsUpdateEx2($param);


		## 첨부파일 설정
		if($intBI_ATTACHEDFILE_USE && $arySessionFileList):

			## 파일 삭제 및 업로드
			foreach($arySessionFileList as $key => $data):
		
				## 기본설정
				$strATC_KEY = $data['ATC_KEY'];
				$strATC_FILE = $data['ATC_FILE'];
				$strUploadFileName = $strATC_FILE;
				$aryFileName = explode("_@_", $strUploadFileName);
				$strSaveFileName = FileDevice::getUniqueFileName($strCommunityDataDefaultDir, date("YmdHis") . "_{$strATC_KEY}_%s_@_" . $aryFileName[1]);

				## 파일 이동
				rename("{$strCommunityTempDefaultDir}/{$strATC_FILE}", "{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 파일 타입 구하기
				$strFileType = FileDevice::my_mime_content_type("{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 파일 사이즈 구하기
				$intFileSize = filesize("{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 데이터 베이스 등록
				$param						= "";
				$param['B_CODE']			= $strBCode;
				$param['FL_UB_NO']			= $intUB_NO;
				$param['FL_KEY']			= $strATC_KEY;
				$param['FL_DIR']			= $strCommunityDataWebDir;
				$param['FL_NAME']			= $strSaveFileName;
				$param['FL_TYPE']			= $strFileType;
				$param['FL_SIZE']			= $intFileSize;
				$param['FL_REG_DT']			= "NOW()";
				$param['FL_REG_NO']			= $intMemberNo;
				$param['FL_MOD_DT']			= "NOW()";
				$param['FL_MOD_NO']			= $intMemberNo;
				$objBoardFileModule->getBoardFileInsertEx($param);

			endforeach;

			## 첨부파일 세션 졍보 삭제
			unset($_SESSION["FILE"]);

		endif;

		//1:1문의 답변 메일발송
		if($strBCode == 'MY_QNA')
		{
			/** 메일 전송 **/
			//$row = $memberMgr->getMemberView($db);
			$aryTAG_LIST['{{__받는사람이름__}}']	= $strUbName;
			$aryTAG_LIST['{{__받는사람메일__}}']	= $strUbMail;
			$aryTAG_LIST['{{__회원명__}}']			= $strUbName;
			goSendMail("017");
			/** 메일 전송 **/
		}

		## dataAnswer END

	break;

	case "dataModify":
		// 글수정

		## 모듈설정
		$objSmsInfo = new SmsInfo($db);
		$objBoardDataModule = new BoardDataModule($db);
		$objBoardAddFieldModule = new BoardAddFieldModule($db);
		$objBoardFileModule = new BoardFileModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];
		$intUbNo = $_POST['ub_no'];
		$strUbLng = $_POST['ub_lng'];
		$intUbBcNo = $_POST['ub_bc_no'];
//		$strUbName = $_POST['ub_name'];		// 필수
		$strUbTitle = $_POST['ub_title'];	// 필수
		$strUbPCode = $_POST['ub_p_code'];
		$intUbPGrade = $_POST['ub_p_grade'];
		$strUbMail = $_POST['ub_mail'];
		$strUbText = $_POST['ub_text'];		// 필수
//		$strUbPass = $_POST['ub_pass'];		// 비회원인경우 필수
		$strUbFuncNotice = $_POST['ub_func_notice']; // 공지글
		$strUbFuncLock = $_POST['ub_func_lock']; // 비밀글
		$strFileDel = $_POST['file_del'];	// 삭제 리스트
		$intMemberNo = $a_admin_no;
		$strMemberID = $a_admin_id;
		$strMemberName = $a_admin_name; // 영문 - 이름, 한글 - 기록 안됨
		$strMemberGroup = $a_admin_group;
		$strMemberLastName = $a_member_last_name; // 영문 - 성, 한글 - 성 + 이름
		$strClientIP = ClientInfo::getClientIP();
		$strLang = $strUbLng;
		$strLangS = $S_ST_LNG; 
		if(!$strLang || $strLang == "--") { $strLang = $strLangS; }
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 
		$strCommunityTempWebDir = "/upload/community/temp";
		$strCommunityDataWebDir = "/upload/community/data/{$strBCode}/" . date("Ym");
		$strCommunityTempDefaultDir = MALL_SHOP . $strCommunityTempWebDir;
		$strCommunityDataDefaultDir = MALL_SHOP . $strCommunityDataWebDir;
		$arySessionFileList = $_SESSION["FILE"];

		## 커뮤니티 설정 파일
		include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
		$aryBoardInfoS = $BOARD_INFO[$strBCode];
		foreach($aryBoardInfoS as $key => $data):
			$strTemp = $aryBoardInfo[$key];
			if($strTemp) { continue; }
			$aryBoardInfo[$key] = $data;
		endforeach;
		$strBI_USERFIELD_USE = $aryBoardInfo['BI_USERFIELD_USE']; // 추가필드 사용 - 사용 = Y, 사용안함 = N
		$strBI_SMS_USE = $aryBoardInfo['BI_SMS_USE']; // SMS 사용 - 사용 = Y, 사용안함 = N
		$strBI_SMS_HP_LIST = $aryBoardInfo['BI_SMS_HP_LIST']; // SMS 연락처
		$strBI_SMS_TEXT = $aryBoardInfo['BI_SMS_TEXT']; // SMS 텍스트
		$intBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
		$aryBI_SMS_HP_LIST = explode(",", $strBI_SMS_HP_LIST);

		## 언어 설정
		## 선택된 언어가 없으면 모든 언어 출력 표시로 변경함.
		if(!$strUbLng) { $strUbLng = "--"; }

		## 공백제거
		$strUbName = trim($strUbName);
		$strUbTitle =trim($strUbTitle);
		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_B_CODE";
			$result['__MSG__'] = "커뮤니티 코드가 없습니다.";
			break;
		endif;
//		if(!$strUbLng):
//			$result['__STATE__'] = "NO_B_LNG";
//			$result['__MSG__'] = "언어 코드가 없습니다.";
//			break;
//		endif;
//		if(!$strUbName):
//			$result['__STATE__'] = "NO_UB_NAME";
//			$result['__MSG__'] = "이름이 없습니다.";
//			break;
//		endif;
		if(!$strUbTitle):
			$result['__STATE__'] = "NO_UB_TITLE";
			$result['__MSG__'] = "제목이 없습니다.";
			break;
		endif;
		if(!$strUbText):
			$result['__STATE__'] = "NO_UB_TEXT";
			$result['__MSG__'] = "내용이 없습니다.";
			break;
		endif;
//		if(!$intMemberNo && !$strUbPass): // 비회원은 비밀번호가 반드시 있어야 합니다.
//			$result['__STATE__'] = "NO_UB_PASS";
//			$result['__MSG__'] = "비밀번호가 없습니다.";
//			break;
//		endif;
//		if($intMemberNo && !$strMemberID): // 회원은 반드시 회원ID가 있어야 합니다.
//			$result['__STATE__'] = "NO_UB_PASS";
//			$result['__MSG__'] = "아이디이(가) 없습니다.";
//			break;
//		endif;

		## 이메일이 있다면 체크
		if($strUbMail):
			$isEmail = StringInfo::isEmailCheck($strUbMail);
			if(!$isEmail):
				$result['__STATE__'] = "WRONG_UB_MAIL_WRITE";
				$result['__MSG__'] = "이메일 형식이 아닙니다.";
				break;
			endif;
		endif;

		## 그룹 폴더 만들기
		if($intBI_ATTACHEDFILE_USE && !FileDevice::makeFolder($strCommunityDataDefaultDir)):
			$result['__STATE__'] = "NO_DIR";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00124"]; // 업로드 폴더를 생성할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;

		## 추가 필드 사용하는 경우
		if($strBI_USERFIELD_USE == "Y"):

			## 추가필드 배열 만들기
			$aryUserfieldList = "";
			foreach($aryBoardInfo as $key => $data):
				
				## 기본설정
				$aryTemp = explode("_", $key);
				$intTempCnt = sizeof($aryTemp);
				if($intTempCnt == 4): 
					$strTemp1 = $aryTemp[0];
					$strTemp2 = $aryTemp[1];
					$strTemp3 = $aryTemp[2];
					$strTemp4 = $aryTemp[3];
				elseif($intTempCnt == 5):
					$strTemp1 = $aryTemp[0];
					$strTemp2 = $aryTemp[1];
					$strTemp3 = $aryTemp[2];
					$strTemp4 = "{$aryTemp[3]}_{$aryTemp[4]}";
				endif;
				## 체크
				if($strTemp2 != "AD") { continue; }

				## 추가필드 배열 만들기
				$aryUserfieldList[$strTemp3][$strTemp4] = $data;

			endforeach;

			## 사용자 정의 필드 설정, param 설정
			$aryUserFieldParam = "";
			foreach($aryUserfieldList as $key => $data):

				## 기본설정
				$strValue = "";
				$strKeyLower = strtolower($key);
				$strUSE = $data['USE'];
				$strESSENTIAL = $data['ESSENTIAL'];
				$strONLYADMIN = $data['ONLYADMIN'];
				$strKIND = $data['KIND'];
				$strNAME = $data['NAME'];
				$strParamName = "AD_{$key}";

				## 유효성 체크 설정
				$isCheckData = true;
				if($strUSE != "Y") { $isCheckData = false; } 
				if($strONLYADMIN == "Y") { $isCheckData = false; } // 관리자 전용인경우 
				if($strESSENTIAL != "Y") { $isCheckData = false; } 

				## 종류별로 설정 방식이 틀려집니다.
				if(in_array($strKIND, array("text","select","radio","textarea","wysiwyg"))):
					
					## 기본설정
					$strValue = $_POST[$strKeyLower];

					## 공백 제거
//					$strValue = trim($strValue);

					## 유효성 체크
					## 필수로 입력을 받아야 하는 경우 null 값 체크
					if($isCheckData && !$strValue):
						$result['__STATE__'] = "NO_{$key}";
						$result['__MSG__'] = "{$strNAME} 이(가) 없습니다.";
						break;
					endif;

					## 사용자 정의 필드 저장
					$aryUserFieldParam[$strParamName] = $strValue;

				elseif(in_array($strKIND, array("phone"))):
					
					if($strLang == "KR"):

						## 기본설정
						$strPhone1 = $_POST["{$strKeyLower}_1"];
						$strPhone2 = $_POST["{$strKeyLower}_2"];
						$strPhone3 = $_POST["{$strKeyLower}_3"];

						## 공백 제거
						$strPhone1 = trim($strPhone1);
						$strPhone2 = trim($strPhone2);
						$strPhone3 = trim($strPhone3);

						if($strPhone1 && $strPhone2 && $strPhone3) { $strValue = "{$strPhone1}-{$strPhone2}-{$strPhone3}"; };

					else:

						## 기본설정
						$strValue = $_POST[$strKeyLower];

						## 공백 제거
						$strValue = trim($strValue);

					endif;

					## 유효성 체크
					## 필수로 입력을 받아야 하는 경우 null 값 체크
					if($isCheckData && !$strValue):
						$result['__STATE__'] = "NO_{$key}";
						$result['__MSG__'] = "{$strNAME} 이(가) 없습니다.";
						break;
					endif;

					## 사용자 정의 필드 저장
					$aryUserFieldParam[$strParamName] = $strValue;

				elseif(in_array($strKIND, array("address"))):

					if($strLang == "KR"):
						
						## 기본설정
						$aryValue = "";
						$strZip1 = $_POST["{$strKeyLower}_zip1"];
						$strZip2 = $_POST["{$strKeyLower}_zip2"];
						$strAddress1 = $_POST["{$strKeyLower}_1"];
						$strAddress2 = $_POST["{$strKeyLower}_2"];

						## 공백 제거
						$strZip1 = trim($strZip1);
						$strZip2 = trim($strZip2);
						$strAddress1 = trim($strAddress1);
						$strAddress2 = trim($strAddress2);

						## 데이터 만들기
						if($strZip1 && $strZip2) { $aryValue['zip'] = "{$strZip1}-{$strZip2}"; }
						$aryValue['address1'] = $strAddress1;					
						$aryValue['address2'] = $strAddress2;
						
					else:

						## 기본설정
						$aryValue = "";
						$strZip = $_POST["{$strKeyLower}_zip"];
						$strAddress1 = $_POST["{$strKeyLower}_1"];
						$strAddress2 = $_POST["{$strKeyLower}_2"];

						## 공백 제거
						$strZip = trim($strZip);
						$strAddress1 = trim($strAddress1);
						$strAddress2 = trim($strAddress2);

						## 데이터 만들기
						$aryValue['zip'] = $strZip; 
						$aryValue['address1'] = $strAddress1;					
						$aryValue['address2'] = $strAddress2;

					endif;
					
					## 기본설정
					$strZip = $aryValue['zip'];
					$strAddress1 = $aryValue['address1'];
					$strAddress2 = $aryValue['address2'];

					## 체크
					if($isCheckData && !($strZip && $strAddress1 && $strAddress2)):
						$result['__STATE__'] = "NO_{$key}";
						$result['__MSG__'] = "{$strNAME}이(가) 없습니다.";
						break;
					endif;

					## 사용자 정의 필드 저장
					$aryUserFieldParam['AD_ZIP'] = $strZip;
					$aryUserFieldParam['AD_ADDR1'] = $strAddress1;
					$aryUserFieldParam['AD_ADDR2'] = $strAddress2;

				endif;

			endforeach;

			## 결과 값이 있으면 종료.
			if($result) { break; }

		endif;

		## 비밀글 설정
		if($strUbFuncNotice != "Y") { $strUbFuncNotice = "N"; }
		if($strUbFuncLock != "Y") { $strUbFuncLock = "N"; }

		## UB_FUNC 설정
		$aryFunc = "";
		$aryFunc[] = $strUbFuncNotice; // 공지글
		$aryFunc[] = $strUbFuncLock; // 비밀글
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$strFunc = implode($aryFunc);

		## 기존에 등록된 게시글 불러오기
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['UB_NO'] = $intUbNo;
		$param['JOIN_MM'] = "Y";
		$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
		$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
		$strUB_NAME = $aryBoardDataRow['UB_NAME'];
		$strUB_M_ID = $aryBoardDataRow['UB_M_ID'];
		$strUB_PASS = $aryBoardDataRow['UB_PASS'];
		$intUB_READ = $aryBoardDataRow['UB_READ'];
//		$strUB_LNG = $aryBoardDataRow['UB_LNG'];
		$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];
		$strUB_ANS_STEP = $aryBoardDataRow['UB_ANS_STEP'];
		$intUB_ANS_M_NO = $aryBoardDataRow['UB_ANS_M_NO'];
		$strUB_P_CODE = $aryBoardDataRow['UB_P_CODE'];

		## 커뮤니티 수정
		$param						= "";
		$param['B_CODE']			= $strBCode;
		$param['UB_NO']				= $intUbNo;
		$param['UB_NAME']			= $strUB_NAME;
		$param['UB_M_NO']			= $intUB_M_NO;
		$param['UB_M_ID']			= $strUB_M_ID;
		$param['UB_PASS']			= $strUB_PASS;
		$param['UB_MAIL']			= $strUbMail;
		$param['UB_URL']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_TITLE']			= $strUbTitle;
		$param['UB_TEXT']			= $strUbText;
		$param['UB_TEXT_MOBILE']	= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_FUNC']			= $strFunc; // 0=공지글,1=비밀글
		$param['UB_IP']				= $strClientIP;
		$param['UB_READ']			= $intUB_READ;
		$param['UB_BC_NO']			= $intUbBcNo;
		$param['UB_LNG']			= $strUbLng;
		$param['UB_ANS_NO']			= $intUB_ANS_NO;
		$param['UB_ANS_STEP']		= $strUB_ANS_STEP;
		$param['UB_ANS_M_NO']		= $intUB_ANS_M_NO;
		$param['UB_PT_NO']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_CI_NO']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_WINNER']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_P_CODE']			= $strUB_P_CODE;
		$param['UB_P_GRADE']		= $intUbPGrade;
		$param['UB_MOD_DT']			= "NOW()";
		$param['UB_MOD_NO']			= $intMemberNo;
		$re							= $objBoardDataModule->getBoardDataUpdateEx($param);

		## 체크
		if(!$re || $re < 0):
			$result['__STATE__'] = "NO_MODIFY_DATA";
			$result['__MSG__'] = "내용을 수정할 수 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		## 추가필드 불러오기
		$param						= "";
		$param['B_CODE']			= $strBCode;
		$param['AD_UB_NO']			= $intUbNo;
		$intBoardAddFieldTotal		= $objBoardAddFieldModule->getBoardAddFieldSelectEx("OP_COUNT", $param);	

		if(!$intBoardAddFieldTotal):
			## 추가필드 등록
			$param						= $aryUserFieldParam;
			$param['B_CODE']			= $strBCode;
			$param['AD_UB_NO']			= $intUbNo;
			$re							= $objBoardAddFieldModule->getBoardAddFieldInsertEx($param);	
		else:
			## 추가필드 수정
			$param						= $aryUserFieldParam;
			$param['B_CODE']			= $strBCode;
			$param['AD_UB_NO']			= $intUbNo;
			$re							= $objBoardAddFieldModule->getBoardAddFieldUpdateEx($param);	
		endif;

		## 기존에 등록된 첨부파일 삭제
		if($intBI_ATTACHEDFILE_USE):

			## 첨부파일 불러오기
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['FL_UB_NO'] = $intUbNo;
			$aryBoardFileList = $objBoardFileModule->getBoardFileSelectEx("OP_ARYTOTAL", $param);

			## 파일 삭제
			if($strFileDel):
				
				## 삭제 리스트 만들기
				$aryFileDel = explode(",", $strFileDel);

				foreach($aryBoardFileList as $key => $data):

					## 기본정보
					$intFL_NO = $data['FL_NO'];
					$strFL_DIR = $data['FL_DIR'];
					$strFL_NAME = $data['FL_NAME'];
					
					## 삭제 리스트 체크
					if(!in_array($intFL_NO, $aryFileDel)) { continue; }

					## 파일 삭제
					FileDevice::fileDelete(MALL_SHOP . "{$strFL_DIR}/{$strFL_NAME}");
					
					## DB 삭제
					$param = "";
					$param['B_CODE'] = $strBCode;;
					$param['FL_NO'] = $intFL_NO;
					$objBoardFileModule->getBoardFileDeleteEx($param);

				endforeach;

			endif;

		endif;

		## 첨부파일 신규 설정
		if($intBI_ATTACHEDFILE_USE && $arySessionFileList):

			## 파일 삭제 및 업로드
			foreach($arySessionFileList as $key => $data):
		
				## 기본설정
				$strATC_KEY = $data['ATC_KEY'];
				$strATC_FILE = $data['ATC_FILE'];
				$strUploadFileName = $strATC_FILE;
				$aryFileName = explode("_@_", $strUploadFileName);
				$strSaveFileName = FileDevice::getUniqueFileName($strCommunityDataDefaultDir, date("YmdHis") . "_{$strATC_KEY}_%s_@_" . $aryFileName[1]);

				## 파일 이동
				rename("{$strCommunityTempDefaultDir}/{$strATC_FILE}", "{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 파일 타입 구하기
				$strFileType = FileDevice::my_mime_content_type("{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 파일 사이즈 구하기
				$intFileSize = filesize("{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 데이터 베이스 등록
				$param						= "";
				$param['B_CODE']			= $strBCode;
				$param['FL_UB_NO']			= $intUbNo;
				$param['FL_KEY']			= $strATC_KEY;
				$param['FL_DIR']			= $strCommunityDataWebDir;
				$param['FL_NAME']			= $strSaveFileName;
				$param['FL_TYPE']			= $strFileType;
				$param['FL_SIZE']			= $intFileSize;
				$param['FL_REG_DT']			= "NOW()";
				$param['FL_REG_NO']			= $intMemberNo;
				$param['FL_MOD_DT']			= "NOW()";
				$param['FL_MOD_NO']			= $intMemberNo;
				$objBoardFileModule->getBoardFileInsertEx($param);

			endforeach;

			## 첨부파일 세션 졍보 삭제
			unset($_SESSION["FILE"]);

		endif;

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "dataWrite":
		// 글등록

		## 모듈설정
		$objSmsInfo = new SmsInfo($db);
		$objBoardDataModule = new BoardDataModule($db);
		$objBoardAddFieldModule = new BoardAddFieldModule($db);
		$objBoardFileModule = new BoardFileModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];
		$strUbLng = $_POST['ub_lng'];
		$intUbBcNo = $_POST['ub_bc_no'];
		$strUbName = $_POST['ub_name'];		// 필수
		$strUbTitle = $_POST['ub_title'];	// 필수
		$strUbPCode = $_POST['ub_p_code'];
		$intUbPGrade = $_POST['ub_p_grade'];
		$strUbMail = $_POST['ub_mail'];
		$strUbText = $_POST['ub_text'];		// 필수
		$strUbPass = $_POST['ub_pass'];		// 비회원인경우 필수
		$strUbFuncNotice = $_POST['ub_func_notice']; // 공지글
		$strUbFuncLock = $_POST['ub_func_lock']; // 비밀글
		$intMemberNo = $a_admin_no;
		$strMemberID = $a_admin_id;
		$strMemberName = $a_admin_name; // 영문 - 이름, 한글 - 기록 안됨
		$strMemberGroup = $a_admin_group;
		$strMemberLastName = $a_member_last_name; // 영문 - 성, 한글 - 성 + 이름
		$strClientIP = ClientInfo::getClientIP();
		$strLang = $strUbLng;
		$strLangS = $S_ST_LNG;
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 
		$strCommunityTempWebDir = "/upload/community/temp";
		$strCommunityDataWebDir = "/upload/community/data/{$strBCode}/" . date("Ym");
		$strCommunityTempDefaultDir = MALL_SHOP . $strCommunityTempWebDir;
		$strCommunityDataDefaultDir = MALL_SHOP . $strCommunityDataWebDir;
		$arySessionFileList = $_SESSION["FILE"];
		$param['UB_SHOP_NO']				= $_SESSION['ADMIN_SHOP_NO'];

		## 커뮤니티 설정 파일
		if(is_file("{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}")) {
			include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
		}
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		if(is_file("{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}")) {
			include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
		}
		$aryBoardInfoS = $BOARD_INFO[$strBCode];
		foreach($aryBoardInfoS as $key => $data):
			$strTemp = $aryBoardInfo[$key];
			if($strTemp) { continue; }
			$aryBoardInfo[$key] = $data;
		endforeach;
		$strBI_USERFIELD_USE = $aryBoardInfo['BI_USERFIELD_USE']; // 추가필드 사용 - 사용 = Y, 사용안함 = N
		$strBI_SMS_USE = $aryBoardInfo['BI_SMS_USE']; // SMS 사용 - 사용 = Y, 사용안함 = N
		$strBI_SMS_HP_LIST = $aryBoardInfo['BI_SMS_HP_LIST']; // SMS 연락처
		$strBI_SMS_TEXT = $aryBoardInfo['BI_SMS_TEXT']; // SMS 텍스트
		$intBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
		$aryBI_SMS_HP_LIST = explode(",", $strBI_SMS_HP_LIST);


		## 언어 설정
		## 선택된 언어가 없으면 모든 언어 출력 표시로 변경함.
		if(!$strUbLng) { $strUbLng = "--"; }

		## 공백제거
		$strUbName = trim($strUbName);
		$strUbTitle =trim($strUbTitle);

		## 회원인경우 추가 설정.
		## 관리자 페이지에서는 관리자가 작성자명을 임이로 변경할수 있습니다.
//		if($intMemberNo):
//
//			## 이름 설정. 세션정보에서 다시 가져옵니다.
//			$strUbName = "";
//			if($strMemberName && $strMemberLastName) { $strUbName = "{$strMemberName} {$strMemberLastName}"; }
//			else if($strMemberLastName) { $strUbName = $strMemberLastName; }
//			else if($strMemberName) { $strUbName = $strMemberName; }
//
//			## 아이디 설정, 이메일 로그인방식(2) 인경우, 이메일의 @ 앞부분을 ID로 사용합니다.(심성일 이사님 요청사항)
//			## 그러므로, ID값이 중복될수 있습니다.
//			## 추후, 이메일 방식일때, ID자동 생성으로 변경이 되면, 그때 아이디 입력으로 변경 예정.
//			if($S_MEM_CERITY == 2) { list($strMemberID) = explode("@", $strMemberID, -1); }
//		endif;

		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_B_CODE";
			$result['__MSG__'] = "커뮤니티 코드가 없습니다.";
			break;
		endif;
		if(!$strUbLng):
			$result['__STATE__'] = "NO_B_LNG";
			$result['__MSG__'] = "언어 코드가 없습니다.";
			break;
		endif;
		if(!$strUbName):
			$result['__STATE__'] = "NO_UB_NAME";
			$result['__MSG__'] = "이름이 없습니다.";
			break;
		endif;
		if(!$strUbTitle):
			$result['__STATE__'] = "NO_UB_TITLE";
			$result['__MSG__'] = "제목이 없습니다.";
			break;
		endif;
		if(!$strUbText):
			$result['__STATE__'] = "NO_UB_TEXT";
			$result['__MSG__'] = "내용이 없습니다.";
			break;
		endif;
		if(!$intMemberNo && !$strUbPass): // 비회원은 비밀번호가 반드시 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = "비밀번호가 없습니다.";
			break;
		endif;
		if($intMemberNo && !$strMemberID): // 회원은 반드시 회원ID가 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = "아이디이(가) 없습니다.";
			break;
		endif;

		## 관리자 그룹만 공지글을 작성할수 있습니다.
		if(!in_array($strMemberGroup, array("001")) && $strUbFuncNotice == "Y"):
			$result['__STATE__'] = "NO_AUTH_NOTICE";
			$result['__MSG__'] = "공지글은 관리자만 작성할 수 있습니다.";
			break;
		endif;

		## 그룹 폴더 만들기
		if($intBI_ATTACHEDFILE_USE && !FileDevice::makeFolder($strCommunityDataDefaultDir)):
			$result['__STATE__'] = "NO_DIR_1";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00124"]; // 업로드 폴더를 생성할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;
		## 메일 내용이 작성되어 있다면 체크
		if($strUbMail):
			$isEmail = StringInfo::isEmailCheck($strUbMail);
			if(!$isEmail):
				$result['__STATE__'] = "WRONG_UB_MAIL_WRITE";
				$result['__MSG__'] = $LNG_TRANS_CHAR["BS00100"]; // 이메일 형식이 아닙니다.
				break;
			endif;
		endif;

		## 추가 필드 사용하는 경우
		if($strBI_USERFIELD_USE == "Y"):

			## 추가필드 배열 만들기
			$aryUserfieldList = "";
			foreach($aryBoardInfo as $key => $data):
				
				## 기본설정
				$aryTemp = explode("_", $key);
				$intTempCnt = sizeof($aryTemp);
				if($intTempCnt == 4): 
					$strTemp1 = $aryTemp[0];
					$strTemp2 = $aryTemp[1];
					$strTemp3 = $aryTemp[2];
					$strTemp4 = $aryTemp[3];
				elseif($intTempCnt == 5):
					$strTemp1 = $aryTemp[0];
					$strTemp2 = $aryTemp[1];
					$strTemp3 = $aryTemp[2];
					$strTemp4 = "{$aryTemp[3]}_{$aryTemp[4]}";
				endif;
				## 체크
				if($strTemp2 != "AD") { continue; }

				## 추가필드 배열 만들기
				$aryUserfieldList[$strTemp3][$strTemp4] = $data;

			endforeach;

			## 사용자 정의 필드 설정, param 설정
			$aryUserFieldParam = "";
			foreach($aryUserfieldList as $key => $data):

				## 기본설정
				$strValue = "";
				$strKeyLower = strtolower($key);
				$strUSE = $data['USE'];
				$strESSENTIAL = $data['ESSENTIAL'];
				$strONLYADMIN = $data['ONLYADMIN'];
				$strKIND = $data['KIND'];
				$strNAME = $data['NAME'];
				$strParamName = "AD_{$key}";

				## 유효성 체크 설정
				$isCheckData = true;
				if($strUSE != "Y") { $isCheckData = false; } 
				if($strONLYADMIN == "Y") { $isCheckData = false; } // 관리자 전용인경우 
				if($strESSENTIAL != "Y") { $isCheckData = false; } 

				## 종류별로 설정 방식이 틀려집니다.
				if(in_array($strKIND, array("text","select","radio","textarea","wysiwyg"))):
					
					## 기본설정
					$strValue = $_POST[$strKeyLower];

					## 공백 제거
//					$strValue = trim($strValue);

					## 유효성 체크
					## 필수로 입력을 받아야 하는 경우 null 값 체크
					if($isCheckData && !$strValue):
						$result['__STATE__'] = "NO_{$key}";
						$result['__MSG__'] = "{$strNAME} 이(가) 없습니다.";
						break;
					endif;

					## 사용자 정의 필드 저장
					$aryUserFieldParam[$strParamName] = $strValue;

				elseif(in_array($strKIND, array("phone"))):
					
					if($strLang == "KR"):

						## 기본설정
						$strPhone1 = $_POST["{$strKeyLower}_1"];
						$strPhone2 = $_POST["{$strKeyLower}_2"];
						$strPhone3 = $_POST["{$strKeyLower}_3"];

						## 공백 제거
						$strPhone1 = trim($strPhone1);
						$strPhone2 = trim($strPhone2);
						$strPhone3 = trim($strPhone3);

						if($strPhone1 && $strPhone2 && $strPhone3) { $strValue = "{$strPhone1}-{$strPhone2}-{$strPhone3}"; };

					else:

						## 기본설정
						$strValue = $_POST[$strKeyLower];

						## 공백 제거
						$strValue = trim($strValue);

					endif;

					## 유효성 체크
					## 필수로 입력을 받아야 하는 경우 null 값 체크
					if($isCheckData && !$strValue):
						$result['__STATE__'] = "NO_{$key}";
						$result['__MSG__'] = "{$strNAME} 이(가) 없습니다.";
						break;
					endif;

					## 사용자 정의 필드 저장
					$aryUserFieldParam[$strParamName] = $strValue;

				elseif(in_array($strKIND, array("address"))):

					if($strLang == "KR"):
						
						## 기본설정
						$aryValue = "";
						$strZip1 = $_POST["{$strKeyLower}_zip1"];
						$strZip2 = $_POST["{$strKeyLower}_zip2"];
						$strAddress1 = $_POST["{$strKeyLower}_1"];
						$strAddress2 = $_POST["{$strKeyLower}_2"];

						## 공백 제거
						$strZip1 = trim($strZip1);
						$strZip2 = trim($strZip2);
						$strAddress1 = trim($strAddress1);
						$strAddress2 = trim($strAddress2);

						## 데이터 만들기
						if($strZip1 && $strZip2) { $aryValue['zip'] = "{$strZip1}-{$strZip2}"; }
						$aryValue['address1'] = $strAddress1;					
						$aryValue['address2'] = $strAddress2;
						
					else:

						## 기본설정
						$aryValue = "";
						$strZip = $_POST["{$strKeyLower}_zip"];
						$strAddress1 = $_POST["{$strKeyLower}_1"];
						$strAddress2 = $_POST["{$strKeyLower}_2"];

						## 공백 제거
						$strZip = trim($strZip);
						$strAddress1 = trim($strAddress1);
						$strAddress2 = trim($strAddress2);

						## 데이터 만들기
						$aryValue['zip'] = $strZip; 
						$aryValue['address1'] = $strAddress1;					
						$aryValue['address2'] = $strAddress2;

					endif;
					
					## 기본설정
					$strZip = $aryValue['zip'];
					$strAddress1 = $aryValue['address1'];
					$strAddress2 = $aryValue['address2'];

					## 체크
					if($isCheckData && !($strZip && $strAddress1 && $strAddress2)):
						$result['__STATE__'] = "NO_{$key}";
						$result['__MSG__'] = "{$strNAME}이(가) 없습니다.";
						break;
					endif;

					## 사용자 정의 필드 저장
					$aryUserFieldParam['AD_ZIP'] = $strZip;
					$aryUserFieldParam['AD_ADDR1'] = $strAddress1;
					$aryUserFieldParam['AD_ADDR2'] = $strAddress2;

				endif;

			endforeach;

			## 결과 값이 있으면 종료.
			if($result) { break; }

		endif;

		## 비밀글 설정
		if($strUbFuncNotice != "Y") { $strUbFuncNotice = "N"; }
		if($strUbFuncLock != "Y") { $strUbFuncLock = "N"; }

		## UB_FUNC 설정
		$aryFunc = "";
		$aryFunc[] = $strUbFuncNotice; // 공지글
		$aryFunc[] = $strUbFuncLock; // 비밀글
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$strFunc = implode($aryFunc);

		## 커뮤니티 등록
		$param['B_CODE']			= $strBCode;
		$param['UB_NAME']			= $strUbName;
		$param['UB_M_NO']			= $intMemberNo;
		$param['UB_M_ID']			= $strMemberID;
		$param['UB_PASS']			= $strUbPass;
		$param['UB_MAIL']			= $strUbMail;
		$param['UB_URL']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_TITLE']			= $strUbTitle;
		$param['UB_TEXT']			= $strUbText;
		$param['UB_TEXT_MOBILE']	= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_FUNC']			= $strFunc;		// 0=공지글,1=비밀글
		$param['UB_IP']				= $strClientIP;
		$param['UB_READ']			= 0;
		$param['UB_BC_NO']			= $intUbBcNo;
		$param['UB_LNG']			= $strUbLng;
		$param['UB_ANS_NO']			= "";
		$param['UB_ANS_STEP']		= "";
		$param['UB_ANS_M_NO']		= "";
		$param['UB_PT_NO']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_CI_NO']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_WINNER']			= "";			// 2014.07.18 kim hee sung 사용안함.
		$param['UB_P_CODE']			= $strUbPCode;
		$param['UB_P_GRADE']		= $intUbPGrade;
		$param['UB_REG_DT']			= "NOW()";
		$param['UB_REG_NO']			= $intMemberNo;
		$param['UB_MOD_DT']			= "NOW()";
		$param['UB_MOD_NO']			= $intMemberNo;
		$intUB_NO					= $objBoardDataModule->getBoardDataInsertEx($param);

		## 체크
		if(!$intUB_NO && $intUB_NO < 0):
			$result['__STATE__'] = "NO_INSERT_DATA";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00106"]; // 내용을 등록할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;

		## 커뮤니티 계층형 컬럼 업데이트
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['UB_NO'] = $intUB_NO;
		$param['UB_ANS_NO'] = $intUB_NO;
		$param['UB_ANS_DEPTH'] = 1;
		$param['UB_ANS_STEP'] = '';
		$param['UB_ANS_M_NO'] = $intMemberNo;
		$objBoardDataModule->getBoardDataAnsUpdateEx2($param);
		
		## 추가필드 등록
		$param						= $aryUserFieldParam;
		$param['B_CODE']			= $strBCode;
		$param['AD_UB_NO']			= $intUB_NO;
		$re							= $objBoardAddFieldModule->getBoardAddFieldInsertEx($param);	


		## APP PUSH
		if($strBCode == 'NOTICE')
		{
			//모바일 App관련 설정 하나로 묶음
	 		include_once	MALL_HOME."/include/mobileApp.inc.php";

			$strUbTitle = strHanCut($strUbTitle,90);
			
			$message = "[Fingbook소식]".$strUbTitle;

			//$message = urlencode($message);

			$message = $message."@@@"."http://222.122.20.23/?menuType=community&mode=dataView&b_code=NOTICE&ubNo=".$intUB_NO;

			$message = urlencode($message);

			$MobileMgr	= new MobileMgr();
					
			$IOSPush	= new IOSPushMessage();

			//$MobileMgr->setM_NO($intMemberNo);
			$MobileMgr->setMOBILE_DEVICE_OS('G');
			$apiKey= $MobileMgr->getMobileKeyList($db);

			//print_r($apiKey);
			if(count($apiKey) > 0 ){
				for($i=0;$i < count($apiKey); $i++){
					//$devices[] = $apiKey[$i][MOBILE_DEVICE_KEY];
					$AndPush = new GCMPushMessage($strAndroidApiKey);
					$AndPush->setDevices($apiKey[$i][MOBILE_DEVICE_KEY]);
					$response = $AndPush->send($message);
				}
			}
			
			//PRINT_R($devices);
			//exit;
			//$AndPush = new GCMPushMessage($strAndroidApiKey);
			//$AndPush->setDevices($devices);
			//$response = $AndPush->send($message);
	
//$txt = urlencode('test');
//$text = iconv("euc-kr","UTF-8",$txt);
//$num = 1;
//$code = "1111";
//$deviceToken = 'b09da1c10fe8d1000b9351406e7944c9832f84618dabd416de5921965dc364ac'; // 앱실행후 로그로 찍힌 디바이스 토큰 정보 입력
//send("휴대폰 토큰값", $text, $num, "default", $code, "custom", "custom data");

			$MobileMgr->setMOBILE_DEVICE_OS('A');
			$apiKey= $MobileMgr->getMobileKeyList($db);
			
			$message = "[Fingbook소식]".$strUbTitle;
			$url =	"http://222.122.20.23/?menuType=community&mode=dataView&b_code=NOTICE&ubNo=".$intUB_NO;
 		  //$arrMessage["REPLY_MSG"] = "[136601소식]".$strUbTitle;
		  //$arrMessage["PUSH_URL"] = "http://222.122.20.23/?menuType=community&mode=dataView&b_code=NOTICE&ubNo=".$intUB_NO;
		 
		  //$arrMessage = array_keys($arrMessage);
			
		
			if(count($apiKey) > 0){
				$num = 1;
				for($i=0;$i < count($apiKey); $i++){
							
					$IOSPush->send($apiKey[$i][MOBILE_DEVICE_KEY], $message, $url, $num, "default");
				}
			}
		}

		## 글작성시 SMS 보내기 설정
		if($strBI_SMS_USE == "Y"):
			
			## 기본 설정
			$isSmsSend = true;

			## 체크
			if(!$aryBI_SMS_HP_LIST) { $isSmsSend = false; }
			if(!$strBI_SMS_TEXT) { $isSmsSend = false; }

			## SMS 전송
			foreach($aryBI_SMS_HP_LIST as $key => $phone):
				$param = "";
				$param['phone'] = $phone;
				$param['callBack'] = '010-0000-0000';
				$param['msg'] = $strBI_SMS_TEXT;
				$param['siteName'] = $S_SITE_NM;
				$objSmsInfo->goSendSms($param);
			endforeach;
		endif;

		## 첨부파일 설정
		if($intBI_ATTACHEDFILE_USE && $arySessionFileList):

			## 파일 삭제 및 업로드
			foreach($arySessionFileList as $key => $data):
		
				## 기본설정
				$strATC_KEY = $data['ATC_KEY'];
				$strATC_FILE = $data['ATC_FILE'];
				$strUploadFileName = $strATC_FILE;
				$aryFileName = explode("_@_", $strUploadFileName);
				$strSaveFileName = FileDevice::getUniqueFileName($strCommunityDataDefaultDir, date("YmdHis") . "_{$strATC_KEY}_%s_@_" . $aryFileName[1]);

				## 파일 이동
				rename("{$strCommunityTempDefaultDir}/{$strATC_FILE}", "{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 파일 타입 구하기
				$strFileType = FileDevice::my_mime_content_type("{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 파일 사이즈 구하기
				$intFileSize = filesize("{$strCommunityDataDefaultDir}/{$strSaveFileName}");

				## 데이터 베이스 등록
				$param						= "";
				$param['B_CODE']			= $strBCode;
				$param['FL_UB_NO']			= $intUB_NO;
				$param['FL_KEY']			= $strATC_KEY;
				$param['FL_DIR']			= $strCommunityDataWebDir;
				$param['FL_NAME']			= $strSaveFileName;
				$param['FL_TYPE']			= $strFileType;
				$param['FL_SIZE']			= $intFileSize;
				$param['FL_REG_DT']			= "NOW()";
				$param['FL_REG_NO']			= $intMemberNo;
				$param['FL_MOD_DT']			= "NOW()";
				$param['FL_MOD_NO']			= $intMemberNo;
				$objBoardFileModule->getBoardFileInsertEx($param);

			endforeach;

			## 첨부파일 세션 졍보 삭제
			unset($_SESSION["FILE"]);

		endif;

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "atcDelete":
		// 첨부파일 삭제

		## 기본설정
		$intNo = $_POST['no'];
		$aryDelFile = $_SESSION['FILE'][$intNo];
		$strATC_DIR = $aryDelFile['ATC_DIR'];
		$strATC_FILE = $aryDelFile['ATC_FILE'];

		## 체크
		if(!$aryDelFile):
			$result['__STATE__'] = "NO_DEL_FILE";
			$result['__MSG__'] = "삭제할 파일이 없습니다.";
			break;
		endif;

		## 파일 삭제
		FileDevice::fileDelete(MALL_SHOP . "{$strATC_DIR}/{$strATC_FILE}");

		## 세션 데이터 삭제
		unset($_SESSION['FILE'][$intNo]);

		## 전달 데이터 만들기
		$aryReturnData['FILE'] = $_SESSION['FILE'];

		## 마무리
		$result['__STATE__'] = "SUCCESS";
		$result['__DATA__'] = $aryReturnData;	

	break;

	case "atcWrite":
		// 첨부파일 등록

		## 기본설정
		$strBCode = $_POST['b_code'];
		$strUbLng = $_POST['ub_lng'];
		$strLang = $strUbLng;
		$strLangS = $S_ST_LNG;
		if(!$strLang) { $strLang = $strLangS; }
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 
		$strCommunityTempWebDir = "/upload/community/temp";
		$strCommunityTempDefaultDir = MALL_SHOP . $strCommunityTempWebDir;

		## 커뮤니티 설정 파일
		include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
		$aryBoardInfoS = $BOARD_INFO[$strBCode];
		foreach($aryBoardInfoS as $key => $data):
			$strTemp = $aryBoardInfo[$key];
			if($strTemp) { continue; }
			$aryBoardInfo[$key] = $data;
		endforeach;
		$intBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
		$aryBI_ATTACHEDFILE_KEY = $aryBoardInfo['BI_ATTACHEDFILE_KEY']; // 첨부파일 키

		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_B_CODE";
			$result['__MSG__'] = "커뮤니티 코드이(가) 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_B_LNG";
			$result['__MSG__'] = "언어 코드이(가) 없습니다.";
			break;
		endif;
		if(!$intBI_ATTACHEDFILE_USE):
			$result['__STATE__'] = "NO_BI_ATTACHEDFILE_USE";
			$result['__MSG__'] = "첨부파일을 업로드 할 수 없습니다. 관리자에게 문의하세요.";
			break;
		endif;
		if(!$_FILES):
			$result['__STATE__'] = "NO_FILE";
			$result['__MSG__'] = "첨부파일이 없습니다.";
			break;
		endif;

		## 파일 업로드
		## 그룹 폴더 만들기
		if(!FileDevice::makeFolder($strCommunityTempDefaultDir)):
			$result['__STATE__'] = "NO_DIR";
			$result['__MSG__'] = "업로드 폴더를 생성할 수 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		for($i=0;$i<$intBI_ATTACHEDFILE_USE;$i++):
			
			## 기본 
			$key = "file_{$i}";
			$aryFile = $_FILES[$key];
			$strAtcKey = $aryBI_ATTACHEDFILE_KEY[$i];

			## 기본설정
			$strName = $aryFile['name'];
			$strType = $aryFile['type'];
			$intSize = $aryFile['size'];
			$strError = $aryFile['error'];
			$strSaveFileName = FileDevice::getUniqueFileName($strCommunityTempDefaultDir, date("YmdHis") . "_{$strAtcKey}_%s_@_" . $strName);

			## 체크
			if(!$strName ) { continue; }
			if($strError) { continue; }
			if(!$strSaveFileName) { continue; }

			## 파일 업로드
			$re = FileDevice::upload($key, "{$strCommunityTempDefaultDir}/{$strSaveFileName}");

			## 결과 체크
			if(!$re):
				$result['__STATE__'] = "NO_B_CODE";
				$result['__MSG__'] = "업로드 작업중 오류가 발생했습니다. 관리자에게 문의하세요.";
				break;
			endif;
			 
			## 결과 저장
			$param = "";
			$param['ATC_KEY'] = $strAtcKey;
			$param['ATC_FILE'] = $strSaveFileName;
			$param['ATC_DIR'] = $strCommunityTempWebDir;
			$_SESSION['FILE'][] = $param;

		endfor;


		## 체크
		if($result) { break; }			

		## 전달 데이터 만들기
		$aryReturnData = "";
		$aryReturnData['WEB_DIR'] = $strCommunityTempWebDir;

		## 파일정보
		foreach($_SESSION['FILE'] as $key => $data):
	
			## 기본설정
			$isDEL = $data['DEL'];

			## 삭제된 데이터 등록안함.
			if($isDEL) { continue; }

			## 등록
			$aryReturnData['FILE'][$key] = $data;

		endforeach;

		## 마무리
		$result['__STATE__'] = "SUCCESS";
		$result['__DATA__'] = $aryReturnData;	

	break;

	case "dataDelete":
		// 커뮤니티 삭제

		## 모듈설정
		$objBoardDataModule = new BoardDataModule($db);
		$objBoardCommentModule = new BoardCommentModule($db);
		$objBoardFileModule = new BoardFileModule($db);
		$objBoardAddFieldModule = new BoardAddFieldModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];
		$intUbNo = $_POST['ubNo'];
		$strDeleteList = $_POST['deleteList'];
		$intMemberNo = $a_admin_no;
		$strMemberID = $a_admin_id;
		$isADTable = $db->getIsTable("BOARD_AD_{$strBCode}");
		$isCMTable = $db->getIsTable("BOARD_CM_{$strBCode}");
		$isFLTable = $db->getIsTable("BOARD_FL_{$strBCode}");
		if($intUbNo) { $strDeleteList = $intUbNo; }

		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_B_CODE";
			$result['__MSG__'] = "커뮤니티 코드이(가) 없습니다.";
			break;
		endif;
		if(!($intUbNo || $strDeleteList)):
			$result['__STATE__'] = "NO_UB_NO";
			$result['__MSG__'] = "게시글 번호이(가) 없습니다.";
			break;
		endif;

		## 배열 만들기
		$intFailCnt = 0;
		$aryDeleteList = explode(",", $strDeleteList);

		$strErrorMsg = '';
		foreach($aryDeleteList as $key => $intUbNo):
			
			## 댓글체크, 댓글이 있는 경우 삭제할수 없습니다.
			if($isCMTable):
				$param = '';
				$param['CM_UB_NO'] = $intUbNo;
				$param['B_CODE'] = $strBCode;
				$intCnt = $objBoardCommentModule->getBoardCommentSelectEx("OP_COUNT", $param);
				if($intCnt):
					$strErrorMsg = "댓글이 있는 게시글은 살제 할 수 없습니다.({$intUbNo})";
					break;
				endif;
			endif;

			## 답변글체크, 답변이 있는 경우 삭제 할 수 없습니다.
			$param = '';
			$param['UB_ANS_NO'] = $intUbNo;
			$param['B_CODE'] = $strBCode;
			$intCnt = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);
			if($intCnt > 1):
				$strErrorMsg = "답변이 있는 게시글은 삭제 할 수 없습니다.({$intUbNo})";
				break;
			endif;

			## 게시글 불러오기
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['UB_NO'] = $intUbNo;
			$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
			$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];
			$strUB_ANS_STEP = $aryBoardDataRow['UB_ANS_STEP'];

			## 답변글에 답변 체크, 답변글에 답변이 있는경우 삭제 할 수 없습니다.
			if($intUB_ANS_NO && $strUB_ANS_STEP):
				$param = '';
				$param['B_CODE'] = $strBCode;
				$param['UB_ANS_NO'] = $intUB_ANS_NO;
				$param['UB_ANS_STEP_LIKE'] = "{$strUB_ANS_STEP}%";
				$intCnt = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);
				if($intCnt > 1):
					$strErrorMsg = "답변이 있는 게시글은 삭제 할 수 없습니다.({$intUbNo})";
					break;
				endif;
			endif;

			## 첨부파일 설정
			if($isFLTable):
				## 첨부파일 리스트 불러오기
				$param = '';
				$param['B_CODE'] = $strBCode;
				$param['FL_UB_NO'] = $intUbNo;
				$aryBoardFileList = $objBoardFileModule->getBoardFileSelectEx("OP_ARYTOTAL", $param);

				## 첨부파일 삭제
				if($aryBoardFileList):
					foreach($aryBoardFileList as $key => $row):
						
						## 기본설정
						$strFL_DIR = $row['FL_DIR'];
						$strFL_NAME = $row['FL_NAME'];
						$path = rtrim(MALL_SHOP, '/') . $strFL_DIR . '/' . $strFL_NAME;

						## 삭제
						FileDevice::fileDelete($path);

					endforeach;
				endif;

				## 첨부파일 리스트 삭제
				$param = '';
				$param['B_CODE'] = $strBCode;
				$param['FL_UB_NO'] = $intUbNo;
				$objBoardFileModule->getBoardFileUbNoDeleteEx($param);
			endif;

			## 추가필드 삭제
			if($isADTable):
				$param = '';
				$param['B_CODE'] = $strBCode;
				$param['AD_UB_NO'] = $intUbNo;
				$objBoardAddFieldModule->getBoardAddFieldDeleteEx($param);
			endif;

			## 게시글 삭제
			$param = '';
			$param['B_CODE'] = $strBCode;
			$param['UB_NO'] = $intUbNo;
			$objBoardDataModule->getBoardDataDeleteEx($param);

		endforeach;

		## 실패 건수가 있으면..
		if($strErrorMsg):
			$result['__STATE__'] = "HAVE_FAIL";
			$result['__MSG__'] = $strErrorMsg;
			break;
		endif;

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

// 2015.01.16 kim hee sung
// 삭제 기능 개선
//	case "dataDelete":
//		// 커뮤니티 삭제
//
//		## 모듈설정
//		$objBoardDataModule = new BoardDataModule($db);
//
//		## 기본설정
//		$strBCode = $_POST['b_code'];
//		$intUbNo = $_POST['ubNo'];
//		$strDeleteList = $_POST['deleteList'];
//		$intMemberNo = $a_admin_no;
//		$strMemberID = $a_admin_id;
//		if($intUbNo) { $strDeleteList = $intUbNo; }
//
//		## 체크
//		if(!$strBCode):
//			$result['__STATE__'] = "NO_B_CODE";
//			$result['__MSG__'] = "커뮤니티 코드이(가) 없습니다.";
//			break;
//		endif;
//		if(!($intUbNo || $strDeleteList)):
//			$result['__STATE__'] = "NO_UB_NO";
//			$result['__MSG__'] = "게시글 번호이(가) 없습니다.";
//			break;
//		endif;
//
//		## 배열 만들기
//		$intFailCnt = 0;
//		$aryDeleteList = explode(",", $strDeleteList);
//		
//		foreach($aryDeleteList as $key => $intUbNo):
//
//			## 기존에 등록된 게시글 불러오기
//			$param = "";
//			$param['B_CODE'] = $strBCode;
//			$param['UB_NO'] = $intUbNo;
//			$param['JOIN_MM'] = "Y";
//			$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
//			if(!$aryBoardDataRow):
//				$intFailCnt++;
//				continue;
//			endif;
//
//			## 내용 삭제 표시
//			$param = "";
//			$param['B_CODE'] = $strBCode;
//			$param['UB_NO'] = $intUbNo;
//			$param['UB_DEL'] = "Y";
//			$param['UB_MOD_DT'] = "NOW()";
//			$param['UB_MOD_NO'] = $intMemberNo;
//			$re = $objBoardDataModule->getBoardDataDelUpdateEx($param);
//			if(!$re || $re < 0):
//				$intFailCnt++;
//				continue;
//			endif;
//
//		endforeach;
//
//		## 실패 건수가 있으면..
//		if($intFailCnt):
//			$result['__STATE__'] = "HAVE_FAIL";
//			$result['__MSG__'] = "실패 건수가 있습니다. 관리자에게 문의하시기 바랍니다.({$intFailCnt})";
//			break;
//		endif;
//
//		## 마무리
//		$result['__STATE__'] = "SUCCESS";
//	break;

	endswitch;