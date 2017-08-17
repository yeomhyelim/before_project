
<div class="tableOrderForm">
	<h3 class="cartTitle"><span><?=$LNG_TRANS_CHAR["CW00003"] //내 장바구니?></span></h3>

	<div class="tableCartList">

	<?
	if ($intCartTotal > 0){
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

			
		<div class="prodInfoWrap">
			<div class="prodInfo">
				<div class="prodListImg"><a href="<?=$strProdLinkUrl?>"><img src="..<?=$strProdImgUrl?>"/></a></div>
				<div class="detailProdInfo">
					<ul>
						<li class="title"><a href="<?=$strProdLinkUrl?>"><?=$strProdName?></a></li>
						<?if($strProdOpt){?><li><?=$strProdOpt?></li><?}?>
						<?if($strProdAddOpt){echo $strProdAddOpt;}?>
						<?if($strProdItem){echo $strProdItem;}?>
						<?if($strProdDeliveryInfo){echo $strProdDeliveryInfo;}?>
					</ul>
				</div>
				<div class="clr"></div>
			</div><!-- prodInfo //-->
			<div class="conditionBtn">
				<input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?=$intNo?>" checked/>
				<a href="javascript:goWish(<?=$intNo?>);" class="btnCartListWisth"><?=$LNG_TRANS_CHAR["OW00089"] //나중에 주문?></a>
				<a href="javascript:goCartDel(<?=$intNo?>);" class="btnCartListDel"><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></a>
			</div>
		</div>
			<?
		}
	}?>

	<!-- tableProdList -->

	<div class="topalPriceInfoList">
		<ul>
			<li><span><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></span>
			<strong><?=$strPriceLeftMark?> <?=$strCartPriceTotalText?><?=$strPriceRightMark?></strong><?=$strCartPriceTotalOrgText?><div class="clr"></div></li>
			
			<?if ($S_SITE_TAX == "Y"){?>
				<li><span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span><strong><strong><?=$strPriceLeftMark?> <?=$strCartPriceTotalTaxText?><?=$strPriceRightMark?></strong><?=$strCartPriceTotalTaxOrgText?><div class="clr"></div></li>
			<?}?>
			<?if($strCartDeliveryTotalText){?>
				<li><span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
				<?=$strPriceLeftMark?> <strong><?=$strCartDeliveryTotalText?><?=$strPriceRightMark?></strong>
				<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span><?=$strCartDeliveryTotalOrgText?></span>)<?}?>				
				<div class="clr"></div></li>
			<?}?>
			<li><span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?></span>
				 <strong class="price"><?=$strPriceLeftMark?> <?=$strCartPriceEndTotalText?><?=$strPriceRightMark?></strong>
				<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><span><?=$strCartPriceEndTotalOrgText?></span>)<?}?>
			<div class="clr"></div>
			</li>
		</ul>
	</div>


	<div class="cartBtnWrap">
		<a href="javascript:goOrderJumun();" class="btnCartBuy"><span><?=$LNG_TRANS_CHAR["OW00079"] //선택상품 주문?></span></a>
		<a href="javascript:goCartAllDel();" class="btnCartDel"><span><?=$LNG_TRANS_CHAR["OW00080"] //선택상품 삭제?></span></a>
		<a href="javascript:goWishAll();" class="btnCartWish"><span><?=$LNG_TRANS_CHAR["PW00025"] //선택상품 담아두기?></span></a>
		<a href="javascript:goProdList();" class="btnCartShopping"><span><?=$LNG_TRANS_CHAR["PW00024"] //쇼핑 계속?></span></a>
	</div>
</div>
