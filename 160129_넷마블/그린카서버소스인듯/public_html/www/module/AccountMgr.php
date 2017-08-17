<?
#/*====================================================================*/# 
#|화일명	: 정산관리 													|# 
#|작성자	: 박영미													|# 
#|작성일	: 2013-02-19												|# 
#|작성내용	: 															|# 
#/*====================================================================*/# 

class AccountMgr
{
	private $query;
	private $param;

	function getAccTotal($db,$param)
	{
		$query  = "SELECT                                ";
		$query .= "   COUNT(*)                           ";
		$query .= "FROM ".TBL_SHOP_ORDER." A             ";
		$query .= "JOIN ".TBL_ORDER_MGR." B              ";
		$query .= "ON A.O_NO = B.O_NO                    ";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_MGR." C    ";
		$query .= "ON A.SH_NO = C.SH_NO                  ";
		$query .= "WHERE A.O_NO IS NOT NULL              ";
		$query .= "	AND A.SO_ORDER_STATUS = 'E'			 "; //구매완료
		
		if ($this->getSearchCompany() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSearchCompany()."	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "K":
					$query .= "	B.O_KEY LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchAccStatus()){
			$query .= "	AND IFNULL(A.SO_ACC_STATUS,'N') = '".$this->getSearchAccStatus()."'	";
		}

		if ($this->getSearchSettleType()){
			// 결제방법
			$query .= "	AND B.O_SETTLE IN ({$this->getSearchSettleType()})";
		}

		if ($param['ORDER_END_START_DT'] && $param['ORDER_END_END_DT']){
			$query .= "	AND A.SO_ORDER_END_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		if ($param['ORDER_ACC_START_DT'] && $param['ORDER_ACC_END_DT']){
			$query .= "	AND A.SO_ACC_DATE BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		return $db->getCount($query);
	}

	function getAccList($db,$param)
	{
		$query  = "SELECT                                ";
		$query .= "   A.*                                ";
		$query .= "  ,B.O_KEY                            ";
		$query .= "  ,B.O_REG_DT                         ";


		$query .= "  ,B.O_J_NAME                         ";
		$query .= "  ,B.O_J_PHONE                        ";
		$query .= "  ,B.O_J_HP							 ";
		$query .= "  ,B.O_J_MAIL                         ";
		$query .= "  ,B.O_B_NAME                         ";
		$query .= "  ,B.O_B_PHONE                        ";
		$query .= "  ,B.O_B_HP                           ";
		$query .= "  ,B.O_B_MAIL                         ";
		$query .= "  ,B.O_B_ZIP							 ";
		$query .= "  ,B.O_B_ADDR1                        ";
		$query .= "  ,B.O_B_ADDR2                        ";
		$query .= "  ,B.O_B_MEMO                         ";
		$query .= "  ,B.O_SETTLE						 ";
		$query .= "  ,C.SH_COM_NAME                      ";
		$query .= "FROM ".TBL_SHOP_ORDER." A             ";
		$query .= "JOIN ".TBL_ORDER_MGR." B              ";
		$query .= "ON A.O_NO = B.O_NO                    ";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_MGR." C    ";
		$query .= "ON A.SH_NO = C.SH_NO                  ";
		$query .= "WHERE A.O_NO IS NOT NULL              ";
		$query .= "	AND A.SO_ORDER_STATUS = 'E'			 "; //구매완료
	
		if ($this->getSearchCompany() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSearchCompany()."	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "K":
					$query .= "	B.O_KEY LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchAccStatus()){
			$query .= "	AND IFNULL(A.SO_ACC_STATUS,'N') = '".$this->getSearchAccStatus()."'	";
		}

		if ($this->getSearchSettleType()){
			// 결제방법
			$query .= "	AND B.O_SETTLE IN ({$this->getSearchSettleType()}) ";
		}

		if ($param['ORDER_END_START_DT'] && $param['ORDER_END_END_DT']){
			$query .= "	AND A.SO_ORDER_END_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		if ($param['ORDER_ACC_START_DT'] && $param['ORDER_ACC_END_DT']){
			$query .= "	AND A.SO_ACC_DATE BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		$query .= "ORDER BY A.SO_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();				
		
		return $db->getExecSql($query);
	}
	
	function getOrderCartList($db,$param = "")
	{
		$query  = "SELECT														";
		$query .= "      A.*													";
		$query .= "     ,AI.P_NAME												";
		$query .= "     ,B.P_TAX												";
		$query .= "FROM ".TBL_ORDER_CART." A									";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B									";
		$query .= "ON A.P_CODE = B.P_CODE										";
		
		if ($this->getP_LNG())
		{
			$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$this->getP_LNG()." AI	";
			$query .= "ON A.P_CODE = AI.P_CODE					";		
		}		
		$query .= "WHERE A.OC_NO IS NOT NULL									";
		if ($this->getO_NO())
		{
			$query .= "	AND A.O_NO = ".$this->getO_NO()."						";			
		}
		
		$query .= "	AND B.P_SHOP_NO = ".$this->getSH_NO()."						";		
		
		#구매상태
		if ($param['OC_ORDER_STATUS']){
			$query .= " AND A.OC_ORDER_STATUS = '".$param['OC_ORDER_STATUS']."'	";
		}
				
		$query .= "ORDER BY A.OC_NO DESC ";	
		
		return $db->getArrayTotal($query);
	}

	function getShopList($db)
	{
		$query  = "SELECT SH_NO,SH_COM_NAME FROM ".TBL_SHOP_MGR;
		$query .= "	WHERE SH_APPR = 'Y'			";
		$qeury .= "	ORDER BY SH_COM_NAME ASC	";
		return $db->getArray($query);
	}


	function getAccPeriodTotal($db,$param)
	{
		$query  = "SELECT COUNT(*) FROM (SELECT                                     ";
		$query .= "     A.SH_NO                                                     ";
		$query .= "FROM ".TBL_SHOP_ORDER." A                                        ";
		$query .= "JOIN ".TBL_ORDER_MGR." B                                         ";
		$query .= "ON A.O_NO = B.O_NO                                               ";
		$query .= "WHERE A.SO_NO IS NOT NULL                                        ";
		$query .= "	AND IFNULL(A.SO_ACC_STATUS,'N') = '".$this->getSearchAccStatus()."'	";
		$query .= " AND A.SO_ORDER_STATUS = 'E'										";

		if ($this->getSearchCompany() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSearchCompany()."	";
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchSettleType()){
			$query .= "	AND B.O_SETTLE IN ({$this->getSearchSettleType()}) ";
		}

		if ($param['ORDER_END_START_DT'] && $param['ORDER_END_END_DT']){
			$query .= "	AND A.SO_ORDER_END_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		if ($param['ORDER_ACC_START_DT'] && $param['ORDER_ACC_END_DT']){
			$query .= "	AND A.SO_ACC_DATE BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		$query .= "GROUP BY A.SH_NO) A                                                 ";
		
		return $db->getCount($query);
	}

	function getAccPeriodList($db,$param)
	{
		$query  = "SELECT                                                           ";
		$query .= "     A.SH_NO                                                     ";
		$query .= "    ,MAX(D.SH_COM_NAME) SH_COM_NAME                              ";
		$query .= "    ,COUNT(*) TOT_CNT                                            ";
		$query .= "    ,SUM(C.TOT_QTY) TOT_QTY                                      ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_CUR_PRICE,0)) TOT_PRICE                 ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_CUR_SPRICE,0)) TOT_SPRICE               ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_DELIVERY_CUR_PRICE,0)) TOT_BPRICE       ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_CUR_APRICE,0)) TOT_APRICE               ";
		$query .= "FROM ".TBL_SHOP_ORDER." A                                        ";
		$query .= "JOIN ".TBL_ORDER_MGR." B                                         ";
		$query .= "ON A.O_NO = B.O_NO                                               ";
		$query .= "JOIN                                                             ";
		$query .= "(                                                                ";
		$query .= "    SELECT                                                       ";
		$query .= "         A.O_NO                                                  ";
		$query .= "        ,B.P_SHOP_NO                                             ";
		$query .= "        ,SUM(A.OC_QTY) TOT_QTY                                   ";
		$query .= "    FROM ".TBL_ORDER_CART." A                                    ";
		$query .= "    JOIN ".TBL_PRODUCT_MGR." B                                   ";
		$query .= "    ON A.P_CODE = B.P_CODE                                       ";
		$query .= "    WHERE A.OC_NO IS NOT NULL									";
		$query .= "		AND IFNULL(A.OC_ORDER_STATUS,'') = 'E'						";
//		if ($param['ORDER_END_START_DT'] && $param['ORDER_END_END_DT']){
//			$query .= "	AND A.OC_E_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_START_DT'])."','%Y-%m-%d 00:00:00') ";
//			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_END_DT'])."','%Y-%m-%d 23:59:59') ";		
//		}

		$query .= "    GROUP BY A.O_NO,B.P_SHOP_NO                                  ";
		$query .= ") C                                                              ";
		$query .= "ON A.O_NO = C.O_NO                                               ";
		$query .= "AND A.SH_NO = C.P_SHOP_NO                                        ";
		$query .= "JOIN ".TBL_SHOP_MGR." D                                          ";
		$query .= "ON A.SH_NO = D.SH_NO                                             ";
		$query .= "WHERE A.SO_NO IS NOT NULL                                        ";
		$query .= "	AND IFNULL(A.SO_ACC_STATUS,'N') = '".$this->getSearchAccStatus()."'	";
		$query .= " AND A.SO_ORDER_STATUS = 'E'										";
	
		if ($this->getSearchCompany() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSearchCompany()."	";
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchSettleType()){
			$query .= "	AND B.O_SETTLE IN ({$this->getSearchSettleType()}) ";
		}

		if ($param['ORDER_END_START_DT'] && $param['ORDER_END_END_DT']){
			$query .= "	AND A.SO_ORDER_END_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		if ($param['ORDER_ACC_START_DT'] && $param['ORDER_ACC_END_DT']){
			$query .= "	AND A.SO_ACC_DATE BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		$query .= "GROUP BY A.SH_NO                                                 ";
		$query .= "ORDER BY A.SO_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();				
		
		return $db->getExecSql($query);
	}


	function getAccSum($db,$param)
	{
		$query  = "SELECT																	  ";
		$query .= "     SUM(IFNULL(A.SO_TOT_CUR_PRICE,0)) TOT_PRICE                           ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_CUR_SPRICE,0)) TOT_SPRICE                         ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_CUR_APRICE,0)) TOT_APRICE                         ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_DELIVERY_CUR_PRICE,0)) TOT_BPRICE                 ";
		$query .= "    ,SUM(IFNULL(A.SO_TOT_CUR_SPRICE,0)) - SUM(IFNULL(A.SO_TOT_CUR_APRICE,0)) TOT_ACC_PRICE ";
		$query .= "FROM ".TBL_SHOP_ORDER." A                                        ";
		$query .= "JOIN ".TBL_ORDER_MGR." B                                         ";
		$query .= "ON A.O_NO = B.O_NO                                               ";
		$query .= "WHERE A.SO_NO IS NOT NULL                                        ";
		$query .= "	AND IFNULL(A.SO_ACC_STATUS,'N') = '".$this->getSearchAccStatus()."'	";
		$query .= " AND IFNULL(A.SH_NO,0) > 0										";
		$query .= " AND B.O_STATUS NOT IN ('F','W','C','R','T')						";
		$query .= " AND A.SO_ORDER_STATUS = 'E'										";
		
		if ($this->getSearchCompany() > 0){
			$query .= "	AND A.SH_NO = ".$this->getSearchCompany()."	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "K":
					$query .= "	B.O_KEY LIKE '%".$this->getSearchKey()."%'		";
				break;
			}
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "	AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchSettleType()){
			// 결제방법
			$query .= "	AND B.O_SETTLE IN ({$this->getSearchSettleType()}) ";
		}

		if ($param['ORDER_END_START_DT'] && $param['ORDER_END_END_DT']){
			$query .= "	AND A.SO_ORDER_END_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		if ($param['ORDER_ACC_START_DT'] && $param['ORDER_ACC_END_DT']){
			$query .= "	AND A.SO_ACC_DATE BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		return $db->getSelect($query);
	}

	/* 구매확정일별 정상목록 */
	function getAccDateList($db,$op,$param)
	{		
		
		$query  = "SELECT																			";
		if ($op == "OP_COUNT") {
			$query .= " COUNT(*)																	";
		} else if ($op == "OP_LIST") {		
			$query .= "     OC.*                                                                    ";
			$query .= "    ,O.O_KEY                                                                 ";
			$query .= "    ,O.O_REG_DT                                                              ";
			$query .= "    ,O.O_SETTLE                                                              ";
			$query .= "    ,O.O_STATUS                                                              ";
			$query .= "    ,P.P_TAX                                                                 ";
			$query .= "    ,IFNULL(P.P_SHOP_NO,0) P_SHOP_NO											";
		} else {
			$query .= "     SUM(IFNULL(OC.OC_CUR_PRICE,0) + IFNULL(OC.OC_OPT_ADD_CUR_PRICE,0)) TOT_SALE_PRICE ";
			$query .= "    ,SUM(IFNULL(OC.OC_STOCK_CUR_PRICE,0)) TOT_STOCK_PRICE					";
		}

		$query .= "FROM ".TBL_ORDER_CART." OC														";
		$query .= "JOIN ".TBL_ORDER_MGR." O															";
		$query .= "ON OC.O_NO = O.O_NO																";
		$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_MGR." P											";
		$query .= "ON OC.P_CODE = P.P_CODE															";
		$query .= "LEFT OUTER JOIN ".TBL_SHOP_ORDER." SO											";
		$query .= "ON OC.O_NO = SO.O_NO																";
		$query .= "AND SO.SH_NO = IFNULL(P.P_SHOP_NO,0)												";
		
		if (($param['SEARCH_FIELD'] && $param['SEARCH_KEY']) && $param['SEARCH_FIELD'] == "N"){
			$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_INFO_LNG.$param["O_USE_LNG"]." PI	";
			$query .= "ON P.P_CODE = PI.P_CODE											";		

		}
		
		$query .= "WHERE OC.OC_DELIVERY_STATUS = 'D'												";
		$query .= "    AND OC.OC_ORDER_STATUS = 'E'													";
		
		if ($param['SEARCH_SETTLE']){
			$query .= " AND O.O_SETTLE IN ({$param['SEARCH_SETTLE']})								";
		}

		if ($param['SEARCH_ACC_STATUS']){
			$query .= "AND IFNULL(SO.SO_ACC_STATUS,'N') = '{$param['SEARCH_ACC_STATUS']}'			";
		}

		if ($param['SEARCH_FIELD'] && $param['SEARCH_KEY']){
			switch($param['SEARCH_FIELD']){
				case "K":
					$query .= " AND O.O_KEY LIKE '%{$param['SEARCH_KEY']}%'		";
				break;
				case "N":
					$query .= " AND PI.P_NAME LIKE '%{$param['SEARCH_KEY']}%'	";
				break;
			}
		}

		if ($param['SEARCH_ORDER_END_ST_DT'] && $param['SEARCH_ORDER_END_END_DT']){
			$query .= "    AND OC.OC_E_REG_DT BETWEEN '{$param['SEARCH_ORDER_END_ST_DT']}' AND '{$param['SEARCH_ORDER_END_END_DT']}'";
		}

		if ($param['SEARCH_SHOP']){
			$query .= " AND IFNULL(P.P_SHOP_NO,0) = {$param['SEARCH_SHOP']}		";
		}
		
		if ($param['ORDER_BY']){
			$query .= "ORDER BY OC.OC_NO DESC														";
		}

		if ($param['LIMIT']){
			$query .= "	LIMIT {$param['LIMIT']}														";
		}
		
		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** View **********************************/
	function getShopView($db)
	{
		$query  = "SELECT * FROM ".TBL_SHOP_MGR."	";
		$query .= "WHERE SH_NO = ".$this->getSH_NO();
		
		return $db->getSelect($query);
	}
	/********************************** Insert **********************************/

	/********************************** Update **********************************/
	function getAccStatusUpdate($db)
	{
		$query  = "UPDATE ".TBL_SHOP_ORDER." SET SO_ACC_STATUS = '".$this->getACC_STATUS()."'	";
		$query .= "	,SO_ACC_DATE = NOW()	";
		$query .= "WHERE SO_NO = ".$this->getSO_NO();
		return $db->getExecSql($query);
	}

	function getAccStatusPeriodUpdate($db,$param)
	{
		$query  = "UPDATE ".TBL_SHOP_ORDER." SET SO_ACC_STATUS = '".$this->getACC_STATUS()."'	";
		$query .= "	,SO_ACC_DATE = NOW()											";
		$query .= "WHERE SO_NO IN 													";	
		$query .= "(																";
		$query .= "		SELECT SO_NO FROM (											";
		$query .= "		SELECT                                                      ";
		$query .= "			A.SO_NO                                                 ";
		$query .= "		FROM ".TBL_SHOP_ORDER." A                                   ";
		$query .= "		JOIN ".TBL_ORDER_MGR." B                                    ";
		$query .= "		ON A.O_NO = B.O_NO                                          ";
		$query .= "		WHERE A.SO_NO IS NOT NULL                                   ";
		$query .= "			AND A.SH_NO = ".$this->getSH_NO()."						";
		$query .= "			AND IFNULL(A.SO_ACC_STATUS,'N') = '".$this->getSearchAccStatus()."'	";
		$query .= "         AND A.SO_ORDER_STATUS = 'E'								";		
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= "		AND B.O_REG_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegStartDt())."','%Y-%m-%d 00:00:00') ";
			$query .= "		AND DATE_FORMAT('".mysql_real_escape_string($this->getSearchRegEndDt())."','%Y-%m-%d 23:59:59') ";		
		}

		if ($this->getSearchSettleType()){
			$query .= "		AND B.O_SETTLE IN ({$this->getSearchSettleType()}) ";
		}

		if ($param['ORDER_END_START_DT'] && $param['ORDER_END_END_DT']){
			$query .= "	AND A.SO_ORDER_END_DT BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_END_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}
		
		if ($param['ORDER_ACC_START_DT'] && $param['ORDER_ACC_END_DT']){
			$query .= "	AND A.SO_ACC_DATE BETWEEN DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$query .= "	AND DATE_FORMAT('".mysql_real_escape_string($param['ORDER_ACC_END_DT'])."','%Y-%m-%d 23:59:59') ";		
		}

		$query .= "		) A															";
		$query .= ")																";
		return $db->getExecSql($query);
	}
	
	
	/********************************** HISTORY **********************************/
	function getOrderAccountHistoryUpdate($db,$param)
	{
		$query = "CALL SP_HISTORY_MGR_I (?,?,?,?,?,?,?,?);";
		
		$param2[]  = $param['m_no'];
		$param2[]  = $param['h_tab'];
		$param2[]  = $param['h_key'];
		$param2[]  = $param['h_code'];
		$param2[]  = $param['h_memo'];
		$param2[]  = $param['h_text'];
		$param2[]  = $param['h_reg_no'];
		$param2[]  = $param['h_adm_no'];

		return $db->executeBindingQuery($query,$param2,true);
	}

	/********************************** Function **********************************/
	function getSelectQuery($db, $query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $db->getSelect($query);
		elseif ( $op == "OP_COUNT" ) :
			return $db->getCount($query);
		elseif ( $op == "OP_ARYLIST" ) :
			return $db->getArray($query);
		elseif ( $op == "OP_ARYTOTAL" ) :
			return $db->getArrayTotal($query);
		elseif ( $op == "OP_RESULT" ) :
			return $db->getResult($query);
		else :
			return -100;
		endif;
	}

	/********************************** variable **********************************/
	function setSH_NO($SH_NO){ $this->SH_NO = $SH_NO; }		
	function getSH_NO(){ return $this->SH_NO; }		

	function setSO_NO($SO_NO){ $this->SO_NO = $SO_NO; }		
	function getSO_NO(){ return $this->SO_NO; }		

	function setACC_STATUS($ACC_STATUS){ $this->ACC_STATUS = $ACC_STATUS; }		
	function getACC_STATUS(){ return $this->ACC_STATUS; }		

	function setP_LNG($P_LNG){ $this->P_LNG = $P_LNG; }		
	function getP_LNG(){ return $this->P_LNG; }	
	/*--------------------------------------------------------------*/	
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }
	
	function setSearchCompany($SEARCH_COMPANY){ $this->SEARCH_COMPANY = $SEARCH_COMPANY; }		
	function getSearchCompany(){ return $this->SEARCH_COMPANY; }

	function setSearchAccStatus($SEARCH_ACC_STATUS){ $this->SEARCH_ACC_STATUS = $SEARCH_ACC_STATUS; }		
	function getSearchAccStatus(){ return $this->SEARCH_ACC_STATUS; }

	function setSearchRegStartDt($SEARCH_REG_START_DT){ $this->SEARCH_REG_START_DT = $SEARCH_REG_START_DT; }		
	function getSearchRegStartDt(){ return $this->SEARCH_REG_START_DT; }

	function setSearchRegEndDt($SEARCH_REG_END_DT){ $this->SEARCH_REG_END_DT = $SEARCH_REG_END_DT; }		
	function getSearchRegEndDt(){ return $this->SEARCH_REG_END_DT; }

	function setSearchSettleType($SEARCH_SETTLE_TYPE){ $this->SEARCH_SETTLE_TYPE = $SEARCH_SETTLE_TYPE; }		
	function getSearchSettleType(){ return $this->SEARCH_SETTLE_TYPE; }
	/*--------------------------------------------------------------*/
	


	/*--------------------------------------------------------------*/	

	/*--------------------------------------------------------------*/	

	function setO_NO($O_NO){ $this->O_NO = $O_NO; }		
	function getO_NO(){ return $this->O_NO; }		

	function setOC_NO($OC_NO){ $this->OC_NO = $OC_NO; }		
	function getOC_NO(){ return $this->OC_NO; }		
	/********************************** variable **********************************/


}
?>