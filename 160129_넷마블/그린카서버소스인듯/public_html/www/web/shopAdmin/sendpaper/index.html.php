
<? include "./include/header.inc.php" ?>

<!-- ******************** JavascriptArea *************** -->
<? include "index.html.js.php" ?>
<? include $includeCommonJSFile; ?>
<? include $includeJSFile; ?>
<!-- ******************** JavascriptArea *************** -->

<!-- ******************** TopArea ********************** -->
<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->

<!-- ******************** contentArea ****************** -->
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
			<!-- ******************** skinArea ********************** -->
			<div class="layoutWrap">
				<form name="form" id="form">
					<input type="hidden" name="menuType" id="menuType" value="<?=$strMenuType?>">
					<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
					<input type="hidden" name="act" id="act" value="<?=$strAct?>">
					<input type="hidden" name="page" id="page" value="<?=$intPage?>">
					<input type="hidden" name="myTarget" id="myTarget" value="<?=$strTarget?>">
					<? include $includeFile;?>
				</form>
			</div>
			<!-- ******************** skinArea ********************** -->
		</td>
	</tr>
	</table>
</div>
<!-- ******************** contentArea ****************** -->

<!-- ******************** footerArea ******************* -->
<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ******************* -->

</body>

</html>

