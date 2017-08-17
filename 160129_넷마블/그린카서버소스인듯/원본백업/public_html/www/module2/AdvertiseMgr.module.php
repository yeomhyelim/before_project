<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-06-11												|# 
#|작성내용	: 베너 그룹 모듈 클레스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class AdvertiseMgrModule extends Module2
{
		function getAdvertiseMgrSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "A.A_NO";
			$aryColumn[] = "A.A_NAME";
			$aryColumn[] = "A.A_TAG";
			$aryColumn[] = "A.A_LOCA";
			$aryColumn[] = "A.A_TABLE_W";
			$aryColumn[] = "A.A_TABLE_H";
			$aryColumn[] = "A.A_SIZE_W";
			$aryColumn[] = "A.A_SIZE_H";
			$aryColumn[] = "A.A_MARGIN_W";
			$aryColumn[] = "A.A_MARGIN_H";
			$aryColumn[] = "A.A_USE";
			$aryColumn[] = "A.A_REG_DT";
			$aryColumn[] = "A.A_REG_NO";
			$aryColumn[] = "A.A_MOD_DT";
			$aryColumn[] = "A.A_MOD_NO";

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
			if($param['A_NO']) { $aryWhere1[] = "A.A_NO = {$param['A_NO']}"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "A.A_NO ASC";
			$aryOrderBy['noDesc']			= "A.A_NO DESC";
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
//			$SQL .= "       A.*		                                       ";
			$SQL .= "  FROM                                                ";
			$SQL .= "       ADVERTISE AS A                                 ";
			$SQL .= " {$strWhere1}										   ";
//			$SQL .= "ORDER BY A.A_NO DESC                                  ";
			$SQL .= " {$strOrderBy}										   ";
//			$SQL .= "LIMIT 0,30                                            ";
			$SQL .= " {$strLimit}										   ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getAdvertiseMgrInsertEx($param)
		{

		}

		function getAdvertiseMgrUpdateEx($param)
		{

		}

		function getAdvertiseMgrDeleteEx($param)
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