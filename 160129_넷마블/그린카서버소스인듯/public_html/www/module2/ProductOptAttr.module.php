<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-16												|# 
#|작성내용	: 상품 옵션 속성 관리 클래스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductOptAttrModule extends Module2
{
	function getProductOptAttrSelectEx($op, $param)
	{
	}

	function getProductOptAttrInsertEx($param)
	{
	}

	function getProductOptAttrUpdateEx($param)
	{

	}

	// 상품옵션별 수량 변경
	function getProductOptAttrQTYSumUpdateEx($param)
	{
		## 기본 설정
		$intPOA_NO = $param['POA_NO'];
		$intPOA_STOCK_QTY = $param['POA_STOCK_QTY'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['POA_STOCK_QTY']			= "IFNULL(POA_STOCK_QTY, 0) + {$intPOA_STOCK_QTY}";

		## where
		$where = "POA_NO = {$intPOA_NO}";

		return $this->db->getUpdateParam("PRODUCT_OPT_ATTR", $paramData, $where);		
	}

	function getProductOptAttrDeleteEx($param)
	{

	}

	function getSelectQuery($query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $this->db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $this->db->getSelect($query);
		elseif ( $op == "OP_COUNT" ) :
			return $this->db->getCount($query);
		elseif ( $op == "OP_ARYLIST" ) :
			return $this->db->getArray($query);
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $this->db->getArrayTotal($query);
		else :
			return -100;
		endif;
	}	
}