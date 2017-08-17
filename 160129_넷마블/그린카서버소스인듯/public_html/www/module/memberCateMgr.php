<?
#/*====================================================================*/# 
#|작성자	: 김희성(thav@naver.com)									|# 
#|작성일	: 2013-08-08												|# 
#|작성내용	: 회원소속관리												|# 
#/*====================================================================*/# 
class MemberCateMgr
{
	private $query;
	private $param;


	/********************************** List Total **********************************/
	function getMemberCateListEx($db, $op, $param) 
	{
		
		$column['OP_LIST']			= "*";
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "*";
		$column['OP_MAX_C_CODE']	= "MAX(C_CODE) AS MAX_C_CODE";
		
		if(!$op)			{ return; }

		if ($param['COL_ADD_POINT'] == "Y"):
			$addColList = "{$addColList},(CASE WHEN IFNULL(C.C_M_NO,0) > 0 THEN 
													(SELECT M_POINT FROM ".TBL_MEMBER_MGR." WHERE M_NO = C.C_M_NO) ELSE 0 END) C_TOT_POINT "; 
		endif;
		
		if ($param['COL_ADD_ORDER'] == "Y"):
			$addColList = "{$addColList},IFNULL(O.O_TOT_SPRICE,0) C_TOT_ORDER_SPRICE 
										,IFNULL(O.O_TOT_PRICE,0) C_TOT_ORDER_PRICE
		   "; 

		endif;
		
		$from	= "MEMBER_CATE_MGR";
		$query	= "SELECT {$column[$op]} {$addColList} FROM {$from} AS C	";

		if ($param['COL_ADD_ORDER'] == "Y"):
			
			$query .= "LEFT OUTER JOIN											";
			$query .= "(														";
			$query .= "		SELECT												";
			$query .= "			 MC.C_CODE										";
			$query .= "			,IFNULL(SUM(O.O_TOT_CUR_SPRICE),0) O_TOT_SPRICE	";
			$query .= "			,IFNULL(SUM(O.O_TOT_CUR_PRICE),0) O_TOT_PRICE	";
			$query .= "		FROM ".TBL_ORDER_MGR." O							";
			$query .= "     JOIN ".TBL_MEMBER_CATE." MC							";
			$query .= "     ON O.M_NO = MC.M_NO									";

			## 검색어
			if($param['O_SEARCH_KEY'] && $param['O_SEARCH_FIELD']){
				$query .= " JOIN ".TBL_MEMBER_MGR." M							";
				$query .= " ON O.M_NO = M.M_NO									";
			}

			$query .= "		WHERE O.O_STATUS = 'E'								";

			## 가입일
			if($param['O_REG_DT_BETWEEN'][0] && $param['O_REG_DT_BETWEEN'][1]):
				$param['O_REG_DT_BETWEEN'][0]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][0]);
				$param['O_REG_DT_BETWEEN'][1]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][1]);
				$query	.= " AND O.O_REG_DT BETWEEN DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
			endif;

			## 검색어
			if($param['O_SEARCH_KEY'] && $param['O_SEARCH_FIELD']){
				switch ($param['O_SEARCH_FIELD']){
					case "id":
						$query .= " AND M.M_ID LIKE '%".$param['O_SEARCH_KEY']."%'		";
					break;
					case "name":
						$query .= " AND M.M_L_NAME LIKE '%".$param['O_SEARCH_KEY']."%'		";
					break;
					case "mail":
						$query .= " AND M.M_MAIL LIKE '%".$param['O_SEARCH_KEY']."%'		";
					break;
					case "hp":
						$query .= " AND M.M_HP LIKE '%".$param['O_SEARCH_KEY']."%'		";
					break;
				}
			}

			$query .= "		GROUP BY MC.C_CODE									";
			$query .= ") O														";
			$query .= "ON C.C_CODE = O.C_CODE									";

		endif;

		$where	= "WHERE C.C_CODE IS NOT NULL";

		if($param['C_CODE_LIKE_L']):
			$where		= "{$where} AND C.C_CODE LIKE ('{$param['C_CODE_LIKE_L']}%')";
		endif;

		if($param['C_CODE']):
			$where		= "{$where} AND C.C_CODE = '{$param['C_CODE']}'";
		endif;

		if($param['C_LEVEL']):
			$where		= "{$where} AND C.C_LEVEL = {$param['C_LEVEL']}";
		endif;

		if($param['C_NATION']):
			$where		= "{$where} AND C.C_NATION = '{$param['C_NATION']}'";
		endif;
		
		if($param['C_LEVEL_VIEW_LIMIT'] > 0){
			$where		= "{$where} AND C.C_LEVEL <= '{$param['C_LEVEL_VIEW_LIMIT']}' ";
		}

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$where} {$order_by} {$limit}";
		
		return $this->getSelectQuery($db, $query, $op);
	}

	function getMemberCateJoinListEx($db, $op, $param) 
	{
		
		$column['OP_LIST']			= "*";
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "*";
		$column['OP_ARYLIST']		= "MC.MC_NO, MC.M_NO";
		$column['OP_ARYTOTAL']		= "*";

		if($param['C_CODE_COLUMN_ARYLIST']	== "Y"):
			$column['OP_ARYLIST']		= "MC.MC_NO, MC.C_CODE";
		endif;

		if(!$op)			{ return; }

		$from	= "MEMBER_CATE";
		$query	= "SELECT {$column[$op]} FROM {$from} AS MC";
		$where	= "WHERE MC.MC_NO IS NOT NULL";

		if($param['MEMBER_CATE_MGR_JOIN'] == "Y"):
			$join1		= "LEFT OUTER JOIN MEMBER_CATE_MGR AS C ON C.C_CODE = MC.C_CODE";
		endif;

		if($param['C_CODE']):
			$where		= "{$where} AND MC.C_CODE = '{$param['C_CODE']}'";
		endif;

		if($param['M_NO']):
					
			$where		= "{$where} AND MC.M_NO = '{$param['M_NO']}'";
		endif;

		if($param['C_NATION']):
			$where		= "{$where} AND C.C_NATION = '{$param['C_NATION']}'";
		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$join1} {$where} {$order_by} {$limit}";
		
		return $this->getSelectQuery($db, $query, $op);
	}	

	function getMemberCateCntEx($db,$param)
	{
		$query  = "SELECT								";
		$query .= "     COUNT(*) C_MEMBER_CNT			";
		$query .= "FROM ".TBL_MEMBER_CATE." A			";
		$query .= "JOIN ".TBL_MEMBER_MGR." B			";
		$query .= "ON A.M_NO = B.M_NO					";
		$query .= "WHERE A.M_NO IS NOT NULL				";
		$query .= "	AND IFNULL(B.M_OUT,'Y') != 'N'		";
		
		$query .= "	AND A.C_CODE LIKE '".$param['C_CODE']."%'	";
		$query .= "GROUP BY A.C_CODE					";

		return $this->getSelectQuery($db, $query, "OP_COUNT");
	}

	function getMemberCateHighLowListEx($db, $param) 
	{
		$query  = "SELECT									";
		$query .= "    C_CODE								";
		$query .= "FROM ".TBL_MEMBER_CATE."					";
		$query .= "WHERE C_HCODE   = '".$param['C_CODE']."'	";
		$query .= "    AND C_LEVEL = ".$param['C_LEVEL']."	";
		$query .= "    AND C_VIEW  = 'Y'					";
		
		return $this->getSelectQuery($db, $query, "OP_COUNT");

	}
	
	function getMemberCateOrderSumEx($db,$param)
	{
		$query  = "SELECT                                                                                         ";
		$query .= "     SUBSTRING(C.C_CODE,1,".(3 * $param['C_LEVEL']).")                                         ";
		$query .= "    ,MAX(C.C_NAME) C_NAME																	  ";		
		$query .= "    ,SUM(A.O_TOT_PRICE) C_TOT_ORDER_PRICE                                                      ";
		$query .= "    ,SUM(A.O_TOT_SPRICE) C_TOT_ORDER_SPRICE                                                    ";
		$query .= "FROM                                                                                           ";
		$query .= "(                                                                                              ";
		$query .= "    SELECT                                                                                     ";
		$query .= "         A.M_NO                                                                                ";
		$query .= "        ,SUM(A.O_TOT_CUR_PRICE) O_TOT_PRICE                                                    ";
		$query .= "        ,SUM(A.O_TOT_CUR_SPRICE) O_TOT_SPRICE                                                  ";
		$query .= "    FROM ".TBL_ORDER_MGR." A                                                                   ";
		
		## 검색어
		if($param['O_SEARCH_KEY'] && $param['O_SEARCH_FIELD']){
			$query .= "JOIN ".TBL_MEMBER_MGR." M									";
			$query .= "ON A.M_NO = M.M_NO											";			
		}
		
		$query .= "    WHERE A.O_STATUS = '{$param['O_SEARCH_STATUS']}'                                           ";
		
		## 가입일
		if($param['O_REG_DT_BETWEEN'][0] && $param['O_REG_DT_BETWEEN'][1]):
			$param['O_REG_DT_BETWEEN'][0]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][0]);
			$param['O_REG_DT_BETWEEN'][1]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][1]);
			$query	.= "   AND A.O_REG_DT BETWEEN DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
		endif;

		## 검색어
		if($param['O_SEARCH_KEY'] && $param['O_SEARCH_FIELD']){
			switch ($param['O_SEARCH_FIELD']){
				case "id":
					$query .= " AND M.M_ID LIKE '%".$param['O_SEARCH_KEY']."%'		";
				break;
				case "name":
					$query .= " AND M.M_L_NAME LIKE '%".$param['O_SEARCH_KEY']."%'	";
				break;
				case "mail":
					$query .= " AND M.M_MAIL LIKE '%".$param['O_SEARCH_KEY']."%'	";
				break;
				case "hp":
					$query .= " AND M.M_HP LIKE '%".$param['O_SEARCH_KEY']."%'		";
				break;
			}
		}
		
		$query .= "    GROUP BY A.M_NO                                                                            ";
		$query .= ") A                                                                                            ";
		$query .= "JOIN ".TBL_MEMBER_CATE." B                                                                     ";
		$query .= "ON A.M_NO = B.M_NO                                                                             ";
		$query .= "JOIN ".TBL_MEMBER_CATE_MGR." C                                                                 ";
		$query .= "ON B.C_CODE = C.C_CODE                                                                         ";
		$query .= "WHERE C.C_LEVEL = 2                                                                            ";
		$query .= "    AND SUBSTRING(B.C_CODE,1,".(3 * $param['C_LEVEL']).") = '{$param['C_CODE']}'               ";
		$query .= "GROUP BY SUBSTRING(B.C_CODE,1,".(3 * $param['C_LEVEL']).")                                     ";
		
		return $db->getSelect($query);
	}
	function getMemberCateOrderListEx($db,$op,$param)
	{
		$column['OP_LIST']			= "A.*								";
		$column['OP_COUNT']			= "COUNT(*)							";
		
		$query  = "SELECT												";
		$query .= $column[$op];
		$query .= "FROM													";
		$query .= "(													";
		$query .= "    SELECT											";
		$query .= "         A.M_NO										";
		$query .= "        ,C.M_ID										";
		$query .= "        ,C.M_L_NAME									";
		$query .= "        ,SUM(A.O_TOT_CUR_SPRICE) O_TOT_SPRICE		";
		$query .= "        ,SUM(A.O_TOT_CUR_PRICE) O_TOT_PRICE			";
		$query .= "    FROM ".TBL_ORDER_MGR." A							";
		$query .= "    JOIN												";
		$query .= "    (												";
		$query .= "        SELECT										";
		$query .= "            M_NO										";
		$query .= "        FROM ".TBL_MEMBER_CATE."						";
		
		if ($param["C_CODE"]){
			$query .= "    WHERE C_CODE LIKE  '".$param["C_CODE"]."%'	";
		}

		$query .= "        GROUP BY M_NO								";
		$query .= "    ) B												";
		$query .= "    ON A.M_NO = B.M_NO								";
		$query .= "    JOIN MEMBER_MGR C								";
		$query .= "    ON A.M_NO = C.M_NO								";
		$query .= "    WHERE A.O_STATUS = '{$param['O_SEARCH_STATUS']}' ";

		
		## 가입일
		if($param['O_REG_DT_BETWEEN'][0] && $param['O_REG_DT_BETWEEN'][1]):
			$param['O_REG_DT_BETWEEN'][0]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][0]);
			$param['O_REG_DT_BETWEEN'][1]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][1]);
			$query	.= " AND A.O_REG_DT BETWEEN DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
		endif;


		## 검색어
		if($param['O_SEARCH_KEY'] && $param['O_SEARCH_FIELD']){
			switch ($param['O_SEARCH_FIELD']){
				case "id":
					$query .= " AND C.M_ID LIKE '%".$param['O_SEARCH_KEY']."%'		";
				break;
				case "name":
					$query .= " AND C.M_L_NAME LIKE '%".$param['O_SEARCH_KEY']."%'		";
				break;
				case "mail":
					$query .= " AND C.M_MAIL LIKE '%".$param['O_SEARCH_KEY']."%'		";
				break;
				case "hp":
					$query .= " AND C.M_HP LIKE '%".$param['O_SEARCH_KEY']."%'		";
				break;
			}
		}

		$query .= "    GROUP BY A.M_NO									";
		$query .= ") A													";
		
		if ($op != "OP_COUNT"){
			
			switch ($param['ORDER_BY']){
				case "totPriceDesc":
					$query .= " ORDER BY A.O_TOT_PRICE	DESC			";
				break;
				case "totPriceAsc":
					$query .= " ORDER BY A.O_TOT_PRICE	ASC				";
				break;
				case "totSPriceDesc":
					$query .= " ORDER BY A.O_TOT_SPRICE	DESC			";
				break;
				case "toSPriceAsc":
					$query .= " ORDER BY A.O_TOT_SPRICE	ASC				";
				break;
				default:
					$query .= " ORDER BY A.O_TOT_SPRICE	DESC			";
				break;
			}
			
			if ($param["LIMIT"]){

				$query .= " LIMIT {$param['LIMIT']} ";						
			}
		}
		return $this->getSelectQuery($db, $query, $op);
	}
	/********************************** List **********************************/


	/********************************** View **********************************/

	/********************************** Insert **********************************/
	function getMemberCateInsertEx($db, $paramData) 
	{
			$param['C_CODE']		= $db->getSQLString($paramData['C_CODE']);
			$param['C_NAME']		= $db->getSQLString($paramData['C_NAME']);
			$param['C_LEVEL']		= $db->getSQLInteger($paramData['C_LEVEL']);
			$param['C_LOW_YN']		= $db->getSQLString($paramData['C_LOW_YN']);
			$param['C_HCODE']		= $db->getSQLString($paramData['C_HCODE']);
			$param['C_ORDER']		= $db->getSQLInteger($paramData['C_ORDER']);
			$param['C_VIEW']		= $db->getSQLString($paramData['C_VIEW']);
			$param['C_NATION']		= $db->getSQLString($paramData['C_NATION']);
			$param['C_POINT']		= $db->getSQLInteger($paramData['C_POINT']);
			$param['C_POINT_OFF']	= $db->getSQLString($paramData['C_POINT_OFF']);
			$param['C_POINT2']		= $db->getSQLInteger($paramData['C_POINT2']);
			$param['C_POINT2_OFF']	= $db->getSQLString($paramData['C_POINT2_OFF']);			
			$param['C_REG_DT']		= "NOW()";
			$param['C_REG_NO']		= $db->getSQLInteger($paramData['C_REG_NO']);
			$param['C_MOD_DT']		= "NOW()";
			$param['C_MOD_NO']		= $db->getSQLInteger($paramData['C_MOD_NO']);
			return $db->getInsertParam("MEMBER_CATE_MGR",$param);
	}

	function getMemberCateVirtualMake($db,$paramData)
	{
		$param['M_ID']			= $db->getSQLString($paramData['M_ID']);
		$param['M_L_NAME']		= $db->getSQLString($paramData['M_L_NAME']);
		$param['M_GROUP']		= $db->getSQLString($paramData['M_GROUP']);
		$param['M_AUTH']		= $db->getSQLString('Y');
		$param['M_REG_DT']		= "NOW()";
		$param['M_REG_NO']		= $db->getSQLInteger($paramData['M_REG_NO']);
		
		return $db->getInsertParam(TBL_MEMBER_MGR,$param);	
	}

	function getMemberCateVirtualAddMake($db,$paramData)
	{
		$param['M_NO']			= $db->getSQLInteger($paramData['M_NO']);
		
		return $db->getInsertParam(TBL_MEMBER_ADD,$param);	
	}

	function getMemberCateVirtualPwdUpdate($db,$param)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_PASS = SHA1(CONCAT('".$param['M_PASS']."','!@#$')) WHERE M_NO = ".$param['M_NO'];
		return $db->getExecSql($query);
	}

	function getMemberCateVirtualIdUpdate($db,$param)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_ID = '".$param['M_ID']."' WHERE M_NO = ".$param['M_NO'];
		return $db->getExecSql($query);
	}


	function getMemberCateJoinInsertEx($db, $paramData)
	{
//			$param['MC_NO']			= $db->getSQLInteger($paramData['MC_NO']);
			$param['C_CODE']		= $db->getSQLString($paramData['C_CODE']);
			$param['M_NO']			= $db->getSQLInteger($paramData['M_NO']);
			return $db->getInsertParam("MEMBER_CATE",$param);
	}

	/********************************** Update **********************************/
	function getMemberCateUpdateEx($db, $paramData) 
	{


//			$param['C_CODE']		= $db->getSQLString($paramData['C_CODE']);
		$param['C_NAME']		= $db->getSQLString($paramData['C_NAME']);
		$param['C_LEVEL']		= $db->getSQLInteger($paramData['C_LEVEL']);
		$param['C_LOW_YN']		= $db->getSQLString($paramData['C_LOW_YN']);
//		$param['C_HCODE']		= $db->getSQLString($paramData['C_HCODE']);
		$param['C_ORDER']		= $db->getSQLInteger($paramData['C_ORDER']);
		$param['C_VIEW']		= $db->getSQLString($paramData['C_VIEW']);
		$param['C_NATION']		= $db->getSQLString($paramData['C_NATION']);
		$param['C_POINT']		= $db->getSQLInteger($paramData['C_POINT']);
		$param['C_POINT_OFF']	= $db->getSQLString($paramData['C_POINT_OFF']);
		$param['C_POINT2']		= $db->getSQLInteger($paramData['C_POINT2']);
		$param['C_POINT2_OFF']	= $db->getSQLString($paramData['C_POINT2_OFF']);			
//			$param['C_REG_DT']		= "NOW()";
//			$param['C_REG_NO']		= $db->getSQLInteger($paramData['C_REG_NO']);
		$param['C_MOD_DT']		= "NOW()";
		$param['C_MOD_NO']		= $db->getSQLInteger($paramData['C_MOD_NO']);

		if($paramData['C_CODE']):
			$where				= "C_CODE = '{$paramData['C_CODE']}'";
		endif;
		
		if(!$where)					{ return; }

		return $db->getUpdateParam("MEMBER_CATE_MGR",$param, $where);		
	}
	
	function getMemberCateUpdateVirtualUpdate($db,$paramData)
	{
		if($paramData['C_CODE']):
			$where				= "C_CODE = '{$paramData['C_CODE']}'";
		endif;

		$param['C_M_NO']		= $db->getSQLInteger($paramData['M_NO']);
		return $db->getUpdateParam("MEMBER_CATE_MGR",$param, $where);		

	}
	/********************************** Delete **********************************/


	function getMemberCateDeleteEx($db, $paramData)
	{
		$where			= "";
		if($paramData['C_CODE']):
			$where			= "{$where} C_CODE = '{$paramData['C_CODE']}'";
		endif;

		if(!$where) { return; }

		$db->getDelete("MEMBER_CATE_MGR", $where);
	}

	function getMemberCateJoinDeleteEx($db, $paramData)
	{
		$where			= "";
		if($paramData['MC_NO']):
			$where			= "{$where} MC_NO = '{$paramData['MC_NO']}'";
		endif;

		if(!$where) { return; }

		$db->getDelete("MEMBER_CATE", $where);
	}

	function getMemberCateVirtualMemberDeleteEx($db, $param)
	{
		
		$query = "CALL SP_MEMBER_CATE_VIRTUAL_D (?);";

		$param[]  = $param['C_M_NO'];

		return $db->executeBindingQuery($query,$param,true);		
		
	}

	function getSelectQuery($db, $query, $op)
	{
		if ( $op == "OP_LIST" ) :
			return $db->getExecSql($query);
		elseif ( $op == "OP_SELECT" ) :
			return $db->getSelect($query);
		elseif ( $op == "OP_MAX_C_CODE" ) :
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

	/********************************** variable **********************************/



	/********************************** variable **********************************/


}
?>