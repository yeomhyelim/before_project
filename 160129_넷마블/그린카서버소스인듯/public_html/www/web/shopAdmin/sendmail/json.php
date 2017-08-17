<?
	switch ($strAct){

	case "sendMailModifyOK":

		$emailMgr->getEmailUseUpdate($db);
		$emailViewRow = $emailMgr->getEmailView($db);

		/*-- 파일 생성 --*/
		$strFileName			= $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/layout/mail/mailContents_".strtolower($strMailLng)."_{$strEM_SEND_CODE}.html";
		updateHtmlFile($strFileName, $strEM_TEXT);

		$aryData[0]['key']		= "\$EM_SETTING_DATA['{$strMailLng}']['{$strEM_SEND_CODE}']['EM_AUTO']";
		$aryData[0]['data'] 	= "\"$strEM_AUTO\"";
		$aryData[1]['key']		= "\$EM_SETTING_DATA['{$strMailLng}']['{$strEM_SEND_CODE}']['EM_SENDER']";
		$aryData[1]['data'] 	= "\"$strEM_SENDER\"";
		$aryData[2]['key']		= "\$EM_SETTING_DATA['{$strMailLng}']['{$strEM_SEND_CODE}']['EM_TITLE']";
		$aryData[2]['data'] 	= "\"$strEM_TITLE\"";
		$strFileName			= $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/layout/mail/_config.inc.php";
		shopConfigFileUpdateEx ( $aryData, $strFileName );
		/*-- 파일 생성 --*/

		$txtModify		= "<div style='padding-bottom: 5px;'><a class='btn_sml' href='javascript:goMoveUrl(\"sendMailModify\",".$emailViewRow[EM_NO].")' id='menu_auth_m'><strong>".$LNG_TRANS_CHAR["CW00044"]."</strong></a></div>";
		
		$responseText  .= "<div id='modifyText_".$emailViewRow[EM_NO]."'><table class='mt10'>";
		
		$responseText  .= "<tr><th>".$LNG_TRANS_CHAR["EW00046"]."</th><td>".$emailViewRow[EM_SEND_NAME]."</td></tr>";
		
		$responseText  .= "<tr><th>".$LNG_TRANS_CHAR["EW00005"]."</th><td>$txtModify".$emailViewRow[EM_TITLE]."</td></tr>";
		
		$responseText  .= "</table></div>";
	
		echo $responseText;

	break;

	case "emailUseType":

		$responseText  = ".";

//		$siteMgr->getEmailUseUpdate(&$db);
		$aryData[0]["column"]	= "S_EMAIL_USE";
		$aryData[0]["value"]	= $strS_EMAIL_USE;
		shopInfoInsertUpdate($siteMgr, $aryData);	
		
		/*-- 파일 생성 --*/
		$aryData[0]['key']		= "\$EM_SETTING_USE";
		$aryData[0]['data'] 	= sprintf("\"%s\"", $strS_EMAIL_USE);
		$strFileName			= $S_DOCUMENT_ROOT . $S_SHOP_HOME . "/layout/mail/_config.inc.php";
		shopConfigFileUpdateEx ( $aryData, $strFileName );
		/*-- 파일 생성 --*/

		echo $responseText;

	break;

	}

?>
