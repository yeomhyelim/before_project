						<input type="hidden" name="groupCode" id="groupCode" value="<?=$strG_CODE?>">
						<input type="hidden" name="memberNo" value="<?=$intM_NO?>">
						<input type="hidden" name="searchOrderSortCol" id="searchOrderSortCol" value="<?=$strSearchOrderSortCol?>">
						<input type="hidden" name="searchOrderSort" id="searchOrderSort" value="<?=$strSearchOrderSort?>">
						<input type="hidden" name="searchOut" value="<?=$strSearchOut?>">

						<?if ($strMode != "memberList" && ($strMode == "memberModify")){?>
						<input type="hidden" name="searchField" value="<?=$strSearchField?>">
						<input type="hidden" name="searchKey" value="<?=$strSearchKey?>">
						<input type="hidden" name="searchRegStartDt" value="<?=$strSearchRegStartDt?>">
						<input type="hidden" name="searchRegEndDt" value="<?=$strSearchRegEndDt?>">
						<input type="hidden" name="searchOutStartDt" value="<?=$strSearchOutStartDt?>">
						<input type="hidden" name="searchOutEndDt" value="<?=$strSearchOutEndDt?>">
						<input type="hidden" name="searchGroup" value="<?=$strSearchGroup?>">
						<?}?>
