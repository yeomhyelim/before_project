<?php
	/**
	 * 작성일		: 2013.12.12
	 * 작성자		: kim hee sung
	 * 내  용		: 추천 상품을 슬라이더 모션으로 보여줌.
	 * 참고사항		: 수정을 원하시는 경우 반드시 주석을 작성해주시기 바랍니다.
	 *				  개발 규칙이 있으므로 반드시 개발자에게 문의 바랍니다.
	 **/

	## 모듈 설정
	include_once SHOP_HOME . "/conf/product.inc.php";
	include_once SHOP_HOME . "/conf/site_skin_product.conf.inc.php";
	include_once MALL_HOME . "/config/product.func.php";
	require_once MALL_HOME . "/module2/ProductMgr.module.php";
	if(!$productMgrModule):
	$productMgrModule				= new ProductMgrModule($db);
	endif;

	$aryScript[]			= "/common/js/app/productSlider/jquery.jcarousel-core.js";
	$aryScript[]			= "/common/js/app/productSlider/jquery.jcarousel-eum.js";
	$aryScriptEx[]			= "/common/js/app/productSlider/jquery.jcarousel-core.js";
	$aryScriptEx[]			= "/common/js/app/productSlider/jquery.jcarousel-eum.js";

	## 기본 설정
	$intAppID						= $intAppID + 1; 
	$strAppID						= "APP_ID_{$intAppID}";
	
	## 옵션 설정
	if($EUMSHOP_APP_INFO['itemCnt'])	{ $intAppItemCnt	= $EUMSHOP_APP_INFO['itemCnt'];		}
	if($EUMSHOP_APP_INFO['iconNo'])		{ $intAppIconNo		= $EUMSHOP_APP_INFO['iconNo'];		}
	if($EUMSHOP_APP_INFO['play'])		{ $strAppPlay		= $EUMSHOP_APP_INFO['play'];		}

	## 기본 설정
	$intSliderListLength			= 0;
	$intSliderItemCnt				= $EUMSHOP_APP_INFO['itemCnt'];
	$intIconNo						= $EUMSHOP_APP_INFO['iconNo'];
	$strPlay						= $EUMSHOP_APP_INFO['play'];
//	$intWSize 						= ${"S_MAIN_PRODLIST_IMG_SIZE_W_{$intIconNo}"};
//	$intHSize						= ${"S_MAIN_PRODLIST_IMG_SIZE_H_{$intIconNo}"};
//	$intWList 						= ${"S_MAIN_PRODLIST_IMG_VIEW_W_{$intIconNo}"};
//	$intHList						= ${"S_MAIN_PRODLIST_IMG_VIEW_H_{$intIconNo}"};
	$strWAlign						= ${"S_MAIN_BEST_LIST{$intIconNo}_WORD_ALIGN"};
	$strMoney						= ${"S_MAIN_BEST_LIST{$intIconNo}_MONEY_TYPE"};
	$strMoneyIcon					= ${"S_MAIN_BEST_LIST{$intIconNo}_MONEY_ICON"};
//	$strShow1						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_1"};
//	$strShow2						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_2"};
//	$strShow3						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_3"};
//	$strShow4						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_4"};
//	$strShow5						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_5"};
//	$strShow6						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_6"};
//	$strShow7						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_7"};
//	$strShow8						= ${"S_MAIN_BEST_LIST{$intIconNo}_SHOW_8"};
//	$strColor1						= ${"S_MAIN_BEST_LIST{$intIconNo}_COLOR_1"};
//	$strColor2						= ${"S_MAIN_BEST_LIST{$intIconNo}_COLOR_2"};
//	$strColor3						= ${"S_MAIN_BEST_LIST{$intIconNo}_COLOR_3"};
//	$strColor4						= ${"S_MAIN_BEST_LIST{$intIconNo}_COLOR_4"};
//	$strColor5						= ${"S_MAIN_BEST_LIST{$intIconNo}_COLOR_5"};
//	$strTitleShow					= ${"S_MAIN_BEST_LIST{$intIconNo}_TITLE_SHOW_USE"};
//	$strTitleFile					= ${"S_MAIN_BEST_LIST{$intIconNo}_TITLE_FILE_NAME"};
//	$intTitleMaxsize				= ${"S_MAIN_BEST_LIST{$intIconNo}_TITLE_MAXSIZE"};

	## 통화 설정
	$strMoneyIconL					= "";
	$strMoneyIconR					= "";
	if($strMoney =="icon"): 
		// 아이콘 사용
		$strMoneyIconR				= "";
		$strMoneyIconL				= "<img src='/himg/icon/{$strMoneyIcon}'>";
	elseif(in_array($strMoney, array("sign","won"))):
		// 문자 사용
		if($S_SITE_LNG == "KR"):
			$strMoneyIconL			= "";
			$strMoneyIconR			= $S_SITE_CUR_MARK2;
		elseif($S_SITE_LNG == "JP"):
			$strMoneyIconL			= "";
			$strMoneyIconR			= $S_SITE_CUR_MARK1;
		elseif($S_SITE_LNG == "RU"):
			$strMoneyIconL			= "";
			$strMoneyIconR			= $S_SITE_CUR_MARK1;
		elseif($S_SITE_LNG == "US"):
			$strMoneyIconL			= $S_SITE_CUR_MARK2 . " ";
			$strMoneyIconR			= "";
		elseif($S_SITE_LNG == "CN"):
			$strMoneyIconL			= $S_SITE_CUR_MARK2 . " ";
			$strMoneyIconR			= "";
		endif;
	endif;

	## 데이터 불러오기
	$param							= "";
	$param['LNG']					= $S_SITE_LNG;
	$param['P_ICON'][]				= $intIconNo;
	$param['LIMIT']					= "0,20";
	$param['PRODUCT_INFO_JOIN']		= "Y";
	$param['PRODUCT_IMG_JOIN']		= "Y";
	$appResult						= $productMgrModule->getProductMgrSelectEx("OP_LIST", $param);

//	$productMgrModule->getProductMgrSelectEx2("OP_LIST", $param);
	
//	echo "<!--" . $db->query . "-->";

	## 초기화
	$arySliderList					= "";

	## 데이터 만들기
	if(is_resource($appResult)):
		while($row = mysql_fetch_array($appResult)):

			## 기본 설정
			$pcode							= $row['P_CODE'];
			$src							= $row['PM_REAL_NAME'];
			$title							= $row['P_NAME'];
			$listIcon						= explode("/", $row['P_LIST_ICON']);
			$href							= "./?menuType=product&mode=view&prodCode={$pcode}";
			$icon							= "";
			$price							= 0;

			## 금액 설정
			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")	{ $price = getProdDiscountPrice($row,"1",0,"US");		} 
			else											{ $price = getProdDiscountPrice($row);					}

			$price							= $strMoneyIconL . $price . $strMoneyIconR;

			## 아이콘 설정
			if($listIcon):
				foreach($listIcon as $key => $data):
					if($data) { $icon[$data]	= $S_ARY_PRODUCT_LIST_ICON[$data]; }
				endforeach;
			endif;

			## 데이터 만들기
			$arySliderList['src'][]			= $src;
			$arySliderList['title'][]		= $title;
			$arySliderList['price'][]		= $price;
			$arySliderList['href'][]		= $href;
			$arySliderList['icon']['1'][]	= $icon[1];
			$arySliderList['icon']['2'][]	= $icon[2];
			$arySliderList['icon']['3'][]	= $icon[3];
			$arySliderList['icon']['4'][]	= $icon[4];
			$arySliderList['icon']['5'][]	= $icon[5];
			$arySliderList['icon']['6'][]	= $icon[6];
			$arySliderList['icon']['7'][]	= $icon[7];

			## 기타 설정
			$intSliderListLength++;			// 개수 증가
//			break;
		endwhile;
	endif;

	## 슬라이더 설정
//	$intSliderListLength			= 8;
//	$intSliderItemCnt				= 4;

//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131210/prodImg2/2013121000011.jpg";
//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131209/prodImg2/2013120900017.jpg";
//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131209/prodImg2/2013120900012.jpg";
//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131203/prodImg2/2013120300005.png";
//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131210/prodImg2/2013121000011.jpg";
//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131209/prodImg2/2013120900017.jpg";
//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131209/prodImg2/2013120900012.jpg";
//	$arySliderList['src'][]			= "http://www.ajkorea.com/upload/product/20131203/prodImg2/2013120300005.png";

//	$arySliderList['title'][]		= "[한정특가]보만[독일] 컬러 무선주전자";
//	$arySliderList['title'][]		= "[특가한정] [독일 가이타이너] 오븐기 GT-06T";
//	$arySliderList['title'][]		= "[크린웰] No1 생활과학 할로겐 히터 BHH-800";
//	$arySliderList['title'][]		= "[한정특가]울트라 메가 골드 멀티비타민&미네랄";
//	$arySliderList['title'][]		= "[한정특가]보만[독일] 컬러 무선주전자";
//	$arySliderList['title'][]		= "[특가한정] [독일 가이타이너] 오븐기 GT-06T";
//	$arySliderList['title'][]		= "[크린웰] No1 생활과학 할로겐 히터 BHH-800";
//	$arySliderList['title'][]		= "[한정특가]울트라 메가 골드 멀티비타민&미네랄";

//	$arySliderList['price'][]		= "32,900원";
//	$arySliderList['price'][]		= "35,000원";
//	$arySliderList['price'][]		= "59,900원";
//	$arySliderList['price'][]		= "22,900원";
//	$arySliderList['price'][]		= "32,900원";
//	$arySliderList['price'][]		= "35,000원";
//	$arySliderList['price'][]		= "59,900원";
//	$arySliderList['price'][]		= "22,900원";

//	$arySliderList['href'][]		= "http://www.naver.com";
//	$arySliderList['href'][]		= "http://www.naver.com";
//	$arySliderList['href'][]		= "http://www.naver.com";
//	$arySliderList['href'][]		= "http://www.naver.com";
//	$arySliderList['href'][]		= "http://www.naver.com";
//	$arySliderList['href'][]		= "http://www.naver.com";
//	$arySliderList['href'][]		= "http://www.naver.com";
//	$arySliderList['href'][]		= "http://www.naver.com";

//	$arySliderList['icon']['1'][]	= "http://ajkorea.com/himg/icon/prod_icon_new.gif";	
//	$arySliderList['icon']['1'][]	= "http://ajkorea.com/himg/icon/prod_icon_new.gif";	
//	$arySliderList['icon']['1'][]	= "http://ajkorea.com/himg/icon/prod_icon_new.gif";	
//	$arySliderList['icon']['1'][]	= "http://ajkorea.com/himg/icon/prod_icon_new.gif";	
//	$arySliderList['icon']['1'][]	= "http://ajkorea.com/himg/icon/prod_icon_new.gif";	
//	$arySliderList['icon']['1'][]	= "http://ajkorea.com/himg/icon/prod_icon_new.gif";	
//	$arySliderList['icon']['1'][]	= "http://ajkorea.com/himg/icon/prod_icon_new.gif";	
//
//	$arySliderList['icon']['2'][]	= "http://ajkorea.com/himg/icon/prod_icon_best.gif";
//	$arySliderList['icon']['2'][]	= "http://ajkorea.com/himg/icon/prod_icon_best.gif";	
//	$arySliderList['icon']['2'][]	= "http://ajkorea.com/himg/icon/prod_icon_best.gif";
//	$arySliderList['icon']['2'][]	= "http://ajkorea.com/himg/icon/prod_icon_best.gif";
//	$arySliderList['icon']['2'][]	= "http://ajkorea.com/himg/icon/prod_icon_best.gif";
//	$arySliderList['icon']['2'][]	= "http://ajkorea.com/himg/icon/prod_icon_best.gif";	
//	$arySliderList['icon']['2'][]	= "http://ajkorea.com/himg/icon/prod_icon_best.gif";


//	include SHOP_HOME . "/app/productSlider/productSlider.inc.php";

?>
<style>
/*	.prodIcon img{float:left;} */
</style>
<div productSlider itemCnt="<?=$intSliderItemCnt?>" play="<?=$strPlay?>">
	<div class="jcarousel-wrapper">
		<div class="jcarousel">
			<ul>
				<?for($i=0;$i<$intSliderListLength;$i++):
					$src		= $arySliderList['src'][$i];
					$title		= $arySliderList['title'][$i];
					$price		= $arySliderList['price'][$i];	
					$href		= $arySliderList['href'][$i];
					$icon1		= $arySliderList['icon']['1'][$i];
					$icon2		= $arySliderList['icon']['2'][$i];
					$icon3		= $arySliderList['icon']['3'][$i];
					$icon4		= $arySliderList['icon']['4'][$i];
					$icon5		= $arySliderList['icon']['5'][$i];
					$icon6		= $arySliderList['icon']['6'][$i];
					$icon7		= $arySliderList['icon']['7'][$i];		?>
				<li>
					<?if($href):?><a href="<?=$href?>"><?endif;?>
					<?if($src):?><img src="<?=$src?>" alt="<?=$title?>" class="listProdImg"><?endif;?>
					<?if($href):?></a><?endif;?>
					<div class="prodIcon">
					<?if($icon1):?><?=$icon1?><?endif;?>
					<?if($icon2):?><?=$icon2?><?endif;?>
					<?if($icon3):?><?=$icon3?><?endif;?>
					<?if($icon4):?><?=$icon4?><?endif;?>
					<?if($icon5):?><?=$icon5?><?endif;?>
					<?if($icon6):?><?=$icon6?><?endif;?>
					<?if($icon7):?><?=$icon7?><?endif;?>
						<div class="clr"></div>
					</div>
					<?if($href):?><a href="<?=$href?>"><?endif;?>
					<?if($title):?><p class="title"><?=$title?></p><?endif;?>
					<?if($href):?></a><?endif;?>
					<?if($price):?><p class="priceSale"><?=$price?></p><?endif;?>
					
				</li>
				<?endfor;?>
			</ul>
		</div>

		<a href="#" class="jcarousel-control-prev"><span>&lsaquo;</span></a>
		<a href="#" class="jcarousel-control-next"><span>&rsaquo;</span></a>

		<p class="jcarousel-pagination"></p>
	</div>
</div>
