<?php
	
	## 기본 설정
	$strPL_HTML = $prodPlanRow['PL_HTML'];

?>
<?php if($strPL_HTML):?>
<!-- 기획전 HTML 영역 //-->
<div class="evt_main">
	<?php echo $strPL_HTML;?>
</div>
<!-- 기획전 HTML 영역 //-->
<?php endif;?>
<?php foreach($aryProdPlanCateList as $key => $data):
		
		## 기본 설정
		$strPL_P_CATE = $data['PL_P_CATE'];
		$strCate1 = substr($strPL_P_CATE, 0, 3);
		$strCate2 = substr($strPL_P_CATE, 3, 3);
		$strCate3 = substr($strPL_P_CATE, 6, 3);
		$strCate4 = substr($strPL_P_CATE, 9, 3);

		## 체크
		if(!$strSearchSort) { $strSearchSort = "DE"; }
		if($strCate1 == "000") { $strCate1 = ""; }
		if($strCate2 == "000") { $strCate2 = ""; }
		if($strCate3 == "000") { $strCate3 = ""; }
		if($strCate4 == "000") { $strCate4 = ""; }
		if(!$strCate1) { continue; }

		## 최대 플렌 카테고리 정보
		$strPlanCate = "";
		if($strCate1) { $strPlanCate .= $strCate1; }
		if($strCate2) { $strPlanCate .= $strCate2; }
		if($strCate3) { $strPlanCate .= $strCate3; }
		if($strCate4) { $strPlanCate .= $strCate4; }


		## 기획전 카테고리 정보 불러오기
		$param						= "";
		$param['C_CODE']			= $strPlanCate;
		$param['PL_LNG']			= $S_SITE_LNG;
		$prodPlanCateRow			= $planMgr->getProdPlanCateInfo($db,$param);
		$strCL_NAME					= $prodPlanCateRow['CL_NAME'];
		$strCL_IMG1					= $prodPlanCateRow['CL_IMG1'];

		## 데이터 불러오기
		$param = "";
		$param['PL_NO'] = $intProdPlanNo;
		$param['PL_LNG'] = $S_SITE_LNG;
		$param['PL_P_CATE'] = $strPL_P_CATE;
		$param['ORDER_BY'] = $strSearchSort;
		$result = $planMgr->getProdPlanCateProdList($db,"OP_LIST",$param);	
?>
<div class="prodListWrap">
<h2><?php echo $strCL_NAME;?></h2>
<!-- 기획전 상품 리스트 //-->
<ul>
<?php while($row = mysql_fetch_array($result)):

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

			## 체크
			if(!$strP_CODE) { continue; }

			## 재고 수량 표시
			$strP_QTY = "";
			if($S_IS_QTY_SHOW == "Y"):
				## 제고 수량 설정	
				if($intP_QTY) { $strP_QTY = "<span>재고수량:</span>" . $intP_QTY; }
			endif;

			## 색상 설정
			$aryP_COLOR_IMG = "";
			if($strP_COLOR && $strAppShow6):
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
			if($intProdPoint <= 0) { $strAppShow3 = ""; }
			if($strAppShow3 == "Y") { $intProdPointMoney = getCurToPrice($intProdPoint); }

			## 소비자가격 설정
			$strP_CONSUMER_PRICE = "";
			if($intP_CONSUMER_PRICE > 0):
				$intP_CONSUMER_PRICE = getCurToPrice($intP_CONSUMER_PRICE);
				$strP_CONSUMER_PRICE = "{$strAppMoneyIconL}{$intP_CONSUMER_PRICE}{$strAppMoneyIconR}";
			endif;

			## 상품 가격 설정
			$strTextPrice = $strAppMoneyIconL . getProdDiscountPrice($row) . $strAppMoneyIconR;
			if($S_ARY_CUR[$strAppLang]["USD"][2] == "Y") { $strTextPrice = getCurMark("USD") . getProdDiscountPrice($row,"1",0,"US") . getCurMark2("USD"); }
			if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; } 

			## 이미지 설정
			if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

			## 마우스 오버시 변경 이미지 설정
			$strOverImage = "";
			if($strAppTurnUse == "Y" && $strPM_REAL_NAME2):
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

			if($_SERVER['HTTP_HOST'] == "ausieshop.eumshop.co.kr"):
				$strAppShow9 = "Y";
				$strAppShow10 = "Y";
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
	<li onClick="goProductListmobileBestSkinViewMoveEvent('<?php echo $strAppID?>', '<?php echo $strP_CODE?>')">
		<div class="productInfoWrap">
			<div class="bestIco_<?php echo $j;?>"></div>
			<?php if($strProdMovieUrl):?>
			<iframe width="<?php echo $intAppWSize?>" height="<?php echo $intAppHSize?>" src="<?php echo $strProdMovieUrl?>" frameborder="0" allowfullscreen></iframe>
			<?php else:?>
			<img src="<?php echo $strPM_REAL_NAME;?>"<?php echo $strOverImage;?> class="listProdImg"/>
			<?php endif;?>
			<?php if($strAppShow9 == "Y"):?>
			<div class="icoScore">
				<img src="/himg/board/icon/icon_star_<?php echo $intGrade;?>.png" class="iconGrade"> <span><?php echo $intP_GRADE_CNT;?></span>
			</div>
			<?php endif;?>
			<?php if($strAppShow10 == "Y"):?>
			<a href="javascript:goProductListmobileBestSkinAddCartMoveEvent('<?=$strAppID;?>','<?=$strP_CODE?>','<?=$intP_OPT_CNT?>');" class="btnAddCart">ADD TO CART</a>
			<?php endif;?>
			<?php if($strEvent):?>
			<div class="sailInfo">
				<strong><?php echo $strEvent;?></strong>%									
			</div>
			<?php endif;?>
			<div class="prodInfoSum">
				<dl>
					<?php if($iconTag):?>
					<dd class="prodIcon"><?php echo $iconTag;?><div class='clr'></div></dd>
					<?php endif;?>
					<?php if($aryP_COLOR_IMG):?>
					<dd class="color">
						<?php foreach($strP_COLOR_IMG as $url):?>
						<span><img src="<?php echo $url?>"/></span>
						<?php endforeach;?>
					</dd>
					<?php endif;?>
					<?php if($strAppShow8 == "Y"):?>
					<dd class="brandTit"><?php echo $strP_BRAND_NAME; // 브렌드?></dd>
					<?php endif;?>
					<?php if($strAppShow1 == "Y"):?>
					<dd class="title"><?php echo $strP_NAME;?></dd>
					<?php endif;?>
					<?php if($strAppShow7 == "Y"):?>
					<dd class="model"><?php echo $strP_MODEL; // 모델명?></dd>
					<?php endif;?>
					<?if($strAppShow2 == "Y"):?>
					<dd class="comment"><?php echo $strP_ETC; // 상품설명?></dd>
					<?php endif;?>
					<?php if($strAppShow3 == "Y"):?>
					<dd class="pricePoint"><?php echo $intProdPointMoney; // 적립금?></dd>
					<?php endif;?>
					<?php if($strAppShow4 == "Y"):?>
					<dd class="priceConsumer"><s><?php echo $strP_CONSUMER_PRICE; // 소비자가격?></s></dd>
					<?php endif;?>
					<?php if($strAppShow5 == "Y"):?>
					<dd class="priceSale"><span><?php echo $strTextPrice; // 가격?></span></dd>
					<?php endif;?>
					<?php if($intP_QTY):?>
					<dd class="qty"><?php echo $strP_QTY; // 제고수량?></dd>
					<?php endif;?>
					<?php if($intProdDiscountRate > 0 && $strProdDiscountRateText):?>
					<dd class="discount"><?php echo $strProdDiscountRateText; // 할인율?></dd>
					<?php endif;?>
					<?php if($strProdFreeDeliveryText):?>
					<dd class="deliveryfree"><?php echo $strProdFreeDeliveryText; // 무료배송?></dd>
					<?php endif;?>
				</dl>
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
	</li>
<?php endwhile;?>
</ul>
<!-- 기획전 상품 리스트 //-->
<?php endforeach;?>
</div>

