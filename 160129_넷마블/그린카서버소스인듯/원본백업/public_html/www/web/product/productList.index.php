<?
	## 작성자 : kim hee sung
	## 작성일 : 2013.07.18
	## 내  용 : 상품 리스트 분류
	##			productList, productList
	
	$arySkinFolder	= array(	"list"				=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/productList_body.inc.php",
								"search"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/productList_body_searchList.inc.php",
								"planMain"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/productList_body_planMain.inc.php"		);

	include $arySkinFolder[$strMode];
?>