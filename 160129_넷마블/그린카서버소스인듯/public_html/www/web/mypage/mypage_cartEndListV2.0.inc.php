		<div class="cartListWrap mt20">
			<div class="tableProdList mt10">
				<table>
					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
						<?=($S_MALL_TYPE != "R" && $orderRow['O_USE_LNG'] == "KR")?"<col/>":"";?>
						<col/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></th>
						<th><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
						<th><?=$LNG_TRANS_CHAR["OW00004"] //합계?></th>
						<?=($S_MALL_TYPE != "R"  && $orderRow['O_USE_LNG'] == "KR")?"<th>".$LNG_TRANS_CHAR['PW00012']."</th>":""; //배송비?>
						<th><?="배송/구매상태"?></th>
					</tr>
					<?
					if ($intCartTotal == 0){
					?>
					<tr>
						<td colspan="5"><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></td>
					</tr>
					<?
					} else {
						$intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;

						while ($cartRow = mysql_fetch_array($cartResult)){

							/* 입점형/프랜차이즈일때 */
							if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){
								$intRowSpan = 0;
								if (($intShopNo != "0" && !$intShopNo) || ($intShopNo != $cartRow[P_SHOP_NO])) {
									$intShopNo	= ($cartRow[P_SHOP_NO])?$cartRow[P_SHOP_NO]:"0";
									$intRowSpan = $aryProdCartShopList[$intShopNo][CART_CNT];
								}else {
									$intRowSpan = 0;
								}
							}

							$intCartPrice = ($cartRow[OC_CUR_PRICE] * $cartRow[OC_QTY]) + $cartRow[OC_OPT_ADD_CUR_PRICE];
							$intCartPriceTotal += $intCartPrice;

							$orderMgr->setOC_NO($cartRow[OC_NO]);
							$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);

							$strCartOptAttrVal = "";
							for($kk=1;$kk<=10;$kk++){
								if ($cartRow["OC_OPT_ATTR".$kk]){
									$strCartOptAttrVal .= "/".$cartRow["OC_OPT_ATTR".$kk];
								}
							}
							$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

							$aryCartItemList = "";
							if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
								$aryCartItemList = $orderMgr->getOrderCartItemList($db);
							}

							$strProdEventText = "";
							if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
								//if ($cartRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"%")).")";
								//else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"")).")";
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


							//구매확정 상태가 아니고, 배송완료 일 시 남덕희
							if ($cartRow['OC_ORDER_STATUS'] != 'E' && $cartRow['OC_DELIVERY_STATUS'] == "D")
							{
								$btnDeliverE = "<ul class=\"deliveryInfo\"><li><a href=\"javascript:goOrderCeritySaveActEvent(".$cartRow['OC_NO'].");\" class=\"deliveryChkBtn\"><span>".$LNG_TRANS_CHAR["OW00100"]."</span></a></li></ul>";
							}


							/* 배송 정보 */
							$strOrderDeliveryUrl = $strDeliveryInfoHtml = "";
							if ($cartRow['OC_DELIVERY_STATUS'] == "I" || $cartRow['OC_DELIVERY_STATUS'] == "D")
							{
								if ($cartRow['OC_DELIVERY_COM'] && $cartRow['OC_DELIVERY_NUM']){

									if ((!$orderRow['O_PG'] || $orderRow['O_PG'] == "K")){
										$strOrderDeliveryUrl = str_replace("{dev_no}",$cartRow['OC_DELIVERY_NUM'],$aryDeliveryUrl[$cartRow['OC_DELIVERY_COM']]);
									}

									$strDeliveryInfoHtml .= "<ul class=\"deliveryInfo\">";
									$strDeliveryInfoHtml .= "	<li><strong>".$aryDeliveryCom[$cartRow['OC_DELIVERY_COM' ]]."</strong></li>";
									$strDeliveryInfoHtml .= "	<li><strong>".$cartRow['OC_DELIVERY_NUM']."</strong></li>";
									$strDeliveryInfoHtml .= "	<li><a href=\"".$strOrderDeliveryUrl."\" class=\"deliveryChkBtn\" target=\"_blank\"><span>배송추적</span></a></li>";
									$strDeliveryInfoHtml .= "</ul>";
								}
							}

							?>
					<tr>
						<td class="prodInfo">
							<img src="<?=$cartRow[PM_REAL_NAME]?>" style="width:50px;"/>
							<ul>
								<li><a href="./?menuType=product&mode=view&prodCode=<?=$cartRow[P_CODE]?>"><?=$cartRow[P_NAME]?><?=$strProdEventText?></a></li>
								<li><?=$strCartOptAttrVal?></li>

								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){

									?>
									<li><?=$LNG_TRANS_CHAR["OW00006"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
								<?}}?>
								<?
								if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
									if (is_array($aryCartItemList)){
										for($k=0;$k<sizeof($aryCartItemList);$k++){
											?>
											<li><?=$aryCartItemList[$k]['OCI_ITEM_NM']?>:<?=$aryCartItemList[$k]['OCI_ITEM_VAL']?></li>
											<?
										}
									}
								}
								?>
								<?=$strBaesongPrice?>

							</ul>

							<div class="clear"></div>
						</td>
						<td>
							<strong class="priceBoldGray"><?=getCurMark($orderRow["O_USE_CUR"])?> <?=getFormatPrice($cartRow[OC_PRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong>
							<?if ($cartRow[OC_OPT_ADD_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getCurMark($orderRow["O_USE_CUR"])?> <?=getFormatPrice($cartRow[OC_OPT_ADD_PRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?><?}?>
						</td>
						<td>
							<?=$cartRow[OC_QTY]?>
						</td>
						<td><strong class="priceOrange"><?=getCurMark($orderRow["O_USE_CUR"])?> <?=getCurToPrice($intCartPrice,$orderRow["O_USE_LNG"],$orderRow["O_USE_CUR_RATE"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong></td>
						<?

							$param	= "";
							if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){
								if ($intRowSpan >= 1) {
									$param["o_no"]		= $cartRow['O_NO'];
									$param["shop_no"]	= $cartRow['P_SHOP_NO'];
									$shopOrderRow		= $orderMgr->getShopOrderView($db,$param);
						?>
						<td rowspan="<?=$intRowSpan?>">
							<?if ($intRowSpan == $aryProdCartShopList[$cartRow[P_SHOP_NO]]['AFTER_CHARGE_CNT'] && $aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE] == 0){?>
							<?=$LNG_TRANS_CHAR["PW00049"] //착불?>
							<?}else{?>
							<?=getCurMark($orderRow["O_USE_CUR"])?><?=getCurToPrice($aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE])?><?=getCurMark2($orderRow["O_USE_CUR"])?>
							<?}?>

						</td>
						<?
								}
							}?>
						<td>
							<?=$S_ARY_SETTLE_STATUS[SUBSTR($cartRow['OC_ORDER_STATUS'],0,1)]?>
							<?=(!$cartRow['OC_ORDER_STATUS']) ? $strDeliveryInfoHtml : "";?>
							<?=$btnDeliverE?>
						</td>
					</tr>
							<?
						}
					}

					?>

				</table>
			</div><!-- tableProdList -->
			<div class="totalPriceWrap">
				<span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?>:</span> <?=getCurMark($orderRow["O_USE_CUR"])?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_PRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong>
				<?if ($S_SITE_TAX == "Y"){?>
				+ <span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?>:</span> <?=getCurMark($orderRow["O_USE_CUR"])?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TAX_PRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong>
				<?}?>

				<?if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){ //주문시 배송정보를 사용하지 않을때?>

				+ <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?>:</span> <?=getCurMark($orderRow["O_USE_CUR"])?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_DELIVERY_PRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong>

				<?}?>
				<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00070"] //추가할인금액?>:</span> <?=getCurMark($orderRow["O_USE_CUR"])?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_PRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong>
				<?}?>

				<?if ($orderRow[O_USE_POINT] > 0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?>:</span> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_USE_POINT],2,$orderRow["O_USE_CUR"])?></strong>
				<?}?>

				<?if ($orderRow[O_USE_COUPON] > 0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00115"] //사용쿠폰?>:</span> <?=getCurMark($orderRow["O_USE_CUR"])?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_USE_CUR_COUPON],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong>
				<?}?>

				=
				<span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?>:</span><?=getCurMark($orderRow["O_USE_CUR"])?> <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_SPRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong>
			</div>
		</div><!-- cartListWrap -->

		<?if (is_array($aryOrderGiftList)){?>
		<div class="cartListWrap mt20">
			<div class="tableProdList mt10">
				<table>
					<colgroup>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00101"] //사은품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
					</tr>
					<?for($j=0;$j<sizeof($aryOrderGiftList);$j++){?>
					<tr>
						<td class="prodInfo">
							<img src="..<?=$aryOrderGiftList[$j][CG_FILE]?>" style="width:50px;"/>
							<ul>
								<li><?=$aryOrderGiftList[$j][CG_NAME]?></li>
								<li><?=$aryOrderGiftList[$j][OG_OPT]?></li>
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<?=$aryOrderGiftList[$j][OG_QTY]?>
						</td>
					</tr>
					<?}?>
				</table>
			</div>
		</div>
		<?}?>