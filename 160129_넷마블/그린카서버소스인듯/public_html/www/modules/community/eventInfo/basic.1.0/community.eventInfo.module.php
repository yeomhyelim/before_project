<?php
    /**
     * /home/shop_eng/www/modules/community/eventInfo/basic.1.0/community.eventInfo.module.php
     * @author eumshop(thav@naver.com)
     * community eventInfo module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityEventInfoModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community eventInfo module class (basic.1.0)";
		}

		function getEventInfoMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";
			$column['OP_ARYLIST']	= "a.BE_KEY, a.BE_VAL";

			$query = "SELECT %s FROM %s AS a WHERE a.BE_B_CODE IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_EVENT_INFO_MGR");

			if($param['be_b_code']):
				$query = sprintf("%s AND a.BE_B_CODE = '%s'", $query, $param['be_b_code']);
			endif;

			if($param['be_ub_no']):
				$query = sprintf("%s AND a.BE_UB_NO = '%s'", $query, $param['be_ub_no']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		function getEventInfoMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";
			$column['OP_ARYLIST']	= "a.BE_KEY, a.BE_VAL";

			$query = "SELECT %s FROM %s AS a WHERE a.BE_B_CODE IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_EVENT_INFO_MGR");

			if($this->field['be_b_code']):
				$query = sprintf("%s AND a.BE_B_CODE = '%s'", $query, $this->field['be_b_code']);
			endif;

			if($this->field['be_ub_no']):
				$query = sprintf("%s AND a.BE_UB_NO = '%s'", $query, $this->field['be_ub_no']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		/********************************** Insert **********************************/
		function getEventInfoMgrInsert()
		{		
		}

		/********************************** Update **********************************/
		function getEventInfoMgrUpdate()
		{
		}

		/********************************** Delete **********************************/
		function getEventInfoMgrDelete(&$db)
		{
		}

		/********************************** Insert & Update *************************/
		function getEventInfoMgrInsertUpdate() {
			$query = "CALL SP_BOARD_EVENT_INFO_MGR_IU (?,?,?,?,?);";

			$param[]  = $this->field['be_b_code'];
			$param[]  = $this->field['be_ub_no'];
			$param[]  = $this->field['be_key'];
			$param[]  = $this->field['be_val'];
			$param[]  = $this->field['be_comment'];

			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Create **********************************/
		function getEventInfoMgrCreateTable() {
			$query = "CREATE TABLE `BOARD_EVENT_INFO_MGR` (
						  `BE_B_CODE` VARCHAR(50) NOT NULL COMMENT '코드',
						  `BE_UB_NO` BIGINT NOT NULL COMMENT '게시판 번호',
						  `BE_KEY` VARCHAR(50) NOT NULL COMMENT '키',
						  `BE_VAL` VARCHAR(100) COMMENT '값',
						  `BE_COMMENT` VARCHAR(200) COMMENT '설명',
						  PRIMARY KEY(BE_B_CODE,BE_UB_NO,BE_KEY)
						) ENGINE=MyISAM COMMENT='커뮤니티 이벤트  추가 옵션(포인트/쿠폰)';";
					
			return $this->db->getExecSql($query);
		}

		function getEventInfoMgrCreateProcedure_I() {
		}

		function getEventInfoMgrCreateProcedure_U() {
		}

		function getEventInfoMgrCreateProcedure_IU() {
			$query = "CREATE PROCEDURE `SP_BOARD_EVENT_INFO_MGR_IU`(
							 IN IN_BE_B_CODE VARCHAR(50)
							,IN IN_BE_UB_NO INT
							,IN IN_BE_KEY VARCHAR(50)
							,IN IN_BE_VAL VARCHAR(100)
							,IN IN_BE_COMMENT VARCHAR(200)
						)
						BEGIN

							DECLARE INT_CNT INT DEFAULT 0;
							
							SELECT COUNT(*) INTO INT_CNT
							FROM BOARD_EVENT_INFO_MGR 
							WHERE BE_B_CODE = IN_BE_B_CODE AND BE_UB_NO = IN_BE_UB_NO AND BE_KEY = IN_BE_KEY;
							
							IF (INT_CNT > 0) THEN
								
								UPDATE BOARD_EVENT_INFO_MGR SET 
									 BE_VAL = IN_BE_VAL
									,BE_COMMENT = IN_BE_COMMENT
								WHERE  BE_B_CODE = IN_BE_B_CODE AND BE_UB_NO = IN_BE_UB_NO AND BE_KEY = IN_BE_KEY;

							ELSE
				
								INSERT INTO BOARD_EVENT_INFO_MGR (
									 BE_B_CODE
									,BE_UB_NO
									,BE_KEY
									,BE_VAL
									,BE_COMMENT
								) VALUES (
									 IN_BE_B_CODE
									,IN_BE_UB_NO
									,IN_BE_KEY
									,IN_BE_VAL
									,IN_BE_COMMENT
								);

							END IF; 
							
						END";
			
			return $this->db->getExecSql($query);
		}

		function getEventInfoMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getEventInfoMgrDropTable() {
			$query = "DROP TABLE BOARD_EVENT_INFO_MGR;";
			return $this->db->getExecSql($query);
		}

		function getEventInfoMgrDropProcedure_I() {
		}

		function getEventInfoMgrDropProcedure_U() {
		}

		function getEventInfoMgrDropProcedure_D() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_EVENT_INFO_MGR_IU`;";
			return $this->db->getExecSql($query);
		}
    }
?>
