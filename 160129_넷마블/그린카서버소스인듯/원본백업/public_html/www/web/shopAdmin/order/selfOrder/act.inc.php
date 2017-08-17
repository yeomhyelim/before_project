<?
	require_once MALL_CONF_LIB."OrderHandAddrAdmMgr.php";
	require_once MALL_CONF_LIB."OrderSelfMemberInfoAdmMgr.php";
//	require_once MALL_CONF_LIB."OrderSelfProductAdmMgr.php";
	require_once MALL_CONF_LIB."OrderAdmMgr.php";

	$orderHandAddrMgr			= new OrderHandAddrAdmMgr();
	$orderSelfMemberInfoMgr		= new OrderSelfMemberInfoAdmMgr();
//	$orderSelfProductMgr		= new OrderSelfProductAdmMgr();
	$orderMgr					= new OrderMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strMode				= $_POST["mode"]				? $_POST["mode"]				: $_REQUEST["mode"];
	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]			: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]			: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];

	//입금계좌, 은행, 입금자명
	$strO_BANK_NAME			= $_POST["input_bank_name"]		? $_POST["input_bank_name"]		: $_REQUEST["input_bank_name"];
	$strO_BANK				= $_POST["input_bank_code"]		? $_POST["input_bank_code"]		: $_REQUEST["input_bank_code"];
	$strO_BANK_ACC			= $_POST["settle_bank_code"]	? $_POST["settle_bank_code"]	: $_REQUEST["settle_bank_code"];
	
	// 주소록 등록
	$intHA_NO				= $_POST["ha_no"]				? $_POST["ha_no"]				: $_REQUEST["ha_no"];
	$intHA_AG_NO			= $_POST["ha_ag_no"]			? $_POST["ha_ag_no"]			: $_REQUEST["ha_ag_no"];
	$strHA_AG_NAME			= $_POST["ha_ag_name"]			? $_POST["ha_ag_name"]			: $_REQUEST["ha_ag_name"];
	$strHA_NAME				= $_POST["ha_name"]				? $_POST["ha_name"]				: $_REQUEST["ha_name"];
	$strHA_ZIP_1			= $_POST["ha_zip_1"]			? $_POST["ha_zip_1"]			: $_REQUEST["ha_zip_1"];
	$strHA_ZIP_2			= $_POST["ha_zip_2"]			? $_POST["ha_zip_2"]			: $_REQUEST["ha_zip_2"];
	$strHA_ADDR1			= $_POST["ha_addr1"]			? $_POST["ha_addr1"]			: $_REQUEST["ha_addr1"];
	$strHA_ADDR2			= $_POST["ha_addr2"]			? $_POST["ha_addr2"]			: $_REQUEST["ha_addr2"];
	$strHA_EMAIL_1			= $_POST["ha_email_1"]			? $_POST["ha_email_1"]			: $_REQUEST["ha_email_1"];
	$strHA_EMAIL_2			= $_POST["ha_email_2"]			? $_POST["ha_email_2"]			: $_REQUEST["ha_email_2"];
	$strHA_PHONE1_1			= $_POST["ha_phone1_1"]			? $_POST["ha_phone1_1"]			: $_REQUEST["ha_phone1_1"];
	$strHA_PHONE1_2			= $_POST["ha_phone1_2"]			? $_POST["ha_phone1_2"]			: $_REQUEST["ha_phone1_2"];
	$strHA_PHONE1_3			= $_POST["ha_phone1_3"]			? $_POST["ha_phone1_3"]			: $_REQUEST["ha_phone1_3"];
	$strHA_PHONE2_1			= $_POST["ha_phone2_1"]			? $_POST["ha_phone2_1"]			: $_REQUEST["ha_phone2_1"];
	$strHA_PHONE2_2			= $_POST["ha_phone2_2"]			? $_POST["ha_phone2_2"]			: $_REQUEST["ha_phone2_2"];
	$strHA_PHONE2_3			= $_POST["ha_phone2_3"]			? $_POST["ha_phone2_3"]			: $_REQUEST["ha_phone2_3"];
	$strHA_MEMO				= $_POST["ha_memo"]				? $_POST["ha_memo"]				: $_REQUEST["ha_memo"];
	$intHA_REG_DT			= $_POST["ha_reg_dt"]			? $_POST["ha_reg_dt"]			: $_REQUEST["ha_reg_dt"];
	$intHA_REG_NO			= $_POST["ha_reg_no"]			? $_POST["ha_reg_no"]			: $_REQUEST["ha_reg_no"];
	$intHA_MOD_DT			= $_POST["ha_mod_dt"]			? $_POST["ha_mod_dt"]			: $_REQUEST["ha_mod_dt"];
	$intHA_MOD_NO			= $_POST["ha_mod_no"]			? $_POST["ha_mod_no"]			: $_REQUEST["ha_mod_no"];

	// 수기등록 - 주문자, 수령자 정보
	$intOM_NO				= $_POST["om_no"]				? $_POST["om_no"]				: $_REQUEST["om_no"];
	$strOM_O_ID				= $_POST["om_o_id"]				? $_POST["om_o_id"]				: $_REQUEST["om_o_id"];
	$strOM_O_NAME			= $_POST["om_o_name"]			? $_POST["om_o_name"]			: $_REQUEST["om_o_name"];
	$strOM_O_EMAIL_1		= $_POST["om_o_email_1"]		? $_POST["om_o_email_1"]		: $_REQUEST["om_o_email_1"];
	$strOM_O_EMAIL_2		= $_POST["om_o_email_2"]		? $_POST["om_o_email_2"]		: $_REQUEST["om_o_email_2"];
	$strOM_O_PHONE_1		= $_POST["om_o_phone_1"]		? $_POST["om_o_phone_1"]		: $_REQUEST["om_o_phone_1"];
	$strOM_O_PHONE_2		= $_POST["om_o_phone_2"]		? $_POST["om_o_phone_2"]		: $_REQUEST["om_o_phone_2"];
	$strOM_O_PHONE_3		= $_POST["om_o_phone_3"]		? $_POST["om_o_phone_3"]		: $_REQUEST["om_o_phone_3"];
	$strOM_O_HP_1			= $_POST["om_o_hp_1"]			? $_POST["om_o_hp_1"]			: $_REQUEST["om_o_hp_1"];
	$strOM_O_HP_2			= $_POST["om_o_hp_2"]			? $_POST["om_o_hp_2"]			: $_REQUEST["om_o_hp_2"];
	$strOM_O_HP_3			= $_POST["om_o_hp_3"]			? $_POST["om_o_hp_3"]			: $_REQUEST["om_o_hp_3"];
	$strOM_O_ZIP_1			= $_POST["om_o_zip_1"]			? $_POST["om_o_zip_1"]			: $_REQUEST["om_o_zip_1"];
	$strOM_O_ZIP_2			= $_POST["om_o_zip_2"]			? $_POST["om_o_zip_2"]			: $_REQUEST["om_o_zip_2"];
	$strOM_O_ADDR1			= $_POST["om_o_addr1"]			? $_POST["om_o_addr1"]			: $_REQUEST["om_o_addr1"];
	$strOM_O_ADDR2			= $_POST["om_o_addr2"]			? $_POST["om_o_addr2"]			: $_REQUEST["om_o_addr2"];
	$strOM_R_NAME			= $_POST["om_r_name"]			? $_POST["om_r_name"]			: $_REQUEST["om_r_name"];
	$strOM_R_PHONE_1		= $_POST["om_r_phone_1"]		? $_POST["om_r_phone_1"]		: $_REQUEST["om_r_phone_1"];
	$strOM_R_PHONE_2		= $_POST["om_r_phone_2"]		? $_POST["om_r_phone_2"]		: $_REQUEST["om_r_phone_2"];
	$strOM_R_PHONE_3		= $_POST["om_r_phone_3"]		? $_POST["om_r_phone_3"]		: $_REQUEST["om_r_phone_3"];
	$strOM_R_HP_1			= $_POST["om_r_hp_1"]			? $_POST["om_r_hp_1"]			: $_REQUEST["om_r_hp_1"];
	$strOM_R_HP_2			= $_POST["om_r_hp_2"]			? $_POST["om_r_hp_2"]			: $_REQUEST["om_r_hp_2"];
	$strOM_R_HP_3			= $_POST["om_r_hp_3"]			? $_POST["om_r_hp_3"]			: $_REQUEST["om_r_hp_3"];
	$strOM_R_ZIP_1			= $_POST["om_r_zip_1"]			? $_POST["om_r_zip_1"]			: $_REQUEST["om_r_zip_1"];
	$strOM_R_ZIP_2			= $_POST["om_r_zip_2"]			? $_POST["om_r_zip_2"]			: $_REQUEST["om_r_zip_2"];
	$strOM_R_ADDR1			= $_POST["om_r_addr1"]			? $_POST["om_r_addr1"]			: $_REQUEST["om_r_addr1"];
	$strOM_R_ADDR2			= $_POST["om_r_addr2"]			? $_POST["om_r_addr2"]			: $_REQUEST["om_r_addr2"];
	$strOM_MEMBER_TYPE		= $_POST["om_member_type"]		? $_POST["om_member_type"]		: $_REQUEST["om_member_type"];
	$strOM_MEMO				= $_POST["om_memo"]				? $_POST["om_memo"]				: $_REQUEST["om_memo"];
	$intOM_SUM_PRICE		= $_POST["om_sum_price"]		? $_POST["om_sum_price"]		: $_REQUEST["om_sum_price"];
	$intOM_DELIVERY_PRICE	= $_POST["om_delivery_price"]	? $_POST["om_delivery_price"]	: $_REQUEST["om_delivery_price"];
	$intOM_POINT			= $_POST["om_point"]			? $_POST["om_point"]			: $_REQUEST["om_point"];
	$intOM_TOTAL_PRICE		= $_POST["om_total_price"]		? $_POST["om_total_price"]		: $_REQUEST["om_total_price"];
	$strOM_BANK_COMPANY_NAME = $_POST["om_bank_company_name"]	? $_POST["om_bank_company_name"]			: $_REQUEST["om_bank_company_name"];
	$strOM_BANK_ACCOUNT		= $_POST["om_bank_account"]		? $_POST["om_bank_account"]		: $_REQUEST["om_bank_account"];
	$strOM_BANK_NAME		= $_POST["om_bank_name"]		? $_POST["om_bank_name"]		: $_REQUEST["om_bank_name"];
	$intOM_REG_DT			= $_POST["om_reg_dt"]			? $_POST["om_reg_dt"]			: $_REQUEST["om_reg_dt"];
	$intOM_REG_NO			= $_POST["om_reg_no"]			? $_POST["om_reg_no"]			: $_REQUEST["om_reg_no"];
	$intOM_MOD_DT			= $_POST["om_mod_dt"]			? $_POST["om_mod_dt"]			: $_REQUEST["om_mod_dt"];
	$intOM_MOD_NO			= $_POST["om_mod_no"]			? $_POST["om_mod_no"]			: $_REQUEST["om_mod_no"];

	// 수기등록 - 주문상품정보
 	$intOP_NO				= $_POST["op_no"]				? $_POST["op_no"]				: $_REQUEST["op_no"];
	$intOP_OM_NO			= $_POST["op_om_no"]			? $_POST["op_om_no"]			: $_REQUEST["op_om_no"];
	$aryOP_P_CODE			= $_POST["op_p_code"]			? $_POST["op_p_code"]			: $_REQUEST["op_p_code"];
	$aryOP_P_NAME			= $_POST["op_p_name"]			? $_POST["op_p_name"]			: $_REQUEST["op_p_name"];
	$aryOP_P_POINT			= $_POST["op_p_point"]			? $_POST["op_p_point"]			: $_REQUEST["op_p_point"];
	$aryOP_P_QTY			= $_POST["op_p_qty"]			? $_POST["op_p_qty"]			: $_REQUEST["op_p_qty"];
	$aryOP_P_SALE_PRICE		= $_POST["op_p_sale_price"]		? $_POST["op_p_sale_price"]		: $_REQUEST["op_p_sale_price"];
	$intOP_P_REG_DT			= $_POST["op_p_reg_dt"]			? $_POST["op_p_reg_dt"]			: $_REQUEST["op_p_reg_dt"];
	$intOP_P_REG_NO			= $_POST["op_p_reg_no"]			? $_POST["op_p_reg_no"]			: $_REQUEST["op_p_reg_no"];
	$intOP_P_MOD_DT			= $_POST["op_p_mod_dt"]			? $_POST["op_p_mod_dt"]			: $_REQUEST["op_p_mod_dt"];
	$intOP_P_MOD_NO			= $_POST["op_p_mod_no"]			? $_POST["op_p_mod_no"]			: $_REQUEST["op_p_mod_no"];
	/*##################################### Parameter 셋팅 #####################################*/

	if($strHA_ZIP_1 && $strHA_ZIP_2):
		$strHA_ZIP = $strHA_ZIP_1 . "-" . $strHA_ZIP_2;
	endif;
	if($strHA_EMAIL_1 && $strHA_EMAIL_1):
		$strHA_EMAIL = $strHA_EMAIL_1 . "@" . $strHA_EMAIL_2;
	endif;
	if($strHA_PHONE1_1 && $strHA_PHONE1_2 && $strHA_PHONE1_3):
		$strHA_PHONE1 = $strHA_PHONE1_1 . "-" . $strHA_PHONE1_2 . "-" . $strHA_PHONE1_3;
	endif;
	if($strHA_PHONE2_1 && $strHA_PHONE2_2 && $strHA_PHONE2_3):
		$strHA_PHONE2 = $strHA_PHONE2_1 . "-" . $strHA_PHONE2_2 . "-" . $strHA_PHONE2_3;
	endif;
	
	if($strOM_O_EMAIL_1 && $strOM_O_EMAIL_2):
		$strOM_O_EMAIL = $strOM_O_EMAIL_1 . "@" . $strOM_O_EMAIL_2;
	endif;
	if($strOM_O_PHONE_1 && $strOM_O_PHONE_2 && $strOM_O_PHONE_3):
		$strOM_O_PHONE = $strOM_O_PHONE_1 . "-" . $strOM_O_PHONE_2 . "-" . $strOM_O_PHONE_3;
	endif;
	if($strOM_O_HP_1 && $strOM_O_HP_2 && $strOM_O_HP_3):
		$strOM_O_HP = $strOM_O_HP_1 . "-" . $strOM_O_HP_2 . "-" . $strOM_O_HP_3;
	endif;
	if($strOM_O_ZIP_1 && $strOM_O_ZIP_2):
		$strOM_O_ZIP = $strOM_O_ZIP_1 . "-" . $strOM_O_ZIP_2;
	endif;
	if($strOM_R_PHONE_1 && $strOM_R_PHONE_2 && $strOM_R_PHONE_3):
		$strOM_R_PHONE = $strOM_R_PHONE_1 . "-" . $strOM_R_PHONE_2 . "-" . $strOM_R_PHONE_3;
	endif;
	if($strOM_R_HP_1 && $strOM_R_HP_2 && $strOM_R_HP_3):
		$strOM_R_HP = $strOM_R_HP_1 . "-" . $strOM_R_HP_2 . "-" . $strOM_R_HP_3;
	endif;
	if($strOM_R_ZIP_1 && $strOM_R_ZIP_2):
		$strOM_R_ZIP = $strOM_R_ZIP_1 . "-" . $strOM_R_ZIP_2;
	endif;

	$intHA_REG_NO			= $_SESSION["ADMIN_NO"];
	$intHA_MOD_NO			= $_SESSION["ADMIN_NO"];

	$intOM_REG_NO			= $_SESSION["ADMIN_NO"];
	$intOM_MOD_NO			= $_SESSION["ADMIN_NO"];

	$intOP_P_REG_NO			= $_SESSION["ADMIN_NO"];
	$intOP_P_MOD_NO			= $_SESSION["ADMIN_NO"];

	$strHA_NAME				= strTrim($strHA_NAME,60);
	$strHA_ZIP				= strTrim($strHA_ZIP,10);
	$strHA_ADDR1			= strTrim($strHA_ADDR1,100);
	$strHA_ADDR2			= strTrim($strHA_ADDR2,150);
	$strHA_EMAIL			= strTrim($strHA_EMAIL,30);
	$strHA_PHONE1			= strTrim($strHA_PHONE1,30);
	$strHA_PHONE2			= strTrim($strHA_PHONE2,30);
	$strHA_MEMO				= strTrim($strHA_MEMO,500);
	
	$strOM_O_ID				= strTrim($strOM_O_ID,20);
	$strOM_O_NAME			= strTrim($strOM_O_NAME,60);
	$strOM_O_EMAIL			= strTrim($strOM_O_EMAIL,10);
	$strOM_O_PHONE			= strTrim($strOM_O_PHONE,30);
	$strOM_O_HP				= strTrim($strOM_O_HP,30);
	$strOM_O_ZIP			= strTrim($strOM_O_ZIP,10);
	$strOM_O_ADDR1			= strTrim($strOM_O_ADDR1,100);
	$strOM_O_ADDR2			= strTrim($strOM_O_ADDR2,150);
	$strOM_R_NAME			= strTrim($strOM_R_NAME,60);
	$strOM_R_PHONE			= strTrim($strOM_R_PHONE,30);
	$strOM_R_HP				= strTrim($strOM_R_HP,30);
	$strOM_R_ZIP			= strTrim($strOM_R_ZIP,10);
	$strOM_R_ADDR1			= strTrim($strOM_R_ADDR1,100);
	$strOM_R_ADDR2			= strTrim($strOM_R_ADDR2,150);
	$strOM_MEMBER_TYPE		= strTrim($strOM_MEMBER_TYPE,1);
	$strOM_MEMO				= strTrim($strOM_MEMO,500);
	$strOM_BANK_COMPANY_NAME = strTrim($strOM_BANK_COMPANY_NAME,40);
	$strOM_BANK_ACCOUNT		= strTrim($strOM_BANK_ACCOUNT,50);
	$strOM_BANK_NAME		= strTrim($strOM_BANK_NAME,60);

	$strOP_P_CODE			= strTrim($strOP_P_CODE,20);
	$strOP_P_NAME			= strTrim($strOP_P_NAME,20);

	$orderHandAddrMgr->setHA_NO($intHA_NO);
	$orderHandAddrMgr->setHA_AG_NO($intHA_AG_NO);
	$orderHandAddrMgr->setHA_NAME($strHA_NAME);
	$orderHandAddrMgr->setHA_ZIP($strHA_ZIP);
	$orderHandAddrMgr->setHA_ADDR1($strHA_ADDR1);
	$orderHandAddrMgr->setHA_ADDR2($strHA_ADDR2);
	$orderHandAddrMgr->setHA_EMAIL($strHA_EMAIL);
	$orderHandAddrMgr->setHA_PHONE1($strHA_PHONE1);
	$orderHandAddrMgr->setHA_PHONE2($strHA_PHONE2);
	$orderHandAddrMgr->setHA_MEMO($strHA_MEMO);
	$orderHandAddrMgr->setHA_REG_DT($intHA_REG_DT);
	$orderHandAddrMgr->setHA_REG_NO($intHA_REG_NO);
	$orderHandAddrMgr->setHA_MOD_DT($intHA_MOD_DT);
	$orderHandAddrMgr->setHA_MOD_NO($intHA_MOD_NO);

//	$orderSelfMemberInfoMgr->setOM_NO($intOM_NO);
//	$orderSelfMemberInfoMgr->setOM_O_ID($strOM_O_ID);
//	$orderSelfMemberInfoMgr->setOM_O_NAME($strOM_O_NAME);
//	$orderSelfMemberInfoMgr->setOM_O_EMAIL($strOM_O_EMAIL);
//	$orderSelfMemberInfoMgr->setOM_O_PHONE($strOM_O_PHONE);
//	$orderSelfMemberInfoMgr->setOM_O_HP($strOM_O_HP);
//	$orderSelfMemberInfoMgr->setOM_O_ZIP($strOM_O_ZIP);
//	$orderSelfMemberInfoMgr->setOM_O_ADDR1($strOM_O_ADDR1);
//	$orderSelfMemberInfoMgr->setOM_O_ADDR2($strOM_O_ADDR2);
//	$orderSelfMemberInfoMgr->setOM_R_NAME($strOM_R_NAME);
//	$orderSelfMemberInfoMgr->setOM_R_PHONE($strOM_R_PHONE);
//	$orderSelfMemberInfoMgr->setOM_R_HP($strOM_R_HP);
//	$orderSelfMemberInfoMgr->setOM_R_ZIP($strOM_R_ZIP);
//	$orderSelfMemberInfoMgr->setOM_R_ADDR1($strOM_R_ADDR1);
//	$orderSelfMemberInfoMgr->setOM_R_ADDR2($strOM_R_ADDR2);
//	$orderSelfMemberInfoMgr->setOM_MEMBER_TYPE($strOM_MEMBER_TYPE);
//	$orderSelfMemberInfoMgr->setOM_MEMO($strOM_MEMO);
//	$orderSelfMemberInfoMgr->setOM_SUM_PRICE($intOM_SUM_PRICE);
//	$orderSelfMemberInfoMgr->setOM_DELIVERY_PRICE($intOM_DELIVERY_PRICE);
//	$orderSelfMemberInfoMgr->setOM_POINT($intOM_POINT);
//	$orderSelfMemberInfoMgr->setOM_TOTAL_PRICE($intOM_TOTAL_PRICE);
//	$orderSelfMemberInfoMgr->setOM_BANK_COMPANY_NAME($strOM_BANK_COMPANY_NAME);
//	$orderSelfMemberInfoMgr->setOM_BANK_ACCOUNT($strOM_BANK_ACCOUNT);
//	$orderSelfMemberInfoMgr->setOM_BANK_NAME($strOM_BANK_NAME);
//	$orderSelfMemberInfoMgr->setOM_REG_DT($intOM_REG_DT);
//	$orderSelfMemberInfoMgr->setOM_REG_NO($intOM_REG_NO);
//	$orderSelfMemberInfoMgr->setOM_MOD_DT($intOM_MOD_DT);
//	$orderSelfMemberInfoMgr->setOM_MOD_NO($intOM_MOD_NO);	

//	$orderSelfProductMgr->setOP_NO($intOP_NO);
//	$orderSelfProductMgr->setOP_OM_NO($intOP_OM_NO);
//	$orderSelfProductMgr->setOP_P_CODE($strOP_P_CODE);						// 상품코드
//	$orderSelfProductMgr->setOP_P_NAME($strOP_P_NAME);						// 상품명
//	$orderSelfProductMgr->setOP_P_POINT($intOP_P_POINT);					// 적립금
//	$orderSelfProductMgr->setOP_P_QTY($intOP_P_QTY);						// 수량
//	$orderSelfProductMgr->setOP_P_SALE_PRICE($intOP_P_SALE_PRICE);			// 판매가
//	$orderSelfProductMgr->setOP_P_REG_DT($intOP_P_REG_DT);
//	$orderSelfProductMgr->setOP_P_REG_NO($intOP_P_REG_NO);
//	$orderSelfProductMgr->setOP_P_MOD_DT($intOP_P_MOD_DT);
//	$orderSelfProductMgr->setOP_P_MOD_NO($intOP_P_MOD_NO);




	switch ($strAct) :
		case "prodOrderWrite":
			// 수기 상품 등록

			/* 주문정보 KEY 생성*/
			$strOrderKey = date("Ymd").STRTOUPPER(rand_code(5)).$orderMgr->getOrderKey($db);
			$orderMgr->setO_KEY($strOrderKey);
			$intDupKeyCnt = $orderMgr->getOrderDupKey($db);
			
			if ($intDupKeyCnt > 0){
				$strFlag = false;

				while($strFlag == false){

					$strOrderKey = date("Ymd").STRTOUPPER(rand_code(5)).$orderMgr->getOrderKey($db);
					$orderMgr->setO_KEY($strOrderKey);
					$intDupKeyCnt = $orderMgr->getOrderDupKey($db);
					
					if($intDupKeyCnt=="0"){
						$strFlag = true;
						break;
					}
				}			
			}

			//입금계좌, 은행, 입금자명
			$arySiteSettleBank = explode("/",$S_BANK);
			$strO_BANK_ACC = $arySiteSettleBank[$strO_BANK_ACC];
			$orderMgr->setO_BANK_NAME($strO_BANK_NAME);	// 무통장입금자명
			$orderMgr->setO_BANK($strO_BANK);			// 무통장입금은행
			$orderMgr->setO_BANK_ACC($strO_BANK_ACC);	// 무통장입금계좌번호

			// 구매자 정보
			if($intOM_NO) { $intOM_NO = 0; }			// 비회원
			$orderMgr->setM_NO($intOM_NO);				// 회원 번호
			$orderMgr->setO_J_NAME($strOM_O_NAME);		// 이름
			$orderMgr->setO_J_PHONE($strOM_O_PHONE);	// 연락처
			$orderMgr->setO_J_HP($strOM_O_HP);			// 휴대폰
			$orderMgr->setO_J_MAIL($strOM_O_EMAIL);		// 메일
			
			$orderMgr->setO_B_NAME($strOM_R_NAME);		// 받는사람
			$orderMgr->setO_B_PHONE($strOM_R_PHONE);	// 받는사람 연락처
			$orderMgr->setO_B_HP($strOM_R_HP);			// 받는사람 휴대폰
			$orderMgr->setO_B_MAIL("");					// 받는사람 이메일
			$orderMgr->setO_B_ZIP($OM_R_ZIP);			// 받는사람 우편번호
			$orderMgr->setO_B_COUNTRY("");				// 받는사람 배송지 국가
			$orderMgr->setO_B_ADDR1($strOM_R_ADDR1);	// 받는사람 기본주소
			$orderMgr->setO_B_ADDR2($strOM_R_ADDR2);	// 받는사람 상세주소
			$orderMgr->setO_B_CITY("");					// 받는사람 도시
			$orderMgr->setO_B_STATE("");				// 받는사람 STATE
			$orderMgr->setO_B_MEMO($strOM_MEMO);		// 받는사람 메모

			$orderMgr->setO_PG("");						// 결제사(PG)
			$orderMgr->setO_SETTLE("B");				// 결제방법(B:무통장입금)
			$orderMgr->setO_BANK_VALID_DT("");			// 가상계좌입금마감시
			$orderMgr->setO_DELIVERY_COM("");			// 배송회사
			$orderMgr->setO_DELIVERY_NUM("");			// 배송번호
			$orderMgr->setO_DELIVERY_WEIGHT("");		// 배송총무게
			$orderMgr->setO_USE_POINT("");				// 사용포인트
			$orderMgr->setO_USE_CUR_POINT("");			// 통화사용포인트
			$orderMgr->setO_DELIVERY_COM("");			// 배송회사
			$orderMgr->setO_J_TITLE($aryOP_P_NAME[0]);	// 상품명
			
			$intQty = sizeof($aryOP_P_CODE);
			$orderMgr->setO_TOT_QTY($intQty);	
			if($intQty>1):
				$strTitle = $aryOP_P_NAME[0] . " 외 " . $intQty . " 개";
				$orderMgr->setO_J_TITLE($strTitle);				// 상품명
			endif;
			
			// ORDER_MGR 테이블에 데이터 등록
			$orderMgr->getOrderInsert($db);
			$intO_NO = $db->getLastInsertID();			
			$orderMgr->setO_NO($intO_NO);						// 주문번호

			/* 장바구니(주문) 테이블에 정보 입력 */
			for($i=0;$i<sizeof($aryOP_P_CODE);$i++):
				$orderMgr->setP_CODE($aryOP_P_CODE[$i]);		// 상품번호
				/*-- 상품옵션 추가 할것 --*/
				/*-- 상품옵션 추가 할것 --*/
				$orderMgr->getOrderCartInsertPro($db);
			
			endfor;
			/* 장바구니(주문) 테이블에 정보 입력 */

			$strMsg = "등록되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=selfOrderWrite";	
		break;
		case "addressWrite":
			// 주소록 등록

			/* 그룹 검색 */
			$orderHandAddrMgr->setAG_NAME($strHA_AG_NAME);
			$orderHandAddrGrpRow = $orderHandAddrMgr->getOrderHandAddrGrpList($db, "OP_SELECT");
			if(!$orderHandAddrGrpRow):
				// 신규 그룹 insert
				$orderHandAddrGrpInsert = $orderHandAddrMgr->getOrderHandAddrGrpInsert($db);
				$orderHandAddrGrpRow = $orderHandAddrMgr->getOrderHandAddrGrpList($db, "OP_SELECT");
			endif;
			$orderHandAddrMgr->setHA_AG_NO($orderHandAddrGrpRow['AG_NO']);	

			/* 신규 주소 등록 */
			$orderHandAddrInsert = $orderHandAddrMgr->getOrderHandAddrInsert($db);

			$strMsg = "등록되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=addressList";	
		break;

		case "addressModify":
			// 주소록 수정
			/* 그룹 검색 */
			$orderHandAddrMgr->setAG_NAME($strHA_AG_NAME);
			$orderHandAddrGrpRow = $orderHandAddrMgr->getOrderHandAddrGrpList($db, "OP_SELECT");
			if(!$orderHandAddrGrpRow):
				// 신규 그룹 insert
				$orderHandAddrGrpInsert = $orderHandAddrMgr->getOrderHandAddrGrpInsert($db);
				$orderHandAddrGrpRow = $orderHandAddrMgr->getOrderHandAddrGrpList($db, "OP_SELECT");
			endif;
			$orderHandAddrMgr->setHA_AG_NO($orderHandAddrGrpRow['AG_NO']);	

			/* 주소록 수정 */
			$orderHandAddrInsert = $orderHandAddrMgr->getOrderHandAddrUpdate($db);

			$strMsg = "수정되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=addressList";	
		break;

		case "addressDelete":
			// 주소록 삭제
		
			/* 주소록 삭제 */
			$orderHandAddrDelete = $orderHandAddrMgr->getOrderHandAddrDelete( $db );

			$strMsg = "삭제되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=addressList";	
		break;
	endswitch;


	function rand_code($nc, $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		 $l = strlen($a) - 1; $r = '';
		 while($nc-->0) $r .= $a{mt_rand(0,$l)};
		 return $r;
	}
?>