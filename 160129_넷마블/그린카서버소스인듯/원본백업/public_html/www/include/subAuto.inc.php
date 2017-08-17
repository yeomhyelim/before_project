<?
	## 설정
	$subAutoIncludeFile		= "";
	
	switch($strMenuType):
	case "community2":
		// 커뮤니티 서브 페이지
		
		## 기본 설정
		$bCode							= $_GET['b_code'];
		$strStLng						= $S_SITE_LNG;

		$bCodeLower						= strtolower($bCode);
		$strStLngLower					= strtolower($strStLng);

		$subAutoIncludeFile				= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/{$strMenuType}/{$bCodeLower}/board.{$strStLngLower}.html.php";

	break;

	endswitch;

	include $subAutoIncludeFile;