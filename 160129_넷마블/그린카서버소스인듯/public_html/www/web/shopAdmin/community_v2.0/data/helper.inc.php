<?php
	switch($strMode):
	case "dataAnswer":
		// 답변
	case "dataModify":
		// 수정
	case "dataView":
		// 게시판 내용

		## 모듈 설정
		$objBoardFileModule = new BoardFileModule($db);
		$objBoardDataModule = new BoardDataModule($db);

		## 스크립트 설정
		if(!$strMode){
		$aryScriptEx[]				= "./common/js/community_v2.0/data/{$strMode}.js";
		}

		## 기본 설정
		$strBCode = $_GET['b_code'];
		$intUbNo = $_GET['ubNo'];
		$strLang = $_GET['lang'];
		//$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		//사이트 언어로 변경(세션). 남덕희
		$strLangS = $strAdmSiteLng; // 시작 언어(기준언어)
		if(!$strLang) { $strLang = $strLangS; }
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$strBCodeLower = strtolower($strBCode);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 
		$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strLangLower}";
		$strCommunityCateFile = "category.{$strBCode}.info.php"; 
		$intMemberNo = $a_admin_no;
		$strMemberName = $a_admin_name;
		$strMemberEmail = $a_admin_mail;
		$strMemberGroup = $a_admin_group;
		$strMemberType = $a_admin_type;
//		$strSiteFacebook = $S_SITE_FACEBOOK;
//		$strSiteTwitter = $S_SITE_TWITTER;
//		$strSiteFacebookAppID = $S_SITE_FACEBOOK_APP_ID;
//		$strSiteFacebookSecret = $S_SITE_FACEBOOK_SECRET;
		$arySessionFileList = $_SESSION['FILE']; // 세션에 등록된 파일 리스트
		$strEditorDir = "community/{$strBCodeLower}";
		$aryUseLang = explode("/", $S_USE_LNG);
		$intUseLang = sizeof($aryUseLang);

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

		## 체크
		if(!$strBCode):
			$param = "";
			$param['file'] = __FILE__;
			$param['msg'] = "b_code가 없습니다.";
			getDebug($param);
			return;
		endif;
		if(!$aryBoardInfo):
			$param = "";
			$param['file'] = __FILE__;
			$param['msg'] = "boardInfo가 없습니다.";
			getDebug($param);
			return;		
		endif;
		if(!$intUbNo):
			$param = "";
			$param['file'] = __FILE__;
			$param['msg'] = "ubNo가 없습니다.";
			getDebug($param);
			return;		
		endif;

		## 커뮤니티 카테고리 설정 파일
		include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
		$aryCategoryList = $CATEGORY_LIST;

		## 커뮤니티 설정
		$strB_NAME = $aryBoardInfo['B_NAME'];
//		$strBI_START_MODE = $aryBoardInfo['BI_START_MODE']; 
//		$strB_KIND_SKIN = $aryBoardInfo['B_KIND_SKIN']; 
//		$strB_CSS = $aryBoardInfo['B_CSS'];
//		$strBI_CATEGORY_USE = $aryBoardInfo['BI_CATEGORY_USE'];
		$aryBI_DATALIST_FIELD_USE = $aryBoardInfo['BI_DATALIST_FIELD_USE'];
		$intBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
		$strBI_DATAWRITE_FORM = $aryBoardInfo['BI_DATAWRITE_FORM']; // 글쓰기 폼 설정
//		$aryBI_DATALIST_WRITER_SHOW = $aryBoardInfo['BI_DATALIST_WRITER_SHOW'];
//		$intBI_DATALIST_WRITER_HIDDEN = $aryBoardInfo['BI_DATALIST_WRITER_HIDDEN'];
//		$strBI_DATAVIEW_USE = $aryBoardInfo['BI_DATAVIEW_USE']; // 글보기권한(모든회원/비회원-A, 회원전용-M)
//		$aryBI_DATAVIEW_MEMBER_AUTH = $aryBoardInfo['BI_DATAVIEW_MEMBER_AUTH'];
//		$strBI_DATAANSWER_USE = $aryBoardInfo['BI_DATAANSWER_USE']; // 답변권환(모든회원/비회원-A, 회원전용-M)
//		$aryBI_DATAANSWER_MEMBER_AUTH = $aryBoardInfo['BI_DATAANSWER_MEMBER_AUTH'];
//		$strBI_DATAVIEW_FACEBOOK_USE = $aryBoardInfo['BI_DATAVIEW_FACEBOOK_USE']; // 페이스북 사용 유무
//		$strBI_DATAVIEW_TWITTER_USE = $aryBoardInfo['BI_DATAVIEW_TWITTER_USE']; // 트위터 사용 유무
//		$strBI_DATALIST_ORDERBY = $aryBoardInfo['BI_DATALIST_ORDERBY']; // 리스트 정렬
//		$strBI_START_MODE = $aryBoardInfo['BI_START_MODE']; // 시작페이지 
//		$strBI_DATAWRITE_END_MOVE = $aryBoardInfo['BI_DATAWRITE_END_MOVE']; // 글쓰기후이동 
//		$strBI_DATAVIEW_NEXTPRVE_USE = $aryBoardInfo['BI_DATAVIEW_NEXTPRVE_USE']; // 글보기 네비게이션 설정

		## 데이터 불러오기
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['UB_NO'] = $intUbNo;
		$param['UB_LNG_IN'][] = $strLang;
		//$param['UB_LNG_IN'][] = "--";
		$param['JOIN_MM'] = "Y";
		$param['JOIN_PM'] = "Y";
		$param['JOIN_PRO_MGR'] = "Y";
		$aryBoardDataRow = $objBoardDataModule->getBoardDataSelectEx2("OP_SELECT", $param);
		$strUB_DEL = $aryBoardDataRow['UB_DEL'];

		## 삭제글 체크
		if($strUB_DEL == "Y"):
			goErrMsg("삭제된 글입니다.");
			return;
		endif;
		## 데이터 기본 설정
		$intUB_NO = $aryBoardDataRow['UB_NO'];
		$strUB_TITLE = $aryBoardDataRow['UB_TITLE'];
		$strUB_NAME = $aryBoardDataRow['UB_NAME']; 
		$intUB_M_NO = $aryBoardDataRow['UB_M_NO'];
		$strUB_M_ID = $aryBoardDataRow['UB_M_ID'];
		$strUB_MAIL = $aryBoardDataRow['UB_MAIL']; 
		$strUB_TITLE = $aryBoardDataRow['UB_TITLE'];
		$strUB_REG_DT = $aryBoardDataRow['UB_REG_DT'];
		$intUB_READ = $aryBoardDataRow['UB_READ'];
		$intUB_P_GRADE = $aryBoardDataRow['UB_P_GRADE'];
		$intUB_BC_NO = $aryBoardDataRow['UB_BC_NO'];
		$strUB_TEXT = $aryBoardDataRow['UB_TEXT'];
		$strUB_FUNC = $aryBoardDataRow['UB_FUNC'];
		$strUB_PASS = $aryBoardDataRow['UB_PASS'];
		$intUB_ANS_NO = $aryBoardDataRow['UB_ANS_NO'];
		$strUB_IP = $aryBoardDataRow['UB_IP'];
		$strUB_LNG = $aryBoardDataRow['UB_LNG'];
		$intUB_SHOP_NO = $aryBoardDataRow['UB_SHOP_NO'];

		$strP_NAME = $aryBoardDataRow['P_NAME']; //상품이름
		$strP_CODE = $aryBoardDataRow['P_CODE']; //상품코드
		$strPM_REAL_NAME = $aryBoardDataRow['PM_REAL_NAME']; //상품이미지위치

		## 언어 설정
		$strUB_LNG_NAME = $S_ARY_COUNTRY[$strUB_LNG];
		if(!$strUB_LNG_NAME) { $strUB_LNG_NAME = "전체"; }

		## 카테고리 설정
		$strUB_BC_NO_NAME = $aryCategoryList[$intUB_BC_NO];
		if(!$strUB_BC_NO_NAME) { $strUB_BC_NO_NAME = "없음"; }

		## 작성일자 설정
		$strUB_REG_DT = date("Y.m.d", strtotime($strUB_REG_DT));
		
		## CRM 버튼 설정 	 "dataAnswer": "dataModify": "dataView":
		$isBtnUseCrn = true;
		if(!$intUB_M_NO) { $isBtnUseCrn = false; } /* 회원글이 아닌 경우 */
		if($strMemberType != "A") {  $isBtnUseCrn = false; } /*최고 관리자가 아닌경우 숨김 처리 */

		## 메일설정
		if(!$strUB_MAIL) { $strUB_MAIL = "없음"; }

		## UB_FUNC 설정(0~9)
		$aryFunc = "";
		$strFuncNotice = $strUB_FUNC[0]; // 공지글
		$strFuncLock = $strUB_FUNC[1]; // 비밀글
		$strFuncText = $strUB_FUNC[2]; // text
	//	$aryFunc[] = $strUB_FUNC[3]; // 대기
	//	$aryFunc[] = $strUB_FUNC[4]; // 대기
	//	$aryFunc[] = $strUB_FUNC[5]; // 대기
	//	$aryFunc[] = $strUB_FUNC[6]; // 대기
	//	$aryFunc[] = $strUB_FUNC[7]; // 대기
	//	$aryFunc[] = $strUB_FUNC[8]; // 대기
	//	$aryFunc[] = $strUB_FUNC[9]; // 대기

		## 내용 설정
		## 모바일에서 글작성을 하면, html 편집기로 작성을 하지 않기 때문에, 엔터값(\n) 을 br 테그로 변환 해줘야 합니다.
		if($strFuncText == "Y"):
			$strUB_TEXT = strConvertCut2($strUB_TEXT, 0, "N");
		endif;

		## 목록 설정
		$aryColumn = "";
		$aryColumn[] = "제목";
		if($aryBI_DATALIST_FIELD_USE[0] == "Y") { $aryColumn[] = "번호"; }
		if($aryBI_DATALIST_FIELD_USE[1] == "Y") { $aryColumn[] = "작성자"; }
		if($aryBI_DATALIST_FIELD_USE[2] == "Y") { $aryColumn[] = "등록일"; }
		if($aryBI_DATALIST_FIELD_USE[3] == "Y") { $aryColumn[] = "조회수"; }
		if($aryBI_DATALIST_FIELD_USE[4] == "Y") { $aryColumn[] = "점수"; }
		if($aryBI_DATALIST_FIELD_USE[5] == "Y") { $aryColumn[] = "카테고리"; }
		if($aryBI_DATALIST_FIELD_USE[6] == "Y") { $aryColumn[] = "리스트이미지"; }

		## 첨부파일 사용유무
		$isFile = false;
		if($intBI_ATTACHEDFILE_USE):

			## 설정
			$isFile = true;
			
			## 첨부파일 불러오기
			$param = "";
			$param['B_CODE'] = $strBCode;
			$param['FL_UB_NO'] = $intUbNo;
			$aryBoardFileList = $objBoardFileModule->getBoardFileSelectEx("OP_ARYTOTAL", $param);

			## 첨부파일 설정
			$aryBoardFile = "";
			if($aryBoardFileList):
				foreach($aryBoardFileList as $key => $row):
					
					## 기본설정
					$strFL_KEY = $row['FL_KEY'];

					## 만들기
					$aryBoardFile[$strFL_KEY][] = $row;

				endforeach;
			endif;

		endif;
	

	break;

	case "dataWrite":
		// 게시판 글쓰기

		## 모듈 설정
		$objBoardDataModule = new BoardDataModule($db);

		## 기본 설정
		$intPage = $_GET['page'];
		$strBCode = $_GET['b_code'];
		$strLang = $_GET['lang'];
		//$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		//사이트 언어로 변경(세션). 남덕희
		$strLangS = $strAdmSiteLng; // 시작 언어(기준언어)
		if(!$strLang) { $strLang = $strLangS; }
		$strLangLower = strtolower($strLang);
		$aryUseLang = explode("/", $S_USE_LNG);
		$intUseLang = sizeof($aryUseLang);
		$strBCodeLower = strtolower($strBCode);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 
		$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strLangLower}";
		$strCommunityCateFile = "category.{$strBCode}.info.php"; 
		$strMemberName = $_SESSION['ADMIN_NAME'];
		$strMemberEmail = $_SESSION['ADMIN_MAIL'];
		$strMemberGroup = $_SESSION['ADMIN_GROUP'];
		$arySessionFileList = $_SESSION['FILE']; // 세션에 등록된 파일 리스트
		$strEditorDir = "community/{$strBCodeLower}";
//		print_r($_SESSION);

		## 체크
		if(!$strLang):
			echo "언어 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;
		if(!$strBCode):
			echo "게시판 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;

		## 커뮤니티 설정 파일
		/* 수정전
		include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
		$aryBoardInfoS = $BOARD_INFO[$strBCode];
		foreach($aryBoardInfoS as $key => $data):
			$strTemp = $aryBoardInfo[$key];
			if($strTemp) { continue; }
			$aryBoardInfo[$key] = $data;
		endforeach;
		*/
		if(is_file("{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}"))
		{
			include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
		}elseif(is_file("{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}"))
		{
			include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
		}else{

		}
		$aryBoardInfo = $BOARD_INFO[$strBCode];

		$strB_NAME = $aryBoardInfo['B_NAME']; // 커뮤니티 이름
		$strBI_DATALIST_ORDERBY = $aryBoardInfo['BI_DATALIST_ORDERBY']; // 리스트 정렬 설정
		$aryBI_DATALIST_FIELD_USE = $aryBoardInfo['BI_DATALIST_FIELD_USE']; // 목록항목
		$strBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
		$strBI_CATEGORY_USE = $aryBoardInfo['BI_CATEGORY_USE']; // 카테고리 사용유무
		$strBI_DATAWRITE_LOCK_USE = $aryBoardInfo['BI_DATAWRITE_LOCK_USE']; // 비밀글 사용 - 사용자선택 = C, 무조건 = E
		$strBI_DATAWRITE_FORM = $aryBoardInfo['BI_DATAWRITE_FORM']; // 글쓰기 폼 설정
		$intBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
		$aryBI_ATTACHEDFILE_NAME = $aryBoardInfo['BI_ATTACHEDFILE_NAME']; // 첨부파일 이름
		$aryBI_ATTACHEDFILE_KEY = $aryBoardInfo['BI_ATTACHEDFILE_KEY']; // 첨부파일 키

		## 커뮤니티 카테고리 설정 파일
		include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
		$aryCategoryList = $CATEGORY_LIST;

		## 목록 설정
		$aryColumn = "";
		$aryColumn[] = "제목";
		if($aryBI_DATALIST_FIELD_USE[0] == "Y") { $aryColumn[] = "번호"; }
		if($aryBI_DATALIST_FIELD_USE[1] == "Y") { $aryColumn[] = "작성자"; }
		if($aryBI_DATALIST_FIELD_USE[2] == "Y") { $aryColumn[] = "등록일"; }
		if($aryBI_DATALIST_FIELD_USE[3] == "Y") { $aryColumn[] = "조회수"; }
		if($aryBI_DATALIST_FIELD_USE[4] == "Y") { $aryColumn[] = "점수"; }
		if($aryBI_DATALIST_FIELD_USE[5] == "Y") { $aryColumn[] = "카테고리"; }
		if($aryBI_DATALIST_FIELD_USE[6] == "Y") { $aryColumn[] = "리스트이미지"; }
		if($aryBI_DATALIST_FIELD_USE[7] == "Y") { $aryColumn[] = "상품이미지"; }

		## 정렬 설정
		$strOrderBy							= $strBI_DATALIST_ORDERBY;
		if(!$strOrderBy) { $strOrderBy = "defaultDesc"; }

		## 상품 이미지 join 설정
		$strProductImgJoin = "";
		if(in_array("상품이미지", $aryColumn)) { $strProductImgJoin = "Y"; }

		## 첨부파일 join 설정
//		$strAttchedfile = "";
//		if($strBI_ATTACHEDFILE_USE) { $strAttchedfile = "Y"; }

		## 비밀글 설정
//		$isLock = false;
//		if(in_array($strBI_DATAWRITE_LOCK_USE, array("C","E"))) { $isLock = true; }

		## 공지사항 설정
//		$isNotice = false;
//		if(in_array($strMemberGroup, array("001"))) { $isNotice = true; } // 관리자그룹(001)

		## 카테고리 사용 유무 설정
		## 글쓰기설정
		if($strBI_CATEGORY_USE == "Y") {  $aryColumn[] = "카테고리"; }

		## 카테고리 리스트 불러오기
		if(in_array("카테고리", $aryColumn)):

			## 불러오기
			include MALL_SHOP . "/upload/community/category/{$strLang}/category.{$strBCode}.info.php";
			$aryCategoryList = $CATEGORY_LIST;
		endif;
	
		## 첨부파일 사용유무
		$isFile = true;
		if(!$intBI_ATTACHEDFILE_USE) { $isFile = false; }

	break;

	case "dataList":
		// 게시판 리스트
	
		## 모듈 설정
		$objBoardDataModule = new BoardDataModule($db);

		## 기본 설정
		$intPage = $_GET['page'];
		$strBCode = $_GET['b_code'];
		$strLang = $_GET['lang'];
		//$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		//
		$strLangS = $strAdmSiteLng; // 시작 언어(기준언어)
		if(!$strLang) { $strLang = $strLangS; }
		$strLangLower = strtolower($strLang);
		$strCommunityConfDir = MALL_SHOP . "/conf/community";
		$strCommunityConfFile = "board.{$strBCode}.info.php"; 
		$strCommunityCateDir = MALL_SHOP . "/conf/community/category/{$strLangLower}";
		$strCommunityCateFile = "category.{$strBCode}.info.php"; 
		$arySessionFileList = $_SESSION['FILE']; // 세션에 등록된 파일 리스트

		## 체크
		if(!$strLang):
			echo "언어 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;
		if(!$strBCode):
			echo "게시판 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;

		## 커뮤니티 설정 파일
		if(is_file("{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}"))
		{
			include_once "{$strCommunityConfDir}/{$strLangLower}/{$strCommunityConfFile}";
		}elseif(is_file("{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}"))
		{
			include_once "{$strCommunityConfDir}/{$strLangSLower}/{$strCommunityConfFile}";
		}else{

		}
		$aryBoardInfo = $BOARD_INFO[$strBCode];
		$strB_NAME = $aryBoardInfo['B_NAME']; // 커뮤니티 이름
		$strBI_DATALIST_ORDERBY = $aryBoardInfo['BI_DATALIST_ORDERBY']; // 리스트 정렬 설정
		$aryBI_DATALIST_FIELD_USE = $aryBoardInfo['BI_DATALIST_FIELD_USE']; // 목록항목
		$strBI_ATTACHEDFILE_USE = $aryBoardInfo['BI_ATTACHEDFILE_USE']; // 첨부파일 사용유무
		$strBI_DATADELETE_AFTER = $aryBoardInfo['BI_DATADELETE_AFTER']; // 삭제후설정

		## 커뮤니티 카테고리 설정 파일
		@include_once "{$strCommunityCateDir}/{$strCommunityCateFile}";
		$aryCategoryList = $CATEGORY_LIST;

		## 목록 설정
		$aryColumn = "";
		$aryColumn[] = "제목";
		if($aryBI_DATALIST_FIELD_USE[0] == "Y") { $aryColumn[] = "번호"; }
		if($aryBI_DATALIST_FIELD_USE[1] == "Y") { $aryColumn[] = "작성자"; }
		if($aryBI_DATALIST_FIELD_USE[2] == "Y") { $aryColumn[] = "등록일"; }
		if($aryBI_DATALIST_FIELD_USE[3] == "Y") { $aryColumn[] = "조회수"; }
		if($aryBI_DATALIST_FIELD_USE[4] == "Y") { $aryColumn[] = "점수"; }
		if($aryBI_DATALIST_FIELD_USE[5] == "Y") { $aryColumn[] = "카테고리"; }
		if($aryBI_DATALIST_FIELD_USE[6] == "Y") { $aryColumn[] = "리스트이미지"; }
		if($aryBI_DATALIST_FIELD_USE[7] == "Y") { $aryColumn[] = "상품이미지"; }

		## 정렬 설정
		$strOrderBy							= $strBI_DATALIST_ORDERBY;
		if(!$strOrderBy) { $strOrderBy = "defaultDesc"; }

		## 상품 이미지 join 설정
		$strProductImgJoin = "";
		if(in_array("상품이미지", $aryColumn)) { $strProductImgJoin = "Y"; }

		## 첨부파일 join 설정
		$strAttchedfile = "";
		if($strBI_ATTACHEDFILE_USE) { $strAttchedfile = "Y"; }

		## 삭제된 데이터 숨김 처리
		$strUbDelNot = "";
		if($strBI_DATADELETE_AFTER == "hide") { $strUbDelNot = "Y"; }

		## 데이터 불러오기
		$param								= "";
		$param['B_CODE']					= $strBCode;
//		$param['UB_LNG']					= $strLang;
		$param['UB_LNG_IN'][]				= $strLang;
		$param['UB_LNG_IN'][]				= "--";
		$param['UB_DEL_NOT']				= $strUbDelNot;
//		$param['UB_ANS_DEPTH']				= $intUbAnsDepth;
//		$param['UB_P_CODE']					= $strPCode;
//		$param['UB_ANS_M_NO']				= $intAnsMemberNo;

		## CRM 버튼 설정 	 dataList
		$isBtnUseCrn = true;
		//if(!$intUB_M_NO) { $isBtnUseCrn = false; } /* 회원글이 아닌 경우 */
		if($a_admin_type != "A") {  $isBtnUseCrn = false; } /*최고 관리자가 아닌경우 숨김 처리 */

		//입점사공지사항이 아닐 때 입점사는 자신의 글만 보기. S:입점사 A:운영사 남덕희
		if($a_admin_type=='S'){
			if($strBCode !='S_NOTICE'){
				//$param['UB_ANS_M_NO']				= $a_admin_no;
				$param['UB_SHOP_NO']				= $a_admin_shop_no;
				$param['UB_P_CODE']					= $strPCode;
			}else{

			}
		}

		$param['searchKey']					= $arySearchKey;
		$param['searchVal']					= $strSearchVal;
//		$param['UB_SHOP_NO']				= $a_admin_shop_no;
		$intTotal							= $objBoardDataModule->getBoardDataSelectEx2("OP_COUNT", $param);				// 데이터 전체 개수
		$intPageLine						= ( $intPageLine )		? $intPageLine	: 10;									// 리스트 개수
		$intPage							= ( $intPage )			? $intPage		: 1;
		$intFirst							= ( $intTotal == 0 )	? 0				: $intPageLine * ( $intPage - 1 );

		$param['JOIN_MM']					= "Y";
		$param['JOIN_FL']					= $strAttchedfile;
		$param['JOIN_PM']					= $strProductImgJoin;
		$param['ORDER_BY']					= $strOrderBy;
		$param['LIMIT']						= "{$intFirst},{$intPageLine}";
		$resResult							= $objBoardDataModule->getBoardDataSelectEx2("OP_LIST", $param);
		$intPageBlock						= 10;															// 블럭 개수 
		$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
		$intTotPage							= ceil( $intTotal / $intPageLine );
//		echo $db->query;

		## paging 설정
		$intPage			= $intPage;									// 현재 페이지
		$intTotPage			= $intTotPage;								// 전체 페이지 수
		$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
		$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
		$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
		$intNextBlock		= ($intBlock * $intPageBlock) + 1;			// 다음 블럭
		$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
		$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점

		if($intFirstBlock <= 0) { $intFirstBlock = 1; }
		if($intPrevBlock  <= 0) { $intPrevBlock	= 1; }
		if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
		if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

		## 페이지 시작/마지막 번호 설정
		$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
		$intLastNo			= $intPage * $intPageLine;
		if(!$intFirstNo) { $intFirstNo = ""; }
		if($intLastNo > $intTotal) { $intLastNo = $intTotal; }



	break;

	endswitch;