<?php
    /**
     * /home/shop_eng/www/modules/community/group/basic.1.0/community.group.controller.php
     * @author eumshop(thav@naver.com)
     * community group controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/group/basic.1.0/community.group.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";

    class CommunityGroupController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityGroupModule($db, $field);
			$this->name		="GroupMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community group controller class (basic.1.0)";
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## STEP 1.
			## 파일 업로드			
			$this->getUpFileUpload();

			## STEP 2.
			## DB 등록
			parent::getWrite();

			## STEP 3.
			## 그룹 파일 만들기
			$this->getBoardGroupFileWrite();
		}


		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {

			## STEP 1.
			## 파일 업로드	
			$this->getUpFileUpload();

			## STEP 2.
			## 기존 파일 삭제	
			$f_spath		= $this->getUploadServerPath();
			$groupListRow	= $this->module->getGroupMgrSelect("OP_SELECT");
			$f_sfname1		= $groupListRow['BG_FILE1'];
			$f_sfname2		= $groupListRow['BG_FILE2'];

			if($this->field['bg_file1'] || $this->field['bg_file1_del'] == "Y"):
				if($f_sfname1) { unlink($f_spath.$f_sfname1); };
			else:
				$this->field['bg_file1'] = $f_sfname1;
			endif;

			if($this->field['bg_file2'] || $this->field['bg_file2_del'] == "Y"):
				if($f_sfname2) { unlink($f_spath.$f_sfname2); };
			else:
				$this->field['bg_file2'] = $f_sfname2;
			endif;

			## STEP 3.
			## DB 수정
			parent::getModify();	

			## STEP 4.
			## 그룹 파일 만들기
			$this->getBoardGroupFileWrite();
		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {

			## STEP 1.
			## 파일 삭제
			$f_spath		= $this->getUploadServerPath();
			$groupListRow	= $this->module->getGroupMgrSelect("OP_SELECT");
			$f_sfname1		= $groupListRow['BG_FILE1'];
			$f_sfname2		= $groupListRow['BG_FILE2'];
			if($f_sfname1) { unlink($f_spath.$f_sfname1); }
			if($f_sfname2) { unlink($f_spath.$f_sfname2); }

			## STEP 2.
			## DB 삭제
			parent::getDelete();

			## STEP 3.
			## 그룹 파일 만들기
			$this->getBoardGroupFileWrite();
		}

		/**
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			$intTableCnt = $this->module->getSchemaTableSelect("BOARD_GROUP_NEW");
			if($intTableCnt == 0) :	// 테이블이 없으면 실행
				return parent::getCreateTable();		
			endif;
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * **/
		function getDropTable() {
			$intTableCnt = $this->module->getSchemaTableSelect("BOARD_GROUP_NEW");
			if($intTableCnt > 0) : // 테이블이 있으면 실행
				return parent::getDropTable();	
			endif;
		}

		/**
		 * getCreateProcedure()
		 * 프로시저 생성
		 * **/
		function getCreateProcedure() {
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_GROUP_NEW_I");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("I");	
			endif;
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_GROUP_NEW_U");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("U");	
			endif;
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_GROUP_NEW_D");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("D");	
			endif;
		}

		/**
		 * getDropProcedure()
		 * 프로시저 삭제
		 * **/
		function getDropProcedure() {
			parent::getDropProcedure("I");
			parent::getDropProcedure("U");	
			parent::getDropProcedure("D");	
		}


		## 함수 모음 ##

		/**
		 * getUploadServerPath()
		 * 업로드 경로
		 * **/
		function getUploadServerPath() {
			$f_spath		= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/group/";
			return $f_spath;
		}

		/**
		 * getUpFileUpload()
		 * 파일 저장
		 * **/
		function getUpFileUpload() {

			$file				= new FileHandler();	
			$aryUpLoadInfo1		= array(		"F_NAME"		=> "bg_file1",
												"F_FILTER"		=> "jpg;gif;png",
												"F_SPATH"		=> $this->getUploadServerPath(),
												"F_SFNAME"		=> "",
												"F_SECTION"		=> "GROUP"		);
			$re = $file->getFileUpload($aryUpLoadInfo1);
			$aryUpLoadInfo2		= array(		"F_NAME"		=> "bg_file2",
												"F_FILTER"		=> "jpg;gif;png",
												"F_SPATH"		=> $this->getUploadServerPath(),
												"F_SFNAME"		=> "",
												"F_SECTION"		=> "GROUP"		);
			$re = $file->getFileUpload($aryUpLoadInfo2);
			$this->field['bg_file1'] = $aryUpLoadInfo1['F_SFNAME'];
			$this->field['bg_file2'] = $aryUpLoadInfo2['F_SFNAME'];
		}


		/**
		 * getBoardGroupFileWrite($act)
		 * board_group 파일 저장 및 변경
		 * **/
		function getBoardGroupFileWrite($act) {

			## STEP 1.
			## 데이터 폼 함수
			function getFileForm($key1, $key2, $val) {
				$data	 = sprintf("\$GROUP_LIST['%s']['%s']", str_pad($key1, 3, "0", STR_PAD_LEFT), $key2);
				$data	 = str_pad($data, 50, " ", STR_PAD_RIGHT);
				$data	 = sprintf("%s = \"%s\";", $data, $val); 
				return $data;
			}

			## STEP 2.
			## 데이터 만들기
			$groupListResult = parent::getListNoPage();
			while($row = mysql_fetch_array($groupListResult)) :
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['BG_NO'], "bg_name", $row['BG_NAME']);
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['BG_NO'], "bg_file1", $row['BG_FILE1']);
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['BG_NO'], "bg_file2", $row['BG_FILE2']);
			endwhile;

			## STEP 3.
			## 파일 만들기(기존 데이터 업데이트 형)
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/groupList.info.php";
			$file				= new FileHandler();	
			$file->getMadeInfo($fileName, $data, "/*@ GROUP @*/");
		}
    }
?>