<?php

	switch($strAct):

	case "boardStop":
		// 커뮤니티 운영정지

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);

		## 기본설정
		$strBCode = $_POST['b_code'];

		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_B_CODE";
			$result['__MSG__'] = "운영정지할 커뮤니티 코드가 없습니다.";
			break;	
		endif;

		## 데이터 불러오기
		$param = "";
		$param['B_CODE'] = $strBCode;
		$aryBoardRow = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_SELECT", $param);

		if(!$aryBoardRow):
			$result['__STATE__'] = "NO_DATA";
			$result['__MSG__'] = "등록된 커뮤니티가 없습니다.";
			break;	
		endif;

		## 데이터 업데이트
		$param					= "";
		$param['B_CODE']		= $strBCode;
		$param['B_USE']			= "N";
		$param['B_MOD_DT']		= "NOW()";
		$param['B_MOD_NO']		= "NOW()";
		$objBoardMgrNewModule->getBoardMgrNewUseUpdateEx($param);

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "boardFileMake":
		// 커뮤니티 리스트 파일 생성

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);

		## 기본설정
		$strUseLang = $S_USE_LNG;
		$aryUseLang = explode("/", $strUseLang);

		## 데이터 불러오기
		$param = "";
//		$param['B_USE'] = "Y";
		$aryBoardList = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_ARYTOTAL", $param);

		## 체크
		if(!$aryBoardList):
			$result['__STATE__'] = "NO_DATA";
			$result['__MSG__'] = "등록된 커뮤니티 정보가 없습니다.";
			break;	
		endif;

		## 기준데이터 만들기
		$aryBoardListDefault = "";
		foreach($aryBoardList as $key => $row):

			## 기본설정
			$strB_CODE = $row['B_CODE'];
			$strB_NAME = $row['B_NAME'];
			$intB_BG_NO = $row['B_BG_NO'];
			$strB_USE = $row['B_USE'];

			## 배열 만들기
			$aryBoardListDefault[$strB_CODE]['b_name'] = $strB_NAME;
			$aryBoardListDefault[$strB_CODE]['b_bg_no'] = $intB_BG_NO;
			$aryBoardListDefault[$strB_CODE]['b_use'] = $strB_USE;

		endforeach;


		## 언어별로 설정
		foreach($aryUseLang as $lang):
		
			## 기본설정
			$langLower = strtolower($lang);
			$aryBoardListData = $aryBoardListDefault;

			## 언어별로 데이터 가져요기
			$param = "";
			$param['BA_KEY'] = "B_NAME";
			$param['BA_LNG'] = $lang;
			$aryBoardInfoNameList = $objBoardInfoMgrModule->getBoardInfoMgrSelectEx("OP_ARYTOTAL", $param);
			
			## 언어별 이름 정의
			if($aryBoardInfoNameList):
				foreach($aryBoardInfoNameList as $key => $row):

					## 기본 설정
					$strBA_B_CODE = $row['BA_B_CODE'];
					$strBA_VAL = $row['BA_VAL'];

					## 데이터 만들기
					$aryBoardListData[$strBA_B_CODE]['b_name'] = $strBA_VAL; 

				endforeach;
			endif;

			## 데이터 만들기
			$strConfText = "";
			foreach($aryBoardListData as $key => $data):
				
				## 기본 설정
				$strB_NAME = $data['b_name'];
				$strB_BG_NAME = $data['b_bg_no'];
				$strB_USE = $data['b_use'];
				$strTemp = "";

				## 체크
				if($strB_USE != "Y") { continue; }

				## 설정파일
				$strTemp .= "\$BOARD_LIST['{$key}']['b_name'] = \"{$strB_NAME}\";\n";
				$strTemp .= "\$BOARD_LIST['{$key}']['b_bg_no'] = \"{$strB_BG_NAME}\";\n";

				## 설정파일 리스트
				if($strConfText ) { $strConfText .= "\n"; }
				$strConfText .= $strTemp;

			endforeach;

			## 파일 만들기
			$strConfTextFile = MALL_SHOP . "/conf/community/{$langLower}/boardList.info.php";
			FileDevice::getMadeInfo($strConfTextFile, $strConfText, "## BOARD");

		endforeach;

		## 메뉴권한 파일 만들기
		include MALL_SHOP . '/www/web/shopAdmin/basic/communityMakeFile.php';

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "boardModifyScript":
		// 커뮤니티 스크립트 수정

		## 모듈설정
		$objAdvertiseMgrModule = new AdvertiseMgrModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$strBiDataScriptData = $_POST['bi_datascript_data'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strScriptDir = MALL_SHOP . "/layout/html/community/{$strLangLower}";
		$strScriptFile = "board.{$strBCode}.script.php";
		$strScriptTagFile = "board.{$strBCode}.script.tag.php";


		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_BG_NO";
			$result['__MSG__'] = "번호가 없습니다.";
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__'] = "NO_MEMBER_NO";
			$result['__MSG__'] = "수정할 권한이 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;

		## 예약어 설정
		$aryTag['{{__커뮤니티본문__}}'] = "<?php include \$includeFile;?>";
		$aryTag['{{__서브폼문시작__}}'] = "<?php include MALL_HOME . \"/web/{\$strMenuType}/{\$strMenuType}_form_start.inc.php\";?>";
		$aryTag['{{__서브폼문끝__}}'] = "<?php include MALL_HOME . \"/web/{\$strMenuType}/{\$strMenuType}_form_end.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_1__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity1.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_2__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity2.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_3__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity3.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_4__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity4.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_5__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity5.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_6__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity6.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_7__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity7.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_8__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity8.inc.php\";?>";
		$aryTag['{{__사용자_커뮤니티_9__}}'] = "<?php include MALL_SHOP . \"/html/userCommunity9.inc.php\";?>";


		## 예약어 설정(배너)
		$param = "";
		$aryBannerGroupList = $objAdvertiseMgrModule->getAdvertiseMgrSelectEx("OP_ARYTOTAL", $param);
		if($aryBannerGroupList):
			foreach($aryBannerGroupList as $key => $row):

				## 기본설정
				$intA_NO = $row['A_NO'];
				
				## 예약어 설정
				$aryTag["{{__banner_{$intA_NO}__}}"] = "<?php include MALL_SHOP . \"/layout/banner/{\$S_SITE_LNG_PATH}/banner_{$intA_NO}.html.php\";?>";
				
			endforeach;
		endif;

		## 폴더 생성			
		if(!FileDevice::makeFolder($strScriptDir)):
			$result['__STATE__'] = "CAN_NOT_MAKE_SCRIPT_DIR";
			$result['__MSG__'] = "스크립트 폴더를 생성할수 없습니다. 관리자에게 문의하세요.";
			break;
		endif;
		
		## 태그 쓰기
		$strTagData = $strBiDataScriptData;
		FileDevice::fileWrite("{$strScriptDir}/{$strScriptTagFile}", $strTagData);

		## APP태그 변환
		## include 사용 형태 <!--?ID=12345678901234567890&WIDTH=100&HEIGHT=200-->
		$strTagData = str_replace("&lt;", "<", $strTagData);
		$strTagData = str_replace("&gt;", ">", $strTagData);
		preg_match_all("/<!--\?.*-->/iU", $strTagData, $preg_data);
		foreach($preg_data[0] as $data):
			## 필요 없는 내용 삭제
			$dataTemp	= $data;
			$dataTemp	= str_replace("<!--?", "", $dataTemp);
			$dataTemp	= str_replace("-->", "", $dataTemp);

			## 구분
			$dataTemp1	= "  \$EUMSHOP_APP_INFO = \"\";";
			$dataTemp2	= explode("&", $dataTemp); 
			foreach($dataTemp2 as $temp):
				list($key, $value) = explode("=", $temp);
				if($dataTemp1) { $dataTemp1 .= "\r\n"; }
				$dataTemp1 .= "  \$EUMSHOP_APP_INFO['{$key}'] = \"{$value}\";";
			endforeach;

			if($dataTemp1) { $dataTemp1 .= "\r\n  include \"{\$S_DOCUMENT_ROOT}www/web/app/index.php\";"; }
			$dataTemp1				= "<?\r\n{$dataTemp1}\r\n?>";
			$strTagData				= str_replace($data, $dataTemp1, $strTagData);
		endforeach;

		## 내용 쓰기
		foreach($aryTag as $key => $data):
			$strTagData = str_replace($key, $data, $strTagData);
		endforeach;
		FileDevice::fileWrite("{$strScriptDir}/{$strScriptFile}", $strTagData);

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "boardModifyCategory":
		// 커뮤니티 카테고리 옵션 수정

		## 커뮤니티 기본정보 컬럼 설명 리스트
		include_once MALL_HOME . "/config/community.conf.php";

		## 모듈 설정
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$intMemberNo = $_SESSION['ADMIN_NO'];

		## 체크
		if(!$intMemberNo):
			$result['__STATE__'] = "NO_MEMBER_NO";
			$result['__MSG__'] = "수정할 권한이 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;

		## 기존에 등록된 BOARD_INFO_MGR 테이블 정보 삭제
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strAct;
		$param['BA_LNG'] = $strLangS;
		$objBoardInfoMgrModule->getBoardInfoMgrDeleteEx($param);

		## BOARD_INFO_MGR 테이블 정보 등록
		foreach($_POST as $key => $data):
			
			## 제외 항목 설정
			if(in_array($key, array("menuType","mode","act","b_code","lang"))) { continue; }

			## 기본설정
			$aryData = $data;
			$keyUpper = strtoupper($key);
			$intArraySize = sizeof($data);

			## 배열이 아닌 경우 배열로 만들기
			if(is_string($data)) { $aryData = ""; $aryData[] = $data; }

			## 데이터 등록
			foreach($aryData as $key2 => $data2):

				## infoKey 설정
				$strInfoKey = $keyUpper;
				if($intArraySize > 1) { $strInfoKey = "{$strInfoKey}_{$key2}"; }

				## 설명글 설정
				$strComment = $G_BOARD_INFO_NAME[$strInfoKey];
				if(!$strComment) { $strComment = $G_BOARD_INFO_NAME[$keyUpper]; }

				## 데이터 등록
				$param = "";
				$param['BA_B_CODE'] = $strBCode;
				$param['BA_MODE'] = $strAct;
				$param['BA_LNG'] = $strLangS;
				$param['BA_KEY'] = $strInfoKey;
				$param['BA_VAL'] = $data2;
				$param['BA_COMMENT'] = $strComment;
				$objBoardInfoMgrModule->getBoardInfoMgrInsertEx($param);

			endforeach;

		endforeach;

		####
		## 파일 만들기
		#### 

		## 기본설정
		$aryData = "";
		$strConfDir = MALL_SHOP . "/conf/community/{$strLangSLower}";
		$strConfFile = "board.{$strBCode}.info.php";

		## 커뮤니티 추가 정보 불러오기
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strAct;
		$param['BA_LNG'] = $strLang;
		$aryBoardInfoList = $objBoardInfoMgrModule->getBoardInfoMgrSelectEx("OP_ARYTOTAL", $param);

		## 추가정보 데이터 만들기
		if($aryBoardInfoList):
			foreach($aryBoardInfoList as $key => $row):
				
				## 기본정보
				$strBA_KEY = $row['BA_KEY'];
				$strBA_VAL = $row['BA_VAL'];

				## 데이터 설정
				$aryData[$strBA_KEY] = $strBA_VAL;
			endforeach;
		endif;

		## 파일 데이터 만들기
		$strConfData = "";
		foreach($aryData as $key => $val):

			## 기본설정
			$strInfoKey = "['{$key}']";
			$aryInfoKey = explode('_', $key);
			$strLastText = array_pop($aryInfoKey);
			$strComment = $G_BOARD_INFO_NAME[$key]; // 설명

			## 내용 추가시 2칸 뛰움
			if($strConfData) { $strConfData .= "\n\n"; }

			## 마지막 정보가 숫자이면, 변수명을 배열로 변경합니다.
			if(is_numeric($strLastText)):
				$strTemp = implode("_", explode('_', $key, -1));
				$strInfoKey = "['{$strTemp}'][{$strLastText}]";
				if(!$strComment) { $strComment = $G_BOARD_INFO_NAME[$strTemp]; } // 설명
			endif;

			## 변수명을 소문자로 변경
//			$strInfoKeyLower = strtolower($strInfoKey);

			## 파일 데이터 문장 만들기
			$strConfData .= "## {$strComment}\n";
			$strConfData .= "\$BOARD_INFO['{$strBCode}']{$strInfoKey} = '{$val}';";

		endforeach;

		## 폴더 체크
		if(!FileDevice::makeFolder($strConfDir)):
			$result['__STATE__'] = "NO_MAKE_DIR";
			$result['__MSG__'] = "폴더를 생성할수 없습니다. 관리자에게 문의하세요.";
			break;			
		endif;

		## 파일 만들기
		FileDevice::getMadeInfo("{$strConfDir}/{$strConfFile}", $strConfData, "/*@ {$strAct} @*/");

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "boardModifyUserfield":
		// 커뮤니티 추가필드 수정

		## 커뮤니티 기본정보 컬럼 설명 리스트
		include_once MALL_HOME . "/config/community.conf.php";

		## 모듈 설정
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strStLng);
		$intMemberNo = $_SESSION['ADMIN_NO'];

		## 체크
		if(!$intMemberNo):
			$result['__STATE__'] = "NO_MEMBER_NO";
			$result['__MSG__'] = "수정할 권한이 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;

		## 기존에 등록된 BOARD_INFO_MGR 테이블 정보 삭제
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strAct;
		$param['BA_LNG'] = $strLang;
		$objBoardInfoMgrModule->getBoardInfoMgrDeleteEx($param);

		## BOARD_INFO_MGR 테이블 정보 등록
		foreach($_POST as $key => $data):
			
			## 제외 항목 설정
			if(in_array($key, array("menuType","mode","act","b_code","lang"))) { continue; }

			## 기본설정
			$aryData = $data;
			$keyUpper = strtoupper($key);
			$intArraySize = sizeof($data);

			## 배열이 아닌 경우 배열로 만들기
			if(is_string($data)) { $aryData = ""; $aryData[] = $data; }

			## 데이터 등록
			foreach($aryData as $key2 => $data2):

				## infoKey 설정
				$strInfoKey = $keyUpper;
				if($intArraySize > 1) { $strInfoKey = "{$strInfoKey}_{$key2}"; }

				## 설명글 설정
				$strComment = $G_BOARD_INFO_NAME[$strInfoKey];
				if(!$strComment) { $strComment = $G_BOARD_INFO_NAME[$keyUpper]; }

				## 데이터 등록
				$param = "";
				$param['BA_B_CODE'] = $strBCode;
				$param['BA_MODE'] = $strAct;
				$param['BA_LNG'] = $strLang;
				$param['BA_KEY'] = $strInfoKey;
				$param['BA_VAL'] = $data2;
				$param['BA_COMMENT'] = $strComment;
				$objBoardInfoMgrModule->getBoardInfoMgrInsertEx($param);

			endforeach;

		endforeach;

		####
		## 파일 만들기
		#### 

		## 기본설정
		$aryData = "";
		$strConfDir = MALL_SHOP . "/conf/community/{$strLangLower}";
		$strConfFile = "board.{$strBCode}.info.php";

		## 커뮤니티 추가 정보 불러오기
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strAct;
		$param['BA_LNG'] = $strLang;
		$aryBoardInfoList = $objBoardInfoMgrModule->getBoardInfoMgrSelectEx("OP_ARYTOTAL", $param);

		## 추가정보 데이터 만들기
		if($aryBoardInfoList):
			foreach($aryBoardInfoList as $key => $row):
				
				## 기본정보
				$strBA_KEY = $row['BA_KEY'];
				$strBA_VAL = $row['BA_VAL'];

				## 데이터 설정
				$aryData[$strBA_KEY] = $strBA_VAL;
			endforeach;
		endif;

		## 파일 데이터 만들기
		$strConfData = "";
		foreach($aryData as $key => $val):

			## 기본설정
			$strInfoKey = "['{$key}']";
			$aryInfoKey = explode('_', $key);
			$strLastText = array_pop($aryInfoKey);
			$strComment = $G_BOARD_INFO_NAME[$key]; // 설명

			## 내용 추가시 2칸 뛰움
			if($strConfData) { $strConfData .= "\n\n"; }

			## 마지막 정보가 숫자이면, 변수명을 배열로 변경합니다.
			if(is_numeric($strLastText)):
				$strTemp = implode("_", explode('_', $key, -1));
				$strInfoKey = "['{$strTemp}'][{$strLastText}]";
				if(!$strComment) { $strComment = $G_BOARD_INFO_NAME[$strTemp]; } // 설명
			endif;

			## 변수명을 소문자로 변경
//			$strInfoKeyLower = strtolower($strInfoKey);

			## 파일 데이터 문장 만들기
			$strConfData .= "## {$strComment}\n";
			$strConfData .= "\$BOARD_INFO['{$strBCode}']{$strInfoKey} = '{$val}';";

		endforeach;

		## 폴더 체크
		if(!FileDevice::makeFolder($strConfDir)):
			$result['__STATE__'] = "NO_MAKE_DIR";
			$result['__MSG__'] = "폴더를 생성할수 없습니다. 관리자에게 문의하세요.";
			break;			
		endif;

		## 파일 만들기
		FileDevice::getMadeInfo("{$strConfDir}/{$strConfFile}", $strConfData, "/*@ {$strAct} @*/");

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "boardWrite":
		// 커뮤니티 생성

		## 커뮤니티 기본정보 컬럼 설명 리스트
		include_once MALL_HOME . "/config/community.conf.php";
			
		## 그룹 리스트
		include_once  MALL_SHOP . "/conf/community/groupList.info.php";

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$strBName = $_POST['b_name'];
		$strBKindSkin = $_POST['b_kind_skin'];
		$strBCss = $_POST['b_css'];
		$strBBgNo = $_POST['b_bg_no'];
		$strLang = $S_ST_LNG;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strStLng);
		$intMemberNo = $_SESSION['ADMIN_NO'];
//		$strScriptDir = MALL_SHOP . "/layout/html/community/{$strLangLower}";
		$strScriptDirFmt = MALL_SHOP . "/layout/html/community/{lang}";
		$strScriptFile = "board.{$strBCode}.script.php";
		$strScriptTagFile = "board.{$strBCode}.script.tag.php";
		$aryUseLang = explode("/", $S_USE_LNG);
		$aryUseLang = array_filter($aryUseLang);

		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_BG_NO";
			$result['__MSG__'] = "번호가 없습니다.";
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__'] = "NO_MEMBER_NO";
			$result['__MSG__'] = "수정할 권한이 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;

		## 게시판 코드는 대문자로 무조건 설정
		$strBCode = strtoupper($strBCode);

		## 게시판 코드 중복 체크
		$param = "";
		$param['B_CODE'] = $strBCode;
		$intBoardCnt = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_COUNT", $param);
		if($intBoardCnt):
			$result['__STATE__'] = "HAVE_B_CODE";
			$result['__MSG__'] = "게시판 코드가 이미 사용중입니다.";
			break;
		endif;

		## 게시판종류, 게시판스킨 값 분리
		if($strBKindSkin) { list($strBKind, $strBSkin) = explode("_", $strBKindSkin); }

		## 게시판 번호 생성 
		## 2013.11.28 kim hee sung 게시판 번호 추가
		$intMaxBoardNo		= $objBoardMgrNewModule->getBoardMgrNewMAX_B_NO();
		$intMaxBoardNo++;


		## BOARD_MGR_NEW 테이블 정보 생성
		$param					= "";
		$param['B_CODE']		= $strBCode;
		$param['B_NO']			= $intMaxBoardNo;
		$param['B_NAME']		= $strBName;
		$param['B_KIND']		= $strBKind;
		$param['B_SKIN']		= $strBSkin;
		$param['B_CSS']			= $strBCss;
		$param['B_BG_NO']		= $strBBgNo;
		$param['B_USE']			= "Y";
		$param['B_REG_DT']		= "NOW()";
		$param['B_REG_NO']		= $intMemberNo;
		$param['B_MOD_DT']		= "NOW()";
		$param['B_MOD_NO']		= $intMemberNo;
		$re						= $objBoardMgrNewModule->getBoardMgrNewInsertEx($param);

		## APP PUSH
		if($strBCode == 'NOTICE')
		{
			include MALL_CONF_LIB."MobileMgr.php";
			include MALL_CONF_LIB."AndroidApiMgr.php";

			$MobileMgr = new MobileMgr();
			
			//$MobileMgr->setM_NO(1);
			$apiKey= $MobileMgr->getMobileKeyList($db);
			
			$message = '공지사항';

			if(is_array($apiKey)){
				for($i=0; $i < sizeof($apiKey); $i++)
				{
					$AndPush = new GCMPushMessage($apiKey[$i][MOBILE_KEY]);
					$AndPush->setDevices($apiKey[$i][MOBILE_DEVICES]);
					$response = $AndPush->send($message);
				}
			}
		}

		## 테이블 생성(커뮤니티)
		$param ="";
		$param['b_code'] = $strBCode;
		$param['b_name'] = $strBName;
		$objBoardMgrNewModule->getBoardMgrNewBoardUbTableCreate($param); // 커뮤니티 테이블
		$objBoardMgrNewModule->getBoardMgrNewBoardFLTableCreate($param); // 첨부파일 테이블
		$objBoardMgrNewModule->getBoardMgrNewBoardCMTableCreate($param); // 코멘트 테이블
		$objBoardMgrNewModule->getBoardMgrNewBoardADTableCreate($param); // 추가필드 테이블

		## 스크립트 데이터 만들기
		## 2014.09.02 kim hee sung 사용중인 모든 언어에 script 만들기
		foreach($aryUseLang as $key => $lang):
			
			$strScriptDir = str_replace("{lang}", strtolower($lang), $strScriptDirFmt);

			if(!is_file("{$strScriptDir}/{$strScriptFile}")):

				## 예약어 설정
				$aryTag['{{__커뮤니티본문__}}'] = "<?php include \$includeFile;?>";

				## 폴더 생성			
				if(!FileDevice::makeFolder($strScriptDir)):
					$result['__STATE__'] = "CAN_NOT_MAKE_SCRIPT_DIR";
					$result['__MSG__'] = "스크립트 폴더를 생성할수 없습니다. 관리자에게 문의하세요.";
					break;
				endif;
				
				## 태그 쓰기
				$strTagData = "{{__커뮤니티본문__}}";
				FileDevice::fileWrite("{$strScriptDir}/{$strScriptTagFile}", $strTagData);

				## 내용 쓰기
				foreach($aryTag as $key => $data):
					$strTagData = str_replace($key, $data, $strTagData);
				endforeach;
				FileDevice::fileWrite("{$strScriptDir}/{$strScriptFile}", $strTagData);

			endif;

		endforeach;



		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "boardModifyBasic":
		// 커뮤니티 기본 정보 업데이트

		## 그룹 리스트
		include_once  MALL_SHOP . "/conf/community/groupList.info.php";

		## 커뮤니티 기본정보 컬럼 설명 리스트
		include_once MALL_HOME . "/config/community.conf.php";

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$strBName = $_POST['b_name'];
		$strBKindSkin = $_POST['b_kind_skin'];
		$strBCss = $_POST['b_css'];
		$strBBgNo = $_POST['b_bg_no'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strStLng);
		$intMemberNo = $_SESSION['ADMIN_NO'];

		## 체크
		if(!$strBCode):
			$result['__STATE__'] = "NO_BG_NO";
			$result['__MSG__'] = "번호가 없습니다.";
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__'] = "NO_MEMBER_NO";
			$result['__MSG__'] = "수정할 권한이 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;

		## 게시판종류, 게시판스킨 값 분리
		if($strBKindSkin) { list($strBKind, $strBSkin) = explode("_", $strBKindSkin); }

		## 다른 언어 체크
		## 기준언어는 모든 옵션을 저장할수 있다.
		## 기준언어와 다른경우, 게시판 제목, 첨부파일명만 설정 할 수 있다.
		if($strLang != $strLangS):

			## 기존에 등록된 정보 불러오기
			$param = "";
			$param['B_CODE'] = $strBCode;
			$aryBoardDataRow = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_SELECT", $param);

			## BOARD_MGR_NEW 테이블 값 설정
			$strBKind = $aryBoardDataRow['B_KIND'];
			$strBSkin = $aryBoardDataRow['B_SKIN'];
			$strBCss = $aryBoardDataRow['B_CSS'];
			$strBBgNo = $aryBoardDataRow['B_BG_NO'];

			## 저장 가능한 리스트 설정
			$arySaveList = array("b_name","bi_attachedfile_name"); 
		endif;

		## BOARD_MGR_NEW 테이블 정보 업데이트
		$param					= "";
		$param['B_CODE']		= $strBCode;
		$param['B_NAME']		= $strBName;
		$param['B_KIND']		= $strBKind;
		$param['B_SKIN']		= $strBSkin;
		$param['B_CSS']			= $strBCss;
		$param['B_BG_NO']		= $strBBgNo;
		$param['B_MOD_DT']		= "NOW()";
		$param['B_MOD_NO']		= $intMemberNo;
		$objBoardMgrNewModule->getBoardMgrNewUpdateEx($param);

		## 기존에 등록된 BOARD_INFO_MGR 테이블 정보 삭제
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strAct;
		$param['BA_LNG'] = $strLang;
		$objBoardInfoMgrModule->getBoardInfoMgrDeleteEx($param);

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	endswitch;


	## 커뮤니티 생성, 커뮤니티 수정 공통 작업
	if($result['__STATE__'] == "SUCCESS"):

		if(in_array($strAct, array("boardWrite","boardModifyBasic"))):

			## 커뮤니티 기본정보 컬럼 설명 리스트
			include_once MALL_HOME . "/config/community.conf.php";

			## BA_MODE 설정
			## boardWrite 는 boardModifyBasic 으로 변경합니다.
			$strBaMode = $strAct;
			if($strBaMode == "boardWrite") { $strBaMode = "boardModifyBasic"; }

			## BOARD_INFO_MGR 테이블 정보 등록
			foreach($_POST as $key => $data):
				
				## 제외 항목 설정
				if(in_array($key, array("menuType","mode","act","b_code","lang"))) { continue; }

				## 기본설정
				$aryData = $data;
				$keyUpper = strtoupper($key);
				$intArraySize = sizeof($data);
				$isArray = false;

				## 배열이 아닌 경우 배열로 만들기
				if(is_string($data)) { $aryData = ""; $aryData[] = $data; }
				else { $isArray = true; }

				## 데이터 등록
				foreach($aryData as $key2 => $data2):

					## infoKey 설정
					$strInfoKey = $keyUpper;
					if($isArray) { $strInfoKey = "{$strInfoKey}_{$key2}"; }

					## 설명글 설정
					$strComment = $G_BOARD_INFO_NAME[$strInfoKey];
					if(!$strComment) { $strComment = $G_BOARD_INFO_NAME[$keyUpper]; }

					## 기준언어와 다른경우 특정값만 저장 합니다.
					if($arySaveList):
						if(!in_array($key, $arySaveList)) { continue; }
					endif;

					## 데이터 등록
					$param = "";
					$param['BA_B_CODE'] = $strBCode;
					$param['BA_MODE'] = $strBaMode;
					$param['BA_LNG'] = $strLang;
					$param['BA_KEY'] = $strInfoKey;
					$param['BA_VAL'] = $data2;
					$param['BA_COMMENT'] = $strComment;
					$objBoardInfoMgrModule->getBoardInfoMgrInsertEx($param);

				endforeach;

			endforeach;

			####
			## 파일 만들기
			#### 

			## 기본설정
			$aryData = "";
			$strConfDir = MALL_SHOP . "/conf/community/{$strLangLower}";
			$strConfFile = "board.{$strBCode}.info.php";

			## 커뮤니티 추가 정보 불러오기
			$param = "";
			$param['BA_B_CODE'] = $strBCode;
			$param['BA_MODE'] = $strBaMode;
			$param['BA_LNG'] = $strLang;
			$aryBoardInfoList = $objBoardInfoMgrModule->getBoardInfoMgrSelectEx("OP_ARYTOTAL", $param);

			## 추가정보 데이터 만들기
			if($aryBoardInfoList):
				foreach($aryBoardInfoList as $key => $row):
					
					## 기본정보
					$strBA_KEY = $row['BA_KEY'];
					$strBA_VAL = $row['BA_VAL'];

					## 데이터 설정
					$aryData[$strBA_KEY] = $strBA_VAL;
				endforeach;
			endif;

			## 기준언어와 다른경우 해당 언어 정보 불러오기
			if($strLang != $strLangS):
				$param = "";
				$param['BA_B_CODE'] = $strBCode;
				$param['BA_MODE'] = $strBaMode;
				$param['BA_LNG'] = $strLang;
				$aryBoardInfoListS = $objBoardInfoMgrModule->getBoardInfoMgrSelectEx("OP_ARYTOTAL", $param);

				## 추가정보 데이터 만들기
				if($aryBoardInfoListS):
					foreach($aryBoardInfoListS as $key => $row):
						
						## 기본정보
						$strBA_KEY = $row['BA_KEY'];
						$strBA_VAL = $row['BA_VAL'];

						## 데이터 설정
						$aryData[$strBA_KEY] = $strBA_VAL;
					endforeach;
				endif;
			endif;

			## 파일 데이터 만들기
			$strConfData = "";
			foreach($aryData as $key => $val):

				## 기본설정
				$strInfoKey = "['{$key}']";
				$aryInfoKey = explode('_', $key);
				$strLastText = array_pop($aryInfoKey);
				$strComment = $G_BOARD_INFO_NAME[$key]; // 설명

				## 내용 추가시 2칸 뛰움
				if($strConfData) { $strConfData .= "\n\n"; }

				## 마지막 정보가 숫자이면, 변수명을 배열로 변경합니다.
				if(is_numeric($strLastText)):
					$strTemp = implode("_", explode('_', $key, -1));
					$strInfoKey = "['{$strTemp}'][{$strLastText}]";
					if(!$strComment) { $strComment = $G_BOARD_INFO_NAME[$strTemp]; } // 설명
				endif;

				## 변수명을 소문자로 변경
	//			$strInfoKeyLower = strtolower($strInfoKey);

				## 파일 데이터 문장 만들기
				$strConfData .= "## {$strComment}\n";
				$strConfData .= "\$BOARD_INFO['{$strBCode}']{$strInfoKey} = '{$val}';";

			endforeach;

			## 폴더 체크
			if(!FileDevice::makeFolder($strConfDir)):
				$result['__STATE__'] = "NO_MAKE_DIR";
				$result['__MSG__'] = "폴더를 생성할수 없습니다. 관리자에게 문의하세요.";
				return;		
			endif;

			## 파일 만들기
			FileDevice::getMadeInfo("{$strConfDir}/{$strConfFile}", $strConfData, "/*@ {$strBaMode} @*/");

		endif;

	endif;
