<?php
    /**
     * /home/shop_eng/www/modules/coupon/coupon.controller.php
     * @author eumshop(thav@naver.com)
     * coupon controller class
     * **/

	require_once MALL_HOME . "/modules/controller.php";

    class  CouponController extends Controller {

		function getMessage() {
			echo "coupon controller class";
		}
		/**
		 * getCouponUpdate()
		 * 포인트 업데이트
		 * **/
		function getCouponUpdate() {
			return $this->module->{"get{$this->name}CouponUpdate"}();
		}
    }
?>
