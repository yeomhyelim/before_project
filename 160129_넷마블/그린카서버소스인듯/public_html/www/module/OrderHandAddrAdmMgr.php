<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-14												|# 
#|작성내용	: 주문관리													|# 
#/*====================================================================*/# 
class OrderHandAddrAdmMgr
{
	/********************************** select **********************************/

	/* 주소록 관리 - 주소록 그룹 관리 */
	function getOrderHandAddrList($db, $op="OP_LIST") 
	{
		$column['OP_LIST']		= "a.*, b.AG_NAME";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*, b.AG_NAME";
		$column['OP_ARYTOTAL']	= "a.HA_NO, a.HA_NAME";

		$query		= "SELECT %s FROM %s AS a ";
		$query		= sprintf($query, $column[$op], TBL_ORDER_HAND_ADDR);

		$join1		= "%s LEFT OUTER JOIN %s AS b ON a.HA_AG_NO = b.AG_NO";
		$query		= sprintf($join1, $query, TBL_ORDER_HAND_ADDR_GRP);

		$where		= "%s WHERE a.HA_NO IS NOT NULL ";
		$query		= sprintf($where, $query);
		
		if($this->getHA_NO() && $op == "OP_SELECT") :
			$query = sprintf("%s AND HA_NO = %d", $query, $this->getHA_NO());
		endif;

		if($this->getHA_NAME()) :
			$query = sprintf("%s AND HA_NAME = '%s'", $query, $this->getHA_NAME());
		endif;

		if($this->getSearchField()):
			switch($this->getSearchField()):
			case "N":
				$query = sprintf("%s AND HA_NAME LIKE ('%%%s%%')", $query, $this->getSearchKey());
			break;
			endswitch;
		endif;

		$query		= sprintf("%s ORDER BY a.HA_NO DESC", $query);

		if($this->getPageLine()) :
			$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}

	/* 주소록 관리 - 주소록 그룹 관리 */
	function getOrderHandAddrGrpList($db, $op="OP_LIST") 
	{
		$column['OP_LIST']		= "a.*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*";
		$column['OP_ARYTOTAL']	= "a.AG_NO, a.AG_NAME";

		$query		= "SELECT %s FROM %s AS a ";
		$query		= sprintf($query, $column[$op], TBL_ORDER_HAND_ADDR_GRP);

		$where		= "%s WHERE a.AG_NO IS NOT NULL ";
		$query		= sprintf($where, $query);
		
		if($this->getAG_NO() && $op == "OP_SELECT") :
			$query = sprintf("%s AND AG_NO = %d", $query, $this->getAG_NO());
		endif;

		if($this->getAG_NAME()) :
			$query = sprintf("%s AND AG_NAME = '%s'", $query, $this->getAG_NAME());
		endif;

		$query		= sprintf("%s ORDER BY a.AG_NO DESC", $query);

		if($this->getPageLine()) :
			$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** insert **********************************/
	function getOrderHandAddrInsert($db)
	{
		$query = "CALL SP_ORDER_HAND_ADDR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getHA_NO();
		$param[]  = $this->getHA_AG_NO();
		$param[]  = $this->getHA_NAME();
		$param[]  = $this->getHA_ZIP();
		$param[]  = $this->getHA_ADDR1();
		$param[]  = $this->getHA_ADDR2();
		$param[]  = $this->getHA_EMAIL();
		$param[]  = $this->getHA_PHONE1();
		$param[]  = $this->getHA_PHONE2();
		$param[]  = $this->getHA_MEMO();
		$param[]  = $this->getHA_REG_DT();
		$param[]  = $this->getHA_REG_NO();
		$param[]  = $this->getHA_MOD_DT();
		$param[]  = $this->getHA_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getOrderHandAddrGrpInsert($db)
	{
		$query = "CALL SP_ORDER_HAND_ADDR_GRP_I (?,?,?,?,?,?,?);";

		$param[]  = $this->getAG_NO();
		$param[]  = $this->getAG_NAME();
		$param[]  = $this->getAG_CNT();
		$param[]  = $this->getAG_REG_DT();
		$param[]  = $this->getAG_REG_NO();
		$param[]  = $this->getAG_MOD_DT();
		$param[]  = $this->getAG_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** update **********************************/
	function getOrderHandAddrUpdate($db)
	{
		$query = "CALL SP_ORDER_HAND_ADDR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getHA_NO();
		$param[]  = $this->getHA_AG_NO();
		$param[]  = $this->getHA_NAME();
		$param[]  = $this->getHA_ZIP();
		$param[]  = $this->getHA_ADDR1();
		$param[]  = $this->getHA_ADDR2();
		$param[]  = $this->getHA_EMAIL();
		$param[]  = $this->getHA_PHONE1();
		$param[]  = $this->getHA_PHONE2();
		$param[]  = $this->getHA_MEMO();
		$param[]  = $this->getHA_REG_DT();
		$param[]  = $this->getHA_REG_NO();
		$param[]  = $this->getHA_MOD_DT();
		$param[]  = $this->getHA_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getOrderHandAddrGrpUpdate($db)
	{
		$query = "CALL SP_ORDER_HAND_ADDR_GRP_U (?,?,?,?,?,?,?);";

		$param[]  = $this->getAG_NO();
		$param[]  = $this->getAG_NAME();
		$param[]  = $this->getAG_CNT();
		$param[]  = $this->getAG_REG_DT();
		$param[]  = $this->getAG_REG_NO();
		$param[]  = $this->getAG_MOD_DT();
		$param[]  = $this->getAG_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** delete **********************************/
	function getOrderHandAddrDelete($db)
	{
		$query = "CALL SP_ORDER_HAND_ADDR_D (?);";
		$param[]  = $this->getHA_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getOrderHandAddrGrpDelete($db)
	{
		$query = "CALL SP_ORDER_HAND_ADDR_GRP_D (?);";
		$param[]  = $this->getAG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** function **********************************/
	// 쿼리 선택
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

	// ORDER_HAND_ADDR
	function setHA_NO($HA_NO){ $this->HA_NO = $HA_NO; }		
	function getHA_NO(){ return $this->HA_NO; }		

	function setHA_AG_NO($HA_AG_NO){ $this->HA_AG_NO = $HA_AG_NO; }		
	function getHA_AG_NO(){ return $this->HA_AG_NO; }		

	function setHA_NAME($HA_NAME){ $this->HA_NAME = $HA_NAME; }		
	function getHA_NAME(){ return $this->HA_NAME; }		

	function setHA_ZIP($HA_ZIP){ $this->HA_ZIP = $HA_ZIP; }		
	function getHA_ZIP(){ return $this->HA_ZIP; }		

	function setHA_ADDR1($HA_ADDR1){ $this->HA_ADDR1 = $HA_ADDR1; }		
	function getHA_ADDR1(){ return $this->HA_ADDR1; }		

	function setHA_ADDR2($HA_ADDR2){ $this->HA_ADDR2 = $HA_ADDR2; }		
	function getHA_ADDR2(){ return $this->HA_ADDR2; }		

	function setHA_EMAIL($HA_EMAIL){ $this->HA_EMAIL = $HA_EMAIL; }		
	function getHA_EMAIL(){ return $this->HA_EMAIL; }		

	function setHA_PHONE1($HA_PHONE1){ $this->HA_PHONE1 = $HA_PHONE1; }		
	function getHA_PHONE1(){ return $this->HA_PHONE1; }		

	function setHA_PHONE2($HA_PHONE2){ $this->HA_PHONE2 = $HA_PHONE2; }		
	function getHA_PHONE2(){ return $this->HA_PHONE2; }		

	function setHA_MEMO($HA_MEMO){ $this->HA_MEMO = $HA_MEMO; }		
	function getHA_MEMO(){ return $this->HA_MEMO; }		

	function setHA_REG_DT($HA_REG_DT){ $this->HA_REG_DT = $HA_REG_DT; }		
	function getHA_REG_DT(){ return $this->HA_REG_DT; }		

	function setHA_REG_NO($HA_REG_NO){ $this->HA_REG_NO = $HA_REG_NO; }		
	function getHA_REG_NO(){ return $this->HA_REG_NO; }		

	function setHA_MOD_DT($HA_MOD_DT){ $this->HA_MOD_DT = $HA_MOD_DT; }		
	function getHA_MOD_DT(){ return $this->HA_MOD_DT; }		

	function setHA_MOD_NO($HA_MOD_NO){ $this->HA_MOD_NO = $HA_MOD_NO; }		
	function getHA_MOD_NO(){ return $this->HA_MOD_NO; }


	// ORDER_HAND_ADDR_GRP
	function setAG_NO($AG_NO){ $this->AG_NO = $AG_NO; }		
	function getAG_NO(){ return $this->AG_NO; }		

	function setAG_NAME($AG_NAME){ $this->AG_NAME = $AG_NAME; }		
	function getAG_NAME(){ return $this->AG_NAME; }		

	function setAG_CNT($AG_CNT){ $this->AG_CNT = $AG_CNT; }		
	function getAG_CNT(){ return $this->AG_CNT; }		

	function setAG_REG_DT($AG_REG_DT){ $this->AG_REG_DT = $AG_REG_DT; }		
	function getAG_REG_DT(){ return $this->AG_REG_DT; }		

	function setAG_REG_NO($AG_REG_NO){ $this->AG_REG_NO = $AG_REG_NO; }		
	function getAG_REG_NO(){ return $this->AG_REG_NO; }		

	function setAG_MOD_DT($AG_MOD_DT){ $this->AG_MOD_DT = $AG_MOD_DT; }		
	function getAG_MOD_DT(){ return $this->AG_MOD_DT; }		

	function setAG_MOD_NO($AG_MOD_NO){ $this->AG_MOD_NO = $AG_MOD_NO; }		
	function getAG_MOD_NO(){ return $this->AG_MOD_NO; }

	/*--------------------------------------------------------------*/	
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }






}
?>