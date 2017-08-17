<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-06-22												|# 
#|작성내용	: 움직이는 배너 이미지 모듈 클레스							|# 
#/*====================================================================*/# 

require_once "Module.php";

class DesignSliderBannerImgModule extends Module2
{
		function getDesignSliderBannerImgSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "SI.*";

			## where 설정
			$aryWhere1 = "";
			if($param['SI_NO']) { $aryWhere1[] = "SI.SI_NO = {$param['SI_NO']}"; }
			if($param['SB_NO']) { $aryWhere1[] = "SI.SB_NO = {$param['SB_NO']}"; }
			if($param['SI_LNG']) { $aryWhere1[] = "SI.SI_LNG = '{$param['SI_LNG']}'"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "SI.SI_NO ASC";
			$aryOrderBy['noDesc']			= "SI.SI_NO DESC";
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
			if($strOrderBy) { $strOrderBy = "ORDER BY {$strOrderBy}"; }
			if($strLimit) { $strLimit = "LIMIT {$strLimit}"; }

			$SQL =    "SELECT {$strColumn}                                 ";
			$SQL .= "  FROM                                                ";
			$SQL .= "       DESIGN_SLIDER_BANNER_IMG AS SI                 ";
			$SQL .= " {$strWhere1}										   ";
			$SQL .= " {$strOrderBy}										   ";
			$SQL .= " {$strLimit}										   ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getDesignSliderBannerImgInsertEx($param)
		{
			## 체크
			if(!trim($param['SB_NO'])) { return; }
			if(!trim($param['SI_LNG'])) { return; }

			$paramData						= "";
//			$paramData['SI_NO']				= $this->db->getSQLInteger($param['SI_NO']);
			$paramData['SB_NO']				= $this->db->getSQLInteger($param['SB_NO']);
			$paramData['SI_IMG']			= $this->db->getSQLString($param['SI_IMG']);
			$paramData['SI_LINK']			= $this->db->getSQLString($param['SI_LINK']);
			$paramData['SI_TEXT']			= $this->db->getSQLString($param['SI_TEXT']);
			$paramData['SI_LNG']			= $this->db->getSQLString($param['SI_LNG']);
			$paramData['SI_REG_DT']			= $this->db->getSQLDatetime($param['SI_REG_DT']);
			$paramData['SI_REG_NO']			= $this->db->getSQLInteger($param['SI_REG_NO']);
			$paramData['SI_MOD_DT']			= $this->db->getSQLDatetime($param['SI_MOD_DT']);
			$paramData['SI_MOD_NO']			= $this->db->getSQLInteger($param['SI_MOD_NO']);

			return $this->db->getInsertParam("DESIGN_SLIDER_BANNER_IMG", $paramData);
		}

		function getDesignSliderBannerImgUpdateEx($param)
		{
			## 체크
			if(!trim($param['SI_NO'])) { return; }

			$paramData						= "";
			$paramData['SI_IMG']			= $this->db->getSQLString($param['SI_IMG']);
			$paramData['SI_LINK']			= $this->db->getSQLString($param['SI_LINK']);
			$paramData['SI_TEXT']			= $this->db->getSQLString($param['SI_TEXT']);
			$paramData['SI_MOD_DT']			= $this->db->getSQLDatetime($param['SI_MOD_DT']);
			$paramData['SI_MOD_NO']			= $this->db->getSQLInteger($param['SI_MOD_NO']);

			if($param['SI_NO']):
				$intSI_NO			= $this->db->getSQLInteger($param['SI_NO']);
				$where				= "SI_NO = {$intSI_NO}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("DESIGN_SLIDER_BANNER_IMG", $paramData, $where);	

		}

		function getDesignSliderBannerImgDeleteEx($param)
		{

			## 체크
			if(!trim($param['SI_NO'])) { return; }

			$where					= "";
			
			if($param['SI_NO']):
				$intSI_NO			= $this->db->getSQLInteger($param['SI_NO']);
				$where				= "SI_NO = {$intSI_NO}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("DESIGN_SLIDER_BANNER_IMG", $where);
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