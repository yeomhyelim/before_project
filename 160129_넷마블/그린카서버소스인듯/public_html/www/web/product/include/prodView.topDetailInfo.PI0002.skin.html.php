<?
if(!$g_member_no)
{
	$loginCheck = "javascript:loginCheck();";
}
else
{
	$loginCheck = "javascript:popProdInquiry({$strP_CODE});";
}
?>
<script type="text/javascript">
	<!--
	$( document ).ready(function() {

		<? if($strViewList){?>
		C_getTabChange('tab','2');
		C_getTabChange('comProd','2');
		<?
		}
		else
		{
			if($strComView){
			?>
		C_getTabChange('tab','2');
		C_getTabChange('comProd','1');
		<?
        }else{
        ?>
		//goTabChange('tab','1');
		//goTabChange('prodDetail','1');
		C_getTabChange('tab','1');
		C_getTabChange('prodDetail','1');
		<?
			}
		}
		?>
	});
	function pop_alert(strMsg){
		alert(strMsg);
	}

	function loginCheck(pCode){
		alert('로그인후 이용가능합니다.');
		location.href="./?menuType=member&mode=login";
	}

	//-->
</script>
<??>
<input type="hidden" id="prodCompare" name="prodCompare" value="<?=$strProdCompareCookie;?>">
<div class="prodTopAreaView">
	<h2>
		<?=$strP_NAME?>
		<? $icon = explode("/", $prodRow['P_LIST_ICON']);
		for($x=0;$x<sizeof($icon);$x++):
			//if(in_array($x, $icon)) { $iconTag .= $S_ARY_PRODUCT_LIST_ICON[$x]; };
			$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
		endfor;
		if($iconTag) { echo "<span class=\"prodIcon\">{$iconTag}</span"; }
		?>
	</h2>
	<div class="locationWrap">
		<ul>
			<li class="home">H</li>
			<li><a href="./?menuType=product&mode=list&lcate=<?=$strSearchHCode1?>&mcate=&scate="><?php echo $strSearchHCodeName1;?></a></li>
			<li><a href="./?menuType=product&mode=list&lcate=<?=$strSearchHCode1?>&mcate=<?=$strSearchHCode2?>&scate="><?php echo $strSearchHCodeName2;?></a></li>
			<li class="end"><a href="./?menuType=product&mode=list&lcate=<?=$strSearchHCode1?>&mcate=<?=$strSearchHCode2?>&scate=<?=$strSearchHCode3?>"><?php echo $strSearchHCodeName3;?></a><?//=$strP_NAME?></li>
		</ul>
	</div>
	<div class="clr"></div>
</div>
<div class="clr"></div>
<?php
## 상품 이미지 include 파일 설정
$strProductViewImageSkinFile = MALL_HOME .  "/web/product/include/prodView.MultyImage.index.inc.php";
if($S_PRODUCT_VIEW_IMAGE_SKIN) { $strProductViewImageSkinFile =  MALL_HOME . "/web/product/skin/prodView.image.{$S_PRODUCT_VIEW_IMAGE_SKIN}.php"; }
?>

<div class="tabProdWrap">
	<a class="btn1 on" href="#;" onclick="C_getTabChange('tab','1')" id="btn-tab1"><?=$LNG_TRANS_CHAR["PW00088"] //제품정보?></a>
	<a class="btn2" href="#;" onclick="C_getTabChange('tab','2')" id="btn-tab2"><?=$LNG_TRANS_CHAR["PW00089"] //회사소개?></a>
</div>
<div class="list" id="tab1">
	<div class="prodDetailWrap">
		<div class="prodDetail" >
			<div class="detailImg">
				<?php include $strProductViewImageSkinFile; ?>
			</div>

			<div class="detailInfo">
				<div class="infoTableWrap">
					<table class="infoTable">
						<!--<tr class="titleInfoRow">
							<th></th>
							<td class="titleWrap">
								<?=$prodRow[P_NAME]?>
								<? $icon = explode("/", $prodRow['P_LIST_ICON']);
						for($x=0;$x<sizeof($icon);$x++):
							//if(in_array($x, $icon)) { $iconTag .= $S_ARY_PRODUCT_LIST_ICON[$x]; };
							$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
						endfor;
						if($iconTag) { echo "<span class=\"prodIcon\">{$iconTag}</span"; }
						?>
							</td>
						</tr>-->
						<?if($strShow2=="Y" && $prodRow[P_ETC]):?>
							<tr>
								<th colspan="2" class="viewCommentWrap"><span class="viewComment"><?=$prodRow[P_ETC]?></span></th>
							</tr>
						<?endif;?>
						<?if ($strP_ORIGIN){?>
							<tr class="originRow">
								<th><?=$LNG_TRANS_CHAR["PW00028"] //원산지?></th>
								<td><?=$aryCountryList[$strP_ORIGIN]?></td>
							</tr>
						<?}?>
						<?if ($strP_CATE){?>
							<tr class="originRow">
								<th><?=$LNG_TRANS_CHAR["CW00064"] //카테고리?></th>
								<td><?=$strSearchHCodeName1?></td>
							</tr>
						<?}?>
						<?php if(!$isPriceHide){?>
							<?if ($strP_CONSUMER_PRICE > 0 && $strP_CONSUMER_PRICE != $intP_SALE_PRICE){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["PW00002"] //소비자가?></th>
									<td>
										<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
											<s class="priceOrg">
												<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($strP_CONSUMER_PRICE)?> / <?=getCurMark("$")?><?=getCurToPrice($strP_CONSUMER_PRICE,"US")?><?=getCurMark2("USD")?>
											</s>
										<?}else{?>
											<?=$strMoneyIconL?><s class="priceOrg"><?=getCurToPrice($strP_CONSUMER_PRICE)?><?=$strMoneyIconR?></s>
										<?}?>
									</td>
								</tr>
							<?}?>
							<tr class="realPriceRow">
								<th><?if($S_PRODUCT_RENT == "Y" && $strP_STOCK_PRICE != "1" ){echo $LNG_TRANS_CHAR["PW00003"]; }else{echo $LNG_TRANS_CHAR["PW00004"];} //임대가/판매가?></th>
								<td class="realPayPriceInfo">

									<?if($prodRow[P_PRICE_TEXT]){ // 가격대체문구 ?>
										<span class="priceText"><?=$prodRow[P_PRICE_TEXT]?></span>
									<?}else{?>
									<!-- 이벤트 -->
									<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?>
									<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
									<s>
										<?=$S_SITE_CUR_MARK1?><s><?=getCurToPrice($intP_SALE_PRICE)?> /
											<strong class="priceOrange _fs14" id="realPayPriceText"><?=getCurMark("USD")?>		<?=getCurToPrice($intP_SALE_PRICE,"US")?></strong><?=getCurMark2("USD")?>
										</s>
										<?}else{?>
											<s>
												<strong class="priceOrange _fs14" id="realPayPriceText"><?=$strMoneyIconL?> <?=getCurToPrice($intP_SALE_PRICE)?></strong><?=$strMoneyIconR?>
											</s>
										<?}?>

										<?}else{?>
											<?/*if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
												<strong class="priceOrange _fs14"><?=$S_SITE_CUR_MARK1?><?=getProdDiscountPrice($prodRow)?></strong> /
												<strong id="realPayPriceText"><?=getCurMark("$")?><?=getProdDiscountPrice($prodRow,"1",0,"US")?></strong><?=getCurMark2("USD")?>dddd
											<?}else{*/?>
												<strong class="priceOrange _fs14" id="realPayPriceText" style="color:red">
													<?
													$strTextPrice = $strP_PRICE_FILTER;
													$strTextPrice .= ' ' .getCurMarkFilter($strP_PRICE_FILTER, $S_SITE_LNG). getCurToPriceFilter($intP_SALE_PRICE,'','',$strP_PRICE_FILTER);
													if($S_SITE_LNG == 'CN'){
														$strTextPrice .= ' (' .getCurMarkFilter($strP_PRICE_FILTER, 'US'). getCurToPriceFilter($intP_SALE_PRICE,'US','',$strP_PRICE_FILTER).')' ;
													}
													echo $strTextPrice;
													?>
													<? if($strP_PRICE_UNIT){?>	/ <?= $strP_PRICE_UNIT ?>	<!-- (1<?=$strP_PRICE_UNIT?> 당) --> <?}?>
												</strong>
											<?//}?>
										<?}?>
										<?}?>
								</td>
							</tr>

							<!-- 이벤트가 -->
							<?if ($strP_EVENT > 0 && getProdEventInfo($prodRow) == "Y"){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["PW00005"] //특별할인가?></th>
									<td>
										<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
											<strong class="priceOrange _fs14"><?=$S_SITE_CUR_MARK1?><?=getProdDiscountPrice($prodRow)?></strong> /
											<strong id="realPayPriceTaxText"><?=getCurMark("$")?><?=getProdDiscountPrice($prodRow,"1",0,"US")?></strong><?=getCurMark2("USD")?>

										<?}else{?>
											<strong class="priceOrange _fs14" id="realPayPriceTaxText"><?=$strMoneyIconL?><?=getProdDiscountPrice($prodRow)?></strong><?=$strMoneyIconR?>
										<?}?>
										<?=$S_EVENT_INFO[$strP_EVENT]["PRICE_TEXT"][$S_SITE_LNG]?>
									</td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["PW00047"] //할인기간?></th>
									<td><?=SUBSTR($S_EVENT_INFO[$prodRow['P_EVENT']]["START_DT"],0,10)?> ~ <?=SUBSTR($S_EVENT_INFO[$strP_EVENT]["END_DT"],0,10)?></td>
								</tr>
							<?}?>

							<!-- 포인트 -->
							<?if ($intProdPoint > 0 && $strProdPointViewSpecGroupYN == "Y"){?>
								<tr class="pointInfoRow">
									<th><?=$LNG_TRANS_CHAR["OW00065"] //포인트?></th>
									<td><?=getFormatPrice($intProdPoint,2)?> <?=$LNG_TRANS_CHAR["PW00008"] //포인트?></td>
								</tr>
							<?}?>

							<!-- 할인율 -->
							<?if ($intProdDiscountRate > 0 && $strProdDiscountRateText){?>
								<tr class="discountRateRow">
									<th><?=$LNG_TRANS_CHAR["PW00051"] //할인율?></th>
									<td><div  class="discount"><?php echo $strProdDiscountRateText; // 할인율?></div></td>
								</tr>
							<?}?>
						<?php }?>
					</table>
					<!-- end: infoTable -->

					<!-- start: infoTable_2 -->
					<?
					if ($S_FIX_PROD_BASIC_ITEM_USE == "Y"){
						include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/html/prodView.topDetailInfo.{$S_PRODUCT_VIEW_IMAGE_DESIGN}.user.skin.html.php";
					}else{?>
						<table class="infoTable_2">
							<?/*
								if ($prodRow["P_MAKER"]){?>
								<tr class="makerRow">
									<th><?=$LNG_TRANS_CHAR["PW00026"] //제조사?></th>
									<td><?=$prodRow[P_MAKER]?></td>
								</tr>
								<?}
								*/?>
							<?if ($strP_BRAND_NAME){?>
								<tr class="brandRow">
									<th><?=$LNG_TRANS_CHAR["PW00027"] //브랜드?></th>
									<td><?=$strP_BRAND_NAME?></td>
								</tr>
							<?}?>
							<?if ($strP_MODEL){?>
								<tr class="modelRow">
									<th><?=$LNG_TRANS_CHAR["PW00029"] //모델?></th>
									<td><?=$strP_MODEL?></td>
								</tr>
							<?}?>
							<?if ($strP_MIN_QTY){?>
								<tr class="modelRow">
									<th><?=$LNG_TRANS_CHAR["PW00090"] //최소구매수량?></th>
									<td><?=$strP_MIN_QTY?> <?=$strP_SAIL_UNIT;?></td>
								</tr>
							<?}?>
							<?if ($strP_CAS_NO){?>
								<tr class="modelRow">
									<th>CAS No</th>
									<td><?=$strP_CAS_NO?></td>
								</tr>
							<?}?>

							<?if ($strP_OTHER_NAMES){?>
								<tr class="modelRow">
									<th>Other Names</th>
									<td><?=$strP_OTHER_NAMES?></td>
								</tr>
							<?}?>
						</table>
					<?}?>
					<!-- end: infoTable_2 -->
					<!-- start: optTable_1 -->
					<?
					if ($strP_OPT == "1" || $strP_OPT == "3"){
						echo "<table class=\"optTable_1\">";
						/* 다중가격사용안함 */

						if (is_array($aryProdOpt)){
							for($i=0;$i<sizeof($aryProdOpt);$i++){
								$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
								for($kk=1;$kk<=10;$kk++){
									if ($aryProdOpt[$i]["PO_NAME".$kk]){
										?>
										<tr class="optionInfoRow">
											<th><?=$aryProdOpt[$i]["PO_NAME".$kk]?></th>
											<td>
												<select id="cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>" name="cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>"  onchange="javascript:goSelectProdOpt('cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>',<?=$kk?>);">
													<option value="">:: <?=($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"]; //필수선택:선택?> ::</option>
													<?
													if ($aryProdOpt[$i]["OPT_ATTR".$kk]){
														for($j=0;$j<sizeof($aryProdOpt[$i]["OPT_ATTR".$kk]);$j++){
															## 품절표시
															$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'].")" : "";
															if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
															?>
															<option value="<?=$aryProdOpt[$i]["OPT_ATTR".$kk][$j][POA_ATTR1]?>"><?=$aryProdOpt[$i]["OPT_ATTR".$kk][$j][POA_ATTR1]?><?=$strProdOptAttrSoldOut?></option>
															<?
														} //->for
													} //->if
													?>
												</select>
											</td>
										</tr>
										<?
									} //->if
								} //->for
							} //->for
						} //->if

					} else if ($strP_OPT == "2") {
						/* 다중가격일체형 */

						if (is_array($aryProdOpt)){

							for($i=0;$i<sizeof($aryProdOpt);$i++){
								?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["PW00010"] //옵션선택?></th>
									<td>
										<select id="cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>" name="cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>" onchange="javascript:goSelectProdOpt('cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>');">
											<option value="">:: <?=($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"]; //필수선택:선택?> ::</option>
											<?
											if (is_array($aryProdOpt[$i][OPT_ATTR_ALL])){
												for($j=0;$j<sizeof($aryProdOpt[$i][OPT_ATTR_ALL]);$j++){

													$strProdOptAttr = "";
													for($kk=1;$kk<=10;$kk++){
														if ($aryProdOpt[$i]["PO_NAME".$kk]){
															$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][$j]["POA_ATTR".$kk];
														}
													}

													$strProdOptAttr = SUBSTR($strProdOptAttr,1);

													## 품절표시
													$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'].")" : "";
													if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
													?>
													<option value="<?=$aryProdOpt[$i][OPT_ATTR_ALL][$j][POA_NO]?>"><?=$strProdOptAttr?><?=$strProdOptAttrSoldOut?></option>
												<?		}
											}
											?>
										</select>
									</td>
								</tr>
								<?
							}

						}
					}
					/* 추가옵션관리 */
					if ($prodRow[P_ADD_OPT] == "Y" && is_array($aryProdAddOpt)){
						for($i=0;$i<sizeof($aryProdAddOpt);$i++){
							?>
							<tr>
								<th><?=$aryProdAddOpt[$i][PO_NAME1]?></th>
								<td>
									<select id="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>" name="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>"  onchange="javascript:goSelectProdAddOpt(this,<?=$aryProdAddOpt[$i][PO_NO]?>);">
										<option value="">:: <?=($aryProdAddOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"];?> ::</option>
										<?for($j=0;$j<sizeof($aryProdAddOpt[$i][OPT_ATTR]);$j++){?>
											<option value="<?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NO]?>"><?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NAME]?></option>
										<?}?>
									</select>
								</td>
							</tr>
							<?
						}
					}
					?>


					<?
					//FOB 일때는 배송비 안보이게 처리 2015.05.20
					if($strP_PRICE_FILTER == 'EXW')
					{
						if (($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)) || ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH != "W"))
						{
							if ($strP_BAESONG_TYPE == "1")
							{
								$intShopDeliveryStPrice = $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"];
								if ($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S')
								{
									$intShopDeliveryStPrice = $prodShopInfo['SH_COM_DELIVERY_ST_PRICE'];
								}

								if ($intShopDeliveryStPrice > 0)
								{
									if (($intP_SALE_PRICE > $intShopDeliveryStPrice))
									{
										?>
										<tr class="deliveryFreeInfoRow">
											<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
											<td><?=$LNG_TRANS_CHAR["PW00013"] //무료?></td>
										</tr>
										<?
									}
									else
									{
										?>

										<tr class="deliveryPriceInfoRow">
											<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
											<td><?=($intSH_NO > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S' ) ? getCurToPrice($strSH_COM_DELIVERY_PRICE) : getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"]);?>원</td>
										</tr>
										<tr class="deliveryConditionInfoRow">
											<th><?=$LNG_TRANS_CHAR["PW00014"] //배송비무료조건?></th>
											<td>
												<?=$strFreeDeliveryCondition?>
											</td>
										</tr>
										<?if(!$S_DELIVERY_PAY_TYPE):?>
										<tr class="deliveryPayInfoRow">
											<th><?=$LNG_TRANS_CHAR["PW00015"] //배송비결제여부?></th>
											<td>
												<select id="cartDelivery" name="cartDelivery">
													<option value="1">::<?=$strDeliveryOrder?> ::</option>
													<option value="2">::<?=$LNG_TRANS_CHAR["PS00005"]?> ::</option>
												</select>
											</td>
										</tr>
									<?endif;?>


										<!--<tr>
                                            <th>예외지역배송</th>
                                            <td><input type="checkbox" id="cartDeliveryExp" name="cartDeliveryExp" value="Y"></td>
                                            (* 예외지역 배송일 경우 체크)
                                        </tr>//-->
									<?				}
								}
							}
							else if ($strP_BAESONG_TYPE == "2")
							{
								if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH != "G"){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
										<td><?=$LNG_TRANS_CHAR["PW00016"] //무료배송?></td>
									</tr>
								<?			}
							} else if ($strP_BAESONG_TYPE == "3"){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
									<td><?=$LNG_TRANS_CHAR["PW00017"] //고정 배송비?> <?=getCurToPrice($intP_BAESONG_PRICE)?><?=getCurMark2()?></td>
								</tr>
							<?		} else if ($strP_BAESONG_TYPE == "4"){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
									<td><?=$LNG_TRANS_CHAR["PW00018"] //수량별 배송?> <?=getCurToPrice($intP_BAESONG_PRICE)?><?=getCurMark2()?></td>
								</tr>
							<?		} else if ($strP_BAESONG_TYPE == "5"){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
									<td>
										<?=$strProdDeliveryAfter;?>
									</td>
								</tr>
							<?		}
						}
						else
						{
							?>
							<!--<tr>
							<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
							<td>배송비 설명 페이지 링크</td>
						</tr>//-->
							<?
						}
					}
					?>

					<!-- 상품 항목 설명 -->
					<?
					if ($S_FIX_PROD_BASIC_ITEM_USE != "Y")
					{
						if (is_array($aryProdItem))
						{
							for($i=0;$i<sizeof($aryProdItem);$i++)
							{
								$strProdItemType		= (!$aryProdItem[$i][PI_TYPE]) ? "B":$aryProdItem[$i][PI_TYPE];
								$arrProdItemTypeText	= explode(";",$aryProdItem[$i][PI_TEXT]);
								?>
								<tr>
									<th><?=$aryProdItem[$i][PI_NAME]?></th>
									<td>
										<?if(!$strProdItemType || ($strProdItemType == "B")){?>
											<?=$aryProdItem[$i][PI_TEXT]?>
										<?}elseif($strProdItemType == "C"){?>
											<?=drawCheckBox("cartAddItem".$aryProdItem[$i][PI_NO],$arrProdItemTypeText,"","",false, "&nbsp;", $colCnt=0,$onclick="")?>
										<?}elseif($strProdItemType == "S"){?>
											<?=drawSelectBox("cartAddItem".$aryProdItem[$i][PI_NO],$arrProdItemTypeText,"","","",$etc="",$firstItem="",$firstItemValue="")?>
										<?}elseif($strProdItemType == "R"){?>
											<?=drawRadioBox("cartAddItem".$aryProdItem[$i][PI_NO],$arrProdItemTypeText,"","",false, $gap="&nbsp;", $colCnt=0, $etc="",$onchange="")?>
										<?}else{?>
											<input type="text" name="cartAddItem<?=$aryProdItem[$i][PI_NO]?>"  id="cartAddItem<?=$aryProdItem[$i][PI_NO]?>" value="" maxlength="100"
												<?=($strProdItemType == "D")?"data-simple-datepicker-check readonly":"";?>>
										<?}?>

									</td>
								</tr>
								<?
							}
						}
					}
					?>
					<!-- 상품 항목 설명 -->
					<? if ( count( $aryProdOpt ) > 0 || ( ( $prodRow['P_QTY'] > 0 || $prodRow['P_STOCK_LIMIT'] == 'Y' ) && $prodRow['P_STOCK_OUT'] != 'Y' ) ) : ?>
					<?else:?>
						<tr>
							<th class="prodCntSelect"><?=$LNG_TRANS_CHAR["PW00019"] //구매수량?></th>
							<td class="prodCntSelect">
								<span class="soldoutTxt"><?=$LNG_TRANS_CHAR['PW00041'] // 품절 ?></span>
							</td>
						</tr>
					<?endif;?>
					</table>
				</div><!-- infoTableWrap //-->
				<div class="shopSumInfo">
					<table class="shopInfoTable">
						<tr>
							<th><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></th>
							<td><?=$strSH_COM_NAME?></td>
						</tr>
						<tr>
							<th><?= $LNG_TRANS_CHAR["MW00021"]; //국가 ?></th>
							<td><?=$aryCountryList[$strSH_COM_COUNTRY];?></td>
						</tr>
						<tr>
							<th>TYPE</th>
							<td><?=$aryType[$strP_TYPE];?></td>
						</tr>
						<tr>
							<th><?= $LNG_TRANS_CHAR["SW00040"]; //웹사이트 ?></th>
							<td><a onclick="javascript:window.open('http://<?=$strSH_COM_SITE;?>')" ><?=$strSH_COM_SITE;?></a></td>
						</tr>
					</table>
					<div class="shopIcoWrap">
						<table class="shopIcoTable">
							<tr>
								<th><?= $LNG_TRANS_CHAR["PW00083"]; //등급 ?></th>
								<td>
									<img src="<?=$strSH_COM_CREDIT_GRADE_IMG;?>">
									<img src="<?=$strSH_COM_SALE_GRADE_IMG;?>">
									<img src="<?=$strSH_COM_LOCUS_GRADE_IMG;?>">
								</td>
							</tr>
						</table>
					</div>
				</div><!-- (4) shopSumInfo //-->
				<div class="clr"></div>
				<!-- start: 상품금액 -->
				<div class="totPirceInfoWrap">
					<div class="totPirceInfoBox">
						<?php if(!$isPriceHide){?>
							<?if(($strP_QTY > 0 || $strP_STOCK_LIMIT == "Y") && $strP_STOCK_OUT != "Y" && !is_array($aryProdOpt)){?>
								<div class="optionValueWrap" id="divSelectOpt">
									<div id="divCartOptAttr_0" class="optionWrap">
										<input type="hidden" name="cartOptNo[]" value="0">
										<?
										if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")
										{
											?>
											<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="<?if ($strP_EVENT > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($intP_SALE_PRICE,"US")?><?}else{?><?=getProdDiscountPrice($prodRow,"1",0,"US")?><?}?>">
											<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="<?if ($strP_EVENT > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($intP_SALE_PRICE)?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>">
											<?
										}
										else
										{
											?>
											<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="<?if ($strP_EVENT > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($intP_SALE_PRICE)?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>">
											<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="0">
											<?
										}
										?>
										<table>
											<tr>
												<td class="optTit"><?=$LNG_TRANS_CHAR["PW00019"] //구매수량?></td>
												<td class="cntWrap">
													<a href="javascript:goProdViewQtyChange(0,'down',1);" class="btnDown">-</a>
													<input type="input" id="0_cartQty" name="0_cartQty" value="<?=$strP_MIN_QTY?>" class="i_wCnt"/>
													<a href="javascript:goProdViewQtyChange(0,'up',1);" class="btnUp">+</a>
												</td>
												<td class="optPrice">
													<?if($strProdSaleOrgTotalPrice){?>
														<strong id="0_cartOptOrgPriceMark"><?=$strProdSaleTotalOrgPriceLeftMark?><?=$strProdSaleOrgTotalPrice?><?=$strProdSaleTotalOrgPriceRightMark?></strong> /
													<?}?>
													<strong id="0_cartOptPriceMark"><?=$strProdSaleTotalPriceLeftMark?><?=$strProdSaleTotalPrice?><?=$strMoneyIconR?></strong>
												</td>
											</tr>
										</table>
									</div>
								</div>
								<div class="totalPriceWrap" id="divSelectOptTotalPrice">
									<?=$LNG_TRANS_CHAR["PW00042"]; //총상품금액?>:
									<?if($strProdSaleOrgTotalPrice){?>
										<strong  class="totalPrice"><?=$strProdSaleTotalOrgPriceLeftMark?><?=$strProdSaleOrgTotalPrice?><?=$strProdSaleTotalOrgPriceRightMark?></strong> /
									<?}?>
									<strong id="cartOptTotalPrice" class="totalPrice"><?=$strProdSaleTotalPriceLeftMark?><?=$strProdSaleTotalPrice?></strong><strong class="totalPriceTxt"><?=$strMoneyIconR?></strong>
								</div>
								<div class="clr"></div>
							<?}else{?>
								<div class="optionValueWrap" id="divSelectOpt"></div>
								<div class="totalPriceWrap" id="divSelectOptTotalPrice"></div>
							<?}?>
							<?if($S_DELIVERY_PAY_TYPE){?>
								<?$cartDeliveryValue = 1; if($S_DELIVERY_PAY_TYPE == "selfPay") { $cartDeliveryValue = 2; } ?>
								<input type="hidden" name="cartDelivery" value="<?=$cartDeliveryValue?>">
							<?}?>
						<?php }?>
					</div>
					<!-- end: 상품금액 -->
				</div>
			</div><!-- (3) detailInfo //-->
			<div class="clr"></div>
		</div><!-- (2) prodDetail //-->
		<div class="clr"></div>
	</div><!-- (1) prodDetailWrap //-->
	<div class="clr"></div>
	<!-- start: 구매버튼 -->
	<div class="orderBtnWrap">

		<?
		if($strP_PRICE_FILTER == 'EXW')
		{
			?>
			<a href="javascript:goCart();" class="btnProdWish_new"  <?=$strLogBasketBtnEvent?>><span><?=$LNG_TRANS_CHAR["PW00022"] //장바구니?></span></a>
			<a href="javascript:goWish();" class="btnProdWish_new"><span><?=$LNG_TRANS_CHAR["PW00023"] //담아두기?></span></a>
			<a href="javascript:goCartOrder();" class="btnProdBuy_new" <?=$strLogOrderBtnEvent?>><span><?=$LNG_TRANS_CHAR["PW00021"] //상품구매?></span></a>
		<?}?>
		<a href="<?=$loginCheck?>" class="btn_red"  <?=$strLogBasketBtnEvent?>><span><?=$LNG_TRANS_CHAR["PW00091"] //문의하기?></span></a>
	</div>
	<!-- start: 구매버튼 -->
	<!-- 상품 탑 상세정보 -->
	<?php $select='detail'; include MALL_HOME . "/web/product/include/tabMenu.inc.php";?>
	<div class="detailInfoArea">
		<div class="detailArea" id="prodDetail1" style="display:block;">
			<!--<h3><?php echo $LNG_TRANS_CHAR["OW00001"]; //상세정보?></h3>-->
			<div class="mt20">
				<?=$prodRow['P_WEB_TEXT']?>
				<?
				//상품 안내용 첨부파일 추가. 남덕희
				for($i=1;$i<=3;$i++)
				{
					$productMgr->setP_CODE($strP_CODE);
					$productMgr->setPM_TYPE("file".$i);
					$aryProdFile[$i] = $productMgr->getProdImg($db);
				}

				for($z=1;$z<=3;$z++){
					if (is_array($aryProdFile[$z]) && $aryProdFile[$z][0]['PM_NO'] > 0){
						?>
						<?=$LNG_TRANS_CHAR["CW00058"] //첨부파일?>
						: <a href="./?menuType=popup&mode=prodFileDown&no=<?=$aryProdFile[$z][0]['PM_NO']?>"><?=$aryProdFile[$z][0]['PM_SAVE_NAME']?></a>
					<?}?><br>
				<?}?>

			</div>
		</div>
	</div>

	<!-- 배송안내/교환반품 //-->
	<?php if($strProdDeliveryText):?>
		<div class="prodDetailDelivery" id="prodDetail2" style="display:none">
			<!--<h3><?php echo $LNG_TRANS_CHAR["CW00032"]; //배송&교환반품안내?></h3>-->
			<div class="txtInfo">
				<?php echo $strProdDeliveryText;?>
			</div>
			<div class="txtInfo">
				<?php echo $strProdReturnText;?>
			</div>
		</div>
	<?php endif;?>
	<!-- 배송안내/교환반품 //-->
</div>

</div><!-- TAB 1 //-->


<!-- start: 회사소개 -->
<div class="list companyInfoListBox" id="tab2">
	<div class="companySumInfo">
		<div class="infoWrap">
			<h2><?=$strSH_COM_NAME?></h2>

			<div class="photo left">
				<img src="<?=$sh_file4?>" style="width:210px;height:200px">
			</div>

			<div class="artcleWra right">
				<h3><?=$strSH_COM_INTRO1?></h3>
				<div class="artcle">
					<?=strHanCutUtf2($strSH_COM_INTRO2,350);?>
				</div>
			</div>
			<div class="clr"></div>
		</div>
		<div class="shopSumInfo">
			<table class="shopInfoTable">
				<tr>
					<th><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></th>
					<td><?=$strSH_COM_NAME?></td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["MW00021"]; //국가 ?></th>
					<td><?=$aryCountryList[$strSH_COM_COUNTRY];?></td>
				</tr>
				<tr>
					<th>TYPE</th>
					<td><?=$aryType[$strSH_COM_CATEGORY];?></td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00040"]; //웹사이트 ?></th>
					<td><a onclick="javascript:window.open('http://<?=$strSH_COM_SITE;?>')" ><?=$strSH_COM_SITE?></a></td>
				</tr>
			</table>
			<div class="shopIcoWrap">
				<table class="shopIcoTable">
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00083"]; //등급 ?></th>
						<td>
							<img src="<?=$strSH_COM_CREDIT_GRADE_IMG;?>">
							<img src="<?=$strSH_COM_SALE_GRADE_IMG;?>">
							<img src="<?=$strSH_COM_LOCUS_GRADE_IMG;?>">
						</td>
					</tr>
				</table>
			</div>
			<div class="btnWrap">
				<a href="<?=$loginCheck?>" class="btn_red"><?=$LNG_TRANS_CHAR["PW00091"] //문의하기?></a>
			</div>
		</div><!-- (4) shopSumInfo //-->
		<div class="clr"></div>
	</div><!-- (1) companySumInfo //-->

	<div class="tabBox">
		<a href="#;" onclick="C_getTabChange('comProd','1')" id="btn-comProd1" class="on btn1" ><?=$LNG_TRANS_CHAR["PW00092"]; //회사정보 ?></a> |
		<a href="#;" onclick="C_getTabChange('comProd','2')" id="btn-comProd2" class="btn2"><?=$LNG_TRANS_CHAR["PW00088"]; //제품정보 ?></a>
	</div>
	<div class="bg_gray" id="comProd1" style="display:block;">
		<div class="companyInfo_1">

			<div class="infoTableWrap">
				<table class="comInfoTable">
					<tr>
						<th><?= $LNG_TRANS_CHAR["MW00021"]; //국가 ?></th>
						<td><?=$aryCountryList[$strSH_COM_COUNTRY];?></td>
						<th>Type</th>
						<td><?=$aryType[$strSH_COM_CATEGORY];?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></th>
						<td><?=$strSH_COM_NAME?></td>
						<th><?= $LNG_TRANS_CHAR["MW00064"]; //대표자 ?></th>
						<td><?=$strSH_COM_REP_NM;?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00007"]; //대표전화 ?></th>
						<td><?=$strSH_COM_PHONE?></td>
						<th><?= $LNG_TRANS_CHAR["SW00008"]; //대표팩스 ?></th>
						<td><?=$strSH_COM_FAX?></td>
					</tr>
					<tr>
						<th>E-mail</th>
						<td><?=$strSH_COM_MAIL?></td>
						<th><?= $LNG_TRANS_CHAR["SW00012"]; //사업자번호 ?></th>
						<td><?=$strSH_COM_NUM?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00015"]; //회사주소 ?></th>
						<td colspan="3"><?=$strSH_COM_ADDR?></td>
					</tr>
				</table>
			</div>
			<div class="clr"></div>
		</div>

		<div class="companyInfo_tb">
			<table class="comInfoTable">
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00040"]; //웹사이트 ?></th>
					<td><a onclick="javascript:window.open('http://<?=$strSH_COM_SITE;?>')" ><?=$strSH_COM_SITE ; ?></a>
					</td>
					<th><?= $LNG_TRANS_CHAR["SW00041"]; //설립연도 ?></th>
					<td><?=$strSH_COM_FOUNDED?><?= $LNG_TRANS_CHAR["CW00010"]; //년 ?></td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00042"]; //직원수 ?></th>
					<td><?=number_format($strSH_COM_NUMBER);?><?= $LNG_TRANS_CHAR["SW00058"]; //명 ?></td>
					<th><?= $LNG_TRANS_CHAR["SW00043"]; //연간 총 매출액 ?></th>
					<td><?=$strSH_COM_TOTAL_SALE;?></td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00044"]; //수출비율 ?></th>
					<td><?=$strSH_COM_RATE?> %</td>
					<th><?= $LNG_TRANS_CHAR["SW00045"]; //연간 총 생산량 ?></th>
					<td><?=$strSH_COM_TOTAL_PRODUCTION;?></td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00046"]; //주요 유통 시장 ?></th>
					<td colspan="3"><span class="graphImg">
					<?
					for($i=1;$i <= $aryEntryCnt ; $i++){
						?>
						<ul>
							<li><?php echo $aryEntry["SH_COM_COUNTRY{$i}"];?></li>
							<li><?php echo $prodShopInfo["SH_COM_COUNTRY{$i}"];?>%</li>
						</ul>
						<?
					}
					?>

							<!--<img src="/upload/images/graph.jpg">-->



					</span></td>
				<tr/>
			</table>
		</div>

		<!--<div class="companyInfo_2">
			<div class="tit">주요 유통 시장</div>
			<div class="graphWrap">
				<img src="/upload/images/graph.jpg">
			</div>
		</div>-->

		<div class="companyInfo_tb companyInfo_tb2">
			<table class="comInfoTable">
				<colgroup>
					<col/>
					<col width="300"/>
					<col/>
					<col/>
				</colgroup>
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00048"]; //공장위치 ?></th>
					<td><?=$prodShopInfo[SH_COM_LOCAL]?></td>
					<th><?= $LNG_TRANS_CHAR["SW00047"]; //공장크기 ?></th>
					<td><?=$prodShopInfo[SH_COM_SIZE]?>㎡</td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00049"]; //R&D직원수 ?></th>
					<td><?=$prodShopInfo[SH_COM_RD]?><?= $LNG_TRANS_CHAR["SW00058"]; //명 ?></td>
					<th><?= $LNG_TRANS_CHAR["SW00050"]; //Production capacity ?></th>
					<td><?=$prodShopInfo[SH_COM_CATE]?></td>
				</tr>
				<tr>
					<th><?= $LNG_TRANS_CHAR["SW00051"]; //인증서 ?></th>
					<td colspan="3">
						<?if($sh_certificates1):?>
							<div>
								<a href="<?=fileExtCheck($sh_certificates1);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES1]?></a>
								<!--img src="<?=$sh_certificates1?>" style="width:70px;height:70px"-->
							</div>
						<?endif;?>
						<?if($sh_certificates2):?>
							<div>
								<a href="<?=fileExtCheck($sh_certificates2);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES2]?></a>
								<!--img src="<?=$sh_certificates2?>" style="width:70px;height:70px"-->
							</div>
						<?endif;?>
						<?if($sh_certificates3):?>
							<div>
								<a href="<?=fileExtCheck($sh_certificates3);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES3]?></a>
								<!--img src="<?=$sh_certificates3?>" style="width:70px;height:70px"-->
							</div>
						<?endif;?>
						<?if($sh_certificates4):?>
							<div>
								<a href="<?=fileExtCheck($sh_certificates4);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES4]?></a>
								<!--img src="<?=$sh_certificates4?>" style="width:70px;height:70px"-->
							</div>
						<?endif;?>
						<?if($sh_certificates5):?>
							<div>
								<a href="<?=fileExtCheck($sh_certificates5);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES5]?></a>
								<!--img src="<?=$sh_certificates5?>" style="width:70px;height:70px"-->
							</div>
						<?endif;?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?
	$no				= 1;
	// 상품 리스트

	/* 정의 */

	$intHList=5;
	$intWList = 2;

	if (!$intWSize) $intWSize 			= $S_PRODLIST_IMG_SIZE_W;
	if (!$intHSize) $intHSize			= $S_PRODLIST_IMG_SIZE_H;
	if (!$intWList) $intWList 			= $S_PRODLIST_IMG_VIEW_W;
	if (!$intHList) $intHList			= $S_PRODLIST_IMG_VIEW_H;
	$strWAlign							= $S_PRODLIST_WORD_ALIGN;
	$strMoney							= $S_PRODLIST_MONEY_TYPE;
	$strMoneyIcon						= $S_PRODLIST_MONEY_ICON;
	$strShow1							= $S_PRODLIST_SHOW_1;
	$strShow2							= $S_PRODLIST_SHOW_2;
	$strShow3							= $S_PRODLIST_SHOW_3;
	$strShow4							= $S_PRODLIST_SHOW_4;
	$strShow5							= $S_PRODLIST_SHOW_5;
	$strShow6							= $S_PRODLIST_SHOW_6;
	$strShow7							= $S_PRODLIST_SHOW_7;
	$strShow8							= $S_PRODLIST_SHOW_8;
	$strColor1							= $S_PRODLIST_COLOR_1;
	$strColor2							= $S_PRODLIST_COLOR_2;
	$strColor3							= $S_PRODLIST_COLOR_3;
	$strColor4							= $S_PRODLIST_COLOR_4;
	$strColor5							= $S_PRODLIST_COLOR_5;
	$strTitleShow						= $S_PRODLIST_TITLE_SHOW_USE;
	$strTitleFile						= $S_PRODLIST_TITLE_FILE_NAME;
	$strNaviUse							= $S_PRODUCT_NAVI_USE_OP;
	$intTitleMaxsize					= $S_PRODLIST_TITLE_MAXSIZE;

	$viewProductMgr = new ProductMgr();
	$listDataParam	 = "";

	$viewProductMgr->setP_SHOP_NO($prodRow[P_SHOP_NO]);
	$viewProductMgr->setSearchWebView('Y');

	//웹 보임 상품만 출력 추가. 남덕희
	$viewProductMgr->setP_WEB_VIEW('Y');

	//카테고리
	$cateMgr -> setC_LEVEL('1');
	$cateMgr -> setCL_VIEW_YN('Y');
	$aryCategorys = $cateMgr -> getCateLevelAry($db);
	//PRINT_R($aryCategorys);
	$aryCateNames = array();
	for($i = 0; $i < sizeof($aryCategorys); $i++){
		$aryCateNames[$aryCategorys[$i][CATE_CODE]] = $aryCategorys[$i][CATE_NAME];
	}


	//카테고리 sort용
	for($i = 0; $i < sizeof($aryCategorys); $i++){
		$aryCateTotal[$i] = $aryCategorys[$i][CATE_CODE];
	}
	//카테고리 순서 정렬
	sort($aryCateTotal);

	//카테고리별 임의 정렬 값
	$listDataParam['SELECT_CATE'] = $strSearchHCode1;
	$listDataParam['CATE_ORDER_BY'] = $aryCateTotal;
	//PRINT_R($aryCateNames);

	/* 데이터 리스트 */
	$intTotal	= $viewProductMgr->getProdTotal($db,$strMode,$listDataParam);
	//echo $db->query;
	$intPageLine							= $intWList * $intHList;															// 리스트 개수
	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
	$viewProductMgr->setLimitFirst( $intFirst );
	if ($strProdListAllView == "Y") $viewProductMgr->setPageLine( $intTotal );
	else $viewProductMgr->setPageLine( $intPageLine );

	$result = $viewProductMgr->getProdList($db,$strMode,$listDataParam);

	$intPageBlock					= 10;															// 블럭 개수
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );				// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );
	/* 데이터 리스트 */


	$aryProdShopCateCount = $viewProductMgr -> getProdShopCateGroup($db);

	$aryProdCount = array();
	$intProdCountTotal = 0;
	for($i = 0; $i < sizeof($aryProdShopCateCount); $i++){
		$aryProdCount[$aryProdShopCateCount[$i][P_LCATE]] = $aryProdShopCateCount[$i][P_CATE_COUNT];
		$intProdCountTotal += $aryProdShopCateCount[$i][P_CATE_COUNT];
	}


	$row = array();
	while ( $_row = mysql_fetch_array($result) ) {
		array_push($row, $_row);
	}
	?>

	<div class="comProdBox" id="comProd2" style="display:none;">
		<?
		if(sizeof($aryCategorys) > 0 ){
			?>
			<div class="comProdInfoTableWrap">
				<div class="comProdCntWrap">
					<!-- 총 <span><?php echo (!$intProdCountTotal) ? 0 : number_format($intProdCountTotal);?></span>개의 제품을 보유하고 있습니다.-->
					<?= callLangTrans($LNG_TRANS_CHAR["MS00160"],array( (!$intProdCountTotal) ? 0 : number_format($intProdCountTotal) )); ?>
				</div>
				<div class="comProdInfoTable">
					<?
					for($i =0; $i<sizeof($aryCategorys);$i++)
					{
						?>
						<div class="prodCntWrap">
							<ul class="prodCnt">
								<li><?=$aryCategorys[$i][CATE_NAME];?></li>
								<li>
									<a href="./?menuType=product&mode=view&lcate=<?=$aryCategorys[$i][CATE_CODE]?>&prodCode=<?=$strP_CODE?>&viewList=Y&page=<?=$intPage?>"><span><?
											if($aryProdCount[$aryCategorys[$i][CATE_CODE]])
											{
												echo $aryProdCount[$aryCategorys[$i][CATE_CODE]];
											}
											else
											{
												echo '0';
											}
											?></span></a><?= $LNG_TRANS_CHAR["PW00020"]; //개 ?>
								</li>
							</ul>
						</div>
						<?
					}
					?>
					<div class="clr"></div>
				</div>
			</div>
		<?}?>

		<div class="prodNewListWrapB">
			<table class="listTypeTable"><!--- class="listTypeTable"-->
				<!--start loop-->
				<?
				for($r=0,$k=0; $r < $intHList; $r++)
				{
					?>
					<tr>
						<?
						for($j=0;$j<$intWList;$j++)
						{
							?>
							<td<? if($j==($intWList-1)) { echo sprintf(" style='width:%dpx'", $intWSize); } ?> class="pInfoBox">
								<?
								$k++;
								$di = $k-1;

								if($row[$di]):

									## 기본 설정
									$strViewP_CODE			= $row[$di]['P_CODE'];
									$strViewP_NAME			= $row[$di]['P_NAME'];
									$intViewP_GRADE			= $row[$di]['P_GRADE'];
									$intViewP_GRADE_CNT		= $row[$di]['P_GRADE_CNT'];
									$strViewP_COLOR			= $row[$di]['P_COLOR'];
									$intViewP_SALE_PRICE	= $row[$di]['P_SALE_PRICE'];
									$intViewP_POINT			= $row[$di]['P_POINT'];
									$strViewP_POINT_TYPE	= $row[$di]['P_POINT_TYPE'];
									$strViewP_POINT_OFF1	= $row[$di]['P_POINT_OFF1'];
									$strViewP_POINT_OFF2	= $row[$di]['P_POINT_OFF2'];
									$strViewPM_REAL_NAME	= $row[$di]['PM_REAL_NAME'];
									$strViewPM_REAL_NAME2	= $row[$di]['PM_REAL_NAME2']; // 이미지2 (마우스 오버시 이미지)
									$strViewP_EVENT			= $row[$di]['P_EVENT'];
									$strViewP_LIST_ICON		= $row[$di]['P_LIST_ICON'];
									$strViewP_COLOR_IMG		= $row[$di]['P_COLOR_IMG'];
									$strViewP_BRAND_NAME	= $row[$di]['P_BRAND_NAME'];
									$strViewP_MODEL			= $row[$di]['P_MODEL'];
									$strViewP_ETC			= $row[$di]['P_ETC'];
									$intViewP_CONSUMER_PRICE = $row[$di]['P_CONSUMER_PRICE'];
									$strViewP_PRICE_TEXT	= $row[$di]['P_PRICE_TEXT'];
									$intViewP_QTY			= $row[$di]['P_QTY']; // 수량
									$strViewP_STOCK_OUT		= $row[$di]['P_STOCK_OUT']; // 품절여부
									$strViewP_RESTOCK		= $row[$di]['P_RESTOCK']; // 재입고여부
									$strViewP_STOCK_LIMIT	= $row[$di]['P_STOCK_LIMIT']; // 무제한상품
									$strViewP_BAESONG_TYPE	= $row[$di]['P_BAESONG_TYPE']; // 배송타입
									$strViewP_MEMO			= $row[$di]['P_MEMO'];

									$strViewP_PRICE_FILTER	= $row[$di]['P_PRICE_FILTER'];
									$strViewP_PRICE_UNIT	= $row[$di]['P_PRICE_UNIT'];
									$strViewP_CAS_NO		= $row[$di]['P_CAS_NO'];
									$strViewP_OTHER_NAMES	= $row[$di]['P_OTHER_NAMES'];
									$strViewP_MIN_QTY		= $row[$di]['P_MIN_QTY'];
									$strViewP_ORIGIN		= $row[$di]['P_ORIGIN'];
									$strViewP_MAX_QTY		= $row[$di]['P_MAX_QTY'];
									//$strSH_COM_NAME			= $row[$di]['SH_COM_NAME'];
									//$strSH_COM_CATEGORY		= $row[$di]['SH_COM_CATEGORY'];
									//$strSH_COM_CREDIT_GRADE = $row[$di]['SH_COM_CREDIT_GRADE'];
									//$strSH_COM_SALE_GRADE	= $row[$di]['SH_COM_SALE_GRADE'];
									//$strSH_COM_LOCUS_GRADE	= $row[$di]['SH_COM_LOCUS_GRADE'];
									//$strSH_COM_COUNTRY		= $row[$di]['SH_COM_COUNTRY'];

									$strP_CATE		= substr($row[$di]['P_CATE'],0,3);


									if ($strSearchHCode1){
										$cateMgr->setC_CODE($strSearchHCode1);
										$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);

										//카테고리별 관련 상품
										//$aryProdCateSellList = $productMgr->getProdCateSellList($db);
									}

									/* 상품 옵션 */
									//$viewProductMgr->setP_LNG($S_SITE_LNG);
									//$cateMgr->setCL_LNG($S_SITE_LNG);

									$viewProductMgr->setP_CODE($strViewP_CODE);
									$viewProductMgr->setPO_TYPE("O");
									$aryViewProdOpt = $viewProductMgr->getProdOpt($db);

									if (is_array($aryViewProdOpt)){
										for($i=0;$i<sizeof($aryViewProdOpt);$i++){
											if ($aryViewProdOpt[$i][PO_NO] > 0){
												$productMgr->setPO_NO($aryViewProdOpt[$i][PO_NO]);

												/* 다중가격사용안함.다중가격분리형 */
												$aryViewProdOpt[$i]["OPT_ATTR1"] = $productMgr->getProdOptAttrGroup($db);

												/* 다중각격분리형 */
												$aryViewProdOpt[$i]["OPT_ATTR_ALL"] = $productMgr->getProdOptAttr($db);
											}
										}
									}

									if ($strP_OPT == "1" || $strP_OPT == "3"){
										/* 다중가격사용안함 */

										if (is_array($aryViewProdOpt)){
											for($i=0;$i<sizeof($aryViewProdOpt);$i++){
												$intProdOptAttrCnt = sizeof($aryViewProdOpt[$i][OPT_ATTR]);
												for($kk=1;$kk<=10;$kk++){
													if ($aryViewProdOpt[$i]["PO_NAME".$kk]){
														if ($aryViewProdOpt[$i]["OPT_ATTR".$kk]){
															## 품절표시
															if(isset($aryViewProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'])){
																$strProdOptAttrSoldOut = ($row[$di]['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryViewProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
																if (($row[$di]['P_STOCK_OUT'] == "Y") || ($aryViewProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($row[$di]['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
															}

														} //->if

														$strPO_NO = 'cartOpt'.$kk.'_'.$aryViewProdOpt[$i][PO_NO];
														$strPOA_ATTR1 = $aryViewProdOpt[$i]["OPT_ATTR".$kk][0][POA_ATTR1];
														$strSort = $kk;
													} //->if
												} //->for
											} //->for

											$strProdOpt = "<span class=\"w_20\">";
											$strProdOpt .= $aryViewProdOpt[0]["PO_NAME1"];
											$strProdOpt .= "</span>";
											//echo sizeof($aryViewProdOpt[0]["OPT_ATTR1"]);
											for($i=0;$i < sizeof($aryViewProdOpt[0]["OPT_ATTR1"]);$i++){
												$strProdOpt .= $aryViewProdOpt[0]["OPT_ATTR1"][$i][POA_ATTR1]." "; //리스트 옵션 표시
											} //->for

										} //->if

									} else if ($strP_OPT == "2") {
										/* 다중가격일체형 */

										if (is_array($aryViewProdOpt)){

											for($i=0;$i<sizeof($aryViewProdOpt);$i++){
												if (is_array($aryViewProdOpt[$i][OPT_ATTR_ALL])){

													$strProdOptAttr = "";
													for($kk=1;$kk<=10;$kk++){
														if ($aryViewProdOpt[$i]["PO_NAME".$kk]){
															$strProdOptAttr .= "/".$aryViewProdOpt[$i][OPT_ATTR_ALL][0]["POA_ATTR".$kk];
														}
													}

													$strProdOptAttr = SUBSTR($strProdOptAttr,1);

													## 품절표시
													$strProdOptAttrSoldOut = ($row[$di]['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryViewProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
													if (($row[$di]['P_STOCK_OUT'] == "Y") || ($aryViewProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($row[$di]['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

													$strPO_NO = 'cartOpt1_'.$aryViewProdOpt[$i][PO_NO];
													$strPOA_ATTR1 = $aryViewProdOpt[$i][OPT_ATTR_ALL][0][POA_NO];
													$strSort = $kk;

													for($j=0;$j<sizeof($aryViewProdOpt[$i][OPT_ATTR_ALL]);$j++)
													{

														$strProdOptAttr = "";
														for($kk=1;$kk<=10;$kk++){
															if ($aryViewProdOpt[$i]["PO_NAME".$kk]){
																$strProdOptAttr .= "/".$aryViewProdOpt[$i][OPT_ATTR_ALL][$j]["POA_ATTR".$kk];
															}
														}

														$strProdOptAttr = SUBSTR($strProdOptAttr,1);

														## 품절표시
														$strProdOptAttrSoldOut = ($strP_STOCK_LIMIT != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryViewProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'].")" : "";
														if (($strP_STOCK_OUT == "Y") || ($aryViewProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'] == 0 && ($strP_STOCK_LIMIT != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

														$strProdOpt = $strProdOptAttr.$strProdOptAttrSoldOut; //리스트 옵션 표시
													}
												}
											}
										}
									}
									if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")
									{
										//<input type="hidden" name="cartOptNo[]" value="0">
										//<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="
										if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
										{
											$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE'],"US");
										}else{
											$strCartOptPrice = getProdDiscountPrice($row[$key],"1",0,"US");
										}


										//<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="
										if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
										{
											$strCartOptOrgPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
										}else{
											$strCartOptOrgPrice = getProdDiscountPrice($row[$key]);
										}
									}
									else
									{
										if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
										{
											$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
										}else{
											$strCartOptPrice = getProdDiscountPrice($row[$key]);
										}

										$strCartOptOrgPrice = '0';
									}

									## 재고 수량 표시
									$strP_QTY = "";
									if($S_IS_QTY_SHOW == "Y"):
										## 제고 수량 설정
										if($intP_QTY) { $strP_QTY = "<span>".$LNG_TRANS_CHAR["PW00080"]."</span>" . $intP_QTY; }
									endif;

									## 색상 설정
									$aryP_COLOR_IMG = "";
									if($strP_COLOR && $strShow6):
										$aryP_COLOR = explode("|", $strP_COLOR);
										foreach($aryP_COLOR as $key => $val):
											if($val != "Y") { continue; }
											if($S_ARY_PROD_COLOR[$key]['USE'] != "Y") { continue; }
											$aryP_COLOR_IMG[] = $S_ARY_PROD_COLOR[$key]['IMG'];
										endforeach;
									endif;

									## 적립금 설정
									$intProdPoint = getProdPoint($intViewP_SALE_PRICE, $intViewP_POINT, $strViewP_POINT_TYPE, $strViewP_POINT_OFF1, $strViewP_POINT_OFF2);

									$intProdPointMoney = 0;
									if($intProdPoint <= 0) { $strShow3 = ""; }
									if($strShow3 == "Y") { $intProdPointMoney = getCurToPrice($intProdPoint); }

									## 소비자가격 설정
									$strTextConsumerPrice = "";
									$strTextConsumerPriceUsd = "";
									if($intP_CONSUMER_PRICE > 0):
										$strTextConsumerPrice = getCurToPrice($intP_CONSUMER_PRICE);
										$strTextConsumerPrice = "{$strMoneyIconL}{$strTextConsumerPrice}{$strMoneyIconR}";
										if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextConsumerPriceUsd = getCurMark("USD") . getCurToPrice($intP_CONSUMER_PRICE, "US") . getCurMark2("USD"); }
									endif;

									## 상품 가격 설정
									$strTextPriceUsd = "";


									if($strViewP_PRICE_FILTER=='FOB'){
										//$strTextPrice = getCurMark("$") .'<strong>' . getProdDiscountPrice($row[$di],"1",0,"US") . '</strong>';
										$strTextPrice = getCurMark("$") .'<strong>' . number_format($row[$di]['P_SALE_PRICE']) . '</strong>';
										$strTextPrice = $strMoneyIconL . $strTextPrice ;
										//$strTextPrice .= '$';
									}else{
										$strTextPrice = '<strong>' . getProdDiscountPrice($row[$di]) . '</strong>';
										$strTextPrice = $strMoneyIconL . $strTextPrice ;
										$strTextPrice .= $strMoneyIconR;
									}

									if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("$") . getProdDiscountPrice($row[$di],"1",0,"US") . getCurMark2("USD"); }
									if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; }

									## 이미지 설정
									if(!$strViewPM_REAL_NAME) { $strViewPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

									## 마우스 오버시 변경 이미지 설정
									$strViewOverImage = "";
									if($strTurnUse == "Y" && $strViewPM_REAL_NAME2):
										$strViewOverImage = " overImg='{$strPM_REAL_NAME2}'";
									endif;

									## 리스트 이미지를 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
									$strProdMovieUrl = "";
									if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($row[$di]['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)):
										$productMgr->setP_CODE($strP_CODE);
										$productMgr->setPM_TYPE("movie1");
										$prodMovieRow = $productMgr->getProdImg($db);
										$strProdMovieUrl = $prodMovieRow[0]['PM_REAL_NAME'];
									endif;

									## 이벤트 정보
									$strViewEvent = "";
									if($strViewP_EVENT > 0 && getProdEventInfo($row[$di]) == "Y"):
										if($S_EVENT_INFO[$strViewP_EVENT]["PRICE_TYPE"] == "1"):
											$strViewEvent = $S_EVENT_INFO[$row[$di][P_EVENT]]["PRICE_MARK"];
										endif;
									endif;

									## 아이콘 설정
									$iconTag = "";
									$icon = explode("/", $strP_LIST_ICON);
									for($x=0; $x<sizeof($icon); $x++):
										$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
									endfor;

									## 상품명 설정
									$strViewP_NAME = strHanCutUtf2($strViewP_NAME, $intTitleMaxsize, "N");

									## 평점 설정
									$intViewGrade = 0;
									if($intViewP_GRADE && $intViewP_GRADE_CNT){
										$intViewGrade = $intViewP_GRADE / $intViewP_GRADE_CNT;
									}

									## td style 설정
									$strStyleTD = "";
									if($j==($intWList-1)) { $strStyleTD = "width:{$intWSize}px"; }

									## div class 설정
									$strClassDiv = "productInfoWrap";
									if($j==($intWList-1)) { $strClassDiv .= " endProdList"; }

									## div style 설정
									$strStyleDiv = "width:{$intWSize}px;text-align:{$strWAlign}";


									## 판매가 할인율
									$intProdDiscountRate	= 0;
									if ($S_FIX_PRODUCT_DISCOUNT_RATE_SHOW == "Y"){
										if($row[$key]['P_CONSUMER_PRICE'] > 0.00001){
											$intProdDiscountRate= getRoundUp((($row[$di]['P_CONSUMER_PRICE'] - $row[$di]['P_SALE_PRICE'])/$row[$di]['P_CONSUMER_PRICE']) * 100,0);
											$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
										}
									}

									## 무료배송아이콘표시
									$strProdFreeDeliveryText = "";
									if ($S_FIX_PRODUCT_FREE_DELIVERY_SHOW == "Y"){
										if ($strP_BAESONG_TYPE == "2"){
											$strProdFreeDeliveryText = "무료배송";
										}
									}

									## 2015.02.09 kim hee sung
									## 상품가격 출력 설정
									##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
									if($isPriceHide):
										$strProdDiscountRateText = '';
										$strTextPrice = '';
										$intProdPointMoney = '';
										$strTextConsumerPrice = '';
										$strTextConsumerPriceUsd = '';
									endif;
									?>
									<table class="productInfoWrap">
										<tr id="prod<?php echo $strP_CODE;?>">
											<td class="prodImgWrap">
												<a href="javascript:goProdView('<?php echo $strViewP_CODE;?>');"><img src="<?php echo $strViewPM_REAL_NAME;?>" class="listProdImg"/></a>
												<!-- 품절 //-->
												<?php if($isSoldOut):?>
													<!--div class="soldout">Sold Out</div-->
													<div class="soldout"><img src="/upload/images/img_soldout.png" /></div>
												<?php endif;?>
												<!-- 품절 //-->
												<div class="icoWrap">
													<!--<a href="javascript:goListWish('<?php echo $strP_CODE;?>','<?php echo $strP_STOCK_OUT;?>','<?php echo $intP_QTY;?>','<?php echo $strP_STOCK_LIMIT;?>','<?php echo $strCartOptPrice;?>','<?php echo $strCartOptOrgPrice;?>','<?php echo $strP_MIN_QTY;?>','<?=$strPO_NO?>',<?=$strSort?>,'<?=$strPOA_ATTR1?>','<?=$strP_OPT?>','<?=$strP_MAX_QTY?>');" alt="담아두기" title="담아두기"><img src="/upload/images/ico_list_star1.png"> <span class="ico_wish">담아두기</span></a>-->
													<!--<a href="javascript:goProdCompare(<?php echo $strP_CODE;?>)" title="비교하기"><img src="/upload/images/ico_list_chk1.png" alt="비교하기"> <span class="ico_chk">비교하기</span></a>-->
												</div>
											</td>

											<td class="prodInfoWrap">
												<ul>
													<li class="tit"><a href="javascript:goProdView('<?php echo $strViewP_CODE;?>');"><?=$strViewP_NAME?></a></li>
												</ul>
												<ul class="prodInfo1"><?php echo $aryCategory;?>
													<li><span><?= $LNG_TRANS_CHAR["PW00028"]; //원산지 ?></span><?php echo $aryCountryList[$strViewP_ORIGIN]?></li>
													<li><span><?= $LNG_TRANS_CHAR["CW00064"]; //카테고리 ?></span><?php echo $aryCateNames[$strP_CATE]?></li>
												</ul>
												<ul class="addINfo">
													<li class="option"><span><?= $LNG_TRANS_CHAR["PW00081"]; //가격 ?></span><?
														if($strShow5 == "Y") {
															if($strTextPriceUsd) {
																echo $strTextPrice; // 가격
																echo ' / ';
																echo $strTextPriceUsd; // USD 달러
															}
															else {
																echo $strTextPrice;// 가격
															}
															if($strViewP_PRICE_UNIT){
																echo '(1';
																echo $strViewP_PRICE_UNIT;
																echo ' 당)';
															}
														}
														?>
													</li>
													<!--<li><span>CAS No.</span><?php echo $strP_CAS_NO?></li>-->
													<li class="packing"><?php echo $strProdOpt;	?></li>
													<li class="cnt"><span class="w_93"><?= $LNG_TRANS_CHAR["PW00090"]; //최소구매수량 ?></span><?php echo $strViewP_MIN_QTY?></li>
												</ul>
											</td>
										</tr>
									</table>
								<? endif; ?>
							</td>
						<? }	?>
					</tr>
					<? if($intListNum <= $k) { break; } ?>
				<? } ?>
			</table>
			<?if ($strProdListAllView != "Y"){?>
				<div id="pagenate">
					<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","","","")?>
				</div>
				<? if ( $S_SHOP_MORE_VIEW_USE == 'Y' && $intTotPage > 1 ) { ?><a href="<?=$_SERVER['PHP_SELF']?>&page=2" id="btnProductMore" class="btnProductMore">더보기</a><? } ?>
			<?}?>

		</div>
		<!-- End list view -->

	</div>
</div><!-- TAB 2 //-->

<!--end: 회사소개 -->
<script type="text/javascript">
	<!--
	//C_DelCookie("prodCompare");
	var prodCompareCnt = <?=($intProdCompareCookieCnt) ? $intProdCompareCookieCnt : 0; ?>;
	function goProdCompare(intProdCode)
	{
		if(!$("#chkInfoBox"+intProdCode).html())
		{
			var prodCompareListC = C_GetCookie("prodCompare");
			var prodCompareListI = $("#prodCompare").val();
			var prodAry = prodCompareListI.split("|");
			var prodCode = prodAry.indexOf(intProdCode+"");
			var prodCompareListCnt = prodAry.length -1;

			if(prodCode == -1)
			{
				C_SetCookie("prodCompare",prodCompareListC + intProdCode + "|");
				$("#prodCompare").val( prodCompareListI + intProdCode + "|");
				prodCompareCnt = prodCompareListCnt + 1;

			}

			//기존에 생성된 비교하기 버튼 제거
			$(".chkInfoBox").remove();

			//비교하기 버튼
			var	prodComparesHtml = "";
			prodComparesHtml += "<div class=\"chkInfoBox\" id=\"chkInfoBox"+intProdCode+"\" style=\"display:;\">";
			prodComparesHtml += "<a href=\"javascript:goProdComparesHtmlClose("+intProdCode+")\" class=\"btnClose\">닫기</a>";
			prodComparesHtml += "<div class=\"infoTxt\">선택한 상품(<span id=\"prodComparesCnt\">"+prodCompareCnt+"</span> /10)</div>";
			//prodComparesHtml += "<div class=\"infoTxt\">선택한 상품(<span id=\"prodComparesCnt\">0</span> /10)</div>";
			prodComparesHtml += "<a href=\"javascript:goProdComparesView()\" class=\"btnChk\">비교하기</a>";
			prodComparesHtml += "</div>";

			$("#prod"+intProdCode + " .icoWrap" ).append(prodComparesHtml);
		}else{

		}
	}

	function goProdComparesHtmlClose(intProdCode){
		$("#chkInfoBox"+intProdCode).remove();

	}

	function goProdComparesView()
	{
		//var prodCoparisonHtml = $("#prodComparisonBox").html();

		var	strPCodeList = $("#prodCompare").val();

		var strUrl = './?menuType=product&mode=prodCompare&prodCodeList=' + strPCodeList;

		$.smartPop.open({	//html: prodCoparisonHtml,
			url : strUrl,
			bodyClose: false,
			width : 955,
			height : 648,
		});
	}
	//-->
</script>