<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2014-07-13												|# 
#|작성내용	: 커뮤니티 카테고리 언어별 모듈 클레스						|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardCategoryLngModule extends Module2
{
		function getBoardCategoryLngSelectEx($op, $param)
		{
			$column['OP_LIST']		= "BCL.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## query(1) 영역
			
			## limit1
			if($param['LIMIT']):
				$limit1			= "LIMIT {$param['LIMIT']}";
			endif;		
			
			## order_by1
			if($param['ORDER_BY']):
				$order_by1		= "ORDER BY {$param['ORDER_BY']}";
			else:
				## default
				$order_by1		= "ORDER BY BCL.BCL_REG_DT ASC";
			endif;

			## where1
			$where1				= "WHERE BCL.BCL_BC_NO IS NOT NULL";

			if($param['BCL_BC_NO']):
				$where1			= "{$where1} AND BCL.BCL_BC_NO = {$param['BCL_BC_NO']}";
			endif;

			if($param['BCL_LNG']):
				$where1			= "{$where1} AND BCL.BCL_LNG = '{$param['BCL_LNG']}'";
			endif;

			## from1
			$from1				= "FROM BOARD_CATEGORY_LNG AS BCL";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getBoardCategoryLngInsertEx($param)
		{
			## 체크
			if(!$param['BCL_BC_NO']) { return; }
			if(!$param['BCL_LNG']) { return; }

			$paramData						= "";
			$paramData['BCL_BC_NO']			= $this->db->getSQLInteger($param['BCL_BC_NO']);
			$paramData['BCL_LNG']			= $this->db->getSQLString($param['BCL_LNG']);
			$paramData['BCL_NAME']			= $this->db->getSQLString($param['BCL_NAME']);
			$paramData['BCL_IMAGE_1']		= $this->db->getSQLString($param['BCL_IMAGE_1']);
			$paramData['BCL_IMAGE_2']		= $this->db->getSQLString($param['BCL_IMAGE_2']);
			$paramData['BCL_REG_DT']		= $this->db->getSQLDatetime($param['BCL_REG_DT']);
			$paramData['BCL_REG_NO']		= $this->db->getSQLInteger($param['BCL_REG_NO']);
			$paramData['BCL_MOD_DT']		= $this->db->getSQLDatetime($param['BCL_MOD_DT']);
			$paramData['BCL_MOD_NO']		= $this->db->getSQLInteger($param['BCL_MOD_NO']);

			return $this->db->getInsertParam("BOARD_CATEGORY_LNG", $paramData);
		}

		function getBoardCategoryLngUpdateEx($param)
		{
			## 기본 설정
			$intBCL_BC_NO = $param['BCL_BC_NO'];
			$strBCL_LNG = $param['BCL_LNG'];

			## 공백제거
			$intBCL_BC_NO = trim($intBCL_BC_NO);
			$strBCL_LNG = trim($strBCL_LNG);

			## 체크
			if(!$intBCL_BC_NO) { return; }
			if(!$strBCL_LNG) { return; }

			## 기본 설정
			$paramData						= "";
//			$paramData['BCL_BC_NO']			= $this->db->getSQLInteger($param['BCL_BC_NO']);
//			$paramData['BCL_LNG']			= $this->db->getSQLString($param['BCL_LNG']);
			$paramData['BCL_NAME']			= $this->db->getSQLString($param['BCL_NAME']);
			$paramData['BCL_IMAGE_1']		= $this->db->getSQLString($param['BCL_IMAGE_1']);
			$paramData['BCL_IMAGE_2']		= $this->db->getSQLString($param['BCL_IMAGE_2']);
//			$paramData['BCL_REG_DT']		= $this->db->getSQLDatetime($param['BCL_REG_DT']);
//			$paramData['BCL_REG_NO']		= $this->db->getSQLInteger($param['BCL_REG_NO']);
			$paramData['BCL_MOD_DT']		= $this->db->getSQLDatetime($param['BCL_MOD_DT']);
			$paramData['BCL_MOD_NO']		= $this->db->getSQLInteger($param['BCL_MOD_NO']);

			## WHERE 절 설정
			$where							= "BCL_BC_NO = {$intBCL_BC_NO} AND BCL_LNG = '{$strBCL_LNG}'";

			return $this->db->getUpdateParam("BOARD_CATEGORY_LNG", $paramData, $where);	
		}

		function getBoardCategoryLngDeleteEx($param)
		{
			## 기본 설정
			$intBCL_BC_NO = $param['BCL_BC_NO'];
			$strBCL_LNG = $param['BCL_LNG'];

			## 공백제거
			$intBCL_BC_NO = trim($intBCL_BC_NO);
			$strBCL_LNG = trim($strBCL_LNG);

			## 체크
			if(!$intBCL_BC_NO) { return; }
			if(!$strBCL_LNG) { return; }
			
			## WHERE 절 설정
			$where							= "BCL_BC_NO = {$intBCL_BC_NO} AND BCL_LNG = '{$strBCL_LNG}'";

			return $this->db->getDelete("BOARD_CATEGORY_LNG", $where);
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