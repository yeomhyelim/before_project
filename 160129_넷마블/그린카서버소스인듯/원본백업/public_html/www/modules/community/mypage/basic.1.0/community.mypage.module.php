<?php
    /**
     * /home/shop_eng/www/modules/community/mypage/basic.1.0/community.mypage.module.php
     * @author eumshop(thav@naver.com)
     * community mypage module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityMypageModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community mypage module class (basic.1.0)";
		}

		function getMypageMgrSelectEx($op="OP_LIST", $param) {
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], "BOARD_UB_{$param['b_code']}");

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$param['b_code']}");			
			endif;

			if($this->field['BOARD_INFO']['bi_userfield_use'] == "Y"):		// 사용자 필드 사용하는 경우
				$join = "%s LEFT OUTER JOIN %s AS c ON a.UB_NO = c.AD_UB_NO";
				$query = sprintf($join, $query, "BOARD_AD_{$param['b_code']}");	
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($param['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $param['ub_no']);
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

			return $this->getSelectQuery($query, $op);
		}

		function getMypageMgrSelect($op="OP_LIST") {
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], "BOARD_UB_{$this->field['b_code']}");

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$this->field['b_code']}");			
			endif;

			if($this->field['BOARD_INFO']['bi_userfield_use'] == "Y"):		// 사용자 필드 사용하는 경우
				$join = "%s LEFT OUTER JOIN %s AS c ON a.UB_NO = c.AD_UB_NO";
				$query = sprintf($join, $query, "BOARD_AD_{$this->field['b_code']}");	
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($this->field['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $this->field['ub_no']);
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

			return $this->getSelectQuery($query, $op);
		}

		function getMypageMgrAnsStepMaxSelect()
		{
			$query = "SELECT MAX(UB_ANS_STEP) as UB_ANS_STEP FROM %s";
			$where = "%s WHERE UB_ANS_NO = %s AND UB_ANS_STEP LIKE '%s%%'";
			
			$query = sprintf($query, $this->field['ub_table']);
			$query = sprintf($where, $query, $this->field['ub_ans_no'], $this->field['ub_ans_step']);

			return $this->getSelectQuery($query, "OP_SELECT");
		}

			

		/********************************** Insert **********************************/
		function getMypageMgrInsert()
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
//			$param['UB_P_CODE']		= $this->getSQLString($this->field['ub_p_code']);	
			$param['UB_REG_DT']		= "NOW()";
			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);
			
			return $this->db->getInsertParam($this->field['ub_table'],$param);
		}

		/********************************** Update **********************************/
		function getMypageMgrUpdate()
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
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);

			$where					= "UB_NO = {$this->field['ub_no']}";
	
			return $this->db->getUpdateParam($this->field['ub_table'], $param, $where);
		}

		function getMypageMgrAnsNoUpdate()
		{
			$field = "UB_ANS_NO = {$this->field['ub_ans_no']}";
			$where = "WHERE  UB_NO = {$this->field['ub_no']}";
			
			return $this->db->getUpdateSql($this->field['ub_table'], $field, $where);
		}

		function getMypageMgrReadUpdate()
		{
			$field = "UB_READ = UB_READ + 1";
			$where = "WHERE  UB_NO = {$this->field['ub_no']}";
			
			return $this->db->getUpdateSql($this->field['ub_table'], $field, $where);
		}

		/********************************** Delete **********************************/
		function getMypageMgrDelete(&$db)
		{
			$where					= "UB_NO = {$this->field['ub_no']}";
			
			if($this->field['ub_ans_no'] && $this->field['ub_ans_no']):
				$where				= "UB_ANS_NO = {$this->field['ub_ans_no']} AND UB_ANS_STEP LIKE '{$this->field['ub_ans_step']}%'";
			endif;

			$this->db->getDelete($this->field['ub_table'], $where);
		}

		/********************************** Create **********************************/
		function getMypageMgrCreateTable() {

			$query = "CREATE TABLE `BOARD_UB_{$this->field['b_code']}` (
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

		function getMypageMgrCreateProcedure_I() {
		}

		function getMypageMgrCreateProcedure_U() {
		}

		function getMypageMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getMypageMgrDropTable() {
		}

		function getMypageMgrDropProcedure_I() {
		}

		function getMypageMgrDropProcedure_U() {
		}

		function getMypageMgrDropProcedure_D() {
		}
    }
?>
