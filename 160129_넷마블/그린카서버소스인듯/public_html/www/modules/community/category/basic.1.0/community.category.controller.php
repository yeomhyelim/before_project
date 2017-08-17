<?php
    /**
     * /home/shop_eng/www/modules/community/category/basic.1.0/community.category.controller.php
     * @author eumshop(thav@naver.com)
     * community category controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/category/basic.1.0/community.category.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";

    class CommunityCategoryController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityCategoryModule($db, $field);
			$this->name		="CategoryMgr";
			$this->db		= &$db;
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
		 * getDeleteCode()
		 * 관련 코드 내용 삭제
		 * **/
		function getDeleteCode() {

			## STEP 1.
			## 카테고리 코드 내용 삭제
			$param['bc_b_code']	= $this->field['bc_b_code'];
			$f_spath			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/category/";
			$categoryResult		= parent::getSelectEx("OP_LIST", $param);
			while($row = mysql_fetch_array($categoryResult, MYSQL_ASSOC)):
				$f_sfname1		= $f_spath.$row['BC_IMAGE_1'];
				$f_sfname2		= $f_spath.$row['BC_IMAGE_2'];	
				if(is_file($f_sfname1)) { unlink($f_sfname1); }
				if(is_file($f_sfname1)) { unlink($f_sfname1); }
			endwhile;
			$this->module->getCategoryMgrDeleteCode($param);
		}

		/**
		 * getDeleteFile()
		 * 카테고리 파일 삭제
		 * **/
		function getDeleteFile() {
			$confFile			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/category/category.{$this->field['b_code']}.info.php";
			if(is_file($confFile)) { unlink($confFile); }
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
			$this->getBoardCategoryFileWrite();
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
			$f_spath		= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/category/";
			$categoxryRow	=  parent::getSelect();
			$f_sfname1		= $categoxryRow['BC_IMAGE_1'];
			$f_sfname2		= $categoxryRow['BC_IMAGE_2'];

			if($this->field['bc_image_1'] || $this->field['bc_image_1_del'] == "Y"):
				if($f_sfname1) { unlink($f_spath.$f_sfname1); };
			else:
				$this->field['bc_image_1'] = $f_sfname1;
			endif;

			if($this->field['bc_image_2'] || $this->field['bc_image_2_del'] == "Y"):
				if($f_sfname2) { unlink($f_spath.$f_sfname2); };
			else:
				$this->field['bc_image_2'] = $f_sfname2;
			endif;

			## STEP 3.
			## DB 수정
			parent::getModify();	

			## STEP 4.
			## 그룹 파일 만들기
			$this->getBoardCategoryFileWrite();
		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete() {
			
			## STEP 1.
			## 설정
			$f_spath		= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/category/";

			## STEP 2.
			## 파일 삭제
			$categoxryRow	=  parent::getSelect();

			$f_sfname1		= $categoxryRow['BC_IMAGE_1'];
			$f_sfname2		= $categoxryRow['BC_IMAGE_2'];
			if($f_sfname1) { unlink($f_spath.$f_sfname1); }
			if($f_sfname2) { unlink($f_spath.$f_sfname2); }

			## STEP 3.
			## DB 삭제
			parent::getDelete();

			## STEP 4.
			## 카테고리 파일 만들기
			$this->getBoardCategoryFileWrite();
		}

		/**
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * 2013.04.10 커뮤니티 통합(상속 부분) 영역으로 변경
		 * **/
//		function getDropTable() {
//		}

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


		## 함수 모음 ##

		/**
		 * getUploadServerPath()
		 * 업로드 경로
		 * **/
		function getUploadServerPath() {
		}

		/**
		 * getUpFileUpload()
		 * 파일 저장
		 * **/
		function getUpFileUpload() {

			$f_spath		= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/category/";

			$file				= new FileHandler();	
			$aryUpLoadInfo1		= array(		"F_NAME"		=> "bc_image_1",
												"F_FILTER"		=> "jpg;gif;png",
												"F_SPATH"		=> $f_spath,
												"F_SFNAME"		=> "",
												"F_SECTION"		=> "CATEGORY"		);
			$re = $file->getFileUpload($aryUpLoadInfo1);
			$aryUpLoadInfo2		= array(		"F_NAME"		=> "bc_image_2",
												"F_FILTER"		=> "jpg;gif;png",
												"F_SPATH"		=> $f_spath,
												"F_SFNAME"		=> "",
												"F_SECTION"		=> "CATEGORY"		);
			$re = $file->getFileUpload($aryUpLoadInfo2);
			$this->field['bc_image_1'] = $aryUpLoadInfo1['F_SFNAME'];
			$this->field['bc_image_2'] = $aryUpLoadInfo2['F_SFNAME'];
		}


		/**
		 * getBoardCategoryFileWrite($act)
		 * board_group 파일 저장 및 변경
		 * **/
		function getBoardCategoryFileWrite($act) {
			## STEP 1.
			## 데이터 폼 함수
			function getFileForm($key1, $key2, $val) {
//				$data	 = sprintf("\$CATEGORY_LIST['%s']['%s']", str_pad($key1, 3, "0", STR_PAD_LEFT), $key2);
				$data	 = sprintf("\$CATEGORY_LIST['%s']['%s']", $key1, $key2);
				$data	 = str_pad($data, 50, " ", STR_PAD_RIGHT);
				$data	 = sprintf("%s = \"%s\";", $data, $val); 
				return $data;
			}

			## STEP 2.
			## 데이터 만들기
			$categoryListResult = parent::getListNoPage();
			while($row = mysql_fetch_array($categoryListResult)) :
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['BC_NO'], "bc_name", $row['BC_NAME']);
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['BC_NO'], "bc_image_1", $row['BC_IMAGE_2']);
				$data .= ($data) ? "\r\n" : "";
				$data .= getFileForm($row['BC_NO'], "bc_image_2", $row['BC_IMAGE_1']);
			endwhile;

			## STEP 3.
			## 파일 만들기(기존 데이터 업데이트 형)
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/conf/community/category/category.{$this->field['bc_b_code']}.info.php";
			$file				= new FileHandler();	
			$file->getMadeInfo($fileName, $data, "/*@ CATEGORY {$this->field['bc_b_code']} @*/");
		}
    }
?>