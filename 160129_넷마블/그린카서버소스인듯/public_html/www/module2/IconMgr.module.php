<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-08-26												|# 
#|작성내용	: 아이콘 관리 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class IconMgrModule extends Module2
{
	
		function getIconMgrSelectEx($op, $param)
		{
			## 체크

			## column 설정
			$aryColumn[] = "IC.*";

			## 검색(텍스트)
			## 기본 설정
			$aryWhere1 = ""; 

			## 공백 제거

			## search query 설정

			## 검색(가입일)

			## where 설정
			if($param['IC_NO']) { $aryWhere1[] = "IC.IC_NO = {$param['IC_NO']}"; }
			if($param['IC_TYPE']) { $aryWhere1[] = "IC.IC_TYPE = '{$param['IC_TYPE']}'"; }
			if($param['IC_CODE']) { $aryWhere1[] = "IC.IC_CODE = '{$param['IC_CODE']}'"; }
			if($param['IC_USE']) { $aryWhere1[] = "IC.IC_USE = '{$param['IC_USE']}'"; }

			## join 설정

			## order by 설정
			$aryOrderBy['icNoAsc']			= "IC.IC_NO ASC";
			$aryOrderBy['icNoDesc']			= "IC.IC_NO DESC";
			$aryOrderBy['icCodeAsc']		= "IC.IC_CODE ASC";
			$aryOrderBy['icCodeDesc']		= "IC.IC_CODE DESC";
			$strOrderBy						= $aryOrderBy[$param['ORDER_BY']];

			## limit 설정
			if($param['LIMIT']):
				list($param['LIMIT_START'], $param['LIMIT_END']) = explode(",", $param['LIMIT']);
			endif;
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$strLimit					= "{$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;
			
			## 쿼리 만들기
			if($aryColumn) { $strColumn = implode(",", $aryColumn); } 
			if($op == "OP_COUNT") { $strColumn = "COUNT(*)"; }
			if(!$strColumn) { $strColumn = "*"; }
			if($aryWhere1) { $strWhere1 = "WHERE " .  implode(" AND ", $aryWhere1); } 
//			if($aryWhere2) { $strWhere2 = "WHERE " .  implode(" AND ", $aryWhere2); } 
//			if($aryWhere3) { $strWhere3 = "WHERE " .  implode(" AND ", $aryWhere3); } 
			if($strOrderBy) { $strOrderBy = "ORDER BY {$strOrderBy}"; }
			if($strLimit) { $strLimit = "LIMIT {$strLimit}"; }

			$SQL  = " SELECT {$strColumn}                                               ";
			$SQL .= " FROM                                                              ";
			$SQL .= "       ICON_MGR AS IC					                            ";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}	


		function getIconMgrInsertEx($param)
		{
			## 체크
			if(!$param['IC_TYPE']) { return; }
			if(!$param['IC_CODE']) { return; }

			$paramData						= "";
//			$paramData['IC_NO']				= $this->db->getSQLInteger($param['IC_NO']);
			$paramData['IC_TYPE']			= $this->db->getSQLString($param['IC_TYPE']);
			$paramData['IC_CODE']			= $this->db->getSQLString($param['IC_CODE']);
			$paramData['IC_NAME']			= $this->db->getSQLString($param['IC_NAME']);
			$paramData['IC_IMG']			= $this->db->getSQLString($param['IC_IMG']);
			$paramData['IC_USE']			= $this->db->getSQLString($param['IC_USE']);
			$paramData['IC_REG_DT']			= $this->db->getSQLDatetime($param['IC_REG_DT']);
			$paramData['IC_REG_NO']			= $this->db->getSQLInteger($param['IC_REG_NO']);
			$paramData['IC_MOD_DT']			= $this->db->getSQLDatetime($param['IC_MOD_DT']);
			$paramData['IC_MOD_NO']			= $this->db->getSQLInteger($param['IC_MOD_NO']);

			return $this->db->getInsertParam("ICON_MGR", $paramData);
		}

		function getIconMgrUpdateEx($param)
		{	
			## 기본설정
			$intIC_NO = $param['IC_NO'];

			## 유효성 체크
			if(!$intIC_NO) { return; }
			
			## 데이터 만들기
			$paramData						= "";
//			$paramData['IC_NO']				= $this->db->getSQLInteger($param['IC_NO']);
//			$paramData['IC_TYPE']			= $this->db->getSQLString($param['IC_TYPE']);
//			$paramData['IC_CODE']			= $this->db->getSQLString($param['IC_CODE']);
			$paramData['IC_NAME']			= $this->db->getSQLString($param['IC_NAME']);
			$paramData['IC_IMG']			= $this->db->getSQLString($param['IC_IMG']);
			$paramData['IC_USE']			= $this->db->getSQLString($param['IC_USE']);
//			$paramData['IC_REG_DT']			= $this->db->getSQLDatetime($param['IC_REG_DT']);
//			$paramData['IC_REG_NO']			= $this->db->getSQLInteger($param['IC_REG_NO']);
			$paramData['IC_MOD_DT']			= $this->db->getSQLDatetime($param['IC_MOD_DT']);
			$paramData['IC_MOD_NO']			= $this->db->getSQLInteger($param['IC_MOD_NO']);

			## where 만들기
			$where = "IC_NO = {$intIC_NO}";

			return $this->db->getUpdateParam("ICON_MGR", $paramData, $where);	
		}


		function getIconMgrDeleteEx($param)
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