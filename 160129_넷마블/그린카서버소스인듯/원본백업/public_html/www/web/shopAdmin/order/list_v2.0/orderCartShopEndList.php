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
							<div class="clr"></div>
						</td>
						<td>
							<?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($cartRow[OC_CUR_PRICE],2)?></strong>
							<?if ($cartRow[OC_OPT_ADD_PRICE]){?><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=getCurMark()?>  <?=getFormatPrice($cartRow[OC_OPT_ADD_CUR_PRICE],2)?><?}?>
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