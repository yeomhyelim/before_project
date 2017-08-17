<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 주문 고객 사은품 모듈 클래스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class OrderGiftModule extends Module2
{
	function getOrderGiftSelectEx($op, $param)
	{
		## column 설정
		$aryColumn[] = "OG.*";

		## 기본 설정
		$aryWhere1 = ""; 
		$strLang = $param['LANG'];
		
		## 체크
		if(!$strLang) { return; }

		## where 설정
		if($param['O_NO']) { $aryWhere1[] = "OG.O_NO = {$param['O_NO']}"; }

		## join 설정
		if($param['JOIN_CG'] == "Y"):
			$aryColumn[] = "CG.CG_STOCK";
			$aryColumn[] = "CG.CG_QTY";
			$aryColumn[] = "CG.CG_FILE";

			$aryJoin['JOIN_CG']  = "JOIN CUS_GIFT_MGR AS CG ON OG.CG_NO = CG.CG_NO";
		endif;

		if($param['JOIN_CGL'] == "Y"):
			$aryColumn[] = "CGL.CG_NAME";

			$aryJoin['JOIN_CGL']  = "JOIN CUS_GIFT_LNG AS CGL ON CG.CG_NO = CGL.CG_NO AND CGL.CG_LNG = '{$strLang}'";
		endif;


		## order by 설정
		$aryOrderBy['no_asc']			= "OG.OG_NO ASC";
		$aryOrderBy['no_desc']			= "OG.OG_NO DESC";
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

		$SQL  = "SELECT {$strColumn}												";
		$SQL .= "FROM ORDER_GIFT AS OG                                              ";
		$SQL .= " {$aryJoin['JOIN_CG']}								    			";
		$SQL .= " {$aryJoin['JOIN_CGL']}								    		";
		$SQL .= " {$strWhere1}										                ";
		$SQL .= " {$strOrderBy}									                    ";
		$SQL .= " {$strLimit}										                ";

		## 결과
		return $this->getSelectQuery($SQL, $op);	
		

	}

	function getOrderGiftInsertEx($param)
	{
	}

	function getOrderGiftUpdateEx($param)
	{

	}

	function getOrderGiftDeleteEx($param)
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