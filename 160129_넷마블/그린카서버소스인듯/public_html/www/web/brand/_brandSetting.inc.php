<?
	$arySkinFolder	= array(	"userPage"				=> "brand"		);

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "007";
	/* 관리자 권한 설정 */

	if ($strMode == "act" || $strMode == "json"){
		include $strIncludePath.$strMode.".php";
		exit;
	}

	if(!$includeFile):
		$includeFile = sprintf("%sskin/%s/%s.skin.php", $strIncludePath, $arySkinFolder[$strMode], $strMode);
	endif;

	if(!$includeJSFile):
		$includeJSFile = sprintf("%sskin/%s/%s.js.php", $strIncludePath, $arySkinFolder[$strMode], $strMode);
	endif;
?>