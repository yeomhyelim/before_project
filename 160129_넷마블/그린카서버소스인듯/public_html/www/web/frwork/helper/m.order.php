<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";
	
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/member.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/paypal_conf_inc.php";

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;	

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$orderMgr = new OrderMgr();
	$productMgr = new ProductMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$pointMgr = new PointMgr();

	$strP_CODE				= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];
	$intO_NO				= $_POST["oNo"]					? $_POST["oNo"]					: $_REQUEST["oNo"];

	$intPB_NO				= $_POST["cartNo"]				? $_POST["cartNo"]				: $_REQUEST["cartNo"];
	$intPW_NO				= $_POST["wishNo"]				? $_POST["wishNo"]				: $_REQUEST["wishNo"];
	
	$intNo					= $_POST["no"]					? $_POST["no"]					: $_REQUEST["no"];

	$strSearchHCode1		= $_POST["lcate"]				? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strSearchHCode2		= $_POST["mcate"]				? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strSearchHCode3		= $_POST["scate"]				? $_POST["scate"]				: $_REQUEST["scate"];
	$strSearchHCode4		= $_POST["fcate"]				? $_POST["fcate"]				: $_REQUEST["fcate"];

	$intCartPage			= $_POST["cartPage"]			? $_POST["cartPage"]			: $_REQUEST["cartPage"];
	$intWishPage			= $_POST["wishPage"]			? $_POST["wishPage"]			: $_REQUEST["wishPage"];
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];

	/*################주문공통단################*/ 
	include WEB_FRWORK_HELP."order.order.php";
	
	include WEB_FRWORK_HELP."m.order.inc.php";
	/*################주문공통단################*/ 
	
	/*################공통 자바스크립트################*/ 
	include WEB_FRWORK_JS.$strMenuType.".js.php";
	/*################공통 자바스크립트################*/
	
	/*################모드별 자바스크립트################*/ 
	include WEB_FRWORK_JS."order_".$strMode.".js.php";
	/*################모드별 자바스크립트################*/

	if ($strMode == "order"){
	
		$strModeLngJsFile = "kr";
		if ($S_SITE_LNG != "KR"){
			$strModeLngJsFile = "for";
		}
		
		include WEB_FRWORK_JS."order_".$strMode.".".$strModeLngJsFile.".js.php";
	
		if ($S_SITE_LNG == "KR"){
			if ($S_PG == "K"){
			}
		}
	}
?>
