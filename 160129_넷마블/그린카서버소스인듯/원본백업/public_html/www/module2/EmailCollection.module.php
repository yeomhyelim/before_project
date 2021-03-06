<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-01-03												|# 
#|작성내용	: 이메일 수집 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class EmailCollectionModule extends Module2
{
		function getEmailCollectionSelectEx($op, $param)
		{
			$column['OP_LIST']		= "EC.*";
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
				$order_by1		= "ORDER BY EC.EC_REG_DT DESC";
			endif;

			## where1
			$where1				= "WHERE EC.EC_NO IS NOT NULL";

			if($param['EC_NO']):
				$where1			= "{$where1} AND EC.EC_NO = '{$param['EC_NO']}'";
			endif;

			if($param['EC_EMAIL']):
				$where1			= "{$where1} AND EC.EC_EMAIL = '{$param['EC_EMAIL']}'";
			endif;

			## from1
			$from1				= "FROM EMAIL_COLLECTTION AS EC";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}


		function getEmailCollectionInsertEx($param)
		{
			$paramData					= "";
			$paramData['EC_EMAIL']		= $this->db->getSQLString($param['EC_EMAIL']);
			$paramData['EC_REG_DT']		= $this->db->getSQLDatetime($param['EC_REG_DT']);

			return $this->db->getInsertParam("EMAIL_COLLECTTION", $paramData);
		}

		function getEmailCollectionUpdateEx($param)
		{

		}

		function getEmailCollectionDeleteEx($param)
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