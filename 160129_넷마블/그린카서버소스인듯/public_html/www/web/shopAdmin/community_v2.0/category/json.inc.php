<?php

	switch($strAct):

	case "categoryDelete":
		// 커뮤니티 카테고리 내용 삭제

		## 모듈 설정
		$objBoardCategoryModule = new BoardCategoryModule($db);
		$objBoardCategoryLngModule = new BoardCategoryLngModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$intBcNo = $_POST['bc_no'];
		$intBcSort = $_POST['bc_sort'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strWebDir = "/upload/community/category";
		$strDefaultDir = MALL_SHOP . $strWebDir;

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
		if(!$intBcNo):
			$result['__STATE__'] = "NO_BC_NO";
			$result['__MSG__'] = "수정할 카테고리 번호가 없습니다.";
			break;
		endif;

		## 데이터 불러오기(기준)
		$param = "";
		$param['LNG'] = $strLang;
		$param['BC_NO'] = $intBcNo;
		$param['BC_B_CODE'] = $strBCode;
		$aryCategoryRow = $objBoardCategoryModule->getBoardCategorySelectEx("OP_SELECT", $param);
		$strBC_IMAGE_1 = $aryCategoryRow['BC_IMAGE_1'];
		$strBC_IMAGE_2 = $aryCategoryRow['BC_IMAGE_2'];

		## 데이터 불러오기(언어)
		$param = "";
		$param['BCL_BC_NO'] = $intBcNo;
		$aryCategoryList = $objBoardCategoryLngModule->getBoardCategoryLngSelectEx("OP_ARYTOTAL", $param);

		## 파일&데이터 삭제(언어별)
		if($aryCategoryList):
			foreach($aryCategoryList as $key => $row):
				
				## 기본 설정
				$intBCL_BC_NO = $row['BCL_BC_NO'];
				$strBCL_LNG = $row['BCL_LNG'];
				$strBCL_IMAGE_1 = $row['BCL_IMAGE_1'];
				$strBCL_IMAGE_2 = $row['BCL_IMAGE_2'];

				## 파일 삭제
				if($strBCL_IMAGE_1) { FileDevice::fileDelete("{$strDefaultDir}/{$strBCL_IMAGE_1}"); }
				if($strBCL_IMAGE_2) { FileDevice::fileDelete("{$strDefaultDir}/{$strBCL_IMAGE_2}"); }

				## 파일 삭제(DB 삭제)
				$param = "";
				$param['BCL_BC_NO'] = $intBCL_BC_NO;
				$param['BCL_LNG'] = $strBCL_LNG;
				$re = $objBoardCategoryLngModule->getBoardCategoryLngDeleteEx($param);
			
			endforeach;
		endif;

		## 데이터 삭제(기준언어)
		$param = "";
		$param['BC_NO'] = $intBcNo;
		$re = $objBoardCategoryModule->getBoardCategoryDeleteEx($param);
	
		## 파일 만들기
		getCategoryFileMake($strLang, $strBCode);

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	case "categorySelect":
		// 커뮤니티 카테고리 내용 전달.

		## 모듈 설정
		$objBoardCategoryModule = new BoardCategoryModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$intBcNo = $_POST['bc_no'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strWebDir = "/upload/community/category";
		$strDefaultDir = MALL_SHOP . $strWebDir;
;
		## 체크
		if(!$intMemberNo):
			$result['__STATE__'] = "NO_MEMBER_NO";
			$result['__MSG__'] = "권한이 없습니다.";
			break;
		endif;
		if(!$strBCode):
			$result['__STATE__'] = "B_CODE";
			$result['__MSG__'] = "카테고리 코드값이 없습니다.";
			break;
		endif;
		if(!$strLang):
			$result['__STATE__'] = "NO_LANG";
			$result['__MSG__'] = "설정된 언어가 없습니다.";
			break;
		endif;
		if(!$intBcNo):
			$result['__STATE__'] = "NO_BC_NO";
			$result['__MSG__'] = "카테고리 번호가 없습니다.";
			break;
		endif;

		## 데이터 불러오기
		$param = "";
		$param['LNG'] = $strLang;
		$param['BC_NO'] = $intBcNo;
		$param['BC_B_CODE'] = $strBCode;
		$aryCategoryRow = $objBoardCategoryModule->getBoardCategorySelectEx("OP_SELECT", $param);
		$intBC_NO = $aryCategoryRow['BC_NO'];
		$strBC_NAME = $aryCategoryRow['BC_NAME'];
		$strBC_IMAGE_1 = $aryCategoryRow['BC_IMAGE_1'];
		$strBC_IMAGE_2 = $aryCategoryRow['BC_IMAGE_2'];
		$strBCL_NAME = $aryCategoryRow['BCL_NAME'];
		$strBCL_IMAGE_1 = $aryCategoryRow['BCL_IMAGE_1'];
		$strBCL_IMAGE_2 = $aryCategoryRow['BCL_IMAGE_2'];
		$intBC_SORT = $aryCategoryRow['BC_SORT'];

		if(!$aryCategoryRow || $aryCategoryRow <= 0):
			$result['__STATE__'] = "NO_HAVA_DATA";
			$result['__MSG__'] = "데이터를 불러올수 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		## 이미지 설정
		$strImageFile1 = $strBCL_IMAGE_1;
		$strImageFile2 = $strBCL_IMAGE_2;
		if($strImageFile1) { $strImageFile1 = "{$strWebDir}/{$strImageFile1}"; }
		if($strImageFile2) { $strImageFile2 = "{$strWebDir}/{$strImageFile2}"; }

		## 전달 데이터 만들기
		$aryReturnData = "";
		$aryReturnData['BC_NO'] = $intBC_NO;
		$aryReturnData['BCL_NAME'] = $strBCL_NAME;
		$aryReturnData['IMAGE_FILE1'] = $strImageFile1;
		$aryReturnData['IMAGE_FILE2'] = $strImageFile2;
		$aryReturnData['BC_SORT'] = $intBC_SORT;

		## 마무리
		$result['__STATE__'] = "SUCCESS";
		$result['__DATA__'] = $aryReturnData;	

	break;

	case "categoryWrite":
		// 커뮤니티 카테고리 등록

		## 모듈 설정
		$objBoardCategoryModule = new BoardCategoryModule($db);
		$objBoardCategoryLngModule = new BoardCategoryLngModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$strBcName = $_POST['bc_name'];
		$intBcSort = $_POST['bc_sort'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strWebDir = "/upload/community/category";
		$strDefaultDir = MALL_SHOP . $strWebDir;

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
		if(!$strBcName):
			$result['__STATE__'] = "NO_BC_NAME";
			$result['__MSG__'] = "카테고리 이름이 없습니다.";
			break;
		endif;
		if($strLang != $strLangS):
			$result['__STATE__'] = "DIFF_LANG";
			$result['__MSG__'] = "기준언어 카테고리를 먼저 등록하시기 바랍니다.";
			break;
		endif;

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
				if($re) { $_POST[$key] = $strSaveFileName; }

			endforeach;

			## 카테고리 파일명 설정
			$strBcImage1 = $_POST['bc_image_1'];
			$strBcImage2 = $_POST['bc_image_2'];

		endif;

		## 기준언어와 시작언어가 같으면 기준언어 테이블에 저장
		if($strLang == $strLang):
			## 데이터 등록(기준)
			$param						= "";
			$param['BC_B_CODE']			= $strBCode;
			$param['BC_NAME']			= $strBcName;
			$param['BC_IMAGE_1']		= $strBcImage1;
			$param['BC_IMAGE_2']		= $strBcImage2;
			$param['BC_SORT']			= $intBcSort;
			$param['BC_REG_DT']			= "NOW()";
			$param['BC_REG_NO']			= $intMemberNo;
			$param['BC_MOD_DT']			= "NOW()";
			$param['BC_MOD_NO']			= $intMemberNo;
			$intBC_NO					= $objBoardCategoryModule->getBoardCategoryInsertEx($param);

			if(!$intBC_NO || $intBC_NO <= 0):
				$result['__STATE__'] = "NO_INSERT_DATA";
				$result['__MSG__'] = "등록 할 수 없습니다. 관리자에게 문의하세요.";
				break;
			endif;
		endif;

		## 데이터 등록(언어)
		if($intBC_NO):
			$param						= "";
			$param['BCL_BC_NO']			= $intBC_NO;
			$param['BCL_LNG']			= $strLang;
			$param['BCL_NAME']			= $strBcName;
			$param['BCL_IMAGE_1']		= $strBcImage1;
			$param['BCL_IMAGE_2']		= $strBcImage2;
			$param['BCL_REG_DT']		= "NOW()";
			$param['BCL_REG_NO']		= $intMemberNo;
			$param['BCL_MOD_DT']		= "NOW()";
			$param['BCL_MOD_NO']		= $intMemberNo;
			$re							= $objBoardCategoryLngModule->getBoardCategoryLngInsertEx($param);
		endif;

		## 파일 만들기
		getCategoryFileMake($strLang, $strBCode);

		## 마무리
		$result['__STATE__'] = "SUCCESS";

	break;

	case "categoryModify":
		// 커뮤니티 카테고리 수정

		## 모듈 설정
		$objBoardCategoryModule = new BoardCategoryModule($db);
		$objBoardCategoryLngModule = new BoardCategoryLngModule($db);

		## 기본 설정
		$strBCode = $_POST['b_code'];
		$intBcNo = $_POST['bc_no'];
		$strBcName = $_POST['bc_name'];
		$intBcSort = $_POST['bc_sort'];
		$aryDelList = $_POST['del_list'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$intMemberNo = $_SESSION['ADMIN_NO'];
		$strWebDir = "/upload/community/category";
		$strDefaultDir = MALL_SHOP . $strWebDir;

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
		if(!$strBcName):
			$result['__STATE__'] = "NO_BC_NAME";
			$result['__MSG__'] = "카테고리 이름이 없습니다.";
			break;
		endif;
		if(!$intBcNo):
			$result['__STATE__'] = "NO_BC_NO";
			$result['__MSG__'] = "수정할 카테고리 번호가 없습니다.";
			break;
		endif;

		## 데이터 불러오기
		$param = "";
		$param['LNG'] = $strLang;
		$param['BC_NO'] = $intBcNo;
		$param['BC_B_CODE'] = $strBCode;
		$aryCategoryRow = $objBoardCategoryModule->getBoardCategorySelectEx("OP_SELECT", $param);
		$intBC_NO = $aryCategoryRow['BC_NO'];
		$strBC_NAME = $aryCategoryRow['BC_NAME'];
		$strBC_IMAGE_1 = $aryCategoryRow['BC_IMAGE_1'];
		$strBC_IMAGE_2 = $aryCategoryRow['BC_IMAGE_2'];
		$strBCL_NAME = $aryCategoryRow['BCL_NAME'];
		$strBCL_IMAGE_1 = $aryCategoryRow['BCL_IMAGE_1'];
		$strBCL_IMAGE_2 = $aryCategoryRow['BCL_IMAGE_2'];
		$intBC_SORT = $aryCategoryRow['BC_SORT'];

		if(!$aryCategoryRow || $aryCategoryRow <= 0):
			$result['__STATE__'] = "NO_HAVA_DATA";
			$result['__MSG__'] = "수정할 데이터가 없습니다. 관리자에게 문의하세요.";
			break;
		endif;

		## 이미지 설정
		$strBcImage1 = "";
		$strBcImage2 = "";
		if($strBCL_IMAGE_1 && !in_array("bc_image_1", $aryDelList)):	
			$strBcImage1 = $strBCL_IMAGE_1;		
		endif;
		if($strBCL_IMAGE_2 && !in_array("bc_image_2", $aryDelList)):	
			$strBcImage2 = $strBCL_IMAGE_2;
		endif;

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
					if($key == "bc_image_1") { $strBcImage1 = $strSaveFileName; }
					if($key == "bc_image_2") { $strBcImage2 = $strSaveFileName; }
					$aryDelList[] = $key;
				endif;

			endforeach;
	
			## 중복되는 내용 정리
			$aryDelList = array_unique($aryDelList);
		endif;

		## 데이터 삭제
		if($strBC_IMAGE_1 && in_array("bc_image_1", $aryDelList)):	
			FileDevice::fileDelete("{$strDefaultDir}/{$strBCL_IMAGE_1}");				
		endif;
		if($strBC_IMAGE_2 && in_array("bc_image_2", $aryDelList)):	
			FileDevice::fileDelete("{$strDefaultDir}/{$strBCL_IMAGE_2}");	
		endif;
		
		## 기준언어와 시작언어가 같으면 기준언어 정보 수정
		if($strLang == $strLang):
			## 데이터 등록(기준)
			$param					= "";
			$param['BC_NO']			= $intBcNo;
			$param['BC_NAME']		= $strBcName;
			$param['BC_IMAGE_1']	= $strBcImage1;
			$param['BC_IMAGE_2']	= $strBcImage2;
			$param['BC_SORT']		= $intBcSort;
			$param['BC_MOD_DT']		= "NOW()";
			$param['BC_MOD_NO']		= $intMemberNo;
			$re						= $objBoardCategoryModule->getBoardCategoryUpdateEx($param);
		endif;

		## 기존에 등록된 데이터 삭제(언어)
		$param						= "";
		$param['BCL_BC_NO']			= $intBcNo;
		$param['BCL_LNG']			= $strLang;
		$re							= $objBoardCategoryLngModule->getBoardCategoryLngDeleteEx($param);
		
		## 데이터 등록(언어)
		$param						= "";
		$param['BCL_BC_NO']			= $intBcNo;
		$param['BCL_LNG']			= $strLang;
		$param['BCL_NAME']			= $strBcName;
		$param['BCL_IMAGE_1']		= $strBcImage1;
		$param['BCL_IMAGE_2']		= $strBcImage2;
		$param['BCL_REG_DT']		= "NOW()";
		$param['BCL_REG_NO']		= $intMemberNo;
		$param['BCL_MOD_DT']		= "NOW()";
		$param['BCL_MOD_NO']		= $intMemberNo;
		$re							= $objBoardCategoryLngModule->getBoardCategoryLngInsertEx($param);

		## 파일 만들기
		getCategoryFileMake($strLang, $strBCode);

		## 마무리
		$result['__STATE__'] = "SUCCESS";
	break;

	endswitch;


	## 함수
	## category.conf 파일 만들기
	function getCategoryFileMake($strLang, $strBCode) {

		## 전역함수 설정
		global $db;

		## 모듈 설정
		$objBoardCategoryModule = new BoardCategoryModule($db);		

		## 기본설정
		$strLangLower = strtolower($strLang);
		$strWebDir = "/upload/community/category";
		$strConfDir = MALL_SHOP . "/conf/community/category/{$strLangLower}";
		$strConfFile = "category.{$strBCode}.info.php";

		## 데이터 리스트 가져오기
		$param = "";
		$param['LNG'] = $strLang;
		$param['BC_B_CODE'] = $strBCode;
		$param['ORDER_BY'] = "sortAsc";
		$aryCategoryList = $objBoardCategoryModule->getBoardCategorySelectEx("OP_ARYTOTAL", $param);

		## 체크
		if(!$aryCategoryList) { return; }

		## 파일 데이터 만들기
		$strConfData = "";
		foreach($aryCategoryList as $key => $row):

				## 기본정보
				$intBC_NO = $row['BC_NO'];
				$strBC_NAME = $row['BC_NAME'];
				$strBC_IMAGE_1 = $row['BC_IMAGE_1'];
				$strBC_IMAGE_2 = $row['BC_IMAGE_2'];
				$intBC_SORT = $row['BC_SORT'];
				$strBCL_NAME = $row['BCL_NAME'];
				$strBCL_IMAGE_1 = $row['BCL_IMAGE_1'];
				$strBCL_IMAGE_2 = $row['BCL_IMAGE_2'];

				## 이름 설정
				$strName = $strBC_NAME;
				if($strBCL_NAME) { $strName = $strBCL_NAME; }

				## 이미지1 설정
				$strImageFile1 = $strBC_IMAGE_1;
				if($strBCL_IMAGE_1) { $strImageFile1 = $strBCL_IMAGE_1; }
//				if($strImageFile1) { $strImageFile1 = "{$strWebDir}/{$strImageFile1}"; }

				## 이미지2 설정
				$strImageFile2 = $strBC_IMAGE_2;
				if($strBCL_IMAGE_2) { $strImageFile2 = $strBCL_IMAGE_2; }
//				if($strImageFile2) { $strImageFile2 = "{$strWebDir}/{$strImageFile2}"; }

				## 내용 추가시 1칸 뛰움
				if($strConfData) { $strConfData .= "\n"; }

				## 파일 데이터 문장 만들기
				$strConfData .= "\$CATEGORY_LIST['{$intBC_NO}']['bc_name'] = '{$strName}';\n";
				$strConfData .= "\$CATEGORY_LIST['{$intBC_NO}']['bc_image_1'] = '{$strImageFile1}';\n";
				$strConfData .= "\$CATEGORY_LIST['{$intBC_NO}']['bc_image_2'] = '{$strImageFile1}';";

		endforeach;

		## 폴더 체크
		if(!FileDevice::makeFolder($strConfDir)):
			$result['__STATE__'] = "NO_MAKE_DIR";
			$result['__MSG__'] = "폴더를 생성할수 없습니다. 관리자에게 문의하세요.";
			break;			
		endif;

		## 파일 만들기
		FileDevice::getMadeInfo("{$strConfDir}/{$strConfFile}", $strConfData, "/*@ CATEGORY USER_REPORT @*/");

	}