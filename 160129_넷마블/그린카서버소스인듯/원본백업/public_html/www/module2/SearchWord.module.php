<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-02												|# 
#|작성내용	: 검색어 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class SearchWordModule extends Module2
{

		function getSearchWordSelectEx($op, $param)
		{
			## order by 설정
			## $param['ORDER_BY'] = 'countDesc';
			$aryOrderBy['countAsc']			= "SW.SW_COUNT ASC";
			$aryOrderBy['countDesc']		= "SW.SW_COUNT DESC";
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
			if($strOrderBy) { $strOrderBy = "ORDER BY {$strOrderBy}"; }
			if($strLimit) { $strLimit = "LIMIT {$strLimit}"; }

			$SQL =    "SELECT * FROM SEARCH_WORD AS SW {$strOrderBy} {$strLimit}";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}	

		function getSearchWordInsertEx($param)
		{

		}


		function getSearchWordUpdateEx($param)
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