<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2013-11-10												|# 
#|작성내용	: 커뮤니티 추가필드 모듈 클레스								|# 
#/*====================================================================*/# 

require_once "Module.php";

class BoardAddFieldModule extends Module2
{
		function getBoardAddFieldSelectEx($op, $param)
		{
			$column['OP_LIST']		= "AD.*";
			$column['OP_SELECT']	= "*";
			$column['OP_COUNT']		= "COUNT(*)";
			$column['OP_ARYTOTAL']	= "*";

			## 체크
			if(!$param['B_CODE']) { return; }

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
				$order_by1		= "ORDER BY AD.AD_UB_NO DESC";
			endif;

			## where1
			$where1				= "WHERE AD.AD_UB_NO IS NOT NULL";

			if($param['AD_UB_NO']):
				$where1			= "{$where1} AND AD.AD_UB_NO = {$param['AD_UB_NO']}";
			endif;

			## from1
			$from1				= "FROM BOARD_AD_{$param['B_CODE']} AS AD";

			## select1
			$select1			= "SELECT {$column[$op]}";
			
			## query1
			$query1				= "{$select1} {$from1} {$join1_1} {$join1_2} {$where1} {$order_by1} {$limit1}";
		//	echo $query1;

			return $this->getSelectQuery($query1, $op);
		}

		function getBoardAddFieldInsertUpdateEx($param) 
		{

			## 기본 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['AD_UB_NO']) { return; }

			## 데이터 체크
			$intCnt				= $this->getBoardAddFieldSelectEx("OP_COUNT", $param);

			if($intCnt == 0):
				$this->getBoardAddFieldInsertEx($param);
			else:
				$this->getBoardAddFieldUpdateEx($param);
			endif;
		}

		function getBoardAddFieldInsertEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['AD_UB_NO']) { return; }

			$paramData						= "";
			$paramData['AD_UB_NO']			= $this->db->getSQLInteger($param['AD_UB_NO']);
			$paramData['AD_PHONE1']			= $this->db->getSQLString($param['AD_PHONE1']);
			$paramData['AD_PHONE2']			= $this->db->getSQLString($param['AD_PHONE2']);
			$paramData['AD_PHONE3']			= $this->db->getSQLString($param['AD_PHONE3']);
			$paramData['AD_ZIP']			= $this->db->getSQLString($param['AD_ZIP']);
			$paramData['AD_ADDR1']			= $this->db->getSQLString($param['AD_ADDR1']);
			$paramData['AD_ADDR2']			= $this->db->getSQLString($param['AD_ADDR2']);
			$paramData['AD_COMPANY']		= $this->db->getSQLString($param['AD_COMPANY']);
			$paramData['AD_TEMP1']			= $this->db->getSQLString($param['AD_TEMP1']);
			$paramData['AD_TEMP2']			= $this->db->getSQLString($param['AD_TEMP2']);
			$paramData['AD_TEMP3']			= $this->db->getSQLString($param['AD_TEMP3']);
			$paramData['AD_TEMP4']			= $this->db->getSQLString($param['AD_TEMP4']);
			$paramData['AD_TEMP5']			= $this->db->getSQLString($param['AD_TEMP5']);
			$paramData['AD_TEMP6']			= $this->db->getSQLString($param['AD_TEMP6']);
			$paramData['AD_TEMP7']			= $this->db->getSQLString($param['AD_TEMP7']);
			$paramData['AD_TEMP8']			= $this->db->getSQLString($param['AD_TEMP8']);
			$paramData['AD_TEMP9']			= $this->db->getSQLString($param['AD_TEMP9']);
			$paramData['AD_TEMP10']			= $this->db->getSQLString($param['AD_TEMP10']);
			$paramData['AD_TEMP11']			= $this->db->getSQLString($param['AD_TEMP11']);
			$paramData['AD_TEMP12']			= $this->db->getSQLString($param['AD_TEMP12']);
			$paramData['AD_TEMP13']			= $this->db->getSQLString($param['AD_TEMP13']);
			$paramData['AD_TEMP14']			= $this->db->getSQLString($param['AD_TEMP14']);
			$paramData['AD_TEMP15']			= $this->db->getSQLString($param['AD_TEMP15']);
			$paramData['AD_TEMP16']			= $this->db->getSQLString($param['AD_TEMP16']);
			$paramData['AD_TEMP17']			= $this->db->getSQLString($param['AD_TEMP17']);
			$paramData['AD_TEMP18']			= $this->db->getSQLString($param['AD_TEMP18']);
			$paramData['AD_TEMP19']			= $this->db->getSQLString($param['AD_TEMP19']);
			$paramData['AD_TEMP20']			= $this->db->getSQLString($param['AD_TEMP20']);

			return $this->db->getInsertParam("BOARD_AD_{$param['B_CODE']}", $paramData);
		}


		function getBoardAddFieldUpdateEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['AD_UB_NO']) { return; }

			$paramData						= "";
//			$paramData['AD_UB_NO']			= $this->db->getSQLInteger($param['AD_UB_NO']);
			$paramData['AD_PHONE1']			= $this->db->getSQLString($param['AD_PHONE1']);
			$paramData['AD_PHONE2']			= $this->db->getSQLString($param['AD_PHONE2']);
			$paramData['AD_PHONE3']			= $this->db->getSQLString($param['AD_PHONE3']);
			$paramData['AD_ZIP']			= $this->db->getSQLString($param['AD_ZIP']);
			$paramData['AD_ADDR1']			= $this->db->getSQLString($param['AD_ADDR1']);
			$paramData['AD_ADDR2']			= $this->db->getSQLString($param['AD_ADDR2']);
			$paramData['AD_COMPANY']		= $this->db->getSQLString($param['AD_COMPANY']);
			$paramData['AD_TEMP1']			= $this->db->getSQLString($param['AD_TEMP1']);
			$paramData['AD_TEMP2']			= $this->db->getSQLString($param['AD_TEMP2']);
			$paramData['AD_TEMP3']			= $this->db->getSQLString($param['AD_TEMP3']);
			$paramData['AD_TEMP4']			= $this->db->getSQLString($param['AD_TEMP4']);
			$paramData['AD_TEMP5']			= $this->db->getSQLString($param['AD_TEMP5']);
			$paramData['AD_TEMP6']			= $this->db->getSQLString($param['AD_TEMP6']);
			$paramData['AD_TEMP7']			= $this->db->getSQLString($param['AD_TEMP7']);
			$paramData['AD_TEMP8']			= $this->db->getSQLString($param['AD_TEMP8']);
			$paramData['AD_TEMP9']			= $this->db->getSQLString($param['AD_TEMP9']);
			$paramData['AD_TEMP10']			= $this->db->getSQLString($param['AD_TEMP10']);
			$paramData['AD_TEMP11']			= $this->db->getSQLString($param['AD_TEMP11']);
			$paramData['AD_TEMP12']			= $this->db->getSQLString($param['AD_TEMP12']);
			$paramData['AD_TEMP13']			= $this->db->getSQLString($param['AD_TEMP13']);
			$paramData['AD_TEMP14']			= $this->db->getSQLString($param['AD_TEMP14']);
			$paramData['AD_TEMP15']			= $this->db->getSQLString($param['AD_TEMP15']);
			$paramData['AD_TEMP16']			= $this->db->getSQLString($param['AD_TEMP16']);
			$paramData['AD_TEMP17']			= $this->db->getSQLString($param['AD_TEMP17']);
			$paramData['AD_TEMP18']			= $this->db->getSQLString($param['AD_TEMP18']);
			$paramData['AD_TEMP19']			= $this->db->getSQLString($param['AD_TEMP19']);
			$paramData['AD_TEMP20']			= $this->db->getSQLString($param['AD_TEMP20']);

			if($param['AD_UB_NO']):
				$no					= $this->db->getSQLInteger($param['AD_UB_NO']);
				$where				= "AD_UB_NO = {$no}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_AD_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardAddFieldReportUpdateEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['AD_UB_NO']) { return; }

			$paramData						= "";
			$paramData['AD_TEMP1']			= $this->db->getSQLString($param['AD_TEMP1']);

			if($param['AD_UB_NO']):
				$no					= $this->db->getSQLInteger($param['AD_UB_NO']);
				$where				= "AD_UB_NO = {$no}";
			endif;
			
			if(!$where)					{ return; }

			return $this->db->getUpdateParam("BOARD_AD_{$param['B_CODE']}", $paramData, $where);	

		}

		function getBoardAddFieldDeleteEx($param)
		{
			## 체크
			if(!$param['B_CODE']) { return; }
			if(!$param['AD_UB_NO']) { return; }

			$where					= "";
			
			if($param['AD_UB_NO']):
				$no					= $this->db->getSQLInteger($param['AD_UB_NO']);
				$where				= "AD_UB_NO = {$no}";
			endif;
			
			if(!$where)				{ return; }

			return $this->db->getDelete("BOARD_AD_{$param['B_CODE']}", $where);
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