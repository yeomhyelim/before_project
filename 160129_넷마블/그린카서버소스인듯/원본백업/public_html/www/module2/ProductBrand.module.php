<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-04-22												|# 
#|작성내용	: 상품브랜드관리											|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductBrandModule extends Module2
{
		function getProductBrandSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "PR.PR_NO";
			$aryColumn[] = "PR.PR_NAME";
			$aryColumn[] = "PR.PR_LIST_IMG";
			$aryColumn[] = "PR.PR_HTML";

			## 검색(텍스트)
			if($param['searchKey']):
				$arySearchText['name']				= "PR.PR_NAME LIKE ('%{$param['searchKey']}%')";
				$temp								= $arySearchText[$param['searchField']];
				if(!$temp):
					foreach($arySearchText as $key => $data):
						if($temp) { $temp = "{$temp} OR"; }
						$temp = "{$temp} {$data}";
					endforeach;
					$temp		= "( {$temp} )";
				endif;
				$aryWhere2[] = $temp;
			endif;

			## where 설정
			if($param['PR_NO']) { $aryWhere1[] = "PR.PR_NO = '{$param['PR_NO']}'"; }

			## order by 설정
			$aryOrderBy['regAsc']			= "PR.PR_REG_DT ASC";
			$aryOrderBy['regDesc']			= "PR.PR_REG_DT DESC";
			$aryOrderBy['sortAsc']			= "PR.PR_ALIGN ASC";
			$aryOrderBy['sortDesc']			= "PR.PR_ALIGN DESC";
			$aryOrderBy['nameAsc']			= "PR.PR_NAME ASC";
			$aryOrderBy['nameDesc']			= "PR.PR_NAME DESC";
			$strOrderBy						= $aryOrderBy[$param['ORDER_BY']];

			## limit 설정
			if($param['LIMIT']):
				list($param['LIMIT_START'], $param['LIMIT_END']) = explode(",", $param['LIMIT']);
			endif;
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$strLimit						= "{$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;

			## join 설정
			if($param['JOIN_PBL'] == "Y"):
				$aryColumn[] = "PBL.PL_PR_HTML";

				$aryJoin['JOIN_PBL']  = "    JOIN														          ";
				$aryJoin['JOIN_PBL'] .= "        PRODUCT_BRAND_LNG AS PBL										  ";
				$aryJoin['JOIN_PBL'] .= "        ON																  ";
				$aryJoin['JOIN_PBL'] .= "        PBL.PL_PR_NO = PR.PR_NO										  ";
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



			## sql 설정
			$SQL  =    "SELECT {$strColumn}      ";
//			$SQL .= "       PR.PR_NO,            ";
//			$SQL .= "       PR.PR_NAME,          ";
//			$SQL .= "       PR.PR_LIST_IMG       ";
			$SQL .= "  FROM                      ";
			$SQL .= "       PRODUCT_BRAND AS PR  ";
			$SQL .= " {$aryJoin['JOIN_PBL']}	 ";
			$SQL .= " {$strOrderBy}				 ";
			$SQL .= " {$strWhere1}				 ";
//			$SQL .= "ORDER BY                    ";
//			$SQL .= "       PR.PR_ALIGN DESC     ";
			$SQL .= " {$strLimit}				 ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getProductBrandInsertEx($param)
		{

		}

		function getProductBrandUpdateEx($param)
		{

		}

		function getProductBrandDeleteEx($param)
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