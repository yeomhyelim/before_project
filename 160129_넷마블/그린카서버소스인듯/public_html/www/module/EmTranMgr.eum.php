<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2013-01-21												|# 
#|작성내용	: 문자발송			 										|# 
#/*====================================================================*/# 

class EmTranMgr
{
	private $query;
	private $param;
	
	/********************************** select **********************************/


	/********************************** Insert **********************************/
	function getEmTranInsert(&$db)
	{
//		$query	 = "Insert into em_tran (tran_phone, tran_callback, tran_status, tran_date, tran_msg , tran_type) values ('%s','%s',%d, %s,'%s', %d)";
//		$query = sprintf($query, $this->getTRAN_PHONE(), $this->getTRAN_CALLBACK(), $this->getTRAN_STATUS(), $this->getTRAN_DATE(), $this->getTRAN_MSG(), $this->getTRAN_TYPE());

		$strTranPhone = $this->getTRAN_PHONE();
		$strTranCallBack = $this->getTRAN_CALLBACK();
		$strTranStatus = $this->getTRAN_STATUS();
		$strTranDate = $this->getTRAN_DATE();
		$strTranMsg = $this->getTRAN_MSG();
		$strTranType = $this->getTRAN_TYPE();

		## 체크
		if(!$strTranDate ) { $strTranDate  = "NOW()"; }

		$SQL =    "INSERT                     ";
		$SQL .= "  INTO                       ";
		$SQL .= "       Oneshot_Tran          ";
		$SQL .= "       (                     ";
		$SQL .= "           Status,           ";
		$SQL .= "           Phone_No,         ";
		$SQL .= "           Callback_No,      ";
		$SQL .= "           Sms_Msg,          ";
		$SQL .= "           Send_Time,        ";
		$SQL .= "           Save_Time,        ";
		$SQL .= "           Tran_Time,        ";
		$SQL .= "           Msg_Type          ";
		$SQL .= "       )                     ";
		$SQL .= "       VALUES                ";
		$SQL .= "       (                     ";
		$SQL .= "           0,                ";
		$SQL .= "           '{$strTranPhone}',			";
		$SQL .= "           '{$strTranCallBack}',       ";
		$SQL .= "           '{$strTranMsg}',			";
		$SQL .= "            {$strTranDate} ,			";
		$SQL .= "           now() ,           ";
		$SQL .= "           now() ,           ";
		$SQL .= "           4                 ";
		$SQL .= "       )                     ";
		$SQL .= "			                  ";


		return $db->getExecSql($SQL);
	}

/*
	function getEmTranInsert($db)
	{
		$query = "CALL SP_EM_TRAN_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getTRAN_PR();
		$param[]  = $this->getTRAN_REFKEY();
		$param[]  = $this->getTRAN_ID();
		$param[]  = $this->getTRAN_PHONE();			//
		$param[]  = $this->getTRAN_CALLBACK();		//
		$param[]  = $this->getTRAN_STATUS();		//
		$param[]  = $this->getTRAN_DATE();			//
		$param[]  = $this->getTRAN_RELTDATE();
		$param[]  = $this->getTRAN_REPORTDATE();
		$param[]  = $this->getTRAN_RSLT();
		$param[]  = $this->getTRAN_NET();
		$param[]  = $this->getTRAN_MSG();			//
		$param[]  = $this->getTRAN_ETC1();
		$param[]  = $this->getTRAN_ETC2();
		$param[]  = $this->getTRAN_ETC3();
		$param[]  = $this->getTRAN_ETC4();
		$param[]  = $this->getTRAN_TYPE();			//

		return $db->executeBindingQuery($query,$param,true);
	}
*/

	/********************************** update **********************************/


	/********************************** delete **********************************/

	/********************************** variable **********************************/
	function setTRAN_PR($tTRAN_PR){ $this->tTRAN_PR = $tTRAN_PR; }		
	function getTRAN_PR(){ return $this->tTRAN_PR; }		

	function setTRAN_REFKEY($TRAN_REFKEY){ $this->TRAN_REFKEY = $TRAN_REFKEY; }		
	function getTRAN_REFKEY(){ return $this->TRAN_REFKEY; }		
	
	function setTRAN_ID($TRAN_ID){ $this->TRAN_ID = $TRAN_ID; }		
	function getTRAN_ID(){ return $this->TRAN_ID; }		
	
	function setTRAN_PHONE($TRAN_PHONE){ $this->TRAN_PHONE = $TRAN_PHONE; }		
	function getTRAN_PHONE(){ return $this->TRAN_PHONE; }		
	
	function setTRAN_CALLBACK($TRAN_CALLBACK){ $this->TRAN_CALLBACK = $TRAN_CALLBACK; }		
	function getTRAN_CALLBACK(){ return $this->TRAN_CALLBACK; }		
	
	function setTRAN_STATUS($TRAN_STATUS){ $this->TRAN_STATUS = $TRAN_STATUS; }		
	function getTRAN_STATUS(){ return $this->TRAN_STATUS; }		
	
	function setTRAN_DATE($TRAN_DATE){ $this->TRAN_DATE = $TRAN_DATE; }		
	function getTRAN_DATE(){ return $this->TRAN_DATE; }		
	
	function setTRAN_RELTDATE($TRAN_RELTDATE){ $this->TRAN_RELTDATE = $TRAN_RELTDATE; }		
	function getTRAN_RELTDATE(){ return $this->TRAN_RELTDATE; }		
	
	function setTRAN_REPORTDATE($TRAN_REPORTDATE){ $this->TRAN_REPORTDATE = $TRAN_REPORTDATE; }		
	function getTRAN_REPORTDATE(){ return $this->TRAN_REPORTDATE; }		
	
	function setTRAN_RSLT($TRAN_RSLT){ $this->TRAN_RSLT = $TRAN_RSLT; }		
	function getTRAN_RSLT(){ return $this->TRAN_RSLT; }		
	
	function setTRAN_NET($TRAN_NET){ $this->TRAN_NET = $TRAN_NET; }		
	function getTRAN_NET(){ return $this->TRAN_NET; }		
	
	function setTRAN_MSG($tTRAN_MSG){ $this->tTRAN_MSG = $tTRAN_MSG; }		
	function getTRAN_MSG(){ return $this->tTRAN_MSG; }		
	
	function setTRAN_ETC1($TRAN_ETC1){ $this->TRAN_ETC1 = $TRAN_ETC1; }		
	function getTRAN_ETC1(){ return $this->TRAN_ETC1; }		
	
	function setTRAN_ETC2($TRAN_ETC2){ $this->TRAN_ETC2 = $TRAN_ETC2; }		
	function getTRAN_ETC2(){ return $this->TRAN_ETC2; }		
	
	function setTRAN_ETC3($TRAN_ETC3){ $this->TRAN_ETC3 = $TRAN_ETC3; }		
	function getTRAN_ETC3(){ return $this->TRAN_ETC3; }		
	
	function setTRAN_ETC4($TRAN_ETC4){ $this->TRAN_ETC4 = $TRAN_ETC4; }		
	function getTRAN_ETC4(){ return $this->TRAN_ETC4; }		
	
	function setTRAN_TYPE($TRAN_TYPE){ $this->TRAN_TYPE = $TRAN_TYPE; }		
	function getTRAN_TYPE(){ return $this->TRAN_TYPE; }		
	/********************************** variable **********************************/
}
?>