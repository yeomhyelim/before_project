<?php
    /**
     * /home/shop_eng/www/modules/coupon/issue/basic.1.0/coupon.issue.module.php
     * @author eumshop(thav@naver.com)
     * coupon issue module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/coupon/coupon.module.php";

    class CouponIssueModule extends CouponModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "coupon issue module class (basic.1.0)";
		}

		/********************************** Select **********************************/
		function getCouponIssueMgrSelect($op="OP_LIST")
		{
		}

		function getCouponIssueMgrCiCodeCount()
		{
			$query = "SELECT COUNT(*) FROM COUPON_ISSUE AS a WHERE a.CI_CODE = '{$this->field['ci_code']}'";
			return $this->getSelectQuery($query, "OP_COUNT");
		}

		/********************************** Insert **********************************/
		function getCouponIssueMgrInsertEx($paramData)
		{		
			$query = "CALL SP_COUPON_ISSUE_I (?,?,?,?,?,?);";

			$param[]  = $paramData['m_no'];
			$param[]  = $paramData['cu_no'];
			$param[]  = $paramData['b_no'];
			$param[]  = $paramData['ci_code'];
			$param[]  = $paramData['ci_memo'];
			$param[]  = $paramData['ci_reg_no'];

			$re = $this->db->executeBindingQuery($query,$param,true);
			if($re == 1) { return $this->db->getLastInsertID(); }
			return $re;
		}

		function getCouponIssueMgrInsert()
		{		
			$query = "CALL SP_COUPON_ISSUE_I (?,?,?,?,?,?);";

			$param[]  = $this->field['m_no'];
			$param[]  = $this->field['cu_no'];
			$param[]  = $this->field['b_no'];
			$param[]  = $this->field['ci_code'];
			$param[]  = $this->field['ci_memo'];
			$param[]  = $this->field['ci_reg_no'];

			$re = $this->db->executeBindingQuery($query,$param,true);
			if($re == 1) { return $this->db->getLastInsertID(); }
			return $re;
		}

		/********************************** Update **********************************/
		function getCouponIssueMgrUpdate()
		{
		}

		/********************************** Delete **********************************/
		function getCouponIssueMgrDeleteEx($param)
		{
			if($param['ci_no']):
				$where			= "CI_NO = {$param['ci_no']}";
			endif;

			if(!$where) { return; }

			$this->db->getDelete("COUPON_ISSUE", $where);
		}

		/********************************** Insert & Update *************************/
		function getCouponIssueMgrInsertUpdate() {
		}

		/********************************** Create **********************************/
		function getCouponIssueMgrCreateTable() {
		}

		function getCouponIssueMgrCreateProcedure_I() {
		}

		function getCouponIssueMgrCreateProcedure_U() {
		}

		function getCouponIssueMgrCreateProcedure_IU() {
		}

		function getCouponIssueMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getCouponIssueMgrDropTable() {
		}

		function getCouponIssueMgrDropProcedure_I() {
		}

		function getCouponIssueMgrDropProcedure_U() {
		}

		function getCouponIssueMgrDropProcedure_D() {
		}
    }
?>
