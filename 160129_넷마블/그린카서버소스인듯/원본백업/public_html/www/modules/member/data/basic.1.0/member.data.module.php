<?php
    /**
     * /home/shop_eng/www/modules/member/data/basic.1.0/member.data.module.php
     * @author eumshop(thav@naver.com)
     * member data module class (basic.1.0)
     * **/

	require_once MALL_HOME . "/modules/member/member.module.php";

    class MemberDataModule extends MemberModule {
		
		function __construct(&$db, &$field) {
			$this->db		= &$db;
			$this->field	= &$field;
		}

		function getMessage() {
			echo "member data module class (basic.1.0)";
		}

		function getMemberMgrSelect($op="OP_LIST")
		{
		}

		/********************************** Insert **********************************/
		function getMemberMgrInsert()
		{		
		}

		/********************************** Update **********************************/
		function getMemberMgrUpdate()
		{
		}

		function getMemberMgrPointUpdateEx($param)
		{
			$field = "M_POINT = IFNULL(M_POINT, 0) + {$param['m_point']}";
			$where = "WHERE M_NO = {$param['m_no']}";
	
			return $this->db->getUpdateSql("MEMBER_MGR", $field, $where);
		}

		function getMemberMgrPointUpdate()
		{
			$field = "M_POINT = IFNULL(M_POINT, 0) + {$this->field['m_point']}";
			$where = "WHERE M_NO = {$this->field['m_no']}";
	
			return $this->db->getUpdateSql("MEMBER_MGR", $field, $where);
		}

		/********************************** Delete **********************************/
		function getMemberMgrDelete()
		{
		}

		/********************************** Insert & Update *************************/
		function getMemberMgrInsertUpdate() {
		}

		/********************************** Create **********************************/
		function getMemberMgrCreateTable() {
		}

		function getMemberMgrCreateProcedure_I() {
		}

		function getMemberMgrCreateProcedure_U() {
		}

		function getMemberMgrCreateProcedure_IU() {
		}

		function getMemberMgrCreateProcedure_D() {
		}

		/********************************** drop table query ****************************/
		/*		주의!! 테이블 삭제 후, 복구 불가!! 신중하게 사용 할것!!					*/
		/********************************************************************************/
		function getMemberMgrDropTable() {
		}

		function getMemberMgrDropProcedure_I() {
		}

		function getMemberMgrDropProcedure_U() {
		}

		function getMemberMgrDropProcedure_D() {
		}
    }
?>
