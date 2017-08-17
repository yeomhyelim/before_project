	<div class="cartListWrap">
			<div class="tableProdList">
				<table>
					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
						<?if ($orderRow['O_USE_LNG'] == 'KR'){?><col/><?}?>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00022"] //상품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?></th>
						<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
						<th><?=$LNG_TRANS_CHAR["OW00026"] //합계?></th>
						<?if ($orderRow['O_USE_LNG'] == 'KR'){?><th><?="배송비" //배송비?></th><?}?>
					</tr>
					<?
					if ($intCartTotal == 0){
					?>
					<tr>
						<td colspan="5"><?=$LNG_TRANS_CHAR["OS00003"] //주문바구니에 담긴 상품이 없습니다.?></td>
					</tr>
					<?
					} else {
						$intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;

						while ($cartRow = mysql_fetch_array($cartResult)){

							$intRowSpan = 0;
							if (($intShopNo != "0" && !$intShopNo) || ($intShopNo != $cartRow[P_SHOP_NO])) {
								$intShopNo	= ($cartRow[P_SHOP_NO])?$cartRow[P_SHOP_NO]:"0";
								$intRowSpan = $aryProdCartShopList[$intShopNo][CART_CNT];
							}else {
								$intRowSpan = 0;
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

							/* 상품에 착불가격이 있는 경우 */
							## P_BAESONG_TYPE = 1 : 기본 배송
							## P_BAESONG_TYPE = 2 : 무료 배송
							## P_BAESONG_TYPE = 3 : 고정 배송		배송비 보임
							## P_BAESONG_TYPE = 4 : 수량별 배송		배송비 보임
							## P_BAESONG_TYPE = 5 : 착불 배송		배송비 보임
							if($orderRow['O_USE_LNG'] == "KR"):
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
						<td class="prodInfo">
							<img src="<?=$cartRow[PM_REAL_NAME]?>" style="width:50px;"/>
							<ul>
								<li><?=$cartRow[P_NAME]?></li>
								<li><?=$strCartOptAttrVal?>
									<? if ( ! empty ( $cartRow['OC_ORDER_STATUS'] ) && array_search ( substr ( $cartRow['OC_ORDER_STATUS'] , 0 , 1 )  , array ( 'C' , 'S' , 'R' , 'T' ) ) !== false ) :
									echo '&nbsp;&nbsp;<span style="font-weight:bold; color:red;">' ;
									switch ( substr ( $cartRow['OC_ORDER_STATUS'] , 0 , 1 ) )
									{
										case 'C' : $cStatus = '취소' ; break ;
										case 'S' : $cStatus = '교환' ; break ;
										case 'R' : $cStatus = '반품' ; break ;
										case 'T' : $cStatus = '환불' ; break ;
									}
									echo '['. $cStatus . ( substr ( $cartRow['OC_ORDER_STATUS'] , -1 ) == 1 ? '신청' : '완료' ) . ']' ;
									echo '</span>';
									endif ; ?>
								</li>

								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){

									?>
									<li><?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
								<?}}?>
								<?if ($strBaesongPrice){?><li><?=$strBaesongPrice?></li><?}?>
							</ul>
							<div class="clr"></div>
						</td>
						<td>
							<?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($cartRow[OC_CUR_PRICE],2)?></strong>
							<?if ($cartRow[OC_OPT_ADD_PRICE]){?><br><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=getCurMark()?>  <?=getFormatPrice($cartRow[OC_OPT_ADD_CUR_PRICE],2)?><?}?>
						</td>
						<td>
							<?=$cartRow[OC_QTY]?>
						</td>
						<td><strong class="priceOrange"><?=getCurMark()?> <?=getFormatPrice($intCartPrice,2)?></strong></td>
						<?
							$strDeliveryInfoHtml	= "";
							$param					= "";

							if ($orderRow['O_USE_LNG'] == 'KR'){
								if ($intRowSpan >= 1) {
									$param["o_no"]		= $cartRow['O_NO'];
									$param["shop_no"]	= $cartRow['P_SHOP_NO'];
									$shopOrderRow = $orderMgr->getShopOrderView($db,$param);

									if ($orderRow['O_STATUS'] == "I" || $orderRow['O_STATUS'] == "D"){
										$strOrderDeliveryUrl = "";
										if ($shopOrderRow['SO_DELIVERY_COM'] && $shopOrderRow['SO_DELIVERY_NUM']){

											if ((!$orderRow['O_PG'] || $orderRow['O_PG'] == "K")){
												$strOrderDeliveryUrl = str_replace("{dev_no}",$shopOrderRow['SO_DELIVERY_NUM'],$aryDeliveryUrl[$shopOrderRow['SO_DELIVERY_COM']]);
												echo $aryDeliveryUrl[$shopOrderRow['SO_DELIVERY_NUM']]."<Br>";
											}

											$strDeliveryInfoHtml .= "<ul class=\"deliveryInfo\">";
											$strDeliveryInfoHtml .= "	<li><strong>".$aryDeliveryCom[$shopOrderRow['SO_DELIVERY_COM' ]]."</strong></li>";
											$strDeliveryInfoHtml .= "	<li><strong>".$shopOrderRow['SO_DELIVERY_NUM']."</strong></li>";
											$strDeliveryInfoHtml .= "	<li><a href=\"".$strOrderDeliveryUrl."\" target=\"_blank\">[배송추적]</a></li>";
											$strDeliveryInfoHtml .= "</ul>";
										}
									}
						?>
						<td rowspan="<?=$intRowSpan?>">
							<?if ($intRowSpan == $aryProdCartShopList[$cartRow[P_SHOP_NO]]['AFTER_CHARGE_CNT'] && $aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE] == 0){?>
							<?=$LNG_TRANS_CHAR["PW00049"] //착불?>
							<?}else{?>
							<?=getCurMark($orderRow["O_USE_CUR"])?><?=getCurToPrice($aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE])?><?=getCurMark2($orderRow["O_USE_CUR"])?>
							<?}?>
							<?=$strDeliveryInfoHtml?>
						</td>
						<?
								}
							}
						?>
					</tr>
							<?
						}
					}

					?>

				</table>
			</div><!-- tableProdList -->
			<div class="totalPriceWrap">
				<span><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong> +

				<?if ($S_SITE_TAX == "Y"){?>
				+ <span><?=$LNG_TRANS_CHAR["OW00084"] //부과세?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TAX_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong>
				<?}?>

				<span><?=$LNG_TRANS_CHAR["OW00027"] //배송비?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong>

				<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00115"] //추가할인금액?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong>
				<?}?>

				<?if ($orderRow[O_USE_POINT]>0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?>:</span> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_USE_CUR_POINT],2)?></strong>
				<?}?>

				<?if ($orderRow[O_USE_COUPON] > 0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00116"] //사용쿠폰?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_USE_CUR_COUPON],2)?><?=getCurMark2($S_ST_CUR)?></strong>
				<?}?>

				=
				<span><?=$LNG_TRANS_CHAR["OW00029"] //최종결제금액?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_CUR_SPRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong>
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
						<th><?=$LNG_TRANS_CHAR["OW00117"] //사은품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
					</tr>
					<?for($j=0;$j<sizeof($aryOrderGiftList);$j++){?>
					<tr>
						<td class="prodInfo">
							<img src="<?=$aryOrderGiftList[$j][CG_FILE]?>" style="width:50px;"/>
							<ul>
								<li><?=$aryOrderGiftList[$j][CG_NAME]?></li>
								<li><?=$aryOrderGiftList[$j][OG_OPT]?></li>
							</ul>
							<div class="clr"></div>
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