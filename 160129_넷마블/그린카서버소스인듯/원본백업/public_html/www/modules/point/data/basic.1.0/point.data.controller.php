<?php
    /**
     * /home/shop_eng/www/modules/point/data/basic.1.0/point.data.controller.php
     * @author eumshop(thav@naver.com)
     * point data controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/point/point.controller.php";
	require_once MALL_HOME . "/modules/point/data/basic.1.0/point.data.module.php";

    class PointDataController extends PointController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new PointDataModule($db, $field);
			$this->name		="PointMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "point data controller class (basic.1.0)";
		}

 		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWriteEx($param) {
			return parent::getWriteEx($param);
		}

 		/**
		 * getWrite()
		 * 데이터 등록
		 * **/
		function getWrite() {
			return parent::getWrite();
		}

    }
?>