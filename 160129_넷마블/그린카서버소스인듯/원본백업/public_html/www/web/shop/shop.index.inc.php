<?
	$arySkinFolder	= array(
								"shopApply"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/shop_body_{$strMode}.inc.php",
								"shopApplyAgree"	=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/shop_body_{$strMode}.inc.php",
								"shopApplyReg"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/shop_body_{$strMode}.inc.php",
								"shopApplyAdmin"	=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/shop_body_{$strMode}.inc.php",
								"shopApplyEnd"	=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/shop_body_{$strMode}.inc.php",
								);

	if($arySkinFolder[$strMode]) :
		include $arySkinFolder[$strMode];
	else:
		include sprintf("%swww/web/%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode );
	endif;

 ?>

