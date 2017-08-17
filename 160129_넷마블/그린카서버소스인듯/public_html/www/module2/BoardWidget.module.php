<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-24												|# 
#|작성내용	: 커뮤니티 위젯 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardWidgetModule extends Module2
{
		function getBoardWidgetSelectEx($op, $param)
		{
			$column['OP_LIST']		= "BW.*";
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
				$order_by1		= "ORDER BY BW.BW_REG_DT ASC";
			endif;

			## where1
			$where1				= "WHERE BW.BW_CODE IS NOT NULL";

			if($param['BW_CODE']):
				$where1			= "{$where1} AND BW.BW_CODE = '{$param['BW_CODE']}'";
			endif;

			if($param['BW_USE']):
				$where1			= "{$where1} AND BW.BW_USE = '{$param['BW_USE']}'";
			endif;

			## from1
			$from1				= "FROM BOARD_WIDGET AS BW";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}


		function getBoardWidgetInsertEx($param)
		{
			$paramData					= "";
			$paramData['BW_CODE']		= $this->db->getSQLString($param['BW_CODE']);
			$paramData['BW_B_CODE']		= $this->db->getSQLString($param['BW_B_CODE']);
			$paramData['BW_NAME']		= $this->db->getSQLString($param['BW_NAME']);
			$paramData['BW_SKIN']		= $this->db->getSQLString($param['BW_SKIN']);
			$paramData['BW_CSS']		= $this->db->getSQLString($param['BW_CSS']);
			$paramData['BW_USE']		= $this->db->getSQLString($param['BW_USE']);
			$paramData['BW_REG_DT']		= $this->db->getSQLDatetime($param['BW_REG_DT']);
			$paramData['BW_REG_NO']		= $this->db->getSQLInteger($param['BW_REG_NO']);
			$paramData['BW_MOD_DT']		= $this->db->getSQLDatetime($param['BW_MOD_DT']);
			$paramData['BW_MOD_NO']		= $this->db->getSQLInteger($param['BW_MOD_NO']);

			return $this->db->getInsertParam("BOARD_WIDGET", $paramData);
		}

		function getBoardWidgetUpdateEx($param)
		{
			$paramData					= "";
//			$paramData['BW_CODE']		= $this->db->getSQLString($param['BW_CODE']);
//			$paramData['BW_B_CODE']		= $this->db->getSQLString($param['BW_B_CODE']);
			$paramData['BW_NAME']		= $this->db->getSQLString($param['BW_NAME']);
			$paramData['BW_SKIN']		= $this->db->getSQLString($param['BW_SKIN']);
			$paramData['BW_CSS']		= $this->db->getSQLString($param['BW_CSS']);
			$paramData['BW_USE']		= $this->db->getSQLString($param['BW_USE']);
//			$paramData['BW_REG_DT']		= $this->db->getSQLDatetime($param['BW_REG_DT']);
//			$paramData['BW_REG_NO']		= $this->db->getSQLInteger($param['BW_REG_NO']);
			$paramData['BW_MOD_DT']		= $this->db->getSQLDatetime($param['BW_MOD_DT']);
			$paramData['BW_MOD_NO']		= $this->db->getSQLInteger($param['BW_MOD_NO']);

			if($param['BW_CODE']):
				$bwCode				= $this->db->getSQLString($param['BW_CODE']);
				$where				= "BW_CODE = {$bwCode}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_WIDGET", $paramData, $where);	
		}

		function getBoardWidgetDeleteEx($param)
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