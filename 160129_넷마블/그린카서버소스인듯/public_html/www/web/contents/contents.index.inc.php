<?
	$arySkinFolder	= array(	"communityMain"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/sub_body_{$strMode}.inc.php",
								"helpDiskMain"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/sub_body_{$strMode}.inc.php",
							);
	if($arySkinFolder[$strMode]) :
		include $arySkinFolder[$strMode];
	else:
		include sprintf("%swww/web/%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $strMode );
	endif;
	
 ?>

