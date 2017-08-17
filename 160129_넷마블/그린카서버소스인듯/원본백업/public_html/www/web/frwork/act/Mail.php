<?
	switch ($strMailMode){
		case "searchPwd":
			ob_start();
			include $S_DOCUMENT_ROOT.$S_SHOP_HOME."/mailing/mailSearchPassForm.php";			
			$strMailHtml = ob_get_contents();
			ob_end_clean();
			
			
			$strMailSubj = ICONV("utf-8","euc-kr", "회원님의 임시 비밀번호가 발송 되었습니다.");
			
			$strMailHtml = STR_REPLACE("###SEARCH_ID###",$row[M_ID],$strMailHtml);
			$strMailHtml = STR_REPLACE("###SEARCH_NAME###",$row[M_NAME],$strMailHtml);
			$strMailHtml = STR_REPLACE("###SEARCH_PASS###",$strTmpPass,$strMailHtml);
		break;
	}


	ob_start();
	include $S_DOCUMENT_ROOT.$S_SHOP_HOME."/mailing/mailForm.php";
	$strMailFormHtml = ob_get_contents();
	ob_end_clean();

	$S_SITE_NAME = ICONV("utf-8","euc-kr", $S_SITE_NAME);
	$strPostMailName = ICONV("utf-8","euc-kr", $strPostMailName);

	$strMailFormHtml = STR_REPLACE("###MAIL_FORM###",$strMailHtml,$strMailFormHtml);
	sendMail($S_SITE_NAME,$S_SITE_MAIL,$strMailSubj,$strMailFormHtml,"Y",$strPostMailName,$strPostMailAddr,"UTF-8");


?>