<?php
    /**
     * /home/shop_eng/www/modules/community/product/basic.1.0/community.product.module.php
     * @author eumshop(thav@naver.com)
     * community product module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityProductModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community product module class (basic.1.0)";
		}

		## 2013.04.08 신규 버전..

		function getProductMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";
			$product_img_use		= "Y";
			$product_mgr_use		= "Y";

			$query = "SELECT {COLUMN} FROM %s AS a ";
			$query = sprintf($query, "BOARD_UB_{$param['b_code']}");

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$column['OP_LIST']		= $column['OP_LIST'] . ", b.*";
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$param['b_code']}");			
			endif;

			if($this->field['BOARD_INFO']['bi_userfield_use'] == "Y"):		// 사용자 필드 사용하는 경우
				$column['OP_LIST']		= $column['OP_LIST'] . ", c.*";
				$join = "%s LEFT OUTER JOIN %s AS c ON a.UB_NO = c.AD_UB_NO";
				$query = sprintf($join, $query, "BOARD_AD_{$param['b_code']}");	
			endif;

			if($product_img_use == "Y"):									// 상품 이미지 사용하는 경우.
				$column['OP_LIST']		= $column['OP_LIST'] . ", d.PM_REAL_NAME";
				$join	= "%s LEFT OUTER JOIN %s AS d ON a.UB_P_CODE = d.P_CODE AND d.PM_TYPE = 'list'";
				$query	= sprintf($join, $query, "PRODUCT_IMG");	
			endif;

			if($product_mgr_use == "Y"):									// 상품 정보 테이블을 사용하는 경우
				$column['OP_LIST']		= $column['OP_LIST'] . ", e.P_NAME";
				$join	= "%s LEFT OUTER JOIN %s AS e ON a.UB_P_CODE = e.P_CODE";
				$query	= sprintf($join, $query, "PRODUCT_MGR");				
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($param['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $param['ub_no']);
			endif;

			if($param['ub_p_code']):
				$query = sprintf("%s AND a.UB_P_CODE = '%s'", $query, $param['ub_p_code']);
			endif;

			if($param['search_ub_reg_dt_op'] == "TODAY"):
				$query = sprintf("%s AND a.UB_REG_DT > curdate()", $query);
			endif;

			if($param['ub_m_no']):
				$query = sprintf("%s AND a.UB_ANS_NO IN (SELECT UB_NO FROM %s WHERE UB_M_NO = %s)", $query, "BOARD_UB_{$param['b_code']}", $param['ub_m_no']); 
			endif;

			if($param['ub_func_icon']):
				$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,3, 1) = '%s'", $query, $param['ub_func_icon']);	
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;
		
			$query = str_replace("{COLUMN}", $column[$op], $query);

//			 SUBSTR(UB_FUNC,3,1) = "Y"

			return $this->getSelectQuery($query, $op);
		}

		## 2013.04.08 이전 버전...

		// $this->field['BOARD_INFO']['bi_attachedfile_use']
		// select * from BOARD_UB_PROD_QNA as a LEFT OUTER JOIN PRODUCT_IMG as b ON a.UB_P_CODE = b.P_CODE where b.PM_TYPE = 'list'
		function getProductMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";
			$product_img_use		= "Y";
			$product_mgr_use		= "Y";

			$query = "SELECT {COLUMN} FROM %s AS a ";
			$query = sprintf($query, "BOARD_UB_{$this->field['b_code']}");

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$column['OP_LIST']		= $column['OP_LIST'] . ", b.*";
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$this->field['b_code']}");			
			endif;

			if($this->field['BOARD_INFO']['bi_userfield_use'] == "Y"):		// 사용자 필드 사용하는 경우
				$column['OP_LIST']		= $column['OP_LIST'] . ", c.*";
				$join = "%s LEFT OUTER JOIN %s AS c ON a.UB_NO = c.AD_UB_NO";
				$query = sprintf($join, $query, "BOARD_AD_{$this->field['b_code']}");	
			endif;

			if($product_img_use == "Y"):									// 상품 이미지 사용하는 경우.
				$column['OP_LIST']		= $column['OP_LIST'] . ", d.PM_REAL_NAME";
				$join	= "%s LEFT OUTER JOIN %s AS d ON a.UB_P_CODE = d.P_CODE AND d.PM_TYPE = 'list'";
				$query	= sprintf($join, $query, "PRODUCT_IMG");	
			endif;

			if($product_mgr_use == "Y"):									// 상품 정보 테이블을 사용하는 경우
				$column['OP_LIST']		= $column['OP_LIST'] . ", e.P_NAME";
				$join	= "%s LEFT OUTER JOIN %s AS e ON a.UB_P_CODE = e.P_CODE";
				$query	= sprintf($join, $query, "PRODUCT_MGR");				
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($this->field['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $this->field['ub_no']);
			endif;

			if($this->field['ub_p_code']):
				$query = sprintf("%s AND a.UB_P_CODE = '%s'", $query, $this->field['ub_p_code']);
			endif;

			if($this->field['search_ub_reg_dt_op'] == "TODAY"):
				$query = sprintf("%s AND a.UB_REG_DT > curdate()", $query);
			endif;

			if($this->field['ub_m_no']):
				$query = sprintf("%s AND a.UB_ANS_NO IN (SELECT UB_NO FROM %s WHERE UB_M_NO = %s)", $query, "BOARD_UB_{$this->field['b_code']}", $this->field['ub_m_no']); 
			endif;

			if($this->field['ub_func_icon']):
				$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,3, 1) = '%s'", $query, $this->field['ub_func_icon']);	
			endif;

			if($this->field['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $this->field['orderby']); 
			endif;

			if($this->field['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->field['limit_first'], $this->field['page_line']);
			endif;
		
			$query = str_replace("{COLUMN}", $column[$op], $query);

//			 SUBSTR(UB_FUNC,3,1) = "Y"

			return $this->getSelectQuery($query, $op);
		}

		function getProductMgrAnsStepMaxSelect()
		{
			$query = "SELECT MAX(UB_ANS_STEP) as UB_ANS_STEP FROM %s";
			$where = "%s WHERE UB_ANS_NO = %s AND UB_ANS_STEP LIKE '%s%%'";
			
			$query = sprintf($query, $this->field['ub_table']);
			$query = sprintf($where, $query, $this->field['ub_ans_no'], $this->field['ub_ans_step']);

			return $this->getSelectQuery($query, "OP_SELECT");
		}

			

		/********************************** Insert **********************************/
		function getProductMgrInsert()
		{	
//			$param['UB_NO']			= $this->field['ub_no'];
			$param['UB_NAME']		= $this->getSQLString($this->field['ub_name']);
			$param['UB_M_NO']		= $this->getSQLString($this->field['ub_m_no']);
			$param['UB_M_ID']		= $this->getSQLString($this->field['ub_m_id']);
			$param['UB_PASS']		= $this->getSQLString($this->field['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($this->field['ub_mail']);
			$param['UB_URL']		= $this->getSQLString($this->field['ub_url']);
			$param['UB_TITLE']		= $this->getSQLString($this->field['ub_title']);
			$param['UB_TEXT']		= $this->getSQLString($this->field['ub_text']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_READ']		= $this->getSQLInteger($this->field['ub_read']);
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);	
			$param['UB_ANS_NO']		= $this->getSQLInteger($this->field['ub_ans_no']);	
			$param['UB_ANS_STEP']	= $this->getSQLString($this->field['ub_ans_step']);	
			$param['UB_P_CODE']		= $this->getSQLString($this->field['ub_p_code']);	
			$param['UB_P_GRADE']	= $this->getSQLInteger($this->field['ub_p_grade']);	
			$param['UB_REG_DT']		= "NOW()";
			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);
			
			return $this->db->getInsertParam($this->field['ub_table'],$param);
		}

		/********************************** Update **********************************/
		function getProductMgrUpdate()
		{
//			$param['UB_NO']			= $this->field['ub_no'];
//			$param['UB_M_NO']		= $this->getSQLString($this->field['ub_m_no']);
//			$param['UB_M_ID']		= $this->getSQLString($this->field['ub_m_id']);
//			$param['UB_READ']		= $this->getSQLInteger($this->field['ub_read']);
//			$param['UB_REG_DT']		= "NOW()";
//			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
//			$param['UB_ANS_NO']		= $this->getSQLInteger($this->field['ub_ans_no']);	
//			$param['UB_ANS_STEP']	= $this->getSQLString($this->field['ub_ans_step']);	
			$param['UB_NAME']		= $this->getSQLString($this->field['ub_name']);
			$param['UB_PASS']		= $this->getSQLString($this->field['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($this->field['ub_mail']);
			$param['UB_URL']		= $this->getSQLString($this->field['ub_url']);
			$param['UB_TITLE']		= $this->getSQLString($this->field['ub_title']);
			$param['UB_TEXT']		= $this->getSQLString($this->field['ub_text']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_P_GRADE']	= $this->getSQLInteger($this->field['ub_p_grade']);	
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);

			$where					= "UB_NO = {$this->field['ub_no']}";
	
			return $this->db->getUpdateParam($this->field['ub_table'], $param, $where);
		}

		function getProductMgrAnsNoUpdate()
		{
			$field = "UB_ANS_NO = {$this->field['ub_ans_no']}";
			$where = "WHERE  UB_NO = {$this->field['ub_no']}";
			
			return $this->db->getUpdateSql($this->field['ub_table'], $field, $where);
		}

		function getProductMgrReadUpdate()
		{
			$field = "UB_READ = UB_READ + 1";
			$where = "WHERE  UB_NO = {$this->field['ub_no']}";
			
			return $this->db->getUpdateSql($this->field['ub_table'], $field, $where);
		}

		function getProductMgrPointUpdateEx($paramData) {
			$strTableName			= "BOARD_UB_{$paramData['b_code']}";
			$param['UB_PT_NO']		= $this->getSQLInteger($paramData['ub_pt_no']);
			$param['UB_WINNER']		= $this->getSQLString($paramData['ub_winner']);
			
			$where					= "UB_NO = {$paramData['ub_no']}";
			return $this->db->getUpdateParam($strTableName, $param, $where);
		}

		function getProductMgrCouponUpdateEx($paramData) {
			$strTableName			= "BOARD_UB_{$paramData['b_code']}";
			$param['UB_CI_NO']		= $this->getSQLInteger($paramData['ub_ci_no']);
			$param['UB_WINNER']		= $this->getSQLString($paramData['ub_winner']);
			
			$where					= "UB_NO = {$paramData['ub_no']}";
			return $this->db->getUpdateParam($strTableName, $param, $where);
		}

		/********************************** Delete **********************************/
		function getProductMgrDelete(&$db)
		{
			$where					= "UB_NO = {$this->field['ub_no']}";
			
			if($this->field['ub_ans_no'] && $this->field['ub_ans_no']):
				$where				= "UB_ANS_NO = {$this->field['ub_ans_no']} AND UB_ANS_STEP LIKE '{$this->field['ub_ans_step']}%'";
			endif;

			$this->db->getDelete("BOARD_UB_{$this->field['b_code']}", $where);
		}

		/********************************** Create **********************************/
// ALTER TABLE `linksjeans`.`BOARD_UB_PROD_QNA` ADD COLUMN `UB_P_GRADE` SMALLINT COMMENT '상품-평점' AFTER `UB_P_CODE`;
		function getProductMgrCreateTable() {

			$query = "CREATE TABLE `{$this->field['ub_table']}` (
					  `UB_NO` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '번호',
					  `UB_NAME` varchar(20) DEFAULT NULL COMMENT '이름',
					  `UB_M_NO` bigint(20) DEFAULT NULL COMMENT '회원번호',
					  `UB_M_ID` varchar(20) DEFAULT NULL COMMENT '아이디',
					  `UB_PASS` varchar(100) DEFAULT NULL COMMENT '비밀번호',
					  `UB_MAIL` varchar(50) DEFAULT NULL COMMENT '이메일',
					  `UB_URL` varchar(200) DEFAULT NULL COMMENT '웹주소',
					  `UB_TITLE` varchar(200) DEFAULT NULL COMMENT '제목',
					  `UB_TEXT` text COMMENT '내용',
					  `UB_FUNC` varchar(20) DEFAULT '0000000000' COMMENT '기능(공지글, 비밀글..)',
					  `UB_IP` varchar(20) DEFAULT NULL COMMENT 'IP',
					  `UB_READ` int(11) DEFAULT '0' COMMENT '조회수',
					  `UB_BC_NO` bigint(20) DEFAULT '0' COMMENT '카테고리 번호',
					  `UB_ANS_NO` bigint(20) default NULL COMMENT '계층형-최상위글 번호',
					  `UB_ANS_STEP` varbinary(100) default NULL COMMENT '계층형-답변모양',
					  `UB_P_CODE` varchar(20) DEFAULT NULL COMMENT '상품-코드',
					  `UB_P_GRADE` smallint(6) DEFAULT '0' COMMENT '상품-평점',		
					  `UB_PT_NO` bigint(20) default NULL COMMENT '이벤트-포인트 번호',
					  `UB_CI_NO` bigint(20) default NULL COMMENT '이벤트-쿠폰 번호',
					  `UB_WINNER` varchar(1) default NULL COMMENT '이벤트-담청자',					  
					  `UB_REG_DT` datetime DEFAULT NULL COMMENT '작성일',
					  `UB_REG_NO` bigint(20) DEFAULT NULL COMMENT '작성자',
					  `UB_MOD_DT` datetime DEFAULT NULL COMMENT '수정일',
					  `UB_MOD_NO` bigint(20) DEFAULT NULL COMMENT '수정자',
					  PRIMARY KEY (`UB_NO`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='{$this->field['b_name']}';";
					
			return $this->db->getExecSql($query);
		}

		function getProductMgrCreateProcedure_I() {
		}

		function getProductMgrCreateProcedure_U() {
		}

		function getProductMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getDataMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getProductMgrDropProcedure_I() {
		}

		function getProductMgrDropProcedure_U() {
		}

		function getProductMgrDropProcedure_D() {
		}
    }
?>
