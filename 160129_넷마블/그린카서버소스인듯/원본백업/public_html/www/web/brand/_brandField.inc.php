<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$productMgr = new ProductAdmMgr();	

	// 공통
	$strSearchField			= $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$arySelfCheck			= $_POST['selfCheck']		? $_POST['selfCheck']		: $_REQUEST['selfCheck'];	// 선택된 글 리스트 

	// PRODUCT_BRAND
	$intPR_NO				= $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];
	$strPR_NAME				= $_POST["pr_name"]			? $_POST["pr_name"]			: $_REQUEST["pr_name"];
	$strPR_LIST_IMG			= $_POST["pr_list_img"]		? $_POST["pr_list_img"]		: $_REQUEST["pr_list_img"];
	$strPR_TITLE_IMG		= $_POST["pr_title_img"]	? $_POST["pr_title_img"]	: $_REQUEST["pr_title_img"];
	$strPR_VIEW_IMG			= $_POST["pr_view_img"]		? $_POST["pr_view_img"]		: $_REQUEST["pr_view_img"];
	$strPR_ADD_IMG			= $_POST["pr_add_img"]		? $_POST["pr_add_img"]		: $_REQUEST["pr_add_img"];
	$strPR_COMMENT			= $_POST["pr_comment"]		? $_POST["pr_comment"]		: $_REQUEST["pr_comment"];
	$strPR_HTML				= $_POST["pr_html"]			? $_POST["pr_html"]			: $_REQUEST["pr_html"];
	$strPR_TMP1				= $_POST["pr_tmp1"]			? $_POST["pr_tmp1"]			: $_REQUEST["pr_tmp1"];
	$strPR_TMP2				= $_POST["pr_tmp2"]			? $_POST["pr_tmp2"]			: $_REQUEST["pr_tmp2"];
	$strPR_TMP3				= $_POST["pr_tmp3"]			? $_POST["pr_tmp3"]			: $_REQUEST["pr_tmp3"];
	$intPR_REG_DT			= $_POST["pr_reg_dt"]		? $_POST["pr_reg_dt"]		: $_REQUEST["pr_reg_dt"];
	$intPR_REG_NO			= $_POST["pr_reg_no"]		? $_POST["pr_reg_no"]		: $_REQUEST["pr_reg_no"];
	$intPR_MOD_DT			= $_POST["pr_mod_dt"]		? $_POST["pr_mod_dt"]		: $_REQUEST["pr_mod_dt"];
	$intPR_MOD_NO			= $_POST["pr_mod_no"]		? $_POST["pr_mod_no"]		: $_REQUEST["pr_mod_no"];

	// PRODUCT_BRAND
	$strPR_NAME				= strTrim($strPR_NAME,50);
	$strPR_LIST_IMG			= strTrim($strPR_LIST_IMG,100);
	$strPR_TITLE_IMG		= strTrim($strPR_TITLE_IMG,100);
	$strPR_VIEW_IMG			= strTrim($strPR_VIEW_IMG,100);
	$strPR_ADD_IMG			= strTrim($strPR_ADD_IMG,100);
	$strPR_COMMENT			= strTrim($strPR_COMMENT,500);
	$strPR_HTML				= strTrim($strPR_HTML,65535);
	$strPR_TMP1				= strTrim($strPR_TMP1,50);
	$strPR_TMP2				= strTrim($strPR_TMP2,50);
	$strPR_TMP3				= strTrim($strPR_TMP3,200);

	// PRODUCT_BRAND
	$productMgr->setPR_NO($intPR_NO);
	$productMgr->setPR_NAME($strPR_NAME);
	$productMgr->setPR_LIST_IMG($strPR_LIST_IMG);
	$productMgr->setPR_TITLE_IMG($strPR_TITLE_IMG);
	$productMgr->setPR_VIEW_IMG($strPR_VIEW_IMG);
	$productMgr->setPR_ADD_IMG($strPR_ADD_IMG);
	$productMgr->setPR_COMMENT($strPR_COMMENT);
	$productMgr->setPR_HTML($strPR_HTML);
	$productMgr->setPR_TMP1($strPR_TMP1);
	$productMgr->setPR_TMP2($strPR_TMP2);
	$productMgr->setPR_TMP3($strPR_TMP3);
	$productMgr->setPR_REG_DT($intPR_REG_DT);
	$productMgr->setPR_REG_NO($intPR_REG_NO);
	$productMgr->setPR_MOD_DT($intPR_MOD_DT);
	$productMgr->setPR_MOD_NO($intPR_MOD_NO);
?>