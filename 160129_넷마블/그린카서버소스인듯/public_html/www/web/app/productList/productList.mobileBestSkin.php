<?php
	/**
	 * eumshop app - productList - mobileBestSkin
	 *
	 * 상품 브랜드 리스트를 불러옵니다.
	 * 디자인관리 추천상품 옵션을 따라갑니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productList/productList.mobileBestSkin.php
	 * @manual		menuType=app&mode=productList&skin=mobileBestSkin
	 * @history
	 *				2014.06.15 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_LIST_{$intAppID}";
	endif;

	## 모듈 설정
	require_once MALL_HOME . "/config/product.func.php";
	$objProductMgrModule		= new ProductMgrModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productList/productList.mobileBestSkin.js";

	## 기본 설정
	$intAppNo					= $EUMSHOP_APP_INFO['no'];
	$strAppType					= $EUMSHOP_APP_INFO['type']; // main or sub or brand
	$strAppLang					= $EUMSHOP_APP_INFO['lang'];

	## 체크
	if(!$intAppNo) { return; }
	if(!$strAppType) { $strAppType = "main"; } 	
	if(!$strAppLang) { $strAppLang = $S_SITE_LNG; }
	
	## 타입 설정
	$strAppType = strtoupper($strAppType);
	if(!in_array($strAppType, array("MAIN","SUB"))) { return; }

	## 아이콘 번호 설정
	$intIconNo = $intAppNo;
	if($strAppType == "SUB") { $intIconNo = $intIconNo + 5; }

	## 설정 정보 include
	include_once MALL_SHOP . "/conf/site_skin_main.conf.inc.php";
	include_once MALL_SHOP . "/conf/site_skin_product.conf.inc.php";


	## 옵션 설정
	$strAppUse				= ${"S_ARY_{$strAppType}_PRODLIST_USE"}[$intAppNo];
	$strAppTitle			= ${"S_{$strAppType}_PRODLIST_TIT_{$intAppNo}"};
	$intAppWSize 			= ${"S_{$strAppType}_PRODLIST_IMG_SIZE_W_{$intAppNo}"};
	$intAppHSize			= ${"S_{$strAppType}_PRODLIST_IMG_SIZE_H_{$intAppNo}"};
	$intAppWList 			= ${"S_{$strAppType}_PRODLIST_IMG_VIEW_W_{$intAppNo}"};
	$intAppHList			= ${"S_{$strAppType}_PRODLIST_IMG_VIEW_H_{$intAppNo}"};
	$strAppWAlign			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_WORD_ALIGN"};
	$strAppMoney			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_MONEY_TYPE"};
	$strAppMoneyIcon		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_MONEY_ICON"};
	$strAppShow1			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_1"};
	$strAppShow2			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_2"};
	$strAppShow3			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_3"};
	$strAppShow4			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_4"};
	$strAppShow5			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_5"};
	$strAppShow6			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_6"};
	$strAppShow7			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_7"};
	$strAppShow8			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_8"};
	$strAppColor1			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_1"};
	$strAppColor2			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_2"};
	$strAppColor3			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_3"};
	$strAppColor4			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_4"};
	$strAppColor5			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_5"};
	$strAppTitleShow		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TITLE_SHOW_USE"};
	$strAppTitleFile		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TITLE_FILE_NAME"};
	$intAppTitleMaxsize		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TITLE_MAXSIZE"};
	$strAppTurnUse			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TURN_USE"};

	## 2015.03.11 kim hee sung
	## 진열장 이름 설정 변경으로 내용 추가
	include_once MALL_SHOP . "/conf/product.inc.php";
	if($S_ARY_PRODUCT_LIST_MAIN):
		if($strAppType == 'MAIN'):
			$strAppTitle	= $S_ARY_PRODUCT_LIST_MAIN[$intAppNo]['NAME'];
			$strAppUse		= $S_ARY_PRODUCT_LIST_MAIN[$intAppNo]['USE'];
		else:
			$strAppTitle	= $S_ARY_PRODUCT_LIST_SUB[$intAppNo]['NAME'];
			$strAppUse		= $S_ARY_PRODUCT_LIST_SUB[$intAppNo]['USE'];
		endif;
	endif;


	## 상품 출력 개수 설정
	if(!$intAppWList) { $intAppWList = 2; }
	if(!$intAppHList) { $intAppHList = 2; }
	$intPageLine		= $intAppWList * $intAppHList;

	## 체크
	if($strAppUse != "Y") {return; }

	## 통화 설정
	$strAppMoneyIconL		= "";
	$strAppMoneyIconR		= "";
	if($strAppMoney == "sign" || $strAppMoney == "won"){ 
		if ($strAppLang != "KR" && $strAppLang != "JP" && $strAppLang != "RU"){
			if ($strAppLang == "ES") $strAppMoneyIconL = $S_SITE_CUR_MARK1;
			else $strAppMoneyIconL = $S_SITE_CUR_MARK2." ";
		} else {
			if ($strAppLang == "JP") $strAppMoneyIconR = $S_SITE_CUR_MARK1;
			else if ($strAppLang == "RU") $strAppMoneyIconR = $S_SITE_CUR_MARK1;
			else $strAppMoneyIconR = $S_SITE_CUR_MARK2;
		}
	} 
	else if($strAppMoney =="icon")	{ $strAppMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strAppMoneyIcon); } 
	else						{ $strAppMoneyIcon = ""; }

	## 데이터 불러오기
	$param							= "";
	$param['LNG']					= $strAppLang;
	$param['P_ICON'][]				= $intIconNo;
	$param['LIMIT']					= "{$intPageLine}";
	$param['P_WEB_VIEW']			= "Y";
	$param['PRODUCT_INFO_JOIN']		= "Y";
	$param['PRODUCT_IMG_JOIN']		= "Y";
//	$param['PRODUCT_IMG_JOIN2']		= "Y"; ## 2014.06.18 kim hee sung 모바일 사용안함.
	$param['UBJ_JOIN']				= "Y";
	$aryProdList					= $objProductMgrModule->getProductMgrSelectEx("OP_ARYTOTAL", $param);
	
	## 체크
	if(!$aryProdList) { return; }
?>
<!-- eumshop app - productList - mobileBestSkin (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']					= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']					= "<?php echo $strAppSkin;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PRICE_HIDE']			= "<?php echo $isPriceHide;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['S_PRICE_SHOW_VIEW']		= "<?php echo $S_PRICE_SHOW_VIEW;?>"; 
</script>
<div id="<?php echo $strAppID?>" class="prodListWrap">
	<?php if($strAppTitleShow != "Y" && $strAppTitle):?>
		<h2><?php echo $strAppTitle;?></h2>
	<?php endif;?>
	<ul>
		<?php foreach($aryProdList as $key => $row):
	
				## 기본 설정
				$strP_CODE = $row['P_CODE'];
				$strP_NAME = $row['P_NAME'];
				$intP_GRADE = $row['P_GRADE'];
				$intP_GRADE_CNT = $row['P_GRADE_CNT'];
				$strP_COLOR = $row['P_COLOR'];
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
				$intP_SALE_PRICE = $row['P_SALE_PRICE'];
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
				if($intP_CONSUMER_PRICE > 0 && $intP_SALE_PRICE != $intP_CONSUMER_PRICE):
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

				## td style 설정
//				$strStyleTD = "";
//				if($j==($intAppWList-1)) { $strStyleTD = "width:{$intAppWSize}px"; }

				## div class 설정
//				$strClassDiv = "productInfoWrap";
//				if($j==($intAppWList-1)) { $strClassDiv .= " endProdList"; }

				## div style 설정
//				$strStyleDiv = "width:{$intAppWSize}px;text-align:{$strAppWAlign}";

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
						<?php if($strAppShow4 == "Y" && $strP_CONSUMER_PRICE):?>
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
		<?php endforeach;?>
	</ul>
	<div class="clr"></div>
</div>
<!-- eumshop app - productList - mobileBestSkin (<?php echo $strAppID?>) -->