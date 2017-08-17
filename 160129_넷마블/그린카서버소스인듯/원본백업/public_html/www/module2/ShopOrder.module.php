<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 입점사 주문관리 모듈 클래스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class ShopOrderModule extends Module2
{
	function getShopOrderSelectEx($op, $param)
	{
		
	}

	function getShopOrderInsertEx($param)
	{
	}

	function getShopOrderUpdateEx($param)
	{

	}
	
	// 입점사 주문상태 변경
	function getShopOrderOrderStatusUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strSO_ORDER_STATUS = $param['SO_ORDER_STATUS'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['SO_ORDER_STATUS']		= $this->db->getSQLString($strSO_ORDER_STATUS);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("SHOP_ORDER", $paramData, $where);	
	}
	
	// 입점사 배송상태 변경
	function getShopOrderDeliveryStatusUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strSO_DELIVERY_STATUS = $param['SO_DELIVERY_STATUS'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['SO_DELIVERY_STATUS']	= $this->db->getSQLString($strSO_DELIVERY_STATUS);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("SHOP_ORDER", $paramData, $where);	
	}

	function getShopOrderDeleteEx($param)
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