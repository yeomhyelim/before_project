<?

	require_once MALL_CONF_LIB."MemberMgr.php";	
	require_once MALL_CONF_LIB."ProductMgr.php";	
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ShopMgr.php";
		
	$memberMgr = new MemberMgr();
	$productMgr = new ProductMgr();
	$couponMgr = new CouponMgr();
	$shopMgr = new ShopMgr();	

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	
	/* Join Form */
	$strM_ID		= $_POST["id"]				? $_POST["id"]				: $_REQUEST["id"];
	$strM_PASS		= $_POST["pwd1"]			? $_POST["pwd1"]			: $_REQUEST["pwd1"];
	$strM_PASS_ORG	= $_POST["pwd"]				? $_POST["pwd"]				: $_REQUEST["pwd"];
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
	$strM_TM_ID			= $_POST["tm_id"]			? $_POST["tm_id"]			: $_REQUEST["tm_id"];
	
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

	$strM_GROUP			= $_POST["memberGroup"]		? $_POST["memberGroup"]		: $_REQUEST["memberGroup"];	//회원그룹선택시 등록시
	$strMemberJoinType	= $_POST["joinType"]		? $_POST["joinType"]		: $_REQUEST["joinType"];	//회원가입시그룹선택
	/* Join Form */

	/* Login */
	$aryCartNo		= $_POST["cartNo"]			? $_POST["cartNo"]			: $_REQUEST["cartNo"];
	$strReturnMenu	= $_POST["returnMenu"]		? $_POST["returnMenu"]		: $_REQUEST["returnMenu"];
	$strReturnMode	= $_POST["returnMode"]		? $_POST["returnMode"]		: $_REQUEST["returnMode"];
	$strReturnParam	= $_POST["returnParam"]		? $_POST["returnParam"]		: $_REQUEST["returnParam"];

	$strLOGIN_ID	= $_POST["login_id"]		? $_POST["login_id"]		: $_REQUEST["login_id"];
	$strLOGIN_PWD	= $_POST["login_pwd"]		? $_POST["login_pwd"]		: $_REQUEST["login_pwd"];	
	$strLOGIN_COM	= $_POST["login_company"]	? $_POST["login_company"]	: $_REQUEST["login_company"];	

	$strAutoLogin	= $_POST["chkAutoLogin"]	? $_POST["chkAutoLogin"]	: $_REQUEST["chkAutoLogin"];	
	/* Login */

	/* SearchID & SearchPWD */
	$strM_ID_NAME	= $_POST["searchId_Name"]	? $_POST["searchId_Name"]	: $_REQUEST["searchId_Name"];
	$strM_ID_MAIL1	= $_POST["searchId_Mail1"]	? $_POST["searchId_Mail1"]	: $_REQUEST["searchId_Mail1"];
	$strM_ID_MAIL2	= $_POST["searchId_Mail2"]	? $_POST["searchId_Mail2"]	: $_REQUEST["searchId_Mail2"];
	
	$strM_PASS_ID	= $_POST["searchPass_Id"]	? $_POST["searchPass_Id"]	: $_REQUEST["searchPass_Id"];
	$strM_PASS_NAME	= $_POST["searchPass_Name"]	? $_POST["searchPass_Name"]	: $_REQUEST["searchNameB"];
	$strM_PASS_MAIL1= $_POST["searchPass_Mail1"]? $_POST["searchPass_Mail1"]: $_REQUEST["searchPass_Mail1"];
	$strM_PASS_MAIL2= $_POST["searchPass_Mail2"]? $_POST["searchPass_Mail2"]: $_REQUEST["searchPass_Mail2"];
	/* SearchID & SearchPWD */

	/* 레이어 팝업에서 로그인일때 */
	$strLayerClickType= $_POST["clickType"]? $_POST["clickType"]: $_REQUEST["clickType"];
	/* 레이어 팝업에서 로그인일때 */
	
	/* 입점사로 인한 회원가입 */
	$intShopNo		= $_POST["shopNo"]? $_POST["shopNo"]: $_REQUEST["shopNo"];
	/* 입점사로 인한 회원가입 */

	$strM_ID		= strTrim($strM_ID,20);
	$strM_PASS		= strTrim($strM_PASS,100);
	$strM_F_NAME	= strTrim($strM_F_NAME,30);
	$strM_L_NAME	= strTrim($strM_L_NAME,30);
	$strM_NICK_NAME = strTrim($strM_NICK_NAME,40);
	$strM_BIRTH		= strTrim($strM_BIRTH,10);
	$strM_SEX		= strTrim($strM_SEX,1);
	$strM_MAIL		= strTrim($strM_MAIL,50);
	$strM_PHONE		= strTrim($strM_PHONE,30);
	$strM_HP		= strTrim($strM_HP,30);
	$strM_WED_DAY	= strTrim($strM_WED_DAY,10);
	$strM_WED		= strTrim($strM_WED,1);
	$strM_ZIP		= strTrim($strM_ZIP,20);
	$strM_ADDR		= strTrim($strM_ADDR,100);
	$strM_ADDR2		= strTrim($strM_ADDR2,150);
	$strM_SMSYN		= strTrim($strM_SMSYN,1);
	$strM_MAILYN	= strTrim($strM_MAILYN,1);
	$strM_TEXT		= strTrim($strM_TEXT,"");
	$strM_REC_ID	= strTrim($strM_REC_ID,100);
	$strM_CONCERN	= strTrim($strM_CONCERN,100);
	$strM_JOB		= strTrim($strM_JOB,10);
	$strM_FAX		= strTrim($strM_FAX,30);
	
	$strM_CHILD			= strTrim($strM_CHILD,10);
	$strM_COM_NM		= strTrim($strM_COM_NM,50);
	$strM_TM_ID			= strTrim($strM_TM_ID,20);
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

	$strLOGIN_ID	= strTrim($strLOGIN_ID,30);
	$strLOGIN_PWD	= strTrim($strLOGIN_PWD,100);
	$strLOGIN_COM	= strTrim($strLOGIN_COM,100);	

	if (!$strM_F_NAME) $strM_F_NAME = $strM_NAME; /* 한국일때 */

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
	$memberMgr->setM_TM_ID($strM_TM_ID);
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

	/* SearchID & SearchPWD */
	$memberMgr->setM_ID_NAME($strM_ID_Name);		/* name   */
	$memberMgr->setM_ID_MAIL1($strM_ID_Mail1);		/* 구분 @ (front)  */
	$memberMgr->setM_ID_MAIL2($strM_ID_Mail2);		/* 구분 @ (behind) */
	

	$memberMgr->setM_PASS_ID($strM_PASS_Id);			/* ID	  */
	$memberMgr->setM_PASS_NAME($strM_PASS_Name);		/* name   */
	$memberMgr->setM_PASS_MAIL1($strM_PASS_MAIL1);		/* 구분 @ (front)  */
	$memberMgr->setM_PASS_MAIL2($strM_PASS_MAIL2);		/* 구분 @ (behind) */

	/* SearchID & SearchPWD */

	$strLinkPage = "";

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;	

	/* 여기에 추가되어야 함(메일관련) */
	if(is_file($S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php")) :
		require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
		require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	endif;
	/* 여기에 추가되어야 함(메일관련) */
	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
// 2015.01.15 kim hee sung sms v2.0 에서는 사용을 안합니다.
//	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
//	if(is_file($smsConfFile)):
//		require_once $smsConfFile;
//		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
//		$smsFunc = new SmsFunc();
//	endif;
	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/member.inc.php";

	switch ($strAct) {
		case "memberDropout":
			// 회원 탈퇴

			## 회원 비밀번호 체크
			$pass = $_POST['pass'];
			if($S_MEM_CERITY == 1):			// 아이디 체크
				$memberMgr->setM_ID($g_member_id);
				$memberMgr->setM_PASS($pass);
				$memberCnt = $memberMgr->getMemberPwdCheck($db);		
			elseif($S_MEM_CERITY == 2):		// 이메일 체크
				$memberMgr->setM_MAIL($g_member_email);
				$memberMgr->setM_PASS($pass);
				$memberCnt = $memberMgr->getMemberPwdCheck($db);	
			else:
				echo "시스템 오류!!";
				exit;
			endif;
			if($memberCnt<=0):
				// 회원정보 없음.
				echo "비밀번호가 틀렸습니다.";
				exit;
			endif;

			## 회원 탈퇴 정보 업데이트
			$m_out_txt = $_POST['out_txt'];
			$memberMgr->setM_OUT_TXT($m_out_txt);
			$memberMgr->setM_NO($g_member_no);
			$memberMgr->getMemberOut($db);

			## 메일 발송
			include_once MALL_SHOP . '/layout/mail/_config.inc.php';
			if($EM_SETTING_USE == "Y"):

				## 기본 설정
				$isSendMail = true;
				$strLang = $S_SITE_LNG;
				$strLangLower = strtolower($strLang);
				$strMailKey = "006";
				$aryMailInfo = $EM_SETTING_DATA[$strLang][$strMailKey];
				$strEM_AUTO = $aryMailInfo['EM_AUTO'];
				$strEM_SENDER = $aryMailInfo['EM_SENDER'];
				$strEM_TITLE = $aryMailInfo['EM_TITLE'];
				$strMailFile = MALL_SHOP . "/layout/mail/mailContents_{$strLangLower}_{$strMailKey}.html";
				$strMemberEmail = $g_member_email;
				$strMemberName = $g_member_name; // 이름
				$strMemberLastName = $g_member_last_name; // 성
				
				## 전제 이름 설정
				$strMemberFullName = $strMemberLastName; 
				if($strMemberName):
					if($strMemberFullName) { $strMemberFullName .= " "; }
					$strMemberFullName .= $strMemberName;
				endif;

				## 제목 설정
				$strEM_TITLE = str_replace("{{__회원명__}}", $strMemberFullName, $strEM_TITLE);

				## 내용 설정
				$strMailText = FileDevice::getContents($strMailFile);
				$strMailText = str_replace("{{__회원명__}}", $strMemberFullName, $strMailText);
				$strMailText = str_replace("{{__회사명__}}", $S_COM_NM, $strMailText);
				$strMailText = str_replace("{{__회사주소__}}", "({$S_COM_ZIP}){$S_COM_ADDR}", $strMailText);
				$strMailText = str_replace("{{__대표자명__}}", $S_REP_NM, $strMailText);
				$strMailText = str_replace("{{__사업자번호__}}", $S_COM_NUM1, $strMailText);
				$strMailText = str_replace("{{__통신번호__}}", $S_COM_NUM2, $strMailText);
				$strMailText = str_replace("{{__전화번호__}}", $S_COM_PHONE, $strMailText);
				$strMailText = str_replace("{{__개인정보_담당자__}}", $S_PIM_NAME, $strMailText);
				$strMailText = str_replace("{{__개인정보_이메일__}}", $S_PIM_MAIL, $strMailText);
				$strMailText = str_replace("{{__사이트주소__}}", $S_SITE_URL, $strMailText);
				
				## 체크
				if($strEM_AUTO != "Y") { $isSendMail = false; }
				if(!$strMailText) { $isSendMail = false; }

				## 메일 전송
				if($isSendMail):
					$param['SEND_NAME'] = $S_SITE_NM;
					$param['SEND_EMAIL'] = $strEM_SENDER;
					$param['RECEIVE_NAME'] = $strMemberFullName;
					$param['RECEIVE_EMAIL'] = $strMemberEmail;
					$param['TITLE'] = $strEM_TITLE;
					$param['TEXT'] = $strMailText;
					EmailInfo::goSendEmail($param);
				endif;

			endif;

			## 세션 삭제
			$_SESSION[SESS_MEMBER_LOGIN]				= false;
			$_SESSION[SESS_MEMBER_ID]					= "";
			$_SESSION[SESS_MEMBER_NAME]					= "";
			$_SESSION[SESS_MEMBER_LAST_NAME]			= "";		
			$_SESSION[SESS_MEMBER_GROUP]				= "";
			$_SESSION[SESS_MEMBER_NO]					= "";
			$_SESSION[SESS_MEMBER_EMAIL]				= "";
			$_SESSION[SESS_MEMBER_IPADDR]				= "";
			$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]		= "";
			$_SESSION[SESS_MEMBER_NICKNAME]				= "";

			setCookie("COOKIE_CART_PRIKEY","",time()-86400,"/");

			session_destroy();

			$strUrl = "./?menuType=mypage&mode=popDropout&callBack=goMemberDropoutCallBackEvent";

		break;
		case "memberPhoneKeyExpire":
			// 인증키 만료(json Mode)

			## STEP 1.
			## 세션 삭제
			$_SESSION['SESS_MEMBER_JOIN_CNT']	= "";	// 요청 건수
			$_SESSION['SESS_MEMBER_JOIN_TIME']	= "";	// 요청 시간
			$_SESSION['SESS_MEMBER_JOIN_HP']	= "";	// 휴대폰 번호		
			$_SESSION['SESS_MEMBER_JOIN_KEY']	= "";	// 인증 키

			## STEP 2.
			## 결과값
			$result[0]['RET']					= "EXPIRE";

			## STEP 3.
			## JSON 전송
			$result_array = json_encode($result);
			echo $result_array;
			$db->disConnect();
			exit;			
		break;
		case "memberPhoneKeyRequest":
			// 인증키 요청(json Mode)

			## STEP 1.
			## 마지막 요청 시간 체크
			$nowTime = time();
			$oldTime = $_SESSION['SESS_MEMBER_JOIN_TIME'];
			if($oldTime) { $time    = ($nowTime - $oldTime) / 60; }
			if($time && $time > 5) { $_SESSION['SESS_MEMBER_JOIN_CNT'] = ""; }

			## STEP 2.
			## 인증키 3회 이상 수행 정지 정책.
			if($_SESSION['SESS_MEMBER_JOIN_CNT'] > 3):
				$result[0]['AFTER']		= $time;
				$result[0]['RET']		= "OVER";
				$result_array = json_encode($result);
				echo $result_array;
				$db->disConnect();
				exit;
			endif;

			## STEP 4.
			## 인증키 생성
			require_once "{$S_DOCUMENT_ROOT}www/classes/string/string.func.class.php";
			$stringFunc							= new StringFunc();
			$key								= $stringFunc->getCode(6, "OP_INTEGER");
			$_SESSION['SESS_MEMBER_JOIN_CNT']	= $_SESSION['SESS_MEMBER_JOIN_CNT'] + 1;	// 요청 건수
			$_SESSION['SESS_MEMBER_JOIN_TIME']	= time();									// 요청 시간
			$_SESSION['SESS_MEMBER_JOIN_HP']	= $_POST['hp'];								// 휴대폰 번호		
			$_SESSION['SESS_MEMBER_JOIN_KEY']	= $key;										// 인증 키
//			$_SESSION['SESS_MEMBER_JOIN_KEY']	= "333333";									// 인증 키

			## STEP 5.
			## 인증키 전송
			require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
			$smsFunc			= new SmsFunc();
			$smsCode			= "001";
			$smsPhone			= "{$_REQUEST['hp']}";		
			$smsCallBackPhone	= $S_COM_PHONE;
			$smsMsg				= "[{$S_COM_NM }]본인인증번호는 {$key} 입니다. 정확히 입력해주세요.";
			$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
			$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1

			$result[0]['CNT']		= $_SESSION['SESS_MEMBER_JOIN_CNT'] + 1;	// 요청 건수
			$result[0]['TIME']		= $_SESSION['SESS_MEMBER_JOIN_TIME'];		// 요청 시간
			$result[0]['KEY']		= $_SESSION['SESS_MEMBER_JOIN_KEY'];		// 인증 키
			$result[0]['HP']		= $_SESSION['SESS_MEMBER_JOIN_HP'];			// 휴대폰 번호
			$result[0]['RET']		= "START";

			$result_array = json_encode($result);
			echo $result_array;
			$db->disConnect();
			exit;
		break;
		case "memberPhoneKeyCheck":
			// 인증키 확인(json Mode)

			## STEP 1.
			## 인증키 정보
			$joinCnt	= $_SESSION['SESS_MEMBER_JOIN_CNT'];
			$joinTime	= $_SESSION['SESS_MEMBER_JOIN_TIME'];
			$joinKey	= $_SESSION['SESS_MEMBER_JOIN_KEY'];
			$joinHp		= $_SESSION['SESS_MEMBER_JOIN_HP'];

			if($_POST['phoneKey'] != $joinKey || $_POST['hp'] != $joinHp):
				$result[0]['RET']		= "WRONG";
			else:
				$result[0]['RET']		= "CORRECT";
			endif;

			$result_array = json_encode($result);
			echo $result_array;
			$db->disConnect();
			exit;	
		break;

		case "memberDroupout":
			// 회원 탈퇴
			
			## STEP 1.
			## 회원 비밀번호 체크
			$pass = $_POST['pass'];
			if($S_MEM_CERITY == 1):			// 아이디 체크
				$memberMgr->setM_ID($g_member_id);
				$memberMgr->setM_PASS($pass);
				$memberCnt = $memberMgr->getMemberPwdCheck($db);		
			elseif($S_MEM_CERITY == 2):		// 이메일 체크
				$memberMgr->setM_MAIL($g_member_email);
				$memberMgr->setM_PASS($pass);
				$memberCnt = $memberMgr->getMemberPwdCheck($db);	
			else:
				echo "시스템 오류!!";
				exit;
			endif;
			if($memberCnt<=0):
				// 회원정보 없음.
				echo "비밀번호가 틀렸습니다.";
				exit;
			endif;

			## STEP 2.
			## 회원 탈퇴 정보 업데이트
			$m_out_txt = $_POST['out_txt'];
			$memberMgr->setM_OUT_TXT($m_out_txt);
			$memberMgr->setM_NO($g_member_no);
			$memberMgr->getMemberOut($db);

			## STEP 3.
			## 세션 삭제
			$_SESSION[SESS_MEMBER_LOGIN]				= false;
			$_SESSION[SESS_MEMBER_ID]					= "";
			$_SESSION[SESS_MEMBER_NAME]					= "";
			$_SESSION[SESS_MEMBER_LAST_NAME]			= "";		
			$_SESSION[SESS_MEMBER_GROUP]				= "";
			$_SESSION[SESS_MEMBER_NO]					= "";
			$_SESSION[SESS_MEMBER_EMAIL]				= "";
			$_SESSION[SESS_MEMBER_IPADDR]				= "";
			$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]		= "";
			$_SESSION[SESS_MEMBER_NICKNAME]				= "";

			setCookie("COOKIE_CART_PRIKEY","",time()-86400,"/");

			session_destroy();

			$strUrl = "./";

		break;
		case "memberModify":

			## STEP 1.
			## 회원 정보 불러오기.
			/* 오류.
			$memberMgr->setM_NO($g_member_no);
			$memberRow = $memberMgr->getMemberView($db);

			$memberMgr->setM_PASS($strM_PASS_ORG);

			$intPassCheck	= $memberMgr->getMemberPwdCheck($db);
			if(!$intPassCheck){
				goErrMsg('기존 비밀번호가 맞지 않습니다.'); //비밀번호 업데이트 도중 오류가 발생했습니다.
				exit;
			}

			$memberMgr->setM_PASS($strM_PASS);
			*/

			//회원정보 오류 수정. 남덕희
			if(!$strM_PASS_ORG){
				goErrMsg('기존 비밀번호 입력해 주세요.');
				exit;
			}
			$memberMgr->setM_NO($g_member_no);
			$memberRow = $memberMgr->getMemberView($db);

			$memberMgr->setM_ID($g_member_id);
			$memberMgr->setM_MAIL("");
			$memberMgr->setM_PASS($strM_PASS_ORG);

			$intPassCheck	= $memberMgr->getMemberPwdCheck($db);
			if($intPassCheck == 0){
				goErrMsg('기존 비밀번호가 맞지 않습니다.');
				exit;
			}else if($intPassCheck > 1){
				goErrMsg('SYSTEM ERROR');
				exit;
			}

			$memberMgr->setM_PASS($strM_PASS);
			$memberMgr->setM_MAIL($strM_MAIL);

			//$memberRow
			/** 아이디 체크 **/
			/** SSO인증여부 아이디 UPDATE */
			if ($SHOP_MEMBER_ID_MODIFY_FLAG == "Y" && !$memberRow['M_ID']){
				
				if ($_POST['id']){
					$memberMgr->setM_ID($_POST["id"]);
					$intCount = $memberMgr->getMemberIdCheck($db);
					if ($intCount > 0){
						goErrMsg($LNG_TRANS_CHAR['MS00017']); //"중복된 아이디가 존재합니다."
						exit;
					}
				}
			}

			/** 휴대폰 인증 모듈 **/

			## STEP 1.
			## 휴대폰 인증 모듈(세션 초기화)
//			$_SESSION['SESS_MEMBER_JOIN_MODE']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_CNT']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_TIME']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_KEY']		= "";
			$phoneCheck								= "Y";

			## STEP 2. 
			## 휴대폰 인증 모듈(사용 유무 체크)
//			require_once MALL_CONF_LIB."MemberMgr.php";	
//			$memberMgr		= new MemberMgr();
			$settingRow		= $memberMgr->getSettingView($db);
			if($settingRow['J_PHONE'] != "Y") { $phoneCheck = ""; }

			## STEP 3.
			## 휴대폰 인증 모듈(한국어 사이트 체크).
			if($S_SITE_LNG != "KR") { $phoneCheck = ""; }

			## STEP 4.
			## 휴대폰 인증 모듈(문자 발송 가능 건수 체크)
			require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
			$smsFunc		= new SmsFunc();
			$smsMoney		= $smsFunc->getSmsMoneySelect($db); // 머니 체크
			if($smsMoney['VAL'] <= 0) { $phoneCheck = ""; }

			## STEP 5.
			## 휴대폰 인증 모듈(휴대폰 인증키 체크)
			if($phoneCheck == "Y"):
				if($strM_HP != $memberRow['M_HP']): /** 2013.05.30 휴대폰 번호가 수정된 경우.. **/
					if(!$_SESSION['SESS_MEMBER_JOIN_KEY'] || !$_POST['phoneKey']):
						$db->disConnect();
						echo "입력된 인증키가 없습니다. 가입할 수 없습니다.";
						exit;
					endif;
					if(!$_SESSION['SESS_MEMBER_JOIN_HP'] || !$strM_HP):
						$db->disConnect();
						echo "입력된 휴대폰 번호가 없습니다. 가입할 수 없습니다.";
						exit;
					endif;
					if($_SESSION['SESS_MEMBER_JOIN_KEY'] != $_POST['phoneKey']):
						$db->disConnect();
						echo "인증키가 틀립니다. 가입할 수 없습니다.";
						exit;
					endif;
					if($_SESSION['SESS_MEMBER_JOIN_HP'] != $strM_HP):
						$db->disConnect();
						echo "휴대폰 번호가 틀립니다. 가입할 수 없습니다.";
						exit;
					endif;
				endif;
			endif;
			/** 휴대폰 인증 모듈 **/	

			/* 회원 그룹 설정 */
			$memberMgr->setM_GROUP($memberRow['M_GROUP']);

			/* 이메일 중복 체크 */
			if (!$memberMgr->getM_MAIL()) $memberMgr->setM_MAIL($memberRow[M_MAIL]);
			
			$intCount = $memberMgr->getMemberMailCheck($db);
			if ($intCount > 1){
				goErrMsg($LNG_TRANS_CHAR['MS00012']); //중복된 이메일이 존재합니다.
				exit;
			}
					
			/* password change */
			if(strlen(trim($strM_PASS))>0)
			{
				if($memberMgr->getMemberPwdUpdate($db) != 1)
				{
					goErrMsg($LNG_TRANS_CHAR['MS00028']); //비밀번호 업데이트 도중 오류가 발생했습니다.
					exit;
				}
			}
			$memberMgr->getMemberUpdate($db);
			
			/* 추가 사항 업데이트 */
			/* 사진 업로드 */
			$strMemberPhotoPath = "upload/member";
			if ($_FILES["photo"][name]){
		
				if (!getAllowImgFileExt($_FILES["photo"][name])){
					$memberMgr->setM_PHOTO($memberRow[M_PHOTO]);
				} else {
				
					$strFileName	= $_FILES["photo"][name];
					$strFileTmpName = $_FILES["photo"][tmp_name];
					$intFileSize	= $_FILES["photo"][size];
					$strFileType	= $_FILES["photo"][type];

					$fres = $fh->doUpload("photo_".$intM_NO,"../".$strMemberPhotoPath,$strFileName,$strFileTmpName,$intFileSize,$strFileType);

					if($fres) {
						$memberMgr->setM_PHOTO($fres[file_real_name]);

						if ($memberRow[M_PHOTO]){
							$fh->fileDelete("../".$strMemberPhotoPath."/".$memberRow[M_PHOTO]);
						}
					} 
				}
			}
			/* 사진 업로드 */
			
			/* tmp1 컬럼은 사용중이나 관리자 페이지에서만 컨트롤이 가능할때 원래 데이터값은 동일하게 유지(2013.08.16) - ahyeop */
			if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["MYPAGE"] != "Y"){
				$memberMgr->setM_TMP1($memberRow['M_TMP1']);
			}
			$memberMgr->getMemberAddUpdate($db);
			
			/* 회원 가족관계 INSERT/UPDATE */
			if ($S_MEM_FAMILY == "Y"){
				$memberMgr->setJI_GB("M");
				$aryFamilyItemList = $memberMgr->getJoinItemList($db);
				
				/* INSERT */
				$strMemberFamilyList = "";
				if (is_array($aryFamilyItemList)){
					
					for($i=0;$i<sizeof($aryFamilyItemList);$i++){
						if ($aryFamilyItemList[$i][JI_CODE] == "FAMILY_DAY"){
							$aryFAMILY_DAY1 = $_POST["fa_day1"];
							$aryFAMILY_DAY2 = $_POST["fa_day2"];
							$aryFAMILY_DAY3 = $_POST["fa_day3"];
							
						} else {
							${"ary".$aryFamilyItemList[$i][JI_CODE]} = $_POST["fa_".SUBSTR(STRTOLOWER($aryFamilyItemList[$i][JI_CODE]),7)];
						}
					}

					for($i=0;$i<sizeof($aryFAMILY_NAME);$i++){
						
						if ($aryFAMILY_NAME[$i]){
							$strMemberFamilyField  = " MF_NO";
							$strMemberFamilyField .= ",M_NO";
							$strMemberFamilyField .= ",MF_DATE";

							$strMemberFamilyData  = "''";
							$strMemberFamilyData .= ",".$memberMgr->getM_NO();
							$strMemberFamilyData .= ",NOW()";

							for($j=0;$j<sizeof($aryFamilyItemList);$j++){
								$strColVal = "";
								if ($aryFamilyItemList[$j][JI_CODE] == "FAMILY_DAY") {
									if (is_array($aryFAMILY_DAY1)){
										$strColVal	= $aryFAMILY_DAY1[$i]."-".$aryFAMILY_DAY2[$i]."-".$aryFAMILY_DAY3[$i];
									}
								} else {
									$aryColVal  = ${"ary".$aryFamilyItemList[$j][JI_CODE]};
									$strColVal	= $aryColVal[$i];
								}
								
								if ($strColVal!==null){
									$strMemberFamilyField .= ",MF_".SUBSTR($aryFamilyItemList[$j][JI_CODE],7);
									$strMemberFamilyData  .= ",'".$strColVal."'";
								}
							}
							
							$intMF_NO = $db->getInsertSql(TBL_MEMBER_FAMILY,$strMemberFamilyField,$strMemberFamilyData,true);
							$strMemberFamilyList .= $intMF_NO.",";
						}
					}
				}
				/* INSERT */

				/* UPDATE */
				$aryMF_NO = $_POST["fa_no"];
				if (is_array($aryMF_NO)){
					for($i=0;$i<sizeof($aryMF_NO);$i++){
						$intMF_NO = $aryMF_NO[$i];
						if ($intMF_NO > 0){
							$strMemberFamilyList .= $intMF_NO.",";
							
							$strMemberFamilyUpdateSql = "M_NO = ".$memberMgr->getM_NO();
							
							$strFAMILY_DAY1 = $_POST["fa_day1_".$intMF_NO];
							$strFAMILY_DAY2 = $_POST["fa_day2_".$intMF_NO];
							$strFAMILY_DAY3 = $_POST["fa_day3_".$intMF_NO];

							for($j=0;$j<sizeof($aryFamilyItemList);$j++){
								if ($aryFamilyItemList[$j][JI_CODE] == "FAMILY_DAY") {
									$strColVal = $strFAMILY_DAY1."-".$strFAMILY_DAY2."-".$strFAMILY_DAY3;
								} else {
									$strColVal = $_POST["fa_".SUBSTR(STRTOLOWER($aryFamilyItemList[$j][JI_CODE]),7)."_".$intMF_NO];
								}

								if ($strColVal!==null){
									$strMemberFamilyUpdateSql .= ",MF_".SUBSTR($aryFamilyItemList[$j][JI_CODE],7)." = '".$strColVal."'";
								}
							}
							$db->getUpdateSql(TBL_MEMBER_FAMILY,$strMemberFamilyUpdateSql," WHERE MF_NO = $intMF_NO AND M_NO = $g_member_no");
						}
					}
				}

				/* DELETE */
				if ($strMemberFamilyList){
					$strMemberFamilyList = SUBSTR($strMemberFamilyList,0,STRLEN($strMemberFamilyList)-1);
					$db->getDelete(TBL_MEMBER_FAMILY," M_NO = $g_member_no and MF_NO NOT IN (".$strMemberFamilyList.")");
				}

				/** 2013.04.19 회원 가족 관계 정보가 없으면, 가족 관계 모두 삭제 **/
				if (sizeof($_POST['fa_name']) == 1 && $_POST['fa_name'][0] == ""):
					$db->getDelete(TBL_MEMBER_FAMILY," M_NO = $g_member_no");
				endif;
			}
			/* 회원 가족관계 INSERT/UPDATE */

			/** TM ID **/
			if (!$memberRow[M_TM_ID] && $strM_TM_ID){
				$memberMgr->setM_ID($strM_TM_ID);
				$intCnt = $memberMgr->getMemberRecNo($db);
				
				if ($intCnt > 0) {
					$memberMgr->setM_NO($intM_NO);
					$memberMgr->setM_TM_ID($strM_TM_ID);
					$memberMgr->getMemberTmIdUpdate($db);
				}
			}
			/** TM ID **/

			/** SSO인증여부 아이디 UPDATE */
			if ($SHOP_MEMBER_ID_MODIFY_FLAG == "Y" && !$memberRow['M_ID']){
				if ($_POST['id']){
					$memberMgr->setM_ID($_POST["id"]);
					$memberMgr->getMemberIdUpdate($db);
				}
			}

			$strMsg = $LNG_TRANS_CHAR["MS00037"]; //내정보가 수정되었습니다.
			$strUrl = "./?menuType=mypage&mode=myInfo";

		break;

		case "join":
		case "join2":
			// 회원 가입

			/** 휴대폰 인증 모듈 **/

			## STEP 1.
			## 휴대폰 인증 모듈(세션 초기화)
//			$_SESSION['SESS_MEMBER_JOIN_MODE']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_CNT']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_TIME']		= "";
//			$_SESSION['SESS_MEMBER_JOIN_KEY']		= "";
			$phoneCheck								= "N";

			## STEP 2. 
			## 휴대폰 인증 모듈(사용 유무 체크)
//			require_once MALL_CONF_LIB."MemberMgr.php";	
//			$memberMgr		= new MemberMgr();
			$settingRow		= $memberMgr->getSettingView($db);
			if($settingRow['J_PHONE'] != "Y") { $phoneCheck = ""; }

			## STEP 3.
			## 휴대폰 인증 모듈(한국어 사이트 체크).
			if($S_SITE_LNG != "KR") { $phoneCheck = ""; }

			## STEP 4.
			## 휴대폰 인증 모듈(문자 발송 가능 건수 체크)
			//휴대폰 문자 사용안함 2015.05.26 kjp
			//require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
			//$smsFunc		= new SmsFunc();
			//$smsMoney		= $smsFunc->getSmsMoneySelect($db); // 머니 체크
			//if($smsMoney['VAL'] <= 0) { $phoneCheck = ""; }

			## STEP 5.
			## 휴대폰 인증 모듈(휴대폰 인증키 체크)
			if($phoneCheck == "Y"):
				if(!$_SESSION['SESS_MEMBER_JOIN_KEY'] || !$_POST['phoneKey']):
					$db->disConnect();
					echo "입력된 인증키가 없습니다. 가입할 수 없습니다.";
					exit;
				endif;
				if(!$_SESSION['SESS_MEMBER_JOIN_HP'] || !$strM_HP):
					$db->disConnect();
					echo "입력된 휴대폰 번호가 없습니다. 가입할 수 없습니다.";
					exit;
				endif;
				if($_SESSION['SESS_MEMBER_JOIN_KEY'] != $_POST['phoneKey']):
					$db->disConnect();
					echo "인증키가 틀립니다. 가입할 수 없습니다.";
					exit;
				endif;
				if($_SESSION['SESS_MEMBER_JOIN_HP'] != $strM_HP):
					$db->disConnect();
					echo "휴대폰 번호가 틀립니다. 가입할 수 없습니다.";
					exit;
				endif;
			endif;
			/** 휴대폰 인증 모듈 **/			

			$settingRow = $memberMgr->getSettingView($db);

			if ($S_SITE_LNG == "KR"){
				if ($settingRow[J_JUMIN] == "Y" || $settingRow[J_IPIN] == "Y"){
					$strRequestEncType	= $_POST["sEnctype"];
					$strRequestNo		= $_POST["sRequestNO"];
					$strRequestSafeId	= $_POST["sSafeId"];
					
					if ($strRequestEncType == "I" && $settingRow[J_IPIN] == "Y"){
						if ($_SESSION['CPREQUEST'] != $strRequestNo){
							goErrMsg("요청번호가 불일치 합니다. 다시 시도해주세요.");
							exit;
						}
					}
					
					if (!$strRequestEncType && $settingRow[J_JUMIN] == "Y"){
						if ($_SESSION['REQ_SEQ'] != $strRequestNo){
							goErrMsg("요청번호가 불일치 합니다. 다시 시도해주세요.");
							exit;
						}
					}

				}
			}

			if ($S_MEM_CERITY == "1"){
				//$intCount = $memberMgr->getMemberIdCheck($db);
				//if ($intCount > 0){
				//	goErrMsg($LNG_TRANS_CHAR['MS00017']); //"중복된 아이디가 존재합니다."
				//	exit;
				//}

				//$memberMgr->setM_ID($strM_ID);
				$intTotalCount = $memberMgr->getMemberIdCheck($db);

				$intCount = $memberMgr->getMemberValidIdCheck($db);

				$intValidCount = 0;
				if($intTotalCount == $intCount){
					$intValidCount = $intCount;
				}

				if ($intValidCount > 0) {
					goErrMsg($LNG_TRANS_CHAR['MS00017']); //"중복된 아이디가 존재합니다."
					exit;
				} else {

					$arySetting = $memberMgr->getSettingView($db);

					$aryMemberReJoinCheck = $memberMgr->getMemberReJoinCheck($db);
					$intCountCheck=0;
					if(is_array($aryMemberReJoinCheck)){
						foreach($aryMemberReJoinCheck as $key => $val)
						{
							$strMemberOutDate = explode(" ",$aryMemberReJoinCheck[$key]['M_OUT_DT']);
							$intOutDt = strtotime($strMemberOutDate[0]);
							$intNowDt = strtotime(date('Y-m-d'));
							$intLastDt = $intNowDt - $intOutDt;
							$intReJoinTime = 60*60*24*$arySetting[J_RE_DAY];//초단위로계산
							//echo $intLastDt.":".$intReJoinTime;
							if($intReJoinTime != 0)
							{
								if($intLastDt < $intReJoinTime)
								{
									$intCountCheck ++;
								}
							}
						}
					}


					if($intCountCheck > 0){
						goErrMsg($LNG_TRANS_CHAR['MS00017']."2"); //"중복된 아이디가 존재합니다."
						exit;
					}
				}

				if ($S_JOIN_NICK_NAME_USE == "Y"){
					$intCount = $memberMgr->getMemberNickNameCheck($db);
					if ($intCount > 0){
						goErrMsg($LNG_TRANS_CHAR["MS00033"]); //"중복된 닉네임이 존재합니다."
						exit;
					}
				}

				/* 불가 ID 체크*/
				$aryRegNoIdList = explode(",",$settingRow[J_NO_ID]);
				for($i=0;$i<sizeof($aryRegNoIdList);$i++){
					if ($aryRegNoIdList[$i] == $strM_ID){
						goErrMsg($LNG_TRANS_CHAR['MS00018']); //"등록할 수 없는 아이디입니다."
						break;
						exit;
					}
				}
			}
			
			/* 이메일 중복 체크 */
			if ($strAct == "join"){
				$intCount = $memberMgr->getMemberMailCheck($db);
				if ($intCount > 0){
					goErrMsg($LNG_TRANS_CHAR["MS00012"]);
					exit;
				}
			}

			/* 가입시 인증여부 */
			if ($settingRow[J_CERITY] == "Y"){
				$memberMgr->setM_AUTH("N");
			}

			/* 가입시 회원그룹 */
			if ($strM_GROUP) $memberMgr->setM_GROUP($strM_GROUP); 
			else {
				if ($strMemberJoinType) $memberMgr->setM_GROUP($strMemberJoinType); 
				else $memberMgr->setM_GROUP($settingRow[J_GROUP]);
			}
			/* 추천인 확인 */
			if ($strM_REC_ID){
				$memberMgr->setM_REC_ID("");
			}

			$memberMgr->getMemberInsert($db);
			$intM_NO = $db->getLastInsertID();
			$memberMgr->setM_NO($intM_NO);

			/* 사진 업로드 */
			$strMemberPhotoPath = "upload/member";
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

			/* 회원 가족관계 INSERT */
			if ($S_MEM_FAMILY == "Y"){
				$memberMgr->setJI_GB("M");
				$aryFamilyItemList = $memberMgr->getJoinItemList($db);
				
				if (is_array($aryFamilyItemList)){
					
					for($i=0;$i<sizeof($aryFamilyItemList);$i++){
						if ($aryFamilyItemList[$i][JI_CODE] == "FAMILY_DAY"){
							$aryFAMILY_DAY1 = $_POST["fa_day1"];
							$aryFAMILY_DAY2 = $_POST["fa_day2"];
							$aryFAMILY_DAY3 = $_POST["fa_day3"];
							
						} else {
							${"ary".$aryFamilyItemList[$i][JI_CODE]} = $_POST["fa_".SUBSTR(STRTOLOWER($aryFamilyItemList[$i][JI_CODE]),7)];
						}
					}

					for($i=0;$i<sizeof($aryFAMILY_NAME);$i++){
						
						if ($aryFAMILY_NAME[$i]){
							$strMemberFamilyField  = " MF_NO";
							$strMemberFamilyField .= ",M_NO";
							$strMemberFamilyField .= ",MF_DATE";

							$strMemberFamilyData  = "''";
							$strMemberFamilyData .= ",".$intM_NO;
							$strMemberFamilyData .= ",NOW()";

							for($j=0;$j<sizeof($aryFamilyItemList);$j++){
								$strColVal = "";
								if ($aryFamilyItemList[$j][JI_CODE] == "FAMILY_DAY") {
									if (is_array($aryFAMILY_DAY1)){
										$strColVal	= $aryFAMILY_DAY1[$i]."-".$aryFAMILY_DAY2[$i]."-".$aryFAMILY_DAY3[$i];
									}
								} else {
									$aryColVal  = ${"ary".$aryFamilyItemList[$j][JI_CODE]};
									$strColVal	= $aryColVal[$i];
								}
								
								if ($strColVal!==null){
									$strMemberFamilyField .= ",MF_".SUBSTR($aryFamilyItemList[$j][JI_CODE],7);
									$strMemberFamilyData  .= ",'".$strColVal."'";
								}
							}
							
							$db->getInsertSql(TBL_MEMBER_FAMILY,$strMemberFamilyField,$strMemberFamilyData,false);
						}
					}
				}
			}
			/* 회원 가족관계 INSERT */

			/* 방문수(로그인) UPDATE(이전 사이트의 회원 데이터가 있을 경우 가입시 visit를 1로 업데이트 해준다. */
			if ($S_MEM_PASS_RECOVERY){
				$memberMgr->setM_NO($intM_NO);
				$memberMgr->getMemberVisitUpdate($db);
			}
			/* 가입시 포인트 확인*/
			if ($settingRow[J_POINT] > 0){
				$memberMgr->setM_NO($intM_NO);	
				$memberMgr->setM_POINT($settingRow[J_POINT]);
				$memberMgr->getMemberPointUpdate($db);
				
				/* 포인트 관리 데이터 INSERT */
				$memberMgr->setM_NO($intM_NO);
				$memberMgr->setB_NO(0);
				$memberMgr->setO_NO(0);
				$memberMgr->setPT_TYPE('004');
				$memberMgr->setPT_POINT($memberMgr->getM_POINT());
				$memberMgr->setPT_MEMO($LNG_TRANS_CHAR["MW00061"]); //회원가입포인트
				$memberMgr->setPT_START_DT(date("Y-m-d"));
				$memberMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
				$memberMgr->setPT_REG_IP($S_REOMTE_ADDR);
				$memberMgr->setPT_ETC($intRecNo);
				$memberMgr->setPT_REG_NO(1);
				$memberMgr->setPT_POINT_USE_YEAR($S_POINT_USE_YEAR);
				$memberMgr->getMemberPointInsert($db);
			}
			
			/* 추천인 포인트 지급 */
			if ($strM_REC_ID){
				$memberMgr->setM_ID("");
				$memberMgr->setM_MAIL("");
				
				if ($S_MEM_CERITY == "1"){
					$memberMgr->setM_ID($strM_REC_ID);
				} else {
					$memberMgr->setM_MAIL($strM_REC_ID);
				}
				$intRecNo = $memberMgr->getMemberRecNo($db);

				if ($intRecNo > 0) {
					
					/*추천인 M_NO UPDATE */
					$memberMgr->setM_REC_ID($intRecNo);
					$memberMgr->getMemberRecNoUpdate($db);

					/* 신규 가입회원 포인트 지급 */
					if ($settingRow[J_REC_POINT1] > 0){
						$memberMgr->setM_NO($intM_NO);	
						$memberMgr->setM_POINT($settingRow[J_REC_POINT1]);
						$memberMgr->getMemberPointUpdate($db);
						
						/* 포인트 관리 데이터 INSERT */
						$memberMgr->setM_NO($intM_NO);
						$memberMgr->setB_NO(0);
						$memberMgr->setO_NO(0);
						$memberMgr->setPT_TYPE('004');
						$memberMgr->setPT_POINT($memberMgr->getM_POINT());
						$memberMgr->setPT_MEMO($LNG_TRANS_CHAR["MW00062"]); //회원가입[추천인]
						$memberMgr->setPT_START_DT(date("Y-m-d"));
						$memberMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
						$memberMgr->setPT_REG_IP($S_REOMTE_ADDR);
						$memberMgr->setPT_ETC($intRecNo);
						$memberMgr->setPT_REG_NO(1);
						$memberMgr->setPT_POINT_USE_YEAR($S_POINT_USE_YEAR);
						$memberMgr->getMemberPointInsert($db);
					}
					
					/* 추천인 포인트 지급 */
					if ($settingRow[J_REC_POINT2] > 0){
						$memberMgr->setM_NO($intRecNo);	
						$memberMgr->setM_POINT($settingRow[J_REC_POINT2]);
						$memberMgr->getMemberPointUpdate($db);
						
						/* 포인트 관리 데이터 INSERT */
						$memberMgr->setM_NO($intRecNo);
						$memberMgr->setO_NO(0);
						$memberMgr->setB_NO(0);
						$memberMgr->setPT_TYPE('004');
						$memberMgr->setPT_POINT($memberMgr->getM_POINT());
						$memberMgr->setPT_MEMO($LNG_TRANS_CHAR["MW00063"]); //추천인[회원가입]
						$memberMgr->setPT_START_DT(date("Y-m-d"));
						$memberMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
						$memberMgr->setPT_REG_IP($S_REOMTE_ADDR);
						$memberMgr->setPT_ETC($intM_NO);
						$memberMgr->setPT_REG_NO(1);
						$memberMgr->setPT_POINT_USE_YEAR($S_POINT_USE_YEAR);
						$memberMgr->getMemberPointInsert($db);
					}
				}
			}
			
			/* 회원가입쿠폰발급 */
			if ($intM_NO > 0){
				$couponMgr->setSearchCouponIssue("3");
				$couponMgr->setSearchCouponUse("Y");			
				$intCouponTotal = $couponMgr->getCouponTotal($db);
				$couponMgr->setLimitFirst(0);
				$couponMgr->setPageLine($intCouponTotal);
				
				if ($intCouponTotal > 0){
					$couponRet = $couponMgr->getCouponList($db);
					while($couponRow = mysql_fetch_array($couponRet)){
						$couponMgr->setCU_NO($couponRow[CU_NO]);

						$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
						$couponMgr->setCI_CODE($strCouponCode);
						$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
						if ($intDupCnt > 0){
							$strFlag = false;

							while($strFlag == false){

								$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
								$couponMgr->setCI_CODE($strCouponCode);
								$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
								
								if($intDupKeyCnt=="0"){
									$strFlag = true;
									break;
								}
							}
						}
						
						$couponMgr->setM_NO($intM_NO);
						$couponMgr->setCI_REG_NO($intM_NO);
						$couponMgr->getIssueInsert($db);
					}
				}
			}

			/** TM ID **/
			if ($strM_TM_ID){
				$memberMgr->setM_ID("");
				$memberMgr->setM_MAIL("");
				
				if ($strAct == "join2") {
					$memberMgr->setM_NO($intM_NO);
					$memberMgr->setM_TM_ID($strM_TM_ID);
					$memberMgr->getMemberTmIdUpdate($db);
				} else {
					$memberMgr->setM_ID($strM_TM_ID);
					$intCnt = $memberMgr->getMemberRecNo($db);
					
					if ($intCnt > 0) {
						$memberMgr->setM_NO($intM_NO);
						$memberMgr->setM_TM_ID($strM_TM_ID);
						$memberMgr->getMemberTmIdUpdate($db);
					}
				}
			}
			/** TM ID **/

			/** 사용언어 */
			$memberMgr->setM_LNG($S_SITE_LNG);
			$memberMgr->getMemberLngUpdate($db);
			/** 사용언어 */

			/** 입점사 관리자 등록 **/
			if ($intShopNo > 0){
				$shopMgr->setSH_NO($intShopNo);
				$shopMgr->setM_NO($intM_NO);
				$shopMgr->setSU_TYPE("A");
				$shopMgr->setSU_USE("N");
				$shopMgr->getShopUserInsert($db);
			}

			/** 메일 전송 **/
			$memberMgr->setM_NO($intM_NO);
			$memberRow = $memberMgr->getMemberView($db);
			/** 메일 전송 **/
			
			$strMailMode = "join";
			include WEB_FRWORK_ACT."memberMailForm.inc.php";

			$aryTAG_LIST['{{__받는사람이름__}}']	= $strM_F_NAME." ".$strM_L_NAME;
			$aryTAG_LIST['{{__받는사람메일__}}']	= $strM_MAIL;
			$aryTAG_LIST['{{__회원명__}}']			= $strM_F_NAME." ".$strM_L_NAME;
			$aryTAG_LIST['{{__회원가입정보__}}']	= $strMemberInfoHtml;
			
			goSendMail("001");
			/** 메일 전송 **/

			## 2015.01.15 kim hee sung SMS 모듈 V2.0
			## 한국어 전용
			## 관리자페이지에서 SMS 사용함 설정된 경우

			## 설정파일 불러오기
			include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';

			if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

				## 사용자 SMS
				## 모듈 설정
				$objSmsInfo = new SmsInfo($db);

				## 코드 설정
				$strSmsCode = "001"; // 회원가입 축하(고객용)

				if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

					## 문자 설정
					$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
					$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
					$strSmsMsg			= str_replace("{{고객명}}", $memberRow['M_L_NAME'], $strSmsMsg);

					## SMS 전송
					$param = '';
					$param['phone']			= $memberRow['M_HP'];		
					$param['callBack']		= $S_COM_PHONE;	
					$param['msg']			= $strSmsMsg;
					$param['siteName']		= $S_SITE_KNAME;
					$objSmsInfo->goSendSms($param);

				endif;

				## 관리자 SMS
				## 필요시 추가하세요..

			endif;	

			/** 2013.04.18 SMS 전송 모듈 추가 **/
			## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
// 2015.01.15 kim hee sung 소스 정리 및 sms 작동 오류 수정
//			if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//				$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//				if($smsMoney['VAL'] > 0):
//					$smsCode			= "001";
//					$smsPhone			= "{$_POST['hp1']}{$_POST['hp2']}{$_POST['hp3']}";		
//					$smsCallBackPhone	= $S_COM_PHONE;
//					$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//					$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//					$smsMsg				= str_replace("{{고객명}}", $_POST['l_name'], $smsMsg);
//					if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] =="Y"): //  자동발송 사용..
//						$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//						$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//					endif;
//				else:
//					// sms 머니 부족.. 부분 처리..
//				endif;
//			endif;
			/** 2013.04.18 SMS 전송 모듈 추가 **/
			

			/* 회원 가입 아이디 확인 */
			$_SESSION["SESS_MEMBER_JOIN_ID"] = $strM_ID;
			/* 회원 가입 아이디 확인 */

			$strUrl = "./?menuType=".$strMenuType."&mode=joinEnd&target=$strPageTarget&id=".$strM_ID;
			if ($S_MEM_CERITY == "2"){
				$_SESSION["SESS_MEMBER_JOIN_ID"] = $strM_MAIL;
				$strUrl = "./?menuType=".$strMenuType."&mode=joinEnd&target=$strPageTarget&id=".$strM_MAIL;
			}
			
			/* 회원가입시 그룹 클릭으로 들어왔을때 */
			if ($strUrl && $strMemberJoinType) $strUrl .= "&joinType=".$strMemberJoinType;

			/* 입점사 신청으로 들어왔을때 */
			if ($intShopNo > 0) $strUrl = "./?menuType=shop&mode=shopApplyEnd";
		break;

		case "login":
			
			$result_array = array();

			$strLOGIN_TYPE = $_POST["login_type"]; //sso 인증 여부
			
			if (!$strLOGIN_ID){
				$db->disConnect();
				goErrMsg($LNG_TRANS_CHAR["MS00022"]); //"아이디/메일을 입력해주세요."
				exit;
			}

			if (!$strLOGIN_PWD){
				$db->disConnect();
				goErrMsg($LNG_TRANS_CHAR["MS00022"]); //"아이디/메일을 입력해주세요."
				exit;
			}

			if ($S_MEM_CERITY == "1") $memberMgr->setM_ID($strLOGIN_ID);
			else $memberMgr->setM_MAIL($strLOGIN_ID);
			$memberMgr->setM_PASS($strLOGIN_PWD);

			if ($strLOGIN_COM) $memberMgr->setM_TM_ID($strLOGIN_COM);
			
			if ($strLOGIN_TYPE == "F"){
				$memberMgr->setM_ID("");
				$memberMgr->setM_MAIL("");

				$memberMgr->setM_TMP1($strLOGIN_ID);
			}			
			$row = $memberMgr->getMemberInfo($db);		

			$memberMgr->setM_NO($row[M_NO]);

			if ($row){
				/* 사이트이전시 회원 비밀번호 비교 */
				$strPreSitePassOk = "N";
				if ($S_MEM_PASS_RECOVERY && !$row[M_VISIT_CNT]){
					if ($S_MEM_PASS_RECOVERY == "MD5" || $S_MEM_PASS_RECOVERY == "CRYPT"){
						if ($S_MEM_PASS_RECOVERY == "MD5" && md5($strLOGIN_PWD) == $row[M_PASS] ){
							$strPreSitePassOk = "Y";
						}
						
						if ($S_MEM_PASS_RECOVERY == "CRYPT" && @crypt($strLOGIN_PWD,"MALL") == $row[M_PASS] ){
							$strPreSitePassOk = "Y";
						}

						if ($strPreSitePassOk != "Y"){
							if ($strPageTarget){
								$db->disConnect();
								$result[0]["RET"] = "N";
								$result[0]["MSG"] = $LNG_TRANS_CHAR["MS00011"];	
								$result_array = json_encode($result);
								echo $result_array;
								exit;
							} else {
								$db->disConnect();
								goErrMsg($LNG_TRANS_CHAR["MS00011"]); //"비밀번호가 일치하지 않습니다."
								exit;
							}
						}
					}
				}
				
				if ($strPreSitePassOk == "Y" || $memberMgr->getMemberPwdCheck($db) > 0){

					if ($row[M_OUT] == "Y"){
						if ($strPageTarget){
							$db->disConnect();
							$result[0]["RET"] = "N";
							$result[0]["MSG"] = $LNG_TRANS_CHAR["MS00034"];	
							$result_array = json_encode($result);
							echo $result_array;
							exit;
						} else {
							goErrMsg($LNG_TRANS_CHAR["MS00034"]); //"탈퇴한 회원입니다."
							exit;
						}
					}
					
					$_SESSION[SESS_MEMBER_LOGIN]	= true;
					
					if ($S_MEM_CERITY == "1") $_SESSION[SESS_MEMBER_ID]		= $row[M_ID];
					else $_SESSION[SESS_MEMBER_ID]		= $row[M_MAIL];

					$_SESSION[SESS_MEMBER_NAME]				= $row[M_F_NAME];
					$_SESSION[SESS_MEMBER_LAST_NAME]		= $row[M_L_NAME];		
					$_SESSION[SESS_MEMBER_GROUP]			= $row[M_GROUP];
					$_SESSION[SESS_MEMBER_GROUP_NAME]		= $row[G_NAME];
					$_SESSION[SESS_MEMBER_LEVEL]			= $row[G_LEVEL];
					$_SESSION[SESS_MEMBER_NO]				= $row[M_NO];
					$_SESSION[SESS_MEMBER_EMAIL]			= $row[M_MAIL];
					$_SESSION[SESS_MEMBER_IPADDR]			= $S_REOMTE_ADDR;
					$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]	= false;
					$_SESSION[SESS_MEMBER_NICKNAME]			= $row[M_NICK_NAME];
	
					/* 방문수(로그인) UPDATE */
					$memberMgr->getMemberVisitUpdate($db);
					
					/* 사이트 이전 회원은 비밀번호 업데이트 */
					if ($strPreSitePassOk == "Y"){
						$memberMgr->getMemberPwdUpdate($db);
					}

					if ($strAutoLogin == "Y"){
						setCookie("COOKIE_AUTO_LOGIN",$strLOGIN_ID,time()+(86400 * 30),"/");						
						setCookie("COOKIE_AUTO_LOGIN_TYPE",$strLOGIN_TYPE,time()+(86400 * 30),"/");
					} else {
						setCookie("COOKIE_AUTO_LOGIN","",time()-86400,"/");
						setCookie("COOKIE_AUTO_LOGIN_TYPE","",time()-86400,"/");
					}


					## APP UPDATE (M_NO 추가)
					//include MALL_CONF_LIB."MobileMgr.php";

					//$MobileMgr = new MobileMgr();
					//$strDeviceiD = $_COOKIE['device_id'];
					
					//$MobileMgr->setMOBILE_DEVICE_KEY($strDeviceiD);
					//$appKey = $MobileMgr->getMobileKey($db);
					//if(!$appKey[M_NO]){
					//	$MobileMgr->setM_NO($row[M_NO]);						
					//	$MobileMgr->getMobileKeyUpdate($db);
					//}


					if (is_array($aryCartNo)){
						/* 주문 로그인일때 가격 조정 필요 */
						$strCartParamList = "";
						for($i=0;$i<sizeof($aryCartNo);$i++){
							$productMgr->setM_NO($row[M_NO]);
							$productMgr->setPB_NO($aryCartNo[$i]);
							$productMgr->getProdBasketOrderLoginUpdate($db);
							
							$strCartParamList .= "<input type=\"hidden\" name=\"cartNo[]\" value=\"".$aryCartNo[$i]."\">";
						}
						$strCartParamList .= "<input type=\"hidden\" name=\"basketDirect\" value=\"Y\">";
						$db->disConnect();
						/* 주문 로그인일때 가격 조정 필요 */
						
						$aryForm["menuType"] = "order";
						$aryForm["mode"] = "order";
						$aryForm["act"] = "./ ";	

						drawPageRedirect("frmAct","./index.php",$aryForm,$strCartParamList);
						
						exit;

					} else {
						
						/* 로그인시 장바구니 회원번호 update */
						if ($g_cart_prikey){
							$productMgr->setM_NO($row[M_NO]);
							$productMgr->setPB_KEY($g_cart_prikey);
							$productMgr->getProdBasketLoginUpdate($db);
							setCookie("COOKIE_CART_PRIKEY","",time()-86400,"/");
						}
						/* 로그인시 장바구니 회원번호 update */

						$strUrl = "./";
						if ($strReturnMenu){
							if ($strReturnMenu == "community"){
								$strUrl .= "./?menuType=$strReturnMenu";
							} else {
								if ($strReturnMode) $strUrl .= "./?menuType=$strReturnMenu&mode=$strReturnMode";
							}
							
							$strReturnParam = str_replace("^0^","&",$strReturnParam);
							$strReturnParam = str_replace("^||^","=",$strReturnParam);
							
							if ($strReturnParam) $strUrl .= "&".$strReturnParam;
						}
						
						if ($strPageTarget){
							
							//goLayerPopUrl("",$strUrl,$strLayerClickType);
							$db->disConnect();
							$result[0]["RET"]	= "Y";
							$result[0]["URL"]	= $strUrl;
							$result[0]["TYPE"]	= $strLayerClickType;	
							$result_array = json_encode($result);
							echo $result_array;
							exit;
						}
					}

				} else {
					if ($strPageTarget){
						$db->disConnect();
						$result[0]["RET"] = "N";
						$result[0]["MSG"] = $LNG_TRANS_CHAR["MS00011"];	
						$result_array = json_encode($result);
						echo $result_array;
						exit;
					} else {
						goErrMsg($LNG_TRANS_CHAR["MS00011"]); //"비밀번호가 일치하지 않습니다."
						exit;
					}
				}
			} else {

				$strErrMsg = $LNG_TRANS_CHAR["MS00020"];
				if ($S_MEM_CERITY == "2") $strErrMsg = $LNG_TRANS_CHAR["MS00021"];
				if ($strPageTarget){
					$db->disConnect();
					$result[0]["RET"] = "N";
					$result[0]["MSG"] = $strErrMsg;	
					$result_array = json_encode($result);
					echo $result_array;
					exit;
				} else {
					goErrMsg($strErrMsg); //"존재하지 않는 아이디입니다."
					exit;
				}
			}

			// 2013.07.09 kim hee sung, 로그인을 시작한 시점으로 이동 기능 추가.
			if($_POST['http_referer']){
				
				$aryHttpRefer = explode("?",$_POST['http_referer']);
				$strReturnUrl = $aryHttpRefer[1];
				
//				if (!$strReturnUrl) $strReturnUrl = "menuType=main&mode=list";		
				if($strReturnUrl) { $strUrl = "./?{$strReturnUrl}"; }
				else { $strUrl = "./"; }
			} 

		break;

		case "logout":
			
			$_SESSION[SESS_MEMBER_LOGIN]				= false;
			$_SESSION[SESS_MEMBER_ID]					= "";
			$_SESSION[SESS_MEMBER_NAME]					= "";
			$_SESSION[SESS_MEMBER_LAST_NAME]			= "";		
			$_SESSION[SESS_MEMBER_GROUP]				= "";
			$_SESSION[SESS_MEMBER_GROUP_NAME]			= "";
			$_SESSION[SESS_MEMBER_NO]					= "";
			$_SESSION[SESS_MEMBER_EMAIL]				= "";
			$_SESSION[SESS_MEMBER_IPADDR]				= "";
			$_SESSION[SESS_MEMBER_FACEBOOK_LOGIN]		= "";
			$_SESSION[SESS_MEMBER_NICKNAME]				= "";

			setCookie("COOKIE_CART_PRIKEY","",time()-86400,"/");

			session_destroy();

			$strUrl = "./";
		break;

		case "memberFamilyInsertUpdate":
			
			/* 회원 정보 변경 */
			$memberMgr->setM_NO($g_member_no);

			/* 회원 가족관계 INSERT/UPDATE */
			if ($S_MEM_FAMILY == "Y"){
				$memberMgr->setJI_GB("M");
				$aryFamilyItemList = $memberMgr->getJoinItemList($db);
				
				/* INSERT */
				$strMemberFamilyList = "";
				if (is_array($aryFamilyItemList)){
					
					for($i=0;$i<sizeof($aryFamilyItemList);$i++){
						if ($aryFamilyItemList[$i][JI_CODE] == "FAMILY_DAY"){
							$aryFAMILY_DAY1 = $_POST["fa_day1"];
							$aryFAMILY_DAY2 = $_POST["fa_day2"];
							$aryFAMILY_DAY3 = $_POST["fa_day3"];
							
						} else {
							${"ary".$aryFamilyItemList[$i][JI_CODE]} = $_POST["fa_".SUBSTR(STRTOLOWER($aryFamilyItemList[$i][JI_CODE]),7)];
						}
					}

					$aryMF_NO = $_POST["fa_no"];
					for($i=0;$i<sizeof($aryFAMILY_NAME);$i++){
						
						if ($aryFAMILY_NAME[$i]){
							
							if ($aryMF_NO[$i]){
								
								$intMF_NO = $aryMF_NO[$i];
								if ($intMF_NO > 0){
									$strMemberFamilyList .= $intMF_NO.",";
									
									$strMemberFamilyUpdateSql = "M_NO = ".$memberMgr->getM_NO();
									
									for($j=0;$j<sizeof($aryFamilyItemList);$j++){
										if ($aryFamilyItemList[$j][JI_CODE] == "FAMILY_DAY") {
											$strColVal = $aryFAMILY_DAY1[$i]."-".$aryFAMILY_DAY2[$i]."-".$aryFAMILY_DAY3[$i];
										} else {
											$aryColVal  = ${"ary".$aryFamilyItemList[$j][JI_CODE]};
											$strColVal	= $aryColVal[$i];
										}

										if ($strColVal!==null){
											$strMemberFamilyUpdateSql .= ",MF_".SUBSTR($aryFamilyItemList[$j][JI_CODE],7)." = '".$strColVal."'";
										}
									}
									$db->getUpdateSql(TBL_MEMBER_FAMILY,$strMemberFamilyUpdateSql," WHERE MF_NO = $intMF_NO AND M_NO = $g_member_no");
								}

							} else {
							
								$strMemberFamilyField  = " MF_NO";
								$strMemberFamilyField .= ",M_NO";
								$strMemberFamilyField .= ",MF_DATE";

								$strMemberFamilyData  = "''";
								$strMemberFamilyData .= ",".$memberMgr->getM_NO();
								$strMemberFamilyData .= ",NOW()";

								for($j=0;$j<sizeof($aryFamilyItemList);$j++){
									$strColVal = "";
									if ($aryFamilyItemList[$j][JI_CODE] == "FAMILY_DAY") {
										if (is_array($aryFAMILY_DAY1)){
											$strColVal	= $aryFAMILY_DAY1[$i]."-".$aryFAMILY_DAY2[$i]."-".$aryFAMILY_DAY3[$i];
										}
									} else {
										$aryColVal  = ${"ary".$aryFamilyItemList[$j][JI_CODE]};
										$strColVal	= $aryColVal[$i];
									}
									
									if ($strColVal!==null){
										$strMemberFamilyField .= ",MF_".SUBSTR($aryFamilyItemList[$j][JI_CODE],7);
										$strMemberFamilyData  .= ",'".$strColVal."'";
									}
								}
								
								$intMF_NO = $db->getInsertSql(TBL_MEMBER_FAMILY,$strMemberFamilyField,$strMemberFamilyData,true);
								$strMemberFamilyList .= $intMF_NO.",";
							}
						}
					}
					
				}
				/* INSERT */

				/* DELETE */
				if ($strMemberFamilyList){
					$strMemberFamilyList = SUBSTR($strMemberFamilyList,0,STRLEN($strMemberFamilyList)-1);
					$db->getDelete(TBL_MEMBER_FAMILY," M_NO = $g_member_no and MF_NO NOT IN (".$strMemberFamilyList.")");
				}

				/* 등록된거는 존재하나 회원이 삭제하려고 할때 */
				if (!$strMemberFamilyList){
					if (is_array($aryMF_NO)){
						for($i=0;$i<sizeof($aryMF_NO);$i++){
							if ($aryMF_NO[$i]){
								$db->getDelete(TBL_MEMBER_FAMILY," M_NO = $g_member_no and MF_NO IN (".$aryMF_NO[$i].")");
							}
						}
					}
				}
				/* 등록된거는 존재하나 회원이 삭제하려고 할때 */

			}
			/* 회원 가족관계 INSERT/UPDATE */
			$strSubmitTarget = $_POST["submitTarget"];
			$strUrl = "./?menuType=member&mode=family&target=".$strPageTarget;
			if ($strSubmitTarget == "ifrm"){
				$db->disConnect();
				$aryMemberFamilyList = $memberMgr->getMemberFamilyList($db);
				
				include sprintf ( "%s%s/layout/member/member_family.html.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  );
				$db->disConnect();
				exit;
			}
		break;

		case "joinNameCheck":
		
			$settingRow = $memberMgr->getSettingView($db);
			
			if ($settingRow[J_JUMIN] == "Y"){
				include MALL_HOME."/web/frwork/act/member.cerity.php";
			}

			exit;		
		break;

	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>