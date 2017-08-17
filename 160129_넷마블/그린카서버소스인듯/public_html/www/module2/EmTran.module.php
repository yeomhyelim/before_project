<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-12												|# 
#|작성내용	: eumshop sms 전송 클레스									|# 
#/*====================================================================*/# 

// require_once "Module.php";

class EmTranModule extends Module2
{
		function getEmTranSelectEx($op, $param)
		{
			$column['OP_LIST']		= "EM.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## 기본 설정
			$ym					= $param['ym'];

			## 기본 설정 체크
			if(!$ym) { $ym = date("Ym"); }

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
				$order_by1		= "ORDER BY EM.Msg_Id ASC";
			endif;

			## where1
			$where1				= "WHERE EM.Msg_Id IS NOT NULL";

			if($param['tran_pr']):
				$where1			= "{$where1} AND EM.Msg_Id = {$param['tran_pr']}";
			endif;

			if($param['tran_etc1']):
				$where1			= "{$where1} AND EM.Etc1 = '{$param['tran_etc1']}'";
			endif;

			## from1
			$from1				= "FROM Oneshot_Log_{$ym} AS EM";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";

			return $this->getSelectQuery($query1, $op);
		}

		function getEmTranInsertEx($param)
		{

			$paramData							= "";

			$paramData['Status']		= $this->db->getSQLString(0);
			$paramData['Phone_No']		= $this->db->getSQLString($param['tran_phone']);
			$paramData['Callback_No']	= $this->db->getSQLString($param['tran_callback']);
			$paramData['Sms_Msg']		= $this->db->getSQLString($param['tran_msg']);
			$paramData['Send_Time']		= $this->db->getSQLDatetime($param['tran_date']);
			$paramData['Save_Time']		= $this->db->getSQLDatetime($param['tran_date']);
			$paramData['Tran_Time']		= $this->db->getSQLDatetime($param['tran_date']);
			$paramData['Msg_Type']		= $this->db->getSQLInteger($param['tran_type']);
			$paramData['Etc1']			= $this->db->getSQLString($param['tran_etc1']);

			return $this->db->getInsertParam("Oneshot_Tran", $paramData);

////			$paramData['tran_pr']				= $this->db->getSQLInteger($param['tran_pr']);
//			$paramData['tran_refkey']			= $this->db->getSQLString($param['tran_refkey']);
//			$paramData['tran_id']				= $this->db->getSQLString($param['tran_id']);
//			$paramData['tran_phone']			= $this->db->getSQLString($param['tran_phone']);
//			$paramData['tran_callback']			= $this->db->getSQLString($param['tran_callback']);
//			$paramData['tran_status']			= $this->db->getSQLString($param['tran_status']);
//			$paramData['tran_date']				= $this->db->getSQLDatetime($param['tran_date']);
//			$paramData['tran_rsltdate']			= $this->db->getSQLDatetime($param['tran_rsltdate']);
//			$paramData['tran_reportdate']		= $this->db->getSQLDatetime($param['tran_reportdate']);
//			$paramData['tran_rslt']				= $this->db->getSQLString($param['tran_rslt']);
//			$paramData['tran_net']				= $this->db->getSQLString($param['tran_net']);
//			$paramData['tran_msg']				= $this->db->getSQLString($param['tran_msg']);
//			$paramData['tran_etc1']				= $this->db->getSQLString($param['tran_etc1']);
//			$paramData['tran_etc2']				= $this->db->getSQLString($param['tran_etc2']);
//			$paramData['tran_etc3']				= $this->db->getSQLString($param['tran_etc3']);
//			$paramData['tran_etc4']				= $this->db->getSQLInteger($param['tran_etc4']);
//			$paramData['tran_type']				= $this->db->getSQLInteger($param['tran_type']);
//
//			return $this->db->getInsertParam("em_tran", $paramData);
		}

		function getEmTranUpdateEx($param)
		{

		}

		function getEmTranDeleteEx($param)
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