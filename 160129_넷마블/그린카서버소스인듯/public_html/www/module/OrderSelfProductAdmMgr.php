<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-14												|# 
#|작성내용	: 수기등록 - 주문상품정보									|# 
#/*====================================================================*/# 
class OrderSelfProductAdmMgr
{
	/********************************** select **********************************/

	function getOrderSelfProductList($db, $op="OP_LIST") 
	{
		$column['OP_LIST']		= "a.*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*";

		$query		= "SELECT %s FROM %s AS a ";
		$query		= sprintf($query, $column[$op], TBL_ORDER_SELF_PRODUCT);

//		$join1		= "%s LEFT OUTER JOIN %s AS b ON a.HA_AG_NO = b.AG_NO";
//		$query		= sprintf($join1, $query, TBL_ORDER_HAND_ADDR_GRP);

		$where		= "%s WHERE a.OP_NO IS NOT NULL ";
		$query		= sprintf($where, $query);
		
		if($this->getOP_NO() && $op == "OP_SELECT") :
			$query = sprintf("%s AND a.OP_NO = %d", $query, $this->geOP_NO());
		endif;

		$query		= sprintf("%s ORDER BY a.OP_NO DESC", $query);

		if($this->getPageLine()) :
			$query = sprintf("%s LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** insert **********************************/
	function getOrderSelfProductInsert($db)
	{
		$query = "CALL SP_ORDER_SELF_PRODUCT_I (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getOP_NO();
		$param[]  = $this->getOP_OM_NO();
		$param[]  = $this->getOP_P_CODE();
		$param[]  = $this->getOP_P_NAME();
		$param[]  = $this->getOP_P_POINT();
		$param[]  = $this->getOP_P_QTY();
		$param[]  = $this->getOP_P_SALE_PRICE();
		$param[]  = $this->getOP_P_REG_DT();
		$param[]  = $this->getOP_P_REG_NO();
		$param[]  = $this->getOP_P_MOD_DT();
		$param[]  = $this->getOP_P_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** update **********************************/
	function getOrderSelfProductUpdate($db)
	{
		$query = "CALL SP_ORDER_SELF_PRODUCT_U (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getOP_NO();
		$param[]  = $this->getOP_OM_NO();
		$param[]  = $this->getOP_P_CODE();
		$param[]  = $this->getOP_P_NAME();
		$param[]  = $this->getOP_P_POINT();
		$param[]  = $this->getOP_P_QTY();
		$param[]  = $this->getOP_P_SALE_PRICE();
		$param[]  = $this->getOP_P_REG_DT();
		$param[]  = $this->getOP_P_REG_NO();
		$param[]  = $this->getOP_P_MOD_DT();
		$param[]  = $this->getOP_P_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** delete **********************************/
	function getOrderSelfProductDelete($db)
	{
		$query = "CALL SP_ORDER_SELF_PRODUCT_D (?);";
		$param[]  = $this->getOP_NO();

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

	// ORDER_SELF_PRODUCT
	function setOP_NO($OP_NO){ $this->OP_NO = $OP_NO; }		
	function getOP_NO(){ return $this->OP_NO; }		

	function setOP_OM_NO($OP_OM_NO){ $this->OP_OM_NO = $OP_OM_NO; }		
	function getOP_OM_NO(){ return $this->OP_OM_NO; }		

	function setOP_P_CODE($OP_P_CODE){ $this->OP_P_CODE = $OP_P_CODE; }		
	function getOP_P_CODE(){ return $this->OP_P_CODE; }		

	function setOP_P_NAME($OP_P_NAME){ $this->OP_P_NAME = $OP_P_NAME; }		
	function getOP_P_NAME(){ return $this->OP_P_NAME; }		

	function setOP_P_POINT($OP_P_POINT){ $this->OP_P_POINT = $OP_P_POINT; }		
	function getOP_P_POINT(){ return $this->OP_P_POINT; }		

	function setOP_P_QTY($OP_P_QTY){ $this->OP_P_QTY = $OP_P_QTY; }		
	function getOP_P_QTY(){ return $this->OP_P_QTY; }		

	function setOP_P_SALE_PRICE($OP_P_SALE_PRICE){ $this->OP_P_SALE_PRICE = $OP_P_SALE_PRICE; }		
	function getOP_P_SALE_PRICE(){ return $this->OP_P_SALE_PRICE; }		

	function setOP_P_REG_DT($OP_P_REG_DT){ $this->OP_P_REG_DT = $OP_P_REG_DT; }		
	function getOP_P_REG_DT(){ return $this->OP_P_REG_DT; }		

	function setOP_P_REG_NO($OP_P_REG_NO){ $this->OP_P_REG_NO = $OP_P_REG_NO; }		
	function getOP_P_REG_NO(){ return $this->OP_P_REG_NO; }		

	function setOP_P_MOD_DT($OP_P_MOD_DT){ $this->OP_P_MOD_DT = $OP_P_MOD_DT; }		
	function getOP_P_MOD_DT(){ return $this->OP_P_MOD_DT; }		

	function setOP_P_MOD_NO($OP_P_MOD_NO){ $this->OP_P_MOD_NO = $OP_P_MOD_NO; }		
	function getOP_P_MOD_NO(){ return $this->OP_P_MOD_NO; }		

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