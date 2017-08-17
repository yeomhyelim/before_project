<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-01-07												|# 
#|작성내용	: 커뮤니티 아이콘 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardIconModule extends Module2
{
		function getBoardIconSelectEx($op, $param)
		{
			$column['OP_LIST']		= "BI.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## 체크

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
				$order_by1		= "ORDER BY BI.BI_SORT ASC";
			endif;

			## where1
			$where1				= "WHERE BI.BI_NO IS NOT NULL";

			if($param['BI_NO']):
				$where1			= "{$where1} AND BI.BI_NO = {$param['BI_NO']}";
			endif;

			if($param['BI_ICON']):
				$where1			= "{$where1} AND BI.BI_ICON = '{$param['BI_ICON']}'";
			endif;

			if($param['BI_B_CODE']):
				$where1			= "{$where1} AND BI.BI_B_CODE = '{$param['BI_B_CODE']}'";
			endif;

			if($param['BI_UB_NO']):
				$where1			= "{$where1} AND BI.BI_UB_NO = {$param['BI_UB_NO']}";
			endif;
			
			if($param['BOARD_MGR_JOIN']):
				$column['OP_LIST']		.= ", B.*";
				$join1_1				 = "LEFT OUTER JOIN BOARD_MGR_NEW AS B ON B.B_CODE = BI.BI_B_CODE";
			endif;
			
			## from1
			$from1				= "FROM BOARD_ICON AS BI";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$join10_1} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getBoardIconInsertEx($param)
		{
			## 체크
			if(!$param['BI_ICON'])		{ return; }
			if(!$param['BI_B_CODE'])	{ return; }
			if(!$param['BI_UB_NO'])		{ return; }

			$paramData						= "";
//			$paramData['BI_NO']				= $this->db->getSQLInteger($param['BI_NO']);
			$paramData['BI_ICON']			= $this->db->getSQLString($param['BI_ICON']);
			$paramData['BI_B_CODE']			= $this->db->getSQLString($param['BI_B_CODE']);
			$paramData['BI_UB_NO']			= $this->db->getSQLInteger($param['BI_UB_NO']);
			$paramData['BI_SORT']			= $this->db->getSQLInteger($param['BI_SORT']);

			return $this->db->getInsertParam("BOARD_ICON", $paramData);
		}

		function getBoardIconUpdateEx($param)
		{
			## 체크
			if(!$param['BI_ICON'])		{ return; }
			if(!$param['BI_B_CODE'])	{ return; }
			if(!$param['BI_UB_NO'])		{ return; }

			$paramData						= "";
//			$paramData['BI_NO']				= $this->db->getSQLInteger($param['BI_NO']);
			$paramData['BI_ICON']			= $this->db->getSQLString($param['BI_ICON']);
			$paramData['BI_B_CODE']			= $this->db->getSQLString($param['BI_B_CODE']);
			$paramData['BI_UB_NO']			= $this->db->getSQLInteger($param['BI_UB_NO']);
			$paramData['BI_SORT']			= $this->db->getSQLInteger($param['BI_SORT']);

			if($param['BI_NO']):
				$biNo						= $this->db->getSQLInteger($param['BI_NO']);
				$where						= "BI_NO = {$biNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_ICON", $paramData, $where);	
		}

		function getBoardIconDeleteEx($param)
		{
			$where					= "";
			
			if($param['BI_NO']):
				$no				= $this->db->getSQLInteger($param['BI_NO']);
				$where				= "BI_NO = {$no}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("BOARD_ICON", $where);
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