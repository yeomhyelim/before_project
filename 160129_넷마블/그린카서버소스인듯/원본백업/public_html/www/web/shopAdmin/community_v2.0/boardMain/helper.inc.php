<?php

	switch($strMode):
	case "boardNonList":
		// 운영정지 게시판

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);

		## 기본설정
		$intPage = $_GET['page'];

		## 데이터 불러오기
		$param							= "";
		$param['B_USE']					= "N";
		$intTotal						= $objBoardMgrNewModule->getBoardDataSelectEx2("OP_COUNT", $param);				// 데이터 전체 개수
		$intPageLine					= ( $intPageLine )		? $intPageLine	: 10;										// 리스트 개수
		$intPage						= ( $intPage )			? $intPage		: 1;
		$intFirst						= ( $intTotal == 0 )		? 0					: $intPageLine * ( $intPage - 1 );

		$param['ORDER_BY']				= $strOrderBy;
		$param['LIMIT']					= "{$intFirst},{$intPageLine}";
		$resResult						= $objBoardMgrNewModule->getBoardDataSelectEx2("OP_LIST", $param);
		$intPageBlock					= 10;																	// 블럭 개수
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );									// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );
//		echo $db->query;

		## paging 설정
		$intPage			= $intPage;									// 현재 페이지
		$intTotPage			= $intTotPage;								// 전체 페이지 수
		$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
		$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
		$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
		$intNextBlock		= ($intBlock * $intPageBlock) + 1;		// 다음 블럭
		$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
		$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점
		if($intFirstBlock <= 0) { $intFirstBlock	= 1; }
		if($intPrevBlock  <= 0) { $intPrevBlock		= 1; }
		if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
		if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

		## 페이지 시작/마지막 번호 설정
		$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
		$intLastNo			= $intPage * $intPageLine;
		if(!$intFirstNo) { $intFirstNo = ""; }
		if($intLastNo > $intTotal) { $intLastNo = $intTotal; }


	break;

	case "boardList":
		// 커뮤니티 리스트

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);

		## 기본설정
		$intPage = $_GET['page'];
		$strSearchGroup = $_GET['searchGroup'];
		$strSearchKey = $_GET['searchKey'];
		$strSearchVal = $_GET['searchVal'];
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangSLower = strtolower($strLangS);
//		$strWebDir = "/upload/community/group";
//		$strDefaultDir = MALL_SHOP . $strWebDir;

		## 그룹 리스트 불러오기
		include_once MALL_SHOP . "conf/community/{$strLangSLower}/groupList.info.php";

		## 데이터 불러오기
		$param							= "";
		$param['B_USE']					= "Y";
		$param['B_BG_NO']				= $strSearchGroup;
		$param['searchKey']				= $strSearchKey;
		$param['searchVal']				= $strSearchVal;
		$intTotal						= $objBoardMgrNewModule->getBoardDataSelectEx2("OP_COUNT", $param);				// 데이터 전체 개수
		$intPageLine					= ( $intPageLine )		? $intPageLine	: 10;										// 리스트 개수
		$intPage						= ( $intPage )			? $intPage		: 1;
		$intFirst						= ( $intTotal == 0 )		? 0					: $intPageLine * ( $intPage - 1 );

		$param['ORDER_BY']				= $strOrderBy;
		$param['LIMIT']					= "{$intFirst},{$intPageLine}";
		$resResult						= $objBoardMgrNewModule->getBoardDataSelectEx2("OP_LIST", $param);
		$intPageBlock					= 10;																	// 블럭 개수
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );									// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );
//		echo $db->query;

		## paging 설정
		$intPage			= $intPage;									// 현재 페이지
		$intTotPage			= $intTotPage;								// 전체 페이지 수
		$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
		$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
		$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
		$intNextBlock		= ($intBlock * $intPageBlock) + 1;		// 다음 블럭
		$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
		$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점
		if($intFirstBlock <= 0) { $intFirstBlock	= 1; }
		if($intPrevBlock  <= 0) { $intPrevBlock		= 1; }
		if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
		if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

		## 페이지 시작/마지막 번호 설정
		$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
		$intLastNo			= $intPage * $intPageLine;
		if(!$intFirstNo) { $intFirstNo = ""; }
		if($intLastNo > $intTotal) { $intLastNo = $intTotal; }


	break;

	case "boardModifyScript":
		// HTML 편집

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);
		$objBoardCategoryModule = new BoardCategoryModule($db);

		## 기본 설정
		$strBCode = $_GET['b_code'];
		$strLang = $_GET['lang'];
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strScriptDir = MALL_SHOP . "/layout/html/community/{$strLangLower}";
		$strScriptFile = "board.{$strBCode}.script.php";
		$strScriptTagFile = "board.{$strBCode}.script.tag.php";
		$aryData = "";

		## 체크
		if(!$strLang):
			echo "언어 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;
		if(!$strBCode):
			echo "게시판 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;

		## 커뮤니티 기본 정보 불러오기.
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['B_USE'] = "Y";
		$aryBoardDataRow = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_SELECT", $param);
		$aryData['B_NAME'] = $aryBoardDataRow['B_NAME'];

		## SKIN 파일에 적용할 내용 설정
		$strB_NAME = $aryData['B_NAME'];

		## 스크립트 파일이 없으면, default 형태로 변경
		if(!is_file("{$strScriptDir}/{$strScriptFile}")):

			## 예약어 설정
			$aryTag['{{__커뮤니티본문__}}'] = "<?php include \$includeFile;?>";

			## 폴더 생성
			if(!FileDevice::makeFolder($strScriptDir)):
				echo "스크립트 폴더를 생성할수 없습니다. 관리자에게 문의하세요.";
				return;
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

	break;

	case "boardModifyCategory":
		// 카테고리 설정

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);
		$objBoardCategoryModule = new BoardCategoryModule($db);

		## 기본 설정
		$strBCode = $_GET['b_code'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$aryData = "";
		$strDisabled = ""; // 기준어어와 다르면, 사용자가 수정 못하도록 disabled 합니다.
		$strWebDir = "/upload/community/category";
		$strOrderBy = "sortAsc";

		## 체크
		if(!$strLang):
			echo "언어 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;
		if(!$strBCode):
			echo "게시판 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;

		## 커뮤니티 기본 정보 불러오기.
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['B_USE'] = "Y";
		$aryBoardDataRow = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_SELECT", $param);
		$aryData['B_NAME'] = $aryBoardDataRow['B_NAME'];

		## 체크
		if(!$aryBoardDataRow):
			echo "게시판 정보가 없습니다.";
			return;
		endif;

		## 커뮤니티 추가 정보 불러오기
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strMode;
		$param['BA_LNG'] = $strLangS;
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

		## 기본설정
		$strB_NAME = $aryData['B_NAME'];
		$strBI_CATEGORY_USE = $aryData['BI_CATEGORY_USE'];
		$strBI_CATEGORY_SKIN = $aryData['BI_CATEGORY_SKIN'];
		$strBI_CATEGORY_LIST_USE = $aryData['BI_CATEGORY_LIST_USE'];

		## 기준언어와 다른경우 해당 언어 정보 불러오기
		if($strLang != $strLangS):
			$param = "";
			$param['BA_B_CODE'] = $strBCode;
			$param['BA_MODE'] = $strMode;
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

			## disabled
			$strDisabled = " disabled";
		endif;

		####
		## 카테고리 리스트
		####

		## 데이터 불러오기
		$param							= "";
		$param['BC_B_CODE']				= $strBCode;
		$param['LNG']					= $strLang;
		$intTotal						= $objBoardCategoryModule->getBoardCategorySelectEx("OP_COUNT", $param);			// 데이터 전체 개수
		$intPageLine					= ( $intPageLine )		? $intPageLine	: 10;										// 리스트 개수
		$intPage						= ( $intPage )			? $intPage		: 1;
		$intFirst						= ( $intTotal == 0 )		? 0					: $intPageLine * ( $intPage - 1 );

		$param['ORDER_BY']				= $strOrderBy;
		$param['LIMIT']					= "{$intFirst},{$intPageLine}";
		$resResult						= $objBoardCategoryModule->getBoardCategorySelectEx("OP_LIST", $param);
		$intPageBlock					= $strPageBlock;																	// 블럭 개수
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );									// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );
//		echo $db->query;

		## paging 설정
		$intPage			= $intPage;									// 현재 페이지
		$intTotPage			= $intTotPage;								// 전체 페이지 수
		$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
		$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
		$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
		$intNextBlock		= ($intBlock * $intPageBlock) + 1;		// 다음 블럭
		$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
		$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점
		if($intFirstBlock <= 0) { $intFirstBlock	= 1; }
		if($intPrevBlock  <= 0) { $intPrevBlock		= 1; }
		if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
		if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

		## 페이지 시작/마지막 번호 설정
		$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
		$intLastNo			= $intPage * $intPageLine;
		if(!$intFirstNo) { $intFirstNo = ""; }
		if($intLastNo > $intTotal) { $intLastNo = $intTotal; }

		## 기준언어와 페이지 언어가 같은 경우 삭제가 가능합니다.
		$isDelBtn = false;
		if($strLang == $strLangS) { $isDelBtn = true; }

	break;

	case "boardModifyUserfield":
		// 추가 필드

		## 추가 필드 리스트
		include_once  MALL_HOME . "/config/community.userfield.conf.php";

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);

		## 기본 설정
		$strBCode = $_GET['b_code'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$aryData = "";
		$strDisabled = ""; // 기준어어와 다르면, 사용자가 수정 못하도록 disabled 합니다.

		## 체크
		if(!$strLang):
			echo "언어 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;
		if(!$strBCode):
			echo "게시판 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;

		## 커뮤니티 기본 정보 불러오기.
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['B_USE'] = "Y";
		$aryBoardDataRow = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_SELECT", $param);
		$aryData['B_NAME'] = $aryBoardDataRow['B_NAME'];

		## 체크
		if(!$aryBoardDataRow):
			echo "게시판 정보가 없습니다.";
			return;
		endif;

		## 커뮤니티 추가 정보 불러오기
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strMode;
		$param['BA_LNG'] = $strLangS;
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
			$param['BA_MODE'] = $strMode;
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

			## disabled
			$strDisabled = " disabled";
		endif;

		## 기본설정
		$strB_NAME = $aryData['B_NAME'];
		$strBI_USERFIELD_USE = $aryData['BI_USERFIELD_USE']; // 추가필드 사용유무

	break;

	case "boardModifyBasic":
		// 커뮤니티 기본 설정

		## 모듈 설정
		$objBoardMgrNewModule = new BoardMgrNewModule($db);
		$objBoardInfoMgrModule = new BoardInfoMgrModule($db);

		## 기본 설정
		$strBCode = $_GET['b_code'];
		$strLang = $strStLng;
		$strLangS = $S_ST_LNG; // 시작 언어(기준언어)
		$strLangLower = strtolower($strLang);
		$strLangSLower = strtolower($strLangS);
		$aryData = "";
		$strDisabled = ""; // 기준어어와 다르면, 사용자가 수정 못하도록 disabled 합니다.

		## 그룹 리스트
		include_once  MALL_SHOP . "/conf/community/{$strLangSLower}groupList.info.php";

		## 체크
		if(!$strLang):
			echo "언어 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;
		if(!$strBCode):
			echo "게시판 코드가 없습니다. 관리자에게 문의하세요.";
			return;
		endif;

		## 커뮤니티 기본 정보 불러오기.
		$param = "";
		$param['B_CODE'] = $strBCode;
		$param['B_USE'] = "Y";
		$aryBoardDataRow = $objBoardMgrNewModule->getBoardMgrNewSelectEx("OP_SELECT", $param);
		$aryData['B_NAME'] = $aryBoardDataRow['B_NAME'];
		$aryData['B_KIND'] = $aryBoardDataRow['B_KIND'];
		$aryData['B_SKIN'] = $aryBoardDataRow['B_SKIN'];
		$aryData['B_CSS'] = $aryBoardDataRow['B_CSS'];
		$aryData['B_BG_NO'] = $aryBoardDataRow['B_BG_NO'];
		$intMemberGroupCnt = sizeof($S_MEMBER_GROUP);

		## 체크
		if(!$aryBoardDataRow):
			echo "게시판 정보가 없습니다.";
			return;
		endif;

		## 커뮤니티 추가 정보 불러오기
		$param = "";
		$param['BA_B_CODE'] = $strBCode;
		$param['BA_MODE'] = $strMode;
		$param['BA_LNG'] = $strLangS;
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
			$param['BA_MODE'] = $strMode;
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

			## disabled
			$strDisabled = " disabled";
		endif;

		## 기본설정
		$strB_NAME = $aryData['B_NAME'];
		$intB_BG_NO = $aryData['B_BG_NO'];
		$intB_KIND = $aryData['B_KIND'];
		$intB_SKIN = $aryData['B_SKIN'];
		$strB_CSS = $aryData['B_CSS'];
		$strBI_DATAVIEW_FACEBOOK_USE = $aryData['BI_DATAVIEW_FACEBOOK_USE'];
		$strBI_DATAVIEW_TWITTER_USE = $aryData['BI_DATAVIEW_TWITTER_USE'];
		$intBI_DATALIST_TITLE_LEN = $aryData['BI_DATALIST_TITLE_LEN'];
		$strBI_DATALIST_FIELD_USE_0 = $aryData['BI_DATALIST_FIELD_USE_0']; // 번호
		$strBI_DATALIST_FIELD_USE_1 = $aryData['BI_DATALIST_FIELD_USE_1']; // 작성자
		$strBI_DATALIST_FIELD_USE_2 = $aryData['BI_DATALIST_FIELD_USE_2']; // 등록일
		$strBI_DATALIST_FIELD_USE_3 = $aryData['BI_DATALIST_FIELD_USE_3']; // 조회수
		$strBI_DATALIST_FIELD_USE_4 = $aryData['BI_DATALIST_FIELD_USE_4']; // 점수
		$strBI_DATALIST_FIELD_USE_5 = $aryData['BI_DATALIST_FIELD_USE_5']; // 카테고리
		$strBI_DATALIST_FIELD_USE_6 = $aryData['BI_DATALIST_FIELD_USE_6']; // 리스트 이미지
		$strBI_DATALIST_FIELD_USE_7 = $aryData['BI_DATALIST_FIELD_USE_7']; // 상품 이미지
		$strBI_DATALIST_WRITER_SHOW_0 = $aryData['BI_DATALIST_WRITER_SHOW_0']; // 성명
		$strBI_DATALIST_WRITER_SHOW_1 = $aryData['BI_DATALIST_WRITER_SHOW_1']; // 아이디
		$strBI_DATALIST_WRITER_SHOW_2 = $aryData['BI_DATALIST_WRITER_SHOW_2']; // 닉네임
		$intBI_DATALIST_WRITER_HIDDEN = $aryData['BI_DATALIST_WRITER_HIDDEN']; // 작성자명 자리수 이후 ***표시
		$strBI_DATALIST_ORDERBY = $aryData['BI_DATALIST_ORDERBY']; // 리스트 정렬 설정
		$strBI_START_MODE = $aryData['BI_START_MODE']; // 시작페이지
		$strBI_DATAWRITE_END_MOVE = $aryData['BI_DATAWRITE_END_MOVE']; // 글쓰기후이동
		$strBI_DATALIST_USE = $aryData['BI_DATALIST_USE']; // 목록권한(A:모든회원/비회원, M:회원전용)
		$strBI_DATAVIEW_USE = $aryData['BI_DATAVIEW_USE']; // 글보기권한(A:모든회원/비회원, M:회원전용)
		$strBI_DATAWRITE_USE = $aryData['BI_DATAWRITE_USE']; // 글쓰기권한(A:모든회원/비회원, M:회원전용)
		$strBI_DATAANSWER_USE = $aryData['BI_DATAANSWER_USE']; // 답변권한(A:모든회원/비회원, M:회원전용)
		$strBI_COMMENT_USE = $aryData['BI_COMMENT_USE']; // 댓글권한(A:모든회원/비회원, M:회원전용)
		$strBI_DATAVIEW_NEXTPRVE_USE = $aryData['BI_DATAVIEW_NEXTPRVE_USE']; // 글보기 네비게이션
		$strBI_DATAWRITE_LOCK_USE = $aryData['BI_DATAWRITE_LOCK_USE']; // 비밀글기능
		$strBI_DATAWRITE_FORM = $aryData['BI_DATAWRITE_FORM']; // 에디터사용
		$strBI_ADMIN_MAIN_SHOW = $aryData['BI_ADMIN_MAIN_SHOW']; // 관리자 메인화면 표시 여부
		$intBI_ADMIN_MAIN_SORT = $aryData['BI_ADMIN_MAIN_SORT']; // 관리자 메인화면 표시 여부 - 순위
		$intBI_ATTACHEDFILE_USE = $aryData['BI_ATTACHEDFILE_USE']; // 첨부파일(0=사용안함, 최대 5개)
		$strBI_SMS_USE = $aryData['BI_SMS_USE']; // SMS 사용 유무
		$strBI_SMS_HP_LIST = $aryData['BI_SMS_HP_LIST']; // SMS 받을 사람 연락처
		$strBI_SMS_TEXT = $aryData['BI_SMS_TEXT']; // SMS 문자
		$intBI_COLUMN_DEFAULT = $aryData['BI_COLUMN_DEFAULT']; // 목록수(칸)
		$intBI_LIST_DEFAULT = $aryData['BI_LIST_DEFAULT']; // 목록수(라인)
		$strBI_DATADELETE_AFTER = $aryData['BI_DATADELETE_AFTER']; // 삭제후 삭제글 설정(hide=숨김, text=삭제된 글입니다.)

		## 그룹별 권한 설정
		for($i=0;$i<$intMemberGroupCnt;$i++):
			$aryBI_DATALIST_MEMBER_AUTH[] = $aryData["BI_DATALIST_MEMBER_AUTH_{$i}"]; // 목록 그룹권한
			$aryBI_DATAVIEW_MEMBER_AUTH[] = $aryData["BI_DATAVIEW_MEMBER_AUTH_{$i}"]; // 글보기 그룹권한
			$aryBI_DATAWRITE_MEMBER_AUTH[] = $aryData["BI_DATAWRITE_MEMBER_AUTH_{$i}"]; // 글쓰기 그룹권한
			$aryBI_DATAANSWER_MEMBER_AUTH[] = $aryData["BI_DATAANSWER_MEMBER_AUTH_{$i}"]; // 답변 그룹권한
			$aryBI_COMMENT_MEMBER_AUTH[] = $aryData["BI_COMMENT_MEMBER_AUTH_{$i}"]; // 댓글 그룹권한
		endfor;

//		print_r($aryData);

		## 파일명 설정
		for($i=0;$i<5;$i++):
			$aryBI_ATTACHEDFILE_NAME[] = $aryData["BI_ATTACHEDFILE_NAME_{$i}"]; // 파일명
			$aryBI_ATTACHEDFILE_KEY[] = $aryData["BI_ATTACHEDFILE_KEY_{$i}"];  // 파일 옵션
		endfor;

		## SMS 받는 사람 연락처 설정
		$aryBI_SMS_HP_LIST = explode(",", $strBI_SMS_HP_LIST);

		## 스킨 설정
		$strB_KIND_SKIN = "";
		if($intB_KIND && $intB_SKIN) { $strB_KIND_SKIN = "{$intB_KIND}_{$intB_SKIN}"; }

		## 목록수 칸/라인 설정
		$strListCntColumnHide = "";
		if($strB_KIND_SKIN != "data_gallery") { $strListCntColumnHide = " hide"; }

		## 삭제글 설정
		if(!$strBI_DATADELETE_AFTER) { $strBI_DATADELETE_AFTER = "hide"; }

	break;

	endswitch;