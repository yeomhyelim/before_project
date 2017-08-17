<?
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/
	if ($strMode == "act" || $strMode == "json" || $strMode == "userJson" || $strMode == "open" || SUBSTR($strMode,0,3) == "pop"){

		if ($strMode == "act"){
			include WEB_FRWORK_ACT."Product.php";
			exit;
		}

		if ($strMode == "userJson"){
			include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/html/json/product.php";
			exit;
		}

		if ($strMode == "json"){
			include WEB_FRWORK_JSON."Product.php";
			exit;
		}

		if ($strMode == "open") {
			include "include/{$strOpenUrl}.OpenWindow.index.inc.php";
			exit;
		}

		if (SUBSTR($strMode,0,3) == "pop") {
			include "{$strIncludePath}{$strMode}.php";
			exit;
		}
	}


	


	/*##################################### Act Page 이동 #####################################*/

	## 스크립트 리스트 설정
	$aryScript				= "";
	$aryScript[]			= "/common/js/common2.js";

	/*-- *********** Header Area *********** --*/
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT);
	/*-- *********** Header Area *********** --*/

	if(!($S_USER_PRODUCT_VIEW_HELPER == 'Y' && $strMode == "view")) {
		include WEB_FRWORK_HELP."product.php";
	}

	if($strMode == "view") :
		include "../layout/html/productView_html.inc.php";
	elseif($strMode == "prodInquiry"): //상품문의하기
		include MALL_HOME . "/web/product/productInquiry.popup.inc.php";
	elseif($strMode == "prodCompare"): //상품비교하기
		include MALL_HOME . "/web/product/prodCompare.popup.inc.php";
	elseif($strMode == "brandMain" || $strMode == "brandList") :
		include "../layout/html/brand_html.inc.php";
	elseif($strMode == "categoryMain"):
		include "../layout/html/productList_body_categoryMain.inc.php";
	elseif($strMode == "planMain"):
		include "../layout/html/productList_body_planMain.inc.php";
	elseif(in_array($strMode, array("shopMain","shopProdList"))):
		include "../layout/html/shop_html.inc.php";
	else :
		include "../layout/html/productList_html.inc.php";
	endif;

?>

