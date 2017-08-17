<?
#/*====================================================================*/# 
#|화일명	: 															|# 
#|작성자	: kim hee sung												|# 
#|작성일	: 2015-02-16												|# 
#|작성내용	: 주문 관리 모듈 클래스										|# 
#/*====================================================================*/# 

require_once "Module.php";

class OrderMgrModule extends Module2
{
	// 취소승인번호
	function getOrderMgrCancelNoSelect()
	{
		## 기본 설정
		$strCelNo = '';

		## 취소승인번호 만들기
		for($i=0;$i<=100;$i++):
			
			$strCelNo = 'C' . date('Ymd') . strtoupper(getCode(5));

			$SQL = "SELECT * FROM ORDER_MGR WHERE O_CEL_NO = '{$strCelNo}'; ";

			$intCnt = $this->getSelectQuery($SQL, 'OP_COUNT');

			if(!$intCnt)
				break;

			$strCelNo = '';

		endfor;

		return $strCelNo;
	}

	function getOrderMgrSelectEx($op, $param)
	{
		## column 설정
		$aryColumn[] = "O.*";

		## where 설정
		$aryWhere1 = "";
		if($param['O_NO']) { $aryWhere1[] = "O.O_NO = {$param['O_NO']}"; }
		if($param['O_KEY']) { $aryWhere1[] = "O.O_KEY = '{$param['O_KEY']}'"; }
		
		## order by 설정
		$aryOrderBy['noAsc']			= "O.O_NO ASC";
		$aryOrderBy['noDesc']			= "O.O_NO DESC";
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
									 
		$SQL  = " SELECT {$strColumn}					";
		$SQL .= " FROM ORDER_MGR AS O					";
		$SQL .= " {$strWhere1}							";
		$SQL .= " {$strOrderBy}							";
		$SQL .= " {$strLimit}							";

		## 결과
		return $this->getSelectQuery($SQL, $op);
	}

	// 주문 건수 불러오기
	function getOrderMgrOrderCntSelectEx($op, $param)
	{
		## 기본정보
		$intM_NO = $param['M_NO'];

		## 체크
		if(!$intM_NO) return;
		
		$SQL  = "SELECT COUNT(*) AS JUMUN_CNT ,															";
		$SQL .= "       IFNULL(SUM(CASE WHEN O_STATUS = 'E' THEN 1 ELSE 0 END), 0) AS DELIVERY_CNT 		";
		$SQL .= "FROM ORDER_MGR																			";
		$SQL .= "WHERE M_NO = {$intM_NO} AND O_STATUS NOT IN ('F','W')									";
		$SQL .= "																						";

		## 결과
		return $this->getSelectQuery($SQL, $op);
	}

	function getOrderMgrInsertEx($param)
	{
	}

	function getOrderMgrUpdateEx($param)
	{

	}

	// 주문상태 변경
	function getOrderMgrStatusUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strO_STATUS = $param['O_STATUS'];

		## 체크
		if(!$intO_NO) { return; }
		if(!$strO_STATUS) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['O_STATUS']				= $this->db->getSQLString($strO_STATUS);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_MGR", $paramData, $where);		
	}

	// 은행,계좌번호 UPDATE
	function getOrderMgrBankInfoUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strO_BANK = $param['O_BANK'];
		$strO_BANK_ACC = $param['O_BANK_ACC'];
		$strO_BANK_NAME = $param['O_BANK_NAME'];
		$strO_BANK_VALID_DT = $param['O_BANK_VALID_DT'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['O_BANK']				= $this->db->getSQLString($strO_BANK);
		$paramData['O_BANK_ACC']			= $this->db->getSQLString($strO_BANK_ACC);
		$paramData['O_BANK_NAME']			= $this->db->getSQLString($strO_BANK_NAME);
		$paramData['O_BANK_VALID_DT']		= $this->db->getSQLString($strO_BANK_VALID_DT);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_MGR", $paramData, $where);	
	}

	// 주문 적립포인트 지급 유무 UPDATE(취소시 적립된 포인트를 다시 가지고 올때 기본설정이 변경이 되면 다시 못가지고 올 수 있으므로..)
	function getOrderMgrAddPointUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strO_ADD_POINT = $param['O_ADD_POINT'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['O_ADD_POINT']			= $this->db->getSQLString($strO_ADD_POINT);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_MGR", $paramData, $where);	
	}

	// 첫 구매 업데이트
	function getOrderMgrFirstPointUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strO_FIRST_YN = $param['O_FIRST_YN'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['O_FIRST_YN']			= $this->db->getSQLString($strO_FIRST_YN);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_MGR", $paramData, $where);	

	}

	// 거래번호 업데이트
	function getOrderMgrApprNoUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strO_APPR_NO = $param['O_APPR_NO'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['O_APPR_NO']			= $this->db->getSQLString($strO_APPR_NO);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_MGR", $paramData, $where);	
	}

	// 에스크로 업데이트
	function getOrderMgrEscrowUpdateEx($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strO_ESCROW = $param['O_ESCROW'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['O_ESCROW']			= $this->db->getSQLString($strO_ESCROW);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_MGR", $paramData, $where);	
	}

	//주문취소 UPDATE
	function getOrderMgrCancelUpdate($param)
	{
		## 기본 설정
		$intO_NO = $param['O_NO'];
		$strO_CEL_NO = $param['O_CEL_NO'];
		$strO_CEL_REQ_DT = $param['O_CEL_REQ_DT'];
		$strO_CEL_REG_DT = $param['O_CEL_REG_DT'];
		$strO_STATUS = $param['O_STATUS'];
		$strO_CEL_MEMO = $param['O_CEL_MEMO'];
		$strO_RETURN_BANK = $param['O_RETURN_BANK'];
		$strO_RETURN_ACC = $param['O_RETURN_ACC'];
		$strO_RETURN_NAME = $param['O_RETURN_NAME'];
		$strO_CEL_STATUS = $param['O_CEL_STATUS'];

		## 체크
		if(!$intO_NO) { return; }

		## 수정 데이터
		$paramData							= "";
		$paramData['O_CEL_NO']				= $this->db->getSQLString($strO_CEL_NO);
		$paramData['O_CEL_REQ_DT']			= $this->db->getSQLDatetime($strO_CEL_REQ_DT);
		$paramData['O_CEL_REG_DT']			= $this->db->getSQLDatetime($strO_CEL_REG_DT);
		$paramData['O_STATUS']				= $this->db->getSQLString($strO_STATUS);
		$paramData['O_CEL_MEMO']			= $this->db->getSQLString($strO_CEL_MEMO);
		$paramData['O_RETURN_BANK']			= $this->db->getSQLString($strO_RETURN_BANK);
		$paramData['O_RETURN_ACC']			= $this->db->getSQLString($strO_RETURN_ACC);
		$paramData['O_RETURN_NAME']			= $this->db->getSQLString($strO_RETURN_NAME);
		$paramData['O_CEL_STATUS']			= $this->db->getSQLString($strO_CEL_STATUS);

		## where
		$where = "O_NO = {$intO_NO}";

		return $this->db->getUpdateParam("ORDER_MGR", $paramData, $where);	
	}

	function getOrderMgrDeleteEx($param)
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