<?php

	## json 처리
	if($strMode == "json"):
		include_once $strIncludePath . $strMode . ".php";
		exit;
	endif;

	## 페이지 분류
	$aryIncludeFolder = array(	"htmlModify"			=> "html"
							 );

	## helper 설정
	include "{$aryIncludeFolder[$strMode]}/helper.inc.php";

	## includeFile 설정
	$includeFile	= "{$aryIncludeFolder[$strMode]}/{$strMode}.php";

	## 실행
	include "index.html.php";