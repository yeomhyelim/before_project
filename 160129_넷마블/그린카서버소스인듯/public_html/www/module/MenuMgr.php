<?
#/*====================================================================*/#
#|화일명	: 메뉴관리													|#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2012-03-10												|#
#|작성내용	: 메뉴 등록/수정/삭제										|#
#/*====================================================================*/#

class MenuMgr
{
	private $query;
	private $param;

	/********************************** 1차 List **********************************/
	function getList01($db){
		$query  = "SELECT								";
		$query .= "      A.*							";
		$query .= "FROM ".TBL_MENU_MGR." A				";
		$query .= "WHERE A.MN_LEVEL = 1					";
		$query .= "AND A.MN_USE = 'Y'					";
		$query .= "ORDER BY A.MN_ORDER ASC,A.MN_CODE ASC	";

		return $db->getExecSql($query);
	}

	function getListAry01($db){
		$query  = "SELECT									";
		$query .= "      A.MN_CODE							";
		$query .= "     ,A.MN_NAME_KR						";
		$query .= "     ,A.MN_NAME_US						";
		$query .= "     ,A.MN_NAME_CN						";
		$query .= "     ,A.MN_NAME_JP						";
		$query .= "     ,A.MN_NAME_ID						";
		$query .= "     ,A.MN_NAME_FR						";

		$query .= "FROM ".TBL_MENU_MGR." A					";
		$query .= "WHERE A.MN_LEVEL = 1						";
		$query .= "AND A.MN_USE = 'Y'						";
		$query .= "ORDER BY A.MN_ORDER ASC,A.MN_CODE ASC	";

		return $db->getArray($query);
	}

	/********************************** 2차 List **********************************/
	function getList02($db){
		$query  = "SELECT									";
		$query .= "      A.*								";
		$query .= "FROM ".TBL_MENU_MGR." A					";
		$query .= "WHERE A.MN_LEVEL = 2						";
		$query .= "AND A.MN_USE = 'Y'						";
		$query .= "AND A.MN_HIGH_01 = '".mysql_real_escape_string($this->getMN_HIGH_01())."'";
		$query .= "ORDER BY A.MN_ORDER ASC,A.MN_CODE ASC	";

		return $db->getExecSql($query);
	}

	function getListAry02($db){
		$query  = "SELECT									";
		$query .= "      A.MN_CODE							";
		$query .= "     ,A.MN_NAME_KR MN_NAME				";
		$query .= "FROM ".TBL_MENU_MGR." A					";
		$query .= "WHERE A.MN_LEVEL = 2						";
		$query .= "AND A.MN_USE = 'Y'						";
		$query .= "AND A.MN_HIGH_01 = '".mysql_real_escape_string($this->getMN_HIGH_01())."'	";
		$query .= "ORDER BY A.MN_ORDER ASC,A.MN_CODE ASC	";

		return $db->getArray($query);
	}


	/********************************** 3차 List **********************************/
	function getList03($db){
		$query  = "SELECT									";
		$query .= "      A.*								";
		$query .= "FROM ".TBL_MENU_MGR." A					";
		$query .= "WHERE A.MN_LEVEL = 3						";
		$query .= "AND A.MN_USE = 'Y'						";
		$query .= "AND A.MN_HIGH_01 = '".mysql_real_escape_string($this->getMN_HIGH_01())."'";
		$query .= "AND A.MN_HIGH_02 = '".mysql_real_escape_string($this->getMN_HIGH_02())."'";
		$query .= "ORDER BY A.MN_ORDER ASC,A.MN_CODE ASC	";

		return $db->getExecSql($query);
	}

	/********************************** View **********************************/
	function getView($db){
		$query  = "SELECT *							";
		$query .= "FROM ".TBL_MENU_MGR."			";
		$query .= "WHERE MN_NO = ".mysql_real_escape_string($this->getMN_NO());

		return $db->getSelect($query);
	}


	/********************************** Insert **********************************/
	function getInsert($db)
	{
		$query = "CALL SP_MENU_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getMN_NAME_KR();
		$param[]  = $this->getMN_NAME_US();
		$param[]  = $this->getMN_NAME_CN();
		$param[]  = $this->getMN_NAME_JP();
		$param[]  = $this->getMN_NAME_ID();
		$param[]  = $this->getMN_NAME_FR();
		$param[]  = $this->getMN_LEVEL();
		$param[]  = $this->getMN_HIGH_01();
		$param[]  = $this->getMN_HIGH_02();
		$param[]  = $this->getMN_AUTH_L();
		$param[]  = $this->getMN_AUTH_W();
		$param[]  = $this->getMN_AUTH_M();
		$param[]  = $this->getMN_AUTH_D();
		$param[]  = $this->getMN_AUTH_E();
		$param[]  = $this->getMN_AUTH_C();
		$param[]  = $this->getMN_AUTH_S();
		$param[]  = $this->getMN_AUTH_U();
		$param[]  = $this->getMN_AUTH_P();
		$param[]  = $this->getMN_AUTH_E1();
		$param[]  = $this->getMN_AUTH_E2();
		$param[]  = $this->getMN_AUTH_E3();
		$param[]  = $this->getMN_AUTH_E4();
		$param[]  = $this->getMN_AUTH_E5();
		$param[]  = $this->getMN_URL();
		$param[]  = $this->getMN_USE();
		$param[]  = $this->getMN_ORDER();
		$param[]  = $this->getMN_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getUpdate($db)
	{
		$query = "CALL SP_MENU_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getMN_NO();
		$param[]  = $this->getMN_NAME_KR();
		$param[]  = $this->getMN_NAME_US();
		$param[]  = $this->getMN_NAME_CN();
		$param[]  = $this->getMN_NAME_JP();
		$param[]  = $this->getMN_NAME_ID();
		$param[]  = $this->getMN_NAME_FR();
		$param[]  = $this->getMN_AUTH_L();
		$param[]  = $this->getMN_AUTH_W();
		$param[]  = $this->getMN_AUTH_M();
		$param[]  = $this->getMN_AUTH_D();
		$param[]  = $this->getMN_AUTH_E();
		$param[]  = $this->getMN_AUTH_C();
		$param[]  = $this->getMN_AUTH_S();
		$param[]  = $this->getMN_AUTH_U();
		$param[]  = $this->getMN_AUTH_P();
		$param[]  = $this->getMN_AUTH_E1();
		$param[]  = $this->getMN_AUTH_E2();
		$param[]  = $this->getMN_AUTH_E3();
		$param[]  = $this->getMN_AUTH_E4();
		$param[]  = $this->getMN_AUTH_E5();
		$param[]  = $this->getMN_URL();
		$param[]  = $this->getMN_USE();
		$param[]  = $this->getMN_ORDER();
		$param[]  = $this->getMN_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getUpdate2($db)
	{
		$query = "CALL SP_MENU_MGR_NM_U (?,?,?,?,?,?,?,?);";

		$param[]  = $this->getMN_NO();
		$param[]  = $this->getMN_NAME_KR();
		$param[]  = $this->getMN_NAME_US();
		$param[]  = $this->getMN_NAME_CN();
		$param[]  = $this->getMN_NAME_JP();
		$param[]  = $this->getMN_NAME_ID();
		$param[]  = $this->getMN_NAME_FR();
		$param[]  = $this->getMN_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** Insert **********************************/
	function getDelete($db)
	{
		$query = "CALL SP_MENU_MGR_D (?);";
		$param[]  = $this->getMN_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** variable **********************************/
	function setMN_NO($MN_NO){ $this->MN_NO = $MN_NO; }		
	function getMN_NO(){ return $this->MN_NO; }		

	function setMN_CODE($MN_CODE){ $this->MN_CODE = $MN_CODE; }		
	function getMN_CODE(){ return $this->MN_CODE; }		

	function setMN_NAME_KR($MN_NAME_KR){ $this->MN_NAME_KR = $MN_NAME_KR; }		
	function getMN_NAME_KR(){ return $this->MN_NAME_KR; }		

	function setMN_NAME_US($MN_NAME_US){ $this->MN_NAME_US = $MN_NAME_US; }		
	function getMN_NAME_US(){ return $this->MN_NAME_US; }		

	function setMN_NAME_CN($MN_NAME_CN){ $this->MN_NAME_CN = $MN_NAME_CN; }		
	function getMN_NAME_CN(){ return $this->MN_NAME_CN; }		

	function setMN_NAME_JP($MN_NAME_JP){ $this->MN_NAME_JP = $MN_NAME_JP; }		
	function getMN_NAME_JP(){ return $this->MN_NAME_JP; }		

	function setMN_NAME_ID($MN_NAME_ID){ $this->MN_NAME_ID = $MN_NAME_ID; }		
	function getMN_NAME_ID(){ return $this->MN_NAME_ID; }		

	function setMN_NAME_FR($MN_NAME_FR){ $this->MN_NAME_FR = $MN_NAME_FR; }		
	function getMN_NAME_FR(){ return $this->MN_NAME_FR; }		

	function setMN_LEVEL($MN_LEVEL){ $this->MN_LEVEL = $MN_LEVEL; }		
	function getMN_LEVEL(){ return $this->MN_LEVEL; }		

	function setMN_HIGH_01($MN_HIGH_01){ $this->MN_HIGH_01 = $MN_HIGH_01; }		
	function getMN_HIGH_01(){ return $this->MN_HIGH_01; }		

	function setMN_HIGH_02($MN_HIGH_02){ $this->MN_HIGH_02 = $MN_HIGH_02; }		
	function getMN_HIGH_02(){ return $this->MN_HIGH_02; }		

	function setMN_URL($MN_URL){ $this->MN_URL = $MN_URL; }		
	function getMN_URL(){ return $this->MN_URL; }		

	function setMN_USE($MN_USE){ $this->MN_USE = $MN_USE; }		
	function getMN_USE(){ return $this->MN_USE; }		

	function setMN_ORDER($MN_ORDER){ $this->MN_ORDER = $MN_ORDER; }		
	function getMN_ORDER(){ return $this->MN_ORDER; }		

	function setMN_AUTH_L($MN_AUTH_L){ $this->MN_AUTH_L = $MN_AUTH_L; }		
	function getMN_AUTH_L(){ return $this->MN_AUTH_L; }		

	function setMN_AUTH_W($MN_AUTH_W){ $this->MN_AUTH_W = $MN_AUTH_W; }		
	function getMN_AUTH_W(){ return $this->MN_AUTH_W; }		

	function setMN_AUTH_M($MN_AUTH_M){ $this->MN_AUTH_M = $MN_AUTH_M; }		
	function getMN_AUTH_M(){ return $this->MN_AUTH_M; }		

	function setMN_AUTH_D($MN_AUTH_D){ $this->MN_AUTH_D = $MN_AUTH_D; }		
	function getMN_AUTH_D(){ return $this->MN_AUTH_D; }		

	function setMN_AUTH_E($MN_AUTH_E){ $this->MN_AUTH_E = $MN_AUTH_E; }		
	function getMN_AUTH_E(){ return $this->MN_AUTH_E; }		

	function setMN_AUTH_C($MN_AUTH_C){ $this->MN_AUTH_C = $MN_AUTH_C; }		
	function getMN_AUTH_C(){ return $this->MN_AUTH_C; }		

	function setMN_AUTH_S($MN_AUTH_S){ $this->MN_AUTH_S = $MN_AUTH_S; }		
	function getMN_AUTH_S(){ return $this->MN_AUTH_S; }		

	function setMN_AUTH_U($MN_AUTH_U){ $this->MN_AUTH_U = $MN_AUTH_U; }		
	function getMN_AUTH_U(){ return $this->MN_AUTH_U; }		

	function setMN_AUTH_P($MN_AUTH_P){ $this->MN_AUTH_P = $MN_AUTH_P; }		
	function getMN_AUTH_P(){ return $this->MN_AUTH_P; }		

	function setMN_AUTH_E1($MN_AUTH_E1){ $this->MN_AUTH_E1 = $MN_AUTH_E1; }		
	function getMN_AUTH_E1(){ return $this->MN_AUTH_E1; }		

	function setMN_AUTH_E2($MN_AUTH_E2){ $this->MN_AUTH_E2 = $MN_AUTH_E2; }		
	function getMN_AUTH_E2(){ return $this->MN_AUTH_E2; }		

	function setMN_AUTH_E3($MN_AUTH_E3){ $this->MN_AUTH_E3 = $MN_AUTH_E3; }		
	function getMN_AUTH_E3(){ return $this->MN_AUTH_E3; }		

	function setMN_AUTH_E4($MN_AUTH_E4){ $this->MN_AUTH_E4 = $MN_AUTH_E4; }		
	function getMN_AUTH_E4(){ return $this->MN_AUTH_E4; }		

	function setMN_AUTH_E5($MN_AUTH_E5){ $this->MN_AUTH_E5 = $MN_AUTH_E5; }		
	function getMN_AUTH_E5(){ return $this->MN_AUTH_E5; }		

	function setMN_REG_DT($MN_REG_DT){ $this->MN_REG_DT = $MN_REG_DT; }		
	function getMN_REG_DT(){ return $this->MN_REG_DT; }		

	function setMN_REG_NO($MN_REG_NO){ $this->MN_REG_NO = $MN_REG_NO; }		
	function getMN_REG_NO(){ return $this->MN_REG_NO; }		

	function setMN_MOD_DT($MN_MOD_DT){ $this->MN_MOD_DT = $MN_MOD_DT; }		
	function getMN_MOD_DT(){ return $this->MN_MOD_DT; }		

	function setMN_MOD_NO($MN_MOD_NO){ $this->MN_MOD_NO = $MN_MOD_NO; }		
	function getMN_MOD_NO(){ return $this->MN_MOD_NO; }		

	/**공통**/
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }
	/********************************** variable **********************************/


}
?>