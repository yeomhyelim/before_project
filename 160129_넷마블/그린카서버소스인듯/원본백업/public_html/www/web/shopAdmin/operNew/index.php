<?
	if($strMode == "act"):
		include "{$strMode}.php";
		exit;
	endif;

	/* 페이지 분류 */
	$aryIncludeFolder = array(	"popupList"				=> "popup",
								"popupWrite"			=> "popup",
								"popupList"				=> "popup",
								"popupModify"			=> "popup",
							 );

	$scriptFile		= "{$aryIncludeFolder[$strMode]}/script.inc.php";
	$includeFile	= "{$aryIncludeFolder[$strMode]}/{$strMode}.php";

	include "{$aryIncludeFolder[$strMode]}/helper.inc.php";

	include "index.html.php";
?>