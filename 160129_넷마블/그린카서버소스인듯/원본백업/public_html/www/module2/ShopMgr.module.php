<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-08-29												|# 
#|작성내용	: 입점몰관리 모듈 클레스									|# 
#/*====================================================================*/# 

require_once "Module.php";

class ShopMgrModule extends Module2
{

		function getShopMgrSelectEx($op, $param)
		{
			## column 설정
			$aryColumn[] = "SH.*";

			## 검색(텍스트)
			## 기본 설정
			$aryWhere1 = ""; 
//			$arySearchKey = $param['searchKey'];
//			$strSearchVal = $param['searchVal'];
		
			## 공백 제거
//			$strSearchVal = trim($strSearchVal);

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

			## where 설정
			if($param['SH_NO']) { $aryWhere1[] = "SH.SH_NO = {$param['SH_NO']}"; }
			if($param['SH_APPR']) {$aryWhere1[] = "SH.SH_APPR = '{$param['SH_APPR']}'"; }
			if($param['SH_COM_MAIN']) {$aryWhere1[] = "SH.SH_COM_MAIN = '{$param['SH_COM_MAIN']}'"; }

			## join 설정
//			if($param['JOIN_FL'] == "Y"):
//				$aryColumn[] = "FL.*";
//
//				$aryJoin['JOIN_FL']  = "    LEFT OUTER JOIN											          ";
//				$aryJoin['JOIN_FL'] .= "        BOARD_FL_{$param['B_CODE']} AS FL	    					  ";
//				$aryJoin['JOIN_FL'] .= "    ON																  ";
//				$aryJoin['JOIN_FL'] .= "        FL.FL_UB_NO = UB.UB_NO AND FL.FL_KEY = 'listImage' 		      ";
//			endif;

			## order by 설정
			$aryOrderBy['noAsc']			= "SH.SH_NO ASC";
			$aryOrderBy['noDesc']			= "SH.SH_NO DESC";
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
			$SQL .= " FROM                                                              ";
			$SQL .= "	SHOP_MGR AS SH													";
			$SQL .= " {$strWhere1}										                ";
			$SQL .= " {$strOrderBy}									                    ";
			$SQL .= " {$strLimit}										                ";

			## 결과
			return $this->getSelectQuery($SQL, $op);	
		}	

		function getShopMgrInsertEx($param)
		{

		}


		function getShopMgrUpdateEx($param)
		{

		}

		function getShopMgrComCountryUpdateEx($param)
		{
			## 기본 설정
			$intSH_NO = $param['SH_NO'];

			## 체크
			if(!$intSH_NO) { return; }

			## where 설정
			$where = "SH_NO = {$intSH_NO}";

			## 업데이트 
			$paramData						= "";
			$paramData['SH_COM_ZIP']		= $this->db->getSQLString($param['SH_COM_ZIP']);
			$paramData['SH_COM_ADDR']		= $this->db->getSQLString($param['SH_COM_ADDR']);
			$paramData['SH_COM_ADDR2']		= $this->db->getSQLString($param['SH_COM_ADDR2']);
			$paramData['SH_COM_COUNTRY']	= $this->db->getSQLString($param['SH_COM_COUNTRY']);
			$paramData['SH_COM_CITY']		= $this->db->getSQLString($param['SH_COM_CITY']);
			$paramData['SH_COM_STATE']		= $this->db->getSQLString($param['SH_COM_STATE']);

			return $this->db->getUpdateParam("SHOP_MGR", $paramData, $where);	
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