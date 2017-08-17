<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-12-24												|# 
#|작성내용	: 공통코드 그룹관리											|# 
#/*====================================================================*/# 

require_once "Module.php";

class CommGrpModule extends Module2
{
		function getCommGrpSelectEx($op, $param)
		{
			$column['OP_LIST']		= "CG.*";
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
				$order_by1		= "ORDER BY CG.CG_NO DESC";
			endif;

			## where1
			$where1				= "WHERE CG.CG_NO IS NOT NULL";

			if($param['CG_NO']):
				$where1			= "{$where1} AND CG.CG_NO = {$param['CG_NO']}";
			endif;

			if($param['CG_NAME']):
				$where1			= "{$where1} AND CG.CG_NAME = '{$param['CG_NAME']}'";
			endif;

			if($param['CG_CODE']):
				$where1			= "{$where1} AND CG.CG_CODE = '{$param['CG_CODE']}'";
			endif;

			if($param['CG_CODE_LIKE']):
				$where1			= "{$where1} AND CG.CG_CODE LIKE ('{$param['CG_CODE_LIKE']}')";
			endif;

			if($param['CG_TYPE']):
				$where1			= "{$where1} AND CG.CG_TYPE = '{$param['CG_TYPE']}'";
			endif;

			if($param['CG_USE']):
				$where1			= "{$where1} AND CG.CG_USE = '{$param['CG_USE']}'";
			endif;

			## from1
			$from1				= "FROM COMM_GRP AS CG";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getCommGrpInsertEx($param)
		{

		}

		function getCommGrpUpdateEx($param)
		{

		}

		function getCommGrpDeleteEx($param)
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