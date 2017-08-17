<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-08-21												|# 
#|작성내용	: SITE_TEXT 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class SiteTextModule extends Module2
{
		function getSiteTextSelectEx($op, $param)
		{
			## 체크
//			if(!$param['B_CODE']) { break; }

			## column 설정
			$aryColumn[] = "ST.*";

			## 검색(텍스트)
			## 기본 설정
			$aryWhere1 = ""; 

			## where 설정
			if($param['NO']) { $aryWhere1[] = "ST.NO = {$param['NO']}"; }
			if($param['COL']) { $aryWhere1[] = "ST.COL = '{$param['COL']}'"; }

			## order by 설정
			$aryOrderBy['noAsc']			= "ST.NO ASC";
			$aryOrderBy['noDesc']			= "ST.NO DESC";
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
			if($strOrderBy) { $strOrderBy = "ORDER BY {$strOrderBy}"; }
			if($strLimit) { $strLimit = "LIMIT {$strLimit}"; }

			$SQL  = " SELECT {$strColumn}                                               ";
			$SQL .= "  FROM                                                             ";
			$SQL .= "       SITE_TEXT AS ST					                            ";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}

		function getSiteTextInsertEx($param)
		{
			if(!$param['COL']) { return; }

			$paramData					= "";
//			$paramData['NO']			= $this->db->getSQLInteger($param['NO']);
			$paramData['COL']			= $this->db->getSQLString($param['COL']);
			$paramData['VAL']			= $this->db->getSQLString($param['VAL']);
			$paramData['REG_DT']		= $this->db->getSQLDatetime($param['REG_DT']);
			$paramData['REG_NO']		= $this->db->getSQLInteger($param['REG_NO']);
			$paramData['MOD_DT']		= $this->db->getSQLDatetime($param['MOD_DT']);
			$paramData['MOD_NO']		= $this->db->getSQLInteger($param['MOD_NO']);

			return $this->db->getInsertParam("SITE_TEXT", $paramData);
		}

		function getSiteTextUpdateEx($param)
		{


		}

		function getSiteTextColDeleteEx($param)
		{
			## 기본 설정
			$strCOL = $param['COL'];

			## 공백제거
			$strCOL = trim($strCOL);

			## 체크
			if(!$strCOL) { return; }

			$where = "COL = '{$strCOL}'";

			return $this->db->getDelete("SITE_TEXT", $where);
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