<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-03												|# 
#|작성내용	: 회원 모듈 클레스											|# 
#/*====================================================================*/# 

require_once "Module.php";

class MemberMgrModule extends Module2
{
		function getMemberMgrSelectEx2($op, $param)
		{
			## column 설정
			$aryColumn[] = "M.*, CONCAT(IFNULL(M.M_F_NAME,''),'',IFNULL(M.M_L_NAME,'')) AS M_NAME";

			## 검색(텍스트)
			## 기본 설정
			$aryWhere1 = ""; 
			$arySearchKey = $param['searchKey'];
			$strSearchVal = $param['searchVal'];
		
			## 공백 제거
			$strSearchVal = trim($strSearchVal);

			## search query 설정
//			$arySearchText['title'] = "UB.UB_TITLE LIKE ('%{$strSearchVal}%')";
//			$arySearchText['text'] = "UB.UB_TEXT LIKE ('%{$strSearchVal}%')";
//			$arySearchText['name'] = "UB.UB_NAME LIKE ('%{$strSearchVal}%')";
//			$arySearchText['id'] = "UB.UB_M_ID LIKE ('%{$strSearchVal}%')";
//			if($strSearchVal):
//				$arySearchQuery = "";
//				if($arySearchKey && !is_array($arySearchKey)) { $arySearchKey = array($arySearchKey); }
//				if($arySearchKey):
//					foreach($arySearchKey as $key => $data):
//						$temp = $arySearchText[$data];
//						if(!$temp) { continue; }
//						$arySearchQuery[] = $temp;
//					endforeach;
//				endif;
//				if(!$arySearchQuery):
//					foreach($arySearchText as $key => $data):
//						$arySearchQuery[] = $data;
//					endforeach;
//				endif;
//				$strSearchQuery = implode(" OR ", $arySearchQuery);
//				$strSearchQuery = "( {$strSearchQuery} )";
//				$aryWhere1[] = $strSearchQuery;
//			endif;

			## 검색(가입일)
//			$strSearchRegDTStart = $param['searchRegDTStart'];
//			$strSearchRegDTEnd = $param['searchRegDTEnd'];
//			if($strSearchRegDTStart || $strSearchRegDTEnd):
//				if(!$strSearchRegDTStart) { $strSearchRegDTStart = "1900-12-08"; }
//				if(!$strSearchRegDTEnd)	{ $strSearchRegDTEnd = "2200-12-08"; }
//
//				$strSearchRegDTStart = mysql_real_escape_string($strSearchRegDTStart);
//				$strSearchRegDTEnd = mysql_real_escape_string($strSearchRegDTEnd);
//				$aryWhere1[] = "UB.UB_REG_DT BETWEEN DATE_FORMAT('{$strSearchRegDTStart}','%Y-%m-%d 00:00:00') AND DATE_FORMAT('{$strSearchRegDTEnd}','%Y-%m-%d 23:59:59')";
//			endif;

			## where 설정
			if($param['M_NO']) { $aryWhere1[] = "M.M_NO = {$param['M_NO']}"; }
			if($param['M_ID']) { $aryWhere1[] = "M.M_ID = '{$param['M_ID']}'"; }
			if($param['M_MAIL']) { $aryWhere1[] = "M.M_MAIL = '{$param['M_MAIL']}'"; }
			if($param['M_HP']) { $aryWhere1[] = "M.M_HP = '{$param['M_HP']}'"; }
			if($param['M_PASS']) { $aryWhere1[] = "M.M_PASS = SHA1(CONCAT('{$param['M_PASS']}','!@#$'))"; }

			## join 설정
			if($param['JOIN_MA'] == "Y"):
				$aryColumn[] = "MA.*";

				$aryJoin['JOIN_MA']  = "    LEFT OUTER JOIN											  ";
				$aryJoin['JOIN_MA'] .= "        MEMBER_ADD AS MA 	    						      ";
				$aryJoin['JOIN_MA'] .= "    ON														  ";
				$aryJoin['JOIN_MA'] .= "        MA.M_NO = M.M_NO	 					              ";
			endif;


			## order by 설정
			$aryOrderBy['no_asc']			= "M.M_NO ASC";
			$aryOrderBy['no_desc']			= "UB.M_NO DESC";
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
			$SQL .= "  FROM                                                             ";
			$SQL .= "       MEMBER_MGR AS M					                            ";
			$SQL .= " {$aryJoin['JOIN_MA']}								    			";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}	

		function getMemberMgrSelectEx($op, $param)
		{
			$column['OP_LIST']		= "M.*, CONCAT(IFNULL(M.M_F_NAME,''),'',IFNULL(M.M_L_NAME,'')) AS M_NAME";
			$column['OP_SELECT']	= "*, CONCAT(IFNULL(M.M_F_NAME,''),'',IFNULL(M.M_L_NAME,'')) AS M_NAME";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*, CONCAT(IFNULL(M.M_F_NAME,''),'',IFNULL(M.M_L_NAME,'')) AS M_NAME";

			## query(1) 영역
			
			## limit1
			if($param['LIMIT']):
				$limit1			= "LIMIT {$param['LIMIT']}";
			endif;		
			
			## order_by1
			if($param['ORDER_BY']):
				$order_by1		= "ORDER BY {$param['ORDER_BY']}";
			else:
				## default
				$order_by1		= "ORDER BY M.M_NO ASC";
			endif;

			## where1
			$where1				= "WHERE M.M_NO IS NOT NULL";

			if($param['M_NO']):
				$where1			= "{$where1} AND M.M_NO = '{$param['M_NO']}'";
			endif;

			if($param['M_ID']):
				$where1			= "{$where1} AND M.M_ID = '{$param['M_ID']}'";
			endif;

			if($param['M_MAIL']):
				$where1			= "{$where1} AND M.M_MAIL = '{$param['M_MAIL']}'";
			endif;

			if($param['M_HP']):
				$where1			= "{$where1} AND M.M_HP = '{$param['M_HP']}'";
			endif;

			if($param['M_PASS']):
				$where1			= "{$where1} AND M.M_PASS = SHA1(CONCAT('{$param['M_PASS']}','!@#$'))";
			endif;

			$where1			= "{$where1} AND IF(M.M_OUT = '' , 'N', IFNULL(M.M_OUT, 'N')) = 'N'";

			## 검색(텍스트)
			if($param['searchKey']):
				$arySearchText['name']				= "(M.M_F_NAME LIKE ('%{$param['searchKey']}%') OR M.M_L_NAME LIKE ('%{$param['searchKey']}%'))";
				$arySearchText['id']				= "M.M_ID LIKE ('%{$param['searchKey']}%')";
				$arySearchText['hp']				= "M.M_HP LIKE ('%{$param['searchKey']}%')";
				$arySearchText['phone']				= "M.M_PHONE LIKE ('%{$param['searchKey']}%')";
				$temp								= $arySearchText[$param['searchField']];

				if(!$temp):
					foreach($arySearchText as $key => $data):
						if($temp) { $temp = "{$temp} OR"; }
						$temp = "{$temp} {$data}";
					endforeach;
					$temp		= "( {$temp} )";
				endif;

				$where1								= "{$where1} AND {$temp}";
			endif;

			## from1
			$from1				= "FROM MEMBER_MGR AS M";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getMemberMgrInsertEx($param)
		{

		}

		function getMemberMgrUpdateEx($param)
		{

		}

		function getMemberVisitUpdate($param)
		{
			## 기본 설정
			$intM_NO					= $this->db->getSQLInteger($param['M_NO']);

			if($intM_NO):
				if($where) { $where = "{$where} AND "; }
				$where				= "M_NO = {$intM_NO}";
			endif;
			
			if(!$where)					{ return; }

			## 업데이트 
			$paramData					= "";
			$paramData['M_VISIT_CNT']	= "IFNULL(M_VISIT_CNT,0) + 1";
			$paramData['M_LOGIN_DT']	= "NOW()";

			return $this->db->getUpdateParam("MEMBER_MGR", $paramData, $where);	
		}

		function getMemberPwdUpdate($param)
		{
			## 기본 설정
			$intM_NO					= $param['M_NO'];
			$strM_PASS					= $param['M_PASS'];

			## 체크
			if(!$intM_NO) { return; }
			if(!$strM_PASS) { return; }
			
			## where 만들기
			$where = "M_NO = {$intM_NO}";

			## 업데이트 
			$paramData					= "";
			$paramData['M_PASS']		= "SHA1(CONCAT('{$strM_PASS}','!@#$'))";

			return $this->db->getUpdateParam("MEMBER_MGR", $paramData, $where);	
		}

		// 포인트 업데이트
		function getMemberMgrPointUpdate($param)
		{
			## 기본 설정
			$intM_NO					= $param['M_NO'];
			$intM_POINT					= $param['M_POINT'];

			## 체크
			if(!$intM_NO) { return; }
			
			## where 만들기
			$where = "M_NO = {$intM_NO}";

			## 업데이트 
			$paramData					= "";
			$paramData['M_POINT']		= "IFNULL(M_POINT,0) + {$intM_POINT}";

			return $this->db->getUpdateParam("MEMBER_MGR", $paramData, $where);	
		}

		function getMemberNameUpdate($param)
		{
			## 기본 설정
			$intM_NO					= $param['M_NO'];
			$strM_F_NAME				= $param['M_F_NAME']; // 한국어일때 사용안함, 외국어일때 이름으로 사용
			$strM_L_NAME				= $param['M_L_NAME']; // 한국어일때 성 + 이름 으로 사용, 외국어일때 성으로 사용

			## 체크
			if(!$intM_NO) { return; }
			
			## where 만들기
			$where = "M_NO = {$intM_NO}";

			## 업데이트 
			$paramData					= "";
			$paramData['M_F_NAME']		= "'{$strM_F_NAME}'";
			$paramData['M_L_NAME']		= "'{$strM_L_NAME}'";

			return $this->db->getUpdateParam("MEMBER_MGR", $paramData, $where);	
		}

		function getMemberMgrDeleteEx($param)
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