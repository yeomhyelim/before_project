<?
#/*====================================================================*/# 
#|화일명	: 관리자 메뉴관리											|# 
#|작성자	: 박영미(ivetmi@naver.com)									|# 
#|작성일	: 2012-03-12												|# 
#|작성내용	: 관리자 메뉴권한 등록/수정/삭제							|# 
#/*====================================================================*/# 

class AdminMenu
{
	private $query;
	private $param;

	/********************************** 1차 List **********************************/
	function getList01($db){
		$query  = "SELECT								";
		$query .= "      A.*							";
		$query .= "		,B.MN_NO AM_MN_NO				";
		$query .= "		,B.AM_L							";
		$query .= "		,B.AM_W							";
		$query .= "		,B.AM_M							";
		$query .= "		,B.AM_D							";
		$query .= "		,B.AM_E							";
		$query .= "		,B.AM_C							";
		$query .= "		,B.AM_S							";
		$query .= "		,B.AM_P							";
		$query .= "		,B.AM_U							";
		$query .= "		,B.AM_E1						";
		$query .= "		,B.AM_E2						";
		$query .= "		,B.AM_E3						";
		$query .= "		,B.AM_E4						";
		$query .= "		,B.AM_E5						";
		$query .= "FROM ".TBL_MENU_MGR." A				";
		$query .= "LEFT OUTER JOIN ".TBL_ADMIN_MENU." B	";
		$query .= "ON A.MN_NO = B.MN_NO					";
		$query .= "AND B.M_NO = ".mysql_real_escape_string($this->getM_NO())."	";
		$query .= "WHERE A.MN_LEVEL = 1					";
		$query .= "AND A.MN_USE = 'Y'					";
		$query .= "ORDER BY A.MN_CODE ASC				";
		return $db->getExecSql($query);
	}

	/********************************** 2차 List **********************************/
	function getList02($db){
		$query  = "SELECT									";
		$query .= "      A.*								";
		$query .= "		,B.MN_NO AM_MN_NO					";
		$query .= "		,B.AM_L							";
		$query .= "		,B.AM_W							";
		$query .= "		,B.AM_M							";
		$query .= "		,B.AM_D							";
		$query .= "		,B.AM_E							";
		$query .= "		,B.AM_C							";
		$query .= "		,B.AM_S							";
		$query .= "		,B.AM_P							";
		$query .= "		,B.AM_U							";
		$query .= "		,B.AM_E1						";
		$query .= "		,B.AM_E2						";
		$query .= "		,B.AM_E3						";
		$query .= "		,B.AM_E4						";
		$query .= "		,B.AM_E5						";
		$query .= "FROM ".TBL_MENU_MGR." A					";
		$query .= "LEFT OUTER JOIN ".TBL_ADMIN_MENU." B		";
		$query .= "ON A.MN_NO = B.MN_NO						";
		$query .= "AND B.M_NO = ".mysql_real_escape_string($this->getM_NO())."		";
		$query .= "WHERE A.MN_LEVEL = 2						";
		$query .= "AND A.MN_USE = 'Y'						";
		$query .= "AND A.MN_HIGH_01 = '".mysql_real_escape_string($this->getMN_HIGH_01())."'";
		$query .= "ORDER BY A.MN_CODE ASC					";
		
		return $db->getResult($query);
	}

	/********************************** 3차 List **********************************/
	function getList03($db){
		$query  = "SELECT									";
		$query .= "      A.*								";
		$query .= "		,B.MN_NO AM_MN_NO					";
		$query .= "		,B.AM_L							";
		$query .= "		,B.AM_W							";
		$query .= "		,B.AM_M							";
		$query .= "		,B.AM_D							";
		$query .= "		,B.AM_E							";
		$query .= "		,B.AM_C							";
		$query .= "		,B.AM_S							";
		$query .= "		,B.AM_P							";
		$query .= "		,B.AM_U							";
		$query .= "		,B.AM_E1						";
		$query .= "		,B.AM_E2						";
		$query .= "		,B.AM_E3						";
		$query .= "		,B.AM_E4						";
		$query .= "		,B.AM_E5						";
		$query .= "FROM ".TBL_MENU_MGR." A					";
		$query .= "LEFT OUTER JOIN ".TBL_ADMIN_MENU." B		";
		$query .= "ON A.MN_NO = B.MN_NO						";
		$query .= "AND B.M_NO = ".mysql_real_escape_string($this->getM_NO())."		";
		$query .= "WHERE A.MN_LEVEL = 3						";
		$query .= "AND A.MN_USE = 'Y'						";
		$query .= "AND A.MN_HIGH_01 = '".mysql_real_escape_string($this->getMN_HIGH_01())."'";
		$query .= "AND A.MN_HIGH_02 = '".mysql_real_escape_string($this->getMN_HIGH_02())."'";
		$query .= "ORDER BY A.MN_CODE ASC					";
		
		return $db->getResult($query);
	}

	/********************************** 회원별 권한 메뉴 리스트 **********************************/
	function getMemAuthList($db){
		$query  = "SELECT								";
		$query .= "		 B.MN_NO					    ";
		$query .= "		,B.AM_L							";
		$query .= "		,B.AM_W							";
		$query .= "		,B.AM_M							";
		$query .= "		,B.AM_D							";
		$query .= "		,B.AM_E							";
		$query .= "		,B.AM_C							";
		$query .= "		,B.AM_S							";
		$query .= "		,B.AM_P							";
		$query .= "		,B.AM_U							";
		$query .= "		,B.AM_E1						";
		$query .= "		,B.AM_E2						";
		$query .= "		,B.AM_E3						";
		$query .= "		,B.AM_E4						";
		$query .= "		,B.AM_E5						";
		$query .= "FROM ".TBL_ADMIN_MENU." B			";
		$query .= "WHERE B.M_NO = ".mysql_real_escape_string($this->getM_NO())."		";
		$query .= "	AND B.AM_TYPE	= '".$this->getAM_TYPE()."'							";
		$query .= "ORDER BY B.M_NO ASC					";
		return $db->getResult($query);
	}

	/********************************** Insert Update **********************************/
	function getInsertUpdate($db)
	{
		$query = "CALL SP_ADMIN_MENU_IU (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

		$param[]  = $this->getAM_TYPE();
		$param[]  = $this->getMN_NO();
		$param[]  = $this->getMN_CODE();
		$param[]  = $this->getMN_HIGH_01();
		$param[]  = $this->getMN_HIGH_02();
		$param[]  = $this->getM_NO();
		$param[]  = $this->getAM_L();
		$param[]  = $this->getAM_W();
		$param[]  = $this->getAM_M();
		$param[]  = $this->getAM_D();
		$param[]  = $this->getAM_E();
		$param[]  = $this->getAM_C();
		$param[]  = $this->getAM_S();
		$param[]  = $this->getAM_U();
		$param[]  = $this->getAM_P();
		$param[]  = $this->getAM_E1();
		$param[]  = $this->getAM_E2();
		$param[]  = $this->getAM_E3();
		$param[]  = $this->getAM_E4();
		$param[]  = $this->getAM_E5();

		return $db->executeBindingQuery($query,$param,true);
	}

	/********************************** Insert **********************************/
	function getDelete($db)
	{
		$query  = "DELETE FROM ".TBL_ADMIN_MENU;
		$query .= " WHERE M_NO = ".$this->getM_NO();
		$query .= "		AND AM_TYPE = '".$this->getAM_TYPE()."'	";
		if ($this->getAM_MN_NO())
			$query .= "	AND MN_NO NOT IN (".$this->getAM_MN_NO().")";
		
		return $db->getExecSql($query);
	}
	
	function getCommunityAdmList($db)
	{
		$query  = "SELECT                    ";
		$query .= "     2 MN_LEVEL           ";
		$query .= "    ,'1' MN_NO            ";
		$query .= "    ,'관리' MN_NAME_KR     ";
		$query .= "    ,'관리' MN_NAME_US     ";
		$query .= "    ,'관리' MN_NAME_CN     ";
		$query .= "    ,'관리' MN_NAME_JP     ";
		$query .= "    ,'관리' MN_NAME_ID     ";
		$query .= "    ,'관리' MN_NAME_FR     ";
		$query .= "    ,'관리' MN_NAME_RU     ";
		$query .= "    ,'' MN_AUTH_L         ";
		$query .= "    ,'Y' MN_AUTH_W        ";
		$query .= "    ,'Y' MN_AUTH_M        ";
		$query .= "    ,'Y' MN_AUTH_D        ";
		$query .= "    ,'' MN_AUTH_E         ";
		$query .= "    ,'' MN_AUTH_C         ";
		$query .= "    ,'' MN_AUTH_S         ";
		$query .= "    ,'' MN_AUTH_U         ";
		$query .= "    ,'' MN_AUTH_P         ";
		$query .= "    ,'' MN_AUTH_E1        ";
		$query .= "    ,'' MN_AUTH_E2        ";
		$query .= "    ,'' MN_AUTH_E3        ";
		$query .= "    ,'' MN_AUTH_E4        ";
		$query .= "    ,'' MN_AUTH_E5        ";
		$query .= "    ,'006' MN_HIGH_01     ";
		$query .= "    ,'' MN_HIGH_02        ";
		$query .= "    ,'./?menuType=community&mode=boardList' MN_URL ";
		$query .= "                          ";
		$query .= "UNION                     ";
		$query .= "                          ";
		$query .= "SELECT                    ";
		$query .= "     3 MN_LEVEL           ";
		$query .= "    ,'1' MN_NO            ";
		$query .= "    ,'게시판관리' MN_NAME_KR   ";
		$query .= "    ,'게시판관리' MN_NAME_US   ";
		$query .= "    ,'게시판관리' MN_NAME_CN   ";
		$query .= "    ,'게시판관리' MN_NAME_JP   ";
		$query .= "    ,'게시판관리' MN_NAME_ID   ";
		$query .= "    ,'게시판관리' MN_NAME_FR   ";
		$query .= "    ,'게시판관리' MN_NAME_RU   ";
		$query .= "    ,'' MN_AUTH_L         ";
		$query .= "    ,'Y' MN_AUTH_W        ";
		$query .= "    ,'Y' MN_AUTH_M        ";
		$query .= "    ,'Y' MN_AUTH_D        ";
		$query .= "    ,'' MN_AUTH_E         ";
		$query .= "    ,'' MN_AUTH_C         ";
		$query .= "    ,'' MN_AUTH_S         ";
		$query .= "    ,'' MN_AUTH_U         ";
		$query .= "    ,'' MN_AUTH_P         ";
		$query .= "    ,'' MN_AUTH_E1        ";
		$query .= "    ,'' MN_AUTH_E2        ";
		$query .= "    ,'' MN_AUTH_E3        ";
		$query .= "    ,'' MN_AUTH_E4        ";
		$query .= "    ,'' MN_AUTH_E5        ";
		$query .= "    ,'006' MN_HIGH_01     ";
		$query .= "    ,'001' MN_HIGH_02     ";
		$query .= "    ,'./?menuType=community&mode=boardList' MN_URL ";
		$query .= "                          ";
		$query .= "UNION                     ";
		$query .= "                          ";
		$query .= "SELECT                    ";
		$query .= "     3 MN_LEVEL           ";
		$query .= "    ,'2' MN_NO            ";
		$query .= "    ,'정지된 게시판' MN_NAME_KR";
		$query .= "    ,'정지된 게시판' MN_NAME_US";
		$query .= "    ,'정지된 게시판' MN_NAME_CN";
		$query .= "    ,'정지된 게시판' MN_NAME_JP";
		$query .= "    ,'정지된 게시판' MN_NAME_ID";
		$query .= "    ,'정지된 게시판' MN_NAME_FR";
		$query .= "    ,'정지된 게시판' MN_NAME_RU";
		$query .= "    ,'' MN_AUTH_L         ";
		$query .= "    ,'' MN_AUTH_W         ";
		$query .= "    ,'Y' MN_AUTH_M        ";
		$query .= "    ,'Y' MN_AUTH_D        ";
		$query .= "    ,'' MN_AUTH_E         ";
		$query .= "    ,'' MN_AUTH_C         ";
		$query .= "    ,'' MN_AUTH_S         ";
		$query .= "    ,'' MN_AUTH_U         ";
		$query .= "    ,'' MN_AUTH_P         ";
		$query .= "    ,'' MN_AUTH_E1        ";
		$query .= "    ,'' MN_AUTH_E2        ";
		$query .= "    ,'' MN_AUTH_E3        ";
		$query .= "    ,'' MN_AUTH_E4        ";
		$query .= "    ,'' MN_AUTH_E5        ";
		$query .= "    ,'006' MN_HIGH_01     ";
		$query .= "    ,'001' MN_HIGH_02     ";
		$query .= "    ,'./?menuType=community&mode=boardNonList&b_use=N' MN_URL ";
		$query .= "UNION                     ";
		$query .= "                          ";
		$query .= "SELECT                    ";
		$query .= "     3 MN_LEVEL           ";
		$query .= "    ,'3' MN_NO            ";
		$query .= "    ,'그룹관리' MN_NAME_KR    ";
		$query .= "    ,'그룹관리' MN_NAME_US    ";
		$query .= "    ,'그룹관리' MN_NAME_CN    ";
		$query .= "    ,'그룹관리' MN_NAME_JP    ";
		$query .= "    ,'그룹관리' MN_NAME_ID    ";
		$query .= "    ,'그룹관리' MN_NAME_FR    ";
		$query .= "    ,'그룹관리' MN_NAME_RU    ";
		$query .= "    ,'' MN_AUTH_L         ";
		$query .= "    ,'Y' MN_AUTH_W        ";
		$query .= "    ,'Y' MN_AUTH_M        ";
		$query .= "    ,'Y' MN_AUTH_D        ";
		$query .= "    ,'' MN_AUTH_E         ";
		$query .= "    ,'' MN_AUTH_C         ";
		$query .= "    ,'' MN_AUTH_S         ";
		$query .= "    ,'' MN_AUTH_U         ";
		$query .= "    ,'' MN_AUTH_P         ";
		$query .= "    ,'' MN_AUTH_E1        ";
		$query .= "    ,'' MN_AUTH_E2        ";
		$query .= "    ,'' MN_AUTH_E3        ";
		$query .= "    ,'' MN_AUTH_E4        ";
		$query .= "    ,'' MN_AUTH_E5        ";
		$query .= "    ,'006' MN_HIGH_01     ";
		$query .= "    ,'001' MN_HIGH_02     ";
		$query .= "    ,'./?menuType=community&mode=groupWrite' MN_URL ";
		
		return $db->getArrayTotal($query);
	}

	function getCommunityList($db)
	{
		$query =    "SELECT                                      ";
		$query .= "     1 MN_LEVEL                             ";
		$query .= "    ,6 MN_NO                                ";
		$query .= "    ,'' MN_B_CODE                               ";
		$query .= "    ,'커뮤니티' MN_NAME_KR                      ";
		$query .= "    ,'커뮤니티' MN_NAME_US                      ";
		$query .= "    ,'커뮤니티' MN_NAME_CN                      ";
		$query .= "    ,'커뮤니티' MN_NAME_JP                      ";
		$query .= "    ,'커뮤니티' MN_NAME_ID                      ";
		$query .= "    ,'커뮤니티' MN_NAME_FR                      ";
		$query .= "    ,'커뮤니티' MN_NAME_RU                      ";
		$query .= "    ,'' MN_AUTH_L                           ";
		$query .= "    ,'Y' MN_AUTH_W                          ";
		$query .= "    ,'Y' MN_AUTH_M                          ";
		$query .= "    ,'Y' MN_AUTH_D                          ";
		$query .= "    ,'' MN_AUTH_E                           ";
		$query .= "    ,'' MN_AUTH_C                           ";
		$query .= "    ,'' MN_AUTH_S                           ";
		$query .= "    ,'' MN_AUTH_U                           ";
		$query .= "    ,'' MN_AUTH_P                           ";
		$query .= "    ,'' MN_AUTH_E1                          ";
		$query .= "    ,'' MN_AUTH_E2                          ";
		$query .= "    ,'' MN_AUTH_E3                          ";
		$query .= "    ,'' MN_AUTH_E4                          ";
		$query .= "    ,'' MN_AUTH_E5                          ";
		$query .= "    ,'' MN_HIGH_01                          ";
		$query .= "    ,'' MN_HIGH_02                          ";
		$query .= "    ,'' MN_URL                              ";
		$query .= "    ,'' MN_GROUP_NO                         ";
		$query .= "UNION                                       ";
		$query .= "                                            ";
		$query .= "SELECT                                      ";
		$query .= "     2 MN_LEVEL                             ";
		$query .= "    ,2 MN_NO                                ";
		$query .= "    ,'' MN_B_CODE                              ";
		$query .= "    ,'게시판' MN_NAME_KR                       ";
		$query .= "    ,'게시판' MN_NAME_US                       ";
		$query .= "    ,'게시판' MN_NAME_CN                       ";
		$query .= "    ,'게시판' MN_NAME_JP                       ";
		$query .= "    ,'게시판' MN_NAME_ID                       ";
		$query .= "    ,'게시판' MN_NAME_FR                       ";
		$query .= "    ,'게시판' MN_NAME_RU                       ";
		$query .= "    ,'' MN_AUTH_L                           ";
		$query .= "    ,'Y' MN_AUTH_W                          ";
		$query .= "    ,'Y' MN_AUTH_M                          ";
		$query .= "    ,'Y' MN_AUTH_D                          ";
		$query .= "    ,'' MN_AUTH_E                           ";
		$query .= "    ,'' MN_AUTH_C                           ";
		$query .= "    ,'' MN_AUTH_S                           ";
		$query .= "    ,'' MN_AUTH_U                           ";
		$query .= "    ,'' MN_AUTH_P                           ";
		$query .= "    ,'' MN_AUTH_E1                          ";
		$query .= "    ,'' MN_AUTH_E2                          ";
		$query .= "    ,'' MN_AUTH_E3                          ";
		$query .= "    ,'' MN_AUTH_E4                          ";
		$query .= "    ,'' MN_AUTH_E5                          ";
		$query .= "    ,'006' MN_HIGH_01                       ";
		$query .= "    ,'' MN_HIGH_02                          ";
		$query .= "    ,'' MN_URL							   ";
		$query .= "    ,'' MN_GROUP_NO                         ";
		$query .= "UNION                                       ";
		$query .= "                                            ";
		$query .= "SELECT                                      ";
		$query .= "    3 MN_LEVEL                              ";
		$query .= "    ,A.B_NO MN_NO                           ";
		$query .= "    ,A.B_CODE MN_B_CODE                     ";
		$query .= "    ,A.B_NAME MN_NAME_KR                    ";
		$query .= "    ,A.B_NAME MN_NAME_US                    ";
		$query .= "    ,A.B_NAME MN_NAME_CN                    ";
		$query .= "    ,A.B_NAME MN_NAME_JP                    ";
		$query .= "    ,A.B_NAME MN_NAME_ID                    ";
		$query .= "    ,A.B_NAME MN_NAME_FR                    ";
		$query .= "    ,A.B_NAME MN_NAME_RU                    ";
		$query .= "    ,'' MN_AUTH_L                           ";
		$query .= "    ,'Y' MN_AUTH_W                          ";
		$query .= "    ,'Y' MN_AUTH_M                          ";
		$query .= "    ,'Y' MN_AUTH_D                          ";
		$query .= "    ,'' MN_AUTH_E                           ";
		$query .= "    ,'' MN_AUTH_C                           ";
		$query .= "    ,'' MN_AUTH_S                           ";
		$query .= "    ,'' MN_AUTH_U                           ";
		$query .= "    ,'' MN_AUTH_P                           ";
		$query .= "    ,'Y' MN_AUTH_E1                         ";
		$query .= "    ,'Y' MN_AUTH_E2                          ";
		$query .= "    ,'' MN_AUTH_E3                          ";
		$query .= "    ,'' MN_AUTH_E4                          ";
		$query .= "    ,'' MN_AUTH_E5                          ";
		$query .= "    ,'006' MN_HIGH_01                       ";
		$query .= "    ,'002' MN_HIGH_02                       ";
		$query .= "    ,CONCAT('./?menuType=community&mode=dataList&b_code=',A.B_CODE) MN_URL ";
		$query .= "    ,A.B_BG_NO MN_GROUP_NO                  ";
		$query .= "FROM BOARD_MGR_NEW A                        ";
		$query .= "WHERE A.B_USE = 'Y'                         ";
		$query .= "ORDER BY MN_LEVEL,MN_HIGH_02 DESC,MN_NO ASC";


		$re = $db->getArrayTotal($query);
//		echo $db->query;
		return $re;
	}
	/********************************** variable **********************************/
	function setAM_NO($AM_NO){ $this->AM_NO = $AM_NO; }		
	function getAM_NO(){ return $this->AM_NO; }		

	function setAM_TYPE($AM_TYPE){ $this->AM_TYPE = $AM_TYPE; }		
	function getAM_TYPE(){ return $this->AM_TYPE; }		

	function setMN_NO($MN_NO){ $this->MN_NO = $MN_NO; }		
	function getMN_NO(){ return $this->MN_NO; }		

	function setMN_CODE($MN_CODE){ $this->MN_CODE = $MN_CODE; }		
	function getMN_CODE(){ return $this->MN_CODE; }		

	function setM_NO($M_NO){ $this->M_NO = $M_NO; }		
	function getM_NO(){ return $this->M_NO; }		

	function setAM_L($AM_L){ $this->AM_L = $AM_L; }		
	function getAM_L(){ return $this->AM_L; }		

	function setAM_W($AM_W){ $this->AM_W = $AM_W; }		
	function getAM_W(){ return $this->AM_W; }		

	function setAM_M($AM_M){ $this->AM_M = $AM_M; }		
	function getAM_M(){ return $this->AM_M; }		

	function setAM_D($AM_D){ $this->AM_D = $AM_D; }		
	function getAM_D(){ return $this->AM_D; }		

	function setAM_E($AM_E){ $this->AM_E = $AM_E; }		
	function getAM_E(){ return $this->AM_E; }	

	function setAM_C($MN_AUTH_C){ $this->MN_AUTH_C = $MN_AUTH_C; }		
	function getAM_C(){ return $this->MN_AUTH_C; }		

	function setAM_S($MN_AUTH_S){ $this->MN_AUTH_S = $MN_AUTH_S; }		
	function getAM_S(){ return $this->MN_AUTH_S; }		
	
	function setAM_P($MN_AUTH_P){ $this->MN_AUTH_P = $MN_AUTH_P; }		
	function getAM_P(){ return $this->MN_AUTH_P; }		

	function setAM_U($MN_AUTH_U){ $this->MN_AUTH_U = $MN_AUTH_U; }		
	function getAM_U(){ return $this->MN_AUTH_U; }			

	function setAM_E1($MN_AUTH_E1){ $this->MN_AUTH_E1 = $MN_AUTH_E1; }		
	function getAM_E1(){ return $this->MN_AUTH_E1; }			

	function setAM_E2($MN_AUTH_E2){ $this->MN_AUTH_E2 = $MN_AUTH_E2; }		
	function getAM_E2(){ return $this->MN_AUTH_E2; }			

	function setAM_E3($MN_AUTH_E3){ $this->MN_AUTH_E3 = $MN_AUTH_E3; }		
	function getAM_E3(){ return $this->MN_AUTH_E3; }			

	function setAM_E4($MN_AUTH_E4){ $this->MN_AUTH_E4 = $MN_AUTH_E4; }		
	function getAM_E4(){ return $this->MN_AUTH_E4; }			

	function setAM_E5($MN_AUTH_E5){ $this->MN_AUTH_E5 = $MN_AUTH_E5; }		
	function getAM_E5(){ return $this->MN_AUTH_E5; }			

	function setAM_REG_DT($AM_REG_DT){ $this->AM_REG_DT = $AM_REG_DT; }		
	function getAM_REG_DT(){ return $this->AM_REG_DT; }		

	function setAM_MN_NO($AM_MN_NO){ $this->AM_MN_NO = $AM_MN_NO; }		
	function getAM_MN_NO(){ return $this->AM_MN_NO; }

	function setMN_HIGH_01($MN_HIGH_01){ $this->MN_HIGH_01 = $MN_HIGH_01; }		
	function getMN_HIGH_01(){ return $this->MN_HIGH_01; }		

	function setMN_HIGH_02($MN_HIGH_02){ $this->MN_HIGH_02 = $MN_HIGH_02; }		
	function getMN_HIGH_02(){ return $this->MN_HIGH_02; }
	/********************************** variable **********************************/


}
?>