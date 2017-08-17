	<h4 class="titCart"><span><?=$LNG_TRANS_CHAR["CW00004"] //내 장바구니?></span> <strong>(<?=NUMBER_FORMAT($intCartTotal)?>)</strong></h4>

	<div class="myOrderListWrap mt10">
				<table>
					<colgroup>
						<col style="width:20px;"/>
						<col/>
						<col/>
						<col/>
						<col />
						<?=($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR")?"<col style='width:50px;'/>":"";?>
					</colgroup>
					<tr>
						<th><input type="checkbox" id="chkAll" name="chkAll" value="Y" onclick="javascript:goCartAllCheck(this);"/></th>
						<th><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></th>
						<th class="amountDiv"><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
						<th><?=$LNG_TRANS_CHAR["OW00004"] //합계?></th>
						<?=($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR")?"<th>".$LNG_TRANS_CHAR['PW00012']."</th>":""; //배송비?>
					</tr>
					<?
					if ($intCartTotal == 0){
					?>
					<tr>
						<td colspan="7" class="dataNoList"><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></td>
					</tr>
					<?
					} else {
						$intCartPrice = $intCartPriceTotal = $intCartDeliveryPriceTotal = 0;
						for($i=1;$i<=5;$i++){
							$aryDeliveryPrice[$i] = 0;
						}

						while ($cartRow = mysql_fetch_array($cartResult)){

							/* 입점형/프랜차이즈일때 */
							if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){
								$intRowSpan = 0;
								if (($intShopNo != "0" && !$intShopNo) || ($intShopNo != $cartRow[P_SHOP_NO])) {
									$intShopNo	= ($cartRow[P_SHOP_NO])?$cartRow[P_SHOP_NO]:"0";
									$intRowSpan = $aryProdBasketShopList[$intShopNo][BASKET_CNT];
								}else {
									$intRowSpan = 0;
								}
							}

							$intCartPrice = ($cartRow[PB_PRICE] * $cartRow[PB_QTY]) + $cartRow[PB_ADD_OPT_PRICE];
							$intCartPriceTotal += $intCartPrice;
							if ($S_DELIVERY_MTH == "G" && $cartRow[P_BAESONG_TYPE] != "2"){
								$intCartDeliveryPriceTotal += $intCartPrice;
							}

							$productMgr->setPB_NO($cartRow[PB_NO]);
							$aryProdCartAddOptList = $productMgr->getProdBasketAddList($db);

							/* 배송비설정*/
							$intDeliveryPrice = getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice,$cartRow[PB_QTY],$aryProdBasketShopList[$cartRow[P_SHOP_NO]]);
							$aryDeliveryPrice[$cartRow[P_BAESONG_TYPE]] += $intDeliveryPrice;

							$strCartOptAttrVal = "";
							for($kk=1;$kk<=10;$kk++){
								if ($cartRow["PB_OPT_ATTR".$kk]){
									$strCartOptAttrVal .= "/".$cartRow["PB_OPT_ATTR".$kk];
								}
							}
							$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

							$strProdEventText = "";
							if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
								if ($cartRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"%")).")";
								else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"")).")";
							}

							/* 상품에 착불가격이 있는 경우 */
							## P_BAESONG_TYPE = 1 : 기본 배송
							## P_BAESONG_TYPE = 2 : 무료 배송
							## P_BAESONG_TYPE = 3 : 고정 배송		배송비 보임
							## P_BAESONG_TYPE = 4 : 수량별 배송		배송비 보임
							## P_BAESONG_TYPE = 5 : 착불 배송		배송비 보임
							if($S_SITE_LNG == "KR"):
								$strBaesongPrice			= "";
									if($cartRow['P_BAESONG_TYPE'] == 1):
								elseif($cartRow['P_BAESONG_TYPE'] == 2):
								elseif($cartRow['P_BAESONG_TYPE'] == 3):
									$strBaesongPrice		= $cartRow['P_BAESONG_PRICE'];
									$strBaesongPrice		= "(고정배송비:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
								elseif($cartRow['P_BAESONG_TYPE'] == 4):
									$strBaesongPrice		= $cartRow['P_BAESONG_PRICE'];
									$strBaesongPrice		= "(수량별배송비:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
								elseif($cartRow['P_BAESONG_TYPE'] == 5):
									$strBaesongPrice		= $cartRow['P_BAESONG_PRICE'];
									$strBaesongPrice		= "(착불:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
								endif;
							endif;
							?>
					<tr>
						<td><input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?=$cartRow[PB_NO]?>"/></td>
						<td class="prodInfo">
							<a href="./?menuType=product&mode=view&prodCode=<?=$cartRow[P_CODE]?>"><img src="<?=$cartRow[PM_REAL_NAME]?>" style="width:50px;"/></a>
							<ul>
								<li><a href="./?menuType=product&mode=view&prodCode=<?=$cartRow[P_CODE]?>"><?=$cartRow[P_NAME]?><?=$strProdEventText?></a> / <?=$strCartOptAttrVal?> </li>
								<!--<li><?=$strCartOptAttrVal?></li>-->
								<!--<li><a href="#" class="optBtn">선택사항 변경 </a></li>//-->

								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){

									?>
									<li><?=$LNG_TRANS_CHAR["OW00006"] //추가선택?> : <?=$aryProdCartAddOptList[$k][PBA_OPT_NM]?></li>
								<?}}?>
								<?=$strBaesongPrice?>
								<li>
									<!--<a href="javascript:goWish(<?=$cartRow[PB_NO]?>);" class="cartMovWishBtn"><span><?=$LNG_TRANS_CHAR["OW00089"] //나중에 주문?></span></a>-->
									<a href="javascript:goCartDel(<?=$cartRow[PB_NO]?>);" class="cartListDelBtn"><span><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></span></a>
								</li>
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
							<strong class="priceBoldGray"><?=getCurMark("USD")?> <?=getCurToPrice($cartRow[PB_PRICE],"US")?></strong>
							(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($cartRow[PB_PRICE])?>)
							<?if ($cartRow[PB_ADD_OPT_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getCurMark("USD")?> <?=getCurToPrice($cartRow[PB_ADD_OPT_PRICE],"US")?>(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($cartRow[PB_ADD_OPT_PRICE])?>)<?}?>
							<?}else{?>
							<strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($cartRow[PB_PRICE])?><?=getCurMark2()?></strong>
							<?if ($cartRow[PB_ADD_OPT_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getCurMark()?> <?=getCurToPrice($cartRow[PB_ADD_OPT_PRICE])?><?=getCurMark2()?><?}?>
							<?}?>
						</td>
						<td>
							<dl>
								<dd><input type="input" id="cartQty<?=$cartRow[PB_NO]?>" name="cartQty<?=$cartRow[PB_NO]?>" value="<?=$cartRow[PB_QTY]?>" class="defInput _w30" style="text-addgn:right; width:20px;"/></dd>
								<dd>
									<a href="javascript:goQtyUpMinus('cart',1,<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/btn_prod_cnt_up.gif"/></a>
									<a href="javascript:goQtyUpMinus('cart',-1,<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/btn_prod_cnt_down.gif"/></a>
								</dd>
								<a href="javascript:goQtyUpdate('cart',<?=$cartRow[PB_NO]?>);" class="cartCntModify"><span><?=$LNG_TRANS_CHAR["OW00072"] //수정?></span></a>
							</dl>

						</td>
						<td>
							<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
							<strong class="priceOrange"><?=getCurMark("USD")?> <?=getCurToPrice($intCartPrice,"US")?></strong>
							(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($intCartPrice)?>)
							<?}else{?>
							<strong class="priceOrange"><?=getCurMark()?> <?=getCurToPrice($intCartPrice)?><?=getCurMark2()?></strong>
							<?}?></strong>
						</td>
						<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
							<?if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){?>
							<?=($intRowSpan >= 1) ? "<td rowspan=\"".$intRowSpan."\">".getCurMark("USD")." ".getCurToPrice($aryProdBasketShopList[$cartRow[P_SHOP_NO]][DELIVERY_PRICE],"US")."(".$S_SITE_CUR_MARK1.getCurToPrice($aryProdBasketShopList[$cartRow[P_SHOP_NO]][DELIVERY_PRICE]).") </td>":"";?>
							<?}?>
						<?}else{?>
							<?if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){?>
							<?=($intRowSpan >= 1) ? "<td rowspan=\"".$intRowSpan."\">".
							//getCurMark()." ".getCurToPrice($aryProdBasketShopList[$cartRow[P_SHOP_NO]][DELIVERY_PRICE]).
							(($aryProdBasketShopList[$cartRow[P_SHOP_NO]][DELIVERY_PRICE]>0) ? getCurMark()." ".getCurToPrice($aryProdBasketShopList[$cartRow[P_SHOP_NO]][DELIVERY_PRICE]) : $LNG_TRANS_CHAR["PW00013"]).
							" </td>":"";?>
							<?}?>
						<?}?>
					</tr>
							<?
						}
					}

					/* 배송비설정 */
					if ($S_DELIVERY_MTH == "G") $intDeliveryTotal = 0;
					else $intDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$intCartPriceTotal,$SHOP_ARY_DELIVERY);

					if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
						$intDeliveryTotal = $intProdBasketDeliveryTotal;
					}

					/*부과세포함*/
					$intCartPriceEndTotal = $intCartPriceTotal+$intDeliveryTotal;
					if ($S_SITE_TAX == "Y"){
						$intCartPriceEndTotal = $intCartPriceEndTotal + ($intCartPriceTotal*0.1);
					}
					?>

				</table>
			</div>

			<!-- tableProdList -->
			<div class="totalPriceWrap">
				<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>

				<span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?>:</span> <strong class="priceBoldGray"><?=getCurMark("USD")?> <?=getCurToPrice($intCartPriceTotal,"US")?></strong>
				(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($intCartPriceTotal)?>)
				<?if ($S_SITE_TAX == "Y"){?>
				 + <span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?>:</span> <strong class="priceBoldGray"><?=getCurMark("USD")?> <?=getCurToPrice($intCartPriceTotal * 0.1,"US")?></strong>
					(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($intCartPriceTotal * 0.1)?>)
				<?}?>
				<?if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH){?>
				 + <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?>:</span> <strong class="priceBoldGray">
				 <?if ($intDeliveryTotal>0){?><?=getCurMark("USD")?> <?=getCurToPrice($intDeliveryTotal,"US")?>(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($intDeliveryTotal)?>)
				 <?}else{?><?=$LNG_TRANS_CHAR["PW00013"] //무료?><?}?>
				 </strong>
				<?}else{?>
				 <!-- + <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?>:</span> 배송비 설정 페이지 링크</strong>//-->
				<?}?>
				=
				<span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?>:</span><strong class="priceOrange"><?=getCurMark("USD")?> <?=getCurToPrice($intCartPriceEndTotal,"US")?></strong>
				(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($intCartPriceEndTotal)?>)

				<?}else{?>

				<span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?>:</span> <strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($intCartPriceTotal)?><?=getCurMark2()?></strong>
				<?if ($S_SITE_TAX == "Y"){?>
				 + <span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?>:</span> <strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($intCartPriceTotal * 0.1)?><?=getCurMark2()?></strong>
				<?}?>
				<?if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH){?>
				 + <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?> : </span> <strong class="priceBoldGray">
				 <?if($intDeliveryTotal>0){?><?=getCurMark()?> <?=getCurToPrice($intDeliveryTotal)?><?=getCurMark2()?><?}else{?><?=$LNG_TRANS_CHAR["PW00013"] //무료?><?}?></strong>
				<?}else{?>
				 <!-- + <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?>:</span> 배송비 설정 페이지 링크</strong>//-->
				<?}?>
				<span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?>:</span> <strong class="priceOrange"><?=getCurToPrice($intCartPriceEndTotal)?><?=getCurMark2()?></strong>
				<?}?>
			</div>


			<div class="btnCenter">
				<a href="javascript:goOrderJumun();" class="chkOrderBigBtn"><span><?=$LNG_TRANS_CHAR["OW00079"] //선택상품 주문?></span></a>
				<a href="javascript:goCartAllDel();" class="prodDelBigBtn"><span><?=$LNG_TRANS_CHAR["OW00080"] //선택상품 삭제?></span></a>
			</div>