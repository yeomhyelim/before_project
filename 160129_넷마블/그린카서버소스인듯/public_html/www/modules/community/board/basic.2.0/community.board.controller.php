<?php
    /**
     * /home/shop_eng/www/modules/community/board/basic.2.0/community.board.controller.php
     * @author eumshop(thav@naver.com)
     * community board controller class (basic.2.0)
     * **/

	require_once MALL_HOME . "/modules/community/board/basic.2.0/community.board.controller.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.2.0/community.boardInfo.controller.php";
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.controller.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.controller.php";
	require_once MALL_HOME . "/modules/community/category/basic.1.0/community.category.controller.php";

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.controller.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.controller.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.controller.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.controller.php";
	require_once MALL_HOME . "/modules/community/mypage/basic.1.0/community.mypage.controller.php";

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.view.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.view.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.view.php";

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.module.php";
	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.view.php";
	require_once MALL_HOME . "/classes/file/file.handler.class.php";

    class CommunityBoardController extends CommunityController {

		function __construct(&$db, &$field) {
			$this->module	= new CommunityBoardModule($db, $field);
			$this->name		="BoardMgr";
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community board controller class (basic.2.0)";
		}
		
		/**
		 * getModifyProcess()
		 * 데이터 수정 프로세스
		 * 2013.04.07 추가된 코드
		 * **/		
		function getModifyProcess() {

			## STEP 1.
			## 데이터 수정
			$this->getModify();	

			## STEP 1.
			## 추가 정보 수정
			$boardInfoController		= new CommunityBoardInfoController($this->db, $this->field);
			$boardInfoController->getWriteModify();	
			
			## STEP 3.
			## 코멘트 테이블 생성(사용시..)
			## 2013.05.10 일반 코멘트, 커뮤니티 코멘트 구분함.
			if($this->field['b_kind'] == "event"):
			$commentController		= new CommunityEventCommentController($this->db, $this->field);
			$commentController->getCreateTable();
			else:
			$commentController		= new CommunityCommentController($this->db, $this->field);
			$commentController->getCreateTable();
			endif;

			## STEP 8.
			## 커뮤니티 첨부파일 테이블 생성(사용시..)
			$attachedfileController		= new CommunityAttachedfileController($this->db, $this->field);
			$attachedfileController->getCreateTable();	
		}

		/**
		 * getDropProcess()
		 * 데이터 삭제 프로세스
		 * 2013.04.07 추가된 코드
		 * **/		
		function getDropProcess() {

			## STEP 1.
			## 데이터 테이블 내용 체크 - BOARD_UB_{tableName}
			## 1개 이상의 데이터가 존재 한다면, 테이블을 삭제 할 수 없습니다.
			$boardCnt = $this->module->getSchemaTableSelect("BOARD_UB_{$this->field['b_code']}");
			if($boardCnt):
				if     ($this->field['b_kind'] == "data")		{ $dataView = new CommunityDataView($this->db, $this->field);		}
				else if($this->field['b_kind'] == "event")		{ $dataView = new CommunityEventView($this->db, $this->field);		}
				else if($this->field['b_kind'] == "talk")		{ $dataView = new CommunityTalkView($this->db, $this->field);		}
				else if($this->field['b_kind'] == "product")	{ $dataView = new CommunityProductView($this->db, $this->field);	}
				else if($this->field['b_kind'] == "myPage")		{ $dataView= new CommunityMypageView($this->db, $this->field);		}
				$dataResult = $dataView->getCountTotalEx();
				if($dataResult>0):
					$_POST['act'] = "boardDropCount";
					return; 
				endif;
			endif;

			## STEP 1.
			## 파일 테이블 및 폴더 삭제 - BOARD_FL_{tableName}
			$attachedfileController	= new CommunityAttachedfileController($this->db, $this->field);
			$attachedfileController->getDropTable("BOARD_FL_{$this->field['b_code']}");
			$attachedfileController->getDropDirectory();

			## STEP 2.
			## 코멘트 테이블 및 폴더 삭제 - BOARD_CM_{tableName}	
			## 2013.05.10 일반 코멘트, 커뮤니티 코멘트 구분함.
			if($this->field['b_kind'] == "event"):
			$commentController		= new CommunityEventCommentController($this->db, $this->field);
			$commentController->getDropTable("BOARD_CM_{$this->field['b_code']}");
			else:
			$commentController		= new CommunityCommentController($this->db, $this->field);
			$commentController->getDropTable("BOARD_CM_{$this->field['b_code']}");
			endif;			


			## STEP 3.
			## 데이터 테이블 및 폴더 삭제 - BOARD_UB_{tableName}	
			if     ($this->field['b_kind'] =="data")		{ $dataController= new CommunityDataController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "event")		{ $dataController= new CommunityEventController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "talk")		{ $dataController= new CommunityTalkController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "product")	{ $dataController= new CommunityProductController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "mypage")		{ $dataController= new CommunityDataController($this->db, $this->field);;	}
			$dataController->getDropTable("BOARD_UB_{$this->field['b_code']}");

			## STEP 4.
			## 추가필드 테이블 및 폴더 삭제 - BOARD_AD_{tableName}	
			$userfieldController = new CommunityUserfieldController($this->db, $this->field);
			$userfieldController->getDropTable("BOARD_AD_{$this->field['b_code']}");

			## STEP 5.
			## 카테고리 데이터 내용 삭제 및 파일 삭제 - BOARD_CATEGORY
			$this->field['bc_b_code'] = $this->field['b_code'];
			$categoryController = new CommunityCategoryController($this->db, $this->field);
			$categoryController->getDeleteCode();
			$categoryController->getDeleteFile();

			## STEP 6.
			## 커뮤니티 추가 정보 삭제 BOARD_ADD
			$this->field['ba_b_code'] = $this->field['b_code'];
			$boardInfoController = new CommunityBoardInfoController($this->db, $this->field);
			$boardInfoController->getDeleteCode();

			## STEP 7.
			## 커뮤니티 정보 삭제 BOARD_MGR_NEW
			$this->getDeleteCode();

		}


		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## STEP 1. 
			## 설정(2.0버전에서 추가)
			list($b_kind, $b_skin) = explode("_", $this->field['b_kind_skin']);
			$this->field['b_kind'] = $b_kind;
			$this->field['b_skin'] = $b_skin;
			$this->field['b_code'] = strtoupper($this->field['b_code']);
			if($this->field['admin_mode']):
				$this->field['b_kind'] = $this->field['b_kind_admin'];
				$this->field['b_skin'] = $this->field['b_skin_admin'];	
			endif;

			## STEP 2.
			## 데이터 중복 체크
			$boardView				= new CommunityBoardView($this->db, $this->field);
			$boardSelectRow			= $boardView->getSelect();
			if($boardSelectRow):
				$this->field['act'] = "boardWriteAlready";
				return;
			endif;
			$boardTableUBCount		= $this->module->getSchemaTableSelect("BOARD_UB_{$this->field['b_code']}");
			$boardTableFLCount		= $this->module->getSchemaTableSelect("BOARD_FL_{$this->field['b_code']}");
			$boardTableCMCount		= $this->module->getSchemaTableSelect("BOARD_CM_{$this->field['b_code']}");
			if($boardTableUBCount > 0 || $boardTableFLCount > 0 || $boardTableCMCount > 0):
				$this->field['act'] = "boardWriteAlready";
				return;
			endif;

			## 게시판 번호 생성 
			## 2013.11.28 kim hee sung 게시판 번호 추가
			$intMaxBoardNo			= $this->module->getBoardMgrMAX_B_NO();
			$this->field['b_no']	= $intMaxBoardNo['MAX_B_NO'] + 1;

			## STEP 3.
			## 데이터 기록
 			parent::getWrite();		


			## STEP 4.
			## 데이터 만들기
			$this->getBoardInfoFileWrite("boardWrite");		


			## STEP 5.
			## 커뮤니티 리스트 만들기
			$this->getBoardListFileWrite();


			## STEP 6.
			## 커뮤니티 추가 정보 등록
			$boardInfoController		= new CommunityBoardInfoController($this->db, $this->field);
			$boardInfoController->getWrite();	
			$boardInfoController->getSaveScriptFile();

			## STEP 7.
			## 커뮤니티 테이블 생성
			if     ($this->field['b_kind'] =="data")		{ $dataController= new CommunityDataController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "event")		{ $dataController= new CommunityEventController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "talk")		{ $dataController= new CommunityTalkController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "product")	{ $dataController= new CommunityProductController($this->db, $this->field);	}
			else if($this->field['b_kind'] == "mypage")		{ $dataController= new CommunityMypageController($this->db, $this->field);	}
			$dataController->getCreateTable();


			## STEP 2.
			## 코멘트 테이블 및 폴더 삭제 - BOARD_CM_{tableName}	
			## 2013.05.10 일반 코멘트, 커뮤니티 코멘트 구분함.
			if($this->field['b_kind'] == "event"):
			$commentController		= new CommunityEventCommentController($this->db, $this->field);
			$commentController->getCreateTable();
			else:
			$commentController		= new CommunityCommentController($this->db, $this->field);
			$commentController->getCreateTable();
			endif;

			## STEP 8.
			## 커뮤니티 첨부파일 테이블 생성
			$attachedfileController		= new CommunityAttachedfileController($this->db, $this->field);
			$attachedfileController->getCreateTable();	


		}

		/**
		 * getBoardListFileWrite()
		 * boardList 파일 저장 및 변경
		 * **/
		function getBoardListFileWrite() {

			## STEP 1.
			## 데이터 폼 함수
			function getFileForm($key1, $key2, $val) {
				$data	 = sprintf("\$BOARD_LIST['%s']['%s']", $key1, $key2);
				$data	 = str_pad($data, 50, " ", STR_PAD_RIGHT);
				$data	 = sprintf("%s = \"%s\";", $data, $val); 
				return $data;
			}

			## STEP 2.
			## 데이터 만들기
			$b_code_temp			= $this->field['b_code'];
			$this->field['b_code']	= "";
			$boardListResult		= parent::getListNoPage("OP_ALL_LIST");
			while($row = mysql_fetch_array($boardListResult)) :
				if($row['B_USE'] != "Y") { continue; }
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['B_CODE'], "b_name", $row['B_NAME']);
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['B_CODE'], "b_bg_no", $row['B_BG_NO']);
			endwhile;
			$this->field['b_code'] = $b_code_temp;

			## STEP 3.
			## 파일 만들기(기존 데이터 업데이트 형)
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/boardList.info.php";
			$file				= new FileHandler();	
			$file->getMadeInfo($fileName, $data, "/*@ BOARD_LIST @*/");
		}


		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {

			function getMemberGroupCheck(&$field, $mode) {
				$intCnt = 0;
				foreach($field['S_MEMBER_GROUP'] as $key => $group):
					if($field["bi_{$mode}_member_auth"][$intCnt]) { continue; }
					$field["bi_{$mode}_member_auth"][$intCnt] = "N";
					$intCnt++;
				endforeach;
			}

			## STEP 1. 
			## 설정(2.0버전에서 추가)
			if($this->field['admin_mode']):
				$this->field['b_kind'] = $this->field['b_kind_admin'];
				$this->field['b_skin'] = $this->field['b_skin_admin'];
			else:
				list($b_kind, $b_skin) = explode("_", $this->field['b_kind_skin']);
				$this->field['b_kind'] = $b_kind;
				$this->field['b_skin'] = $b_skin;
			endif;

			## STEP 1-1.
			## 그룹 설정(2.0버전에서 추가)
			getMemberGroupCheck($this->field, "dataanswer");
			getMemberGroupCheck($this->field, "datalist");
			getMemberGroupCheck($this->field, "dataview");	
			getMemberGroupCheck($this->field, "datawrite");
			getMemberGroupCheck($this->field, "comment");

			## STEP 1-2.
			## 목록항목 설정
			for($i=0;$i<6;$i++):
				if($this->field['bi_datalist_field_use'][$i] == "Y") { continue; }
				$this->field['bi_datalist_field_use'][$i] = "N";
			endfor;

			## STEP 1-3.
			## 작성자 표시 방법
			for($i=0;$i<3;$i++):
				if($this->field['bi_datalist_writer_show'][$i] == "Y") { continue; }
				$this->field['bi_datalist_writer_show'][$i] = "N";
			endfor;

			## STEP 1-4.
			## 댓글 설정
//			if($this->field['bi_comment_use'] != "Y"):
//				$this->field['bi_comment_use'] = "N";
//			endif;

			## STEP 2.
			## 데이터 수정
			parent::getModify();	

			## STEP 3.
			## 데이터 만들기
			$this->getBoardInfoFileWrite("boardWrite");	

			## STEP 4.
			## 커뮤니티 리스트 만들기
			$this->getBoardListFileWrite();
		}



		/**
		 * getStop()
		 * 데이터 정지
		 * **/
		function getStop() {

			## STEP 1.
			## 설정
			$this->field['b_use']		= "N";
			$this->field['b_mod_no']	= $_SESSION["ADMIN_NO"];

			## STEP 2.
			## 데이터 업데이트
			parent::getUseUpdate();		

			## STEP 3.
			## 커뮤니티 리스트 만들기
			$this->getBoardListFileWrite();
		}

		/**
		 * getUse()
		 * 데이터 사용
		 * **/
		function getUse() {

			## STEP 1.
			## 설정
			$this->field['b_use']		= "Y";
			$this->field['b_mod_no']	= $_SESSION["ADMIN_NO"];

			## STEP 2.
			## 데이터 업데이트
			return parent::getUseUpdate();	
			
			## STEP 3.
			## 커뮤니티 리스트 만들기
			$this->getBoardListFileWrite();
		}

		function getDeleteCode() {
			$param['b_code']	= $this->field['b_code'];
			$this->module->getBoardMgrDeleteCode($param);
		}



		/**
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			$intTableCnt = $this->module->getSchemaTableSelect("BOARD_MGR_NEW");
			if($intTableCnt == 0) :	// 테이블이 없으면 실행
				return parent::getCreateTable();		
			endif;
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * 2013.04.10 커뮤니티 통합(상속 부분) 영역으로 변경
		 * **/
//		function getDropTable() {
//			$intTableCnt = $this->module->getSchemaTableSelect("BOARD_MGR_NEW");
//			if($intTableCnt > 0) : // 테이블이 있으면 실행
//				return parent::getDropTable();	
//			endif;
//		}

		/**
		 * getCreateProcedure()
		 * 프로시저 생성
		 * **/
		function getCreateProcedure() {
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_MGR_NEW_I");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("I");	
			endif;
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_MGR_NEW_U");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("U");	
			endif;
		}

		/**
		 * getDropProcedure()
		 * 프로시저 삭제
		 * **/
		function getDropProcedure() {
			parent::getDropProcedure("I");
			parent::getDropProcedure("U");	
		}
    }
?>