<?php
    /**
     * /home/shop_eng/www/modules/community/board/basic.1.0/community.boardInfo.controller.php
     * @author eumshop(thav@naver.com)
     * community boardInfo controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.controller.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.1.0/community.boardInfo.module.php";

	require_once MALL_HOME . "/classes/file/file.handler.class.php";

    class CommunityBoardInfoController extends CommunityController {

		function __construct(&$db, &$field) {
			$this->module			= new CommunityBoardInfoModule($db, $field);
			$this->name				="BoardInfoMgr";
			$this->field			= &$field;
		}

		function getMessage() {
			echo "community boardInfo controller class (basic.1.0)";
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {

			## STEP 1.
			## 디폴트 세팅 정보 불러오기
			$boardDefaultInfoHref	= "{$this->field['S_DOCUMENT_ROOT']}www/config/community/board.default.{$_POST['b_kind']}.info.php";
			if(!is_file($boardDefaultInfoHref)) { return; }
			include $boardDefaultInfoHref;

			## STEP 2.
			## 디폴트 세팅 정보 DB에 등록
			$aryBoardSet			= $this->getBoardInfoKeyDefine();	
			foreach($BOARD_SET as $act => $set):
				foreach($set as $key => $val):
						$this->field['ba_b_code']			= $this->field['b_code'];
						$this->field['ba_key']				= strtoupper($key);
						$this->field['ba_val']				= $val;
						$this->field['ba_comment']			= $aryBoardSet[$act][$key];
						$this->field[$key]					= $val;
						parent::getWriteModify();
				endforeach;
				$this->getBoardInfoFileWrite($act);			// 파일 생성
				
			endforeach;
		}

		/**
		 * getWriteModify()
		 * 데이터 등록&수정
		 * **/
		function getWriteModify() {

			## STEP 1.
			## 데이터 기록
			$aryBoardInfo		= $this->getBoardInfoKeyDefine($this->field['act']);

			if(is_array($aryBoardInfo)):
				foreach($aryBoardInfo as $key => $comment):
					$field = $this->field[strtolower($key)];
					if(is_array($field)):
						foreach($field as $fieldKey => $fieldVal):
							$this->field['ba_b_code']	= $this->field['b_code'];
							$this->field['ba_key']		= "{$key}_{$fieldKey}" ;
							$this->field['ba_val']		= $fieldVal;
							$this->field['ba_comment']	= $comment;
							parent::getWriteModify();
						endforeach;
					else:
						$this->field['ba_b_code']	= $this->field['b_code'];
						$this->field['ba_key']		= $key ;
						$this->field['ba_val']		= $field;
						$this->field['ba_comment']	= $comment;
						parent::getWriteModify();
					endif;
				endforeach;
			endif;
			

			## STEP 2.
			## 데이터 만들기
			$this->getBoardInfoFileWrite($this->field['act']);	
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {	
		}


		/**
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable() {
			$intTableCnt = $this->module->getSchemaTableSelect("BOARD_INFO_MGR");
			if($intTableCnt == 0) :	// 테이블이 없으면 실행
				return parent::getCreateTable();		
			endif;
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * **/
		function getDropTable() {
			$intTableCnt = $this->module->getSchemaTableSelect("BOARD_INFO_MGR");
			if($intTableCnt > 0) : // 테이블이 있으면 실행
				return parent::getDropTable();	
			endif;
		}

		/**
		 * getCreateProcedure()
		 * 프로시저 생성
		 * **/
		function getCreateProcedure() {
			$intProcedureCnt = $this->module->getSchemaProcedureSelect("SP_BOARD_INFO_MGR_IU");
			if($intProcedureCnt == 0) : // 프로시저가 없으면 실행
				parent::getCreateProcedure("IU");	
			endif;
		}

		/**
		 * getDropProcedure()
		 * 프로시저 삭제
		 * **/
		function getDropProcedure() {
			parent::getDropProcedure("IU");
		}

		/**
		 * getSaveScriptFile()
		 * 커뮤니티 스크립트 저장
		 * **/	
		function getSaveScriptFile() {

			## STEP 1.
			## 수행파일 만들기
			$bi_datascript_data					= $this->field['bi_datascript_data'];
			preg_match_all("/<%.*%>/", $bi_datascript_data, $preg_data);
			foreach($preg_data[0] as $data):
				$dataTemp = $data;
				$dataTemp = str_replace("<%", "", $dataTemp);
				$dataTemp = str_replace("%>", "", $dataTemp);
					
				/* include 치환 */
				if(preg_match("/^include[ |\"]/", $dataTemp)):
					$dataTemp			= str_replace("include", "", $dataTemp);
					$dataTemp			= str_replace("\"", "", $dataTemp);
					$dataTemp			= str_replace(" ", "", $dataTemp);
					if(is_file("{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}{$dataTemp}")):
						$dataTemp		= "<? include \"{\$S_DOCUMENT_ROOT}{\$S_SHOP_HOME}{$dataTemp}\"; ?>";
					else:
						$dataTemp		= "<!--ERROR NO FILE-->";
					endif;
					$bi_datascript_data	= str_replace($data, $dataTemp, $bi_datascript_data);
				endif;
			endforeach;

			## STEP 2.
			## 커뮤니티 스크립트 파일명 정의
			$bi_datascript_href					= "/layout/html/community/board.{$this->field['b_code']}.script.php";
			$bi_datascript_href_tag				= "/layout/html/community/board.{$this->field['b_code']}.script.tag.php";
			$bi_datascript_data_tag				= $this->field['bi_datascript_data'];

			$this->field['bi_datascript_href']	= $bi_datascript_href;

			## STEP 3.
			## 커뮤니티 스크립트 예약어 정의			
			$aryTag['{{__커뮤니티본문__}}']		= "<? include \$includeFile; ?>";

			## STEP 4.
			## 파일 만들기(태그파일)
			$file				= new FileHandler();
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}{$bi_datascript_href_tag}";
			$file->fileWrite($fileName, $bi_datascript_data_tag);

			## STEP 5.
			## 파일 만들기(수행파일)
			foreach($aryTag as $key => $tag):
				$bi_datascript_data = str_replace($key, $tag, $bi_datascript_data);
			endforeach;
			$fileName			= "{$this->field['S_DOCUMENT_ROOT']}{$this->field['S_SHOP_HOME']}{$bi_datascript_href}";
			$file->fileWrite($fileName, $bi_datascript_data);

		}

		/**
		 * getUserfieldSet()
		 * 커뮤니티 추가필드(사용자정의필드) 데이터 정리
		 * **/	
		function getUserfieldSet() {
			
			$intCnt						= sizeof($this->field['bi_userfield_name']);
			$userfield_field_use		= "";

			for($i=0;$i<$intCnt;$i++):
				$use = $this->field['userfield_field_use'][$i];
				$userfield_field_use .= ($use) ? $use : "N";
			endfor;
			$this->field['bi_userfield_field_use'] = $userfield_field_use;
//			print_r($this->field);
		}
    }
?>