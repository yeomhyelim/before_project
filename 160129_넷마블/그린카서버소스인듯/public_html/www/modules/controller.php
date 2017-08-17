<?php
    /**
     * /home/shop_eng/www/modules/controller.php
     * @author eumshop(thav@naver.com)
     * controller class
     * **/

    class Controller {

		var $db;
		var $name;
		var	$field;
		var $module;
		var $view;

		function getMessage() {
			echo "controller class";
		}

		## 2013.04.08 신규 버전..

		/**
		 * getSelectEx($param)
		 * 선택 데이터
		 * 2013.04.08 업데이트 버전
		 * **/
		function getSelectEx($op="OP_SELECT", $param) {
			return $this->module->{"get{$this->name}SelectEx"}($op, $param);
		}

		## 2013.04.08 이전 버전...

		/**
		 * getListNoPage($op = "OP_LIST")
		 * 리스트 데이터(단, 페이지 나눔 없음
		 * **/
		function getListNoPage($op = "OP_LIST") {
			return $this->module->{"get{$this->name}Select"}($op);
		}

		/**
		 * getSelect()
		 * 선택 데이터
		 * **/
		function getSelect() {
			return $this->module->{"get{$this->name}Select"}("OP_SELECT");
		}

		/**
		 * getAnsStepMaxSelect()
		 * 계층형-스텝 최대값 가져오기
		 * **/
		function getAnsStepMaxSelect() {
			return $this->module->{"get{$this->name}AnsStepMaxSelect"}("OP_SELECT");
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWriteEx($param){
			return $this->module->{"get{$this->name}InsertEx"}($param);
		}

		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite(){
			return $this->module->{"get{$this->name}Insert"}();
		}

		/**
		 * getInsertSelect()
		 * 데이터 복사
		 * **/
		function getInsertSelect($param) {
			return $this->module->{"get{$this->name}InsertSelect"}($param);
		}

		/**
		 * getWriteModify()
		 * 데이터 등록&수정
		 * **/
		function getWriteModify(){
			return $this->module->{"get{$this->name}InsertUpdate"}();
		}

		/**
		 * getModifyEx($param)
		 * 데이터 수정
		 * **/
		function getModifyEx($param) {
			return $this->module->{"get{$this->name}UpdateEx"}($param);
		}


		/**
		 * getModify()
		 * 데이터 수정
		 * **/
		function getModify() {
			return $this->module->{"get{$this->name}Update"}();
		}

		/**
		 * getDelete()
		 * 데이터 삭제
		 * **/
		function getDelete($op=""){
			return $this->module->{"get{$this->name}Delete"}($op);
		}

		/**
		 * getDeleteEx($param)
		 * 데이터 삭제
		 * **/
		function getDeleteEx($param){
			return $this->module->{"get{$this->name}DeleteEx"}($param);
		}

		/**
		 * getUseUpdate()
		 * 데이터 사용/정지
		 * **/
		function getUseUpdate() {
			return $this->module->{"get{$this->name}UseUpdate"}();
		}

		/**
		 * getAnsNoUpdate()
		 * 계층형 데이터 업데이트(계층형-최상위글 번호)
		 * **/
		function getAnsNoUpdate() {
			return $this->module->{"get{$this->name}AnsNoUpdate"}();
		}

		/**
		 * getAnsNoUpdateEx()
		 * 계층형 데이터 업데이트(계층형-최상위글 번호)
		 * **/
		function getAnsNoUpdateEx($param) {
			return $this->module->{"get{$this->name}AnsNoUpdateEx"}($param);
		}

		/**
		 * getCreateTable()
		 * 테이블 생성
		 * **/
		function getCreateTable(){
			return $this->module->{"get{$this->name}CreateTable"}();
		}

		/**
		 * getDropTable()
		 * 테이블 삭제
		 * **/
//		function getDropTable(&$param){
//			return $this->module->{"get{$this->name}DropTable"}(&$param);
//		}

		/**
		 * getCreateProcedure($type)
		 * 프로시저 생성
		 * $type 는 3가지 타입 (I, U, D)
		 * **/
		function getCreateProcedure($type) {
			return $this->module->{"get{$this->name}CreateProcedure_{$type}"}();
		}

		/**
		 * getDropProcedure($type)
		 * 프로시저 삭제
		 * $type 는 3가지 타입 (I, U, D)
		 * **/
		function getDropProcedure($type) {
			return $this->module->{"get{$this->name}DropProcedure_{$type}"}();
		}

		/**
		 * getSessionInfo()
		 * 관리자, 일반 회원 로그인 통합
		 * **/
		function getSessionInfo() {
			if($_SESSION['ADMIN_LOGIN']):
				// 관리자로 로그인 된경우.
				$this->field['member_login']		= $_SESSION['ADMIN_LOGIN'];
				$this->field['member_id']			= $_SESSION['ADMIN_ID'];
				$this->field['member_mail']			= $_SESSION['ADMIN_MAIL'];
				$this->field['member_name']			= $_SESSION['ADMIN_NAME'];
				$this->field['member_level']		= $_SESSION['ADMIN_LEVEL'];
				$this->field['member_group']		= $_SESSION['ADMIN_GROUP'];
				$this->field['member_no']			= $_SESSION['ADMIN_NO'];
				$this->field['shop_no']				= $_SESSION['ADMIN_SHOP_NO'];
			elseif($_SESSION['member_login']):
				// 일반 회원으로 로그인 된경우.
				$this->field['member_login']		= $_SESSION['member_login'];
				$this->field['member_id']			= $_SESSION['member_id'];
				$this->field['member_mail']			= $_SESSION['member_mail'];
				$this->field['member_name']			= $_SESSION['member_last_name'] . $_SESSION['member_name'];
				$this->field['member_level']		= $_SESSION['member_level'];
				$this->field['member_group']		= $_SESSION['member_group'];
				$this->field['member_no']			= $_SESSION['member_no'];
			endif;
		}

    }
?>
