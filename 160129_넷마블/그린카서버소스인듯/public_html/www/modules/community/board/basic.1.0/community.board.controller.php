<?php
    /**
     * /home/shop_eng/www/modules/community/board/basic.1.0/community.board.controller.php
     * @author eumshop(thav@naver.com)
     * community board controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";

    class CommunityBoardController extends CommunityController {

		function __construct(&$db, &$field) {
			$this->module	= new CommunityBoardModule($db, $field);
			$this->name		="BoardMgr";
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community board controller class (basic.1.0)";
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## STEP 1.
			## 데이터 기록
 			parent::getWrite();		

			## STEP 2.
			## 데이터 만들기
			$this->getBoardInfoFileWrite("boardWrite");	

			## STEP 3.
			## 커뮤니티 리스트 만들기
			$this->getBoardListFileWrite();
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
			$b_code_temp		   = $this->field['b_code'];
			$this->field['b_code'] = "";
			$boardListResult = parent::getListNoPage("OP_ALL_LIST");
			while($row = mysql_fetch_array($boardListResult)) :
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

			## STEP 1.
			## 데이터 수정
			parent::getModify();	

			## STEP 2.
			## 데이터 만들기
			$this->getBoardInfoFileWrite("boardWrite");	

			## STEP 3.
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
		 * **/
		function getDropTable() {
			$intTableCnt = $this->module->getSchemaTableSelect("BOARD_MGR_NEW");
			if($intTableCnt > 0) : // 테이블이 있으면 실행
				return parent::getDropTable();	
			endif;
		}

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