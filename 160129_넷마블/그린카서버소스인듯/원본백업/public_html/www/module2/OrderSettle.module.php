<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 주문결제관리 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class OrderSettleModule extends Module2
{

	function getOrderSettleSelectEx($op, $param)
	{

	}

	function getOrderSettleInsertEx($param)
	{
		## 체크
		if(!$param['O_NO']) { return; }

		$paramData							= "";
//		$paramData['OS_NO']					= $this->db->getSQLInteger($param['OS_NO']);
		$paramData['O_NO']					= $this->db->getSQLInteger($param['O_NO']);
		$paramData['M_NO']					= $this->db->getSQLInteger($param['M_NO']);
		$paramData['OS_TITLE']				= $this->db->getSQLString($param['OS_TITLE']);
		$paramData['OS_USE_POINT']			= $this->db->getSQLInteger($param['OS_USE_POINT']);
		$paramData['OS_USE_COUPON']			= $this->db->getSQLInteger($param['OS_USE_COUPON']);
		$paramData['OS_TOT_PRICE']			= $this->db->getSQLInteger($param['OS_TOT_PRICE']);
		$paramData['OS_TOT_DELIVERY_PRICE']	= $this->db->getSQLInteger($param['OS_TOT_DELIVERY_PRICE']);
		$paramData['OS_TOT_TAX_PRICE']		= $this->db->getSQLInteger($param['OS_TOT_TAX_PRICE']);
		$paramData['OS_TOT_SPRICE']			= $this->db->getSQLInteger($param['OS_TOT_SPRICE']);
		$paramData['OS_TOT_POINT']			= $this->db->getSQLInteger($param['OS_TOT_POINT']);
		$paramData['OS_STATUS']				= $this->db->getSQLString($param['OS_STATUS']);
		$paramData['OS_SETTLE']				= $this->db->getSQLString($param['OS_SETTLE']);
		$paramData['OS_APPR_NO']			= $this->db->getSQLString($param['OS_APPR_NO']);
		$paramData['OS_APPR_DT']			= $this->db->getSQLDatetime($param['OS_APPR_DT']);
		$paramData['OS_DEAL_NO']			= $this->db->getSQLString($param['OS_DEAL_NO']);
		$paramData['OS_CEL_NO']				= $this->db->getSQLString($param['OS_CEL_NO']);
		$paramData['OS_CEL_DT']				= $this->db->getSQLDatetime($param['OS_CEL_DT']);
		$paramData['OS_ES_SENDNO']			= $this->db->getSQLString($param['OS_ES_SENDNO']);
		$paramData['OS_CARD_CODE']			= $this->db->getSQLString($param['OS_CARD_CODE']);

		return $this->db->getInsertParam("ORDER_SETTLE", $paramData);
	}

	function getOrderSettleUpdateEx($param)
	{

	}

	function getOrderSettleDeleteEx($param)
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