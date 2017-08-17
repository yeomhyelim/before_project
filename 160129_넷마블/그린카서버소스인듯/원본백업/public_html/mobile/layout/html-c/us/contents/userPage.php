<?php 

	## 기본설정
	$strLangS = $S_ST_LNG;
	$strLangLower = strtolower($strLang);
	$strLangSLower = strtolower($strLangS);
	$strPageID = $_GET['id'];

	## 체크
	if(!$strPageID) { return; }
	
	## html file 설정
	$strContentFile1 = MALL_SHOP . "/layout/contents/{$strLangSLower}/contents_{$strPageID}.html.php";
	$strContentFile2 = MALL_SHOP . "/layout/contents/{$strLangLower}/contents_{$strPageID}.html.php";

	## 페이지 언어 파일이 있는경우, 해당 언어 파일 실행
	if(is_file($strContentFile2)) { $strContentFile1 = $strContentFile2; }

	## 페이지 include
	include $strContentFile1;