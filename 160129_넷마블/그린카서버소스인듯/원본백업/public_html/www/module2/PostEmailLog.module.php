<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-12												|# 
#|작성내용	: 메일 발송 로그 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class PostEmailLogModule extends Module2
{
		function getPostEmailLogSelectEx($op, $param)
		{
			$column['OP_LIST']		= "PL.*";
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
				$order_by1		= "ORDER BY PL.PL_NO ASC";
			endif;

			## where1
			$where1				= "WHERE PL.PL_NO IS NOT NULL";

			if($param['PL_NO']):
				$where1			= "{$where1} AND PL.PL_NO = {$param['PL_NO']}";
			endif;

			if($param['PL_PM_NO']):
				$where1			= "{$where1} AND PL.PL_PM_NO = {$param['PL_PM_NO']}";
			endif;

			if($param['PL_TO_M_NO']):
				$where1			= "{$where1} AND PL.PL_TO_M_NO = {$param['PL_TO_M_NO']}";
			endif;


			## from1
			$from1				= "FROM POST_MAIL_LOG AS PL";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		// PL_PM_NO			=> -20;		// 고정값 : -20 은 CRM 전송이라는것을 의미
		function getPostEmailLogInsertEx($param)
		{
			$paramData							= "";
//			$paramData['PL_NO']					= $this->db->getSQLInteger($param['PL_NO']);
			$paramData['PL_PM_NO']				= $this->db->getSQLInteger($param['PL_PM_NO']);
			$paramData['PL_TO_M_NO']			= $this->db->getSQLInteger($param['PL_TO_M_NO']);
			$paramData['PL_TO_M_MAIL']			= $this->db->getSQLString($param['PL_TO_M_MAIL']);
			$paramData['PL_TO_M_NAME']			= $this->db->getSQLString($param['PL_TO_M_NAME']);
			$paramData['PL_FROM_M_NO']			= $this->db->getSQLInteger($param['PL_FROM_M_NO']);
			$paramData['PL_FROM_M_MAIL']		= $this->db->getSQLString($param['PL_FROM_M_MAIL']);
			$paramData['PL_FROM_M_NAME']		= $this->db->getSQLString($param['PL_FROM_M_NAME']);
			$paramData['PL_TITLE']				= $this->db->getSQLString($param['PL_TITLE']);
			$paramData['PL_TEXT']				= $this->db->getSQLString($param['PL_TEXT']);
			$paramData['PL_IP']					= $this->db->getSQLString($param['PL_IP']);
			$paramData['PL_SEND_DATE']			= $this->db->getSQLDatetime($param['PL_SEND_DATE']);
			$paramData['PL_SEND_RESULT']		= $this->db->getSQLString($param['PL_SEND_RESULT']);
			$paramData['PL_REG_DT']				= $this->db->getSQLDatetime($param['PL_REG_DT']);
			$paramData['PL_REG_NO']				= $this->db->getSQLInteger($param['PL_REG_NO']);

			return $this->db->getInsertParam("POST_MAIL_LOG", $paramData);
		}

		function getPostEmailLogUpdateEx($param)
		{

		}

		function getPostEmailLogDeleteEx($param)
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