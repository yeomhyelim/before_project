<?php
    /**
     * /home/shop_eng/www/modules/point/data/basic.1.0/point.data.module.php
     * @author eumshop(thav@naver.com)
     * point data module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/point/point.module.php";

    class PointDataModule extends PointModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "point data module class (basic.1.0)";
		}
		
		function getPointMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$where = "";
			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], "POINT_MGR");

			if($param['pt_no']):	
				$where .= "AND a.PT_NO = {$param['pt_no']} ";	
			endif;

			if($where) { $query .= "WHERE a.PT_NO IS NOT NULL {$where}"; }

			return $this->getSelectQuery($query, $op);
		}

		/********************************** Insert **********************************/
		function getPointMgrInsertEx($paramData)
		{		
			$query = "CALL SP_POINT_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $paramData['m_no'];
			$param[]  = $paramData['b_no'];
			$param[]  = $paramData['o_no'];
			$param[]  = $paramData['pt_type'];
			$param[]  = $paramData['pt_point'];
			$param[]  = $paramData['pt_memo'];
			$param[]  = $paramData['pt_start_dt'];
			$param[]  = $paramData['pt_end_dt'];
			$param[]  = $paramData['pt_reg_ip'];
			$param[]  = $paramData['pt_etc'];
			$param[]  = $paramData['pt_reg_no'];

			$re = $this->db->executeBindingQuery($query,$param,true);
			if($re == 1) { return $this->db->getLastInsertID(); }
			return $re;
		}

		function getPointMgrInsert()
		{		
			$query = "CALL SP_POINT_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->field['m_no'];
			$param[]  = $this->field['b_no'];
			$param[]  = $this->field['o_no'];
			$param[]  = $this->field['pt_type'];
			$param[]  = $this->field['pt_point'];
			$param[]  = $this->field['pt_memo'];
			$param[]  = $this->field['pt_start_dt'];
			$param[]  = $this->field['pt_end_dt'];
			$param[]  = $this->field['pt_reg_ip'];
			$param[]  = $this->field['pt_etc'];
			$param[]  = $this->field['pt_reg_no'];

			$re = $this->db->executeBindingQuery($query,$param,true);
			if($re == 1) { return $this->db->getLastInsertID(); }
			return $re;
		}

		/********************************** Update **********************************/
		function getPointMgrUpdate()
		{
		}

		/********************************** Delete **********************************/
		function getPointMgrDelete()
		{
		}

		/********************************** Insert & Update *************************/
		function getPointMgrInsertUpdate() {
		}

		/********************************** Create **********************************/
		function getPointMgrCreateTable() {
		}

		function getPointMgrCreateProcedure_I() {
		}

		function getPointMgrCreateProcedure_U() {
		}

		function getPointMgrCreateProcedure_IU() {
		}

		function getPointMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getPointMgrDropTable() {
		}

		function getPointMgrDropProcedure_I() {
		}

		function getPointMgrDropProcedure_U() {
		}

		function getPointMgrDropProcedure_D() {
		}
    }
?>
