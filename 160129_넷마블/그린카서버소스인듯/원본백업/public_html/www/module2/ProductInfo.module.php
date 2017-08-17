<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-09-05												|# 
#|작성내용	: 상품 정보(다국어) 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class ProductInfoModule extends Module2
{
		function getProductInfoSelectEx($op, $param) 
		{
			## 기본 설정
			$strLang = $param['LNG'];
			$aryWhere1 = ""; 

			## 체크
			if(!$strLang) { return; }

			## column 설정
			$aryColumn[] = "PI.*";

			## where 설정
			if($param['P_CODE']) { $aryWhere1[] = "PI.P_CODE = {$param['P_CODE']}"; }

			## join 설정

			## order by 설정
			$aryOrderBy['codeAsc']			= "PI.P_CODE ASC";
			$aryOrderBy['codeDesc']			= "PI.P_CODE DESC";
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
			$SQL .= "       PRODUCT_INFO_{$strLang} AS PI		                        ";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}


		function getProductInfoInsertEx($param)
		{

		}

		function getProductInfoUpdateEx($param)
		{

		}

		// 상품출력 변경
		function getProductInfoViewUpdateEx($param)
		{
			## 기본 설정
			$strLang = $param['LNG'];
			$strPCode = $param['P_CODE'];

			## 체크
			if(!$strLang) { return; }
			if(!$strPCode) { return; }

			## 수정 데이터
			$paramData							= "";
			$paramData['P_WEB_VIEW']			= $this->db->getSQLString($param['P_WEB_VIEW']);
			$paramData['P_MOB_VIEW']			= $this->db->getSQLString($param['P_MOB_VIEW']);

			## where
			$where = "P_CODE = '{$strPCode}'";

			return $this->db->getUpdateParam("PRODUCT_INFO_{$strLang}", $paramData, $where);
		}

		function getProductInfoDeleteEx($param)
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