<body>
	<? include sprintf ( "%swww/include/quickMenu.skin.inc.php", $S_DOCUMENT_ROOT ); ?>
	<? include sprintf ( "%s%s/layout/html/sub_top.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
	<div id="contentArea">
		<? include "{$S_DOCUMENT_ROOT}www/web/product/productList.index.php" ?>
	</div>
	<? include sprintf ( "%s%s/layout/html/%s/main_bottom.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH  ); ?>

</body>