	<div class="searchTableWrap mt20">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
				<option value="C" <?=($strSearchField=="C")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
				<option value="M" <?=($strSearchField=="M")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
				<option value="O" <?=($strSearchField=="O")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
				<option value="D" <?=($strSearchField=="D")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" <?=$nBox?> value="<?=$strSearchKey?>"/>
			<a class="btn_blue_big" href="javascript:goSearch('prodList');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchFormWrap -->

		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
				<td>
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchStartDt" name="searchLaunchStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchLaunchEndDt" name="searchLaunchEndDt" maxlength="10"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepStartDt" name="searchRepStartDt" maxlength="10"/>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="searchRepEndDt" name="searchRepEndDt" maxlength="10"/>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRepStartDt','searchRepEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="./?menuType=product&mode=prodList"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
				</td>
			</tr> 
			<tr>
				<th>브랜드</th>
				<td>
					<?=drawSelectBoxMoreQuery("searchProdBrand",$aryProdBrandList,$selected=$strSearchProdBrand,"","","",$LNG_TRANS_CHAR["PW00025"],"N","PR_NO","PR_NAME")?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
				<td>
					<input type="checkbox" id="searchWebView" name="searchWebView" value="Y"><?=$LNG_TRANS_CHAR["PW00011"] //웹?>
					<input type="checkbox" id="searchMobileView" name="searchMobileView" value="Y"><?=$LNG_TRANS_CHAR["PW00012"] //모바일?>
				</td>
			</tr>
			<?if(is_array($aryProdMainDisplayList)){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00027"] //메인 진열정보?></th>
				<td>
					<?for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
							$strSearchIconName = "searchIcon".($i+1);
							$strSearchIconChecked = (${"strSearchIcon".($i+1)} == "Y") ? "checked":""; 
						?>
						<input type="checkbox" id="<?=$strSearchIconName?>" name="<?=$strSearchIconName?>" value="Y" <?=$strSearchIconChecked?>><?=$aryProdMainDisplayList[$i][IC_NAME]?>
					<?}}?>
				</td>
			</tr>
			<?}?>
			<?if(is_array($aryProdSubDisplayList)){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00028"] //서브 진열정보?></th>
				<td>
					<?for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
							$strSearchIconName = "searchIcon".($i+6);
							$strSearchIconChecked = (${"strSearchIcon".($i+6)} == "Y") ? "checked":""; 
						?>
						<input type="checkbox" id="<?=$strSearchIconName?>" name="<?=$strSearchIconName?>" value="Y" <?=$strSearchIconChecked?>><?=$aryProdSubDisplayList[$i][IC_NAME]?>
					<?}}?>
				</td>
			</tr>
			<?}?>
			<?if ($a_admin_type == "A" && $S_MALL_TYPE == "M"){?>
			<tr>
				<th>입점사</th>
				<td>
					<?=drawSelectBoxMore("searchShopNo",$aryShopList,$strSearchShopNo,$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["OW00100"],$html="N","-1")?>
				</td>
			</tr>
			<?}?>
		</table>
	</div>