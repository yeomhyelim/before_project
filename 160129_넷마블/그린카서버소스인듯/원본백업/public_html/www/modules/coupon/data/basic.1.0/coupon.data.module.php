<?php
    /**
     * /home/shop_eng/www/modules/coupon/data/basic.1.0/coupon.data.module.php
     * @author eumshop(thav@naver.com)
     * coupon data module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/coupon/coupon.module.php";

    class CouponDataModule extends CouponModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "coupon data module class (basic.1.0)";
		}

		function getCouponMgrSelect($op="OP_LIST")
		{
		}

		/********************************** Insert **********************************/
		function getCouponDataMgrInsert()
		{		
			$query = "CALL SP_COUPON_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->field['cu_name'];
			$param[]  = $this->field['cu_text'];
			$param[]  = $this->field['cu_type'];
			$param[]  = $this->field['cu_issue'];
			$param[]  = $this->field['cu_price'];
			$param[]  = $this->field['cu_price_off'];
			$param[]  = $this->field['cu_use'];
			$param[]  = $this->field['cu_img_mth'];
			$param[]  = $this->field['cu_img_path'];
			$param[]  = $this->field['cu_period'];
			$param[]  = $this->field['cu_start_dt'];
			$param[]  = $this->field['cu_end_dt'];
			$param[]  = $this->field['cu_use_day'];
			$param[]  = $this->field['cu_limit_price'];
			$param[]  = $this->field['cu_limit_settle'];
			$param[]  = $this->field['cu_limit_member'];
			$param[]  = $this->field['cu_useyn'];
			$param[]  = $this->field['cu_reg_no'];

			$re = $this->db->executeBindingQuery($query,$param,true);
			if($re == 1) { return $this->db->getLastInsertID(); }
			return $re;
		}

		/********************************** Update **********************************/
		function getCouponDataMgrUpdate()
		{
		}

		/********************************** Delete **********************************/
		function getCouponDataMgrDelete()
		{
		}

		/********************************** Insert & Update *************************/
		function getCouponDataMgrInsertUpdate() {
		}

		/********************************** Create **********************************/
		function getCouponDataMgrCreateTable() {
		}

		function getCouponDataMgrCreateProcedure_I() {
		}

		function getCouponDataMgrCreateProcedure_U() {
		}

		function getCouponDataMgrCreateProcedure_IU() {
		}

		function getCouponDataMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getCouponDataMgrDropTable() {
		}

		function getCouponDataMgrDropProcedure_I() {
		}

		function getCouponDataMgrDropProcedure_U() {
		}

		function getCouponDataMgrDropProcedure_D() {
		}
    }
?>
