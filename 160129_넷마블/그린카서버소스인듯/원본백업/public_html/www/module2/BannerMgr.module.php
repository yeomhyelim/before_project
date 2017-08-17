<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-04-30												|# 
#|작성내용	: 베너 모듈 클레스											|# 
#/*====================================================================*/# 

require_once "Module.php";

class BannerMgrModule extends Module2
{
		function getBannerMgrSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "B.*";
			$aryColumn[] = "A.A_NAME";

			## 검색(텍스트)
			if($param['searchKey']):
				$arySearchText['title']				= "B.B_TITLE LIKE ('%{$param['searchKey']}%')";
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
			if($param['B_NO']) { $aryWhere1[] = "B.B_NO = {$param['B_NO']}"; }
			if($param['A_NO']) { $aryWhere1[] = "B.A_NO = {$param['A_NO']}"; }
			if($param['B_VIEW']) { $aryWhere1[] = "B.B_VIEW = '{$param['B_VIEW']}'"; }
			if($param['B_TYPE']) { $aryWhere1[] = "B.B_TYPE = '{$param['B_TYPE']}'"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "B.B_NO ASC";
			$aryOrderBy['noDesc']			= "B.B_NO DESC";
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
//			$SQL .= "       B.*,                                           ";
//			$SQL .= "       A.A_NAME                                       ";
			$SQL .= "  FROM                                                ";
			$SQL .= "       BANNER AS B                                    ";
			$SQL .= "   LEFT OUTER JOIN ADVERTISE AS A ON A.A_NO = B.A_NO  ";
			$SQL .= " {$strWhere1}										   ";
//			$SQL .= "ORDER BY B.B_NO DESC                                  ";
			$SQL .= " {$strOrderBy}										   ";
//			$SQL .= "LIMIT 0,30                                            ";
			$SQL .= " {$strLimit}										   ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getBannerMgrInsertEx($param)
		{
			## 기본 설정
			$paramData = "";
			$aryUseLng = $param['ARY_USE_LNG'];

			## 유효성체크
			if(!$aryUseLng) { return; }

			## 입력 데이터 만들기			
//			$paramData['B_NO']					= $this->db->getSQLInteger($param['B_NO']);
			$paramData['A_NO']					= $this->db->getSQLString($param['A_NO']);
			$paramData['B_TITLE']				= $this->db->getSQLString($param['B_TITLE']);
			$paramData['B_VIEW']				= $this->db->getSQLString($param['B_VIEW']);
			$paramData['B_TYPE']				= $this->db->getSQLString($param['B_TYPE']);
			$paramData['B_START_DT']			= $this->db->getSQLDatetime($param['B_START_DT']);
			$paramData['B_END_DT']				= $this->db->getSQLDatetime($param['B_END_DT']);
			$paramData['B_LINK_URL']			= $this->db->getSQLString($param['B_LINK_URL']);
			$paramData['B_LINK_TYPE']			= $this->db->getSQLString($param['B_LINK_TYPE']);
			$paramData['B_FILE']				= $this->db->getSQLString($param['B_FILE']);
			$paramData['B_WIDTH']				= $this->db->getSQLInteger($param['B_WIDTH']);
			$paramData['B_HEIGHT']				= $this->db->getSQLInteger($param['B_HEIGHT']);
			$paramData['B_REG_DT']				= $this->db->getSQLDatetime($param['B_REG_DT']);
			$paramData['B_REG_NO']				= $this->db->getSQLInteger($param['B_REG_NO']);
			$paramData['B_MOD_DT']				= $this->db->getSQLDatetime($param['B_MOD_DT']);
			$paramData['B_MOD_NO']				= $this->db->getSQLInteger($param['B_MOD_NO']);
		
			## 언어별 컬럼 설정
			foreach($aryUseLng as $lng):
				$paramData["B_LINK_URL_{$lng}"] = $this->db->getSQLString($param["B_LINK_URL_{$lng}"]);
				$paramData["B_FILE_{$lng}"] = $this->db->getSQLString($param["B_FILE_{$lng}"]);
			endforeach;

			return $this->db->getInsertParam("BANNER", $paramData);
		}

		function getBannerMgrUpdateEx($param)
		{
			## 기본 설정
			$paramData = "";
			$aryUseLng = $param['ARY_USE_LNG'];

			## 유효성체크
			if(!$aryUseLng) { return; }

			## 입력 데이터 만들기			
//			$paramData['B_NO']					= $this->db->getSQLInteger($param['B_NO']);
			$paramData['A_NO']					= $this->db->getSQLString($param['A_NO']);
			$paramData['B_TITLE']				= $this->db->getSQLString($param['B_TITLE']);
			$paramData['B_VIEW']				= $this->db->getSQLString($param['B_VIEW']);
			$paramData['B_TYPE']				= $this->db->getSQLString($param['B_TYPE']);
			$paramData['B_START_DT']			= $this->db->getSQLDatetime($param['B_START_DT']);
			$paramData['B_END_DT']				= $this->db->getSQLDatetime($param['B_END_DT']);
			$paramData['B_LINK_URL']			= $this->db->getSQLString($param['B_LINK_URL']);
			$paramData['B_LINK_TYPE']			= $this->db->getSQLString($param['B_LINK_TYPE']);
			$paramData['B_FILE']				= $this->db->getSQLString($param['B_FILE']);
			$paramData['B_WIDTH']				= $this->db->getSQLInteger($param['B_WIDTH']);
			$paramData['B_HEIGHT']				= $this->db->getSQLInteger($param['B_HEIGHT']);
//			$paramData['B_REG_DT']				= $this->db->getSQLDatetime($param['B_REG_DT']);
//			$paramData['B_REG_NO']				= $this->db->getSQLInteger($param['B_REG_NO']);
			$paramData['B_MOD_DT']				= $this->db->getSQLDatetime($param['B_MOD_DT']);
			$paramData['B_MOD_NO']				= $this->db->getSQLInteger($param['B_MOD_NO']);
		
			## 언어별 컬럼 설정
			foreach($aryUseLng as $lng):
				$paramData["B_LINK_URL_{$lng}"] = $this->db->getSQLString($param["B_LINK_URL_{$lng}"]);
				$paramData["B_FILE_{$lng}"] = $this->db->getSQLString($param["B_FILE_{$lng}"]);
			endforeach;

			if($param['B_NO']):
				$no							= $this->db->getSQLInteger($param['B_NO']);
				$where						= "B_NO = {$no}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BANNER", $paramData, $where);	
		}

		function getBannerMgrDeleteEx($param)
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