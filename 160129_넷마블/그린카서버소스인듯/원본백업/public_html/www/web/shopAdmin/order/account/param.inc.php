						<input type="hidden" name="searchAccStatus" id="searchAccStatus" value="<?=$strSearchAccStatus?>">
						<input type="hidden" name="accStatusUpdateType" id="" value="">
						<input type="hidden" name="shopNo" id="shopNo" value="<?=$intSH_NO?>">
						<input type="hidden" name="page" id="page" value="<?=$intPage?>">
						<input type="hidden" name="searchYN" id="searchYN" value="<?=$strSearchYN?>">
						<?if ($strMode != "accPeriodList" && $strMode != "accList"  && $strMode != "accDateList"){?>
						<input type="hidden" name="searchRegStartDt" id="searchRegStartDt" value="<?=$strSearchRegStartDt?>">
						<input type="hidden" name="searchRegEndDt" id="searchRegEndDt" value="<?=$strSearchRegEndDt?>">
						<input type="hidden" name="searchCompany" id="searchCompany" value="<?=$strSearchCompany?>">
						<?}?>