	<div class="cartListWrapBig mt20">
			<div class="cartTabWrap">
				<span class="tabBtn1">내 장바구니(<?=NUMBER_FORMAT($intCartTotal)?>)</span>
			</div>
			<div class="tableProdList mt10">
				<table>
					<colgroup>
						<col style="50px;"/>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th><input type="checkbox" id="chkAll" name="chkAll" value="Y" onclick="javascript:goCartAllCheck(this);"/></th>
						<th>상품정보</th>
						<th>상품금액</th>
						<th>수량</th>
						<th>합계</th>
						<th>비고</th>
					</tr>
					<?
					if ($intCartTotal == 0){
					?>
					<tr>
						<td colspan="6">장바구니에 담긴 상품이 없습니다.</td>
					</tr>
					<?
					} else {
						$intCartPrice = $intCartPriceTotal = $intCartDeliveryPriceTotal = 0;
						for($i=1;$i<=5;$i++){
							$aryDeliveryPrice[$i] = 0;
						}

						while ($cartRow = mysql_fetch_array($cartResult)){

							$intCartPrice = ($cartRow[PB_PRICE] * $cartRow[PB_QTY]) + $cartRow[PB_ADD_OPT_PRICE];
							$intCartPriceTotal += $intCartPrice;
							if ($siteRow[S_DELIVERY_GROUP] == "Y" && $cartRow[P_BAESONG_TYPE] != "2"){
								$intCartDeliveryPriceTotal += $intCartPrice;
							}
							
							$productMgr->setPB_NO($cartRow[PB_NO]);
							$aryProdCartAddOptList = $productMgr->getProdBasketAddList($db);

							/* 배송비설정*/
							$intDeliveryPrice = getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice);

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
								if ($cartRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".$cartRow[P_EVENT]."% 할인가 적용)";
								else $strProdEventText = "(".$cartRow[P_EVENT]."원 할인가 적용)";
							}		
							?>
					<tr>
						<td><input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?=$cartRow[PB_NO]?>" checked/></td>
						<td class="prodInfo">
							<img src=".<?=$cartRow[PM_REAL_NAME]?>" style="width:50px;"/>
							<ul>
								<li><?=$cartRow[P_NAME]?><?=$strProdEventText?></li>
								<li><?=$strCartOptAttrVal?></li>
								<!--<li><a href="#" class="optBtn">선택사항 변경 </a></li>//-->

								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
									
									?>
									<li>추가선택 : <?=$aryProdCartAddOptList[$k][PBA_OPT_NM]?></li>
								<?}}?>
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<strong class="priceBoldGray"><?=NUMBER_FORMAT($cartRow[PB_PRICE])?>원</strong>
							<?if ($cartRow[PB_ADD_OPT_PRICE] > 0){?><br>추가금액:<?=NUMBER_FORMAT($cartRow[PB_ADD_OPT_PRICE])?><?}?>
						</td>
						<td>
							<dl>
								<dd><input type="input" id="cartQty<?=$cartRow[PB_NO]?>" name="cartQty<?=$cartRow[PB_NO]?>" value="<?=$cartRow[PB_QTY]?>" class="defInput _w30" style="text-addgn:right;"/></dd>
								<dd>
									<a href="javascript:goQtyUpMinus('cart',1,<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/btn_cart_cnt_up.gif"/></a>
									<a href="javascript:goQtyUpMinus('cart',-1,<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/btn_cart_cnt_down.gif"/></a>
								</dd>
								<dd><a href="javascript:goQtyUpdate('cart',<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/btn_cart_cnt_modify.gif"/></a></dd> 
							</dl>
							
						</td>
						<td><strong class="priceOrange"><?=NUMBER_FORMAT($intCartPrice)?>원</strong></td>
						<td class="checkBtn">
							<a href="javascript:goWish(<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/btn_cart_list_wish.gif"/></a>
							<a href="javascript:goCartDel(<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/btn_cart_list_del.gif"/></a>
						</td>
					</tr>
							<?
						}
					}

					/* 배송비설정 */
//					$intDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$intCartPriceTotal,$SHOP_ARY_DELIVERY);
					if ($siteRow[S_DELIVERY_GROUP] == "Y") $intDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$intCartDeliveryPriceTotal,$SHOP_ARY_DELIVERY);
					else $intDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$intCartPriceTotal,$SHOP_ARY_DELIVERY);

					/*부과세포함*/
					$intCartPriceEndTotal = $intCartPriceTotal+$intDeliveryTotal;
					if ($siteRow[S_SITE_TAX] == "Y"){
						$intCartPriceEndTotal = $intCartPriceEndTotal + ($intCartPriceTotal*0.1);
					}
					?>
					
				</table>
				
			</div>
			<!-- tableProdList -->
			<div class="totalPriceWrap">
				<span>상품금액:</span> <strong class="priceBoldGray"><?=NUMBER_FORMAT($intCartPriceTotal)?>원</strong> +
				<?if ($siteRow[S_SITE_TAX] == "Y"){?>
				<span>부과세:</span> <strong class="priceBoldGray"><?=NUMBER_FORMAT($intCartPriceTotal * 0.1)?>원</strong> +
				<?}?>
				<span>배송비:</span> <strong class="priceBoldGray"><?=NUMBER_FORMAT($intDeliveryTotal)?>원</strong> =
				<span>최종결제금액:</span><strong class="priceOrange"><?=NUMBER_FORMAT($intCartPriceEndTotal)?>원</strong>
			</div>
		</div><!-- cartListWrapBig -->