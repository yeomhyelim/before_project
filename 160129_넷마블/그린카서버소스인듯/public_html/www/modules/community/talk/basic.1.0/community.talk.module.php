<?php
    /**
     * /home/shop_eng/www/modules/community/talk/basic.1.0/community.data.module.php
     * @author eumshop(thav@naver.com)
     * community talk module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityTalkModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community talk module class (basic.1.0)";
		}

		function getTalkMgrSelectEx($op="OP_LIST", $param)
		{

			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], "BOARD_UB_{$param['b_code']}");

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'list'";
				$query = sprintf($join, $query, $param['fl_table']);			
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($param['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $param['ub_no']);
			endif;

			if($param['ub_pass'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_PASS = '%s'", $query, $param['ub_pass']);
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		function getTalkMgrSelect($op="OP_LIST")
		{

			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], $this->field['ub_table']);

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'list'";
				$query = sprintf($join, $query, $this->field['fl_table']);			
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($this->field['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $this->field['ub_no']);
			endif;

			if($this->field['ub_pass'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_PASS = '%s'", $query, $this->field['ub_pass']);
			endif;

			if($this->field['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $this->field['orderby']); 
			endif;

			if($this->field['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->field['limit_first'], $this->field['page_line']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		/********************************** Insert **********************************/
		function getTalkMgrInsert()
		{		
//			$param['UB_NO']			= $this->field['ub_no'];
			$param['UB_NAME']		= $this->getSQLString($this->field['ub_name']);
			$param['UB_M_NO']		= $this->getSQLString($this->field['ub_m_no']);
			$param['UB_M_ID']		= $this->getSQLString($this->field['ub_m_id']);
			$param['UB_PASS']		= $this->getSQLString($this->field['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($this->field['ub_mail']);
			$param['UB_TALK']		= $this->getSQLString($this->field['ub_talk']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);
			$param['UB_REG_DT']		= "NOW()";
			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);

			return $this->db->getInsertParam($this->field['ub_table'],$param);
		}

		/********************************** Update **********************************/
		function getTalkMgrUpdate()
		{
//			$param['UB_NO']			= $this->field['ub_no'];
//			$param['UB_M_NO']		= $this->getSQLString($this->field['ub_m_no']);
//			$param['UB_M_ID']		= $this->getSQLString($this->field['ub_m_id']);
//			$param['UB_READ']		= $this->getSQLInteger($this->field['ub_read']);
//			$param['UB_REG_DT']		= "NOW()";
//			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
			$param['UB_NAME']		= $this->getSQLString($this->field['ub_name']);
			$param['UB_PASS']		= $this->getSQLString($this->field['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($this->field['ub_mail']);
			$param['UB_TALK']		= $this->getSQLString($this->field['ub_talk']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);

			$where					= "UB_NO = {$this->field['ub_no']}";
	
			return $this->db->getUpdateParam($this->field['ub_table'], $param, $where);
		}

		/********************************** Delete **********************************/
		function getTalkMgrDelete(&$db)
		{
			$where					= "UB_NO = {$this->field['ub_no']}";
			$this->db->getDelete($this->field['ub_table'], $where);
		}

		/********************************** Create **********************************/
		function getTalkMgrCreateTable() {

			$query = "CREATE TABLE `{$this->field['tableName']}` (
					  `UB_NO` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '번호',
					  `UB_NAME` varchar(20) DEFAULT NULL COMMENT '이름',
					  `UB_M_NO` bigint(20) DEFAULT NULL COMMENT '회원번호',
					  `UB_M_ID` varchar(20) DEFAULT NULL COMMENT '아이디',
					  `UB_PASS` varchar(100) DEFAULT NULL COMMENT '비밀번호',
					  `UB_MAIL` varchar(50) DEFAULT NULL COMMENT '이메일',
					  `UB_TALK` varchar(500) DEFAULT NULL COMMENT '토크',
					  `UB_FUNC` varchar(20) DEFAULT '0000000000' COMMENT '기능(공지글, 비밀글..)',
					  `UB_IP` varchar(20) DEFAULT NULL COMMENT 'IP',
					  `UB_BC_NO` bigint(20) DEFAULT '0' COMMENT '카테고리 번호',
					  `UB_REG_DT` datetime DEFAULT NULL COMMENT '작성일',
					  `UB_REG_NO` bigint(20) DEFAULT NULL COMMENT '작성자',
					  `UB_MOD_DT` datetime DEFAULT NULL COMMENT '수정일',
					  `UB_MOD_NO` bigint(20) DEFAULT NULL COMMENT '수정자',
					  PRIMARY KEY (`UB_NO`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='{$this->field['b_name']}';";
					
			return $this->db->getExecSql($query);
		}

		function getTalkMgrCreateProcedure_I() {
		}

		function getTalkMgrCreateProcedure_U() {
		}

		function getTalkMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getTalkMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getTalkMgrDropProcedure_I() {
		}

		function getTalkMgrDropProcedure_U() {
		}

		function getTalkMgrDropProcedure_D() {
		}
    }
?>
