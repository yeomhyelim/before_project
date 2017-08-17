<?include "./include/header.inc.php"?>

<?include $scriptFile; ?>

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
						<form name="form" id="form">
							<input type="hidden" name="menuType"	value="<?=$strMenuType?>">
							<input type="hidden" name="mode"		value="<?=$strMode?>">
							<input type="hidden" name="act"			value="<?=$strMode?>">
							<input type="hidden" name="lang"		value="<?=$strStLng?>">
							<?include $includeFile;?>
						</form>
						</div>
					<!-- ******************** contentsArea ********************** -->
				</td>
			</tr>
		</table>
	</div>

<?include "./include/bottom.inc.php"?>

</body>
</html>