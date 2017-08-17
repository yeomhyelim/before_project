<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-06-16												|# 
#|작성내용	: 카테고리 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class CateMgrModule extends Module2
{
		function getCateMgrSelectEx($op, $param)
		{
			
			## 체크
			if(!$param['LNG']) { return; }		

			## column 설정
			$aryColumn[] = "C.C_CODE";
			$aryColumn[] = "C.C_LEVEL";
			$aryColumn[] = "C.C_LOW_YN";
			$aryColumn[] = "C.C_HCODE";
			$aryColumn[] = "C.C_GROUP";
			$aryColumn[] = "C.C_ORDER";
			$aryColumn[] = "C.C_VIEW_YN";
			$aryColumn[] = "C.C_SHARE";
			$aryColumn[] = "C.C_TYPE";
			$aryColumn[] = "C.C_REG_DT";
			$aryColumn[] = "C.C_REG_NO";
			$aryColumn[] = "C.C_MOD_DT";
			$aryColumn[] = "C.C_MOD_NO";
			$aryColumn[] = "CL.CL_NAME";
			$aryColumn[] = "CL.CL_IMG1";
			$aryColumn[] = "CL.CL_IMG2";

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
			if($param['C_CODE']) { $aryWhere1[] = "C.C_CODE = '{$param['C_CODE']}'"; }
			if($param['C_SHARE']) { $aryWhere1[] = "C.C_SHARE = '{$param['C_SHARE']}'"; }
			if($param['C_VIEW_YN']) { $aryWhere1[] = "C.C_VIEW_YN = '{$param['C_VIEW_YN']}'"; }
			if($param['C_TYPE']) { $aryWhere1[] = "C.C_TYPE = '{$param['C_TYPE']}'"; }
			if($param['C_TYPE_NULL']) { $aryWhere1[] = "C.C_TYPE IS NULL"; } 
			if($param['CL_VIEW_YN']) { $aryWhere1[] = "CL.CL_VIEW_YN = '{$param['CL_VIEW_YN']}'"; }
			
			## order by 설정
			$strOrderBy						= "";
			$aryOrderBy['orderAsc']			= "C.C_ORDER ASC";
			$aryOrderBy['orderDesc']		= "C.C_ORDER DESC";
			$aryOrderBy['levelAsc']			= "C.C_LEVEL ASC";
			$aryOrderBy['levelDesc']		= "C.C_LEVEL DESC";
			$aryOrderBy['codeAsc']			= "C.C_CODE ASC";
			$aryOrderBy['codeDesc']			= "C.C_CODE DESC";
			if($param['ORDER_BY']):
				if(!is_array($param['ORDER_BY'])) { $param['ORDER_BY'][] = $param['ORDER_BY']; }
				foreach($param['ORDER_BY'] as $order):
					if($strOrderBy) { $strOrderBy .= ", "; }
					$strOrderBy .= $aryOrderBy[$order];
				endforeach;
			endif;


			## limit 설정
			if($param['LIMIT']):
				list($param['LIMIT_START'], $param['LIMIT_END']) = explode(",", $param['LIMIT']);
			endif;
			if($param['LIMIT_END']):
				if(!$param['LIMIT_START']) { $param['LIMIT_START'] = 0; }
				$strLimit					= "{$param['LIMIT_START']},{$param['LIMIT_END']}";
			endif;
	
			## join 설정
//			if($param['JOIN_STC'] == "Y"):
//				$aryJoin['JOIN_STC']  = "    JOIN														          ";
//				$aryJoin['JOIN_STC'] .= "        STORY_TOC AS STC	    										  ";
//				$aryJoin['JOIN_STC'] .= "        ON																  ";
//				$aryJoin['JOIN_STC'] .= "        SR.SR_NO = STC.STC_SR_NO  			 					          ";
//			endif;

			## 쿼리 만들기
			if($aryColumn) { $strColumn = implode(",", $aryColumn); } 
			if($op == "OP_COUNT") { $strColumn = "COUNT(*)"; }
			if(!$strColumn) { $strColumn = "*"; }
			if($aryWhere1) { $strWhere1 = "WHERE " .  implode(" AND ", $aryWhere1); } 
//			if($aryWhere2) { $strWhere2 = "WHERE " .  implode(" AND ", $aryWhere2); } 
//			if($aryWhere3) { $strWhere3 = "WHERE " .  implode(" AND ", $aryWhere3); } 
			if($strOrderBy) { $strOrderBy = "ORDER BY {$strOrderBy}"; }
			if($strLimit) { $strLimit = "LIMIT {$strLimit}"; }


			$SQL =    "SELECT {$strColumn}										";
//			$SQL .= "       C.*													";
			$SQL .= "  FROM														";
			$SQL .= "       CATE_MGR AS C										";
			$SQL .= "  LEFT OUTER JOIN CATE_LNG AS CL							";
			$SQL .= "  ON														";
			$SQL .= "  CL.C_CODE = C.C_CODE	AND CL.CL_LNG = '{$param['LNG']}'	";
			$SQL .= " {$strWhere1}												";
//			$SQL .= "ORDER BY C.C_CODE DESC										";
			$SQL .= " {$strOrderBy}												";
//			$SQL .= "LIMIT 0,30													";
			$SQL .= " {$strLimit}												";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getCateMgrInsertEx($param)
		{

		}

		function getCateMgrUpdateEx($param)
		{

		}

		function getCateMgrDeleteEx($param)
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