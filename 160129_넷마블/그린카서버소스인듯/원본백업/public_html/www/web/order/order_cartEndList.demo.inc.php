<?
	$intCartPrice				= $intCartPriceTotal		= $intCartPointTotal	= $intCartDeliveryPriceTotal = 0;
	$arrCartRow					= "";	
	while ($cartRow = mysql_fetch_array($cartResult))
	{		
		## 입점형일때 배송비관련 ROWSPAN 수
		if ($S_MALL_TYPE != "R")
		{
			$intRowSpan		= 0;
			if (($intShopNo != "0" && !$intShopNo) || ($intShopNo != $cartRow['P_SHOP_NO'])) {
				$intShopNo	= ($cartRow['P_SHOP_NO'])?$cartRow['P_SHOP_NO']:"0";
				$intRowSpan = $aryProdCartShopList[$intShopNo]['CART_CNT']; 
			}					
		}
		
		## 상품 가격(할인가격)
		$intProdPrice					= $cartRow['OC_CUR_PRICE'];								//기준통화
		$intProdPriceCur				= $cartRow['OC_PRICE'];									//결제한 통화
		$intProdPriceOrg				= getCurToPriceSave($cartRow['OC_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);			//사용 통화
		
		## 상품 총 합계(금액 * 수량)
		$intCartPrice					= ($intProdPrice * $cartRow['OC_QTY']) + $cartRow['OC_OPT_ADD_CUR_PRICE'];

		##기준통화에서 현재 언어 통화로 변경시 환율 오차가 발생하여 상품금액을 현재통화로 변경 후 계산 */		
		$strPriceCurLeftMark			= getCurMark($orderRow['O_USE_CUR']);
		$strPriceCurRightMark			= getCurMark2($orderRow['O_USE_CUR']);
		
		$strProdPriceCurText			= $strPriceCurLeftMark." ".getFormatPrice($intProdPriceCur,2).$strPriceCurRightMark; 
		$strProdAddPriceCurText			= "";
		if ($cartRow['OC_OPT_ADD_PRICE'] > 0){
			$strProdAddPriceCurText		= $strPriceCurLeftMark." ".getFormatPrice($cartRow['OC_OPT_ADD_PRICE'],2).$strPriceCurRightMark; 
		}
									
		$intCartPriceCur				= ($intProdPriceCur * $cartRow['OC_QTY']) + $cartRow['OC_OPT_ADD_PRICE'];
		$strCartPriceCurText			= $strPriceCurLeftMark." ".getFormatPrice($intCartPriceCur,2).$strPriceCurRightMark;
		
		$strProdPriceOrgText			= "";
		$strProdAddPriceOrgText			= "";
		$strCartPriceOrgText			= "";
		
		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")
		{			
			$strPriceCurLeftMark		= getCurMark("USD");
			$strPriceCurRightMark		= getCurMark2("USD");
			
			$strPriceOrgLeftMark		= getCurLeftMark($orderRow['O_USE_LNG']);
			$strPriceOrgRightMark		= "";
			
			$strProdPriceCurText		= $strPriceCurLeftMark.getFormatPrice($intProdPriceCur,2,"USD").$strPriceCurRightMark;
			$strProdPriceOrgText		= "(".$strPriceOrgLeftMark.getCurToPrice($intProdPrice,$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']).")";

			$strProdAddPriceCurText		= "";
			if ($cartRow['OC_OPT_ADD_PRICE'] > 0){
				$strProdAddPriceCurText = $strPriceCurLeftMark.getFormatPrice($cartRow['OC_OPT_ADD_PRICE'],2,"USD").$strPriceCurRightMark;
				$strProdAddPriceOrgText = "(".$strPriceOrgLeftMark.getCurToPrice($cartRow['OC_OPT_ADD_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']).")";
			}

			$intCartPriceCur			= ($intProdPriceCur * $cartRow['OC_QTY']) + $cartRow['OC_OPT_ADD_PRICE'];
			$strCartPriceCurText		= $strPriceCurLeftMark.getFormatPrice($intCartPriceCur,2,"USD").$strPriceCurRightMark;
				
			$intCartPriceOrg			= ($intProdPriceOrg * $cartRow['OC_QTY']) + getCurToPriceSave($cartRow['OC_OPT_ADD_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$intCartPriceTotalOrg      += $intCartPriceOrg;
			
			$strCartPriceOrgText		= "(".$strPriceOrgLeftMark.getFormatPrice($intCartPriceOrg,2,$S_ARY_NAT_USER_CUR[$orderRow['O_USE_LNG']]).")";
		}
						
		## 배송비설정
		
		$strDeliveryPriceText	= "";
		if($S_SITE_LNG == "KR")
		{
			$strDeliveryPriceText			= "";
			switch($cartRow['P_BAESONG_TYPE']){
				case "3":
					$strDeliveryPriceText	= "(고정배송비:".getCurToPrice($cartRow['P_BAESONG_PRICE']).getCurMark2().")";		
				break;
				case "4":
					$strDeliveryPriceText	= "(수량별배송비:".getCurToPrice($cartRow['P_BAESONG_PRICE']).getCurMark2().")";		
				break;
				case "5":
					$strDeliveryPriceText	= "(착불:".getCurToPrice($cartRow['P_BAESONG_PRICE']).getCurMark2().")";		
				break;
			}
		}


		## 상품옵션리스트
		$strCartOptAttrVal = "";
		for($kk=1;$kk<=10;$kk++){
			if ($cartRow["OC_OPT_ATTR".$kk]){
				$strCartOptAttrVal .= "/".$cartRow["OC_OPT_ATTR".$kk];
			}
		}
		$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
	
		## 상품추가옵션
		$orderMgr->setOC_NO($cartRow['OC_NO']);
		$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);
		$strCartAddOptAttrVal	= "";
		if (is_array($aryProdCartAddOptList)){
			for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
				$strCartAddOptAttrVal .= "<li>".$LNG_TRANS_CHAR['OW00006'].":".$aryProdCartAddOptList[$k]['OCA_OPT_NM']."</li>";
			}
		}

		## 상품추가항목사용
		$aryProdCartItemList	 = "";
		$strCartItemVal			= "";
		if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
			$aryProdCartItemList = $orderMgr->getOrderCartItemList($db);
			if (is_array($aryProdCartItemList)){
				for($k=0;$k<sizeof($aryProdCartItemList);$k++){
					$strCartItemVal .= "<li>".$aryProdCartItemList[$k]['OCI_ITEM_NM'].":".$aryProdCartItemList[$k]['OCI_ITEM_VAL']."</li>";	
				}
			}
		}
		
		## 몰인몰 상점별 배송비
		$strProdShopDeliveryText		= "";
		if ($S_MALL_TYPE != "R" && ($intRowSpan >= 1 && $S_SITE_LNG == "KR")){
			$strProdShopDeliveryText	= getCurMark($orderRow['O_USE_CUR'])." ".getCurToPrice($aryProdCartShopList[$cartRow[P_SHOP_NO]][SO_TOT_DELIVERY_CUR_PRICE]).getCurMark2($orderRow["O_USE_CUR"]);
			if ($intRowSpan == $aryProdCartShopList[$cartRow['P_SHOP_NO']]['AFTER_CHARGE_CNT'] && $aryProdCartShopList[$cartRow['P_SHOP_NO']]['SO_TOT_DELIVERY_CUR_PRICE'] == 0) {
				$strProdShopDeliveryText= $LNG_TRANS_CHAR["PW00049"]; //착불
			}
		}

		## html 배열 생성
		$arrRowHtml						= "";								//html 리스트 row 배열
		$arrRowHtml['OC_NO']			= $cartRow['OC_NO'];				//장바구니번호
		$arrRowHtml['PM_REAL_NAME']		= $cartRow['PM_REAL_NAME'];			//상품이미지URL
		$arrRowHtml['P_NAME']			= $cartRow['P_NAME'];				//상품명
		$arrRowHtml['P_OPT']			= $strCartOptAttrVal;				//상품옵션
		$arrRowHtml['P_ADD_OPT']		= $strCartAddOptAttrVal;			//상품추가옵션
		$arrRowHtml['P_ITEM']			= $strCartItemVal;					//상품항목
		$arrRowHtml['P_DELIVERY_INFO']	= $strDeliveryPriceText;			//상품배송정보
		$arrRowHtml['P_PRICE']			= $strProdPriceCurText;				//상품가격
		$arrRowHtml['P_PRICE_ORG']		= $strProdPriceOrgText;				//상품가격
		$arrRowHtml['P_ADD_PRICE']		= $strProdAddPriceCurText;			//상품추가옵션가격
		$arrRowHtml['P_ADD_PRICE_ORG']	= $strProdAddPriceOrgText;
		$arrRowHtml['P_QTY']			= $cartRow['OC_QTY'];				//상품수량
		$arrRowHtml['CART_PRICE']		= $strCartPriceCurText;				//상품총합계
		$arrRowHtml['CART_PRICE_ORG']	= $strCartPriceOrgText;				
		$arrRowHtml['P_SHOP_DELIVERY']	= $strProdShopDeliveryText;			//상품입점사별 배송비
		$arrRowHtml['ROWSPAN']			= $intRowSpan;						//상품입점사별 배송비 로우수
		
		$arrCartRow[]					= $arrRowHtml;
	}

	## 총상품금액(현재통화)
	$strPriceLeftMark					= getCurMark($orderRow['O_USE_CUR']);
	$strPriceRightMark					= getCurMark2($orderRow['O_USE_CUR']);
	$strCartPriceTotalText				= getFormatPrice($orderRow['O_TOT_PRICE'],2);
	
	## 총부과세(현재통화)
	$strCartPriceTotalTaxText			= getFormatPrice($orderRow['O_TAX_PRICE'],2);
	
	## 총수수료
	$strCartPricePgCommissionText	= "";
	if ($S_PG_COMMISSION == "Y" && $orderRow['O_TOT_PG_COMMISSION'] > 0){
		$strCartPricePgCommissionText	= getFormatPrice($orderRow['O_TOT_PG_COMMISSION']);
	}

	## 배송비(주문시 배송정보를 사용할때)
	$strCartDeliveryTotalText	= "";
	if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){
		if ($orderRow['O_TOT_DELIVERY_CUR_PRICE'] > 0){
			$strCartDeliveryTotalText	= getFormatPrice($orderRow['O_TOT_DELIVERY_PRICE'],2);
		}
	}
	
	## 추가할인금액
	$strCartMemberDiscountPriceText		= "";
	if ($orderRow['O_TOT_MEM_DISCOUNT_CUR_PRICE'] > 0){
		$strCartMemberDiscountPriceText	= getFormatPrice($orderRow['O_TOT_MEM_DISCOUNT_PRICE'],2);
	}

	## 사용포인트
	$strCartUsePointPriceText			= "";
	if ($orderRow['O_USE_POINT'] > 0){
		$strCartUsePointPriceText		= getFormatPrice($orderRow['O_USE_POINT'],2);
	}
	
	## 사용쿠폰
	$strCartUseCouponPriceText			= "";
	if ($orderRow['O_USE_COUPON'] > 0){
		$strCartUseCouponPriceText		= getFormatPrice($orderRow['O_USE_COUPON'],2);
	}

	## 최종결제금액
	$strCartPriceEndTotalText			= getFormatPrice($orderRow['O_TOT_SPRICE'],2);
	
	if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
		
		## 총상품금액(현재통화)
		$strPriceLeftMark					= getCurMark("USD");
		$strPriceRightMark					= getCurMark2("USD");
		$strCartPriceTotalText				= getFormatPrice($orderRow['O_TOT_PRICE'],2);
		$intCartPriceTotalOrg				= $intCartPriceTotalOrg;
		$strCartPriceTotalOrgText			= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartPriceTotalOrg.")";
		
		## 총부과세(현재통화)
		$strCartPriceTotalTaxText			= getFormatPrice($orderRow['O_TAX_PRICE'],2);
		$intCartPriceTotalTaxOrg			= getCurToPrice($orderRow['O_TAX_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
		$strCartPriceTotalTaxOrgText		= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartPriceTotalTaxOrg.")";
		
		## 총수수료
		$strCartPricePgCommissionText		= "";
		$strCartPricePgCommissionOrgText	= "";
		$intCartPricePgCommissionOrg		= 0;
		if ($S_PG_COMMISSION == "Y" && $orderRow['O_TOT_PG_COMMISSION'] > 0){
			$strCartPricePgCommissionText	= getFormatPrice($orderRow['O_TOT_PG_COMMISSION']);
			$intCartPricePgCommissionOrg	= getCurToPrice($orderRow['O_TOT_PG_CUR_COMMISSION'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$strCartPricePgCommissionOrgText= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartPricePgCommissionOrg.")";
		}

		## 배송비(주문시 배송정보를 사용할때)
		$strCartDeliveryTotalText			= "";
		$strCartDeliveryTotalOrgText		= "";
		$intCartDeliveryTotalOrg			= 0;
		if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){
			if ($orderRow['O_TOT_DELIVERY_PRICE'] > 0){
				$strCartDeliveryTotalText	= getFormatPrice($orderRow['O_TOT_DELIVERY_PRICE'],2);
				$intCartDeliveryTotalOrg	= getCurToPrice($orderRow['O_TOT_DELIVERY_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
				$strCartDeliveryTotalOrgText= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartDeliveryTotalOrg.")";
			}
		}
		
		## 추가할인금액
		$strCartMemberDiscountPriceText		= "";
		$strCartMemberDiscountPriceOrgText	= "";
		$intCartMemberDiscountPriceOrg		= 0;
		if ($orderRow['O_TOT_MEM_DISCOUNT_CUR_PRICE'] > 0){
			$strCartMemberDiscountPriceText		= getFormatPrice($orderRow['O_TOT_MEM_DISCOUNT_PRICE'],2);
			$intCartMemberDiscountPriceOrg		= getCurToPrice($orderRow['O_TOT_MEM_DISCOUNT_CUR_PRICE'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$strCartMemberDiscountPriceOrgText	= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartMemberDiscountPriceOrg.")";
		}

		## 사용포인트
		$strCartUsePointPriceText			= "";
		$intCartUsePointPriceOrg			= 0;
		if ($orderRow['O_USE_POINT'] > 0){
			$strCartUsePointPriceText		= getFormatPrice($orderRow['O_USE_POINT'],2);
			$intCartUsePointPriceOrg		= getCurToPrice($orderRow['O_USE_CUR_POINT'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
		}
		
		## 사용쿠폰
		$strCartUseCouponPriceText			= "";
		$strCartUseCouponPriceOrgText		= "";
		$intCartUseCouponPriceOrg			= 0;
		if ($orderRow['O_USE_COUPON'] > 0){
			$strCartUseCouponPriceText		= getFormatPrice($orderRow['O_USE_COUPON'],2);
			$intCartUseCouponPriceOrg		= getCurToPrice($orderRow['O_USE_CUR_COUPON'],$orderRow['O_USE_LNG'],$orderRow['O_USE_CUR_ORG_RATE']);
			$strCartUseCouponPriceOrgText	= "(".getCurLeftMark($orderRow['O_USE_LNG']).$intCartUseCouponPriceOrg.")";
		}

		## 최종결제금액
		$strCartPriceEndTotalText			= getFormatPrice($orderRow['O_TOT_SPRICE'],2);
		$intCartPriceEndTotalOrg			= ($intCartPriceTotalOrg + $intCartPriceTotalTaxOrg + $intCartDeliveryTotalOrg + $intCartPricePgCommissionOrg) - $intCartMemberDiscountPriceOrg - $intCartUsePointPriceOrg - $intCartUseCouponPriceOrg;
		$strCartPriceEndTotalOrgText		= "(".getCurLeftMark($orderRow['O_USE_LNG']).getFormatPrice($intCartPriceEndTotalOrg,2,"USD").")";
	}
?>
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
				<?=$strPriceLeftMark?> <strong class="priceBoldGray"><?=$strCartUseCouponPriceText?></strong><?=$strPriceRightMark?><?=$strCartUseCouponPriceOrgText?>
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