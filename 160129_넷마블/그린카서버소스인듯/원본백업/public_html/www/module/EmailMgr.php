<?
#/*====================================================================*/# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-08-14												|# 
#|작성내용	: 자동 mail 관리			 										|# 
#/*====================================================================*/# 

class EmailMgr
{
	private $query;
	private $param;
	
	/********************************** select **********************************/
	function getEmailList($db)
	{
		$intGrpNo	= $this->getCG_NO_GRP();		// 그룹 이름을 알기 위해서
		$intSendNo	= $this->getCG_NO_SEND();		// 메세지 제목을 알기 위해서
		
		$query  = "SELECT A.EM_NO, A.EM_GRP_CODE, A.EM_SEND_CODE, A.EM_TITLE, A.EM_TEXT, A.EM_AUTO	";
		$query .= ", A.EM_SENDER, A.EM_REG_DT, B.CC_NAME_".$this->getEM_LNG()." AS EM_GRP_NAME		";
		$query .= ", C.CC_NAME_".$this->getEM_LNG()." AS EM_SEND_NAME FROM ".TBL_EMAIL_MGR." A		";
		$query .= "LEFT OUTER JOIN COMM_CODE B ON A.EM_GRP_CODE = B.CC_CODE	AND B.CC_USE = 'Y'		";
		$query .= "LEFT OUTER JOIN COMM_CODE C ON A.EM_SEND_CODE = C.CC_CODE AND C.CC_USE = 'Y'		";
		$query .= "WHERE A.EM_LNG = '".$this->getEM_LNG()."' AND B.CG_NO = $intGrpNo AND C.CG_NO = $intSendNo  ";
		$query .= "ORDER BY A.EM_GRP_CODE ASC	"; 

		return $db->getExecSql($query);
	}

	function getEmailGrpList($db)
	{
		$query	 = "SELECT CC_NO, CG_NO, CC_CODE, CC_NAME_".$this->getEM_LNG().", CC_SORT FROM COMM_CODE A WHERE CG_NO = 35 AND CC_USE = 'Y'  ORDER BY A.CC_SORT ASC";

		return $db->getExecSql($query);
	}

	function getEmailView($db)
	{
		$intNo		= $this->getEM_NO();			// 번호
		$intGrpNo	= $this->getCG_NO_GRP();		// 그룹 이름을 알기 위해서
		$intSendNo	= $this->getCG_NO_SEND();		// 메세지 제목을 알기 위해서

		$query  = "SELECT A.EM_NO, A.EM_TITLE, A.EM_TEXT, A.EM_AUTO, A.EM_SENDER, A.EM_REG_DT, B.CC_NAME_".$this->getEM_LNG()." AS EM_GRP_NAME,";
		$query .= " C.CC_NAME_".$this->getEM_LNG()." AS EM_SEND_NAME FROM ".TBL_EMAIL_MGR." A			";
		$query .= "LEFT OUTER JOIN COMM_CODE B ON A.EM_GRP_CODE = B.CC_CODE			";
		$query .= "LEFT OUTER JOIN COMM_CODE C ON A.EM_SEND_CODE = C.CC_CODE		";
		$query .= "WHERE A.EM_NO = $intNo AND B.CG_NO = $intGrpNo AND C.CG_NO = $intSendNo ";
		$query .= " AND A.EM_LNG = '".$this->getEM_LNG()."' ORDER BY A.EM_GRP_CODE ASC		";

		return $db->getSelect($query);
	}

	/* email 내용 업데이트 */
	function getEmailUseUpdate($db)
	{
		$intNo		= $this->getEM_NO();			// 번호

		$query  = "  EM_TITLE			= '".mysql_real_escape_string($this->getEM_TITLE())."'";
		$query .= ", EM_TEXT			= '".mysql_real_escape_string($this->getEM_TEXT())."'";
		$query .= ", EM_AUTO			= '".mysql_real_escape_string($this->getEM_AUTO())."'";
		$query .= ", EM_SENDER			= '".mysql_real_escape_string($this->getEM_SENDER())."'";

		return $db->getUpdateSql(TBL_EMAIL_MGR,$query, " Where EM_NO = $intNo");
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
	function setEM_NO($EM_NO){ $this->EM_NO = $EM_NO; }		
	function getEM_NO(){ return $this->EM_NO; }		

	function setEM_GRP_CODE($EM_GRP_CODE){ $this->EM_GRP_CODE = $EM_GRP_CODE; }		
	function getEM_GRP_CODE(){ return $this->EM_GRP_CODE; }		

	function setEM_SEND_CODE($EM_SEND_CODE){ $this->EM_SEND_CODE = $EM_SEND_CODE; }		
	function getEM_SEND_CODE(){ return $this->EM_SEND_CODE; }		

	function setEM_TITLE($EM_TITLE){ $this->EM_TITLE = $EM_TITLE; }		
	function getEM_TITLE(){ return $this->EM_TITLE; }		

	function setEM_TEXT($EM_TEXT){ $this->EM_TEXT = $EM_TEXT; }		
	function getEM_TEXT(){ return $this->EM_TEXT; }		

	function setEM_AUTO($EM_AUTO){ $this->EM_AUTO = $EM_AUTO; }		
	function getEM_AUTO(){ return $this->EM_AUTO; }		

	function setEM_SENDER($EM_SENDER){ $this->EM_SENDER = $EM_SENDER; }		
	function getEM_SENDER(){ return $this->EM_SENDER; }		

	function setEM_REG_DT($EM_REG_DT){ $this->EM_REG_DT = $EM_REG_DT; }		
	function getEM_REG_DT(){ return $this->EM_REG_DT; }		

	function setEM_REG_NO($EM_REG_NO){ $this->EM_REG_NO = $EM_REG_NO; }		
	function getEM_REG_NO(){ return $this->EM_REG_NO; }		

	function setEM_MOD_DT($EM_MOD_DT){ $this->EM_MOD_DT = $EM_MOD_DT; }		
	function getEM_MOD_DT(){ return $this->EM_MOD_DT; }		

	function setEM_MOD_NO($EM_MOD_NO){ $this->EM_MOD_NO = $EM_MOD_NO; }		
	function getEM_MOD_NO(){ return $this->EM_MOD_NO; }		

	function setEM_LNG($EM_LNG){ $this->EM_LNG = $EM_LNG; }		
	function getEM_LNG(){ return $this->EM_LNG; }		

	function setCG_NO_GRP($CG_NO_GRP){ $this->CG_NO_GRP = $CG_NO_GRP; }		
	function getCG_NO_GRP(){ return $this->CG_NO_GRP; }
	
	function setCG_NO_SEND($CG_NO_SEND){ $this->CG_NO_SEND = $CG_NO_SEND; }		
	function getCG_NO_SEND(){ return $this->CG_NO_SEND; }

	/********************************** variable **********************************/


}
?>