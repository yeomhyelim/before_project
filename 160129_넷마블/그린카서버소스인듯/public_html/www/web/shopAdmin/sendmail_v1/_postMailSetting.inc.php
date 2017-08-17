<?
	$arySkinFolder	= array(	"sendmail"				=> "sendMail",
								"postMailWrite"			=> "postMail",
								"postMailList"			=> "postMail",
								"postMailView"			=> "postMail",
								"postMailModify"		=> "postMail",	
								"postMailTestSend"		=> "postMail",
								"postMailShot"			=> "postMail",
								"postMailLogList"		=> "postMailLog",
								"collectionEmail"		=> "collection",
								"excelCollectionEmail"	=> "collection",		);

	/* 메일 설정 국가 */
	if (!$strMailLng) $strMailLng = $S_SITE_LNG;
	$emailMgr->setEM_LNG($strMailLng);				
	/* 메일 설정 국가 */

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "007";
	/* 관리자 권한 설정 */

	if ($strMode == "act" || $strMode == "json" || $strMode == "excel"){
		include $strIncludePath.$strMode.".php";
		exit;
	}

	if(!$includeFile):
		$includeFile = sprintf("%sskin/%s/%s.skin.php", $strIncludePath, $arySkinFolder[$strMode], $strMode);
	endif;

	if(!$includeJsFile):
		$includeJsFile = sprintf("%sskin/%s/%s.js.php", $strIncludePath, $arySkinFolder[$strMode], $strMode);
	endif;
	
?>