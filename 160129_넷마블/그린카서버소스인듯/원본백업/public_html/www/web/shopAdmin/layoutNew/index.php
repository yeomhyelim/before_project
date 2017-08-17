<?
	if($strMode == "act"):
		include "{$strMode}.php";
		exit;
	endif;

	if(substr($strMode, 0, 3) == "pop"):
		include "pop.php";
		exit;
	endif;

	/* 페이지 분류 */
	$aryIncludeFolder = array(	"htmlModify"			=> "html",
							 );

	$scriptFile		= "{$aryIncludeFolder[$strMode]}/script.inc.php";
	$includeFile	= "{$aryIncludeFolder[$strMode]}/{$strMode}.php";

	include "{$aryIncludeFolder[$strMode]}/helper.inc.php";

	include "index.html.php";
?>