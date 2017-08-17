<?php
    /**
     * /home/shop_eng/www/modules/community/event/basic.1.0/community.event.module.php
     * @author eumshop(thav@naver.com)
     * community event module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityEventModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community data module class (basic.1.0)";
		}

		function getDataMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op],"BOARD_UB_{$param['b_code']}");


// 2013.05.09 모든 옵션은 $param에서 받아오도록 변경
			if($param['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$param['b_code']}");			
			endif;

			if($param['bi_userfield_use'] == "Y"):		// 사용자 필드 사용하는 경우
				$join = "%s LEFT OUTER JOIN %s AS c ON a.UB_NO = c.AD_UB_NO";
				$query = sprintf($join, $query, "BOARD_AD_{$param['b_code']}");	
			endif;


			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($param['pageArea'] != "adminPage"):
				if($param['device'] == "m"):
					// 모바일용
					$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,6, 1) = 'Y'", $query);	
				else:
					// 웹용
					$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,5, 1) = 'Y'", $query);	
				endif;
			endif;

			if($param['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $param['ub_no']);
			endif;

			if($param['ub_func_notice']):
				$query = sprintf("%s AND SUBSTR(a.UB_FUNC ,1, 1) = '%s'", $query, $param['ub_func_notice']);	
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		// $this->field['BOARD_INFO']['bi_attachedfile_use']
		function getDataMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], "BOARD_UB_{$this->field['b_code']}");

			if($this->field['BOARD_INFO']['bi_attachedfile_use'] > 0):		// 첨부 파일이 있는 경우.
				$join = "%s LEFT OUTER JOIN %s AS b ON a.UB_NO = b.FL_UB_NO AND b.FL_KEY = 'listImage'";
				$query = sprintf($join, $query, "BOARD_FL_{$this->field['b_code']}");			
			endif;

			$where = "%s WHERE a.UB_NO IS NOT NULL";
			$query = sprintf($where, $query);

			if($this->field['ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.UB_NO = '%s'", $query, $this->field['ub_no']);
			endif;

			if($this->field['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $this->field['orderby']); 
			endif;

			if($this->field['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->field['limit_first'], $this->field['page_line']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		// SELECT COUNT(*) AS TOTAL, SUM(CASE WHEN  UB_REG_DT > CURDATE() THEN 1 ELSE 0 END) AS TODAY FROM BOARD_UB_NOTICE
		function getDataMgrCountEx($param) {
			
			$table = "BOARD_UB_{$param['b_code']}";

			$query = "SELECT COUNT(*) AS TOTAL, SUM(CASE WHEN  UB_REG_DT > CURDATE() THEN 1 ELSE 0 END) AS TODAY FROM {$table} WHERE UB_NO IS NOT NULL ";
			
			if($param['ub_func_icon']):
				$query = "{$query} AND SUBSTR(UB_FUNC ,3, 1) = '{$param['ub_func_icon']}'";
			endif;

//			if($param['answer_no']):
//				$query = "{$query} AND UB_ANS_STEP = ''";	
//			endif;

			return $this->getSelectQuery($query, "OP_SELECT");
		}
		/********************************** Insert **********************************/
		function getDataMgrInsert()
		{		
//			$param['UB_NO']			= $this->field['ub_no'];
			$param['UB_NAME']		= $this->getSQLString($this->field['ub_name']);
			$param['UB_M_NO']		= $this->getSQLString($this->field['ub_m_no']);
			$param['UB_M_ID']		= $this->getSQLString($this->field['ub_m_id']);
			$param['UB_PASS']		= $this->getSQLString($this->field['ub_pass']);
			$param['UB_MAIL']		= $this->getSQLString($this->field['ub_mail']);
			$param['UB_TITLE']		= $this->getSQLString($this->field['ub_title']);
			$param['UB_EXPLAIN']	= $this->getSQLString($this->field['ub_explain']);
			$param['UB_TEXT']		= $this->getSQLString($this->field['ub_text']);
			$param['UB_TEXT_MOBILE']= $this->getSQLString($this->field['ub_text_mobile']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_READ']		= $this->getSQLInteger($this->field['ub_read']);
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);
			$param['UB_LNG']		= $this->getSQLString($this->field['ub_lng']);
			$param['UB_EVENT_S_DT']	= $this->getSQLDatetime($this->field['ub_event_s_dt']);
			$param['UB_EVENT_E_DT']	= $this->getSQLDatetime($this->field['ub_event_e_dt']);
			$param['UB_REG_DT']		= "NOW()";
			$param['UB_REG_NO']		= $this->getSQLInteger($this->field['ub_reg_no']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);

			return $this->db->getInsertParam($this->field['ub_table'],$param);
		}

		/********************************** Update **********************************/
		function getDataMgrUpdate()
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
			$param['UB_TITLE']		= $this->getSQLString($this->field['ub_title']);
			$param['UB_EXPLAIN']	= $this->getSQLString($this->field['ub_explain']);
			$param['UB_TEXT']		= $this->getSQLString($this->field['ub_text']);
			$param['UB_TEXT_MOBILE']= $this->getSQLString($this->field['ub_text_mobile']);
			$param['UB_FUNC']		= $this->getSQLString($this->field['ub_func']);
			$param['UB_IP']			= $this->getSQLString($this->field['ub_ip']);
			$param['UB_BC_NO']		= $this->getSQLInteger($this->field['ub_bc_no']);
			$param['UB_LNG']		= $this->getSQLString($this->field['ub_lng']);
			$param['UB_EVENT_S_DT']	= $this->getSQLString($this->field['ub_event_s_dt']);
			$param['UB_EVENT_E_DT']	= $this->getSQLString($this->field['ub_event_e_dt']);
			$param['UB_MOD_DT']		= "NOW()";
			$param['UB_MOD_NO']		= $this->getSQLInteger($this->field['ub_mod_no']);

			$where					= "UB_NO = {$this->field['ub_no']}";

			return $this->db->getUpdateParam($this->field['ub_table'], $param, $where);
		}

		function getDataMgrReadUpdate()
		{
			$field = "UB_READ = UB_READ + 1";
			$where = "WHERE  UB_NO = {$this->field['ub_no']}";
			
			return $this->db->getUpdateSql("BOARD_UB_{$this->field['b_code']}", $field, $where);
		}

		/********************************** Delete **********************************/
		function getDataMgrDelete(&$db)
		{
			$where					= "UB_NO = {$this->field['ub_no']}";
			$this->db->getDelete($this->field['ub_table'], $where);
		}

		/********************************** Create **********************************/
		function getDataMgrCreateTable() {

			$query = "CREATE TABLE `{$this->field['ub_table']}` (
					  `UB_NO` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '번호',
					  `UB_NAME` varchar(20) DEFAULT NULL COMMENT '이름',
					  `UB_M_NO` bigint(20) DEFAULT NULL COMMENT '회원번호',
					  `UB_M_ID` varchar(20) DEFAULT NULL COMMENT '아이디',
					  `UB_PASS` varchar(100) DEFAULT NULL COMMENT '비밀번호',
					  `UB_MAIL` varchar(50) DEFAULT NULL COMMENT '이메일',
					  `UB_TITLE` varchar(200) DEFAULT NULL COMMENT '제목',
					  `UB_EXPLAIN` varchar(500) DEFAULT NULL COMMENT '간략설명',
					  `UB_TEXT` text COMMENT '내용(웹)',
					  `UB_TEXT_MOBILE` text COMMENT '내용(모바일)',
					  `UB_FUNC` varchar(20) DEFAULT '0000000000' COMMENT '기능(공지글, 비밀글..)',
					  `UB_IP` varchar(20) DEFAULT NULL COMMENT 'IP',
					  `UB_READ` int(11) DEFAULT '0' COMMENT '조회수',
					  `UB_BC_NO` bigint(20) DEFAULT '0' COMMENT '카테고리 번호',
					  `UB_LNG` varchar(2) DEFAULT NULL COMMENT '작성 언어',
					  `UB_EVENT_S_DT` datetime DEFAULT NULL COMMENT '이벤트 시작시간',
					  `UB_EVENT_E_DT` datetime DEFAULT NULL COMMENT '이벤트 종료시간',
					  `UB_REG_DT` datetime DEFAULT NULL COMMENT '작성일',
					  `UB_REG_NO` bigint(20) DEFAULT NULL COMMENT '작성자',
					  `UB_MOD_DT` datetime DEFAULT NULL COMMENT '수정일',
					  `UB_MOD_NO` bigint(20) DEFAULT NULL COMMENT '수정자',
					  PRIMARY KEY (`UB_NO`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='{$this->field['b_name']}';";

			return $this->db->getExecSql($query);
		}

		function getDataMgrCreateProcedure_I() {
		}

		function getDataMgrCreateProcedure_U() {
		}

		function getDataMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getDataMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getDataMgrDropProcedure_I() {
		}

		function getDataMgrDropProcedure_U() {
		}

		function getDataMgrDropProcedure_D() {
		}
    }
?>
