<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-08-06												|# 
#|작성내용	: 포인트관리												|# 
#/*====================================================================*/# 

class PointMgr
{
	private $query;
	private $param;

	/********************************** List **********************************/
	function getPointTotal($db)
	{
		$query  = "SELECT												";
		$query .= "     COUNT(*)										";
		$query .= "FROM ".TBL_POINT_MGR." A                             ";
		$query .= "JOIN ".TBL_MEMBER_MGR." B							";
		$query .= "ON A.M_NO = B.M_NO									";
		$query .= "WHERE A.PT_NO IS NOT NULL							";

		if ($this->getM_NO()){
			$query .= " AND A.M_NO = ".$this->getM_NO()."	";
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	B.M_ID LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	CONCAT(B.M_F_NAME,' ',IFNULL(B.M_L_NAME,'')) LIKE '%".$this->getSearchKey()."%'			";
				break;
			}
		}

		if ($this->getSearchPointType()){
			$query .= " AND A.PT_TYPE ='".$this->getSearchPointType()."'	";
		}

		
		return $db->getCount($query);
		
	}
	

	function getPointListEx($db, $op, $param)
	{
		global $SHOP_MEMBER_GROUP_NOT_IN;
		$column['OP_LIST']			= "*";
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "*";

		if($param['COLUMN_DETAIL'] == "Y"):
			$column['OP_LIST']		 = "";
			$column['OP_LIST']		.= "  PT.*";
			$column['OP_LIST']		.= ", M.M_ID";
			$column['OP_LIST']		.= ", M.M_MAIL";
			$column['OP_LIST']		.= ", CONCAT(IFNULL(M.M_F_NAME,''),' ',IFNULL(M.M_L_NAME,'')) M_NAME";
			$column['OP_LIST']		.= ", GET_COMM_CODE('POINT',PT.PT_TYPE) POINT_TYPE_NM";
			$column['OP_LIST']		.= ", MR.M_ID M_RECEIVE_ID	";	
			$column['OP_LIST']		.= ", CONCAT(IFNULL(MR.M_F_NAME,''),' ',IFNULL(MR.M_L_NAME,'')) M_RECEIVE_NAME";
		endif;

		if(!$op)			{ return; }

		if($param['MEMBER_MGR_JOIN'] == "Y"):
			$joinFrom				= TBL_MEMBER_MGR;
			$join1					= "LEFT OUTER JOIN {$joinFrom} AS M ON M.M_NO = PT.M_NO";
		endif;

		## 회원소속검색
//		if($param['M_CATE']):
//			$join2From  = "SELECT                   ";
//			$join2From .= "    M_NO                 ";
//			$join2From .= "FROM ".TBL_MEMBER_CATE." ";
//			$join2From .= "WHERE C_CODE LIKE '".$param['M_CATE']."%'	";
//			$join2From .= "GROUP BY M_NO            ";
//
//			$join2		= "JOIN ({$join2From}) AS MC ON MC.M_NO = PT.M_NO";	
//		endif;

		## 회원소속검색(부관리자일때 자기가 속한 소속만 보이도록 처리)
		if($param['M_CATE']):

			$join2Where			= "";

			if(!is_array($param['M_CATE'])) { 
					$temp					= $param['M_CATE'];
					$param['M_CATE']		= "";
					$param['M_CATE'][]		= $temp;
			}

			foreach($param['M_CATE'] as $key => $data):
				if($join2Where) { $join2Where .= " OR"; }
				$join2Where		= "{$join2Where} MC2.C_CODE LIKE ('{$data}%')";
			endforeach;

			if($join2Where) { $join2Where = "AND ({$join2Where})"; }

			if($param['SEARCH_CATE']):
				$join2Where = "{$join2Where} AND C_CODE LIKE '{$param['SEARCH_CATE']}%'";
			endif;

			$join2Query			= "SELECT MC2.M_NO FROM MEMBER_CATE AS MC2 WHERE MC2.M_NO IS NOT NULL {$join2Where} GROUP BY MC2.M_NO";
			$join2				= "JOIN ({$join2Query}) AS MC ON MC.M_NO = PT.M_NO";		
			
		endif;

		## 회원소속검색(부관리자일때 자기가 속한 소속만 보이도록 처리)
// 2013.12.20 kim hee sung 소스 정리.
//		if($param['M_CATE']):
//			
//			$join2From  = "SELECT                   ";
//			$join2From .= "    M_NO                 ";
//			$join2From .= "FROM ".TBL_MEMBER_CATE." ";
//			
//			$aryMemberJoinCate  = $param['M_CATE']; 
//			$join2From .= "WHERE ";
//			if (is_array($aryMemberJoinCate)){
//				$join3Where			.= "(";
//				foreach($aryMemberJoinCate as $key => $val):
//					$join3Where .= " C_CODE LIKE '".$val."%' OR";
//				endforeach;
//				
//				$join3Where = SUBSTR($join3Where,0,STRLEN($join3Where)-2);
//				$join3Where			.= ")";
//			
//			} else {
//				$join3Where .= "C_CODE LIKE '".$param['M_CATE']."%'	";
//			}
//
//			$join2From .= $join3Where;
//			$join2From .= "GROUP BY M_NO            ";
//
//			$join2		= "JOIN ({$join2From}) AS MC ON MC.M_NO = PT.M_NO";			
//		endif;

		## 포인트 준 회원검색
		$join3  = "LEFT OUTER JOIN ".TBL_MEMBER_MGR." MR	";
		$join3 .= "ON PT.PT_REG_NO = MR.M_NO				";

		$from	= TBL_POINT_MGR;
		$query	= "SELECT {$column[$op]} FROM {$from} AS PT";
		$where	= "WHERE PT.PT_NO IS NOT NULL";

		## 시작일 검색
		if($param['PT_START_DT_BETWEEN'][0] && $param['PT_START_DT_BETWEEN'][1]):
			$param['PT_START_DT_BETWEEN'][0]		= mysql_real_escape_string($param['PT_START_DT_BETWEEN'][0]);
			$param['PT_START_DT_BETWEEN'][1]		= mysql_real_escape_string($param['PT_START_DT_BETWEEN'][1]);
			$where		= "{$where} AND PT.PT_START_DT BETWEEN '{$param['PT_START_DT_BETWEEN'][0]}' AND '{$param['PT_START_DT_BETWEEN'][1]}'";
		endif;

		## 종료일 검색
		if($param['PT_END_DT_BETWEEN'][0] && $param['PT_END_DT_BETWEEN'][1]):
			$param['PT_END_DT_BETWEEN'][0]		= mysql_real_escape_string($param['PT_END_DT_BETWEEN'][0]);
			$param['PT_END_DT_BETWEEN'][1]		= mysql_real_escape_string($param['PT_END_DT_BETWEEN'][1]);
			$where		= "{$where} AND PT.PT_END_DT BETWEEN '{$param['PT_END_DT_BETWEEN'][0]}' AND '{$param['PT_END_DT_BETWEEN'][1]}'";
		endif;

		## 성별
		if($param['M_SEX']):
			$where		= "{$where} AND M.M_SEX = '{$param['M_SEX']}'";
		endif;

		## 적립금
		if($param['PT_POINT_BETWEEN'][0] && $param['PT_POINT_BETWEEN'][1]):
			$where		= "{$where} AND PT.PT_POINT BETWEEN {$param['PT_POINT_BETWEEN'][0]} AND {$param['PT_POINT_BETWEEN'][1]}";
		endif;

		## 생년월일(월)
		if($param['M_BIRTH_M']):
			$where		= "{$where} AND DATE_FORMAT(M.M_BIRTH, '%m') = {$param['M_BIRTH_M']}";
		endif;

		## 생년월일(일)
		if($param['M_BIRTH_D']):
			$where		= "{$where} AND DATE_FORMAT(M.M_BIRTH, '%d') = {$param['M_BIRTH_D']}";
		endif;

		## 포인트 종류
		if($param['PT_TYPE']):
			$where		= "{$where} AND PT.PT_TYPE = '{$param['PT_TYPE']}'";
		endif;

		## 키워드 검색
		if($param['SEARCH_QUERY']):
			$where		= "{$where} AND ({$param['SEARCH_QUERY']})";
		endif;

		## 리스트에 보여지지 않는 그룹
		if ($SHOP_MEMBER_GROUP_NOT_IN) {
			$where		= "{$where} AND M.M_GROUP NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")		";
		}

		## 정렬
		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		## 범위
		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$join1} {$join2} {$join3} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getPointSumListEx($db, $op, $param)
	{
		global $SHOP_MEMBER_GROUP_NOT_IN;
//		$column['OP_LIST']			= "  SUM(PT.PT_POINT) TOT_POINT
//										,SUM(CASE WHEN O.O_STATUS = 'E' THEN O.O_TOT_CUR_SPRICE ELSE 0 END) TOT_ORDER_PRICE1
//										,SUM(CASE WHEN O.O_STATUS NOT IN ('C','S','R','T') THEN O.O_TOT_CUR_SPRICE ELSE 0 END) TOT_ORDER_PRICE2		
//		";
		$column['OP_LIST']			= "  SUM(PT.PT_POINT) TOT_POINT";

		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "  SUM(PT.PT_POINT) TOT_POINT";

		if(!$op)			{ return; }

		if($param['MEMBER_MGR_JOIN'] == "Y"):
			$joinFrom				= TBL_MEMBER_MGR;
			$join1					= "LEFT OUTER JOIN {$joinFrom} AS M ON M.M_NO = PT.M_NO";
		endif;

		## 회원소속검색
		if($param['M_CATE']):
			$join2From  = "SELECT                   ";
			$join2From .= "    M_NO                 ";
			$join2From .= "FROM ".TBL_MEMBER_CATE." ";
			$join2From .= "WHERE C_CODE LIKE '".$param['M_CATE']."%'	";
			$join2From .= "GROUP BY M_NO            ";

			$join2		= "JOIN ({$join2From}) AS MC ON MC.M_NO = PT.M_NO";	
		endif;

//		$join3From	 = TBL_ORDER_MGR;
//		$join3		 = "LEFT OUTER JOIN {$join3From} AS O ON PT.O_NO = O.O_NO			";
//		$join3		.= " AND O.O_STATUS IN ('J','O','A','B','I','D','E','C','R','T')		";

		$from	= TBL_POINT_MGR;
		$query	= "SELECT {$column[$op]} FROM {$from} AS PT";
		$where	= "WHERE PT.PT_NO IS NOT NULL";

		## 시작일 검색
		if($param['PT_START_DT_BETWEEN'][0] && $param['PT_START_DT_BETWEEN'][1]):
			$param['PT_START_DT_BETWEEN'][0]		= mysql_real_escape_string($param['PT_START_DT_BETWEEN'][0]);
			$param['PT_START_DT_BETWEEN'][1]		= mysql_real_escape_string($param['PT_START_DT_BETWEEN'][1]);
			$where		= "{$where} AND PT.PT_START_DT BETWEEN '{$param['PT_START_DT_BETWEEN'][0]}' AND '{$param['PT_START_DT_BETWEEN'][1]}'";
		endif;

		## 종료일 검색
		if($param['PT_END_DT_BETWEEN'][0] && $param['PT_END_DT_BETWEEN'][1]):
			$param['PT_END_DT_BETWEEN'][0]		= mysql_real_escape_string($param['PT_END_DT_BETWEEN'][0]);
			$param['PT_END_DT_BETWEEN'][1]		= mysql_real_escape_string($param['PT_END_DT_BETWEEN'][1]);
			$where		= "{$where} AND PT.PT_END_DT BETWEEN '{$param['PT_END_DT_BETWEEN'][0]}' AND '{$param['PT_END_DT_BETWEEN'][1]}'";
		endif;

		## 성별
		if($param['M_SEX']):
			$where		= "{$where} AND M.M_SEX = '{$param['M_SEX']}'";
		endif;

		## 적립금
		if($param['PT_POINT_BETWEEN'][0] && $param['PT_POINT_BETWEEN'][1]):
			$where		= "{$where} AND PT.PT_POINT BETWEEN {$param['PT_POINT_BETWEEN'][0]} AND {$param['PT_POINT_BETWEEN'][1]}";
		endif;

		## 생년월일(월)
		if($param['M_BIRTH_M']):
			$where		= "{$where} AND DATE_FORMAT(M.M_BIRTH, '%m') = {$param['M_BIRTH_M']}";
		endif;

		## 생년월일(일)
		if($param['M_BIRTH_D']):
			$where		= "{$where} AND DATE_FORMAT(M.M_BIRTH, '%d') = {$param['M_BIRTH_D']}";
		endif;

		## 포인트 종류
		if($param['PT_TYPE']):
			$where		= "{$where} AND PT.PT_TYPE = '{$param['PT_TYPE']}'";
		endif;

		## 키워드 검색
		if($param['SEARCH_QUERY']):
			$where		= "{$where} AND ({$param['SEARCH_QUERY']})";
		endif;

		## 리스트에 보여지지 않는 그룹
		if ($SHOP_MEMBER_GROUP_NOT_IN) {
			$where		= "{$where} AND M.M_GROUP NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")		";
		}

		## 정렬
		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		## 범위
		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$join1} {$join2} {$join3} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}
	
	function getPointCateSum($db,$op,$param)
	{
		$query  = "SELECT								";
		$query .= "    SUM(A.PT_POINT) TOT_CATE_POINT	";
		$query .= "FROM ".TBL_POINT_MGR." A             ";
		$query .= "WHERE A.M_NO IN						";
		$query .= "(									";
		$query .= "    SELECT							";
		$query .= "        C_M_NO						";
		$query .= "    FROM ".TBL_MEMBER_CATE_MGR." A   ";
		$query .= "    WHERE A.C_CODE LIKE '".$param['M_CATE']."%'  ";
		$query .= ")                                  ";
		
		return $this->getSelectQuery($db, $query, $op);
	}

	function getPointList($db,$op="OP_LIST") 
	{
		$column['OP_LIST']		= "a.*, b.M_ID, CONCAT(b.M_F_NAME,' ',IFNULL(b.M_L_NAME,'')) M_NAME, GET_COMM_CODE('POINT',a.PT_TYPE) POINT_TYPE_NM";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "a.*, b.M_ID, CONCAT(b.M_F_NAME,' ',IFNULL(b.M_L_NAME,'')) M_NAME, GET_COMM_CODE('POINT',a.PT_TYPE) POINT_TYPE_NM";
		$column['OP_SUM']		= "SUM(a.PT_POINT) AS PT_POINT";

		$query			= "SELECT %s FROM %s AS a ";
		$query			= sprintf($query, $column[$op], TBL_POINT_MGR);

		$queryJoin		= "%s JOIN %s AS b ON a.M_NO = b.M_NO";
		$query			= sprintf($queryJoin, $query, TBL_MEMBER_MGR);

		$queryWhere		= "%s WHERE a.PT_NO IS NOT NULL";
		$query			= sprintf($queryWhere, $query);

		// 회원ID
		if ($this->getM_NO()) :
			$query		= sprintf("%s AND a.M_NO = %d", $query, $this->getM_NO());
		endif;
		
		// 회원ID , 회원 이름
		if ($this->getSearchField() && $this->getSearchKey()):
			$querySearchField['I'] = "%s AND b.M_ID LIKE '%%%s%%'";
			$querySearchField['N'] = "%s AND CONCAT(b.M_F_NAME,' ',IFNULL(b.M_L_NAME,'')) LIKE '%%%s%%'";
			$query = sprintf($querySearchField[$this->getSearchField()], $query, $this->getSearchKey());
		endif;

		// 포인트 등록일
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()) :
			$query = sprintf("%s AND a.PT_START_DT BETWEEN DATE_FORMAT('%s','%%Y-%%m-%%d 00:00:00') AND DATE_FORMAT('%s', '%%Y-%%m-%%d 23:59:59')", $query, $this->getSearchRegStartDt(), $this->getSearchRegEndDt()); 
		elseif($this->getSearchRegStartDt()):
			$query = sprintf("%s AND a.PT_START_DT >= DATE_FORMAT('%s','%%Y-%%m-%%d 00:00:00')", $query, $this->getSearchRegStartDt()); 
		elseif($this->getSearchRegEndDt()):
			$query = sprintf("%s AND a.PT_START_DT <= DATE_FORMAT('%s','%%Y-%%m-%%d 00:00:00')", $query, $this->getSearchRegEndDt()); 
		endif;

		// 포인트 소멸일
		if ($this->getSearchExpStartDt() && $this->getSearchExpEndDt()) :
			$query = sprintf("%s AND a.PT_END_DT BETWEEN DATE_FORMAT('%s','%%Y-%%m-%%d 00:00:00') AND DATE_FORMAT('%s', '%%Y-%%m-%%d 23:59:59')", $query, $this->getSearchExpStartDt(), $this->getSearchExpEndDt()); 
		elseif($this->getSearchExpStartDt()):
			$query = sprintf("%s AND a.PT_END_DT >= DATE_FORMAT('%s','%%Y-%%m-%%d 00:00:00')", $query, $this->getSearchExpStartDt()); 
		elseif($this->getSearchExpEndDt()):
			$query = sprintf("%s AND a.PT_END_DT <= DATE_FORMAT('%s','%%Y-%%m-%%d 00:00:00')", $query, $this->getSearchExpEndDt()); 
		endif;

		// 성별
		if($this->getSearchSex() == "M" || $this->getSearchSex() == "W") :
			$query = sprintf("%s AND b.M_SEX = '%s'", $query, $this->getSearchSex());
		endif;
		
		// 적립금
		if ($this->getSearchPointStart() && $this->getSearchPointEnd()) :
			$query = sprintf("%s AND a.PT_POINT BETWEEN %d AND %d", $query, $this->getSearchPointStart(), $this->getSearchPointEnd()); 
		elseif($this->getSearchPointStart()):
			$query = sprintf("%s AND a.PT_POINT >= %d", $query, $this->getSearchPointStart()); 
		elseif($this->getSearchPointEnd()):
			$query = sprintf("%s AND a.PT_POINT <= %d", $query, $this->getSearchPointEnd()); 
		endif;

		// 생년월일(월)
		if($this->getSearchBirthMonth()) :
			$query = sprintf("%s AND DATE_FORMAT(b.M_BIRTH, '%%m') = %d", $query, $this->getSearchBirthMonth());
		endif;

		// 생년월일(일)
		if($this->getSearchBirthDay()) :
			$query = sprintf("%s AND DATE_FORMAT(b.M_BIRTH, '%%d') = %d", $query, $this->getSearchBirthDay());
		endif;

		// 포인트 종류
		if ($this->getSearchPointType()):
			$query = sprintf("%s and a.PT_TYPE = '%s'", $query, $this->getSearchPointType());
		endif;

		if($this->getPageLine() && $op !="OP_SUM") :
			$query = sprintf("%s ORDER BY a.PT_NO DESC LIMIT %d, %d", $query, $this->getLimitFirst(), $this->getPageLine());
		endif;

		return $this->getSelectQuery($db, $query, $op);
	}


/*-- 구버전
	function getPointList($db)
	{
		$query  = "SELECT													";
		$query .= "     A.*													";
		$query .= "    ,B.M_ID												";
		$query .= "    ,CONCAT(B.M_F_NAME,' ',IFNULL(B.M_L_NAME,'')) M_NAME	";
		$query .= "    ,GET_COMM_CODE('POINT',A.PT_TYPE) POINT_TYPE_NM		";
		$query .= "FROM ".TBL_POINT_MGR." A                             ";
		$query .= "JOIN ".TBL_MEMBER_MGR." B							";
		$query .= "ON A.M_NO = B.M_NO									";
		$query .= "WHERE A.PT_NO IS NOT NULL							";

		if ($this->getM_NO()){
			$query .= " AND A.M_NO = ".$this->getM_NO()."	";
		}
	
		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	B.M_ID LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	CONCAT(B.M_F_NAME,' ',IFNULL(B.M_L_NAME,'')) LIKE '%".$this->getSearchKey()."%'			";
				break;
			}
		}

		if ($this->getSearchPointType()){
			$query .= " AND A.PT_TYPE ='".$this->getSearchPointType()."'	";
		}

		$query .= "	ORDER BY A.PT_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
		return $db->getExecSql($query);
		
	}
--*/
	
	function getMemberView($db,$param)
	{
		$query  = "SELECT A.* ";
		$query .= "FROM ".TBL_MEMBER_MGR." A				";
		$query .= "WHERE A.M_NO = {$param['RECEIVE_M_NO']}	";
		return $db->getSelect($query);
	}

	/********************************** Insert **********************************/
	function getPointInsert($db)
	{
		$query = "CALL SP_POINT_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getB_NO();
		$param[]  = $this->getO_NO();
		$param[]  = $this->getPT_TYPE();
		$param[]  = $this->getPT_POINT();
		$param[]  = $this->getPT_MEMO();
		$param[]  = $this->getPT_START_DT();
		$param[]  = $this->getPT_END_DT();
		$param[]  = $this->getPT_REG_IP();
		$param[]  = $this->getPT_ETC();
		$param[]  = $this->getPT_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getHistoryInsert($db)
	{
		$query = "CALL SP_HISTORY_MGR_I (?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getH_TAB();
		$param[]  = $this->getH_KEY();
		$param[]  = $this->getH_CODE();
		$param[]  = $this->getH_MEMO();
		$param[]  = $this->getH_TEXT();
		$param[]  = $this->getH_REG_NO();
		$param[]  = $this->getH_ADM_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Insert **********************************/
	function getUpdate($db)
	{
		$query = "CALL SP_POINT_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getPT_NO();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getB_NO();
		$param[]  = $this->getO_NO();
		$param[]  = $this->getPT_TYPE();
		$param[]  = $this->getPT_POINT();
		$param[]  = $this->getPT_MEMO();
		$param[]  = $this->getPT_START_DT();
		$param[]  = $this->getPT_END_DT();
		$param[]  = $this->getPT_REG_IP();
		$param[]  = $this->getPT_ETC();
		$param[]  = $this->getPT_REG_NO();
		$param[]  = $this->getPT_REG_DT();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************** Insert **********************************/
	function getDelete($db)
	{
		$query = "CALL SP_POINT_MGR_D (?);";
		$param[]  = $this->getPT_NO();

		return $db->executeBindingQuery($query,$param,true);
	}


	/********************************* Function ********************************/
	
	// 쿼리 선택
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
		elseif ( $op == "OP_SUM" ) :
			return $db->getSelect($query);
		else :
			return -100;
		endif;
	}

	/********************************** variable **********************************/
	function setPT_NO($PT_NO){ $this->PT_NO = $PT_NO; }		
	function getPT_NO(){ return $this->PT_NO; }		

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		

	function setB_NO($B_NO){ $this->B_NO = $B_NO; }		
	function getB_NO(){ return $this->B_NO; }		

	function setO_NO($O_NO){ $this->O_NO = $O_NO; }		
	function getO_NO(){ return $this->O_NO; }		

	function setPT_TYPE($PT_TYPE){ $this->PT_TYPE = $PT_TYPE; }		
	function getPT_TYPE(){ return $this->PT_TYPE; }		

	function setPT_POINT($PT_POINT){ $this->PT_POINT = $PT_POINT; }		
	function getPT_POINT(){ return $this->PT_POINT; }		

	function setPT_MEMO($PT_MEMO){ $this->PT_MEMO = $PT_MEMO; }		
	function getPT_MEMO(){ return $this->PT_MEMO; }		
	
	function setPT_CUR_POINT($PT_CUR_POINT){ $this->PT_CUR_POINT = $PT_CUR_POINT; }		
	function getPT_CUR_POINT(){ return $this->PT_CUR_POINT; }

	function setPT_START_DT($PT_START_DT){ $this->PT_START_DT = $PT_START_DT; }		
	function getPT_START_DT(){ return $this->PT_START_DT; }		

	function setPT_END_DT($PT_END_DT){ $this->PT_END_DT = $PT_END_DT; }		
	function getPT_END_DT(){ return $this->PT_END_DT; }		

	function setPT_REG_IP($PT_REG_IP){ $this->PT_REG_IP = $PT_REG_IP; }		
	function getPT_REG_IP(){ return $this->PT_REG_IP; }		

	function setPT_ETC($PT_ETC){ $this->PT_ETC = $PT_ETC; }		
	function getPT_ETC(){ return $this->PT_ETC; }		

	function setPT_REG_NO($PT_REG_NO){ $this->PT_REG_NO = $PT_REG_NO; }		
	function getPT_REG_NO(){ return $this->PT_REG_NO; }		

	function setPT_REG_DT($PT_REG_DT){ $this->PT_REG_DT = $PT_REG_DT; }		
	function getPT_REG_DT(){ return $this->PT_REG_DT; }		

	/*--------------------------------------------------------------*/	
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchRegStartDt($SEARCH_REG_START_DT){ $this->SEARCH_REG_START_DT = $SEARCH_REG_START_DT; }		
	function getSearchRegStartDt(){ return $this->SEARCH_REG_START_DT; }

	function setSearchRegEndDt($SEARCH_REG_END_DT){ $this->SEARCH_REG_END_DT = $SEARCH_REG_END_DT; }		
	function getSearchRegEndDt(){ return $this->SEARCH_REG_END_DT; }

	function setSearchPointType($SEARCH_POINT_TYPE){ $this->SEARCH_POINT_TYPE = $SEARCH_POINT_TYPE; }		
	function getSearchPointType(){ return $this->SEARCH_POINT_TYPE; }

	function setSearchSex($SEARCH_SEX){ $this->SEARCH_SEX = $SEARCH_SEX; }		
	function getSearchSex(){ return $this->SEARCH_SEX; }
		
	function setSearchExpStartDt($SEARCH_EXP_START_DT){ $this->SEARCH_EXP_START_DT = $SEARCH_EXP_START_DT; }		
	function getSearchExpStartDt(){ return $this->SEARCH_EXP_START_DT; }
	
	function setSearchExpEndDt($SEARCH_EXP_END_DT){ $this->SEARCH_EXP_END_DT = $SEARCH_EXP_END_DT; }		
	function getSearchExpEndDt(){ return $this->SEARCH_EXP_END_DT; }
	
	function setSearchPointStart($SEARCH_POINT_START){ $this->SEARCH_POINT_START = $SEARCH_POINT_START; }		
	function getSearchPointStart(){ return $this->SEARCH_POINT_START; }
	
	function setSearchPointEnd($SEARCH_POINT_END){ $this->SEARCH_POINT_END = $SEARCH_POINT_END; }		
	function getSearchPointEnd(){ return $this->SEARCH_POINT_END; }

	function setSearchBirthMonth($SEARCH_BIRTH_MONTH){ $this->SEARCH_BIRTH_MONTH = $SEARCH_BIRTH_MONTH; }		
	function getSearchBirthMonth(){ return $this->SEARCH_BIRTH_MONTH; }

	function setSearchBirthDay($SEARCH_BIRTH_DAY){ $this->SEARCH_BIRTH_DAY = $SEARCH_BIRTH_DAY; }		
	function getSearchBirthDay(){ return $this->SEARCH_BIRTH_DAY; }

	/*--------------------------------------------------------------*/	
	function setH_NO($H_NO){ $this->H_NO = $H_NO; }		
	function getH_NO(){ return $this->H_NO; }		

	function setH_TAB($H_TAB){ $this->H_TAB = $H_TAB; }		
	function getH_TAB(){ return $this->H_TAB; }		

	function setH_KEY($H_KEY){ $this->H_KEY = $H_KEY; }		
	function getH_KEY(){ return $this->H_KEY; }		

	function setH_CODE($H_CODE){ $this->H_CODE = $H_CODE; }		
	function getH_CODE(){ return $this->H_CODE; }		

	function setH_MEMO($H_MEMO){ $this->H_MEMO = $H_MEMO; }		
	function getH_MEMO(){ return $this->H_MEMO; }		

	function setH_TEXT($H_TEXT){ $this->H_TEXT = $H_TEXT; }		
	function getH_TEXT(){ return $this->H_TEXT; }		

	function setH_REG_NO($H_REG_NO){ $this->H_REG_NO = $H_REG_NO; }		
	function getH_REG_NO(){ return $this->H_REG_NO; }		

	function setH_ADM_NO($H_ADM_NO){ $this->H_ADM_NO = $H_ADM_NO; }		
	function getH_ADM_NO(){ return $this->H_ADM_NO; }		

	function setH_REG_DT($H_REG_DT){ $this->H_REG_DT = $H_REG_DT; }		
	function getH_REG_DT(){ return $this->H_REG_DT; }		


	/********************************** variable **********************************/

}
?>