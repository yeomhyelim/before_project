<?php
    /**
     * /home/shop_eng/www/modules/community/userfield/basic.1.0/community.userfield.controller.php
     * @author eumshop(thav@naver.com)
     * community userfield controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
 //	require_once MALL_HOME . "/classes/client/client.info.class.php";

    class CommunityUserfieldController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityUserfieldModule($db, $field);
			$this->name		="UserfieldMgr";
			$this->db		= &$db;
			$this->field	= &$field;
			$this->getSessionInfo();
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community userfield controller class (basic.1.0)";
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
		}


		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## 모듈 설정
			require_once MALL_HOME . "/module2/BoardInfoMgr.module.php";
			require_once MALL_HOME . "/module2/BoardAddField.module.php";
			$boardAddField			= new BoardAddFieldModule($this->db);

			## 기본 설정
			$aryBoardInfo			= $this->field['BOARD_INFO'];
			$strUserfieldUse		= $aryBoardInfo['bi_userfield_use'];
			$strBCode				= $this->field['b_code'];
			$intUbNo				= $this->field['ub_no'];

			## 기본 설정 체크
			if($strUserfieldUse != "Y") { return; }
			if(!$strBCode) { return; }
			if(!$intUbNo) { return; }

			## 데이터 만들기
			$param					= "";
			$param['B_CODE']		= $strBCode;
			$param['AD_UB_NO']		= $intUbNo;
			foreach($G_USERFIELD_INFO as $key => $data):

				## 기본 설정
				$strColumnName		= $data['columnName'];
				$strColumnNameLower	= strtolower($strColumnName);
				$strKind			= $aryBoardInfo["bi_{$strColumnNameLower}_kind"];
	//			$strKindData		= $aryBoardInfo["bi_{$strColumnNameLower}_kind_data"];
	//			$strOnlyadmin		= $aryBoardInfo["bi_{$strColumnNameLower}_onlyadmin"];
	//			$strEssential		= $aryBoardInfo["bi_{$strColumnNameLower}_essential"];
	//			$strName			= $aryBoardInfo["bi_{$strColumnNameLower}_name"];
	//			$strSort			= $aryBoardInfo["bi_{$strColumnNameLower}_sort"];
				$strUse				= $aryBoardInfo["bi_{$strColumnNameLower}_use"];
				$strField			= $this->field[$strColumnNameLower];

				if($strUse != "Y") { continue; }

				if(in_array($strKind, array("zip","phone"))):
					$strField = implode("-", $strField);
				endif;

				$param[$strColumnName]		= 	$strField;
			
			endforeach;

			## 데이터 등록
			$boardAddField->getBoardAddFieldInsertUpdateEx($param);
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {

 			## 모듈 설정
			require_once MALL_HOME . "/module2/BoardInfoMgr.module.php";
			require_once MALL_HOME . "/module2/BoardAddField.module.php";
			$boardAddField			= new BoardAddFieldModule($this->db);

			## 기본 설정
			$aryBoardInfo			= $this->field['BOARD_INFO'];
			$strUserfieldUse		= $aryBoardInfo['bi_userfield_use'];
			$strBCode				= $this->field['b_code'];
			$intUbNo				= $this->field['ub_no'];

			## 기본 설정 체크
			if($strUserfieldUse != "Y") { return; }
			if(!$strBCode) { return; }
			if(!$intUbNo) { return; }

			## 데이터 만들기
			$param					= "";
			$param['B_CODE']		= $strBCode;
			$param['AD_UB_NO']		= $intUbNo;
			foreach($G_USERFIELD_INFO as $key => $data):

				## 기본 설정
				$strColumnName		= $data['columnName'];
				$strColumnNameLower	= strtolower($strColumnName);
				$strKind			= $aryBoardInfo["bi_{$strColumnNameLower}_kind"];
	//			$strKindData		= $aryBoardInfo["bi_{$strColumnNameLower}_kind_data"];
	//			$strOnlyadmin		= $aryBoardInfo["bi_{$strColumnNameLower}_onlyadmin"];
	//			$strEssential		= $aryBoardInfo["bi_{$strColumnNameLower}_essential"];
	//			$strName			= $aryBoardInfo["bi_{$strColumnNameLower}_name"];
	//			$strSort			= $aryBoardInfo["bi_{$strColumnNameLower}_sort"];
				$strUse				= $aryBoardInfo["bi_{$strColumnNameLower}_use"];
				$strField			= $this->field[$strColumnNameLower];
				if($strUse != "Y") { continue; }

				if(in_array($strKind, array("zip","phone"))):
					$strField = implode("-", $strField);
				endif;

				$param[$strColumnName]		= 	$strField;
			
			endforeach;

			## 데이터 등록
//			$boardAddField->getBoardAddFieldUpdateEx($param);
			
			## 2013.12.11 kim hee sung 신규는 insert, 중복이면 update 
			$boardAddField->getBoardAddFieldInsertUpdateEx($param);
		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {

			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']) { return; }

			## STEP 1.
			## 사용유무
			if($this->field['BOARD_INFO']['bi_userfield_use'] != "Y") { return; }	
			
			## STEP 2.
			## 권한유무(추후 작업 예정)
//			$lock = $this->getLockCheck($dataSelectRow);
//			if($lock == "111"):
//				echo "비밀글입니다. 다른 회원이 작성한 글입니다.";
//				exit;
//			elseif($lock == "110"):	
//				$this->field['modeBack']	= $this->field['mode'];
//				$this->field['mode']		= "dataPassword";
//				echo "비밀글입니다. 비회원이 작성한 글입니다.";
//				exit;
//			endif;

			## STEP 3.
			## 필드 정리
			$strTableName							= strtoupper($this->field['b_code']);
			$this->field['ad_table']				= "BOARD_AD_{$strTableName}";
			$this->field['ad_ub_no']				= $this->field['ub_no'];

			## STEP 4.
			## 데이터 삭제
			return parent::getDelete();	
		}

		/**
		 * getPassword()
		 * 작성된 글의 비밀번호와 사용자가 입력한 비밀번호가 같은지 체크
		 * **/
		function getPassword() {
		}

		/** 
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			if(!$this->field['b_code']) { return; }
			$strTableName				= strtoupper($this->field['b_code']);
			$this->field['tableName']	= "BOARD_AD_{$strTableName}";
			$intTableCnt				= $this->module->getSchemaTableSelect($this->field['tableName']);
			
			if($intTableCnt == 0) :	// 테이블이 없으면 실행
				return parent::getCreateTable();	
			endif;
		}

		/**
		 * getCreateProcedure()
		 * 프로시저 생성
		 * **/
		function getCreateProcedure() {
		}

		/**
		 * getDropProcedure()
		 * 프로시저 삭제
		 * **/
		function getDropProcedure() {
		}

		/**
		 * getSelectForModify()
		 * 수정을 위한 데이터 정보 호출
		 * **/
		function getSelectForModify() {

		}

		## 함수 모음 ##

		/**
		 * getLockCheck(&$row)
		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
		 * **/		
		function getLockCheck(&$row) {
		}

		/**
		 * getUB_FUNC_ENCODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_ENCODER() {
		}

		/**
		 * getUB_FUNC_DECODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_DECODER(&$row) {
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * 2013.04.10 커뮤니티 통합(상속 부분) 영역으로 변경
		 * **/
//		function getDropTable() {
//			$tableName		= "BOARD_AD_{$this->field['b_code']}";
//			$intTableCnt	= $this->module->getSchemaTableSelect($tableName);
//			if($intTableCnt > 0) : // 테이블이 있으면 실행
//				$param['tableName'] = $tableName;
//				return parent::getDropTable($param);	
//			endif;
//		}

    }
?>