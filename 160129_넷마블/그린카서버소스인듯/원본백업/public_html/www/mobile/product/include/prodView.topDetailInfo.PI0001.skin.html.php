
	
	<!-- 상품 탑 상세정보 -->
	<div class="prodDetail mt10" >	
		<dl>
			<dd class="detailImg">
				<? include sprintf ( "%swww/web/product/include/prodView.MultyImage.index.inc.php", $S_DOCUMENT_ROOT  ); ?>
			</dd>
			<dd class="multyImg" ><!-- 다중 이미지 -->
			
			</dd>
			<dd class="detailInfo">
				<table border="0">
					<tr>
						<th colspan="2" class="titleWrap">
							<?=$prodRow[P_NAME]?>
						</th>
					</tr>
					<?if($strShow2=="Y" && $prodRow[P_ETC]):?>
					<tr>
						<th colspan="2" class="titleWrap"><?=$prodRow[P_ETC]?></th>
					</tr>
					<?endif;?>
					<?if ($prodRow[P_CONSUMER_PRICE] > 0){?><tr><th>소비자가</th><td> <?=getCurMark()?> <s class="priceOrg"><?=getCurToPrice($prodRow[P_CONSUMER_PRICE])?></s></td></tr><?}?>
					<tr><th><?if($S_PRODUCT_RENT == "Y" && $prodRow[P_STOCK_PRICE] != "1" ){echo $LNG_TRANS_CHAR["PW00003"]; }else{echo $LNG_TRANS_CHAR["PW00004"];} //임대가/판매가?></th><td>
					<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?><s><?}?>
						<strong class="priceOrange _fs14" id="realPayPriceText"><?=getCurMark()?> <?=getProdDiscountPrice($prodRow)?></strong>
					<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?></s><?}?></td></tr>
					<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?>
						<tr><th><?=$LNG_TRANS_CHAR["PW00005"] //특별할인가?></th><td> <?=getCurMark()?><strong class="priceOrange _fs14" id="realPayPriceTaxText"><?=getCurToPrice(getProdEventPrice($prodRow[P_SALE_PRICE],$prodRow[P_EVENT_UNIT],$prodRow[P_EVENT]))?></strong> <?=$LNG_TRANS_CHAR["PW00007"] //(10%할인)?></></td></tr>
					<?}?>
					<?if ($intProdPoint > 0){?>
					<tr><th><?=$LNG_TRANS_CHAR["PW00006"] //마일리지?></th><td>  <?=getCurMark()?> <img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/icon_point_green.gif" style="vertical-align:middle;"/> <?=getCurToPrice($intProdPoint)?> <?=$LNG_TRANS_CHAR["PW00008"] //포인트?></td></tr>	
					<?}?>				
					
					<?
					if ($prodRow[P_OPT] == "1" || $prodRow[P_OPT] == "3"){
						/* 다중가격사용안함 */

						if (is_array($aryProdOpt)){
							for($i=0;$i<sizeof($aryProdOpt);$i++){
								$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
								for($kk=1;$kk<=10;$kk++){
									if ($aryProdOpt[$i]["PO_NAME".$kk]){
								?>
									<tr>
										<th><?=$aryProdOpt[$i]["PO_NAME".$kk]?></th>
										<td>
										<select id="cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>" name="cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>"  onchange="javascript:goSelectProdOpt('cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>',<?=$kk?>);">
											<option value="">:: <?=($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"]; //필수선택:선택?> ::</option>
											<?
												if ($aryProdOpt[$i]["OPT_ATTR".$kk]){
													for($j=0;$j<sizeof($aryProdOpt[$i]["OPT_ATTR".$kk]);$j++){
											?>
											<option value="<?=$aryProdOpt[$i]["OPT_ATTR".$kk][$j][POA_ATTR1]?>"><?=$aryProdOpt[$i]["OPT_ATTR".$kk][$j][POA_ATTR1]?></option>
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

					} else if ($prodRow[P_OPT] == "2") {
						/* 다중가격일체형 */
						
						if (is_array($aryProdOpt)){

							for($i=0;$i<sizeof($aryProdOpt);$i++){
								?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00011"] //옵션선택?></th>
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
											?>
											<option value="<?=$aryProdOpt[$i][OPT_ATTR_ALL][$j][POA_NO]?>"><?=$strProdOptAttr?></option>
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
									<th><?=$aryProdAddOpt[$i][PO_NAME1]?></th><td>
									<select id="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>" name="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>"  >
										<option value="">:: <?=($aryProdAddOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"];?> ::</option>
										<?for($j=0;$j<sizeof($aryProdAddOpt[$i][OPT_ATTR]);$j++){?>
										<option value="<?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NO]?>"><?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NAME]?></option>
										<?}?>
									</select>
								</td></tr>
							<?
						}
					}

					if (($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)) || ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH != "W")){
						
						if ($prodRow[P_BAESONG_TYPE] == "1"){
							if ($SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"] > 0){
								if (($prodRow[P_SALE_PRICE] > $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"])){
					?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00013"] //무료?></td>
					</tr>
					<?	
								} else {

					?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"])?></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00014"] //배송비무료조건?></th>
						<td><?=callLangTrans($LNG_TRANS_CHAR["PS00003"],array(getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"]))); //{{단어1}}이상 구매시?></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00015"] //배송비결제여부?></th>
						<td>
							<select id="cartDelivery" name="cartDelivery">
								<option value="1">::<?=callLangTrans($LNG_TRANS_CHAR["PS00004"],array(getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"]))); //주문시 {{단어1}} 결제?> ::</option>
								<option value="2">::<?=$LNG_TRANS_CHAR["PS00005"]?> ::</option>
							</select>
						</td>
					</tr>
					<!--<tr>
						<th>예외지역배송</th>
						<td><input type="checkbox" id="cartDeliveryExp" name="cartDeliveryExp" value="Y"></td>
						(* 예외지역 배송일 경우 체크)
					</tr>//-->
					<?		}}} else if ($prodRow[P_BAESONG_TYPE] == "2"){
						if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH != "G"){		?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th><td> <?=$LNG_TRANS_CHAR["PW00016"] //무료배송?></td>
					</tr>
					<?		}} else if ($prodRow[P_BAESONG_TYPE] == "3"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00017"] //고정 배송비?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?></td>
					</tr>
					<?		} else if ($prodRow[P_BAESONG_TYPE] == "4"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00018"] //수량별 배송?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?></td>
					</tr>
					<?		} else if ($prodRow[P_BAESONG_TYPE] == "5"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th> <td><?=callLangTrans($LNG_TRANS_CHAR["PS00006"],array($S_SITE_CUR,getCurToPrice($prodRow[P_BAESONG_PRICE]))); //상품 수령 후 {{단어1}} {{단어2}} 지불?></td>
					</tr>
					<?		}
					} else {
					?>
					<!--<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td>배송비 설명 페이지 링크</td> 
					</tr>//-->
					<?}?>
					<!-- 상품 항목 설명 -->
					<?
						if (is_array($aryProdItem)){
							
							for($i=0;$i<sizeof($aryProdItem);$i++){
							?>
					<tr>
						<th><?=$aryProdItem[$i][PI_NAME]?></th>
						<td><?=$aryProdItem[$i][PI_TEXT]?></td>
					</tr>
							<?
							}
						}
					?>
					<!-- 상품 항목 설명 -->
					<tr>
						<th class="prodCntSelect"><?=$LNG_TRANS_CHAR["PW00019"] //구매수량?></th>
						<td class="prodCntSelect"> 
							<div class="cntInputWrap">
							<input type="input" id="cartQty" name="cartQty" value="<?=$prodRow[P_MIN_QTY]?>" style="width:30px;padding:2px;border:1px solid #bebebe;"/> <?=$LNG_TRANS_CHAR["PW00020"] //개?> 
							</div>
						<strong class="btnCntUpDown">
							<a href="javascript:goProdViewQtyChange('up',<?=$prodRow[P_MIN_QTY]?>);"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_prod_cnt_up.gif"/></a>
							<a href="javascript:goProdViewQtyChange('down',<?=$prodRow[P_MIN_QTY]?>);"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_prod_cnt_down.gif"/></a>
						</strong>
						<div class="clear"></div>
						</td>
					</tr>
					<tr class="snsInfo">
						<td colspan="2"><br>
							<!-- sns -->
							<?if($arySns['twitter']=="Y"):?>
							<a href="javascript:goTwitter('<?=$strSnsName?>', '<?=$strSnsLink?>')"><img src="/himg/board/A0001/icon_black_twitter.gif"></a>
							<?endif;?>
							<?if($arySns['facebook']=="Y"):?>
							<a href="javascript:goFacebook('<?=$strSnsLink?>', '<?=$strSnsImg?>', '<?=$S_SITE_KNAME?>', '<?=$strSnsName?>', '')"><img src="/himg/board/A0001/icon_black_facebook.gif"></a>
							<?endif;?>
							<?if($arySns['m2day']=="Y"):?>
							<a href="javascript:goMe2Day('<?=$strSnsName?>', '<?=$strSnsLink?>')"><img src="/himg/board/A0001/icon_black_m2day.gif"></a>
							<?endif;?>
						</td>
					</td>
				</table>
				<!-- 구매버튼 -->
					<div class="orderBtnWrap mt40">
						<a href="javascript:goCartOrder();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_detail_buy.gif"/></a>
						<a href="javascript:goCart();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_detail_cart.gif"/></a>
						<a href="javascript:goWish();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_detail_wish.gif"/></a>
						<a href="javascript:goProdList();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_detail_list.gif"/></a>
					</div>
					<!-- 구매버튼 -->
			</dd>
		</dl>
	</div>
	<!-- 상품 탑 상세정보 -->


