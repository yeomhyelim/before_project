	<div class="cartListWrap mt20">
			<div class="cartTabWrap">
				<span class="tabBtn1"><?=$LNG_TRANS_CHAR["OW00021"] //내 주문건수?>(<?=NUMBER_FORMAT($intCartTotal)?>)</span>
			</div>
			<div class="tableProdList mt10">
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
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($cartRow[OC_CUR_PRICE],2)?></strong>
							<?if ($cartRow[OC_OPT_ADD_PRICE]){?><br><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=getCurMark()?>  <?=getFormatPrice($cartRow[OC_OPT_ADD_CUR_PRICE],2)?><?}?>
						</td>
						<td>
							<?=$cartRow[OC_QTY]?>
						</td>
						<td><strong class="priceOrange"><?=getCurMark()?> <?=getFormatPrice($intCartPrice,2)?></strong></td>
						
					</tr>
							<?
						}
					}

					?>
					
				</table>
			</div><!-- tableProdList -->
			<div class="totalPriceWrap">
				<span><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?>:</span> <?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_CUR_PRICE],2)?></strong> +
				<span><?=$LNG_TRANS_CHAR["OW00027"] //배송비?>:</span> <?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],2)?></strong> 
				<?if ($orderRow[O_USE_POINT]){?>
				- <span><?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?>:</span> <?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_USE_CUR_POINT],2)?></strong>
				<?}?>
				=
				<span><?=$LNG_TRANS_CHAR["OW00029"] //최종결제금액?>:</span> <?=getCurMark()?> <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_CUR_SPRICE],2)?></strong>
			</div>
		</div><!-- cartListWrap -->