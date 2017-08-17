<div class="tableOrderForm">
	<!--<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["CW00003"] //내 장바구니?></span></div>-->

		<div class="tableCartList">
		<?if ($intCartTotal == 0){?>
		<?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?>
		<?} else {

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

				$strProdCode			= $row['P_CODE'];
					?>
					<div class="prodInfoWrap">
						<div class="prodInfo">
							<div class="prodListImg"><a href="./?menuType=product&mode=view&prodCode=<?=$strProdCode?>"><img src="..<?=$strProdImgUrl?>"/></a></div>
							<div class="detailProdInfo">
								<ul>
									<li class="title"><a href="./?menuType=product&mode=view&prodCode=<?=$strProdCode?>"><?=$strProdName?></a></li>
									<!--<?if($strProdOpt){?><li><?=$strProdOpt?></li><?}?>
									<?if($strProdAddOpt){echo $strProdAddOpt;}?>
									<?if($strProdItem){echo $strProdItem;}?>
									<?if($strProdDeliveryInfo){echo $strProdDeliveryInfo;}?>
									<? echo '<br>' ?>-->
									<li><span>Packing</span><strong> <?= $strProdOpt; ?></strong></li>
									<li><span><?= $LNG_TRANS_CHAR["PW00081"]; //제품가격 ?></span><strong><?echo $strProdPrice;?></strong></li>
								</ul>
							</div>
							<div class="clr"></div>							
						</div>
						<div class="buyInfo">
							<input type="hidden" id="cartNo[]" name="cartNo[]" value="<?=$intNo?>"/>
							<?=$LNG_TRANS_CHAR["PW00019"]?>
							<span class="cntInfo _w40px"><input type="hidden" id="cartQty<?=$intNo?>" name="cartQty<?=$intNo?>" value="<?=$intQty?>" class="cartCntForm"/><?=$intQty?></span>
							 <strong class="price"><?= $LNG_TRANS_CHAR["OW00004"]; //합계 ?> :<?=$strCartPrice?></strong><?=$strCartPriceOrg?></strong>
						</div>
					</div>
					<?
				}
			}
			?>
			</div><!-- tableProdList -->

	<div class="topalPriceInfoList">
		<ul>
			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["OW00051"] //주문금액 ?></span>
				<span class="valueTxt"><?=$strPriceLeftMark?><strong class="priceBoldGray"> <?=$strCartPriceTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalOrgText?></span><div class="clr"></div></li>

			<?if ($S_SITE_TAX == "Y"){?>
				<li>
					<span class="title"><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>
					<span class="valueTxt"><?=$strPriceLeftMark?><strong class="priceBoldGray"> <?=$strCartPriceTotalTaxText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalTaxOrgText?></span><div class="clr"></div>
				</li>
			<?}?>

			<li>
				<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
				<span class="valueTxt"><?=$strPriceLeftMark?> <strong class="priceBoldGray" id="cartTotalDeliveryPrice"><?=$strCartDeliveryTotalText?></strong><?=$strPriceRightMark?>
				<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalDeliveryOrgPrice"><?=$strCartDeliveryTotalOrgText?></span>)<?}?></span>
				<div class="clr"></div></li>

			<li class="orderTotalPrice">
				<span class="title"><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?></span>
				<span class="valueTxt"><?=$strPriceLeftMark?> <strong class="price" id="cartTotalPrice"> <?=$strCartPriceEndTotalText?></strong><?=$strPriceRightMark?>
				<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span id="cartTotalOrgPrice"><?=$strCartPriceEndTotalOrgText?></span>)<?}?>
				<?if ($S_PG_COMMISSION == "Y" && ($S_PG_CARD_COMMISSION > 0)){?><strong class="price" id="cartPgCommission"></strong><?}?></span>
				<div class="clr"></div>
			</li>
		</ul>
	</div>
