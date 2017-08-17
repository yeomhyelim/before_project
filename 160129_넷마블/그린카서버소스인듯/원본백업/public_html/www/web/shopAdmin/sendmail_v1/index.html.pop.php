
<? include "./include/header.inc.php" ?>

<!-- ******************** JavascriptArea *************** -->
<? include "index.html.js.php" ?>
<? include $includeJsFile; ?>
<!-- ******************** JavascriptArea *************** -->

<!-- ******************** contentArea ****************** -->

<div id="contentArea" style="min-width:0">
	<table style="width:100%">
	<tr>
		<td class="contentWrap" style="padding:10px 20px 0 0">	
			<!-- ******************** skinArea ********************** -->
			<div class="layoutWrap">
				<form name="form" id="form">
					<input type="hidden" name="menuType" value="<?=$strMenuType?>">
					<input type="hidden" name="mode" value="<?=$strMode?>">
					<input type="hidden" name="act" value="<?=$strMode?>">
					<input type="hidden" name="page" id="page" value="<?=$intPage?>">
					<input type="hidden" name="target" value="<?=$strTarget?>">
					<? include $includeFile;?>
				</form>
			</div>
			<!-- ******************** skinArea ********************** -->
		</td>
	</tr>
	</table>
</div>

<!-- ******************** contentArea ****************** -->


</body>

</html>