<?php

	## 기본설정
	$strLayout = $_GET['layout'];

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || SUBSTR($strMode,0,3) == "pop"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Member.php";
			exit;
		}
		
		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Member.php";
			exit;
		}

		if (SUBSTR($strMode,0,3) == "pop") {
			include "{$strIncludePath}{$strMode}.php";
			exit;
		}
	}
	/*##################################### Act Page 이동 #####################################*/

	## layout 설정
	if(!$strLayout) { $strLayout = "default"; }
	include_once "layout-{$strLayout}.php";

