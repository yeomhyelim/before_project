<?php
    /**
     * /home/shop_eng/www/modules/community/eventComment/basic.1.0/community.eventComment.module.php
     * @author eumshop(thav@naver.com)
     * community event comment module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityEventCommentModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community event comment module class (basic.1.0)";
		}

		function getEventCommentMgrSelectEx($op="OP_LIST", $param)
		{
			$column1['OP_LIST']		= "a.*";
			$column1['OP_COUNT']	= "COUNT(*)";
			$column1['OP_SELECT']	= "a.*";

			if($this->field['BOARD_INFO']['bi_point_use']=="Y" && in_array($op, array("OP_LIST","OP_SELECT"))):

				$column1['OP_LIST']		= "a.*, b.PT_POINT, e.CU_NAME, f.GM_TITLE";
				$column1['OP_COUNT']		= "COUNT(*)";
				$column1['OP_SELECT']	= "a.*, b.PT_POINT, e.CU_NAME, f.GM_TITLE";

				$join1					= "LEFT OUTER JOIN POINT_MGR AS b ON a.CM_PT_NO = b.PT_NO	";

// 2013.05.24 속도 느림 현상으로 주석 처리함.		
//
//				$column2 = ",c.CM_PART_CNT";						// 이벤트 참여횟수
//				$column3 = ",c.CM_WIN_CNT";							// 이벤트 당첨횟수
//				
//				$join1	 = "LEFT OUTER JOIN POINT_MGR AS b ON a.CM_PT_NO = b.PT_NO	";
//				$join1  .= " LEFT OUTER JOIN (";
//				$join1  .= "    SELECT                                                               ";
//				$join1  .= "         A.CM_M_NO                                                       ";
//				$join1  .= "        ,SUM((CASE WHEN A.CM_WINNER = 'Y' THEN 1 ELSE 0 END)) CM_WIN_CNT ";
//				$join1  .= "        ,COUNT(A.CM_M_NO) CM_PART_CNT                                    ";
//				$join1  .= "    FROM BOARD_CM_EVENT A                                                ";
//				$join1  .= "    GROUP BY A.CM_M_NO                                                   ";
//				$join1	.= ") c on a.CM_M_NO = c.CM_M_NO ";

				$join1	.= "LEFT OUTER JOIN ( ";
				$join1	.= "    SELECT * FROM COUPON_ISSUE A ";
				$join1	.= ") d on a.CM_CI_NO = d.CI_NO ";

				$join1	.= "LEFT OUTER JOIN ( ";
				$join1	.= "    SELECT * FROM COUPON_MGR A ";
				$join1	.= ") e on d.CU_NO = e.CU_NO ";

				$join1	.= "LEFT OUTER JOIN BOARD_GIFT_MGR AS f on a.CM_POINT_GM_NO = f.GM_NO ";

			endif;

			$query = "SELECT %s %s %s FROM %s AS a %s WHERE a.CM_NO IS NOT NULL ";
			$query = sprintf($query, $column1[$op], $column2, $column3, "BOARD_CM_{$param['b_code']}", $join1);

			if($param['cm_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.CM_NO = '%s'", $query, $param['cm_no']);
			endif;
			
			if($param['cm_pass'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.CM_PASS = '%s'", $query, $param['cm_pass']);
			endif;

			if($param['cm_ub_no']):
				$query = sprintf("%s AND a.CM_UB_NO = %d", $query, $param['cm_ub_no']);
			endif;

			/** 2013.04.29 board_cm_event 테이블에만 적용되어 있음... 다른 테이블에 사용 하고 싶으면 컬럼 확인 **/
			if($param['cm_event_type']):
				$query = sprintf("%s AND a.CM_EVENT_TYPE = %s", $query, $param['cm_event_type']);
			endif;

			if($param['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $param['orderby']); 
			endif;

			if($param['page_line'] && $op != "OP_COUNT") :
				$query = sprintf("%s LIMIT %d, %d", $query, $param['limit_first'], $param['page_line']);
			endif;

			$re = $this->getSelectQuery($query, $op);

			return $re;
		}

		function getEventCommentMgrSelect($op="OP_LIST")
		{
			$column1['OP_LIST']		= "a.*";
			$column1['OP_COUNT']		= "COUNT(*)";
			$column1['OP_SELECT']	= "a.*";

			if($this->field['BOARD_INFO']['bi_point_use']=="Y" && $this->field['BOARD_INFO']['bi_point_c_use'] == "Y" && $this->field['BOARD_INFO']['bi_coupon_c_use'] == "Y"):
			
				$column1['OP_LIST']		= "a.*, b.PT_POINT";
				$column1['OP_COUNT']		= "COUNT(*)";
				$column1['OP_SELECT']	= "a.*, b.PT_POINT";

				$column2 = ",(SELECT COUNT(*) FROM BOARD_CM_{$this->field['b_code']} AS b WHERE b.CM_M_NO= a.CM_M_NO) CM_PART_CNT";						// 이벤트 참여횟수
				$column3 = ",(SELECT COUNT(*) FROM BOARD_CM_{$this->field['b_code']} AS c WHERE c.CM_M_NO= a.CM_M_NO AND CM_WINNER = 'Y' ) CM_WIN_CNT";	// 이벤트 당첨횟수
				
				$join1	 = "LEFT OUTER JOIN POINT_MGR AS b ON a.CM_PT_NO = b.PT_NO";

			endif;

			$query = "SELECT %s %s %s FROM %s AS a %s WHERE a.CM_NO IS NOT NULL ";
			$query = sprintf($query, $column1[$op], $column2, $column3, "BOARD_CM_{$this->field['b_code']}", $join1);

			if($this->field['cm_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.CM_NO = '%s'", $query, $this->field['cm_no']);
			endif;
			
			if($this->field['cm_pass'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.CM_PASS = '%s'", $query, $this->field['cm_pass']);
			endif;

			if($this->field['cm_ub_no']):
				$query = sprintf("%s AND a.CM_UB_NO = %d", $query, $this->field['cm_ub_no']);
			endif;

			if($this->field['orderby']) :
				$query = sprintf("%s ORDER BY %s", $query, $this->field['orderby']); 
			endif;

			if($this->field['page_line']) :
				$query = sprintf("%s LIMIT %d, %d", $query, $this->field['limit_first'], $this->field['page_line']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		/**
		  * 2013.04.29
		  * getCommentMgrCmEventTypeSelect($op="OP_LIST")
		  * 이벤트 게시판 코멘트에 필요한 함수 
		  * 이벤트 타입 리스트 
		  **/
		function getEventCommentMgrCmEventTypeSelect($op="OP_ARYLIST")
		{
			$query = "SELECT CM_EVENT_TYPE FROM BOARD_CM_EVENT GROUP BY CM_EVENT_TYPE";

			return $this->getSelectQuery($query, $op);
		}

		/********************************** count **********************************/
		function getEventCommentMgrPointCount(){
					
			$query = "SELECT COUNT(*) FROM BOARD_CM_{$this->field['b_code']} AS a WHERE  a.CM_UB_NO = {$this->field['cm_ub_no']} AND a.CM_M_NO = {$this->field['cm_m_no']} AND a.CM_PT_NO > 0";
			return $this->getSelectQuery($query, "OP_COUNT");
		}
		
		function getEventCommentMgrCouponCount(){
					
			$query = "SELECT COUNT(*) FROM BOARD_CM_{$this->field['b_code']} AS a WHERE  a.CM_UB_NO = {$this->field['cm_ub_no']} AND a.CM_M_NO = {$this->field['cm_m_no']} AND a.CM_CI_NO > 0";
			return $this->getSelectQuery($query, "OP_COUNT");
		}

		function getEventCommentMgrJoinCountEx($param){
					
			$query = "SELECT COUNT(*) FROM BOARD_CM_{$param['b_code']} AS a WHERE a.CM_NO IS NOT NULL ";

			if($param['cm_m_no']):
				$query = "{$query} AND a.CM_M_NO = {$param['cm_m_no']} ";
			endif;

			if($param['cm_winner']):
				$query = "{$query} AND a.CM_WINNER = '{$param['cm_winner']}' ";
			endif;
 
			return $this->getSelectQuery($query, "OP_COUNT");
		}

		/********************************** Insert **********************************/
		function getEventCommentMgrInsert()
		{	
//			$param['CM_NO']			= $this->field['cm_no'];
			$param['CM_UB_NO']		= $this->getSQLInteger($this->field['cm_ub_no']);
			$param['CM_NAME']		= $this->getSQLString($this->field['cm_name']);
			$param['CM_M_NO']		= $this->getSQLInteger($this->field['cm_m_no']);
			$param['CM_M_ID']		= $this->getSQLString($this->field['cm_m_id']);
			$param['CM_PASS']		= $this->getSQLString($this->field['cm_pass']);
			$param['CM_MAIL']		= $this->getSQLString($this->field['cm_mail']);
			$param['CM_TITLE']		= $this->getSQLString($this->field['cm_title']);
			$param['CM_TEXT']		= $this->getSQLString($this->field['cm_text']);
			$param['CM_FUNC']		= $this->getSQLString($this->field['cm_func']);
			$param['CM_IP']			= $this->getSQLString($this->field['cm_ip']);
			$param['CM_READ']		= $this->getSQLInteger($this->field['cm_read']);
			$param['CM_ANS_NO']		= $this->getSQLInteger($this->field['cm_ans_no']);	
			$param['CM_ANS_STEP']	= $this->getSQLString($this->field['cm_ans_step']);				
			$param['CM_PT_NO']		= $this->getSQLInteger($this->field['cm_pt_no']);
			$param['CM_CI_NO']		= $this->getSQLInteger($this->field['cm_ci_no']);
			$param['CM_WINNER']		= $this->getSQLString($this->field['cm_winner']);
			$param['CM_REG_DT']		= "NOW()";
			$param['CM_REG_NO']		= $this->getSQLInteger($this->field['cm_reg_no']);
			$param['CM_MOD_DT']		= "NOW()";
			$param['CM_MOD_NO']		= $this->getSQLInteger($this->field['cm_mod_no']);

			return $this->db->getInsertParam("BOARD_CM_{$this->field['b_code']}", $param);
		}

		/********************************** Update **********************************/
		function getEventCommentMgrUpdate()
		{
//			$param['CM_NO']			= $this->field['cm_no'];
//			$param['CM_UB_NO']		= $this->getSQLInteger($this->field['cm_ub_no']);
//			$param['CM_M_NO']		= $this->getSQLInteger($this->field['cm_m_no']);
//			$param['CM_M_ID']		= $this->getSQLString($this->field['cm_m_id']);
//			$param['CM_READ']		= $this->getSQLInteger($this->field['cm_read']);
//			$param['CM_REG_DT']		= "NOW()";
//			$param['CM_REG_NO']		= $this->getSQLInteger($this->field['cm_reg_no']);
//			$param['CM_NAME']		= $this->getSQLString($this->field['cm_name']);
//			$param['CM_PASS']		= $this->getSQLString($this->field['cm_pass']);
			$param['CM_MAIL']		= $this->getSQLString($this->field['cm_mail']);
			$param['CM_TITLE']		= $this->getSQLString($this->field['cm_title']);
			$param['CM_TEXT']		= $this->getSQLString($this->field['cm_text']);
			$param['CM_FUNC']		= $this->getSQLString($this->field['cm_func']);
			$param['CM_IP']			= $this->getSQLString($this->field['cm_ip']);
			$param['CM_MOD_DT']		= "NOW()";
			$param['CM_MOD_NO']		= $this->getSQLInteger($this->field['cm_mod_no']);

//			$where					= "CM_NO = {$this->field['cm_no']} AND CM_PASS = '{$this->field['cm_pass']}'";
			$where					= "CM_NO = {$this->field['cm_no']}";

			return $this->db->getUpdateParam("BOARD_CM_{$this->field['b_code']}", $param, $where);
		}

		function getEventCommentMgrAnsNoUpdate()
		{
			$field = "CM_ANS_NO = {$this->field['cm_ans_no']}";
			$where = "WHERE  CM_NO = {$this->field['cm_no']}";
			
			return $this->db->getUpdateSql("BOARD_CM_{$this->field['b_code']}", $field, $where);
		}

		function getPointUpdateEx($paramData) {
			$strTableName			= "BOARD_CM_{$paramData['b_code']}";
			$param['CM_POINT_GM_NO']= $this->getSQLInteger($paramData['cm_point_gm_no']);
			$param['CM_PT_NO']		= $this->getSQLInteger($paramData['cm_pt_no']);
			$param['CM_WINNER']		= $this->getSQLString($paramData['cm_winner']);
			
			$where					= "CM_NO = {$paramData['cm_no']}";
			return $this->db->getUpdateParam($strTableName, $param, $where);
		}

		function getCouponUpdateEx($paramData) {
			$strTableName				= "BOARD_CM_{$paramData['b_code']}";
			$param['CM_COUPON_GM_NO']	= $this->getSQLInteger($paramData['cm_coupon_gm_no']);
			$param['CM_CI_NO']			= $this->getSQLInteger($paramData['cm_ci_no']);
			$param['CM_WINNER']			= $this->getSQLString($paramData['cm_winner']);
			
			$where						= "CM_NO = {$paramData['cm_no']}";
			return $this->db->getUpdateParam($strTableName, $param, $where);
		}

		function getEventCommentMgrPointUpdate()
		{
			$param['CM_PT_NO']		= $this->getSQLInteger($this->field['cm_pt_no']);
			$param['CM_WINNER']		= $this->getSQLString($this->field['cm_winner']);

			$where					= "CM_NO = {$this->field['cm_no']}";
			
			return $this->db->getUpdateParam("BOARD_CM_{$this->field['b_code']}", $param, $where);
		}

		function getEventCommentMgrCouponUpdate()
		{
			$param['CM_CI_NO']		= $this->getSQLInteger($this->field['cm_ci_no']);
			$param['CM_WINNER']		= $this->getSQLString($this->field['cm_winner']);

			$where					= "CM_NO = {$this->field['cm_no']}";
			
			return $this->db->getUpdateParam("BOARD_CM_{$this->field['b_code']}", $param, $where);
		}
		
		/********************************** Delete **********************************/
		function getEventCommentMgrDelete($op="OP_CM_NO")
		{
			if($op == "OP_CM_NO")				{ $where = "CM_NO = {$this->field['cm_no']} AND CM_PASS = '{$this->field['cm_pass']}'";		}
			else if($op == "OP_CM_UB_NO")		{ $where = "CM_UB_NO = {$this->field['cm_ub_no']}";		}
			else								{ return; }

			return $this->db->getDelete($this->field['cm_table'], $where);
		}

		function getEventCommentMgrDeleteEx($param)
		{
			if($param['cm_no']):
				$where = "CM_NO = {$param['cm_no']}";
			endif; 

			if(!$where) { return; }

			return $this->db->getDelete("BOARD_CM_{$param['b_code']}", $where);
		}

		/********************************** Create **********************************/
		function getEventCommentMgrCreateTable() {
			$query = "CREATE TABLE `BOARD_CM_{$this->field['b_code']}` (
						  `CM_NO` BIGINT NOT NULL AUTO_INCREMENT COMMENT '번호',
						  `CM_UB_NO` BIGINT COMMENT '게시판 번호',
						  `CM_NAME` VARCHAR(20) COMMENT '이름',
						  `CM_M_NO` BIGINT COMMENT '회원 번호',
						  `CM_M_ID` VARCHAR(20) COMMENT '아이디',
						  `CM_PASS` VARCHAR(100) COMMENT '비밀번호',
						  `CM_MAIL` VARCHAR(50) COMMENT '이메일',
						  `CM_TITLE` VARCHAR(200) COMMENT '제목',
						  `CM_TEXT` TEXT COMMENT '내용',
						  `CM_FUNC` VARCHAR(20) DEFAULT '0000000000' COMMENT '기능(공지글,비밀글)',
						  `CM_IP` VARCHAR(20) COMMENT 'IP',
						  `CM_READ` INT COMMENT '추천수',
						  `CM_ANS_NO` bigint(20) default NULL COMMENT '계층형-최상위글 번호',
						  `CM_ANS_STEP` varbinary(100) default NULL COMMENT '계층형-답변모양',
						  `CM_PT_NO` BIGINT COMMENT '이벤트-포인트 번호',
						  `CM_MULTI_NO` BIGINT COMMENT '이벤트-차등포인트지급 번호',
						  `CM_CI_NO` BIGINT COMMENT '이벤트-쿠폰 번호',
						  `CM_WINNER` VARCHAR(1) COMMENT '이벤트-담청자',
						  `CM_EVENT_TYPE` VARCHAR(1) COMMENT '이벤트-구분',
						  `CM_REG_DT` DATETIME COMMENT '작성일',
						  `CM_REG_NO` BIGINT COMMENT '작성자',
						  `CM_MOD_DT` DATETIME COMMENT '수정일',
						  `CM_MOD_NO` BIGINT COMMENT '수정자',
						  PRIMARY KEY(CM_NO),
						  KEY `IDX_M_NO` (`CM_M_NO`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='코멘트';";
					
			return $this->db->getExecSql($query);
		}

		function getEventCommentMgrCreateProcedure_I() {

		}


		function getEventCommentMgrCreateProcedure_U() {

		}

		function getEventCommentMgrCreateProcedure_D() {

		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getEventCommentMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getEventCommentMgrDropProcedure_I() {
		}

		function getEventCommentMgrDropProcedure_U() {
		}

		function getEventCommentMgrDropProcedure_D() {
		}
    }
?>
