<?php
    /**
     * /home/shop_eng/www/modules/member/data/basic.1.0/member.data.controller.php
     * @author eumshop(thav@naver.com)
     * member data controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/member/member.controller.php";
	require_once MALL_HOME . "/modules/member/data/basic.1.0/member.data.module.php";

    class MemberDataController extends MemberController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new MemberDataModule($db, $field);
			$this->name		="MemberMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "member data controller class (basic.1.0)";
		}

 		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {
		}

 		/**
		 * getPointUpdate()
		 * 포인트 업데이트
		 * **/
		function getPointUpdateEx($param) {
			return parent::getPointUpdateEx($param);
		}


 		/**
		 * getPointUpdate()
		 * 포인트 업데이트
		 * **/
		function getPointUpdate() {
			return parent::getPointUpdate();
		}

    }
?>