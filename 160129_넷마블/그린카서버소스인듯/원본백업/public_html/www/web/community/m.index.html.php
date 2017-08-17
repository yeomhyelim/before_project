<? include "./include/header.inc.php";?>


<!-- javascript Area -->
<? include "index.js.php" ?>
<!-- javascript Area -->

<body>

<!-- **** Top Area ***** -->
<?include "./include/top.inc.php";?>


<!-- *********** Content Wrap ************  -->
	<div id="contentWrap">
		<form name="form" method="post">
			<input type="hidden" name="menuType" id="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" id="mode"  value="<?=$strMode?>">
			<input type="hidden" name="act" id="act"  value="<?=$strMode?>">
			<input type="hidden" name="prodCode" id="prodCode"  value="">
			<input type="hidden" name="myTarget" id="myTarget" value="<?=$_REQUEST['myTarget']?>">
				
			<div id="contentArea">
				<div id="contentWrap" style="width:100%;">
					<div class="contentWrap">
					<!-- body html Area -->
					<? include sprintf ( "%s%s/mobile/layout/html/community_html.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
					<!-- body html Area -->
					</div>
				</div>
			</div>	
		</form>
	</div>
<!-- *********** Content Wrap ************  -->

<!-- ********* Bottom Area ********* -->
<?include "./include/bottom.inc.php";?>
<!-- ********* Bottom Area ********* -->
</body>
</html>










