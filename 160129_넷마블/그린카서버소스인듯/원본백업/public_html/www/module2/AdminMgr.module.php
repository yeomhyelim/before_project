<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-06-09												|# 
#|작성내용	: 부관리자 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class AdminMgrModule extends Module2
{
		function getAdminMgrSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "A.M_NO";
			$aryColumn[] = "A.A_MEMO";
			$aryColumn[] = "A.A_STATUS";
			$aryColumn[] = "A.A_LNG";
			$aryColumn[] = "A.A_TM_YN";
			$aryColumn[] = "A.A_SHOP_LIST";
			$aryColumn[] = "A.A_REG_DT";
			$aryColumn[] = "A.A_REG_NO";
			$aryColumn[] = "A.A_MOD_DT";
			$aryColumn[] = "A.A_MOD_NO";

			## 검색(텍스트)
			$aryWhere1 = "";
			if($param['searchKey']):
				$arySearchText['T']					= " CONCAT(IFNULL(M.M_F_NAME,''),'',IFNULL(M.M_L_NAME,'')) LIKE ('%{$param['searchKey']}%')";
				$arySearchText['I']					= "M.M_ID LIKE ('%{$param['searchKey']}%') OR M.M_MAIL LIKE ('%{$param['searchKey']}%')";
				$temp								= $arySearchText[$param['searchField']];
				if(!$temp):
					foreach($arySearchText as $key => $data):
						if($temp) { $temp = "{$temp} OR"; }
						$temp = "{$temp} {$data}";
					endforeach;
					$temp		= "( {$temp} )";
				endif;
				$aryWhere1[] = $temp;
			endif;

			## where 설정
			if($param['M_NO']) { $aryWhere1[] = "A.M_NO = {$param['M_NO']}"; }
			if($param['A_STATUS']) { $aryWhere1[] = "A.A_STATUS = {$param['A_STATUS']}"; }
			if($param['A_STATUS_NOT_IN']):
				$aryTemp = $param['A_STATUS_NOT_IN'];
				if(!is_array($aryTemp)) { $aryTemp = array($aryTemp); }
				$aryTemp = implode(",", $aryTemp);
				$aryWhere1[] = "A.A_STATUS NOT IN ({$aryTemp})";
			endif;
			
			## order by 설정
			$aryOrderBy['noAsc']			= "A.M_NO ASC";
			$aryOrderBy['noDesc']			= "A.M_NO DESC";
			$strOrderBy						= $aryOrderBy[$param['ORDER_BY']];

			## limit 설정
			if($param['LIMIT']):
				list($param['LIMIT_START'], $param['LIMIT_END']) = explode(",", $param['LIMIT']);
			endif;
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$strLimit					= "{$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;

			## join 설정
			if($param['JOIN_M'] == "Y"):
				$aryColumn[] = "CONCAT(IFNULL(M.M_F_NAME,''),'',IFNULL(M.M_L_NAME,'')) AS M_NAME";
				$aryColumn[] = "M.M_ID, M.M_HP, M.M_MAIL";
				$aryJoin['JOIN_M']  = "    JOIN														          ";
				$aryJoin['JOIN_M'] .= "        MEMBER_MGR AS M	    										  ";
				$aryJoin['JOIN_M'] .= "        ON															  ";
				$aryJoin['JOIN_M'] .= "        M.M_NO = A.M_NO  			 							      ";
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


			$SQL =    "SELECT {$strColumn}                                 ";
			$SQL .= "  FROM                                                ";
			$SQL .= "       ADMIN_MGR AS A                                 ";
			$SQL .= " {$aryJoin['JOIN_M']}								   ";
			$SQL .= " {$strWhere1}										   ";
//			$SQL .= "ORDER BY A.M_NO DESC                                  ";
			$SQL .= " {$strOrderBy}										   ";
//			$SQL .= "LIMIT 0,30                                            ";
			$SQL .= " {$strLimit}										   ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getAdminMgrInsertEx($param)
		{

		}

		function getAdminMgrUpdateEx($param)
		{

		}

		function getAdminMgrDeleteEx($param)
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