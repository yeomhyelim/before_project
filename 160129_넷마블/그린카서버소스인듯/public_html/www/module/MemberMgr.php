<?
#/*====================================================================*/#
#|작성자	: 박영미(ivetmi@naver.com)									|#
#|작성일	: 2012-06-04												|#
#|작성내용	: 회원관리													|#
#/*====================================================================*/#

class MemberMgr
{
	private $query;
	private $param;

	/********************************** List **********************************/
	function getGroupList($db)
	{
		$query = "SELECT * FROM ".TBL_MEMBER_GROUP." ORDER BY G_CODE ASC";

		return $db->getArrayTotal($query);
	}

	/********************************** View **********************************/
	function getGroupView($db)
	{
		$query = "SELECT * FROM ".TBL_MEMBER_GROUP." WHERE G_CODE = '".mysql_real_escape_string($this->getG_CODE())."'";

		return $db->getSelect($query);
	}

	function getSettingView($db)
	{
		$query = "SELECT * FROM ".TBL_MEMBER_JOIN;

		return $db->getSelect($query);
	}

	function getMemberView($db)
	{
		$query  = "SELECT A.*,CONCAT(IFNULL(A.M_F_NAME,''),' ',IFNULL(A.M_L_NAME,'')) M_NAME, B.* ";
		$query .= ",(SELECT CONCAT(M_F_NAME,' ',IFNULL(M_L_NAME,'')) FROM ".TBL_MEMBER_MGR." WHERE M_NO = A.M_REC_ID) M_REC_NAME	";
		$query .= "FROM ".TBL_MEMBER_MGR." A ";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_ADD." B ON A.M_NO = B.M_NO WHERE A.M_NO = ".$this->getM_NO();
		$query .= "	AND IF(A.M_OUT = '' , 'N', IFNULL(A.M_OUT,'N')) = 'N'	";
		return $db->getSelect($query);
	}

	function getMemberInfo($db)
	{
		$query  = "SELECT A.*		";
		$query .= ",B.M_WED         ";
		$query .= ",B.M_WED_DAY     ";
		$query .= ",B.M_JOB         ";
		$query .= ",B.M_CHILD       ";
		$query .= ",B.M_COM_NM      ";
		$query .= ",B.M_BUSI_NM     ";
		$query .= ",B.M_BUSI_NUM    ";
		$query .= ",B.M_BUSI_UPJ    ";
		$query .= ",B.M_BUSI_UTE    ";
		$query .= ",B.M_BUSI_ZIP    ";
		$query .= ",B.M_BUSI_ADDR1  ";
		$query .= ",B.M_BUSI_ADDR2  ";
		$query .= ",B.M_CONCERN     ";
		$query .= ",B.M_FOREIGN     ";
		$query .= ",B.M_FOREIGN_NUM	";
		$query .= ",B.M_PASSPORT    ";
		$query .= ",B.M_DRIVE_NUM   ";
		$query .= ",B.M_NATION      ";
		$query .= ",B.M_PHOTO       ";
		$query .= ",B.M_TMP1        ";
		$query .= ",B.M_TMP2        ";
		$query .= ",B.M_TMP3        ";
		$query .= ",B.M_TMP4        ";
		$query .= ",B.M_TMP5        ";
		$query .= ",CONCAT(A.M_F_NAME,' ',IFNULL(A.M_L_NAME,'')) M_NAME		";
		$query .= ",(SELECT CONCAT(M_F_NAME,' ',IFNULL(M_L_NAME,'')) FROM ".TBL_MEMBER_MGR." WHERE M_NO = A.M_REC_ID) M_REC_NAME	";
		$query .= ",C.G_LEVEL								";
		$query .= ",C.G_NAME								";
		$query .= "FROM ".TBL_MEMBER_MGR." A				";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_ADD." B		";
		$query .= "ON A.M_NO = B.M_NO						";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_GROUP." C	";
		$query .= "ON A.M_GROUP = C.G_CODE					";
		$query .= "WHERE A.M_NO IS NOT NULL			";
		$query .= "	AND IF(A.M_OUT = '' , 'N', IFNULL(A.M_OUT,'N')) = 'N'	";
		if ($this->getM_ID()){
			$query .= "AND A.M_ID = '".$this->getM_ID()."'	";
		}

		if ($this->getM_MAIL()){
			$query .= "AND A.M_MAIL = '".$this->getM_MAIL()."'	";
		}

		if ($this->getM_TM_ID()){
			$query .= "	AND A.M_TM_ID = '".$this->getM_TM_ID()."'	";
		}

		if ($this->getM_TMP1()){
			$query .= "	AND B.M_TMP1 = '".$this->getM_TMP1()."'	";
		}

		return $db->getSelect($query);
	}

	function getMemberPwdCheck($db)
	{
		$query  = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." A		";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_GROUP." B	";
		$query .= "ON A.M_GROUP = B.G_CODE					";

		if ($this->getM_TMP1()){
			$query .= "LEFT OUTER JOIN ".TBL_MEMBER_ADD." C	";
			$query .= "ON A.M_NO = C.M_NO					";
		}

		if ($this->getM_ID()){
			$query .= "WHERE A.M_ID = '".$this->getM_ID()."'";
		}

		if ($this->getM_MAIL()){
			$query .= "WHERE A.M_MAIL = '".$this->getM_MAIL()."'";
		}

		if ($this->getM_TMP1()){
			$query .= "	WHERE C.M_TMP1 = '".$this->getM_TMP1()."'	";
		}
	
		$query .= "	AND IF(A.M_OUT = '' , 'N', IFNULL(A.M_OUT,'N')) = 'N'	";
		$query .= " AND A.M_PASS = SHA1(CONCAT('".$this->getM_PASS()."','!@#$'))	";
		return $db->getCount($query);
	}

	function getFaceBookLogin($db) {

		$query  = "SELECT A.*,B.G_LEVEL FROM ".TBL_MEMBER_MGR." A		";
		$query .= "LEFT OUTER JOIN ".TBL_MEMBER_GROUP." B	";
		$query .= "ON A.M_GROUP = B.G_CODE					";
		$query .= "WHERE A.M_FACEBOOK_ID = '".$this->getM_FACEBOOK_ID()."'		";
		$query .= "	AND IF(A.M_OUT = '' , 'N', IFNULL(A.M_OUT,'N')) = 'N'	";
//		$query .= "	AND A.M_FACEBOOK_TOKEN = '".$this->getM_FACEBOOK_TOKEN()."'	";

		return $db->getSelect($query);
	}

	function getMemberOrderCount($db)
	{
		$query  = "SELECT                                                               ";
		$query .= "     COUNT(*) JUMUN_CNT                                              ";
		$query .= "    ,SUM((CASE WHEN O_STATUS = 'E' THEN 1 ELSE 0 END)) DELIVERY_CNT	";
		$query .= "FROM ".TBL_ORDER_MGR." A                                             ";
		$query .= "WHERE A.M_NO = ".$this->getM_NO();
		$query .= " AND A.O_STATUS NOT IN ('F','W')										";
		return $db->getSelect($query);
	}

	function getMemberAddrList($db)
	{
		$query  = "SELECT A. * ";
		$query .= "FROM ".TBL_MEMBER_ADDR." A	";
		$query .= "WHERE A.M_NO = ".$this->getM_NO()."	";
		$query .= "ORDER BY A.MA_TYPE,A.MA_NO DESC	";
		return $db->getArrayTotal($query);
	}

	function getMemberAddrView($db)
	{
		$query  = "SELECT A. * ";
		$query .= "FROM ".TBL_MEMBER_ADDR." A	";
		$query .= "WHERE A.MA_NO = ".$this->getMA_NO()."	";
		return $db->getSelect($query);
	}

	function getMemberBasicAddrCount($db)
	{
		$query  = "SELECT A.MA_NO						";
		$query .= "FROM ".TBL_MEMBER_ADDR." A			";
		$query .= "WHERE A.M_NO = ".$this->getM_NO()."	";
		$query .= " AND A.MA_TYPE = '1'					";

		return $db->getCount($query);
	}

	function getMemberCouponList($db,$opt)
	{
		$query  = "SELECT							";
		if ($opt == "Count") $query .= " COUNT(*)	";
		else {
			$query .= "     A.*						";
			$query .= "    ,C.CU_NAME				";
			$query .= "    ,C.CU_PRICE				";
		}
		$query .= "FROM ".TBL_COUPON_ISSUE." A		";
		$query .= "JOIN ".TBL_MEMBER_MGR." B		";
		$query .= "ON A.M_NO = B.M_NO				";
		$query .= "JOIN ".TBL_COUPON_MGR." C		";
		$query .= "ON A.CU_NO = C.CU_NO				";
		$query .= "WHERE A.M_NO = ".$this->getM_NO();
		$query .= "	AND IF(B.M_OUT = '' , 'N', IFNULL(B.M_OUT,'N')) = 'N'	";
		if ($opt == "Count") return $db->getCount($query);
		else {
			$query .= "	ORDER BY A.CI_NO DESC LIMIT ".$this->getLimitFirst().",".$this->getPageLine();
			return $db->getExecSql($query);
		}
	}

	function getJoinItemList($db)
	{
		$query  = "                               ";
		$query .= "SELECT *                       ";
		$query .= "FROM ".TBL_MEMBER_JOIN_ITEM."  ";

		if ($this->getJI_GB()){
			$query .= "WHERE JI_GB = '".$this->getJI_GB()."'	";
			$query .= "ORDER BY JI_ORDER ASC					";
		} else {
			$query .= "ORDER BY JI_GB ASC,JI_ORDER ASC			";

		}

		return $db->getArrayTotal($query);
	}

	function getMemberFamilyList($db)
	{
		$query  = "SELECT *									";
		$query .= "FROM ".TBL_MEMBER_FAMILY." A				";
		$query .= "WHERE A.M_NO = '".$this->getM_NO()."'	";
		$query .= "ORDER BY A.MF_NO ASC						";

		return $db->getArrayTotal($query);
	}

	function getMemberPointDupCnt($db,$param,$op="OP_COUNT")
	{
		$column['OP_COUNT']		= "COUNT(*)							";
		$column['OP_SELECT']	= "*								";

		$query  = "SELECT											";
		$query .= $column[$op];
		$query .= "FROM ".TBL_POINT_MGR."							";
		$query .= "WHERE M_NO		= ".$param["M_NO"]."			";
		$query .= "    AND O_NO		= ".$param["O_NO"]."			";
		$query .= "    AND PT_TYPE	= '".$param["POINT_TYPE"]."'	";

		if ($param["POINT_ETC"]){
			$query .= "    AND PT_ETC = '".$param["POINT_ETC"]."'	";
		}

		if ($op == "OP_COUNT") return $db->getCount($query);
		else if($op == "OP_SELECT") return $db->getSelect($query);
	}

	/********************************** Insert **********************************/
	function getMemberInsert($db)
	{
		$query = "CALL SP_MEMBER_MGR_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_ID();
		$param[]  = $this->getM_PASS();
		$param[]  = $this->getM_F_NAME();
		$param[]  = $this->getM_L_NAME();
		$param[]  = $this->getM_NICK_NAME();
		$param[]  = $this->getM_BIRTH_CAL();
		$param[]  = $this->getM_BIRTH();
		$param[]  = $this->getM_SEX();
		$param[]  = $this->getM_MAIL();
		$param[]  = $this->getM_PHONE();
		$param[]  = $this->getM_FAX();
		$param[]  = $this->getM_HP();
		$param[]  = $this->getM_ZIP();
		$param[]  = $this->getM_COUNTRY();
		$param[]  = $this->getM_ADDR();
		$param[]  = $this->getM_ADDR2();
		$param[]  = $this->getM_CITY();
		$param[]  = $this->getM_STATE();
		$param[]  = $this->getM_SMSYN();
		$param[]  = $this->getM_MAILYN();
		$param[]  = $this->getM_TEXT();
		$param[]  = $this->getM_REC_ID();
		$param[]  = $this->getM_GROUP();
		$param[]  = $this->getM_AUTH();
		$param[]  = $this->getM_POINT();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberAddInsert($db)
	{
		$query = "CALL SP_MEMBER_ADD_I (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getM_WED();
		$param[]  = $this->getM_WED_DAY();
		$param[]  = $this->getM_JOB();
		$param[]  = $this->getM_CHILD();
		$param[]  = $this->getM_COM_NM();
		$param[]  = $this->getM_BUSI_NM();
		$param[]  = $this->getM_BUSI_NUM();
		$param[]  = $this->getM_BUSI_UPJ();
		$param[]  = $this->getM_BUSI_UTE();
		$param[]  = $this->getM_BUSI_ZIP();
		$param[]  = $this->getM_BUSI_ADDR1();
		$param[]  = $this->getM_BUSI_ADDR2();
		$param[]  = $this->getM_CONCERN();
		$param[]  = $this->getM_FOREIGN();
		$param[]  = $this->getM_FOREIGN_NUM();
		$param[]  = $this->getM_PASSPORT();
		$param[]  = $this->getM_DRIVE_NUM();
		$param[]  = $this->getM_NATION();
		$param[]  = $this->getM_PHOTO();
		$param[]  = $this->getM_TMP1();
		$param[]  = $this->getM_TMP2();
		$param[]  = $this->getM_TMP3();
		$param[]  = $this->getM_TMP4();
		$param[]  = $this->getM_TMP5();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberPointInsert($db)
	{
		$query = "CALL SP_POINT_MGR_I (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getB_NO();
		$param[]  = $this->getO_NO();
		$param[]  = $this->getPT_TYPE();
		$param[]  = $this->getPT_POINT();
		$param[]  = $this->getPT_MEMO();
		$param[]  = $this->getPT_START_DT();
		$param[]  = $this->getPT_END_DT();
		$param[]  = $this->getPT_REG_IP();
		$param[]  = $this->getPT_ETC();
		$param[]  = $this->getPT_REG_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberAddrInsert($db)
	{
		$query = "CALL SP_MEMBER_ADDR_I (?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getMA_TYPE();
		$param[]  = $this->getMA_NAME();
		$param[]  = $this->getMA_PHONE();
		$param[]  = $this->getMA_HP();
		$param[]  = $this->getMA_ZIP();
		$param[]  = $this->getMA_COUNTRY();
		$param[]  = $this->getMA_ADDR1();
		$param[]  = $this->getMA_ADDR2();
		$param[]  = $this->getMA_CITY();
		$param[]  = $this->getMA_STATE();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** Update **********************************/
	function getMemberUpdate($db)
	{
		$query = "CALL SP_MEMBER_MGR_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getM_MAIL();
		$param[]  = $this->getM_PHONE();
		$param[]  = $this->getM_HP();
		$param[]  = $this->getM_ZIP();
		$param[]  = $this->getM_ADDR();
		$param[]  = $this->getM_ADDR2();
		$param[]  = $this->getM_SMSYN();
		$param[]  = $this->getM_MAILYN();
		$param[]  = $this->getM_GROUP();
		$param[]  = $this->getM_COUNTRY();
		$param[]  = $this->getM_CITY();
		$param[]  = $this->getM_STATE();
		$param[]  = $this->getM_FAX();
		$param[]  = $this->getM_TEXT();
		$param[]  = $this->getM_MOD_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberPwdUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_PASS = SHA1(CONCAT('".$this->getM_PASS()."','!@#$')) WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberPointUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_POINT = IFNULL(M_POINT,0) + ".$this->getM_POINT()." WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberAddUpdate($db)
	{
		$query = "CALL SP_MEMBER_ADD_U (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getM_NO();
		$param[]  = $this->getM_WED();
		$param[]  = $this->getM_WED_DAY();
		$param[]  = $this->getM_JOB();
		$param[]  = $this->getM_CHILD();
		$param[]  = $this->getM_COM_NM();
		$param[]  = $this->getM_BUSI_NM();
		$param[]  = $this->getM_BUSI_NUM();
		$param[]  = $this->getM_BUSI_UPJ();
		$param[]  = $this->getM_BUSI_UTE();
		$param[]  = $this->getM_BUSI_ZIP();
		$param[]  = $this->getM_BUSI_ADDR1();
		$param[]  = $this->getM_BUSI_ADDR2();
		$param[]  = $this->getM_CONCERN();
		$param[]  = $this->getM_FOREIGN();
		$param[]  = $this->getM_FOREIGN_NUM();
		$param[]  = $this->getM_PASSPORT();
		$param[]  = $this->getM_DRIVE_NUM();
		$param[]  = $this->getM_NATION();
		$param[]  = $this->getM_PHOTO();
		$param[]  = $this->getM_TMP1();
		$param[]  = $this->getM_TMP2();
		$param[]  = $this->getM_TMP3();
		$param[]  = $this->getM_TMP4();
		$param[]  = $this->getM_TMP5();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberAddrUpdate($db)
	{
		$query = "CALL SP_MEMBER_ADDR_U (?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getMA_NO();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getMA_TYPE();
		$param[]  = $this->getMA_NAME();
		$param[]  = $this->getMA_PHONE();
		$param[]  = $this->getMA_HP();
		$param[]  = $this->getMA_ZIP();
		$param[]  = $this->getMA_COUNTRY();
		$param[]  = $this->getMA_ADDR1();
		$param[]  = $this->getMA_ADDR2();
		$param[]  = $this->getMA_CITY();
		$param[]  = $this->getMA_STATE();

		return $db->executeBindingQuery($query,$param,true);
	}
	/********************************** Delete **********************************/

	/********************************** Member Auth **********************************/
	function getMemberAuth($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_AUTH = 'Y' WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	/********************************** Member Out **********************************/
	function getMemberOut($db)
	{
		$m_out_txt = $this->getM_OUT_TXT();
		$m_out_txt = mysql_real_escape_string($m_out_txt);

		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_OUT = 'Y' , M_OUT_DT = NOW() , M_OUT_TXT = '{$m_out_txt}' WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	
	function getMemberReJoinCheck($db)
	{
		$query  = "SELECT M_NO, M_ID, M_OUT, M_OUT_DT  ";
		$query .= "FROM ".TBL_MEMBER_MGR."	";
		$query .= "WHERE M_ID = '".$this->getM_ID()."'	";
		$query .= " AND M_OUT = 'Y'";

		return $db->getArrayTotal($query);
	}

	function getMemberValidIdCheck($db)
	{
		$query  = "SELECT COUNT(M_NO)  ";
		$query .= "FROM ".TBL_MEMBER_MGR."	";
		$query .= "WHERE M_ID = '".$this->getM_ID()."'	";
		$query .= " AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'";

		return $db->getCount($query);
	}


	/********************************** Member Id Check **********************************/
	function getMemberIdCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_ID='".$this->getM_ID()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";
		return $db->getCount($query);
	}

	/********************************** Member Nick Name Check **********************************/
	function getMemberNickNameCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_NICK_NAME='".$this->getM_NICK_NAME()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";
		return $db->getCount($query);
	}

	/********************************** Member Mail Check **********************************/
	function getMemberMailCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_MAIL='".$this->getM_MAIL()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";
		return $db->getCount($query);
	}

	/********************************** Member Mail Check **********************************/
	function getMemberCompanyCheck($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_TM_ID='".$this->getM_COM_NM()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";
		return $db->getCount($query);
	}

	/********************************** Member Find Id & Password Check **********************************/
	function getMemberFindId($db)
	{
		/** 2013.04.12 다국어 버전으로 아이디 찾기 변경
		$query  = "SELECT * FROM ".TBL_MEMBER_MGR." WHERE M_F_NAME='".$this->getM_ID_NAME()."' ";
		$query .= "AND M_MAIL='".$this->getM_ID_MAIL1()."@".$this->getM_ID_MAIL2()."'";
		**/

		global $S_SITE_LNG;

		$query  = "SELECT * FROM ".TBL_MEMBER_MGR." ";
		$query .= "WHERE M_NO IS NOT NULL			";

		if ($S_SITE_LNG != "KR"){
			$query .= "	AND M_F_NAME='".$this->getM_F_ID_NAME()."' ";
		}

		$query .= " AND M_L_NAME='".$this->getM_L_ID_NAME()."' ";
		$query .= " AND M_MAIL='".$this->getM_ID_MAIL1()."@".$this->getM_ID_MAIL2()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";
		return $db->getSelect($query);
	}

	function getMemberFindPwd($db)
	{
		$query  = "SELECT * FROM ".TBL_MEMBER_MGR." ";
		$query .= "WHERE M_NO IS NOT NULL			";

		if ($this->getM_PASS_ID()){
			$query .= " AND M_ID='".$this->getM_PASS_ID()."' ";
		}

		if ($this->getM_F_PASS_NAME()){
			$query .= " AND M_F_NAME='".$this->getM_F_PASS_NAME()."' ";
		}

		if ($this->getM_L_PASS_NAME()){
			$query .= " AND M_L_NAME='".$this->getM_L_PASS_NAME()."' ";
		}

		$query .= "AND M_MAIL='".$this->getM_PASS_MAIL1()."@".$this->getM_PASS_MAIL2()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";

		return $db->getSelect($query);
	}

	function getMemberFindPwdSms($db)
	{
		$query  = "SELECT * FROM ".TBL_MEMBER_MGR." WHERE M_ID='".$this->getM_PASS_ID()."' ";
		$query .= "AND M_F_NAME='".$this->getM_PASS_NAME()."' ";
		$query .= "AND M_HP='".$this->getM_PASS_HP1()."-".$this->getM_PASS_HP2()."-".$this->getM_PASS_HP3()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";

		return $db->getSelect($query);
	}

	function getMemberVisitUpdate($db)
	{
		$query = "UPDATE MEMBER_MGR SET M_VISIT_CNT = IFNULL(M_VISIT_CNT,0) + 1 ,M_LOGIN_DT = NOW() WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberFaceBookUpdate($db)
	{
		$query  = "UPDATE ".TBL_MEMBER_MGR." SET M_FACEBOOK_ID = '".$this->getM_FACEBOOK_ID()."' ";
		$query .= ",M_FACEBOOK_TOKEN = '".$this->getM_FACEBOOK_TOKEN()."'	";
		$query .= "WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}


	function getMemberRecNo($db)
	{
		$query  = "SELECT M_NO FROM ".TBL_MEMBER_MGR."	";
		$query .= " WHERE M_NO IS NOT NULL				";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";

		if ($this->getM_ID()){
			$query .= "AND M_ID = '".mysql_real_escape_string($this->getM_ID())."'	";
		}

		if ($this->getM_MAIL()){
			$query .= "AND M_MAIL = '".mysql_real_escape_string($this->getM_MAIL())."'	";
		}

		return $db->getCount($query);
	}

	function getMemberRecNoUpdate($db)
	{
		$query = "UPDATE MEMBER_MGR SET M_REC_ID = ".$this->getM_REC_ID()." WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberAddrDelete($db)
	{
		$query = "DELETE FROM ".TBL_MEMBER_ADDR." WHERE MA_NO = ".$this->getMA_NO();

		return $db->getExecSql($query);
	}

	function getMemberBuyUpdate($db)
	{
		$query = "CALL SP_MEMBER_MGR_BUY_U (?);";

		$param[]  = $this->getM_NO();

		return $db->executeBindingQuery($query,$param,true);
	}

	function getMemberTmIdUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_TM_ID = '".$this->getM_TM_ID()."' WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberTmIdDupCnt($db)
	{
		$query = "SELECT COUNT(*) FROM ".TBL_MEMBER_MGR." WHERE M_TM_ID = '".$this->getM_TM_ID()."'";
		$query .= "	AND IF(M_OUT = '' , 'N', IFNULL(M_OUT,'N')) = 'N'	";
		return $db->getCount($query);
	}

	function getMemberLngUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_LNG = '".$this->getM_LNG()."' WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberIdUpdate($db)
	{
		$query = "UPDATE ".TBL_MEMBER_MGR." SET M_ID = '".$this->getM_ID()."' WHERE M_NO = ".$this->getM_NO();
		return $db->getExecSql($query);
	}

	function getMemberProdLikeList($db,$op,$param){

		$query  = "SELECT									";
		$query .= "     SUBSTRING(B.P_CATE,1,3) CATE_CODE	";
		$query .= "    ,C.C_LEVEL CATE_LEVEL				";
		$query .= "    ,D.CL_NAME CATE_NAME					";
		$query .= "    ,C.C_ORDER CATE_ORDER				";
		$query .= "FROM ".TBL_MEMBER_PROD_LIKE." A			";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B				";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "JOIN ".TBL_CATE_MGR." C					";
		$query .= "ON SUBSTRING(B.P_CATE,1,3) = C.C_CODE	";
		$query .= "JOIN ".TBL_CATE_LNG." D					";
		$query .= "ON C.C_CODE = D.C_CODE					";
		$query .= "AND D.CL_LNG = '".$param['CATE_LNG']."'	";
		$query .= "WHERE A.M_NO = ".$param['M_NO'];
		$query .= "	AND B.P_WEB_VIEW = 'Y'					";
		$query .= "											";
		$query .= "UNION									";
		$query .= "											";
		$query .= "SELECT									";
		$query .= "     SUBSTRING(B.P_CATE,1,6) CATE_CODE	";
		$query .= "    ,C.C_LEVEL CATE_LEVEL				";
		$query .= "    ,D.CL_NAME CATE_NAME					";
		$query .= "    ,C.C_ORDER CATE_ORDER				";
		$query .= "FROM ".TBL_MEMBER_PROD_LIKE." A			";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B				";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "JOIN ".TBL_CATE_MGR." C					";
		$query .= "ON SUBSTRING(B.P_CATE,1,6) = C.C_CODE	";
		$query .= "JOIN ".TBL_CATE_LNG." D					";
		$query .= "ON C.C_CODE = D.C_CODE					";
		$query .= "AND D.CL_LNG = '".$param['CATE_LNG']."'	";
		$query .= "WHERE A.M_NO = ".$param['M_NO'];
		$query .= "	AND B.P_WEB_VIEW = 'Y'					";
		$query .= "											";
		$query .= "UNION									";
		$query .= "											";
		$query .= "SELECT									";
		$query .= "     SUBSTRING(B.P_CATE,1,9) CATE_CODE	";
		$query .= "    ,C.C_LEVEL CATE_LEVEL				";
		$query .= "    ,D.CL_NAME CATE_NAME					";
		$query .= "    ,C.C_ORDER CATE_ORDER				";
		$query .= "FROM ".TBL_MEMBER_PROD_LIKE." A			";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B				";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "JOIN ".TBL_CATE_MGR." C					";
		$query .= "ON SUBSTRING(B.P_CATE,1,9) = C.C_CODE	";
		$query .= "JOIN ".TBL_CATE_LNG." D					";
		$query .= "ON C.C_CODE = D.C_CODE					";
		$query .= "AND D.CL_LNG = '".$param['CATE_LNG']."'	";
		$query .= "WHERE A.M_NO = ".$param['M_NO'];
		$query .= "	AND B.P_WEB_VIEW = 'Y'					";
		$query .= "											";
		$query .= "UNION									";
		$query .= "											";
		$query .= "SELECT									";
		$query .= "     B.P_CATE CATE_CODE					";
		$query .= "    ,C.C_LEVEL CATE_LEVEL				";
		$query .= "    ,D.CL_NAME CATE_NAME					";
		$query .= "    ,C.C_ORDER CATE_ORDER				";
		$query .= "FROM ".TBL_MEMBER_PROD_LIKE." A			";
		$query .= "JOIN ".TBL_PRODUCT_MGR." B				";
		$query .= "ON A.P_CODE = B.P_CODE					";
		$query .= "JOIN ".TBL_CATE_MGR." C					";
		$query .= "ON B.P_CATE = C.C_CODE					";
		$query .= "JOIN ".TBL_CATE_LNG." D					";
		$query .= "ON C.C_CODE = D.C_CODE					";
		$query .= "AND D.CL_LNG = '".$param['CATE_LNG']."'	";
		$query .= "WHERE A.M_NO = ".$param['M_NO'];
		$query .= "	AND B.P_WEB_VIEW = 'Y'					";
		$query .= "GROUP BY CATE_CODE						";
		$query .= "ORDER BY CATE_CODE ASC,CATE_ORDER ASC	";

		return $db->getArrayTotal($query);
	}

	/********************************** variable **********************************/
	function setG_CODE($G_CODE){ $this->G_CODE = $G_CODE; }
	function getG_CODE(){ return $this->G_CODE; }

	function setG_NAME($G_NAME){ $this->G_NAME = $G_NAME; }
	function getG_NAME(){ return $this->G_NAME; }

	function setG_SHOW($G_SHOW){ $this->G_SHOW = $G_SHOW; }
	function getG_SHOW(){ return $this->G_SHOW; }

	function setG_ICON($G_ICON){ $this->G_ICON = $G_ICON; }
	function getG_ICON(){ return $this->G_ICON; }

	function setG_LEVEL($G_LEVEL){ $this->G_LEVEL = $G_LEVEL; }
	function getG_LEVEL(){ return $this->G_LEVEL; }

	function setG_PRICE_MIN($G_PRICE_MIN){ $this->G_PRICE_MIN = $G_PRICE_MIN; }
	function getG_PRICE_MIN(){ return $this->G_PRICE_MIN; }

	function setG_PRICE_MAX($G_PRICE_MAX){ $this->G_PRICE_MAX = $G_PRICE_MAX; }
	function getG_PRICE_MAX(){ return $this->G_PRICE_MAX; }

	function setG_BUY_CNT($G_BUY_CNT){ $this->G_BUY_CNT = $G_BUY_CNT; }
	function getG_BUY_CNT(){ return $this->G_BUY_CNT; }

	function setG_PRODUCT_CNT($G_PRODUCT_CNT){ $this->G_PRODUCT_CNT = $G_PRODUCT_CNT; }
	function getG_PRODUCT_CNT(){ return $this->G_PRODUCT_CNT; }

	function setG_DISCOUNT_ST($G_DISCOUNT_ST){ $this->G_DISCOUNT_ST = $G_DISCOUNT_ST; }
	function getG_DISCOUNT_ST(){ return $this->G_DISCOUNT_ST; }

	function setG_DISCOUNT_PRICE($G_DISCOUNT_PRICE){ $this->G_DISCOUNT_PRICE = $G_DISCOUNT_PRICE; }
	function getG_DISCOUNT_PRICE(){ return $this->G_DISCOUNT_PRICE; }

	function setG_DISCOUNT_RATE($G_DISCOUNT_RATE){ $this->G_DISCOUNT_RATE = $G_DISCOUNT_RATE; }
	function getG_DISCOUNT_RATE(){ return $this->G_DISCOUNT_RATE; }

	function setG_DISCOUNT_UNIT($G_DISCOUNT_UNIT){ $this->G_DISCOUNT_UNIT = $G_DISCOUNT_UNIT; }
	function getG_DISCOUNT_UNIT(){ return $this->G_DISCOUNT_UNIT; }

	function setG_POINT_ST($G_POINT_ST){ $this->G_POINT_ST = $G_POINT_ST; }
	function getG_POINT_ST(){ return $this->G_POINT_ST; }

	function setG_POINT_PRICE($G_POINT_PRICE){ $this->G_POINT_PRICE = $G_POINT_PRICE; }
	function getG_POINT_PRICE(){ return $this->G_POINT_PRICE; }

	function setG_POINT_RATE($G_POINT_RATE){ $this->G_POINT_RATE = $G_POINT_RATE; }
	function getG_POINT_RATE(){ return $this->G_POINT_RATE; }

	function setG_POINT_UNIT($G_POINT_UNIT){ $this->G_POINT_UNIT = $G_POINT_UNIT; }
	function getG_POINT_UNIT(){ return $this->G_POINT_UNIT; }

	function setG_REG_DT($G_REG_DT){ $this->G_REG_DT = $G_REG_DT; }
	function getG_REG_DT(){ return $this->G_REG_DT; }

	function setG_REG_NO($G_REG_NO){ $this->G_REG_NO = $G_REG_NO; }
	function getG_REG_NO(){ return $this->G_REG_NO; }

	function setG_MOD_DT($G_MOD_DT){ $this->G_MOD_DT = $G_MOD_DT; }
	function getG_MOD_DT(){ return $this->G_MOD_DT; }

	function setG_MOD_NO($G_MOD_NO){ $this->G_MOD_NO = $G_MOD_NO; }
	function getG_MOD_NO(){ return $this->G_MOD_NO; }

	/*--------------------------------------------------------------*/
	function setJ_CERITY($J_CERITY){ $this->J_CERITY = $J_CERITY; }
	function getJ_CERITY(){ return $this->J_CERITY; }

	function setJ_RE_DAY($J_RE_DAY){ $this->J_RE_DAY = $J_RE_DAY; }
	function getJ_RE_DAY(){ return $this->J_RE_DAY; }

	function setJ_NO_ID($J_NO_ID){ $this->J_NO_ID = $J_NO_ID; }
	function getJ_NO_ID(){ return $this->J_NO_ID; }

	function setJ_POINT($J_POINT){ $this->J_POINT = $J_POINT; }
	function getJ_POINT(){ return $this->J_POINT; }

	function setJ_COUPON($J_COUPON){ $this->J_COUPON = $J_COUPON; }
	function getJ_COUPON(){ return $this->J_COUPON; }

	function setJ_GROUP($J_GROUP){ $this->J_GROUP = $J_GROUP; }
	function getJ_GROUP(){ return $this->J_GROUP; }

	function setJ_REC_POINT1($J_REC_POINT1){ $this->J_REC_POINT1 = $J_REC_POINT1; }
	function getJ_REC_POINT1(){ return $this->J_REC_POINT1; }

	function setJ_REC_POINT2($J_REC_POINT2){ $this->J_REC_POINT2 = $J_REC_POINT2; }
	function getJ_REC_POINT2(){ return $this->J_REC_POINT2; }

	function setJ_JUMIN($J_JUMIN){ $this->J_JUMIN = $J_JUMIN; }
	function getJ_JUMIN(){ return $this->J_JUMIN; }

	function setJ_IPIN($J_IPIN){ $this->J_IPIN = $J_IPIN; }
	function getJ_IPIN(){ return $this->J_IPIN; }

	function setJ_GROUP_VIEW($J_GROUP_VIEW){ $this->J_GROUP_VIEW = $J_GROUP_VIEW; }
	function getJ_GROUP_VIEW(){ return $this->J_GROUP_VIEW; }

	function setJ_PHONE($J_PHONE){ $this->J_PHONE = $J_PHONE; }
	function getJ_PHONE(){ return $this->J_PHONE; }

	function setJ_MOD_NO($J_MOD_NO){ $this->J_MOD_NO = $J_MOD_NO; }
	function getJ_MOD_NO(){ return $this->J_MOD_NO; }

	/*--------------------------------------------------------------*/
	function setM_NO($M_NO){ $this->M_NO = $M_NO; }
	function getM_NO(){ return $this->M_NO; }

	function setM_ID($M_ID){ $this->M_ID = $M_ID; }
	function getM_ID(){ return $this->M_ID; }

	function setM_PASS($M_PASS){ $this->M_PASS = $M_PASS; }
	function getM_PASS(){ return $this->M_PASS; }

	function setM_F_NAME($M_F_NAME){ $this->M_F_NAME = $M_F_NAME; }
	function getM_F_NAME(){ return $this->M_F_NAME; }

	function setM_L_NAME($M_L_NAME){ $this->M_L_NAME = $M_L_NAME; }
	function getM_L_NAME(){ return $this->M_L_NAME; }

	function setM_NICK_NAME($M_NICK_NAME){ $this->M_NICK_NAME = $M_NICK_NAME; }
	function getM_NICK_NAME(){ return $this->M_NICK_NAME; }

	function setM_BIRTH($M_BIRTH){ $this->M_BIRTH = $M_BIRTH; }
	function getM_BIRTH(){ return $this->M_BIRTH; }

	function setM_BIRTH_CAL($M_BIRTH_CAL){ $this->M_BIRTH_CAL = $M_BIRTH_CAL; }
	function getM_BIRTH_CAL(){ return $this->M_BIRTH_CAL; }

	function setM_SEX($M_SEX){ $this->M_SEX = $M_SEX; }
	function getM_SEX(){ return $this->M_SEX; }

	function setM_MAIL($M_MAIL){ $this->M_MAIL = $M_MAIL; }
	function getM_MAIL(){ return $this->M_MAIL; }

	function setM_PHONE($M_PHONE){ $this->M_PHONE = $M_PHONE; }
	function getM_PHONE(){ return $this->M_PHONE; }

	function setM_FAX($M_FAX){ $this->M_FAX = $M_FAX; }
	function getM_FAX(){ return $this->M_FAX; }

	function setM_HP($M_HP){ $this->M_HP = $M_HP; }
	function getM_HP(){ return $this->M_HP; }

	function setM_ZIP($M_ZIP){ $this->M_ZIP = $M_ZIP; }
	function getM_ZIP(){ return $this->M_ZIP; }

	function setM_COUNTRY($M_COUNTRY){ $this->M_COUNTRY = $M_COUNTRY; }
	function getM_COUNTRY(){ return $this->M_COUNTRY; }

	function setM_ADDR($M_ADDR){ $this->M_ADDR = $M_ADDR; }
	function getM_ADDR(){ return $this->M_ADDR; }

	function setM_ADDR2($M_ADDR2){ $this->M_ADDR2 = $M_ADDR2; }
	function getM_ADDR2(){ return $this->M_ADDR2; }

	function setM_CITY($M_CITY){ $this->M_CITY = $M_CITY; }
	function getM_CITY(){ return $this->M_CITY; }

	function setM_STATE($M_STATE){ $this->M_STATE = $M_STATE; }
	function getM_STATE(){ return $this->M_STATE; }

	function setM_SMSYN($M_SMSYN){ $this->M_SMSYN = $M_SMSYN; }
	function getM_SMSYN(){ return $this->M_SMSYN; }

	function setM_MAILYN($M_MAILYN){ $this->M_MAILYN = $M_MAILYN; }
	function getM_MAILYN(){ return $this->M_MAILYN; }

	function setM_TEXT($M_TEXT){ $this->M_TEXT = $M_TEXT; }
	function getM_TEXT(){ return $this->M_TEXT; }

	function setM_REC_ID($M_REC_ID){ $this->M_REC_ID = $M_REC_ID; }
	function getM_REC_ID(){ return $this->M_REC_ID; }

	function setM_GROUP($M_GROUP){ $this->M_GROUP = $M_GROUP; }
	function getM_GROUP(){ return $this->M_GROUP; }

	function setM_AUTH($M_AUTH){ $this->M_AUTH = $M_AUTH; }
	function getM_AUTH(){ return $this->M_AUTH; }

	function setM_POINT($M_POINT){ $this->M_POINT = $M_POINT; }
	function getM_POINT(){ return $this->M_POINT; }

	function setM_BUY_PRICE($M_BUY_PRICE){ $this->M_BUY_PRICE = $M_BUY_PRICE; }
	function getM_BUY_PRICE(){ return $this->M_BUY_PRICE; }

	function setM_BUY_CNT($M_BUY_CNT){ $this->M_BUY_CNT = $M_BUY_CNT; }
	function getM_BUY_CNT(){ return $this->M_BUY_CNT; }

	function setM_VISIT_CNT($M_VISIT_CNT){ $this->M_VISIT_CNT = $M_VISIT_CNT; }
	function getM_VISIT_CNT(){ return $this->M_VISIT_CNT; }

	function setM_OUT($M_OUT){ $this->M_OUT = $M_OUT; }
	function getM_OUT(){ return $this->M_OUT; }

	function setM_OUT_DT($M_OUT_DT){ $this->M_OUT_DT = $M_OUT_DT; }
	function getM_OUT_DT(){ return $this->M_OUT_DT; }

	function setM_OUT_TXT($M_OUT_TXT){ $this->M_OUT_TXT = $M_OUT_TXT; }
	function getM_OUT_TXT(){ return $this->M_OUT_TXT; }

	function setM_FACEBOOK_ID($M_FACEBOOK_ID){ $this->M_FACEBOOK_ID = $M_FACEBOOK_ID; }
	function getM_FACEBOOK_ID(){ return $this->M_FACEBOOK_ID; }

	function setM_FACEBOOK_TOKEN($M_FACEBOOK_TOKEN){ $this->M_FACEBOOK_TOKEN = $M_FACEBOOK_TOKEN; }
	function getM_FACEBOOK_TOKEN(){ return $this->M_FACEBOOK_TOKEN; }

	function setM_TM_ID($M_TM_ID){ $this->M_TM_ID = $M_TM_ID; }
	function getM_TM_ID(){ return $this->M_TM_ID; }

	function setM_LNG($M_LNG){ $this->M_LNG = $M_LNG; }
	function getM_LNG(){ return $this->M_LNG; }

	function setM_REG_DT($M_REG_DT){ $this->M_REG_DT = $M_REG_DT; }
	function getM_REG_DT(){ return $this->M_REG_DT; }

	function setM_REG_NO($M_REG_NO){ $this->M_REG_NO = $M_REG_NO; }
	function getM_REG_NO(){ return $this->M_REG_NO; }

	function setM_MOD_DT($M_MOD_DT){ $this->M_MOD_DT = $M_MOD_DT; }
	function getM_MOD_DT(){ return $this->M_MOD_DT; }

	function setM_MOD_NO($M_MOD_NO){ $this->M_MOD_NO = $M_MOD_NO; }
	function getM_MOD_NO(){ return $this->M_MOD_NO; }

	/* SearchID & SearchPWD */
	function setM_ID_NAME($M_ID_NAME){ $this->M_ID_NAME = $M_ID_NAME; }
	function getM_ID_NAME(){ return $this->M_ID_NAME; }

	function setM_L_ID_NAME($M_L_ID_NAME){ $this->M_L_ID_NAME = $M_L_ID_NAME; }
	function getM_L_ID_NAME(){ return $this->M_L_ID_NAME; }

	function setM_F_ID_NAME($M_F_ID_NAME){ $this->M_F_ID_NAME = $M_F_ID_NAME; }
	function getM_F_ID_NAME(){ return $this->M_F_ID_NAME; }

	function setM_ID_MAIL1($M_ID_MAIL1){ $this->M_ID_MAIL1 = $M_ID_MAIL1; }
	function getM_ID_MAIL1(){ return $this->M_ID_MAIL1; }

	function setM_ID_MAIL2($M_ID_MAIL2){ $this->M_ID_MAIL2 = $M_ID_MAIL2; }
	function getM_ID_MAIL2(){ return $this->M_ID_MAIL2; }

	function setM_PASS_ID($M_PASS_ID){ $this->M_PASS_ID = $M_PASS_ID; }
	function getM_PASS_ID(){ return $this->M_PASS_ID; }

	function setM_PASS_NAME($M_PASS_NAME){ $this->M_PASS_NAME = $M_PASS_NAME; }
	function getM_PASS_NAME(){ return $this->M_PASS_NAME; }

	function setM_F_PASS_NAME($M_F_PASS_NAME){ $this->M_F_PASS_NAME = $M_F_PASS_NAME; }
	function getM_F_PASS_NAME(){ return $this->M_F_PASS_NAME; }

	function setM_L_PASS_NAME($M_L_PASS_NAME){ $this->M_L_PASS_NAME = $M_L_PASS_NAME; }
	function getM_L_PASS_NAME(){ return $this->M_L_PASS_NAME; }

	function setM_PASS_MAIL1($M_PASS_MAIL1){ $this->M_PASS_MAIL1 = $M_PASS_MAIL1; }
	function getM_PASS_MAIL1(){ return $this->M_PASS_MAIL1; }

	function setM_PASS_MAIL2($M_PASS_MAIL2){ $this->M_PASS_MAIL2 = $M_PASS_MAIL2; }
	function getM_PASS_MAIL2(){ return $this->M_PASS_MAIL2; }

	function setM_PASS_HP1($M_PASS_HP1){ $this->M_PASS_HP1 = $M_PASS_HP1; }
	function getM_PASS_HP1(){ return $this->M_PASS_HP1; }

	function setM_PASS_HP2($M_PASS_HP2){ $this->M_PASS_HP2 = $M_PASS_HP2; }
	function getM_PASS_HP2(){ return $this->M_PASS_HP2; }

	function setM_PASS_HP3($M_PASS_HP3){ $this->M_PASS_HP3 = $M_PASS_HP3; }
	function getM_PASS_HP3(){ return $this->M_PASS_HP3; }
	/* SearchID & SearchPWD */

	/*--------------------------------------------------------------*/
	function setLimitFirst($LIMIT_FIRST){ $this->LIMIT_FIRST = $LIMIT_FIRST; }
	function getLimitFirst(){ return $this->LIMIT_FIRST; }

	function setPageLine($PAGE_LINE){ $this->PAGE_LINE = $PAGE_LINE; }
	function getPageLine(){ return $this->PAGE_LINE; }

	function setSearchField($SEARCH_FIELD){ $this->SEARCH_FIELD = $SEARCH_FIELD; }
	function getSearchField(){ return $this->SEARCH_FIELD; }

	function setSearchKey($SEARCH_KEY){ $this->SEARCH_KEY = $SEARCH_KEY; }
	function getSearchKey(){ return $this->SEARCH_KEY; }

	function setSearchOut($SEARCH_OUT){ $this->SEARCH_OUT = $SEARCH_OUT; }
	function getSearchOut(){ return $this->SEARCH_OUT; }

	function setSearchRegStartDt($SEARCH_REG_START_DT){ $this->SEARCH_REG_START_DT = $SEARCH_REG_START_DT; }
	function getSearchRegStartDt(){ return $this->SEARCH_REG_START_DT; }

	function setSearchRegEndDt($SEARCH_REG_END_DT){ $this->SEARCH_REG_END_DT = $SEARCH_REG_END_DT; }
	function getSearchRegEndDt(){ return $this->SEARCH_REG_END_DT; }

	function setSearchOutStartDt($SEARCH_OUT_START_DT){ $this->SEARCH_OUT_START_DT = $SEARCH_OUT_START_DT; }
	function getSearchOutStartDt(){ return $this->SEARCH_OUT_START_DT; }

	function setSearchOutEndDt($SEARCH_OUT_END_DT){ $this->SEARCH_OUT_END_DT = $SEARCH_OUT_END_DT; }
	function getSearchOutEndDt(){ return $this->SEARCH_OUT_END_DT; }

	function setSearchGroup($SEARCH_GROUP){ $this->SEARCH_GROUP = $SEARCH_GROUP; }
	function getSearchGroup(){ return $this->SEARCH_GROUP; }


	/**********************************  **********************************/
	function setM_WED($M_WED){ $this->M_WED = $M_WED; }
	function getM_WED(){ return $this->M_WED; }

	function setM_WED_DAY($M_WED_DAY){ $this->M_WED_DAY = $M_WED_DAY; }
	function getM_WED_DAY(){ return $this->M_WED_DAY; }

	function setM_JOB($M_JOB){ $this->M_JOB = $M_JOB; }
	function getM_JOB(){ return $this->M_JOB; }

	function setM_CHILD($M_CHILD){ $this->M_CHILD = $M_CHILD; }
	function getM_CHILD(){ return $this->M_CHILD; }

	function setM_COM_NM($M_COM_NM){ $this->M_COM_NM = $M_COM_NM; }
	function getM_COM_NM(){ return $this->M_COM_NM; }

	function setM_BUSI_NM($M_BUSI_NM){ $this->M_BUSI_NM = $M_BUSI_NM; }
	function getM_BUSI_NM(){ return $this->M_BUSI_NM; }

	function setM_BUSI_NUM($M_BUSI_NUM){ $this->M_BUSI_NUM = $M_BUSI_NUM; }
	function getM_BUSI_NUM(){ return $this->M_BUSI_NUM; }

	function setM_BUSI_UPJ($M_BUSI_UPJ){ $this->M_BUSI_UPJ = $M_BUSI_UPJ; }
	function getM_BUSI_UPJ(){ return $this->M_BUSI_UPJ; }

	function setM_BUSI_UTE($M_BUSI_UTE){ $this->M_BUSI_UTE = $M_BUSI_UTE; }
	function getM_BUSI_UTE(){ return $this->M_BUSI_UTE; }

	function setM_BUSI_ZIP($M_BUSI_ZIP){ $this->M_BUSI_ZIP = $M_BUSI_ZIP; }
	function getM_BUSI_ZIP(){ return $this->M_BUSI_ZIP; }

	function setM_BUSI_ADDR1($M_BUSI_ADDR1){ $this->M_BUSI_ADDR1 = $M_BUSI_ADDR1; }
	function getM_BUSI_ADDR1(){ return $this->M_BUSI_ADDR1; }

	function setM_BUSI_ADDR2($M_BUSI_ADDR2){ $this->M_BUSI_ADDR2 = $M_BUSI_ADDR2; }
	function getM_BUSI_ADDR2(){ return $this->M_BUSI_ADDR2; }

	function setM_CONCERN($M_CONCERN){ $this->M_CONCERN = $M_CONCERN; }
	function getM_CONCERN(){ return $this->M_CONCERN; }

	function setM_FOREIGN($M_FOREIGN){ $this->M_FOREIGN = $M_FOREIGN; }
	function getM_FOREIGN(){ return $this->M_FOREIGN; }

	function setM_FOREIGN_NUM($M_FOREIGN_NUM){ $this->M_FOREIGN_NUM = $M_FOREIGN_NUM; }
	function getM_FOREIGN_NUM(){ return $this->M_FOREIGN_NUM; }

	function setM_PASSPORT($M_PASSPORT){ $this->M_PASSPORT = $M_PASSPORT; }
	function getM_PASSPORT(){ return $this->M_PASSPORT; }

	function setM_DRIVE_NUM($M_DRIVE_NUM){ $this->M_DRIVE_NUM = $M_DRIVE_NUM; }
	function getM_DRIVE_NUM(){ return $this->M_DRIVE_NUM; }

	function setM_NATION($M_NATION){ $this->M_NATION = $M_NATION; }
	function getM_NATION(){ return $this->M_NATION; }

	function setM_PHOTO($M_PHOTO){ $this->M_PHOTO = $M_PHOTO; }
	function getM_PHOTO(){ return $this->M_PHOTO; }

	function setM_TMP1($M_TMP1){ $this->M_TMP1 = $M_TMP1; }
	function getM_TMP1(){ return $this->M_TMP1; }

	function setM_TMP2($M_TMP2){ $this->M_TMP2 = $M_TMP2; }
	function getM_TMP2(){ return $this->M_TMP2; }

	function setM_TMP3($M_TMP3){ $this->M_TMP3 = $M_TMP3; }
	function getM_TMP3(){ return $this->M_TMP3; }

	function setM_TMP4($M_TMP4){ $this->M_TMP4 = $M_TMP4; }
	function getM_TMP4(){ return $this->M_TMP4; }

	function setM_TMP5($M_TMP5){ $this->M_TMP5 = $M_TMP5; }
	function getM_TMP5(){ return $this->M_TMP5; }

	/*--------------------------------------------------------------*/
	function setPT_NO($PT_NO){ $this->PT_NO = $PT_NO; }
	function getPT_NO(){ return $this->PT_NO; }

	function setB_NO($B_NO){ $this->B_NO = $B_NO; }
	function getB_NO(){ return $this->B_NO; }

	function setO_NO($O_NO){ $this->O_NO = $O_NO; }
	function getO_NO(){ return $this->O_NO; }

	function setPT_TYPE($PT_TYPE){ $this->PT_TYPE = $PT_TYPE; }
	function getPT_TYPE(){ return $this->PT_TYPE; }

	function setPT_POINT($PT_POINT){ $this->PT_POINT = $PT_POINT; }
	function getPT_POINT(){ return $this->PT_POINT; }

	function setPT_MEMO($PT_MEMO){ $this->PT_MEMO = $PT_MEMO; }
	function getPT_MEMO(){ return $this->PT_MEMO; }

	function setPT_START_DT($PT_START_DT){ $this->PT_START_DT = $PT_START_DT; }
	function getPT_START_DT(){ return $this->PT_START_DT; }

	function setPT_END_DT($PT_END_DT){ $this->PT_END_DT = $PT_END_DT; }
	function getPT_END_DT(){ return $this->PT_END_DT; }

	function setPT_REG_IP($PT_REG_IP){ $this->PT_REG_IP = $PT_REG_IP; }
	function getPT_REG_IP(){ return $this->PT_REG_IP; }

	function setPT_ETC($PT_ETC){ $this->PT_ETC = $PT_ETC; }
	function getPT_ETC(){ return $this->PT_ETC; }

	function setPT_REG_NO($PT_REG_NO){ $this->PT_REG_NO = $PT_REG_NO; }
	function getPT_REG_NO(){ return $this->PT_REG_NO; }

	function setPT_REG_DT($PT_REG_DT){ $this->PT_REG_DT = $PT_REG_DT; }
	function getPT_REG_DT(){ return $this->PT_REG_DT; }

	function setPT_POINT_USE_YEAR($PT_POINT_USE_YEAR){ $this->PT_POINT_USE_YEAR = $PT_POINT_USE_YEAR; }
	function getPT_POINT_USE_YEAR(){ return $this->PT_POINT_USE_YEAR; }

	/*--------------------------------------------------------------*/
	function setMA_NO($MA_NO){ $this->MA_NO = $MA_NO; }
	function getMA_NO(){ return $this->MA_NO; }

	function setMA_TYPE($MA_TYPE){ $this->MA_TYPE = $MA_TYPE; }
	function getMA_TYPE(){ return $this->MA_TYPE; }

	function setMA_NAME($MA_NAME){ $this->MA_NAME = $MA_NAME; }
	function getMA_NAME(){ return $this->MA_NAME; }

	function setMA_PHONE($MA_PHONE){ $this->MA_PHONE = $MA_PHONE; }
	function getMA_PHONE(){ return $this->MA_PHONE; }

	function setMA_HP($MA_HP){ $this->MA_HP = $MA_HP; }
	function getMA_HP(){ return $this->MA_HP; }

	function setMA_ZIP($MA_ZIP){ $this->MA_ZIP = $MA_ZIP; }
	function getMA_ZIP(){ return $this->MA_ZIP; }

	function setMA_COUNTRY($MA_COUNTRY){ $this->MA_COUNTRY = $MA_COUNTRY; }
	function getMA_COUNTRY(){ return $this->MA_COUNTRY; }

	function setMA_ADDR1($MA_ADDR1){ $this->MA_ADDR1 = $MA_ADDR1; }
	function getMA_ADDR1(){ return $this->MA_ADDR1; }

	function setMA_ADDR2($MA_ADDR2){ $this->MA_ADDR2 = $MA_ADDR2; }
	function getMA_ADDR2(){ return $this->MA_ADDR2; }

	function setMA_CITY($MA_CITY){ $this->MA_CITY = $MA_CITY; }
	function getMA_CITY(){ return $this->MA_CITY; }

	function setMA_STATE($MA_STATE){ $this->MA_STATE = $MA_STATE; }
	function getMA_STATE(){ return $this->MA_STATE; }

	function setMA_REG_DT($MA_REG_DT){ $this->MA_REG_DT = $MA_REG_DT; }
	function getMA_REG_DT(){ return $this->MA_REG_DT; }

	/*--------------------------------------------------------------*/
	function setJI_GB($JI_GB){ $this->JI_GB = $JI_GB; }
	function getJI_GB(){ return $this->JI_GB; }

	/********************************** variable **********************************/


}
?>