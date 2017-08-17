<?
	if(!$adminMenu):
		require_once MALL_CONF_LIB."AdminMenu.php";
		$adminMenu = new AdminMenu();				
	endif;

	/* 게시판 관리자 메뉴 가지고 오기 */
	$aryCommunityAdmList = $adminMenu->getCommunityAdmList($db);

	/* 게시판 리스트 메뉴 가지고 오기 */
	$aryCommunityList = $adminMenu->getCommunityList($db);


	$strCommunityListText  = "";
	if (is_array($aryCommunityAdmList)){
		for($i=0;$i<sizeof($aryCommunityAdmList);$i++){
			$intMN_LEVEL	= $aryCommunityAdmList[$i][MN_LEVEL];
			$intMN_NO		= $aryCommunityAdmList[$i][MN_NO];
			
			if ($intMN_LEVEL == 2) {
				$intMN_NO		= 6000 + $aryCommunityAdmList[$i][MN_NO];
			} else if ($intMN_LEVEL == 3) {
				$intMN_NO		= 5900 + (int)$aryCommunityAdmList[$i][MN_NO];
			}
			
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NO]			= \"".$intMN_NO."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_KR]		= \"".$aryCommunityAdmList[$i][MN_NAME_KR]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_US]		= \"".$aryCommunityAdmList[$i][MN_NAME_US]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_CN]		= \"".$aryCommunityAdmList[$i][MN_NAME_CN]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_JP]		= \"".$aryCommunityAdmList[$i][MN_NAME_JP]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_ID]		= \"".$aryCommunityAdmList[$i][MN_NAME_ID]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_FR]		= \"".$aryCommunityAdmList[$i][MN_NAME_FR]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_LEVEL]		= \"".$aryCommunityAdmList[$i][MN_LEVEL]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_URL]			= \"".$aryCommunityAdmList[$i][MN_URL]."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_USE]			= \"Y\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_ORDER]		= \"".$i."\"; \n";
			$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_GROUP_NO]	= \"\"; \n";
		}
	}


	if (is_array($aryCommunityList)){
		for($i=0;$i<sizeof($aryCommunityList);$i++){
			$intMN_LEVEL	= $aryCommunityList[$i][MN_LEVEL];
			$intMN_NO		= $aryCommunityList[$i][MN_NO];
			
			if ($intMN_LEVEL > 1) {
				if ($intMN_LEVEL == 2) {
					$intMN_NO		= 6000 + $aryCommunityList[$i][MN_NO];
				} else if ($intMN_LEVEL == 3) {
					$intMN_NO		= 5000 + (int)$aryCommunityList[$i][MN_NO];
				}

				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NO]			= \"".$intMN_NO."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_KR]		= \"".$aryCommunityList[$i][MN_NAME_KR]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_US]		= \"".$aryCommunityList[$i][MN_NAME_US]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_CN]		= \"".$aryCommunityList[$i][MN_NAME_CN]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_JP]		= \"".$aryCommunityList[$i][MN_NAME_JP]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_ID]		= \"".$aryCommunityList[$i][MN_NAME_ID]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_NAME_FR]		= \"".$aryCommunityList[$i][MN_NAME_FR]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_LEVEL]		= \"".$aryCommunityList[$i][MN_LEVEL]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_URL]			= \"".$aryCommunityList[$i][MN_URL]."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_USE]			= \"Y\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_ORDER]		= \"".$i."\"; \n";
				$strCommunityListText .= "\$aryMallAdminMenu[".$intMN_NO."][MN_GROUP_NO]	= \"".$aryCommunityList[$i][MN_GROUP_NO]."\"; \n";
		
			}
		}
	}


	$strCommunityListText = "<?\n".$strCommunityListText."?>\n";
	$file = "../conf/community.menu.inc.php";
	@chmod($file,0755);
	$fw = fopen($file, "w");
	fputs($fw,$strCommunityListText, strlen($strCommunityListText));
	fclose($fw);
?>