<?
	$strSubSkinName = STRTOUPPER($strMenuType)."_".STRTOUPPER($strMode);

	if($strMenuType=="product") {
		include sprintf("%swww/web/%s/%s.index.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType);
	}else if($strMenuType == "member" || $strMenuType == "order" || $strMenuType == "contents" || $strMenuType == "mypage" || $strMenuType == "shop") {
		include sprintf("%swww/web/%s/%s.index.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType);
	}else if($strMenuType == "community") {
		include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_community.inc.php";
	}else {

		if ($S_SKIN[$strSubSkinName]){
	//		echo sprintf("%swww/web/%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $S_SKIN[$strSubSkinName] );
			include sprintf("%swww/web/%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $S_SKIN[$strSubSkinName] );
		} else {
			include sprintf ("%swww/web/%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode);
		}

	}
	if($strMenuType=="reservation") {
		if($strMode=="" || $strMode=="list"){
			include sprintf("%shtml/%s/%s.index.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType);
		}else if($strMode=="start"){
			include sprintf("%shtml/%s/%s_%s.index.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode);
		}else if($strMode=="step1" || $strMode=="step2"){
			include sprintf("%shtml/%s/%s_%s.index.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode);
		}else if($strMode=="result" || $strMode=="rule" || $strMode == "inquiry" || $strMode=="result2"){
			include sprintf("%shtml/%s/%s_%s.index.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode);
		}
	}

?>