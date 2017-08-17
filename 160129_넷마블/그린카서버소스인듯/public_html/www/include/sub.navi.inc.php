<?
	$strSubNaviPageName = sprintf ( "%swww/web/navi/sub_navi_%s_%s.inc.php", $S_DOCUMENT_ROOT, $S_DESIGN_LAYOUT,$strMenuType  );
	if (file_exists($strSubNaviPageName)){
		include sprintf ( "%swww/web/navi/sub_navi_%s_%s.inc.php", $S_DOCUMENT_ROOT, $S_DESIGN_LAYOUT,$strMenuType  );
	}
 
?>