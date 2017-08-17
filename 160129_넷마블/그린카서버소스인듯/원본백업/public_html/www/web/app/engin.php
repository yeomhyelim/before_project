<?php

	## code 설정
	switch($e['mode']):
	case "include":

		## 기본설정
		$strEnginInclude = $e['include'];
		
		## 예약어 설정
//		if($strEnginInclude == "contents") { $strEnginInclude = SHOP_HOME . "/{$strDevice}/layout/html-c/{$strLang}/{$strMenuType}/{$strMode}.php"; }
		
		if($strEnginInclude == "contents"):
			$strEnginInclude = MALL_SHOP . "/{$strDevice}/layout/html-c/{lang}/{$strMenuType}/{$strMode}.php";
			$strEnginInclude = getFileLang($strEnginInclude);
		elseif($strEnginInclude == "header"):
			$strEnginInclude = MALL_SHOP . "/{$strDevice}/layout/html-c/{lang}/{$strMenuType}/header.inc.php";
			$strEnginInclude = getFileLang($strEnginInclude);
		elseif($strEnginInclude == "footer"):
			$strEnginInclude = MALL_SHOP . "/{$strDevice}/layout/html-c/{lang}/{$strMenuType}/footer.inc.php";
			$strEnginInclude = getFileLang($strEnginInclude);
		endif;

		## 체크
		if(!$strEnginInclude) { return; }

		## include 호출
		echo "<!-- {$strEnginInclude} //-->";
		include $strEnginInclude;

	break;
	endswitch;
