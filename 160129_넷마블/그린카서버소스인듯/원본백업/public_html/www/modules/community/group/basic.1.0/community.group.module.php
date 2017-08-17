<?php
    /**
     * /home/shop_eng/www/modules/community/group/basic.1.0/community.group.module.php
     * @author eumshop(thav@naver.com)
     * community group module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityGroupModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community group module class (basic.1.0)";
		}

		function getGroupMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";
			$column['OP_ARYLIST']	= "a.BG_NO, a.BG_NAME";

			$query = "SELECT %s FROM %s AS a WHERE a.BG_NO IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_GROUP_NEW");

			if($this->field['bg_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.BG_NO = '%s'", $query, $this->field['bg_no']);
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
		function getGroupMgrInsert()
		{
			$query = "CALL SP_BOARD_GROUP_NEW_I (?,?,?,?,?,?,?,?);";

			$param[]  = $this->field['bg_no'];
			$param[]  = $this->field['bg_name'];
			$param[]  = $this->field['bg_file1'];
			$param[]  = $this->field['bg_file2'];
			$param[]  = $this->field['bg_reg_dt'];
			$param[]  = $this->field['bg_reg_no'];
			$param[]  = $this->field['bg_mod_dt'];
			$param[]  = $this->field['bg_mod_no']; 

			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getGroupMgrUpdate()
		{
			$query = "CALL SP_BOARD_GROUP_NEW_U (?,?,?,?,?,?,?,?);";

			$param[]  = $this->field['bg_no'];
			$param[]  = $this->field['bg_name'];
			$param[]  = $this->field['bg_file1'];
			$param[]  = $this->field['bg_file2'];
			$param[]  = $this->field['bg_reg_dt'];
			$param[]  = $this->field['bg_reg_no'];
			$param[]  = $this->field['bg_mod_dt'];
			$param[]  = $this->field['bg_mod_no'];

			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Delete **********************************/
		function getGroupMgrDelete(&$db)
		{
			$query		= "CALL SP_BOARD_GROUP_NEW_D (?);";
			$param[]	= $this->field['bg_no'];

			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Create **********************************/
		function getGroupMgrCreateTable() {

			$query = "CREATE TABLE `BOARD_GROUP_NEW` (
					  `BG_NO` int(11) NOT NULL AUTO_INCREMENT COMMENT '일련번호',
					  `BG_NAME` varchar(50) DEFAULT NULL COMMENT '그룹명',
					  `BG_FILE1` varchar(100) DEFAULT NULL COMMENT '대표이미지',
					  `BG_FILE2` varchar(100) DEFAULT NULL COMMENT '서브이미지',
					  `BG_REG_DT` datetime DEFAULT NULL COMMENT '등록일',
					  `BG_REG_NO` bigint(20) DEFAULT NULL COMMENT '등록자 ',
					  `BG_MOD_DT` datetime DEFAULT NULL COMMENT '수정일',
					  `BG_MOD_NO` bigint(20) DEFAULT NULL COMMENT '수정자',
					  PRIMARY KEY (`BG_NO`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='게시판그룹관리';";
					
			return $this->db->getExecSql($query);
		}

		function getGroupMgrCreateProcedure_I() {

			$query = "CREATE PROCEDURE `SP_BOARD_GROUP_NEW_I`(
							 IN IN_BG_NO INT
							,IN IN_BG_NAME VARCHAR(50)
							,IN IN_BG_FILE1 VARCHAR(100)
							,IN IN_BG_FILE2 VARCHAR(100)
							,IN IN_BG_REG_DT DATETIME
							,IN IN_BG_REG_NO INT
							,IN IN_BG_MOD_DT DATETIME
							,IN IN_BG_MOD_NO INT
						)
						BEGIN
							INSERT INTO BOARD_GROUP_NEW (
								 BG_NAME
								,BG_FILE1
								,BG_FILE2
								,BG_REG_DT
								,BG_REG_NO
								,BG_MOD_DT
								,BG_MOD_NO
							) VALUES (
								 IN_BG_NAME
								,IN_BG_FILE1
								,IN_BG_FILE2
								,NOW()
								,IN_BG_REG_NO
								,NOW()
								,IN_BG_MOD_NO
							);
						END";
			
			return $this->db->getExecSql($query);

		}

		function getGroupMgrCreateProcedure_U() {

			$query = "CREATE PROCEDURE `SP_BOARD_GROUP_NEW_U`(
							 IN IN_BG_NO INT
							,IN IN_BG_NAME VARCHAR(50)
							,IN IN_BG_FILE1 VARCHAR(100)
							,IN IN_BG_FILE2 VARCHAR(100)
							,IN IN_BG_REG_DT DATETIME
							,IN IN_BG_REG_NO INT
							,IN IN_BG_MOD_DT DATETIME
							,IN IN_BG_MOD_NO INT
						)
						BEGIN
							UPDATE BOARD_GROUP_NEW SET 
								 BG_NAME = IN_BG_NAME
								,BG_FILE1 = IN_BG_FILE1
								,BG_FILE2 = IN_BG_FILE2
								,BG_MOD_DT = NOW()
								,BG_MOD_NO = IN_BG_MOD_NO
							WHERE BG_NO = IN_BG_NO;
						END";
					
			return $this->db->getExecSql($query);

		}

		function getGroupMgrCreateProcedure_D() {

			$query = "CREATE PROCEDURE SP_BOARD_GROUP_NEW_D (
							 IN IN_BG_NO INT
						)
						BEGIN
							DELETE FROM BOARD_GROUP_NEW
							WHERE BG_NO = IN_BG_NO;
						END;";
					
			return $this->db->getExecSql($query);

		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getGroupMgrDropTable() {
			$query = "DROP TABLE BOARD_GROUP_NEW;";
			return $this->db->getExecSql($query);
		}

		function getGroupMgrDropProcedure_I() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_GROUP_NEW_I`;";
			return $this->db->getExecSql($query);
		}

		function getGroupMgrDropProcedure_U() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_GROUP_NEW_U`;";
			return $this->db->getExecSql($query);
		}

		function getGroupMgrDropProcedure_D() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_GROUP_NEW_D`;";
			return $this->db->getExecSql($query);
		}
    }
?>
