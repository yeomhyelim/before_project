<?php
    /**
     * /home/shop_eng/www/modules/coupon/data/basic.1.0/coupon.data.controller.php
     * @author eumshop(thav@naver.com)
     * coupon data controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/coupon/coupon.controller.php";
	require_once MALL_HOME . "/modules/coupon/data/basic.1.0/coupon.data.module.php";

    class CouponDataController extends CouponController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CouponDataModule($db, $field);
			$this->name		="CouponDataMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "coupon data controller class (basic.1.0)";
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