<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 장바구니 모듈 클래스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductBasketAddModule extends Module2
{
	function getProductBasketAddSelectEx($op, $param)
	{
		
	}

	function getProductBasketAddInsertEx($param)
	{
	}

	function getProductBasketAddUpdateEx($param)
	{

	}

	function getProductBasketAddDeleteEx($param)
	{
		## 기본 설정
		$intPB_NO = $param['PB_NO'];

		## 공백제거
		$intPB_NO = trim($intPB_NO);

		## 체크
		if(!$intPB_NO) { return; }
		
		## WHERE 절 설정
		$where = "PB_NO = {$intPB_NO}";

		return $this->db->getDelete("PRODUCT_BASKET_ADD", $where);
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