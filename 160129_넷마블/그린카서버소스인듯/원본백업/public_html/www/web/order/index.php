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

		if ($strMode == "pgTest"){
			include WEB_FRWORK_ACT."OrderPgPayTest.php";
			exit;
		}
	}
	/*##################################### Act Page 이동 #####################################*/

	## 스크립트 리스트 설정
	$aryScript				= "";
	$aryScript[]			= "/common/js/common2.js";

	/*-- *********** Header Area *********** --*/
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT);

	include WEB_FRWORK_HELP."order.php";

	/*-- *********** Header Area *********** --*/

	include "../layout/html/order_html.inc.php";


?>

