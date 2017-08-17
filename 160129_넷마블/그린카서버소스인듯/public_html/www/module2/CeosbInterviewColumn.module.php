<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-27												|# 
#|작성내용	: CEO 스케치북 - 감성 인터뷰 칼럼 모듈 클레스				|# 
#/*====================================================================*/# 

require_once "Module.php";

class CeosbInterviewColumnModule extends Module2
{
		function getCeosbInterviewColumnSelectEx($op, $param)
		{
			$column['OP_LIST']		= "IC.*";
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
				$order_by1		= "ORDER BY IC.IC_REG_DT DESC";
			endif;

			## where1
			$where1				= "WHERE IC.IC_CODE IS NOT NULL";

			if($param['IC_CODE']):
				$where1			= "{$where1} AND IC.IC_CODE = '{$param['IC_CODE']}'";
			endif;

			if($param['IC_USE']):
				$where1			= "{$where1} AND IC.IC_USE = '{$param['IC_USE']}'";
			endif;

			if($param['IC_KIND']):
				$where1			= "{$where1} AND IC.IC_KIND = {$param['IC_KIND']}";
			endif;

			## from1
			$from1				= "FROM _CEOSB_INTERVIEW_COLUMN AS IC";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$join10_1} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getCeosbInterviewColumnInsertEx($param)
		{
			$paramData						= "";
			$paramData['IC_CODE']			= $this->db->getSQLString($param['IC_CODE']);
			$paramData['IC_TITLE']			= $this->db->getSQLString($param['IC_TITLE']);
			$paramData['IC_KIND']			= $this->db->getSQLInteger($param['IC_KIND']);
			$paramData['IC_SUMMARY']		= $this->db->getSQLString($param['IC_SUMMARY']);
			$paramData['IC_PREVIEW']		= $this->db->getSQLString($param['IC_PREVIEW']);
			$paramData['IC_TEXT']			= $this->db->getSQLString($param['IC_TEXT']);
			$paramData['IC_KEYWORD']		= $this->db->getSQLString($param['IC_KEYWORD']);
//			$paramData['IC_VISIT_CNT']		= $this->db->getSQLInteger($param['IC_VISIT_CNT']);
			$paramData['IC_IMAGE1']			= $this->db->getSQLString($param['IC_IMAGE1']);
			$paramData['IC_IMAGE2']			= $this->db->getSQLString($param['IC_IMAGE2']);
//			$paramData['IC_IMAGE3']			= $this->db->getSQLString($param['IC_IMAGE3']); /** 사용을 원하시면 주석을 지우세요 **/
//			$paramData['IC_USE']			= $this->db->getSQLString($param['IC_USE']);
			$paramData['IC_REG_DT']			= $this->db->getSQLDatetime($param['IC_REG_DT']);
			$paramData['IC_REG_NO']			= $this->db->getSQLInteger($param['IC_REG_NO']);
			$paramData['IC_MOD_DT']			= $this->db->getSQLDatetime($param['IC_MOD_DT']);
			$paramData['IC_MOD_NO']			= $this->db->getSQLInteger($param['IC_MOD_NO']);

			return $this->db->getInsertParam("_CEOSB_INTERVIEW_COLUMN", $paramData);
		}

		function getCeosbInterviewColumnUpdateEx($param)
		{
			## 체크
			if(!$param['IC_CODE'])	{ return; }

			$paramData						= "";
//			$paramData['IC_CODE']			= $this->db->getSQLString($param['IC_CODE']);
			$paramData['IC_TITLE']			= $this->db->getSQLString($param['IC_TITLE']);
			$paramData['IC_KIND']			= $this->db->getSQLInteger($param['IC_KIND']);
			$paramData['IC_SUMMARY']		= $this->db->getSQLString($param['IC_SUMMARY']);
			$paramData['IC_PREVIEW']		= $this->db->getSQLString($param['IC_PREVIEW']);
			$paramData['IC_TEXT']			= $this->db->getSQLString($param['IC_TEXT']);
			$paramData['IC_KEYWORD']		= $this->db->getSQLString($param['IC_KEYWORD']);
//			$paramData['IC_VISIT_CNT']		= $this->db->getSQLInteger($param['IC_VISIT_CNT']);
			$paramData['IC_IMAGE1']			= $this->db->getSQLString($param['IC_IMAGE1']);
			$paramData['IC_IMAGE2']			= $this->db->getSQLString($param['IC_IMAGE2']);
//			$paramData['IC_IMAGE3']			= $this->db->getSQLString($param['IC_IMAGE3']);
			$paramData['IC_USE']			= $this->db->getSQLString($param['IC_USE']);
//			$paramData['IC_REG_DT']			= $this->db->getSQLDatetime($param['IC_REG_DT']);
//			$paramData['IC_REG_NO']			= $this->db->getSQLInteger($param['IC_REG_NO']);
			$paramData['IC_MOD_DT']			= $this->db->getSQLDatetime($param['IC_MOD_DT']);
			$paramData['IC_MOD_NO']			= $this->db->getSQLInteger($param['IC_MOD_NO']);

			if($param['IC_CODE']):
				$icCode				= $this->db->getSQLString($param['IC_CODE']);
				$where				= "IC_CODE = {$icCode}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("_CEOSB_INTERVIEW_COLUMN", $paramData, $where);	

		}

		function getCeosbInterviewColumnVisitCntUpdateEx($param)
		{
			## 체크
			if(!$param['IC_CODE'])	{ return; }

			$paramData						= "";
			$paramData['IC_VISIT_CNT']		= "IC_VISIT_CNT + 1";

			$icCode				= $this->db->getSQLString($param['IC_CODE']);
			$where				= "IC_CODE = {$icCode}";
		
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("_CEOSB_INTERVIEW_COLUMN", $paramData, $where);	

		}

		function getCeosbInterviewColumnDeleteEx($param)
		{
			## 체크
			if(!$param['IC_CODE']) { return; }

			$where					= "";
			
			if($param['IC_CODE']):
				$icCode				= $this->db->getSQLString($param['IC_CODE']);
				$where				= "IC_CODE = {$icCode}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("_CEOSB_INTERVIEW_COLUMN", $where);
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