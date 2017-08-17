						<input type="hidden" name="shopNo" id="shopNo" value="<?=$intSH_NO?>">	
						<input type="hidden" name="shopUserNo" id="shopUserNo" value="<?=$intSU_NO?>">
						<?if ($strMode != "shopList"){?>
						<input type="hidden" name="page" value="<?=$intPage?>">
						<input type="hidden" name="pageLine" value="<?=$intPageLine?>">
						<input type="hidden" name="searchField" value="<?=$strSearchField?>">
						<input type="hidden" name="searchKey" value="<?=$strSearchKey?>">
						<input type="hidden" name="searchComAuth" value="<?=$strSearchComAuth?>">
						<?}?>
						<input type="hidden" name="shopFileNo" value="">
						<?if ($strMode == "shopWrite" || $strMode == "shopModify"){?>
						<input type="hidden" name="shop_type" id="shop_type" value="<?=$strShopType?>">
						<?}?>
						<input type="hidden" name="state" value="">
						<input type="hidden" name="prodCode" value="">
						
