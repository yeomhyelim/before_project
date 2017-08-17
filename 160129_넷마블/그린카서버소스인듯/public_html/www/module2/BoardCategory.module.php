<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-03												|# 
#|작성내용	: 커뮤니티 카테고리 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardCategoryModule extends Module2
{

		function getBoardCategorySelectEx($op, $param)
		{
			## column 설정
			$aryColumn   = "";
			$aryColumn[] = "BC.BC_NO AS BC_NO";
			$aryColumn[] = "BC.BC_NAME AS BC_NAME";
			$aryColumn[] = "BC.BC_IMAGE_1 AS BC_IMAGE_1";
			$aryColumn[] = "BC.BC_IMAGE_2 AS BC_IMAGE_2";
			$aryColumn[] = "BCL.BCL_NAME AS BCL_NAME";
			$aryColumn[] = "BCL.BCL_IMAGE_1 AS BCL_IMAGE_1";
			$aryColumn[] = "BCL.BCL_IMAGE_2 AS BCL_IMAGE_2";
			$aryColumn[] = "BC.BC_SORT";

			## 체크
			if(!$param['LNG']) { return; }

			## 검색(텍스트)
//			if($param['searchKey']):
//				$arySearchText['title']				= "BC.BG_NAME LIKE ('%{$param['searchKey']}%')";
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
			if($param['BC_NO']) { $aryWhere1[] = "BC.BC_NO = {$param['BC_NO']}"; }
			if($param['BC_B_CODE']) { $aryWhere1[] = "BC.BC_B_CODE = '{$param['BC_B_CODE']}'"; }
			
			## order by 설정
			$aryOrderBy['noAsc']			= "BC.BG_NO ASC";
			$aryOrderBy['noDesc']			= "BC.BG_NO DESC";
			$aryOrderBy['sortAsc']			= "BC.BC_SORT ASC";
			$aryOrderBy['sortDesc']			= "BC.BC_SORT DESC";
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

			$SQL  = " SELECT																	 ";
			$SQL .= "		{$strColumn}														 ";
//			$SQL .= "       BC.BC_NO AS BC_NO,													 ";
//			$SQL .= "       IFNULL( BCL.BCL_NAME, BC.BC_NAME) AS BC_NAME,						 ";
//			$SQL .= "       IFNULL( BCL.BCL_IMAGE_1, BC.BC_IMAGE_1) AS BC_IMAGE_1,				 ";
//			$SQL .= "       IFNULL( BCL.BCL_IMAGE_2, BC.BC_IMAGE_2) AS BC_IMAGE_2,				 ";
//			$SQL .= "       BC.BC_SORT															 ";
			$SQL .= " FROM																		 ";
			$SQL .= "       BOARD_CATEGORY AS BC												 ";
			$SQL .= " LEFT OUTER JOIN															 ";
			$SQL .= "       BOARD_CATEGORY_LNG AS BCL											 ";
			$SQL .= "       ON																	 ";
			$SQL .= "       BCL.BCL_BC_NO = BC.BC_NO AND BCL.BCL_LNG = '{$param['LNG']}'         ";
//			$SQL .= " WHERE																		 ";
//			$SQL .= "		BC.BC_B_CODE = 'TEST001'											 ";
			$SQL .= " {$strWhere1}																 ";
//			$SQL .= "ORDER BY BC.BC_NO ASC														 ";
			$SQL .= " {$strOrderBy}																 ";
//			$SQL .= "LIMIT 0,10																	 ";
			$SQL .= " {$strLimit}																 ";

			## 결과
			return $this->getSelectQuery($SQL, $op);
		}

		function getBoardCategoryInsertEx($param)
		{
			## 체크
			if(!$param['BC_B_CODE']) { return; }

			$paramData						= "";
//			$paramData['BC_NO']				= $this->db->getSQLInteger($param['BC_NO']);
			$paramData['BC_B_CODE']			= $this->db->getSQLString($param['BC_B_CODE']);
			$paramData['BC_NAME']			= $this->db->getSQLString($param['BC_NAME']);
			$paramData['BC_IMAGE_1']		= $this->db->getSQLString($param['BC_IMAGE_1']);
			$paramData['BC_IMAGE_2']		= $this->db->getSQLString($param['BC_IMAGE_2']);
			$paramData['BC_SORT']			= $this->db->getSQLInteger($param['BC_SORT']);
			$paramData['BC_REG_DT']			= $this->db->getSQLDatetime($param['BC_REG_DT']);
			$paramData['BC_REG_NO']			= $this->db->getSQLInteger($param['BC_REG_NO']);
			$paramData['BC_MOD_DT']			= $this->db->getSQLDatetime($param['BC_MOD_DT']);
			$paramData['BC_MOD_NO']			= $this->db->getSQLInteger($param['BC_MOD_NO']);

			return $this->db->getInsertParam("BOARD_CATEGORY", $paramData);
		}

		function getBoardCategoryUpdateEx($param)
		{
			## 기본 설정
			$paramData						= "";
//			$paramData['BC_NO']				= $this->db->getSQLInteger($param['BC_NO']);
//			$paramData['BC_B_CODE']			= $this->db->getSQLString($param['BC_B_CODE']);
			$paramData['BC_NAME']			= $this->db->getSQLString($param['BC_NAME']);
			$paramData['BC_IMAGE_1']		= $this->db->getSQLString($param['BC_IMAGE_1']);
			$paramData['BC_IMAGE_2']		= $this->db->getSQLString($param['BC_IMAGE_2']);
			$paramData['BC_SORT']			= $this->db->getSQLInteger($param['BC_SORT']);
//			$paramData['BC_REG_DT']			= $this->db->getSQLDatetime($param['BC_REG_DT']);
//			$paramData['BC_REG_NO']			= $this->db->getSQLInteger($param['BC_REG_NO']);
			$paramData['BC_MOD_DT']			= $this->db->getSQLDatetime($param['BC_MOD_DT']);
			$paramData['BC_MOD_NO']			= $this->db->getSQLInteger($param['BC_MOD_NO']);

			## where 절 설정
			$intBcNo						= $this->db->getSQLInteger($param['BC_NO']);
			if(!$intBcNo) { return; }
			$where							= "BC_NO = {$intBcNo}";

			return $this->db->getUpdateParam("BOARD_CATEGORY", $paramData, $where);	
		}

		function getBoardCategoryDeleteEx($param)
		{
			## 기본 설정
			$intBC_NO = $param['BC_NO'];

			## 공백제거
			$intBC_NO = trim($intBC_NO);

			## 체크
			if(!$intBC_NO) { return; }
			
			## WHERE 절 설정
			$where							= "BC_NO = {$intBC_NO}";

			return $this->db->getDelete("BOARD_CATEGORY", $where);
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