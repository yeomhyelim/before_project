<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-01-29												|# 
#|작성내용	: 상품 이미지 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductImgModule extends Module2
{
		function getProductImgSelectEx($op, $param) 
		{
			$column['OP_LIST']		= "PM.*";
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
	//			$order_by1		= "ORDER BY PM.PM_NO ASC";
	      $order_by1		= "ORDER BY PM_TYPE";
			endif;

			## where1
			$where1				= "WHERE PM.PM_NO IS NOT NULL";

			if($param['PM_NO']):
				$where1			= "{$where1} AND PM.PM_NO = {$param['PM_NO']}";
			endif;

			if($param['P_CODE']):
				$where1			= "{$where1} AND PM.P_CODE = '{$param['P_CODE']}'";
			endif;

			if($param['PM_TYPE']):
				$where1			= "{$where1} AND PM.PM_TYPE = '{$param['PM_TYPE']}'";
			endif;

			## from1
			$from1				= "FROM PRODUCT_IMG AS PM";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}


		function getProductImgInsertEx($param)
		{

		}

		function getProductImgUpdateEx($param)
		{

		}

		// 우선순위 변경
		function getProductImgOrderUpdateEx($param)
		{

		}

		function getProductImgDeleteEx($param)
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