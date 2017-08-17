	<div class="cartListWrapBig mt20">
			<div class="cartTabWrap">
				<span class="tabBtn1"><?=$LNG_TRANS_CHAR["CW00003"] //내 장바구니?>(<?=NUMBER_FORMAT($intCartTotal)?>)</span>
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
						<th><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></th>
						<th><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
						<th><?=$LNG_TRANS_CHAR["OW00004"] //합계?></th>
						<th><?=$LNG_TRANS_CHAR["OW00005"] //비고?></th>
					</tr>
					<?
					if ($intCartTotal == 0){
					?>
					<tr>
						<td colspan="6"><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></td>
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
							$intDeliveryPrice = getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intCartPrice,$cartRow[PB_QTY]);

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
							?>
					<tr>
						<td><input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?=$cartRow[PB_NO]?>" checked/></td>
						<td class="prodInfo">
							<img src="..<?=$cartRow[PM_REAL_NAME]?>" style="width:50px;"/>
							<ul>
								<li><?=$cartRow[P_NAME]?><?=$strProdEventText?></li>
								<li><?=$strCartOptAttrVal?></li>
								<!--<li><a href="#" class="optBtn">선택사항 변경 </a></li>//-->

								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
									
									?>
									<li><?=$LNG_TRANS_CHAR["OW00006"] //추가선택?> : <?=$aryProdCartAddOptList[$k][PBA_OPT_NM]?></li>
								<?}}?>
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($cartRow[PB_PRICE])?></strong>
							<?if ($cartRow[PB_ADD_OPT_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getCurMark()?> <?=getCurToPrice($cartRow[PB_ADD_OPT_PRICE])?><?}?>
						</td>
						<td>
							<dl>
								<dd><input type="input" id="cartQty<?=$cartRow[PB_NO]?>" name="cartQty<?=$cartRow[PB_NO]?>" value="<?=$cartRow[PB_QTY]?>" class="defInput _w30" style="text-addgn:right;"/></dd>
								<dd>
									<a href="javascript:goQtyUpMinus('cart',1,<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_cnt_up.gif"/></a>
									<a href="javascript:goQtyUpMinus('cart',-1,<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_cnt_down.gif"/></a>
								</dd>
								<dd><a href="javascript:goQtyUpdate('cart',<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_cnt_modify.gif"/></a></dd> 
							</dl>
							
						</td>
						<td><strong class="priceOrange"><?=getCurMark()?> <?=getCurToPrice($intCartPrice)?></strong></td>
						<td class="checkBtn">
							<a href="javascript:goWish(<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_list_wish.gif"/></a>
							<a href="javascript:goCartDel(<?=$cartRow[PB_NO]?>);"><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_list_del.gif"/></a>
						</td>
					</tr>
							<?
						}
					}

					/* 배송비설정 */
					if ($siteRow[S_DELIVERY_GROUP] == "G") $intDeliveryTotal = 0;
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
				<span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?>:</span> <strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($intCartPriceTotal)?></strong>
				<?if ($S_SITE_TAX == "Y"){?>
				 + <span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?>:</span> <strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($intCartPriceTotal * 0.1)?></strong>
				<?}?>
				<?if ($S_SITE_LNG == "KR" && $S_DELIVERY_GROUP == "N" || !$S_DELIVERY_GROUP){?>
				 + <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?>:</span> <strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($intDeliveryTotal)?></strong>
				<?}else{?>
				 + <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?>:</span> 배송비 설정 페이지 링크</strong>
				<?}?>
				=
				<span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?>:</span><strong class="priceOrange"><?=getCurMark()?> <?=getCurToPrice($intCartPriceEndTotal)?></strong>
			</div>
		</div><!-- cartListWrapBig -->