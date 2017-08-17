<?php
    /**
     * /home/shop_eng/www/modules/community/userfield/basic.1.0/community.userfield.module.php
     * @author eumshop(thav@naver.com)
     * community userfield module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/community/community.module.php";

    class CommunityUserfieldModule extends CommunityModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "community userfield module class (basic.1.0)";
		}

		function getUserfieldMgrSelect($op="OP_LIST")
		{
			$column['OP_LIST']		= "a.*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_SELECT']	= "a.*";

			$query = "SELECT %s FROM %s AS a WHERE a.AD_UB_NO IS NOT NULL ";
			$query = sprintf($query, $column[$op], $this->field['ad_table']);

			if($this->field['ad_ub_no'] && $op == "OP_SELECT"):
				$query = sprintf("%s AND a.AD_UB_NO = '%s'", $query, $this->field['ad_ub_no']);
			endif;

			return $this->getSelectQuery($query, $op);
		}

		/********************************** Insert **********************************/
		function getUserfieldMgrInsert()
		{	
			$param['AD_UB_NO']		= $this->getSQLString($this->field['ad_ub_no']);
			$param['AD_PHONE1']		= $this->getSQLString($this->field['ad_phone1']);
			$param['AD_PHONE2']		= $this->getSQLString($this->field['ad_phone2']);
			$param['AD_PHONE3']		= $this->getSQLString($this->field['ad_phone3']);
			$param['AD_ZIP']		= $this->getSQLString($this->field['ad_zip']);
			$param['AD_ADDR1']		= $this->getSQLString($this->field['ad_addr1']);
			$param['AD_ADDR2']		= $this->getSQLString($this->field['ad_addr2']);
			$param['AD_COMPANY']	= $this->getSQLString($this->field['ad_company']);
			$param['AD_TEMP1']		= $this->getSQLString($this->field['ad_temp1']);
			$param['AD_TEMP2']		= $this->getSQLString($this->field['ad_temp2']);
			$param['AD_TEMP3']		= $this->getSQLString($this->field['ad_temp3']);
			$param['AD_TEMP4']		= $this->getSQLString($this->field['ad_temp4']);
			$param['AD_TEMP5']		= $this->getSQLString($this->field['ad_temp5']);
			$param['AD_TEMP6']		= $this->getSQLString($this->field['ad_temp6']);
			$param['AD_TEMP7']		= $this->getSQLString($this->field['ad_temp7']);
			$param['AD_TEMP8']		= $this->getSQLString($this->field['ad_temp8']);
			$param['AD_TEMP9']		= $this->getSQLString($this->field['ad_temp9']);
			$param['AD_TEMP10']		= $this->getSQLString($this->field['ad_temp10']);
			$param['AD_TEMP11']		= $this->getSQLString($this->field['ad_temp11']);
			$param['AD_TEMP12']		= $this->getSQLString($this->field['ad_temp12']);
			$param['AD_TEMP13']		= $this->getSQLString($this->field['ad_temp13']);
			$param['AD_TEMP14']		= $this->getSQLString($this->field['ad_temp14']);
			$param['AD_TEMP15']		= $this->getSQLString($this->field['ad_temp15']);
			$param['AD_TEMP16']		= $this->getSQLString($this->field['ad_temp16']);
			$param['AD_TEMP17']		= $this->getSQLString($this->field['ad_temp17']);
			$param['AD_TEMP18']		= $this->getSQLString($this->field['ad_temp18']);
			$param['AD_TEMP19']		= $this->getSQLString($this->field['ad_temp19']);
			$param['AD_TEMP20']		= $this->getSQLString($this->field['ad_temp20']);

			
			return $this->db->getInsertParam($this->field['ad_table'], $param);			
		}

		/********************************** Update **********************************/
		function getUserfieldMgrUpdate()
		{
//			$param['AD_UB_NO']		= $this->getSQLString($this->field['ad_ub_no']);
			$param['AD_PHONE1']		= $this->getSQLString($this->field['ad_phone1']);
			$param['AD_PHONE2']		= $this->getSQLString($this->field['ad_phone2']);
			$param['AD_PHONE3']		= $this->getSQLString($this->field['ad_phone3']);
			$param['AD_ZIP']		= $this->getSQLString($this->field['ad_zip']);
			$param['AD_ADDR1']		= $this->getSQLString($this->field['ad_addr1']);
			$param['AD_ADDR2']		= $this->getSQLString($this->field['ad_addr2']);
			$param['AD_COMPANY']	= $this->getSQLString($this->field['ad_company']);
			$param['AD_TEMP1']		= $this->getSQLString($this->field['ad_temp1']);
			$param['AD_TEMP2']		= $this->getSQLString($this->field['ad_temp2']);
			$param['AD_TEMP3']		= $this->getSQLString($this->field['ad_temp3']);
			$param['AD_TEMP4']		= $this->getSQLString($this->field['ad_temp4']);
			$param['AD_TEMP5']		= $this->getSQLString($this->field['ad_temp5']);
			$param['AD_TEMP6']		= $this->getSQLString($this->field['ad_temp6']);
			$param['AD_TEMP7']		= $this->getSQLString($this->field['ad_temp7']);
			$param['AD_TEMP8']		= $this->getSQLString($this->field['ad_temp8']);
			$param['AD_TEMP9']		= $this->getSQLString($this->field['ad_temp9']);
			$param['AD_TEMP10']		= $this->getSQLString($this->field['ad_temp10']);
			$param['AD_TEMP11']		= $this->getSQLString($this->field['ad_temp11']);
			$param['AD_TEMP12']		= $this->getSQLString($this->field['ad_temp12']);
			$param['AD_TEMP13']		= $this->getSQLString($this->field['ad_temp13']);
			$param['AD_TEMP14']		= $this->getSQLString($this->field['ad_temp14']);
			$param['AD_TEMP15']		= $this->getSQLString($this->field['ad_temp15']);
			$param['AD_TEMP16']		= $this->getSQLString($this->field['ad_temp16']);
			$param['AD_TEMP17']		= $this->getSQLString($this->field['ad_temp17']);
			$param['AD_TEMP18']		= $this->getSQLString($this->field['ad_temp18']);
			$param['AD_TEMP19']		= $this->getSQLString($this->field['ad_temp19']);
			$param['AD_TEMP20']		= $this->getSQLString($this->field['ad_temp20']);

			$where					= "AD_UB_NO = {$this->field['ad_ub_no']}";
	
			return $this->db->getUpdateParam($this->field['ad_table'], $param, $where);
		}

		/********************************** Delete **********************************/
		function getUserfieldMgrDelete(&$db)
		{
			$where					= "AD_UB_NO = {$this->field['ad_ub_no']}";
			$this->db->getDelete($this->field['ad_table'], $where);
		}

		/********************************** Create **********************************/
		function getUserfieldMgrCreateTable() {

			$query = "CREATE TABLE `{$this->field['tableName']}` (
						  `AD_UB_NO` BIGINT NOT NULL UNIQUE COMMENT '게시판번호',
						  `AD_PHONE1` VARCHAR(30) COMMENT '연락처1',
						  `AD_PHONE2` VARCHAR(30) COMMENT '연락처2',
						  `AD_PHONE3` VARCHAR(30) COMMENT '연락처3',
						  `AD_ZIP` VARCHAR(10) COMMENT '우편번호',
						  `AD_ADDR1` VARCHAR(100) COMMENT '주소1',
						  `AD_ADDR2` VARCHAR(150) COMMENT '주소2',
						  `AD_COMPANY` VARCHAR(100) COMMENT '회사명',
						  `AD_TEMP1` VARCHAR(50) COMMENT '임시필드1',
						  `AD_TEMP2` VARCHAR(50) COMMENT '임시필드2',
						  `AD_TEMP3` VARCHAR(50) COMMENT '임시필드3',
						  `AD_TEMP4` VARCHAR(50) COMMENT '임시필드4',
						  `AD_TEMP5` VARCHAR(200) COMMENT '임시필드5',
						  `AD_TEMP6` VARCHAR(200) COMMENT '임시필드6',
						  `AD_TEMP7` VARCHAR(200) COMMENT '임시필드7',
						  `AD_TEMP8` VARCHAR(200) COMMENT '임시필드8',
						  `AD_TEMP9` VARCHAR(500) COMMENT '임시필드9',
						  `AD_TEMP10` VARCHAR(500) COMMENT '임시필드10',
						  `AD_TEMP11` VARCHAR(500) COMMENT '임시필드11',
						  `AD_TEMP12` VARCHAR(500) COMMENT '임시필드12',
						  `AD_TEMP13` VARCHAR(10) COMMENT '임시필드13',
						  `AD_TEMP14` VARCHAR(10) COMMENT '임시필드14',
						  `AD_TEMP15` VARCHAR(10) COMMENT '임시필드15',
						  `AD_TEMP16` VARCHAR(1) COMMENT '임시필드16',
						  `AD_TEMP17` VARCHAR(1) COMMENT '임시필드17',
						  `AD_TEMP18` TEXT COMMENT '임시필드18',
						  `AD_TEMP19` TEXT COMMENT '임시필드19',
						  `AD_TEMP20` TEXT COMMENT '임시필드20',
						  PRIMARY KEY(AD_UB_NO)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='추가필드';";
					
			return $this->db->getExecSql($query);
		}

		function getUserfieldMgrCreateProcedure_I() {
		}

		function getUserfieldMgrCreateProcedure_U() {
		}

		function getUserfieldMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getUserfieldMgrDropTable(&$param) {
			$query = "DROP TABLE {$param['tableName']};";
			return $this->db->getExecSql($query);
		}

		function getUserfieldMgrDropProcedure_I() {
		}

		function getUserfieldMgrDropProcedure_U() {
		}

		function getUserfieldMgrDropProcedure_D() {
		}
    }
?>
