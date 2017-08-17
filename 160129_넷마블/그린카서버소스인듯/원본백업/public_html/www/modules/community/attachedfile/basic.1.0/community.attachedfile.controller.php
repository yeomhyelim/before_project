<?php
    /**
     * /home/shop_eng/www/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php
     * @author eumshop(thav@naver.com)
     * community attachedfile controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";
 //	require_once MALL_HOME . "/classes/client/client.info.class.php";

    class CommunityAttachedfileController extends CommunityController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityAttachedfileModule($db, $field);
			$this->name		="AttachedfileMgr";
			$this->db		= &$db;
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community attachedfile controller class (basic.1.0)";
		}

		/**
		 * getUploadServerPath($op)
		 * 업로드 경로
		 * **/
		function getUploadServerPath($op) {
			$upper_b_code					= strtoupper($this->field['b_code']);
			$subFolder						= date("Ym");
			$f_spath['OP_UPLOAD']			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}";
			$f_spath['OP_TEMP']				= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/temp/";
			$f_spath['OP_DATA_PATH']		= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/data/{$upper_b_code}/{$subFolder}/";
			return $f_spath[$op];
		}

		/**
		 * getUploadWebPath()
		 * 업로드 파일 웹 경로
		 * **/
		function getUploadWebPath($op) {
			$upper_b_code					= strtoupper($this->field['b_code']);
			$subFolder						= date("Ym");
			$f_wpath['OP_TEMP']			= "/upload/community/temp/";
			$f_wpath['OP_DATA_PATH']	= "/upload/community/data/{$upper_b_code}/{$subFolder}/";
			return $f_wpath[$op];
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## STEP 1.
			## 업로드 파일이 있는지 체크
			if(!is_array($this->field['fl_temp_file'])) { return; }

			## STEP 2.
			## TEMP 폴더에 있는 파일을 DATA 폴더로 이동.
			$file		= new FileHandler();
			$tempPath	= $this->getUploadServerPath("OP_TEMP");
			$dataPath	= $this->getUploadServerPath('OP_DATA_PATH');
			$webPath	= $this->getUploadWebPath('OP_DATA_PATH');
			$re			= $file->makeFolder($dataPath);
			if(!$re) { return; }	// 업로드 할  DATA 폴더가 없으면 종료.

			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";		// 테이블 명
			$this->field['fl_ub_no']	= $this->field['ub_no'];
			$this->field['fl_dir']		= $webPath;
			$this->field['fl_mod_no']	= $this->field['member_no'];
			foreach($this->field['fl_temp_file'] as $i => $fileName) :
				$tempPathFile = $tempPath . $fileName;
				$dataPathFile = $dataPath . $fileName;
				if(is_file($tempPathFile)):
					// 파일이 있으면
					if(is_file($dataPathFile)):
						// DATA 폴더에 중복 파일이 있는 경우 처리....
					endif;
					$path_parts = pathinfo($tempPathFile);
					$this->field['fl_name']		= $path_parts['basename'];
					$this->field['fl_type']		= mime_content_type($tempPathFile);
					$this->field['fl_size']		= filesize($tempPathFile);
					$this->field['fl_key']		= $this->field['fl_temp_key'][$i];
					rename($tempPathFile, $dataPathFile);
					/* 데이터 등록 */
					parent::getWrite();
					/* 데이터 등록 */
				endif;
			endforeach;
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {


			## STEP 1.
			## 삭제된 파일이 있으면 파일 삭제 및 데이터 삭제
			if(is_array($this->field['del_fl_no'])):
				$uploadPath					= $this->getUploadServerPath("OP_UPLOAD");
				$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";		// 테이블 명
				foreach($this->field['del_fl_no'] as $fl_no):
					$this->field['fl_no']	= $fl_no;
					$selectRow				= parent::getSelect();
					if(is_array($selectRow)):
						// 파일 정보가 있다면,
						$dataPathFile = $uploadPath . $selectRow['FL_DIR'] . $selectRow['FL_NAME'];
						if(is_file($dataPathFile)):
							// 파일이 있으면
							unlink($dataPathFile);
						endif;
						/* 데이터 삭제 */
						parent::getDelete("OP_FL_NO");
						/* 데이터 삭제 */
					endif;
				endforeach;
			endif;

			## STEP 2.
			## 신규로 등록되는 파일이 있으면 생성.
			$this->getWrite();
		}

		/**
		 * getDelete()
		 * 데이터 삭제(게시판 글 삭제시 관련 데이터 모두 삭제)
		 * **/
		function getDelete() {

			## STEP 1.
			## 권한 체크
			if(!$this->field['dataAuth']['check']) { return; }

			## STEP 1.
			## 첨부파일 기능을 사용하는지 체크
			if($this->field['BOARD_INFO']['bi_attachedfile_use'] <= 0) { return; }

			## STEP 2.
			## 등록된 첨부파일 및 데이터 삭제
			$this->field['fl_table']	= "BOARD_FL_{$this->field['b_code']}";		// 테이블 명
			$this->field['fl_ub_no']	= $this->field['ub_no'];
			$listResult					= parent::getListNoPage();

			if($listResult):
				$uploadPath					= $this->getUploadServerPath("OP_UPLOAD");
				while($row = mysql_fetch_array($listResult)) :
					$this->field['fl_no']	= $row['FL_NO'];
					$dataPathFile			= $uploadPath . $row['FL_DIR'] . $row['FL_NAME'];
					if(is_file($dataPathFile)):
						// 파일이 있으면
						unlink($dataPathFile);
					endif;
				endwhile;
				/* 데이터 삭제(게시판 관련 글 모두 삭제) */
				parent::getDelete("FL_UB_NO");
				/* 데이터 삭제(게시판 관련 글 모두 삭제) */
			endif;
		}

		/**
		 * getSelectForModify()
		 * 수정을 위한 데이터 정보 호출
		 * **/
		function getSelectForModify() {
		}

		/**
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			if(!$this->field['b_code'])					{ return; }
			if(!$this->field['bi_attachedfile_use'])	{ return; }

			$strTableName				= strtoupper($this->field['b_code']);
			$this->field['tableName']	= "BOARD_FL_{$strTableName}";
			$intTableCnt				= $this->module->getSchemaTableSelect($this->field['tableName']);

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
//			$tableName		= "BOARD_FL_{$this->field['b_code']}";
//			$intTableCnt	= $this->module->getSchemaTableSelect($tableName);
//			if($intTableCnt > 0) : // 테이블이 있으면 실행
//				$param['tableName'] = $tableName;
//				return parent::getDropTable($param);
//			endif;
//		}

		/**
		 * getDropDirectory()
		 * 디렉토리 삭제
		 * **/
		function getDropDirectory() {
			$b_code		= strtoupper($this->field['b_code']);
			$f_spath	= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}/upload/community/data/{$b_code}";
			if(is_dir($f_spath)):
				$file = new FileHandler();
				$file->dirDelete($f_spath);
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

		## 추가 함수 ##

		/**
		 * getTempFileUpload()
		 * 첨부파일 템프 폴더로 업로드
		 * **/
		function getTempFileUpload() {

			$data = $this->getUpFileUpload("OP_TEMP");

			if($this->field['mode'] == "json"):
				$result['mode']		= 1;
				$result['data']		= $data;
			endif;

			$this->field['result']	= $result;
		}


		/**
		 * getTempFileDelete()
		 * Temp 파일 삭제
		 * **/
		function getTempFileDelete() {
			$uploadServerPath	= $this->getUploadServerPath("OP_TEMP");

			$dataPathFile		= $uploadServerPath . $this->field['fl_temp_file'][$this->field['attached_filetemp_del']];

			if(is_file($dataPathFile)):
				// 파일이 있으면
				unlink($dataPathFile);
			endif;

			if($this->field['mode'] == "json"):
				$result['mode']		= 1;
				$result['data']		= array("no" => $this->field['attached_filetemp_del']);
			endif;
			$this->field['result']	= $result;
		}

		## 함수 모음 ##

		/**
		 * getUpFileUpload()
		 * 파일 저장
		 * **/
		function getUpFileUpload($op) {

			$aryUpLoadInfo		= "";
			$file				= new FileHandler();
			$uploadServerPath	= $this->getUploadServerPath($op);
			$uploadWebPath		= $this->getUploadWebPath($op);
			$intCnt				= 0;
			$aryFilterList		= array(	"listImage"		=> "gif;jpg;png",
											"image"			=> "gif;jpg;png",
											"movie"			=> "avi"			);

			foreach($_FILES['file']['name'] as $key => $val):
				$fileKey				= $this->field['BOARD_INFO']['bi_attachedfile_key'][$intCnt];
				$aryTemp				= array(		"F_NAME"		=> "file",
														"F_FILTER"		=> $aryFilterList[$fileKey],
														"F_SPATH"		=> $uploadServerPath,
														"F_WPATH"		=> $uploadWebPath,
														"F_SFNAME"		=> "",
														"F_SECTION"		=> $this->field['b_code'],
														"F_NUM"			=> $key,
														"F_KEY"			=> $this->field['key'][$key],			);

				$re						= $file->getFileUpload($aryTemp);
				$aryUpLoadInfo[$key]	= $aryTemp;
				$intCnt++;
			endforeach;

			return $aryUpLoadInfo;
		}
    }
?>