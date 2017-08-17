						<input type="hidden" name="lang" value="<?=$strStLng?>">
						<input type="hidden" name="prodCode" id="prodCode" value="<?=$strP_CODE?>">
						<input type="hidden" name="prodImgNo" id="prodImgNo" value="">
						<input type="hidden" name="prodLang" id="prodLang" value="<?=$strProdLng?>">
						<input type="hidden" name="page" value="<?=$intPage?>">
						<?if ($strMode != "prodList" && ($strMode == "prodModify")){?>
						<input type="hidden" name="pageLine" value="<?=$intPageLine?>">
						<input type="hidden" name="searchField" value="<?=$strSearchField?>">
						<input type="hidden" name="searchKey" value="<?=$strSearchKey?>">
						<input type="hidden" name="searchCate1" value="<?=$strSearchHCode1?>">
						<input type="hidden" name="searchCate2" value="<?=$strSearchHCode2?>">
						<input type="hidden" name="searchCate3" value="<?=$strSearchHCode3?>">
						<input type="hidden" name="searchCate4" value="<?=$strSearchHCode4?>">
						<input type="hidden" name="searchLaunchStartDt" value="<?=$strSearchLaunchStartDt?>">
						<input type="hidden" name="searchLaunchEndDt" value="<?=$strSearchLaunchEndDt?>">
						<input type="hidden" name="searchRepStartDt" value="<?=$strSearchRepStartDt?>">
						<input type="hidden" name="searchRepEndDt" value="<?=$strSearchRepEndDt?>">
						<input type="hidden" name="searchWebView" value="<?=$strSearchWebView?>">
						<input type="hidden" name="searchMobileView" value="<?=$strSearchMobileView?>">
						<input type="hidden" name="searchIcon1" value="<?=$strSearchIcon1?>">
						<input type="hidden" name="searchIcon2" value="<?=$strSearchIcon2?>">
						<input type="hidden" name="searchIcon3" value="<?=$strSearchIcon3?>">
						<input type="hidden" name="searchIcon4" value="<?=$strSearchIcon4?>">
						<input type="hidden" name="searchIcon5" value="<?=$strSearchIcon5?>">
						<input type="hidden" name="searchIcon6" value="<?=$strSearchIcon6?>">
						<input type="hidden" name="searchIcon7" value="<?=$strSearchIcon7?>">
						<input type="hidden" name="searchIcon8" value="<?=$strSearchIcon8?>">
						<input type="hidden" name="searchIcon9" value="<?=$strSearchIcon9?>">
						<input type="hidden" name="searchIcon10" value="<?=$strSearchIcon10?>">
						<input type="hidden" name="searchShopNo" value="<?=$strSearchShopNo?>">
						<?}?>
