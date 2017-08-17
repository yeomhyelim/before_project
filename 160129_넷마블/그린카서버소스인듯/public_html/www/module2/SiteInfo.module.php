<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-03												|# 
#|작성내용	: 사이트 설정 정보 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class SiteInfoModule extends Module2
{
		function getSiteInfoSelectEx($op, $param)
		{
			$column['OP_LIST']		= "SI.*";
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
				$order_by1		= "ORDER BY SI.NO ASC";
			endif;

			## where1
			$where1				= "WHERE SI.NO IS NOT NULL";

			if($param['COL']):
				$where1			= "{$where1} AND SI.COL = '{$param['COL']}'";
			endif;

			if($param['VIEW']):
				$where1			= "{$where1} AND SI.VIEW = '{$param['VIEW']}'";
			endif;

			## from1
			$from1				= "FROM SITE_INFO AS SI";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getSiteInfoInsertEx($param)
		{
			if(!$param['COL']) { return; }

			$paramData					= "";
//			$paramData['NO']			= $this->db->getSQLInteger($param['NO']);
			$paramData['COL']			= $this->db->getSQLString($param['COL']);
			$paramData['VAL']			= $this->db->getSQLString($param['VAL']);
			$paramData['VIEW']			= $this->db->getSQLString($param['VIEW']);
			$paramData['MEMO']			= $this->db->getSQLString($param['MEMO']);
			$paramData['REG_DT']		= $this->db->getSQLDatetime($param['REG_DT']);
			$paramData['REG_NO']		= $this->db->getSQLInteger($param['REG_NO']);
			$paramData['MOD_DT']		= $this->db->getSQLDatetime($param['MOD_DT']);
			$paramData['MOD_NO']		= $this->db->getSQLInteger($param['MOD_NO']);

			return $this->db->getInsertParam("SITE_INFO", $paramData);
		}

		function getSiteInfoUpdateEx($param)
		{
			$paramData					= "";
//			$paramData['NO']			= $this->db->getSQLInteger($param['NO']);
//			$paramData['COL']			= $this->db->getSQLString($param['COL']);
			$paramData['VAL']			= $this->db->getSQLString($param['VAL']);
			$paramData['VIEW']			= $this->db->getSQLString($param['VIEW']);
			$paramData['MEMO']			= $this->db->getSQLString($param['MEMO']);
//			$paramData['REG_DT']		= $this->db->getSQLDatetime($param['REG_DT']);
//			$paramData['REG_NO']		= $this->db->getSQLInteger($param['REG_NO']);
			$paramData['MOD_DT']		= $this->db->getSQLDatetime($param['MOD_DT']);
			$paramData['MOD_NO']		= $this->db->getSQLInteger($param['MOD_NO']);

			if($param['NO']):
				$no					= $this->db->getSQLInteger($param['NO']);
				$where				= "NO = {$no}";
			endif;

			if($param['COL']):
				$col				= $this->db->getSQLString($param['COL']);
				$where				= "COL = {$col}";
			endif;

			if(!$where)					{ return; }

			return $this->db->getUpdateParam("SITE_INFO", $paramData, $where);	

		}

		function getSiteInfoDeleteEx($param)
		{
			## 기본 설정
			$strWhere					= "";
			$intNO						= $this->db->getSQLInteger($param['NO']);
			$strCOL						= $this->db->getSQLString($param['COL']);
			
			if($intNO):
				$strWhere				= "NO = {$intNO}";
			endif;

			if($strCOL):
				$strWhere				= "COL = {$strCOL}";
			endif;

			if(!$strWhere) { return; }

			return $this->db->getDelete("SITE_INFO", $strWhere);
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