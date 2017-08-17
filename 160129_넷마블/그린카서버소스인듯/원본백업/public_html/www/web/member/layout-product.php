<?php
	## 프레임 코드 설정
	$strFrameName = "product_frame";
?>
<?php include_once MALL_HOME . "/include/header.inc.php";?>
<?php include WEB_FRWORK_HELP."member.php";?>
<body>

	<!-- *********** Content Wrap ************  -->
			<div id="contentArea">
				<div id="contentWrap">
					<? include sprintf ( "%s%s/layout/html/member_body.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
				</div>
			</div>
	<!-- *********** Content Wrap ************  -->

	<?php include_once MALL_HOME . "/include/footer.inc.php";?>

	<script type="text/javascript">
		function init() {
			setInterval(function() {

				var height		= $("body").prop("offsetHeight");
				var frameId		= "<?php echo $strFrameName;?>";
				parent.document.getElementById(frameId).height = height + 25 + "px";
			});
		}
		window.onload = function() { init(); }
	</script>

</body>

</html>