<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 쿠폰발행 관리 모듈 클래스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class CouponIssueModule extends Module2
{
	function getCouponIssueSelectEx($op, $param)
	{

	}


	function getCouponIssueInsertEx($param)
	{
	}

	function getCouponIssueUpdateEx($param)
	{

	}
	
	function getCouponIssueUseUpdateEx($param)
	{
		## 기본 설정
		$intCI_NO = $param['CI_NO'];
		$intO_NO = $param['O_NO'];
		$strCI_USE = $param['CI_USE'];
		$strCI_USE_DT = $param['CI_USE_DT'];
		$strCI_MEMO = $param['CI_MEMO'];

		## 체크
		if(!$intCI_NO) { return; }

		## 수정 데이터
		$paramData						= "";
		$paramData['O_NO']				= $this->db->getSQLInteger($intO_NO);
		$paramData['CI_USE']			= $this->db->getSQLString($strCI_USE);
		$paramData['CI_USE_DT']			= $this->db->getSQLDatetime($strCI_USE_DT);
		$paramData['CI_MEMO']			= $this->db->getSQLString($strCI_MEMO);
		
		## where
		$where = "CI_NO = {$intCI_NO}";

		return $this->db->getUpdateParam("COUPON_ISSUE", $paramData, $where);	
	}

	function getCouponIssueDeleteEx($param)
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