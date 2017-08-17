						<input type="hidden" name="planNo" value="<?=$intPL_NO?>">
						<input type="hidden" name="page" value="<?=$intPage?>">

						<?if ($strMode != "prodPlanList"){?>
						<input type="hidden" name="searchField" id="searchField" value="<?=$_REQUEST['searchField']?>">
						<input type="hidden" name="searchKey" id="searchKey" value="<?=$_REQUEST['searchKey']?>">
						<input type="hidden" name="searchStartDt" id="searchStartDt" value="<?=$_REQUEST['searchStartDt']?>">
						<input type="hidden" name="searchEndDt" id="searchEndDt" value="<?=$_REQUEST['searchEndDt']?>">
						<input type="hidden" name="searchViewY" id="searchViewY" value="<?=$_REQUEST['searchViewY']?>">
						<input type="hidden" name="searchViewN" id="searchViewN" value="<?=$_REQUEST['searchViewN']?>">
						<?}?>