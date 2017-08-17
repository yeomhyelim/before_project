<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 포인트 관리 모듈 클래스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class PointMgrModule extends Module2
{
	function getPointMgrSelectEx($op, $param)
	{

	}


	function getPointMgrInsertEx($param)
	{
	}

	
	## 포인트 프로시저
	function getPointMgrProInsert($param)
	{
		$query = "CALL SP_POINT_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

		$paramData[]  = $param['M_NO'];
		$paramData[]  = $param['B_NO'];			// 게시판 번호
		$paramData[]  = $param['O_NO'];
		$paramData[]  = $param['PT_TYPE'];
		$paramData[]  = $param['PT_POINT'];
		$paramData[]  = $param['PT_MEMO'];
		$paramData[]  = $param['PT_START_DT'];
		$paramData[]  = $param['PT_END_DT'];
		$paramData[]  = $param['PT_REG_IP'];
		$paramData[]  = $param['PT_ETC'];
		$paramData[]  = $param['PT_REG_NO'];

		return $this->db->executeBindingQuery($query, $paramData, true);
	}

	function getPointMgrUpdateEx($param)
	{

	}

	function getPointMgrDeleteEx($param)
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