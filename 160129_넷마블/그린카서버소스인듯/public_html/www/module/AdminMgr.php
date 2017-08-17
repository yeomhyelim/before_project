<?
#/*====================================================================*/#
#|화일명	: 관리자관리												|#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2012-03-10												|#
#|작성내용	: 관리자 등록/수정/삭제										|#
#/*====================================================================*/#

class AdminMgr
{
	private $query;
	private $param;
	
	function getAdminListEx($db, $op, $param) 
	{
		$column['OP_LIST']			= "*";
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "*";

		if(!$op)			{ return; }

		$from	= TBL_ADMIN_MGR;
		$query	= "SELECT {$column[$op]} FROM {$from} AS A";
		$where	= "WHERE A.M_NO IS NOT NULL";

		if($param['M_NO']):
			$where = "{$where} AND A.M_NO = {$param['M_NO']}";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** List Total **********************************/
	function getTotal($db) {		
		
		$query  =  "SELECT						";
		$query .= "     COUNT(*)				";
		$query .= "FROM ".TBL_ADMIN_MGR." A		";
		$query .= "JOIN ".TBL_MEMBER_MGR." B	";
		$query .= "ON A.M_NO = B.M_NO			";
		$query .= "WHERE A.M_NO IS NOT NULL		";
		$query .= "	AND A.A_STATUS > 0			";
		
		if ($this->getSearchStatus() == "1"){
			$query .= "	AND A.A_STATUS = 1		";
		}

		if ($this->getSearchStatus() == "9"){
			$query .= "	AND A.A_STATUS = 9		";
		}
				
		//검색어
		if ($this->getSearchField() && $this->getSearchKey()) {			
			$strSearchField = ""; 
			switch($this->getSearchField()){
				case "T":
					$strSearchField = "TRIM(REPLACE(CONCAT(B.M_F_NAME,B.M_L_NAME),' ','')) 	";
				break;
				case "I":
					$strSearchField = "B.M_ID	";
				break;
			}
			
			if ($strSearchField)
				$query .=" AND ".$strSearchField." LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'";
		}
		return $db->getCount($query);
	}

	/********************************** List **********************************/
	function getList($db) {		
		
		$query  =  "SELECT						";
		$query .= "     A.*						";
		$query .= "    ,CONCAT(IFNULL(B.M_F_NAME,''),' ',IFNULL(B.M_L_NAME,'')) M_NAME	";
		$query .= "    ,B.M_ID					";
		$query .= "    ,B.M_MAIL				";
		$query .= "    ,B.M_PHONE				";
		$query .= "FROM ".TBL_ADMIN_MGR." A		";
		$query .= "JOIN ".TBL_MEMBER_MGR." B	";
		$query .= "ON A.M_NO = B.M_NO			";
		$query .= "WHERE A.M_NO IS NOT NULL		";
		$query .= "	AND A.A_STATUS > 0			";
		
		if ($this->getSearchStatus() == "1"){
			$query .= "	AND A.A_STATUS = 1		";
		}

		if ($this->getSearchStatus() == "9"){
			$query .= "	AND A.A_STATUS = 9		";
		}
								
		//검색어
		if ($this->getSearchField() && $this->getSearchKey()) {			
			$strSearchField = ""; 
			switch($this->getSearchField()){
				case "T":
					$strSearchField = "TRIM(REPLACE(CONCAT(B.M_F_NAME,B.M_L_NAME),' ','')) 	";
				break;
				case "I":
					$strSearchField = "B.M_ID	";
				break;
			}
			
			if ($strSearchField)
				$query .=" AND ".$strSearchField." LIKE '%".mysql_real_escape_string($this->getSearchKey())."%'";
		}
		
		$query .= "ORDER BY A.A_REG_DT DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();

		return $db->getExecSql($query);
	}

	/********************************** Insert **********************************/
	function getIdChk($db)
	{
		$query = "SELECT * FROM ".TBL_ADMIN_MGR." WHERE M_NO=".mysql_real_escape_string($this->getM_NO());

		return $db->getSelect($query);
	}
	
	function getUniqeCount($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_ADMIN_MGR." WHERE M_NO=".mysql_real_escape_string($this->getM_NO());
		return $db->getCount($query);
	}

	function getInsert($db)
	{
		$query = "CALL SP_ADMIN_MGR_I (?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getA_MEMO();
		$param[]  = $this->getA_TM();
		$param[]  = $this->getA_STATUS();
		$param[]  = $this->getA_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** View **********************************/
	function getView($db)
	{
		$query  = "SELECT											";
		$query .= "     A.M_F_NAME									";
		$query .= "    ,A.M_MAIL									";
		$query .= "    ,A.M_PHONE									";
		$query .= "    ,CONCAT(A.M_F_NAME,' ',A.M_L_NAME) M_NAME	";
		$query .= "    ,A.M_ID										";
		$query .= "	   ,B.*											";
		$query .= "FROM ".TBL_MEMBER_MGR." A, ".TBL_ADMIN_MGR." B	";
		$query .= "WHERE A.M_NO = B.M_NO							";
		$query .= "	AND B.M_NO = ".mysql_real_escape_string($this->getM_NO());
		return $db->getSelect($query);
	}
	
	function getSuperView($db)
	{
		$query  = "SELECT											";
		$query .= "     A.*											";
		$query .= "FROM ".TBL_MEMBER_MGR." A, ".TBL_ADMIN_MGR." B	";
		$query .= "WHERE A.M_NO = B.M_NO							";
		$query .= "	AND B.A_STATUS = 0								";
		
		return $db->getSelect($query);
	}

	function getSuperPwdCheck($db)
	{
		$query  = "SELECT SHA1(CONCAT('".$this->getM_PASS()."','!@#$'))	";
		return $db->getCount($query);
	}

	/********************************** Update **********************************/
	function getUpdate($db)
	{
		$query = "CALL SP_ADMIN_MGR_U (?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getA_MEMO();
		$param[]  = $this->getA_TM();

		return $db->executeBindingQuery($query,$param,true);
	}
	
	function getDelete($db)
	{
		$query  = "UPDATE ".TBL_ADMIN_MGR." SET A_STATUS = 9 ";
		$query .= "WHERE M_NO = ".$this->getM_NO();

		return $db->getExecSql($query);
	}

	function getRestore($db)
	{
		$query  = "UPDATE ".TBL_ADMIN_MGR." SET A_STATUS = 1 ";
		$query .= "WHERE M_NO = ".$this->getM_NO();

		return $db->getExecSql($query);
	}


	function getSuperUpdate($db)
	{
		$query = "CALL SP_SUPER_ADMIN_U (?);";
		$param[] = $this->getM_PASS();

		return $db->executeBindingQuery($query,$param,true);	
	}

	function getShopListUpdateEx($db, $paramData) {
		
		$param['A_SHOP_LIST']		= $db->getSQLString($paramData['A_SHOP_LIST']);

		if($paramData['M_NO']):
			$where					= "M_NO = {$paramData['M_NO']}";
		endif;

		if(!$where) { return; }

		return $db->getUpdateParam(TBL_ADMIN_MGR,$param, $where);		
	}

	/********************************** Login **********************************/
	function getLogin($db)
	{
		global $ADMIN_SHOP_SELECT_USE;

		$query  = "SELECT											";
		$query .= "     A.*											";
		$query .= "    ,B.A_STATUS									";
		$query .= "    ,B.A_LNG										";
		$query .= "    ,B.A_TM_YN									";
		
		if ($ADMIN_SHOP_SELECT_USE == "Y"){
			$query .= "    ,B.A_SHOP_LIST							";
		}

		$query .= "	   ,C.G_LEVEL									";
		$query .= "    ,CASE WHEN IFNULL(A.M_F_NAME,'') != '' THEN CONCAT(IFNULL(A.M_L_NAME,''),' ',IFNULL(A.M_F_NAME,'')) ELSE A.M_L_NAME END M_NAME ";
		$query .= "FROM ".TBL_MEMBER_MGR." A						";
		$query .= "JOIN ".TBL_ADMIN_MGR." B							";
		$query .= "ON A.M_NO = B.M_NO								";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_GROUP." C			";
		$query .= "ON A.M_GROUP = C.G_CODE							";

		if ($this->getM_ID()){
			$query .= "WHERE A.M_ID			= '".mysql_real_escape_string($this->getM_ID())."'		";
		}

		if ($this->getM_MAIL()){
			$query .= "WHERE A.M_MAIL		= '".mysql_real_escape_string($this->getM_MAIL())."'		";
		}
		return $db->getSelect($query);
	}

	function getLoginPwdCheck($db)
	{

		$query  = "SELECT											";
		$query .= "     A.*											";
		$query .= "    ,B.A_STATUS									";
		$query .= "    ,B.A_LNG										";
		$query .= "	   ,C.G_LEVEL									";
		$query .= "FROM ".TBL_MEMBER_MGR." A						";
		$query .= "JOIN ".TBL_ADMIN_MGR." B							";
		$query .= "ON A.M_NO = B.M_NO								";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_GROUP." C			";
		$query .= "ON A.M_GROUP = C.G_CODE							";

		if ($this->getM_ID()){
			$query .= "WHERE A.M_ID			= '".mysql_real_escape_string($this->getM_ID())."'		";
		}

		if ($this->getM_MAIL()){
			$query .= "WHERE A.M_MAIL		= '".mysql_real_escape_string($this->getM_MAIL())."'		";
		}
		$query .= " AND A.M_PASS = SHA1(CONCAT('".$this->getM_PASS()."','!@#$'))	";
		
		return $db->getCount($query);
	}

	function getLoginMenuUrl($db){
		$query  = "SELECT                                                                                     ";
		$query .= "     A.*																					  ";
		$query .= "FROM ".TBL_ADMIN_MENU." A                                                                  ";
//		$query .= "JOIN ".TBL_MENU_MGR." B                                                                    ";
//		$query .= "ON A.MN_NO = B.MN_NO                                                                       ";
//		$query .= "AND B.MN_LEVEL = 1                                                                         ";
		$query .= "WHERE A.M_NO = ".mysql_real_escape_string($this->getM_NO())."                              ";
		$query .= "		AND A.AM_TYPE = '".$this->getAM_TYPE()."'											  ";
//		$query .= "	AND (A.MN_HIGH_01 IS NULL OR A.MN_HIGH_01 = '')											  ";	
//		$query .= "AND B.MN_USE = 'Y'                                                                         ";
		$query .= "ORDER BY A.MN_CODE ASC											                          ";
		//echo 'getLoginMenuUrl:'.$query;exit;
		return $db->getArrayTotal($query);
	}

	function getLoginLowMenuArray($db)
	{
	
		$query  = "SELECT                                                                           ";
		$query .= "     A.MN_CODE                                                                   ";
		$query .= "    ,A.MN_HIGH_01                                                                ";
		$query .= "    ,A.MN_HIGH_02                                                                ";
		$query .= "    ,A.MN_NO		                                                                ";
		$query .= "FROM ".TBL_ADMIN_MENU." A                                                        ";
		$query .= "WHERE A.M_NO = ".mysql_real_escape_string($this->getM_NO())."                    ";
		$query .= "		AND A.AM_TYPE = '".$this->getAM_TYPE()."'									";
		$query .= "AND A.MN_HIGH_01 = '".$this->getMN_HIGH_01()."'									";
		$query .= "AND (A.MN_HIGH_02 IS NULL OR A.MN_HIGH_02 = '')									";	
		$query .= "ORDER BY A.MN_CODE ASC															";
		return $db->getArrayTotal($query);
	}

	function getLoginLowMenuArray02($db)
	{
		$query  = "SELECT                                                                           ";
		$query .= "     A.MN_CODE                                                                   ";
		$query .= "    ,A.MN_HIGH_01                                                                ";
		$query .= "    ,A.MN_HIGH_02                                                                ";
		$query .= "    ,A.MN_NO		                                                                ";
		$query .= "FROM ".TBL_ADMIN_MENU." A                                                        ";
		$query .= "WHERE A.M_NO = ".mysql_real_escape_string($this->getM_NO())."                    ";
		$query .= "		AND A.AM_TYPE = '".$this->getAM_TYPE()."'									";
		$query .= "AND A.MN_HIGH_01 = '".$this->getMN_HIGH_01()."'									";
		$query .= "AND A.MN_HIGH_02 = '".$this->getMN_HIGH_02()."'									";
		$query .= "ORDER BY A.MN_CODE ASC															";
		return $db->getArrayTotal($query);
	}


	function getSelectQuery($db, $query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $db->getSelect($query);
		elseif ( $op == "OP_COUNT" ) :
			return $db->getCount($query);
		elseif ( $op == "OP_ARYLIST" ) :
			return $db->getArray($query);
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $db->getArrayTotal($query);
		else :
			return -100;
		endif;
	}

	/********************************** variable **********************************/
	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		

	function setA_MEMO($A_MEMO){ $this->A_MEMO = $A_MEMO; }		
	function getA_MEMO(){ return $this->A_MEMO; }		

	function setA_STATUS($A_STATUS){ $this->A_STATUS = $A_STATUS; }		
	function getA_STATUS(){ return $this->A_STATUS; }		

	function setA_TM($A_TM){ $this->A_TM = $A_TM; }		
	function getA_TM(){ return $this->A_TM; }		

	function setA_REG_DT($A_REG_DT){ $this->A_REG_DT = $A_REG_DT; }		
	function getA_REG_DT(){ return $this->A_REG_DT; }		

	function setA_REG_NO($A_REG_NO){ $this->A_REG_NO = $A_REG_NO; }		
	function getA_REG_NO(){ return $this->A_REG_NO; }		

	function setA_MOD_DT($A_MOD_DT){ $this->A_MOD_DT = $A_MOD_DT; }		
	function getA_MOD_DT(){ return $this->A_MOD_DT; }		

	function setA_MOD_NO($A_MOD_NO){ $this->A_MOD_NO = $A_MOD_NO; }		
	function getA_MOD_NO(){ return $this->A_MOD_NO; }		

	function setM_ID($M_ID){ $this->M_ID = $M_ID; }
	function getM_ID(){ return $this->M_ID; }

	function setM_MAIL($M_MAIL){ $this->M_MAIL = $M_MAIL; }
	function getM_MAIL(){ return $this->M_MAIL; }

	function setM_PASS($M_PASS){ 
		if (!$M_PASS) $this->M_PASS = "";
		else $this->M_PASS = $M_PASS; 
	}
	function getM_PASS(){ return $this->M_PASS; }

	/**공통**/
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }
	
	function setSearchStatus($SEARCH_STATUS){ $this->SEARCH_STATUS = $SEARCH_STATUS; }		
	function getSearchStatus(){ return $this->SEARCH_STATUS; }
	
	function setMN_HIGH_01($MN_HIGH_01){ $this->MN_HIGH_01 = $MN_HIGH_01; }		
	function getMN_HIGH_01(){ return $this->MN_HIGH_01; }		

	function setMN_HIGH_02($MN_HIGH_02){ $this->MN_HIGH_02 = $MN_HIGH_02; }		
	function getMN_HIGH_02(){ return $this->MN_HIGH_02; }

	function setAM_TYPE($AM_TYPE){ $this->AM_TYPE = $AM_TYPE; }		
	function getAM_TYPE(){ return $this->AM_TYPE; }		


	/********************************** variable **********************************/
}
?>
