<!-- *********** Header Area *********** -->
<body>
	<!-- *********** Quick Menu *********** -->
	<? include sprintf ( "%swww/include/quickMenu.skin.inc.php", $S_DOCUMENT_ROOT ); ?>
	<!-- *********** Quick Menu *********** -->

	<!-- *********** Top Area *********** -->
		<? include sprintf ( "%s%s/layout/html/main_top.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
	<!-- *********** Top Area *********** -->

	<!-- *********** Content Wrap ************  -->
			<div id="contentArea">
				<div id="contentWrap">
					<div id="leftArea">
					  <? include sprintf ( "%s%s/layout/html/productList_left.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
					</div>
					<div class="mainBodyWrap">
						<!-- *********** Content Wrap ************  -->
							<? include sprintf ( "%s%s/layout/html/community_body.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
						<!-- *********** Content Wrap ************  -->
					</div>
					<!-- 본문영역 -->
					<div class="clear"></div>
				</div>
			</div>
	<!-- *********** Content Wrap ************  -->

	<!-- ********* Bottom Area ********* -->
		<? include sprintf ( "%s%s/layout/html/main_bottom.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  ); ?>
	<!-- ********* Bottom Area ********* -->

</body>