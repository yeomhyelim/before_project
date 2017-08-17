<?php
	# 베스트 상품 스킨 PB0001
	$strStyleDivName = "bestProdListWrap{$no}";
?>



<style>
	.<?php echo $strStyleDivName?> .title{color:<?php echo $strColor1?>;}
	.<?php echo $strStyleDivName?> .comment{color:<?php echo $strColor2?>;}
	.<?php echo $strStyleDivName?> .pricePoint{color:<?php echo $strColor3?>;}
	.<?php echo $strStyleDivName?> .priceConsumer{color:<?php echo $strColor4?>}
	.<?php echo $strStyleDivName?> .priceSale{color:<?php echo $strColor5?>;}
</style>

<div class="bestProdListWrap<?php echo $no?>">

	<div class="bestTitle"><?php echo $strTitleCode?></div>

	<div class="prodListWrap">
	<table>
		<?php for($i=0;$i<$intHList;$i++):?>
		<tr>
			<?php for($j=0;$j<$intWList;$j++):

				## 데이터 설정
				$row = mysql_fetch_array($aryProdRow);

				## 기본 설정
				$strP_CODE = $row['P_CODE'];
				$strP_NAME = $row['P_NAME'];
				$intP_GRADE = $row['P_GRADE'];
				$intP_GRADE_CNT = $row['P_GRADE_CNT'];
				$strP_COLOR = $row['P_COLOR'];
				$intP_SALE_PRICE = $row['P_SALE_PRICE'];
				$intP_POINT = $row['P_POINT'];
				$strP_POINT_TYPE = $row['P_POINT_TYPE'];
				$strP_POINT_OFF1 = $row['P_POINT_OFF1'];
				$strP_POINT_OFF2 = $row['P_POINT_OFF2'];
				$strPM_REAL_NAME = $row['PM_REAL_NAME'];
				$strPM_REAL_NAME2 = $row['PM_REAL_NAME2']; // 이미지2 (마우스 오버시 이미지)
				$strP_EVENT = $row['P_EVENT'];
				$strP_LIST_ICON = $row['P_LIST_ICON'];
				$strP_COLOR_IMG = $row['P_COLOR_IMG'];
				$strP_BRAND_NAME = $row['P_BRAND_NAME'];
				$strP_MODEL = $row['P_MODEL'];
				$strP_ETC = $row['P_ETC'];
				$intP_CONSUMER_PRICE = $row['P_CONSUMER_PRICE'];
				$strP_PRICE_TEXT = $row['P_PRICE_TEXT'];
				$intP_QTY = $row['P_QTY']; // 수량
				$strP_STOCK_OUT = $row['P_STOCK_OUT']; // 품절여부
				$strP_RESTOCK = $row['P_RESTOCK']; // 재입고여부
				$strP_STOCK_LIMIT = $row['P_STOCK_LIMIT']; // 무제한상품
				$strP_BAESONG_TYPE = $row['P_BAESONG_TYPE']; // 배송타입
				## 재고 수량 표시
				$strP_QTY = "";
				if($S_IS_QTY_SHOW == "Y"):
					## 제고 수량 설정
					if($intP_QTY) { $strP_QTY = "<span>재고수량:</span>" . $intP_QTY; }
				endif;

				## 색상 설정
				$aryP_COLOR_IMG = "";
				if($strP_COLOR && $strShow6):
					$aryP_COLOR = explode("|", $strP_COLOR);
					foreach($aryP_COLOR as $key => $val):
						if($val != "Y") { continue; }
						if($S_ARY_PROD_COLOR[$key]['USE'] != "Y") { continue; }
						$aryP_COLOR_IMG[] = $S_ARY_PROD_COLOR[$key]['IMG'];
					endforeach;
				endif;

				## 적립금 설정
				$intRelationProdPoint = getProdPoint($intP_SALE_PRICE, $intP_POINT, $strP_POINT_TYPE, $strP_POINT_OFF1, $strP_POINT_OFF2);
				$intRelationProdPointMoney = 0;
				if($intRelationProdPoint <= 0) { $strShow3 = ""; }
				if($strShow3 == "Y") { $intRelationProdPointMoney = getCurToPrice($intRelationProdPoint); }

				## 소비자가격 설정
				$strP_CONSUMER_PRICE = "";
				if($intP_CONSUMER_PRICE > 0):
					$intP_CONSUMER_PRICE = getCurToPrice($intP_CONSUMER_PRICE);
					$strP_CONSUMER_PRICE = "{$strMoneyIconL}{$intP_CONSUMER_PRICE}{$strMoneyIconR}";
				endif;

				## 상품 가격 설정
				$strTextPrice = $strMoneyIconL . getProdDiscountPrice($row) . $strMoneyIconR;
				if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPrice = getCurMark("USD") . getProdDiscountPrice($row,"1",0,"US") . getCurMark2("USD"); }
				if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; }

				## 이미지 설정
				if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

				## 마우스 오버시 변경 이미지 설정
				$strOverImage = "";
				if($strTurnUse == "Y" && $strPM_REAL_NAME2):
					$strOverImage = " overImg='{$strPM_REAL_NAME2}'";
				endif;

				## 리스트 이미지를 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
				$strProdMovieUrl = "";
				if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($row['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)):
					$productMgr->setP_CODE($strP_CODE);
					$productMgr->setPM_TYPE("movie1");
					$prodMovieRow = $productMgr->getProdImg($db);
					$strProdMovieUrl = $prodMovieRow[0]['PM_REAL_NAME'];
				endif;

				## 이벤트 정보
				$strEvent = "";
				if($strP_EVENT > 0 && getProdEventInfo($row) == "Y"):
					if($S_EVENT_INFO[$strP_EVENT]["PRICE_TYPE"] == "1"):
						$strEvent = $S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"];
					endif;
				endif;

				## 아이콘 설정
				$iconTag = "";
				$icon = explode("/", $strP_LIST_ICON);
				for($x=0; $x<sizeof($icon); $x++):
					$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
				endfor;

				## 상품명 설정
				$strP_NAME = strHanCutUtf2($strP_NAME, $intTitleMaxsize, "N");

				## 평점 설정
				$intGrade = $intP_GRADE / $intP_GRADE_CNT;
				if(!$intGrade) { $intGrade = 0; }

				## td style 설정
				$strStyleTD = "";
				if($j==($intWList-1)) { $strStyleTD = "width:{$intWSize}px"; }

				## div class 설정
				$strClassDiv = "productInfoWrap";
				if($j==($intWList-1)) { $strClassDiv .= " endProdList"; }

				## div style 설정
				$strStyleDiv = "width:{$intWSize}px;text-align:{$strWAlign}";

				if($_SERVER['HTTP_HOST'] == "ausieshop.eumshop.co.kr"):
					$strShow9 = "Y";
					$strShow10 = "Y";
				endif;

				## 판매가 할인율
				$intProdDiscountRate	= 0;
				if ($S_FIX_PRODUCT_DISCOUNT_RATE_SHOW == "Y"){
					if($row[$key]['P_CONSUMER_PRICE'] > 0.00001){
					$intProdDiscountRate= getRoundUp((($row['P_CONSUMER_PRICE'] - $row['P_SALE_PRICE'])/$row['P_CONSUMER_PRICE']) * 100,0);
					$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
					}
				}

				## 무료배송아이콘표시
				$strProdFreeDeliveryText = "";
				if ($S_FIX_PRODUCT_FREE_DELIVERY_SHOW == "Y"){
					if ($strP_BAESONG_TYPE == "2"){
						$strProdFreeDeliveryText = "무료배송";
					}
				}
			?>
			<td style="<?php echo $strStyleTD;?>">
			<?php if($row):?>
				<div class="<?php echo $strClassDiv?>" style="<?php echo $strStyleDiv;?>">
					<div class="bestIco_<?php echo $j;?>"></div>
					<?php if($strProdMovieUrl):?>
					<iframe width="<?php echo $intWSize?>" height="<?php echo $intHSize?>" src="<?php echo $strProdMovieUrl?>" frameborder="0" allowfullscreen></iframe>
					<?php else:?>
					<a href="javascript:goProdView('<?php echo $row['P_CODE']?>');"><img src="<?php echo $row['PM_REAL_NAME']?>"<?php echo $strOverImage;?> class="listProdImg" style="width:<?php echo $intWSize?>px;height:<?php echo $intHSize?>px;"/></a>
					<?php endif;?>
					<?php if($strShow9 == "Y"):?>
					<div class="icoScore">
						<img src="/himg/board/icon/icon_star_<?php echo $intGrade;?>.png" class="iconGrade"> <span><?php echo $intP_GRADE_CNT;?></span>
					</div>
					<?php endif;?>
					<?php if($strShow10 == "Y"):?>
					<a href="javascript:goAddCartEvent('<?=$strAppID;?>','<?=$strP_CODE?>','<?=$intP_OPT_CNT?>');" class="btnAddCart">ADD TO CART</a>
					<?php endif;?>
					<?php if($strEvent):?>
					<div class="sailInfo">
						<strong><?php echo $strEvent;?></strong>%
					</div>
					<?php endif;?>
					<div class="prodInfoSum">
						<ul>
							<?php if($iconTag):?>
								<li class="prodIcon">
									<?php echo $iconTag;?>
									<div class='clr'></div>
								</li>
							<?php endif;?>
							<?php if($aryP_COLOR_IMG):?>
								<li class="color">
									<?php foreach($strP_COLOR_IMG as $url):?>
									<span><img src="<?php echo $url?>"/></span>
									<?php endforeach;?>
								</li>
							<?php endif;?>
							<?php if($strShow8 == "Y"):?>
								<li class="brandTit"><?php echo $strP_BRAND_NAME; // 브렌드?></li>
							<?php endif;?>
							<?php if($strShow1 == "Y"):?>
								<li class="title"><a href="javascript:goProdView('<?php echo $strP_CODE?>');"><?php echo $strP_NAME;?></a></li>
							<?php endif;?>
							<?php if($strShow7 == "Y"):?>
								<li class="model"><?php echo $strP_MODEL; // 모델명?></li>
							<?php endif;?>
							<?if($strShow2 == "Y"):?>
								<li class="comment"><?php echo $strP_ETC; // 상품설명?></li>
							<?php endif;?>
							<?php if($strShow3 == "Y"):?>
								<li class="pricePoint"><?php echo $intRelationProdPointMoney; // 적립금?></li>
							<?php endif;?>
							<?php if($strShow4 == "Y"):?>
								<li class="priceConsumer"><s><?php echo $strP_CONSUMER_PRICE; // 소비자가격?></s></li>
							<?php endif;?>
							<?php if($strShow5 == "Y"):?>
								<li class="priceSale"><span><?php echo $strTextPrice; // 가격?></span></li>
							<?php endif;?>
							<?php if($intP_QTY):?>
								<li class="qty"><?php echo $strP_QTY; // 제고수량?></li>
							<?php endif;?>
							<?php if($intProdDiscountRate > 0 && $strProdDiscountRateText):?>
								<li class="discount"><?php echo $strProdDiscountRateText; // 할인율?></li>
							<?php endif;?>
							<?php if($strProdFreeDeliveryText):?>
								<li class="deliveryfree"><?php echo $strProdFreeDeliveryText; // 무료배송?></li>
							<?php endif;?>

						</ul>
						<div class="clr"></div>
					</div>
					<div class="clr"></div>
					<div class="prodAddInfo"></div>
					<!-- popup Cart -->
					<?if($S_PROD_ADD_CART_USE == "Y"){?>
					<? include MALL_HOME."/web/product/product.addCart.inc.php";?>
					<?}?>
					<!-- popup Cart -->
				</div>

				</div>
				<?php endif; ?>
			</td>
			<?php endfor;	?>
		</tr>
		<?php endfor; ?>
	</table>
	</div>
	<div class="clr"></div>

</div>