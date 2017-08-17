<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-06-04												|# 
#|작성내용	: 회원관리													|# 
#/*====================================================================*/# 

## JI_GB 네이밍 정의

$aryJI_GB_Naming = array(
							"user"			=> "U", // 유저 정보
							"business"		=> "S", // 회사 정보
							"country"		=> "F", // 나라 정보
							"add"			=> "A", // 추가 정보
							"temp"			=> "T", // 임시 정보
							"family"		=> "M", // 가족 정보
						 );


class MemberMgr
{
	private $query;
	private $param;

	/********************************** List **********************************/
	function getMemberListEx($db, $op, $param)
	{
//		global $SHOP_MEMBER_GROUP_NOT_IN;

		$column['OP_LIST']			= "*";
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "*";

		if(!$op)			{ return; }

		if($param['MEMBER_COLUMN_DETAIL'] == "Y"):
			$select1From			 = TBL_COUPON_ISSUE;
			$column['OP_LIST']		 = "";
			$column['OP_LIST']		.= "  M.*";
			$column['OP_LIST']		.= ", G.G_NAME";
			$column['OP_LIST']		.= ", CONCAT(M2.M_F_NAME,'',M2.M_L_NAME) M_REC_NAME";
			$column['OP_LIST']		.= ", CONCAT(M.M_F_NAME,'',M.M_L_NAME) M_NAME";
			$column['OP_LIST']		.= ", (SELECT COUNT(*) FROM {$select1From} WHERE M_NO = M.M_NO) M_COUPON_CNT";
			$column['OP_LIST']		.= ", (DATEDIFF(NOW(),M.M_OUT_DT)) M_OUT_DAY";
			
			if($param['ORDER_MGR_JOIN'] == "Y"):
				$column['OP_LIST']		 = "{$column['OP_LIST']}, OM.OM_TOT_CNT, OM.OM_TOT_PRICE ";
			endif;

		endif;
		$from	= TBL_MEMBER_MGR;
		$query	= "SELECT {$column[$op]} FROM {$from} AS M";
		$where	= "WHERE M.M_NO IS NOT NULL AND M.M_NO <> 1";

		## 그룹 조인
		if($param['MEMBER_GROUP_JOIN'] == "Y"):
			$join1From			= TBL_MEMBER_GROUP;
			$join1				= "LEFT JOIN {$join1From} AS G ON G.G_CODE = M.M_GROUP";	
		endif;

		## 셀프 조인
		if($param['MEMBER_MGR_SELF_JOIN'] == "Y"):
			$join2From			= TBL_MEMBER_MGR;
			$join2				= "LEFT JOIN {$join2From} AS M2 ON M.M_REC_ID = M2.M_NO";	
		endif;

		## 추가 검색 조인
		if($param['MEMBER_ADD_MGR_JOIN'] == "Y"):
			$join4From			= TBL_MEMBER_ADD;
			$join4				= "LEFT JOIN {$join4From} AS MA ON M.M_NO = MA.M_NO";	
		endif;

		## 회원소속검색(부관리자일때 자기가 속한 소속만 보이도록 처리)
		if($param['M_CATE']):

			$join3Where			= "";

			if(!is_array($param['M_CATE'])) { 
					$temp					= $param['M_CATE'];
					$param['M_CATE']		= "";
					$param['M_CATE'][]		= $temp;
			}

			foreach($param['M_CATE'] as $key => $data):
				if($join3Where) { $join3Where .= " OR"; }
				$join3Where		= "{$join3Where} MC2.C_CODE LIKE ('{$data}%')";
			endforeach;

			if($join3Where) { $join3Where = "AND ({$join3Where})"; }

			if($param['SEARCH_CATE']):
				$join3Where = "{$join3Where} AND C_CODE LIKE '{$param['SEARCH_CATE']}%'";
			endif;

			$join3Query			= "SELECT MC2.M_NO FROM MEMBER_CATE AS MC2 WHERE MC2.M_NO IS NOT NULL {$join3Where} GROUP BY MC2.M_NO";
			$join3				= "JOIN ({$join3Query}) AS MC ON MC.M_NO = M.M_NO";		
			
		endif;

// 2013.12.20 kim hee sung 소스 정리.
//		if($param['M_CATE']):
//			
//			$join3From  = "SELECT                   ";
//			$join3From .= "    M_NO                 ";
//			$join3From .= "FROM ".TBL_MEMBER_CATE." ";
//			
//			$aryMemberJoinCate  = $param['M_CATE']; 
//			$join3From .= "WHERE ";
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
//			$join3From .= $join3Where;
//			$join3From .= "GROUP BY M_NO            ";
//
//			$join3		= "JOIN ({$join3From}) AS MC ON MC.M_NO = M.M_NO";			
//		endif;

		## 2013.12.10 kim hee sung 기간내에 주문 건수 회원만 출력
		if($param['ORDER_MGR_JOIN'] == "Y"):
			
			$join5Where				 = "WHERE OM1.O_NO IS NOT NULL";

			## 주문상태
			if($param['O_STATUS']):
				$join5Where			 = "{$join5Where} AND OM1.O_STATUS = '{$param['O_STATUS']}'";			
			endif;

			## 결제승인일자
			if($param['O_REG_DT_BETWEEN'][0] && $param['O_REG_DT_BETWEEN'][1]):
				$param['O_REG_DT_BETWEEN'][0]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][0]);
				$param['O_REG_DT_BETWEEN'][1]		= mysql_real_escape_string($param['O_REG_DT_BETWEEN'][1]);
				$join5Where			 = "{$join5Where} AND OM1.O_REG_DT BETWEEN DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['O_REG_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
			endif;

			$join5Query				 = "SELECT OM1.M_NO, COUNT(*) AS OM_TOT_CNT,SUM(OM1.O_TOT_CUR_SPRICE) OM_TOT_PRICE FROM ORDER_MGR AS OM1 {$join5Where} GROUP BY OM1.M_NO";
			
			$join5					 = "JOIN ( {$join5Query} ) AS OM ON OM.M_NO = M.M_NO"; 

		endif;
		
		## 탈퇴
		if ($param['M_OUT'] == "Y"):
			$where = "{$where} AND M.M_OUT = 'Y'	";
		else:
			$where = "{$where} AND IFNULL(M.M_OUT,'N') != 'Y'	";
		endif;

		## 가입일
		if($param['M_REG_DT_BETWEEN'][0] && $param['M_REG_DT_BETWEEN'][1]):
			$param['M_REG_DT_BETWEEN'][0]		= mysql_real_escape_string($param['M_REG_DT_BETWEEN'][0]);
			$param['M_REG_DT_BETWEEN'][1]		= mysql_real_escape_string($param['M_REG_DT_BETWEEN'][1]);
			$where		= "{$where} AND M.M_REG_DT BETWEEN DATE_FORMAT('{$param['M_REG_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['M_REG_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
		endif;

		## 최종로그인
		if($param['M_LOGIN_DT_BETWEEN'][0] && $param['M_LOGIN_DT_BETWEEN'][1]):
			$param['M_LOGIN_DT_BETWEEN'][0]		= mysql_real_escape_string($param['M_LOGIN_DT_BETWEEN'][0]);
			$param['M_LOGIN_DT_BETWEEN'][1]		= mysql_real_escape_string($param['M_LOGIN_DT_BETWEEN'][1]);
			$where		= "{$where} AND M.M_LOGIN_DT BETWEEN DATE_FORMAT('{$param['M_LOGIN_DT_BETWEEN'][0]}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$param['M_LOGIN_DT_BETWEEN'][1]}','%Y-%m-%d 23:59:59')";
		endif;

		## 방문횟수
		if($param['M_VISIT_CNT_BETWEEN'][0] || $param['M_VISIT_CNT_BETWEEN'][1]):
			$where		= "{$where} AND M.M_VISIT_CNT BETWEEN {$param['M_VISIT_CNT_BETWEEN'][0]} AND {$param['M_VISIT_CNT_BETWEEN'][1]}";
		endif;

		## 성별
		if($param['M_SEX']):
			$where		= "{$where} AND M.M_SEX = '{$param['M_SEX']}'";
		endif;

		## 메일수신여부
		if($param['M_MAILYN']):
			$where		= "{$where} AND M.M_MAILYN = '{$param['M_MAILYN']}'";
		endif;

		## SMS 수신여부
		if($param['M_SMSYN']):
			$where		= "{$where} AND M.M_SMSYN = '{$param['M_SMSYN']}'";
		endif;

		## 생년월일
		if($param['M_BIRTH_M']):
			$where		= "{$where} AND DATE_FORMAT(M.M_BIRTH, '%m') = {$param['M_BIRTH_M']}";
		endif;

		if($param['M_BIRTH_D']):
			$where		= "{$where} AND DATE_FORMAT(M.M_BIRTH, '%d') = {$param['M_BIRTH_D']}";
		endif;

		## 그룹
		if($param['M_GROUP_IN']):
			$where		= "{$where} AND M.M_GROUP IN ({$param['M_GROUP_IN']})";
		endif;

		## 추천인ID
		if($param['M_REC_ID']):
			$where		= "{$where} AND M.M_REC_ID = {$param['M_REC_ID']}";
		endif;
		
		## 키워드 검색
		if($param['SEARCH_QUERY']):
			$where		= "{$where} AND ({$param['SEARCH_QUERY']})";
		endif;

		## 접속 사이트 검색
		if($param['M_LNG_IN']):
			$where		= "{$where} AND M.M_LNG IN ({$param['M_LNG_IN']})";
		endif;


		## 리스트에 보여지지 않는 그룹
// 2013.08.30 kim hee sung 잘못된 사용법입니다.
// $param['M_GROUP_IN'] 을 사용하여 외부에서 처리 부탁합니다.
// 주석 차리 하기전에 사용 부분 변경 부탁합니다.
// 예)	if($SHOP_MEMBER_GROUP_NOT_IN):
//			$param['M_GROUP_NOT_IN'] = $SHOP_MEMBER_GROUP_NOT_IN;
//		endif
		if ($SHOP_MEMBER_GROUP_NOT_IN) {
			$where		= "{$where} AND M.M_GROUP NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")		";
		}

		if ($param['M_GROUP_NOT_IN']) {
			$where		= "{$where} AND M.M_GROUP NOT IN ({$param['M_GROUP_NOT_IN']})			";
		}

		## 체크된 검색 회원만 보이기
// 2013.08.30 kim hee sung 잘못된 사용법입니다.
// IN 으로 조건을 사용하려면, ***_IN 으로 param 값을 정의 해주시 바랍니다.
//		if ($param['M_NO']){
//			$where		= "{$where} AND M.M_NO IN (".$param['M_NO'].")	";
//		}

		if ($param['M_NO']){
			$where		= "{$where} AND M.M_NO = ".$param['M_NO']."	";
		}

		if ($param['M_NO_IN']){
			$where		= "{$where} AND M.M_NO IN (".$param['M_NO_IN'].")	";
		}

		## 포함된 회원 제외해서  보이기
		if ($param['NOT_M_NO']){
			$where		= "{$where} AND M.M_NO NOT IN (".$param['NOT_M_NO'].")	";
		}
		## 정렬
		switch($param['ORDER_BY']){
			case "N":	//번호
				$order_by = "ORDER BY M.M_NO ";	
			break;
			case "I":	//아이디
				$order_by = "ORDER BY M.M_ID  ";	
			break;
			case "A":	//회원명
				$order_by = "ORDER BY M.M_L_NAME  ";	
			break;
			case "G":	//그룹
				$order_by = "ORDER BY M.M_GROUP  ";	
			break;
			case "E":	//이메일
				$order_by = "ORDER BY M.M_MAIL  ";	
			break;
			case "H":	//핸드폰
				$order_by = "ORDER BY M.M_HP  ";	
			break;
			case "D":	//주소
				$order_by = "ORDER BY M.M_ADDR1  ";	
			break;
			case "P":	//포인트
				$order_by = "ORDER BY M.M_POINT  ";	
			break;
			case "O":	//구매
				$order_by = "ORDER BY M.M_BUY_PRICE  ";	
			break;	
			case "R":	//추천인
				$order_by = "ORDER BY M2.M_L_NAME  ";	
			break;
			case "T":	//가입일
				$order_by = "ORDER BY M.M_REG_DT  ";	
			break;
			case "U":	//탈퇴일
				$order_by = "ORDER BY M.M_OUT_DT  ";	
			break;

			default:
				if ($param['M_OUT'] == "Y") $order_by = "ORDER BY M.M_OUT_DT ";	
				else $order_by = "ORDER BY M.M_NO ";	
			break;
		}
		
		if ($order_by){
			if (!$param['ORDER_SORT']) $param['ORDER_SORT']  = "DESC";
			$order_by = "{$order_by} ".$param['ORDER_SORT'];
		}
		
		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$join1} {$join2} {$join3} {$join4} {$join5} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getMemberTotal($db)
	{
		global $SHOP_MEMBER_GROUP_NOT_IN;

		$query  = "SELECT							";
		$query .= "     COUNT(*)					";
		$query .= "FROM ".TBL_MEMBER_MGR." A		";
		$query .= "LEFT JOIN ".TBL_MEMBER_GROUP." B	";
		$query .= "ON A.M_GROUP = B.G_CODE			";
		if ($this->getSearchRecId()){
			$query .= "LEFT JOIN ".TBL_MEMBER_MGR." C	";
			$query .= "ON A.M_REC_ID = C.M_NO			";
		}
				
		$query .= "	WHERE A.M_NO IS NOT NULL AND A.M_NO <> 1		";

		if ($this->getSearchOut() == "Y")
		{
			$query .= " AND A.M_OUT = 'Y'	"; 
		} else {
			$query .= " AND IFNULL(A.M_OUT,'N') != 'Y'	"; 
		}

		if ($this->getSearchField() && $this->getSearchKey()){

			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	A.M_ID LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	(A.M_F_NAME LIKE '%".$this->getSearchKey()."%' OR A.M_L_NAME LIKE '%".$this->getSearchKey()."%')		";
				break;
				case "M":
					$query .= "	A.M_MAIL LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "H":
					$query .= "	A.M_HP LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;
				case "P":
					$query .= "	A.M_PHONE LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;

			}
		}

		/* 가입일 */
		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= " AND A.M_REG_DT BETWEEN DATE_FORMAT('".$this->getSearchRegStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchRegEndDt()."','%Y-%m-%d 23:59:59') ";
		}

		/* 최종로그인 */
		if ($this->getSearchLastLoginStartDt() && $this->getSearchLastLoginEndDt()){
			$query .= " AND A.M_LOGIN_DT BETWEEN DATE_FORMAT('".$this->getSearchLastLoginStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchLastLoginEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		
		/* 방문횟수 */
		if ($this->getSearchVisitStartCnt() > 0 && $this->getSearchVisitEndCnt() > 0){
			$query .= " AND A.M_VISIT_CNT BETWEEN ".$this->getSearchVisitStartCnt()." AND ".$this->getSearchVisitEndCnt()."	";
		}

		/* 성별 */
		if ($this->getSearchSex() && $this->getSearchSex() != "T"){
			$query .= " AND A.M_SEX = '".$this->getSearchSex()."'	";
		}

		/* 메일수신여부 */
		if ($this->getSearchMailYN() && $this->getSearchMailYN() != "T"){
			$query .= " AND A.M_MAILYN = '".$this->getSearchMailYN()."'	";
		}

		/* SMS 수신여부 */
		if ($this->getSearchSmsYN() && $this->getSearchSmsYN() != "T"){
			$query .= " AND A.M_SMSYN = '".$this->getSearchSmsYN()."'	";
		}

		/* 생년월일 */
		if ($this->getSearchBirth()){
			$query .= " AND SUBSTRING(A.M_BIRTH,6) = '".$this->getSearchBirth()."'	";
		}

		/* 추천인ID */
		if ($this->getSearchRecId()){
			$query .= " AND CONCAT(C.M_F_NAME,C.M_L_NAME) LIKE  '%".$this->getSearchRecId()."%'	";
		}

		/* 탈퇴 및 삭제일 */
		if ($this->getSearchOutStartDt() && $this->getSearchOutEndDt()){
			$query .= " AND A.M_OUT_DT BETWEEN DATE_FORMAT('".$this->getSearchOutStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchOutEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		
		/* 그룹 */
		if ($this->getSearchGroup()){
			$query .= " AND A.M_GROUP IN (".$this->getSearchGroup().")	";
		}

		/* tm 회원 */
		if ($this->getSearchTmId()){
			$query .= " AND A.M_TM_ID = '".$this->getSearchTmId()."'	";
		} 

		## 리스트에 보여지지 않는 그룹
		if ($SHOP_MEMBER_GROUP_NOT_IN && (!$this->getSearchGroupNotView() || $this->getSearchGroupNotView() == "N")) {
			$query .= " AND A.M_GROUP NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")	";
		}
		
		return $db->getCount($query);
	}


	function getMemberList($db)
	{
		global $SHOP_MEMBER_GROUP_NOT_IN;
		$query  = "SELECT							";
		$query .= "     A.*							";
		$query .= "    ,B.G_NAME					";
		$query .= "    ,CONCAT(IFNULL(C.M_F_NAME,''),'',IFNULL(C.M_L_NAME,'')) M_REC_NAME ";
		$query .= "    ,CONCAT(IFNULL(A.M_F_NAME,''),'',IFNULL(A.M_L_NAME,'')) M_NAME ";
		$query .= "    ,(SELECT COUNT(*) FROM ".TBL_COUPON_ISSUE." WHERE M_NO = A.M_NO) M_COUPON_CNT ";
		$query .= "	   ,(DATEDIFF(NOW(),A.M_OUT_DT)) M_OUT_DAY ";
		$query .= "FROM ".TBL_MEMBER_MGR." A		";
		$query .= "LEFT JOIN ".TBL_MEMBER_GROUP." B	";
		$query .= "ON A.M_GROUP = B.G_CODE			";		
		$query .= "LEFT JOIN ".TBL_MEMBER_MGR." C	";
		$query .= "ON A.M_REC_ID = C.M_NO			";
		$query .= "WHERE A.M_NO IS NOT NULL AND A.M_NO <> 1		";
		
		if ($this->getSearchOut() == "Y")
		{
			$query .= " AND A.M_OUT = 'Y'	"; 
		} else {
			$query .= " AND IFNULL(A.M_OUT,'N') != 'Y'	"; 
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	A.M_ID LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	(A.M_F_NAME LIKE '%".$this->getSearchKey()."%' OR A.M_L_NAME LIKE '%".$this->getSearchKey()."%')		";
				break;
				case "M":
					$query .= "	A.M_MAIL LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "H":
					$query .= "	A.M_HP LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;
				case "P":
					$query .= "	A.M_PHONE LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;
			}
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= " AND A.M_REG_DT BETWEEN DATE_FORMAT('".$this->getSearchRegStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchRegEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		/* 최종로그인 */
		if ($this->getSearchLastLoginStartDt() && $this->getSearchLastLoginEndDt()){
			$query .= " AND A.M_LOGIN_DT BETWEEN DATE_FORMAT('".$this->getSearchLastLoginStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchLastLoginEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		
		/* 방문횟수 */
		if ($this->getSearchVisitStartCnt() > 0 && $this->getSearchVisitEndCnt() > 0){
			$query .= " AND A.M_VISIT_CNT BETWEEN ".$this->getSearchVisitStartCnt()." AND ".$this->getSearchVisitEndCnt()."	";
		}

		/* 성별 */
		if ($this->getSearchSex() && $this->getSearchSex() != "T"){
			$query .= " AND A.M_SEX = '".$this->getSearchSex()."'	";
		}

		/* 메일수신여부 */
		if ($this->getSearchMailYN() && $this->getSearchMailYN() != "T"){
			$query .= " AND A.M_MAILYN = '".$this->getSearchMailYN()."'	";
		}

		/* SMS 수신여부 */
		if ($this->getSearchSmsYN() && $this->getSearchSmsYN() != "T"){
			$query .= " AND A.M_SMSYN = '".$this->getSearchSmsYN()."'	";
		}

		/* 생년월일 */
		if ($this->getSearchBirth()){
			$query .= " AND SUBSTRING(A.M_BIRTH,6) = '".$this->getSearchBirth()."'	";
		}

		/* 추천인 */
		if ($this->getSearchRecId()){
			$query .= " AND CONCAT(C.M_F_NAME,C.M_L_NAME) LIKE  '%".$this->getSearchRecId()."%'	";
		}

		/* 탈퇴 및 삭제일 */
		if ($this->getSearchOutStartDt() && $this->getSearchOutEndDt()){
			$query .= " AND A.M_OUT_DT BETWEEN DATE_FORMAT('".$this->getSearchOutStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchOutEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		
		/* 그룹 */
		if ($this->getSearchGroup()){
			$query .= " AND A.M_GROUP NOT IN (".$this->getSearchGroup().")	";
		}

		/* tm 회원 */
		if ($this->getSearchTmId()){
			$query .= " AND A.M_TM_ID = '".$this->getSearchTmId()."'	";
		} 

		## 리스트에 보여지지 않는 그룹
		if ($SHOP_MEMBER_GROUP_NOT_IN && (!$this->getSearchGroupNotView() || $this->getSearchGroupNotView() == "N")) {
			$query .= " AND A.M_GROUP NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")	";
		}

		switch($this->getSearchOrderSortCol()){
			case "N":	//번호
				$query .= "ORDER BY A.M_NO ";	
			break;
			case "I":	//아이디
				$query .= "ORDER BY A.M_ID  ";	
			break;
			case "A":	//회원명
				$query .= "ORDER BY A.M_F_NAME  ";	
			break;
			case "G":	//그룹
				$query .= "ORDER BY A.M_GROUP  ";	
			break;
			case "E":	//이메일
				$query .= "ORDER BY A.M_MAIL  ";	
			break;
			case "H":	//핸드폰
				$query .= "ORDER BY A.M_HP  ";	
			break;
			case "D":	//주소
				$query .= "ORDER BY A.M_ADDR1  ";	
			break;
			case "P":	//포인트
				$query .= "ORDER BY A.M_POINT  ";	
			break;
			case "O":	//구매
				$query .= "ORDER BY A.M_BUY_PRICE  ";	
			break;	
			case "R":	//추천인
				$query .= "ORDER BY C.M_F_NAME  ";	
			break;
			case "T":	//가입일
				$query .= "ORDER BY A.M_REG_DT  ";	
			break;
			case "U":	//탈퇴일
				$query .= "ORDER BY A.M_OUT_DT  ";	
			break;

			default:
				if ($this->getSearchOut() == "Y") $query .= "ORDER BY A.M_OUT_DT ";	
				else $query .= "ORDER BY A.M_NO ";	
			break;
		}
		$query .= $this->getSearchOrderSort()." LIMIT ".$this->getLimitFirst().",".$this->getPageLine();				
		
		return $db->getExecSql($query);
	}


	function getMemberCrmSearchList($db)
	{
		global $SHOP_MEMBER_GROUP_NOT_IN;

		$query  = "SELECT							";
		$query .= "     A.M_NO id					";
		$query .= "    ,CONCAT(A.M_F_NAME,'',A.M_L_NAME,'(',A.M_ID,')') name ";
		$query .= "FROM ".TBL_MEMBER_MGR." A		";
		$query .= "WHERE A.M_NO IS NOT NULL AND A.M_NO <> 1		";
		
		if ($this->getSearchOut() == "Y")
		{
			$query .= " AND A.M_OUT = 'Y'	"; 
		} else {
			$query .= " AND IFNULL(A.M_OUT,'N') != 'Y'	"; 
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	A.M_ID LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	(A.M_F_NAME LIKE '%".$this->getSearchKey()."%' OR A.M_L_NAME LIKE '%".$this->getSearchKey()."%')		";
				break;
				case "M":
					$query .= "	A.M_MAIL LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "H":
					$query .= "	A.M_HP LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;
				case "P":
					$query .= "	A.M_PHONE LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;
			}
		}

		## 리스트에 보여지지 않는 그룹
		if ($SHOP_MEMBER_GROUP_NOT_IN) {
			$query .= " AND A.M_GROUP NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")		";
		}

		$query .= "ORDER BY A.M_NO DESC";		
		return $db->getResult($query);
	}

	function getMemberTotalCnt($db)
	{
		$query  = "SELECT                                                                                             ";
		$query .= "     COUNT(*) TOT_CNT                                                                              ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_REG_DT,1,10) = SUBSTRING(NOW(),1,10) THEN 1 ELSE 0 END) TOT_NOW_CNT ";
		$query .= "    ,SUM(CASE WHEN SUBSTRING(A.M_REG_DT,1,7) = SUBSTRING(NOW(),1,7) THEN 1 ELSE 0 END) TOT_MONTH_CNT ";
		$query .= "FROM ".TBL_MEMBER_MGR." A                                                                          ";
		$query .= "LEFT JOIN ".TBL_MEMBER_GROUP." B	";
		$query .= "ON A.M_GROUP = B.G_CODE			";		
		$query .= "LEFT JOIN ".TBL_MEMBER_MGR." C	";
		$query .= "ON A.M_REC_ID = C.M_NO			";
		$query .= "WHERE A.M_NO IS NOT NULL AND A.M_NO <> 1		";
		
		if ($this->getSearchOut() == "Y")
		{
			$query .= " AND A.M_OUT = 'Y'	"; 
		} else {
			$query .= " AND IFNULL(A.M_OUT,'N') != 'Y'	"; 
		}

		if ($this->getSearchField() && $this->getSearchKey()){
			$query .= "	AND ";
			switch ($this->getSearchField()){
				case "I":
					$query .= "	A.M_ID LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "N":
					$query .= "	(A.M_F_NAME LIKE '%".$this->getSearchKey()."%' OR A.M_L_NAME LIKE '%".$this->getSearchKey()."%')		";
				break;
				case "M":
					$query .= "	A.M_MAIL LIKE '%".$this->getSearchKey()."%'		";
				break;
				case "H":
					$query .= "	A.M_HP LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;
				case "P":
					$query .= "	A.M_PHONE LIKE '%".STR_REPLACE("-","",$this->getSearchKey())."%'		";
				break;
			}
		}

		if ($this->getSearchRegStartDt() && $this->getSearchRegEndDt()){
			$query .= " AND A.M_REG_DT BETWEEN DATE_FORMAT('".$this->getSearchRegStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchRegEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		/* 최종로그인 */
		if ($this->getSearchLastLoginStartDt() && $this->getSearchLastLoginEndDt()){
			$query .= " AND A.M_LOGIN_DT BETWEEN DATE_FORMAT('".$this->getSearchLastLoginStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchLastLoginEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		
		/* 방문횟수 */
		if ($this->getSearchVisitStartCnt() > 0 && $this->getSearchVisitEndCnt() > 0){
			$query .= " AND A.M_VISIT_CNT BETWEEN ".$this->getSearchVisitStartCnt()." AND ".$this->getSearchVisitEndCnt()."	";
		}

		/* 성별 */
		if ($this->getSearchSex() && $this->getSearchSex() != "T"){
			$query .= " AND A.M_SEX = '".$this->getSearchSex()."'	";
		}

		/* 메일수신여부 */
		if ($this->getSearchMailYN() && $this->getSearchMailYN() != "T"){
			$query .= " AND A.M_MAILYN = '".$this->getSearchMailYN()."'	";
		}

		/* SMS 수신여부 */
		if ($this->getSearchSmsYN() && $this->getSearchSmsYN() != "T"){
			$query .= " AND A.M_SMSYN = '".$this->getSearchSmsYN()."'	";
		}

		/* 생년월일 */
		if ($this->getSearchBirth()){
			$query .= " AND SUBSTRING(A.M_BIRTH,6) = '".$this->getSearchBirth()."'	";
		}

		/* 추천인 */
		if ($this->getSearchRecId()){
			$query .= " AND CONCAT(C.M_F_NAME,C.M_L_NAME) LIKE  '%".$this->getSearchRecId()."%'	";
		}

		/* 탈퇴 및 삭제일 */
		if ($this->getSearchOutStartDt() && $this->getSearchOutEndDt()){
			$query .= " AND A.M_OUT_DT BETWEEN DATE_FORMAT('".$this->getSearchOutStartDt()."','%Y-%m-%d 00:00:00') ";
			$query .= "					      AND DATE_FORMAT('".$this->getSearchOutEndDt()."','%Y-%m-%d 23:59:59') ";
		}
		
		/* 그룹 */
		if ($this->getSearchGroup()){
			$query .= " AND A.M_GROUP IN (".$this->getSearchGroup().")	";
		}

		/* tm 회원 */
		if ($this->getSearchTmId()){
			$query .= " AND A.M_TM_ID = '".$this->getSearchTmId()."'	";
		}
		
		## 리스트에 보여지지 않는 그룹
		if ($SHOP_MEMBER_GROUP_NOT_IN) {
			$query .= " AND A.M_GROUP NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")		";
		}

		return $db->getSelect($query);
	}

	function getGroupListEx($db, $op, $param)
	{
		global $SHOP_MEMBER_GROUP_NOT_IN;

		$column['OP_LIST']			= "*";
		$column['OP_COUNT']			= "COUNT(*)";
		$column['OP_SELECT']		= "*";
		$column['OP_ARYTOTAL']		= "*";

		if(!$op)			{ return; }

		if($param['G_MEMBER_CNT_COLUMN'] == "Y"):
			$columnFrom					= TBL_MEMBER_MGR;
			$column['OP_LIST']			= "G.*, (SELECT COUNT(*) FROM {$columnFrom} WHERE M_GROUP = G_CODE) AS G_MEMBER_CNT";
			$column['OP_ARYTOTAL']		= "G.*, (SELECT COUNT(*) FROM {$columnFrom} WHERE M_GROUP = G_CODE) AS G_MEMBER_CNT";
		endif;

		$from	= TBL_MEMBER_GROUP;
		$query	= "SELECT {$column[$op]} FROM {$from} AS G";
		$where	= "WHERE G.G_CODE IS NOT NULL";
		
		## 2013.06.12 입점몰은 사용 안함
		if($param['S_MALL_TYPE '] == "R"): 
			$where		= "WHERE G.G_CODE NOT IN ('003','004','005')";
		else:
			if ($SHOP_MEMBER_GROUP_NOT_IN) {
				$where		= "WHERE G.G_CODE NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")";
			}

		endif;

		if($param['ORDER_BY']):
			$order_by	= "ORDER BY {$param['ORDER_BY']}";
		endif;

		if($param['LIMIT']):
			$limit		= "LIMIT {$param['LIMIT']}";
		endif;
		
		$query = "{$query} {$where} {$order_by} {$limit}";

		return $this->getSelectQuery($db, $query, $op);
	}

	function getGroupList($db)
	{
		global $S_MALL_TYPE;
		global $SHOP_MEMBER_GROUP_NOT_IN;

		$query	= "SELECT * ";
		$query .= "	,(SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_GROUP = G_CODE) G_MEMBER_CNT		";
		$query .= "FROM ".TBL_MEMBER_GROUP."					";
		if($S_MALL_TYPE == "R"): // 2013.06.12 입점몰은 사용 안함
			$query .= "WHERE G_CODE NOT IN ('003','004','005')		";
		else:
			if ($SHOP_MEMBER_GROUP_NOT_IN) {
				$query .= "WHERE G_CODE NOT IN (".$SHOP_MEMBER_GROUP_NOT_IN.")		";
			}
		endif;
		$query .= "ORDER BY G_CODE ASC							";

		return $db->getArrayTotal($query);
	}

	function getJoinItemList($db)
	{
		$query  = "                               ";
		$query .= "SELECT *                       ";
		$query .= "FROM ".TBL_MEMBER_JOIN_ITEM."  ";

		if ($this->getJI_GB()){
			$query .= "WHERE JI_GB = '".$this->getJI_GB()."'	";
			$query .= "ORDER BY JI_ORDER ASC					";
		} else {
			$query .= "ORDER BY JI_GB ASC,JI_ORDER ASC			";
		
		}
		return $db->getArrayTotal($query);
	}
	

	function getMemberFamilyList($db)
	{
		$query  = "SELECT *									";
		$query .= "FROM ".TBL_MEMBER_FAMILY." A				";
		$query .= "WHERE A.M_NO = '".$this->getM_NO()."'	";
		$query .= "ORDER BY A.MF_NO ASC						";
		

		return $db->getArrayTotal($query);
	}

	/**
	 * 2013.05.06 회원간편검색부분에 사용
	 * SELECT * FROM MEMBER_JOIN_ITEM WHERE JI_USE IN ( 'Y', 'A') ORDER BY JI_GB ASC,JI_ORDER ASC
	 **/
	function getMemberJoinItemSelect($db, $op = "OP_LIST")
	{
		$column['OP_LIST']		= "*";
		$column['OP_COUNT']		= "COUNT(*)";
		$column['OP_SELECT']	= "*";

		$query			= "SELECT {$column[$op]} FROM MEMBER_JOIN_ITEM ";
		$where			= "WHERE JI_NO IS NOT NULL ";

		$jb_gb			= $this->getJI_GB();
		if(is_array($jb_gb)):
			$temp = "";
			foreach($jb_gb as $val):
				if($temp) { $temp = ", "; }
				$temp	= "'{$val}'";
			endforeach;
			$where	   .= "AND JI_GB IN ({$temp}) ";
		else:
			$where	   .= "AND JI_GB = '{$jb_gb}' ";
		endif;

		$orderby		= "ORDER BY JI_ORDER ASC ";
		
		$query			= $query . $where . $orderby;

		return $this->getSelectQuery($db, $query, $op);
	}

	function getMemberPointDupCnt($db,$param,$op = "OP_COUNT")
	{
		$column['OP_COUNT']		= "COUNT(*) ";
		$column['OP_SELECT']	= "*		";

		$query  = "SELECT											";
		$query .= $column[$op];
		$query .= "FROM ".TBL_POINT_MGR."							";
		$query .= "WHERE M_NO		= ".$param["M_NO"]."			";
		$query .= "    AND O_NO		= ".$param["O_NO"]."			";
		$query .= "    AND PT_TYPE	= '".$param["POINT_TYPE"]."'	";

		if ($param["POINT_ETC"]){
			$query .= "    AND PT_ETC = '".$param["POINT_ETC"]."'	";
		}

//		return $db->getCount($query);
		return $this->getSelectQuery($db, $query, $op);
	}

	/********************************** View **********************************/
	function getGroupView($db)
	{
		$query = "SELECT * FROM ".TBL_MEMBER_GROUP." WHERE G_CODE = '".mysql_real_escape_string($this->getG_CODE())."'";

		return $db->getSelect($query);
	}

	function getGroupInfo($db)
	{
		$query = "SELECT * FROM ".TBL_MEMBER_GROUP." WHERE G_CODE = '".mysql_real_escape_string($this->getG_CODE())."'";

		return $db->getArrayTotal($query);
	}

	function getGroupCodeSearch($db)
	{
		$query = "SELECT G_CODE FROM ".TBL_MEMBER_GROUP." WHERE G_NAME = '".mysql_real_escape_string($this->getG_NAME())."'";

		return $db->getCount($query);
	}


	function getSettingView($db)
	{
		$query = "SELECT * FROM ".TBL_MEMBER_JOIN;

		return $db->getSelect($query);
	}

	function getMemberView($db)
	{
		$query  = "SELECT A.*,CONCAT(IFNULL(A.M_F_NAME,''),' ',IFNULL(A.M_L_NAME,'')) M_NAME, B.* ";
		$query .= ",(SELECT CONCAT(IFNULL(A.M_F_NAME,''),' ',IFNULL(A.M_L_NAME,'')) FROM ".TBL_MEMBER_MGR." WHERE M_NO = A.M_REC_ID) M_REC_NAME	";
		$query .= ', SM.SH_COM_NAME, SM.SH_COM_NUM ';
		$query .= "FROM ".TBL_MEMBER_MGR." A ";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_ADD." B ON A.M_NO = B.M_NO ";

		//입점사 정보 추가.쿼리 남덕희 2015.09.04
		$query .= ' LEFT OUTER JOIN SHOP_USER SU ON A.M_NO = SU.M_NO';
		$query .= ' LEFT OUTER JOIN SHOP_MGR SM ON SM.SH_NO = SU.SH_NO';

		$query .= '	WHERE A.M_NO = '.$this->getM_NO();

		return $db->getSelect($query);
	}

	function getMemberInfo($db)
	{
		$query  = "SELECT A.*,B.G_LEVEL FROM ".TBL_MEMBER_MGR." A		";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_GROUP." B	";
		$query .= "ON A.M_GROUP = B.G_CODE					";

		if ($this->getM_ID()){
			$query .= "WHERE A.M_ID = '".$this->getM_ID()."'";
		}

		if ($this->getM_MAIL()){
			$query .= "WHERE A.M_MAIL = '".$this->getM_MAIL()."'";
		}

		return $db->getSelect($query);
	}


	function getMemberOrderCount($db)
	{
		$query  = "SELECT                                                               ";
		$query .= "     COUNT(*) JUMUN_CNT                                              ";
		$query .= "    ,SUM((CASE WHEN O_STATUS = 'E' THEN 1 ELSE 0 END)) DELIVERY_CNT	";
		$query .= "FROM ".TBL_ORDER_MGR." A                                             ";
		$query .= "WHERE A.M_NO = ".$this->getM_NO();
		$query .= " AND A.O_STATUS NOT IN ('F','W')										";
		return $db->getSelect($query);
	}

	/********************************** Insert **********************************/
	function getGroupCode($db)
	{
		$query  = "SELECT LPAD(IFNULL(MAX(A.G_CODE)+1,1),3,0) ";
		$query .= "	FROM ".TBL_MEMBER_GROUP." A ";

		return $db->getCount($query);
	}
		
	function getGroupInsert($db)
	{
		$query = "CALL SP_MEMBER_GROUP_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getG_CODE();
		$param[]  = $this->getG_NAME();
		$param[]  = $this->getG_SHOW();
		$param[]  = $this->getG_APPLY();
		$param[]  = $this->getG_SETTLE();
		$param[]  = $this->getG_PRICE_ST();
		$param[]  = $this->getG_ICON();
		$param[]  = $this->getG_LEVEL();
		$param[]  = $this->getG_PRICE_MIN();
		$param[]  = $this->getG_PRICE_MAX();
		$param[]  = $this->getG_BUY_CNT();
		$param[]  = $this->getG_PRODUCT_CNT();
		$param[]  = $this->getG_DISCOUNT_ST();
		$param[]  = $this->getG_DISCOUNT_PRICE();
		$param[]  = $this->getG_DISCOUNT_RATE();
		$param[]  = $this->getG_DISCOUNT_UNIT();
		$param[]  = $this->getG_DISCOUNT_OFF();
		$param[]  = $this->getG_DISCOUNT_POINT();
		$param[]  = $this->getG_POINT_PRICE();
		$param[]  = $this->getG_POINT_RATE();
		$param[]  = $this->getG_POINT_UNIT();
		$param[]  = $this->getG_POINT_OFF();
		$param[]  = $this->getG_POINT_POINT();
		$param[]  = $this->getG_ADD_DISCOUNT();
		$param[]  = $this->getG_ADD_DISCOUNT_PRICE();
		$param[]  = $this->getG_ADD_DISCOUNT_RATE();
		$param[]  = $this->getG_ADD_DISCOUNT_UNIT();
		$param[]  = $this->getG_ADD_DISCOUNT_OFF();
		$param[]  = $this->getG_ADD_DISCOUNT_POINT();
		$param[]  = $this->getG_IMG();
		$param[]  = $this->getG_FILE();
		$param[]  = $this->getG_MEMO();
		$param[]  = $this->getG_EXP_CATEGORY();
		$param[]  = $this->getG_EXP_PRODUCT();
		$param[]  = $this->getG_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberInsert($db)
	{
		$query = "CALL SP_MEMBER_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_ID();
		$param[]  = $this->getM_PASS();
		$param[]  = $this->getM_F_NAME();
		$param[]  = $this->getM_L_NAME();
		$param[]  = $this->getM_NICK_NAME();
		$param[]  = $this->getM_BIRTH_CAL();
		$param[]  = $this->getM_BIRTH();
		$param[]  = $this->getM_SEX();
		$param[]  = $this->getM_MAIL();
		$param[]  = $this->getM_PHONE();
		$param[]  = $this->getM_FAX();
		$param[]  = $this->getM_HP();
		$param[]  = $this->getM_ZIP();
		$param[]  = $this->getM_COUNTRY();
		$param[]  = $this->getM_ADDR();
		$param[]  = $this->getM_ADDR2();
		$param[]  = $this->getM_CITY();
		$param[]  = $this->getM_STATE();
		$param[]  = $this->getM_SMSYN();
		$param[]  = $this->getM_MAILYN();
		$param[]  = $this->getM_TEXT();
		$param[]  = $this->getM_REC_ID();
		$param[]  = $this->getM_GROUP();
		$param[]  = $this->getM_AUTH();
		$param[]  = $this->getM_POINT();
		
		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberAddInsert($db)
	{
		$query = "CALL SP_MEMBER_ADD_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getM_WED();
		$param[]  = $this->getM_WED_DAY();
		$param[]  = $this->getM_JOB();
		$param[]  = $this->getM_CHILD();
		$param[]  = $this->getM_COM_NM();
		$param[]  = $this->getM_BUSI_NM();
		$param[]  = $this->getM_BUSI_NUM();
		$param[]  = $this->getM_BUSI_UPJ();
		$param[]  = $this->getM_BUSI_UTE();
		$param[]  = $this->getM_BUSI_ZIP();
		$param[]  = $this->getM_BUSI_ADDR1();
		$param[]  = $this->getM_BUSI_ADDR2();
		$param[]  = $this->getM_CONCERN();
		$param[]  = $this->getM_FOREIGN();
		$param[]  = $this->getM_FOREIGN_NUM();
		$param[]  = $this->getM_PASSPORT();
		$param[]  = $this->getM_DRIVE_NUM();
		$param[]  = $this->getM_NATION();
		$param[]  = $this->getM_PHOTO();
		$param[]  = $this->getM_TMP1();
		$param[]  = $this->getM_TMP2();
		$param[]  = $this->getM_TMP3();
		$param[]  = $this->getM_TMP4();
		$param[]  = $this->getM_TMP5();

		return $db->executeBindingQuery($query,$param,true);
	}
        function getMemberAddUpdate($db)
        {
                $query = "CALL SP_MEMBER_ADD_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

                $param[]  = $this->getM_NO();
                $param[]  = $this->getM_WED();
                $param[]  = $this->getM_WED_DAY();
                $param[]  = $this->getM_JOB();
                $param[]  = $this->getM_CHILD();
                $param[]  = $this->getM_COM_NM();
                $param[]  = $this->getM_BUSI_NM();
                $param[]  = $this->getM_BUSI_NUM();
                $param[]  = $this->getM_BUSI_UPJ();
                $param[]  = $this->getM_BUSI_UTE();
                $param[]  = $this->getM_BUSI_ZIP();
                $param[]  = $this->getM_BUSI_ADDR1();
                $param[]  = $this->getM_BUSI_ADDR2();
                $param[]  = $this->getM_CONCERN();
                $param[]  = $this->getM_FOREIGN();
                $param[]  = $this->getM_FOREIGN_NUM();
                $param[]  = $this->getM_PASSPORT();
                $param[]  = $this->getM_DRIVE_NUM();
                $param[]  = $this->getM_NATION();
                $param[]  = $this->getM_PHOTO();
                $param[]  = $this->getM_TMP1();
                $param[]  = $this->getM_TMP2();
                $param[]  = $this->getM_TMP3();
                $param[]  = $this->getM_TMP4();
                $param[]  = $this->getM_TMP5();

                return $db->executeBindingQuery($query,$param,true);
        }


	/********************************** Update **********************************/
	function getGroupUpdate($db)
	{

		$query = "CALL SP_MEMBER_GROUP_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getG_CODE();
		$param[]  = $this->getG_NAME();
		$param[]  = $this->getG_SHOW();
		$param[]  = $this->getG_APPLY();
		$param[]  = $this->getG_SETTLE();
		$param[]  = $this->getG_PRICE_ST();
		$param[]  = $this->getG_ICON();
		$param[]  = $this->getG_LEVEL();
		$param[]  = $this->getG_PRICE_MIN();
		$param[]  = $this->getG_PRICE_MAX();
		$param[]  = $this->getG_BUY_CNT();
		$param[]  = $this->getG_PRODUCT_CNT();
		$param[]  = $this->getG_DISCOUNT_ST();
		$param[]  = $this->getG_DISCOUNT_PRICE();
		$param[]  = $this->getG_DISCOUNT_RATE();
		$param[]  = $this->getG_DISCOUNT_UNIT();
		$param[]  = $this->getG_DISCOUNT_OFF();
		$param[]  = $this->getG_DISCOUNT_POINT();
		$param[]  = $this->getG_POINT_PRICE();
		$param[]  = $this->getG_POINT_RATE();
		$param[]  = $this->getG_POINT_UNIT();
		$param[]  = $this->getG_POINT_OFF();
		$param[]  = $this->getG_POINT_POINT();
		$param[]  = $this->getG_ADD_DISCOUNT();
		$param[]  = $this->getG_ADD_DISCOUNT_PRICE();
		$param[]  = $this->getG_ADD_DISCOUNT_RATE();
		$param[]  = $this->getG_ADD_DISCOUNT_UNIT();
		$param[]  = $this->getG_ADD_DISCOUNT_OFF();
		$param[]  = $this->getG_ADD_DISCOUNT_POINT();
		$param[]  = $this->getG_IMG();
		$param[]  = $this->getG_FILE();
		$param[]  = $this->getG_MEMO();
		$param[]  = $this->getG_EXP_CATEGORY();
		$param[]  = $this->getG_EXP_PRODUCT();
		$param[]  = $this->getG_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	
	function getGroupIconUpdate($db)
	{
		$query	= "UPDATE ".TBL_MEMBER_GROUP." SET G_ICON = ''";
		$query .= "	WHERE G_CODE = '".mysql_real_escape_string($this->getG_CODE())."'";
	
		return $db->getExecSql($query);
	}

	function getGroupImgUpdate($db)
	{
		$query	= "UPDATE ".TBL_MEMBER_GROUP." SET G_IMG = ''";
		$query .= "	WHERE G_CODE = '".mysql_real_escape_string($this->getG_CODE())."'";
	
		return $db->getExecSql($query);
	}

	function getGroupFileUpdate($db)
	{
		$query	= "UPDATE ".TBL_MEMBER_GROUP." SET G_FILE = ''";
		$query .= "	WHERE G_CODE = '".mysql_real_escape_string($this->getG_CODE())."'";
	
		return $db->getExecSql($query);
	}

	function getSettingUpdate($db)
	{
		$query = "CALL SP_MEMBER_JOIN_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getJ_CERITY();
		$param[]  = $this->getJ_RE_DAY();
		$param[]  = $this->getJ_NO_ID();
		$param[]  = $this->getJ_POINT();
		$param[]  = $this->getJ_COUPON();
		$param[]  = $this->getJ_GROUP();
		$param[]  = $this->getJ_REC_POINT1();
		$param[]  = $this->getJ_REC_POINT2();
		$param[]  = $this->getJ_JUMIN();
		$param[]  = $this->getJ_IPIN();
		$param[]  = $this->getJ_GROUP_VIEW();
		$param[]  = $this->getJ_PHONE();
		$param[]  = $this->getJ_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberUpdate($db)
	{
		
		$query  = "UPDATE ".TBL_MEMBER_MGR." SET ";
		$query .= "  M_MAIL		= '".mysql_real_escape_string($this->getM_MAIL())."'";
		$query .= " ,M_HP		= '".mysql_real_escape_string($this->getM_HP())."'";
		$query .= " ,M_PHONE	= '".mysql_real_escape_string($this->getM_PHONE())."'";
		$query .= " ,M_SMSYN	= '".mysql_real_escape_string($this->getM_SMSYN())."'";
		$query .= " ,M_MAILYN	= '".mysql_real_escape_string($this->getM_MAILYN())."'";
		$query .= " ,M_GROUP	= '".mysql_real_escape_string($this->getM_GROUP())."'";
		$query .= " ,M_TM_ID	= '".mysql_real_escape_string($this->getM_TM_ID())."'";
		$query .= " ,M_MOD_DT	= NOW()";
		$query .= " ,M_MOD_NO	= '".mysql_real_escape_string($this->getM_MOD_NO())."'";
		$query .= "	WHERE M_NO = ".$this->getM_NO();
		
		return $db->getExecSql($query);
	}
	
	function getMemberPwdUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_PASS = SHA1(CONCAT('".$this->getM_PASS()."','!@#$')) WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}


	function getMemberPointUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_POINT = IFNULL(M_POINT,0) + ".$this->getM_POINT()." WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getJoinItemUpdate($db)
	{
		$query = "CALL SP_MEMBER_JOIN_ITEM_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getJI_NO();
		$param[]  = $this->getJI_NES();
		$param[]  = $this->getJI_TYPE();
		$param[]  = $this->getJI_TYPE_VAL();
		$param[]  = $this->getJI_JOIN();
		$param[]  = $this->getJI_MYPAGE();
		$param[]  = $this->getJI_GRADE();
		$param[]  = $this->getJI_USE();
		$param[]  = $this->getJI_ORDER();
		$param[]  = $this->getJI_NAME_KR();
		$param[]  = $this->getJI_NAME_US();
		$param[]  = $this->getJI_NAME_CN();
		$param[]  = $this->getJI_NAME_JP();
		$param[]  = $this->getJI_NAME_ID();
		$param[]  = $this->getJI_NAME_FR();
		$param[]  = $this->getJI_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getJoinItemLngUpdate($db,$param)
	{
		$query  = "UPDATE ".TBL_MEMBER_JOIN_ITEM." SET	";
		$query .= $param['COLUMN']."					";
		$query .= "WHERE JI_NO = ".$param['JI_NO'];
		return $db->getExecSql($query);
	}

	/********************************** Delete **********************************/
	function getGroupDelete($db)
	{
		$query = "CALL SP_MEMBER_GROUP_MGR_D (?);";
		$param[]  = $this->getG_CODE();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Member Auth **********************************/
	function getMemberAuth($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_AUTH = 'Y' WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}
	
	/********************************** Member Out **********************************/
	function getMemberOut($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_OUT = 'Y' , M_OUT_DT = NOW() WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberReJoinCheck($db)
	{
		$query  = "SELECT M_NO, M_ID, M_OUT, M_OUT_DT  ";
		$query .= "FROM ".TBL_MEMBER_MGR."	";
		$query .= "WHERE M_ID = '".$this->getM_ID()."'	";
		$query .= " AND M_OUT = 'Y'";

		return $db->getArrayTotal($query);
	}

	function getMemberValidIdCheck($db)
	{
		$query  = "SELECT COUNT(M_NO)  ";
		$query .= "FROM ".TBL_MEMBER_MGR."	";
		$query .= "WHERE M_ID = '".$this->getM_ID()."'	";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";

		return $db->getArrayTotal($query);
	}

	/********************************** Member Recovery **********************************/
	function getMemberRecovery($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_OUT = NULL , M_OUT_DT = NULL, M_OUT_TXT = NULL WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	/********************************** Member Id Check **********************************/
	function getMemberIdCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_ID='".$this->getM_ID()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";
		return $db->getCount($query);
	}

	/********************************** Member Nick Name Check **********************************/
	function getMemberNickNameCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_NICK_NAME='".$this->getM_NICK_NAME()."'";
		return $db->getCount($query);
	}

	/********************************** Member Mail Check **********************************/
	function getMemberMailCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE ";
		$query .= " M_MAIL='".$this->getM_MAIL()."'";
		//그룹별 메일체크 2015.06.24
		if($this->getM_GROUP()){
		$query .= "M_GROUP = '".$this->getM_GROUP()."'";
		}
		return $db->getCount($query);
	}

	/********************************** Member Group Change **********************************/
	function getMemberGroupChange($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_GROUP = '".$this->getM_GROUP()."' WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberBuyUpdate($db) 
	{
		$query = "CALL SP_MEMBER_MGR_BUY_U (?);";

		$param[]  = $this->getM_NO();

		return $db->executeBindingQuery($query,$param,true);		
	}

	function getMemberOutDataUpdate($db) 
	{
		$query = "CALL SP_DAY_CRON_P (?);";
		$param[]  = $this->getM_NO();

		return $db->executeBindingQuery($query,$param,true);		
	}

	/** 함수 **/

	/**
	 * getSelectQuery($query, $op)
	 * $op 형에 따라서 $query 실행
	 * **/
	function getSelectQuery($db, $query, $op)
	{
		if ( $op == "OP_LIST" || $op == "OP_ALL_LIST" ) :
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

	function getMemberRecNo($db)
	{
		$query  = "SELECT M_NO FROM ".TBL_MEMBER_MGR."	";
		$query .= " WHERE M_NO IS NOT NULL				";

		if ($this->getM_ID()){
			$query .= "AND M_ID = '".mysql_real_escape_string($this->getM_ID())."'	";
		}

		if ($this->getM_MAIL()){
			$query .= "AND M_MAIL = '".mysql_real_escape_string($this->getM_MAIL())."'	";
		}

		return $db->getCount($query);
	}

	function getMemberVisitUpdate($db)
	{
		$query = "UPDATE MEMBER_MGR SET M_VISIT_CNT = IFNULL(M_VISIT_CNT,0) + 1 ,M_LOGIN_DT = NOW() WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberRecNoUpdate($db)
	{
		$query = "UPDATE MEMBER_MGR SET M_REC_ID = ".$this->getM_REC_ID()." WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberLngUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_LNG = '".$this->getM_LNG()."' WHERE M_NO = ".$this->getM_NO();
	}
	/********************************** variable **********************************/
	function setG_CODE($G_CODE){ $this->G_CODE = $G_CODE; }		
	function getG_CODE(){ return $this->G_CODE; }		

	function setG_NAME($G_NAME){ $this->G_NAME = $G_NAME; }		
	function getG_NAME(){ return $this->G_NAME; }		

	function setG_SHOW($G_SHOW){ $this->G_SHOW = $G_SHOW; }		
	function getG_SHOW(){ return $this->G_SHOW; }		

	function setG_APPLY($G_APPLY){ $this->G_APPLY = $G_APPLY; }		
	function getG_APPLY(){ return $this->G_APPLY; }		

	function setG_SETTLE($G_SETTLE){ $this->G_SETTLE = $G_SETTLE; }		
	function getG_SETTLE(){ return $this->G_SETTLE; }	

	function setG_PRICE_ST($G_PRICE_ST){ $this->G_PRICE_ST = $G_PRICE_ST; }		
	function getG_PRICE_ST(){ return $this->G_PRICE_ST; }		

	function setG_ICON($G_ICON){ $this->G_ICON = $G_ICON; }		
	function getG_ICON(){ return $this->G_ICON; }		

	function setG_LEVEL($G_LEVEL){ $this->G_LEVEL = $G_LEVEL; }		
	function getG_LEVEL(){ return $this->G_LEVEL; }		

	function setG_PRICE_MIN($G_PRICE_MIN){ $this->G_PRICE_MIN = $G_PRICE_MIN; }		
	function getG_PRICE_MIN(){ return $this->G_PRICE_MIN; }		

	function setG_PRICE_MAX($G_PRICE_MAX){ $this->G_PRICE_MAX = $G_PRICE_MAX; }		
	function getG_PRICE_MAX(){ return $this->G_PRICE_MAX; }		

	function setG_BUY_CNT($G_BUY_CNT){ $this->G_BUY_CNT = $G_BUY_CNT; }		
	function getG_BUY_CNT(){ return $this->G_BUY_CNT; }		

	function setG_PRODUCT_CNT($G_PRODUCT_CNT){ $this->G_PRODUCT_CNT = $G_PRODUCT_CNT; }		
	function getG_PRODUCT_CNT(){ return $this->G_PRODUCT_CNT; }		

	function setG_DISCOUNT_ST($G_DISCOUNT_ST){ $this->G_DISCOUNT_ST = $G_DISCOUNT_ST; }		
	function getG_DISCOUNT_ST(){ return $this->G_DISCOUNT_ST; }		

	function setG_DISCOUNT_PRICE($G_DISCOUNT_PRICE){ $this->G_DISCOUNT_PRICE = $G_DISCOUNT_PRICE; }		
	function getG_DISCOUNT_PRICE(){ return $this->G_DISCOUNT_PRICE; }		

	function setG_DISCOUNT_RATE($G_DISCOUNT_RATE){ $this->G_DISCOUNT_RATE = $G_DISCOUNT_RATE; }		
	function getG_DISCOUNT_RATE(){ return $this->G_DISCOUNT_RATE; }		

	function setG_DISCOUNT_UNIT($G_DISCOUNT_UNIT){ $this->G_DISCOUNT_UNIT = $G_DISCOUNT_UNIT; }		
	function getG_DISCOUNT_UNIT(){ return $this->G_DISCOUNT_UNIT; }	

	function setG_DISCOUNT_POINT($G_DISCOUNT_POINT){ $this->G_DISCOUNT_POINT = $G_DISCOUNT_POINT; }		
	function getG_DISCOUNT_POINT(){ return $this->G_DISCOUNT_POINT; }	
	
	function setG_DISCOUNT_OFF($G_DISCOUNT_OFF){ $this->G_DISCOUNT_OFF = $G_DISCOUNT_OFF; }		
	function getG_DISCOUNT_OFF(){ return $this->G_DISCOUNT_OFF; }	

	function setG_POINT_PRICE($G_POINT_PRICE){ $this->G_POINT_PRICE = $G_POINT_PRICE; }		
	function getG_POINT_PRICE(){ return $this->G_POINT_PRICE; }		

	function setG_POINT_RATE($G_POINT_RATE){ $this->G_POINT_RATE = $G_POINT_RATE; }		
	function getG_POINT_RATE(){ return $this->G_POINT_RATE; }		

	function setG_POINT_UNIT($G_POINT_UNIT){ $this->G_POINT_UNIT = $G_POINT_UNIT; }		
	function getG_POINT_UNIT(){ return $this->G_POINT_UNIT; }		

	function setG_POINT_POINT($G_POINT_POINT){ $this->G_POINT_POINT = $G_POINT_POINT; }		
	function getG_POINT_POINT(){ return $this->G_POINT_POINT; }		

	function setG_POINT_OFF($G_POINT_OFF){ $this->G_POINT_OFF = $G_POINT_OFF; }		
	function getG_POINT_OFF(){ return $this->G_POINT_OFF; }		

	function setG_ADD_DISCOUNT($G_ADD_DISCOUNT){ $this->G_ADD_DISCOUNT = $G_ADD_DISCOUNT; }		
	function getG_ADD_DISCOUNT(){ return $this->G_ADD_DISCOUNT; }		

	function setG_ADD_DISCOUNT_PRICE($G_ADD_DISCOUNT_PRICE){ $this->G_ADD_DISCOUNT_PRICE = $G_ADD_DISCOUNT_PRICE; }		
	function getG_ADD_DISCOUNT_PRICE(){ return $this->G_ADD_DISCOUNT_PRICE; }		

	function setG_ADD_DISCOUNT_RATE($G_ADD_DISCOUNT_RATE){ $this->G_ADD_DISCOUNT_RATE = $G_ADD_DISCOUNT_RATE; }		
	function getG_ADD_DISCOUNT_RATE(){ return $this->G_ADD_DISCOUNT_RATE; }		

	function setG_ADD_DISCOUNT_UNIT($G_ADD_DISCOUNT_UNIT){ $this->G_ADD_DISCOUNT_UNIT = $G_ADD_DISCOUNT_UNIT; }		
	function getG_ADD_DISCOUNT_UNIT(){ return $this->G_ADD_DISCOUNT_UNIT; }		

	function setG_ADD_DISCOUNT_POINT($G_ADD_DISCOUNT_POINT){ $this->G_ADD_DISCOUNT_POINT = $G_ADD_DISCOUNT_POINT; }		
	function getG_ADD_DISCOUNT_POINT(){ return $this->G_ADD_DISCOUNT_POINT; }		

	function setG_ADD_DISCOUNT_OFF($G_ADD_DISCOUNT_OFF){ $this->G_ADD_DISCOUNT_OFF = $G_ADD_DISCOUNT_OFF; }		
	function getG_ADD_DISCOUNT_OFF(){ return $this->G_ADD_DISCOUNT_OFF; }	

	function setG_IMG($G_IMG){ $this->G_IMG = $G_IMG; }		
	function getG_IMG(){ return $this->G_IMG; }		

	function setG_FILE($G_FILE){ $this->G_FILE = $G_FILE; }		
	function getG_FILE(){ return $this->G_FILE; }		

	function setG_MEMO($G_MEMO){ $this->G_MEMO = $G_MEMO; }		
	function getG_MEMO(){ return $this->G_MEMO; }		

	function setG_EXP_CATEGORY($G_EXP_CATEGORY){ $this->G_EXP_CATEGORY = $G_EXP_CATEGORY; }		
	function getG_EXP_CATEGORY(){ return $this->G_EXP_CATEGORY; }		

	function setG_EXP_PRODUCT($G_EXP_PRODUCT){ $this->G_EXP_PRODUCT = $G_EXP_PRODUCT; }		
	function getG_EXP_PRODUCT(){ return $this->G_EXP_PRODUCT; }	

	function setG_REG_DT($G_REG_DT){ $this->G_REG_DT = $G_REG_DT; }		
	function getG_REG_DT(){ return $this->G_REG_DT; }		

	function setG_REG_NO($G_REG_NO){ $this->G_REG_NO = $G_REG_NO; }		
	function getG_REG_NO(){ return $this->G_REG_NO; }		

	function setG_MOD_DT($G_MOD_DT){ $this->G_MOD_DT = $G_MOD_DT; }		
	function getG_MOD_DT(){ return $this->G_MOD_DT; }		

	function setG_MOD_NO($G_MOD_NO){ $this->G_MOD_NO = $G_MOD_NO; }		
	function getG_MOD_NO(){ return $this->G_MOD_NO; }	

	/*--------------------------------------------------------------*/	
	function setJ_CERITY($J_CERITY){ $this->J_CERITY = $J_CERITY; }		
	function getJ_CERITY(){ return $this->J_CERITY; }		

	function setJ_RE_DAY($J_RE_DAY){ $this->J_RE_DAY = $J_RE_DAY; }		
	function getJ_RE_DAY(){ return $this->J_RE_DAY; }		

	function setJ_NO_ID($J_NO_ID){ $this->J_NO_ID = $J_NO_ID; }		
	function getJ_NO_ID(){ return $this->J_NO_ID; }		

	function setJ_POINT($J_POINT){ $this->J_POINT = $J_POINT; }		
	function getJ_POINT(){ return $this->J_POINT; }		

	function setJ_COUPON($J_COUPON){ $this->J_COUPON = $J_COUPON; }		
	function getJ_COUPON(){ return $this->J_COUPON; }		

	function setJ_GROUP($J_GROUP){ $this->J_GROUP = $J_GROUP; }		
	function getJ_GROUP(){ return $this->J_GROUP; }		

	function setJ_REC_POINT1($J_REC_POINT1){ $this->J_REC_POINT1 = $J_REC_POINT1; }		
	function getJ_REC_POINT1(){ return $this->J_REC_POINT1; }		

	function setJ_REC_POINT2($J_REC_POINT2){ $this->J_REC_POINT2 = $J_REC_POINT2; }		
	function getJ_REC_POINT2(){ return $this->J_REC_POINT2; }		

	function setJ_JUMIN($J_JUMIN){ $this->J_JUMIN = $J_JUMIN; }		
	function getJ_JUMIN(){ return $this->J_JUMIN; }		

	function setJ_IPIN($J_IPIN){ $this->J_IPIN = $J_IPIN; }		
	function getJ_IPIN(){ return $this->J_IPIN; }		

	function setJ_GROUP_VIEW($J_GROUP_VIEW){ $this->J_GROUP_VIEW = $J_GROUP_VIEW; }		
	function getJ_GROUP_VIEW(){ return $this->J_GROUP_VIEW; }	

	function setJ_PHONE($J_PHONE){ $this->J_PHONE = $J_PHONE; }		
	function getJ_PHONE(){ return $this->J_PHONE; }		

	function setJ_MOD_NO($J_MOD_NO){ $this->J_MOD_NO = $J_MOD_NO; }		
	function getJ_MOD_NO(){ return $this->J_MOD_NO; }	

	/*--------------------------------------------------------------*/	
	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		

	function setM_ID($M_ID){ $this->M_ID = $M_ID; }		
	function getM_ID(){ return $this->M_ID; }		

	function setM_PASS($M_PASS){ $this->M_PASS = $M_PASS; }		
	function getM_PASS(){ return $this->M_PASS; }	

	function setM_F_NAME($M_F_NAME){ $this->M_F_NAME = $M_F_NAME; }		
	function getM_F_NAME(){ return $this->M_F_NAME; }		

	function setM_L_NAME($M_L_NAME){ $this->M_L_NAME = $M_L_NAME; }		
	function getM_L_NAME(){ return $this->M_L_NAME; }		

	function setM_NICK_NAME($M_NICK_NAME){ $this->M_NICK_NAME = $M_NICK_NAME; }		
	function getM_NICK_NAME(){ return $this->M_NICK_NAME; }	

	function setM_BIRTH($M_BIRTH){ $this->M_BIRTH = $M_BIRTH; }		
	function getM_BIRTH(){ return $this->M_BIRTH; }	
	
	function setM_BIRTH_CAL($M_BIRTH_CAL){ $this->M_BIRTH_CAL = $M_BIRTH_CAL; }		
	function getM_BIRTH_CAL(){ return $this->M_BIRTH_CAL; }	

	function setM_SEX($M_SEX){ $this->M_SEX = $M_SEX; }		
	function getM_SEX(){ return $this->M_SEX; }		

	function setM_MAIL($M_MAIL){ $this->M_MAIL = $M_MAIL; }		
	function getM_MAIL(){ return $this->M_MAIL; }		

	function setM_PHONE($M_PHONE){ $this->M_PHONE = $M_PHONE; }		
	function getM_PHONE(){ return $this->M_PHONE; }		

	function setM_HP($M_HP){ $this->M_HP = $M_HP; }		
	function getM_HP(){ return $this->M_HP; }		

	function setM_FAX($M_FAX){ $this->M_FAX = $M_FAX; }		
	function getM_FAX(){ return $this->M_FAX; }		

	function setM_WED_DAY($M_WED_DAY){ $this->M_WED_DAY = $M_WED_DAY; }		
	function getM_WED_DAY(){ return $this->M_WED_DAY; }		

	function setM_WED($M_WED){ $this->M_WED = $M_WED; }		
	function getM_WED(){ return $this->M_WED; }		

	function setM_ZIP($M_ZIP){ $this->M_ZIP = $M_ZIP; }		
	function getM_ZIP(){ return $this->M_ZIP; }		

	function setM_ADDR($M_ADDR){ $this->M_ADDR = $M_ADDR; }		
	function getM_ADDR(){ return $this->M_ADDR; }		

	function setM_ADDR2($M_ADDR2){ $this->M_ADDR2 = $M_ADDR2; }		
	function getM_ADDR2(){ return $this->M_ADDR2; }		

	function setM_SMSYN($M_SMSYN){ $this->M_SMSYN = $M_SMSYN; }		
	function getM_SMSYN(){ return $this->M_SMSYN; }		

	function setM_MAILYN($M_MAILYN){ $this->M_MAILYN = $M_MAILYN; }		
	function getM_MAILYN(){ return $this->M_MAILYN; }		

	function setM_TEXT($M_TEXT){ $this->M_TEXT = $M_TEXT; }		
	function getM_TEXT(){ return $this->M_TEXT; }		

	function setM_REC_ID($M_REC_ID){ $this->M_REC_ID = $M_REC_ID; }		
	function getM_REC_ID(){ return $this->M_REC_ID; }		

	function setM_GROUP($M_GROUP){ $this->M_GROUP = $M_GROUP; }		
	function getM_GROUP(){ return $this->M_GROUP; }		

	function setM_AUTH($M_AUTH){ $this->M_AUTH = $M_AUTH; }		
	function getM_AUTH(){ return $this->M_AUTH; }		

	function setM_POINT($M_POINT){ $this->M_POINT = $M_POINT; }		
	function getM_POINT(){ return $this->M_POINT; }		

	function setM_BUY_PRICE($M_BUY_PRICE){ $this->M_BUY_PRICE = $M_BUY_PRICE; }		
	function getM_BUY_PRICE(){ return $this->M_BUY_PRICE; }		

	function setM_BUY_CNT($M_BUY_CNT){ $this->M_BUY_CNT = $M_BUY_CNT; }		
	function getM_BUY_CNT(){ return $this->M_BUY_CNT; }		

	function setM_VISIT_CNT($M_VISIT_CNT){ $this->M_VISIT_CNT = $M_VISIT_CNT; }		
	function getM_VISIT_CNT(){ return $this->M_VISIT_CNT; }		

	function setM_OUT($M_OUT){ $this->M_OUT = $M_OUT; }		
	function getM_OUT(){ return $this->M_OUT; }		

	function setM_OUT_DT($M_OUT_DT){ $this->M_OUT_DT = $M_OUT_DT; }		
	function getM_OUT_DT(){ return $this->M_OUT_DT; }		

	function setM_CONCERN($M_CONCERN){ $this->M_CONCERN = $M_CONCERN; }		
	function getM_CONCERN(){ return $this->M_CONCERN; }		

	function setM_JOB($M_JOB){ $this->M_JOB = $M_JOB; }		
	function getM_JOB(){ return $this->M_JOB; }		

	function setM_FACEBOOK_ID($M_FACEBOOK_ID){ $this->M_FACEBOOK_ID = $M_FACEBOOK_ID; }		
	function getM_FACEBOOK_ID(){ return $this->M_FACEBOOK_ID; }		

	function setM_FACEBOOK_TOKEN($M_FACEBOOK_TOKEN){ $this->M_FACEBOOK_TOKEN = $M_FACEBOOK_TOKEN; }		
	function getM_FACEBOOK_TOKEN(){ return $this->M_FACEBOOK_TOKEN; }		

	function setM_COUNTRY($M_COUNTRY){ $this->M_COUNTRY = $M_COUNTRY; }		
	function getM_COUNTRY(){ return $this->M_COUNTRY; }		

	function setM_CITY($M_CITY){ $this->M_CITY = $M_CITY; }		
	function getM_CITY(){ return $this->M_CITY; }		

	function setM_STATE($M_STATE){ $this->M_STATE = $M_STATE; }		
	function getM_STATE(){ return $this->M_STATE; }		
	
	function setM_TM_ID($M_TM_ID){ $this->M_TM_ID = $M_TM_ID; }		
	function getM_TM_ID(){ return $this->M_TM_ID; }		

	function setM_REG_DT($M_REG_DT){ $this->M_REG_DT = $M_REG_DT; }		
	function getM_REG_DT(){ return $this->M_REG_DT; }		

	function setM_REG_NO($M_REG_NO){ $this->M_REG_NO = $M_REG_NO; }		
	function getM_REG_NO(){ return $this->M_REG_NO; }		

	function setM_MOD_DT($M_MOD_DT){ $this->M_MOD_DT = $M_MOD_DT; }		
	function getM_MOD_DT(){ return $this->M_MOD_DT; }		

	function setM_MOD_NO($M_MOD_NO){ $this->M_MOD_NO = $M_MOD_NO; }		
	function getM_MOD_NO(){ return $this->M_MOD_NO; }	

	/* SearchID & SearchPWD */
	function setM_ID_NAME($M_ID_NAME){ $this->M_ID_NAME = $M_ID_NAME; }		
	function getM_ID_NAME(){ return $this->M_ID_NAME; }	

	function setM_ID_MAIL1($M_ID_MAIL1){ $this->M_ID_MAIL1 = $M_ID_MAIL1; }		
	function getM_ID_MAIL1(){ return $this->M_ID_MAIL1; }	

	function setM_ID_MAIL2($M_ID_MAIL2){ $this->M_ID_MAIL2 = $M_ID_MAIL2; }		
	function getM_ID_MAIL2(){ return $this->M_ID_MAIL2; }	
	
	function setM_PASS_ID($M_PASS_ID){ $this->M_PASS_ID = $M_PASS_ID; }		
	function getM_PASS_ID(){ return $this->M_PASS_ID; }

	function setM_PASS_NAME($M_PASS_NAME){ $this->M_PASS_NAME = $M_PASS_NAME; }		
	function getM_PASS_NAME(){ return $this->M_PASS_NAME; }	

	function setM_PASS_MAIL1($M_PASS_MAIL1){ $this->M_PASS_MAIL1 = $M_PASS_MAIL1; }		
	function getM_PASS_MAIL1(){ return $this->M_PASS_MAIL1; }	

	function setM_PASS_MAIL2($M_PASS_MAIL2){ $this->M_PASS_MAIL2 = $M_PASS_MAIL2; }		
	function getM_PASS_MAIL2(){ return $this->M_PASS_MAIL2; }	

	function setM_PASS_HP1($M_PASS_HP1){ $this->M_PASS_HP1 = $M_PASS_HP1; }		
	function getM_PASS_HP1(){ return $this->M_PASS_HP1; }

	function setM_PASS_HP2($M_PASS_HP2){ $this->M_PASS_HP2 = $M_PASS_HP2; }		
	function getM_PASS_HP2(){ return $this->M_PASS_HP2; }

	function setM_PASS_HP3($M_PASS_HP3){ $this->M_PASS_HP3 = $M_PASS_HP3; }		
	function getM_PASS_HP3(){ return $this->M_PASS_HP3; }
	/* SearchID & SearchPWD */


	function setM_CHILD($M_CHILD){ $this->M_CHILD = $M_CHILD; }		
	function getM_CHILD(){ return $this->M_CHILD; }		

	function setM_COM_NM($M_COM_NM){ $this->M_COM_NM = $M_COM_NM; }		
	function getM_COM_NM(){ return $this->M_COM_NM; }		

	function setM_BUSI_NM($M_BUSI_NM){ $this->M_BUSI_NM = $M_BUSI_NM; }		
	function getM_BUSI_NM(){ return $this->M_BUSI_NM; }		

	function setM_BUSI_NUM($M_BUSI_NUM){ $this->M_BUSI_NUM = $M_BUSI_NUM; }		
	function getM_BUSI_NUM(){ return $this->M_BUSI_NUM; }		

	function setM_BUSI_UPJ($M_BUSI_UPJ){ $this->M_BUSI_UPJ = $M_BUSI_UPJ; }		
	function getM_BUSI_UPJ(){ return $this->M_BUSI_UPJ; }		

	function setM_BUSI_UTE($M_BUSI_UTE){ $this->M_BUSI_UTE = $M_BUSI_UTE; }		
	function getM_BUSI_UTE(){ return $this->M_BUSI_UTE; }		

	function setM_BUSI_ZIP($M_BUSI_ZIP){ $this->M_BUSI_ZIP = $M_BUSI_ZIP; }		
	function getM_BUSI_ZIP(){ return $this->M_BUSI_ZIP; }		

	function setM_BUSI_ADDR1($M_BUSI_ADDR1){ $this->M_BUSI_ADDR1 = $M_BUSI_ADDR1; }		
	function getM_BUSI_ADDR1(){ return $this->M_BUSI_ADDR1; }		

	function setM_BUSI_ADDR2($M_BUSI_ADDR2){ $this->M_BUSI_ADDR2 = $M_BUSI_ADDR2; }		
	function getM_BUSI_ADDR2(){ return $this->M_BUSI_ADDR2; }		


	function setM_FOREIGN($M_FOREIGN){ $this->M_FOREIGN = $M_FOREIGN; }		
	function getM_FOREIGN(){ return $this->M_FOREIGN; }		

	function setM_FOREIGN_NUM($M_FOREIGN_NUM){ $this->M_FOREIGN_NUM = $M_FOREIGN_NUM; }		
	function getM_FOREIGN_NUM(){ return $this->M_FOREIGN_NUM; }		

	function setM_PASSPORT($M_PASSPORT){ $this->M_PASSPORT = $M_PASSPORT; }		
	function getM_PASSPORT(){ return $this->M_PASSPORT; }		

	function setM_DRIVE_NUM($M_DRIVE_NUM){ $this->M_DRIVE_NUM = $M_DRIVE_NUM; }		
	function getM_DRIVE_NUM(){ return $this->M_DRIVE_NUM; }		

	function setM_NATION($M_NATION){ $this->M_NATION = $M_NATION; }		
	function getM_NATION(){ return $this->M_NATION; }		

	function setM_PHOTO($M_PHOTO){ $this->M_PHOTO = $M_PHOTO; }		
	function getM_PHOTO(){ return $this->M_PHOTO; }		

	function setM_TMP1($M_TMP1){ $this->M_TMP1 = $M_TMP1; }		
	function getM_TMP1(){ return $this->M_TMP1; }		

	function setM_TMP2($M_TMP2){ $this->M_TMP2 = $M_TMP2; }		
	function getM_TMP2(){ return $this->M_TMP2; }		

	function setM_TMP3($M_TMP3){ $this->M_TMP3 = $M_TMP3; }		
	function getM_TMP3(){ return $this->M_TMP3; }		

	function setM_TMP4($M_TMP4){ $this->M_TMP4 = $M_TMP4; }		
	function getM_TMP4(){ return $this->M_TMP4; }		

	function setM_TMP5($M_TMP5){ $this->M_TMP5 = $M_TMP5; }		
	function getM_TMP5(){ return $this->M_TMP5; }	

	function setM_LNG($M_LNG){ $this->M_LNG = $M_LNG; }		
	function getM_LNG(){ return $this->M_LNG; }	
	/*--------------------------------------------------------------*/	
	function setJI_NO($JI_NO){ $this->JI_NO = $JI_NO; }		
	function getJI_NO(){ return $this->JI_NO; }		

	function setJI_CODE($JI_CODE){ $this->JI_CODE = $JI_CODE; }		
	function getJI_CODE(){ return $this->JI_CODE; }		

	function setJI_NAME_KR($JI_NAME_KR){ $this->JI_NAME_KR = $JI_NAME_KR; }		
	function getJI_NAME_KR(){ return $this->JI_NAME_KR; }		

	function setJI_NAME_US($JI_NAME_US){ $this->JI_NAME_US = $JI_NAME_US; }		
	function getJI_NAME_US(){ return $this->JI_NAME_US; }	

	function setJI_NAME_CN($JI_NAME_CN){ $this->JI_NAME_CN = $JI_NAME_CN; }		
	function getJI_NAME_CN(){ return $this->JI_NAME_CN; }	

	function setJI_NAME_JP($JI_NAME_JP){ $this->JI_NAME_JP = $JI_NAME_JP; }		
	function getJI_NAME_JP(){ return $this->JI_NAME_JP; }	

	function setJI_NAME_ID($JI_NAME_ID){ $this->JI_NAME_ID = $JI_NAME_ID; }		
	function getJI_NAME_ID(){ return $this->JI_NAME_ID; }	

	function setJI_NAME_FR($JI_NAME_FR){ $this->JI_NAME_FR = $JI_NAME_FR; }		
	function getJI_NAME_FR(){ return $this->JI_NAME_FR; }	

	function setJI_GB($JI_GB){ $this->JI_GB = $JI_GB; }		
	function getJI_GB(){ return $this->JI_GB; }		

	function setJI_NES($JI_NES){ $this->JI_NES = $JI_NES; }		
	function getJI_NES(){ return $this->JI_NES; }		

	function setJI_TYPE($JI_TYPE){ $this->JI_TYPE = $JI_TYPE; }		
	function getJI_TYPE(){ return $this->JI_TYPE; }		

	function setJI_TYPE_VAL($JI_TYPE_VAL){ $this->JI_TYPE_VAL = $JI_TYPE_VAL; }		
	function getJI_TYPE_VAL(){ return $this->JI_TYPE_VAL; }		

	function setJI_JOIN($JI_JOIN){ $this->JI_JOIN = $JI_JOIN; }		
	function getJI_JOIN(){ return $this->JI_JOIN; }		

	function setJI_MYPAGE($JI_MYPAGE){ $this->JI_MYPAGE = $JI_MYPAGE; }		
	function getJI_MYPAGE(){ return $this->JI_MYPAGE; }		

	function setJI_GRADE($JI_GRADE){ $this->JI_GRADE = $JI_GRADE; }		
	function getJI_GRADE(){ return $this->JI_GRADE; }		

	function setJI_USE($JI_USE){ $this->JI_USE = $JI_USE; }		
	function getJI_USE(){ return $this->JI_USE; }		

	function setJI_ORDER($JI_ORDER){ $this->JI_ORDER = $JI_ORDER; }		
	function getJI_ORDER(){ return $this->JI_ORDER; }		

	function setJI_REG_DT($JI_REG_DT){ $this->JI_REG_DT = $JI_REG_DT; }		
	function getJI_REG_DT(){ return $this->JI_REG_DT; }		

	function setJI_REG_NO($JI_REG_NO){ $this->JI_REG_NO = $JI_REG_NO; }		
	function getJI_REG_NO(){ return $this->JI_REG_NO; }		

	function setJI_MOD_DT($JI_MOD_DT){ $this->JI_MOD_DT = $JI_MOD_DT; }		
	function getJI_MOD_DT(){ return $this->JI_MOD_DT; }		

	function setJI_MOD_NO($JI_MOD_NO){ $this->JI_MOD_NO = $JI_MOD_NO; }		
	function getJI_MOD_NO(){ return $this->JI_MOD_NO; }	
	/*--------------------------------------------------------------*/	

	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }		
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }		
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }		
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }		
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchOut($SEARCH_OUT){ $this->SEARCH_OUT = $SEARCH_OUT; }		
	function getSearchOut(){ return $this->SEARCH_OUT; }

	function setSearchRegStartDt($SEARCH_REG_START_DT){ $this->SEARCH_REG_START_DT = $SEARCH_REG_START_DT; }		
	function getSearchRegStartDt(){ return $this->SEARCH_REG_START_DT; }

	function setSearchRegEndDt($SEARCH_REG_END_DT){ $this->SEARCH_REG_END_DT = $SEARCH_REG_END_DT; }		
	function getSearchRegEndDt(){ return $this->SEARCH_REG_END_DT; }

	/* 최종로그인 */
	function setSearchLastLoginStartDt($SEARCH_LAST_LOGIN_START_DT){ $this->SEARCH_LAST_LOGIN_START_DT = $SEARCH_LAST_LOGIN_START_DT; }		
	function getSearchLastLoginStartDt(){ return $this->SEARCH_LAST_LOGIN_START_DT; }

	function setSearchLastLoginEndDt($SEARCH_LAST_LOGIN_END_DT){ $this->SEARCH_LAST_LOGIN_END_DT = $SEARCH_LAST_LOGIN_END_DT; }		
	function getSearchLastLoginEndDt(){ return $this->SEARCH_LAST_LOGIN_END_DT; }
	
	/* 방문횟수 */
	function setSearchVisitStartCnt($SEARCH_VISIT_START_CNT){ $this->SEARCH_VISIT_START_CNT = $SEARCH_VISIT_START_CNT; }		
	function getSearchVisitStartCnt(){ return $this->SEARCH_VISIT_START_CNT; }

	function setSearchVisitEndCnt($SEARCH_VISIT_END_CNT){ $this->SEARCH_VISIT_END_CNT = $SEARCH_VISIT_END_CNT; }		
	function getSearchVisitEndCnt(){ return $this->SEARCH_VISIT_END_CNT; }
	
	/* 성별 */
	function setSearchSex($SEARCH_SEX){ $this->SEARCH_SEX = $SEARCH_SEX; }		
	function getSearchSex(){ return $this->SEARCH_SEX; }
	
	/* 메일수신여부 */
	function setSearchMailYN($SEARCH_MAIL_YN){ $this->SEARCH_MAIL_YN = $SEARCH_MAIL_YN; }		
	function getSearchMailYN(){ return $this->SEARCH_MAIL_YN; }

	/* SMS수신여부 */
	function setSearchSmsYN($SEARCH_SMS_YN){ $this->SEARCH_SMS_YN = $SEARCH_SMS_YN; }		
	function getSearchSmsYN(){ return $this->SEARCH_SMS_YN; }

	/* 생년월일 */
	function setSearchBirth($SEARCH_BIRTH){ $this->SEARCH_BIRTH = $SEARCH_BIRTH; }		
	function getSearchBirth(){ return $this->SEARCH_BIRTH; }

	/* 추천인ID */
	function setSearchRecId($SEARCH_REC_ID){ $this->SEARCH_REC_ID = $SEARCH_REC_ID; }		
	function getSearchRecId(){ return $this->SEARCH_REC_ID; }

	/* 회원그룹 */
	function setSearchGroup($SEARCH_GROUP){ $this->SEARCH_GROUP = $SEARCH_GROUP; }		
	function getSearchGroup(){ return $this->SEARCH_GROUP; }
	
	/* 회원 탈퇴/삭제일 */
	function setSearchOutStartDt($SEARCH_OUT_START_DT){ $this->SEARCH_OUT_START_DT = $SEARCH_OUT_START_DT; }		
	function getSearchOutStartDt(){ return $this->SEARCH_OUT_START_DT; }

	function setSearchOutEndDt($SEARCH_OUT_END_DT){ $this->SEARCH_OUT_END_DT = $SEARCH_OUT_END_DT; }		
	function getSearchOutEndDt(){ return $this->SEARCH_OUT_END_DT; }

	function setSearchOrderSortCol($SEARCH_ORDER_SORT_COL){ $this->SEARCH_ORDER_SORT_COL = $SEARCH_ORDER_SORT_COL; }		
	function getSearchOrderSortCol(){ return $this->SEARCH_ORDER_SORT_COL; }

	function setSearchOrderSort($SEARCH_ORDER_SORT){ $this->SEARCH_ORDER_SORT = $SEARCH_ORDER_SORT; }		
	function getSearchOrderSort(){ return $this->SEARCH_ORDER_SORT; }

	function setSearchTmId($SEARCH_TM_ID){ $this->SEARCH_TM_ID = $SEARCH_TM_ID; }		
	function getSearchTmId(){ return $this->SEARCH_TM_ID; }

	function setSearchGroupNotView($SEARCH_GROUP_NOT_VIEW){ $this->SEARCH_GROUP_NOT_VIEW = $SEARCH_GROUP_NOT_VIEW; }		
	function getSearchGroupNotView(){ return $this->SEARCH_GROUP_NOT_VIEW; }


	/********************************** variable **********************************/


}
?>
