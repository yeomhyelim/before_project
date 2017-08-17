<?php
	## 프레임 코드 설정
	$strBCodeLower = strtolower($strBCode);
	$strFrameName = "{$strBCodeLower}_frame";

?>
<?php include_once MALL_HOME . "/include/header.inc.php";?>
<body class="bdCtl <?php echo $strBCodeLower;?>">

	<?php include "{$includeFile}"; ?>

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