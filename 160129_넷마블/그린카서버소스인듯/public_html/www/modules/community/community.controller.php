<?php
    /**
     * /home/shop_eng/www/modules/community/community.controller.php
     * @author eumshop(thav@naver.com)
     * community controller class
     * **/

	require_once MALL_HOME . "/modules/controller.php";

    class  CommunityController extends Controller {

		function getMessage() {
			echo "community controller class";
		}

		function getPointUpdate() {
			return $this->module->{"get{$this->name}PointUpdate"}();
		}

		function getCouponUpdate() {
			return $this->module->{"get{$this->name}CouponUpdate"}();
		}

		/**
		 * getBoardInfoKeyDefine($act)
		 * 커뮤니티 $act 호출에 따른 info 정보
		 * **/
		function getBoardInfoKeyDefine($act) {
			$aryBoardInfo['boardWrite']					= 	array(	"B_CODE"						=> "커뮤니티 코드",
																	"B_NO"							=> "커뮤니티 번호",
																	"B_NAME"						=> "커뮤니티 이름",
																	"B_GRP_NO"						=> "커뮤니티 그룹 번호",
																	"B_KIND"						=> "커뮤니티 종류",
																	"B_SKIN"						=> "커뮤니티 스킨",
																	"B_CSS"							=> "커뮤니티 CSS"				);

			$aryBoardInfo['boardModifyBasic']			= 	array(	"BI_START_MODE"					=> "커뮤니티 시작 페이지(list,view,write)",
																	"BI_ADMIN_NICKNAME"				=> "커뮤니티 관리자 명칭 ",
																	"BI_COMMENT_USE"				=> "커뮤니티 코멘트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
																	"BI_COMMENT_MEMBER_AUTH"		=> "커뮤니티 코멘트 사용 권한(일반회원, 관리자회원, 공급사회원)",				"BI_DATALIST_USE"				=> "커뮤니티 리스트 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
																	"BI_DATALIST_MEMBER_AUTH"		=> "커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)",
																	"BI_COLUMN_DEFAULT"				=> "세로줄 수",
																	"BI_LIST_DEFAULT"				=> "리스트 수",
																	"BI_PAGE_DEFAULT"				=> "페이지 수",
																	"BI_DATALIST_ORDERBY"			=> "리스트 정렬 설정(등록날짜오름차순, 등록날짜내림차순...)",
																	"BI_DATALIST_FIELD_USE"			=> "커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3,점수=4)",
																	"BI_DATALIST_WRITER_SHOW"		=> "커뮤니티 리스트 작성자 표시 방법([0]=성명,[1]=아이디)",
																	"BI_DATALIST_WRITER_HIDDEN"		=> "커뮤니티 리스트 작성자 부분 숨김(갯수)",									"BI_DATAVIEW_USE"				=> "커뮤니티 보기 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
																	"BI_DATAVIEW_MEMBER_AUTH"		=> "커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)",
																	"BI_DATAVIEW_TWITTER_USE"		=> "트위터 사용",
																	"BI_DATAVIEW_FACEBOOK_USE"		=> "페이스북 사용",
																	"BI_DATAVIEW_M2DAY_USE"			=> "미투데이",
																	"BI_DATAWRITE_USE"				=> "커뮤니티 쓰기/수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
																	"BI_DATAWRITE_MEMBER_AUTH"		=> "커뮤니티 보기 사용 권한(일반회원, 관리자회원, 공급사회원)",
																	"BI_DATAWRITE_NOTICE_USE"		=> "공지글 사용(사용=Y, 사용안함=N)",
																	"BI_DATAWRITE_LOCK_USE"			=> "비밀글 사용(사용자선택=C.무조건=E,사용안함=N or '')",
																	"BI_DATAWRITE_FORM"				=> "글쓰기 폼(텍스트폼=textWrite, 에디터폼=editWrite)",
																	"BI_DATAWRITE_ICON_USE"			=> "아이콘(사용=Y, 사용안함=N)",
																	"BI_DATAWRITE_END_MOVE"			=> "글쓰기 완료 후, 이동경로(목록화면, 글쓰기화면, 상세보기화면)",
																	"BI_DATADELETE_USE"				=> "커뮤니티 삭제/기타 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
																	"BI_DATADELETE_MEMBER_AUTH"		=> "커뮤니티 삭제 사용 권한(일반회원, 관리자회원, 공급사회원)",
																	"BI_DATAMODIFY_USE"				=> "커뮤니티 수정 사용(사용=Y, 모든회원/비회원=A, 회원전용=M)",
																	"BI_DATAMODIFY_MEMBER_AUTH"		=> "커뮤니티 수정 사용 권한(일반회원, 관리자회원, 공급사회원)",
																	"BI_ATTACHEDFILE_USE"			=> "커뮤니티 첨부파일 사용(사용=1/2/3/4..., 사용안함=0)",
																	"BI_ATTACHEDFILE_NAME"			=> "커뮤니티 첨부파일 이름",
																	"BI_ATTACHEDFILE_KEY"			=> "커뮤니티 첨부파일 키(file, image, movie..)",
																	"BI_DATAANSWER_USE"				=> "커뮤니티 답변 사용(사용=Y, 모든회원/비회원=A, 회원전용=M, 사용안함=N)",
																	"BI_DATAANSWER_MEMBER_AUTH"		=> "커뮤니티 답변 사용 권한(일반회원, 관리자회원, 공급사회원)",
																	"BI_DATALIST_TITLE_LEN"			=> "커뮤니티 리스트 타이틀 자리수",
																	"BI_DATAVIEW_NEXTPRVE_USE"		=> "커뮤니티 보기에서 다음/이전 리스트 사용(사용=Y, 사용안함=N)",
																	"BI_ADMIN_MAIN_SHOW"			=> "커뮤니티 관리자 메인화면 표시 여부(사용=Y, 사용안함=N)",
																	"BI_ADMIN_MAIN_SORT"			=> "커뮤니티 관리자 메인화면 순위(정렬)",
																	"BI_SMS_USE"					=> "SMS 사용 유무",
																	"BI_SMS_HP_LIST"				=> "SMS 연락처 리스트",
																	"BI_SMS_TEXT"					=> "SMS 텍스트"					);

			$aryBoardInfo['boardModifyCategory']		= 	array(	"BI_CATEGORY_USE"				=> "카테고리 사용(사용(전체사용자)=Y, 사용(관리자만)=A, 사용안함=N)",
																	"BI_CATEGORY_SKIN"				=> "카테고리 스킨(텍스트=text, 이미지=image, 콤보박스=combobox)",
																	"BI_CATEGORY_LIST_USE"			=> "리스트 화면 상단에 카테고리 사용(사용=Y, 사용안함=N)",						);

			$aryBoardInfo['boardModifyPoint']			= 	array(	"BI_POINT_USE"					=> "포인트사용(사용=Y, 사용안함=N)",
																	"BI_POINT_W_USE"				=> "글쓰기 포인트지급(사용=Y, 사용안함=N)",
																	"BI_POINT_W_GIVE"				=> "글쓰기 포인트지급방법(자동=A, 수동=M, 다중=T)",
																	"BI_COUPON_W_USE"				=> "글쓰기 쿠폰지급사용(사용=Y, 사용안함=N)",
																	"BI_COUPON_W_GIVE"				=> "글쓰기 쿠폰지급방법(자동=A, 수동=M, 다중=T)",
																	"BI_POINT_C_USE"				=> "댓글 포인트지급사용(사용=Y, 사용안함=N)",
																	"BI_POINT_C_GIVE"				=> "댓글 포인트지급방법(자동=A, 수동=M, 다중=T)",
																	"BI_COUPON_C_USE"				=> "댓글 쿠폰지급사용(사용=Y, 사용안함=N)",
																	"BI_COUPON_C_GIVE"				=> "댓글 쿠폰지급방법(자동=A, 수동=M, 다중=T)",
			);

			$aryBoardInfo['boardModifyScriptWidget']	=	array(
																	"BI_WIDGET_COLUMN_DEFAULT"		=> "세로줄 수",
																	"BI_WIDGET_LIST_DEFAULT"		=> "리스트 수",
																	"BI_WIDGET_DATALIST_FIELD_USE"	=> "커뮤니티 리스트 목록 설정(번호=0,작성자=1,등록일=2,조회수=3)",
																	"BI_WIDGET_DATALIST_TITLE_LEN"	=> "WIDGET 타이틀 자리수",
																	"BI_WIDGET_SKIN"				=> "WIDGET SKIN",
																	"BI_WIDGET_DATAWRITE_END_MOVE"	=> "글쓰기 완료 후, 이동경로(닫기, 목록화면)",
																	"BI_WIDGET_ICON_USE"			=> "사용함(Y)으로 설정할 경우, 위젯 리스트를 관리자가 콘트롤 할 수 있다.",
																	"BI_WIDGET_CATEGORY_SHOW"		=> "카테고리 사용 여부(Y:표시,N혹은 null:숨김)",
			);


			$aryBoardInfo['boardModifyUserfield']		=	array(	"BI_USERFIELD_USE"				=> "커뮤니티 추가필드 사용(사용=Y 사용안함=N)",
																	"BI_USERFIELD_FIELD_USE"		=> "커뮤니티 추가필드 필드 사용(사용=Y 사용안함=N)",
																	"BI_USERFIELD_ESSENTIAL"		=> "커뮤니티 추가필드 필수 입력(사용=Y)",
																	"BI_USERFIELD_KIND"				=> "커뮤니티 추가필드 종류(입력박스, 선택박스,...)",
																	"BI_USERFIELD_KIND_NAME"		=> "커뮤니티 추가필드 종류 데이터",
																	"BI_USERFIELD_ONLYADMIN"		=> "커뮤니티 추가필드 관리자 옵션(관리자전용=Y)",
																	"BI_USERFIELD_NAME"				=> "커뮤니티 추가필드 이름",
																	"BI_USERFIELD_SORT"				=> "커뮤니티 추가필드 정렬",			);


			return ($act) ? $aryBoardInfo[$act] : $aryBoardInfo;
		}

		/**
		 * getBoardInfoFile($act)
		 * board_info 파일 저장 및 변경
		 * **/
		function getBoardInfoFileWrite($act) {
			## STEP 2.
			## 데이터 만들기
			$aryBoardInfo		= $this->getBoardInfoKeyDefine($act);
			if(is_array($aryBoardInfo)):
				foreach($aryBoardInfo as $key => $comment):
					$field = $this->field[strtolower($key)];
					if(is_array($field)):
						foreach($field as $fieldKey => $fieldVal):
							$dataTemp	= "";
							$dataTemp	= sprintf("\$BOARD_INFO['%s']['%s'][%d]", $this->field['b_code'], strtolower($key), $fieldKey);
							$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
							$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $fieldVal);
							$dataTemp	= str_pad($dataTemp, 140, " ", STR_PAD_RIGHT);
							$dataTemp	= sprintf("%s // %s", $dataTemp, $comment);
							$data	   .= ($data) ? "\n" : "";
							$data	   .= $dataTemp;
						endforeach;
					else:
						$dataTemp	= "";
						$dataTemp	= sprintf("\$BOARD_INFO['%s']['%s']", $this->field['b_code'], strtolower($key));
						$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
						$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $field);
						$dataTemp	= str_pad($dataTemp, 140, " ", STR_PAD_RIGHT);
						$dataTemp	= sprintf("%s // %s", $dataTemp, $comment);
						$data	   .= ($data) ? "\n" : "";
						$data	   .= $dataTemp;
					endif;
				endforeach;
			endif;

			## STEP 3.
			## 파일 만들기(기존 데이터 업데이트 형)
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/board.{$this->field['b_code']}.info.php";
			$file				= new FileHandler();
			$file->getMadeInfo($fileName, $data, "/*@ {$act} @*/");
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * **/
		function getDropTable($tableName) {
			if(!$tableName) { return; }
//			$tableName		= "BOARD_UB_{$this->field['b_code']}";
			$intTableCnt	= $this->module->getSchemaTableSelect($tableName);
			if($intTableCnt > 0) : // 테이블이 있으면 실행
				$param['tableName'] = $tableName;
				return parent::getDropTable($param);
			endif;
		}

		/**
		 * getAuthCheck(&$row)
		 * $auth['member']	= 0		=> 비회원
		 * $auth['member']	= 1		=>   회원
		 * $auth['check']	= 0		=> 권한 없음
		 * $auth['check']	= 1		=> 권한 있음
		 * 2013.03.25 버전
		 * 2013.04.11 community.view.php 으로 이동
		 * **/
		function getAuthCheck(&$row) {

			if($row['UB_M_NO'])																						{ $auth['member'] = "1"; }
//			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['member'] = "1"; }	// 관리자 로그인을 했다면 1
			else																									{ $auth['member'] = "0"; }

			if($this->field['member_login'] && $row['UB_M_NO'] && $this->field['member_no'] == $row['UB_M_NO'])		{ $auth['check'] = "1"; }	// 회원이 작성한 글과 로그인 한 회원이 같으면 1
			elseif($this->field['ub_pass'] && $row['UB_PASS'] && $this->field['ub_pass'] == $row['UB_PASS']) 		{ $auth['check'] = "1"; }	// 비회원이 작성한 글과 비밀번호가     같으면 1
			elseif($this->field['b_code'] == $_SESSION['b_code'] && $this->field['ub_no'] == $_SESSION['ub_no'])	{ $auth['check'] = "1"; }	// 세션 정보와 작성한 글의 정보가	   같으면 1
//			elseif($this->field['member_login'] && in_array($this->field['member_type'], array("A", "S")))			{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1  /* 2013.04.11 사용자 페이지에서 사용 할 수 없음.*/
			elseif($this->field['member_login'] && $this->field['member_group'] == "001")							{ $auth['check'] = "1"; }	// 관리자 로그인을 했다면 1
			else																									{ $auth['check'] = "0"; }	// 권한이 필요한 경우.

			if($auth['check'] == 0 && $row['UB_ANS_NO'] != $row['UB_NO']):
				$ub_no_bak				= $this->field['ub_no'];
				$this->field['ub_no']	=  $row['UB_ANS_NO'];
				$ansRow = $this->getSelect();
				$this->field['ub_no']	= $ub_no_bak;
				return $this->getAuthCheck($ansRow);	// 재귀호출
			endif;

			return $auth;
		}

		/**
		 * getCommunityView()
		 * 커뮤니티 데이터 뷰 리턴
		 * **/
		function getCommunityView() {
			if     ($this->field['BOARD_INFO']['b_kind'] =="data")		{ return  new CommunityDataView($this->db,  $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "event")	{ return  new CommunityEventView($this->db, $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "talk")		{ return  new CommunityTalkView($this->db, $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityProductView($this->db, $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "mypage")	{ return  new CommunityMypageView($this->db, $this->field); }
		}

		/**
		 * getCommunityController()
		 * 커뮤니티 데이터 뷰 리턴
		 * **/
		function getCommunityController() {
			if     ($this->field['BOARD_INFO']['b_kind'] =="data")		{ return  new CommunityDataController($this->db,  $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "event")	{ return  new CommunityEventController($this->db, $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "talk")		{ return  new CommunityTalkController($this->db, $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityProductController($this->db, $this->field); }
			else if($this->field['BOARD_INFO']['b_kind'] == "mypage")	{ return  new CommunityMypageController($this->db, $this->field); }
		}
    }
?>
