<?

	require_once MALL_CONF_LIB."ShopMgr.php";
	require_once MALL_CONF_LIB."AdminMenu.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	require_once "{$S_DOCUMENT_ROOT}/conf/site_skin_product.conf.inc.php";
	require_once "{$S_DOCUMENT_ROOT}/conf/category.inc.php";

	// 이미지 관련 함수.
	require_once "{$S_DOCUMENT_ROOT}www/classes/image/ImageFunc.class.php";

	$shopMgr = new ShopMgr();
	$adminMenu = new AdminMenu();
	$memberMgr = new MemberMgr();
	$productMgr = new ProductAdmMgr();

	/*##################################### Parameter 셋팅 #####################################*/

	/* 선택 */
	$aryChkNo				= $_POST["chkNo"]				? $_POST["chkNo"]					: $_REQUEST["chkNo"];

	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$strSearchComAuth		= $_POST["searchComAuth"]		? $_POST["searchComAuth"]	: $_REQUEST["searchComAuth"];
	$strSearchCountry		= $_POST['searchCountry']		? $_POST['searchCountry'] : $_REQUEST["searchCountry"] ;
	$strSearchCategory1		= $_POST['searchCategory1']		? $_POST['searchCategory1'] :  $_REQUEST["searchCategory1"];
	$strSearchCategory2		= $_POST['searchCategory2']		? $_POST['searchCategory2'] :  $_REQUEST["searchCategory2"];
	$strSearchCategory3		= $_POST['searchCategory3']		? $_POST['searchCategory3'] :  $_REQUEST["searchCategory3"];
	$strSearchCreditGrade1	= $_POST['searchCreditGrade1']	? $_POST['searchCreditGrade1'] :  $_REQUEST["searchCreditGrade1"];
	$strSearchCreditGrade2	= $_POST['searchCreditGrade2']	? $_POST['searchCreditGrade2'] :  $_REQUEST["searchCreditGrade2"];
	$strSearchCreditGrade3	= $_POST['searchCreditGrade3']	? $_POST['searchCreditGrade3'] : $_REQUEST["searchCreditGrade3"] ;
	$strSearchSaleGrade1	= $_POST['searchSaleGrade1']	? $_POST['searchSaleGrade1'] : $_REQUEST["searchSaleGrade1"] ;
	$strSearchSaleGrade2	= $_POST['searchSaleGrade2']	? $_POST['searchSaleGrade2'] : $_REQUEST["searchSaleGrade2"] ;
	$strSearchSaleGrade3	= $_POST['searchSaleGrade3']	? $_POST['searchSaleGrade3'] : $_REQUEST["searchSaleGrade3"] ;
	$strSearchLocusGrade1	= $_POST['searchLocusGrade1']	? $_POST['searchLocusGrade1'] : $_REQUEST["searchLocusGrade1"] ;
	$strSearchLocusGrade2	= $_POST['searchLocusGrade2']	? $_POST['searchLocusGrade2'] : $_REQUEST["searchLocusGrade2"] ;
	$strOrder				= $_POST['order']				? $_POST['order'] : $_REQUEST["order"] ;

	$intPage				= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine			= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$intSH_NO				= $_POST["shopNo"]			? $_POST["shopNo"]			: $_REQUEST["shopNo"];
	$intSH_FILE_NO			= $_POST["shopFileNo"]		? $_POST["shopFileNo"]		: $_REQUEST["shopFileNo"];
	$intSU_NO				= $_POST["shopUserNo"]		? $_POST["shopUserNo"]		: $_REQUEST["shopUserNo"];

	$strSH_TYPE				= $_POST["shop_type"]			? $_POST["shop_type"]			: $_REQUEST["shop_type"];
	$strSH_COM_TYPE			= $_POST["com_type"]			? $_POST["com_type"]			: $_REQUEST["com_type"];
	$strSH_COM_NAME			= $_POST["com_name"]			? $_POST["com_name"]			: $_REQUEST["com_name"];
	$strSH_COM_REP_NM		= $_POST["com_rep_nm"]			? $_POST["com_rep_nm"]			: $_REQUEST["com_rep_nm"];
	$strSH_COM_PHONE		= $_POST["com_phone"]			? $_POST["com_phone"]			: $_REQUEST["com_phone"];
	$strSH_COM_FAX			= $_POST["com_fax"]				? $_POST["com_fax"]				: $_REQUEST["com_fax"];
	$strSH_COM_MAIL			= $_POST["com_mail"]			? $_POST["com_mail"]			: $_REQUEST["com_mail"];
	$strSH_COM_UPTAE		= $_POST["com_uptae"]			? $_POST["com_uptae"]			: $_REQUEST["com_uptae"];
	$strSH_COM_CATEGORY		= $_POST["com_category"]		? $_POST["com_category"]		: $_REQUEST["com_category"];
	$strSH_COM_UPJONG		= $_POST["com_upjong"]			? $_POST["com_upjong"]			: $_REQUEST["com_upjong"];
	$strSH_COM_ADDR			= $_POST["com_addr"]			? $_POST["com_addr"]			: $_REQUEST["com_addr"];
	$strSH_COM_ADDR2		= $_POST["com_addr2"]			? $_POST["com_addr2"]			: $_REQUEST["com_addr2"];
	

	$strSH_COM_DEPOSIT		= $_POST["com_deposit"]			? $_POST["com_deposit"]			: $_REQUEST["com_deposit"];
	$strSH_COM_BANK			= $_POST["com_bank"]			? $_POST["com_bank"]			: $_REQUEST["com_bank"];
	$strSH_COM_BANK_NUM		= $_POST["com_bank_num"]		? $_POST["com_bank_num"]		: $_REQUEST["com_bank_num"];
	$strSH_COM_ACC_PRICE	= $_POST["com_acc_price"]		? $_POST["com_acc_price"]		: $_REQUEST["com_acc_price"];
	$intSH_COM_ACC_RATE		= $_POST["com_acc_rate"]		? $_POST["com_acc_rate"]		: $_REQUEST["com_acc_rate"];

	$strSH_COM_MAIN			= $_POST["shop_main"]			? $_POST["shop_main"]			: $_REQUEST["shop_main"];

	$strSH_APPR				= $_POST["shop_appr"]			? $_POST["shop_appr"]			: $_REQUEST["shop_appr"];

	$strSH_APPR_NO_REASON	= $_POST["shop_appr_no_reason"]			? $_POST["shop_appr_no_reason"]			: $_REQUEST["shop_sh_appr_no_reason"];

	$strSH_COM_NUM1_1		= $_POST["com_num1_1"]			? $_POST["com_num1_1"]			: $_REQUEST["com_num1_1"];
	$strSH_COM_NUM1_2		= $_POST["com_num1_2"]			? $_POST["com_num1_2"]			: $_REQUEST["com_num1_2"];
	$strSH_COM_NUM1_3		= $_POST["com_num1_3"]			? $_POST["com_num1_3"]			: $_REQUEST["com_num1_3"];

	$strSH_COM_NUM2_1		= $_POST["com_num2_1"]			? $_POST["com_num2_1"]			: $_REQUEST["com_num2_1"];
	$strSH_COM_NUM2_2		= $_POST["com_num2_2"]			? $_POST["com_num2_2"]			: $_REQUEST["com_num2_2"];
	$strSH_COM_NUM2_3		= $_POST["com_num2_3"]			? $_POST["com_num2_3"]			: $_REQUEST["com_num2_3"];



	$strSH_COM_PHONE1		= $_POST["com_phone1"]			? $_POST["com_phone1"]			: $_REQUEST["com_phone1"];
	$strSH_COM_PHONE2		= $_POST["com_phone2"]			? $_POST["com_phone2"]			: $_REQUEST["com_phone2"];
	$strSH_COM_PHONE3		= $_POST["com_phone3"]			? $_POST["com_phone3"]			: $_REQUEST["com_phone3"];
	$strSH_COM_FAX1			= $_POST["com_fax1"]			? $_POST["com_fax1"]			: $_REQUEST["com_fax1"];
	$strSH_COM_FAX2			= $_POST["com_fax2"]			? $_POST["com_fax2"]			: $_REQUEST["com_fax2"];
	$strSH_COM_FAX3			= $_POST["com_fax3"]			? $_POST["com_fax3"]			: $_REQUEST["com_fax3"];

	$strSH_COM_COUNTRY		= $_POST["com_country"]			? $_POST["com_country"]			: $_REQUEST["com_country"];

	$strSH_COM_DELIVERY				= $_POST["com_delivery"]				? $_POST["com_delivery"]				: $_REQUEST["com_delivery"];
	$intSH_COM_DELIVERY_ST_PRICE	= $_POST["com_delivery_st_price"]		? $_POST["com_delivery_st_price"]		: $_REQUEST["com_delivery_st_price"];
	$intSH_COM_DELIVERY_PRICE		= $_POST["com_delivery_price"]			? $_POST["com_delivery_price"]			: $_REQUEST["com_delivery_price"];
	$arySH_COM_DELIVERY_COR			= $_POST["com_delivery_cor"]			? $_POST["com_delivery_cor"]			: $_REQUEST["com_delivery_cor"];
	$arySH_COM_DELIVERY_FOR_COR		= $_POST["com_delivery_for_cor"]		? $_POST["com_delivery_for_cor"]		: $_REQUEST["com_delivery_for_cor"];
	$strSH_COM_DELIVERY_FREE		= $_POST["com_delivery_free"]			? $_POST["com_delivery_free"]			: $_REQUEST["com_delivery_free"];
	$strSH_COM_DEVLIERY_PROD		= $_POST["com_devliery_prod"]			? $_POST["com_devliery_prod"]			: $_REQUEST["com_devliery_prod"];
	$strSH_COM_DELIVERY_AREA		= $_POST["com_delivery_area"]			? $_POST["com_delivery_area"]			: $_REQUEST["com_delivery_area"];
	$strSH_COM_DELIVERY_TEXT		= $_POST["com_delivery_text"]			? $_POST["com_delivery_text"]			: $_REQUEST["com_delivery_text"];

	$strSH_COM_PROD_AUTH			= $_POST["com_prod_auth"]				? $_POST["com_prod_auth"]			: $_REQUEST["com_prod_auth"];


	$strSH_COM_SITE					= $_POST["com_site"]					? $_POST["com_site"]			: $_REQUEST["com_site"];
	$intSH_COM_FOUNDED				= $_POST["com_founded"]					? $_POST["com_founded"]			: $_REQUEST["com_founded"];
	$intSH_COM_NUMBER				= $_POST["com_number"]					? $_POST["com_number"]			: $_REQUEST["com_number"];
	$intSH_COM_TOTAL_SALE			= $_POST["com_total_sale"]				? $_POST["com_total_sale"]		: $_REQUEST["com_total_sale"];
	$intSH_COM_RATE					= $_POST["com_rate"]					? $_POST["com_rate"]			: $_REQUEST["com_rate"];
	$intSH_COM_TOTAL_PRODUCTION		= $_POST["com_total_production"]		? $_POST["com_total_production"]			: $_REQUEST["com_total_production"];
	$intSH_COM_COUNTRY1				= $_POST["com_country1"]				? $_POST["com_country1"]			: $_REQUEST["com_country1"];
	$intSH_COM_COUNTRY2				= $_POST["com_country2"]				? $_POST["com_country2"]			: $_REQUEST["com_country2"];
	$intSH_COM_COUNTRY3				= $_POST["com_country3"]				? $_POST["com_country3"]			: $_REQUEST["com_country3"];
	$intSH_COM_COUNTRY4				= $_POST["com_country4"]				? $_POST["com_country4"]			: $_REQUEST["com_country4"];
	$intSH_COM_COUNTRY5				= $_POST["com_country5"]				? $_POST["com_country5"]			: $_REQUEST["com_country5"];
	$intSH_COM_COUNTRY6				= $_POST["com_country6"]				? $_POST["com_country6"]			: $_REQUEST["com_country6"];
	$intSH_COM_COUNTRY7				= $_POST["com_country7"]				? $_POST["com_country7"]			: $_REQUEST["com_country7"];
	$intSH_COM_COUNTRY8				= $_POST["com_country8"]			? $_POST["com_country8"]			: $_REQUEST["com_country8"];
	$intSH_COM_COUNTRY9				= $_POST["com_country9"]			? $_POST["com_country9"]			: $_REQUEST["com_country9"];
	$intSH_COM_COUNTRY10			= $_POST["com_country10"]			? $_POST["com_country10"]			: $_REQUEST["com_country10"];
	$intSH_COM_COUNTRY11			= $_POST["com_country11"]			? $_POST["com_country11"]			: $_REQUEST["com_country11"];
	$intSH_COM_COUNTRY12			= $_POST["com_country12"]			? $_POST["com_country12"]			: $_REQUEST["com_country12"];
	$intSH_COM_COUNTRY13			= $_POST["com_country13"]			? $_POST["com_country13"]			: $_REQUEST["com_country13"];
	$intSH_COM_COUNTRY14			= $_POST["com_country14"]			? $_POST["com_country14"]			: $_REQUEST["com_country14"];
	$strSH_COM_LOCAL				= $_POST["com_local"]				? $_POST["com_local"]				: $_REQUEST["com_local"];
	$strSH_COM_SIZE					= $_POST["com_size"]				? $_POST["com_size"]				: $_REQUEST["com_size"];
	$intSH_COM_RD					= $_POST["com_rd"]					? $_POST["com_rd"]					: $_REQUEST["com_rd"];
	$strSH_COM_CATE					= $_POST["com_cate"]				? $_POST["com_cate"]				: $_REQUEST["com_cate"];

	$strSH_COM_CERTIFICATES1		= $_POST["com_certificates1"]		? $_POST["com_certificates1"]		: $_REQUEST["com_certificates1"];
	$strSH_COM_CERTIFICATES2		= $_POST["com_certificates2"]		? $_POST["com_certificates2"]		: $_REQUEST["com_certificates2"];
	$strSH_COM_CERTIFICATES3		= $_POST["com_certificates3"]		? $_POST["com_certificates3"]		: $_REQUEST["com_certificates3"];
	$strSH_COM_CERTIFICATES4		= $_POST["com_certificates4"]		? $_POST["com_certificates4"]		: $_REQUEST["com_certificates4"];
	$strSH_COM_CERTIFICATES5		= $_POST["com_certificates5"]		? $_POST["com_certificates5"]		: $_REQUEST["com_certificates5"];

	//$strSH_COM_CERTIFICATES1_FILE	= $_POST["com_certificates1_file"]		? $_POST["com_certificates1_file"]		: $_REQUEST["com_certificates1_file"];
	//$strSH_COM_CERTIFICATES2_FILE	= $_POST["com_certificates2_file"]		? $_POST["com_certificates2_file"]		: $_REQUEST["com_certificates2_file"];
	//$strSH_COM_CERTIFICATES3_FILE	= $_POST["com_certificates3_file"]		? $_POST["com_certificates3_file"]		: $_REQUEST["com_certificates3_file"];
	//$strSH_COM_CERTIFICATES4_FILE	= $_POST["com_certificates4_file"]		? $_POST["com_certificates4_file"]		: $_REQUEST["com_certificates4_file"];
	//$strSH_COM_CERTIFICATES5_FILE	= $_POST["com_certificates5_file"]		? $_POST["com_certificates5_file"]		: $_REQUEST["com_certificates5_file"];

	$strSH_COM_INTRO1				= $_POST["com_intro1"]				? $_POST["com_intro1"]				: $_REQUEST["com_intro1"];
	$strSH_COM_INTRO2				= $_POST["com_intro2"]				? $_POST["com_intro2"]				: $_REQUEST["com_intro2"];


	$strSH_COM_CREDIT_GRADE			= $_POST["com_credit_grade"]			? $_POST["com_credit_grade"]			: $_REQUEST["com_credit_grade"];
	$strSH_COM_SALE_GRADE			= $_POST["com_sale_grade"]				? $_POST["com_sale_grade"]				: $_REQUEST["com_sale_grade"];
	$strSH_COM_LOCUS_GRADE			= $_POST["com_locus_grade"]				? $_POST["com_locus_grade"]				: $_REQUEST["com_locus_grade"];

	$strST_NAME						= $_POST["store_name"]			? $_POST["store_name"]			: $_REQUEST["store_name"];
	$strST_NAME_ENG					= $_POST["store_name_eng"]		? $_POST["store_name_eng"]		: $_REQUEST["store_name_eng"];
	$strST_TEXT						= $_POST["store_text"]			? $_POST["store_text"]			: $_REQUEST["store_text"];
	$strST_MEMO						= $_POST["store_memo"]			? $_POST["store_memo"]			: $_REQUEST["store_memo"];

	$intSU_NO						= $_POST["shopUserNo"]			? $_POST["shopUserNo"]			: $_REQUEST["shopUserNo"];
	$intM_NO						= $_POST["m_no"]				? $_POST["m_no"]				: $_REQUEST["m_no"];
	$strSU_TYPE						= $_POST["user_type"]			? $_POST["user_type"]			: $_REQUEST["user_type"];
	$strSU_MEMO						= $_POST["user_memo"]			? $_POST["user_memo"]			: $_REQUEST["user_memo"];
	$strSU_USE						= $_POST["user_use"]			? $_POST["user_use"]			: $_REQUEST["user_use"];

	//메뉴번호
	$aryChkMenuNo					= $_POST["mn_no"]			? $_POST["mn_no"]			: $_REQUEST["mn_no"];

	$strSH_COM_NUM		= $strSH_COM_NUM1_1."-".$strSH_COM_NUM1_2."-".$strSH_COM_NUM1_3;
	$strSH_COM_NUM2		= $strSH_COM_NUM2_1."-".$strSH_COM_NUM2_2."-".$strSH_COM_NUM2_3;
	//$strSH_COM_ZIP		= $strSH_COM_ZIP1."-".$strSH_COM_ZIP2;
	//$strSH_COM_PHONE	= $strSH_COM_PHONE1."-".$strSH_COM_PHONE2."-".$strSH_COM_PHONE3;
	//$strSH_COM_FAX		= $strSH_COM_FAX1."-".$strSH_COM_FAX2."-".$strSH_COM_FAX3;

	/* 무료/상품별 배송정책은 현재의 쇼핑몰 기준을 따른다. */
	if (!$strSH_COM_DELIVERY_FREE) $strSH_COM_DELIVERY_FREE = "1";
	if (!$strSH_COM_DEVLIERY_PROD) $strSH_COM_DEVLIERY_PROD = "1";

	/* Join Form */
	$strM_ID		= $_POST["id"]				? $_POST["id"]				: $_REQUEST["id"];
	$strM_PASS		= $_POST["pwd1"]			? $_POST["pwd1"]			: $_REQUEST["pwd1"];
	$strM_NAME		= $_POST["name"]			? $_POST["name"]			: $_REQUEST["name"];
	$strM_F_NAME	= $_POST["f_name"]			? $_POST["f_name"]			: $_REQUEST["f_name"];
	$strM_L_NAME	= $_POST["l_name"]			? $_POST["l_name"]			: $_REQUEST["l_name"];

	$strM_NICK_NAME = $_POST["nickname"]		? $_POST["nickname"]		: $_REQUEST["nickname"];

	$strM_BIRTH1	= $_POST["birth1"]			? $_POST["birth1"]			: $_REQUEST["birth1"];
	$strM_BIRTH2	= $_POST["birth2"]			? $_POST["birth2"]			: $_REQUEST["birth2"];
	$strM_BIRTH3	= $_POST["birth3"]			? $_POST["birth3"]			: $_REQUEST["birth3"];
	$strM_BIRTH		= $strM_BIRTH1."-".$strM_BIRTH2."-".$strM_BIRTH3;

	$strM_SEX		= $_POST["sex"]				? $_POST["sex"]				: $_REQUEST["sex"];
	$strM_MAIL		= $_POST["mail"]			? $_POST["mail"]			: $_REQUEST["mail"];


	if($strSH_COM_COUNTRY == 'KR')
	{
		$strM_PHONE1	= $_POST["phone1"]			? $_POST["phone1"]			: $_REQUEST["phone1"];
		$strM_PHONE2	= $_POST["phone2"]			? $_POST["phone2"]			: $_REQUEST["phone2"];
		$strM_PHONE3	= $_POST["phone3"]			? $_POST["phone3"]			: $_REQUEST["phone3"];
		$strM_PHONE		= $strM_PHONE1;
		if ($strM_PHONE2) $strM_PHONE .= "-".$strM_PHONE2;
		if ($strM_PHONE3) $strM_PHONE .= "-".$strM_PHONE3;

		$strM_FAX1		= $_POST["fax1"]			? $_POST["fax1"]			: $_REQUEST["fax1"];
		$strM_FAX2		= $_POST["fax2"]			? $_POST["fax2"]			: $_REQUEST["fax2"];
		$strM_FAX3		= $_POST["fax3"]			? $_POST["fax3"]			: $_REQUEST["fax3"];
		$strM_FAX		= $strM_FAX1;
		if ($strM_FAX2) $strM_FAX .= "-".$strM_FAX2;
		if ($strM_FAX3) $strM_FAX .= "-".$strM_FAX3;

		$strM_HP1		= $_POST["hp1"]				? $_POST["hp1"]				: $_REQUEST["hp1"];
		$strM_HP2		= $_POST["hp2"]				? $_POST["hp2"]				: $_REQUEST["hp2"];
		$strM_HP3		= $_POST["hp3"]				? $_POST["hp3"]				: $_REQUEST["hp3"];
		$strM_HP		= $strM_HP1;
		if ($strM_HP2) $strM_HP .= "-".$strM_HP2;
		if ($strM_HP3) $strM_HP .= "-".$strM_HP3;

		$strM_ZIP1		= $_POST["zip1"]			? $_POST["zip1"]			: $_REQUEST["zip1"];
		$strM_ZIP2		= $_POST["zip2"]			? $_POST["zip2"]			: $_REQUEST["zip2"];
		$strM_ZIP		= $strM_ZIP1;
		if ($strM_ZIP2) $strM_ZIP .= "-".$strM_ZIP2;

		$strSH_COM_ZIP1			= $_POST["com_zip1"]			? $_POST["com_zip1"]			: $_REQUEST["com_zip1"];
		$strSH_COM_ZIP2			= $_POST["com_zip2"]			? $_POST["com_zip2"]			: $_REQUEST["com_zip2"];
		$strSH_COM_ZIP			= $strSH_COM_ZIP1."-".$strSH_COM_ZIP2;

	}
	else if($strSH_COM_COUNTRY == 'US')
	{
		$strSH_COM_CITY			= $_POST["com_city"]			? $_POST["com_city"]			: $_REQUEST["com_city"];
		$strM_PHONE = $strSH_COM_PHONE;
		$strM_FAX = $strSH_COM_FAX;

		$strSH_COM_STATE		= $_POST["com_state_2"]			? $_POST["com_state_2"]			: $_REQUEST["com_state_2"];
	}
	else
	{
		$strSH_COM_CITY			= $_POST["com_city"]			? $_POST["com_city"]			: $_REQUEST["com_city"];
		$strM_PHONE = $strSH_COM_PHONE;
		$strM_FAX = $strSH_COM_FAX;

		$strSH_COM_STATE		= $_POST["com_state_1"]			? $_POST["com_state_1"]			: $_REQUEST["com_state_1"];
	}



	$strM_ADDR		= $_POST["addr1"]			? $_POST["addr1"]			: $_REQUEST["addr1"];
	$strM_ADDR2		= $_POST["addr2"]			? $_POST["addr2"]			: $_REQUEST["addr2"];
	$strM_SMSYN		= $_POST["smsYN"]			? $_POST["smsYN"]			: $_REQUEST["smsYN"];
	$strM_MAILYN	= $_POST["mailYN"]			? $_POST["mailYN"]			: $_REQUEST["mailYN"];
	$strM_TEXT		= $_POST["memo"]			? $_POST["memo"]			: $_REQUEST["memo"];
	$strM_REC_ID	= $_POST["rec_id"]			? $_POST["rec_id"]			: $_REQUEST["rec_id"];

	$strM_WED		= $_POST["weddingYN"]		? $_POST["weddingYN"]		: $_REQUEST["weddingYN"];
	$strM_WED_DAY1	= $_POST["weddingDay1"]		? $_POST["weddingDay1"]		: $_REQUEST["weddingDay1"];
	$strM_WED_DAY2	= $_POST["weddingDay2"]		? $_POST["weddingDay2"]		: $_REQUEST["weddingDay2"];
	$strM_WED_DAY3	= $_POST["weddingDay3"]		? $_POST["weddingDay3"]		: $_REQUEST["weddingDay3"];
	$strM_WED_DAY	= $strM_WED_DAY1."-".$strM_WED_DAY2."-".$strM_WED_DAY3;

	$strM_JOB			= $_POST["job"]				? $_POST["job"]				: $_REQUEST["job"];
	$strM_CONCERN		= $_POST["concern"]			? $_POST["concern"]			: $_REQUEST["concern"];
	$strM_CHILD			= $_POST["child"]			? $_POST["child"]			: $_REQUEST["child"];
	$strM_COM_NM		= $_POST["com_nm"]			? $_POST["com_nm"]			: $_REQUEST["com_nm"];

	$strM_BUSI_NM		= $_POST["busi_nm"]			? $_POST["busi_nm"]			: $_REQUEST["busi_nm"];

	$strM_BUSI_NUM1		= $_POST["busi_num1"]		? $_POST["busi_num1"]		: $_REQUEST["busi_num1"];
	$strM_BUSI_NUM2		= $_POST["busi_num2"]		? $_POST["busi_num2"]		: $_REQUEST["busi_num2"];
	$strM_BUSI_NUM3		= $_POST["busi_num3"]		? $_POST["busi_num3"]		: $_REQUEST["busi_num3"];
	$strM_BUSI_NUM		= $strM_BUSI_NUM1;
	if ($strM_BUSI_NUM2) $strM_BUSI_NUM .= "-".$strM_BUSI_NUM2;
	if ($strM_BUSI_NUM3) $strM_BUSI_NUM .= "-".$strM_BUSI_NUM3;

	$strM_BUSI_UPJ		= $_POST["busi_upj"]		? $_POST["busi_upj"]		: $_REQUEST["busi_upj"];
	$strM_BUSI_UTE		= $_POST["busi_ute"]		? $_POST["busi_ute"]		: $_REQUEST["busi_ute"];

	$strM_BUSI_ZIP1		= $_POST["busi_zip1"]		? $_POST["busi_zip1"]		: $_REQUEST["busi_zip1"];
	$strM_BUSI_ZIP2		= $_POST["busi_zip2"]		? $_POST["busi_zip2"]		: $_REQUEST["busi_zip2"];
	$strM_BUSI_ZIP		= $strM_BUSI_ZIP1;
	if ($strM_BUSI_ZIP2) $strM_BUSI_ZIP .= "-".$strM_BUSI_ZIP2;
	$strM_BUSI_ADDR1 = $_POST["busi_addr1"]		? $_POST["busi_addr1"]			: $_REQUEST["busi_addr1"];
	$strM_BUSI_ADDR2 = $_POST["busi_addr2"]		? $_POST["busi_addr2"]			: $_REQUEST["busi_addr2"];

	$strM_FOREIGN		= $_POST["foreign"]			? $_POST["foreign"]			: $_REQUEST["foreign"];
	$strM_FOREIGN_NUM	= $_POST["foreign_num"]		? $_POST["foreign_num"]		: $_REQUEST["foreign_num"];
	$strM_PASSPORT		= $_POST["passport"]		? $_POST["passport"]		: $_REQUEST["passport"];
	$strM_DRIVE_NUM		= $_POST["drive_num"]		? $_POST["drive_num"]		: $_REQUEST["drive_num"];
	$strM_NATION		= $_POST["nation"]			? $_POST["nation"]			: $_REQUEST["nation"];

	$strM_TMP1			= $_POST["tmp1"]			? $_POST["tmp1"]			: $_REQUEST["tmp1"];
	$strM_TMP2			= $_POST["tmp2"]			? $_POST["tmp2"]			: $_REQUEST["tmp2"];
	$strM_TMP3			= $_POST["tmp3"]			? $_POST["tmp3"]			: $_REQUEST["tmp3"];
	$strM_TMP4			= $_POST["tmp4"]			? $_POST["tmp4"]			: $_REQUEST["tmp4"];
	$strM_TMP5			= $_POST["tmp5"]			? $_POST["tmp5"]			: $_REQUEST["tmp5"];

	$strM_COUNTRY	= $_POST["country"]			? $_POST["country"]			: $_REQUEST["country"];
	$strM_CITY		= $_POST["city"]			? $_POST["city"]			: $_REQUEST["city"];
	$strM_STATE1	= $_POST["state_1"]			? $_POST["state_1"]			: $_REQUEST["state_1"];
	$strM_STATE2	= $_POST["state_2"]			? $_POST["state_2"]			: $_REQUEST["state_2"];
	$strM_STATE		= $strM_STATE1;
	if ($strM_COUNTRY == "US") $strM_STATE = $strM_STATE2;

	/* Join Form */

	$strSH_TYPE				= strTrim($strSH_TYPE,1);
	$strSH_COM_TYPE			= strTrim($strSH_COM_TYPE,1);
	$strSH_COM_NUM			= strTrim($strSH_COM_NUM,20);
	$strSH_COM_NAME			= strTrim($strSH_COM_NAME,100);
	$strSH_COM_REP_NM		= strTrim($strSH_COM_REP_NM,30);
	$strSH_COM_PHONE		= strTrim($strSH_COM_PHONE,30);
	$strSH_COM_FAX			= strTrim($strSH_COM_FAX,30);
	$strSH_COM_MAIL			= strTrim($strSH_COM_MAIL,30);
	$strSH_COM_UPTAE		= strTrim($strSH_COM_UPTAE,50);
	$strSH_COM_UPJONG		= strTrim($strSH_COM_UPJONG,50);
	$strSH_COM_NUM2			= strTrim($strSH_COM_NUM2,20);
	$strSH_COM_ZIP			= strTrim($strSH_COM_ZIP,10);
	$strSH_COM_ADDR			= strTrim($strSH_COM_ADDR,150);
	$strSH_COM_DEPOSIT		= strTrim($strSH_COM_DEPOSIT,30);
	$strSH_COM_BANK			= strTrim($strSH_COM_BANK,10);
	$strSH_COM_BANK_NUM		= strTrim($strSH_COM_BANK_NUM,30);
	$strSH_COM_ACC_PRICE	= strTrim($strSH_COM_ACC_PRICE,1);
	$strSH_APPR				= strTrim($strSH_APPR,1);

	$strSH_COM_DELIVERY			= strTrim($strSH_COM_DELIVERY,1);
	$strSH_COM_DELIVERY_TYPE	= strTrim($strSH_COM_DELIVERY_TYPE,1);
//	$strSH_COM_DELIVERY_COR		= strTrim($strSH_COM_DELIVERY_COR,150);
	$strSH_COM_DELIVERY_FREE	= strTrim($strSH_COM_DELIVERY_FREE,1);
	$strSH_COM_DEVLIERY_PROD	= strTrim($strSH_COM_DEVLIERY_PROD,1);
	$strSH_COM_DELIVERY_AREA	= strTrim($strSH_COM_DELIVERY_AREA,0,"N");
	$strSH_COM_DELIVERY_TEXT	= strTrim($strSH_COM_DELIVERY_TEXT,0);

	$strSH_APPR_NO_REASON	= strTrim($strSH_APPR_NO_REASON,0);

	$strST_NAME		= strTrim($strST_NAME,100);
	$strST_NAME_ENG	= strTrim($strST_NAME_ENG,100);
	$strST_TEXT		= strTrim($strST_TEXT,"","N");
	$strST_MEMO		= strTrim($strST_MEMO,0,"");

	$strSU_TYPE = strTrim($strSU_TYPE,1);
	$strSU_MEMO = strTrim($strSU_MEMO,"","N");
	$strSU_USE	= strTrim($strSU_USE,1);

	$strM_ID		= strTrim($strM_ID,20);
	$strM_PASS		= strTrim($strM_PASS,100);
	$strM_F_NAME	= strTrim($strM_F_NAME,30);
	$strM_L_NAME	= strTrim($strM_L_NAME,30);
	$strM_NICK_NAME = strTrim($strM_NICK_NAME,40);
	$strM_BIRTH		= strTrim($strM_BIRTH,10);
	$strM_SEX		= strTrim($strM_SEX,1);
	$strM_MAIL		= strTrim($strM_MAIL,30);
	$strM_PHONE		= strTrim($strM_PHONE,30);
	$strM_HP		= strTrim($strM_HP,30);
	$strM_WED_DAY	= strTrim($strM_WED_DAY,10);
	$strM_WED		= strTrim($strM_WED,1);
	$strM_ZIP		= strTrim($strM_ZIP,10);
	$strM_ADDR		= strTrim($strM_ADDR,100);
	$strM_ADDR2		= strTrim($strM_ADDR2,150);
	$strM_SMSYN		= strTrim($strM_SMSYN,1);
	$strM_MAILYN	= strTrim($strM_MAILYN,1);
	$strM_TEXT		= strTrim($strM_TEXT,"");
	$strM_REC_ID	= strTrim($strM_REC_ID,50);
	$strM_CONCERN	= strTrim($strM_CONCERN,100);
	$strM_JOB		= strTrim($strM_JOB,10);
	$strM_FAX		= strTrim($strM_FAX,30);

	$strM_CHILD			= strTrim($strM_CHILD,10);
	$strM_COM_NM		= strTrim($strM_COM_NM,50);
	$strM_BUSI_NM		= strTrim($strM_BUSI_NM,50);
	$strM_BUSI_NUM		= strTrim($strM_BUSI_NUM,30);
	$strM_BUSI_UPJ		= strTrim($strM_BUSI_UPJ,10);
	$strM_BUSI_UTE		= strTrim($strM_BUSI_UTE,10);
	$strM_BUSI_ZIP		= strTrim($strM_BUSI_ZIP,10);
	$strM_BUSI_ADDR1	= strTrim($strM_BUSI_ADDR1,150);
	$strM_BUSI_ADDR2	= strTrim($strM_BUSI_ADDR2,100);
	$strM_FOREIGN		= strTrim($strM_FOREIGN,1);
	$strM_FOREIGN_NUM	= strTrim($strM_FOREIGN_NUM,30);
	$strM_PASSPORT		= strTrim($strM_PASSPORT,20);
	$strM_DRIVE_NUM		= strTrim($strM_DRIVE_NUM,20);
	$strM_NATION		= strTrim($strM_NATION,10);
	$strM_TMP1			= strTrim($strM_TMP1,250);
	$strM_TMP2			= strTrim($strM_TMP2,250);
	$strM_TMP3			= strTrim($strM_TMP3,250);
	$strM_TMP4			= strTrim($strM_TMP4,250);
	$strM_TMP5			= strTrim($strM_TMP5,250);

	if (!$strM_SMSYN) $strM_SMSYN = "N";
	if (!$strM_MAILYN) $strM_MAILYN = "N";

	if (!$strM_F_NAME) $strM_L_NAME = $strM_NAME; /* 한국일때 */


	if (is_array($arySH_COM_DELIVERY_COR)){
		$strSH_COM_DELIVERY_COR = "";
		foreach($arySH_COM_DELIVERY_COR as $key => $val){
			$strSH_COM_DELIVERY_COR .= $val.",";
		}

		$strSH_COM_DELIVERY_COR = substr($strSH_COM_DELIVERY_COR,0,strlen($strSH_COM_DELIVERY_COR)-1);
	}

	if (is_array($arySH_COM_DELIVERY_FOR_COR)){
		$strSH_COM_DELIVERY_FOR_COR = "";
		foreach($arySH_COM_DELIVERY_FOR_COR as $keya => $vala){
			$strSH_COM_DELIVERY_FOR_COR .= $vala.",";
		}

		$strSH_COM_DELIVERY_FOR_COR = substr($strSH_COM_DELIVERY_FOR_COR,0,strlen($strSH_COM_DELIVERY_FOR_COR)-1);
	}
	/*##################################### Parameter 셋팅 #####################################*/

	$shopMgr->setSH_NO($intSH_NO);
	$shopMgr->setSH_TYPE($strSH_TYPE);
	$shopMgr->setSH_COM_TYPE($strSH_COM_TYPE);
	$shopMgr->setSH_COM_NUM($strSH_COM_NUM);
	$shopMgr->setSH_COM_NAME($strSH_COM_NAME);
	$shopMgr->setSH_COM_REP_NM($strSH_COM_REP_NM);
	$shopMgr->setSH_COM_PHONE($strSH_COM_PHONE);
	$shopMgr->setSH_COM_FAX($strSH_COM_FAX);
	$shopMgr->setSH_COM_MAIL($strSH_COM_MAIL);
	$shopMgr->setSH_COM_UPTAE($strSH_COM_UPTAE);
	$shopMgr->setSH_COM_UPJONG($strSH_COM_UPJONG);
	$shopMgr->setSH_COM_CATEGORY($strSH_COM_CATEGORY);
	$shopMgr->setSH_COM_NUM2($strSH_COM_NUM2);
	$shopMgr->setSH_COM_ZIP($strSH_COM_ZIP);
	$shopMgr->setSH_COM_ADDR($strSH_COM_ADDR);
	$shopMgr->setSH_COM_ADDR2($strSH_COM_ADDR2);
	$shopMgr->setSH_COM_COUNTRY($strSH_COM_COUNTRY);
	$shopMgr->setSH_COM_DEPOSIT($strSH_COM_DEPOSIT);
	$shopMgr->setSH_COM_BANK($strSH_COM_BANK);
	$shopMgr->setSH_COM_BANK_NUM($strSH_COM_BANK_NUM);
	$shopMgr->setSH_COM_ACC_PRICE($strSH_COM_ACC_PRICE);
	$shopMgr->setSH_COM_ACC_RATE($intSH_COM_ACC_RATE);
	$shopMgr->setSH_COM_DELIVERY($strSH_COM_DELIVERY);
	$shopMgr->setSH_COM_DELIVERY_ST_PRICE($intSH_COM_DELIVERY_ST_PRICE);
	$shopMgr->setSH_COM_DELIVERY_PRICE($intSH_COM_DELIVERY_PRICE);
	$shopMgr->setSH_COM_DELIVERY_COR($strSH_COM_DELIVERY_COR);
	$shopMgr->setSH_COM_DELIVERY_FOR_COR($strSH_COM_DELIVERY_FOR_COR);
	$shopMgr->setSH_COM_DELIVERY_FREE($strSH_COM_DELIVERY_FREE);
	$shopMgr->setSH_COM_DEVLIERY_PROD($strSH_COM_DEVLIERY_PROD);
	$shopMgr->setSH_COM_DELIVERY_AREA($strSH_COM_DELIVERY_AREA);
	$shopMgr->setSH_COM_DELIVERY_TEXT($strSH_COM_DELIVERY_TEXT);
	$shopMgr->setSH_COM_PROD_AUTH($strSH_COM_PROD_AUTH);
	$shopMgr->setSH_APPR($strSH_APPR);

	$shopMgr->setSH_COM_MAIN($strSH_COM_MAIN);



	$shopMgr->setSH_APPR_NO_REASON($strSH_APPR_NO_REASON);

	$shopMgr->setSH_COM_SITE($strSH_COM_SITE);
	$shopMgr->setSH_COM_FOUNDED($intSH_COM_FOUNDED);
	$shopMgr->setSH_COM_NUMBER($intSH_COM_NUMBER);
	$shopMgr->setSH_COM_TOTAL_SALE($intSH_COM_TOTAL_SALE);
	$shopMgr->setSH_COM_RATE($intSH_COM_RATE);
	$shopMgr->setSH_COM_TOTAL_PRODUCTION($intSH_COM_TOTAL_PRODUCTION);
	$shopMgr->setSH_COM_COUNTRY1($intSH_COM_COUNTRY1);
	$shopMgr->setSH_COM_COUNTRY2($intSH_COM_COUNTRY2);
	$shopMgr->setSH_COM_COUNTRY3($intSH_COM_COUNTRY3);
	$shopMgr->setSH_COM_COUNTRY4($intSH_COM_COUNTRY4);
	$shopMgr->setSH_COM_COUNTRY5($intSH_COM_COUNTRY5);
	$shopMgr->setSH_COM_COUNTRY6($intSH_COM_COUNTRY6);
	$shopMgr->setSH_COM_COUNTRY7($intSH_COM_COUNTRY7);
	$shopMgr->setSH_COM_COUNTRY8($intSH_COM_COUNTRY8);
	$shopMgr->setSH_COM_COUNTRY9($intSH_COM_COUNTRY9);
	$shopMgr->setSH_COM_COUNTRY10($intSH_COM_COUNTRY10);
	$shopMgr->setSH_COM_COUNTRY11($intSH_COM_COUNTRY11);
	$shopMgr->setSH_COM_COUNTRY12($intSH_COM_COUNTRY12);
	$shopMgr->setSH_COM_COUNTRY13($intSH_COM_COUNTRY13);
	$shopMgr->setSH_COM_COUNTRY14($intSH_COM_COUNTRY14);
	$shopMgr->setSH_COM_LOCAL($strSH_COM_LOCAL);
	$shopMgr->setSH_COM_SIZE($strSH_COM_SIZE);
	$shopMgr->setSH_COM_RD($intSH_COM_RD);
	$shopMgr->setSH_COM_CATE($strSH_COM_CATE);
	$shopMgr->setSH_COM_CERTIFICATES1($strSH_COM_CERTIFICATES1);
	$shopMgr->setSH_COM_CERTIFICATES2($strSH_COM_CERTIFICATES2);
	$shopMgr->setSH_COM_CERTIFICATES3($strSH_COM_CERTIFICATES3);
	$shopMgr->setSH_COM_CERTIFICATES4($strSH_COM_CERTIFICATES4);
	$shopMgr->setSH_COM_CERTIFICATES5($strSH_COM_CERTIFICATES5);

	$shopMgr->setSH_COM_CREDIT_GRADE($strSH_COM_CREDIT_GRADE);
	$shopMgr->setSH_COM_SALE_GRADE($strSH_COM_SALE_GRADE);
	$shopMgr->setSH_COM_LOCUS_GRADE($strSH_COM_LOCUS_GRADE);

	$shopMgr->setSH_COM_INTRO1($strSH_COM_INTRO1);
	$shopMgr->setSH_COM_INTRO2($strSH_COM_INTRO2);

	$shopMgr->setSH_COM_STATE($strSH_COM_STATE);
	$shopMgr->setSH_COM_CITY($strSH_COM_CITY);


	$shopMgr->setSH_REG_NO($a_admin_no);
	$shopMgr->setSH_MOD_NO($a_admin_no);

	$shopMgr->setST_NAME($strST_NAME);
	$shopMgr->setST_NAME_ENG($strST_NAME_ENG);
	$shopMgr->setST_TEXT($strST_TEXT);
	$shopMgr->setST_MEMO($strST_MEMO);

	$shopMgr->setSU_NO($intSU_NO);
	$shopMgr->setM_NO($intM_NO);
	$shopMgr->setSU_TYPE($strSU_TYPE);
	$shopMgr->setSU_MEMO($strSU_MEMO);
	$shopMgr->setSU_USE($strSU_USE);

	$memberMgr->setM_ID($strM_ID);
	$memberMgr->setM_PASS($strM_PASS);
	$memberMgr->setM_F_NAME($strM_F_NAME);
	$memberMgr->setM_L_NAME($strM_L_NAME);
	$memberMgr->setM_NICK_NAME($strM_NICK_NAME);
	$memberMgr->setM_BIRTH($strM_BIRTH);
	$memberMgr->setM_SEX($strM_SEX);
	$memberMgr->setM_MAIL($strM_MAIL);
	$memberMgr->setM_PHONE($strM_PHONE);
	$memberMgr->setM_HP($strM_HP);
	$memberMgr->setM_WED_DAY($strM_WED_DAY);
	$memberMgr->setM_WED($strM_WED);
	$memberMgr->setM_ZIP($strM_ZIP);
	$memberMgr->setM_ADDR($strM_ADDR);
	$memberMgr->setM_ADDR2($strM_ADDR2);
	$memberMgr->setM_SMSYN($strM_SMSYN);
	$memberMgr->setM_MAILYN($strM_MAILYN);
	$memberMgr->setM_TEXT($strM_TEXT);
	$memberMgr->setM_REC_ID($strM_REC_ID);
	$memberMgr->setM_CONCERN($strM_CONCERN);
	$memberMgr->setM_JOB($strM_JOB);
	$memberMgr->setM_FAX($strM_FAX);
	$memberMgr->setM_COUNTRY($strM_COUNTRY);
	$memberMgr->setM_CITY($strM_CITY);
	$memberMgr->setM_STATE($strM_STATE);
	$memberMgr->setM_AUTH("Y");

	$memberMgr->setM_CHILD($strM_CHILD);
	$memberMgr->setM_COM_NM($strM_COM_NM);
	$memberMgr->setM_BUSI_NM($strM_BUSI_NM);
	$memberMgr->setM_BUSI_NUM($strM_BUSI_NUM);
	$memberMgr->setM_BUSI_UPJ($strM_BUSI_UPJ);
	$memberMgr->setM_BUSI_UTE($strM_BUSI_UTE);
	$memberMgr->setM_BUSI_ZIP($strM_BUSI_ZIP);
	$memberMgr->setM_BUSI_ADDR1($strM_BUSI_ADDR1);
	$memberMgr->setM_BUSI_ADDR2($strM_BUSI_ADDR2);
	$memberMgr->setM_FOREIGN($strM_FOREIGN);
	$memberMgr->setM_FOREIGN_NUM($strM_FOREIGN_NUM);
	$memberMgr->setM_PASSPORT($strM_PASSPORT);
	$memberMgr->setM_DRIVE_NUM($strM_DRIVE_NUM);
	$memberMgr->setM_NATION($strM_NATION);
	$memberMgr->setM_PHOTO($strM_PHOTO);
	$memberMgr->setM_TMP1($strM_TMP1);
	$memberMgr->setM_TMP2($strM_TMP2);
	$memberMgr->setM_TMP3($strM_TMP3);
	$memberMgr->setM_TMP4($strM_TMP4);
	$memberMgr->setM_TMP5($strM_TMP5);

	if(!$strStLng){
		$strStLng = $S_SITE_LNG;
	}

	$strLinkPage = "&searchField=$strSearchField";
	$strLinkPage .= "&searchKey=$strSearchKey";
	$strLinkPage .= "&searchComAuth=$strSearchComAuth";
	$strLinkPage .= "&searchCreditGrade1=$strSearchCreditGrade1";
	$strLinkPage .= "&searchCreditGrade2=$strSearchCreditGrade2";
	$strLinkPage .= "&searchCreditGrade3=$strSearchCreditGrade3";
	$strLinkPage .= "&searchSaleGrade1=$strSearchSaleGrade1";
	$strLinkPage .= "&searchSaleGrade2=$strSearchSaleGrade2";
	$strLinkPage .= "&searchSaleGrade3=$strSearchSaleGrade3";
	$strLinkPage .= "&searchLocusGrade1=$strSearchLocusGrade1";
	$strLinkPage .= "&searchLocusGrade2=$strSearchLocusGrade2";
	$strLinkPage .= "&page=$intPage";


	switch ($strAct) {

		case "shopWrite":
			// 입점몰 등록

			/* 이메일 중복 체크 */
			$intCount = $shopMgr->getShopMailCheck($db);
			if ($intCount > 0){
				goErrMsg($LNG_TRANS_CHAR["MS00027"]); // 중복된 이메일이 존재합니다.
				exit;
			}

			/* 파일 업로드 */
			$strSaveDir		= WEB_UPLOAD_PATH . "/shop";
			$strSaveTime	= date("YmdHis");

			for($i=1;$i<=5;$i++){
				$makeDirName = $strSaveDir."/file{$i}";
				if(!is_dir($makeDirName)):
					@mkdir($makeDirName,0707);
					@chmod($makeDirName,0707);
				endif;

				if ($_FILES['com_file'.$i]['name']){
					$aryFileInfo	= $fh->getFileInfo($_FILES['com_file'.$i]['name']);

					if ($i==1){
						$strSaveName	= sprintf("%s_%s", $strSaveTime, "stamp.".$aryFileInfo['extension']);
					} else if ($i==2){
						$strSaveName	= sprintf("%s_%s", $strSaveTime, "bank.".$aryFileInfo['extension']);
					} else if ($i==3){
						$strSaveName	= sprintf("%s_%s", $strSaveTime, "paper.".$aryFileInfo['extension']);
					} else if ($i==4){
						$strSaveName	= sprintf("%s_%s", $strSaveTime, "logo.".$aryFileInfo['extension']);
					} else if ($i==5){
						$strSaveName	= sprintf("%s_%s", $strSaveTime, "video.".$aryFileInfo['extension']);
					}

					if($fh->doUploadEasy($strSaveDir. "/file".$i."/". $strSaveName, "com_file".$i)):
						${"strFile".$i}		= $strSaveName;
					endif;
				}
			}


            #회사 로고 리사이징 2015.06.10 남덕희
            $imageResize	= new ImageFunc();
            $copyRe= $imageResize->getImageResize($strSaveDir. "/file4/". $strFile4, $strSaveDir. "/file4/". $strFile4, $S_PRODLIST_IMG_SIZE_W, $S_PRODLIST_IMG_SIZE_H);

			$shopMgr->setSH_COM_FILE1($strFile1);
			$shopMgr->setSH_COM_FILE2($strFile2);
			$shopMgr->setSH_COM_FILE3($strFile3);
			$shopMgr->setSH_COM_FILE4($strFile4);
			$shopMgr->setSH_COM_FILE5($strFile5);
			/* 파일 업로드 */


			for($j=1;$j<=5;$j++){
				$makeDirName2 = $strSaveDir."/certificates{$j}";
				if(!is_dir($makeDirName2)):
					@mkdir($makeDirName2,0707);
					@chmod($makeDirName2,0707);
				endif;
				if ($_FILES['com_certificates'.$i.'_file']['name']){
					$aryFileInfo2	= $fh->getFileInfo($_FILES['com_certificates'.$j.'_file']['name']);

					if ($j==1){
						$strSaveName2	= sprintf("%s_%s", $strSaveTime, "stamp.".$aryFileInfo2['extension']);
					} else if ($j==2){
						$strSaveName2	= sprintf("%s_%s", $strSaveTime, "bank.".$aryFileInfo2['extension']);
					} else if ($j==3){
						$strSaveName2	= sprintf("%s_%s", $strSaveTime, "paper.".$aryFileInfo2['extension']);
					} else if ($j==4){
						$strSaveName2	= sprintf("%s_%s", $strSaveTime, "logo.".$aryFileInfo2['extension']);
					} else if ($j==5){
						$strSaveName2	= sprintf("%s_%s", $strSaveTime, "video.".$aryFileInfo2['extension']);
					}

					if($fh->doUploadEasy($strSaveDir. "/certificates".$j."/". $strSaveName2, 'com_certificates'.$j.'_file')):
						${"strSH_COM_CERTIFICATES".$j."_FILE"}		= $strSaveName2;
					endif;
				}
			}

			$shopMgr->setSH_COM_CERTIFICATES1_FILE($strSH_COM_CERTIFICATES1_FILE);
			$shopMgr->setSH_COM_CERTIFICATES2_FILE($strSH_COM_CERTIFICATES2_FILE);
			$shopMgr->setSH_COM_CERTIFICATES3_FILE($strSH_COM_CERTIFICATES3_FILE);
			$shopMgr->setSH_COM_CERTIFICATES4_FILE($strSH_COM_CERTIFICATES4_FILE);
			$shopMgr->setSH_COM_CERTIFICATES5_FILE($strSH_COM_CERTIFICATES5_FILE);


			$shopMgr->getShopInsert($db);

			$intSH_NO = $db->getLastInsertID();
			$shopMgr->setSH_NO($intSH_NO);

			/* 상품 기본정보 언어별 INSERT */
			$aryUseLng = explode("/", $S_USE_LNG);
			for($j=0;$j<sizeof($aryUseLng);$j++){
				if ($aryUseLng[$j]){
					$shopMgr->setP_LNG($aryUseLng[$j]);
					$shopMgr->getShopInfoInsert($db);
				}
			}


			$strUrl = "./?menuType=seller&mode=shopList";

		break;

		case "shopModify":
			// 입점몰 수정
			// 2103.06.19 kim hee sung 소스 정리 및 버그 수정

			## STEP 1.
			## 기본저보 불러오기
			$shopMgr->setSH_NO($intSH_NO);
			$shopRow =$shopMgr->getShopView($db);
			$shopMgr->setSH_COM_FILE1($shopRow['SH_COM_FILE1']);
			$shopMgr->setSH_COM_FILE2($shopRow['SH_COM_FILE2']);
			$shopMgr->setSH_COM_FILE3($shopRow['SH_COM_FILE3']);
			$shopMgr->setSH_COM_FILE4($shopRow['SH_COM_FILE4']);
			$shopMgr->setSH_COM_FILE5($shopRow['SH_COM_FILE5']);

			$shopMgr->setSH_COM_CERTIFICATES1_FILE($shopRow['SH_COM_CERTIFICATES1_FILE']);
			$shopMgr->setSH_COM_CERTIFICATES2_FILE($shopRow['SH_COM_CERTIFICATES2_FILE']);
			$shopMgr->setSH_COM_CERTIFICATES3_FILE($shopRow['SH_COM_CERTIFICATES3_FILE']);
			$shopMgr->setSH_COM_CERTIFICATES4_FILE($shopRow['SH_COM_CERTIFICATES4_FILE']);
			$shopMgr->setSH_COM_CERTIFICATES5_FILE($shopRow['SH_COM_CERTIFICATES5_FILE']);

			## STEO 2,
			## 파일 삭제
			$webUploadPath = WEB_UPLOAD_PATH;

			if($_POST['com_file1_del']) { unlink("{$webUploadPath}/shop/file1/{$_POST['com_file1_del']}"); $shopMgr->setSH_COM_FILE1(""); }
			if($_POST['com_file2_del']) { unlink("{$webUploadPath}/shop/file2/{$_POST['com_file2_del']}"); $shopMgr->setSH_COM_FILE2(""); }
			if($_POST['com_file3_del']) { unlink("{$webUploadPath}/shop/file3/{$_POST['com_file3_del']}"); $shopMgr->setSH_COM_FILE3(""); }
			if($_POST['com_file4_del']) { unlink("{$webUploadPath}/shop/file4/{$_POST['com_file4_del']}"); $shopMgr->setSH_COM_FILE4(""); }
			if($_POST['com_file5_del']) { unlink("{$webUploadPath}/shop/file5/{$_POST['com_file5_del']}"); $shopMgr->setSH_COM_FILE5(""); }

			if($_POST['com_certificates1_file_del']) {
				unlink("{$webUploadPath}/shop/certificates1/{$_POST['com_certificates1_file_del']}");
				$shopMgr->setSH_COM_CERTIFICATES1_FILE("");
			}
			if($_POST['com_certificates2_file_del']) {
				unlink("{$webUploadPath}/shop/certificates2/{$_POST['com_certificates2_file_del']}");
				$shopMgr->setSH_COM_CERTIFICATES2_FILE("");
			}
			if($_POST['com_certificates3_file_del']) {
				unlink("{$webUploadPath}/shop/certificates3/{$_POST['com_certificates3_file_del']}");
				$shopMgr->setSH_COM_CERTIFICATES3_FILE("");
			}
			if($_POST['com_certificates4_file_del']) {
				unlink("{$webUploadPath}/shop/certificates4/{$_POST['com_certificates4_file_del']}");
				$shopMgr->setSH_COM_CERTIFICATES4_FILE("");
			}
			if($_POST['com_certificates5_file_del']) {
				unlink("{$webUploadPath}/shop/certificates5/{$_POST['com_certificates5_file_del']}");
				$shopMgr->setSH_COM_CERTIFICATES5_FILE("");
			}

			## STEO 2,
			## 파일 저장
			$strSaveTime		= date("YmdHis");
			for($i=1;$i<=5;$i++):
				$file = $_FILES["com_file{$i}"];
				$makeDirName = $webUploadPath."/shop/file{$i}";
				if(!is_dir($makeDirName)):
					@mkdir($makeDirName,0707);
					@chmod($makeDirName,0707);
				endif;
				if($file['error'] == 0):
					$aryFileInfo						= $fh->getFileInfo($file['name']);
					if($i == 1)			{ $strSaveName	= "{$strSaveTime}_stamp.{$aryFileInfo['extension']}"; }
					else if($i == 2)	{ $strSaveName	= "{$strSaveTime}_bank.{$aryFileInfo['extension']}"; }
					else if($i == 3)	{ $strSaveName	= "{$strSaveTime}_paper.{$aryFileInfo['extension']}"; }
					else if($i == 4)	{
					   $strSaveName	= "{$strSaveTime}_logo.{$aryFileInfo['extension']}";
                       $strSaveName4 = $strSaveName;
                     }
					else if($i == 5)	{ $strSaveName	= "{$strSaveTime}_video.{$aryFileInfo['extension']}"; }
				endif;

				if($fh->doUploadEasy("{$webUploadPath}/shop/file{$i}/{$strSaveName}", "com_file{$i}")):
					$fileName = $shopRow["SH_COM_FILE{$i}"];
					unlink("{$webUploadPath}/shop/file{$i}/{$fileName}");
					$shopMgr->{"setSH_COM_FILE{$i}"}($strSaveName);
				endif;
			endfor;

            #회사 로고 리사이징 2015.06.10 남덕희
            $imageResize	= new ImageFunc();
            $copyRe= $imageResize->getImageResize("{$webUploadPath}/shop/file4/$strSaveName4","{$webUploadPath}/shop/file4/$strSaveName4", $S_PRODLIST_IMG_SIZE_W, $S_PRODLIST_IMG_SIZE_H);

			for($j=1;$j<=5;$j++):
				$file2 = $_FILES["com_certificates{$j}_file"];
				$makeDirName2 = $webUploadPath."/shop/certificates{$j}";
				if(!is_dir($makeDirName2)):
					@mkdir($makeDirName2,0707);
					@chmod($makeDirName2,0707);
				endif;
				if($file2['error'] == 0):
					$aryFileInfo2						= $fh->getFileInfo($file2['name']);

					if($j == 1)			{ $strSaveName2	= "{$strSaveTime}_stamp.{$aryFileInfo2['extension']}"; }
					else if($j == 2)	{ $strSaveName2	= "{$strSaveTime}_bank.{$aryFileInfo2['extension']}"; }
					else if($j == 3)	{ $strSaveName2	= "{$strSaveTime}_paper.{$aryFileInfo2['extension']}"; }
					else if($j == 4)	{ $strSaveName2	= "{$strSaveTime}_logo.{$aryFileInfo2['extension']}"; }
					else if($j == 5)	{ $strSaveName2	= "{$strSaveTime}_video.{$aryFileInfo2['extension']}"; }
				endif;
				if($fh->doUploadEasy("{$webUploadPath}/shop/certificates{$j}/{$strSaveName2}", "com_certificates{$j}_file")):
					$fileName2 = $shopRow["SH_COM_CERTIFICATES{$j}_FILE"];
					unlink("{$webUploadPath}/shop/certificates{$j}/{$fileName2}");
					$shopMgr->{"setSH_COM_CERTIFICATES{$j}_FILE"}($strSaveName2);
				endif;
			endfor;

			## STEP 3.
			## 승인여부(입점사)
			if($a_admin_type == "S"):
				$shopMgr->setSH_APPR($shopRow['SH_APPR']);
			endif;

			## STEO 4,
			## 기본정보 업데이트
			$shopMgr->getShopUpdate($db);

			/* 상품 언어 설정 */
//print_r($shopMgr);
			$shopMgr->setP_LNG($strStLng);
			//echo 111;
			$shopMgr->getShopInfoInsert($db);
			//echo 222;
			$shopMgr->getShopInfoUpdate($db);

			$strUrl = "./?menuType=".$strMenuType."&mode=shopModify&shopNo=".$intSH_NO."&lang=".$strStLng.$strLinkPage;

		break;

		case "shopGrade":
			$shopMgr->setSH_NO($intSH_NO);
			$shopRow = $shopMgr->getShopView($db);

			$strSH_INFO_CHECK				= $_POST["info_check"]					? $_POST["info_check"]					: $_REQUEST["info_check"];
			$strSH_INFO_POINT				= $_POST["info_point"]					? $_POST["info_point"]					: $_REQUEST["info_point"];
			$strSH_PROD_CNT					= $_POST["prod_cnt"]					? $_POST["prod_cnt"]					: $_REQUEST["prod_cnt"];
			$strSH_PROD_POINT				= $_POST["prod_point"]					? $_POST["prod_point"]					: $_REQUEST["prod_point"];
			$strSH_WORK_CHECK				= $_POST["work_check"]					? $_POST["work_check"]					: $_REQUEST["work_check"];
			$strSH_WORK_POINT				= $_POST["work_point"]					? $_POST["work_point"]					: $_REQUEST["work_point"];
			$strSH_CERTI_CHECK				= $_POST["certi_check"]					? $_POST["certi_check"]					: $_REQUEST["certi_check"];
			$strSH_CERTI_POINT				= $_POST["certi_point"]					? $_POST["certi_point"]					: $_REQUEST["certi_point"];
			$strSH_GRADE_UNTRUTH			= $_POST["grade_untruth"]				? $_POST["grade_untruth"]				: $_REQUEST["grade_untruth"];
			$strSH_GRADE_UNTRUTH_POINT		= $_POST["grade_untruth_point"]			? $_POST["grade_untruth_point"]			: $_REQUEST["grade_untruth_point"];
			$strSH_PROD_POINT2				= $_POST["prod_point2"]					? $_POST["prod_point2"]					: $_REQUEST["prod_point2"];
			$strSH_ORDER_CHECK				= $_POST["order_check"]					? $_POST["order_check"]					: $_REQUEST["order_check"];
			$strSH_ORDER_POINT				= $_POST["order_point"]					? $_POST["order_point"]					: $_REQUEST["order_point"];
			$strSH_GRADE_CHECK				= $_POST["grade_check"]					? $_POST["grade_check"]					: $_REQUEST["grade_check"];
			$strSH_GRADE_POINT				= $_POST["grade_point"]					? $_POST["grade_point"]					: $_REQUEST["grade_point"];
			$strSH_RATING_CHECK				= $_POST["rating_check"]				? $_POST["rating_check"]				: $_REQUEST["rating_check"];
			$strSH_RATING_POINT				= $_POST["rating_point"]				? $_POST["rating_point"]				: $_REQUEST["rating_point"];
			$strSH_PROD_UNTRUTH				= $_POST["prod_untruth"]				? $_POST["prod_untruth"]				: $_REQUEST["prod_untruth"];
			$strSH_PROD_UNTRUTH_POINT		= $_POST["prod_untruth_point"]			? $_POST["prod_untruth_point"]			: $_REQUEST["prod_untruth_point"];

			$shopMgr->setSH_INFO_CHECK($strSH_INFO_CHECK);
			$shopMgr->setSH_INFO_POINT($strSH_INFO_POINT);
			$shopMgr->setSH_PROD_CNT($strSH_PROD_CNT);
			$shopMgr->setSH_PROD_POINT($strSH_PROD_POINT);
			$shopMgr->setSH_WORK_CHECK($strSH_WORK_CHECK);
			$shopMgr->setSH_WORK_POINT($strSH_WORK_POINT);
			$shopMgr->setSH_CERTI_CHECK($strSH_CERTI_CHECK);
			$shopMgr->setSH_CERTI_POINT($strSH_CERTI_POINT);
			$shopMgr->setSH_GRADE_UNTRUTH($strSH_GRADE_UNTRUTH);
			$shopMgr->setSH_GRADE_UNTRUTH_POINT($strSH_GRADE_UNTRUTH_POINT);
			$shopMgr->setSH_PROD_POINT2($strSH_PROD_POINT2);
			$shopMgr->setSH_ORDER_CHECK($strSH_ORDER_CHECK);
			$shopMgr->setSH_ORDER_POINT($strSH_ORDER_POINT);
			$shopMgr->setSH_GRADE_CHECK($strSH_GRADE_CHECK);
			$shopMgr->setSH_GRADE_POINT($strSH_GRADE_POINT);
			$shopMgr->setSH_RATING_CHECK($strSH_RATING_CHECK);
			$shopMgr->setSH_RATING_POINT($strSH_RATING_POINT);
			$shopMgr->setSH_PROD_UNTRUTH($strSH_PROD_UNTRUTH);
			$shopMgr->setSH_PROD_UNTRUTH_POINT($strSH_PROD_UNTRUTH_POINT);

			$shopGradePoint = $shopMgr->getShopGradePointView($db);

			if($shopGradePoint){
				$shopMgr->getShopGradePointUpdate($db);
			}else{
				$shopMgr->getShopGradePointInsert($db);
			}

			$shopMgr->getShopGrade($db);
			$strUrl = "./?menuType=".$strMenuType."&mode=shopGrade&shopNo=".$intSH_NO.$strLinkPage;

		break;

		case "shopOkCheck":

			require_once MALL_CONF_LIB."EmailMgr.php";
			require_once MALL_CONF_LIB."PostMailMgr.php";
			require_once MALL_CONF_LIB."PostMailLogMgr.php";

			$emailMgr		= new EmailMgr();
			$postMailMgr	= new PostMailMgr();
			$postMailLogMgr	= new PostMailLogMgr();

			$shopMgr->setSH_NO($intSH_NO);
			$shopRow = $shopMgr->getShopView($db);

			$shopMgr->getShopOkCheck($db);

			//ECHO "11";
			/** 입점사 메일발송 시작**/
			//require_once MALL_HOME."/web/shopAdmin/sendmail/_function.lib.inc.php";
			//ECHO "22";
			//require_once MALL_HOME."/web/shopAdmin/sendmail/_postMailField.inc.php";
			//ECHO "33";
			//require_once MALL_HOME."/web/shopAdmin/sendmail/_postMailSetting.inc.php";
//ECHO "44";

			/* 메일 전송 */
			$strMailFromName		= $S_SITE_NM;							// 보내는 사람 이름
			$strMailFromAddr		= $S_SITE_MAIL;							// 보내는 사람 메일
			$strMailTitle			= "축하합니다. 입점신청이 승인되었습니다.";					// 메일 제목
			$strContents			= "입점에 대한 상세 계약 진행 절차는<br><Br>협의를 통해 진행될 예정이며<br><Br>담당자가 직접 전화를 드리도록하겠습니다.";					// 메일 내용
			$strMailToName			= $shopRow[SH_COM_REP_NM];							// 받는 사람 이름
			$strMailToAddr			= $shopRow[SH_COM_MAIL];							// 받는 사람 메일


			$sendMailResult			= sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");
			$sendMailResult			= ($sendMailResult) ? $sendMailResult : 0;
			/* 메일 전송 */


			/* 로그 기록 */
			$postMailLogMgr->setPL_PM_NO($intPM_NO);
			$postMailLogMgr->setPL_TO_M_MAIL($strMailToAddr);
			$postMailLogMgr->setPL_TO_M_NAME($strMailToName);
			$postMailLogMgr->setPL_TO_M_NO($intM_NO);
			$postMailLogMgr->setPL_FROM_M_MAIL($strMailFromAddr);
			$postMailLogMgr->setPL_FROM_M_NAME($strMailFromName);
			$postMailLogMgr->setPL_FROM_M_NO($a_admin_no);
			$postMailLogMgr->setPL_IP(getClientIP());
			$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);
			$postMailLogMgr->setPL_REG_NO($a_admin_no);
			$postMailLogMgr->getPostMailLogInsert($db);
			/* 로그 기록 */

			$postMailMgr->setPM_NO($intPM_NO);
			$postMailMgr->setPM_TOTAL_CNT(1);
			$postMailMgr->getPostMailCntUpdate($db);
			/** 입점사 메일발송 끝**/

			//$strUrl = "./?menuType=".$strMenuType."&mode=shopOkCheck&shopNo=".$intSH_NO.$strLinkPage;
			$strUrl = "./?menuType=".$strMenuType."&mode=shopList&shopNo=".$intSH_NO.$strLinkPage;

		break;

		case "shopNotOk":

				require_once MALL_CONF_LIB."EmailMgr.php";
				require_once MALL_CONF_LIB."PostMailMgr.php";
				require_once MALL_CONF_LIB."PostMailLogMgr.php";

				$emailMgr		= new EmailMgr();
				$postMailMgr	= new PostMailMgr();
				$postMailLogMgr	= new PostMailLogMgr();


				$shopMgr->setSH_NO($intSH_NO);
				$shopRow = $shopMgr->getShopView($db);

				$shopMgr->setSH_APPR_NO_REASON($strSH_APPR_NO_REASON);

				$shopMgr->getShopNotOk($db);

				/** 입점사 메일발송 시작**/
				//require_once "/sendmail/_function.lib.inc.php";
				//require_once "/sendmail/_postMailField.inc.php";
				//require_once "/sendmail/_postMailSetting.inc.php";


				/* 메일 전송 */
				$strMailFromName		= $S_SITE_NM;							// 보내는 사람 이름
 				$strMailFromAddr		= $S_SITE_MAIL;							// 보내는 사람 메일
				$strMailTitle			= "죄송합니다. 입점신청이 미승인되었습니다.";					// 메일 제목
				$strContents			= $strSH_APPR_NO_REASON;					// 메일 내용
				$strMailToName			= $shopRow[SH_COM_REP_NM];							// 받는 사람 이름
				$strMailToAddr			= $shopRow[SH_COM_MAIL];							// 받는 사람 메일

				$sendMailResult			= sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");
				$sendMailResult			= ($sendMailResult) ? $sendMailResult : 0;
				/* 메일 전송 */

				/* 로그 기록 */
				$postMailLogMgr->setPL_PM_NO($intPM_NO);
				$postMailLogMgr->setPL_TO_M_MAIL($strMailToAddr);
				$postMailLogMgr->setPL_TO_M_NAME($strMailToName);
				$postMailLogMgr->setPL_TO_M_NO($intM_NO);
				$postMailLogMgr->setPL_FROM_M_MAIL($strMailFromAddr);
				$postMailLogMgr->setPL_FROM_M_NAME($strMailFromName);
				$postMailLogMgr->setPL_FROM_M_NO($a_admin_no);
				$postMailLogMgr->setPL_IP(getClientIP());
				$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);
				$postMailLogMgr->setPL_REG_NO($a_admin_no);
				$postMailLogMgr->getPostMailLogInsert($db);
				/* 로그 기록 */

				$postMailMgr->setPM_NO($intPM_NO);
				$postMailMgr->setPM_TOTAL_CNT(1);
				$postMailMgr->getPostMailCntUpdate($db);
				/** 입점사 메일발송 끝**/


				//$strUrl = "./?menuType=".$strMenuType."&mode=shopNotOk&shopNo=".$intSH_NO.$strLinkPage;
				echo "<script>parent.goLayoutPopCloseEvent();</script>";
				exit;
		break;

		case "shopFileDelete":
			$shopMgr->setSH_NO($intSH_NO);
			$shopMgr->setSH_FILE_NO($intSH_FILE_NO);
			$shopRow =$shopMgr->getShopView($db);

			if ($shopRow["SH_COM_FILE".$intSH_FILE_NO]){
				$fh->fileDelete("../upload/shop/file".$intSH_FILE_NO."/".$shopRow["SH_COM_FILE".$intSH_FILE_NO]);

				$shopMgr->getShopFileDelete($db);
			}

			$strMsg = $LNG_TRANS_CHAR["CS00018"]; //파일이 삭제되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=shopModify&shopNo=".$intSH_NO.$strLinkPage;
		break;
		case "shopDelete":

			$shopMgr->setSH_NO($intSH_NO);
			$shopRow =$shopMgr->getShopView($db);
			$storeRow = $shopMgr->getStoreView($db);

			$intProdCnt = $shopMgr->getShopPrductCnt($db);
			if ($intProdCnt > 0) {
				goErrMsg("입점사의 상품이 존재합니다.");
				$db->disConnect();
				exit;
			}

			for($i=1;$i<=5;$i++){
				if ($shopRow["SH_COM_FILE".$i]){
					$fh->fileDelete("../upload/shop/file".$i."/".$shopRow["SH_COM_FILE".$i]);
					$shopMgr->getShopFileDelete($db);
				}

				if ($i == "1") $strColName = "ST_LOGO";
				else if ($i == "2") $strColName = "ST_IMG";
				else if ($i == "3") $strColName = "ST_THUMB_IMG";
				if ($storeRow[$strColName]){
					$fh->fileDelete("../upload/shop/store_".$intSH_NO."/design/".$storeRow[$strColName]);
					$shopMgr->getStoreFileDelete($db);
				}
			}

			$shopMgr->getShopDelete($db);
			$shopMgr->getStoreDelete($db);

			$aryShopUserList =$shopMgr->getShopUserList($db);
			if (is_array($aryShopUserList)){
				for($i=0;$i<sizeof($aryShopUserList);$i++){

					$adminMenu->setM_NO($aryShopUserList[$i][M_NO]);
					$adminMenu->setAM_TYPE("S");
					$adminMenu->getDelete($db);

					$shopMgr->setSU_NO($aryShopUserList[$i][SU_NO]);
					$shopMgr->getShopUserDelete($db);
				}
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=shopList".$strLinkPage;

		break;

		case "shopSiteUpdate":
			// 상점정보 업데이트
			// 2013.06.19 kim hee sung 소스 정리 및 오류 수정

			## STEP 1.
			## 기본저보 불러오기
			$shopMgr->setSH_NO($intSH_NO);
			$storeRow = $shopMgr->getStoreView($db);
			$shopMgr->setST_LOGO($storeRow['ST_LOGO']);
			$shopMgr->setST_IMG($storeRow['ST_IMG']);
			$shopMgr->setST_THUMB_IMG($storeRow['ST_THUMB_IMG']);

			## STEO 2,
			## 폴더 생성
			$webUploadPath	= WEB_UPLOAD_PATH;
			$makeDirName	= "{$webUploadPath}/shop/store_{$intSH_NO}";
			if(!is_dir($makeDirName)):
				@mkdir($makeDirName,0707);
				@chmod($makeDirName,0707);
				@mkdir($makeDirName."/design",0707);
				@chmod($makeDirName."/design",0707);
			endif;

			## STEO 3,
			## 파일 삭제
			if($_POST['store_logo_del'])		{ unlink("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$_POST['store_logo_del']}");			$shopMgr->setST_LOGO("");		}
			if($_POST['store_img_del'])			{ unlink("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$_POST['store_img_del']}");			$shopMgr->setST_IMG("");		}
			if($_POST['store_thumb_img_del'])	{ unlink("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$_POST['store_thumb_img_del']}");	$shopMgr->setST_THUMB_IMG("");	}

			## STEO 4,
			## 파일 저장
			$strSaveTime		= date("YmdHis");

			// 로고
			$file				= $_FILES['store_logo'];
			if($file['error'] == 0):
				$aryFileInfo	= $fh->getFileInfo($file['name']);
				$strSaveName	= "{$strSaveTime}_logo.{$aryFileInfo['extension']}";
				if($fh->doUploadEasy("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$strSaveName}", "store_logo")):
					$fileName = $storeRow['ST_LOGO'];
					unlink("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$fileName}");
					$shopMgr->setST_LOGO($strSaveName);
				endif;
			endif;

			// 이미지
			$file				= $_FILES['store_img'];
			if($file['error'] == 0):
				$aryFileInfo	= $fh->getFileInfo($file['name']);
				$strSaveName	= "{$strSaveTime}_img.{$aryFileInfo['extension']}";
				if($fh->doUploadEasy("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$strSaveName}", "store_img")):
					$fileName = $storeRow['ST_IMG'];
					unlink("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$fileName}");
					$shopMgr->setST_IMG($strSaveName);
				endif;
			endif;

			// 썸네일
			$file				= $_FILES['store_thumb_img'];
			if($file['error'] == 0):
				$aryFileInfo	= $fh->getFileInfo($file['name']);
				$strSaveName	= "{$strSaveTime}_thumb.{$aryFileInfo['extension']}";
				if($fh->doUploadEasy("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$strSaveName}", "store_thumb_img")):
					$fileName = $storeRow['ST_THUMB_IMG'];
					unlink("{$webUploadPath}/shop/store_{$storeRow['SH_NO']}/design/{$fileName}");
					$shopMgr->setST_THUMB_IMG($strSaveName);
				endif;
			endif;

			## STEO 5,
			## 상점정보 업데이트
			$shopMgr->getStoreInsertUpdate($db);

			$strUrl = "./?menuType=".$strMenuType."&mode=shopSite&shopNo=".$intSH_NO.$strLinkPage;

		break;
		case "shopSettingUpdate":
			## 입점몰에서 수정시, 특정 데이터 수정 불가.
			if($a_admin_type == "S"):
				$shopMgr->setSH_NO($intSH_NO);
				$storeRow = $shopMgr->getShopView($db);

				$shopMgr->setSH_COM_DEPOSIT($storeRow['SH_COM_DEPOSIT']);		// 계금주
				$shopMgr->setSH_COM_BANK($storeRow['SH_COM_BANK']);				// 은행정보
				$shopMgr->setSH_COM_BANK_NUM($storeRow['SH_COM_BANK_NUM']);		// 계좌정보
				$shopMgr->setSH_COM_PROD_AUTH($storeRow['SH_COM_PROD_AUTH']);	// 상점노출
				$shopMgr->setSH_COM_ACC_PRICE($storeRow['SH_COM_ACC_PRICE']);	// 정산기준가
				$shopMgr->setSH_COM_ACC_RATE($storeRow['SH_COM_ACC_RATE']);		// 정산수수료
				$shopMgr->setSH_COM_DELIVERY($storeRow['SH_COM_DELIVERY']);		// 배송정책
			endif;

			$shopMgr->getShopSettingUpdate($db);
			$strUrl = "./?menuType=".$strMenuType."&mode=shopSetting&shopNo=".$intSH_NO.$strLinkPage;
		break;

		case "storeFileDelete":
			$shopMgr->setSH_NO($intSH_NO);
			$shopMgr->setSH_FILE_NO($intSH_FILE_NO);
			$storeRow =$shopMgr->getStoreView($db);

			if ($intSH_FILE_NO == "1") $strColName = "ST_LOGO";
			else if ($intSH_FILE_NO == "2") $strColName = "ST_IMG";
			else if ($intSH_FILE_NO == "3") $strColName = "ST_THUMB_IMG";

			if ($storeRow[$strColName]){
				$fh->fileDelete("../upload/shop/store_".$intSH_NO."/design/".$storeRow[$strColName]);
				$shopMgr->getStoreFileDelete($db);
			}

			$strMsg = $LNG_TRANS_CHAR["CS00018"]; //파일이 삭제되었습니다.
			$strUrl = "./?menuType=".$strMenuType."&mode=shopSetting&shopNo=".$intSH_NO.$strLinkPage;
		break;

		case "shopUserWrite":

			$shopMgr->setSH_NO($intSH_NO);
			$shopRow =$shopMgr->getShopView($db);

			$settingRow = $memberMgr->getSettingView($db);

			if ($S_MEM_CERITY == "1"){
				$intCount = $memberMgr->getMemberIdCheck($db);
				if ($intCount > 0){
					goErrMsg($LNG_TRANS_CHAR['MS00024']); //"중복된 아이디가 존재합니다."
					exit;
				}

				if ($S_JOIN_NICK_NAME_USE == "Y"){
					$intCount = $memberMgr->getMemberNickNameCheck($db);
					if ($intCount > 0){
						goErrMsg($LNG_TRANS_CHAR["MS00025"]); //"중복된 닉네임이 존재합니다."
						exit;
					}
				}

				/* 불가 ID 체크*/
				$aryRegNoIdList = explode(",",$settingRow[J_NO_ID]);
				for($i=0;$i<sizeof($aryRegNoIdList);$i++){
					if ($aryRegNoIdList[$i] == $strM_ID){
						goErrMsg($LNG_TRANS_CHAR['MS00026']); //"등록할 수 없는 아이디입니다."
						break;
						exit;
					}
				}
			}

			/* 가입시 회원그룹 */
			if ($shopRow[SH_TYPE] == "P")
			{
				$memberMgr->setM_GROUP("003");
			}
			else if ($shopRow[SH_TYPE] == "S")
			{
				$memberMgr->setM_GROUP("004");
			}
			else if ($shopRow[SH_TYPE] == "C")
			{
				$memberMgr->setM_GROUP("005");
			}

			/* 이메일 중복 체크 */
			//그룹별 체크로 변경 2015.06.24
			$intCount = $memberMgr->getMemberMailCheck($db);
			if ($intCount > 0){
				goErrMsg($LNG_TRANS_CHAR["MS00027"]);
				exit;
			}

			/* 추천인 확인 */
			if ($strM_REC_ID){
				$memberMgr->setM_REC_ID("");
			}

			$memberMgr->getMemberInsert($db);
			$intM_NO = $db->getLastInsertID();
			$memberMgr->setM_NO($intM_NO);

			/* 사진 업로드 */
			$strMemberPhotoPath = "../upload/member";
			if ($_FILES["photo"][name]){

				if (!getAllowImgFileExt($_FILES["photo"][name])){
					$memberMgr->setM_PHOTO("");
				} else {

					$strFileName	= $_FILES["photo"][name];
					$strFileTmpName = $_FILES["photo"][tmp_name];
					$intFileSize	= $_FILES["photo"][size];
					$strFileType	= $_FILES["photo"][type];

					$fres = $fh->doUpload("photo_".$intM_NO,"../".$strMemberPhotoPath,$strFileName,$strFileTmpName,$intFileSize,$strFileType);

					if($fres) {
						$memberMgr->setM_PHOTO($fres[file_real_name]);
					}
				}
			}
			/* 사진 업로드 */
			$memberMgr->getMemberAddInsert($db);

			$shopMgr->setM_NO($intM_NO);
			$shopMgr->getShopUserInsert($db);
			$strUrl = "./?menuType=".$strMenuType."&mode=shopUser&shopNo=".$intSH_NO.$strLinkPage;


		break;

		case "shopUserModify":
			// 상점 사용자 등록 정보 수정
			$row = $shopMgr->getShopUserView($db);
			$shopMgr->getShopUserUpdate($db);


			//회원정보수정수 빈값으로 들어가기때문에 넘겨받는값이 없는 필드 추가 2015.03.14
			$memberMgr->setM_NO($row[M_NO]);
			$memberRow = $memberMgr->getMemberView($db);

			$memberMgr->setM_PHONE($memberRow[M_PHONE]);
			$memberMgr->setM_HP($memberRow[M_HP]);
			$memberMgr->setM_ZIP($memberRow[M_ZIP]);
			$memberMgr->setM_ADDR($memberRow[M_ADDR]);
			$memberMgr->setM_ADDR2($memberRow[M_ADDR2]);
			$memberMgr->setM_SMSYN($memberRow[M_SMSYN]);
			$memberMgr->setM_GROUP($memberRow[M_GROUP]);
			$memberMgr->setM_COUNTRY($memberRow[M_COUNTRY]);
			$memberMgr->setM_CITY($memberRow[M_CITY]);
			$memberMgr->setM_STATE($memberRow[M_STATE]);
			$memberMgr->setM_FAX($memberRow[M_FAX]);
			$memberMgr->setM_TEXT($memberRow[M_TEXT]);

			/* 이메일 중복 체크 */
			//그룹별 체크로 변경 2015.06.24
			/*
			$intCount = $memberMgr->getMemberMailCheck($db);
			if ($intCount > 0){
				goErrMsg($LNG_TRANS_CHAR["MS00027"]);
				exit;
			}
			*/
			//회원정보수정 2015.03.14
			$memberMgr->getMemberUpdate($db);



			$adminMenu->setM_NO($row[M_NO]);
			$adminMenu->setAM_TYPE("S");

			## 메뉴 공통 서버 DB 접속
//			$dbMenuConn = mysql_connect("211.115.68.68", "eumshop_comm", "eum!@)(com") or exit('DB Connect Error');
//			mysql_select_db("eumshop_comm", $dbMenuConn) or exit('DB Select Error');
//			mysql_query("SET NAMES utf8");

			$strAM_MN_NO = "";
			//관리자 메뉴 권한 수정 시작
			if(is_Array($aryChkMenuNo)){
				for($i=0;$i<=count($aryChkMenuNo);$i++){

					if($aryChkMenuNo[$i] > 0){

						$intMN_NO		= $aryChkMenuNo[$i];
						$strMN_AUTH_L	= $_POST["mn_auth_l_".$intMN_NO]	? $_POST["mn_auth_l_".$intMN_NO]	: $_REQUEST["mn_auth_l_".$intMN_NO];
						$strMN_AUTH_W	= $_POST["mn_auth_w_".$intMN_NO]	? $_POST["mn_auth_w_".$intMN_NO]	: $_REQUEST["mn_auth_w_".$intMN_NO];
						$strMN_AUTH_M	= $_POST["mn_auth_m_".$intMN_NO]	? $_POST["mn_auth_m_".$intMN_NO]	: $_REQUEST["mn_auth_m_".$intMN_NO];
						$strMN_AUTH_D	= $_POST["mn_auth_d_".$intMN_NO]	? $_POST["mn_auth_d_".$intMN_NO]	: $_REQUEST["mn_auth_d_".$intMN_NO];
						$strMN_AUTH_E	= $_POST["mn_auth_e_".$intMN_NO]	? $_POST["mn_auth_e_".$intMN_NO]	: $_REQUEST["mn_auth_e_".$intMN_NO];

						$strMN_AUTH_C	= $_POST["mn_auth_c_".$intMN_NO]	? $_POST["mn_auth_c_".$intMN_NO]	: $_REQUEST["mn_auth_c_".$intMN_NO];
						$strMN_AUTH_S	= $_POST["mn_auth_s_".$intMN_NO]	? $_POST["mn_auth_s_".$intMN_NO]	: $_REQUEST["mn_auth_s_".$intMN_NO];
						$strMN_AUTH_P	= $_POST["mn_auth_p_".$intMN_NO]	? $_POST["mn_auth_p_".$intMN_NO]	: $_REQUEST["mn_auth_p_".$intMN_NO];
						$strMN_AUTH_U	= $_POST["mn_auth_u_".$intMN_NO]	? $_POST["mn_auth_u_".$intMN_NO]	: $_REQUEST["mn_auth_u_".$intMN_NO];

						$strMN_AUTH_E1	= $_POST["mn_auth_e1_".$intMN_NO]	? $_POST["mn_auth_e1_".$intMN_NO]	: $_REQUEST["mn_auth_e1_".$intMN_NO];
						$strMN_AUTH_E2	= $_POST["mn_auth_e2_".$intMN_NO]	? $_POST["mn_auth_e2_".$intMN_NO]	: $_REQUEST["mn_auth_e2_".$intMN_NO];
						$strMN_AUTH_E3	= $_POST["mn_auth_e3_".$intMN_NO]	? $_POST["mn_auth_e3_".$intMN_NO]	: $_REQUEST["mn_auth_e3_".$intMN_NO];
						$strMN_AUTH_E4	= $_POST["mn_auth_e4_".$intMN_NO]	? $_POST["mn_auth_e4_".$intMN_NO]	: $_REQUEST["mn_auth_e4_".$intMN_NO];
						$strMN_AUTH_E5	= $_POST["mn_auth_e5_".$intMN_NO]	? $_POST["mn_auth_e5_".$intMN_NO]	: $_REQUEST["mn_auth_e5_".$intMN_NO];

						if (!$strMN_AUTH_L) $strMN_AUTH_L = "N";
						if (!$strMN_AUTH_W) $strMN_AUTH_W = "N";
						if (!$strMN_AUTH_M) $strMN_AUTH_M = "N";
						if (!$strMN_AUTH_D) $strMN_AUTH_D = "N";
						if (!$strMN_AUTH_E) $strMN_AUTH_E = "N";
						if (!$strMN_AUTH_C) $strMN_AUTH_C = "N";
						if (!$strMN_AUTH_S) $strMN_AUTH_S = "N";
						if (!$strMN_AUTH_P) $strMN_AUTH_P = "N";
						if (!$strMN_AUTH_U) $strMN_AUTH_U = "N";

						if (!$strMN_AUTH_E1) $strMN_AUTH_E1 = "N";
						if (!$strMN_AUTH_E2) $strMN_AUTH_E2 = "N";
						if (!$strMN_AUTH_E3) $strMN_AUTH_E3 = "N";
						if (!$strMN_AUTH_E4) $strMN_AUTH_E4 = "N";
						if (!$strMN_AUTH_E5) $strMN_AUTH_E5 = "N";

						if ($intMN_NO >= 5000) {

							// 커뮤니티 관련 권한 설정
							$strMN_CODE		= substr($intMN_NO,1);
							$strMN_HIGH_01	= "006";
							$strMN_HIGH_02  = "";
							if ($intMN_NO >= 5901 && $intMN_NO < 6000) $strMN_HIGH_02 = "001";
							else if ($intMN_NO >= 5000 && $intMN_NO < 5900) $strMN_HIGH_02	= "002";

						} else {

							## 공통 서버 TABLE 접속 정보 가지고 오기
							$menuQry		= "SELECT * FROM SHOP_LANG_MENU WHERE MN_NO = {$intMN_NO}";
							$menuRow		= $db->getSelect($menuQry);

//							$menuQry		= "SELECT * FROM SHOP_LANG_MENU WHERE MN_NO = {$intMN_NO}";
//							$menuRet		= mysql_query($menuQry,$dbMenuConn);
//							$menuRow		= mysql_fetch_array($menuRet);

							$strMN_CODE		= $menuRow['MN_CODE'];
							$strMN_HIGH_01	= $menuRow['MN_HIGH_01'];
							$strMN_HIGH_02	= $menuRow['MN_HIGH_02'];

//							$xml_string = file_get_contents(MALL_HOME."/api/xml/shop.lang.menu.view.xml.php?no=".$intMN_NO);
//							$menuRow = simplexml_load_string($xml_string);
//
//							$strMN_CODE		= $menuRow->ITEM[0]->MN_CODE;
//							$strMN_HIGH_01	= $menuRow->ITEM[0]->MN_HIGH_01;
//							$strMN_HIGH_02	= $menuRow->ITEM[0]->MN_HIGH_02;
						}

						$adminMenu->setMN_NO($intMN_NO);
						$adminMenu->setMN_CODE(strval($strMN_CODE));
						$adminMenu->setMN_HIGH_01(strval($strMN_HIGH_01));
						$adminMenu->setMN_HIGH_02(strval($strMN_HIGH_02));
						$adminMenu->setM_NO($intM_NO);
						$adminMenu->setAM_L($strMN_AUTH_L);
						$adminMenu->setAM_W($strMN_AUTH_W);
						$adminMenu->setAM_M($strMN_AUTH_M);
						$adminMenu->setAM_D($strMN_AUTH_D);
						$adminMenu->setAM_E($strMN_AUTH_E);
						$adminMenu->setAM_C($strMN_AUTH_C);
						$adminMenu->setAM_S($strMN_AUTH_S);
						$adminMenu->setAM_P($strMN_AUTH_P);
						$adminMenu->setAM_U($strMN_AUTH_U);
						$adminMenu->setAM_E1($strMN_AUTH_E1);
						$adminMenu->setAM_E2($strMN_AUTH_E2);
						$adminMenu->setAM_E3($strMN_AUTH_E3);
						$adminMenu->setAM_E4($strMN_AUTH_E4);
						$adminMenu->setAM_E5($strMN_AUTH_E5);

						$adminMenu->getInsertUpdate($db);

						if ($i > 0) $strAM_MN_NO .= ",";
						$strAM_MN_NO .= $intMN_NO;
					}
				}
			}

			if ($strAM_MN_NO) {
				$adminMenu->setAM_MN_NO($strAM_MN_NO);
				$adminMenu->getDelete($db);
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=shopUserModify&shopNo=".$intSH_NO."&shopUserNo=".$intSU_NO.$strLinkPage;
		break;


		case "shopUserDelete":
			$row = $shopMgr->getShopUserView($db);

			$adminMenu->setM_NO($row[M_NO]);
			$adminMenu->setAM_TYPE("S");
			$adminMenu->getDelete($db);

			$shopMgr->getShopUserDelete($db);
			$strUrl = "./?menuType=".$strMenuType."&mode=shopUser&shopNo=".$intSH_NO.$strLinkPage;

		break;

		case "prodAllAppr":
			if (is_array($aryChkNo)){
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {

						$strP_CODE = $aryChkNo[$p];

						$productMgr->setP_CODE($strP_CODE);
						$productMgr->setP_LNG($strStLng);
						$prodRow = $productMgr->getProdView($db);

						/*if($prodRow[P_VIEW]=='N')
						{
							$strP_View = 'Y';
						}else{
							$strP_View = 'N';
						}*/
						//$productMgr->setP_SALE_PRICE(STR_REPLACE(",","",$intP_SALE_PRICE));
						//$productMgr->setP_CONSUMER_PRICE(STR_REPLACE(",","",$intP_CONSUMER_PRICE));
						//$productMgr->setP_STOCK_PRICE(STR_REPLACE(",","",$intP_STOCK_PRICE));
						//$productMgr->setP_POINT(STR_REPLACE(",","",$intP_POINT));
						//$productMgr->setP_QTY($intP_QTY);
						$productMgr->setP_APPR('Y');
						$productMgr->getProdApprUpdate($db);
					}
				}
			}

			//$strUrl = "./?menuType=".$strMenuType."&mode=shopProduct&shopNo={$intSH_NO}&".$strLinkPage;;
			$strUrl = $_SERVER['HTTP_REFERER'];

/*			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage";
			$strLinkPage .= "&searchShopNo=$strSearchShopNo";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodList&".$strLinkPage;
*/
		break;

		case "prodAllDelete":

			if (is_array($aryChkNo)){
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {

						$strP_CODE = $aryChkNo[$p];
						$productMgr->setP_CODE($strP_CODE);

						/* 주문 상품 체크 */
						$intProdOrderCnt = $productMgr->getProdOrderCount($db);
						if ($intProdOrderCnt > 0){
							continue;
						}

						/* 이미지 삭제 */
						$strProductImgPath = "upload/product/".substr($strP_CODE,0,8);
						for($i=1;$i<=28;$i++){

							if ($i == 1) {
								$strProdImgType = "main";
							} else if ($i == 2){
								$strProdImgType = "list";
							} else if ($i == 3){
								$strProdImgType = "view";
							} else if ($i == 4){
								$strProdImgType = "large";
							} else if ($i == 5){
								$strProdImgType = "mobile_main";
							} else if ($i == 6){
								$strProdImgType = "mobile_view";
							} else if ($i >= 7 && $i <= 17){
								$strProdImgType = "view".($i-5);
							} else if ($i >= 18 && $i <= 28){
								$strProdImgType = "large".($i-16);
							}

							$productMgr->setPM_TYPE($strProdImgType);
							$aryProdImg[$i] = $productMgr->getProdImg($db);

							if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){
								if (substr($aryProdImg[$i][0][PM_REAL_NAME],0,4) != "http"){
									$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);
								}

								$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
								$productMgr->getProdImgDelete($db);
							}
						}

						$productMgr->getProdIconAllDelete($db);

						/* 상품 ITEM 국가별 삭제 */
						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setPI_LNG($arySiteUseLng[$k]);
								$productMgr->getProdItemLngDelete($db);
							}
						}
						$productMgr->getProdItemAllDelete($db);


						/* 옵션 국가별 삭제 */
						$productMgr->setPO_TYPE("O");
						$aryProdOpt = $productMgr->getProdOpt($db);
						if (is_array($aryProdOpt)){
							for($i=0;$i<sizeof($aryProdOpt);$i++){
								if ($aryProdOpt[$i][PO_NO] > 0){
									$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

									for($k=0;$k<sizeof($arySiteUseLng);$k++){
										if ($arySiteUseLng[$k]){
											$productMgr->setP_LNG($arySiteUseLng[$k]);
											$productMgr->getProdOptAttrLangAllDelete($db);
										}
									}
									$productMgr->getProdOptAttrAllDelete($db);
								}
							}
						}

						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdOptLangAllDelete($db);
							}
						}
						$productMgr->getProdOptAllDelete($db);

						$productMgr->setPO_TYPE("A");
						$aryProdAddOpt = $productMgr->getProdOpt($db);
						if (is_array($aryProdAddOpt)){
							for($i=0;$i<sizeof($aryProdAddOpt);$i++){
								if ($aryProdAddOpt[$i][PO_NO] > 0){
									$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

									for($k=0;$k<sizeof($arySiteUseLng);$k++){
										if ($arySiteUseLng[$k]){
											$productMgr->setP_LNG($arySiteUseLng[$k]);
											$productMgr->getProdAddOptAttrLangAllDelete($db);
										}
									}
									$productMgr->getProdAddOptAllDelete($db);
								}
							}
						}
						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdOptLangAllDelete($db);
							}
						}
						$productMgr->getProdOptLangAllDelete($db);


						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdInfoLngDelete($db);
							}
						}

						$productMgr->getProdDelete($db);
					}
				}
			}

			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage&lang=$strStLng";
			$strLinkPage .= "&searchShopNo=$strSearchShopNo";

			$strUrl = "./?menuType=".$strMenuType."&mode=shopProduct&".$strLinkPage;

		break;

		case "prodDelete":

			$productMgr->setP_CODE($strP_CODE);

			/* 주문 상품 체크 */
			$intProdOrderCnt = $productMgr->getProdOrderCount($db);
			if ($intProdOrderCnt > 0){
				goErrMsg("주문된 상품이 존재합니다.");
				exit;
			}

			/* 이미지 삭제 */
			$strProductImgPath = "upload/product/".substr($strP_CODE,0,8);
			for($i=1;$i<=28;$i++){

				if ($i == 1) {
					$strProdImgType = "main";
				} else if ($i == 2){
					$strProdImgType = "list";
				} else if ($i == 3){
					$strProdImgType = "view";
				} else if ($i == 4){
					$strProdImgType = "large";
				} else if ($i == 5){
					$strProdImgType = "mobile_main";
				} else if ($i == 6){
					$strProdImgType = "mobile_view";
				} else if ($i >= 7 && $i <= 17){
					$strProdImgType = "view".($i-5);
				} else if ($i >= 18 && $i <= 28){
					$strProdImgType = "large".($i-16);
				}

				$productMgr->setPM_TYPE($strProdImgType);
				$aryProdImg[$i] = $productMgr->getProdImg($db);

				if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){

					if (SUBSTR($aryProdImg[$i][0][PM_REAL_NAME],0,4) != "http"){
						$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);
					}

					$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
					$productMgr->getProdImgDelete($db);
				}
			}

			$productMgr->getProdIconAllDelete($db);

			/* 상품 ITEM 국가별 삭제 */
			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setPI_LNG($arySiteUseLng[$k]);
					$productMgr->getProdItemLngDelete($db);
				}
			}
			$productMgr->getProdItemAllDelete($db);


			/* 옵션 국가별 삭제 */
			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);
			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdOptAttrLangAllDelete($db);
							}
						}
						$productMgr->getProdOptAttrAllDelete($db);
					}
				}
			}

			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setP_LNG($arySiteUseLng[$k]);
					$productMgr->getProdOptLangAllDelete($db);
				}
			}
			$productMgr->getProdOptAllDelete($db);

			$productMgr->setPO_TYPE("A");
			$aryProdAddOpt = $productMgr->getProdOpt($db);
			if (is_array($aryProdAddOpt)){
				for($i=0;$i<sizeof($aryProdAddOpt);$i++){
					if ($aryProdAddOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdAddOptAttrLangAllDelete($db);
							}
						}
						$productMgr->getProdAddOptAllDelete($db);
					}
				}
			}
			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setP_LNG($arySiteUseLng[$k]);
					$productMgr->getProdOptLangAllDelete($db);
				}
			}
			$productMgr->getProdOptLangAllDelete($db);


			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setP_LNG($arySiteUseLng[$k]);
					$productMgr->getProdInfoLngDelete($db);
				}
			}

			$productMgr->getProdDelete($db);

			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage&lang=$strStLng";
			$strLinkPage .= "&searchShopNo=$strSearchShopNo";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodList&".$strLinkPage;
		break;

	}
	goUrl('',$strUrl);
?>