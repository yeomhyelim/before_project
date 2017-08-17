<?

	$arySkinFolder	= array(	"list"				=> "productList.inc.php",
								"search"			=> "productList.inc.php",
								"brandMain"			=> "productBrandMain.inc.php",
								"brandList"			=> "productBrandList.inc.php",
								"view"				=> "productView.inc.php",
								"planMain"			=> "productPlanMain.inc.php"
								);

	## 2014.07.17 kim hee sung  productView 스킨기능 추가.
	if($S_PRODUCT_VIEW_SKIN == "tabSkin") { $arySkinFolder['view'] = "productView.{$S_PRODUCT_VIEW_SKIN}.inc.php"; }

	include $arySkinFolder[$strMode];
 ?>