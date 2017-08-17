<?php

	switch($strAct):

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
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00105"])); // 삭제할 파일이 없습니다.
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
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00104"])); // 커뮤니티 코드이(가) 없습니다.
			break;
		endif;
		if(!$strUbLng):
			$result['__STATE__'] = "NO_B_LNG";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00105"])); // 언어 코드이(가) 없습니다.
			break;
		endif;
		if(!$intBI_ATTACHEDFILE_USE):
			$result['__STATE__'] = "NO_BI_ATTACHEDFILE_USE";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00120"]; // 첨부파일을 업로드 할 수 없습니다. 관리자에게 문의하세요.
			break;
		endif;
		if(!$_FILES):
			$result['__STATE__'] = "NO_FILE";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00121"]; // 첨부파일이 없습니다.
			break;
		endif;

		## 파일 업로드
		## 그룹 폴더 만들기
		if(!FileDevice::makeFolder($strCommunityTempDefaultDir)):
			$result['__STATE__'] = "NO_DIR";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00124"]; // 업로드 폴더를 생성할 수 없습니다. 관리자에게 문의하세요.
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
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00122"]; // 업로드 작업중 오류가 발생했습니다. 관리자에게 문의하세요.
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

	case "dataPasswordCheck":
		// 비빌번호 체크

		## 모듈설정
		$objBoardDataModule = new BoardDataModule($db);
		
		## 기본설정
		$strBCode = $_POST['b_code'];
		$intUbNo = $_POST['ub_no'];
		$strUbPass = $_POST['ub_pass'];

		## 세션 삭제
		$_SESSION['communityPasswordCode'] = "";

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
		if(!$strUbPass):
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00002"])); // 비밀번호이(가) 없습니다.
			break;
		endif;

		## 데이터 불러오기
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['UB_NO'] = $intUbNo;
		$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
		$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];
		$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
		$strUB_PASS = $aryBoardDataRow['UB_PASS'];

		## 답변글인경우, 원글 정보도 불러옵니다.
		if($intUbNo != $intUB_ANS_NO):
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['UB_NO'] = $intUB_ANS_NO;
			$aryAnsBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
			$intANS_UB_M_NO = $aryAnsBoardDataRow['UB_M_NO'];
			$strANS_UB_PASS = $aryAnsBoardDataRow['UB_PASS'];
		endif;

		## 체크
		if(!$aryBoardDataRow):
			$result['__STATE__'] = "NO_DATA";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00115"]; // 내용을 찾을수 없습니다.\\n고객센터로 문의하시기 바랍니다.
			break;	
		endif;
		if($intUB_M_NO && $intANS_UB_M_NO):
			$result['__STATE__'] = "NO_UB_M_NO";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00116"]; // 회원글은 비밀번호 찾기 기능을 지원하지 않습니다. 
			break;	
		endif;
		if(!$strUB_PASS && !$strANS_UB_PASS):
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00117"]; // 비회원글에 비밀번호가 없습니다. 관리자에게 문의하세요.
			break;	
		endif;
		if($strUbPass != $strUB_PASS && $strUbPass != $strANS_UB_PASS):
			$result['__STATE__'] = "DIFF_UB_PASS";
			$result['__MSG__'] = $LNG_TRANS_CHAR["PS00019"]; // 비밀번호가 틀렸습니다.
			break;	
		endif;

		## 암호화 만들기
		$strCommunityPasswordCode = "{$strBCode}_{$intUbNo}_{$strUbPass}";
		$strCommunityPasswordCode = crypt($strCommunityPasswordCode);
		
		## 세션에 보관
		$_SESSION['communityPasswordCode'] = $strCommunityPasswordCode;

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "dataDelete":
		// 글삭제

		## 모듈설정
		$objBoardDataModule = new BoardDataModule($db);
		$objBoardCommentModule = new BoardCommentModule($db);
		$objBoardFileModule = new BoardFileModule($db);
		$objBoardAddFieldModule = new BoardAddFieldModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];
		$intUbNo = $_POST['ub_no'];
		$intMemberNo = $g_member_no;
		$strMemberID = $g_member_id;
		$isADTable = $db->getIsTable("BOARD_AD_{$strBCode}");
		$isCMTable = $db->getIsTable("BOARD_CM_{$strBCode}");
		$isFLTable = $db->getIsTable("BOARD_FL_{$strBCode}");

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

		## 기존에 등록된 게시글 불러오기
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['UB_NO'] = $intUbNo;
		$param['JOIN_MM'] = "Y";
		$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
		$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
		$strUB_PASS = $aryBoardDataRow['UB_PASS'];
		$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];
		$strUB_ANS_STEP = $aryBoardDataRow['UB_ANS_STEP'];

		## 작성자 권한 체크
		if($intUB_M_NO): 
			##회원글
			if(!$intMemberNo):
				$result['__STATE__'] = "NEED_LOGIN";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
				break;	
			endif;
			if($intMemberNo != $intUB_M_NO):
				$result['__STATE__'] = "DIFF_USER";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00111"]; // 게시판을 삭제하실 권한이 없습니다.\\n본인글만 삭제할 수 있습니다.
				break;	
			endif;
		else: 
			##비회원글
			
			## 기본 설정
			$strCommunityPasswordCode = $_SESSION['communityPasswordCode']; 

			## 세션 정보 삭제
			$_SESSION['communityPasswordCode'] = "";

			## 체크
			if(!$strCommunityPasswordCode):
				$result['__STATE__'] = "NEED_PASSWORD_CODE";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00118"]; // 비회원이 작성한 글은 비밀번호가 필요합니다.
				break;	
			endif;
			if(!$strUB_PASS):
				$result['__STATE__'] = "NO_UB_PASS";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00116"]; // 비회원글에 비밀번호가 없습니다. 관리자에게 문의하세요.
				break;	
			endif;

			## 암호화 만들기
			$strTemp = "{$strBCode}_{$intUbNo}_{$strUB_PASS}";
			$strTemp = crypt($strTemp, $strCommunityPasswordCode);
			if($strCommunityPasswordCode != $strTemp):
				$result['__STATE__'] = "DIFF_USER";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00111"]; // 게시판을 삭제하실 권한이 없습니다.\\n본인글만 삭제할 수 있습니다.
				break;	
			endif;
		endif;

		## 댓글체크, 댓글이 있는 경우 삭제할수 없습니다.
		if($isCMTable):
			$param = '';
			$param['CM_UB_NO'] = $intUbNo;
			$param['B_CODE'] = $strBCode;
			$intCnt = $objBoardCommentModule->getBoardCommentSelectEx("OP_COUNT", $param);
			if($intCnt):
				$result['__STATE__'] = "HAVE_REPLAY";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00154"]; //댓글이 있는 게시글은 살제 할 수 없습니다.
				break;
			endif;
		endif;

		## 답변글체크, 답변이 있는 경우 삭제 할 수 없습니다.
		$param = '';
		$param['UB_ANS_NO'] = $intUbNo;
		$param['B_CODE'] = $strBCode;
		$intCnt = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);
		if($intCnt > 1):
			$result['__STATE__'] = "HAVE_ANSER";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00155"]; //답변이 있는 게시글은 삭제 할 수 없습니다.
			break;
		endif;

		## 답변글에 답변 체크, 답변글에 답변이 있는경우 삭제 할 수 없습니다.
		if($intUB_ANS_NO && $strUB_ANS_STEP):
			$param = '';
			$param['B_CODE'] = $strBCode;
			$param['UB_ANS_NO'] = $intUB_ANS_NO;
			$param['UB_ANS_STEP_LIKE'] = "{$strUB_ANS_STEP}%";
			$intCnt = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);
			if($intCnt > 1):
				$result['__STATE__'] = "HAVE_ANSER";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00155"]; //답변이 있는 게시글은 삭제 할 수 없습니다.
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

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

// 2015.01.16 kim hee sung 삭제기능변경
//	case "dataDelete":
//		// 글삭제
//
//		## 모듈설정
//		$objBoardDataModule = new BoardDataModule($db);
//
//		## 기본설정
//		$strBCode = $_POST['b_code'];
//		$intUbNo = $_POST['ub_no'];
//		$intMemberNo = $g_member_no;
//		$strMemberID = $g_member_id;
//
//		## 체크
//		if(!$strBCode):
//			$result['__STATE__'] = "NO_B_CODE";
//			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00104"])); // 커뮤니티 코드이(가) 없습니다.
//			break;
//		endif;
//		if(!$intUbNo):
//			$result['__STATE__'] = "NO_UB_NO";
//			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00106"])); // 게시글 번호이(가) 없습니다.
//			break;
//		endif;
//
//		## 기존에 등록된 게시글 불러오기
//		$param = "";
//		$param['B_CODE'] = $strBCode;
//		$param['UB_NO'] = $intUbNo;
//		$param['JOIN_MM'] = "Y";
//		$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
//		$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
//		$strUB_PASS = $aryBoardDataRow['UB_PASS'];
//
//		## 작성자 권한 체크
//		if($intUB_M_NO): 
//			##회원글
//			if(!$intMemberNo):
//				$result['__STATE__'] = "NEED_LOGIN";
//				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
//				break;	
//			endif;
//			if($intMemberNo != $intUB_M_NO):
//				$result['__STATE__'] = "DIFF_USER";
//				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00111"]; // 게시판을 삭제하실 권한이 없습니다.\\n본인글만 삭제할 수 있습니다.
//				break;	
//			endif;
//		else: 
//			##비회원글
//			
//			## 기본 설정
//			$strCommunityPasswordCode = $_SESSION['communityPasswordCode']; 
//
//			## 세션 정보 삭제
//			$_SESSION['communityPasswordCode'] = "";
//
//			## 체크
//			if(!$strCommunityPasswordCode):
//				$result['__STATE__'] = "NEED_PASSWORD_CODE";
//				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00118"]; // 비회원이 작성한 글은 비밀번호가 필요합니다.
//				break;	
//			endif;
//			if(!$strUB_PASS):
//				$result['__STATE__'] = "NO_UB_PASS";
//				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00116"]; // 비회원글에 비밀번호가 없습니다. 관리자에게 문의하세요.
//				break;	
//			endif;
//
//			## 암호화 만들기
//			$strTemp = "{$strBCode}_{$intUbNo}_{$strUB_PASS}";
//			$strTemp = crypt($strTemp, $strCommunityPasswordCode);
//			if($strCommunityPasswordCode != $strTemp):
//				$result['__STATE__'] = "DIFF_USER";
//				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00111"]; // 게시판을 삭제하실 권한이 없습니다.\\n본인글만 삭제할 수 있습니다.
//				break;	
//			endif;
//		endif;
//
//		## 내용 삭제 표시
//		$param = "";
//		$param['B_CODE'] = $strBCode;
//		$param['UB_NO'] = $intUbNo;
//		$param['UB_DEL'] = "Y";
//		$param['UB_MOD_DT'] = "NOW()";
//		$param['UB_MOD_NO'] = $intMemberNo;
//		$re = $objBoardDataModule->getBoardDataDelUpdateEx($param);
//
//		## 체크
//		if(!$re || $re < 0):
//			$result['__STATE__'] = "NO_DELETE_DATA";
//			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00113"]; // 내용을 삭제할 수 없습니다. 관리자에게 문의하세요.
//			break;
//		endif;
//
//		## 마무리
//		$result['__STATE__'] = "SUCCESS";
//
//	break;
	
	case "dataAnswer":
		// 답변쓰기

		## 모듈설정
		$objBoardDataModule = new BoardDataModule($db);
		$objBoardAddFieldModule = new BoardAddFieldModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];
		$intUbNo = $_POST['ub_no'];
		$strUbLng = $_POST['ub_lng'];
//		$intUbBcNo = $_POST['ub_bc_no'];
		$strUbName = $_POST['ub_name'];		
		$strUbTitle = $_POST['ub_title'];	// 필수
		$strUbPCode = $_POST['ub_p_code'];
		$intUbPGrade = $_POST['ub_p_grade'];
		$strUbMail = $_POST['ub_mail'];
		$strUbText = $_POST['ub_text'];		// 필수
		$strUbPass = $_POST['ub_pass'];		// 비회원인경우 필수
		$strUbFuncText = $_POST['ub_func_text']; // text
		$intMemberNo = $g_member_no;
		$strMemberID = $g_member_id;
		$strMemberGroup = $g_member_group;
//		$strMemberName = $g_member_name; // 영문 - 이름, 한글 - 기록 안됨
//		$strMemberLastName = $g_member_last_name; // 영문 - 성, 한글 - 성 + 이름
		$strClientIP = ClientInfo::getClientIP();
		$strLang = $strUbLng;
		$strLangS = $S_ST_LNG;
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 

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
		$strBI_DATAANSWER_USE = $aryBoardInfo['BI_DATAANSWER_USE']; // 답변권환(모든회원/비회원-A, 회원전용-M)
		$aryBI_DATAANSWER_MEMBER_AUTH = $aryBoardInfo['BI_DATAANSWER_MEMBER_AUTH'];

		## 답변사용 권한 설정
		if(!in_array($strBI_DATAANSWER_USE, array("A","M"))): // 사용유무 체크
			$result['__STATE__'] = "NO_ANSWER_FUNC";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00125"]; // 답변 작성 기능을 사용하지 않습니다.
			break;		
		endif;
		if($strBI_DATAANSWER_USE == "M"): // 회원 전용, 사용 권한 체크
			if(!$intMemberNo):
				$result['__STATE__'] = "NO_MEMBER";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
				break;	
			endif;
			if(!in_array($strMemberGroup, $aryBI_DATAANSWER_MEMBER_AUTH)):
				$result['__STATE__'] = "NO_AUTH";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00102"]; // 게시판을 사용하실 권한이 없습니다.\\n고객센터로 문의하시기 바랍니다.
				break;	
			endif;
		endif;

		## 공백제거
		$strUbTitle =trim($strUbTitle);

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
		if(!$intMemberNo && !$strUbPass): // 비회원은 비밀번호가 반드시 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00002"])); // 비밀번호이(가) 없습니다.
			break;
		endif;
		if($intMemberNo && !$strMemberID): // 회원은 반드시 회원ID가 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00001"])); // 아이디이(가) 없습니다.
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
		$strUbFuncNotice = $strUB_FUNC[0]; // 공지글
		$strUbFuncLock = $strUB_FUNC[1]; // 비밀글
//		$strUbFuncText = $strUB_FUNC[2]; // text
//		$aryFunc[] = $strUB_FUNC[3]; // 대기
//		$aryFunc[] = $strUB_FUNC[4]; // 대기
//		$aryFunc[] = $strUB_FUNC[5]; // 대기
//		$aryFunc[] = $strUB_FUNC[6]; // 대기
//		$aryFunc[] = $strUB_FUNC[7]; // 대기
//		$aryFunc[] = $strUB_FUNC[8]; // 대기
//		$aryFunc[] = $strUB_FUNC[9]; // 대기

		## 질문글이 공지글이면 답변을 달 수 없습니다.
		if($strUbFuncNotice == "Y"):
			$result['__STATE__'] = "CAN_NOT_ANSWER";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00151"]; // 공지글은 답변을 달 수 없습니다.
			break;
		endif;
		
		## UB_FUNC 설정
		$aryFunc = "";
		$aryFunc[] = $strUbFuncNotice; // 공지글
		$aryFunc[] = $strUbFuncLock; // 비밀글
		$aryFunc[] = $strUbFuncText; // text
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
		$param['UB_FUNC']			= $strFunc;  // 0=공지글,1=비밀글,2=html
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

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "dataModify":
		// 글수정

		## 모듈설정
		$objBoardDataModule = new BoardDataModule($db);
		$objBoardAddFieldModule = new BoardAddFieldModule($db);
		$objBoardFileModule = new BoardFileModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];
		$intUbNo = $_POST['ub_no'];
		$strUbLng = $_POST['ub_lng'];
		$intUbBcNo = $_POST['ub_bc_no'];
//		$strUbName = $_POST['ub_name'];		
		$strUbTitle = $_POST['ub_title'];	// 필수
		$strUbPCode = $_POST['ub_p_code'];
		$intUbPGrade = $_POST['ub_p_grade'];
		$strUbMail = $_POST['ub_mail'];
		$strUbText = $_POST['ub_text'];		// 필수
		$strUbPass = $_POST['ub_pass'];		// 비회원인경우 필수
		$strUbFuncNotice = $_POST['ub_func_notice']; // 공지글
		$strUbFuncLock = $_POST['ub_func_lock']; // 비밀글
		$strUbFuncText = $_POST['ub_func_text']; // text
		$strFileDel = $_POST['file_del'];	// 삭제 리스트
		$intMemberNo = $g_member_no;
		$strMemberID = $g_member_id;
		$strMemberGroup = $g_member_group;
//		$strMemberName = $g_member_name; // 영문 - 이름, 한글 - 기록 안됨
//		$strMemberLastName = $g_member_last_name; // 영문 - 성, 한글 - 성 + 이름
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
		$intBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 파일 사용시 사용 개수

		## 공백제거
		$strUbTitle =trim($strUbTitle);

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
//		if(!$strUbName):
//			$result['__STATE__'] = "NO_UB_NAME";
//			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00004"])); // 이름이(가) 없습니다.
//			break;
//		endif;
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
		if(!$intMemberNo && !$strUbPass): // 비회원은 비밀번호가 반드시 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00002"])); // 비밀번호이(가) 없습니다.
			break;
		endif;
		if($intMemberNo && !$strMemberID): // 회원은 반드시 회원ID가 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00001"])); // 아이디이(가) 없습니다.
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

		## 관리자 그룹만 공지글을 작성할수 있습니다.
		if(!in_array($strMemberGroup, array("001")) && $strUbFuncNotice == "Y"):
			$result['__STATE__'] = "NO_AUTH_NOTICE";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00150"]; // 공지글은 관리자만 작성할 수 있습니다.
			break;
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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



		## 답변이 있는경우 공지글을 작성할수 없습니다.
		if($strUbFuncNotice == "Y"):

			## 답변 개수 불러오기
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['UB_ANS_NO'] = $intUbNo;
			$intAnsCnt = $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);

			## 체크
			if($intAnsCnt > 1):
				$result['__STATE__'] = "CAN_NOT_ANSWER";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00152"]; // 답변이 있는경우 공지글을 작성할수 없습니다.
				break;	
			endif;
		endif;

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
		$strUB_LNG = $aryBoardDataRow['UB_LNG'];
		$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];
		$strUB_ANS_STEP = $aryBoardDataRow['UB_ANS_STEP'];
		$intUB_ANS_M_NO = $aryBoardDataRow['UB_ANS_M_NO'];
		$strUB_P_CODE = $aryBoardDataRow['UB_P_CODE'];

		## 작성자 권한 체크
		if($intUB_M_NO): 
			##회원글
			if(!$intMemberNo):
				$result['__STATE__'] = "NEED_LOGIN";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
				break;	
			endif;
			if($intMemberNo != $intUB_M_NO):
				$result['__STATE__'] = "DIFF_USER";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00111"]; // 게시판을 수정하실 권한이 없습니다.\\n본인글만 수정할 수 있습니다.
				break;	
			endif;
		else: 
			##비회원글

			if(!$strUB_PASS):
				$result['__STATE__'] = "NO_UB_PASS";
				$result['__MSG__'] = $LNG_TRANS_CHAR["MS00116"]; // 비회원글에 비밀번호가 없습니다. 관리자에게 문의하세요.
				break;	
			endif;

			if($strUbPass != $strUB_PASS):
				$result['__STATE__'] = "DIFF_USER";
				$result['__MSG__'] = $LNG_TRANS_CHAR["PS00019"]; // 비밀번호가 틀렸습니다.
				break;				
			endif;

		endif;

		## 비밀글 설정
		if($strUbFuncNotice != "Y") { $strUbFuncNotice = "N"; }
		if($strUbFuncLock != "Y") { $strUbFuncLock = "N"; }
		if($strUbFuncText != "Y") { $strUbFuncText = "N"; }

		## UB_FUNC 설정
		$aryFunc = "";
		$aryFunc[] = $strUbFuncNotice; // 공지글
		$aryFunc[] = $strUbFuncLock; // 비밀글
		$aryFunc[] = $strUbFuncText; // text
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$aryFunc[] = "N"; // 대기
		$strFunc = implode($aryFunc);

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
		$param['UB_LNG']			= $strUB_LNG;
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
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00113"]; // 내용을 수정할 수 없습니다. 관리자에게 문의하세요.
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
		// 글쓰기

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
		$strUbFuncText = $_POST['ub_func_text']; // text
		$strUbFuncText = $_POST['ub_func_text']; // text
		$intUbShopNo = $_POST['ub_shop_no']; // 입점사 번호
		$intMemberNo = $g_member_no;
		$strMemberID = $g_member_id;
		$strMemberName = $g_member_name; // 영문 - 이름, 한글 - 기록 안됨
		$strMemberGroup = $g_member_group;
		$strMemberLastName = $g_member_last_name; // 영문 - 성, 한글 - 성 + 이름
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

		## 공백제거
		$strUbName = trim($strUbName);
		$strUbTitle =trim($strUbTitle);

		## 회원인경우 추가 설정.
		if($intMemberNo):

			## 이름 설정. 세션정보에서 다시 가져옵니다.
			$strUbName = "";
			if($strMemberName && $strMemberLastName) { $strUbName = "{$strMemberName} {$strMemberLastName}"; }
			else if($strMemberLastName) { $strUbName = $strMemberLastName; }
			else if($strMemberName) { $strUbName = $strMemberName; }

			## 아이디 설정, 이메일 로그인방식(2) 인경우, 이메일의 @ 앞부분을 ID로 사용합니다.(심성일 이사님 요청사항)
			## 그러므로, ID값이 중복될수 있습니다.
			## 추후, 이메일 방식일때, ID자동 생성으로 변경이 되면, 그때 아이디 입력으로 변경 예정.
			if($S_MEM_CERITY == 2) { list($strMemberID) = explode("@", $strMemberID, -1); }
		endif;

		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_B_CODE";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00104"])); // 커뮤니티 코드이(가) 없습니다.
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
		if(!$intMemberNo && !$strUbPass): // 비회원은 비밀번호가 반드시 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00002"])); // 비밀번호이(가) 없습니다.
			break;
		endif;
		if($intMemberNo && !$strMemberID): // 회원은 반드시 회원ID가 있어야 합니다.
			$result['__STATE__'] = "NO_UB_PASS";
			$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($LNG_TRANS_CHAR["MW00001"])); // 아이디이(가) 없습니다.
			break;
		endif;

		## 관리자 그룹만 공지글을 작성할수 있습니다.
		if(!in_array($strMemberGroup, array("001")) && $strUbFuncNotice == "Y"):
			$result['__STATE__'] = "NO_AUTH_NOTICE";
			$result['__MSG__'] = $LNG_TRANS_CHAR["MS00150"]; // 공지글은 관리자만 작성할 수 있습니다.
			break;
		endif;

		## 그룹 폴더 만들기
		if($intBI_ATTACHEDFILE_USE && !FileDevice::makeFolder($strCommunityDataDefaultDir)):
			$result['__STATE__'] = "NO_DIR";
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
						$result['__MSG__'] = callLangTrans($LNG_TRANS_CHAR["MS00105"], array($strNAME)); // 임시필드 이(가) 없습니다.
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
		if($strUbFuncText != "Y") { $strUbFuncText = "N"; }

		## UB_FUNC 설정
		$aryFunc = "";
		$aryFunc[] = $strUbFuncNotice; // 공지글
		$aryFunc[] = $strUbFuncLock; // 비밀글
		$aryFunc[] = $strUbFuncText; // text
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
		$param['UB_FUNC']			= $strFunc; // 0=공지글,1=비밀글
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

		if($intUbShopNo){
		$param['UB_SHOP_NO']			= $intUbShopNo;
		}

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

	endswitch;


