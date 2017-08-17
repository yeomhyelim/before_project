<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-06-15												|# 
#|작성내용	: 커뮤니티 파일 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardFileModule extends Module2
{
		function getBoardFileSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "FL.FL_NO";
			$aryColumn[] = "FL.FL_UB_NO";
			$aryColumn[] = "FL.FL_KEY";
			$aryColumn[] = "FL.FL_DIR";
			$aryColumn[] = "FL.FL_NAME";
			$aryColumn[] = "FL.FL_TYPE";
			$aryColumn[] = "FL.FL_SIZE";
			$aryColumn[] = "FL.FL_REG_DT";
			$aryColumn[] = "FL.FL_REG_NO";
			$aryColumn[] = "FL.FL_MOD_DT";
			$aryColumn[] = "FL.FL_MOD_NO";
			
			## 체크
			if(!$param['B_CODE']) { return; }

			## 검색(텍스트)
//			if($param['searchKey']):
//				$arySearchText['title']				= "B.B_TITLE LIKE ('%{$param['searchKey']}%')";
//				$temp								= $arySearchText[$param['searchField']];
//				if(!$temp):
//					foreach($arySearchText as $key => $data):
//						if($temp) { $temp = "{$temp} OR"; }
//						$temp = "{$temp} {$data}";
//					endforeach;
//					$temp		= "( {$temp} )";
//				endif;
//				$aryWhere1[] = $temp;
//			endif;

			## where 설정
			$aryWhere1 = "";
			if($param['FL_NO']) { $aryWhere1[] = "FL.FL_NO = {$param['FL_NO']}"; }
			if($param['FL_UB_NO']) { $aryWhere1[] = "FL.FL_UB_NO = {$param['FL_UB_NO']}"; }
			if($param['FL_KEY']):
				$strTemp = $param['FL_KEY'];
				if(!is_array($strTemp)):
					$aryWhere1[] = "FL.FL_KEY = '{$strTemp}'";
				else:
					$strTemp = implode("','", $strTemp);
					$aryWhere1[] = "FL.FL_KEY IN('{$strTemp}')";
				endif;
			endif;

			
			## order by 설정
			$aryOrderBy['noAsc']			= "FL.FL_NO ASC";
			$aryOrderBy['noDesc']			= "FL.FL_NO DESC";
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

			$SQL =    "SELECT {$strColumn}                                 ";
//			$SQL .= "       FL.*		                                   ";
			$SQL .= "  FROM                                                ";
			$SQL .= "       BOARD_FL_{$param['B_CODE']} AS FL              ";
			$SQL .= " {$strWhere1}										   ";
//			$SQL .= "ORDER BY FL.FL_NO DESC                                ";
			$SQL .= " {$strOrderBy}										   ";
//			$SQL .= "LIMIT 0,30                                            ";
			$SQL .= " {$strLimit}										   ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getBoardFileInsertEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['FL_UB_NO']) { return; }

			$paramData						= "";
//			$paramData['FL_NO']				= $this->db->getSQLInteger($param['FL_NO']);
			$paramData['FL_UB_NO']			= $this->db->getSQLInteger($param['FL_UB_NO']);
			$paramData['FL_KEY']			= $this->db->getSQLString($param['FL_KEY']);
			$paramData['FL_DIR']			= $this->db->getSQLString($param['FL_DIR']);
			$paramData['FL_NAME']			= $this->db->getSQLString($param['FL_NAME']);
			$paramData['FL_TYPE']			= $this->db->getSQLString($param['FL_TYPE']);
			$paramData['FL_SIZE']			= $this->db->getSQLInteger($param['FL_SIZE']);
			$paramData['FL_REG_DT']			= $this->db->getSQLDatetime($param['FL_REG_DT']);
			$paramData['FL_REG_NO']			= $this->db->getSQLInteger($param['FL_REG_NO']);
			$paramData['FL_MOD_DT']			= $this->db->getSQLDatetime($param['FL_MOD_DT']);
			$paramData['FL_MOD_NO']			= $this->db->getSQLInteger($param['FL_MOD_NO']);

			return $this->db->getInsertParam("BOARD_FL_{$param['B_CODE']}", $paramData);

		}

		function getBoardFileUpdateEx($param)
		{

		}

		function getBoardFileUbNoDeleteEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['FL_UB_NO']) { return; }

			$where					= "";
			
			if($param['FL_UB_NO']):
				$intUbNo			= $this->db->getSQLInteger($param['FL_UB_NO']);
				$where				= "FL_UB_NO = {$intUbNo}";
			endif;
			
			if(!$where) { return; }

			return $this->db->getDelete("BOARD_FL_{$param['B_CODE']}", $where);
		}

		function getBoardFileDeleteEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['FL_NO']) { return; }

			$where					= "";
			
			if($param['FL_NO']):
				$intNo				= $this->db->getSQLInteger($param['FL_NO']);
				$where				= "FL_NO = {$intNo}";
			endif;
			
			if(!$where) { return; }

			return $this->db->getDelete("BOARD_FL_{$param['B_CODE']}", $where);
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