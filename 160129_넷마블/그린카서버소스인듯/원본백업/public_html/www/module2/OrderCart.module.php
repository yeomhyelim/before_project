<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-18												|# 
#|작성내용	: 주문상품 리스트 모듈 클래스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class OrderCartModule extends Module2
{
	function getOrderCartSelectEx($op, $param)
	{

			## column 설정
			$aryColumn[] = "OC.*";

			## 기본 설정
			$aryWhere1 = ""; 
			$strLang = $param['LANG'];
			
			## 체크
			if(!$strLang) { return; }

			## where 설정
			if($param['O_NO']) { $aryWhere1[] = "OC.O_NO = {$param['O_NO']}"; }
			if($param['P_SHOP_NO']) { $aryWhere1[] = "P.P_SHOP_NO = {$param['P_SHOP_NO']}"; }

			## join 설정
			if($param['JOIN_P'] == "Y"):
				$aryColumn[] = "P.P_STOCK_LIMIT";
				$aryColumn[] = "P.P_STOCK_OUT";
				$aryColumn[] = "P.P_EVENT_UNIT";
				$aryColumn[] = "P.P_EVENT";
				$aryColumn[] = "P.P_POINT_NO_USE";
				$aryColumn[] = "IFNULL(P.P_SHOP_NO,0) AS P_SHOP_NO";
				$aryColumn[] = "P.P_BAESONG_TYPE";
				$aryColumn[] = "P.P_BAESONG_PRICE";
				$aryColumn[] = "P.P_QTY";

				$aryJoin['JOIN_P']  = " JOIN PRODUCT_MGR AS P ON OC.P_CODE = P.P_CODE ";
			endif;

			if($param['JOIN_PI'] == "Y"):
				$aryColumn[] = "PI.P_NAME";

				$aryJoin['JOIN_PI']  = " JOIN PRODUCT_INFO_{$strLang} AS PI ON P.P_CODE = PI.P_CODE ";
			endif;

			if($param['JOIN_PM'] == "Y"):
				
				## 이미지 타입 설정
				$strPM_TYPE = $param['PM_TYPE'];
				if(!$strPM_TYPE) $strPM_TYPE = 'list'; 

				$aryColumn[] = "PI.P_NAME";
				
				$aryJoin['JOIN_PM']  = " LEFT OUTER JOIN PRODUCT_IMG AS PM ON OC.P_CODE = PM.P_CODE AND PM.PM_TYPE = '{$strPM_TYPE}' ";
			endif;

			## order by 설정
			$aryOrderBy['no_asc']			= "OC.OC_NO ASC";
			$aryOrderBy['no_desc']			= "OC.OC_NO DESC";
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
			$SQL .= "FROM ORDER_CART AS OC                                              ";
			$SQL .= " {$aryJoin['JOIN_P']}								    			";
			$SQL .= " {$aryJoin['JOIN_PI']}								    			";
			$SQL .= " {$aryJoin['JOIN_PM']}								    			";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	

		
	}

	function getOrderCartInsertEx($param)
	{
	}

	function getOrderCartUpdateEx($param)
	{

	}
	
	// 배송상태 변경
	function getOrderCartDeliveryStatusUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strOC_DELIVERY_STATUS = $param['OC_DELIVERY_STATUS'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['OC_DELIVERY_STATUS']	= $this->db->getSQLString($strOC_DELIVERY_STATUS);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_CART", $paramData, $where);	
	}

	function getOrderCartDeleteEx($param)
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