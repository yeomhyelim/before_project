<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."AdminMgr.php";
	require_once MALL_CONF_LIB."MenuMgr.php";
	require_once MALL_CONF_LIB."AdminMenu.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";

	require_once "_function.lib.inc.php";

	$boardMgr = new BoardMgr();
	$siteMgr = new SiteMgr();
	$adminMgr = new AdminMgr();
	$menuMgr = new MenuMgr();
	$adminMenu = new AdminMenu();
	$memberMgr = new MemberMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$intS_NO		= $_POST["s_no"]			? $_POST["s_no"]			: $_REQUEST["s_no"];
	$intSC_NO		= $_POST["sc_no"]			? $_POST["sc_no"]			: $_REQUEST["sc_no"];
	$intM_NO		= $_POST["m_no"]			? $_POST["m_no"]			: $_REQUEST["m_no"];

//	$strPolicyLng	= $_POST["policyLng"]		? $_POST["policyLng"]		: $_REQUEST["policyLng"];

	if (!$strSearchStatus) $strSearchStatus = "1";

	/*##################################### Parameter 셋팅 #####################################*/

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	$strSearchStatus= $_POST["searchStatus"]	? $_POST["searchStatus"]	: $_REQUEST["searchStatus"];

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json"){
		include $strIncludePath.$strMode.".php";
		exit;
	}
	if(SUBSTR($strMode,0,3) == "pop"){
		include "{$strIncludePath}{$strMode}.php";
		exit;
	}
	/*##################################### Act Page 이동 #####################################*/

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "001";
	/* 관리자 권한 설정 */

//	echo $strMode;

?>
<? include "./include/header.inc.php"?>
<?
	switch($strMode){
		case "info":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$row = $siteMgr->getSiteInfoView($db);

			//$row = $siteMgr->getSiteInfo($db);

			/* 사업자등록번호 */
			$aryComNum1 = explode("-",$row[S_COM_NUM1]);
			$strComNum1_1 = $strComNum1_2 = $strComNum1_3 = "";
			if (is_array($aryComNum1)){
				$strComNum1_1 = $aryComNum1[0];
				$strComNum1_2 = $aryComNum1[1];
				$strComNum1_3 = $aryComNum1[2];
			}

			/* 통신판매업신고번호 */
			$aryComNum2 = explode("-",$row[S_COM_NUM2]);
			$strComNum2_1 = $strComNum2_2 = $strComNum2_3 = "";
			if (is_array($aryComNum2)){
				$strComNum2_1 = $aryComNum2[0];
				$strComNum2_2 = $aryComNum2[1];
				$strComNum2_3 = $aryComNum2[2];
			}

			/* 전화번호 */
			$aryComPhone = explode("-",$row[S_COM_PHONE]);
			$strComPhone1 = $strComPhone2 = $strComPhone3 = "";
			if (is_array($aryComPhone)){
				$strComPhone1 = $aryComPhone[0];
				$strComPhone2 = $aryComPhone[1];
				$strComPhone3 = $aryComPhone[2];
			}

			/* 팩스번호 */
			$aryComFax = explode("-",$row[S_COM_FAX]);
			$strComFax1 = $strComFax2 = $strComFax3 = "";
			if (is_array($aryComFax)){
				$strComFax1 = $aryComFax[0];
				$strComFax2 = $aryComFax[1];
				$strComFax3 = $aryComFax[2];
			}

			/* 우편번호 */
			$aryComZip = explode("-",$row[S_COM_ZIP]);
			$strComZip1 = $strComZip2 = "";
			if (is_array($aryComZip)){
				$strComZip1 = $aryComZip[0];
				$strComZip2 = $aryComZip[1];
			}

			/* 핸드폰 */
			$aryComHp = explode("-",$row[S_COM_HP]);
			$strComHp1 = $strComHp2 = $strComHp3 = "";
			if (is_array($aryComHp)){
				$strComHp1 = $aryComHp[0];
				$strComHp2 = $aryComHp[1];
				$strComHp3 = $aryComHp[2];
			}

		break;


		case "policy":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			$siteRow = $siteMgr->getSiteInfoView($db);

			$row = $siteMgr->getSiteTextView($db);

			$aryUseLng = explode("/",$siteRow[S_USE_LNG]);
			for($i=0;$i<sizeof($aryUseLng);$i++){
				if ($aryUseLng[$i] == "KR") $strUseLngKr = "Y";
				if ($aryUseLng[$i] == "US") $strUseLngUs = "Y";
				if ($aryUseLng[$i] == "ID") $strUseLngId = "Y";
				if ($aryUseLng[$i] == "CN") $strUseLngCn = "Y";
				if ($aryUseLng[$i] == "JP") $strUseLngJp = "Y";
				if ($aryUseLng[$i] == "FR") $strUseLngFr = "Y";
				if ($aryUseLng[$i] == "ES") $strUseLngEs = "Y";
			}

			if(!$strStLng):
				$strStLng	= strtolower($S_ST_LNG);
			endif;

		break;

		case "order":
		case "orderFor":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$row = $siteMgr->getSiteInfoView($db);
			$arySettle = explode("/",$row[S_SETTLE]);

			$aryDeliveryCom = getCommCodeList("DELIVERY","Y");

			$aryForPg = explode("/",$row['S_FOR_PG']);


		break;

		case "point":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			$row = $siteMgr->getSiteInfoView($db);


		break;

		case "coupon":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */

			$row = $siteMgr->getSiteInfoView($db);
		break;

		case "language":
			// 언어 설정

			## 관리자 Sub Menu 권한 설정
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "001";

			## 사이트 정보 불러오기
			$row = $siteMgr->getSiteInfoView($db);
			$strS_USE_LNG = $row['S_USE_LNG'];
			$strS_ST_LNG = $row['S_ST_LNG']; // 기준언어
			$strS_ST_CUR = $row['S_ST_CUR']; // 기준통화

			## 사용 언어 설정
			$aryS_USE_LNG = explode("/", $strS_USE_LNG);

			## 기준언어 설정
			$strLangSLower = strtolower($strS_ST_LNG);
			$strLangSKName = $S_ARY_LANG_INFO[$strS_ST_LNG]['K_NAME'];
			$strLangSSNAme = $S_ARY_LANG_INFO[$strS_ST_LNG]['S_NAME'];

			## 기존통화 기호 설정
			$strLangSMoneySign = $S_ARY_MONEY_INFO[$strS_ST_CUR]['SIGN'];
		break;

// 2014.08.13 kim hee sung 소스 정리
//		case "language":
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "004";
//			$strLeftMenuCode02 = "001";
//			/* 관리자 Sub Menu 권한 설정 */
//
//			$row = $siteMgr->getSiteInfoView($db);
//
//			$aryUseLng = explode("/",$row[S_USE_LNG]);
//			for($i=0;$i<sizeof($aryUseLng);$i++){
//				if ($aryUseLng[$i] == "KR") $strUseLngKr = "Y";
//				if ($aryUseLng[$i] == "US") $strUseLngUs = "Y";
//				if ($aryUseLng[$i] == "ID") $strUseLngId = "Y";
//				if ($aryUseLng[$i] == "CN") $strUseLngCn = "Y";
//				if ($aryUseLng[$i] == "JP") $strUseLngJp = "Y";
//				if ($aryUseLng[$i] == "FR") $strUseLngFr = "Y";
//				if ($aryUseLng[$i] == "ES") $strUseLngEs = "Y";
//			}
//
//		break;

		case "exchange":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "004";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */
			$siteRow		= $siteMgr->getSiteInfoView($db);
			$aryUseLng		= explode("/",$siteRow[S_USE_LNG]);
			if ($S_PAYPAL_EXT_CUR == "Y") array_push($aryUseLng,"US"); //->인도네시아/중국/러시아통화는 페이팔에서 제공해주지 않는 통화

			$intPageBlock = 10;
			$intPageLine  = 10;

			$siteMgr->setPageLine($intPageLine);

			$intTotal	= $siteMgr->getSiteCurTotal($db);

			$intTotPage	= ceil($intTotal / $siteMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$siteMgr->setLimitFirst($intFirst);

			$result = $siteMgr->getSiteCurList($db);

			$intListNum = $intTotal - ($intPageLine *($intPage-1));

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&page=";

		break;

		case "admin":
			// 관리자비밀번호변경.

			## 관리자 Sub Menu 권한 설정
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "003";

			## 모듈 설정
			$objMemberMgrModule = new MemberMgrModule($db);

			## 기본설정
			$intAdminNo = $_SESSION['ADMIN_NO'];
			$strLogoFileWebDir = "/upload/member/adminLogo";

			## 회원정보 불러오기
			$param = "";
			$param['M_NO'] = $intAdminNo;
			$param['JOIN_MA'] = "Y";
			$aryMemberRow = $objMemberMgrModule->getMemberMgrSelectEx2("OP_SELECT", $param);
			$strM_NAME = $aryMemberRow['M_NAME'];
			$strM_PHOTO = $aryMemberRow['M_PHOTO'];

			## 관리자 로고 설정
			$strAdminLogoFile = "";
			if($strM_PHOTO) { $strAdminLogoFile = "{$strLogoFileWebDir}/{$strM_PHOTO}"; }

		break;

// 2014.08.19 kim hee sung old style
//		case "admin":
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "003";
//			$strLeftMenuCode02 = "003";
//			/* 관리자 Sub Menu 권한 설정 */
//
//			$row = $adminMgr->getSuperView($db);
//
//			$strAdminName  = ($row[M_L_NAME]) ? $row[M_L_NAME]:"";
//			if ($strAdminName) $strAdminName .= " ";
//			$strAdminName .= ($row[M_F_NAME]) ? $row[M_F_NAME]:"";
//		break;

		case "adminList":
			// 관리자 리스트
			// 2014.08.13 kim hee sung 소스 정리
			// 최고관리자는 리스트에 출력하지 않습니다.(A_STATUS 가 0인 관리자)
			// A_STATUS 가 9인 회원은 삭제된 관리자 입니다.

			## 관리자 Sub Menu 권한 설정
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "002";
//			if($strSearchStatus == "1") { $strLeftMenuCode02 = "001"; } 주석 제거할때 반드시 기능을 설명해주세요.

			## 모듈 설정
			$objAdminMgrModule = new AdminMgrModule($db);

			## 기본설정
			$intPageLine = $_GET["pageLine"];
			$intSearchStatus = $_GET['searchStatus']; // 0(최고관리자), 1(관리자), 9(삭제된 관리자)
			$strSearchField = $_GET['searchField'];
			$strSearchKey = $_GET['searchKey'];

			## 개수 설정
			if($intPageLine) { $_COOKIE["COOKIE_ADM_BASIC_LIST_LINE"] = $intPageLine; }
			else { $intPageLine = $_COOKIE["COOKIE_ADM_BASIC_LIST_LINE"]; }

			## 삭제
			$strTitle = "관리자 리스트";
			$aryStatusNotIn[] = 0;
			$aryStatusNotIn[] = 9;
			if($intSearchStatus == 9):
				$strTitle = "삭제된 관리자";
				$aryStatusNotIn = "";
				$intStatus = 9;
			endif;

			## 데이터 불러오기
			$param							= "";
			$param['searchField']			= $strSearchField;
			$param['searchKey']				= $strSearchKey;
			$param['A_STATUS']				= $intStatus;
			$param['A_STATUS_NOT_IN']		= $aryStatusNotIn;
			$param['JOIN_M']				= "Y";
			$intTotal						= $objAdminMgrModule->getAdminMgrSelectEx("OP_COUNT", $param);				// 데이터 전체 개수
			$intPageLine					= ( $intPageLine )		? $intPageLine	: 10;								// 리스트 개수
			$intPage						= ( $intPage )			? $intPage		: 1;
			$intFirst						= ( $intTotal == 0 )		? 0					: $intPageLine * ( $intPage - 1 );

			$param['LIMIT']					= "{$intFirst},{$intPageLine}";
			$resResult						= $objAdminMgrModule->getAdminMgrSelectEx("OP_LIST", $param);
			$intPageBlock					= $strPageBlock;															// 블럭 개수
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );
//			echo $db->query;

			## paging 설정
			$intPage			= $intPage;									// 현재 페이지
			$intTotPage			= $intTotPage;								// 전체 페이지 수
			$intTotBlock		= ceil($intTotPage / $intPageBlock);		// 전체 블럭 수
			$intBlock			= ceil($intPage / $intPageBlock);			// 현재 블럭
			$intPrevBlock		= (($intBlock - 2) * $intPageBlock) + 1;	// 이전 블럭
			$intNextBlock		= ($intBlock * $intPageBlock) + 1;			// 다음 블럭
			$intFirstBlock		= (($intBlock - 1) * $intPageBlock) + 1;	// 현재 블럭 시작 시저
			$intLastBlock		= $intBlock * $intPageBlock;				// 현재 블럭 종료 시점

			if($intFirstBlock <= 0) { $intFirstBlock	= 1; }
			if($intPrevBlock  <= 0) { $intPrevBlock	= 1; }
			if($intNextBlock >= $intTotPage) { $intNextBlock	= $intTotPage; }
			if($intLastBlock >= $intTotPage) { $intLastBlock	= $intTotPage; }

			## 페이지 시작/마지막 번호 설정
			$intFirstNo			= ($intPage <= 1) ? $intPage : (($intPage - 1) * $intPageLine);
			$intLastNo			= $intPage * $intPageLine;
			if(!$intFirstNo) { $intFirstNo = ""; }
			if($intLastNo > $intTotal) { $intLastNo = $intTotal; }

			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);

			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;
			$linkPage		= "./?{$linkPage}&page=";

		break;

// 2014.08.13 kim hee sung 소스 정리
//		case "adminList":
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "003";
//			if ($strSearchStatus == "1") $strLeftMenuCode02 = "001";
//			else  $strLeftMenuCode02 = "002";
//			/* 관리자 Sub Menu 권한 설정 */
//
//			$intPageBlock = 10;
//
//			/* 리스트 페이지 라인 쿠키 설정 */
//			if (!$intPageLine){
//				$intPageLine = $_COOKIE["COOKIE_ADM_BASIC_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_BASIC_LIST_LINE"] : 50;
//			} else {
//				setCookie("COOKIE_ADM_BASIC_LIST_LINE",$intPageLine,time()+(86400 * 30),"/shopAdmin");
//			}
//			/* 리스트 페이지 라인 쿠키 설정 */
//
//			$adminMgr->setPageLine($intPageLine);
//			$adminMgr->setSearchField($strSearchField);
//			$adminMgr->setSearchKey($strSearchKey);
//			$adminMgr->setSearchStatus($strSearchStatus);
//			$intTotal	= $adminMgr->getTotal($db);
//			$intTotPage	= ceil($intTotal / $adminMgr->getPageLine());
//
//			if(!$intPage)	$intPage =1;
//
//			if ($intTotal==0) {
//				$intFirst	= 1;
//				$intLast	= 0;
//			} else {
//				$intFirst	= $intPageLine *($intPage -1);
//				$intLast	= $intPageLine * $intPage;
//			}
//			$adminMgr->setLimitFirst($intFirst);
//			$result = $adminMgr->getList($db);
//
//			$intListNum = $intTotal - ($intPageLine *($intPage-1));
//			$linkPage = "./?menuType=basic&mode=adminList&searchField=$strSearchField&searchKey=$strSearchKey&searchStatus=$strSearchStatus&pageLine=$intPageLine&page=";
//
//
//			$strDelMarkFront	= "";
//			$strDelMarkBack		= "";
//			if ($strSearchStatus == "9"){
//				$strDelMarkFront	= "<s>";
//				$strDelMarkBack		= "</s>";
//			}
//		break;

		case "adminWrite":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$xml_string = file_get_contents(MALL_HOME."/adminMenu.xml");

			$xml = simplexml_load_string($xml_string);

			$linkCancel		= "./?menuType=basic&mode=adminList&searchField=$strSearchField&searchKey=$strSearchKey&searchStatus=$strSearchStatus&page=";

			/* 게시판 관리자 메뉴 가지고 오기 */
			$aryCommunityAdmList = $adminMenu->getCommunityAdmList($db);

			/* 게시판 리스트 메뉴 가지고 오기 */
			$aryCommunityList = $adminMenu->getCommunityList($db);

		break;
		case "adminModify":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			/* 관리자 Left 메뉴 권한 설정 */
			if ($strSearchStatus == "1") $strLeftMenuCode01 = "001";
			else  $strLeftMenuCode01 = "002";
			/* 관리자 Left 메뉴 권한 설정 */

			$adminMgr->setM_NO($intM_NO);
			$adminMenu->setM_NO($intM_NO);
			$adminMenu->setAM_TYPE("A");
			//$menuRet01 = $adminMenu->getList01($db);
			$row = $adminMgr->getView($db);

			$authRet = $adminMenu->getMemAuthList($db);
			while($authRow = mysql_fetch_array($authRet[result])){
				$memberAuthRow[$authRow[MN_NO]] = $authRow;
			}
			$xml_string = file_get_contents(MALL_HOME."/adminMenu.xml");
			$xml = simplexml_load_string($xml_string);

 			$linkCancel		= "./?menuType=basic&mode=adminList&searchField=$strSearchField&searchKey=$strSearchKey&searchStatus=$strSearchStatus&page=$intPage&pageLine=$intPageLine";

			/* 게시판 관리자 메뉴 가지고 오기 */
			$aryCommunityAdmList = $adminMenu->getCommunityAdmList($db);

			/* 게시판 리스트 메뉴 가지고 오기 */
			$aryCommunityList = $adminMenu->getCommunityList($db);

		break;
	}

	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}
?>

<script type="text/javascript">
<!--

	$(document).ready(function() {
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		if($("div#shopSelectForm").length > 0) {
			$("input#a_tm").change(function() {
				if($(this).prop('checked'))		{ $("div#shopSelectForm").css({'display':''});		}
				else							{ $("div#shopSelectForm").css({'display':'none'});	}
			});
		}

		<?if($strMode == "adminList"){?>
		$("select[name=pageLine]").change(function() {
			var data							= new Array(30);
			data['pageLine']					= $(this).val();
			data['page']						= 1;
			data['searchField']					= $("#searchField").val();
			data['searchKey']					= $("#searchKey").val();

			C_getAddLocationUrl(data);
		});
		<?}?>

	});

	/* 이벤트 정의 */
	/* 2013.04.24 tab_language.inc.php 수정 */
//	function goKrTabPageMove() { goTabPage("<?=$strMode?>", "KR"); }
//	function goUsTabPageMove() { goTabPage("<?=$strMode?>", "US"); }
//	function goJpTabPageMove() { goTabPage("<?=$strMode?>", "JP"); }
//	function goCnTabPageMove() { goTabPage("<?=$strMode?>", "CN"); }
//	function goIdTabPageMove() { goTabPage("<?=$strMode?>", "ID"); }
//	function goFrTabPageMove() { goTabPage("<?=$strMode?>", "FR"); }

	/* 함수 정의 */
//	function goTabPage(mode, lng) {
//		location.href = "./?menuType=basic&mode="+mode+"&policyLng="+lng;
//	}

	function goSearch()
	{
		C_getMoveUrl("<?=$strMode?>","get","<?=$PHP_SELF?>");
	}

	/* 공통관리 */
	function goMoveUrl(mode,no)
	{
		switch (mode)
		{
			case "admin":

				if(!C_chkInput("m_now_pwd", true, "<?=$LNG_TRANS_CHAR['BW00084']?>")) return; //현재 비밀번호
				if(!C_chkInput("m_new_pwd1", true, "<?=$LNG_TRANS_CHAR['BW00085']?>")) return; //신규 비밀번호
				if(!C_chkInput("m_new_pwd2", true, "<?=$LNG_TRANS_CHAR['BW00085']?>")) return; //신규 비밀번호

				var strPwd = $("#m_new_pwd1").val();
				if (!C_isNull(strPwd))
				{
					if (strPwd.length < 6 || strPwd.length > 14)
					{
						alert("<?=$LNG_TRANS_CHAR['BS00011']?>"); //비밀번호는 최소 6 ~ 14 이상이어야 합니다.
						return;
					}

					if ($("#m_new_pwd1").val() != $("#m_new_pwd2").val())
					{
						alert("<?=$LNG_TRANS_CHAR['BS00012']?>"); //입력한 비밀번호가 일치하지 않습니다.
						return;
					}
				}

//				C_getAction(mode,"<?=$PHP_SELF?>");
				C_getFileAction(mode,"<?=$PHP_SELF?>");

			break;

			case "adminWrite":

				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");

			break;

			case "adminModify":
				if (!C_isNull(no))
				{
					var doc = document.form;
					doc.m_no.value = no;
				}
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");

			break;

			case "order":
			case "orderFor":
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
			break;

		} // switch

		return;

	}

	function goInfoModify()
	{
		if(!C_chkInput("site_nm",true,"<?=$LNG_TRANS_CHAR['BW00002']?>",true)) return; //쇼핑몰명

//		C_getAction("infoModify","<?=$PHP_SELF?>");
		C_getFileAction("infoModify","<?=$PHP_SELF?>");
	}

// 2014.09.02 kim hee sung script file로 이동
//	function goPolicyModify()
//	{
//		C_getAction("policyModify","<?=$PHP_SELF?>");
//	}

	function goOrderModify()
	{
		C_getAction("orderModify","<?=$PHP_SELF?>");
	}

	function goOrderForModify()
	{
		C_getAction("orderForModify","<?=$PHP_SELF?>");
	}

	function goPointModify()
	{
		C_getAction("pointModify","<?=$PHP_SELF?>");
	}

	function goCouponModify()
	{
		C_getAction("couponModify","<?=$PHP_SELF?>");
	}

	function goDelRetHelp()
	{
		C_getAction("delRetHelpModify","<?=$PHP_SELF?>");
	}

	function goCurModify(){
		C_getAction("currencyModify","<?=$PHP_SELF?>");
	}

	/* 우편번호 찾기 */
	function goZip(num)
	{
		window.open('?menuType=popup&mode=address&num=1','new','width=520px,height=450px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');

	}

	/* 관리자 찾기 */
	function goAdminFind()
	{
		C_openWindow("./?menuType=popup&mode=adminFind", "SearchMember", "500", "500");
	}

	function setMenuUse(chkObj,mn_level)
	{
		var intMN_NO	= chkObj.value;
		var chk_val		= chkObj.checked;
		var menuObj		= document.form["mn_no[]"];
		var strJsonUrl = "./?menuType=basic&mode=json&act=authChk&mn_no="+intMN_NO+"&mn_level="+mn_level+"&m_no="+document.form.m_no.value;
		//location.href = strJsonUrl;
		//return;

		$.getJSON(strJsonUrl,function(data){
			if (data[0].CNT > 0)
			{
				for(var n=0;n<data.length;n++){
					if (menuObj.length>0){

						for (k=0; k<menuObj.length; k++){

							if (menuObj[k].value == data[n].MN_NO)
							{
								menuObj[k].checked = chk_val;

								if (chk_val == true) menuObj[k].checked = true;
								else {
									menuObj[k].checked = false;
								}
								break;
							}
						}
					}
				}
			}
		});
	}

	function goAdminAct(){

		var mode = document.form.mode.value;

		if (mode == "write" || mode == "adminWrite" )
		{
			if(!C_chkInput("m_id", true, "ID")) return;

			var strJsonUrl = "./?menuType=basic&mode=json&act=idChk&m_no="+document.form.m_no.value;
			$.getJSON(strJsonUrl,function(data){

				if (data[0].RET == "N")
				{
					alert(data[0].MSG);
					return;
				} else {
					C_getAction(mode,"<?=$PHP_SELF?>");
				}
			});
		} else {
			C_getAction(mode,"<?=$PHP_SELF?>");
		}
	}

	function goAdminDel(no){
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //데이타를 삭제하시겠습니까?
		if (x==true)
		{

			document.form.m_no.value = no;
			C_getAction("adminDel","<?=$PHP_SELF?>");
		}
	}

	function goAdminRestore(no){
		var x = confirm("<?=$LNG_TRANS_CHAR['CS00008']?>"); //데이타를 복원하시겠습니까?
		if (x==true)
		{

			document.form.m_no.value = no;
			C_getAction("adminRestore","<?=$PHP_SELF?>");
		}
	}

	function goShopSelectWriteMove(){
		var href = "./?menuType=basic&mode=popShopSelectWrite";
		window.open(href, "", "width=600px,height=320px;");
	}
//-->
</script>
<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="leftWrap">
				<!-- ******************** leftArea ********************** -->
					<?include "./include/left.inc.php"?>
				<!-- ******************** leftArea ********************** -->
			</td>
			<td class="contentWrap">
				<div class="bodyTopLine"></div>
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="sc_no" value="<?=$intSC_NO?>">
						<input type="hidden" name="m_no" value="<?=$intM_NO?>">
						<input type="hidden" name="searchStatus" value="<?=$strSearchStatus?>">
						<input type="hidden" name="page" value="<?=$intPage?>">
						<?if($strMode == "adminWrite" || $strMode == "adminModify"){?>
						<input type="hidden" name="pageLine" value="<?=$intPageLine?>">
						<?}?>
						<?
							include $includeFile;
						?>
					</form>
					</div>
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
	</div>
<!-- ******************** footerArea ********************** -->
	<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ********************** -->
</body>
</html>