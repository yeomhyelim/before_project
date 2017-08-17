<?php

	if(in_array($strMode, array("act", "json"))):
		include "{$strMode}.php";
		exit;
	endif;

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "007";
	/* 관리자 권한 설정 */

	/* 페이지 분류 */
	$aryIncludeFolder = array(	"popupList"				=> "popup",
								"popupWrite"			=> "popup",
								"popupList"				=> "popup",
								"popupModify"			=> "popup",
							 );

	$scriptFile		= "{$aryIncludeFolder[$strMode]}/script.inc.php";
	$includeFile	= "{$aryIncludeFolder[$strMode]}/{$strMode}.php";

	## script 설정
	$aryScript			= "";
	if($aryIncludeFolder[$strMode] == "popup"):
		$aryScript[]	= "../common/js/jquery.form.js";
		$aryScript[]	= "./common/js/oper/oper.js";
	endif;

	include "{$aryIncludeFolder[$strMode]}/helper.inc.php";

	include "layout.basic.php";
