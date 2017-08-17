<?
	$intNextOrderStep = $_REQUEST["step"];
	include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/userAdd/userOrder/orderNextStep.Common.php";
		
	include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/userAdd/userOrder/orderNextStep".$intNextOrderStep.".php";

	
?>