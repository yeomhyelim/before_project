<?php
	## 스크립트 설정 
	$aryScriptEx[] = "/common/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.js";
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/product/prodPlan/prodPlanWrite.js";
?>
<link rel="stylesheet" type="text/css" href="/common/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<div id="contentArea">
	<div class="contentTop">
		<h2><?="기획전등록" //기획전 등록?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap" style="margin-top:10px;">
		<table class="tableForm">
			<tr>
				<th><?="기획전명" //기획전명?></th>
				<td><input type="text" id="pp_title" name="pp_title" <?=$nBox?>  style="width:500px;"/></td>
				<th><?="기간" //기간?></th>
				<td>
					<input type="text" <?=$nBox?> style="width:100px;" id="pp_start_dt" name="pp_start_dt"/>
					-
					<input type="text" <?=$nBox?> style="width:100px;" id="pp_end_dt" name="pp_end_dt"/>
				</td>
			</tr>
			<tr>
				<th><?="사용여부" //사용여부?></th>
				<td colspan="3">
					<input type="radio" id="pp_view" name="pp_view" value="Y" checked/>Yes
					<input type="radio" id="pp_view" name="pp_view" value="N"/>No
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<?php include MALL_SHOP . "/common/eumEditor2/editor1.php";?>
					<textarea name="pp_html" style="display:none"></textarea>
				</td>
			</tr>
		</table>
	</div>

	<div class="tableForm mt20">
		<table>
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
		
	</div>
	<!-- 상품 추가 리스트 //-->
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:void(0);" onclick="goProductProdPlanWriteActEvent();" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
		<a class="btn_new_gray" href="javascript:goProdPlanList('<?=$strStLng?>');"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	</div>
<!-- ******** 컨텐츠 ********* -->