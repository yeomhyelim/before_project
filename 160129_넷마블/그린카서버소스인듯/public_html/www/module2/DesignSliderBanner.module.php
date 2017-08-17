<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-06-22												|# 
#|작성내용	: 움직이는 배너 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class DesignSliderBannerModule extends Module2
{
		function getDesignSliderBannerSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "SB.*";

			## where 설정
			$aryWhere1 = "";
			if($param['SB_NO']) { $aryWhere1[] = "SB.SB_NO = {$param['SB_NO']}"; }
			if($param['SB_CODE']) { $aryWhere1[] = "SB.SB_CODE = '{$param['SB_CODE']}'"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "SB.SB_NO ASC";
			$aryOrderBy['noDesc']			= "SB.SB_NO DESC";
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
			$SQL .= "       DESIGN_SLIDER_BANNER AS SB                     ";
			$SQL .= " {$strWhere1}										   ";
			$SQL .= " {$strOrderBy}										   ";
			$SQL .= " {$strLimit}										   ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getDesignSliderBannerInsertEx($param)
		{
			## 체크
			if(!trim($param['SB_CODE'])) { return; }

			$paramData						= "";
//			$paramData['SB_NO']				= $this->db->getSQLInteger($param['SB_NO']);
			$paramData['SB_CODE']			= $this->db->getSQLString($param['SB_CODE']);
			$paramData['SB_COMMENT']		= $this->db->getSQLString($param['SB_COMMENT']);
			$paramData['SB_W_SIZE']			= $this->db->getSQLInteger($param['SB_W_SIZE']);
			$paramData['SB_H_SIZE']			= $this->db->getSQLInteger($param['SB_H_SIZE']);
			$paramData['SB_LINK_TYPE']		= $this->db->getSQLString($param['SB_LINK_TYPE']);
			$paramData['SB_REG_DT']			= $this->db->getSQLDatetime($param['SB_REG_DT']);
			$paramData['SB_REG_NO']			= $this->db->getSQLInteger($param['SB_REG_NO']);
			$paramData['SB_MOD_DT']			= $this->db->getSQLDatetime($param['SB_MOD_DT']);
			$paramData['SB_MOD_NO']			= $this->db->getSQLInteger($param['SB_MOD_NO']);

			return $this->db->getInsertParam("DESIGN_SLIDER_BANNER", $paramData);
		}

		function getDesignSliderBannerUpdateEx($param)
		{
			## 체크
			if(!trim($param['SB_NO'])) { return; }

			$paramData						= "";
			$paramData['SB_COMMENT']		= $this->db->getSQLString($param['SB_COMMENT']);
			$paramData['SB_LINK_TYPE']		= $this->db->getSQLString($param['SB_LINK_TYPE']);
			$paramData['SB_MOD_DT']			= $this->db->getSQLDatetime($param['SB_MOD_DT']);
			$paramData['SB_MOD_NO']			= $this->db->getSQLInteger($param['SB_MOD_NO']);

			if($param['SB_NO']):
				$intSB_NO			= $this->db->getSQLInteger($param['SB_NO']);
				$where				= "SB_NO = {$intSB_NO}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("DESIGN_SLIDER_BANNER", $paramData, $where);	

		}

		function getDesignSliderBannerDeleteEx($param)
		{
			## 체크
			if(!trim($param['SB_NO'])) { return; }

			$where					= "";
			
			if($param['SB_NO']):
				$intSB_NO			= $this->db->getSQLInteger($param['SB_NO']);
				$where				= "SB_NO = {$intSB_NO}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("DESIGN_SLIDER_BANNER", $where);

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