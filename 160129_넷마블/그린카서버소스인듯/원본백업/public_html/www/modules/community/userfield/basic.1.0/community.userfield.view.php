<?php
    /**
     * /home/shop_eng/www/modules/userfield/event/basic.1.0/community.userfield.view.php
     * @author eumshop(thav@naver.com)
     * community userfield view class (basic.1.0)
	 * $dataView = new CommunityUserfieldView($db, $_REQUEST);
     * **/

	require_once MALL_HOME . "/modules/community/community.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.module.php";

    class CommunityUserfieldView extends CommunityView {

		## 기본 함수. 

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CommunityUserfieldModule($db, $field);
			$this->name		="UserfieldMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "community userfield view class (basic.1.0)";
		}

		## 수행 함수. 

		/**
		 * getList()
		 * 데이터 리스트
		 * **/
		function getList($op = "OP_LIST") {
		}

		/**
		 * getView()
		 * 데이터 보기
		 * **/
		function getView() {

// 2013.11.20 kim hee sung 소스 정리를 위해서 숨김처리, 오류 발생시 다른 방법으로 처리 바람
//			## STEP 1.
//			## 권한 체크
//			if(!$this->field['dataAuth']['check']) { return; }

			## STEP 1.
			## 추가 필드 사용 유무
			if($this->field['BOARD_INFO']['bi_userfield_use'] != "Y") { return; }	

			## STEP 2.
			## 설정
			$strTableName							= strtoupper($this->field['b_code']);
			$this->field['ad_table']				= "BOARD_AD_{$strTableName}";
			$this->field['ad_ub_no']				= $this->field['ub_no'];

			## STEP 4.
			## 실행
			return parent::getSelect();
		}

		/**
		 * getWrite()
		 * 데이터 쓰기
		 * **/
		function getWrite() {			
		}

		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {
		}

		/**
		 * getSelect()
		 * 데이터 정보
		 * **/
		function getSelect() {
		}

		/**
		 * getButtonAuth()
		 * 버튼 설정
		 * **/
		function getButtonAuth() {
		}

		/**
		 * getButtonAuthFunc($key)
		 * 버튼 설정 함수
		 * **/
		function getButtonAuthFunc($key) {
		}

		/**
		 * getPageInfo()
		 * 페이징 설정
		 * **/
		function getPageInfo() {		
		}


		## FUNCTION()
		## 함수 모음


		/**
		 * getLockCheck(&$row)
		 * 볼수있는 글이면 return "000", 볼수 없는 글이면 return "11X"
		 * **/		
		function getLockCheck(&$row) {
		}

		/**
		 * getUB_FUNC_DECODER()
		 * 기능 함수
		 * **/
		function getUB_FUNC_DECODER(&$row) {
		}

    }
?>