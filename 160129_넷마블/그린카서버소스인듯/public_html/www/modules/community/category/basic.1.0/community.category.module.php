<?php
    /**
     * /home/shop_eng/www/modules/community/category/basic.1.0/community.category.module.php
     * @author eumshop(thav@naver.com)
     * community category module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityCategoryModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community category module class (basic.1.0)";
		}

		## 2013.04.08 신규 버전..

		function getCategoryMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";
			$column['OP_ARYLIST']	= "a.BC_NO, a.BC_NAME";

			$query = "SELECT %s FROM %s AS a WHERE a.BC_NO IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_CATEGORY");

			if($param['bc_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.BC_NO = '%s'", $query, $param['bc_no']);
			endif;

			if($param['bc_b_code']):
				$query = sprintf("%s AND a.BC_B_CODE = '%s'", $query, $param['bc_b_code']);
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;
	
			return $this->getSelectQuery($query, $op);
		}

		## 2013.04.08 이전 버전...

		function getCategoryMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";
			$column['OP_ARYLIST']	= "a.BC_NO, a.BC_NAME";

			$query = "SELECT %s FROM %s AS a WHERE a.BC_NO IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_CATEGORY");

			if($this->field['bc_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.BC_NO = '%s'", $query, $this->field['bc_no']);
			endif;

			if($this->field['bc_b_code']):
				$query = sprintf("%s AND a.BC_B_CODE = '%s'", $query, $this->field['bc_b_code']);
			endif;

			if($this->field['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $this->field['orderby']); 
			endif;

/** 2013.04.17 카테고리 페이지 분리 사용 안함. (이유: 관리자 카테고리 설정에서 page 인자를 이미 사용 하고 있음.) **/
//			if($this->field['page_line']) :
//				$query = sprintf("%s LIMIT %d, %d", $query, $this->field['limit_first'], $this->field['page_line']);
//			endif;
		
			return $this->getSelectQuery($query, $op);
		}



		/********************************** Insert **********************************/
		function getCategoryMgrInsert()
		{		
			$query = "CALL SP_BOARD_CATEGORY_I (?,?,?,?,?,?,?,?,?,?)";

			$param[]  = $this->field['bc_no'];
			$param[]  = $this->field['bc_b_code'];
			$param[]  = $this->field['bc_name'];
			$param[]  = $this->field['bc_image_1'];
			$param[]  = $this->field['bc_image_2'];
			$param[]  = $this->field['bc_sort'];
			$param[]  = $this->field['bc_reg_dt'];
			$param[]  = $this->field['bc_reg_no']; 
			$param[]  = $this->field['bc_mod_dt'];
			$param[]  = $this->field['bc_mod_no']; 

			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Update **********************************/
		function getCategoryMgrUpdate()
		{
			$query = "CALL SP_BOARD_CATEGORY_U (?,?,?,?,?,?,?,?,?,?)";

			$param[]  = $this->field['bc_no'];
			$param[]  = $this->field['bc_b_code'];
			$param[]  = $this->field['bc_name'];
			$param[]  = $this->field['bc_image_1'];
			$param[]  = $this->field['bc_image_2'];
			$param[]  = $this->field['bc_sort'];
			$param[]  = $this->field['bc_reg_dt'];
			$param[]  = $this->field['bc_reg_no']; 
			$param[]  = $this->field['bc_mod_dt'];
			$param[]  = $this->field['bc_mod_no']; 

			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Delete **********************************/
		function getCategoryMgrDelete($op="OP_BC_NO")
		{
			$query		= "CALL SP_BOARD_CATEGORY_D (?);";
			$param[]	= $this->field['bc_no'];

			return $this->db->executeBindingQuery($query,$param,true);
		}

		function getCategoryMgrDeleteCode($param)
		{
			if(!$param['bc_b_code']) { return; }
			$where = "BC_B_CODE = '{$param['bc_b_code']}'";
			$this->db->getDelete("BOARD_CATEGORY", $where);
		}

		/********************************** Create **********************************/
		function getCategoryMgrCreateTable() {
			$query = "CREATE TABLE `BOARD_CATEGORY` (
						  `BC_NO` BIGINT NOT NULL AUTO_INCREMENT COMMENT '번호',
						  `BC_B_CODE` VARCHAR(50) COMMENT '게시판 코드',
						  `BC_NAME` VARCHAR(50) COMMENT '이름',
						  `BC_IMAGE_1` VARCHAR(100) COMMENT '이미지1',
						  `BC_IMAGE_2` VARCHAR(100) COMMENT '이미지2',
						  `BC_SORT` INT COMMENT '정렬',
						  `BC_REG_DT` DATETIME COMMENT '작성일',
						  `BC_REG_NO` BIGINT COMMENT '작성자',
						  `BC_MOD_DT` DATETIME COMMENT '수정일',
						  `BC_MOD_NO` BIGINT COMMENT '수정자',
						  PRIMARY KEY(BC_NO)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='게시판카테고리';";
					
			return $this->db->getExecSql($query);
		}

		function getCategoryMgrCreateProcedure_I() {
			$query = "CREATE PROCEDURE SP_BOARD_CATEGORY_I (
							 IN IN_BC_NO INT
							,IN IN_BC_B_CODE VARCHAR(50)
							,IN IN_BC_NAME VARCHAR(50)
							,IN IN_BC_IMAGE_1 VARCHAR(100)
							,IN IN_BC_IMAGE_2 VARCHAR(100)
							,IN IN_BC_SORT INT
							,IN IN_BC_REG_DT DATETIME
							,IN IN_BC_REG_NO INT
							,IN IN_BC_MOD_DT DATETIME
							,IN IN_BC_MOD_NO INT
						)
						BEGIN
							INSERT INTO BOARD_CATEGORY (
								 BC_B_CODE
								,BC_NAME
								,BC_IMAGE_1
								,BC_IMAGE_2
								,BC_SORT
								,BC_REG_DT
								,BC_REG_NO
								,BC_MOD_DT
								,BC_MOD_NO
							) VALUES (
								 IN_BC_B_CODE
								,IN_BC_NAME
								,IN_BC_IMAGE_1
								,IN_BC_IMAGE_2
								,IN_BC_SORT
								,NOW()
								,IN_BC_REG_NO
								,NOW()
								,IN_BC_MOD_NO
							);
						END;";
			
			return $this->db->getExecSql($query);
		}

		function getCategoryMgrCreateProcedure_U() {
			$query = "CREATE PROCEDURE SP_BOARD_CATEGORY_U (
							 IN IN_BC_NO INT
							,IN IN_BC_B_CODE VARCHAR(50)
							,IN IN_BC_NAME VARCHAR(50)
							,IN IN_BC_IMAGE_1 VARCHAR(100)
							,IN IN_BC_IMAGE_2 VARCHAR(100)
							,IN IN_BC_SORT INT
							,IN IN_BC_REG_DT DATETIME
							,IN IN_BC_REG_NO INT
							,IN IN_BC_MOD_DT DATETIME
							,IN IN_BC_MOD_NO INT
						)
						BEGIN
							UPDATE BOARD_CATEGORY SET 
								 BC_B_CODE = IN_BC_B_CODE
								,BC_NAME = IN_BC_NAME
								,BC_IMAGE_1 = IN_BC_IMAGE_1
								,BC_IMAGE_2 = IN_BC_IMAGE_2
								,BC_SORT = IN_BC_SORT
								,BC_MOD_DT = NOW()
								,BC_MOD_NO = IN_BC_MOD_NO
							WHERE BC_NO = IN_BC_NO;
						END;";
					
			return $this->db->getExecSql($query);
		}

		function getCategoryMgrCreateProcedure_D() {
			$query = "CREATE PROCEDURE SP_BOARD_CATEGORY_D (
							 IN IN_BC_NO INT
						)
						BEGIN
							DELETE FROM BOARD_CATEGORY
							WHERE BC_NO = IN_BC_NO;
						END;";
					
			return $this->db->getExecSql($query);
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getCategoryMgrDropTable() {
			$query = "DROP TABLE BOARD_CATEGORY;";
			return $this->db->getExecSql($query);
		}

		function getCategoryMgrDropProcedure_I() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_CATEGORY_I`;";
			return $this->db->getExecSql($query);
		}

		function getCategoryMgrDropProcedure_U() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_CATEGORY_U`;";
			return $this->db->getExecSql($query);
		}

		function getCategoryMgrDropProcedure_D() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_CATEGORY_D`;";
			return $this->db->getExecSql($query);
		}
    }
?>
