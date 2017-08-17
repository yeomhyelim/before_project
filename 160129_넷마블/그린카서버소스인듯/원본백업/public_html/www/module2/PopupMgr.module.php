<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-01-09												|# 
#|작성내용	: 팝업창 관리 모듈 클래스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class PopupMgrModule extends Module2
{
		function getPopupMgrSelectEx($op, $param)
		{
			$column['OP_LIST']		= "PO.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## query(1) 영역
			if($param){
				## limit1
				if($param['LIMIT']):
					$limit1			= "LIMIT {$param['LIMIT']}";
				endif;		
				
				## order_by1
				if($param['ORDER_BY']):
					$order_by1		= "ORDER BY {$param['ORDER_BY']}";
				else:
					## default
					$order_by1		= "ORDER BY PO.PO_NO ASC";
				endif;
	
				## where1
				$where1				= "WHERE PO.PO_NO IS NOT NULL";
	
				if($param['PO_NO']):
					$where1			= "{$where1} AND PO.PO_NO = '{$param['PO_NO']}'";
				endif;
	
				if($param['PO_USE']):
					$where1			= "{$where1} AND PO.PO_USE = '{$param['PO_USE']}'";
				endif;
	
				if($param['PO_LANG_LIKE']):
					$where1			= "{$where1} AND PO.PO_LANG LIKE ('%{$param['PO_LANG_LIKE']}%')";
				endif;
	
				if($param['START_END_BETTEN']):
					$where1			= "{$where1} AND (NOW() BETWEEN PO_START_DT AND PO_END_DT)";
				endif;
	
				/*
				2015.03.18 bdcho
				:팝업창 구분(웹/모바일)
				{{
				*/	
	
				switch($param['IS_MOBILE']){
					case "Y":
						$where1			= "{$where1} AND PO.PO_IS_WEB = 2";
						break;
					case "N":
						$where1			= "{$where1} AND PO.PO_IS_WEB = 1";
						break;
				}
				/*
				}}
				2015.03.18 bdcho
				:팝업창 구분(웹/모바일)
				*/
			}
			## from1
			$from1				= "FROM POPUP_MGR AS PO";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getPopupMgrInsertEx($param)
		{
			$paramData						= "";
//			$paramData['PO_NO']				= $this->db->getSQLInteger($param['PO_NO']);
			$paramData['PO_TITLE']			= $this->db->getSQLString($param['PO_TITLE']);
			$paramData['PO_STYLE']			= $this->db->getSQLString($param['PO_STYLE']);
			$paramData['PO_LINK']			= $this->db->getSQLString($param['PO_LINK']);
			$paramData['PO_LINK_TYPE']		= $this->db->getSQLString($param['PO_LINK_TYPE']);
			$paramData['PO_LEFT']			= $this->db->getSQLString($param['PO_LEFT']);
			$paramData['PO_TOP']			= $this->db->getSQLString($param['PO_TOP']);
			$paramData['PO_FILE']			= $this->db->getSQLString($param['PO_FILE']);
			$paramData['PO_LANG']			= $this->db->getSQLString($param['PO_LANG']);
			$paramData['PO_START_DT']		= $this->db->getSQLDatetime($param['PO_START_DT']);
			$paramData['PO_END_DT']			= $this->db->getSQLDatetime($param['PO_END_DT']);
			$paramData['PO_USE']			= $this->db->getSQLString($param['PO_USE']);
			$paramData['PO_REG_DT']			= $this->db->getSQLDatetime($param['PO_REG_DT']);
			$paramData['PO_REG_NO']			= $this->db->getSQLInteger($param['PO_REG_NO']);
			$paramData['PO_MOD_DT']			= $this->db->getSQLDatetime($param['PO_MOD_DT']);
			$paramData['PO_MOD_NO']			= $this->db->getSQLInteger($param['PO_MOD_NO']);

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
			$paramData['PO_IS_WEB']			= $this->db->getSQLInteger($param['PO_IS_WEB']);
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/	

			return $this->db->getInsertParam("POPUP_MGR", $paramData, $where);	
		}

		function getPopupMgrUpdateEx($param)
		{
			$paramData						= "";
//			$paramData['PO_NO']				= $this->db->getSQLInteger($param['PO_NO']);
			$paramData['PO_TITLE']			= $this->db->getSQLString($param['PO_TITLE']);
			$paramData['PO_STYLE']			= $this->db->getSQLString($param['PO_STYLE']);
			$paramData['PO_LINK']			= $this->db->getSQLString($param['PO_LINK']);
			$paramData['PO_LINK_TYPE']		= $this->db->getSQLString($param['PO_LINK_TYPE']);
			$paramData['PO_LEFT']			= $this->db->getSQLString($param['PO_LEFT']);
			$paramData['PO_TOP']			= $this->db->getSQLString($param['PO_TOP']);
			$paramData['PO_FILE']			= $this->db->getSQLString($param['PO_FILE']);
			$paramData['PO_LANG']			= $this->db->getSQLString($param['PO_LANG']);
			$paramData['PO_START_DT']		= $this->db->getSQLDatetime($param['PO_START_DT']);
			$paramData['PO_END_DT']			= $this->db->getSQLDatetime($param['PO_END_DT']);
			$paramData['PO_USE']			= $this->db->getSQLString($param['PO_USE']);
//			$paramData['PO_REG_DT']			= $this->db->getSQLDatetime($param['PO_REG_DT']);
//			$paramData['PO_REG_NO']			= $this->db->getSQLInteger($param['PO_REG_NO']);
			$paramData['PO_MOD_DT']			= $this->db->getSQLDatetime($param['PO_MOD_DT']);
			$paramData['PO_MOD_NO']			= $this->db->getSQLInteger($param['PO_MOD_NO']);

/*
2015.03.18 bdcho
:팝업 관리 항목 추가
{{
*/
			$paramData['PO_IS_WEB']			= $this->db->getSQLInteger($param['PO_IS_WEB']);
/*
}}
2015.03.18 bdcho
:팝업 관리 항목 추가
*/	

			if($param['PO_NO']):
				$intNo				= $this->db->getSQLInteger($param['PO_NO']);
				$where				= "PO_NO = {$intNo}";
			endif;

			if(!$where)					{ return; }

			return $this->db->getUpdateParam("POPUP_MGR", $paramData, $where);	
		}

		function getPopupMgrDeleteEx($param)
		{
			## 기본 설정
			$strWhere					= "";
			$intPoNo					= $this->db->getSQLInteger($param['PO_NO']);
			
			if($intPoNo):
				$strWhere				= "PO_NO = {$intPoNo}";
			endif;

			if(!$strWhere) { return; }

			return $this->db->getDelete("POPUP_MGR", $strWhere);

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