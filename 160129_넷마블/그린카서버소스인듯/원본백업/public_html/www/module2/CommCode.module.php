<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-12-24												|# 
#|작성내용	: 공통코드관리												|# 
#/*====================================================================*/# 

require_once "Module.php";

class CommCodeModule extends Module2
{
		function getCommCodeSelectEx($op, $param)
		{
			$column['OP_LIST']		= "CC.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## query(1) 영역
			
			## limit1
			if($param['LIMIT']):
				$limit1			= "LIMIT {$param['LIMIT']}";
			endif;		
			
			## order_by1
			if($param['ORDER_BY']):
				$order_by1		= "ORDER BY {$param['ORDER_BY']}";
			else:
				## default
				$order_by1		= "ORDER BY CC.CC_SORT ASC";
			endif;

			## where1
			$where1				= "WHERE CC.CC_NO IS NOT NULL";

			if($param['CC_NO']):
				$where1			= "{$where1} AND CC.CC_NO = {$param['CC_NO']}";
			endif;

			if($param['CG_NO']):
				$where1			= "{$where1} AND CC.CG_NO = {$param['CG_NO']}";
			endif;

			if($param['CC_CODE']):
				$where1			= "{$where1} AND CC.CC_CODE = '{$param['CC_CODE']}'";
			endif;

			if($param['CC_USE']):
				$where1			= "{$where1} AND CC.CC_USE = '{$param['CC_USE']}'";
			endif;

			## from1
			$from1				= "FROM COMM_CODE AS CC";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getCommCodeInsertEx($param)
		{

		}

		function getCommCodeUpdateEx($param)
		{

		}

		function getCommCodeDeleteEx($param)
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