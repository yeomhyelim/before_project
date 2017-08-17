	<div class="cartListWrap">

			<div class="tableProdList">
				<table>
					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00022"] //상품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?></th>
						<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
						<th><?=$LNG_TRANS_CHAR["OW00026"] //합계?></th>
					</tr>
					<?
					if ($intCartTotal == 0){
					?>
					<tr>
						<td colspan="4"><?=$LNG_TRANS_CHAR["OS00003"] //주문바구니에 담긴 상품이 없습니다.?></td>
					</tr>
					<?
					} else {
						$intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;
						
						while ($cartRow = mysql_fetch_array($cartResult)){

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

													
							?>
					<tr>
						<td class="prodInfo">
							<img src="<?=$cartRow[PM_REAL_NAME]?>" style="width:50px;"/>
							<ul>
								<li><?=$cartRow[P_NAME]?></li>
								<li><?=$strCartOptAttrVal?></li>

								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
									
									?>
									<li><?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
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
							</ul>
							<div class="clr"></div>
						</td>
						<td>
							<?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($cartRow[OC_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong>
							<?if ($cartRow[OC_OPT_ADD_PRICE]){?><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=getCurMark()?>  <?=getFormatPrice($cartRow[OC_OPT_ADD_CUR_PRICE],2,$orderRow['O_USE_LNG'])?><?=getCurMark2($S_ST_CUR)?><?}?>
						</td>
						<td>
							<?=$cartRow[OC_QTY]?>
						</td>
						<td><strong class="priceOrange"><?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($intCartPrice,2,$S_ST_CUR)?> <?=getCurMark2($S_ST_CUR)?></strong></td>
						
					</tr>
							<?
						}
					}

					?>
					
				</table>
			</div><!-- tableProdList -->
			<div class="totalPriceWrap">
				<span><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong> +
				
				<?if ($S_SITE_TAX == "Y"){?>
				<span><?=$LNG_TRANS_CHAR["OW00084"] //부과세?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TAX_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong> + 
				<?}?>

				<?if ($S_PG_COMMISSION == "Y" && $orderRow['O_TOT_PG_COMMISSION'] > 0){?>
				<span><?=$LNG_TRANS_CHAR["OW00157"] //수수료?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_PG_CUR_COMMISSION],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong> +
				<?}?>
				
				<span><?=$LNG_TRANS_CHAR["OW00027"] //배송비?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong>
				
				<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00115"] //추가할인금액?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong>
				<?}?>

				<?if ($orderRow[O_USE_POINT]>0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?>:</span> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_USE_CUR_POINT],2)?></strong>
				<?}?>

				<?if ($orderRow[O_USE_COUPON] > 0){?>
				- <span><?=$LNG_TRANS_CHAR["OW00116"] //사용쿠폰?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_USE_CUR_COUPON],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong>
				<?}?>

				=
				<span><?=$LNG_TRANS_CHAR["OW00029"] //최종결제금액?>:</span> <?=getCurMark($S_ST_CUR)?> <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_CUR_SPRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong>
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