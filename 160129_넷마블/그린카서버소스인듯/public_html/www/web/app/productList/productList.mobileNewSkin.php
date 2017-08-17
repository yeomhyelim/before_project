<?php
	/**
	 * eumshop app - productList - mobileNewSkin
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
	 * @filesource	/www/web/app/productList/productList.mobileNewSkin.php
	 * @manual		menuType=app&mode=productList&skin=mobileNewSkin
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
	$aryScriptEx[]				= "/common/js/app/productList/productList.mobileNewSkin.js";

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
	//if($strAppUse != "Y") {return; }


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
	//$param['LIMIT']					= "{$intPageLine}";
	$param['LIMIT']					= "10";
	$param['P_MOB_VIEW']			= "Y";
	$param['PRODUCT_INFO_JOIN']		= "Y";
	$param['PRODUCT_IMG_JOIN']		= "Y";
//	$param['PRODUCT_IMG_JOIN2']		= "Y"; ## 2014.06.18 kim hee sung 모바일 사용안함.
	$param['UBJ_JOIN']				= "Y";
	//$param['ORDER_BY']				= "productRegDateDesc";
	$aryProdList					= $objProductMgrModule->getProductMgrSelectEx("OP_ARYTOTAL", $param);

	## 체크
	if(!$aryProdList) { return; }

?>
<!-- eumshop app - productList - mobileNewSkin (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']					= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']					= "<?php echo $strAppSkin;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['PRICE_HIDE']			= "<?php echo $isPriceHide;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['S_PRICE_SHOW_VIEW']		= "<?php echo $S_PRICE_SHOW_VIEW;?>";
</script>
<div id="<?php echo $strAppID?>" class="prodListWrap">
	<?php if($strAppTitleShow != "Y" && $strAppTitle):?>
		<!--h2><?php// echo $strAppTitle;?></h2-->
	<?php endif;?>
	<ul id="<?php echo $strAppID?>_ul">
		<?php foreach($aryProdList as $key => $row):

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
				$strP_CATE = $row['P_CATE']; //
				$strSH_COM_NAME = $row['SH_COM_NAME']; // 회사명
				$strP_PRICE_FILTER = $row['P_PRICE_FILTER'];
				$strP_PRICE_UNIT = $row['P_PRICE_UNIT']; //

				## 체크
				if(!$strP_CODE) { continue; }

				## 재고 수량 표시
				$strP_QTY = "";
				if($S_IS_QTY_SHOW == "Y"):
					## 제고 수량 설정
					if($intP_QTY) { $strP_QTY = "<span>".$LNG_TRANS_CHAR["PW00080"]."</span>" . $intP_QTY; }
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
				$strTextPriceUsd = "";
				if($strP_PRICE_FILTER=='FOB')
				{
				 	//$strTextPrice = getCurMark("$") .getProdDiscountPrice($row,"1",0,"US");
					$strTextPrice = getCurMark("$") .number_format($row['P_SALE_PRICE']);
					$strTextPrice = $strAppMoneyIconL.$strTextPrice;
					//$strTextPrice .= '$';
				}else{
					$strTextPrice = getProdDiscountPrice($row);
					$strTextPrice = $strAppMoneyIconL.$strTextPrice;
					$strTextPrice .= $strAppMoneyIconR;
				}
				//$strTextPrice = $strAppMoneyIconL . getProdDiscountPrice($row) . $strAppMoneyIconR;
				if($S_ARY_CUR[$strAppLang]["USD"][2] == "Y") { $strTextPrice = getCurMark("$") . getProdDiscountPrice($row,"1",0,"US") . getCurMark2("USD"); }
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
					if( isset($row[$key]['P_CONSUMER_PRICE']) && $row[$key]['P_CONSUMER_PRICE'] > 0.00001 ){
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
		<li>
			<a href="javascript:goProdView('<?php echo $strP_CODE?>');">
			<div class="productInfoWrap">
				<div class="prodListImg">
					<img src="<?php echo $strPM_REAL_NAME?>" class="listProdImg"><!--상품이미지-->
					<?php if($isSoldOut):?>
					<!--div class="soldout">Sold Out</div-->
					<div class="soldoutImg"><img src="/upload/images/img_soldout.png" /></div>
					<?php endif;?>
					<div class="icoWrap">
						<!--<a href="javascript:goWish();" class="btnProdWish"><img src="/upload/images/ico_list_star1.png" alt="담아두기" title="담아두기"> <span class="ico_wish">담아두기</span></a>
						<img src="/upload/images/ico_list_chk1.png" alt="비교하기" title="비교하기"> <span class="ico_chk">비교하기</span>-->
					</div>
				</div>
				<div class="prodInfoSum">
					<dl>
						<!--색상-->
						<!--브렌드-->
						<dd class="title"><span><?php echo $strP_NAME;?></span></dd><!--상품명-->
						<dd class="prodInfo">
							<ul class="info">
								<li><span class="tit">제조사</span><strong><?=$strSH_COM_NAME// 회사명?></strong></li>
								<li><span class="tit">상품가격</span><strong><?php echo $strTextPrice; // 가격?><?if($strP_PRICE_UNIT){?>&nbsp;/&nbsp;<?=$strP_PRICE_UNIT?> <?}?></strong></li>
							</ul>
						</dd>
						<div class="clr"></div>
					</dl>
				</div>
				<div class="clr"></div>
			</div>
			</a>
		</li>
		<?php endforeach;?>
	</ul>
	<div class="clr"></div>
</div>
<script>
$(document).ready(function() {
	$('#<?php echo $strAppID?>_ul').bxSlider({
		minSlides: 3,
		maxSlides: 3,
		moveSlides: 1,
		slideWidth: 400,
		slideMargin: 5,
		pause: 3000,
		pager: false,
		auto: false,
		infiniteLoop: false,
		controls:true //전 후 콘트롤 보이기 안보이기
	});
});
</script>
<!-- eumshop app - productList - mobileNewSkin (<?php echo $strAppID?>) -->