<div class="tableOrderForm">
	<h4><span><?=$LNG_TRANS_CHAR["OW00116"] //구매상품?>(<?=NUMBER_FORMAT($intCartTotal)?>)</span></h4>
	<div class="tableCartList">
		
		<?
		if ($intCartTotal == 0){
		?>
			<?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?>
		<?
		} else {
			$intCartPrice = $intCartPriceTotal = $intCartPointTotal = 0;
			
			while ($cartRow = mysql_fetch_array($cartResult)){
				
				/* 입점형/프랜차이즈일때 */
				if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){
					$intRowSpan = 0;
					if (!$intShopNo) {
						$intShopNo	= $cartRow[P_SHOP_NO];
						$intRowSpan = $aryProdCartShopList[$cartRow[P_SHOP_NO]][CART_CNT]; 
					}

					if ($intShopNo && $intShopNo != $cartRow[P_SHOP_NO]) {
						$intShopNo	= $cartRow[P_SHOP_NO];
						$intRowSpan = $aryProdCartShopList[$cartRow[P_SHOP_NO]][CART_CNT]; 
					}
				}

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
							<div class="prodListImg"><img src="<?=$cartRow[PM_REAL_NAME]?>"/></div>
							<div class="detailProdInfo">
								<ul>
									<li class="title"><?=$cartRow[P_NAME]?><?=$strProdEventText?></li>
									<li><?=$strCartOptAttrVal?></li>
									<li>
										<?=$LNG_TRANS_CHAR["OW00002"] //상품금액?>
										<strong class="priceBoldGray"><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($cartRow[OC_PRICE],2,$orderRow['O_USE_CUR'])?></strong></li>
									<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
									?>
									<li><?=$LNG_TRANS_CHAR["OW00006"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
									<?}}?>
									
									<?if ($cartRow[OC_OPT_ADD_PRICE] > 0){?>
									<li><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getFormatPrice($cartRow[OC_OPT_ADD_PRICE],2,$orderRow['O_USE_CUR'])?></li>
									<?}?>
								</ul>
							</div>
							<div class="clr"></div>
							<div class="buyInfo">
								<?=$LNG_TRANS_CHAR["PW00019"]//구매수량?>: <?=$cartRow[OC_QTY]?> 
								 X <strong class="priceOrange"><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($intCartPrice,2,$orderRow['O_USE_CUR'])?></strong>
								 
								 <strong class="price">
									<?if ($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR"){?>
									<?=($intRowSpan >= 1) ? "<span>".getCurMark()." ".getCurToPrice($aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE])." </span>":"";?>
									<?}?></strong>
							</div>
						</div><!-- prodInfo //-->
				<?
			}
		}

		?>
			
	</div><!-- tableProdList -->
	<div class="topalPriceInfoList">
		<ul>
			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></span>
				<span class="valueTxt">
					<strong><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($intCartPriceTotal,2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong>
				</span><div class="clr"></div>
			</li>
			<?if ($S_SITE_TAX == "Y"){?>
			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>
				<span class="valueTxt">
					<strong><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($orderRow[O_TAX_PRICE],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong>
				</span><div class="clr"></div>
			</li>
			<?}?>
			<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["OW00070"] //추가할인금액?></span>
				<span class="valueTxt">
					<strong><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_PRICE],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong>
				</span><div class="clr"></div>
			</li>
			<?}?>
			<?if ($orderRow[O_USE_POINT] > 0){?>
			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></span>
				<span class="valueTxt">
					<strong><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($orderRow[O_USE_POINT],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong>
				</span><div class="clr"></div>
			</li>
			<?}?>
			<?if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH){?>
			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
				<span class="valueTxt">
					<strong><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($orderRow[O_TOT_DELIVERY_PRICE],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong>
				</span><div class="clr"></div></li>
			<?}?>
			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?></span>
				<span class="valueTxt">
					<strong class="price"><?=getCurMark($orderRow['O_USE_CUR'])?> <?=getFormatPrice($orderRow[O_TOT_SPRICE],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong>
				</span><div class="clr"></div>
			</li>
		</ul>
	</div>
</div><!-- cartListWrap -->