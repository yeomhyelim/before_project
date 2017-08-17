<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-04-07												|# 
#|작성내용	: 상품찾기 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductSearchModule extends Module2
{
		function getProductSearchSelectEx($op, $param) 
		{
			$column['OP_LIST']		= "PS.*";
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
	//			$order_by1		= "ORDER BY PS.PS_NO ASC";
			endif;

			## where1
			$where1				= "WHERE PS.PS_P_CODE IS NOT NULL";

			if($param['PS_P_CODE']):
				$where1			= "{$where1} AND PS.PS_P_CODE = {$param['PS_P_CODE']}";
			endif;

			## from1
			$from1				= "FROM PRODUCT_SEARCH AS PS";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}


		function getProductSearchInsertEx($param)
		{
			$paramData							= "";
			$paramData['PS_P_CODE']				= $this->db->getSQLString($param['PS_P_CODE']);
			$paramData['PS_PROD_SEARCH_1']		= $this->db->getSQLString($param['PS_PROD_SEARCH_1']);
			$paramData['PS_PROD_SEARCH_2']		= $this->db->getSQLString($param['PS_PROD_SEARCH_2']);
			$paramData['PS_PROD_SEARCH_3']		= $this->db->getSQLString($param['PS_PROD_SEARCH_3']);
			$paramData['PS_PROD_SEARCH_4']		= $this->db->getSQLString($param['PS_PROD_SEARCH_4']);
			$paramData['PS_PROD_SEARCH_5']		= $this->db->getSQLString($param['PS_PROD_SEARCH_5']);
			$paramData['PS_PROD_SEARCH_6']		= $this->db->getSQLString($param['PS_PROD_SEARCH_6']);
			$paramData['PS_PROD_SEARCH_7']		= $this->db->getSQLString($param['PS_PROD_SEARCH_7']);
			$paramData['PS_PROD_SEARCH_8']		= $this->db->getSQLString($param['PS_PROD_SEARCH_8']);
			$paramData['PS_PROD_SEARCH_9']		= $this->db->getSQLString($param['PS_PROD_SEARCH_9']);
			$paramData['PS_PROD_SEARCH_10']		= $this->db->getSQLString($param['PS_PROD_SEARCH_10']);

			return $this->db->getInsertParam("PRODUCT_SEARCH", $paramData);

		}


		function getProductSearchUpdateEx($param)
		{
			$paramData					= "";
//			$paramData['PS_P_CODE']				= $this->db->getSQLString($param['PS_P_CODE']);
			$paramData['PS_PROD_SEARCH_1']		= $this->db->getSQLString($param['PS_PROD_SEARCH_1']);
			$paramData['PS_PROD_SEARCH_2']		= $this->db->getSQLString($param['PS_PROD_SEARCH_2']);
			$paramData['PS_PROD_SEARCH_3']		= $this->db->getSQLString($param['PS_PROD_SEARCH_3']);
			$paramData['PS_PROD_SEARCH_4']		= $this->db->getSQLString($param['PS_PROD_SEARCH_4']);
			$paramData['PS_PROD_SEARCH_5']		= $this->db->getSQLString($param['PS_PROD_SEARCH_5']);
			$paramData['PS_PROD_SEARCH_6']		= $this->db->getSQLString($param['PS_PROD_SEARCH_6']);
			$paramData['PS_PROD_SEARCH_7']		= $this->db->getSQLString($param['PS_PROD_SEARCH_7']);
			$paramData['PS_PROD_SEARCH_8']		= $this->db->getSQLString($param['PS_PROD_SEARCH_8']);
			$paramData['PS_PROD_SEARCH_9']		= $this->db->getSQLString($param['PS_PROD_SEARCH_9']);
			$paramData['PS_PROD_SEARCH_10']		= $this->db->getSQLString($param['PS_PROD_SEARCH_10']);

			if($param['PS_P_CODE']):
				$strPCode			= $this->db->getSQLString($param['PS_P_CODE']);
				$where				= "PS_P_CODE = {$strPCode}";
			endif;

			if(!$where)					{ return; }

			return $this->db->getUpdateParam("PRODUCT_SEARCH", $paramData, $where);	
		}

		function getProductSearchDeleteEx($param)
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