<?php
    /**
     * /home/shop_eng/www/modules/community/boardInfo/basic.1.0/community.boardInfo.module.php
     * @author eumshop(thav@naver.com)
     * community boardInfo module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityBoardInfoModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community boardInfo module class (basic.1.0)";
		}

		function getBoardInfoMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";
			$column['OP_ARYLIST']	= "a.BA_KEY, a.BA_VAL";

			$query = "SELECT %s FROM %s AS a WHERE a.BA_B_CODE IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_INFO_MGR");

			if($param['ba_b_code']):
				$query = "{$query} AND a.BA_B_CODE = '{$param['ba_b_code']}' ";
			endif;

			return $this->getSelectQuery($query, $op);
		}

		function getBoardInfoMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";
			$column['OP_ARYLIST']	= "a.BA_KEY, a.BA_VAL";

			$query = "SELECT %s FROM %s AS a WHERE a.BA_B_CODE IS NOT NULL ";
			$query = sprintf($query, $column[$op], "BOARD_INFO_MGR");

			if($this->field['ba_b_code']):
				$query = sprintf("%s AND a.BA_B_CODE = '%s'", $query, $this->field['ba_b_code']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		/********************************** Insert **********************************/
		function getBoardInfoMgrInsert()
		{

		}

		

		/********************************** Update **********************************/
		function getBoardInfoMgrUpdate(){
		}

		function getBoardInfoMgrUseUpdate() {
		}

		/********************************** Delete **********************************/
		function getBoardInfoMgrUseDeleteCode($param)
		{
			if(!$param['ba_b_code']) { return; }
			$where = "BA_B_CODE = '{$param['ba_b_code']}'";
			$this->db->getDelete("BOARD_INFO_MGR", $where);
		}

		/********************************** Insert & Update *************************/
		function getBoardInfoMgrInsertUpdate() {
			$query = "CALL SP_BOARD_INFO_MGR_IU (?,?,?,?,?);";

			$param[]  = $this->field['ba_b_code'];
			$param[]  = $this->field['ba_mode'];
			$param[]  = $this->field['ba_key'];
			$param[]  = $this->field['ba_val'];
			$param[]  = $this->field['ba_comment'];
			return $this->db->executeBindingQuery($query,$param,true);
		}

		/********************************** Create **********************************/
		function getBoardInfoMgrCreateTable() {
			$query = "CREATE TABLE `BOARD_INFO_MGR` (
						  `BA_B_CODE` varchar(50) NOT NULL COMMENT '코드',
						  `BA_MODE` varchar(50) NOT NULL COMMENT '저장모드',
						  `BA_KEY` varchar(50) NOT NULL COMMENT '키',
						  `BA_VAL` varchar(100) default NULL COMMENT '값',
						  `BA_COMMENT` varchar(200) default NULL COMMENT '설명',
						  PRIMARY KEY  (`BA_B_CODE`,`BA_KEY`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='게시판설정 추가 옵션';";
					
			return $this->db->getExecSql($query);
		}

		function getBoardInfoMgrCreateProcedure_I() {
		}

		function getBoardInfoMgrCreateProcedure_U() {
		}

		function getBoardInfoMgrCreateProcedure_IU() {
			$query = "CREATE PROCEDURE `SP_BOARD_INFO_MGR_IU`(
							 IN IN_BA_B_CODE VARCHAR(50)
							,IN IN_BA_MODE VARCHAR(50)
							,IN IN_BA_KEY VARCHAR(50)
							,IN IN_BA_VAL VARCHAR(100)
							,IN IN_BA_COMMENT VARCHAR(200)
						)
						BEGIN

							DECLARE INT_CNT INT DEFAULT 0;
							
							SELECT COUNT(*) INTO INT_CNT
							FROM BOARD_INFO_MGR 
							WHERE BA_B_CODE = IN_BA_B_CODE AND BA_KEY = IN_BA_KEY;
							
							IF (INT_CNT > 0) THEN
								
								UPDATE BOARD_INFO_MGR SET 
									 BA_VAL = IN_BA_VAL
									,BA_MODE = IN_BA_MODE
									,BA_COMMENT = IN_BA_COMMENT
								WHERE  BA_B_CODE = IN_BA_B_CODE AND BA_KEY = IN_BA_KEY;

							ELSE
				
								INSERT INTO BOARD_INFO_MGR (
									 BA_B_CODE
									,BA_MODE
									,BA_KEY
									,BA_VAL
									,BA_COMMENT
								) VALUES (
									 IN_BA_B_CODE
									,IN_BA_MODE
									,IN_BA_KEY
									,IN_BA_VAL
									,IN_BA_COMMENT
								);

							END IF; 
							
						END";
			
			return $this->db->getExecSql($query);
		}


		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getBoardInfoMgrDropTable() {
			$query = "DROP TABLE BOARD_INFO_MGR;";
			return $this->db->getExecSql($query);
		}

		function getBoardInfoMgrDropProcedure_I() {
		}

		function getBoardInfoMgrDropProcedure_U() {
		}

		function getBoardInfoMgrDropProcedure_IU() {
			$query = "DROP PROCEDURE IF EXISTS `SP_BOARD_INFO_MGR_IU`;";
			return $this->db->getExecSql($query);
		}
    }
?>
