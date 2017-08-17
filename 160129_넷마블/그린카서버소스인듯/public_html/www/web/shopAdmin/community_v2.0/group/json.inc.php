<?php

	switch($strAct):

	case "groupFileMake":
	// 커뮤니티 그룹 파일로 만들기
	// 2014.11.11 사용 안함
	// 그룹파일성성 버튼 없이 무조건 생성 되도록 변경함.

	break;

	case "groupDelete":
		// 커뮤니티 그룹 삭제

		## 모듈 설정
		$objBoardGroupNewModule = new BoardGroupNewModule($db);

 		## 기본 설정
		$intBgNo = $_POST['bg_no'];
		$intLang = $_POST['lang'];
		$strStLang = $S_ST_LNG;
		$strUseLang = $S_USE_LNG;
		$aryUseLang = explode("/", $strUseLang);
		$strWebDir = "/upload/community/group";
		$strDefaultDir = MALL_SHOP . $strWebDir;

		## 체크
		if(!$intBgNo):
			$result['__STATE__'] = "NO_BG_NO";
			$result['__MSG__'] = "번호가 없습니다.";
			break;
		endif;
		if(!$strStLang):
			$result['__STATE__'] = "NO_ST_LANG";
			$result['__MSG__'] = "기준 언어가 없습니다.";
			break;
		endif;
		if(!$intLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;

		## 삭제 언어 설정
		## 삭제 언어과 기준언어가 같은 경우 모든 언어 삭제
		$aryDelList = "";
		$aryDelList[] = $intLang;
		if($intLang == $strStLang) { $aryDelList = $aryUseLang; }

		## 배열에 등록된 언어에 대한 내용 삭제
		foreach($aryDelList as $key => $lang):
		
			## 데이터 불러오기
			$param = "";
			$param['BG_LNG'] = $lang;
			$param['BG_LNG_NO'] = $intBgNo;
			$aryGroupRow = $objBoardGroupNewModule->getBoardGroupNewSelectEx("OP_SELECT", $param);
			$intBG_NO = $aryGroupRow['BG_NO'];
			$strBG_FILE1 = $aryGroupRow['BG_FILE1'];
			$strBG_FILE2 = $aryGroupRow['BG_FILE2'];

			## 체크
			if(!$aryGroupRow) { continue; }

			## 파일 삭제
			if($strBG_FILE1) { FileDevice::fileDelete("{$strDefaultDir}/{$strBG_FILE1}"); }
			if($strBG_FILE2) { FileDevice::fileDelete("{$strDefaultDir}/{$strBG_FILE2}"); }


			## DB 삭제
			$param = "";
			$param['BG_LNG'] = $lang;
			$param['BG_LNG_NO'] = $intBgNo;
			$objBoardGroupNewModule->getBoardGroupNewDeleteEx($param);

		endforeach;

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;
	
	case "groupData":
		// 커뮤니티 그룹 데이터 불러오기

		## 모듈 설정
		$objBoardGroupNewModule = new BoardGroupNewModule($db);

 		## 기본 설정
		$intBgNo = $_POST['bg_no'];
		$strLang = $_POST['lang'];
		$strStLang = $S_ST_LNG;
		$strWebDir = "/upload/community/group";

		## 체크
		if(!$intBgNo):
			$result['__STATE__'] = "NO_BG_NO";
			$result['__MSG__'] = "번호가 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;

		## 데이터 불러오기(기준언어)
		$param = "";
		$param['BG_LNG'] = $strStLang;
		$param['BG_LNG_NO'] = $intBgNo;
		$aryStGroupRow = $objBoardGroupNewModule->getBoardGroupNewSelectEx("OP_SELECT", $param);
		$intST_BG_NO = $aryStGroupRow['BG_NO'];
		$strST_BG_NAME = $aryStGroupRow['BG_NAME'];
		$intST_BG_SORT = $aryStGroupRow['BG_SORT'];

		## 데이터 불러오기(요청언어)
		$param = "";
		$param['BG_LNG'] = $strLang;
		$param['BG_LNG_NO'] = $intBgNo;
		$aryGroupRow = $objBoardGroupNewModule->getBoardGroupNewSelectEx("OP_SELECT", $param);
		$intBG_NO = $aryGroupRow['BG_NO'];
		$strBG_NAME = $aryGroupRow['BG_NAME'];
		$strBG_FILE1 = $aryGroupRow['BG_FILE1'];
		$strBG_FILE2 = $aryGroupRow['BG_FILE2'];
		$strBG_MENU_USE = $aryGroupRow['BG_MENU_USE'];
		$intBG_SORT = $aryGroupRow['BG_SORT'];

		## 요청언어에 제목이 없으면 기준언어 출력
		if(!$strBG_NAME) { $strBG_NAME = $strST_BG_NAME; }
		if(!$intBG_SORT) { $intBG_SORT = $intST_BG_SORT; }

		## 체크
		if(!$aryStGroupRow):
			$result['__STATE__'] = "NO_DATA";
			$result['__MSG__'] = "요청한 데이터가 없습니다.";
			break;			
		endif;

		## 이미지 설정
		if($strBG_FILE1) { $strBG_FILE1 = "{$strWebDir}/{$strBG_FILE1}"; }
		if($strBG_FILE2) { $strBG_FILE2 = "{$strWebDir}/{$strBG_FILE2}"; }

		## 전달 데이터 만들기
		$aryReturnData = "";
		$aryReturnData['BG_NO'] = $intST_BG_NO;
		$aryReturnData['BG_NAME'] = $strBG_NAME;
		$aryReturnData['BG_FILE1'] = $strBG_FILE1;
		$aryReturnData['BG_FILE2'] = $strBG_FILE2;
		$aryReturnData['BG_MENU_USE'] = $strBG_MENU_USE;
		$aryReturnData['BG_SORT'] = $intBG_SORT;

		## 마무리
		$result['__STATE__'] = "SUCCESS";
		$result['__DATA__'] = $aryReturnData;	

	break;

	case "groupWrite":
		// 커뮤니티 그룹 등록

		## 모듈 설정
		$objBoardGroupNewModule = new BoardGroupNewModule($db);

		## 기본 설정
		$strBgName = $_POST['bg_name'];
		$intBgSort = $_POST['bg_sort'];
		$strBgMenuUse = $_POST['bg_menu_use'];
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strLang = $S_ST_LNG;
		$strLangLower = strtolower($strLang);
		$strWebDir = "/upload/community/group";
		$strDefaultDir = MALL_SHOP . $strWebDir;
		if(!$strBG_MENUUSE) { $strBG_MENUUSE = "Y"; }
		if(!$intBgSort) { $intBgSort = 99999; }
		
		## 파일 업로드
		if($_FILES):

			## 그룹 폴더 만들기
			if(!FileDevice::makeFolder($strDefaultDir)):
				$result['__STATE__'] = "NO_DIR";
				$result['__MSG__'] = "그룹 폴더를 생성할 수 없습니다.";
				break;
			endif;
			
			foreach($_FILES as $key => $data):
				
				## 기본설정
				$strName = $data['name'];
				$strType = $data['type'];
				$intSize = $data['size'];
				$strError = $data['error'];
				$strSaveFileName = FileDevice::getUniqueFileName($strDefaultDir, date("YmdHis") . "_{$key}_%s_@_" . $strName);

				## 체크
				if($strError) { continue; }
				if(!$strSaveFileName) { continue; }

				## 파일 업로드
				$re = FileDevice::upload($key, "{$strDefaultDir}/{$strSaveFileName}");

				## 결과 저장
				if($re) { $_FILES[$key]['saveFileName'] = $strSaveFileName; }

			endforeach;
		endif;

		## 데이터 등록(기준)
		$param = "";
		$param['BG_NAME']			= $strBgName;
		$param['BG_LNG']			= $strLang;
		$param['BG_LNG_NO']			= "";
		$param['BG_FILE1']			= $_FILES['bg_file1']['saveFileName'];
		$param['BG_FILE2']			= $_FILES['bg_file2']['saveFileName'];
		$param['BG_MENU_USE']		= $strBgMenuUse;
		$param['BG_SORT']			= $intBgSort;
		$param['BG_REG_DT']			= "NOW()";
		$param['BG_REG_NO']			= $intMemberNo;
		$param['BG_MOD_DT']			= "NOW()";
		$param['BG_MOD_NO']			= $intMemberNo;
		$intBgNo					= $objBoardGroupNewModule->getBoardGroupNewInsertEx($param);

		## 체크
		if(!$intBgNo || $intBgNo < 0):
			$result['__STATE__'] = "NO_INSERT";
			$result['__MSG__'] = "데이터를 등록할수 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		## 기준언어 번호 업데이트
		$param = "";
		$param['BG_NO']				= $intBgNo;
		$param['BG_LNG_NO']			= $intBgNo;
		$objBoardGroupNewModule->getBoardGroupNewLngNoUpdateEx($param);

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "groupModify":
		// 그룹 수정

		## 모듈 설정
		$objBoardGroupNewModule = new BoardGroupNewModule($db);

		## 기본 설정
		$intBgNo = $_POST['bg_no'];
		$strBgName = $_POST['bg_name'];
		$intBgSort = $_POST['bg_sort'];
		$intLang = $_POST['lang'];
		$strBgMenuUse = $_POST['bg_menu_use'];
		$strBgFile1Del = $_POST['bg_file1_del'];
		$strBgFile2Del = $_POST['bg_file2_del'];
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strLangLower = strtolower($strLang);
		$strWebDir = "/upload/community/group";
		$strDefaultDir = MALL_SHOP . $strWebDir;
		if(!$intBgSort) { $intBgSort = 99999; }

		## 체크
		if(!$intBgNo):
			$result['__STATE__'] = "NO_BG_NO";
			$result['__MSG__'] = "번호가 없습니다.";
			break;
		endif;
		if(!$intLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__'] = "NO_MEMBER_NO";
			$result['__MSG__'] = "수정할 권한이 없습니다.";
			break;
		endif;

		## 파일 삭제 리스트 설정
		$_FILES['bg_file1']['del'] = $strBgFile1Del;
		$_FILES['bg_file2']['del'] = $strBgFile2Del;

		## 파일 업로드
		if($_FILES):

			## 그룹 폴더 만들기
			if(!FileDevice::makeFolder($strDefaultDir)):
				$result['__STATE__'] = "NO_DIR";
				$result['__MSG__'] = "그룹 폴더를 생성할 수 없습니다.";
				break;
			endif;
			
			foreach($_FILES as $key => $data):
				
				## 기본설정
				$strName = $data['name'];
				$strType = $data['type'];
				$intSize = $data['size'];
				$strError = $data['error'];
				$strSaveFileName = FileDevice::getUniqueFileName($strDefaultDir, date("YmdHis") . "_{$key}_%s_@_" . $strName);

				## 체크
				if($strError) { continue; }
				if(!$strSaveFileName) { continue; }

				## 파일 업로드
				$re = FileDevice::upload($key, "{$strDefaultDir}/{$strSaveFileName}");

				## 결과 저장
				if($re):
					$_FILES[$key]['saveFileName'] = $strSaveFileName;
					$_FILES[$key]['del'] = "Y";
				endif;

			endforeach;
		endif;

		## 데이터 불러오기
		$param = "";
		$param['BG_LNG'] = $intLang;
		$param['BG_LNG_NO'] = $intBgNo;
		$aryGroupRow = $objBoardGroupNewModule->getBoardGroupNewSelectEx("OP_SELECT", $param);
		$intBG_NO = $aryGroupRow['BG_NO'];
		$strBG_FILE1 = $aryGroupRow['BG_FILE1'];
		$strBG_FILE2 = $aryGroupRow['BG_FILE2'];

		## 파일 설정
		$strFileName1 = $strBG_FILE1;
		$strFileName2 = $strBG_FILE2;
		$strFileDel1 = $_FILES['bg_file1']['del'];
		$strFileDel2 = $_FILES['bg_file2']['del'];
		$strSaveFileName1 = $_FILES['bg_file1']['saveFileName'];
		$strSaveFileName2 = $_FILES['bg_file2']['saveFileName'];
		if($strFileDel1 == "Y"):
			FileDevice::fileDelete("{$strDefaultDir}/{$strFileName1}");
			$strFileName1 = $strSaveFileName1;
		endif;
		if($strFileDel2 == "Y"):
			FileDevice::fileDelete("{$strDefaultDir}/{$strFileName2}");
			$strFileName2 = $strSaveFileName2;
		endif;

		## 이미 등록된 데이터가 있으면 업데이트, 없으면 신규 생성
		if($aryGroupRow):
			
			$param = "";
			$param['BG_NO']				= $intBG_NO;
			$param['BG_NAME']			= $strBgName;
			$param['BG_FILE1']			= $strFileName1;
			$param['BG_FILE2']			= $strFileName2;
			$param['BG_MENU_USE']		= $strBgMenuUse;
			$param['BG_SORT']			= $intBgSort;  
			$param['BG_MOD_DT']			= "NOW()";
			$param['BG_MOD_NO']			= $intMemberNo;
			$re							= $objBoardGroupNewModule->getBoardGroupNewUpdateEx($param);
		else:
			$param = "";
			$param['BG_LNG']			= $intLang;
			$param['BG_LNG_NO']			= $intBgNo;
			$param['BG_NAME']			= $strBgName;
			$param['BG_FILE1']			= $strFileName1;
			$param['BG_FILE2']			= $strFileName2;
			$param['BG_MENU_USE']		= $strBgMenuUse;
			$param['BG_SORT']			= $intBgSort;  
			$param['BG_REG_DT']			= "NOW()";
			$param['BG_REG_NO']			= $intMemberNo;
			$param['BG_MOD_DT']			= "NOW()";
			$param['BG_MOD_NO']			= $intMemberNo;
			$intBglNo					= $objBoardGroupNewModule->getBoardGroupNewInsertEx($param);
		endif;

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	endswitch;


	## 무조건 파일 생성 되도록 변경함.
	if($result['__STATE__'] == "SUCCESS"):

		## 모듈 설정
		$objBoardGroupNewModule = new BoardGroupNewModule($db);

 		## 기본 설정
		$intLang = $_POST['lang'];
		$strOrderBy = $_POST['orderBy'];
		$strStLang = $S_ST_LNG;
		$strUseLang = $S_USE_LNG;
		$aryUseLang = explode("/", $strUseLang);
		if(!$strOrderBy) { $strOrderBy = "sortAsc"; }

		## 체크
		if(!$intLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			return;
		endif;
		if(!$strStLang):
			$result['__STATE__'] = "NO_ST_LANG";
			$result['__MSG__'] = "기준 언어가 없습니다.";
			return;
		endif;
		if(!$aryUseLang):
			$result['__STATE__'] = "NO_USE_LANG";
			$result['__MSG__'] = "사용되는 언어가 없습니다.";
			return;
		endif;

		## 언어별로 설정
		foreach($aryUseLang as $lang):

			## 기본설정
			$langLower = strtolower($lang);
			$strConfTextDir = MALL_SHOP . "/conf/community/{$langLower}";
			$strConfTextFile = "{$strConfTextDir}/groupList.info.php";

			## 폴더 만들기
			FileDevice::makeFolder($strConfTextDir);

			## 데이터 불러오기
			$param = "";
			$param['LNG'] = $lang;
			$param['S_ST_LNG'] = $strStLang;
			$param['BG_MENU_USE'] ="Y";
			$param['ORDER_BY'] = $strOrderBy;
			$aryGroupList = $objBoardGroupNewModule->getBoardGroupNewLngSelectEx("OP_ARYTOTAL", $param);

			## 체크
			if(!$aryGroupList) { continue; }

			## 파일 데이터 만들기
			$strConfText = "";
			foreach($aryGroupList as $key => $row):
				
				## 기본 설정
				$intBG_NO = $row['BG_NO'];
				$strBG_NAME = $row['BG_NAME'];
				$strBG_FILE1 = $row['BG_FILE1'];
				$strBG_FILE2 = $row['BG_FILE2'];
				$strBG_MENU_USE = $row['BG_MENU_USE'];
				$intBG_SORT = $row['BG_SORT'];
				$intBG_BOARD_CNT = $row['BG_BOARD_CNT'];
				$strTemp = "";

				## 설정파일
				$strTemp .= "\$GROUP_LIST['{$intBG_NO}']['bg_name'] = \"{$strBG_NAME}\";\n";
				$strTemp .= "\$GROUP_LIST['{$intBG_NO}']['bg_file1'] = \"{$strBG_FILE1}\";\n";
				$strTemp .= "\$GROUP_LIST['{$intBG_NO}']['bg_file2'] = \"{$strBG_FILE2}\";\n";
				$strTemp .= "\$GROUP_LIST['{$intBG_NO}']['bg_board_cnt'] = \"{$intBG_BOARD_CNT}\";";

				## 설정파일 리스트
				if($strConfText ) { $strConfText .= "\n"; }
				$strConfText .= $strTemp;
			endforeach;

			## 파일 만들기
			FileDevice::getMadeInfo($strConfTextFile, $strConfText, "## GROUP");

		endforeach;

	endif;