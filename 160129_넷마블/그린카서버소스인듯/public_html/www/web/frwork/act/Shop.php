<?

	require_once MALL_CONF_LIB."ShopMgr.php";
	require_once "{$S_DOCUMENT_ROOT}/conf/site_skin_product.conf.inc.php";
	require_once "{$S_DOCUMENT_ROOT}/conf/category.inc.php";


	// 이미지 관련 함수.
	require_once "{$S_DOCUMENT_ROOT}www/classes/image/ImageFunc.class.php";

	$shopMgr = new ShopMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	//넘겨받는 값이 없어서 사업자로 임의지정;
	$strSH_TYPE  = 'C';
	//$strSH_TYPE					= $_POST["shop_type"]					? $_POST["shop_type"]					: $_REQUEST["shop_type"];
	$strSH_COM_TYPE					= $_POST["com_type"]					? $_POST["com_type"]					: $_REQUEST["com_type"];
	$strSH_COM_NAME					= $_POST["com_name"]					? $_POST["com_name"]					: $_REQUEST["com_name"];
	$strSH_COM_REP_NM				= $_POST["com_rep_nm"]					? $_POST["com_rep_nm"]					: $_REQUEST["com_rep_nm"];
	$strSH_COM_PHONE				= $_POST["com_phone"]					? $_POST["com_phone"]					: $_REQUEST["com_phone"];
	$strSH_COM_FAX					= $_POST["com_fax"]						? $_POST["com_fax"]						: $_REQUEST["com_fax"];
	$strSH_COM_MAIL					= $_POST["com_mail"]					? $_POST["com_mail"]					: $_REQUEST["com_mail"];
	$strSH_COM_UPTAE				= $_POST["com_uptae"]					? $_POST["com_uptae"]					: $_REQUEST["com_uptae"];
	$strSH_COM_UPJONG				= $_POST["com_upjong"]					? $_POST["com_upjong"]					: $_REQUEST["com_upjong"];
	$strSH_COM_ADDR					= $_POST["com_addr"]					? $_POST["com_addr"]					: $_REQUEST["com_addr"];
	$strSH_COM_ADDR2				= $_POST["com_addr2"]					? $_POST["com_addr2"]					: $_REQUEST["com_addr2"];	//20150710 상세주소 추가 kjp
	$strSH_COM_DEPOSIT				= $_POST["com_deposit"]					? $_POST["com_deposit"]					: $_REQUEST["com_deposit"];
	$strSH_COM_BANK					= $_POST["com_bank"]					? $_POST["com_bank"]					: $_REQUEST["com_bank"];
	$strSH_COM_BANK_NUM				= $_POST["com_bank_num"]				? $_POST["com_bank_num"]				: $_REQUEST["com_bank_num"];
	$strSH_COM_ACC_PRICE			= $_POST["com_acc_price"]				? $_POST["com_acc_price"]				: $_REQUEST["com_acc_price"];
	$intSH_COM_ACC_RATE				= $_POST["com_acc_rate"]				? $_POST["com_acc_rate"]				: $_REQUEST["com_acc_rate"];
	$strSH_APPR						= $_POST["shop_appr"]					? $_POST["shop_appr"]					: $_REQUEST["shop_appr"];


	$strSH_COM_NUM1_1				= $_POST["com_num1_1"]					? $_POST["com_num1_1"]					: $_REQUEST["com_num1_1"];
	$strSH_COM_NUM1_2				= $_POST["com_num1_2"]					? $_POST["com_num1_2"]					: $_REQUEST["com_num1_2"];
	$strSH_COM_NUM1_3				= $_POST["com_num1_3"]					? $_POST["com_num1_3"]					: $_REQUEST["com_num1_3"];

	$strSH_COM_NUM2_1				= $_POST["com_num2_1"]					? $_POST["com_num2_1"]					: $_REQUEST["com_num2_1"];
	$strSH_COM_NUM2_2				= $_POST["com_num2_2"]					? $_POST["com_num2_2"]					: $_REQUEST["com_num2_2"];
	$strSH_COM_NUM2_3				= $_POST["com_num2_3"]					? $_POST["com_num2_3"]					: $_REQUEST["com_num2_3"];

	$strSH_COM_ZIP1					= $_POST["com_zip1"]					? $_POST["com_zip1"]					: $_REQUEST["com_zip1"];
	$strSH_COM_ZIP2					= $_POST["com_zip2"]					? $_POST["com_zip2"]					: $_REQUEST["com_zip2"];

	$strSH_COM_PHONE1				= $_POST["com_phone1"]					? $_POST["com_phone1"]					: $_REQUEST["com_phone1"];
	$strSH_COM_PHONE2				= $_POST["com_phone2"]					? $_POST["com_phone2"]					: $_REQUEST["com_phone2"];
	$strSH_COM_PHONE3				= $_POST["com_phone3"]					? $_POST["com_phone3"]					: $_REQUEST["com_phone3"];
	$strSH_COM_FAX1					= $_POST["com_fax1"]					? $_POST["com_fax1"]					: $_REQUEST["com_fax1"];
	$strSH_COM_FAX2					= $_POST["com_fax2"]					? $_POST["com_fax2"]					: $_REQUEST["com_fax2"];
	$strSH_COM_FAX3					= $_POST["com_fax3"]					? $_POST["com_fax3"]					: $_REQUEST["com_fax3"];

	$strSH_COM_DELIVERY				= $_POST["com_delivery"]				? $_POST["com_delivery"]				: $_REQUEST["com_delivery"];
	$intSH_COM_DELIVERY_ST_PRICE	= $_POST["com_delivery_st_price"]		? $_POST["com_delivery_st_price"]		: $_REQUEST["com_delivery_st_price"];
	$intSH_COM_DELIVERY_PRICE		= $_POST["com_delivery_price"]			? $_POST["com_delivery_price"]			: $_REQUEST["com_delivery_price"];
	$arySH_COM_DELIVERY_COR			= $_POST["com_delivery_cor"]			? $_POST["com_delivery_cor"]			: $_REQUEST["com_delivery_cor"];
	$strSH_COM_DELIVERY_FREE		= $_POST["com_delivery_free"]			? $_POST["com_delivery_free"]			: $_REQUEST["com_delivery_free"];
	$strSH_COM_DEVLIERY_PROD		= $_POST["com_devliery_prod"]			? $_POST["com_devliery_prod"]			: $_REQUEST["com_devliery_prod"];
	$strSH_COM_DELIVERY_AREA		= $_POST["com_delivery_area"]			? $_POST["com_delivery_area"]			: $_REQUEST["com_delivery_area"];
	$strSH_COM_DELIVERY_TEXT		= $_POST["com_delivery_text"]			? $_POST["com_delivery_text"]			: $_REQUEST["com_delivery_text"];

	$strSH_COM_PROD_AUTH			= $_POST["com_prod_auth"]				? $_POST["com_prod_auth"]				: $_REQUEST["com_prod_auth"];

	## 상점정보


	$strSH_COM_CATEGORY				= $_POST["com_category"]				? $_POST["com_category"]			: $_REQUEST["com_category"];

	$strSH_COM_COUNTRY				= $_POST["com_country"]					? $_POST["com_country"]				: $_REQUEST["com_country"];


	$strSH_COM_SITE					= $_POST["com_site"]					? $_POST["com_site"]				: $_REQUEST["com_site"];
	$intSH_COM_FOUNDED				= $_POST["com_founded"]					? $_POST["com_founded"]				: $_REQUEST["com_founded"];
	$intSH_COM_NUMBER				= $_POST["com_number"]					? $_POST["com_number"]				: $_REQUEST["com_number"];
	$intSH_COM_TOTAL_SALE			= $_POST["com_total_sale"]				? $_POST["com_total_sale"]			: $_REQUEST["com_total_sale"];
	$intSH_COM_RATE					= $_POST["com_rate"]					? $_POST["com_rate"]				: $_REQUEST["com_rate"];
	$intSH_COM_TOTAL_PRODUCTION		= $_POST["com_total_production"]		? $_POST["com_total_production"]	: $_REQUEST["com_total_production"];
	$intSH_COM_COUNTRY1				= $_POST["com_country1"]				? $_POST["com_country1"]			: $_REQUEST["com_country1"];
	$intSH_COM_COUNTRY2				= $_POST["com_country2"]				? $_POST["com_country2"]			: $_REQUEST["com_country2"];
	$intSH_COM_COUNTRY3				= $_POST["com_country3"]				? $_POST["com_country3"]			: $_REQUEST["com_country3"];
	$intSH_COM_COUNTRY4				= $_POST["com_country4"]				? $_POST["com_country4"]			: $_REQUEST["com_country4"];
	$intSH_COM_COUNTRY5				= $_POST["com_country5"]				? $_POST["com_country5"]			: $_REQUEST["com_country5"];
	$intSH_COM_COUNTRY6				= $_POST["com_country6"]				? $_POST["com_country6"]			: $_REQUEST["com_country6"];
	$intSH_COM_COUNTRY7				= $_POST["com_country7"]				? $_POST["com_country7"]			: $_REQUEST["com_country7"];
	$intSH_COM_COUNTRY8				= $_POST["com_country8"]				? $_POST["com_country8"]			: $_REQUEST["com_country8"];
	$intSH_COM_COUNTRY9				= $_POST["com_country9"]				? $_POST["com_country9"]			: $_REQUEST["com_country9"];
	$intSH_COM_COUNTRY10			= $_POST["com_country10"]				? $_POST["com_country10"]			: $_REQUEST["com_country10"];
	$intSH_COM_COUNTRY11			= $_POST["com_country11"]				? $_POST["com_country11"]			: $_REQUEST["com_country11"];
	$intSH_COM_COUNTRY12			= $_POST["com_country12"]				? $_POST["com_country12"]			: $_REQUEST["com_country12"];
	$intSH_COM_COUNTRY13			= $_POST["com_country13"]				? $_POST["com_country13"]			: $_REQUEST["com_country13"];
	$intSH_COM_COUNTRY14			= $_POST["com_country14"]				? $_POST["com_country14"]			: $_REQUEST["com_country14"];
	$strSH_COM_LOCAL				= $_POST["com_local"]					? $_POST["com_local"]				: $_REQUEST["com_local"];
	$strSH_COM_SIZE					= $_POST["com_size"]					? $_POST["com_size"]				: $_REQUEST["com_size"];
	$intSH_COM_RD					= $_POST["com_rd"]						? $_POST["com_rd"]					: $_REQUEST["com_rd"];
	$strSH_COM_CATE					= $_POST["com_cate"]					? $_POST["com_cate"]				: $_REQUEST["com_cate"];

	$strSH_COM_CERTIFICATES1		= $_POST["com_certificates1"]			? $_POST["com_certificates1"]		: $_REQUEST["com_certificates1"];
	$strSH_COM_CERTIFICATES2		= $_POST["com_certificates2"]			? $_POST["com_certificates2"]		: $_REQUEST["com_certificates2"];
	$strSH_COM_CERTIFICATES3		= $_POST["com_certificates3"]			? $_POST["com_certificates3"]		: $_REQUEST["com_certificates3"];
	$strSH_COM_CERTIFICATES4		= $_POST["com_certificates4"]			? $_POST["com_certificates4"]		: $_REQUEST["com_certificates4"];
	$strSH_COM_CERTIFICATES5		= $_POST["com_certificates5"]			? $_POST["com_certificates5"]		: $_REQUEST["com_certificates5"];

	$strSH_COM_INTRO1				= $_POST["com_intro1"]					? $_POST["com_intro1"]				: $_REQUEST["com_intro1"];
	$strSH_COM_INTRO2				= $_POST["com_intro2"]					? $_POST["com_intro2"]				: $_REQUEST["com_intro2"];



	$strST_NAME						= $_POST["store_name"]					? $_POST["store_name"]				: $_REQUEST["store_name"];
	$strST_NAME_ENG					= $_POST["store_name_eng"]				? $_POST["store_name_eng"]			: $_REQUEST["store_name_eng"];
	$strST_TEXT						= $_POST["store_text"]					? $_POST["store_text"]				: $_REQUEST["store_text"];
	$strST_MEMO						= $_POST["store_memo"]					? $_POST["store_memo"]				: $_REQUEST["store_memo"];


	$strSH_COM_CITY					= $_POST["com_city"]					? $_POST["com_city"]				: $_REQUEST["com_city"];
	$strSH_COM_STATE_1				= $_POST["com_state_1"]					? $_POST["com_state_1"]				: $_REQUEST["com_state_1"];
	$strSH_COM_STATE_2				= $_POST["com_state_2"]					? $_POST["com_state_2"]				: $_REQUEST["com_state_2"];


	//미국일때 STATE 값 변경
	if($strSH_COM_COUNTRY == 'US')
	{
		$strSH_COM_STATE = $strSH_COM_STATE_2;
	}
	else
	{
		$strSH_COM_STATE = $strSH_COM_STATE_1;
	}
// 2014.09.11 kim hee sung 다국어 입력방식 변경으로 수정
//	$strSH_COM_NUM		= $strSH_COM_NUM1_1."-".$strSH_COM_NUM1_2."-".$strSH_COM_NUM1_3;
//	$strSH_COM_NUM2		= $strSH_COM_NUM2_1."-".$strSH_COM_NUM2_2."-".$strSH_COM_NUM2_3;
//	$strSH_COM_ZIP		= $strSH_COM_ZIP1."-".$strSH_COM_ZIP2;
//	$strSH_COM_PHONE	= $strSH_COM_PHONE1."-".$strSH_COM_PHONE2."-".$strSH_COM_PHONE3;
//	$strSH_COM_FAX		= $strSH_COM_FAX1."-".$strSH_COM_FAX2."-".$strSH_COM_FAX3;

	if($strSH_COM_COUNTRY == 'KR'){
		$strSH_COM_NUM = $strSH_COM_NUM1_1;
		$strSH_COM_NUM2 = $strSH_COM_NUM2_1;
		$strSH_COM_ZIP = $strSH_COM_ZIP1;
		$strSH_COM_PHONE = $strSH_COM_PHONE1;
		$strSH_COM_FAX = $strSH_COM_FAX1;
		if($strSH_COM_NUM1_1 && $strSH_COM_NUM1_2 && $strSH_COM_NUM1_3) { $strSH_COM_NUM = "{$strSH_COM_NUM1_1}-{$strSH_COM_NUM1_2}-{$strSH_COM_NUM1_3}"; }
		if($strSH_COM_NUM2_1 && $strSH_COM_NUM2_2 && $strSH_COM_NUM2_3) { $strSH_COM_NUM2 = "{$strSH_COM_NUM2_1}-{$strSH_COM_NUM2_2}-{$strSH_COM_NUM2_3}"; }
		if($strSH_COM_ZIP1 && $strSH_COM_ZIP2) { $strSH_COM_ZIP = "{$strSH_COM_ZIP1}-{$strSH_COM_ZIP2}"; }
		if($strSH_COM_PHONE1 && $strSH_COM_PHONE2 && $strSH_COM_PHONE3) { $strSH_COM_PHONE = "{$strSH_COM_PHONE1}-{$strSH_COM_PHONE2}-{$strSH_COM_PHONE3}"; }
		if($strSH_COM_FAX1 && $strSH_COM_FAX2 && $strSH_COM_FAX3) { $strSH_COM_FAX = "{$strSH_COM_FAX1}-{$strSH_COM_FAX2}-{$strSH_COM_FAX3}"; }
	}else{
		$strSH_COM_PHONE = $strSH_COM_PHONE;
		$strSH_COM_FAX = $strSH_COM_FAX;
	}



	/* 무료/상품별 배송정책은 현재의 쇼핑몰 기준을 따른다. */
	if (!$strSH_COM_DELIVERY_FREE) $strSH_COM_DELIVERY_FREE = "1";
	if (!$strSH_COM_DEVLIERY_PROD) $strSH_COM_DEVLIERY_PROD = "1";
	if (!$strSH_COM_DELIVERY) $strSH_COM_DELIVERY = "C";
	if (!$strSH_COM_PROD_AUTH) $strSH_COM_PROD_AUTH = "Y";
	if (!$strSH_COM_ACC_PRICE) $strSH_COM_ACC_PRICE = "P";

	$strSH_TYPE					= strTrim($strSH_TYPE,1);
	$strSH_COM_TYPE				= strTrim($strSH_COM_TYPE,1);
	$strSH_COM_NUM				= strTrim($strSH_COM_NUM,20);
	$strSH_COM_NAME				= strTrim($strSH_COM_NAME,100);
	$strSH_COM_REP_NM			= strTrim($strSH_COM_REP_NM,30);
	$strSH_COM_PHONE			= strTrim($strSH_COM_PHONE,30);
	$strSH_COM_FAX				= strTrim($strSH_COM_FAX,30);
	$strSH_COM_MAIL				= strTrim($strSH_COM_MAIL,30);
	$strSH_COM_UPTAE			= strTrim($strSH_COM_UPTAE,50);
	$strSH_COM_UPJONG			= strTrim($strSH_COM_UPJONG,50);
	$strSH_COM_NUM2				= strTrim($strSH_COM_NUM2,20);
	$strSH_COM_ZIP				= strTrim($strSH_COM_ZIP,10);
	$strSH_COM_ADDR				= strTrim($strSH_COM_ADDR,150);
	$strSH_COM_ADDR2			= strTrim($strSH_COM_ADDR2,150);
	$strSH_COM_CITY				= strTrim($strSH_COM_CITY,150);
	$strSH_COM_STATE			= strTrim($strSH_COM_STATE,150);
	$strSH_COM_DEPOSIT			= strTrim($strSH_COM_DEPOSIT,30);
	$strSH_COM_BANK				= strTrim($strSH_COM_BANK,10);
	$strSH_COM_BANK_NUM			= strTrim($strSH_COM_BANK_NUM,30);
	$strSH_COM_ACC_PRICE		= strTrim($strSH_COM_ACC_PRICE,1);
	$strSH_APPR					= strTrim($strSH_APPR,1);

	$strSH_COM_DELIVERY			= strTrim($strSH_COM_DELIVERY,1);
	$strSH_COM_DELIVERY_TYPE	= strTrim($strSH_COM_DELIVERY_TYPE,1);
//	$strSH_COM_DELIVERY_COR		= strTrim($strSH_COM_DELIVERY_COR,150);
	$strSH_COM_DELIVERY_FREE	= strTrim($strSH_COM_DELIVERY_FREE,1);
	$strSH_COM_DEVLIERY_PROD	= strTrim($strSH_COM_DEVLIERY_PROD,1);
	$strSH_COM_DELIVERY_AREA	= strTrim($strSH_COM_DELIVERY_AREA,0,"N");
	$strSH_COM_DELIVERY_TEXT	= strTrim($strSH_COM_DELIVERY_TEXT,0);

	## 상점정보
	$strST_NAME		= strTrim($strST_NAME,100);
	$strST_NAME_ENG	= strTrim($strST_NAME_ENG,100);
	$strST_TEXT		= strTrim($strST_TEXT,"","N");
	$strST_MEMO		= strTrim($strST_MEMO,0,"");

	if (is_array($arySH_COM_DELIVERY_COR)){
		$strSH_COM_DELIVERY_COR = "";
		foreach($arySH_COM_DELIVERY_COR as $key => $val){
			$strSH_COM_DELIVERY_COR .= $val.",";
		}

		$strSH_COM_DELIVERY_COR = substr($strSH_COM_DELIVERY_COR,0,strlen($strSH_COM_DELIVERY_COR)-1);
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

	$shopMgr->setSH_COM_NUM2($strSH_COM_NUM2);
	$shopMgr->setSH_COM_ZIP($strSH_COM_ZIP);
	$shopMgr->setSH_COM_ADDR($strSH_COM_ADDR);
	$shopMgr->setSH_COM_ADDR2($strSH_COM_ADDR2);
	$shopMgr->setSH_COM_DEPOSIT($strSH_COM_DEPOSIT);
	$shopMgr->setSH_COM_BANK($strSH_COM_BANK);
	$shopMgr->setSH_COM_BANK_NUM($strSH_COM_BANK_NUM);
	$shopMgr->setSH_COM_ACC_PRICE($strSH_COM_ACC_PRICE);
	$shopMgr->setSH_COM_ACC_RATE($intSH_COM_ACC_RATE);
	$shopMgr->setSH_COM_DELIVERY($strSH_COM_DELIVERY);
	$shopMgr->setSH_COM_DELIVERY_ST_PRICE($intSH_COM_DELIVERY_ST_PRICE);
	$shopMgr->setSH_COM_DELIVERY_PRICE($intSH_COM_DELIVERY_PRICE);
	$shopMgr->setSH_COM_DELIVERY_COR($strSH_COM_DELIVERY_COR);
	$shopMgr->setSH_COM_DELIVERY_FREE($strSH_COM_DELIVERY_FREE);
	$shopMgr->setSH_COM_DEVLIERY_PROD($strSH_COM_DEVLIERY_PROD);
	$shopMgr->setSH_COM_DELIVERY_AREA($strSH_COM_DELIVERY_AREA);
	$shopMgr->setSH_COM_DELIVERY_TEXT($strSH_COM_DELIVERY_TEXT);
	$shopMgr->setSH_COM_PROD_AUTH($strSH_COM_PROD_AUTH);
	$shopMgr->setSH_APPR($strSH_APPR);
	$shopMgr->setSH_REG_NO($a_admin_no);
	$shopMgr->setSH_MOD_NO($a_admin_no);

	## 상점정보

	$shopMgr->setSH_COM_CITY($strSH_COM_CITY);
	$shopMgr->setSH_COM_STATE($strSH_COM_STATE);

	$shopMgr->setSH_COM_CATEGORY($strSH_COM_CATEGORY);
	$shopMgr->setSH_COM_COUNTRY($strSH_COM_COUNTRY);

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

	$shopMgr->setSH_COM_CREDIT_GRADE($strsetSH_COM_LOCUS_GRADE);
	$shopMgr->setSH_COM_SALE_GRADE($strSH_COM_SALE_GRADE);
	$shopMgr->setSH_COM_LOCUS_GRADE($strSH_COM_LOCUS_GRADE);

	$shopMgr->setSH_COM_INTRO1($strSH_COM_INTRO1);
	$shopMgr->setSH_COM_INTRO2($strSH_COM_INTRO2);

	$shopMgr->setST_NAME($strST_NAME);
	$shopMgr->setST_NAME_ENG($strST_NAME_ENG);
	$shopMgr->setST_TEXT($strST_TEXT);
	$shopMgr->setST_MEMO($strST_MEMO);

	$shopMgr->setSU_NO($intSU_NO);
	$shopMgr->setM_NO($intM_NO);
	$shopMgr->setSU_TYPE($strSU_TYPE);
	$shopMgr->setSU_MEMO($strSU_MEMO);
	$shopMgr->setSU_USE($strSU_USE);


	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	/* 여기에 추가되어야 함(메일관련) */


	switch ($strAct) {
		case "shopApplyReg":
			// 입점몰 등록


			/*if(!$g_member_no){
				$strUrl = "./?menuType=member&mode=login";
				goUrl("로그인후 이용해주세요",$strUrl);
				exit;
			}*/

			/* 이메일 중복 체크 */
			$intCount = $shopMgr->getShopMailCheck($db);
			if ($intCount > 0){
				goErrMsg($LNG_TRANS_CHAR["MS00012"]);
				exit;
			}

			## 기본 설정
			$strSaveTime = date("YmdHis");

			/* 파일 업로드 */
			$strSaveDir		= WEB_UPLOAD_PATH . "/shop";
			$strSaveTime	= date("YmdHis");

			for($i=1;$i<=5;$i++){
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

			/* 파일 업로드 */

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

			if ($intSH_NO > 0){

				## 2014.09.11 kim hee sung
				## 입점사 가입시 다국어 주소 추가
				if($S_SHOP_APPLY_REG_VERSION == "V2.0"):

					## 모듈 설정
					$objShopMgrModule = new ShopMgrModule($db);

					## 기본설정
					$strComCountry	= $_POST['com_country'];
					$strComAddr		= $_POST['com_addr'];
					$strComCity		= $_POST['com_city'];
					$strComState1	= $_POST['com_state_1'];
					$strComState2	= $_POST['com_state_2'];
					$strComZip1		= $_POST['com_zip1'];
					$strComZip2		= $_POST['com_zip2'];

					## 국가가 US인경우 strComState2 com_state_2 를 사용합니다.
					if($strComCountry == "US") { $strComState1 = $strComState2; }

					## 우편번호 설정
					$strComZip = $strComZip1;
					if($strComZip1 && $strComZip2) { $strComZip = "{$strComZip1}-{$strComZip2}"; }

					## 주소 업데이트
					$param = "";
					$param['SH_NO'] = $intSH_NO;
					$param['SH_COM_ZIP'] = $strComZip;
					$param['SH_COM_ADDR'] = $strComAddr;
					$param['SH_COM_COUNTRY'] = $strComCountry;
					$param['SH_COM_CITY'] = $strComCity;
					$param['SH_COM_STATE'] = $strComState1;
					$objShopMgrModule->getShopMgrComCountryUpdateEx($param);

				endif;

				## 폴더 생성
				$webUploadPath	= WEB_UPLOAD_PATH;
				$makeDirName	= "{$webUploadPath}/shop/store_{$intSH_NO}";
				if(!is_dir($makeDirName)):
					@mkdir($makeDirName,0707);
					@chmod($makeDirName,0707);
					@mkdir($makeDirName."/design",0707);
					@chmod($makeDirName."/design",0707);
				endif;

				// 로고
				$file				= $_FILES['store_logo'];
				if($file['error'] == 0):
					$aryFileInfo	= $fh->getFileInfo($file['name']);
					$strSaveName	= "{$strSaveTime}_logo.{$aryFileInfo['extension']}";
					if($fh->doUploadEasy("{$webUploadPath}/shop/store_{$intSH_NO}/design/{$strSaveName}", "store_logo")):
						$fileName = $storeRow['ST_LOGO'];
						unlink("{$webUploadPath}/shop/store_{$intSH_NO}/design/{$fileName}");
						$shopMgr->setST_LOGO($strSaveName);
					endif;
				endif;

				// 이미지
				$file				= $_FILES['store_img'];
				if($file['error'] == 0):
					$aryFileInfo	= $fh->getFileInfo($file['name']);
					$strSaveName	= "{$strSaveTime}_img.{$aryFileInfo['extension']}";
					if($fh->doUploadEasy("{$webUploadPath}/shop/store_{$intSH_NO}/design/{$strSaveName}", "store_img")):
						$fileName = $storeRow['ST_IMG'];
						unlink("{$webUploadPath}/shop/store_{$intSH_NO}/design/{$fileName}");
						$shopMgr->setST_IMG($strSaveName);
					endif;
				endif;

				// 썸네일
				$file				= $_FILES['store_thumb_img'];
				if($file['error'] == 0):
					$aryFileInfo	= $fh->getFileInfo($file['name']);
					$strSaveName	= "{$strSaveTime}_thumb.{$aryFileInfo['extension']}";
					if($fh->doUploadEasy("{$webUploadPath}/shop/store_{$intSH_NO}/design/{$strSaveName}", "store_thumb_img")):
						$fileName = $storeRow['ST_THUMB_IMG'];
						unlink("{$webUploadPath}/shop/store_{$intSH_NO}/design/{$fileName}");
						$shopMgr->setST_THUMB_IMG($strSaveName);
					endif;
				endif;


				$shopMgr->setSH_NO($intSH_NO);

				## 상점정보 업데이트
				$shopMgr->getStoreInsertUpdate($db);

				## 셋팅정보 업데이트
				$shopMgr->getShopSettingUpdate($db);

				## 로그인 상태이면 현재 로그인한 정보가 관리자로 들어감
				if ($g_member_no)
				{
					$shopMgr->setSH_NO($intSH_NO);
					$shopMgr->setM_NO($g_member_no);
					$shopMgr->setSU_TYPE("A");
					$shopMgr->setSU_USE("N");
					$shopMgr->getShopUserInsert($db);
				}
			}

			require_once MALL_CONF_LIB."EmailMgr.php";
			require_once MALL_CONF_LIB."PostMailMgr.php";
			require_once MALL_CONF_LIB."PostMailLogMgr.php";

			$emailMgr		= new EmailMgr();
			$postMailMgr	= new PostMailMgr();
			$postMailLogMgr	= new PostMailLogMgr();

			$shopMgr->setSH_NO($intSH_NO);
			$shopRow = $shopMgr->getShopView($db);

			/** 메일 전송 **/
			//$memberMgr->setM_NO($intM_NO);
			//$memberRow = $memberMgr->getMemberView($db);
			/** 메일 전송 **/
			
			//$strMailMode = "join";
			//include WEB_FRWORK_ACT."memberMailForm.inc.php";

			/*$aryTAG_LIST['{{__받는사람이름__}}']	= $strM_F_NAME." ".$strM_L_NAME;
			$aryTAG_LIST['{{__받는사람메일__}}']	= $strM_MAIL;
			$aryTAG_LIST['{{__회원명__}}']			= $strM_F_NAME." ".$strM_L_NAME;
			$aryTAG_LIST['{{__회원가입정보__}}']	= $strMemberInfoHtml;*/

			$aryTAG_LIST['{{__받는사람이름__}}']	= $shopRow[SH_COM_REP_NM];
			$aryTAG_LIST['{{__받는사람메일__}}']	= $shopRow[SH_COM_MAIL];
			$aryTAG_LIST['{{__회원명__}}']			= $shopRow[SH_COM_REP_NM];
			$aryTAG_LIST['{{__회원가입정보__}}']	= $strMemberInfoHtml;
			
			goSendMail("021");
			/** 메일 전송 **/


			//ECHO "11";
			/** 입점사 메일발송 시작**/
			//require_once MALL_HOME."/web/shopAdmin/sendmail/_function.lib.inc.php";
			//ECHO "22";
			//require_once MALL_HOME."/web/shopAdmin/sendmail/_postMailField.inc.php";
			//ECHO "33";
			//require_once MALL_HOME."/web/shopAdmin/sendmail/_postMailSetting.inc.php";
//ECHO "44";

			/* 메일 전송 */
			/*$strMailFromName		= $S_SITE_NM;							// 보내는 사람 이름
			$strMailFromAddr		= $S_SITE_MAIL;							// 보내는 사람 메일
			$strMailTitle			= "축하합니다. 입점신청이 완료되었습니다.";					// 메일 제목
			$strContents			= "입점승인절차 완료후 메일로 알려드리겠습니다.";					// 메일 내용
			$strMailToName			= $shopRow[SH_COM_REP_NM];							// 받는 사람 이름
			$strMailToAddr			= $shopRow[SH_COM_MAIL];							// 받는 사람 메일


			$sendMailResult			= sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");
			$sendMailResult			= ($sendMailResult) ? $sendMailResult : 0;*/
			/* 메일 전송 */

	//		ECHO "a";
	//		exit;

			//로그인없이 입점신청가능하게
			//if ($g_member_no) $strUrl = "./?menuType=shop&mode=shopApplyEnd";
			//else $strUrl = "./?menuType=shop&mode=shopApplyAdmin&shopNo=$intSH_NO";




			$strUrl = "./?menuType=shop&mode=shopApplyEnd";

		break;
	}

	goUrl("",$strUrl);
?>