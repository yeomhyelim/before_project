<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-14												|# 
#|작성내용	: 수기등록 - 주문자, 수령자 정보							|# 
#/*====================================================================*/# 
class OrderSelfMemberInfoAdmMgr
{
	/********************************** select **********************************/

	/* 주소록 관리 - 주소록 그룹 관리 */
	function getOrderSelfMemberInfoList($db, $op="OP_LIST") 
	{
		$column['OP_LIST']		= "a.*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*";


		$query		= "SELECT %s FROM %s AS a ";
		$query		= sprintf($query, $column[$op], TBL_ORDER_SELF_MEMBER_INFO);

//		$join1		= "%s LEFT OUTER JOIN %s AS b ON a.HA_AG_NO = b.AG_NO";
//		$query		= sprintf($join1, $query, TBL_ORDER_HAND_ADDR_GRP);

		$where		= "%s WHERE a.OM_NO IS NOT NULL ";
		$query		= sprintf($where, $query);
		
		if($this->getOM_NO() && $op == "OP_SELECT") :
			$query = sprintf("%s AND OM_NO = %d", $query, $this->getOM_NO());
		endif;

		if($this->getOM_O_ID()) :
			$query = sprintf("%s AND OM_O_ID = '%s'", $query, $this->getOM_O_ID());
		endif;

		$query		= sprintf("%s ORDER BY a.OM_NO DESC", $query);

		if($this->getPageLine()) :
			$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}



	/********************************** insert **********************************/
	function getOrderSelfMemberInfoInsert($db)
	{
		$query = "CALL SP_ORDER_SELF_MEMBER_INFO_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getOM_NO();
		$param[]  = $this->getOM_O_ID();
		$param[]  = $this->getOM_O_NAME();
		$param[]  = $this->getOM_O_EMAIL();
		$param[]  = $this->getOM_O_PHONE();
		$param[]  = $this->getOM_O_HP();
		$param[]  = $this->getOM_O_ZIP();
		$param[]  = $this->getOM_O_ADDR1();
		$param[]  = $this->getOM_O_ADDR2();
		$param[]  = $this->getOM_R_NAME();
		$param[]  = $this->getOM_R_PHONE();
		$param[]  = $this->getOM_R_HP();
		$param[]  = $this->getOM_R_ZIP();
		$param[]  = $this->getOM_R_ADDR1();
		$param[]  = $this->getOM_R_ADDR2();
		$param[]  = $this->getOM_MEMBER_TYPE();
		$param[]  = $this->getOM_MEMO();
		$param[]  = $this->getOM_SUM_PRICE();
		$param[]  = $this->getOM_DELIVERY_PRICE();
		$param[]  = $this->getOM_POINT();
		$param[]  = $this->getOM_TOTAL_PRICE();
		$param[]  = $this->getOM_BANK_COMPANY_NAME();
		$param[]  = $this->getOM_BANK_ACCOUNT();
		$param[]  = $this->getOM_BANK_NAME();
		$param[]  = $this->getOM_REG_DT();
		$param[]  = $this->getOM_REG_NO();
		$param[]  = $this->getOM_MOD_DT();
		$param[]  = $this->getOM_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** update **********************************/
	function getOrderSelfMemberInfoUpdate($db)
	{
		$query = "CALL SP_ORDER_SELF_MEMBER_INFO_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getOM_NO();
		$param[]  = $this->getOM_O_ID();
		$param[]  = $this->getOM_O_NAME();
		$param[]  = $this->getOM_O_EMAIL();
		$param[]  = $this->getOM_O_PHONE();
		$param[]  = $this->getOM_O_HP();
		$param[]  = $this->getOM_O_ZIP();
		$param[]  = $this->getOM_O_ADDR1();
		$param[]  = $this->getOM_O_ADDR2();
		$param[]  = $this->getOM_R_NAME();
		$param[]  = $this->getOM_R_PHONE();
		$param[]  = $this->getOM_R_HP();
		$param[]  = $this->getOM_R_ZIP();
		$param[]  = $this->getOM_R_ADDR1();
		$param[]  = $this->getOM_R_ADDR2();
		$param[]  = $this->getOM_MEMBER_TYPE();
		$param[]  = $this->getOM_MEMO();
		$param[]  = $this->getOM_SUM_PRICE();
		$param[]  = $this->getOM_DELIVERY_PRICE();
		$param[]  = $this->getOM_POINT();
		$param[]  = $this->getOM_TOTAL_PRICE();
		$param[]  = $this->getOM_BANK_COMPANY_NAME();
		$param[]  = $this->getOM_BANK_ACCOUNT();
		$param[]  = $this->getOM_BANK_NAME();
		$param[]  = $this->getOM_REG_DT();
		$param[]  = $this->getOM_REG_NO();
		$param[]  = $this->getOM_MOD_DT();
		$param[]  = $this->getOM_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** delete **********************************/
	function getOrderSelfMemberInfoDelete($db)
	{
		$query = "CALL SP_ORDER_SELF_MEMBER_INFO_D (?);";
		$param[]  = $this->getOM_NO();

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

	// ORDER_SELF_MEMBER_INFO
	function setOM_NO($OM_NO){ $this->OM_NO = $OM_NO; }		
	function getOM_NO(){ return $this->OM_NO; }		

	function setOM_O_ID($OM_O_ID){ $this->OM_O_ID = $OM_O_ID; }		
	function getOM_O_ID(){ return $this->OM_O_ID; }		

	function setOM_O_NAME($OM_O_NAME){ $this->OM_O_NAME = $OM_O_NAME; }		
	function getOM_O_NAME(){ return $this->OM_O_NAME; }		

	function setOM_O_EMAIL($OM_O_EMAIL){ $this->OM_O_EMAIL = $OM_O_EMAIL; }		
	function getOM_O_EMAIL(){ return $this->OM_O_EMAIL; }		

	function setOM_O_PHONE($OM_O_PHONE){ $this->OM_O_PHONE = $OM_O_PHONE; }		
	function getOM_O_PHONE(){ return $this->OM_O_PHONE; }		

	function setOM_O_HP($OM_O_HP){ $this->OM_O_HP = $OM_O_HP; }		
	function getOM_O_HP(){ return $this->OM_O_HP; }		

	function setOM_O_ZIP($OM_O_ZIP){ $this->OM_O_ZIP = $OM_O_ZIP; }		
	function getOM_O_ZIP(){ return $this->OM_O_ZIP; }		

	function setOM_O_ADDR1($OM_O_ADDR1){ $this->OM_O_ADDR1 = $OM_O_ADDR1; }		
	function getOM_O_ADDR1(){ return $this->OM_O_ADDR1; }		

	function setOM_O_ADDR2($OM_O_ADDR2){ $this->OM_O_ADDR2 = $OM_O_ADDR2; }		
	function getOM_O_ADDR2(){ return $this->OM_O_ADDR2; }		

	function setOM_R_NAME($OM_R_NAME){ $this->OM_R_NAME = $OM_R_NAME; }		
	function getOM_R_NAME(){ return $this->OM_R_NAME; }		

	function setOM_R_PHONE($OM_R_PHONE){ $this->OM_R_PHONE = $OM_R_PHONE; }		
	function getOM_R_PHONE(){ return $this->OM_R_PHONE; }		

	function setOM_R_HP($OM_R_HP){ $this->OM_R_HP = $OM_R_HP; }		
	function getOM_R_HP(){ return $this->OM_R_HP; }		

	function setOM_R_ZIP($OM_R_ZIP){ $this->OM_R_ZIP = $OM_R_ZIP; }		
	function getOM_R_ZIP(){ return $this->OM_R_ZIP; }		

	function setOM_R_ADDR1($OM_R_ADDR1){ $this->OM_R_ADDR1 = $OM_R_ADDR1; }		
	function getOM_R_ADDR1(){ return $this->OM_R_ADDR1; }		

	function setOM_R_ADDR2($OM_R_ADDR2){ $this->OM_R_ADDR2 = $OM_R_ADDR2; }		
	function getOM_R_ADDR2(){ return $this->OM_R_ADDR2; }		

	function setOM_MEMBER_TYPE($OM_MEMBER_TYPE){ $this->OM_MEMBER_TYPE = $OM_MEMBER_TYPE; }		
	function getOM_MEMBER_TYPE(){ return $this->OM_MEMBER_TYPE; }		

	function setOM_MEMO($OM_MEMO){ $this->OM_MEMO = $OM_MEMO; }		
	function getOM_MEMO(){ return $this->OM_MEMO; }		

	function setOM_SUM_PRICE($OM_SUM_PRICE){ $this->OM_SUM_PRICE = $OM_SUM_PRICE; }		
	function getOM_SUM_PRICE(){ return $this->OM_SUM_PRICE; }		

	function setOM_DELIVERY_PRICE($OM_DELIVERY_PRICE){ $this->OM_DELIVERY_PRICE = $OM_DELIVERY_PRICE; }		
	function getOM_DELIVERY_PRICE(){ return $this->OM_DELIVERY_PRICE; }		

	function setOM_POINT($OM_POINT){ $this->OM_POINT = $OM_POINT; }		
	function getOM_POINT(){ return $this->OM_POINT; }		

	function setOM_TOTAL_PRICE($OM_TOTAL_PRICE){ $this->OM_TOTAL_PRICE = $OM_TOTAL_PRICE; }		
	function getOM_TOTAL_PRICE(){ return $this->OM_TOTAL_PRICE; }		

	function setOM_BANK_COMPANY_NAME($OM_BANK_COMPANY_NAME){ $this->OM_BANK_COMPANY_NAME = $OM_BANK_COMPANY_NAME; }		
	function getOM_BANK_COMPANY_NAME(){ return $this->OM_BANK_COMPANY_NAME; }		

	function setOM_BANK_ACCOUNT($OM_BANK_ACCOUNT){ $this->OM_BANK_ACCOUNT = $OM_BANK_ACCOUNT; }		
	function getOM_BANK_ACCOUNT(){ return $this->OM_BANK_ACCOUNT; }		

	function setOM_BANK_NAME($OM_BANK_NAME){ $this->OM_BANK_NAME = $OM_BANK_NAME; }		
	function getOM_BANK_NAME(){ return $this->OM_BANK_NAME; }		

	function setOM_REG_DT($OM_REG_DT){ $this->OM_REG_DT = $OM_REG_DT; }		
	function getOM_REG_DT(){ return $this->OM_REG_DT; }		

	function setOM_REG_NO($OM_REG_NO){ $this->OM_REG_NO = $OM_REG_NO; }		
	function getOM_REG_NO(){ return $this->OM_REG_NO; }		

	function setOM_MOD_DT($OM_MOD_DT){ $this->OM_MOD_DT = $OM_MOD_DT; }		
	function getOM_MOD_DT(){ return $this->OM_MOD_DT; }		

	function setOM_MOD_NO($OM_MOD_NO){ $this->OM_MOD_NO = $OM_MOD_NO; }		
	function getOM_MOD_NO(){ return $this->OM_MOD_NO; }	

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