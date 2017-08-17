<?
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."PostPaperMgr.php";
//	require_once MALL_CONF_LIB."PostMailLogMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."MemberPaperMgr.php";
	
	$boardMgr		= new BoardMgr();
	$siteMgr		= new SiteMgr();
	$postPaperMgr	= new PostPaperMgr();
//	$postMailLogMgr	= new PostMailLogMgr();
	$memberMgr		= new MemberMgr();
	$memberPaperMgr	= new MemberPaperMgr();

	// 공통	
	$strSearchField				= $_POST["searchField"]					? $_POST["searchField"]					: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]					? $_POST["searchKey"]					: $_REQUEST["searchKey"];
	$intPage					= $_POST["page"]						? $_POST["page"]						: $_REQUEST["page"];
	$strMailLng					= $_POST["mailLng"]						? $_POST["mailLng"]						: $_REQUEST["mailLng"];
	$arySelfCheck				= $_POST['selfCheck']					? $_POST['selfCheck']					: $_REQUEST['selfCheck'];	// 선택된 글 리스트 


	// postPaper
	$intPP_NO					= $_POST["pp_no"]						? $_POST["pp_no"]						: $_REQUEST["pp_no"];
	$strPP_TITLE				= $_POST["pp_title"]					? $_POST["pp_title"]					: $_REQUEST["pp_title"];
	$strPP_TEXT					= $_POST["pp_text"]						? $_POST["pp_text"]						: $_REQUEST["pp_text"];
	$intPP_TOTAL_CNT			= $_POST["pp_total_cnt"]				? $_POST["pp_total_cnt"]				: $_REQUEST["pp_total_cnt"];
	$intPP_REG_DT				= $_POST["pp_reg_dt"]					? $_POST["pp_reg_dt"]					: $_REQUEST["pp_reg_dt"];
	$intPP_REG_NO				= $_POST["pp_reg_no"]					? $_POST["pp_reg_no"]					: $_REQUEST["pp_reg_no"];
	$intPP_MOD_DT				= $_POST["pp_mod_dt"]					? $_POST["pp_mod_dt"]					: $_REQUEST["pp_mod_dt"];
	$intPP_MOD_NO				= $_POST["pp_mod_no"]					? $_POST["pp_mod_no"]					: $_REQUEST["pp_mod_no"];
	$strSendType				= $_POST['sendType']					? $_POST['sendType']					: $_REQUEST['sendType'];	// 선택된 회원에게 쪽지를 보냅니다. : A, 	검색된 회원에게 쪽지를 보냅니다. : B


	// 회원 검색 관련
	$strSearchOut				= $_POST["searchOut"]					? $_POST["searchOut"]					: $_REQUEST["searchOut"];
	$strSearchRegStartDt		= $_POST["searchRegStartDt"]			? $_POST["searchRegStartDt"]			: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt			= $_POST["searchRegEndDt"]				? $_POST["searchRegEndDt"]				: $_REQUEST["searchRegEndDt"];
	$strSearchOutStartDt		= $_POST["searchOutStartDt"]			? $_POST["searchOutStartDt"]			: $_REQUEST["searchOutStartDt"];
	$strSearchOutEndDt			= $_POST["searchOutEndDt"]				? $_POST["searchOutEndDt"]				: $_REQUEST["searchOutEndDt"];
	$strSearchLastLoginStartDt	= $_POST["searchLastLoginStartDt"]		? $_POST["searchLastLoginStartDt"]		: $_REQUEST["searchLastLoginStartDt"];
	$strSearchLastLoginEndDt	= $_POST["searchLastLoginEndDt"]		? $_POST["searchLastLoginEndDt"]		: $_REQUEST["searchLastLoginEndDt"];
	$strSearchVisitStartCnt		= $_POST["searchVisitStartCnt"]			? $_POST["searchVisitStartCnt"]			: $_REQUEST["searchVisitStartCnt"];
	$strSearchVisitEndCnt		= $_POST["searchVisitEndCnt"]			? $_POST["searchVisitEndCnt"]			: $_REQUEST["searchVisitEndCnt"];
	$strSearchSex				= $_POST["searchSex"]					? $_POST["searchSex"]					: $_REQUEST["searchSex"];
	$strSearchMailYN			= $_POST["searchMailYN"]				? $_POST["searchMailYN"]				: $_REQUEST["searchMailYN"];
	$strSearchSmsYN				= $_POST["searchSmsYN"]					? $_POST["searchSmsYN"]					: $_REQUEST["searchSmsYN"];
	$strSearchBirthMonth		= $_POST["searchBirthMonth"]			? $_POST["searchBirthMonth"]			: $_REQUEST["searchBirthMonth"];
	$strSearchBirthDay			= $_POST["searchBirthDay"]				? $_POST["searchBirthDay"]				: $_REQUEST["searchBirthDay"];
	$strSearchRecId				= $_POST["searchRecId"]					? $_POST["searchRecId"]					: $_REQUEST["searchRecId"];
	$arySearchGroup				= $_POST["searchGroup"]					? $_POST["searchGroup"]					: $_REQUEST["searchGroup"];
	$strSearchOrderSortCol		= $_POST["searchOrderSortCol"]			? $_POST["searchOrderSortCol"]			: $_REQUEST["searchOrderSortCol"];		/* 정렬 */
	$strSearchOrderSort			= $_POST["searchOrderSort"]				? $_POST["searchOrderSort"]				: $_REQUEST["searchOrderSort"];			/* 정렬 */

	$strPP_TITLE			= strTrim($strPP_TITLE,500);
	$strPP_TEXT				= strTrim($strPP_TEXT,65535);


	$postPaperMgr->setPP_NO($intPP_NO);
	$postPaperMgr->setPP_TITLE($strPP_TITLE);
	$postPaperMgr->setPP_TEXT($strPP_TEXT);
	$postPaperMgr->setPP_TOTAL_CNT($intPP_TOTAL_CNT);
	$postPaperMgr->setPP_REG_DT($intPP_REG_DT);
	$postPaperMgr->setPP_REG_NO($intPP_REG_NO);
	$postPaperMgr->setPP_MOD_DT($intPP_MOD_DT);
	$postPaperMgr->setPP_MOD_NO($intPP_MOD_NO);

?>