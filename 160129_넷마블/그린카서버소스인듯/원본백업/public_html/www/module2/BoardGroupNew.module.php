<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-03												|# 
#|작성내용	: 커뮤니티 그룹 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardGroupNewModule extends Module2
{
		function getBoardGroupNewLngSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "BG.BG_NO";
			$aryColumn[] = "IFNULL(BGL.BG_NAME, BG.BG_NAME) AS BG_NAME";
			$aryColumn[] = "IFNULL(BGL.BG_FILE1, BG.BG_FILE1) AS BG_FILE1";
			$aryColumn[] = "IFNULL(BGL.BG_FILE2, BG.BG_FILE2) AS BG_FILE2";
			$aryColumn[] = "IFNULL(BGL.BG_MENU_USE, BG.BG_MENU_USE) AS BG_MENU_USE";
			$aryColumn[] = "IFNULL(BGL.BG_SORT, BG.BG_SORT) AS BG_SORT";
			$aryColumn[] = "(SELECT COUNT(*) FROM BOARD_MGR_NEW  AS B WHERE B.B_BG_NO = BG.BG_NO AND B_USE = 'Y') AS BG_BOARD_CNT";

			## 체크
			if(!$param['LNG']) { return; }
			if(!$param['S_ST_LNG']) { return; }

			## 검색(텍스트)
			if($param['searchKey']):
				$arySearchText['title']				= "BG.BG_NAME LIKE ('%{$param['searchKey']}%')";
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
			$aryWhere1 = "";
			if($param['BG_NO']) { $aryWhere1[] = "BG.BG_NO = {$param['BG_NO']}"; }
			if($param['BG_MENU_USE']) { $aryWhere1[] = "BG.BG_MENU_USE = '{$param['BG_MENU_USE']}'"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "BG.BG_NO ASC";
			$aryOrderBy['noDesc']			= "BG.BG_NO DESC";
			$aryOrderBy['sortDesc']			= "BGL.BG_SORT DESC, BG.BG_SORT DESC";
			$aryOrderBy['sortAsc']			= "BGL.BG_SORT ASC, BG.BG_SORT ASC";
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

			## join 설정
//			if($param['JOIN_STC'] == "Y"):
//				$aryJoin['JOIN_STC']  = "    JOIN														          ";
//				$aryJoin['JOIN_STC'] .= "        STORY_TOC AS STC	    										  ";
//				$aryJoin['JOIN_STC'] .= "        ON																  ";
//				$aryJoin['JOIN_STC'] .= "        SR.SR_NO = STC.STC_SR_NO  			 					          ";
//			endif;

			$SQL  = " SELECT {$strColumn}											 ";
			$SQL .= "  FROM                                                          ";
			$SQL .= "       (SELECT BG_NO,                                           ";
			$SQL .= "              BG_NAME,                                          ";
			$SQL .= "              BG_FILE1,                                         ";
			$SQL .= "              BG_FILE2,                                         ";
			$SQL .= "              BG_MENU_USE,                                      ";
			$SQL .= "              BG_SORT                                           ";
			$SQL .= "         FROM BOARD_GROUP_NEW                                   ";
			$SQL .= "        WHERE BG_LNG = '{$param['S_ST_LNG']}'                   ";
			$SQL .= "       ) AS BG                                                  ";
			$SQL .= "     LEFT OUTER JOIN                                            ";
			$SQL .= "       (SELECT BG_LNG_NO AS BG_NO,                              ";
			$SQL .= "              BG_NAME,                                          ";
			$SQL .= "              BG_FILE1,                                         ";
			$SQL .= "              BG_FILE2,                                         ";
			$SQL .= "              BG_MENU_USE,                                      ";
			$SQL .= "              BG_SORT                                           ";
			$SQL .= "         FROM BOARD_GROUP_NEW                                   ";
			$SQL .= "        WHERE BG_LNG = '{$param['LNG']}'                        ";
			$SQL .= "       ) AS BGL                                                 ";
			$SQL .= "         ON BGL.BG_NO = BG.BG_NO                                ";
			$SQL .= " {$strWhere1}													 ";
//			$SQL .= " ORDER BY BG.BG_NO ASC											 ";
			$SQL .= " {$strOrderBy}													 ";
//			$SQL .= " LIMIT 0,10													 ";
			$SQL .= " {$strLimit}													 ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getBoardGroupNewSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "*";

			## 검색(텍스트)
			if($param['searchKey']):
				$arySearchText['title']				= "BG.BG_NAME LIKE ('%{$param['searchKey']}%')";
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
			$aryWhere1 = "";
			if($param['BG_NO']) { $aryWhere1[] = "BG.BG_NO = {$param['BG_NO']}"; }
			if($param['BG_LNG']) { $aryWhere1[] = "BG.BG_LNG = '{$param['BG_LNG']}'"; }
			if($param['BG_LNG_NO']) { $aryWhere1[] = "BG.BG_LNG_NO = {$param['BG_LNG_NO']}"; }
			if($param['BG_MENU_USE']) { $aryWhere1[] = "BG.BG_MENU_USE = '{$param['BG_MENU_USE']}'"; }

			## order by 설정
			$aryOrderBy['noAsc']			= "BG.BG_NO ASC";
			$aryOrderBy['noDesc']			= "BG.BG_NO DESC";
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

			## join 설정
//			if($param['JOIN_STC'] == "Y"):
//				$aryJoin['JOIN_STC']  = "    JOIN														          ";
//				$aryJoin['JOIN_STC'] .= "        STORY_TOC AS STC	    										  ";
//				$aryJoin['JOIN_STC'] .= "        ON																  ";
//				$aryJoin['JOIN_STC'] .= "        SR.SR_NO = STC.STC_SR_NO  			 					          ";
//			endif;

			$SQL  = " SELECT {$strColumn}											 ";
			$SQL .= " FROM															 ";
			$SQL .= "	BOARD_GROUP_NEW AS BG										 ";
			$SQL .= " {$strWhere1}													 ";
//			$SQL .= " ORDER BY BG.BG_NO ASC											 ";
			$SQL .= " {$strOrderBy}													 ";
//			$SQL .= " LIMIT 0,10													 ";
			$SQL .= " {$strLimit}													 ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getBoardGroupNewInsertEx($param)
		{
			$paramData						= "";
//			$paramData['BG_NO']				= $this->db->getSQLInteger($param['BG_NO']);
			$paramData['BG_LNG']			= $this->db->getSQLString($param['BG_LNG']);
			$paramData['BG_LNG_NO']			= $this->db->getSQLInteger($param['BG_LNG_NO']);
			$paramData['BG_NAME']			= $this->db->getSQLString($param['BG_NAME']);
			$paramData['BG_FILE1']			= $this->db->getSQLString($param['BG_FILE1']);
			$paramData['BG_FILE2']			= $this->db->getSQLString($param['BG_FILE2']);
			$paramData['BG_MENU_USE']		= $this->db->getSQLString($param['BG_MENU_USE']);
			$paramData['BG_SORT']			= $this->db->getSQLInteger($param['BG_SORT']);
			$paramData['BG_REG_DT']			= $this->db->getSQLDatetime($param['BG_REG_DT']);
			$paramData['BG_REG_NO']			= $this->db->getSQLInteger($param['BG_REG_NO']);
			$paramData['BG_MOD_DT']			= $this->db->getSQLDatetime($param['BG_MOD_DT']);
			$paramData['BG_MOD_NO']			= $this->db->getSQLInteger($param['BG_MOD_NO']);

			return $this->db->getInsertParam("BOARD_GROUP_NEW", $paramData);
		}

		function getBoardGroupNewUpdateEx($param)
		{

			## 기본 설정
			$intBG_NO = $param['BG_NO'];

			## 체크
			if(!$intBG_NO) { return; }

			$paramData						= "";
//			$paramData['BG_NO']				= $this->db->getSQLInteger($param['BG_NO']);
//			$paramData['BG_LNG']			= $this->db->getSQLString($param['BG_LNG']);
//			$paramData['BG_LNG_NO']			= $this->db->getSQLInteger($param['BG_LNG_NO']);
			$paramData['BG_NAME']			= $this->db->getSQLString($param['BG_NAME']);
			$paramData['BG_FILE1']			= $this->db->getSQLString($param['BG_FILE1']);
			$paramData['BG_FILE2']			= $this->db->getSQLString($param['BG_FILE2']);
			$paramData['BG_MENU_USE']		= $this->db->getSQLString($param['BG_MENU_USE']);
			$paramData['BG_SORT']			= $this->db->getSQLInteger($param['BG_SORT']);
//			$paramData['BG_REG_DT']			= $this->db->getSQLDatetime($param['BG_REG_DT']);
//			$paramData['BG_REG_NO']			= $this->db->getSQLInteger($param['BG_REG_NO']);
			$paramData['BG_MOD_DT']			= $this->db->getSQLDatetime($param['BG_MOD_DT']);
			$paramData['BG_MOD_NO']			= $this->db->getSQLInteger($param['BG_MOD_NO']);
			
			## where 설정
			$where				= "BG_NO = {$intBG_NO}";

			return $this->db->getUpdateParam("BOARD_GROUP_NEW", $paramData, $where);
		}

		function getBoardGroupNewLngNoUpdateEx($param)
		{
			## 기본 설정
			$intBG_NO = $param['BG_NO'];
			$intBG_LNG_NO = $param['BG_LNG_NO'];

			## 체크
			if(!$intBG_NO) { return; }

			## 업데이트 항목 설정
			$paramData						= "";
			$paramData['BG_LNG_NO']			= $this->db->getSQLInteger($intBG_LNG_NO);

			## where 설정
			$where				= "BG_NO = {$intBG_NO}";

			return $this->db->getUpdateParam("BOARD_GROUP_NEW", $paramData, $where);
		}


		function getBoardGroupNewDeleteEx($param)
		{
			## 기본설정
			$where = "";
			$intBG_NO = $param['BG_NO'];
			$strBG_LNG = $param['BG_LNG'];
			$intBG_LNG_NO = $param['BG_LNG_NO'];

			## 공백 제거
			$strBG_LNG = trim($strBG_LNG ); 

			## where
			if($intBG_NO):
				$where = "BG_NO = {$intBG_NO}";
			elseif($strBG_LNG && $intBG_LNG_NO):
				$where = "BG_LNG = '{$strBG_LNG}' AND BG_LNG_NO = {$intBG_LNG_NO}";
			endif;
			
			if(!$where) { return; }

			return $this->db->getDelete("BOARD_GROUP_NEW", $where);
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