<?include "./include/header.inc.php"?>

<?@include $scriptFile; ?>

<?include "./include/top.inc.php"?>

	<div id="contentArea">
		<table style="width:100%;">
			<tr>
				<td class="leftWrap">
					<!-- ******************** leftArea ********************** -->
						<?include "./include/left.inc.php"?>
					<!-- ******************** leftArea ********************** -->
				</td>
				<td class="contentWrap">
					<div class="bodyTopLine"></div>
					<!-- ******************** contentsArea ********************** -->
						<div class="layoutWrap">
							<?include $includeFile;?>
						</div>
					<!-- ******************** contentsArea ********************** -->
				</td>
			</tr>
		</table>
	</div>

<?include "./include/bottom.inc.php"?>

</body>
</html>