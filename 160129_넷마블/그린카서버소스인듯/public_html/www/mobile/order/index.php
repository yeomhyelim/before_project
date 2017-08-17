<?
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || $strMode == "pg"){
		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Order.php";
			exit;
		}
		
		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Order.php";
			exit;
		}

		if ($strMode == "pg"){
			include WEB_FRWORK_ACT."OrderPgPay.php";
			exit;
		}
	}
	/*##################################### Act Page 이동 #####################################*/

	/*-- *********** Header Area *********** --*/
	include "./include/header.inc.php"; 

	include WEB_FRWORK_HELP."m.order.php";
	/*-- *********** Header Area *********** --*/
	
?>

