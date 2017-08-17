<div class="tableOrderForm">
	<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["CW00013"]//구매내역?></span></div>

	<div class="tableCartList">
					<?
					if ($intCartTotal == 0){
					?>
					<div><?=$LNG_TRANS_CHAR["OS00001"] //장바구니에 담긴 상품이 없습니다.?></div>
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


					<div class="prodInfoWrap">
						<div class="prodInfo">
							<div class="prodListImg"><img src="..<?=$strProdImgUrl?>"/></div>
							<div class="detailProdInfo">
								<ul>
									<li class="title"><?=$strProdName?><?=$strProdEventText?></li>
									<!--<?if($strProdOpt){?><li><?=$strProdOpt?></li><?}?>
									<?if($strProdAddOpt){echo $strProdAddOpt;}?>
									<?if($strProdItem){echo $strProdItem;}?>
									<?if($strProdDeliveryInfo){echo $strProdDeliveryInfo;}?>-->
									<li>
										<span>구매수량</span>
										<strong><?=$intQty?></strong>										
										<?if($strProdAddPrice){?>
										<?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=$strProdAddPrice?><?=$strProdAddPriceOrg?>
										<?}?>
									</li>
									<li>
										<span>제품가격</span>
										<strong class="priceOrange"><?=$strCartPrice?><?=$strCartPriceOrg?></strong>
									</li>
								</ul>
							</div>
							<div class="clr"></div>
						</div>
							<?
						}
					}

					?>
			</div><!-- tableProdList -->