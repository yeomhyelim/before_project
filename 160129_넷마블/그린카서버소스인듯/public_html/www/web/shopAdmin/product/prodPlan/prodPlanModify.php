<?php
	## 스크립트 설정 
	$aryScriptEx[] = "/common/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js";
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/product/prodPlan/prodPlanModify.js";
?>
<link rel="stylesheet" type="text/css" href="/common/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<div id="contentArea">
	<div class="contentTop">
		<h2><?="기획전수정" //기획전 수정?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap" style="margin-top:10px;">
		<table  class="tableForm">
			<tr>
				<th><?="기획전명" //기획전명?></th>
				<td><input type="text" id="pp_title" name="pp_title" <?=$nBox?>  style="width:500px;" value="<?=$row['PL_NAME']?>"/></td>
				<th><?="기간" //기간?></th>
				<td>
					<input type="text" <?=$nBox?> style="width:100px;" id="pp_start_dt" name="pp_start_dt" value="<?=SUBSTR($row['PL_START_DT'],0,10)?>"/>
					-
					<input type="text" <?=$nBox?> style="width:100px;" id="pp_end_dt" name="pp_end_dt" value="<?=SUBSTR($row['PL_END_DT'],0,10)?>"/>
				</td>
			</tr>
			<tr>
				<th><?="사용여부" //사용여부?></th>
				<td colspan="3">
					<input type="radio" id="pp_view" name="pp_view" value="Y" <?=($row['PL_USE']=="Y")?"checked":"";?>/>Yes
					<input type="radio" id="pp_view" name="pp_view" value="N" <?=($row['PL_USE']=="N")?"checked":"";?>/>No
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
					<textarea name="pp_html" style="display:none"><?=$row['PL_HTML']?></textarea>
				</td>
			</tr>
		</table>
	</div>

	<div class="tableFormWrap mt20">
		<table class="tableForm">
			<tr>
				<th><?="카테고리선택" //카테고리선택?></th>
				<td>
					<select id="cateHCode1" name="cateHCode1">
						<option value="">=<?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate01)){
			
							for($i=0;$i<sizeof($aryCate01);$i++){
								$strSelected = ($aryCate01[$i][CATE_CODE] == SUBSTR($strCATE_CODE,0,3))? "selected":"";
								echo "<option value=\"".$aryCate01[$i][CATE_CODE]."\"".$strSelected.">".$aryCate01[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode2" name="cateHCode2">
						<option value="">=<?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate02)){
			
							for($i=0;$i<sizeof($aryCate02);$i++){
								$strSelected = ($aryCate02[$i][CATE_CODE] == SUBSTR($strCATE_CODE,3,3))? "selected":"";
								echo "<option value=\"".$aryCate02[$i][CATE_CODE]."\"".$strSelected.">".$aryCate02[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode3" name="cateHCode3">
						<option value="">=<?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate03)){
			
							for($i=0;$i<sizeof($aryCate03);$i++){
								$strSelected = ($aryCate03[$i][CATE_CODE] == SUBSTR($strCATE_CODE,6,3))? "selected":"";
								echo "<option value=\"".$aryCate03[$i][CATE_CODE]."\"".$strSelected.">".$aryCate03[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode4" name="cateHCode4">
						<option value="">=<?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?>=</option>
						<?
						if (is_array($aryCate04)){
			
							for($i=0;$i<sizeof($aryCate04);$i++){
								$strSelected = ($aryCate04[$i][CATE_CODE] == SUBSTR($strCATE_CODE,9,3))? "selected":"";
								echo "<option value=\"".$aryCate04[$i][CATE_CODE]."\"".$strSelected.">".$aryCate04[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<a class="btn_big" href="javascript:goProdCateAdd();"><strong><?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
				</td>
			</tr>
		</table>
	</div>
	<!-- 상품 추가 리스트 //-->
	<div id="divProdCateList">
		<?foreach($aryProdPlanCateList as $key => $cateData){
			$strCateCode				= $cateData['PL_P_CATE_CODE'];
			$aryProdPlanCateProdList	= $cateData['PL_P_CATE_PRODUCT'];
			?>
		<div style="overflow-x:hidden;overflow-y:scroll;width:100%;height:250px" id="divProdCate_<?=$strCateCode?>">
			<div class="tableListTopWrap mt20" id="divProdCateTop">
				<input type='hidden' name='prodCateCode[]' id='prodCateCode[]' value='<?=$cateData['PL_P_CATE_CODE']?>'>
				<span><?=$cateData['PL_P_CATE_NAME']?></span> 
				<div class="selectedSort">
					<a class="btn_blue_big" href="javascript:goProdAdd('<?=$cateData['PL_P_CATE_CODE']?>');" id="menu_auth_w" style=""><strong><?="상품등록" //상품등록?></strong></a>
				</div>
			</div>
			<div class="clear"></div>
			<div class="tableListWrap" id="divProdCateTableList">
				<table class="tableList">
					<tr>
						<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
						<th><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
						<th><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></th>
						<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?></th>
						<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
						<th><?=$LNG_TRANS_CHAR["CW00026"] //등록일?></th>
						<th><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></th>
					</tr>
					<?
						$intIndex = 1;
						foreach($aryProdPlanCateProdList as $prodKey => $prodData){
							
							$strProdQty = number_format($prodData[P_QTY]);
							if ($prodData['P_QTY'] == 0){
								if ($prodData['P_STOCK_OUT'] == "Y"){
									$strProdQty = $LNG_TRANS_CHAR["PW00041"];	
								}

								if ($prodData['P_STOCK_LIMIT'] == "Y"){
									$strProdQty = $LNG_TRANS_CHAR["PW00020"];	
								}
							} 
					?>
					<tr>
						<td><input type="hidden" name="prodCode_<?=$strCateCode?>[]" id="prodCode_<?=$strCateCode?>[]" value="<?=$prodData['PL_P_CODE']?>">
						<span id="spanTrNo"><?=$intIndex++?></span></td>
						<td><?=$prodData['P_NAME']?></td>
						<td><?=$prodData['P_CODE']?></td>
						<td><?=getCurToPrice($prodData['P_SALE_PRICE'],$strStLng)?></td>
						<td><?=$strProdQty?></td>
						<td><?=$prodData['P_REG_DT']?></td>
						<td><a class="btn_sml" href="javascript:goProdCateTrDel('<?=$strCateCode?>','<?=$intIndex-1?>');" id="menu_auth_d"><strong><?=$LNG_TRANS_CHAR['CW00004'] // 삭제?></strong></td>
					</tr>
					<?	}?>
				</table>
			</div>
		</div>
		<?}?>

	</div>
	<!-- 상품 추가 리스트 //-->
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:void(0);" onclick="goProductProdPlanModifyActEvent();" id="menu_auth_m" style="display:none"><strong class="ico_modify"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a class="btn_new_gray" href="javascript:goProdPlanList('<?=$strStLng?>');"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	</div>
<!-- ******** 컨텐츠 ********* -->