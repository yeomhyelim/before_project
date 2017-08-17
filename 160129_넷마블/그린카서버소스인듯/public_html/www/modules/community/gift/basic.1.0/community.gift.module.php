<?php
    /**
     * /home/shop_eng/www/modules/community/gift/basic.1.0/community.gift.module.php
     * @author eumshop(thav@naver.com)
     * community gift module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityGiftModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community gift module class (basic.1.0)";
		}

		function getGiftMgrSelectEx($op="OP_LIST", $param)
		{
			$column['OP_LIST']		= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "*";

			$where = "";
			$query = "SELECT %s FROM %s AS a ";
			$query = sprintf($query, $column[$op], "BOARD_GIFT_MGR");

			if($param['gm_no']):	
				$where .= "AND a.GM_NO = {$param['gm_no']} ";	
			endif;

			if($param['gm_b_code']):	
				$where .= "AND a.GM_B_CODE = '{$param['gm_b_code']}' ";	
			endif;

			if($param['gm_ub_no']):	
				$where .= "AND a.GM_UB_NO = {$param['gm_ub_no']} ";	
			endif;

			if($where) { $query .= "WHERE a.GM_NO IS NOT NULL {$where}"; }

			return $this->getSelectQuery($query, $op);
		}

		function getGiftMgrSelect($op="OP_LIST")
		{
		}

		/********************************** Insert **********************************/
		function getGiftMgrInsertEx($paramData)
		{		
//			$param['GM_NO']				= $this->getSQLInteger($paramData['gm_no']);
			$param['GM_B_CODE']			= $this->getSQLString($paramData['gm_b_code']);
			$param['GM_UB_NO']			= $this->getSQLInteger($paramData['gm_ub_no']);
			$param['GM_TYPE']			= $this->getSQLString($paramData['gm_type']);
			$param['GM_AREA']			= $this->getSQLString($paramData['gm_area']);
			$param['GM_USE']			= $this->getSQLString($paramData['gm_use']);
			$param['GM_GIVE_TYPE']		= $this->getSQLString($paramData['gm_give_type']);
			$param['GM_MAX']			= $this->getSQLInteger($paramData['gm_max']);
			$param['GM_TITLE']			= $this->getSQLString($paramData['gm_title']);
			$param['GM_DATA']			= $this->getSQLString($paramData['gm_data']);

			return $this->db->getInsertParam("BOARD_GIFT_MGR",$param);
		}

		/********************************** Update **********************************/
		function getGiftMgrUpdateEx($paramData)
		{
//			$param['GM_NO']				= $this->getSQLInteger($paramData['gm_no']);
//			$param['GM_B_CODE']			= $this->getSQLString($paramData['gm_b_code']);
//			$param['GM_UB_NO']			= $this->getSQLInteger($paramData['gm_ub_no']);
			$param['GM_TYPE']			= $this->getSQLString($paramData['gm_type']);
			$param['GM_AREA']			= $this->getSQLString($paramData['gm_area']);
			$param['GM_USE']			= $this->getSQLString($paramData['gm_use']);
			$param['GM_GIVE_TYPE']		= $this->getSQLString($paramData['gm_give_type']);
			$param['GM_MAX']			= $this->getSQLInteger($paramData['gm_max']);
			$param['GM_TITLE']			= $this->getSQLString($paramData['gm_title']);
			$param['GM_DATA']			= $this->getSQLString($paramData['gm_data']);

			if($paramData['gm_no']):
				$where					= "GM_NO = {$paramData['gm_no']}";
			elseif($param['GM_B_CODE'] && $param['GM_UB_NO']):
				$where					= "GM_B_CODE = '{$paramData['gm_b_code']}' AND GM_UB_NO = {$param['GM_UB_NO']}";
			else:
				return;
			endif;

			return $this->db->getUpdateParam("BOARD_GIFT_MGR", $param, $where);
		}

		/********************************** Delete **********************************/
		function getGiftMgrDeleteEx($param) {
			
			if($param['gm_no']):
				$where = "GM_NO = {$param['gm_no']}";
			endif;

			if(!$where) { return; }

			return $this->db->getDelete("BOARD_GIFT_MGR", $where);
		}

		/********************************** Insert & Update *************************/
		function getGiftMgrInsertUpdate() {
		}

		/********************************** Create **********************************/
		function getGiftMgrCreateTable() {
			$query = "CREATE TABLE `BOARD_GIFT_MGR` (
						  `GM_NO` BIGINT NOT NULL AUTO_INCREMENT COMMENT '번호',
						  `GM_B_CODE` VARCHAR(50) COMMENT '커뮤니티 코드',
						  `GM_UB_NO` BIGINT COMMENT '게시판 번호',
						  `GM_TYPE` VARCHAR(20) COMMENT '발급유형(point, coupon)',
						  `GM_AREA` VARCHAR(20) COMMENT '발급위치(event, data, comment)',
						  `GM_USE` VARCHAR(10) COMMENT '사용유무(사용=Y, 사용안함=N)',
						  `GM_GIVE_TYPE` VARCHAR(10) COMMENT '지급방법(자동=A, 수동=M, 멀티=T)',
						  `GM_MAX` INT COMMENT '발급개수',
						  `GM_TITLE` VARCHAR(500) COMMENT '제목',
						  `GM_DATA` VARCHAR(200) COMMENT '데이터(포인트=금액, 쿠폰=쿠폰번호)',
						  PRIMARY KEY(GM_NO)
						) ENGINE=MyISAM
						COMMENT='커뮤니티 포인트/쿠폰 옵션';";		
			return $this->db->getExecSql($query);
		}

		function getGiftMgrCreateProcedure_I() {
		}

		function getGiftMgrCreateProcedure_U() {
		}

		function getGiftMgrCreateProcedure_IU() {
		}

		function getGiftMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getGiftMgrDropTable() {
		}

		function getGiftMgrDropProcedure_I() {
		}

		function getGiftMgrDropProcedure_U() {
		}

		function getGiftMgrDropProcedure_D() {
		}
    }
?>
