<?php
    /**
     * /home/shop_eng/www/modules/coupon/issue/basic.1.0/coupon.issue.controller.php
     * @author eumshop(thav@naver.com)
     * coupon issue controller class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/coupon/coupon.controller.php";
	require_once MALL_HOME . "/modules/coupon/issue/basic.1.0/coupon.issue.module.php";

	require_once MALL_HOME . "/classes/string/string.func.class.php";

    class CouponIssueController extends CouponController {

		/**
		 * __construct(&$db, &$field)
		 * 생성자
		 * **/
		function __construct(&$db, &$field) {
			$this->module	= new CouponIssueModule($db, $field);
			$this->name		="CouponIssueMgr";
			$this->field	= &$field;
		}

		/**
		 * getMessage()
		 * 메시지
		 * **/
		function getMessage() {
			echo "coupon issue controller class (basic.1.0)";
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

 		/**
		 * getMakeCiCode($cu_no)
		 * unique CI_CODE 만들기
		 * **/
		function getMakeCiCode($cu_no) {

			## STEP 1.
			## 함수 선언
			$string						= new StringFunc();

			## STEP 2.
			## unique CI_CODE 생성
			for($i=0;$i<=100;$i++):
				$cl_code				= $string->getCode(10);
				$cl_code				= strtoupper($cl_code);
				$cl_code				= "{$this->field['bi_coupon_c_coupon']}{$cl_code}";
				$this->field['ci_code'] = $cl_code;
				$re						= $this->module->getCouponIssueMgrCiCodeCount();
				if($re == 0) { break; }
				if($re == -9999) { return; }
			endfor;
			if($i >= 100) { return; }
			return $cl_code;
		}

    }
?>