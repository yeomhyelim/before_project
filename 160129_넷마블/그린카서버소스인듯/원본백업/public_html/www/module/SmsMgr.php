<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-08-14												|# 
#|작성내용	: sms 관리			 										|# 
#/*====================================================================*/# 

class SmsMgr
{
	private $query;
	private $param;
	
	/********************************** select **********************************/
	function getSmsList($db)
	{
		$intGrpNo	= $this->getCG_NO_GRP();		// 그룹 이름을 알기 위해서
		$intsendNo	= $this->getCG_NO_SEND();		// 메세지 제목을 알기 위해서
		
		$query   = "SELECT A.SM_NO, A.SM_GRP_CODE, A.SM_SEND_CODE, A.SM_TEXT, A.SM_AUTO, A.SM_AUTO, A.SM_REG_DT, B.CC_NAME_KR AS SM_GRP_NAME, C.CC_NAME_KR AS SM_SEND_NAME FROM SMS_MGR A		";
		$query	.= "LEFT OUTER JOIN COMM_CODE B ON A.SM_GRP_CODE = B.CC_CODE AND B.CC_USE = 'Y'				";
		$query	.= "LEFT OUTER JOIN COMM_CODE C ON A.SM_SEND_CODE = C.CC_CODE AND C.CC_USE = 'Y'			";
		$query	.= "WHERE B.CG_NO = $intGrpNo AND C.CG_NO = $intsendNo ORDER BY A.SM_GRP_CODE ASC			";

		return $db->getExecSql($query);
	}

	function getSmsGrpList($db)
	{
		$query	 = "SELECT CC_NO, CG_NO, CC_CODE, CC_NAME_KR, CC_SORT FROM COMM_CODE A WHERE CG_NO = 33 AND CC_USE = 'Y'  ORDER BY A.CC_SORT ASC";

		return $db->getExecSql($query);
	}

	function getSmsText($db)
	{
		$strCCName	= $this->getCC_NAME_KR();

		$query    = "SELECT C.SM_NO, C.SM_TEXT, C.SM_AUTO FROM COMM_CODE A																						";
		$query   .= "LEFT OUTER JOIN COMM_GRP B ON A.CG_NO = B.CG_NO																							";
		$query   .= "LEFT OUTER JOIN SMS_MGR C ON A.CC_NAME_KR = '$strCCName'																						";
		$query   .= "LEFT OUTER JOIN SITE_MGR D ON D.S_SMS_MONEY																								";
		$query   .= "WHERE A.CC_CODE = C.SM_SEND_CODE AND CG_CODE = 'SEND' AND CC_USE = 'Y' AND CG_USE = 'Y' AND D.S_SMS_MONEY > 0  AND D.S_SMS_USE = 'Y'		";
		// 조건문 설명 :	관리자에서 sms전송 사용 유무 = 사용함(Y) 로 되어 있어야 하며
		//					메시지 건수가 0건 이상 되어 있어야 하며
		//					비밀번호 찾기(고객용) 이 자동발송 설정이 되어 있어야 한다.

		return $db->getSelect($query);
	}

	function getCommGrpList($db)
	{
		if ( !$this->getCG_CODE() ) :
			return -100;
		endif;

		$query  = "SELECT * FROM " . TBL_COMM_GRP . " WHERE CG_CODE  ='" . $this->getCG_CODE() . "'";

		return $db->getArrayTotal($query);
	}

	/********************************** Insert **********************************/
	/* 2012.08.14 no use
	function getInsert($db)
	{
		$query = "CALL SP_SMS_MGR_I (?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getSM_NO();
		$param[]  = $this->getSM_GRP_CODE();
		$param[]  = $this->getSM_SEND_CODE();
		$param[]  = $this->getSM_TEXT();
		$param[]  = $this->getSM_AUTO();
		$param[]  = $this->getSM_REG_DT();
		$param[]  = $this->getSM_REG_NO();
		$param[]  = $this->getSM_MOD_DT();
		$param[]  = $this->getSM_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	*/

	function getSmsLogInsert($db)
	{
		$query = "CALL SP_SMS_LOG_I (?,?,?,?,?,?);";

		$param[]  = $this->getSM_NO();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getMS_SEND_NO();
		$param[]  = $this->getMS_SEND_MSG();
		$param[]  = $this->getMS_SEND_STATUS();
		$param[]  = $this->getMS_SEND_DT();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** update **********************************/
	function getSmsUpdate($db)
	{
		$query = "CALL SP_SMS_MGR_U (?,?,?,?,?);";

		$param[]  = $this->getSM_NO();
		$param[]  = $this->getSM_TEXT();
		$param[]  = $this->getSM_AUTO();
		$param[]  = $this->getSM_MOD_DT();
		$param[]  = $this->getSM_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);	
	}


	/********************************** delete **********************************/
	/* 2012.08.14 no use
	function getDelete($db)
	{
		$query = "CALL SP_SMS_MGR_D (?);";
		$param[]  = $this->getSM_NO();

		return $db->executeBindingQuery($query,$param,true);
	}
	*/


	/********************************** variable **********************************/
	function setSM_NO($SM_NO){ $this->SM_NO = $SM_NO; }		
	function getSM_NO(){ return $this->SM_NO; }		

	function setSM_GRP_CODE($SM_GRP_CODE){ $this->SM_GRP_CODE = $SM_GRP_CODE; }		
	function getSM_GRP_CODE(){ return $this->SM_GRP_CODE; }		

	function setSM_SEND_CODE($SM_SEND_CODE){ $this->SM_SEND_CODE = $SM_SEND_CODE; }		
	function getSM_SEND_CODE(){ return $this->SM_SEND_CODE; }		

	function setSM_TEXT($SM_TEXT){ $this->SM_TEXT = $SM_TEXT; }		
	function getSM_TEXT(){ return $this->SM_TEXT; }		

	function setSM_AUTO($SM_AUTO){ $this->SM_AUTO = $SM_AUTO; }		
	function getSM_AUTO(){ return $this->SM_AUTO; }		

	function setSM_REG_DT($SM_REG_DT){ $this->SM_REG_DT = $SM_REG_DT; }		
	function getSM_REG_DT(){ return $this->SM_REG_DT; }		

	function setSM_REG_NO($SM_REG_NO){ $this->SM_REG_NO = $SM_REG_NO; }		
	function getSM_REG_NO(){ return $this->SM_REG_NO; }		

	function setSM_MOD_DT($SM_MOD_DT){ $this->SM_MOD_DT = $SM_MOD_DT; }		
	function getSM_MOD_DT(){ return $this->SM_MOD_DT; }		

	function setSM_MOD_NO($SM_MOD_NO){ $this->SM_MOD_NO = $SM_MOD_NO; }		
	function getSM_MOD_NO(){ return $this->SM_MOD_NO; }	
	
	function setCG_NO_GRP($CG_NO_GRP){ $this->CG_NO_GRP = $CG_NO_GRP; }		
	function getCG_NO_GRP(){ return $this->CG_NO_GRP; }
	
	function setCG_NO_SEND($CG_NO_SEND){ $this->CG_NO_SEND = $CG_NO_SEND; }		
	function getCG_NO_SEND(){ return $this->CG_NO_SEND; }

	function setCC_NAME_KR($CC_NAME_KR){ $this->CC_NAME_KR = $CC_NAME_KR; }		
	function getCC_NAME_KR(){ return $this->CC_NAME_KR; }	

	/* SMS_LOG */
	function setMS_NO($MS_NO){ $this->MS_NO = $MS_NO; }		
	function getMS_NO(){ return $this->MS_NO; }		

//	function setSM_NO($SM_NO){ $this->SM_NO = $SM_NO; }		
//	function getSM_NO(){ return $this->SM_NO; }	

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		

	function setMS_SEND_NO($MS_SEND_NO){ $this->MS_SEND_NO = $MS_SEND_NO; }		
	function getMS_SEND_NO(){ return $this->MS_SEND_NO; }		

	function setMS_SEND_MSG($MS_SEND_MSG){ $this->MS_SEND_MSG = $MS_SEND_MSG; }		
	function getMS_SEND_MSG(){ return $this->MS_SEND_MSG; }		

	function setMS_SEND_STATUS($MS_SEND_STATUS){ $this->MS_SEND_STATUS = $MS_SEND_STATUS; }		
	function getMS_SEND_STATUS(){ return $this->MS_SEND_STATUS; }		

	function setMS_SEND_DT($MS_SEND_DT){ $this->MS_SEND_DT = $MS_SEND_DT; }		
	function getMS_SEND_DT(){ return $this->MS_SEND_DT; }		

	function setCG_CODE($CG_CODE){ $this->CG_CODE = $CG_CODE; }		
	function getCG_CODE(){ return $this->CG_CODE; }
	/********************************** variable **********************************/


}
?>