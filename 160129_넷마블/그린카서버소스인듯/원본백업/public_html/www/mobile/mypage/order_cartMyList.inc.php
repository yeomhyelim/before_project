<div class="myOrderListWrap myOrderListBodyWrap">
	<h2><?php echo $LNG_TRANS_CHAR["CW00004"]; //내 장바구니?>(<?php echo NUMBER_FORMAT($intCartTotal);?>)</h2>
	<?php if(!$intCartTotal):?>
	<div class="dataNoList"><?php echo $LNG_TRANS_CHAR["OS00001"]; //장바구니에 담긴 상품이 없습니다.?></div>
	<?php else:?>
	<?php 
	$intProdTotalPrice = 0;
	$strProdTotalPrice= "";
	while ($row = mysql_fetch_array($cartResult)):
			
			## 기본 설정
			$strP_CODE =$row['P_CODE'];
			$strPM_REAL_NAME = $row['PM_REAL_NAME'];
			$strP_NAME = $row['P_NAME'];
			$strP_EVENT_UNIT = $row['P_EVENT_UNIT'];
			$strP_EVENT = $row['P_EVENT'];
			$intPB_NO = $row['PB_NO'];
			$intPB_PRICE =$row['PB_PRICE'];
			$intPB_ADD_OPT_PRICE = $row['PB_ADD_OPT_PRICE'];
			$intPB_QTY = $row['PB_QTY'];
			
			$strCartOptAttrVal = "";
							for($kk=1;$kk<=10;$kk++){
								if ($row["PB_OPT_ATTR".$kk]){
									$strCartOptAttrVal .= "/".$row["PB_OPT_ATTR".$kk];
								}
							}
							$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
			
			## 이벤트 텍스트 설정
			$strProdEventText = "";		
			if($strP_EVENT_UNIT && $strP_EVENT):
				if($cartRow['P_EVENT_UNIT'] == "%"):
					$strProdEventText = callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow['P_EVENT'],"%"));
					$strProdEventText = "({$strProdEventText})";
				else:
					$strProdEventText = callLangTrans($LNG_TRANS_CHAR["OS00002"],array($cartRow['P_EVENT'],""));
					$strProdEventText = "({$S_SITE_CUR} {$strProdEventText})";
				endif;
			endif;

			## 옵션 설정
			$strCartOptAttrVal = "";
			for($i=1;$i<=10;$i++):
				$strPB_OPT_ATTR = $row["PB_OPT_ATTR{$i}"];
				if(!$strPB_OPT_ATTR) { continue; }
				if($strCartOptAttrVal) { $strCartOptAttrVal .= "/"; }
				$strCartOptAttrVal .= $strPB_OPT_ATTR;
			endfor;

			## 추가 옵션 설정
			$productMgr->setPB_NO($intPB_NO);
			$aryProdCartAddOptList = $productMgr->getProdBasketAddList($db);

			## 상품 가격 설정
			$strPrice = "";
			$strPrice = getCurToPrice($intPB_PRICE);
			$strPrice = getCurMark() . " " . $strPrice . getCurMark2();
	
			## 합계 설정
			$strTotPrice = $intPB_PRICE * $intPB_QTY;
			
			## 총 합계 설정	
			$intProdTotalPrice = $intProdTotalPrice + $strTotPrice;
			$strProdTotalPrice = getCurToPrice($intProdTotalPrice);
			$strProdTotalPrice = getCurMark() . " " . $strProdTotalPrice . getCurMark2();
		
		  ## 가격 * 수량 = 합계
			$strTotPrice = getCurToPrice($strTotPrice);
			$strTotPrice = getCurMark() . " " . $strTotPrice . getCurMark2();
			
			## 미국 달러 설정
			$strPriceUsd = "";
			if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"):
				$strPriceUsd = getCurToPrice($intPB_PRICE,"US");
				$strPriceUsd = getCurMark("USD") . " " . $strPriceUsd . getCurMark2("USD");

				$strPrice = "{$strPriceUsd} ({$strPrice})";
			endif;

			## 추가 금액 설정
			$strAddPrice = "";
			if($intPB_ADD_OPT_PRICE > 0):
				$strAddPrice = getCurToPrice($intPB_ADD_OPT_PRICE);
				$strAddPrice = getCurMark() . " " . $strAddPrice . getCurMark2();
			endif;
		
	?>
	<div class="prodInfoWrap">
		<div class="prodInfo">
				<!-- 상품 이름 //-->
				<div class="prodTit">
					<a href="./?menuType=product&mode=view&prodCode=<?php echo $strP_CODE;?>"><?php echo $strP_NAME;?><?php echo $strProdEventText;?></a>
					<input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?php echo $intPB_NO;?>" checked/>
					<div class="clr"></div>
				</div>
				<!-- 상품 이름 //-->
				<div class="prodInfoBox">
					<!-- 상품 이미지 //-->
					<div class="prodListImg"><a href="./?menuType=product&mode=view&prodCode=<?php echo $strP_CODE;?>"><img src="<?php echo $strPM_REAL_NAME;?>"/></a></div>
					<!-- 상품 이미지 //-->
					<!-- 상품 정보 //-->
					<div class="detailProdInfo">
						<ul>
							<!--<li><span class="tit">원산지</span>대한민국</li>-->
							<!-- 상품 옵션 //-->
							<!--<li><?php echo $strCartOptAttrVal;?></li>-->
							<!-- 상품 옵션 //-->
							<!-- 상품 추가 옵션 //-->
							<?php if($aryProdCartAddOptList && is_array($aryProdCartAddOptList)):?>
							<?php foreach($aryProdCartAddOptList as $key => $data):?>
							<li><?php echo $LNG_TRANS_CHAR["OW00006"]; //추가선택?> : <?php echo $data['PBA_OPT_NM'];?></li>
							<?php endforeach;?>
							<?php endif;?>
							<!-- 상품 추가 옵션 //-->
							
							<!-- 상품 추가 금액 //-->
							<?php if($strAddPrice):?>
							<li class="addPrice"><?php echo $LNG_TRANS_CHAR["OW00007"]; //추가금액?>:<?php echo $strAddPrice;?></li>
							<?php endif;?>
							<!-- 상품 추가 금액 //-->
							<!-- 상품 수량 //-->
							<li class="cartCntForm">
								<span class="tit"><?= $LNG_TRANS_CHAR["PW00019"]; //구매수량 ?></span>
								<a href="javascript:goQtyUpMinus('cart',-1, <?php echo $intPB_NO;?>);" class="btnCntUp"><span>▼</span></a>							
								<input type="text" id="cartQty<?php echo $intPB_NO;?>" name="cartQty<?php echo $intPB_NO;?>" value="<?php echo $intPB_QTY;?>" class="cartCntForm"/><a href="javascript:goQtyUpMinus('cart', 1, <?php echo $intPB_NO;?>);" class="btnCntUp"><span>▲</span></a>
								<a href="javascript:goQtyUpdate('cart', <?php echo $intPB_NO;?>);" class="btn_cnt_modify"><?php echo $LNG_TRANS_CHAR["OW00072"]; //수정?></a>
							</li>
							<!-- 상품 수량 //-->
							<!-- 상품 가격 //-->
							<li class="price"><span class="tit"><?= $LNG_TRANS_CHAR["PW00081"]; //가격 ?></span><?php echo $strPrice;?></li>
							<li><span class="tit">Packing</span><?= $strCartOptAttrVal; ?></li>
							<!-- 상품 가격 //-->
						</ul>
					</div>
				</div>
				<div class="clr"></div>
				<!-- 상품 정보 //-->

			<!--<div class="conditionBtn">
				<input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?php echo $intPB_NO;?>" checked/>
				<a href="javascript:goWish(<?php echo $intPB_NO;?>);"><?php echo $LNG_TRANS_CHAR["OW00089"]; //나중에 주문?></a>
				<a href="javascript:goCartDel(<?php echo $intPB_NO;?>);"><?php echo $LNG_TRANS_CHAR["CW00036"]; //삭제?></a>
			</div>-->
			<div class="conditionBtn" style="text-align:right;">
				<?= $LNG_TRANS_CHAR["OW00004"]; //합계 ?>&nbsp;&nbsp;<span style="color:red"><?php echo $strTotPrice;?></span>
			</div>
			
		</div>
	</div>
	
	<?php endwhile;?>
	<div class="prodInfoWrap">
		<div class="prodInfo">
				<div class="conditionBtn" style="text-align:right;">
				<span><?=$LNG_TRANS_CHAR["OW00009"] //최종결제금액?>:</span>&nbsp;&nbsp;<span style="color:red"><?php echo $strProdTotalPrice;?></span>
			</div>
		</div>
	</div>
	<div class="myorderBtnWrap">
		<a href="javascript:goOrderJumun();" class="btnCartBuy btn_red"><?php echo $LNG_TRANS_CHAR["OW00079"]; //선택상품 주문?></a>
		<a href="javascript:goCartAllDel();" class="btnCartDel btn_gray"><?php echo $LNG_TRANS_CHAR["OW00080"]; //선택상품 삭제?></a>
	</div>
	<?php endif;?>
</div>