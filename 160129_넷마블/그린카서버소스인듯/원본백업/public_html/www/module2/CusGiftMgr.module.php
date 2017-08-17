<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 고객사은품관리 모듈 클래스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class CusGiftMgrModule extends Module2
{
	function getCusGiftMgrSelectEx($op, $param)
	{

	}

	function getCusGiftMgrInsertEx($param)
	{
	}

	function getCusGiftMgrUpdateEx($param)
	{

	}

	// 고객 사은품 수량 변경
	function getCusGiftMgrQTYSumUpdateEx($param)
	{
		## 기본 설정
		$intCG_NO = $param['CG_NO'];
		$intCG_QTY = $param['CG_QTY'];

		## 체크
		if(!$intCG_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['CG_QTY']				= "IFNULL(CG_QTY, 0) + {$intCG_QTY}";

		## where
		$where = "CG_NO = {$intCG_NO}";

		return $this->db->getUpdateParam("CUS_GIFT_MGR", $paramData, $where);		
	}


	function getCusGiftMgrDeleteEx($param)
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