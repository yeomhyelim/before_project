<?php
    /**
     * /home/shop_eng/www/modules/community/attachedfile/basic.1.0/community.attachedfile.module.php
     * @author eumshop(thav@naver.com)
     * community attachedfile module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityAttachedfileModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community attachedfile module class (basic.1.0)";
		}

		function getAttachedfileMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query = "SELECT %s FROM %s AS a WHERE a.FL_NO IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_FL_{$param['b_code']}");

			if($param['fl_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.FL_NO = '%s'", $query, $param['fl_no']);
			endif;

			if($param['fl_ub_no']):
				$query = sprintf("%s AND a.FL_UB_NO = %s", $query, $param['fl_ub_no']);
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		function getAttachedfileMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query = "SELECT %s FROM %s AS a WHERE a.FL_NO IS NOT NULL ";
			$query = sprintf($query, $column[$op], $this->field['fl_table']);

			if($this->field['fl_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.FL_NO = '%s'", $query, $this->field['fl_no']);
			endif;

			if($this->field['fl_ub_no']):
				$query = sprintf("%s AND a.FL_UB_NO = %s", $query, $this->field['fl_ub_no']);
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
		function getAttachedfileMgrInsert()
		{		

//			$param['FL_NO']			= $this->field['fl_no'];
			$param['FL_UB_NO']		= $this->field['fl_ub_no'];
			$param['FL_KEY']		= $this->getSQLString($this->field['fl_key']);
			$param['FL_DIR']		= $this->getSQLString($this->field['fl_dir']);
			$param['FL_NAME']		= $this->getSQLString($this->field['fl_name']);
			$param['FL_TYPE']		= $this->getSQLString($this->field['fl_type']);
			$param['FL_SIZE']		= $this->getSQLInteger($this->field['fl_size']);
			$param['FL_REG_DT']		= "NOW()";
			$param['FL_REG_NO']		= $this->getSQLInteger($this->field['fl_mod_no']);
			$param['FL_MOD_DT']		= "NOW()";
			$param['FL_MOD_NO']		= $this->getSQLInteger($this->field['fl_mod_no']);

			return $this->db->getInsertParam($this->field['fl_table'],$param);
		}

		/********************************** Update **********************************/
		function getAttachedfileMgrUpdate()
		{

		}

		/********************************** Delete **********************************/
		function getAttachedfileMgrDelete($op="OP_FL_NO")
		{
			if($op == "OP_FL_NO")			{ $where = "FL_NO = {$this->field['fl_no']}";				}
			else if($op == "FL_UB_NO")		{ $where = "FL_UB_NO = {$this->field['fl_ub_no']}";			}
			
			if(!$where) { return; }

			return $this->db->getDelete($this->field['fl_table'], $where);
		}

		/********************************** Create **********************************/
		function getAttachedfileMgrCreateTable() {
			$query = "CREATE TABLE `{$this->field['tableName']}` (
						  `FL_NO` BIGINT NOT NULL AUTO_INCREMENT COMMENT '번호',
						  `FL_UB_NO` BIGINT COMMENT '게시판 번호',
						  `FL_KEY` VARCHAR(50) COMMENT '키',
						  `FL_DIR` VARCHAR(200) COMMENT '파일경로',
						  `FL_NAME` VARCHAR(100) COMMENT '파일이름',
						  `FL_TYPE` VARCHAR(20) COMMENT '파일형식',
						  `FL_SIZE` INT COMMENT '파일크기',
						  `FL_REG_DT` DATETIME COMMENT '작성일',
						  `FL_REG_NO` BIGINT COMMENT '작성자',
						  `FL_MOD_DT` DATETIME COMMENT '수정일',
						  `FL_MOD_NO` BIGINT COMMENT '수정자',
						  PRIMARY KEY(FL_NO)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='첨부파일';";
					
			return $this->db->getExecSql($query);
		}

		function getAttachedfileMgrCreateProcedure_I() {

		}

		function getAttachedfileMgrCreateProcedure_U() {

		}

		function getAttachedfileMgrCreateProcedure_D() {

		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getAttachedfileMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getAttachedfileMgrDropProcedure_I() {
		}

		function getAttachedfileMgrDropProcedure_U() {
		}

		function getAttachedfileMgrDropProcedure_D() {
		}
    }
?>
