		<div class="tableOrderForm">
			<div class="titBox"><span class="barRed"></span><span class="tit">구매상품 정보</span></div>

			<div class="tableCartList">
					<?
					if ($intCartTotal == 0){
					?>
					<tr>
						<td><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></td>
					</tr>
					<?
					} else {
						$intCartPrice = $intCartPriceTotal = $intCartPointTotal = $intCartDeliveryPriceTotal = 0;
						
						while ($cartRow = mysql_fetch_array($cartResult)){
							
							$intCartPrice = ($cartRow[OC_PRICE] * $cartRow[OC_QTY]) + $cartRow[OC_OPT_ADD_PRICE];
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

							$strProdEventText = "";
							if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
								if ($cartRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"%")).")";
								else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow[P_EVENT],"")).")";
							}
							?>
				<div class="prodInfoWrap">
					<div class="prodInfo">
							<div class="prodListImg"><img src="..<?=$cartRow[PM_REAL_NAME]?>"/></div>
								<div class="detailProdInfo">
									<ul>
										<li class="title"><?=$cartRow[P_NAME]?><?=$strProdEventText?></li>
										<!--<li><?=$strCartOptAttrVal?></li>-->

										<?if (is_array($aryProdCartAddOptList)){
											for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
											
											?>
											<li><?=$LNG_TRANS_CHAR["OW00006"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
										<?}}?>
										<li>
											<span>구매수량</span>
											<strong><?=$cartRow[OC_QTY]?></strong>
										</li>
										<li class="priceSubInfo">
											<span>제품가격</span>
											<?if ($cartRow[OC_OPT_ADD_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getFormatPrice($cartRow[OC_OPT_ADD_PRICE],2)?><?=getCurMark2()?><?}?>

							
											<strong class="priceOrange"><?=getCurMark()?> <?=getFormatPrice($intCartPrice,2)?><?=getCurMark2()?></strong></td>
											<?if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){?>
											<?=($intRowSpan >= 1) ? "<td rowspan=\"".$intRowSpan."\">".getCurMark()." ".getCurToPrice($aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE])."":"";?>
											<?}?>
										</li>
									</ul>
								</div>
								<div class="clr"></div>
							</div>
						</div>
							
							<?
						}
					}

					?>
					
			</div><!-- tableProdList -->
		</div>