<?
	switch ($strMode){	
		case "shopApplyAgree":
			include WEB_FRWORK_JS.$strMenuType."_{$strMode}.js.php";
		break;
		case "shopApplyReg":
		case "shopApplyAdmin":
			
			include WEB_FRWORK_HELP."shop.{$strMode}.php";

			include WEB_FRWORK_JS.$strMenuType."_{$strMode}.js.php";
		break;
	}
?>