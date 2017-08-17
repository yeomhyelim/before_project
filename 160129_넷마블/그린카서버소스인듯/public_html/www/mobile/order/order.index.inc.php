<?
	$arySkinFolder	= array(	"buyNonList"		=> "order_cart_basket.inc.php",
								"cart"				=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/order/{$strMode}.php",
								"order"				=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/order/{$strMode}.php",
								"orderStep1"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/order/{$strMode}.php",
								"orderEnd"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/order/{$strMode}.php",
								"nextOrderStep"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/order/orderNextStep.php"
							);
	if($arySkinFolder[$strMode]) :
		include $arySkinFolder[$strMode];
	else:
		include sprintf("%swww/mobile/%s/%s", $S_DOCUMENT_ROOT, $strMenuType, $arySkinFolder[$strMode] );
	endif;
?>