<?
	## 모듈 설정
	$objCommGrpModule = new CommGrpModule($db);

	## 언어 설정
	$strStLngLower = strtolower($S_ST_LNG);
	
	## 상품찾기 설정
	$param = "";
	$param['ORDER_BY'] = "CG.CG_NO ASC";
	$param['CG_CODE_LIKE'] = "PROD_SEARCH%";
	$aryCommGrpList = $objCommGrpModule->getCommGrpSelectEx("OP_ARYTOTAL", $param);

?>
<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/product";
	var uploadFile 	= "../<?=$strStLngLower?>/index.php";
	var htmlYN		= "Y";
//]]>
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["PW00022"]?></h2>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<h3><?=$LNG_TRANS_CHAR["PW00023"]?></h3>
		<table>
			<tr>
				<td>
					<select id="cateHCode1" name="cateHCode1" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00013"]?> =</option>
					</select>
					<select id="cateHCode2" name="cateHCode2" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00014"]?> =</option>
					</select>
					<select id="cateHCode3" name="cateHCode3" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00015"]?> =</option>
					</select>
					<select id="cateHCode4" name="cateHCode4" style="width:250px;height:150px" multiple>
						<option value="">= <?=$LNG_TRANS_CHAR["PW00016"]?> =</option>
					</select>
				</td>
			</tr>
		</table>

		<!--  ****************  -->
		<h3 class="mt10"><?=$LNG_TRANS_CHAR["PW00024"] //상품기본정보?></h3>
		<table>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></span></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:90%;font-weight:bold;font-size:14px;" id="prodName" name="prodName"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:300px;" id="prodViewCode" name="prodViewCode"/>
				</td>
			</tr>
			<tr>
				<th><?=($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MAKE']: $LNG_TRANS_CHAR["PW00004"]; //제조사?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodMake" name="prodMake"/>
					<?=drawSelectBoxMoreQuery("selectProdMake",$aryProductMaker,$selected ="","","javascript:goSelectInputVal('Make');","",($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MAKE']: $LNG_TRANS_CHAR["PW00004"],"N","COL","COL")?>
				</td>
				<th><?=($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['ORIGIN']: $LNG_TRANS_CHAR["PW00005"]; //원산지?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodOrigin" name="prodOrigin"/>
					<?=drawSelectBoxMoreQuery("selectProdOrigin",$aryProductOrigin,$selected ="","","javascript:goSelectInputVal('Origin');","",($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['ORIGIN']: $LNG_TRANS_CHAR["PW00005"],"N","COL","COL")?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00025"] //브랜드?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodBrand" name="prodBrand" readonly/>
					<!--input type="text" <?=$nBox?>  style="width:150px;" id="prodBrandName" name="prodBrandName" readonly/-->
					<?=drawSelectBoxMoreQuery("selectProdBrand",$aryProdBrandList,$selected ="","","javascript:goSelectInputVal('Brand');","",$LNG_TRANS_CHAR["PW00025"],"N","PR_NO","PR_NAME")?>
					<a href="./?menuType=product&mode=prodBrandList" class="btn_sml"><span>브랜드관리</span></a>
				</td>
				<th><?=($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MODEL']: $LNG_TRANS_CHAR["PW00006"]; //모델명?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodModel" name="prodModel"/>
					<?=drawSelectBoxMoreQuery("selectProdModel",$aryProductModel,$selected ="","","javascript:goSelectInputVal('Model');","",($S_FIX_PROD_BASIC_ITEM_USE=="Y") ? $S_FIX_PROD_BASIC_ITEM[$S_SITE_LNG]['MODEL']: $LNG_TRANS_CHAR["PW00006"],"N","COL","COL")?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodLaunchDt" name="prodLaunchDt"/>
				</td>
				<?if($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 입점몰 승인이 필요한 경우?>
					<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
					<td>
						<input type="hidden" id="" name="prodWebViewYN" value="N" />
						<input type="hidden" id="" name="prodMobViewYN" value="N" />
						<div class="helpTxt">
							* 웹페이지와 모바일 페이지에 해당 상품 노출 여부를 선택합니다.
						</div>
					</td>
				<?else:?>
					<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
					<td>
						<input type="checkbox" id="" name="prodWebViewYN" value="Y" checked/><?=$LNG_TRANS_CHAR["PW00011"] //WEB 보임?>
						<input type="checkbox" id="" name="prodMobViewYN" value="Y" checked/><?=$LNG_TRANS_CHAR["PW00012"] //모바일 보임?>
						<div class="helpTxt">
							* 웹페이지와 모바일 페이지에 해당 상품 노출 여부를 선택합니다.
						</div>
					</td>
				<?endif;?>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodRepDt" name="prodRepDt" value="<?=date("Y-m-d")?>"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00026"] //상품우선순위?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:150px;" id="prodOrder" name="prodOrder" />
				</td>
			</tr>
			<?if($a_admin_type == "A"):?>
			<?if(is_array($aryProdMainDisplayList)){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00027"] //메인진열관리?></th>
				<td>
					<?if ($aryProdMainDisplayList[0][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon1" name="prodIcon1" value="Y"><?=$aryProdMainDisplayList[0][IC_NAME]?>
					<?}?>
					<?if ($aryProdMainDisplayList[1][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon2" name="prodIcon2" value="Y"><?=$aryProdMainDisplayList[1][IC_NAME]?>
					<?}?>
					<?if ($aryProdMainDisplayList[2][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon3" name="prodIcon3" value="Y"><?=$aryProdMainDisplayList[2][IC_NAME]?>
					<?}?>
					<?if ($aryProdMainDisplayList[3][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon4" name="prodIcon4" value="Y"><?=$aryProdMainDisplayList[3][IC_NAME]?>
					<?}?>
					<?if ($aryProdMainDisplayList[4][IC_USE] == "Y"){?>
						<input type="checkbox" id="prodIcon5" name="prodIcon5" value="Y"><?=$aryProdMainDisplayList[4][IC_NAME]?>
					<?}?>
					<a href="./?menuType=product&mode=prodDisplay" class="btn_sml"><span>진열장관리</span></a>
					<div class="helpTxt">
						* 메인페이지 추천상품을 관리합니다.<br>
						* 등록 상품을 원하시는 추천에 체크하시면 해당 영역에 노출 됩니다.
					</div>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00028"] //서브진열관리?></th>
				<td>
					<?if ($aryProdSubDisplayList[0][IC_USE] == "Y"){?>
					<input type="checkbox" id="prodIcon6" name="prodIcon6" value="Y"><?=$aryProdSubDisplayList[0][IC_NAME]?>
					<?}?>
					<?if ($aryProdSubDisplayList[1][IC_USE] == "Y"){?>
					<input type="checkbox" id="prodIcon7" name="prodIcon7" value="Y"><?=$aryProdSubDisplayList[1][IC_NAME]?>
					<?}?>
					<?if ($aryProdSubDisplayList[2][IC_USE] == "Y"){?>
					<input type="checkbox" id="prodIcon8" name="prodIcon8" value="Y"><?=$aryProdSubDisplayList[2][IC_NAME]?>
					<?}?>
					<?if ($aryProdSubDisplayList[3][IC_USE] == "Y"){?>
					<input type="checkbox" id="prodIcon9" name="prodIcon9" value="Y"><?=$aryProdSubDisplayList[3][IC_NAME]?>
					<?}?>
					<?if ($aryProdSubDisplayList[4][IC_USE] == "Y"){?>
					<input type="checkbox" id="prodIcon10" name="prodIcon10" value="Y"><?=$aryProdSubDisplayList[4][IC_NAME]?>
					<?}?>
				</td>
			</tr>
			<?}?>
			<?endif;?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00029"] //아이콘?></th>
				<td colspan="3">
					<input type="radio" name="prodListIconView" id="prodListIconView" value="1" checked><?=$LNG_TRANS_CHAR["PW00177"] //계속보여주기?>
					<input type="radio" name="prodListIconView" id="prodListIconView" value="2"><?=$LNG_TRANS_CHAR["PW00178"] //기간설정?><br><br>
					<div style="height:30px;display:none" id="divProdIconStartEndDate">
						<input type="text" <?=$nBox?>  style="width:80px;" id="prodListIconStartDt" name="prodListIconStartDt"/>
						<?=drawSelectBoxDate("prodListIconStartHour",   0,   24,   1, "", "","Hour","")?>
						<?=drawSelectBoxDate("prodListIconStartMin",   0,   60,   1, "", "","Minute","")?>

						~
						<input type="text" <?=$nBox?>  style="width:80px;" id="prodListIconEndDt" name="prodListIconEndDt"/>
						<?=drawSelectBoxDate("prodListIconEndHour",   0,   24,   1, "", "","Hour","")?>
						<?=drawSelectBoxDate("prodListIconEndMin",   0,   60,   1, "", "","Minute","")?>
					</div>
					<?
					if (is_array($aryProdIconDisplayList)){
						for($i=0;$i<sizeof($aryProdIconDisplayList);$i++){
												
							$strProdListIconNo   = $aryProdIconDisplayList[$i][IC_NO];
							$strProdListIconName = "prodListIcon_".$aryProdIconDisplayList[$i][IC_NO];
						?>
						<input type="checkbox" id="<?=$strProdListIconName?>" name="<?=$strProdListIconName?>" value="Y">
						<img src="<?=$aryProdIconDisplayList[$i][IC_IMG]?>">
						<?
						}
					}
					?>
					<a href="./?menuType=product&mode=prodDisplay" class="btn_sml"><span>아이콘 추가</span></a>
					<div class="helpTxt">
						* 체크된 아이콘은 상품 목록에 보여집니다.<br>
						* 아이콘은 기간을 설정하시면 해당 기간만큼만 보여지며 계속 노출을 원하시는 경우 "계속보여주기"를 선택하세요.<br>
						* 자신만의 아이콘으로 변경하길 원하시면 "아이콘 추가" 버튼을 클릭 "진열장 관리"페이지로 이동하여 등록 및 수정이 가능합니다.
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00030"] //검색어?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:500px;" id="prodKeyWord" name="prodKeyWord"/>
					<div class="helpTxt">
						* 검색어는 콤마(,)로 구분하여 등록하세요.<br>
						* 등록된 검색어는 사용자 페이지에서 상품 검색 시 함께 검색 됩니다.
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00031"] //특이사항?></th>
				<td colspan="3">
					<textarea id="prodEtc" name="prodEtc" style="width:500px;height:50px"></textarea>
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
					for($i=0;$i<sizeof($S_ARY_PROD_COLOR);$i++){
						if ($S_ARY_PROD_COLOR[$i]['USE'] == "Y"){
							echo "<input type=\"checkbox\" name=\"prodColor_".$i."\" id=\"prodColor_".$i."\" value=\"Y\">&nbsp;<img src=\"".$S_ARY_PROD_COLOR[$i]['IMG']."\">".$S_ARY_PROD_COLOR[$i]['NAME']."&nbsp;";
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
					<table>
					<?
					for($i=0;$i<sizeof($S_ARY_PROD_SIZE);$i++){
						if ($S_ARY_PROD_SIZE[$i]['USE'] == "Y"){
							if ($i % 10 == 0) echo "<tr>";
							echo "<td><input type=\"checkbox\" name=\"prodSize_".$i."\" id=\"prodSize_".$i."\" value=\"Y\">".$S_ARY_PROD_SIZE[$i]['NAME']."</td>";
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

		</table>

		<!--  ****************  -->
		<?php if($aryCommGrpList):?>
		<h3 class="mt10">상품찾기</h3>
		<table>
			<?php foreach($aryCommGrpList as $grpKey => $grpData):
				## 기본 설정
				$strGrpCode = $grpData['CG_CODE'];
				$strGrpName = $grpData['CG_NAME'];	
				
				## 공통코드 불러오기
				$aryCommCode = getCommCodeList($strGrpCode);				?>
			<tr>
				<th><span class="mustItem"><?php echo $strGrpName;?></span></th>
				<td>
					<?php if($aryCommCode):?>
					<?php foreach($aryCommCode as $codeKey => $codeData):		?>
					<input type="checkbox" name="productSearch[]" value="<?php echo $strGrpCode;?>@<?php echo $codeKey;?>"> <?php echo $codeData;?>
					<?php endforeach;?>
					<?php endif;?>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<?php endif;?>

		<!--  ****************  -->
		<h3 class="mt10"><?=$LNG_TRANS_CHAR["PW00035"] //상품가격및수량관리?></h3>
		<table>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["BW00054"] //판매가격?></span></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["L"]?> 
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;color:#FF0000;" id="prodSalePrice" name="prodSalePrice"/> 
					<?=$S_ARY_MONEY_ICON[$strProdLng]["R"]?>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00036"] //소비자가격?></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["L"]?> 
					<input type="text" <?=$nBox?>    style="width:100px;text-align:right;font-weight:bold;" id="prodConsumerPrice" name="prodConsumerPrice"/>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["R"]?> 
					(할인율:<input type="text" <?=$nBox?>  style="width:40px;text-align:right;font-weight:bold;" id="prodDiscountRate" name="prodDiscountRate" maxlength="3"/>%)
					<span class="helpTxt">
						* 소비자가를 등록하는경우 상품목록에 소비자가가 표시됩니다.
					</span>
					
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00037"] //입고가격?></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["L"]?> 
					<input type="text" <?=$nBox?>    style="width:100px;text-align:right;font-weight:bold;" id="prodStockPrice" name="prodStockPrice"/>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["R"]?> 
				</td>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //적립금?></th>
				<td>
					<input type="text" <?=$nBox?>    style="width:100px;text-align:right;font-weight:bold;" id="prodPoint" name="prodPoint" value="<?=$siteRow[S_POINT_PRICE]?>"/> 
					<select id="prodPointType" name="prodPointType">
						<option value="1" <?=($siteRow[S_POINT_PRICE_UNIT]=="1")?"selected":"";?>>%</option>
						<option value="2" <?=($siteRow[S_POINT_PRICE_UNIT]=="2")?"selected":"";?>><?=$S_ST_CUR?></option>
					</select>
					Point 적립하고, 소수점
					
					<input type="text" <?=$nBox?>    style="width:30px;text-align:right;font-weight:bold;" id="prodPointOff1" name="prodPointOff1" value="<?=$siteRow[S_POINT_PRICE_POS]?>"/><?=$LNG_TRANS_CHAR["PW00044"] //자리?>
					<select id="prodPointOff2" name="prodPointOff2">
						<option value="1"><?=$LNG_TRANS_CHAR["PW00038"] //절삭?></option>
						<option value="2"><?=$LNG_TRANS_CHAR["PW00039"] //반올림?></option>
					</select>
					<input type="checkbox" name="prodPointNoUse" id="prodPointNoUse" value="Y"><?=$LNG_TRANS_CHAR["OW00158"] //주문시포인트사용금지상품?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00099"] //수수료?></th>
				<td>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["L"]?> 
						<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodAccPrice" name="prodAccPrice" readonly/>
					<?=$S_ARY_MONEY_ICON[$strProdLng]["R"]?> 
						<input type="text" <?=$nBox?>  style="width:40px;text-align:right;font-weight:bold;" id="prodAccRate" name="prodAccRate" readonly/>%
						<div class="helpTxt">
							* 입고가와 판매가 대비 마진율을 자동 표시 합니다.
						</div>
				</td>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00040"] //수량?></span></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;font-weight:bold;" id="prodQty" name="prodQty" value="0" disabled/> 
					<input type="checkbox" id="prodStockLimit" name="prodStockLimit" value="Y" onclick="javascript:goStockLimit(this);" checked/> <?=$LNG_TRANS_CHAR["PW00043"] //무제한상품?>	
					<input type="checkbox" id="prodStockOut" name="prodStockOut" value="Y"/> <?=$LNG_TRANS_CHAR["PW00041"] //품절?>
					<input type="checkbox" id="prodReStock" name="prodReStock" value="Y"/> <?=$LNG_TRANS_CHAR["PW00042"] //재입고상품?>
					
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00003"] //재고 수량 관리를 하지 않는경우 <strong>무제한 상품</strong>을 체크해 주세요.?><br/>
						* <?=$LNG_TRANS_CHAR["PS00004"] //재고 관리를 하는경우 수량을 입력해 주시고 <strong>옵션별 재고 수량</strong> 관리 하셔야 합니다.?>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00045"] //최소구매수량?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;" id="prodSaleMinQty" name="prodSaleMinQty" value="1"/>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00046"] //최대구매수량?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;text-align:right;" id="prodSaleMaxQty" name="prodSaleMaxQty"/>
				</td>
			</tr>

			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00047"] //과세?>/<?=$LNG_TRANS_CHAR["PW00048"] //비과세?></th>
				<td>
					<input type="radio" id="prodTax" name="prodTax" value="Y" checked/><?=$LNG_TRANS_CHAR["PW00047"] //과세?>
					<input type="radio" id="prodTax" name="prodTax" value="N"/><?=$LNG_TRANS_CHAR["PW00048"] //비과세?>
				</td>
				<th><?=$LNG_TRANS_CHAR["PW00049"] //가격대체문구?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="prodReplaceText" name="prodReplaceText"/>
					<span class="helpTxt">
						* 가격을 노출하여 판매할 수 없는 상품인 경우 사용됩니다. 예) 판매가: 문의(T: 1644-2508)
					</span>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00108"] //상품무게?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:50px;text-align:right;" id="prodWeight" name="prodWeight"/> g
					(<?=$LNG_TRANS_CHAR["PS00036"] //상품무게는 최소500g 단위로 입력하셔야 합니다.?>)
				</td>
			</tr>
		</table>
	</div>


		<!-- 상품옵션관리 -->
		<div class="areaDivWrap topBorder">
			<h3><?=$LNG_TRANS_CHAR["PW00050"] //상품옵션관리?></h3>
			<a href="javascript:goFormOpenEvent('prodOption')" id="prodOptionBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clear"></div>
		</div>
		<div id="prodOptionArea" style="display:none">			
			<div style="padding:10px 0 5px;">
				<input type="radio" id="prodOptType" name="prodOptType" value="1" checked/><?=$LNG_TRANS_CHAR["PW00051"] //다중가격사용안함?>
				<input type="radio" id="prodOptType" name="prodOptType" value="2"/><?=$LNG_TRANS_CHAR["PW00052"] //다중가격일체형?>
				<input type="radio" id="prodOptType" name="prodOptType" value="3"/><?=$LNG_TRANS_CHAR["PW00053"] //다중가격분리형?>
			</div>
			<div class="tableInList">		
				<table id="tabProdOpt">
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
					<tr>
						<td><input type="text" <?=$nBox?>  style="width:120px;" id="prodOptName1" name="prodOptName1" value=""/></td>
						<td style="text-align:left;"><input type="text" <?=$nBox?>  style="width:99%;" id="prodOptVal1" name="prodOptVal1" value=""/></td>
						<td><input type="checkbox" id="prodOptEss" name="prodOptEss" value="Y" checked/></td>
					</tr>
				</table>
				<a class="btn_blue_sml" id="btnProdOptAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
				<a class="btn_sml" id="btnProdOptDel"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				<a class="btn_sml" id="btnProdOptAttr" href="javascript:goProdOptAttrAdd();"><strong><?=$LNG_TRANS_CHAR["PW00057"] //옵션속성만들기?></strong></a>
				<br><br>
				<table id="tabProdOptAttr">
				</table>	
				<div class="helpTxt">
					* <?=$LNG_TRANS_CHAR["PS00005"] //해당 상품의 특성상 옵션별 재고나 금액이 다른경우 사용합니다.?><br/>
					* <?=$LNG_TRANS_CHAR["PS00006"] //해당 상품의 옵션에 따라 가격이나 재고가 변동이 없는경우 <strong>"다중가격사용안함"</strong>을 선택하세요.?><br/>
					* <?=$LNG_TRANS_CHAR["PS00007"] //옵션별 재고와 가격이 다른경우 <strong>"다중가격분리형"</strong>을 선택하세요.?><br/>
					* <?=$LNG_TRANS_CHAR["PS00008"] //옵션별 속성 구분값은 세미콜론<strong>";"</strong>을 입력하세요.?>
				</div>
				<div class="hefpTxtBox">
					<strong>옵션속성 만들기 방법</strong><br/>
					① 옵션명과 옵션항목을 입력합니다. 옵션항목은 세미콜론(;)으로 구분합니다. 예) Black;Red;Yellow<br/>
					② 선택할 옵션값이 더 있다면 추가 버튼을 클릭하여 한줄을 더 생성합니다. 예) Size: XL;L;S<br/>
					③ 생성할 옵션항목이 입력되었다면 "옵션속성만들기" 버튼을 클릭하세요.  하단에 각 항목이 분리되어 정렬됩니다.<br/>
					④ 생성된 옵션항목의 입력값(재고/판매가 등)을 넣어 주세요.
				</div>
			</div>
		</div>
		<!-- 상품옵션관리 -->

	

	<!--  ****************  -->
	<?if ($S_MALL_TYPE == "R"){?>
	<div class="areaDivWrap">
		<h3><?=$LNG_TRANS_CHAR["PW00058"] //추가옵션관리?></h3>
		<a href="javascript:goFormOpenEvent('addOption')" id="addOptionBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
		<div class="clear"></div>
	</div>
	<div id="addOptionArea" style="display:none">
		<div style="padding:10px 0 5px;">
			<input type="radio" id="prodAddOpt" name="prodAddOpt" value="Y" checked/><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
			<input type="radio" id="prodAddOpt" name="prodAddOpt" value="N"/><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
		</div>
		<div class="tableInList">
			<table id="tabProdAddOpt">
				<colgroup>
					<col width="300"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00059"] //추가옵션명?>/<?=$LNG_TRANS_CHAR["PW00060"] //구매시필수?></th>
					<th><?=$LNG_TRANS_CHAR["PW00062"] //항목명?></th>
					<th><?=$LNG_TRANS_CHAR["PW00061"] //추가금액?></th>
				</tr>
				<tr class="trProdAddOpt1">
					<td class="alignLeft">
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptName[]" name="prodAddOptName[]" value=""/>
						<input type="checkbox" id="prodAddOptChk[]" name="prodAddOptChk[]" value="Y"/>
						<a class="btn_blue_sml" href="javascript:goProdAddOptAdd();" id="btnProdAddOptAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<a class="btn_sml" href="javascript:goProdAddOptDel();" id="btnProdAddOptDel"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptVal1[]" name="prodAddOptVal1[]" value=""/>
						<a class="btn_blue_sml" id="btnProdAddOptValAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
					</td>
					<td>
						<input type="text" <?=$nBox?>  style="width:120px;" id="prodAddOptPrice1[]" name="prodAddOptPrice1[]" value=""/>
					</td>
				</tr>
			</table>

			<div class="helpTxt">
				* <?=$LNG_TRANS_CHAR["PS00009"] //상품 구매 시 별도 추가되는 옵션이 있는경우 사용합니다.?><br/>
				* <?=$LNG_TRANS_CHAR["PS00010"] //상품 가격에 추가되는 금액입니다.?>
			</div>
		</div>
	</div>
	<?}?>

	<div class="tableForm">
		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00032"] //상품추가정보?></h3>
			<a href="javascript:goFormOpenEvent('prodAdd')" id="prodAddBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clear"></div>
		</div>
		<div id="prodAddArea" style="display:none">
			
			<?if ($S_FIX_PROD_ITEM_ADD_FORM_USE == "Y"){?>
			<table id="trProdItemList">
				<colgroup>
					<col width="100"/>
					<col/>
					<col width="100"/>
					<col/>
				</colgroup>
				<?
					$intProdItemFormIndex = 0;
					foreach($S_FIX_PROD_ITEM_ADD_FORM_LIST as $key => $val){
						$intProdItemFormIndex = $key + 1;
				?>
				<tr class="prodItem1">
					<th><?=($intProdItemFormIndex > 1) ? $LNG_TRANS_CHAR['PW00062'].$intProdItemFormIndex : $LNG_TRANS_CHAR["PW00033"]; //항목명?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodItem[]" name="prodItem[]" value="<?=$val?>"/>
						<?if ($intProdItemFormIndex > 1){?>
						<a class="btn_sml" href="javascript:goProdItemDel(<?=$intProdItemFormIndex?>);" id="btnItemAdd"><strong>-<?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
						<?}else{?>
						<a class="btn_blue_sml" href="javascript:goProdItemAdd();" id="btnItemAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
						<?}?>
					</td>
					<th><?=($intProdItemFormIndex > 1) ? $LNG_TRANS_CHAR['PW00116'].$intProdItemFormIndex : $LNG_TRANS_CHAR["PW00034"]; //항목설명?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:300px;" id="prodItemText[]" name="prodItemText[]"/>
					</td>
				</tr>
				<?}?>
			</table>
			<?}else{?>
			<?if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){?>
			<table id="trProdItemList">
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
				<tr class="prodItem1">
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodItem[]" name="prodItem[]"/>
						<a class="btn_blue_sml" href="javascript:goProdItemAddVer2();" id="btnItemAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
					</td>
					<td>
						<select name="prodItemType[]" id="prodItemType[]" onchange="javascript:goProdItemTypeSelect(this);">
							<option value="B">설명</option>
							<option value="U">사용자입력</option>
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
						<input type="text" <?=$nBox?>  style="width:90%;" id="prodItemText[]" name="prodItemText[]"/>
					</td>
				</tr>
			</table>
			<?}else{?>
			<table id="trProdItemList">
				<colgroup>
					<col width="100"/>
					<col width="300"/>
					<col width="100"/>
					<col/>
				</colgroup>
				<tr class="prodItem1">
					<th><?=$LNG_TRANS_CHAR["PW00033"] //항목명1?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:150px;" id="prodItem[]" name="prodItem[]"/>
						<a class="btn_blue_sml" href="javascript:goProdItemAdd();" id="btnItemAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
					</td>
					<th><?=$LNG_TRANS_CHAR["PW00034"] //항목설명1?></th>
					<td>
						<input type="text" <?=$nBox?>  style="width:90%;" id="prodItemText[]" name="prodItemText[]"/>
					</td>
				</tr>
			</table>
			<?}?>
			<?}?>
			<div class="helpTxt">
				* <?=$LNG_TRANS_CHAR["PS00002"] //상품 요약 정보에 추가적으로 문구를 넣으실 수 있습니다.?>
			</div>
		</div>
	</div>


	<div class="tableForm">
			<h3><?=$LNG_TRANS_CHAR["PW00063"] //상품배송비관리?></h3>

		<!--  ****************  -->
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00064"] //배송비?></th>
				<td>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="1" checked/> <?=$LNG_TRANS_CHAR["PW00065"] //기본배송비정책?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="2"/> <?=$LNG_TRANS_CHAR["PW00066"] //무료배송?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="3"/> <?=$LNG_TRANS_CHAR["PW00067"] //배송비고정?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="4"/> <?=$LNG_TRANS_CHAR["PW00068"] //수량별배송?>
					<input type="radio" id="prodDelivery" name="prodDelivery" value="5"/> <?=$LNG_TRANS_CHAR["PW00069"] //착불배송비?>
					<div id="divBaesongPrice" style="display:none">
						<br><?=$LNG_TRANS_CHAR["PW00064"] //배송비?> : <input type="text" name="prodDeliveryPrice" id="prodDeliveryPrice" value="" style="width:80px;">
					</div>
				</td>
			</tr>
		</table>

		<!--  ****************  -->
		<h3 class="mt10"><?=$LNG_TRANS_CHAR["PW00070"] //상품이미지?></h3>
		<table id="tabProdImg2">
			<? ## 2014.04.05 상세이미지 다중이미지로 변경 ?>
			<? ## 2014.04.11 한장의 이미지로 사용하기 - 추가 ?>
			<tr id="prodImgTrId_4">
				<th><?=$LNG_TRANS_CHAR["PW00074"] //확대이미지?></th>
				<td colspan="3">
					<input type="file" id="prodImg4" name="prodImg4" value="" <?=$nBox?> style="height:20px;"/>
					<input type="checkbox" id="prodImgCopy" name="prodImgCopy" value="Y"  <?=$nBox?>  style="height:20px;" /> 한장의 이미지로 사용하기
					<input type="checkbox" id="prodImgUrlYN" name="prodImgUrlYN" value="Y"  <?=$nBox?>  style="height:20px;" /> 이미지 URL 사용하기
					<div class="helpTxt">
					* <?=$LNG_TRANS_CHAR["PS00037"] //확대보기 이미지 입니다.?>,  <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr id="prodImgTrId_3">
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?></span></th>
				<td colspan="3">
					<input type="file" id="prodImg
					3" name="prodImg3" value="" <?=$nBox?> style="height:20px;"/>
					<div class="helpTxt">
					* <?=$LNG_TRANS_CHAR["PS00038"] //상세 보기 이미지 ?>, <?=$LNG_TRANS_CHAR["PW00113"]//이미지 가로사이즈?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr id="prodImgTrId_2">
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00072"] //리스트이미지?></span></th>
				<td colspan="3">
					<input type="file" id="prodImg2" name="prodImg2" value="" <?=$nBox?> style="height:20px;"/> 
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
				</td>
			</tr>
			<?endif;?>
			<tr id="productDetailImage_1">
				<th><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?>
				<a class="btn_blue_sml" id="btnProdImgAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a></th>
				<td colspan="3">
					기본 : <input type="file" id="prodImgBasic" name="prodImg7" value="" <?=$nBox?> style="height:20px;"/>
					확대 : <input type="file" id="prodImgExpend" name="prodImg18" value="" <?=$nBox?> style="height:20px;"/>
				</td>
			</tr>
		</table>
		<table id="tabProdImg3" style="display:none">
			<? ## 2013.08.09 URL 사용하기 - 추가 ?>
			<tr id="prodImgTrId_4">
				<th><?=$LNG_TRANS_CHAR["PW00074"] //확대이미지?></th>
				<td colspan="3">
					<input type="text" id="prodUrlImg4" name="prodUrlImg4" value="" <?=$nBox?> style="width:500px;"/>
					<input type="checkbox" id="prodImgFileYN" name="prodImgFileYN" value="Y"  <?=$nBox?>  /> 이미지 파일로 사용하기
					<div class="helpTxt">
					* <?=$LNG_TRANS_CHAR["PS00037"] //확대보기 이미지 입니다.?><br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?></span></th>
				<td colspan="3">
					<input type="text" id="prodUrlImg3" name="prodUrlImg3" value="" <?=$nBox?> style="width:500px;"/>
					<div class="helpTxt">
					* <?=$LNG_TRANS_CHAR["PS00038"] //상세 보기 이미지 입니다.?><br/>
					* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODUCT_VIEW_ISW?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODUCT_VIEW_ISH?></strong>px<br/>
					</div>
				</td>
			</tr>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["PW00072"] //리스트이미지?></span></th>
				<td colspan="3">
					<input type="text" id="prodUrlImg2" name="prodUrlImg2" value="" <?=$nBox?> style="width:500px;"/> 
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00012"]?><br/>
						* <?=$LNG_TRANS_CHAR["PW00113"]?> <strong><?=$S_PRODLIST_IMG_SIZE_W?></strong>px, <?=$LNG_TRANS_CHAR["PW00114"]?> <strong><?=$S_PRODLIST_IMG_SIZE_H?></strong>px
						(<?=$LNG_TRANS_CHAR["PS00013"]?>}
					</div>
				</td>
			</tr>
			<?if($S_PRODLIST_TURN_USE=="Y"):?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00071"] //리스트이미지2?></th>
				<td colspan="3">
					<input type="text" id="prodUrlImg1" name="prodUrlImg1" value="" <?=$nBox?> style="width:500px;"/>
				</td>
			</tr>
			<?endif;?>
			<tr id="productDetailUrlImage_1">
				<th><?=$LNG_TRANS_CHAR["PW00073"] //상세이미지?>
				<a class="btn_blue_sml" id="btnProdUrlImgAdd"><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a></th>
				<td colspan="3">
					기본 : <span><input type="text" id="prodUrlImgBasic" name="prodUrlImg7" value="" <?=$nBox?> style="width:350px;"/></span>
					확대 : <span><input type="text" id="prodUrlImgExpend" name="prodUrlImg18" value="" <?=$nBox?> style="width:350px;"/></span>
				</td>
			</tr>
		</table>


		<?if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y"):?>
		<h3 class="mt10"><?="상품동영상" //동영상?></h3>
		<table>
			<tr>
				<th><?="동영상URL" //동영상URL?></th>
				<td>
					<input type="text" name="prodMovie1" id="prodMovie1" value="" style="width:500px;">
				</td>
			</tr>
		</table>
		<?endif;?>

		<!--  ****************  -->
		<h3 class="mt10"><?=$LNG_TRANS_CHAR["PW00075"] //상품설명?></h3>
		<table>
			<?if($siteCommArray):?>
			<tr>
				<th>공통 리스트</th>
				<td><select id="siteComm">
						<option value="">=== 공통관리 ===</option>
						<?foreach($siteCommArray as $key => $data):
							$no					= $data['SC_NO'];
							$title				= $data['SC_TITLE'];	?>
						<option value="<?=$no?>"><?=$title?></option>
						<?endforeach;?>
					</select>
					<a class="btn_sml" id="btnProdImgView" href="javascript:goProductSiteCommLoad()"><strong>가져오기</strong></a>
				</td>
			</tr>
			<?endif;?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00075"] //상품설명?></th>
				<td>
					<textarea style="width:100%;height:250px;" name="prodWebText" id="prodWebText" title="higheditor_full"></textarea>
					<div class="helpTxt">
						* <?=$LNG_TRANS_CHAR["PS00014"]?>
					</div>
				</td>
			</tr>
		</table>

	<!--  ****************  -->
		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00164"] //관련상품?></h3>
			<a href="javascript:goSmartPop()" class="btn_blue_sml"onclick=""><strong>+<?=$LNG_TRANS_CHAR["CW00028"] //추가?></strong></a>
			<div class="clear"></div>
		</div>
		
		<div id="prodRelatedListArea"></div>
		<input type="hidden" name="prodrelatedCodeList" id="prodrelatedCodeList"/>
		<!-- prodListArea Form -->
		<textarea id="prodRelatedListSampleCode" style="display:none">
			<ul id="" style="width:150px;">
				<img id="pm_real_name" src="" style="width:70px;height:70px">
				<li id="p_code"></li>
				<li id="p_brand"></li>
				<li id="p_name"></li>
				<li id="p_sale_price"></li>
			</ul>
		</textarea>
		<!-- prodListArea Form -->

	<!--  ****************  -->
		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00076"] //모바일 상품설명?></h3>
			<a href="javascript:goFormOpenEvent('mobileText')" id="mobileTextBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clear"></div>
		</div>
		<div id="mobileTextArea" style="display:none">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00072"] //목록 이미지?>(Mobile)</th>
					<td>
						<input type="file" id="prodImg5" name="prodImg5" value="" <?=$nBox?> style="height:20px;"/>
					</td>
					<th><?=$LNG_TRANS_CHAR["PW00073"] //상세 이미지?>(Mobile)</th>
					<td>
						<input type="file" id="prodImg6" name="prodImg6" value="" <?=$nBox?> style="height:20px;"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00076"] //모바일 상품설명?></th>
					<td colspan="3">
						<textarea style="width:100%;height:250px;" name="prodMobileText" id="prodMobileText" title="higheditor_full"></textarea>
						<div class="helpTxt">
							* <?=$LNG_TRANS_CHAR["PS00015"]?>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<!--  ****************  -->
		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00078"] //상품 안내용 첨부파일?></h3>
			<a href="javascript:goFormOpenEvent('prodHelpFile')" id="prodHelpFileBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clear"></div>
		</div>
		<div id="prodHelpFileArea" style="display:none">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00079"] //첨부파일?>1</th>
					<td>
						<input type="file" id="prodFile1" name="prodFile1" value="" <?=$nBox?> style="height:20px;"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00079"] //첨부파일?>2</th>
					<td>
						<input type="file" id="prodFile2" name="prodFile2" value="" <?=$nBox?> style="height:20px;"/>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00079"] //첨부파일?>3</th>
					<td>
						<input type="file" id="prodFile3" name="prodFile3" value="" <?=$nBox?> style="height:20px;"/>
					</td>
				</tr>
			</table>
		</div>

		<!--  ****************  -->
		<!--
		<h3 class="mt10"><?=$LNG_TRANS_CHAR["PW00080"] //배송안내 및 반품/교환 설명?></h3>
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00081"] //배송안내?></th>
				<td>
					<textarea style="width:100%;height:150px;" name="prodDeliveryText" id="prodDeliveryText" title="higheditor_full"><?=$siteRow[S_PROD_DELIVERY]?></textarea>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00082"] //반품/교환?></th>
				<td>
					<textarea style="width:100%;height:150px;" name="prodReturnText" id="prodReturnText" title="higheditor_full"><?=$siteRow[S_PROD_RETURN]?></textarea>
				</td>
			</tr>
		</table> //-->
		<!--  ****************  -->
		<div class="areaDivWrap">
			<h3><?=$LNG_TRANS_CHAR["PW00083"] //기타및메모?></h3>
			<a href="javascript:goFormOpenEvent('etcMemo')" id="etcMemoBtn" class="btn_sml_open"><span><?=$LNG_TRANS_CHAR["PW00165"]//열기?></span></a>
			<div class="clear"></div>
		</div>
		<div id="etcMemoArea" style="display:none">
			<table>
				<tr>
					<td>
						<textarea id="prodMemo" name="prodMemo" style="width:100%;height:50px"></textarea>	
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="buttonWrap" style="margin:0px;padding-top:5px;padding-bottom:5px;border-top:5px solid #5e5e6d;position:Fixed;left:175px;bottom:0px;width:100%;background:#fff;">
	<a class="btn_blue_big" href="javascript:goProdAct('prodWrite');" id="menu_auth_w" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	<a class="btn_big" href="#"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>(<input type="checkbox" name="autoReg" id="autoReg" value="Y" checked><?=$LNG_TRANS_CHAR["PW00084"] //계속등록?>)
</div>
