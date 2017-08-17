
<div class="cartListWrap">
	<div class="tableProdList">
		<table class="cartListTable">
			<colgroup>
				<col style="50px;"/>
				<col/>
				<col/>
				<col/>
				<col/>
				<?=($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR")?"<col/>":"";?>
			</colgroup>
			<tr>
				<th class="chkDiv"><input type="checkbox" id="chkAll" data_target="cartNo"/></th>				
				<th><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
				<th class="prodPriceDiv"><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></th>
				<th class="amountDiv"><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
				<th class="sumPriceDiv"><?=$LNG_TRANS_CHAR["OW00004"] //합계?></th>
				<?=($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR")?"<th>".$LNG_TRANS_CHAR['PW00012']."</th>":""; //배송비?>
			</tr>
			<?if ($intCartTotal == 0){?>
			<tr>
				<td colspan="6"><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></td>
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

					$strProdEventText		= $row['P_EVENT_TEXT'];					//상품이벤트표시
					$strProdStockOut		= $row['P_STOCK_OUT'];					//상품품절여부
					$strProdStockOutText	= $row['P_STOCK_OUT_TEXT'];				//상품품절여부

					$strProdCode			= $row['P_CODE'];
					$strProdLinkUrl			= $row['P_LINK_URL'];
					$strProdQtyDiscountText	= $row['P_QTY_DISCOUNT_TEXT'];
			?>
			<tr>
				<td><input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?=$intNo?>"/></td>
				<td class="prodInfo">
					<div class="listCartImg"><a href="<?=$strProdLinkUrl?>"><img src="<?=$strProdImgUrl?>" class="cartListImg"/></a></div>
					<div class="cartProdInfo">
						<ul>
							<li class="title">
								<a href="<?=$strProdLinkUrl?>"><?=$strProdName?><?=$strProdEventText?><?=$strProdStockOutText?></a>
							</li>
							<?if($strProdOpt){?>
								<li><?=$strProdOpt?></li>
							<?}?>
							<?if($strProdAddOpt){echo $strProdAddOpt;}?>
							<?if($strProdItem){echo $strProdItem;}?>
							<?if($strProdDeliveryInfo){echo $strProdDeliveryInfo;}?>
						</ul>
						<div class="btnWrap">
							<a href="javascript:goWish(<?=$intNo?>);" class="cartMovWishBtn"><span><?=$LNG_TRANS_CHAR["OW00089"] //나중에 주문?></span></a>
							<a href="javascript:goCartDel(<?=$intNo?>);" class="cartListDelBtn"><span><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></span></a>
						</div>
					</div>
					<div class="clr"></div>
				</td>
				<td>
					<strong class="priceBoldGray"><?=$strProdPrice?></strong><?=$strProdPriceOrg?>
					<?if($strProdAddPrice){?>
					<?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=$strProdAddPrice?><?=$strProdAddPriceOrg?>
					<?}?>
					<?if($strProdQtyDiscountText){echo $strProdQtyDiscountText;}?>
				</td>
				<td class="cntWrap">
					<a href="javascript:goQtyUpMinus('cart',-1,<?=$intNo?>);" class="btnDown">-</a>
					<input type="input" id="cartQty<?=$intNo?>" name="cartQty<?=$intNo?>" value="<?=$intQty?>" class="i_wCnt"/>
					<a href="javascript:goQtyUpMinus('cart',1,<?=$intNo?>);" class="btnUp">+</a>
					<p><a href="javascript:goQtyUpdate('cart',<?=$intNo?>);" class="cartCntModify"><span><?=$LNG_TRANS_CHAR["OW00072"] //수정?></span></a></p>
				</td>
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
	<div class="totalPriceWrap">
		<div class="priceInBox">
			<dl>
				<dd class="tot_1">
					<span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></span> 
					<strong><?=$strPriceLeftMark?> <?=$strCartPriceTotalText?></strong>
					<span><?=$strPriceRightMark?></span>
					<span><?=$strCartPriceTotalOrgText?></span>
					<?if ($S_SITE_TAX == "Y"){?>
						(<span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span> 
						<strong><?=$strPriceLeftMark?> <?=$strCartPriceTotalTaxText?><?=$strPriceRightMark?></strong>
						<span><?=$strCartPriceTotalTaxOrgText?></span>)
					<?}?>
				</dd>		

			
				<?//if($strCartDeliveryTotalText){?>
					<dd class="ico_plus">+</dd>
					<dd class="tot_2">
						<span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span> 
						<?=$strPriceLeftMark?> 
							<strong id="cartTotalDeliveryPrice"><?=$strCartDeliveryTotalText?></strong>
							<span><?=$strPriceRightMark?></span>
						<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalDeliveryOrgPrice"><?=$strCartDeliveryTotalOrgText?></span>)<?}?>
					</dd>
				<?//}?>

				<dd class="ico_equal">=</dd>
				<dd class="tot_3">
					<span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?></span>
					<?=$strPriceLeftMark?> 
						<strong id="cartTotalPrice"> <?=$strCartPriceEndTotalText?></strong>
						<span><?=$strPriceRightMark?></span>
					<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalOrgPrice"><?=$strCartPriceEndTotalOrgText?></span>)<?}?>
				</dd>
			</dl>
		</div>
	</div>
</div><!-- cartListWrap -->

<div class="cartBtnWrap">
	<?if ($strSearchHCode1){?>
		<a href="javascript:goProdList();" class="shoppingBigBtn_new"><span><?=$LNG_TRANS_CHAR["PW00024"] //쇼핑 계속?></span></a>
	<?}?>
	<a href="javascript:goCartAllDel();" class="prodDelBigBtn_new"><span><?=$LNG_TRANS_CHAR["OW00080"] //선택상품 삭제?></span></a>
	<a href="javascript:goWishAll();" class="wishBigBtn_new"><span><?=$LNG_TRANS_CHAR["PW00025"] //선택상품 담아두기?></span></a>
		<a href="javascript:goOrderJumun();" class="chkOrderBigBtn_new"><span><?=$LNG_TRANS_CHAR["OW00079"] //선택상품 주문?></span></a>
	


</div>