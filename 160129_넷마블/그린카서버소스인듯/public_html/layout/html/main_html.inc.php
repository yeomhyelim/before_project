<body>
	<div class="mainContentBox">
		<? include sprintf ( "%swww/include/quickMenu.skin.inc.php", $S_DOCUMENT_ROOT ); ?>
		<? include sprintf ( "%s%s/layout/html/main_top.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
		<? include sprintf ( "%s%s/layout/html/main_body.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
		<? include sprintf ( "%s%s/layout/html/%s/main_bottom.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH  ); ?>
	</div>
</body>