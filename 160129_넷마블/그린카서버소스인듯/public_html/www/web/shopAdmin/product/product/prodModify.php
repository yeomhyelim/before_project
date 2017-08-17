<?
	## 모듈 설정
	$objCommGrpModule = new CommGrpModule($db);
	$objProductSearchModule = new ProductSearchModule($db);

	## 설정
	$strStLngLower		= strtolower($S_ST_LNG);
	//요청으로 소수점 나타나도록. prodModify 남덕희
	$intSalePrice		= $prodRow['P_SALE_PRICE'];
//	if (!is_float( $intSalePrice)) {
//		$intSalePrice		= getCurToPriceSave($prodRow['P_SALE_PRICE'], $S_ST_LNG);
//	}
	$intStockPrice		= getCurToPriceSave($prodRow['P_STOCK_PRICE'],$S_ST_LNG);
	$intConsumerPrice	= getCurToPriceSave($prodRow['P_CONSUMER_PRICE'],$S_ST_LNG);

/*
2015.03.10 bdcho
:포인트 소숫점 1자리로 반올림
{{
*/
//	$intPoint			= getCurToPriceSave($prodRow['P_POINT'],$S_ST_LNG);
	$intPoint			= round($prodRow['P_POINT'], 1);
	/*
	}}
	2015.03.10 bdcho
	:포인트 소숫점 1자리로 반올림
	*/

	if($S_PRODUCT_SEARCH_USE == "Y"):
		## 상품찾기 설정
		$param = "";
		$param['ORDER_BY'] = "CG.CG_NO ASC";
		$param['CG_CODE_LIKE'] = "PROD_SEARCH%";
		$aryCommGrpList = $objCommGrpModule->getCommGrpSelectEx("OP_ARYTOTAL", $param);

		## 상품찾기 등록된 데이터 가져오기
		$param = "";
		$param['PS_P_CODE'] = $strP_CODE;
		$aryProductSearchRow = $objProductSearchModule->getProductSearchSelectEx("OP_SELECT", $param);
	endif;

	## script 설정
	$aryScriptEx[] = "/common/eumEditor2/js/eumEditor2.js";
	$aryScriptEx[] = "./common/js/product/product/prodModify.js";

	## 에디터 업로드 경로 설정
	$strEditorDir = "product/product";
?>
<script type="text/javascript">
$(document).ready(function () {
    $("#btnAnimate").click(function () {
        $("#divSlideBox").slideToggle(function () {
            if ($("#divSlideBox").is(":hidden")) {
                $("#btnAnimate").val("Show");
            }
            else {
                $("#btnAnimate").val("Hide");
            }
        });
    });

});
</script>
<input type="hidden" name="prodShopCountry" value="<?=$strProdShopCountry?>">
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00086"] //상품수정?></h2>
		<div class="clr"></div>
	</div>

	<!-- 언어 선택 탭 -->
	<?include "./include/tab_language.inc.php";?>
	<!-- 언어 선택 탭-->

	<div class="tableForm">
		<table>
			<tr>
				<th>
				<span class="mustItem">&nbsp;</span><?= $LNG_TRANS_CHAR["PS00080"]; //표시가 있는 입력란은 필수 입력란입니다. 꼭 입력해 주세요! ?>
				</th>
			</tr>
		</table>
	</div>


	<div class="tableFormWrap">
		<h3><?=$LNG_TRANS_CHAR["PW00023"] //상품카테고리?></h3>
		<table class="tableForm">
			<tr>
				<td>
					<select id="cateHCode1" name="cateHCode1" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00013"]?> =</option>
						<?
						if (is_array($aryCate01)){

							for($i=0;$i<sizeof($aryCate01);$i++){
								$strSelected = ($aryCate01[$i][CATE_CODE] == SUBSTR($prodRow[P_CATE],0,3))? "selected":"";
								echo "<option value=\"".$aryCate01[$i][CATE_CODE]."\"".$strSelected.">".$aryCate01[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode2" name="cateHCode2" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00014"]?> =</option>
						<?
						if (is_array($aryCate02)){

							for($i=0;$i<sizeof($aryCate02);$i++){
								$strSelected = ($aryCate02[$i][CATE_CODE] == SUBSTR($prodRow[P_CATE],3,3))? "selected":"";
								echo "<option value=\"".$aryCate02[$i][CATE_CODE]."\"".$strSelected.">".$aryCate02[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<select id="cateHCode3" name="cateHCode3" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00015"]?> =</option>
						<?
						if (is_array($aryCate03)){

							for($i=0;$i<sizeof($aryCate03);$i++){
								$strSelected = ($aryCate03[$i][CATE_CODE] == SUBSTR($prodRow[P_CATE],6,3))? "selected":"";
								echo "<option value=\"".$aryCate03[$i][CATE_CODE]."\"".$strSelected.">".$aryCate03[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select>
					<!--select id="cateHCode4" name="cateHCode4" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00016"]?> =</option>
						<?
						if (is_array($aryCate04)){

							for($i=0;$i<sizeof($aryCate04);$i++){
								$strSelected = ($aryCate04[$i][CATE_CODE] == SUBSTR($prodRow[P_CATE],9,3))? "selected":"";
								echo "<option value=\"".$aryCate04[$i][CATE_CODE]."\"".$strSelected.">".$aryCate04[$i][CATE_NAME]."</option>";
							}
						}
						?>
					</select-->
				</td>
			</tr>
		</table>


		<h3 class="mt30"><?= $LNG_TRANS_CHAR["PW00294"]; //상품 노출 정보 ?></h3>
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
				<td>
					<?	## 다국어출력사용여부
						if ($S_PROD_MANY_LANG_VIEW == "Y"){
					?>
					<?= $LNG_TRANS_CHAR["PW00011"]; //웹 ?>:
						<input type="radio" id="" name="prodWebViewYN" value="Y" <?=($prodRow['P_WEB_VIEW_'.$strStLng]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00119"] //보임?>
						<input type="radio" id="" name="prodWebViewYN" value="N" <?=($prodRow['P_WEB_VIEW_'.$strStLng]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00120"] //보임?>
						 , <?= $LNG_TRANS_CHAR["PW00012"]; //모바일 ?>:
						<input type="radio" id="" name="prodMobViewYN" value="Y" <?=($prodRow['P_MOB_VIEW_'.$strStLng]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00119"] //보임?>
						<input type="radio" id="" name="prodMobViewYN" value="N" <?=($prodRow['P_MOB_VIEW_'.$strStLng]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00120"] //보임?>
					<?	}else{?>

					<input type="checkbox" id="" name="prodWebViewYN" value="Y" <?=($prodRow['P_WEB_VIEW']=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00011"] //WEB 보임?>
					<input type="checkbox" id="" name="prodMobViewYN" value="Y" <?=($prodRow['P_MOB_VIEW']=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00012"] //모바일 보임?>
					<?	}?>
						<div class="helpTxt">
							* <?=$LNG_TRANS_CHAR["PS00051"] //웹페이지와 모바일 페이지에 해당 상품 노출 여부를 선택합니다.?>
						</div>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodRepDt" name="prodRepDt" value="<?=SUBSTR($prodRow[P_REP_DT],0,10)?>"/>
				</td>
			</tr>

			<?if($a_admin_type == "A"){?>
				<?if(is_array($aryProdMainDisplayList)){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00026"] //상품우선순위?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodOrder" name="prodOrder" value="<?=$prodRow[P_ORDER];?>" maxlength="4"/>
					</td>
					<th>상품진열관리<?//=$LNG_TRANS_CHAR["PW00027"] //메인진열관리?></th>
					<td>
						<?if ($aryProdMainDisplayList[0][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon1" name="prodIcon1" value="Y" <?=($prodRow[ICON1]=="Y")?"checked":"";?>><?=$aryProdMainDisplayList[0][IC_NAME]?>
						<?}?>
						<?if ($aryProdMainDisplayList[1][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon2" name="prodIcon2" value="Y" <?=($prodRow[ICON2]=="Y")?"checked":"";?>><?=$aryProdMainDisplayList[1][IC_NAME]?>
						<?}?>
						<?if ($aryProdMainDisplayList[2][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon3" name="prodIcon3" value="Y" <?=($prodRow[ICON3]=="Y")?"checked":"";?>><?=$aryProdMainDisplayList[2][IC_NAME]?>
						<?}?>
						<?if ($aryProdMainDisplayList[3][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon4" name="prodIcon4" value="Y" <?=($prodRow[ICON4]=="Y")?"checked":"";?>><?=$aryProdMainDisplayList[3][IC_NAME]?>
						<?}?>
						<?if ($aryProdMainDisplayList[4][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon5" name="prodIcon5" value="Y" <?=($prodRow[ICON5]=="Y")?"checked":"";?>><?=$aryProdMainDisplayList[4][IC_NAME]?>
						<?}?>
						<?/*************?>
						<a href="./?menuType=product&mode=prodDisplay" class="btn_sml"><span><?=$LNG_TRANS_CHAR["PW00223"] //진열장관리?></span></a>
						<!--div class="helpTxt">
							* 메인페이지 추천상품을 관리합니다.<br>
							* 등록 상품을 원하시는 추천에 체크하시면 해당 영역에 노출 됩니다.
						</div-->
						<?if ($aryProdSubDisplayList[0][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon6" name="prodIcon6" value="Y" <?=($prodRow[ICON6]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[0][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[1][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon7" name="prodIcon7" value="Y" <?=($prodRow[ICON7]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[1][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[2][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon8" name="prodIcon8" value="Y" <?=($prodRow[ICON8]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[2][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[3][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon9" name="prodIcon9" value="Y" <?=($prodRow[ICON9]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[3][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[4][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon10" name="prodIcon10" value="Y" <?=($prodRow[ICON10]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[4][IC_NAME]?>
						<?}?>
					</td>

					<th><?=$LNG_TRANS_CHAR["PW00028"] //서브진열관리?></th>
					<td>
						<?if ($aryProdSubDisplayList[0][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon6" name="prodIcon6" value="Y" <?=($prodRow[ICON6]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[0][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[1][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon7" name="prodIcon7" value="Y" <?=($prodRow[ICON7]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[1][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[2][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon8" name="prodIcon8" value="Y" <?=($prodRow[ICON8]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[2][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[3][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon9" name="prodIcon9" value="Y" <?=($prodRow[ICON9]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[3][IC_NAME]?>
						<?}?>
						<?if ($aryProdSubDisplayList[4][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon10" name="prodIcon10" value="Y" <?=($prodRow[ICON10]=="Y")?"checked":"";?>><?=$aryProdSubDisplayList[4][IC_NAME]?>
						<?}?>
						<?*************/?>
					</td>

				</tr>
				<?}?>
			<?}else{?>
				<input type="hidden" name="prodOrder" value="<?=isset($prodRow['P_ORDER']) ? $prodRow['P_ORDER'] : '9999';?>" maxlength="4"/>
			<?} ?>

			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00030"] //검색어?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:500px;" id="prodKeyWord" name="prodKeyWord" value="<?=$prodRow[P_SEARCH_TEXT]?>"/>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00057"] //검색어는 콤마(,)로 구분하여 등록하세요.?><br>
						* <?=$LNG_TRANS_CHAR["PS00058"] //등록된 검색어는 사용자 페이지에서 상품 검색 시 함께 검색 됩니다.?>
					</div>
				</td>
			</tr>
		</table>
		<!--  ****************  -->
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["PW00024"] //상품기본정보?></h3>
		<table class="tableForm">
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>   style="width:90%;font-weight:bold;font-size:14px;" id="prodName" name="prodName" value="<?=($strProdShopCountry) ? "" : htmlspecialchars($prodRow[P_NAME]);?>"/>
				</td>
				<!-- 
				<th><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></th>
				<td >
					<input type="text" <?=$nBox?>  style="width:300px;" id="prodViewCode" name="prodViewCode" value="<?=$prodRow[P_NUM]?>"/>
				</td>
				-->
			</tr>
			<tr>
				<th><?= $LNG_TRANS_CHAR["OW00096"]; //업체명 ?></th>
				<td>
					<?=$shopInfo['SH_COM_NAME']?>
				</td>
				<th><span class="mustItem">Type<?//=$LNG_TRANS_CHAR["PW00003"] //상품코드?></span></th>
				<td >
					<select name="prodType">
						<option value=''> = TYPE =</option>
						<?	foreach($aryType as $key => $val){	?>
						<option value="<?=$key?>" <?=($key == $prodRow['P_TYPE']) ? 'selected' : '';?>><?echo $val?></option>
						<?}?>
					</select>
				</td>
			</tr>
			<tr>
			<?
			/************?>
				<th><?=($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MAKE']: $LNG_TRANS_CHAR["PW00004"]; //제조사?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodMake" name="prodMake" value="<?=$prodRow[P_MAKER]?>"/>
					<?=drawSelectBoxMoreQuery("selectProdMake",$aryProductMaker,$selected ="","","javascript:goSelectInputVal('Make');","",($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MAKE']: $LNG_TRANS_CHAR["PW00004"],"N","COL","COL")?>
				</td>
			<?
			************/?>
				<th><span class="mustItem"><?=($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['ORIGIN']: $LNG_TRANS_CHAR["PW00005"]; //원산지?></span></th>
				<td>
					<?=drawSelectBoxMore("prodOrigin",$aryCountryList,$prodRow[P_ORIGIN],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
					<!--<input type="text" <?=$nBox?>  style="width:150px;" id="prodOrigin" name="prodOrigin" value="<?=($strProdShopCountry) ? "" : $prodRow[P_ORIGIN];?>" readonly/>
					<?=drawSelectBoxMoreQuery("selectProdOrigin",$aryProductOrigin,$selected ="","","javascript:goSelectInputVal('Origin');","",($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['ORIGIN']: $LNG_TRANS_CHAR["PW00005"],"N","COL","COL");
					?>-->
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00045"] //최소구매수량?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodSaleMinQty" name="prodSaleMinQty" value="<?=$prodRow[P_MIN_QTY]?>"/>
					<select name="prodSaleUnit">
						<option value="BAG" <?=($prodRow[P_SAIL_UNIT] == 'BAG' ) ? ' selected ' : '' ;?> >BAG</option>
						<option value="BOX" <?=($prodRow[P_SAIL_UNIT] == 'BOX' ) ? ' selected ' : '' ;?> >BOX</option>
						<option value="DRUM" <?=($prodRow[P_SAIL_UNIT] == 'DRUM' ) ? ' selected ' : '' ;?> >DRUM</option>
						<option value="PIECE" <?=($prodRow[P_SAIL_UNIT] == 'PIECE' ) ? ' selected ' : '' ;?> >PIECE</option>
						<option value="PALLET" <?=($prodRow[P_SAIL_UNIT] == 'PALLET' ) ? ' selected ' : '' ;?> >PALLET</option>
					</select>
				</td>
			</tr>
			<script>
			function goPriceFilter(frm){
				var strPriceFilter = frm.value;
				if(strPriceFilter == 'EXW'){
					$("#priceUnit").html('원');
				}else if(strPriceFilter == 'FOB'){
					$("#priceUnit").html('$');
				}
			}
			</script>
			<tr>
				<th><span class="mustItem"><?= $LNG_TRANS_CHAR["PW00284"]; //상품가 ?></span></th>
				<td colspan="3">
					<!--
					<input type="radio" id="priceFilter" name="priceFilter" value="EXW" <?=($prodRow[P_PRICE_FILTER]=="EXW" && $strLang == 'KR') ? " checked ":"";?> onclick="javascript:goPriceFilter(this);" <?=($strLang == 'KR')? "" : " disabled";?> />EXW
					<input type="radio" id="priceFilter" name="priceFilter" value="FOB" <?=($prodRow[P_PRICE_FILTER]=="FOB" || $strLang != 'KR') ? " checked ":"";?> onclick="javascript:goPriceFilter(this);"/>FOB
					-->
					<? //P_PRICE_FILTER 언어별 구분 없음. 남덕희 ?>
					<input type="radio" id="priceFilter" name="priceFilter" value="EXW" <?=($prodRow[P_PRICE_FILTER]=="EXW") ? " checked ":"";?> onclick="javascript:goPriceFilter(this);" />EXW
					<input type="radio" id="priceFilter" name="priceFilter" value="FOB" <?=($prodRow[P_PRICE_FILTER]=="FOB") ? " checked ":"";?> onclick="javascript:goPriceFilter(this);" />FOB
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;color:#FF0000;" id="prodSalePrice" name="prodSalePrice" value="<?=$intSalePrice?>"/>
					<span id='priceUnit'>
					<?
					if($prodRow[P_PRICE_FILTER] == 'FOB' )	{
						echo "$";
					}else{
					 echo $S_ARY_MONEY_ICON[$S_ST_LNG]["R"];
					}
					?>
					</span>
					<select name="prodUnit" id="prodUnit">
						<!--
						<option value="kg" <?=($prodRow[P_PRICE_UNIT]=="kg")?"selected":"";?>>kg</option>
						<option value="g" <?=($prodRow[P_PRICE_UNIT]=="g")?"selected":"";?>>g</option>
						<option value="l" <?=($prodRow[P_PRICE_UNIT]=="l")?"selected":"";?>>l</option>
						<option value="ml" <?=($prodRow[P_PRICE_UNIT]=="ml")?"selected":"";?>>ml</option>
						-->
						<option value="kg" <?=($prodRow[P_PRICE_UNIT]=="kg")?"selected":"";?>>Kilogram(kg)</option>
						<option value="g" <?=($prodRow[P_PRICE_UNIT]=="g")?"selected":"";?>>Gram(g)</option>
						<option value="mg" <?=($prodRow[P_PRICE_UNIT]=="mg")?"selected":"";?>>Milligram(mg)</option>
						<option value="t" <?=($prodRow[P_PRICE_UNIT]=="t")?"selected":"";?>>Ton(t)</option>
						<option value="lb" <?=($prodRow[P_PRICE_UNIT]=="lb")?"selected":"";?>>Pound(lb)</option>
						<option value="oz" <?=($prodRow[P_PRICE_UNIT]=="oz")?"selected":"";?>>Ounce(oz)</option>
						<option value="L" <?=($prodRow[P_PRICE_UNIT]=="L")?"selected":"";?>>Liter(L)</option>
						<option value="ml" <?=($prodRow[P_PRICE_UNIT]=="ml")?"selected":"";?>>Milliliter(ml)</option>
						<option value="bbl" <?=($prodRow[P_PRICE_UNIT]=="bbl")?"selected":"";?>>Barrel(bbl)</option>
						<option value="gal" <?=($prodRow[P_PRICE_UNIT]=="gal")?"selected":"";?>>Gallon(gal)</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>CAS No</span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodCASNo" name="prodCASNo" value="<?=$prodRow[P_CAS_NO]?>" maxlength = "20"  />
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00040"] //수량?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodQty" name="prodQty" value="<?=$prodRow[P_QTY]?>" <?=($prodRow[P_STOCK_LIMIT]=="Y")?"disabled":"";?>/>
					<input type="checkbox" id="prodStockLimit" name="prodStockLimit" value="Y" <?=($prodRow[P_STOCK_LIMIT]=="Y")?"checked":"";?> onclick="javascript:goStockLimit(this);"/> <?=$LNG_TRANS_CHAR["PW00043"] //무제한상품?>
					<input type="checkbox" id="prodStockOut" name="prodStockOut" value="Y" <?=($prodRow[P_STOCK_OUT]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00041"] //품절?>
					<!--<input type="checkbox" id="prodReStock" name="prodReStock" value="Y" <?=($prodRow[P_RESTOCK]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00042"] //재입고상품?>-->

					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00003"] //재고 수량 관리를 하지 않는경우 <strong>무제한 상품</strong>을 체크해 주세요.?><br/>
						* <?=$LNG_TRANS_CHAR["PS00004"] //재고 관리를 하는경우 수량을 입력해 주시고 <strong>옵션별 재고 수량</strong> 관리 하셔야 합니다.?>
					</div>
				</td>
			</tr>
			<tr>
				<th>Other Names</span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:500px;font-weight:bold;" id="prodOtherNames" name="prodOtherNames" value="<?=$prodRow[P_OTHER_NAMES]?>"  maxlength = "140"  />
				</td>
			</tr>
			<?
			/************?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00025"] //브랜드?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodBrand" name="prodBrand" readonly value="<?=$prodRow[P_BRAND]?>"/>
					<!--input type="text" <?=$nBox?>  style="width:150px;" id="prodBrandName" name="prodBrandName" readonly value="<?=$prodRow[P_BRAND_NAME]?>"/-->
					<?=drawSelectBoxMoreQuery("selectProdBrand",$aryProdBrandList,$prodRow[P_BRAND],"","javascript:goSelectInputVal('Brand');","",$LNG_TRANS_CHAR["PW00025"],"N","PR_NO","PR_NAME")?>
				</td>
				<th><?=($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MODEL']: $LNG_TRANS_CHAR["PW00006"]; //모델명?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodModel" name="prodModel" value="<?=$prodRow[P_MODEL]?>"/>
					<?=drawSelectBoxMoreQuery("selectProdModel",$aryProductModel, $prodRow['P_BRAND'],"","javascript:goSelectInputVal('Model');","",($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MODEL']: $LNG_TRANS_CHAR["PW00006"],"N","COL","COL")?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodLaunchDt" name="prodLaunchDt" value="<?=$prodRow[P_LAUNCH_DT]?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
				<td>
				</td>
				<?if($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 입점몰 승인이 필요한 경우?>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
				<td><input type="hidden" id="" name="prodWebViewYN" value="<?=$prodRow['P_WEB_VIEW']?>" />
					<input type="hidden" id="" name="prodMobViewYN" value="<?=$prodRow['P_MOB_VIEW']?>" />
					<?	## 다국어출력사용여부
						if ($S_PROD_MANY_LANG_VIEW == "Y"){
							echo "승인완료";
						} else {
					?>
					<?if($prodRow['P_WEB_VIEW'] == "Y"):?>
						웹 페이지 승인 완료
					<?else:?>
						웹 페이지 미승인 상품입니다.
					<?endif;?><br>
					<?if($prodRow['P_MOB_VIEW'] == "Y"):?>
						모바일 페이지 승인 완료
					<?else:?>
						모바일 페이지 미승인 상품입니다.
					<?endif;?>
					<?	}?>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00051"] //웹페이지와 모바일 페이지에 해당 상품 노출 여부를 선택합니다.?>
					</div>
				</td>
				<?else:?>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
				<td>
					<?	## 다국어출력사용여부
						if ($S_PROD_MANY_LANG_VIEW == "Y"){
					?>
						<input type="radio" id="" name="prodWebViewYN" value="Y" <?=($prodRow['P_WEB_VIEW_'.$strStLng]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00119"] //WEB 보임?>
						<input type="radio" id="" name="prodWebViewYN" value="N" <?=($prodRow['P_WEB_VIEW_'.$strStLng]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00120"] //모바일 보임?>
					<?	}else{?>

					<input type="checkbox" id="" name="prodMobViewYN" value="Y" <?=($prodRow[P_WEB_VIEW]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00011"] //WEB 보임?>
					<input type="checkbox" id="" name="prodMobViewYN" value="Y" <?=($prodRow[P_MOB_VIEW]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00012"] //모바일 보임?>
					<?	}?>
						<div class="helpTxt">
							* <?=$LNG_TRANS_CHAR["PS00051"] //웹페이지와 모바일 페이지에 해당 상품 노출 여부를 선택합니다.?>
						</div>
				</td>
				<?endif;?>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00029"] //아이콘?></th>
				<td colspan="3">
					<input type="radio" name="prodListIconView" id="prodListIconView" value="1" <?=($prodRow[P_LIST_ICON_VIEW]=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00177"] //계속보여주기?>
					<input type="radio" name="prodListIconView" id="prodListIconView" value="2" <?=($prodRow[P_LIST_ICON_VIEW]=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00178"] //기간설정?><br><br>
					<div style="height:30px;<?=($prodRow[P_LIST_ICON_VIEW]=="1" || !$prodRow[P_LIST_ICON_VIEW])?"display:none":"";?>" id="divProdIconStartEndDate">
						<input type="text" <?=$nBox?>  style="width:80px;" id="prodListIconStartDt" name="prodListIconStartDt" value="<?=SUBSTR($prodRow[P_LIST_ICON_ST],0,10)?>"/>
						<?=drawSelectBoxDate("prodListIconStartHour",   0,   24,   1, SUBSTR($prodRow[P_LIST_ICON_ST],11,2), "","Hour","")?>
						<?=drawSelectBoxDate("prodListIconStartMin",   0,   60,   1, SUBSTR($prodRow[P_LIST_ICON_ST],14,2), "","Minute","")?>

						~
						<input type="text" <?=$nBox?>  style="width:80px;" id="prodListIconEndDt" name="prodListIconEndDt" value="<?=SUBSTR($prodRow[P_LIST_ICON_ET],0,10)?>"/>
						<?=drawSelectBoxDate("prodListIconEndHour",   0,   24,   1, SUBSTR($prodRow[P_LIST_ICON_ET],11,2), "","Hour","")?>
						<?=drawSelectBoxDate("prodListIconEndMin",   0,   60,   1, SUBSTR($prodRow[P_LIST_ICON_ET],14,2), "","Minute","")?>
					</div>
					<?
					if (is_array($aryProdIconDisplayList)){
					for($i=0;$i<sizeof($aryProdIconDisplayList);$i++){

						$strProdListIconChecked = $intKey = "";
						$strProdListIconNo   = $aryProdIconDisplayList[$i]['IC_CODE'];
						$strProdListIconName = "prodListIcon_".$aryProdIconDisplayList[$i]['IC_CODE'];

						if (in_array($strProdListIconNo, $aryProdListIconList)) {
							$strProdListIconChecked = "checked";
						}
						?>
						<input type="checkbox" id="<?=$strProdListIconName?>" name="<?=$strProdListIconName?>" value="Y" <?=$strProdListIconChecked?>>
						<img src="<?=$aryProdIconDisplayList[$i][IC_IMG]?>">
						<?
					}}
					?>
					<a href="./?menuType=product&mode=prodDisplay" class="btn_sml"><span><?=$LNG_TRANS_CHAR["PW00226"] //아이콘 추가?></span></a>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00054"] //체크된 아이콘은 상품 목록에 보여집니다.?><br>
						* <?=$LNG_TRANS_CHAR["PS00055"] //아이콘은 기간을 설정하시면 해당 기간만큼만 보여지며 계속 노출을 원하시는 경우 "계속보여주기"를 선택하세요.?><br>
						* <?=$LNG_TRANS_CHAR["PS00056"] //자신만의 아이콘으로 변경하길 원하시면 "아이콘 추가" 버튼을 클릭 "진열장 관리"페이지로 이동하여 등록 및 수정이 가능합니다.?>
					</div>
				</td>
			</tr>

			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00031"] //특이사항?></th>
				<td colspan="3">
					<textarea id="prodEtc" name="prodEtc" style="width:500px;height:50px"><?=$prodRow[P_ETC]?></textarea>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00001"] //상품리스트의 제목 아래에 노출 됩니다.?>
					</div>
				</td>
			</tr>
			<?if (is_array($S_ARY_PROD_COLOR)){?>
			<tr>
				<th>COLOR</th>
				<td colspan="3">
					<?
					$strProdColor = STR_REPLACE("|","",$prodRow[P_COLOR]);
					for($i=0;$i<sizeof($S_ARY_PROD_COLOR);$i++){
						if ($S_ARY_PROD_COLOR[$i]['USE'] == "Y"){
							$strProdColorChecked = "";
							if (SUBSTR($strProdColor,$i,1) == "Y") $strProdColorChecked = "checked";
							echo "<input type=\"checkbox\" name=\"prodColor_".$i."\" id=\"prodColor_".$i."\" value=\"Y\" ".$strProdColorChecked.">&nbsp;<img src=\"".$S_ARY_PROD_COLOR[$i]['IMG']."\">".$S_ARY_PROD_COLOR[$i]['NAME']."&nbsp;";
						}
					}
					?>
				</td>
			</tr>
			<?}?>
			<?if (is_array($S_ARY_PROD_SIZE)){?>
			<tr>
				<th>SIZE</th>
				<td colspan="3">
					<table class="tableForm">
					<?
					$strProdSize = STR_REPLACE("|","",$prodRow[P_SIZE]);
					for($i=0;$i<sizeof($S_ARY_PROD_SIZE);$i++){
						if ($S_ARY_PROD_SIZE[$i]['USE'] == "Y"){
							if ($i % 10 == 0) echo "<tr>";
							$strProdSizeChecked = "";
							if (SUBSTR($strProdSize,$i,1) == "Y") $strProdSizeChecked = "checked";
							echo "<td><input type=\"checkbox\" name=\"prodSize_".$i."\" id=\"prodSize_".$i."\" value=\"Y\" ".$strProdSizeChecked.">".$S_ARY_PROD_SIZE[$i]['NAME']."</td>";
							if ($i % 10 == 9) echo "</tr>";
						}
					}


					if ($i%10 != 0){
						for($j = $i%10;$j<10;$j++){
							if ($i % 10 == 0) echo "<tr>";
							echo "<td></td>";
							if ($i % 10 == 9) echo "</tr>";
						}
					}
					?>
					</table>
				</td>
			</tr>
			<?}?>
			<?
			**************/?>
		</table>



		<!--  ****************  -->
		<?php if($aryCommGrpList):?>
		<h3 class="mt10">상품찾기</h3>
		<table class="tableForm">
			<?php foreach($aryCommGrpList as $grpKey => $grpData):
				## 기본 설정
				$strGrpCode = $grpData['CG_CODE'];
				$strGrpName = $grpData['CG_NAME'];

				## 선택된 상품찾기 데이터
				$strProductSearch = $aryProductSearchRow["PS_{$strGrpCode}"];
				$aryProductSearch = explode(",", $strProductSearch);

				## 공통코드 불러오기
				$aryCommCode = getCommCodeList($strGrpCode);				?>
			<tr>
				<th><span class="mustItem"><?php echo $strGrpName;?></span></th>
				<td>
					<?php if($aryCommCode):?>
					<?php foreach($aryCommCode as $codeKey => $codeData):
						## 선택 데이터 설정
						$strChecked = "";
						if(in_array($codeKey, $aryProductSearch)) { $strChecked = " checked"; }		?>
					<input type="checkbox" name="productSearch[]" value="<?php echo $strGrpCode;?>@<?php echo $codeKey;?>"<?php echo $strChecked;?>> <?php echo $codeData;?>
					<?php endforeach;?>
					<?php endif;?>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<?php endif;?>

		<!-- 경매관리 -->
		<? include $strIncludePath.$aryIncludeFolder[$strMode]."/prodAuctionForm.inc.php";?>
		<!-- 경매관리 -->

		<!--  ****************  -->
		<?
			/************?>
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["PW00035"] //상품가격및수량관리?></h3>
		<table class="tableForm">
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00054"] //판매가?></span></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;color:#FF0000;" id="prodSalePrice" name="prodSalePrice" value="<?=$intSalePrice?>"/>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00040"] //수량?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodQty" name="prodQty" value="<?=$prodRow[P_QTY]?>" <?=($prodRow[P_QTY]==0)?"disabled":"";?>/>
					<input type="checkbox" id="prodStockLimit" name="prodStockLimit" value="Y" <?=($prodRow[P_STOCK_LIMIT]=="Y")?"checked":"";?> onclick="javascript:goStockLimit(this);"/> <?=$LNG_TRANS_CHAR["PW00043"] //무제한상품?>
					<input type="checkbox" id="prodStockOut" name="prodStockOut" value="Y" <?=($prodRow[P_STOCK_OUT]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00041"] //품절?>
					<input type="checkbox" id="prodReStock" name="prodReStock" value="Y" <?=($prodRow[P_RESTOCK]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00042"] //재입고상품?>

					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00003"] //재고 수량 관리를 하지 않는경우 <strong>무제한 상품</strong>을 체크해 주세요.?><br/>
						* <?=$LNG_TRANS_CHAR["PS00004"] //재고 관리를 하는경우 수량을 입력해 주시고 <strong>옵션별 재고 수량</strong> 관리 하셔야 합니다.?>
					</div>
				</td>
				<!--th><?=$LNG_TRANS_CHAR["PW00036"] //소비자가격?></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodConsumerPrice" name="prodConsumerPrice" value="<?=$intConsumerPrice?>"/>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
					(<?=$LNG_TRANS_CHAR["MW00031"]//할인율?>:<input type="text" <?=$nBox?>  style="width:40px;text-align:right;font-weight:bold;" id="prodDiscountRate" name="prodDiscountRate" maxlength="3" value="<?=$intProdDiscountRate?>"/>%)
					<span class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00059"] //소비자가를 등록하는경우 상품목록에 소비자가가 표시됩니다.?>
					</span>
				</td-->
			</tr>
			<!--tr>
				<th><?=$LNG_TRANS_CHAR["PW00037"] //입고가격?></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodStockPrice" name="prodStockPrice" value="<?=$intStockPrice?>"/>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
				</td>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //적립금?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodPoint" name="prodPoint" value="<?=$intPoint?>" />
					<select id="prodPointType" name="prodPointType">
						<option value="1" <?=($prodRow[P_POINT_TYPE]=="1")?"selected":"";?>>%</option>
						<option value="2" <?=($prodRow[P_POINT_TYPE]=="2")?"selected":"";?>><?=$S_ST_CUR?></option>
					</select>
					Point 적립하고, 소수점

					<input type="text" <?=$nBox?>  style="width:30px;text-align:right;font-weight:bold;" id="prodPointOff1" name="prodPointOff1" value="<?=$prodRow[P_POINT_OFF1]?>"/><?=$LNG_TRANS_CHAR["PW00044"] //자리?>
					<select id="prodPointOff2" name="prodPointOff2">
						<option value="1" <?=($prodRow[P_POINT_OFF2]=="2")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00038"] //절삭?></option>
						<option value="2" <?=($prodRow[P_POINT_OFF2]=="2")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00039"] //반올림?></option>
					</select>
					<input type="checkbox" name="prodPointNoUse" id="prodPointNoUse" value="Y" <?=($prodRow['P_POINT_NO_USE']=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["OW00158"] //주문시포인트사용금지상품?>
				</td>
			</tr-->
			<tr>
				<!--th><?=$LNG_TRANS_CHAR["OW00099"] //수수료?></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["L"]?>
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodAccPrice" name="prodAccPrice" readonly value="<?=$intProdAccPrice?>"/>
					<?=$S_ARY_MONEY_ICON[$S_ST_LNG]["R"]?>
					<input type="text" <?=$nBox?>  style="width:50px;" id="prodAccRate" name="prodAccRate" readonly  value="<?=$intProdAccRate?>"/>%
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00060"] //입고가와 판매가 대비 마진율을 자동 표시 합니다.?>
					</div>
				</td-->

			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00045"] //최소구매수량?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodSaleMinQty" name="prodSaleMinQty" value="<?=$prodRow[P_MIN_QTY]?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00046"] //최대구매수량?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodSaleMaxQty" name="prodSaleMaxQty" value="<?=$prodRow[P_MAX_QTY]?>"/>
				</td>
			</tr>

			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00047"] //과세?>/<?=$LNG_TRANS_CHAR["PW00048"] //비과세?></th>
				<td>
					<input type="radio" id="prodTax" name="prodTax" value="Y" <?=($prodRow[P_TAX]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00047"] //과세?>
					<input type="radio" id="prodTax" name="prodTax" value="N" <?=($prodRow[P_TAX]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00048"] //비과세?>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00049"] //가격대체문구?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodReplaceText" name="prodReplaceText" value="<?=$prodRow[P_PRICE_TEXT]?>"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00108"] //상품무게?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:50px;text-align:right;" id="prodWeight" name="prodWeight" value="<?=$prodRow[P_WEIGHT]?>"/> g
					<?=$LNG_TRANS_CHAR["PS00036"] //상품무게는 최소500g 단위로 입력하셔야 합니다.?>
				</td>
			</tr>
		</table>
		<?
			************/?>


		<!-- 상품옵션관리 -->
		<div class="areaDivWrap topBorder">
			<h3><?=$LNG_TRANS_CHAR["PW00050"] //상품옵션관리?></h3>
			<a href="javascript:goFormOpenEvent('prodOption')" id="prodOptionBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clr"></div>
		</div>
		<div id="prodOptionArea" style="display:">
				<div class="bBoxWrap">
						<!-- <input type="radio" id="prodOptType" name="prodOptType" value="1" <?=($prodRow[P_OPT]=="1")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00051"] //다중가격사용안함?> -->
						<!-- <input type="radio" id="prodOptType" name="prodOptType" value="2" <?=($prodRow[P_OPT]=="2")?"checked":"";?>/><?=$LNG_TRANS_CHAR["PW00052"] //다중가격일체형?> -->
						<input type="hidden" id="prodOptType" name="prodOptType" value="3" <?=($prodRow[P_OPT]=="3")?"checked":"";?>/><!-- <?=$LNG_TRANS_CHAR["PW00053"] //다중가격분리형?> -->
				</div>
			<br>
			<div class="tableInList">
				<table id="tabProdOpt" class="tableForm">
				<input type="hidden" id="prodOptNo[]" name="prodOptNo[]" value="<?=$aryProdOpt[0][PO_NO]?>">
					<colgroup>
						<col style="width:200px;"/>
						<col/>
						<col style="width:130px;"/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00054"] //옵션명?></th>
						<th><?=$LNG_TRANS_CHAR["PW00055"] //옵션속성?></th>
						<th><?=$LNG_TRANS_CHAR["PW00056"] //필수사항?></th>
					</tr>
					<?
					if (is_array($aryProdOpt[0])){
					for ($i=1;$i<=10;$i++){
						$strProdOptName		= $aryProdOpt[0]["PO_NAME".$i];
						$strProdOptNameVal	= $aryProdOpt[0]["PO_NAME_VAL".$i];
						if ($strProdOptName){
						?>
					<tr>
						<td><input type="text" <?=$nBox?>  style="width:120px;" id="prodOptName<?=$i?>" name="prodOptName<?=$i?>" value="<?=$strProdOptName?>" /></td>
						<td style="text-align:left;"><input type="text" <?=$nBox?>  style="width:500px;" id="prodOptVal<?=$i?>" name="prodOptVal<?=$i?>" value="<?=$strProdOptNameVal?>"/></td>
						<td>
							<?if ($i==1){?>
							<input type="checkbox" id="prodOptEss" name="prodOptEss" value="Y" <?=($aryProdOpt[0][PO_ESS]=="Y")?"checked":"";?>/>
							<?}?>
						</td>
					</tr>
						<?
						}
					}} else {
					?>
					<tr>
						<td><input type="text" <?=$nBox?>  style="width:120px;" id="prodOptName1" name="prodOptName1" value="packing" /></td>
						<td style="text-align:left;"><input type="text" <?=$nBox?>  style="width:99%;" id="prodOptVal1" name="prodOptVal1" value=""/></td>
						<td><input type="checkbox" id="prodOptEss" name="prodOptEss" value="Y"/></td>
					</tr>
					<?}?>
				</table>
				<div class="leftBtnWrap">
					<?
					/**/
					if ($S_ST_LNG == $strProdLng){?>
					<a class="btn_blue_sml" id="btnProdOptAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
					<a class="btn_sml" id="btnProdOptDel"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					<?}
					/**/
					?>
					<a class="btn_sml" id="btnProdOptAttr" href="javascript:goProdOptAttrAdd();"><strong><?=$LNG_TRANS_CHAR["PW00057"] //옵션속성만들기?></strong></a>
				</div>

				<br><br>
				<?if ($aryProdOpt[0][PO_NO] > 0){?>
				<?if ($S_ST_LNG == $strProdLng){?>
					<a class="btn_blue_sml" id="btnProdOptAttrAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
					<a class="btn_sml" id="btnProdOptAttrDel"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				<?}?>
				<table id="tabProdOptAttr">
					<tr>
						<?
						for ($i=1;$i<=10;$i++){
							$strProdOptName = $aryProdOpt[0]["PO_NAME".$i];
							if ($strProdOptName){
								echo "<th>".$strProdOptName."</th>";
							}
						}?>
						<th style="width:90px;"><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
						<th style="width:120px;"><?=$LNG_TRANS_CHAR["BW00054"] //판매가격?></th>
						<!--th style="width:120px;"><?=$LNG_TRANS_CHAR["PW00036"] //소비자가격?></th>
						<th style="width:120px;"><?=$LNG_TRANS_CHAR["PW00037"] //입고가격?></th>
						<th style="width:120px;"><?=$LNG_TRANS_CHAR["CW00034"] //적립금?></th-->
					</tr>
					<?
						$intProdOptAttrCnt = 0;
						for($i=0;$i<sizeof($aryProdOpt);$i++){
							$intProdOptNo = $i + 1;
							$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
							if (is_array($aryProdOpt[$i][OPT_ATTR])) {
								for($j=0;$j<sizeof($aryProdOpt[$i][OPT_ATTR]);$j++){
					?>
					<tr class="trProdOpt1">
						<input type="hidden" id="prodOptAttrNo<?=$intProdOptNo?>[]" name="prodOptAttrNo<?=$intProdOptNo?>[]" value="<?=$aryProdOpt[$i][OPT_ATTR][$j][POA_NO]?>">
						<?
						for ($kk=1;$kk<=10;$kk++){
							$strProdOptName = $aryProdOpt[0]["PO_NAME".$kk];
							if ($strProdOptName){
								?>
						<td>
							<input type="text" <?=$nBox?>  style="width:120px;" id="prodOptAttrVal1_<?=$kk?>[]" name="prodOptAttrVal1_<?=$kk?>[]" value="<?=$aryProdOpt[$i][OPT_ATTR][$j]["POA_ATTR".$kk]?>"/>
						</td>
								<?
							}
						}
						?>
						<td>
							<input type="text" <?=$nBox?>  style="width:90px;" id="prodOptAttrQty1[]" name="prodOptAttrQty1[]" value="<?=$aryProdOpt[$i][OPT_ATTR][$j][POA_STOCK_QTY]?>" />
						</td>
						<td>
							<input type="text" <?=$nBox?>  style="width:120px;" id="prodOptAttrSalePrice1[]" name="prodOptAttrSalePrice1[]" value="<?=STR_REPLACE(",","",getCurToPrice($aryProdOpt[$i][OPT_ATTR][$j][POA_SALE_PRICE],$S_ST_LNG))?>" disabled/>
						</td>
						<!--td>
							<input type="text" <?=$nBox?>  style="width:120px;" id="prodOptAttrConsumerPrice1[]" name="prodOptAttrConsumerPrice1[]" value="<?=STR_REPLACE(",","",getCurToPrice($aryProdOpt[$i][OPT_ATTR][$j][POA_CONSUMER_PRICE],$S_ST_LNG))?>" disabled/>
						</td>
						<td>
							<input type="text" <?=$nBox?>  style="width:120px;" id="prodOptAttrStockPrice1[]" name="prodOptAttrStockPrice1[]" value="<?=STR_REPLACE(",","",getCurToPrice($aryProdOpt[$i][OPT_ATTR][$j][POA_STOCK_PRICE],$S_ST_LNG))?>" disabled/>
						</td>
						<td>
							<input type="text" <?=$nBox?>  style="width:120px;" id="prodOptAttrPoint1[]" name="prodOptAttrPoint1[]" value="<?=$aryProdOpt[$i][OPT_ATTR][$j][POA_POINT]?>" disabled/>
						</td-->
					</tr>
					<?
								}
							}
						}
					?>
				</table>
				<?}else{?>

				<table id="tabProdOptAttr">
				</table>
				<?}?>
				<div class="bBoxWrap">
					<div class="helpTxt">
						<!--
						* <?=$LNG_TRANS_CHAR["PS00005"] //해당 상품의 특성상 옵션별 재고나 금액이 다른경우 사용합니다.?><br/>
						* <?=$LNG_TRANS_CHAR["PS00006"] //해당 상품의 옵션에 따라 가격이나 재고가 변동이 없는경우 <strong>"다중가격사용안함"</strong>을 선택하세요.?><br/>
						* <?=$LNG_TRANS_CHAR["PS00007"] //옵션별 재고와 가격이 다른경우 <strong>"다중가격분리형"</strong>을 선택하세요.?><br/>
						* <?=$LNG_TRANS_CHAR["PS00008"] //옵션별 속성 구분값은 세미콜론<strong>";"</strong>을 입력하세요.?>
						-->
					</div>
					<div class="hefpTxtBox">
						<!--
						<strong>옵션속성 만들기 방법</strong><br/>
						① 옵션명과 옵션항목을 입력합니다. 옵션항목은 세미콜론(;)으로 구분합니다. 예) Black;Red;Yellow<br/>
						② 선택할 옵션값이 더 있다면 추가 버튼을 클릭하여 한줄을 더 생성합니다. 예) Size: XL;L;S<br/>
						③ 생성할 옵션항목이 입력되었다면 "옵션속성만들기" 버튼을 클릭하세요.  하단에 각 항목이 분리되어 정렬됩니다.<br/>
						④ 생성된 옵션항목의 입력값(재고/판매가 등)을 넣어 주세요.
						-->

						<?= $LNG_TRANS_CHAR["PS00079"]; //?>
						<!--
						<strong>상품옵션관리 등록 예시</strong><br/>
				    - 다중가격 사용안함<br/>
				      상품의 옵션에 따라 재고량이 다르지만, 가격은 동일한 경우 선택 합니다. <br/>
				      제품 상세 페이지에서, 추가한 옵션의 개수만큼 선택항목을 만들어 사용자에게 보여줍니다.<br/>
						<br/>
				    - 다중가격 분리형<br/>
				      상품의 옵션에 따라 재고량이 다르고 가격이 다른 경우 선택 합니다. <br/>
				      제품 상세 페이지에서, 추가한 옵션의 개수만큼 선택항목을 만들어 사용자에게 보여줍니다.<br/>
						<br/>
						- Packing 및 옵션 등록 예시<br/>
							① Packing 단위가 10kg, 20kg 일 경우, 옵션속성에 '10kg;20kg' 으로 등록하시면 됩니다.<br/>
							옵션별 속성 구분은  세미클론 ';'을 필수로 입력해야 합니다.<br/>
							<br/>
							② 선택할 옵션값이 있다면, '추가' 버튼을 클릭하면 한줄이 추가됩니다.<br/>
							Packing과 같은 방법으로 등록하면 됩니다.<br/>
							<br/>
							③ 생성할 옵션을 입력되었다면 '옵션속성만들기' 버튼을 클릭하세요.<br/>
							하단에 각 항목별로 분리되어 정렬됩니다.<br/>
							<br/>
							④ 생성된 옵션항목에 재고 및 판매가를 입력해 주세요.
						-->
					</div>
				</div>
			</div>
		</div><br>
	<!-- 상품옵션관리 -->

	<!-- 추가옵션관리 -->
	<?if (($S_MALL_TYPE == "R") || ($S_MALL_TYPE == "M" && $S_PRODUCT_ADD_OPT_USE == "Y")){?>
		<div id="tableFormWrap">

		<!--  ****************  -->
		<div class="areaDivWrap">
		<h3><?=$LNG_TRANS_CHAR["PW00058"] //추가옵션관리?></h3>
			<a href="javascript:goFormOpenEvent('addOption')" id="addOptionBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clr"></div>
		</div>
		<div id="addOptionArea" style="display:none">
			<table class="tableForm" class="tableForm">
				<tr>
					<td>
						<input type="radio" id="prodAddOpt" name="prodAddOpt" value="Y" <?=($prodRow[P_ADD_OPT]=="Y")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
						<input type="radio" id="prodAddOpt" name="prodAddOpt" value="N" <?=($prodRow[P_ADD_OPT]=="N")?"checked":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					</td>
				</tr>
			</table>
		<br>

		<div class="tableInList">
			<table id="tabProdAddOpt" class="tableForm">
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00059"] //추가옵션명?>/<?=$LNG_TRANS_CHAR["PW00060"] //구매시필수?></th>
					<th><?=$LNG_TRANS_CHAR["PW00062"] //항목명?></th>
					<th><?=$LNG_TRANS_CHAR["PW00061"] //추가금액?></th>
				</tr>
				<?
				if (is_array($aryProdAddOpt)){

					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						$intProdAddOptNo = $i + 1;
						$intProdAddOptAttrCnt = sizeof($aryProdAddOpt[$i][OPT_ATTR]);
						if (is_array($aryProdAddOpt[$i][OPT_ATTR])) {
							?>
				<tr class="trProdAddOpt<?=$intProdAddOptNo?>">
					<input type="hidden" id="prodAddOptNo[]" name="prodAddOptNo[]" value="<?=$aryProdAddOpt[$i][PO_NO]?>">
					<input type="hidden" id="prodAddOptAttrNo<?=$intProdAddOptNo?>[]" name="prodAddOptAttrNo<?=$intProdAddOptNo?>[]" value="<?=$aryProdAddOpt[$i][OPT_ATTR][0][PAO_NO]?>">
					<td <?=($intProdAddOptAttrCnt > 0)?"rowspan=\"$intProdAddOptAttrCnt\"":"";?>>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptName[]" name="prodAddOptName[]" value="<?=$aryProdAddOpt[$i][PO_NAME1]?>"/>
						<input type="checkbox" id="prodAddOptChk[]" name="prodAddOptChk[]" value="Y" <?=($aryProdAddOpt[$i][PO_ESS]=="Y")?"checked":"";?>/>
						<?if ($S_ST_LNG == $strProdLng){?>
						<?if ($intProdAddOptNo == 1){?>
						<a class="btn_blue_sml" href="javascript:goProdAddOptAdd();" id="btnProdAddOptAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<a class="btn_sml" href="javascript:goProdAddOptDel();" id="btnProdAddOptDel"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a><?}?><?}?>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptVal<?=$intProdAddOptNo?>[]" name="prodAddOptVal<?=$intProdAddOptNo?>[]" value="<?=$aryProdAddOpt[$i][OPT_ATTR][0][PAO_NAME]?>"/>
						<?if ($S_ST_LNG == $strProdLng){?><a class="btn_blue_sml" id="btnProdAddOptValAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a><?}?>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptPrice<?=$intProdAddOptNo?>[]" name="prodAddOptPrice<?=$intProdAddOptNo?>[]" value="<?=STR_REPLACE(",","",getCurToPrice($aryProdAddOpt[$i][OPT_ATTR][0][PAO_PRICE],$S_ST_LNG))?>"/>
					</td>
				</tr>
				<?
							for($j=1;$j<sizeof($aryProdAddOpt[$i][OPT_ATTR]);$j++){
								?>
				<tr class="trProdAddOpt<?=$intProdAddOptNo?>">
					<input type="hidden" id="prodAddOptAttrNo<?=$intProdAddOptNo?>[]" name="prodAddOptAttrNo<?=$intProdAddOptNo?>[]" value="<?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NO]?>">
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptVal<?=$intProdAddOptNo?>[]" name="prodAddOptVal<?=$intProdAddOptNo?>[]" value="<?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NAME]?>"/>
						<?if ($S_ST_LNG == $strProdLng){?>
						<?if ($j > 0){?>
						<a class="btn_sml" id="btnProdAddOptValDel"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
						<?}else{?>
						<a class="btn_blue_sml" id="btnProdAddOptValAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<?}?>
						<?}?>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptPrice<?=$intProdAddOptNo?>[]" name="prodAddOptPrice<?=$intProdAddOptNo?>[]" value="<?=STR_REPLACE(",","",getCurToPrice($aryProdAddOpt[$i][OPT_ATTR][$j][PAO_PRICE],$S_ST_LNG))?>"/>
					</td>
				</tr>
								<?
							}
						} else {
				?>
				<tr class="trProdAddOpt<?=$intProdAddOptNo?>">
				<input type="hidden" id="prodAddOptNo[]" name="prodAddOptNo[]" value="<?=$aryProdAddOpt[$i][PO_NO]?>">
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptName[]" name="prodAddOptName[]" value="<?=$aryProdAddOpt[$i][PO_NAME1]?>"/>
						<input type="checkbox" id="prodAddOptChk[]" name="prodAddOptChk[]" value="Y"/>
						<?if ($S_ST_LNG == $strProdLng){?>
						<?if ($intProdAddOptNo == 1){?><a class="btn_blue_sml" href="javascript:goProdAddOptAdd();" id="btnProdAddOptAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<a class="btn_sml" href="javascript:goProdAddOptDel();" id="btnProdAddOptDel"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a><?}?><?}?>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptVal<?=$intProdAddOptNo?>[]" name="prodAddOptVal<?=$intProdAddOptNo?>[]" value=""/>
						<?if ($S_ST_LNG == $strProdLng){?><a class="btn_blue_sml" id="btnProdAddOptValAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a><?}?>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptPrice<?=$intProdAddOptNo?>[]" name="prodAddOptPrice<?=$intProdAddOptNo?>[]" value=""/>
					</td>
				</tr>

				<?
						}
					}
				} else {
				?>
				<tr class="trProdAddOpt1">
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptName[]" name="prodAddOptName[]" value=""/>
						<input type="checkbox" id="prodAddOptChk[]" name="prodAddOptChk[]" value="Y"/>
						<?if ($S_ST_LNG == $strProdLng){?><a class="btn_blue_sml" href="javascript:goProdAddOptAdd();" id="btnProdAddOptAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<a class="btn_sml" href="javascript:goProdAddOptDel();" id="btnProdAddOptDel"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a><?}?>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptVal1[]" name="prodAddOptVal1[]" value=""/>
						<?if ($S_ST_LNG == $strProdLng){?><a class="btn_blue_sml" id="btnProdAddOptValAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a><?}?>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptPrice1[]" name="prodAddOptPrice1[]" value=""/>
					</td>
				</tr>
				<?}?>
			</table>
			<div class="helpTxt">
				* <?=$LNG_TRANS_CHAR["PS00009"] //상품 구매 시 별도 추가되는 옵션이 있는경우 사용합니다.?><br/>
				* <?=$LNG_TRANS_CHAR["PS00010"] //상품 가격에 추가되는 금액입니다.?>
			</div>
		</div>
	</div><br>
	<?}?>
	<!-- 추가옵션관리 -->
	<!-- 상품추가정보 -->
	<div class="tableFormWrap">

		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00032"] //상품추가정보?></h3>
			<a href="javascript:goFormOpenEvent('prodAdd')" id="prodAddBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clr"></div>
		</div>
		<div id="prodAddArea" style="display:none">
			<?if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){?>
			<table id="trProdItemList" class="tableForm">
				<colgroup>
					<col width="100"/>
					<col width="100"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00062"] //항목명?></th>
					<th><?=$LNG_TRANS_CHAR["PW00188"] //항목타입?></th>
					<th><?=$LNG_TRANS_CHAR["PW00116"] //항목설명?></th>
				</tr>
				<?
				if (is_array($aryProdItem)){

					for($i=0;$i<sizeof($aryProdItem);$i++){
						$intProdItemNo = $i + 1;
					?>
				<tr class="prodItem<?=$intProdItemNo?>">
					<input type="hidden" id="prodItemNo[]" name="prodItemNo[]" value="<?=$aryProdItem[$i][PI_NO]?>">
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodItem[]" name="prodItem[]" value="<?=$aryProdItem[$i][PI_NAME]?>"/>
						<?if ($S_ST_LNG == $strProdLng){?>
						<?if ($i > 0){?>
						<a class="btn_sml" href="javascript:goProdItemDel(<?=$intProdItemNo?>);" id="btnItemAdd"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
						<?}else{?>
						<a class="btn_blue_sml" href="javascript:goProdItemAddVer2();" id="btnItemAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<?}?>
						<?}?>
					</td>
					<td>
						<select name="prodItemType[]" id="prodItemType[]" onchange="javascript:goProdItemTypeSelect(this);">
							<option value="B" <?=($aryProdItem[$i][PI_TYPE]=="B")?"selected":"";?>>설명</option>
							<!-- 설명만 사용하도록 주석처리. 남덕희
							<option value="U" <?=($aryProdItem[$i][PI_TYPE]!="B")?"selected":"";?>>사용자입력</option>
							-->
						</select>
						<div id="divProdItemUserType" <?=($aryProdItem[$i][PI_TYPE]=="B")?"style=\"display:none\"":"";?>">
							<select name="prodItemUserType[]" id="prodItemUserType[]">
								<option value="C" <?=($aryProdItem[$i][PI_TYPE]=="C")?"selected":"";?>>check</option>
								<option value="R" <?=($aryProdItem[$i][PI_TYPE]=="R")?"selected":"";?>>radio</option>
								<option value="S" <?=($aryProdItem[$i][PI_TYPE]=="S")?"selected":"";?>>select</option>
								<option value="T" <?=($aryProdItem[$i][PI_TYPE]=="T")?"selected":"";?>>input</option>
								<option value="D" <?=($aryProdItem[$i][PI_TYPE]=="D")?"selected":"";?>>input date</option>
							</select>
						</div>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="prodItemText[]" name="prodItemText[]" value="<?=$aryProdItem[$i][PI_TEXT]?>"/>
					</td>
				</tr>
				<?
					}
				} else {
				?>
				<tr class="prodItem1">
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodItem[]" name="prodItem[]"/>
						<?if ($S_ST_LNG == $strProdLng){?>
						<a class="btn_blue_sml" href="javascript:goProdItemAdd();" id="btnItemAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<?}?>
					</td>
					<td>
						<select name="prodItemType[]" id="prodItemType[]" onchange="javascript:goProdItemTypeSelect(this);">
							<option value="B">설명</option>
							<!-- 설명만 사용하도록 주석처리. 남덕희
							<option value="U">사용자입력</option>
							-->
						</select>
						<div id="divProdItemUserType" style="display:none">
							<select name="prodItemUserType[]" id="prodItemUserType[]">
								<option value="C">check</option>
								<option value="R">radio</option>
								<option value="S">select</option>
								<option value="T">input</option>
								<option value="D">input date</option>
							</select>
						</div>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="prodItemText[]" name="prodItemText[]"/>
					</td>
				</tr>
				<?}?>
			</table>
			<?}else{?>
			<table id="trProdItemList" class="tableForm">
				<?
				if (is_array($aryProdItem)){

					for($i=0;$i<sizeof($aryProdItem);$i++){
						$intProdItemNo = $i + 1;
					?>
				<tr class="prodItem<?=$intProdItemNo?>">
					<input type="hidden" id="prodItemNo[]" name="prodItemNo[]" value="<?=$aryProdItem[$i][PI_NO]?>">
					<th><?=$LNG_TRANS_CHAR["PW00062"] //항목명?><?=$intProdItemNo?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodItem[]" name="prodItem[]" value="<?=$aryProdItem[$i][PI_NAME]?>"/>
						<?if ($S_ST_LNG == $strProdLng){?>
						<?if ($i > 0){?>
						<a class="btn_sml" href="javascript:goProdItemDel(<?=$intProdItemNo?>);" id="btnItemAdd"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
						<?}else{?>
						<a class="btn_blue_sml" href="javascript:goProdItemAdd();" id="btnItemAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<?}?>
						<?}?>
					</td>
					<th><?=$LNG_TRANS_CHAR["PW00116"] //항목설명?><?=$intProdItemNo?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="prodItemText[]" name="prodItemText[]" value="<?=$aryProdItem[$i][PI_TEXT]?>"/>
					</td>
				</tr>
				<?
					}
				} else {
				?>
				<tr class="prodItem1">
					<th><?=$LNG_TRANS_CHAR["PW00033"] //항목명1?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodItem[]" name="prodItem[]"/>
						<?if ($S_ST_LNG == $strProdLng){?>
						<a class="btn_blue_sml" href="javascript:goProdItemAdd();" id="btnItemAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<?}?>
					</td>
					<th><?=$LNG_TRANS_CHAR["PW00034"] //항목설명1?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="prodItemText[]" name="prodItemText[]"/>
					</td>
				</tr>
				<?}?>
			</table>
			<?}?>
		</div>
	</div><br>
	<!-- 상품추가정보 -->
	<? 	include $strIncludePath.$aryIncludeFolder[$strMode]."/prodNotify.info.inc.php";?>

	<div class="tableFormWrap">
		<!-- 상품배송비관리 -->
		<!--  ****************  -->
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["PW00063"] //상품배송비관리?></h3>
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00064"] //배송비?></th>
				<td>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="1" <?=($prodRow[P_BAESONG_TYPE]=="1")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00065"] //기본배송비정책?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="2" <?=($prodRow[P_BAESONG_TYPE]=="2")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00066"] //무료배송?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="3" <?=($prodRow[P_BAESONG_TYPE]=="3")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00067"] //배송비고정?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="4" <?=($prodRow[P_BAESONG_TYPE]=="4")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00068"] //수량별배송?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="5" <?=($prodRow[P_BAESONG_TYPE]=="5")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PW00069"] //착불배송비?>
					<div id="divBaesongPrice"<?if(in_array($prodRow['P_BAESONG_TYPE'], array("1","2"))){echo " style='display:none'";}?>>
						<br><?=$LNG_TRANS_CHAR["PW00064"] //배송비?> : <input type="text" name="prodDeliveryPrice" id="prodDeliveryPrice" value="<?=$prodRow['P_BAESONG_PRICE']?>" style="width:80px;">
					</div>
				</td>
			</tr>
		</table>
		<!-- 상품배송비관리 -->

		<!-- 상품이미지 -->
		<!--  ****************  -->
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["PW00070"] //상품이미지?></h3>
		<table id="tabProdImg2" <?=($intProdUrlImgCnt>0)?"style=\"display:none\"":"";?> class="tableForm">
			<? ## 2014.04.05 상세이미지 다중이미지로 변경 ?>
			<? ## 2014.04.11 한장의 이미지로 사용하기 - 추가 ?>
			<tr id="prodImgTrId_4" >
				<th><?=$LNG_TRANS_CHAR["PW00074"] //확대이미지?></th>
				<td colspan="3">
					<input type="file" id="prodImg4" name="prodImg4" value="" <?=$nBox?> style="height:20px;"/>
					<?if(is_array($aryProdImg[4])): // 확대이미지가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[4][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[4][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<input type="hidden" id="prodImgCopy" name="prodImgCopy" value="Y" />
					<!-- <input type="checkbox" id="prodImgCopy" name="prodImgCopy" value="Y"  <?=$nBox?>  style="height:20px;" /> <?=$LNG_TRANS_CHAR["PS00049"] //한장의 이미지로 사용하기?> -->
					<!-- <input type="checkbox" id="prodImgUrlYN" name="prodImgUrlYN" value="Y"  <?=$nBox?>  style="height:20px;" <?=($intProdUrlImgCnt>0)?"checked":"";?>/> <?=$LNG_TRANS_CHAR["PS00050"] //이미지 URL 사용하기?> -->

					<div class="helpTxt">
					* <!-- <?=$LNG_TRANS_CHAR["PS00037"] //확대보기 이미지 입니다.?>, -->  <!--<?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px-->
					<?= $LNG_TRANS_CHAR["PS00085"];  ?>
					<br/>
					* <?= $LNG_TRANS_CHAR["PS00081"]; // ?>
					</div>
				</td>
			</tr>
			<!--
			<tr id="prodImgTrId_3">
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?></span></th>
				<td colspan="3">
					<input type="file" id="prodImg3" name="prodImg3" value="" <?=$nBox?> style="height:20px;"/>
					<?if(is_array($aryProdImg[3])): // 상세이미지가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[3][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[3][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxt">
					* <?=$LNG_TRANS_CHAR["PS00038"] //상세 보기 이미지 ?>, <?=$LNG_TRANS_CHAR["PW00113"]//이미지 가로사이즈?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr id="prodImgTrId_2">
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00072"] //리스트이미지?></span></th>
				<td colspan="3">
					<input type="file" id="prodImg2" name="prodImg2" value="" <?=$nBox?> style="height:20px;"/>
					<?if(is_array($aryProdImg[2])): // 리스트이미지가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[2][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[2][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00012"]?>, <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODLIST_IMG_SIZE_W?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODLIST_IMG_SIZE_H?></strong>px<br/>
						* <?=$LNG_TRANS_CHAR["PS00013"]?> <a href="./?menuType=layout&mode=skinSave" class="btn_sml"><span>이미지 사이즈 변경</span></a>
					</div>
				</td>
			</tr>

			<?if($S_PRODLIST_TURN_USE=="Y"):?>
			<tr id="prodImgTrId_1">
				<th><?=$LNG_TRANS_CHAR["PW00071"] //리스트이미지2?></th>
				<td colspan="3">
					<input type="file" id="prodImg1" name="prodImg1" value="" <?=$nBox?> style="height:20px;"/>
					<?if(is_array($aryProdImg[1])): // 리스트이미지2가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[1][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[1][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxtGray">
						* <?=$LNG_TRANS_CHAR["PS00011"]?><br>
						* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODLIST_IMG_SIZE_W?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODLIST_IMG_SIZE_H?></strong>px<br/>
					</div>
				</td>
			</tr>
			<?endif;?>
			-->
			<tr id="productDetailImage_1">
				<th><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?>
				<a class="btn_blue_sml" id="btnProdImgAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a></th>
				<td colspan="3">
					<!-- <?=$LNG_TRANS_CHAR["PW00224"] //기본?> :  -->
					<span><input type="file" id="prodImgBasic" name="prodImg7" value="" <?=$nBox?> style="height:20px;"/></span>
					<?if(is_array($aryProdImg[7])): // 기본이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[7][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[7][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<!--
					<?=$LNG_TRANS_CHAR["PW00225"] //확대?> : <span><input type="file" id="prodImgExpend" name="prodImg18" value="" <?=$nBox?> style="height:20px;"/></span>
					<?if(is_array($aryProdImg[18])): // 확대이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[18][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[18][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					-->
				</td>
			</tr>
			<?for($i=8,$j=19;$i<=17;$i++,$j++):?>
			<?if(!is_array($aryProdImg[$i]) && !is_array($aryProdImg[$j])) { continue; } ?>
			<tr id="productDetailImage_<?=$i-5?>">
				<th><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?>
				<td colspan="3">
					<!-- <?=$LNG_TRANS_CHAR["PW00224"] //기본?> : -->
					<span><input type="file" id="prodImgBasic" name="prodImg<?=$i?>" value="" <?=$nBox?> style="height:20px;"/></span>
					<?if(is_array($aryProdImg[$i])): // 기본이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[$i][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[$i][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<!--
					<?=$LNG_TRANS_CHAR["PW00225"] //확대?> : <span><input type="file" id="prodImgExpend" name="prodImg<?=$j?>" value="" <?=$nBox?> style="height:20px;"/></span>
					<?if(is_array($aryProdImg[$j])): // 확대이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[$j][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[$j][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					-->
				</td>
			</tr>
			<?endfor?>
		</table>
		<table id="tabProdImg3"  <?=($intProdUrlImgCnt==0)?"style=\"display:none\"":"";?> class="tableForm">
			<? ## 2013.08.09 URL 사용하기 - 추가 ?>
			<tr id="prodImgTrId_4">
				<th><?=$LNG_TRANS_CHAR["PW00074"] //확대이미지?></th>
				<td colspan="3">
					<input type="text" id="prodUrlImg4" name="prodUrlImg4" value="<?=(is_array($aryProdImg[4]))?$aryProdImg[4][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="width:500px;"/>
					<input type="checkbox" id="prodImgFileYN" name="prodImgFileYN" value="Y"  <?=$nBox?>  /> 이미지 파일로 사용하기

					<?if(is_array($aryProdImg[4])): // 확대이미지가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[4][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[4][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxtGray">
					* <?=$LNG_TRANS_CHAR["PS00038"] //상세 보기 이미지 입니다.?><br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_PISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_PISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?></span></th>
				<td colspan="3">
					<input type="text" id="prodUrlImg3" name="prodUrlImg3" value="<?=(is_array($aryProdImg[3]))?$aryProdImg[3][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="width:500px;"/>
					<?if(is_array($aryProdImg[3])): // 상세이미지가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[3][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[3][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxtGray">
					* <?=$LNG_TRANS_CHAR["PS00038"] //상세 보기 이미지 입니다.?><br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00072"] //리스트이미지?></span></th>
				<td colspan="3">
					<input type="text" id="prodUrlImg2" name="prodUrlImg2" value="<?=(is_array($aryProdImg[2]))?$aryProdImg[2][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="width:500px;"/>
					<?if(is_array($aryProdImg[2])): // 리스트이미지가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[2][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[2][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxtGray">
						* <?=$LNG_TRANS_CHAR["PS00012"]?><br/>
						* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODLIST_IMG_SIZE_W?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODLIST_IMG_SIZE_H?></strong>px<br/>
						* <?=$LNG_TRANS_CHAR["PS00013"]?>
					</div>
				</td>
			</tr>
			<?if($S_PRODLIST_TURN_USE=="Y"):?>
			<tr id="prodImgTrId_1">
				<th><?=$LNG_TRANS_CHAR["PW00071"] //리스트이미지2?></th>
				<td colspan="3">
					<input type="file" id="prodUrlImg1" name="prodUrlImg1" value="<?=(is_array($aryProdImg[1]))?$aryProdImg[1][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="width:500px;"/>
					<?if(is_array($aryProdImg[1])): // 리스트이미지2가 있을때 ?>
					<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[1][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[1][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxtGray">
						* <?=$LNG_TRANS_CHAR["PS00011"]?><br>
						* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODLIST_IMG_SIZE_W?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODLIST_IMG_SIZE_H?></strong>px<br/>
					</div>
				</td>
			</tr>
			<?endif;?>
			<tr id="productDetailUrlImage_1">
				<th><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?>
				<a class="btn_blue_sml" id="btnProdUrlImgAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a></th>
				<td colspan="3">
					<?=$LNG_TRANS_CHAR["PW00224"] //기본?> : <span><input type="file" id="prodImgBasic" name="prodUrlImg7" value="<?=(is_array($aryProdImg[7]))?$aryProdImg[7][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="width:350px;"/></span>
					<?if(is_array($aryProdImg[7])): // 기본이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[7][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[7][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<?=$LNG_TRANS_CHAR["PW00225"] //확대?> : <span><input type="file" id="prodImgExpend" name="prodUrlImg18" value="<?=(is_array($aryProdImg[18]))?$aryProdImg[18][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="width:350px;"/></span>
					<?if(is_array($aryProdImg[18])): // 확대이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[18][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[18][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
				</td>
			</tr>
			<?for($i=8,$j=19;$i<=17;$i++,$j++):?>
			<?if(!is_array($aryProdImg[$i]) && !is_array($aryProdImg[$j])) { continue; } ?>
			<tr id="productDetailImage_<?=$i-5?>">
				<th><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?>
				<td colspan="3">
					<?=$LNG_TRANS_CHAR["PW00224"] //기본?> : <span><input type="file" id="prodImgBasic" name="prodUrlImg<?=$i?>" value="<?=(is_array($aryProdImg[$i]))?$aryProdImg[$i][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="height:20px;"/></span>
					<?if(is_array($aryProdImg[$i])): // 기본이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[$i][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[$i][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<?=$LNG_TRANS_CHAR["PW00225"] //확대?> : <span><input type="file" id="prodImgExpend" name="prodUrlImg<?=$j?>" value="<?=(is_array($aryProdImg[$j]))?$aryProdImg[$j][0]['PM_REAL_NAME']:"";?>" <?=$nBox?> style="height:20px;"/></span>
					<?if(is_array($aryProdImg[$j])): // 확대이미지가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[$j][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[$j][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
				</td>
			</tr>
			<?endfor?>
		</table>

		<? ## 2014.04.05 추가이미지 확대이미지로 변경 ?>
		<!--h3 class="mt30">추가이미지</h3>
		<table id="tabProdImg">
			<tr id="prodImgTrId_2">
				<th>추가이미지 1</th>
				<td>
					<input type="file" id="prodImg18" name="prodImg18" value="" <?=$nBox?> style="height:20px;"/>
					<?if(is_array($aryProdImg[18])): // 리스트이미지2가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[18][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[18][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<a class="btn_blue_sml" id="btnProdImgAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
					<div class="helpTxtGray">
					* 상세 보기 이미지 입니다.<br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<?for($i=19;$i<=28;$i++):?>
			<?if(!is_array($aryProdImg[$i])) { continue; } ?>
			<tr id="prodImgTrId_2">
				<th>추가이미지 <?=$i-17;?></th>
				<td>
					<input type="file" id="prodImg<?=$i?>" name="prodImg<?=$i?>" value="" <?=$nBox?> style="height:20px;"/>
					<?if(is_array($aryProdImg[$i])): // 리스트이미지2가 있을때 ?>
					<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[$i][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
					<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[$i][0]['PM_NO']?>);"><strong>X</strong></a>
					<?endif;?>
					<div class="helpTxtGray">
					* 상세 보기 이미지 입니다.<br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<?endfor;?>
		</table-->
<? /** 2013.03.13 레이아웃 변경
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["PW00070"] //상품이미지?></h3>
		<table id="tabProdImg">

			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00072"] //리스트이미지?></span></th>
				<td colspan="3">
					<input type="file" id="prodImg2" name="prodImg2" value="" <?=$nBox?> style="height:20px;"/>
					<?
						if (  $strMode != "scrapingModify" ) {
						if (is_array($aryProdImg[2]) && $aryProdImg[2][0][PM_NO] > 0){
							?>
							<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[2][0][PM_NO]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[2][0][PM_NO]?>);"><strong>X</strong></a>
							<?		} } else {			?>
							<a class="btn_sml" href="javascript:C_openWindow('<?=$aryProdImg[2][0][PM_REAL_NAME]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgTempDel('<?=$aryProdImg[2][0][PM_NO]?>');"><strong>X</strong></a>
							<input type="hidden" name="listImg" id="listImg" value="<?=$aryProdImg[2][0][PM_REAL_NAME]?>"  />
							<?
						}
					?>
					<input type="checkbox" id="prodImgCopy" name="prodImgCopy" value="Y"  <?=$nBox?>  style="height:20px;" /> 이미지 복사
					<div class="helpTxtGray">
						* <?=$LNG_TRANS_CHAR["PS00012"]?><br/>
						* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODLIST_IMG_SIZE_W?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODLIST_IMG_SIZE_H?></strong>px<br/>
						* <?=$LNG_TRANS_CHAR["PS00013"]?>
					</div>
				</td>
			</tr>
			<tr id="prodImgTrId_1">
				<th><?=$LNG_TRANS_CHAR["PW00071"] //리스트이미지2?></th>
				<td colspan="3">
					<input type="file" id="prodImg1" name="prodImg1" value="" <?=$nBox?> style="height:20px;"/>
					<?
						if (is_array($aryProdImg[1]) && $aryProdImg[1][0][PM_NO] > 0){
							?>
							<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[1][0][PM_NO]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[1][0][PM_NO]?>);"><strong>X</strong></a>
							<?
						}
					?>
					<div class="helpTxtGray">
						* <?=$LNG_TRANS_CHAR["PS00011"]?><br>
						* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODLIST_IMG_SIZE_W?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODLIST_IMG_SIZE_H?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr id="prodImgTrId_2">
				<th><?=$LNG_TRANS_CHAR["PW00072"] //목록 이미지?>(Mobile)</th>
				<td>
					<input type="file" id="prodImg5" name="prodImg5" value="" <?=$nBox?> style="height:20px;"/>
					<?
						if (is_array($aryProdImg[5]) && $aryProdImg[5][0][PM_NO] > 0){
							?>
							<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[5][0][PM_NO]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[5][0][PM_NO]?>);"><strong>X</strong></a>
							<?
						}
					?>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00073"] //상세 이미지?>(Mobile)</th>
				<td>
					<input type="file" id="prodImg6" name="prodImg6" value="" <?=$nBox?> style="height:20px;"/>
					<?
						if (is_array($aryProdImg[6]) && $aryProdImg[6][0][PM_NO] > 0){
							?>
							<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[6][0][PM_NO]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[6][0][PM_NO]?>);"><strong>X</strong></a>
							<?
						}
					?>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?>1</span></th>
				<td style="width:350px;">
					<input type="file" id="prodImg3" name="prodImg3" value="" <?=$nBox?> style="height:20px;"/>
					<?
						if (  $strMode != "scrapingModify" ) {
						if (is_array($aryProdImg[3]) && $aryProdImg[3][0][PM_NO] > 0){
							?>
							<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[3][0][PM_NO]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[3][0][PM_NO]?>);"><strong>X</strong></a>
							<?	 } } else {	 ?>
							<a class="btn_sml" href="javascript:C_openWindow('<?=$aryProdImg[3][0][PM_REAL_NAME]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgTempDel(<?=$aryProdImg[3][0][PM_NO]?>);"><strong>X</strong></a>
							<input type="hidden" name="viewImg[]" id="viewImg[]" value="<?=$aryProdImg[3][0][PM_REAL_NAME]?>"  />
					<? } ?>
					<a class="btn_blue_sml" id="btnProdImgAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
					<a class="btn_sml" id="btnProdImgDel"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					<div class="helpTxtGray">
					* 상세 보기 이미지 입니다.<br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00074"] //확대이미지?>1</th>
				<td>
					<input type="file" id="prodImg4" name="prodImg4" value="" <?=$nBox?> style="height:20px;"/>
					<?
						if (is_array($aryProdImg[4]) && $aryProdImg[4][0][PM_NO] > 0){
							?>
							<a class="btn_sml" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[4][0][PM_NO]?>','img','500','500');"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdImg[4][0][PM_NO]?>);"><strong>X</strong></a>
							<?
						}
					?>
					<div class="helpTxtGray">
					* 상세 보기 이미지 입니다.<br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>


		</table>
--*/	?>

		<!-- 상품이미지 -->

		<!-- 상품동영상  -->
		<?if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y"):?>
		<h3 class="mt10"><?="상품동영상" //동영상?></h3>
		<table class="tableForm">
			<tr>
				<th><?="동영상URL" //동영상URL?></th>
				<td>
					<input type="text" name="prodMovie1" id="prodMovie1" value="<?=$strProdMovieUrl1?>" style="width:500px;">
				</td>
			</tr>
		</table>
		<?endif;?>

		<!-- 상품설명 -->
		<!--  ****************  -->
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["PW00075"] //상품설명?></h3>
		<table class="tableForm">
			<?if($siteCommArray):?>
			<tr>
				<th><?= $LNG_TRANS_CHAR["PW00293"]; //공통 리스트 ?></th>
				<td><select id="siteComm">
						<option value="">=== <?= $LNG_TRANS_CHAR["PW00287"]; //공통관리 ?> ===</option>
						<?foreach($siteCommArray as $key => $data):
							$no					= $data['SC_NO'];
							$title				= $data['SC_TITLE'];	?>
						<option value="<?=$no?>"><?=$title?></option>
						<?endforeach;?>
					</select>
					<a class="btn_sml" id="btnProdImgView" href="javascript:goProductSiteCommLoad()"><strong><?= $LNG_TRANS_CHAR["PW00288"]; //가져오기 ?></strong></a>
				</td>
			</tr>
			<?endif;?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00075"] //상품설명?></th>
				<td>
					<?php include MALL_HOME . "/common/eumEditor2/editor1.php";?>
					<textarea name="prodWebText" style="display:none"><?=($strProdShopCountry) ? "" : $prodRow[P_WEB_TEXT];?></textarea>
					<div class="helpTxtGray">
						* <?=$LNG_TRANS_CHAR["PS00014"]?>
					</div>
				</td>
			</tr>
		</table>
		<!-- 상품설명 -->

		<!--  관련상품  -->
		<!--div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00164"] //관련상품?></h3>
			<a href="javascript:goSmartPop()" class="btn_blue_sml"onclick=""><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
			<a href="javascript:goFormOpenEvent('prodOption')" id="prodOptionBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clr"></div>
		</div-->

		<div id="prodRelatedListArea">
			<?foreach($aryProdGrpList as $prodGrp):?>
			<dl id="p_code_<?=$prodGrp['P_CODE']?>" style="width:150px;">
				<dt><img id="pm_real_name" src="<?=$prodGrp['PM_REAL_NAME']?>" style="width:70px;height:70px"></dt>
				<dd id="p_code"><?=$prodGrp['P_CODE']?></dd>
				<dd id="p_brand"><?=$prodGrp['P_BRAND']?></dd>
				<dd id="p_name"><?=$prodGrp['P_NAME']?></dd>
				<dd id="p_sale_price"><?=$prodGrp['P_SALE_PRICE']?></dd>
			</dl>
			<?$prodrelatedCodeList .= ($prodrelatedCodeList) ? "," . $prodGrp['P_CODE'] : $prodGrp['P_CODE'];?>
			<?endforeach;?>
			<div class="clr"></div>
		</div>
		<input type="hidden" name="prodrelatedCodeList" id="prodrelatedCodeList" value="<?=$prodrelatedCodeList?>"/>
		<!-- prodListArea Form -->
		<textarea id="prodRelatedListSampleCode" style="display:none">
			<dl id="" class="prodlist">
				<dt>
					<input type="checkbox" name="prodSelect" id="prodSelect" value=""/>
					<img id="pm_real_name" src="" style="width:70px;height:70px">
				</dt>
				<dd id="p_code"></dd>
				<dd id="p_brand"></dd>
				<dd id="p_name"></dd>
				<dd id="p_sale_price"></dd>
			</dl>
		</textarea>
		<!--  관련상품  -->


		<!-- 모바일 상품설명 -->
		<!--  ****************  -->
		<div class="areaDivWrap mt20">
			<h3><?=$LNG_TRANS_CHAR["PW00076"] //모바일 상품설명?></h3>
			<a href="javascript:goFormOpenEvent('mobileText')" id="mobileTextBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clr"></div>
		</div>
		<div id="mobileTextArea" style="display:none">
			<table  class="tableForm">
				<!--
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00072"] //목록 이미지?>(Mobile)</th>
					<td>
						<input type="file" id="prodImg5" name="prodImg5" value="" <?=$nBox?> style="height:20px;"/>
						<?if(is_array($aryProdImg[5])): // 목록 이미지가 있을때 ?>
						<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[5][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
						<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[5][0]['PM_NO']?>);"><strong>X</strong></a>
						<?endif;?>
					</td>
					<th><?=$LNG_TRANS_CHAR["PW00073"] //상세 이미지?>(Mobile)</th>
					<td>
						<input type="file" id="prodImg6" name="prodImg6" value="" <?=$nBox?> style="height:20px;"/>
						<?if(is_array($aryProdImg[6])): // 상세 이미지가 있을때 ?>
						<a class="btn_sml" id="btnProdImgView" href="javascript:C_openWindow('./?menuType=popup&mode=prodImageView&no=<?=$aryProdImg[6][0]['PM_NO']?>','img','500','500');"><strong>view</strong></a>
						<a class="btn_sml" id="btnProdImgDelete" href="javascript:goProdImgDel(<?=$aryProdImg[6][0]['PM_NO']?>);"><strong>X</strong></a>
						<?endif;?>
					</td>
				</tr>
				-->
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00076"] //모바일 상품설명?></th>
					<td colspan="3">
						<?php include MALL_HOME . "/common/eumEditor2/editor2.php";?>
						<textarea name="prodMobileText" style="display:none"><?=($strProdShopCountry) ? "" : $prodRow[P_MOB_TEXT];?></textarea>
						<div class="helpTxtGray">
							* <?= $LNG_TRANS_CHAR["PS00078"]; ?><br/>
							* <?=$LNG_TRANS_CHAR["PS00015"]?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<!-- 모바일 상품설명 -->

		<!-- 상품 안내용 첨부파일 -->
		<!--  ****************  -->
		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00078"] //상품 안내용 첨부파일?></h3>
			<a href="javascript:goFormOpenEvent('prodHelpFile')" id="prodHelpFileBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clr"></div>
		</div>
		<div id="prodHelpFileArea" style="display:none">
			<table class="tableForm">
				<?
					for($z=1;$z<=3;$z++){
						?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00079"] //첨부파일?><?=$z?></th>
					<td>
						<input type="file" id="prodFile<?=$z?>" name="prodFile<?=$z?>" value="" <?=$nBox?> style="height:20px;"/>
						<?
							if (is_array($aryProdFile[$z]) && $aryProdFile[$z][0][PM_NO] > 0){
						?>
								<a class="btn_sml" href="./?menuType=popup&mode=prodFileDown&no=<?=$aryProdFile[$z][0][PM_NO]?>"><strong>view</strong></a><a class="btn_sml" href="javascript:goProdImgDel(<?=$aryProdFile[$z][0][PM_NO]?>);"><strong>X</strong></a>
								<?
							}
						?>
					</td>
				</tr>
						<?
					}
				?>
			</table>
		</div>
		<!-- 상품 안내용 첨부파일 -->


		<!--  ****************  -->
		<!--
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["PW00080"] //배송안내 및 반품/교환 설명?></h3>
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00081"] //배송안내?></th>
				<td>
					<textarea style="width:100%;height:150px;" name="prodDeliveryText" id="prodDeliveryText" title="higheditor_full"><?=$prodRow[P_DELIVERY_TEXT]?></textarea>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00082"] //반품/교환?></th>
				<td>
					<textarea style="width:100%;height:150px;" name="prodReturnText" id="prodReturnText" title="higheditor_full"><?=$prodRow[P_RETURN_TEXT]?></textarea>
				</td>
			</tr>
		</table> //-->

		<!-- 기타및메모 -->
		<!--  ****************  -->
		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00083"] //기타및메모?></h3>
			<a href="javascript:goFormOpenEvent('etcMemo')" id="etcMemoBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clr"></div>
		</div>
		<div id="etcMemoArea" style="display:none">
			<table class="tableForm">
				<tr>
					<td>
						<textarea id="prodMemo" name="prodMemo" style="width:100%;height:50px"><?=$prodRow[P_MEMO]?></textarea>
					</td>
				</tr>
			</table>
		</div>
		<!-- 기타및메모 -->
	</div>
</div>
<div class="buttonWrap" style="margin:0px;padding-top:5px;padding-bottom:5px;border-top:5px solid #5e5e6d;position:Fixed;left:175px;bottom:0px;width:100%;background:#fff;">
	<a class="btn_blue_big" href="javascript:void(0);" onclick="goProductProdModifyActEvent();" id="menu_auth_m" style="display:none"><strong><?=($strProdShopCountry) ? $LNG_TRANS_CHAR["CW00002"] /*등록*/ : $LNG_TRANS_CHAR["CW00003"] /*수정*/;?></strong></a>
	<a class="btn_big" href="javascript:goProdList();"><strong><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
</div>


<input type="hidden" name="lang" value="<?=$strStLng?>"/>