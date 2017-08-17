<?php

require_once MALL_CONF_LIB."CateMgr.php";
$cateMgr		= new CateMgr();
$cateMgr->setCL_LNG($S_SITE_LNG);
	## class 설정
	$strStyleDivName = "bestList{$no}";

?>

<div class="<?php echo $strStyleDivName;?>">
	<div id="ca-container" class="ca-container">
		<span class="ca-nav-prev"><a><span>Previous</span></a></span>
		<span class="ca-nav-next"><a><span>Next</span></a></span>
		<div class="ca-wrapper">
		<?php for($i=0;$i<$intHList;$i++):?>
		<?php for($j=0;$j<$intWList;$j++):?>
		<?php $row = mysql_fetch_array($aryProdRow);?>
		<?php if($row):?>
		<?php
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
				$strP_CATE = $row['P_CATE']; // 배송타입
				$strSH_COM_NAME = $row['SH_COM_NAME']; // 사업자명
				$strP_PRICE_FILTER = $row['P_PRICE_FILTER']; //
				$strP_PRICE_UNIT = $row['P_PRICE_UNIT']; //


				$strSearchHCode1 = substr($strP_CATE, 0, 3);
				if (!$strSearchHCode2) $strSearchHCode2 = substr($strP_CATE, 3, 3);
				if (!$strSearchHCode3) $strSearchHCode3 = substr($strP_CATE, 6, 3);
				if (!$strSearchHCode4) $strSearchHCode4 = substr($strP_CATE, 9, 3);

				$cateMgr->setC_CODE($strSearchHCode1);
				$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);

				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2);
				$strSearchHCodeName2 = $cateMgr->getCateLevelName($db);

				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3);
				$strSearchHCodeName3 = $cateMgr->getCateLevelName($db);

				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4);
				$strSearchHCodeName4 = $cateMgr->getCateLevelName($db);



				## 재고 수량 표시
				$strP_QTY = "";
				if($S_IS_QTY_SHOW == "Y"):
					## 제고 수량 설정
					if($intP_QTY) { $strP_QTY = "<span>".$LNG_TRANS_CHAR["PW00080"]."</span>" . $intP_QTY; }
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
				$intProdPoint = getProdPoint($intP_SALE_PRICE, $intP_POINT, $strP_POINT_TYPE, $strP_POINT_OFF1, $strP_POINT_OFF2);
				$intProdPointMoney = 0;
				if($intProdPoint <= 0) { $strShow3 = ""; }
				if($strShow3 == "Y") { $intProdPointMoney = getCurToPrice($intProdPoint); }

				## 소비자가격 설정
				$strTextConsumerPrice = "";
				$strTextConsumerPriceUsd = "";
				if($intP_CONSUMER_PRICE > 0):
					$strTextConsumerPrice = getCurToPrice($intP_CONSUMER_PRICE);
					$strTextConsumerPrice = "{$strMoneyIconL}{$strTextConsumerPrice}{$strMoneyIconR}";
					if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextConsumerPriceUsd = getCurMark("USD") . getCurToPrice($intP_CONSUMER_PRICE, "US") . getCurMark2("USD"); }
				endif;

				## 상품 가격 설정
				$strTextPriceUsd = "";
				if($strP_PRICE_FILTER=='FOB')
				{
					//$strTextPrice = getCurMark("$").getProdDiscountPrice($row,"1",0,"US").getCurMark2("USD");
					$strTextPrice = getCurMark("$").number_format($row[P_SALE_PRICE]).getCurMark2("USD");
					$strTextPrice = $strMoneyIconL.$strTextPrice;
				}else{
					$strTextPrice = getProdDiscountPrice($row);
					$strTextPrice = $strMoneyIconL.$strTextPrice;
					$strTextPrice .= $strMoneyIconR;
				}
				//$strTextPrice = $strMoneyIconL . getProdDiscountPrice($row) . $strMoneyIconR;

				if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("$") . getProdDiscountPrice($row,"1",0,"US") . getCurMark2("USD"); }
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
				if($intP_GRADE > 0 && $intP_GRADE_CNT > 0){
					$intGrade = $intP_GRADE / $intP_GRADE_CNT;
				}else{
					$intGrade = 0;
				}

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
					@$intProdDiscountRate= getRoundUp((($row['P_CONSUMER_PRICE'] - $row['P_SALE_PRICE'])/$row['P_CONSUMER_PRICE']) * 100,0);
					$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
				}

				## 무료배송아이콘표시
				$strProdFreeDeliveryText = "";
				if ($S_FIX_PRODUCT_FREE_DELIVERY_SHOW == "Y"){
					if ($strP_BAESONG_TYPE == "2"){
						$strProdFreeDeliveryText = "무료배송";
					}
				}

				## 품절 여부 체크
				## 무제한 상품이 아니면서, 품절체크가 되었거나 상품 개수가 0일때 sold out
				$isSoldOut = false;
//				if($strP_STOCK_OUT == "Y" || ($intP_QTY <= 0 && $strP_STOCK_LIMIT == "Y")) { $isSoldOut = true; } 2014.07.28 kim hee sung 잘못된 공식
				if($strP_STOCK_LIMIT != "Y" && ($intP_QTY <= 0 || $strP_STOCK_OUT == "Y")) { $isSoldOut = true; }

				## 2015.02.09 kim hee sung
				## 상품가격 출력 설정
				##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
				if($isPriceHide):
					$strProdDiscountRateText = '';
					$strTextPrice = '';
					$intProdPointMoney = '';
					$strTextConsumerPrice = '';
					$strTextConsumerPriceUsd = '';
				endif;
		?>
		<div class="ca-item">
			<div class="productInfoWrap">
				<div class="bestIco_<?php echo $j+1;?>"></div>
				<a href="javascript:goProdView('<?php echo $strP_CODE;?>');"><img src="<?php echo $strPM_REAL_NAME;?>" class="listProdImg"/></a>
				<?php if($strEvent):?>
				<div class="sailInfo">
					<strong><?php echo $strEvent;?></strong>%
				</div>
				<?php endif;?>
				<ul class="prodInfoTxt">
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
					<li class="brandTit"><?php echo $strSH_COM_NAME; // 브렌드?></li>
					<?php if($strShow7 == "Y"):?>
					<li class="model"><?php echo $strP_MODEL; // 모델명?></li>
					<?php endif;?>
					<?if($strShow2 == "Y"):?>
					<li class="comment"><?php echo $strP_ETC; // 상품설명?></li>
					<?php endif;?>
					<?php if($strShow3 == "Y"):?>
					<li class="pricePoint"><?php echo $intProdPointMoney; // 적립금?></li>
					<?php endif;?>
					<?php if($strShow4 == "Y" && $intP_CONSUMER_PRICE > 0 && $intP_CONSUMER_PRICE != $intP_SALE_PRICE ):?>
					<li class="priceConsumer">
						<s><?php echo $strTextConsumerPrice; // 소비자가격?></s>
					</li>
					<?php endif;?>
					<?php if($strShow5 == "Y"):?>
					<?php if($strTextPriceUsd):?>
					<li>
						<span class="priceCn"><?php echo $strTextPrice; // 가격?></span>
						<span class="priceCn_us"> / <?php echo $strTextPriceUsd // USD 달러?><?if($strP_PRICE_UNIT){?>&nbsp;/&nbsp;<?=$strP_PRICE_UNIT?> <?}?></span>
					</li>
					<?php else:?>
					<li class="priceSale"><span><?php echo $strSearchHCodeName1?></span> | <span><?php echo $strTextPrice; // 가격?><?if($strP_PRICE_UNIT){?>&nbsp;/&nbsp;<?=$strP_PRICE_UNIT?> <?}?></span></li>
					<?php endif;?>
					<?php endif;?>
					<?php if($iconTag):?>
					<li class="prodIcon">
						<?php echo $iconTag;?>
						<div class='clr'></div>
					</li>
					<?php endif;?>
				</ul>
			</div>
		</div>
		<?php endif;?>
		<?php endfor;?>
		<?php endfor;?>
		</div>
	</div>
</div>
<script type="text/javascript" src="../common/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../common/js/jquery.contentcarousel.js"></script>
<script type="text/javascript">
	$('#ca-container').contentcarousel({
		sliderSpeed     : 500,
		sliderEasing    : 'easeOutExpo',
		itemSpeed       : 500,
		itemEasing      : 'easeOutExpo',
		scroll          : 1
	});
</script>
