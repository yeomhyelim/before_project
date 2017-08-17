<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-12-24												|# 
#|작성내용	: 자동 메일 전송 관리										|# 
#/*====================================================================*/# 

require_once "Module.php";

class EmailMgrModule extends Module2
{
//		SELECT * FROM EMAIL_MGR AS EM
//		LEFT OUTER JOIN COMM_CODE AS CC ON CC.CC_CODE = EM.EM_SEND_CODE AND CC.CG_NO = 36
//		WHERE EM.EM_LNG = 'KR' AND CC.CC_USE = 'Y'
		function getEmailMgrSelectEx($op, $param)
		{
			$column['OP_LIST']		= "EM.*";
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
				$order_by1		= "ORDER BY EM.EM_NO DESC";
			endif;

			## where1
			$where1				= "WHERE EM.EM_NO IS NOT NULL";

			if($param['EM_NO']):
				$where1			= "{$where1} AND EM.EM_NO = {$param['EM_NO']}";
			endif;

			if($param['EM_GRP_CODE']):
				$where1			= "{$where1} AND EM.EM_GRP_CODE = '{$param['EM_GRP_CODE']}'";
			endif;

			if($param['EM_SEND_CODE']):
				$where1			= "{$where1} AND EM.EM_SEND_CODE = '{$param['EM_SEND_CODE']}'";
			endif;

			if($param['EM_LNG']):
				$where1			= "{$where1} AND EM.EM_LNG = '{$param['EM_LNG']}'";
			endif;

			if($param['EM_AUTO']):
				$where1			= "{$where1} AND EM.EM_AUTO = '{$param['EM_AUTO']}'";
			endif;

			if($param['COMM_CODE_JOIN']):
			
				if(!$param['CG_NO']) { return; }

				$column['OP_LIST']		   .= ", CC.*";
				$join1_1					= "LEFT OUTER JOIN COMM_CODE AS CC ON CC.CC_CODE = EM.EM_SEND_CODE AND CC.CG_NO = {$param['CG_NO']}";

				if($param['CC_USE']):
					$where1					= "{$where1} AND CC.CC_USE = '{$param['CC_USE']}'";
				endif;
			endif;

			## from1
			$from1				= "FROM EMAIL_MGR AS EM";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getEmailMgrInsertEx($param)
		{

		}

		function getEmailMgrUpdateEx($param)
		{
			$paramData						= "";
//			$paramData['EM_NO']				= $this->db->getSQLInteger($param['EM_NO']);
//			$paramData['EM_GRP_CODE']		= $this->db->getSQLString($param['EM_GRP_CODE']);
//			$paramData['EM_SEND_CODE']		= $this->db->getSQLString($param['EM_SEND_CODE']);
//			$paramData['EM_LNG']			= $this->db->getSQLString($param['EM_LNG']);
			$paramData['EM_TITLE']			= $this->db->getSQLString($param['EM_TITLE']);
			$paramData['EM_TEXT']			= $this->db->getSQLString($param['EM_TEXT']);
			$paramData['EM_AUTO']			= $this->db->getSQLString($param['EM_AUTO']);
			$paramData['EM_SENDER']			= $this->db->getSQLString($param['EM_SENDER']);
			$paramData['EM_RECIPIENT']		= $this->db->getSQLString($param['EM_RECIPIENT']);
//			$paramData['EM_REG_DT']			= $this->db->getSQLDatetime($param['EM_REG_DT']);
//			$paramData['EM_REG_NO']			= $this->db->getSQLInteger($param['EM_REG_NO']);
			$paramData['EM_MOD_DT']			= $this->db->getSQLDatetime($param['EM_MOD_DT']);
			$paramData['EM_MOD_NO']			= $this->db->getSQLInteger($param['EM_MOD_NO']);

			if($param['EM_NO']):
				$emNo						= $this->db->getSQLInteger($param['EM_NO']);
				$where						= "EM_NO = {$emNo}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("EMAIL_MGR", $paramData, $where);	
		}














		function getEmailMgrDeleteEx($param)
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