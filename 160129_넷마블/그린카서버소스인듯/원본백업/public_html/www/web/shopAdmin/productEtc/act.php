<?

	/*##################################### Parameter 셋팅 #####################################*/

	/*배송/반품교환 안내*/
	$strS_PROD_DELIVERY			= $_POST["s_prod_delivery"]		? $_POST["s_prod_delivery"]		: $_REQUEST["s_prod_delivery"];
	$strS_PROD_RETURN			= $_POST["s_prod_return"]		? $_POST["s_prod_return"]		: $_REQUEST["s_prod_return"];

	/*공통관리*/
	$intSC_NO					= $_POST["sc_no"]				? $_POST["sc_no"]				: $_REQUEST["sc_no"];
	$strSC_TITLE				= $_POST["sc_title"]			? $_POST["sc_title"]			: $_REQUEST["sc_title"];
	$strSC_TEXT					= $_POST["sc_text"]				? $_POST["sc_text"]				: $_REQUEST["sc_text"];
	$intSC_REG_DT				= $_POST["sc_reg_dt"]			? $_POST["sc_reg_dt"]			: $_REQUEST["sc_reg_dt"];
	$intSC_REG_NO				= $_POST["sc_reg_no"]			? $_POST["sc_reg_no"]			: $_REQUEST["sc_reg_no"];
	$intSC_MOD_DT				= $_POST["sc_mod_dt"]			? $_POST["sc_mod_dt"]			: $_REQUEST["sc_mod_dt"];
	$intSC_MOD_NO				= $_POST["sc_mod_no"]			? $_POST["sc_mod_no"]			: $_REQUEST["sc_mod_no"];

	/*##################################### Parameter 셋팅 #####################################*/

	$strS_PROD_DELIVERY			= strTrim($strS_PROD_DELIVERY,0);
	$strS_PROD_RETURN			= strTrim($strS_PROD_RETURN,0);

	$strSC_TITLE				= strTrim($strSC_TITLE,50);
	$strSC_TEXT					= strTrim($strSC_TEXT,0);

	/*배송/반품교환 안내*/
	$siteMgr->setS_PROD_DELIVERY($strS_PROD_DELIVERY);
	$siteMgr->setS_PROD_RETURN($strS_PROD_RETURN);
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


	$strLinkPage = "";

	switch ($strAct) {

		case "siteCommWriteOK":

			$siteMgr->getSiteCommInsert($db);
			$strMsg = $LNG_TRANS_CHAR["CS00003"]; //저장되었습니다.

			$strUrl = "./?menuType=".$strMenuType."&mode=siteCommList".$strLinkPage;

		break;

		case "siteCommModifyOK":

			$siteMgr->setSC_NO($intSC_NO);

			$siteMgr->getSiteCommUpdate($db);

			$strMsg = $LNG_TRANS_CHAR["CS00004"]; //내용 수정이 성공 되었습니다.

			$strUrl = "./?menuType=".$strMenuType."&mode=siteCommList&sc_no=".$intSC_NO."&page=".$intPage.$strLinkPage;

		break;

		case "siteCommDelete":
		
			$siteMgr->setSC_NO($intSC_NO);

			$siteMgr->getSiteCommDelete($db);

			$strMsg = $LNG_TRANS_CHAR["CS00005"]; //삭제완료
			
			$strUrl = "./?menuType=".$strMenuType."&mode=siteCommList&page=".$intPage.$strLinkPage;

		break;
		
		case "delRetHelpModify":
			/** 2013.06.05 다국어 버전으로 변경함. **/

			## 언어 설정
			$strLang = $_POST['lang'];
			if(!$strLang) { $strLang = $S_ST_LNG; }
			$strLangLower = strtolower($strLang);

			$aryData[0]["column"]	= "S_PROD_DELIVERY_{$strLang}";
			$aryData[0]["value"]	= $strS_PROD_DELIVERY;

			$aryData[1]["column"]	= "S_PROD_RETURN_{$strLang}";
			$aryData[1]["value"]	= $strS_PROD_RETURN;

			if (is_array($aryData)){
				for ($i=0;$i<sizeof($aryData);$i++) :
					$data = &$aryData[$i];
					
					if ($data['column']){
						$siteMgr->setS_COL($data['column']);
						$siteMgr->setS_VAL($data['value']);
						$siteMgr->getSiteTextInsertUpdate($db);
					}
				endfor;
			}

			$strMsg = $LNG_TRANS_CHAR["CS00003"]; //저장되었습니다.
			$strUrl = "./?menuType={$strMenuType}&mode=delRetHelp&lang={$strLang}{$strLinkPage}";
		
		break;

	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>