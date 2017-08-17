<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-06-21												|# 
#|작성내용	: 커뮤니티 그룹 언어별 모듈 클레스							|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardGroupLngModule extends Module2
{
		function getBoardGroupLngSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "BGL.*";

			## 검색(텍스트)
			if($param['searchKey']):
				$arySearchText['title']				= "BGL.BGL_NAME LIKE ('%{$param['searchKey']}%')";
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
			if($param['BGL_NO']) { $aryWhere1[] = "BGL.BGL_NO = {$param['BG_NO']}"; }
			if($param['BGL_BG_NO']) { $aryWhere1[] = "BGL.BGL_BG_NO = {$param['BGL_BG_NO']}"; }
			if($param['BGL_LNG']) { $aryWhere1[] = "BGL.BGL_LNG = '{$param['BGL_LNG']}'"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "BGL.BGL_NO ASC";
			$aryOrderBy['noDesc']			= "BGL.BGL_NO DESC";
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
			$SQL .= "  FROM                                                ";
			$SQL .= "       BOARD_GROUP_LNG AS BGL                         ";
			$SQL .= "  {$strWhere1}										   ";
//			$SQL .= "ORDER BY BGL.BGL_NO ASC                               ";
			$SQL .= " {$strOrderBy}										   ";
//			$SQL .= "LIMIT 0,10                                            ";
			$SQL .= " {$strLimit}										   ";

			## 결과
			return $this->getSelectQuery($SQL, $op);

		}

		function getBoardGroupLngInsertEx($param)
		{
			$paramData						= "";
//			$paramData['BGL_NO']			= $this->db->getSQLInteger($param['BGL_NO']);
			$paramData['BGL_BG_NO']			= $this->db->getSQLInteger($param['BGL_BG_NO']);
			$paramData['BGL_LNG']			= $this->db->getSQLString($param['BGL_LNG']);
			$paramData['BGL_NAME']			= $this->db->getSQLString($param['BGL_NAME']);
			$paramData['BGL_FILE1']			= $this->db->getSQLString($param['BGL_FILE1']);
			$paramData['BGL_FILE2']			= $this->db->getSQLString($param['BGL_FILE2']);
			$paramData['BGL_MENU_USE']		= $this->db->getSQLString($param['BGL_MENU_USE']);
			$paramData['BGL_SORT']			= $this->db->getSQLInteger($param['BGL_SORT']);
			$paramData['BGL_REG_DT']		= $this->db->getSQLDatetime($param['BGL_REG_DT']);
			$paramData['BGL_REG_NO']		= $this->db->getSQLInteger($param['BGL_REG_NO']);
			$paramData['BGL_MOD_DT']		= $this->db->getSQLDatetime($param['BGL_MOD_DT']);
			$paramData['BGL_MOD_NO']		= $this->db->getSQLInteger($param['BGL_MOD_NO']);

			return $this->db->getInsertParam("BOARD_GROUP_LNG", $paramData);
		}

		function getBoardGroupLngUpdateEx($param)
		{

			$paramData						= "";
//			$paramData['BGL_NO']			= $this->db->getSQLInteger($param['BGL_NO']);
//			$paramData['BGL_BG_NO']			= $this->db->getSQLString($param['BGL_BG_NO']);
//			$paramData['BGL_LNG']			= $this->db->getSQLString($param['BGL_LNG']);
			$paramData['BGL_NAME']			= $this->db->getSQLString($param['BGL_NAME']);
			$paramData['BGL_FILE1']			= $this->db->getSQLString($param['BGL_FILE1']);
			$paramData['BGL_FILE2']			= $this->db->getSQLString($param['BGL_FILE2']);
			$paramData['BGL_MENU_USE']		= $this->db->getSQLString($param['BGL_MENU_USE']);
			$paramData['BGL_SORT']			= $this->db->getSQLInteger($param['BGL_SORT']);
//			$paramData['BGL_REG_DT']		= $this->db->getSQLDatetime($param['BGL_REG_DT']);
//			$paramData['BGL_REG_NO']		= $this->db->getSQLInteger($param['BGL_REG_NO']);
			$paramData['BGL_MOD_DT']		= $this->db->getSQLDatetime($param['BGL_MOD_DT']);
			$paramData['BGL_MOD_NO']		= $this->db->getSQLInteger($param['BGL_MOD_NO']);

			if($param['BG_NO']):
				$no					= $this->db->getSQLInteger($param['BGL_BG_NO']);
				$where				= "BGL_BG_NO = {$no}";
			endif;
			
			if($param['BGL_BG_NO'] && $param['BGL_LNG']):
				$no					= $this->db->getSQLInteger($param['BGL_BG_NO']);
				$lng				= $this->db->getSQLString($param['BGL_LNG']);
				$where				= "BGL_BG_NO = {$no} AND BGL_LNG = {$lng}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getUpdateParam("BOARD_GROUP_LNG", $paramData, $where);

		}

		function getBoardGroupLngDeleteEx($param)
		{
			$where			= "";
			
			if($param['BGL_NO']):
				$intNo				= $this->db->getSQLInteger($param['BGL_NO']);
				$where				= "BGL_NO = {$intNo}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("BOARD_GROUP_LNG", $where);
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