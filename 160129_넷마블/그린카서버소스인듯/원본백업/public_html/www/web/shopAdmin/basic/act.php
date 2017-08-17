<?
	include_once($S_DOCUMENT_ROOT.$S_SHOP_HOME."/config/db_etc.php");

	/*##################################### Parameter 셋팅 #####################################*/
	$strS_SITE_NM		= $_POST["site_nm"]			? $_POST["site_nm"]			: $_REQUEST["site_nm"];
	$strS_SITE_ENG_NM	= $_POST["site_eng_nm"]		? $_POST["site_eng_nm"]		: $_REQUEST["site_eng_nm"];
	$strS_SITE_MAIL		= $_POST["site_mail"]		? $_POST["site_mail"]		: $_REQUEST["site_mail"];
	$strS_SITE_URL		= $_POST["site_url"]		? $_POST["site_url"]		: $_REQUEST["site_url"];
	$strS_COM_NM		= $_POST["com_nm"]			? $_POST["com_nm"]			: $_REQUEST["com_nm"];
	$strS_COM_BUSI1		= $_POST["com_busi1"]		? $_POST["com_busi1"]		: $_REQUEST["com_busi1"];
	$strS_COM_BUSI2		= $_POST["com_busi2"]		? $_POST["com_busi2"]		: $_REQUEST["com_busi2"];
	$strS_COM_ZIP1		= $_POST["com_zip1"]		? $_POST["com_zip1"]		: $_REQUEST["com_zip1"];
	$strS_COM_ZIP2		= $_POST["com_zip2"]		? $_POST["com_zip2"]		: $_REQUEST["com_zip2"];
	$strS_COM_ADDR		= $_POST["com_addr"]		? $_POST["com_addr"]		: $_REQUEST["com_addr"];
	$strS_COM_NUM1_1	= $_POST["com_num1_1"]		? $_POST["com_num1_1"]		: $_REQUEST["com_num1_1"];
	$strS_COM_NUM1_2	= $_POST["com_num1_2"]		? $_POST["com_num1_2"]		: $_REQUEST["com_num1_2"];
	$strS_COM_NUM1_3	= $_POST["com_num1_3"]		? $_POST["com_num1_3"]		: $_REQUEST["com_num1_3"];
	$strS_COM_NUM2_1	= $_POST["com_num2_1"]		? $_POST["com_num2_1"]		: $_REQUEST["com_num2_1"];
	$strS_COM_NUM2_2	= $_POST["com_num2_2"]		? $_POST["com_num2_2"]		: $_REQUEST["com_num2_2"];
	$strS_COM_NUM2_3	= $_POST["com_num2_3"]		? $_POST["com_num2_3"]		: $_REQUEST["com_num2_3"];
	$strS_REP_NM		= $_POST["rep_nm"]			? $_POST["rep_nm"]			: $_REQUEST["rep_nm"];
	$strS_COM_PHONE1	= $_POST["com_phone1"]		? $_POST["com_phone1"]		: $_REQUEST["com_phone1"];
	$strS_COM_PHONE2	= $_POST["com_phone2"]		? $_POST["com_phone2"]		: $_REQUEST["com_phone2"];
	$strS_COM_PHONE3	= $_POST["com_phone3"]		? $_POST["com_phone3"]		: $_REQUEST["com_phone3"];
	$strS_COM_FAX1		= $_POST["com_fax1"]		? $_POST["com_fax1"]		: $_REQUEST["com_fax1"];
	$strS_COM_FAX2		= $_POST["com_fax2"]		? $_POST["com_fax2"]		: $_REQUEST["com_fax2"];
	$strS_COM_FAX3		= $_POST["com_fax3"]		? $_POST["com_fax3"]		: $_REQUEST["com_fax3"];

	$strS_COM_HP1		= $_POST["com_hp1"]			? $_POST["com_hp1"]			: $_REQUEST["com_hp1"];
	$strS_COM_HP2		= $_POST["com_hp2"]			? $_POST["com_hp2"]			: $_REQUEST["com_hp2"];
	$strS_COM_HP3		= $_POST["com_hp3"]			? $_POST["com_hp3"]			: $_REQUEST["com_hp3"];

	$strS_SITE_TITLE	= $_POST["site_title"]		? $_POST["site_title"]		: $_REQUEST["site_title"];
	$strS_SITE_KEYWORD	= $_POST["site_keyword"]	? $_POST["site_keyword"]	: $_REQUEST["site_keyword"];
	$strS_SITE_COPY		= $_POST["site_copy"]		? $_POST["site_copy"]		: $_REQUEST["site_copy"];
	$strS_SITE_FACEBOOK	= $_POST["site_facebook"]	? $_POST["site_facebook"]	: $_REQUEST["site_facebook"];
	$strS_SITE_TWITTER  = $_POST["site_twitter"]	? $_POST["site_twitter"]	: $_REQUEST["site_twitter"];
	$strS_SITE_ME2TODAY	= $_POST["site_me2today"]	? $_POST["site_me2today"]	: $_REQUEST["site_me2today"];
	$strS_SITE_FACEBOOK_APP_ID	= $_POST["site_facebook_app_id"]	? $_POST["site_facebook_app_id"]	: $_REQUEST["site_facebook_app_id"];
	$strSITE_FACEBOOK_SECRET	= $_POST["site_facebook_secret"]	? $_POST["site_facebook_secret"]	: $_REQUEST["site_facebook_secret"];

	$strS_USE_POLICY	= $_POST["use_policy"]		? $_POST["use_policy"]		: $_REQUEST["use_policy"];
	$strS_PERSON_POLICY = $_POST["person_policy"]	? $_POST["person_policy"]	: $_REQUEST["person_policy"];

	$intS_AUTO_CANCEL		= $_POST["auto_cancel"]			? $_POST["auto_cancel"]			: $_REQUEST["auto_cancel"];
	$intS_AUTO_ORDER_END	= $_POST["auto_order_end"]		? $_POST["auto_order_end"]		: $_REQUEST["auto_order_end"];

	$strS_DELIVERY_ST		= $_POST["delivery_st"]			? $_POST["delivery_st"]			: $_REQUEST["delivery_st"];
	$intS_DELIVERY_FREE		= $_POST["delivery_free"]		? $_POST["delivery_free"]		: $_REQUEST["delivery_free"];
	$intS_DELIVERY_FEE		= $_POST["delivery_fee"]		? $_POST["delivery_fee"]		: $_REQUEST["delivery_fee"];
	$intS_DELIVERY_EXT		= $_POST["delivery_ext"]		? $_POST["delivery_ext"]		: $_REQUEST["delivery_ext"];
	$strS_DELIVERY_EXT_AREA = $_POST["delivery_ext_area"]	? $_POST["delivery_ext_area"]	: $_REQUEST["delivery_ext_area"];
	$strS_DELIVERY_COM		= $_POST["delivery_com"]		? $_POST["delivery_com"]		: $_REQUEST["delivery_com"];
	$aryS_DELIVERY_COM_CHK	= $_POST["delivery_com_chk"]	? $_POST["delivery_com_chk"]	: $_REQUEST["delivery_com_chk"];

	$strS_BANK				= $_POST["bank"]				? $_POST["bank"]				: $_REQUEST["bank"];
	$aryS_SETTLE			= $_POST["settle"]				? $_POST["settle"]				: $_REQUEST["settle"];
	$strS_PG				= $_POST["pg"]					? $_POST["pg"]					: $_REQUEST["pg"];
	$strS_FOR_PG1			= $_POST["for_pg"]				? $_POST["for_pg"]				: $_REQUEST["for_pg"];
	$strS_FOR_PG2			= $_POST["for_pg_card"]			? $_POST["for_pg_card"]			: $_REQUEST["for_pg_card"];
	$strS_FOR_PG3			= $_POST["for_alypay"]			? $_POST["for_alypay"]			: $_REQUEST["for_alypay"];
	$strS_FOR_PG4			= $_POST["for_pg_bank"]			? $_POST["for_pg_bank"]			: $_REQUEST["for_pg_bank"];
	$strS_FOR_BANK			= $_POST["for_bank"]			? $_POST["for_bank"]			: $_REQUEST["for_bank"];

	$strS_POINT_USE1			= $_POST["point_use1"]			? $_POST["point_use1"]			: $_REQUEST["point_use1"];
	$strS_POINT_USE2			= $_POST["point_use2"]			? $_POST["point_use2"]			: $_REQUEST["point_use2"];
	$strS_POINT_ORDER_STATUS	= $_POST["point_order_status"]	? $_POST["point_order_status"]	: $_REQUEST["point_order_status"];
	$strS_POINT_ST				= $_POST["point_st"]			? $_POST["point_st"]			: $_REQUEST["point_st"];
	$intS_POINT_ST_PRICE		= $_POST["point_st_price"]		? $_POST["point_st_price"]		: $_REQUEST["point_st_price"];
	$intS_POINT_PRICE			= $_POST["point_price"]			? $_POST["point_price"]			: $_REQUEST["point_price"];
	$strS_POINT_PRICE_UNIT		= $_POST["point_price_unit"]	? $_POST["point_price_unit"]	: $_REQUEST["point_price_unit"];
	$intS_POINT_PRICE_POS		= $_POST["point_price_pos"]		? $_POST["point_price_pos"]		: $_REQUEST["point_price_pos"];
	$intS_POINT_MIN				= $_POST["point_min"]			? $_POST["point_min"]			: $_REQUEST["point_min"];
	$intS_POINT_MAX				= $_POST["point_max"]			? $_POST["point_max"]			: $_REQUEST["point_max"];
	$strS_POINT_COUPON_USE		= $_POST["point_coupon_use"]	? $_POST["point_coupon_use"]	: $_REQUEST["point_coupon_use"];
	$intS_POINT_ORDER_GIVE      = $_POST["point_order_give"]	? $_POST["point_order_give"]	: $_REQUEST["point_order_give"];

	$strS_PIM_NAME				= $_POST["pim_name"]			? $_POST["pim_name"]			: $_REQUEST["pim_name"];
	$strS_PIM_HP				= $_POST["pim_hp"]				? $_POST["pim_hp"]				: $_REQUEST["pim_hp"];
	$strS_PIM_MAIL				= $_POST["pim_mail"]			? $_POST["pim_mail"]			: $_REQUEST["pim_mail"];
	$strS_PROD_DELIVERY			= $_POST["s_prod_delivery"]		? $_POST["s_prod_delivery"]		: $_REQUEST["s_prod_delivery"];
	$strS_PROD_RETURN			= $_POST["s_prod_return"]		? $_POST["s_prod_return"]		: $_REQUEST["s_prod_return"];

	$strS_PG_SITE_CODE			= $_POST["s_pg_site_code"]			? $_POST["s_pg_site_code"]			: $_REQUEST["s_pg_site_code"];
	$strS_PG_SITE_KEY			= $_POST["s_pg_site_key"]			? $_POST["s_pg_site_key"]			: $_REQUEST["s_pg_site_key"];

	/*공통관리*/
	$intSC_NO					= $_POST["sc_no"]				? $_POST["sc_no"]				: $_REQUEST["sc_no"];
	$strSC_TITLE				= $_POST["sc_title"]			? $_POST["sc_title"]			: $_REQUEST["sc_title"];
	$strSC_TEXT					= $_POST["sc_text"]				? $_POST["sc_text"]				: $_REQUEST["sc_text"];
	$intSC_REG_DT				= $_POST["sc_reg_dt"]			? $_POST["sc_reg_dt"]			: $_REQUEST["sc_reg_dt"];
	$intSC_REG_NO				= $_POST["sc_reg_no"]			? $_POST["sc_reg_no"]			: $_REQUEST["sc_reg_no"];
	$intSC_MOD_DT				= $_POST["sc_mod_dt"]			? $_POST["sc_mod_dt"]			: $_REQUEST["sc_mod_dt"];
	$intSC_MOD_NO				= $_POST["sc_mod_no"]			? $_POST["sc_mod_no"]			: $_REQUEST["sc_mod_no"];

	/* 쿠폰관리 */
	$strS_COUPON_USE			= $_POST["coupon_use"]			? $_POST["coupon_use"]			: $_REQUEST["coupon_use"];
	$strS_COUPON_LIMIT			= $_POST["coupon_limit"]		? $_POST["coupon_limit"]		: $_REQUEST["coupon_limit"];

	$strS_COM_NUM1		= $strS_COM_NUM1_1."-".$strS_COM_NUM1_2."-".$strS_COM_NUM1_3;
	$strS_COM_NUM2		= $strS_COM_NUM2_1."-".$strS_COM_NUM2_2."-".$strS_COM_NUM2_3;
	$strS_COM_ZIP		= $strS_COM_ZIP1."-".$strS_COM_ZIP2;
	$strS_COM_FAX		= $strS_COM_FAX1."-".$strS_COM_FAX2."-".$strS_COM_FAX3;
	$strS_COM_HP		= $strS_COM_HP1."-".$strS_COM_HP2."-".$strS_COM_HP3;

	## 전화번호 설정
	$strS_COM_PHONE		 = "";
	$strS_COM_PHONE		 = $strS_COM_PHONE1;
	if($strS_COM_PHONE && $strS_COM_PHONE2) { $strS_COM_PHONE .= "-"; }
	$strS_COM_PHONE		.= $strS_COM_PHONE2;
	if($strS_COM_PHONE && $strS_COM_PHONE3) { $strS_COM_PHONE .= "-"; }
	$strS_COM_PHONE		.= $strS_COM_PHONE3;

	/*슈퍼관리자 비밀번호*/
	$strA_STATUS		= $_POST["a_status"]		? $_POST["a_status"]		: $_REQUEST["a_status"];
	$strA_MEMO			= $_POST["a_memo"]			? $_POST["a_memo"]			: $_REQUEST["a_memo"];
	$strA_TM			= $_POST["a_tm"]			? $_POST["a_tm"]			: $_REQUEST["a_tm"];

	$strM_NOW_PWD		= $_POST["m_now_pwd"]		? $_POST["m_now_pwd"]	: $_REQUEST["m_now_pwd"];
	$strM_NEW_PWD		= $_POST["m_new_pwd1"]		? $_POST["m_new_pwd1"]	: $_REQUEST["m_new_pwd1"];

	//메뉴번호
	$aryChkMenuNo		= $_POST["mn_no"]			? $_POST["mn_no"]			: $_REQUEST["mn_no"];

	$strA_STATUS		= strTrim($strA_STATUS,1);
	$strA_MEMO			= strTrim($strA_MEMO,"");

	## 콤마(,) 제거
	$intS_POINT_ST_PRICE = str_replace(",", "", $intS_POINT_ST_PRICE);
	$intS_POINT_PRICE = str_replace(",", "", $intS_POINT_PRICE);
	$intS_POINT_PRICE_POS = str_replace(",", "", $intS_POINT_PRICE_POS);
	$intS_POINT_MIN = str_replace(",", "", $intS_POINT_MIN);
	$intS_POINT_MAX = str_replace(",", "", $intS_POINT_MAX);
	$intS_POINT_ORDER_GIVE = str_replace(",", "", $intS_POINT_ORDER_GIVE);

	/*##################################### Parameter 셋팅 #####################################*/

	$strS_SITE_NM		= strTrim($strS_SITE_NM,50);
	$strS_SITE_ENG_NM	= strTrim($strS_SITE_ENG_NM,50);
	$strS_SITE_MAIL		= strTrim($strS_SITE_MAIL,30);
	$strS_SITE_URL		= strTrim($strS_SITE_URL,255);
	$strS_COM_NM		= strTrim($strS_COM_NM,50);
	$strS_COM_BUSI1		= strTrim($strS_COM_BUSI1,30);
	$strS_COM_BUSI2		= strTrim($strS_COM_BUSI2,60);
	$strS_COM_ZIP		= strTrim($strS_COM_ZIP,7);
	$strS_COM_ADDR		= strTrim($strS_COM_ADDR,150);
	$strS_COM_NUM1		= strTrim($strS_COM_NUM1,20);
	$strS_COM_NUM2		= strTrim($strS_COM_NUM2,30);
	$strS_REP_NM		= strTrim($strS_REP_NM,30);
	$strS_COM_PHONE		= strTrim($strS_COM_PHONE,20);
	$strS_COM_FAX		= strTrim($strS_COM_FAX,20);
	$strS_SITE_TITLE	= strTrim($strS_SITE_TITLE,100);
	$strS_SITE_KEYWORD	= strTrim($strS_SITE_KEYWORD,"");
	$strS_SITE_COPY		= strTrim($strS_SITE_COPY,1);

	$strS_USE_POLICY	= strTrim($strS_USE_POLICY,0);
	$strS_PERSON_POLICY = strTrim($strS_PERSON_POLICY,0);

	$strS_DELIVERY_ST		= strTrim($strS_DELIVERY_ST,1);
	$strS_DELIVERY_EXT_AREA = strTrim($strS_DELIVERY_EXT_AREA,0,"N");
	$strS_DELIVERY_COM		= strTrim($strS_DELIVERY_COM,200);

	$strS_BANK				= strTrim($strS_BANK,0,"N");
	$strS_PG				= strTrim($strS_PG,1);

	$strS_SETTLE			= "";
	if (is_array($aryS_SETTLE)){
		for($i=0;$i<sizeof($aryS_SETTLE);$i++){
			$strS_SETTLE .= "/".$aryS_SETTLE[$i];
		}
	}

	$strS_POINT_USE1			= strTrim($strS_POINT_USE1,1);
	$strS_POINT_USE2			= strTrim($strS_POINT_USE2,1);
	$strS_POINT_ORDER_STATUS	= strTrim($strS_POINT_ORDER_STATUS,1);
	$strS_POINT_ST				= strTrim($strS_POINT_ST,1);
	$strS_POINT_PRICE_UNIT		= strTrim($strS_POINT_PRICE_UNIT,1);
	$strS_POINT_COUPON_USE		= strTrim($strS_POINT_COUPON_USE,1);
	if (!$intS_POINT_ORDER_GIVE) $intS_POINT_ORDER_GIVE = 0;

	$strS_PROD_DELIVERY			= strTrim($strS_PROD_DELIVERY,0);
	$strS_PROD_RETURN			= strTrim($strS_PROD_RETURN,0);

	$strSC_TITLE				= strTrim($strSC_TITLE,50);
	$strSC_TEXT					= strTrim($strSC_TEXT,0);

	$strS_PIM_NAME				= strTrim($strS_PIM_NAME,50);
	$strS_PIM_HP				= strTrim($strS_PIM_HP,20);
	$strS_PIM_MAIL				= strTrim($strS_PIM_MAIL,30);

	$strS_PG_SITE_CODE			= strTrim($strS_PG_SITE_CODE,20);
	$strS_PG_SITE_KEY			= strTrim($strS_PG_SITE_KEY,50);

	$strS_SITE_FACEBOOK			= strTrim($strS_SITE_FACEBOOK,0,"N");
	$strS_SITE_TWITTER			= strTrim($strS_SITE_TWITTER,0,"N");
	$strS_SITE_ME2TODAY			= strTrim($strS_SITE_ME2TODAY,0,"N");

	$siteMgr->setS_NO($intS_NO);
	$siteMgr->setS_SITE_NM($strS_SITE_NM);
	$siteMgr->setS_SITE_ENG_NM($strS_SITE_ENG_NM);
	$siteMgr->setS_SITE_MAIL($strS_SITE_MAIL);
	$siteMgr->setS_SITE_URL($strS_SITE_URL);
	$siteMgr->setS_COM_NM($strS_COM_NM);
	$siteMgr->setS_COM_BUSI1($strS_COM_BUSI1);
	$siteMgr->setS_COM_BUSI2($strS_COM_BUSI2);
	$siteMgr->setS_COM_ZIP($strS_COM_ZIP);
	$siteMgr->setS_COM_ADDR($strS_COM_ADDR);
	$siteMgr->setS_COM_NUM1($strS_COM_NUM1);
	$siteMgr->setS_COM_NUM2($strS_COM_NUM2);
	$siteMgr->setS_REP_NM($strS_REP_NM);
	$siteMgr->setS_COM_PHONE($strS_COM_PHONE);
	$siteMgr->setS_COM_FAX($strS_COM_FAX);
	$siteMgr->setS_SITE_TITLE($strS_SITE_TITLE);
	$siteMgr->setS_SITE_KEYWORD($strS_SITE_KEYWORD);
	$siteMgr->setS_SITE_COPY($strS_SITE_COPY);
	$siteMgr->setS_USE_POLICY($strS_USE_POLICY);
	$siteMgr->setS_PERSON_POLICY($strS_PERSON_POLICY);

	$siteMgr->setS_AUTO_CANCEL($intS_AUTO_CANCEL);
	$siteMgr->setS_DELIVERY_ST($strS_DELIVERY_ST);
	$siteMgr->setS_DELIVERY_FREE($intS_DELIVERY_FREE);
	$siteMgr->setS_DELIVERY_FEE($intS_DELIVERY_FEE);
	$siteMgr->setS_DELIVERY_EXT($intS_DELIVERY_EXT);
	$siteMgr->setS_DELIVERY_EXT_AREA($strS_DELIVERY_EXT_AREA);
	$siteMgr->setS_DELIVERY_COM($strS_DELIVERY_COM);
	$siteMgr->setS_BANK($strS_BANK);
	$siteMgr->setS_SETTLE($strS_SETTLE);
	$siteMgr->setS_PG($strS_PG);

	$siteMgr->setS_POINT_USE1($strS_POINT_USE1);
	$siteMgr->setS_POINT_USE2($strS_POINT_USE2);
	$siteMgr->setS_POINT_ORDER_STATUS($strS_POINT_ORDER_STATUS);
	$siteMgr->setS_POINT_ST($strS_POINT_ST);
	$siteMgr->setS_POINT_ST_PRICE($intS_POINT_ST_PRICE);
	$siteMgr->setS_POINT_PRICE($intS_POINT_PRICE);
	$siteMgr->setS_POINT_PRICE_UNIT($strS_POINT_PRICE_UNIT);
	$siteMgr->setS_POINT_PRICE_POS($intS_POINT_PRICE_POS);
	$siteMgr->setS_POINT_MIN($intS_POINT_MIN);
	$siteMgr->setS_POINT_MAX($intS_POINT_MAX);
	$siteMgr->setS_POINT_COUPON_USE($strS_POINT_COUPON_USE);

	$siteMgr->setS_PROD_DELIVERY($strS_PROD_DELIVERY);
	$siteMgr->setS_PROD_RETURN($strS_PROD_RETURN);

	/*개인정보 보호 담당자*/
	$siteMgr->setS_PIM_NAME($strS_PIM_NAME);
	$siteMgr->setS_PIM_HP	($strS_PIM_HP);
	$siteMgr->setS_PIM_MAIL($strS_PIM_MAIL);

	$siteMgr->setS_PG_SITE_CODE($strS_PG_SITE_CODE);
	$siteMgr->setS_PG_SITE_KEY($strS_PG_SITE_KEY);

	$siteMgr->setS_REG_DT($S_NOW_TIME_FORMAT2);
	$siteMgr->setS_REG_NO($a_admin_no);
	$siteMgr->setS_MOD_DT($S_NOW_TIME_FORMAT2);
	$siteMgr->setS_MOD_NO($a_admin_no);

	/*공통 관리*/
	$siteMgr->setSC_NO(0);
	$siteMgr->setSC_TITLE($strSC_TITLE);
	$siteMgr->setSC_TEXT($strSC_TEXT);
	$siteMgr->setSC_REG_DT($intSC_REG_DT);
	$siteMgr->setSC_REG_NO($intSC_REG_NO);
	$siteMgr->setSC_MOD_DT($intSC_MOD_DT);
	$siteMgr->setSC_MOD_NO($intSC_MOD_NO);

	/*관리자관리 */
	$adminMgr->setM_NO($intM_NO);
	$adminMgr->setA_STATUS($strA_STATUS);
	$adminMgr->setA_MEMO($strA_MEMO);
	$adminMgr->setA_TM($strA_TM);

	$strLinkPage = "";

	switch ($strAct) {

		case "infoModify":

			## 사이트 정보 불러오기
			$row = $siteMgr->getSiteInfoView($db);
			$strS_SITE_FAVICON_FILE = $row['S_SITE_FAVICON_FILE'];

			## MATE TAG 설정
			$strMetaTag = $_POST['site_metaTag'];
			$strMetaTag = preg_replace('/<\\?.*(\\?>|$)/Us', '',$strMetaTag);
			$strMataTagPath = SHOP_HOME . "/layout/html/inc-metatag.php";
			FileDevice::fileWrite($strMataTagPath, $strMetaTag);
			## favicon 설정(파일업로드)
			## 2014.08.19 kim hee sung 내용 추가
			$arySiteFaviconFile = $_FILES['site_favicon_file'];
			$strSiteFaviconFileDel = $_POST['site_favicon_file_del'];
			$strSiteFaviconFileWebDir = "/upload/site";
			$strSiteFaviconFileAllDir = MALL_SHOP . $strSiteFaviconFileWebDir;
			## 파일 삭제
			if($strSiteFaviconFileDel == "Y"):
				## 등록된 데이터 삭제
				if($strS_SITE_FAVICON_FILE):
					FileDevice::fileDelete("{$strLogoFileAllDir}/{$strS_SITE_FAVICON_FILE}");
					$strS_SITE_FAVICON_FILE = "";
				endif;
			endif;

			## 파일 업로드
			if($arySiteFaviconFile):

				## 기본설정
				$strFaviconFileName = $arySiteFaviconFile['name'];

				if($strFaviconFileName):

					## 폴더 생성
					if(!FileDevice::makeFolder($strSiteFaviconFileAllDir)):
						$strMsg = "폴더를 생성할수 없습니다.";
						break;
					endif;

					## 유니크 파일명 만들기
					$strSaveFileName = time() . "_%s_@_{$strFaviconFileName}";
					$strSaveFileName = FileDevice::getUniqueFileName($strSiteFaviconFileAllDir, $strSaveFileName);

					## 파일 복사
					$re = FileDevice::upload("site_favicon_file", "{$strSiteFaviconFileAllDir}/{$strSaveFileName}");
					if(!$re):
						$strMsg = "파일 업로드 실패했습니다. 관리자에게 문의하세요.";
						break;
					endif;

					## 등록된 데이터 삭제
					if($strS_SITE_FAVICON_FILE):
						FileDevice::fileDelete("{$strLogoFileAllDir}/{$strS_SITE_FAVICON_FILE}");
					endif;

					## 등록된 데이터 변경
					$strS_SITE_FAVICON_FILE = $strSaveFileName;

				endif;

			endif;

			// 관리자 페이지 -> 기본정보 -> 데이터 수정(업데이트) 작업 진행
			$aryData[0]["column"]	= "S_SITE_NM";
			$aryData[0]["value"]	= $strS_SITE_NM;

			$aryData[1]["column"]	= "S_SITE_ENG_NM";
			$aryData[1]["value"]	= $strS_SITE_ENG_NM;

			$aryData[2]["column"]	= "S_SITE_MAIL";
			$aryData[2]["value"]	= $strS_SITE_MAIL;

			$aryData[3]["column"]	= "S_SITE_URL";
			$aryData[3]["value"]	= $strS_SITE_URL;

			$aryData[4]["column"]	= "S_COM_NM";
			$aryData[4]["value"]	= $strS_COM_NM;

			$aryData[5]["column"]	= "S_COM_BUSI1";
			$aryData[5]["value"]	= $strS_COM_BUSI1;

			$aryData[6]["column"]	= "S_COM_BUSI2";
			$aryData[6]["value"]	= $strS_COM_BUSI2;

			$aryData[7]["column"]	= "S_COM_ZIP";
			$aryData[7]["value"]	= $strS_COM_ZIP;

			$aryData[8]["column"]	= "S_COM_ADDR";
			$aryData[8]["value"]	= $strS_COM_ADDR;

			$aryData[9]["column"]	= "S_COM_NUM1";
			$aryData[9]["value"]	= $strS_COM_NUM1;

			$aryData[10]["column"]	= "S_COM_NUM2";
			$aryData[10]["value"]	= $strS_COM_NUM2;

			$aryData[11]["column"]	= "S_REP_NM";
			$aryData[11]["value"]	= $strS_REP_NM;

			$aryData[12]["column"]	= "S_COM_PHONE";
			$aryData[12]["value"]	= $strS_COM_PHONE;

			$aryData[13]["column"]	= "S_COM_FAX";
			$aryData[13]["value"]	= $strS_COM_FAX;

			$aryData[14]["column"]	= "S_SITE_COPY";
			$aryData[14]["value"]	= $strS_SITE_COPY;

			$aryData[15]["column"]	= "S_SITE_TITLE";
			$aryData[15]["value"]	= $strS_SITE_TITLE;

			$aryData[16]["column"]	= "S_PIM_NAME";
			$aryData[16]["value"]	= $strS_PIM_NAME;

			$aryData[17]["column"]	= "S_PIM_HP";
			$aryData[17]["value"]	= $strS_PIM_HP;

			$aryData[18]["column"]	= "S_PIM_MAIL";
			$aryData[18]["value"]	= $strS_PIM_MAIL;

			$aryData[19]["column"]	= "S_SITE_FACEBOOK";
			$aryData[19]["value"]	= $strS_SITE_FACEBOOK;

			$aryData[20]["column"]	= "S_SITE_TWITTER";
			$aryData[20]["value"]	= $strS_SITE_TWITTER;

			$aryData[21]["column"]	= "S_SITE_ME2TODAY";
			$aryData[21]["value"]	= $strS_SITE_ME2TODAY;

			$aryData[22]["column"]	= "S_SITE_FACEBOOK_APP_ID";
			$aryData[22]["value"]	= $strS_SITE_FACEBOOK_APP_ID;

			$aryData[23]["column"]	= "S_SITE_FACEBOOK_SECRET";
			$aryData[23]["value"]	= $strSITE_FACEBOOK_SECRET;

			$aryData[24]["column"]	= "S_COM_HP";
			$aryData[24]["value"]	= $strS_COM_HP;

			$aryData[25]["column"]	= "S_SITE_FAVICON_FILE";
			$aryData[25]["value"]	= $strS_SITE_FAVICON_FILE;

			shopInfoInsertUpdate($siteMgr,$aryData);

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";

			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";

			$strUrl = "./?menuType=".$strMenuType."&mode=info".$strLinkPage;

		break;

		case "policyModify":


//			$row = $siteMgr->getSiteInfoView($db);
//			$aryUseLng = explode("/",$row[S_USE_LNG]);
//			print_r($aryUseLng);
//			exit;
//			for($i=0;$i<sizeof($aryUseLng);$i++){

//				$strUserPolicy = $strPersonPolicy = "";
//				if(!$strPolicyLng) { 	$strLng = strtolower($strStLng); }
//
//				$strUserPolicy = $_POST["use_policy_".$strPolicyLng] ? $_POST["use_policy_".$strPolicyLng]	: $_REQUEST["use_policy_".$strPolicyLng];
//
//				$strPersonPolicy = $_POST["person_policy_".$strPolicyLng] ? $_POST["person_policy_".$strPolicyLng]	: $_REQUEST["person_policy_".$strPolicyLng];
//
//				$aryData[0]["column"]	= "S_USE_POLICY_".strtolower($strPolicyLng);
//				$aryData[0]["value"]	= $strUserPolicy;
//
//				$aryData[1]["column"]	= "S_PERSON_POLICY_".strtolower($strPolicyLng);
//				$aryData[1]["value"]	= $strPersonPolicy;
//				shopTextInsertUpdate($siteMgr,$aryData);

				## STEP 1.
				## 설정
// 2014.09.02 kim hee sung 에디터 변경으로 소스 변경.
//				$sLng					= strtolower($strStLng);
//				$strUserPolicy			= $_POST["use_policy_{$sLng}"];
//				$strPersonPolicy		= $_POST["person_policy_{$sLng}"];

				## 언어 설정
				$strLang = $_GET['lang'];
				if(!$strLang) { $strLang =$S_ST_LNG; }
				$strLang = strtoupper($strLang);
				$strLangLower = strtolower($strLang);
				$strUserPolicy			= $_POST["use_policy"];
				$strPersonPolicy		= $_POST["person_policy"];

				## STEP 2.
				## 등록
				$siteMgr->setS_COL("S_USE_POLICY_{$strLang}");
				$siteMgr->setS_VAL($strUserPolicy);
				$siteMgr->getSiteTextInsertUpdate($db);

				$siteMgr->setS_COL("S_PERSON_POLICY_{$strLang}");
				$siteMgr->setS_VAL($strPersonPolicy);
				$siteMgr->getSiteTextInsertUpdate($db);

				###################

				## STEP 3.
				## 테그 형태로 저장

				/* 회원가입 이용약관 -태그 */
				$file = "../conf/tag_policy.use.{$strLangLower}.inc.php";
				@chmod($file,0755);
				$fw = fopen($file, "w");
				fputs($fw,$strUserPolicy, strlen($strUserPolicy));
				fclose($fw);

				/* 회원가입 개인정보보호정책 -태그 */
				$file = "../conf/tag_policy.person.{$strLangLower}.inc.php";
				@chmod($file,0755);
				$fw = fopen($file, "w");
				fputs($fw,$strPersonPolicy, strlen($strPersonPolicy));
				fclose($fw);


				## STEP 4.
				## 테그 치환
				$strUserPolicy = str_replace("{{__회사명__}}", $S_SITE_NM, $strUserPolicy);
				$strUserPolicy = str_replace("{{__운영쇼핑몰명__}}", $S_SITE_ENG_NM, $strUserPolicy);

				$strPersonPolicy = str_replace("{{__회사명__}}", $S_SITE_NM, $strPersonPolicy);
				$strPersonPolicy = str_replace("{{__운영쇼핑몰명__}}", $S_SITE_ENG_NM, $strPersonPolicy);

				## STEP 5.
				## 변경된 데이터 저장

				/* 회원가입 이용약관 */
				$file = "../conf/policy.use.{$strLangLower}.inc.php";
				@chmod($file,0755);
				$fw = fopen($file, "w");
				fputs($fw,$strUserPolicy, strlen($strUserPolicy));
				fclose($fw);

				/* 회원가입 개인정보보호정책 */
				$file = "../conf/policy.person.{$strLangLower}.inc.php";
				@chmod($file,0755);
				$fw = fopen($file, "w");
				fputs($fw,$strPersonPolicy, strlen($strPersonPolicy));
				fclose($fw);
//			}

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=policy&lang={$strLang}".$strLinkPage;
		break;

		case "orderModify":
			$aryS_DELIVERY_COM_CHK					= $_POST["delivery_com_chk"];

			/* 택배사  */
			$aryDeliveryComList["001"]["CC_NAME"]	= "우체국";
			$aryDeliveryComList["001"]["CC_URL"]	= "http://service.epost.go.kr/trace.RetrieveRegiPrclDeliv.postal?sid1={dev_no}";

			$aryDeliveryComList["002"]["CC_NAME"]	= "경동택배";
			$aryDeliveryComList["002"]["CC_URL"]	= "http://www.kdexp.com/sub4_1.asp?stype=1&p_item={dev_no}";

			$aryDeliveryComList["003"]["CC_NAME"]	= "CJ대한통운";
			$aryDeliveryComList["003"]["CC_URL"]	= "https://www.doortodoor.co.kr/parcel/doortodoor.do?fsp_action=PARC_ACT_002&fsp_cmd=retrieveInvNoACT&invc_no={dev_no}";

			$aryDeliveryComList["004"]["CC_NAME"]	= "동부택배";
			$aryDeliveryComList["004"]["CC_URL"]	= "http://www.dongbups.com/newHtml/delivery/delivery_search_view.jsp?item_no={dev_no}";

			$aryDeliveryComList["005"]["CC_NAME"]	= "로젠택배";
			$aryDeliveryComList["005"]["CC_URL"]	= "http://www.ilogen.com/iLOGEN.Web.New/TRACE/TraceView.aspx?slipno={dev_no}&gubun=slipno";

			$aryDeliveryComList["006"]["CC_NAME"]	= "이노지스택배";
			$aryDeliveryComList["006"]["CC_URL"]	= "http://www.innogis.co.kr/innogis/delivery.asp?invoice={dev_no}";

			$aryDeliveryComList["007"]["CC_NAME"]	= "한진택배";
			$aryDeliveryComList["007"]["CC_URL"]	= "http://www.hanjinexpress.hanjin.net/customer/plsql/hddcw07.result?wbl_num={dev_no}";

			$aryDeliveryComList["008"]["CC_NAME"]	= "CJ GLS";
			$aryDeliveryComList["008"]["CC_URL"]	= "http://nexs.cjgls.com/web/tracking_hth_pop.jsp?slipno={dev_no}";

			$aryDeliveryComList["009"]["CC_NAME"]	= "삼성 HTH";
			$aryDeliveryComList["009"]["CC_URL"]	= "http://cjhth.com/homepage/searchTraceGoods/SearchTraceDtdShtno.jhtml?dtdShtno={dev_no}";

			$aryDeliveryComList["010"]["CC_NAME"]	= "옐로우캡";
			$aryDeliveryComList["010"]["CC_URL"]	= "http://www.yellowcap.co.kr/custom/inquiry_result.asp?invoice_no={dev_no}";

			$aryDeliveryComList["011"]["CC_NAME"]	= "KGB택배";
			$aryDeliveryComList["011"]["CC_URL"]	= "http://www.kgbls.co.kr/sub5/trace.asp?f_slipno={dev_no}";

			$aryDeliveryComList["012"]["CC_NAME"]	= "현대택배";
			$aryDeliveryComList["012"]["CC_URL"]	= "http://www.hlc.co.kr/personalService/tracking/06/tracking_goods_result.jsp?InvNo={dev_no}";

			$aryDeliveryComList["051"]["CC_NAME"]	= "천일택배";
			$aryDeliveryComList["051"]["CC_URL"]	= "http://www.chunil.co.kr/HTrace/HTrace.jsp?transNo={dev_no}";

			$aryDeliveryComList["052"]["CC_NAME"]	= "대신택배";
			$aryDeliveryComList["052"]["CC_URL"]	= "https://www.ds3211.co.kr/freight/internalFreightSearch.ht?billno={dev_no}";

			$aryDeliveryComList["053"]["CC_NAME"]	= "합동택배";
			$aryDeliveryComList["053"]["CC_URL"]	= "http://www.hdexp.co.kr/parcel/order_result_t.asp?stype=1&p_item={dev_no}";

			$aryDeliveryComForCode["E"] = "013";
			$aryDeliveryComForCode["K"] = "014";
			$aryDeliveryComForCode["R"] = "015";
			$aryDeliveryComForCode["F"] = "016";
			$aryDeliveryComForCode["D"] = "017";
			$aryDeliveryComForCode["T"] = "018";
			$aryDeliveryComForCode["U"] = "019";
			$aryDeliveryComForCode["X"] = "020";
			$aryDeliveryComForCode["H"] = "021";

			/* 택배사  */

			if (is_array($aryS_DELIVERY_COM_CHK)){

				$strDeliveryComList		= "";
				$strDeliveryComKrList	= "";
				$strDeliveryComForList	= "";
				for($i=0;$i<sizeof($aryS_DELIVERY_COM_CHK);$i++){

					if ($aryS_DELIVERY_COM_CHK[$i]){
						$siteMgr->setCC_CODE($aryS_DELIVERY_COM_CHK[$i]);
						$siteMgr->setCC_NAME($aryDeliveryComList[$aryS_DELIVERY_COM_CHK[$i]]["CC_NAME"]);
						$siteMgr->setCC_ETC($aryDeliveryComList[$aryS_DELIVERY_COM_CHK[$i]]["CC_URL"]);
						$siteMgr->setCC_SORT($i+1);
						$siteMgr->getDeliveryComInsertUpdate($db);
						$strDeliveryComList .= "'".$aryS_DELIVERY_COM_CHK[$i]."',";

						$strDeliveryComKrList .= "'".$aryS_DELIVERY_COM_CHK[$i]."',";

					}
				}

				if ($strDeliveryComList){
					$aryDeliveryComForList = explode(",",$S_DELIVERY_FOR_COM);
					if (is_array($aryDeliveryComForList)){
						for($i=0;$i<sizeof($aryDeliveryComForList);$i++){
							if ($aryDeliveryComForCode[$aryDeliveryComForList[$i]]){
								$strDeliveryComList .= "'".$aryDeliveryComForCode[$aryDeliveryComForList[$i]]."',";
							}
						}
					}
					$strDeliveryComList = SUBSTR($strDeliveryComList,0,STRLEN($strDeliveryComList)-1);
					$siteMgr->setCC_CODE($strDeliveryComList);
					$siteMgr->getDeliveryComDelete($db);
				}

				if ($strDeliveryComKrList){
					$strDeliveryComKrList = STR_REPLACE("'","",SUBSTR($strDeliveryComKrList,0,STRLEN($strDeliveryComKrList)-1));
				}
			} else {
				$aryDeliveryComForList = explode(",",$S_DELIVERY_FOR_COM);
				for($i=0;$i<sizeof($aryDeliveryComForList);$i++){
					if ($aryDeliveryComForCode[$aryDeliveryComForList[$i]]){
						$strDeliveryComList .= "'".$aryDeliveryComForCode[$aryDeliveryComForList[$i]]."',";
					}
				}

				$strDeliveryComList = STR_REPLACE("'","",SUBSTR($strDeliveryComList,0,STRLEN($strDeliveryComList)-1));
				$siteMgr->setCC_CODE($strDeliveryComList);
				$siteMgr->getDeliveryComDelete($db);
			}

			$aryData[0]["column"]	= "S_AUTO_CANCEL";
			$aryData[0]["value"]	= $intS_AUTO_CANCEL;

			$aryData[1]["column"]	= "S_DELIVERY_ST";
			$aryData[1]["value"]	= $strS_DELIVERY_ST;

			$aryData[2]["column"]	= "S_DELIVERY_FREE";
			$aryData[2]["value"]	= $intS_DELIVERY_FREE;

			$aryData[3]["column"]	= "S_DELIVERY_FEE";
			$aryData[3]["value"]	= $intS_DELIVERY_FEE;

			$aryData[4]["column"]	= "S_DELIVERY_COM";
			$aryData[4]["value"]	= $strDeliveryComList;

			$aryData[5]["column"]	= "S_DELIVERY_KR_COM";
			$aryData[5]["value"]	= $strDeliveryComKrList;


			$aryData[6]["column"]	= "S_BANK";
			$aryData[6]["value"]	= $strS_BANK;

			$aryData[7]["column"]	= "S_SETTLE";
			$aryData[7]["value"]	= $strS_SETTLE;

			$aryData[8]["column"]	= "S_PG";
			$aryData[8]["value"]	= $strS_PG;

			$aryData[9]["column"]	= "S_PG_SITE_CODE";
			$aryData[9]["value"]	= $strS_PG_SITE_CODE;

			$aryData[10]["column"]	= "S_PG_SITE_KEY";
			$aryData[10]["value"]	= $strS_PG_SITE_KEY;

			$aryData[11]['column']	= "S_DELIVERY_PAY_TYPE";
			$aryData[11]['value']	= $_POST['delivery_pay_type'];

			$aryData[12]['column']	= "S_SETTLE_MOBILE_TYPE";
			$aryData[12]['value']	= $_POST['settle_mobile_type'];

			$aryData[13]['column']	= "S_PRICE_SHOW_MEMBER";
			$aryData[13]['value']	= $_POST['priceShowMember'];

			$aryData[14]['column']	= "S_PRICE_SHOW_VIEW";
			$aryData[14]['value']	= $_POST['priceShowView'];

			$aryData[15]['column']	= "S_PRICE_SHOW_GROUP";
			$aryData[15]['value']	= implode(',', $_POST['priceShowGroup']);

			$aryData[16]["column"]	= "S_AUTO_ORDER_END";
			$aryData[16]["value"]	= $intS_AUTO_ORDER_END;

			shopInfoInsertUpdate($siteMgr,$aryData);

			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";
			include MALL_HOME."/web/shopAdmin/basic/orderMakeFile.php";

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=order".$strLinkPage;

		break;

		case "orderForModify":

			/* 택배사  */
			$aryDeliveryComList["013"]["CC_NAME"]	= "EMS";
			$aryDeliveryComList["013"]["CC_URL"]	= "http://service.epost.go.kr/trace.RetrieveEmsTrace.postal?ems_gubun=E&POST_CODE={dev_no}";
			$aryDeliveryComList["013"]["CC_MTH"]	= "E";

			$aryDeliveryComList["014"]["CC_NAME"]	= "K-Packet";
			$aryDeliveryComList["014"]["CC_URL"]	= "";
			$aryDeliveryComList["014"]["CC_MTH"]	= "K";

			$aryDeliveryComList["015"]["CC_NAME"]	= "RR Register";
			$aryDeliveryComList["015"]["CC_URL"]	= "";
			$aryDeliveryComList["015"]["CC_MTH"]	= "R";

			$aryDeliveryComList["016"]["CC_NAME"]	= "Air Parcel";
			$aryDeliveryComList["016"]["CC_URL"]	= "";
			$aryDeliveryComList["016"]["CC_MTH"]	= "F";

			$aryDeliveryComList["017"]["CC_NAME"]	= "DHL";
			$aryDeliveryComList["017"]["CC_URL"]	= "";
			$aryDeliveryComList["017"]["CC_MTH"]	= "D";

			$aryDeliveryComList["018"]["CC_NAME"]	= "TNT";
			$aryDeliveryComList["018"]["CC_URL"]	= "";
			$aryDeliveryComList["018"]["CC_MTH"]	= "T";

			$aryDeliveryComList["019"]["CC_NAME"]	= "UPS";
			$aryDeliveryComList["019"]["CC_URL"]	= "";
			$aryDeliveryComList["019"]["CC_MTH"]	= "U";

			$aryDeliveryComList["020"]["CC_NAME"]	= "FedEx";
			$aryDeliveryComList["020"]["CC_URL"]	= "";
			$aryDeliveryComList["020"]["CC_MTH"]	= "X";

			$aryDeliveryComList["021"]["CC_NAME"]	= "하나택배";
			$aryDeliveryComList["021"]["CC_URL"]	= "";
			$aryDeliveryComList["021"]["CC_MTH"]	= "H";

			$aryDeliveryComList["022"]["CC_NAME"]	= "사가와택배";
			$aryDeliveryComList["022"]["CC_URL"]	= "http://k2k.sagawa-exp.co.jp/p/sagawa/web/okurijoinput.jsp";
			$aryDeliveryComList["022"]["CC_MTH"]	= "S";

			$aryDeliveryComList["023"]["CC_NAME"]	= "순풍택배";
			$aryDeliveryComList["023"]["CC_URL"]	= "http://www.sf-express.com/cn/sc/dynamic_functions/price/";
			$aryDeliveryComList["023"]["CC_MTH"]	= "C01";

			$aryDeliveryComList["024"]["CC_NAME"]	= "원통택배";
			$aryDeliveryComList["024"]["CC_URL"]	= "http://www.yto.net.cn/cn/service/standardPrice.html";
			$aryDeliveryComList["024"]["CC_MTH"]	= "C02";

			$aryDeliveryComList["025"]["CC_NAME"]	= "중퉁택배";
			$aryDeliveryComList["025"]["CC_URL"]	= "http://www.zto.cn/GuestService/PriceQuery";
			$aryDeliveryComList["025"]["CC_MTH"]	= "C03";

			$aryDeliveryComList["026"]["CC_NAME"]	= "airmail";
			$aryDeliveryComList["026"]["CC_URL"]	= "http://www.zto.cn/GuestService/PriceQuery";
			$aryDeliveryComList["026"]["CC_MTH"]	= "C04";

			$aryDeliveryComList["027"]["CC_NAME"]	= "윈다택배";
			$aryDeliveryComList["027"]["CC_URL"]	= "";
			$aryDeliveryComList["027"]["CC_MTH"]	= "C05";

			/* 택배사  */
			if (is_array($aryS_DELIVERY_COM_CHK)){

				$strDeliveryComList		= "";
				$strDeliveryComKrList	= "";
				$strDeliveryComForList	= "";
				for($i=0;$i<sizeof($aryS_DELIVERY_COM_CHK);$i++){

					if ($aryS_DELIVERY_COM_CHK[$i]){

						$siteMgr->setCC_CODE($aryS_DELIVERY_COM_CHK[$i]);
						$siteMgr->setCC_NAME($aryDeliveryComList[$aryS_DELIVERY_COM_CHK[$i]]["CC_NAME"]);
						$siteMgr->setCC_ETC($aryDeliveryComList[$aryS_DELIVERY_COM_CHK[$i]]["CC_URL"]);
						$siteMgr->setCC_SORT($i+1);
						$siteMgr->getDeliveryComInsertUpdate($db);
						$strDeliveryComList .= "'".$aryS_DELIVERY_COM_CHK[$i]."',";

						if (in_array($aryS_DELIVERY_COM_CHK[$i],array("013","014","015","016","017","018","019","020","021","022","023","024","025","026","027"))){
							//$strDeliveryComForList	.= "'".$aryS_DELIVERY_COM_CHK[$i]."',";
							$strDeliveryComForList	.= "'".$aryDeliveryComList[$aryS_DELIVERY_COM_CHK[$i]]["CC_MTH"]."',";
						}
					}
				}

				if ($strDeliveryComList){
					$aryDeliveryComKrList = explode(",",$S_DELIVERY_KR_COM);
					if (is_array($aryDeliveryComKrList)){
						for($i=0;$i<sizeof($aryDeliveryComKrList);$i++){
							if ($aryDeliveryComKrList[$i]){
								$strDeliveryComKrList .= "'".$aryDeliveryComKrList[$i]."',";
							}
						}
					}
					$strDeliveryComList = $strDeliveryComKrList.$strDeliveryComList;
					$strDeliveryComList = SUBSTR($strDeliveryComList,0,STRLEN($strDeliveryComList)-1);
					$siteMgr->setCC_CODE($strDeliveryComList);
					$siteMgr->getDeliveryComDelete($db);
				}

				if ($strDeliveryComForList){
					$strDeliveryComForList = STR_REPLACE("'","",SUBSTR($strDeliveryComForList,0,STRLEN($strDeliveryComForList)-1));
				}
			}

			$aryData[0]["column"]	= "S_DELIVERY_FREE_FOR";
			$aryData[0]["value"]	= $intS_DELIVERY_FREE;

			$aryData[1]["column"]	= "S_DELIVERY_FEE_FOR";
			$aryData[1]["value"]	= $intS_DELIVERY_FEE;

			$aryData[2]["column"]	= "S_DELIVERY_COM";
			$aryData[2]["value"]	= $strDeliveryComList;

			$aryData[3]["column"]	= "S_DELIVERY_FOR_COM";
			$aryData[3]["value"]	= $strDeliveryComForList;

			$strS_FOR_PG = $strS_FOR_PG1."/".$strS_FOR_PG2."/".$strS_FOR_PG3."/".$strS_FOR_PG4;
			$aryData[4]["column"]	= "S_FOR_PG";
			$aryData[4]["value"]	= $strS_FOR_PG;

			$aryData[5]["column"]	= "S_FOR_BANK";
			$aryData[5]["value"]	= $strS_FOR_BANK;

			shopInfoInsertUpdate($siteMgr,$aryData);

			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";
			include MALL_HOME."/web/shopAdmin/basic/orderMakeFile.php";

			$strMsg = $LNG_TRANS_CHAR["CS00002"]; //"저장되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=orderFor".$strLinkPage;
		break;

		case "pointModify":

			$aryData[0]["column"]	= "S_POINT_USE1";
			$aryData[0]["value"]	= $strS_POINT_USE1;

			$aryData[1]["column"]	= "S_POINT_USE2";
			$aryData[1]["value"]	= $strS_POINT_USE2;

			$aryData[2]["column"]	= "S_POINT_ORDER_STATUS";
			$aryData[2]["value"]	= $strS_POINT_ORDER_STATUS;

			$aryData[3]["column"]	= "S_POINT_ST";
			$aryData[3]["value"]	= $strS_POINT_ST;

			$aryData[4]["column"]	= "S_POINT_ST_PRICE";
			$aryData[4]["value"]	= $intS_POINT_ST_PRICE;

			$aryData[5]["column"]	= "S_POINT_PRICE";
			$aryData[5]["value"]	= $intS_POINT_PRICE;

			$aryData[6]["column"]	= "S_POINT_PRICE_UNIT";
			$aryData[6]["value"]	= $strS_POINT_PRICE_UNIT;

			$aryData[7]["column"]	= "S_POINT_PRICE_POS";
			$aryData[7]["value"]	= $intS_POINT_PRICE_POS;

			$aryData[8]["column"]	= "S_POINT_MIN";
			$aryData[8]["value"]	= $intS_POINT_MIN;

			$aryData[9]["column"]	= "S_POINT_MAX";
			$aryData[9]["value"]	= $intS_POINT_MAX;

			$aryData[10]["column"]	= "S_POINT_COUPON_USE";
			$aryData[10]["value"]	= $strS_POINT_COUPON_USE;

			$aryData[11]["column"]	= "S_POINT_ORDER_GIVE";
			$aryData[11]["value"]	= $intS_POINT_ORDER_GIVE;


			shopInfoInsertUpdate($siteMgr,$aryData);

			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";

			$LNG_TRANS_CHAR["CS00002"]; //$strMsg = "저장되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=point".$strLinkPage;
		break;

		case "couponModify":
			$aryData[0]["column"]	= "S_COUPON_USE";
			$aryData[0]["value"]	= $strS_COUPON_USE;

			$aryData[1]["column"]	= "S_COUPON_LIMIT";
			$aryData[1]["value"]	= $strS_COUPON_LIMIT;

			shopInfoInsertUpdate($siteMgr,$aryData);

			include MALL_HOME."/web/shopAdmin/basic/shopMakeFile.php";

			$LNG_TRANS_CHAR["CS00002"]; //$strMsg = "저장되었습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=coupon".$strLinkPage;
		break;

		case "currencyModify":

			$siteRow		= $siteMgr->getSiteInfoView($db);
			$aryUseLng		= explode("/",$siteRow[S_USE_LNG]);

			if ($S_PAYPAL_EXT_CUR == "Y") array_push($aryUseLng,"US"); //->인도네시아/중국/러시아통화는 페이팔에서 제공해주지 않는 통화

			$strStDt = date("Y").".".date("m").".".date("d");
			$siteMgr->setSCR_ST_DT($strStDt);
			for($i=0;$i<sizeof($aryUseLng);$i++){
				$strInputBox	= strtolower($aryUseLng[$i]);

				$intCurStRate	= $_POST["cur_rate_st_".$strInputBox]				? $_POST["cur_rate_st_".$strInputBox]				: $_REQUEST["cur_rate_st_".$strInputBox];
				$intCurShopRate	= $_POST["cur_rate_shop_".$strInputBox]				? $_POST["cur_rate_shop_".$strInputBox]				: $_REQUEST["cur_rate_shop_".$strInputBox];

				$strUseCur		= $S_ARY_NAT_CUR[$aryUseLng[$i]];
				if ($aryUseLng[$i] == "ES") {
					$strUseCur = $S_LNG_ES_CUR;
				}

				$siteMgr->setSCR_NAT($aryUseLng[$i]);
				$siteMgr->setSCR_CUR($strUseCur);
				$siteMgr->setSCR_ST_CUR_RATE($intCurStRate);
				$siteMgr->setSCR_SHOP_CUR_RATE($intCurShopRate);

				$siteMgr->getSiteCurrencyInsertUpdate($db);

			}

			/* 기본정보 */
			$file = "../conf/site.cur.inc.php";

			@chmod($file,0707);
			$fw = fopen($file, "w");
			fwrite($fw, "<?\n");
			fwrite($fw, "	/*################ SHOP 기준 통화 정보:[0:쇼핑몰][1:기준][2:단위] ################*/	\n");

			$aryStCurList = $siteMgr->getSiteCurView($db);

			if (is_array($aryStCurList)){

				for($i=0;$i<sizeof($aryStCurList);$i++){
					fwrite($fw, "	\$S_ARY_CUR[\"".$aryStCurList[$i][SCR_NAT]."\"][\"".$aryStCurList[$i][SCR_CUR]."\"][0]				=	".$aryStCurList[$i][SCR_SHOP_CUR_RATE].";\n");
					fwrite($fw, "	\$S_ARY_CUR[\"".$aryStCurList[$i][SCR_NAT]."\"][\"".$aryStCurList[$i][SCR_CUR]."\"][1]				=	".$aryStCurList[$i][SCR_ST_CUR_RATE].";\n");
					fwrite($fw, "	\$S_ARY_CUR[\"".$aryStCurList[$i][SCR_NAT]."\"][\"".$aryStCurList[$i][SCR_CUR]."\"][2]				=	\"\";\n");


					fwrite($fw, "	\n");
				}
			}

			$aryStUsdCurList = $siteMgr->getSiteUsdCurView($db);
			if (is_array($aryStUsdCurList)){
				for($i=0;$i<sizeof($aryUseLng);$i++){
					if ($aryUseLng[$i] != "US"){
						fwrite($fw, "	\$S_ARY_CUR[\"".$aryUseLng[$i]."\"][\"".$aryStUsdCurList[0][SCR_CUR]."\"][0]				=	".$aryStUsdCurList[0][SCR_SHOP_CUR_RATE].";\n");
						fwrite($fw, "	\$S_ARY_CUR[\"".$aryUseLng[$i]."\"][\"".$aryStUsdCurList[0][SCR_CUR]."\"][1]				=	".$aryStUsdCurList[0][SCR_ST_CUR_RATE].";\n");


						if ($aryUseLng[$i] == "CN" || $aryUseLng[$i] == "TW"){
							fwrite($fw, "	\$S_ARY_CUR[\"".$aryUseLng[$i]."\"][\"".$aryStUsdCurList[0][SCR_CUR]."\"][2]				=	\"Y\";\n");
						} else {
							fwrite($fw, "	\$S_ARY_CUR[\"".$aryUseLng[$i]."\"][\"".$aryStUsdCurList[0][SCR_CUR]."\"][2]				=	\"\";\n");
						}
						fwrite($fw, "	\n");
					}
				}
			}
			/* 사용 국가별 정의 */
			$aryUseNationList = explode("/",$S_USE_LNG);
			foreach($aryUseNationList as $key => $val){

				if ($val == "ES"){
					fwrite($fw, "	\$S_ARY_NAT_USER_CUR[\"".$val."\"] =	\"".$S_LNG_ES_CUR."\"; \n");
				} else {
					if (in_array($val,array("CN","TW")) && !in_array("US",$aryUseNationList)){
						fwrite($fw, "	\$S_ARY_NAT_USER_CUR[\"US\"] =	\"USD\"; \n");
					}
					fwrite($fw, "	\$S_ARY_NAT_USER_CUR[\"".$val."\"] =	\"".$S_ARY_NAT_CUR[$val]."\"; \n");
				}
			}

			fwrite($fw, "?>\n");
			fclose($fw);

			//$strUrl = "./?menuType=".$strMenuType."&mode=exchange".$strLinkPage;
		break;

		case "admin":
			// 관리자비밀번호 변경

			## 모듈 설정
			$objMemberMgrModule = new MemberMgrModule($db);
			$objMemberAddModule = new MemberAddModule($db);

			## 기본설정
			$strName = $_POST['m_name'];
			$strNowPwd = $_POST['m_now_pwd'];
			$strNewPwd1 = $_POST['m_new_pwd1'];
			$strNewPwd2 = $_POST['m_new_pwd2'];
			$strAdminNo = $_SESSION['ADMIN_NO'];
			$strUrl = "./?menuType=basic&mode=admin";
			$aryAdminLogo = $_FILES['m_admin_logo'];
			$strAdminLogoDel = $_POST['m_admin_logo_del'];
			$strLogoFileWebDir = "/upload/member/adminLogo";
			$strLogoFileAllDir = MALL_SHOP . $strLogoFileWebDir;

			## 공백제거
			$strName = trim($strName);

			## 체크
			if(!$strName):
				$strMsg = "관리자 이름이 없습니다.";
				break;
			endif;
			if(!$strNowPwd):
				$strMsg = "기존에 등록된 비밀번호가 없습니다.";
				break;
			endif;
			if($strNewPwd1 != $strNewPwd2):
				$strMsg = "새로운 비밀번호가 동일하지 않습니다..";
				break;
			endif;
			if(!$strAdminNo):
				$strMsg = "로그인이 필요합니다.";
				break;
			endif;

			## 회원정보 불러오기
			$param = "";
			$param['M_NO'] = $strAdminNo;
			$param['M_PASS'] = $strNowPwd;
			$param['JOIN_MA'] = "Y";
			$aryMemberRow = $objMemberMgrModule->getMemberMgrSelectEx2("OP_SELECT", $param);
			$strM_PHOTO = $aryMemberRow['M_PHOTO'];

			## 체크
			if(!$aryMemberRow):
				$strMsg = "비밀번호가 틀립니다.";
				break;
			endif;

			## 관리자 로고 삭제 요청시 삭제
			if($strAdminLogoDel == "Y"):
				## 등록된 데이터 삭제
				if($strM_PHOTO):
					FileDevice::fileDelete("{$strLogoFileAllDir}/{$strM_PHOTO}");
					$strM_PHOTO = "";
				endif;
			endif;

			if($aryAdminLogo):

				## 기본설정
				$strLogoFileName = $aryAdminLogo['name'];

				if($strLogoFileName):

					## 폴더 생성
					if(!FileDevice::makeFolder($strLogoFileAllDir)):
						$strMsg = "폴더를 생성할수 없습니다.";
						break;
					endif;

					## 유니크 파일명 만들기
					$strSaveFileName = time() . "_%s_@_{$strLogoFileName}";
					$strSaveFileName = FileDevice::getUniqueFileName($strLogoFileAllDir, $strSaveFileName);

					## 파일 복사
					$re = FileDevice::upload("m_admin_logo", "{$strLogoFileAllDir}/{$strSaveFileName}");
					if(!$re):
						$strMsg = "파일 업로드 실패했습니다. 관리자에게 문의하세요.";
						break;
					endif;

					## 등록된 데이터 삭제
					if($strM_PHOTO):
						FileDevice::fileDelete("{$strLogoFileAllDir}/{$strM_PHOTO}");
					endif;

					## 등록된 데이터 변경
					$strM_PHOTO = $strSaveFileName;

				endif;

			endif;

			## 비밀번호 변경
			$param = "";
			$param['M_NO'] = $strAdminNo;
			$param['M_PASS'] = $strNewPwd1;
			$objMemberMgrModule->getMemberPwdUpdate($param);

			## 이름 변경
			## 2014.08.13 kim hee sung 개발 공수가 커서 우선 모든 이름은 M_L_NAME에 작성합니다.
			$param = "";
			$param['M_NO'] = $strAdminNo;
			$param['M_F_NAME'] = "";			// 한국어일때 사용안함, 외국어일때 이름으로 사용
			$param['M_L_NAME'] = $strName;		// 한국어일때 성 + 이름 으로 사용, 외국어일때 성으로 사용
			$objMemberMgrModule->getMemberNameUpdate($param);

			## 관리자 로고 이미지 정보 변경
			$param = "";
			$param['M_NO'] = $strAdminNo;
			$param['M_PHOTO'] = $strM_PHOTO;
			$objMemberAddModule->getMemberAddPhotoUpdateEx($param);

			## 마무리
			$strMsg = "변경되었습니다.";

		break;

// 2014.08.13 kim hee sung. 소스 정리
//		case "admin":
//
//			$row = $adminMgr->getSuperView($db);
//			$adminMgr->setM_PASS($strM_NOW_PWD);
//			if ($row[M_PASS] == $adminMgr->getSuperPwdCheck($db)){
//				//슈퍼관리자 비밀번호
//				$adminMgr->setM_PASS($strM_NEW_PWD);
//				$adminMgr->getSuperUpdate($db);
//
//				$strMsg = $LNG_TRANS_CHAR["BS00008"]; //"관리자 비밀번호가 변경되었습니다.";
//
//			} else {
//
//				$strMsg = $LNG_TRANS_CHAR["BS00009"]; //"관리자의 현재비밀번호가 일치하지 않습니다.";
//			}
//
//			$strUrl = "./?menuType=basic&mode=admin";
//
//		break;

		case "adminWrite":
			## (부)관리자 등록

			$adminMgr->setA_STATUS("1");

			$intCnt = $adminMgr->getUniqeCount($db);
			if ($intCnt > 0) {
				$strMsg = $LNG_TRANS_CHAR["BS00010"]; //"이미 등록된 관리자입니다.";
				goErrMsg($strMsg);
				$db->disConnect();
				exit;
			}

			$adminMgr->getInsert($db);
			$adminMenu->setAM_TYPE("A");

			## 2013.08.05 kim hee sung, 관리입점몰 리스트 업데이트
			if($ADMIN_SHOP_SELECT_USE == "Y"):
				$param						= "";
				$param['M_NO']				= $_POST['m_no'];
				$param['A_SHOP_LIST']		= $_POST['a_shop_list'];
				$adminMgr->getShopListUpdateEx($db, $param);
			endif;


			## 메뉴 공통 서버 DB 접속
			$dbMenuConn = mysql_connect("$etc_db_host", "$etc_db_user", "$etc_db_pass") or exit('DB Connect Error: ./www/web/shopAdmin/basic/act.php');
			mysql_select_db("$etc_db_name", $dbMenuConn) or exit('DB Select Error');
			mysql_query("SET NAMES utf8");

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

							$strMN_CODE		= substr($intMN_NO,1);
							$strMN_HIGH_01	= "006";
							$strMN_HIGH_02  = "";
							if ($intMN_NO >= 5901 && $intMN_NO < 6000) $strMN_HIGH_02 = "001";
							else if ($intMN_NO >= 5000 && $intMN_NO < 5900) $strMN_HIGH_02	= "002";

						} else {

							## 공통 서버 TABLE 접속 정보 가지고 오기
							$menuQry		= "SELECT * FROM SHOP_LANG_MENU WHERE MN_NO = {$intMN_NO}";
							$menuRet		= mysql_query($menuQry,$dbMenuConn);
							$menuRow		= mysql_fetch_array($menuRet);

							$strMN_CODE		= $menuRow['MN_CODE'];
							$strMN_HIGH_01	= $menuRow['MN_HIGH_01'];
							$strMN_HIGH_02	= $menuRow['MN_HIGH_02'];

							/*
							$xml_string = file_get_contents("http://www.eumshop.com/api/xml/shop.lang.menu.view.xml.php?no=".$intMN_NO);
							$menuRow = simplexml_load_string($xml_string);

							$strMN_CODE		= $menuRow->ITEM[0]->MN_CODE;
							$strMN_HIGH_01	= $menuRow->ITEM[0]->MN_HIGH_01;
							$strMN_HIGH_02	= $menuRow->ITEM[0]->MN_HIGH_02;
							*/
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

			$strMsg = $LNG_TRANS_CHAR["CS00003"]; //"정보가 등록되었습니다.";
			$strUrl = "./?menuType=basic&mode=adminList";
		break;

		case "adminModify":

			//관리자 정보 수정
			$adminMgr->getUpdate($db);
			$adminMenu->setAM_TYPE("A");
			$strAM_MN_NO = "";
			//관리자 메뉴 권한 수정 시작

			## 2013.08.05 kim hee sung, 관리입점몰 리스트 업데이트
			if($ADMIN_SHOP_SELECT_USE == "Y"):
				$param						= "";
				$param['M_NO']				= $_POST['m_no'];
				$param['A_SHOP_LIST']		= $_POST['a_shop_list'];
				$adminMgr->getShopListUpdateEx($db, $param);
			endif;

			## 메뉴 공통 서버 DB 접속
			$dbMenuConn = mysql_connect("$etc_db_host", "$etc_db_user", "$etc_db_pass") or exit('DB Connect Error:: ./www/web/shopAdmin/basic/act.php');
			mysql_select_db("$etc_db_name", $dbMenuConn) or exit('DB Select Error');
			mysql_query("SET NAMES utf8");

			if(is_Array($aryChkMenuNo)){
				for($i=0;$i<=count($aryChkMenuNo);$i++){

					if($aryChkMenuNo[$i] > 0){

						$intMN_NO	  = $aryChkMenuNo[$i];

						$strMN_AUTH_L = $_POST["mn_auth_l_".$intMN_NO]	? $_POST["mn_auth_l_".$intMN_NO]	: $_REQUEST["mn_auth_l_".$intMN_NO];
						$strMN_AUTH_W = $_POST["mn_auth_w_".$intMN_NO]	? $_POST["mn_auth_w_".$intMN_NO]	: $_REQUEST["mn_auth_w_".$intMN_NO];
						$strMN_AUTH_M = $_POST["mn_auth_m_".$intMN_NO]	? $_POST["mn_auth_m_".$intMN_NO]	: $_REQUEST["mn_auth_m_".$intMN_NO];
						$strMN_AUTH_D = $_POST["mn_auth_d_".$intMN_NO]	? $_POST["mn_auth_d_".$intMN_NO]	: $_REQUEST["mn_auth_d_".$intMN_NO];
						$strMN_AUTH_E = $_POST["mn_auth_e_".$intMN_NO]	? $_POST["mn_auth_e_".$intMN_NO]	: $_REQUEST["mn_auth_e_".$intMN_NO];

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

							$strMN_CODE		= substr($intMN_NO,1);
							$strMN_HIGH_01	= "006";
							$strMN_HIGH_02  = "";
							if ($intMN_NO >= 5901 && $intMN_NO < 6000) $strMN_HIGH_02 = "001";
							else if ($intMN_NO >= 5000 && $intMN_NO < 5900) $strMN_HIGH_02	= "002";

						} else {

							## 공통 서버 TABLE 접속 정보 가지고 오기
							$menuQry		= "SELECT * FROM SHOP_LANG_MENU WHERE MN_NO = {$intMN_NO}";
							$menuRet		= mysql_query($menuQry,$dbMenuConn);
							$menuRow		= mysql_fetch_array($menuRet);

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

			if ($strAM_MN_NO && count($aryChkMenuNo) > 0) {
				$adminMenu->setM_NO($intM_NO);
				$adminMenu->setAM_MN_NO($strAM_MN_NO);
				$adminMenu->getDelete($db);
			} else {
				$adminMenu->setM_NO($intM_NO);
				$adminMenu->getDelete($db);
			}

			//관리자 메뉴 권한 수정 종료
			$strMsg = $LNG_TRANS_CHAR["CS00004"]; //"관리자 정보가 수정되었습니다.";
			$strUrl = "./?menuType=basic&page=$intPage&mode=adminModify&m_no=$intM_NO&searchStatus=$strSearchStatus&page=$intPage&pageLine=$intPageLine";

		break;

		case "adminDel":

			$adminMgr->getDelete($db);

			$strMsg = $LNG_TRANS_CHAR["CS00005"]; //"관리자 정보가 삭제되었습니다.";
			$strUrl = "./?menuType=basic&page=$intPage&mode=adminList";
		break;
		case "adminRestore":
			$adminMgr->getRestore($db);

			$strMsg = $LNG_TRANS_CHAR["CS00006"]; //"관리자 정보가 복원되었습니다.";
			$strUrl = "./?menuType=basic&page=$intPage&mode=adminList";

		break;

		case "communityMakeFile":
			include MALL_HOME."/web/shopAdmin/basic/communityMakeFile.php";

		break;
	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>
