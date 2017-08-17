<?
#/*====================================================================*/#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2012-05-11												|#
#|작성내용	: 쇼핑몰 기본설정 관리 										|#
#/*====================================================================*/#

class ReservationMgr
{
	private $query;
	private $param;

	function getFromServerInfo($db,$strCol)
	{
		$query  = "SELECT * FROM SITE_INFO WHERE COL=";
		$query .= "'".$strCol."'";

		return $db->getSelect($query);
	}

	function getRoomStatus($db,$strDt)
	{
		$query  = "SELECT * FROM RESERVATION_MGR WHERE RS_S_DT LIKE ";
		$query .= "'".$strDt."%'";

		return $db->getExecSql($query);
	}

	function getRservCount($db,$strCol)
	{
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR";

		return $db->getCount($query);
	}

	function getRservCount2($db,$strRsvNo)
	{
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR WHERE RS_NUMBER = '".$strRsvNo."'";

		return $db->getCount($query);
	}

	function getRservCount3($db,$strSearchGroup,$strSearchKey)
	{
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR";
		$query .= " WHERE (RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .= ")";

		return $db->getCount($query);
	}

	function getRservCount4($db,$strSearchSDt,$strSearchEDt,$strSearchKey)
	{
		$strSearchSDt = $strSearchSDt . " 00:00:00";
		$strSearchEDt = $strSearchEDt . " 23:59:59";
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR ";
		$query .= " WHERE (RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%') ";
		$query .= " AND RS_S_DT BETWEEN '".$strSearchSDt."' AND '" .$strSearchEDt."'";

		return $db->getCount($query);
	}

	function getRservCount5($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey)
	{
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR ";
		$query .= " WHERE (RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .=")";
		$query .= " AND RS_S_DT BETWEEN '" . $strSearchSDt . "' AND '". $strSearchEDt . "'";

		return $db->getCount($query);
	}

	function getRservCount6($db,$intStartNo,$intEndNo,$strSearchKey)
	{
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR ";
		$query .= " WHERE RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%' ";

		return $db->getCount($query);
	}

	function getRservCount7($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey,$strSearchField)
	{
		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR ";
		$query .= " WHERE (".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .=")";
		$query .= " AND RS_S_DT BETWEEN '" . $strSearchSDt . "' AND '". $strSearchEDt . "'";

		return $db->getCount($query);
	}

	function getRservCount8($db,$strSearchSDt,$strSearchEDt,$strSearchKey,$strSearchField)
	{
		$strSearchSDt = $strSearchSDt . " 00:00:00";
		$strSearchEDt = $strSearchEDt . " 23:59:59";

		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR ";
		$query .= " WHERE (".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%') ";
		$query .= " AND RS_S_DT BETWEEN '".$strSearchSDt."' AND '" .$strSearchEDt."'";

		return $db->getCount($query);
	}

	function getRservCount9($db,$strSearchGroup,$strSearchKey,$strSearchField)
	{
		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR ";
		$query .= " WHERE (".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .= ")";

		return $db->getCount($query);
	}

	function getRservCount10($db,$intStartNo,$intEndNo,$strSearchKey,$strSearchField)
	{
		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT COUNT(*) FROM RESERVATION_MGR ";
		$query .= " WHERE ".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%' ";

		return $db->getCount($query);
	}

	function getRoomCount($db,$strCol)
	{
		$query  = "SELECT COUNT(*) FROM ROOM_MGR";

		return $db->getCount($query);
	}

	function getFromServerText($db,$strCol)
	{
		$query  = "SELECT * FROM SITE_TEXT WHERE COL=";
		$query .= "'".$strCol."'";

		return $db->getSelect($query);
	}

	function getRoomSetFix2($db,$intNumber)
	{
		$query  = "SELECT * FROM COMM_CODE WHERE CG_NO=";
		$query .= $intNumber;

		return $db->getExecSql($query);
	}

	function getRserv($db,$intStartNo,$intEndNo)
	{
		$query  = "SELECT * FROM RESERVATION_MGR LIMIT ";
		$query .= $intStartNo . ",";
		$query .= $intEndNo;

		return $db->getExecSql($query);
	}

	function getRserv2($db,$strRsvNo,$intStartNo,$intEndNo)
	{
		$query  = "SELECT * FROM RESERVATION_MGR WHERE RS_NUMBER = '".$strRsvNo."' LIMIT ";
		$query .= $intStartNo . ",";
		$query .= $intEndNo;

		return $db->getExecSql($query);
	}

	function getRserv3($db,$strSearchGroup,$strSearchKey)
	{
		$query  = "SELECT * FROM RESERVATION_MGR";
		$query .= " WHERE (RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .= ")";

		return $db->getExecSql($query);
	}

	function getRserv4($db,$strSearchSDt,$strSearchEDt,$strSearchKey)
	{
		$strSearchSDt = $strSearchSDt . " 00:00:00";
		$strSearchEDt = $strSearchEDt . " 23:59:59";
		$query  = "SELECT * FROM RESERVATION_MGR ";
		$query .= " WHERE (RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%') ";
		$query .= " AND RS_S_DT BETWEEN '".$strSearchSDt."' AND '" .$strSearchEDt."'";

		return $db->getExecSql($query);
	}

	function getRserv5($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey)
	{
		$query  = "SELECT * FROM RESERVATION_MGR ";
		$query .= " WHERE (RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .=")";
		$query .= " AND RS_S_DT BETWEEN '" . $strSearchSDt . "' AND '". $strSearchEDt . "'";

		return $db->getExecSql($query);
	}

	function getRserv6($db,$intStartNo,$intEndNo,$strSearchKey)
	{
		$query  = "SELECT * FROM RESERVATION_MGR ";
		$query .= " WHERE RS_NUMBER LIKE '%";
		$query .= $strSearchKey . "%' OR RS_NAME LIKE '%";
		$query .= $strSearchKey . "%' OR RS_EMAIL LIKE '%";
		$query .= $strSearchKey . "%' ";
		$query .= " LIMIT ";
		$query .= $intStartNo . ",";
		$query .= $intEndNo;

		return $db->getExecSql($query);
	}

	function getRserv7($db,$strSearchSDt,$strSearchEDt,$strSearchGroup,$strSearchKey,$strSearchField)
	{
		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT * FROM RESERVATION_MGR ";
		$query .= " WHERE (".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .=")";
		$query .= " AND RS_S_DT BETWEEN '" . $strSearchSDt . "' AND '". $strSearchEDt . "'";

		return $db->getExecSql($query);
	}

	function getRserv8($db,$strSearchSDt,$strSearchEDt,$strSearchKey,$strSearchField)
	{
		$strSearchSDt = $strSearchSDt . " 00:00:00";
		$strSearchEDt = $strSearchEDt . " 23:59:59";

		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT * FROM RESERVATION_MGR ";
		$query .= " WHERE (".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%') ";
		$query .= " AND RS_S_DT BETWEEN '".$strSearchSDt."' AND '" .$strSearchEDt."'";

		return $db->getExecSql($query);
	}

	function getRserv9($db,$strSearchGroup,$strSearchKey,$strSearchField)
	{
		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT * FROM RESERVATION_MGR ";
		$query .= " WHERE (".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%') AND (";

		$strSearchKey =  explode(",",$strSearchGroup);
		$intCount     =  count($strSearchKey);

		for($i=0;$i<$intCount;$i++){
			if($strSearchKey[$i] == "'A'"){$strSearchKey[$i]="입금대기";}
			if($strSearchKey[$i] == "'B'"){$strSearchKey[$i]="입금완료";}
			if($strSearchKey[$i] == "'C'"){$strSearchKey[$i]="선금입금";}
			if($strSearchKey[$i] == "'D'"){$strSearchKey[$i]="예약취소";}
			if($strSearchKey[$i] == "'E'"){$strSearchKey[$i]="잔금입금";}

			$query .= "RS_STATUS = '" . $strSearchKey[$i] . "'";

			if($i!=$intCount-1){$query .= " OR ";}
		}
		$query .= ")";

		return $db->getExecSql($query);
	}

	function getRserv10($db,$intStartNo,$intEndNo,$strSearchKey,$strSearchField)
	{
		if($strSearchField=="no"){$strSearchField = "RS_NUMBER";}
		if($strSearchField=="name"){$strSearchField = "RS_NAME";}
		if($strSearchField=="phone"){$strSearchField = "RS_EMAIL";}
		$query  = "SELECT * FROM RESERVATION_MGR ";
		$query .= " WHERE ".$strSearchField." LIKE '%";
		$query .= $strSearchKey . "%' ";
		$query .= " LIMIT ";
		$query .= $intStartNo . ",";
		$query .= $intEndNo;

		return $db->getExecSql($query);
	}

	function getTimdDt($db)
	{
		$query  = "SELECT * FROM TIME_MGR WHERE T_TYPE=2";

		return $db->getExecSql($query);
	}

	function getTimdDt2($db)
	{
		$query  = "SELECT * FROM TIME_MGR WHERE T_TYPE=1";

		return $db->getExecSql($query);
	}

	function getCmCodeNumber($db)
	{
		$query  = "SELECT IFNULL(MAX(SUBSTRING(CG_CODE,1,8)),0)+1 FROM COMM_GRP WHERE CG_CODE LIKE 'ROOM_ADD%'";

		return $db->getCount($query);
	}

	function getRoomSetEtcInsert($db,$param)
	{
		$paramData							= "";
		$paramData['AM_ORDER']				= $db->getSQLInteger($param['AM_ORDER']);
		$paramData['AM_TYPE']				= $db->getSQLString($param['AM_TYPE']);
		$paramData['AM_PRICE']				= $db->getSQLString($param['AM_PRICE']);
		$paramData['AM_UNIT']				= $db->getSQLString($param['AM_UNIT']);
		$paramData['AM_MEMO']				= $db->getSQLString($param['AM_MEMO']);
		$paramData['AM_DEV']				= $db->getSQLString($param['AM_DEV']);
		$paramData['AM_REG_DT']				= $db->getSQLString($param['AM_REG_DT']);
		$paramData['AM_REG_NO']				= $db->getSQLString($param['AM_REG_NO']);

		return $db->getInsertParam("ADD_MANAGE", $paramData,true);
	}

	function getInsertTime($db,$param)
	{
		$paramData							= "";
		$paramData['T_START_DT']			= $db->getSQLString($param['T_START_DT']);
		$paramData['T_END_DT']				= $db->getSQLString($param['T_END_DT']);
		$paramData['T_REG_DT']				= $db->getSQLString($param['T_REG_DT']);
		$paramData['T_REG_NO']				= $db->getSQLString($param['T_REG_NO']);
		$paramData['T_TYPE']				= $db->getSQLInteger($param['T_TYPE']);

		return $db->getInsertParam("TIME_MGR", $paramData,true);
	}

	function getUpdateTime($db,$param)
	{
		if (!$param['T_NO']) return;

		$paramData							= "";
		$paramData['T_START_DT']			= $db->getSQLString($param['T_START_DT']);
		$paramData['T_END_DT']				= $db->getSQLString($param['T_END_DT']);
		$paramData['T_MOD_DT']				= $db->getSQLString($param['T_MOD_DT']);
		$paramData['T_MOD_NO']				= $db->getSQLString($param['T_MOD_NO']);
		$paramData['T_TYPE']				= $db->getSQLInteger($param['T_TYPE']);

		$where								= " T_NO = {$param['T_NO']} ";

		return $db->getUpdateParam("TIME_MGR", $paramData,$where);
	}

	function getUpdateTime2($db,$param)
	{
		if (!$param['T_NO']) return;

		$paramData							= "";
		$paramData['T_START_DT']			= $db->getSQLString($param['T_START_DT']);
		$paramData['T_END_DT']				= $db->getSQLString($param['T_END_DT']);
		$paramData['T_MOD_DT']				= $db->getSQLString($param['T_MOD_DT']);
		$paramData['T_MOD_NO']				= $db->getSQLString($param['T_MOD_NO']);
		$paramData['T_TYPE']				= $db->getSQLInteger($param['T_TYPE']);

		$where								= " T_NO = {$param['T_NO']} ";

		return $db->getUpdateParam("TIME_MGR", $paramData,$where);
	}

	function getRoomSetFixInsert($db,$param)
	{
		$paramData							= "";
		$paramData['CG_SORT']				= $db->getSQLInteger($param['CG_SORT']);
		$paramData['CG_NAME']				= $db->getSQLString($param['CG_NAME']);
		$paramData['CG_CODE']				= $db->getSQLString($param['CG_CODE']);
		$paramData['CG_USE']				= $db->getSQLString($param['CG_USE']);
		$paramData['CG_TYPE']				= $db->getSQLString($param['CG_TYPE']);

		return $db->getInsertParam("COMM_GRP", $paramData,true);
	}

	function getReservationInsert($db,$param)
	{
		$paramData							= "";
		$paramData['RS_NUMBER']				= $db->getSQLString($param['RS_NUMBER']);
		$paramData['RS_NAME']				= $db->getSQLString($param['RS_NAME']);
		$paramData['RS_EMAIL']				= $db->getSQLString($param['RS_EMAIL']);
		$paramData['RS_REQUEST']			= $db->getSQLString($param['RS_REQUEST']);
		$paramData['RS_PAYCASH']			= $db->getSQLString($param['RS_PAYCASH']);
		$paramData['RS_R_NO']				= $db->getSQLInteger($param['RS_R_NO']);
		$paramData['RS_R_PAY']				= $db->getSQLString($param['RS_R_PAY']);
		$paramData['RS_A_PAY']				= $db->getSQLString($param['RS_A_PAY']);
		$paramData['RS_PAY_TP']				= $db->getSQLString($param['RS_PAY_TP']);
		$paramData['RS_BBOOK']				= $db->getSQLString($param['RS_BBOOK']);
		$paramData['RS_REG_DT']				= $db->getSQLString($param['RS_REG_DT']);
		$paramData['RS_S_DT']				= $db->getSQLString($param['RS_S_DT']);
		$paramData['RS_E_DT']				= $db->getSQLString($param['RS_E_DT']);
		$paramData['RS_ADD_LIST']			= $db->getSQLString($param['RS_ADD_LIST']);
		$paramData['RS_BDD_LIST']			= $db->getSQLString($param['RS_BDD_LIST']);

		return $db->getInsertParam("RESERVATION_MGR", $paramData,true);
	}

	function getReservationInsert2($db,$param)
	{
		$paramData							= "";
		$paramData['RS_NUMBER']				= $db->getSQLString($param['RS_NUMBER']);
		$paramData['RS_NAME']				= $db->getSQLString($param['RS_NAME']);
		$paramData['RS_EMAIL']				= $db->getSQLString($param['RS_EMAIL']);
		$paramData['RS_REQUEST']			= $db->getSQLString($param['RS_REQUEST']);
		$paramData['RS_PAYCASH']			= $db->getSQLString($param['RS_PAYCASH']);
		$paramData['RS_R_NO']				= $db->getSQLInteger($param['RS_R_NO']);
		$paramData['RS_R_PAY']				= $db->getSQLString($param['RS_R_PAY']);
		$paramData['RS_A_PAY']				= $db->getSQLString($param['RS_A_PAY']);
		$paramData['RS_PAY_TP']				= $db->getSQLString($param['RS_PAY_TP']);
		$paramData['RS_BBOOK']				= $db->getSQLString($param['RS_BBOOK']);
		$paramData['RS_REG_DT']				= $db->getSQLString($param['RS_REG_DT']);
		$paramData['RS_S_DT']				= $db->getSQLString($param['RS_S_DT']);
		$paramData['RS_E_DT']				= $db->getSQLString($param['RS_E_DT']);
//		$paramData['RS_ADD_LIST']			= $db->getSQLString($param['RS_ADD_LIST']);
//		$paramData['RS_BDD_LIST']			= $db->getSQLString($param['RS_BDD_LIST']);

		return $db->getInsertParam("RESERVATION_MGR", $paramData,true);
	}


	function getRoomSetFixInsert2($db,$param)
	{
		$paramData							= "";
		$paramData['CC_SORT']				= $db->getSQLInteger($param['CC_SORT']);
		$paramData['CC_NAME_KR']			= $db->getSQLString($param['CC_NAME_KR']);
		$paramData['CC_CODE']				= $db->getSQLString($param['CC_CODE']);
		$paramData['CC_USE']				= $db->getSQLString($param['CC_USE']);
		$paramData['CG_NO']					= $db->getSQLString($param['CG_NO']);

		return $db->getInsertParam("COMM_CODE", $paramData,true);
	}

	function getRoomSetEtcInsert2($db,$param)
	{
		$paramData							= "";
		$paramData['AM_ORDER']				= $db->getSQLInteger($param['AM_ORDER']);
		$paramData['AM_TYPE']				= $db->getSQLString($param['AM_TYPE']);
		$paramData['AM_DEV']				= $db->getSQLString($param['AM_DEV']);
		$paramData['AM_REG_DT']				= $db->getSQLString($param['AM_REG_DT']);
		$paramData['AM_REG_NO']				= $db->getSQLString($param['AM_REG_NO']);

		return $db->getInsertParam("ADD_MANAGE", $paramData,true);
	}

	function getRoomSetEtcAll($db)
	{
		$query  = "SELECT												";
		$query .= "*													";
		$query .= "FROM ADD_MANAGE ORDER BY AM_ORDER ASC				";

		return $db->getExecSql($query);
	}

	function getRoomAdd($db)
	{
		$query  = "SELECT												";
		$query .= "*													";
		$query .= "FROM COMM_GRP WHERE CG_CODE LIKE 'ROOM_ADD%'			";

		return $db->getExecSql($query);
	}

	function getRoomSetEtcView($db,$param)
	{
		$query  = "SELECT												";
		$query .= "	*													";
		$query .= "FROM ADD_MANAGE										";
		$query .= "WHERE												";
		$query .= "AM_NO=												";
		$query .= $param['AM_NO'];

		return $db->getSelect($query);
	}

	function getRoomSetFixView($db,$param)
	{
		$query  = "SELECT												";
		$query .= "	*													";
		$query .= "FROM COMM_GRP										";
		$query .= "WHERE												";
		$query .= "CG_NO=												";
		$query .= $param['CG_NO'];

		return $db->getSelect($query);
	}

	function getRoomSetFixView2($db,$param)
	{
		$query  = "SELECT												";
		$query .= "	*													";
		$query .= "FROM COMM_CODE										";
		$query .= "WHERE												";
		$query .= "CC_NO=												";
		$query .= $param['CC_NO'];

		return $db->getSelect($query);
	}

	function getRoomSetFixView3($db)
	{
		$query  = "SELECT												";
		$query .= "	*													";
		$query .= "FROM COMM_GRP										";
		$query .= "WHERE												";
		$query .= "CG_CODE=												";
		$query .= "'ROOM_ADD1'";

		return $db->getExecSql($query);
	}

	function getRoomSetFixView4($db,$param)
	{
		$query  = "SELECT												";
		$query .= "	*													";
		$query .= "FROM COMM_CODE										";
		$query .= "WHERE												";
		$query .= "CG_NO=												";
		$query .= $param['CG_NO'];

		return $db->getExecSql($query);
	}

	function getRoomSetEtcUpdate($db,$param)
	{
		if (!$param['AM_NO']) return;

		$paramData							= "";
		$paramData['AM_ORDER']				= $db->getSQLInteger($param['AM_ORDER']);
		$paramData['AM_TYPE']				= $db->getSQLString($param['AM_TYPE']);
		$paramData['AM_PRICE']				= $db->getSQLString($param['AM_PRICE']);
		$paramData['AM_UNIT']				= $db->getSQLString($param['AM_UNIT']);
		$paramData['AM_MEMO']				= $db->getSQLString($param['AM_MEMO']);
		$paramData['AM_DEV']				= $db->getSQLString($param['AM_DEV']);
		$paramData['AM_MOD_DT']				= $db->getSQLString($param['AM_MOD_DT']);
		$paramData['AM_MOD_NO']				= $db->getSQLString($param['AM_MOD_NO']);

		$where								= " AM_NO = {$param['AM_NO']} ";

		return $db->getUpdateParam("ADD_MANAGE", $paramData,$where);
	}

	function getSetPolicyUpdate($db,$param)
	{


		$paramData							= "";
		$paramData['VAL']				= $db->getSQLString($param['VAL']);

		$query  = "UPDATE SITE_TEXT SET VAL = 					";
		$query .=  $paramData['VAL'];
		$query .= " WHERE COL='S_REV_CARE'";

		return $db->getExecSql($query);
	}

	function getSetPolicyUpdate2($db,$param)
	{


		$paramData							= "";
		$paramData['VAL']				= $db->getSQLString($param['S_REV_PRICE']);

		$query  = "UPDATE SITE_TEXT SET VAL = 					";
		$query .=  $paramData['VAL'];
		$query .= " WHERE COL='S_REV_PRICE'";

		return $db->getExecSql($query);
	}

	function getSetPolicyUpdate3($db,$param)
	{


		$paramData							= "";
		$paramData['VAL']				= $db->getSQLString($param['S_REV_REFUND']);

		$query  = "UPDATE SITE_TEXT SET VAL = 					";
		$query .=  $paramData['VAL'];
		$query .= " WHERE COL='S_REV_REFUND'";

		return $db->getExecSql($query);
	}

	function getRoomSetFixUpdate($db,$param)
	{
		if (!$param['CG_NO']) return;

		$paramData							= "";
		$paramData['CG_SORT']				= $db->getSQLInteger($param['CG_SORT']);
		$paramData['CG_NAME']				= $db->getSQLString($param['CG_NAME']);
		$paramData['CG_USE']				= $db->getSQLString($param['CG_USE']);
		$paramData['CG_TYPE']				= $db->getSQLString($param['CG_TYPE']);

		$where								= " CG_NO = {$param['CG_NO']} ";

		return $db->getUpdateParam("COMM_GRP", $paramData,$where);
	}

	function getRoomSetFixUpdate2($db,$param)
	{
		if (!$param['CC_NO']) return;

		$paramData							= "";
		$paramData['CC_SORT']				= $db->getSQLInteger($param['CC_SORT']);
		$paramData['CC_NAME_KR']			= $db->getSQLString($param['CC_NAME_KR']);
		$paramData['CC_USE']				= $db->getSQLString($param['CC_USE']);
		$paramData['CG_NO']					= $db->getSQLString($param['CG_NO']);

		$where								= " CC_NO = {$param['CC_NO']} ";

		return $db->getUpdateParam("COMM_CODE", $paramData,$where);
	}

	function getRoomSetEtcUpdate2($db,$param)
	{
		if (!$param['AM_NO']) return;

		$paramData							= "";
		$paramData['AM_ORDER']				= $db->getSQLInteger($param['AM_ORDER']);
		$paramData['AM_TYPE']				= $db->getSQLString($param['AM_TYPE']);
		$paramData['AM_DEV']				= $db->getSQLString($param['AM_DEV']);
		$paramData['AM_MOD_DT']				= $db->getSQLString($param['AM_MOD_DT']);
		$paramData['AM_MOD_NO']				= $db->getSQLString($param['AM_MOD_NO']);

		$where								= " AM_NO = {$param['AM_NO']} ";

		return $db->getUpdateParam("ADD_MANAGE", $paramData,$where);
	}

	function getTimeDelete($db,$param)
	{

		if (!$param['T_NO']) return;
		$where .= "T_NO = {$param['T_NO']} ";

		return $db->getDelete("TIME_MGR", $where);
	}

	function getAddSetDelete($db,$param)
	{

		if (!$param['AM_NO']) return;
		$where .= "AM_NO = {$param['AM_NO']} ";

		return $db->getDelete("ADD_MANAGE", $where);
	}

	function getFixDelete($db,$param)
	{

		if (!$param['CG_NO']) return;
		$where .= "CG_NO = {$param['CG_NO']} ";

		return $db->getDelete("COMM_GRP", $where);
	}

	function getFixDelete2($db,$param)
	{

		if (!$param['CG_NO']) return;
		$where .= "CG_NO = {$param['CG_NO']} ";

		return $db->getDelete("COMM_CODE", $where);
	}

	function getFixDelete3($db,$param)
	{

		if (!$param['CC_NO']) return;
		$where .= "CC_NO = {$param['CC_NO']} ";

		return $db->getDelete("COMM_CODE", $where);
	}

	function getRoomBasicInsert($db,$param)
	{
		$paramData								= "";
		$paramData['R_NAME']					= $db->getSQLString($param['R_NAME']);
		$paramData['R_TYPE']					= $db->getSQLString($param['R_TYPE']);
		$paramData['R_AREA']					= $db->getSQLString($param['R_AREA']);
		$paramData['R_ST_PER']					= $db->getSQLString($param['R_ST_PER']);
		$paramData['R_MAX_PER']					= $db->getSQLString($param['R_MAX_PER']);
		$paramData['R_PRINT']					= $db->getSQLString($param['R_PRINT']);
		$paramData['R_ORDER']					= $db->getSQLInteger($param['R_ORDER']);
		$paramData['R_B_MPRICE']				= $db->getSQLString($param['R_B_MPRICE']);
		$paramData['R_B_WPRICE']				= $db->getSQLString($param['R_B_WPRICE']);
		$paramData['R_B_SPRICE']				= $db->getSQLString($param['R_B_SPRICE']);
		$paramData['R_Z_MPRICE']				= $db->getSQLString($param['R_Z_MPRICE']);
		$paramData['R_Z_WPRICE']				= $db->getSQLString($param['R_Z_WPRICE']);
		$paramData['R_Z_SPRICE']				= $db->getSQLString($param['R_Z_SPRICE']);
		$paramData['R_S_MPRICE']				= $db->getSQLString($param['R_S_MPRICE']);
		$paramData['R_S_WPRICE']				= $db->getSQLString($param['R_S_WPRICE']);
		$paramData['R_S_SPRICE']				= $db->getSQLString($param['R_S_SPRICE']);
		$paramData['R_BI_PRICE']				= $db->getSQLString($param['R_BI_MPRICE']);
		$paramData['R_ZI_PRICE']				= $db->getSQLString($param['R_ZI_MPRICE']);
		$paramData['R_SI_PRICE']				= $db->getSQLString($param['R_SI_MPRICE']);
		$paramData['R_MEMO']					= $db->getSQLString($param['R_MEMO']);
		$paramData['R_REG_DT']					= $db->getSQLString($param['R_REG_DT']);
		$paramData['R_REG_NO']					= $db->getSQLString($param['R_REG_NO']);
		$paramData['R_LIST_IMAGE']				= $db->getSQLString($param['R_LIST_IMAGE']);

		return $db->getInsertParam("ROOM_MGR", $paramData,true);
	}

	function getRoomBasicSetInsert($db,$param)
	{
		$paramData								= "";
		$paramData['R_NO']						= $db->getSQLInteger($param['R_NO']);
		$paramData['R_SET']						= $db->getSQLString($param['R_SET']);

		return $db->getInsertParam("ROOM_BASICSET", $paramData,true);
	}

	function getTimeData1($db)
	{
		$query  = "SELECT * FROM TIME_MGR WHERE T_TYPE=2";

		return $db->getExecSql($query);
	}

	function getTimeData2($db)
	{
		$query  = "SELECT * FROM TIME_MGR WHERE T_TYPE=1";

		return $db->getExecSql($query);
	}

	function getRoomBasic2($db)
	{
		$query  = "SELECT * FROM ROOM_MGR";

		return $db->getArrayTotal($query);
	}

	function getBasicSetting($db,$strName)
	{
		$query  = "SELECT * FROM SITE_INFO WHERE COL=";
		$query .= "'".$strName."'";

		return $db->getSelect($query);
	}

	function getSiteText($db,$strName)
	{
		$query  = "SELECT * FROM SITE_TEXT WHERE COL=";
		$query .= "'".$strName."'";

		return $db->getSelect($query);
	}

	function getRoomBasic($db,$no)
	{
		$query  = "SELECT * FROM ROOM_MGR";

		return $db->getExecSql($query);
	}

	function getRoomBasic3($db,$no)
	{
		$query  = "SELECT * FROM ROOM_MGR";
		$query .= " WHERE R_NO=";
		$query .= $no;

		return $db->getSelect($query);
	}

	function getRoomBasicAll($db)
	{
		$query  = "SELECT												";
		$query .= "*													";
		$query .= "FROM ROOM_MGR ORDER BY R_ORDER ASC					";

		return $db->getExecSql($query);
	}

	function getRoomBasicSelect($db,$intNo)
	{
		$query  = "SELECT * FROM ROOM_MGR WHERE R_NO=";
		$query .= $intNo;

		return $db->getSelect($query);
	}

	function getRoomBasicSetSelect($db,$intNo)
	{
		$query  = "SELECT * FROM ROOM_BASICSET WHERE R_NO=";
		$query .= $intNo;

		return $db->getSelect($query);
	}

	function getRoomBasicUpdate($db,$param)
	{
		if(!$param['R_NO'])return;

		$paramData								= "";
		$paramData['R_NAME']					= $db->getSQLString($param['R_NAME']);
		$paramData['R_TYPE']					= $db->getSQLString($param['R_TYPE']);
		$paramData['R_AREA']					= $db->getSQLString($param['R_AREA']);
		$paramData['R_ST_PER']					= $db->getSQLString($param['R_ST_PER']);
		$paramData['R_MAX_PER']					= $db->getSQLString($param['R_MAX_PER']);
		$paramData['R_PRINT']					= $db->getSQLString($param['R_PRINT']);
		$paramData['R_ORDER']					= $db->getSQLInteger($param['R_ORDER']);
		$paramData['R_B_MPRICE']				= $db->getSQLString($param['R_B_MPRICE']);
		$paramData['R_B_WPRICE']				= $db->getSQLString($param['R_B_WPRICE']);
		$paramData['R_B_SPRICE']				= $db->getSQLString($param['R_B_SPRICE']);
		$paramData['R_Z_MPRICE']				= $db->getSQLString($param['R_Z_MPRICE']);
		$paramData['R_Z_WPRICE']				= $db->getSQLString($param['R_Z_WPRICE']);
		$paramData['R_Z_SPRICE']				= $db->getSQLString($param['R_Z_SPRICE']);
		$paramData['R_S_MPRICE']				= $db->getSQLString($param['R_S_MPRICE']);
		$paramData['R_S_WPRICE']				= $db->getSQLString($param['R_S_WPRICE']);
		$paramData['R_S_SPRICE']				= $db->getSQLString($param['R_S_SPRICE']);
		$paramData['R_BI_PRICE']				= $db->getSQLString($param['R_BI_MPRICE']);
		$paramData['R_ZI_PRICE']				= $db->getSQLString($param['R_ZI_MPRICE']);
		$paramData['R_SI_PRICE']				= $db->getSQLString($param['R_SI_MPRICE']);
		$paramData['R_MEMO']					= $db->getSQLString($param['R_MEMO']);
		$paramData['R_MOD_DT']					= $db->getSQLString($param['R_MOD_DT']);
		$paramData['R_MOD_NO']					= $db->getSQLString($param['R_MOD_NO']);
		if($param['R_LIST_IMAGE']){
		$paramData['R_LIST_IMAGE']				= $db->getSQLString($param['R_LIST_IMAGE']);
		}

		$where								= " R_NO = {$param['R_NO']} ";

		return $db->getUpdateParam("ROOM_MGR", $paramData, $where);
	}

	function getRoomBasicSetUpdate($db,$param)
	{
		if(!$param['R_NO'])return;

		$paramData								= "";
		$paramData['R_SET']					= $db->getSQLString($param['R_SET']);

		$where								= " R_NO = {$param['R_NO']} ";

		return $db->getUpdateParam("ROOM_BASICSET", $paramData, $where);
	}

	function getRoomBasicDelete($db,$param)
	{

		if (!$param['R_NO']) return;
		$where .= "R_NO = {$param['R_NO']} ";

		return $db->getDelete("ROOM_MGR", $where);
	}
}
?>