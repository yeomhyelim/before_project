<body>
	<? include sprintf ( "%swww/include/quickMenu.skin.inc.php", $S_DOCUMENT_ROOT ); ?>
	<? include sprintf ( "%s%s/layout/html/main_top.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
	<div id="contentArea">
		<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
		<div id="contentWrap">
			<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>		
		</div>
		<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
	</div>
	<? include sprintf ( "%s%s/layout/html/%s/main_bottom.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH  ); ?>
</body>