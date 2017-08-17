<div class="cartListWrap mt20">
	<div class="cartTabWrap">
		<span class="tabBtn1"><?=$LNG_TRANS_CHAR["CW00004"]?>(<?=NUMBER_FORMAT($intCartTotal)?>)</span>
	</div>
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
				<th class="chkDiv"><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></th>
				<th class="amountDiv"><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
				<th class="totalDiv"><?=$LNG_TRANS_CHAR["OW00004"] //합계?></th>
				<?=($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR")?"<th>".$LNG_TRANS_CHAR['PW00012']."</th>":""; //배송비?>
			</tr>
			<?if ($intCartTotal == 0){?>
			<tr>
				<td colspan="5"><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></td>
			</tr>
			<?} else {?>
			<?
				foreach($arrCartRow as $key => $row)
				{
					$intNo					= $row['PB_NO'];						//장바구니번호
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
				<input type="hidden" id="cartNo[]" name="cartNo[]" value="<?=$intNo?>"/>
				<td class="prodInfo">
					<img src="<?=$strProdImgUrl?>" style="width:50px;"/>
					<ul>
						<li class="title"><?=$strProdName?><?=$strProdEventText?></li>
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
	<?if ($strOrderTotalDiscountText){?>
	<div class="totalDiscountPriceWrap"><?=$strOrderTotalDiscountText?>
	<br><span><?=$strOrderTotalDiscountRateText?></span>:<span><?=$strOrderTotalDiscountPriceText?></span>
	</div>
	<?}?>
	<div class="totalPriceWrap" >
	
<!-- 
		<span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></span> 
		<strong class="priceBoldGray"><?=$strPriceLeftMark?> <?=$strCartPriceTotalText?></strong><span><?=$strPriceRightMark?></span><?=$strCartPriceTotalOrgText?>

		<?if ($S_SITE_TAX == "Y"){?>
		 <span class="ico_plus">+</span> <span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span> 
		 <strong class="priceBoldGray"><?=$strPriceLeftMark?> <?=$strCartPriceTotalTaxText?></strong><span><?=$strPriceRightMark?></span><?=$strCartPriceTotalTaxOrgText?>
		<?}?>
		
		 <span class="ico_plus">+</span> <span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span> 
		 <?=$strPriceLeftMark?> <strong class="priceBoldGray" id="cartTotalDeliveryPrice"><?=$strCartDeliveryTotalText?></strong><span><?=$strPriceRightMark?></span>
		<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalDeliveryOrgPrice"><?=$strCartDeliveryTotalOrgText?></span>)<?}?>
		<span class="ico_same">=</span>

		<span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?></span>
		<?=$strPriceLeftMark?> <strong class="priceOrange" id="cartTotalPrice"> <?=$strCartPriceEndTotalText?></strong><span><?=$strPriceRightMark?></span>
		<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalOrgPrice"><?=$strCartPriceEndTotalOrgText?></span>)<?}?>

		<?if ($S_PG_COMMISSION == "Y" && ($S_PG_CARD_COMMISSION > 0)){?>
		<span id="cartPgCommission"></span>
		<?}?>
-->

<table>
			<colgroup>
				<col width="35px"/>
				<col width="180px" >
				<col align="right"/>
			</colgroup>
	<tr>
		<td></td>
		<td><span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></span> </td>
		<td><?=$strPriceLeftMark?><strong class="priceBoldGray"> <?=$strCartPriceTotalText?></strong><span><?=$strPriceRightMark?></span><?=$strCartPriceTotalOrgText?></td>
	</tr>
	<?if ($S_SITE_TAX == "Y"){?>
	<tr>
		<td><span class="ico_plus">+</span></td>
		<td><span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span> </td>
		<td><strong class="priceBoldGray"><?=$strPriceLeftMark?> <?=$strCartPriceTotalTaxText?></strong><span><?=$strPriceRightMark?></span><?=$strCartPriceTotalTaxOrgText?></td>
	</tr>	
	<?}?>
	<tr>
		<td><span class="ico_plus">+</span></td>
		<td><span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span> </td>
		<td><?=$strPriceLeftMark?> <strong class="priceBoldGray" id="cartTotalDeliveryPrice"><?=$strCartDeliveryTotalText?></strong><span><?=$strPriceRightMark?></span>
		<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalDeliveryOrgPrice"><?=$strCartDeliveryTotalOrgText?></span>)<?}?></td>
	</tr>
	<tr>
		<td><span class="ico_same">=</span></td>
		<td><span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?></span></td>
		<td><?=$strPriceLeftMark?> <strong class="priceOrange" id="cartTotalPrice"> <?=$strCartPriceEndTotalText?></strong><span><?=$strPriceRightMark?></span>
		<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalOrgPrice"><?=$strCartPriceEndTotalOrgText?></span>)<?}?></td>
	</tr>
</table>
				
		
	</div>
</div><!-- cartListWrap -->
