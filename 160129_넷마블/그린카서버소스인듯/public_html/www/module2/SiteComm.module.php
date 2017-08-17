<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-08												|# 
#|작성내용	: 공통 관리 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class SiteCommModule extends Module2
{
		function getSiteCommSelectEx($op, $param)
		{
			if(!$param){ $param = array();}

			$column['OP_LIST']		= "SC.*";
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
				$order_by1		= "ORDER BY SC.SC_REG_DT ASC";
			endif;

			## where1
			$where1				= "WHERE SC.SC_NO IS NOT NULL";

			if($param['SC_NO']):
				$where1			= "{$where1} AND SC.SC_NO = {$param['SC_NO']}";
			endif;

			## from1
			$from1				= "FROM SITE_COMM AS SC";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getSiteCommInsertEx($param)
		{

		}

		function getSiteCommUpdateEx($param)
		{

		}

		function getSiteCommDeleteEx($param)
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