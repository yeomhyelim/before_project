
	<div class="cartListWrap mt20">
			<div class="tableProdList mt10">
				<table>
					<colgroup>
						<col/>
						<col/>
						<col/>
						<col/>
						<col/>
						<?=($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR")?"<col/>":"";?>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></th>
						<th><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
						<th><?=$LNG_TRANS_CHAR["OW00004"] //합계?></th>
						<?=($S_MALL_TYPE != "R"  && $S_SITE_LNG == "KR")?"<th>".$LNG_TRANS_CHAR['PW00012']."</th>":""; //배송비?>
					</tr>
					<?if ($intCartTotal == 0){?>
					<tr>
						<td colspan="4"><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></td>
					</tr>
					<?}else{
						foreach($arrCartRow as $key => $row)
						{
							$intNo					= $row['OC_NO'];						//장바구니번호
							$strProdImgUrl			= $row['PM_REAL_NAME'];					//상품이미지URL
							$strProdName			= $row['P_NAME'];						//상품명
							$strProdOpt				= $row['P_OPT'];						//상품옵션
							$strProdAddOpt			= $row['P_ADD_OPT'];					//상품추가옵션
							$strProdItem			= $row['P_ITEM'];						//상품항목
							$strProdDeliveryInfo	= $row['P_DELIVERY_INFO'];				//상품배송정보
							$strProdPrice			= $row['P_PRICE'];						//상품가격
							$strProdPriceOrg		= $row['P_PRICE_ORG'];					//상품가격
							$strProdAddPrice		= $row['P_ADD_PRICE'];					//상품추가옵션가격
							$strProdAddPriceOrg		= $row['P_ADD_PRICE_ORG'];
							$intQty					= $row['P_QTY'];						//상품수량
							$strCartPrice			= $row['CART_PRICE'];					//상품총합계
							$strCartPriceOrg		= $row['CART_PRICE_ORG'];
							$strProdShopDelivery	= $row['P_SHOP_DELIVERY'];				//상품입점사별 배송비
							$intRowSpan				= $row['ROWSPAN'];
					?>
					<tr>
						<td class="prodInfo">
							<img src="<?=$strProdImgUrl?>" style="width:50px;"/>
							<ul>
								<li><?=$strProdName?><?=$strProdEventText?></li>
								<?if($strProdOpt){?><li><?=$strProdOpt?></li><?}?>
								<?if($strProdAddOpt){echo $strProdAddOpt;}?>
								<?if($strProdItem){echo $strProdItem;}?>
								<?if($strProdDeliveryInfo){echo $strProdDeliveryInfo;}?>
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<strong class="priceBoldGray"><?=$strProdPrice?></strong><?=$strProdPriceOrg?>
							<?if($strProdAddPrice){?>
							<?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=$strProdAddPrice?><?=$strProdAddPriceOrg?>
							<?}?>
						</td>
						<td><?=$intQty?></td>
						<td>
							<strong class="priceOrange"><?=$strCartPrice?></strong><?=$strCartPriceOrg?>
						</td>
						<?if ($strProdShopDelivery){?>
						<td rowspan="<?=$intRowSpan?>"><?=$strProdShopDelivery?></td>
						<?}?>
					</tr>
					<?  }}?>
				</table>
			</div><!-- tableProdList -->
			<div class="totalPriceWrap">

				<span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?>:</span>
				<?=$strPriceLeftMark?> <strong class="priceBoldGray"><?=$strCartPriceTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalOrgText?>

				<?if ($S_SITE_TAX == "Y"){?>
				 + <span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?>:</span>
				<?=$strPriceLeftMark?> <strong class="priceBoldGray"><?=$strCartPriceTotalTaxText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalTaxOrgText?>
				<?}?>

				<?if ($strCartPricePgCommissionText){?>
				 + <span><?=$LNG_TRANS_CHAR["OW00112"] //수수료?>:</span>
				<?=$strPriceLeftMark?> <strong class="priceBoldGray"><?=$strCartPricePgCommissionText?></strong><?=$strPriceRightMark?><?=$strCartPricePgCommissionOrgText?>
				<?}?>

				<?if($strCartDeliveryTotalText){?>
				 + <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?>:</span>
				 <?=$strPriceLeftMark?> <strong class="priceBoldGray"><?=$strCartDeliveryTotalText?></strong><?=$strPriceRightMark?><?=$strCartDeliveryTotalOrgText?>
				<?}?>

				<?if ($strCartMemberDiscountPriceText){?>
				- <span><?=$LNG_TRANS_CHAR["OW00070"] //추가할인금액?>:</span>
				<?=$strPriceLeftMark?> <strong class="priceBoldGray"><?=$strCartMemberDiscountPriceText?></strong><?=$strPriceRightMark?><?=$strCartMemberDiscountPriceOrgText?>
				<?}?>

				<?if ($strCartUsePointPriceText){?>
				- <span><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?>:</span> <strong class="priceBoldGray"><?=$strCartUsePointPriceText?></strong>
				<?}?>

				<?if ($strCartUseCouponPriceText){?>
				- <span><?=$LNG_TRANS_CHAR["OW00081"] //사용쿠폰?>:</span>
				<?=$strPriceLeftMark?> <strong class="priceBoldGray"><?=$strCartUseCouponPriceText?></strong><?=$strPriceRightMark?>
				<?}?>
				=
				<span><?=$LNG_TRANS_CHAR["OW00026"] //최종결제금액?>:</span>
				<?=$strPriceLeftMark?> <strong class="priceOrange"> <?=$strCartPriceEndTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceEndTotalOrgText?>
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