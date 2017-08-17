<?
#/*====================================================================*/# 
#|화일명	: 상품기획전관리 											|# 
#|작성자	: 박영미													|# 
#|작성일	: 2013-09-10												|# 
#|작성내용	: 															|# 
#/*====================================================================*/# 

class ProductPlanMgr
{
	private $query;
	private $param;
	
	/********************************** List /View **********************************/
	function getProdPlanQry($db, $op, $param) 
	{
		$column['OP_LIST']			= "  A.*
										,B.PL_NAME
		";
			
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "  A.*
										,B.PL_NAME
										,B.PL_HTML
		";
		
		$query  = "SELECT									";
		$query .= $column[$op];
		$query .= "FROM ".TBL_PROD_PLAN." A					";
		$query .= "JOIN ".TBL_PROD_PLAN_LNG." B				";
		$query .= "ON A.PL_NO = B.PL_NO						";
		$query .= "AND B.PL_LNG = '".$param['PL_LNG']."'	";
	
	
		if ($param['PL_NO']){
			$where = "WHERE A.PL_NO = ".mysql_real_escape_string($param['PL_NO'])."	";
		} else {
			$where  = "WHERE A.PL_NO IS NOT NULL			";
		}

		if ($param['SEARCH_FILED'] && $param['SEARCH_KEY']){
			$where .= " AND B.PL_NAME LIKE '%".mysql_real_escape_string($param['SEARCH_KEY'])."%'	";
		}

		if ($param['SEARCH_START_DT'] && $param['SEARCH_END_DT']){
			$where .= " AND A.PL_START_DT <= DATE_FORMAT('".mysql_real_escape_string($param['SEARCH_START_DT'])."','%Y-%m-%d 00:00:00') ";
			$where .= "	AND A.PL_END_DT >= DATE_FORMAT('".mysql_real_escape_string($param['SEARCH_END_DT'])."','%Y-%m-%d 23:59:59') ";
		}

		if ($param['SEARCH_VIEW_Y'] || $param['SEARCH_VIEW_N']){
			
			if (!($param['SEARCH_VIEW_Y'] && $param['SEARCH_VIEW_N'])){

				if ($param['SEARCH_VIEW_Y']){
					$where .= " AND IFNULL(A.PL_USE,'N') = '".mysql_real_escape_string($param['SEARCH_VIEW_Y'])."'	";
				}

				if ($param['SEARCH_VIEW_N']){
					$where .= " AND IFNULL(A.PL_USE,'N') = '".mysql_real_escape_string($param['SEARCH_VIEW_N'])."'	";
				}
			}
		}


		$query .= $where;		
		if($param['ORDER_BY']):
			switch($param['ORDER_BY']){
				case "N":
					$query .= " ORDER BY A.PL_NO DESC		";
				break;
			}
		endif;

		if($param['LIMIT']):
			$query .= "LIMIT {$param['LIMIT']}";
		endif;
		
		return $this->getSelectQuery($db, $query, $op);
	}
	
	function getProdPlanCateList($db,$param)
	{
		$query  = "SELECT					";
		$query .= "    A.PL_P_CATE			";
		$query .= "FROM ".TBL_PRODUCT_PLAN." A ";
		$query .= "WHERE A.PL_NO = ".$param['PL_NO']."    ";
		$query .= "GROUP BY A.PL_P_CATE";

		return $db->getArrayTotal($query);
	}
	
	function getProdPlanCateName($db,$param)
	{
		$query  = "SELECT							";
		$query .= "    B.CL_NAME					";
		$query .= "FROM ".TBL_CATE_MGR." A			";
		$query .= "JOIN ".TBL_CATE_LNG." B			";
		$query .= "ON A.C_CODE = B.C_CODE			";
		$query .= "AND B.CL_LNG = '".$param['PL_LNG']."'		";
		$query .= "WHERE A.C_CODE = '".$param['C_CODE']."'		";
		
		return $db->getCount($query);
	}
	
	function getProdPlanCateInfo($db,$param)
	{
		$query  = "SELECT							";
		$query .= "    B.*							";
		$query .= "FROM ".TBL_CATE_MGR." A			";
		$query .= "JOIN ".TBL_CATE_LNG." B			";
		$query .= "ON A.C_CODE = B.C_CODE			";
		$query .= "AND B.CL_LNG = '".$param['PL_LNG']."'		";
		$query .= "WHERE A.C_CODE = '".$param['C_CODE']."'		";
		
		return $db->getSelect($query);
	}

	function getProdPlanCateCount($db,$param)
	{
		$query  = "SELECT						";
		$query .= "    COUNT(*)					";
		$query .= "FROM ".TBL_PRODUCT_PLAN." A	";
		$query .= "WHERE A.PL_P_CATE LIKE '".$param['PL_P_CATE']."%'    ";
		
		return $db->getCount($query);
	}

	function getProdPlanCateProdList($db,$op,$param)
	{

		$column['OP_ARYTOTAL']		= "  A.*                             
										,PI.P_NAME                       
										,P.P_QTY                         
										,P.P_SALE_PRICE                  
										,P.P_STOCK_OUT                   
										,P.P_STOCK_LIMIT                 
										,P.P_REG_DT                      
										,P.P_NUM 
										,P.P_CODE
		";
			
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_LIST']			= "  
			 P.P_CODE							
		    ,PI.P_NAME							
		    ,P.P_NUM								
		    ,A.PL_P_CATE							
		    ,P.P_LAUNCH_DT						
		    ,P.P_REP_DT							
		    ,P.P_CONSUMER_PRICE					
		    ,P.P_SALE_PRICE						
		    ,P.P_QTY								
		    ,P.P_WEB_VIEW						
		    ,P.P_MOB_VIEW						
		    ,P.P_POINT							
		    ,P.P_EVENT_UNIT						
		    ,P.P_EVENT							
		    ,P.P_LIST_ICON						
		    ,PI.P_ETC								
		    ,P.P_COLOR							
		    ,P.P_MAKER							
		    ,P.P_ORIGIN							
		    ,P.P_MODEL							
		    ,PI.P_PRICE_TEXT						
		    ,PI.P_SEARCH_TEXT						
		    ,B.PM_REAL_NAME						
		    ,P.P_REG_DT							
		    ,P.P_POINT_TYPE                      
		    ,P.P_POINT_OFF1                      
		    ,P.P_POINT_OFF2                      
		    ,SUBSTRING(P.P_ICON,1,1) ICON1		
		    ,SUBSTRING(P.P_ICON,3,1) ICON2		
		    ,SUBSTRING(P.P_ICON,5,1) ICON3		
		    ,SUBSTRING(P.P_ICON,7,1) ICON4		
		    ,SUBSTRING(P.P_ICON,9,1) ICON5		
		    ,SUBSTRING(P.P_ICON,11,1) ICON6		
		    ,SUBSTRING(P.P_ICON,13,1) ICON7		
		    ,SUBSTRING(P.P_ICON,15,1) ICON8		
		    ,SUBSTRING(P.P_ICON,17,1) ICON9		
		    ,SUBSTRING(P.P_ICON,19,1) ICON10		
		    ,P.P_ADD_OPT
		";

		$query  = "SELECT                               ";
		$query .= $column[$op]."						";
		$query .= "FROM ".TBL_PRODUCT_PLAN." A							";
		$query .= "JOIN ".TBL_PRODUCT_MGR." P							";
		$query .= "ON A.PL_P_CODE = P.P_CODE							";
		$query .= "JOIN ".TBL_PRODUCT_INFO_LNG.$param['PL_LNG']." PI	";
		$query .= "ON P.P_CODE = PI.P_CODE								";
//		$query .= "JOIN PRODUCT_BRAND PR	";
//		$query .= "ON PR.PR_NO = P.P_BRAND								";
		
		if ($op != "OP_ARYTOTAL"){
			$query .= "LEFT OUTER JOIN ".TBL_PRODUCT_IMG." B    ";
			$query .= "ON P.P_CODE = B.P_CODE					";
			$query .= "AND B.PM_TYPE = 'list'					";
		}

		if ($op != "OP_ARYTOTAL" && ($param['ORDER_BY'] == "BD" || $param['ORDER_BY']== "SD")){
			$query .= "LEFT OUTER JOIN                           ";
			$query .= "(                                         ";
			$query .= "    SELECT                                ";
			$query .= "         A.UB_P_CODE                      ";
			$query .= "        ,SUM(A.UB_P_GRADE) UB_P_GRADE     ";
			$query .= "    FROM BOARD_UB_PROD_REVIEW A           ";
			$query .= "    WHERE A.UB_P_CODE IS NOT NULL         ";
			$query .= "        AND A.UB_P_CODE != ''             ";
			$query .= "    GROUP BY A.UB_P_CODE                  ";
			$query .= ") U                                       ";
			$query .= "ON P.P_CODE = U.UB_P_CODE                 ";
			$query .= "LEFT OUTER JOIN                           ";
			$query .= "(                                         ";
			$query .= "    SELECT                                ";
			$query .= "         A.P_CODE                         ";
			$query .= "        ,SUM(A.OC_QTY) P_SELL_QTY         ";
			$query .= "    FROM ".TBL_ORDER_CART." A             ";
			$query .= "    JOIN ".TBL_ORDER_MGR." B              ";
			$query .= "    ON A.O_NO = B.O_NO                    ";
			$query .= "    WHERE A.OC_NO IS NOT NULL             ";
			$query .= "        AND B.O_STATUS = 'E'              ";
			$query .= "    GROUP BY A.P_CODE                     ";
			$query .= ") O                                       ";
			$query .= "ON P.P_CODE = O.P_CODE                    ";		
		}
		
		$query .= "WHERE A.PL_NO = ".$param['PL_NO']."                  ";
		$query .= "    AND A.PL_P_CATE = '".$param['PL_P_CATE']."'		";
		
		## 2014.12.19 kim hee sung 화면 출력 부분 설정
		if($param['P_WEB_VIEW']):
			$query .= " AND P.P_WEB_VIEW = '{$param['P_WEB_VIEW']}' ";
		endif;

		if($param['ORDER_BY'] && $op != "OP_COUNT"):
			switch($param['ORDER_BY']){
				case "N":
					$query .= " ORDER BY A.PPL_NO DESC		";
				break;
				case "RA":
					$query .= "	ORDER BY P.P_SALE_PRICE ASC ";	
				break;
				case "RD":
					$query .= "	ORDER BY A.P_SALE_PRICE DESC ";	
				break;
				case "NA":
					$query .= "	ORDER BY A.P_NAME ASC ";	
				break;
				case "ND":
					$query .= "	ORDER BY A.P_NAME DESC ";	
				break;
				case "PA":
					$query .= "	ORDER BY A.P_POINT ASC ";	
				break;
				case "PD":
					$query .= "	ORDER BY A.P_POINT DESC ";	
				break;
				case "MA":
					$query .= "	ORDER BY A.P_MAKER ASC ";	
				break;
				case "MD":
					$query .= "	ORDER BY A.P_MAKER DESC ";	
				break;
				case "TD":
					$query .= "	ORDER BY A.P_REG_DT DESC ";	
				break;

				case "BD":
					$query .= "	ORDER BY U.UB_P_GRADE DESC ";	//판매인기도순
				break;

				case "SD":
					$query .= "	ORDER BY O.P_SELL_QTY DESC ";	//누적판매도순
				break;

				case "DE":
					$query .= "ORDER BY P.P_ORDER ASC,P.P_CODE DESC "; //기본
				break;

				default:
					$query .= "ORDER BY P.P_ORDER ASC, P.P_REG_DT DESC ";
				break;
			}
		endif;

		if($param['LIMIT']):
			$query .= "LIMIT {$param['LIMIT']}";
		endif;
		
		
		return $this->getSelectQuery($db, $query, $op);
	}

	function getProdPlanProdNo($db,$param)
	{
		$query  = "SELECT												";
		$query .= "    A.PPL_NO											";
		$query .= "FROM ".TBL_PRODUCT_PLAN." A							";
		$query .= "WHERE A.PL_NO = ".$param['PLAN_NO']."                ";
		$query .= "    AND A.PL_P_CATE = '".$param['PLAN_P_CATE']."'	";
		$query .= "    AND A.PL_P_CODE = '".$param['PLAN_P_CODE']."'	";

		return $db->getCount($query);
	}

	/********************************** Insert **********************************/
	function getProdPlanInsert($db,$paramData)
	{
		$param['PL_START_DT']	= $db->getSQLDatetime($paramData['PLAN_START_DT']);
		$param['PL_END_DT']		= $db->getSQLDatetime($paramData['PLAN_END_DT']);
		$param['PL_USE']		= $db->getSQLString($paramData['PLAN_VIEW']);
		$param['PL_REG_NO']		= $db->getSQLInteger($paramData['PLAN_REG_NO']);
		$param['PL_REG_DT']		= "NOW()";
		return $db->getInsertParam(TBL_PROD_PLAN,$param);
	}

	function getProdPlanLngInsert($db,$paramData)
	{
		$param['PL_NO']			= $db->getSQLInteger($paramData['PLAN_NO']);
		$param['PL_LNG']		= $db->getSQLString($paramData['PLAN_LNG']);
		$param['PL_NAME']		= $db->getSQLString($paramData['PLAN_NAME']);
		$param['PL_HTML']		= $db->getSQLString($paramData['PLAN_HTML']);
		return $db->getInsertParam(TBL_PROD_PLAN_LNG,$param);
	}

	function getProdPlanProductInsert($db,$paramData)
	{
		$param['PL_NO']			= $db->getSQLInteger($paramData['PLAN_NO']);
		$param['PL_P_CATE']		= $db->getSQLString($paramData['PLAN_P_CATE']);
		$param['PL_P_CODE']		= $db->getSQLString($paramData['PLAN_P_CODE']);
		return $db->getInsertParam(TBL_PRODUCT_PLAN,$param);
	}

	/********************************** Modify **********************************/
	function getProdPlanModify($db,$paramData)
	{	
		$param['PL_START_DT']	= $db->getSQLDatetime($paramData['PLAN_START_DT']);
		$param['PL_END_DT']		= $db->getSQLDatetime($paramData['PLAN_END_DT']);
		$param['PL_USE']		= $db->getSQLString($paramData['PLAN_VIEW']);
		$param['PL_MOD_NO']		= $db->getSQLInteger($paramData['PLAN_MOD_NO']);
		$param['PL_MOD_DT']		= "NOW()";

		if($paramData['PLAN_NO']):
			$where				= "PL_NO = {$paramData['PLAN_NO']}";
		endif;
		
		if(!$where) { return; }

		return $db->getUpdateParam(TBL_PROD_PLAN,$param, $where);		
	}

	function getProdPlanLngModify($db,$paramData)
	{
		$param['PL_NAME']		= $db->getSQLString($paramData['PLAN_NAME']);
		$param['PL_HTML']		= $db->getSQLString($paramData['PLAN_HTML']);

		if($paramData['PLAN_NO']):
			$where				= "PL_NO = {$paramData['PLAN_NO']}";
			$where			   .= " AND PL_LNG = '{$paramData['PLAN_LNG']}'";
		endif;
		
		if(!$where) { return; }

		return $db->getUpdateParam(TBL_PROD_PLAN_LNG,$param, $where);
	}

	/********************************** Delete **********************************/
	function getProdPlanCateProdDelete($db, $paramData)
	{
		
		$param['PL_NO']		= $db->getSQLInteger($paramData['PLAN_NO']);

		$where				= " PL_NO = ".$param['PL_NO'];					
		if($paramData['PPL_NO_LIST']):
			$where			= "{$where} AND PPL_NO NOT IN ({$paramData['PPL_NO_LIST']})";
		endif;

		if($paramData['PL_P_CATE_LIST']):
			$where			= "{$where} AND PL_P_CATE NOT IN ({$paramData['PL_P_CATE_LIST']})";
		endif;

		if(!$where) { return; }

		$db->getDelete(TBL_PRODUCT_PLAN, $where);
	}
	
	function getProdPlanLngDelete($db,$paramData)
	{
		$param['PL_NO']		= $db->getSQLInteger($paramData['PLAN_NO']);
		$where				= " PL_NO = ".$param['PL_NO'];					
		if(!$where) { return; }

		$db->getDelete(TBL_PROD_PLAN_LNG, $where);
	}

	function getProdPlanDelete($db,$paramData)
	{
		$param['PL_NO']		= $db->getSQLInteger($paramData['PLAN_NO']);
		$where				= " PL_NO = ".$param['PL_NO'];					
		if(!$where) { return; }

		$db->getDelete(TBL_PROD_PLAN, $where);
	}

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
		else :
			return -100;
		endif;
	}
}
?>