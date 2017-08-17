<?
	require_once MALL_CONF_MYSQL;
	require_once MALL_CONF_FILE;
	require_once MALL_COMM_LIB;
	require_once MALL_CONF_TBL;
	require_once MALL_WEB_PATH."shopAdmin/include/adminCheck.php";

	## 디버그 설정
	if($_GET['debug'])
		$_SESSION['debug'] = $_GET['debug'];

	## 2013.08.01 kim hee sung, 수동 설정 파일
	$strRequireFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	if(is_file($strRequireFile)){ require_once $strRequireFile; }

	if ($a_admin_type == "A"){
		require_once "./include/adminMenu".$S_MALL_TYPE.".inc.php";
	}

	if ($a_admin_type == "S"){
		require_once "./include/adminMenuS.inc.php";
	}

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community.menu.inc.php")):
		require_once "../conf/community.menu.inc.php";
	endif;

	$strMenuType	= $_POST["menuType"]	? $_POST["menuType"]	: $_REQUEST["menuType"];
	$strMode		= $_POST["mode"]		? $_POST["mode"]		: $_REQUEST["mode"];
	$strAct			= $_POST["act"]			? $_POST["act"]			: $_REQUEST["act"];
	$strStLng		= $_POST["lang"]		? $_POST["lang"]		: $_REQUEST["lang"];
	$strTarget		= $_POST["target"]		? $_POST["target"]		: $_REQUEST["target"];
	$strMyTarget	= $_POST["myTarget"]	? $_POST["myTarget"]	: $_REQUEST["myTarget"];
	$strLayout		= $_POST["layout"]		? $_POST["layout"]		: $_REQUEST["layout"];
	$strDev			= $_POST["dev"]			? $_POST["dev"]			: $_REQUEST["dev"];

	## 2013.11.13 kim hee sung 개발자 모드 추가
	if($strDev== "Y")		{ $_SESSION['ADMIN_DEV'] = "Y"; }
	else if($strDev== "N")	{ $_SESSION['ADMIN_DEV'] = "";  }

	## 2013.12.07 kim hee sung 레이아웃 설정
	if(!$strLayout) { $strLayout = "default"; }

	if($strMyTarget) { $strTarget = $strMyTarget; }

	$strMenuType	= IM_IsBlank($strMenuType,"main");
	$strMode		= IM_IsBlank($strMode,"list");

	##강제로 KR을 잡기때문에 주석처리 2015.05.26 kjp
	//$strStLng		= IM_IsBlank($strStLng,$S_ST_LNG);

	$db->connect();

	/* 언어 셋팅 */
	require_once MALL_CONF_LANG."/lang.admin.".strtolower($strAdmSiteLng).".inc.php";
	/* 언어 셋팅 */


	function getTopMenuArray($auth_no,$auth_lng){
		global $db;
		global $a_admin_type;

		$query =  "SELECT                                                                           ";
		$query .= "     A.MN_CODE                                                                   ";
		$query .= "    ,A.MN_NO		                                                                ";
		$query .= "FROM ".TBL_ADMIN_MENU." A                                                        ";
		$query .= "WHERE A.M_NO = $auth_no															";
		$query .= " AND A.AM_TYPE = '".$a_admin_type."'												";
		$query .= "	AND (A.MN_HIGH_01 IS NULL OR A.MN_HIGH_01 = '')									";
		$query .= "ORDER BY A.MN_CODE ASC															";

//		global $S_SHOP_HOME;
//		if ($S_SHOP_HOME == "demo2") echo $query;
//		echo $query;
		return $db->getArrayTotal($query);
	}

	function getShopNameInc($intNumber){
		global $db;
		global $a_admin_type;

		$query =  "SELECT                                                                           ";
		$query .= "     SH_COM_NAME                                                                 ";
		$query .= "FROM SHOP_MGR				                                                    ";
		$query .= "WHERE SH_NO =																	";
		$query .= $intNumber;

//		global $S_SHOP_HOME;
//		if ($S_SHOP_HOME == "demo2") echo $query;
//		echo $query;
		return $db->getSelect($query);
	}

	function getTopLowMenuArray($auth_no, $high_menu_no, $menu_code="",$auth_lng="")
	{
		global $db;
		global $a_admin_type;

		$query  = "SELECT                                                                           ";
		$query .= "     A.MN_CODE                                                                   ";
		$query .= "    ,A.MN_HIGH_01                                                                ";
		$query .= "    ,A.MN_HIGH_02                                                                ";
		$query .= "    ,A.MN_NO		                                                                ";
		$query .= "    ,A.AM_L		                                                                ";
		$query .= "    ,A.AM_W		                                                                ";
		$query .= "    ,A.AM_M		                                                                ";
		$query .= "    ,A.AM_D		                                                                ";
		$query .= "    ,A.AM_E		                                                                ";
		$query .= "    ,A.AM_C		                                                                ";
		$query .= "    ,A.AM_S		                                                                ";
		$query .= "    ,A.AM_P		                                                                ";
		$query .= "    ,A.AM_U		                                                                ";
		$query .= "    ,A.AM_E1		                                                                ";
		$query .= "    ,A.AM_E2		                                                                ";
		$query .= "    ,A.AM_E3		                                                                ";
		$query .= "    ,A.AM_E4		                                                                ";
		$query .= "    ,A.AM_E5		                                                                ";
		$query .= "FROM ".TBL_ADMIN_MENU." A                                                        ";
		$query .= "WHERE A.M_NO = $auth_no															";
		$query .= " AND A.AM_TYPE = '".$a_admin_type."'												";
		$query .= "AND A.MN_HIGH_01 = '".$high_menu_no."'											";
		$query .= "AND (A.MN_HIGH_02 IS NULL OR A.MN_HIGH_02 = '')									";

		if ($menu_code)
			$query .= " AND A.MN_CODE = '".$menu_code."'											";

		$query .= "ORDER BY A.MN_CODE ASC															";
//		global $S_SHOP_HOME;
//		if ($S_SHOP_HOME == "demo2") echo $query;
		return $db->getArrayTotal($query);
	}



	function getTopLowMenuArray02($auth_no, $high_menu_no1, $high_menu_no2, $menu_code="",$auth_lng="")
	{
		global $db;
		global $a_admin_type;

		$query  = "SELECT                                                                           ";
		$query .= "     A.MN_CODE                                                                   ";
		$query .= "    ,A.MN_HIGH_01                                                                ";
		$query .= "    ,A.MN_HIGH_02                                                                ";
		$query .= "    ,A.MN_NO		                                                                ";
		$query .= "    ,A.AM_L		                                                                ";
		$query .= "    ,A.AM_W		                                                                ";
		$query .= "    ,A.AM_M		                                                                ";
		$query .= "    ,A.AM_D		                                                                ";
		$query .= "    ,A.AM_E		                                                                ";
		$query .= "    ,A.AM_C		                                                                ";
		$query .= "    ,A.AM_S		                                                                ";
		$query .= "    ,A.AM_P		                                                                ";
		$query .= "    ,A.AM_U		                                                                ";
		$query .= "    ,A.AM_E1		                                                                ";
		$query .= "    ,A.AM_E2		                                                                ";
		$query .= "    ,A.AM_E3		                                                                ";
		$query .= "    ,A.AM_E4		                                                                ";
		$query .= "    ,A.AM_E5		                                                                ";
		$query .= "FROM ".TBL_ADMIN_MENU." A                                                        ";
		$query .= "WHERE A.M_NO = $auth_no															";
		$query .= " AND A.AM_TYPE = '".$a_admin_type."'												";
		$query .= "AND A.MN_HIGH_01 = '".$high_menu_no1."'											";
		$query .= "AND A.MN_HIGH_02 = '".$high_menu_no2."'											";

		if ($menu_code)
			$query .= " AND A.MN_CODE = '".$menu_code."'											";

		$query .= "ORDER BY A.MN_CODE ASC															";
//		echo $query."<Br><Br>";
		return $db->getArrayTotal($query);
	}

	/* 메뉴 구조가 변경되어 이전에 권한이 주어진 메뉴가 없어지는 경우가 발생하여 똑같은 메뉴번호는 화면에 보이게 처리해야 함*/
	function getTopLowMenuArray03($auth_no, $high_menu_no1, $menu_no="",$auth_lng)
	{
		global $db;
		global $a_admin_type;

		$query  = "SELECT                                                                           ";
		$query .= "     COUNT(*)	";
		$query .= "FROM ".TBL_ADMIN_MENU." A                                                        ";
		$query .= "WHERE A.M_NO = $auth_no															";
		$query .= " AND A.AM_TYPE = '".$a_admin_type."'												";
		$query .= " AND A.MN_HIGH_01 = '".$high_menu_no1."'											";

		if ($menu_no)
			$query .= " AND A.MN_NO IN (".$menu_no.")												";

//		$query .= "ORDER BY A.MN_CODE ASC															";

//		echo $query."<Br><Br>";
		return $db->getCount($query);
	}

	function getCommuityLeftGroupList($auth_no)
	{
		global $db;
		global $a_admin_type;

		$query  = "SELECT											";
		$query .= "     B.B_BG_NO GROUP_CODE						";
		$query .= "    ,IFNULL(MAX(C.BG_NAME),'기타') GROUP_NAME_KR	";
		$query .= "    ,MIN(A.MN_NO) GROUP_MENU_NO             ";
		$query .= "FROM ".TBL_ADMIN_MENU." A                   ";
		$query .= "LEFT OUTER JOIN BOARD_MGR_NEW B             ";
		$query .= "ON A.MN_CODE = LPAD(B.B_NO,3,0)             ";
		$query .= "LEFT OUTER JOIN BOARD_GROUP_NEW C           ";
		$query .= "ON B.B_BG_NO = C.BG_NO                      ";
		$query .= "WHERE A.M_NO = $auth_no                     ";
		$query .= "    AND A.MN_NO BETWEEN 5000 AND 5900       ";
		$query .= "GROUP BY B.B_BG_NO                          ";
		$query .= "ORDER BY B.B_BG_NO DESC                     ";

		return $db->getArrayTotal($query);
	}

	$aryAdminTopMenu		= getTopMenuArray($a_admin_no,$strAdmSiteLng);
	//$aryAdminTopBoardMenu	= getTopBoardMenuList();

	$strIncludePath = MALL_WEB_PATH."shopAdmin/".$strMenuType."/";


	/* 스페인어일 경우 기본 통화가 EUR인데... 멕시코 통화를 사용할 수 잇으므로 기본통화변경되어야 함*/
	if ($S_ST_LNG == "ES" && $S_LNG_ES_CUR == "MXN") {
		$S_ARY_MONEY_ICON["ES"]["L"] = "MXN";
	}

	include $strIncludePath."index.php";


	$db->disConnect();

?>