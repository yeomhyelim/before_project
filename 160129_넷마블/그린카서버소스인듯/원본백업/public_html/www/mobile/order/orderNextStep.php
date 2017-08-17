<?
	include WEB_FRWORK_HELP."m.order.php";

	$intNextOrderStep = $_REQUEST["step"];
	//include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/layout/userAdd/userOrder/orderNextStep.Common.php";

	include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/layout/html-c/kr/userAdd/userOrder/orderNextStep".$intNextOrderStep.".php";


?>