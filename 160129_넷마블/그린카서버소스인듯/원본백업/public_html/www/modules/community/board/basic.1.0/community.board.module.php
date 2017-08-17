<?php
    /**
     * /home/shop_eng/www/modules/community/board/basic.1.0/community.board.module.php
     * @author eumshop(thav@naver.com)
     * community board module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityBoardModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community basic board module class";
		}

		function getBoardMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_ALL_LIST']	= "a.*";
			$column['OP_LIST']		= "a.*, b.BG_NAME";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query			= "SELECT %s FROM %s AS a LEFT OUTER JOIN %s AS b ON a.B_BG_NO = b.BG_NO WHERE a.B_CODE IS NOT NULL ";
			$query			= sprintf($query, $column[$op], "BOARD_MGR_NEW", "BOARD_GROUP_NEW");

			if($param['b_code']):
				$aryWhere[] = sprintf(" AND a.B_CODE = '%s'", $param['b_code']);
			endif;

			if($param['b_use'] == "Y" || $param['b_use'] == "N") :
				$aryWhere[] = sprintf(" AND a.B_USE = '%s'", $param['b_use']);
			endif;
			
			if($param['searchGroup']):
				$query	= sprintf("%s AND  B_BG_NO = '%s'", $query, $param['searchGroup']);
			endif;

			if($param['searchKey'] && $param['searchVal']):
				// 검색
				$searchVal		= $param['searchVal']; 
				$searchKey		= $param['searchKey']; 
				$searchKeyOp	= array(	"name"			=> "B_NAME LIKE ('%%{$searchVal}%%')",				
											"code"			=> "B_CODE LIKE ('%%{$searchVal}%%')",			);
				
				$search		= $searchKeyOp[$searchKey];
				if($search):
					$query	= sprintf("%s AND %s", $query, $search);
				endif;
			endif;

			if($param['orderby']) :
				$aryWhere[] = sprintf(" ORDER BY %s", $param['orderby']); 
			endif;

			if($param['page_line']) :
				$aryWhere[] = sprintf(" LIMIT %d, %d", $param['limit_first'], $param['page_line']);
			endif;

			if($op != "OP_ALL_LIST"):
				if(is_array($aryWhere)):
					foreach($aryWhere as $where):
						$query .= $where;
					endforeach;
				endif;
			endif;

			return $this->getSelectQuery($query, $op);
		}

		function getBoardMgrSelect($op="OP_LIST")
		{
			$column['OP_ALL_LIST']	= "a.*";
			$column['OP_LIST']		= "a.*, b.BG_NAME";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query			= "SELECT %s FROM %s AS a LEFT OUTER JOIN %s AS b ON a.B_BG_NO = b.BG_NO WHERE a.B_CODE IS NOT NULL ";
			$query			= sprintf($query, $column[$op], "BOARD_MGR_NEW", "BOARD_GROUP_NEW");

			if($this->field['b_code']):
				$aryWhere[] = sprintf(" AND a.B_CODE = '%s'", $this->field['b_code']);
			endif;

			if($this->field['b_use'] == "Y" || $this->field['b_use'] == "N") :
				$aryWhere[] = sprintf(" AND a.B_USE = '%s'", $this->field['b_use']);
			endif;
			
			if($this->field['searchGroup']):
				$query	= sprintf("%s AND  B_BG_NO = '%s'", $query, $this->field['searchGroup']);
			endif;

			if($this->field['searchKey'] && $this->field['searchVal']):
				// 검색
				$searchVal		= $this->field['searchVal']; 
				$searchKey		= $this->field['searchKey']; 
				$searchKeyOp	= array(	"name"			=> "B_NAME LIKE ('%%{$searchVal}%%')",				
											"code"			=> "B_CODE LIKE ('%%{$searchVal}%%')",			);
				
				$search		= $searchKeyOp[$searchKey];
				if($search):
					$query	= sprintf("%s AND %s", $query, $search);
				endif;
			endif;

			if($this->field['orderby']) :
				$aryWhere[] = sprintf(" ORDER BY %s", $this->field['orderby']); 
			endif;

			if($this->field['page_line']) :
				$aryWhere[] = sprintf(" LIMIT %d, %d", $this->field['limit_first'], $this->field['page_line']);
			endif;

			if($op != "OP_ALL_LIST"):
				if(is_array($aryWhere)):
					foreach($aryWhere as $where):
						$query .= $where;
					endforeach;
				endif;
			endif;

			return $this->getSelectQuery($query, $op);
		}

//		SELECT MAX(B_NO) AS MAX_B_NO FROM BOARD_MGR_NEW
		function getBoardMgrMAX_B_NO()
		{
			$query			= "SELECT MAX(B_NO) AS MAX_B_NO FROM BOARD_MGR_NEW";
			return $this->getSelectQuery($query, "OP_SELECT");
		}

		/********************************** Insert **********************************/
		function getBoardMgrInsert()
		{
			$query = "CALL SP_BOARD_MGR_NEW_I (?,?,?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->field['b_code'];
			$param[]  = $this->field['b_no'];
			$param[]  = $this->field['b_name'];
			$param[]  = $this->field['b_kind'];
			$param[]  = $this->field['b_skin'];
			$param[]  = $this->field['b_css'];
			$param[]  = $this->field['b_bg_no'];
			$param[]  = $this->field['b_use'];
			$param[]  = $this->field['b_reg_dt'];
			$param[]  = $this->field['b_reg_no'];
			$param[]  = $this->field['b_mod_dt'];
			$param[]  = $this->field['b_mod_no'];

			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getBoardMgrUpdate()
		{
			$query = "CALL SP_BOARD_MGR_NEW_U (?,?,?,?,?,?,?,?,?,?,?);";

			$param[]  = $this->field['b_code'];
			$param[]  = $this->field['b_name'];
			$param[]  = $this->field['b_kind'];
			$param[]  = $this->field['b_skin'];
			$param[]  = $this->field['b_css'];
			$param[]  = $this->field['b_bg_no'];
			$param[]  = $this->field['b_use'];
			$param[]  = $this->field['b_reg_dt'];
			$param[]  = $this->field['b_reg_no'];
			$param[]  = $this->field['b_mod_dt'];
			$param[]  = $this->field['b_mod_no'];

			return $this->db->executeBindingQuery($query,$param,true);
		}

		function getBoardMgrUseUpdate() {
			
			$query = "UPDATE %s SET B_USE = '%s', B_MOD_DT = NOW(), B_MOD_NO = %s WHERE B_CODE = '%s'";

			$strB_CODE		= mysql_real_escape_string($this->field['b_code']);
			$strB_USE		= mysql_real_escape_string($this->field['b_use']);
			$strB_MOD_NO	= $this->field['b_mod_no'];

			$query			= sprintf($query, "BOARD_MGR_NEW", $strB_USE, $strB_MOD_NO, $strB_CODE);

			return $this->db->getExecSql($query);
		}

		/********************************** Delete **********************************/
		function getBoardMgrDeleteCode($param)
		{
			if(!$param['b_code']) { return; }
			$where = "B_CODE = '{$param['b_code']}'";
			$this->db->getDelete("BOARD_MGR_NEW", $where);
		}

		/********************************** Create **********************************/
		//		ALTER TABLE `BOARD_MGR_NEW` ADD COLUMN `B_NO` BIGINT COMMENT '번호' AFTER `B_CODE`; -- 2013.07.18 kim hee sung 
		function getBoardMgrCreateTable() {

			$query = "CREATE TABLE `BOARD_MGR_NEW` (
					  `B_CODE` varchar(50) NOT NULL COMMENT '코드',
					  `B_NO` bigint(20) NOT NULL COMMENT '번호',
					  `B_NAME` varchar(50) DEFAULT NULL COMMENT '이름',
					  `B_KIND` varchar(10) DEFAULT NULL COMMENT '종류(일반,동영상,블러그..)',
					  `B_SKIN` varchar(10) DEFAULT NULL COMMENT '스킨',
					  `B_CSS` varchar(10) DEFAULT NULL COMMENT 'CSS',
					  `B_BG_NO` int(11) DEFAULT '-1' COMMENT '그룹번호',
					  `B_USE` varchar(1) DEFAULT 'Y' COMMENT '사용유무',
					  `B_REG_DT` datetime DEFAULT NULL COMMENT '작성일',
					  `B_REG_NO` bigint(20) DEFAULT NULL COMMENT '작성자',
					  `B_MOD_DT` datetime DEFAULT NULL COMMENT '수정일',
					  `B_MOD_NO` bigint(20) DEFAULT NULL COMMENT '수정자',
					  PRIMARY KEY (`B_CODE`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='게시판설정';";
					
			return $this->db->getExecSql($query);
		}

		function getBoardMgrCreateProcedure_I() {

			$query = "CREATE PROCEDURE `SP_BOARD_MGR_NEW_I`(
							 IN IN_B_CODE VARCHAR(50)
							,IN IN_B_NO INT
							,IN IN_B_NAME VARCHAR(50)
							,IN IN_B_KIND VARCHAR(10)
							,IN IN_B_SKIN VARCHAR(10)
							,IN IN_B_CSS VARCHAR(10)
							,IN IN_B_BG_NO INT
							,IN IN_B_USE VARCHAR(1)
							,IN IN_B_REG_DT DATETIME
							,IN IN_B_REG_NO INT
							,IN IN_B_MOD_DT DATETIME
							,IN IN_B_MOD_NO INT
						)
						BEGIN
							INSERT INTO BOARD_MGR_NEW (
								 B_CODE
								,B_NO
								,B_NAME
								,B_KIND
								,B_SKIN
								,B_CSS
								,B_BG_NO
								,B_REG_DT
								,B_REG_NO
								,B_MOD_DT
								,B_MOD_NO
							) VALUES (
								 IN_B_CODE
								,IN_B_NO
								,IN_B_NAME
								,IN_B_KIND
								,IN_B_SKIN
								,IN_B_CSS
								,IN_B_BG_NO
								,NOW()
								,IN_B_REG_NO
								,NOW()
								,IN_B_MOD_NO
							);
						END;";
			
			return $this->db->getExecSql($query);

		}

		function getBoardMgrCreateProcedure_U() {

			$query = "CREATE PROCEDURE `SP_BOARD_MGR_NEW_U`(
							 IN IN_B_CODE VARCHAR(50)
							,IN IN_B_NAME VARCHAR(50)
							,IN IN_B_KIND VARCHAR(10)
							,IN IN_B_SKIN VARCHAR(10)
							,IN IN_B_CSS VARCHAR(10)
							,IN IN_B_BG_NO INT
							,IN IN_B_USE VARCHAR(1)
							,IN IN_B_REG_DT DATETIME
							,IN IN_B_REG_NO INT
							,IN IN_B_MOD_DT DATETIME
							,IN IN_B_MOD_NO INT
						)
						BEGIN
							UPDATE BOARD_MGR_NEW SET
								 B_NAME = IN_B_NAME
								,B_KIND = IN_B_KIND
								,B_SKIN = IN_B_SKIN
								,B_CSS = IN_B_CSS
								,B_BG_NO = IN_B_BG_NO
								,B_USE = IN_B_USE
								,B_MOD_DT = NOW()
								,B_MOD_NO = IN_B_MOD_NO
							WHERE B_CODE = IN_B_CODE;
						END";
					
			return $this->db->getExecSql($query);

		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getBoardMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getBoardMgrDropProcedure_I() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_MGR_NEW_I`;";
			return $this->db->getExecSql($query);
		}

		function getBoardMgrDropProcedure_U() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_MGR_NEW_U`;";
			return $this->db->getExecSql($query);
		}
    }
?>
