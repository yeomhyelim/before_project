<?
	## 기본 설정
	$temp				= $strMenuType;
	
	if($temp == "community2") { $temp = "community"; }

	include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/{$temp}_body.inc.php";