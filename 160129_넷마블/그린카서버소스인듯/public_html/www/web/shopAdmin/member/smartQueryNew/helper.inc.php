<?
	$strDE_SELECT		= $_POST["de_select"]		? $_POST["de_select"]		: $_REQUEST["de_select"];
	$strDE_WHERE		= $_POST["de_where"]		? $_POST["de_where"]		: $_REQUEST["de_where"];
	$strDE_WHERE_JOIN	= $_POST["de_where_join"]	? $_POST["de_where_join"]	: $_REQUEST["de_where_join"];
	$strDE_ORDER		= $_POST["de_order"]		? $_POST["de_order"]		: $_REQUEST["de_order"];
	$strNum				= $_POST["num"]				? $_POST["num"]				: $_REQUEST["num"];

	switch($strMode){
		case "dataEditNew":
			// 회원간편검색

			## STEP 1. 
			## 검색 컬럼이 없으면 break.
			if(!$strDE_SELECT) { break; }

			## STEP 2.
			## 설정 파일 불러오기
			include_once "dataEdit_query_{$strNum}.inc.php";

//			sleep(2);
		break;
	}
?>