<?
	switch ($strAct){
	case "sendmailUseModify":
		// 자동메일설정 

		## 모듈 설정
//		require_once MALL_HOME . "/module2/EmailMgr.module.php";
//		require_once MALL_HOME . "/module2/SiteInfo.module.php";
//		require_once MALL_HOME . "/classes/file/file.handler.class.php";
		$objEmailMgrModule		= new EmailMgrModule($db);
		$objSiteInfoModule		= new SiteInfoModule($db);
		$objFile				= new FileDevice();

		## 기본 설정
		$strS_EMAIL_USE			= $_POST['s_email_use'];
		$strCOL					= "S_EMAIL_USE";
		$intMemberNo			= $_SESSION["ADMIN_NO"];
		
		## 기본 설정 체크
		if(!$strS_EMAIL_USE):
			$result['__STATE__']	= "NO_S_EMAIL_USE";
			$result['__MSG__']		= "잘못된 사용법입니다. 사용법을 확인후, 다시 시도하시기 바랍니다.";
			break;
		endif;

		## 기존 데이터 삭제
		$param					= "";
		$param['COL']			= $strCOL;
		$re						= $objSiteInfoModule->getSiteInfoDeleteEx($param);

		if(!$re):
			$result['__STATE__']	= "NO_DONT_DELETE";
			$result['__MSG__']		= "시스템 오류. 관리자에게 문의하세요.";
			break;
		endif;

		## 데이터 수정
		$param					= "";
		$param['COL']			= $strCOL;
		$param['VAL']			= $strS_EMAIL_USE;
		$param['VIEW']			= "Y";
		$param['MEMO']			= "자동메일 사용 유무(Y=사용함, N=사용안함)";
		$param['REG_DT']		= "NOW()";
		$param['REG_NO']		= $intMemberNo;
		$param['MOD_DT']		= "NOW()";
		$param['MOD_NO']		= $intMemberNo;
		$re						= $objSiteInfoModule->getSiteInfoInsertEx($param);

		## INFO 파일 설정
		$strMailConfigFile		= SHOP_HOME . "/layout/mail/_config.inc.php";
			
		## 설정 파일 만들기
		$strMailConfigData		= "";
		$strDataTemp			= "";
		$strDataTemp			= "\$EM_SETTING_USE";
		$strDataTemp			= str_pad($strDataTemp, 70, " ", STR_PAD_RIGHT);
		$strDataTemp			= "{$strDataTemp} = \"{$strS_EMAIL_USE}\";";
		$strDataTemp			= str_pad($strDataTemp, 140, " ", STR_PAD_RIGHT);
		$strDataTemp			= "## 자동메일 사용 유무(Y=사용함, N=사용안함)\n{$strDataTemp}"; 
		$strMailConfigData	   .= ($strMailConfigData) ? "\n" : "";
		$strMailConfigData	   .= $strDataTemp;

		$objFile->getMadeInfo($strMailConfigFile, $strMailConfigData, "/*@ EM_SETTING_USE @*/");

		## 마무리
		$result['__STATE__']	= "SUCCESS";
	break;

	case "sendmailModify":
		// 메일폼 수정

		## 모듈 설정
		require_once MALL_HOME . "/module2/EmailMgr.module.php";
		require_once MALL_HOME . "/classes/file/file.handler.class.php";
		$objEmailMgrModule		= new EmailMgrModule($db);
		$objFile				= new FileHandler();

		## 기본 설정
		$intEM_NO				= $_POST['em_no'];
		$strEM_AUTO				= $_POST['em_auto'];
		$strEM_SENDER			= $_POST['em_sender'];
		$strEM_RECIPIENT		= $_POST['em_recipient'];
		$strEM_TITLE			= $_POST['em_title'];
		$strEM_TEXT				= $_POST['em_text'];
		$intMemberNo			= $_SESSION["ADMIN_NO"];

		## 기본 설정 체크
		if(!$intEM_NO):
			$result['__STATE__']	= "NO_EM_NO";
			$result['__MSG__']		= "잘못된 사용법입니다. 잠시후에 다시 시도하시기 바랍니다.";
			break;
		endif;
		if(!$intMemberNo):
			$result['__STATE__']	= "NO_MEMBER";
			$result['__MSG__']		= "관리자만 수정 할 수 있습니다.";
			break;
		endif;

		## 데이터 수정
		$param					= "";
		$param['EM_NO']			= $intEM_NO;
		$param['EM_TITLE']		= $strEM_TITLE;
		$param['EM_TEXT']		= $strEM_TEXT;
		$param['EM_AUTO']		= $strEM_AUTO;
		$param['EM_SENDER']		= $strEM_SENDER;
		$param['EM_RECIPIENT']	= $strEM_RECIPIENT;
		$param['EM_MOD_DT']		= "NOW()";
		$param['EM_MOD_NO']		= $intMemberNo;
		$re						= $objEmailMgrModule->getEmailMgrUpdateEx($param);

		## 파일 생성
		$param					= "";
		$param['EM_NO']			= $intEM_NO;
		$aryEmailMgrRow			= $objEmailMgrModule->getEmailMgrSelectEx("OP_SELECT", $param);
		$strEM_SEND_CODE		= $aryEmailMgrRow['EM_SEND_CODE'];
		$strEM_LNG				= $aryEmailMgrRow['EM_LNG'];
		$strEM_LNG_LOWER		= strtoLower($strEM_LNG);
		$strMailFileName		= SHOP_HOME . "/layout/mail/mailContents_{$strEM_LNG_LOWER}_{$strEM_SEND_CODE}.html";

		## 파일이 없으면 생성
		if(!is_file($strMailFileName)):
			$objFile->makeFile($strMailFileName);
		endif;
		$objFile->fileWrite($strMailFileName, $strEM_TEXT);

		## INFO 파일 설정
		$strMailConfigFile		= SHOP_HOME . "/layout/mail/_config.inc.php";
			
		## 설정 파일 만들기
		$strMailConfigData		= "";
		$strDataTemp			= "";
		$strDataTemp			= "\$EM_SETTING_DATA['{$strEM_LNG}']['{$strEM_SEND_CODE}']['EM_AUTO']";
		$strDataTemp			= str_pad($strDataTemp, 70, " ", STR_PAD_RIGHT);
		$strDataTemp			= "{$strDataTemp} = \"{$strEM_AUTO}\";";
		$strDataTemp			= str_pad($strDataTemp, 140, " ", STR_PAD_RIGHT);
		$strDataTemp			= "## 자동 전송 여부\n{$strDataTemp}"; 
		$strMailConfigData	   .= ($strMailConfigData) ? "\n" : "";
		$strMailConfigData	   .= $strDataTemp;

		$strDataTemp			= "";
		$strDataTemp			= "\$EM_SETTING_DATA['{$strEM_LNG}']['{$strEM_SEND_CODE}']['EM_SENDER']";
		$strDataTemp			= str_pad($strDataTemp, 70, " ", STR_PAD_RIGHT);
		$strDataTemp			= "{$strDataTemp} = \"{$strEM_SENDER}\";";
		$strDataTemp			= str_pad($strDataTemp, 140, " ", STR_PAD_RIGHT);
		$strDataTemp			= "## 보내는 사람\n{$strDataTemp}"; 
		$strMailConfigData	   .= ($strMailConfigData) ? "\n" : "";
		$strMailConfigData	   .= $strDataTemp;

		$strDataTemp			= "";
		$strDataTemp			= "\$EM_SETTING_DATA['{$strEM_LNG}']['{$strEM_SEND_CODE}']['EM_RECIPIENT']";
		$strDataTemp			= str_pad($strDataTemp, 70, " ", STR_PAD_RIGHT);
		$strDataTemp			= "{$strDataTemp} = \"{$strEM_RECIPIENT}\";";
		$strDataTemp			= str_pad($strDataTemp, 140, " ", STR_PAD_RIGHT);
		$strDataTemp			= "## 받는 사람\n{$strDataTemp}"; 
		$strMailConfigData	   .= ($strMailConfigData) ? "\n" : "";
		$strMailConfigData	   .= $strDataTemp;

		$strDataTemp			= "";
		$strDataTemp			= "\$EM_SETTING_DATA['{$strEM_LNG}']['{$strEM_SEND_CODE}']['EM_TITLE']";
		$strDataTemp			= str_pad($strDataTemp, 70, " ", STR_PAD_RIGHT);
		$strDataTemp			= "{$strDataTemp} = \"{$strEM_TITLE}\";";
		$strDataTemp			= str_pad($strDataTemp, 140, " ", STR_PAD_RIGHT);
		$strDataTemp			= "## 메일 제목\n{$strDataTemp}"; 
		$strMailConfigData	   .= ($strMailConfigData) ? "\n" : "";
		$strMailConfigData	   .= $strDataTemp;

		$objFile->getMadeInfo($strMailConfigFile, $strMailConfigData, "/*@ MAIL_{$strEM_LNG}_{$strEM_SEND_CODE} @*/");

		## 마무리
		$result['__STATE__']	= "SUCCESS";
	break;

// 2013.12.26 kim hee sung - old style
//	case "sendMailModifyOK":
//
//		$emailMgr->getEmailUseUpdate($db);
//		$emailViewRow = $emailMgr->getEmailView($db);
//
//		/*-- 파일 생성 --*/
//		$strFileName			= $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/layout/mail/mailContents_".strtolower($strMailLng)."_{$strEM_SEND_CODE}.html";
//		updateHtmlFile($strFileName, $strEM_TEXT);
//
//		$aryData[0]['key']		= "\$EM_SETTING_DATA['{$strMailLng}']['{$strEM_SEND_CODE}']['EM_AUTO']";
//		$aryData[0]['data'] 	= "\"$strEM_AUTO\"";
//		$aryData[1]['key']		= "\$EM_SETTING_DATA['{$strMailLng}']['{$strEM_SEND_CODE}']['EM_SENDER']";
//		$aryData[1]['data'] 	= "\"$strEM_SENDER\"";
//		$aryData[2]['key']		= "\$EM_SETTING_DATA['{$strMailLng}']['{$strEM_SEND_CODE}']['EM_TITLE']";
//		$aryData[2]['data'] 	= "\"$strEM_TITLE\"";
//		$strFileName			= $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/layout/mail/_config.inc.php";
//		shopConfigFileUpdateEx ( $aryData, $strFileName );
//		/*-- 파일 생성 --*/
//
//		$txtModify		= "<div style='padding-bottom: 5px;'><a class='btn_sml' href='javascript:goMoveUrl(\"sendMailModify\",".$emailViewRow[EM_NO].")' id='menu_auth_m'><strong>".$LNG_TRANS_CHAR["CW00044"]."</strong></a></div>";
//		
//		$responseText  .= "<div id='modifyText_".$emailViewRow[EM_NO]."'><table class='mt10'>";
//		
//		$responseText  .= "<tr><th>".$LNG_TRANS_CHAR["EW00046"]."</th><td>".$emailViewRow[EM_SEND_NAME]."</td></tr>";
//		
//		$responseText  .= "<tr><th>".$LNG_TRANS_CHAR["EW00005"]."</th><td>$txtModify".$emailViewRow[EM_TITLE]."</td></tr>";
//		
//		$responseText  .= "</table></div>";
//	
//		echo $responseText;
//
//	break;
//
//	case "emailUseType":
//
//		$responseText  = ".";
//
////		$siteMgr->getEmailUseUpdate($db);
//		$aryData[0]["column"]	= "S_EMAIL_USE";
//		$aryData[0]["value"]	= $strS_EMAIL_USE;
//		shopInfoInsertUpdate($siteMgr, $aryData);	
//		
//		/*-- 파일 생성 --*/
//		$aryData[0]['key']		= "\$EM_SETTING_USE";
//		$aryData[0]['data'] 	= sprintf("\"%s\"", $strS_EMAIL_USE);
//		$strFileName			= $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/layout/mail/_config.inc.php";
//		shopConfigFileUpdateEx ( $aryData, $strFileName );
//		/*-- 파일 생성 --*/
//
//		echo $responseText;
//
//	break;

	}

?>
