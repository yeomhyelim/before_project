<?php
	/**
	 * eumshop app - productList - shopSkin2
	 *
	 * 상품리스트 - 입점사스킨입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productList/productList.shopSkin2.php
	 * @manual		menuType=app&mode=productList&skin=shopSkin2
	 * @history
	 *				2014.08.18 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1;
		$strAppID				= "PRODUCT_LIST_{$intAppID}";
	endif;

	## 기본설정
	$intShNo = $_GET['sh_no'];
	$strLang = $S_SITE_LNG;
	$strLangLower = strtolower($strLang);

	## 체크
	if(!$intShNo) { return; }

	## 모듈 설정
	$objProductListModule = new ProductListModule($db);
	$objShopSiteModule = new ShopSiteModule($db);
	$objShopMgrModule = new ShopMgrModule($db);

	## 입점몰 정보 불러오기
	$param = "";
	$param['SH_NO'] = $intShNo;
	$aryShopRow = $objShopMgrModule->getShopMgrSelectEx("OP_SELECT", $param);
	$strSH_COM_ADDR = $aryShopRow['SH_COM_ADDR'];
	$strSH_COM_ADDR2 = $aryShopRow['SH_COM_ADDR2'];

	## 상점정보 불러오기
	$param = "";
	$param['SH_NO'] = $intShNo;
	$aryShopSiteRow = $objShopSiteModule->getShopSiteSelectEx("OP_SELECT", $param);
	if(!$aryShopSiteRow) { return; }

	## 기본설정
	$strLogDir = "/upload/shop/store_{$intShNo}/design";
	$strST_LOGO = $aryShopSiteRow['ST_LOGO'];
	$strST_NAME_ENG = $aryShopSiteRow['ST_NAME_ENG'];
	$strST_THUMB_IMG = $aryShopSiteRow['ST_THUMB_IMG'];

	## 이미지 설정
	$strLogFile = $strST_LOGO;
	if($strLogFile) { $strLogFile = "{$strLogDir}/{$strLogFile}"; }

	## 탑베너
	$strThumbImg = $strST_THUMB_IMG;
	if($strThumbImg) { $strThumbImg = "{$strLogDir}/{$strThumbImg}"; }

	## 설명 설정
	$strST_MEMO = $aryShopSiteRow['ST_MEMO'];

	## 상품 개수 불러오기
	$param = "";
	$param['P_SHOP_NO'] = $intShNo;
//	$param["P_CATE"] = $strCode;
	$param["P_LNG"] = $strLang;
	$param['P_WEB_VIEW'] = "Y";
	$intCnt = $objProductListModule->getProductListSelectEx("OP_COUNT",$param);
	$intProductTotal = $intCnt;
	$strProductTotal = number_format($intProductTotal);

	## 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.{$strLangLower}.inc.php";
	$aryCate1List =  $S_CATE_MENU1;

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['LANG'] = $strAppLang;
	$aryAppParam['SHOP_ADDRESS'] = $strSH_COM_ADDR.$strSH_COM_ADDR2;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

	## script 설정
	$aryScriptEx[] = "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyC8VLBkUZxQaV0hNMuvuib0LAphwYuI-Bk";
	$aryScriptEx[] = "/common/js/app/productList/productList.shopSkin2.js";
?>
<div id="<?php echo $strAppID?>">
	<link rel="stylesheet" type="text/css" href="/common/css/product/product_0001.css"/>
	<div class="brandBodyWrap">
		<div class="brandLeftBody">

			<!-- 공통 소스 //-->
			<?php if($strThumbImg):?>
			<div class="thumbImg">
				<img src="<?php echo $strThumbImg;?>">
			</div>
			<?php endif;?>
			<?php if($strST_MEMO):?>
			<div class="memo">
			<?php echo $strST_MEMO;?>
			</div>
			<?php endif;?>
			<div class="listTopSortWrap">
				<h3><strong class="cate_tit"> <span class="product-list-name" appID="<?php echo $strAppID;?>"></span></strong> <?=callLangTrans($LNG_TRANS_CHAR['PS00013'],array("<span class='product-list-total' appID='{$strAppID}'></span>"))?></h3>
				<div class="sortBtn">
					<span class="txt">
						<?=$LNG_TRANS_CHAR["PW00026"]//제조사?><a href="javascript:goSearchSort('RA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('RD');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a>
					</span>
					<span class="txt">
						<?=$LNG_TRANS_CHAR["OW00058"]//상품명?><a href="javascript:goSearchSort('NA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('ND');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a>
					</span>
					<span class="txt">
						<?=$LNG_TRANS_CHAR["PW00008"]//적립금?><a href="javascript:goSearchSort('PA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('PD');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a>
					</span>
					<span class="txt">
						<?=$LNG_TRANS_CHAR["PW00004"]//판매가격?><a href="javascript:goSearchSort('RA');"><img src="/himg/product/A0001/kr/btn_sort_down.gif"></a><a href="javascript:goSearchSort('RD');"><img src="/himg/product/A0001/kr/btn_sort_up.gif"></a>
					</span>
				</div>
				<div class="clr"></div>
			</div>

			<?
			$EUMSHOP_APP_INFO = "";
			$EUMSHOP_APP_INFO['name'] = "상품리스트";
			$EUMSHOP_APP_INFO['mode'] = "productList";
			$EUMSHOP_APP_INFO['appID'] = $strAppID;
			$EUMSHOP_APP_INFO['wList'] = 3;
			include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
			?>

			<div id="pagenate">
				<span class="product-list-paginate" appID="<?php echo $strAppID;?>"></span>
			</div>
			<!-- 공통 소스 //-->

		</div><!--// brandLeftBody -->

		<div class="brandRightBody">
			<div class="brandCateListWrap">
				<h3>Shop Sections</h3>
				<ul>
					<li class="shopHome"><a href="./?menuType=shop&mode=shopProdList&sh_no=<?php echo $intShNo;?>">Shop Home <span class="number"><?php echo $strProductTotal;?> Item</span></a></li>
					<?php foreach($aryCate1List as $key1 => $data1):

							## 기본정보
							$strName = $data1['NAME'];
							$strCode = $data1['CODE'];
							$strCate1 = substr($strCode, 0, 3);
							$strCate2 = substr($strCode, 3, 3);
							$strCate3 = substr($strCode, 6, 3);
							$strCate4 = substr($strCode, 9, 3);

							## 상품 개수 불러오기
							$param = "";
							$param['P_SHOP_NO'] = $intShNo;
							$param["P_CATE"] = $strCode;
							$param["P_LNG"] = $strLang;
							$param['P_WEB_VIEW'] = "Y";
							$intCnt = $objProductListModule->getProductListSelectEx("OP_COUNT",$param);

							## 2차 카테고리 불러오기
							$aryCate2List = $S_CATE_MENU2[$strCode];
					?>
					<li><a href="./?menuType=shop&mode=shopProdList&sh_no=<?php echo $intShNo;?>&lcate=<?php echo $strCate1;?>&mcate=<?php echo $strCate2;?>&scate=<?php echo $strCate3;?>&fcate=<?php echo $strCate4;?>"><?php echo $strName;?> <span class="number"><?php echo $intCnt;?></span></a>
						<?php if($aryCate2List):?>
						<!-- 2차 카테고리 //-->
						<ul class="cate2List">
							<?php foreach($aryCate2List as $key2 => $data2):

									## 기본정보
									$strName = $data2['NAME'];
									$strCode = $data2['CODE'];
									$strCate1 = substr($strCode, 0, 3);
									$strCate2 = substr($strCode, 3, 3);
									$strCate3 = substr($strCode, 6, 3);
									$strCate4 = substr($strCode, 9, 3);

									## 상품 개수 불러오기
									$param = "";
									$param['P_SHOP_NO'] = $intShNo;
									$param["P_CATE"] = $strCode;
									$param["P_LNG"] = $strLang;
									$param['P_WEB_VIEW'] = "Y";
									$intCnt = $objProductListModule->getProductListSelectEx("OP_COUNT",$param);

									## 상품 개수가 0개인건 출력을 하지 않습니다.
									if(!$intCnt) { continue; }

							?>
							<li><a href="./?menuType=shop&mode=shopProdList&sh_no=<?php echo $intShNo;?>&lcate=<?php echo $strCate1;?>&mcate=<?php echo $strCate2;?>&scate=<?php echo $strCate3;?>&fcate=<?php echo $strCate4;?>"><?php echo $strName;?><span class="number"><?php echo $intCnt;?></span></a></li>
							<?php endforeach;?>
						</ul>
						<!-- 2차 카테고리 //-->
						<?php endif;?>
					</li>
					<?php endforeach;?>
				</ul>
			</div><!--// brandCateListWrap -->

			<div class="shopInfoWrap">
				<h3>Shop Owner</h3>

				<div class="shopInfoBox">
					<div class="shopInfo">
						<ul>
							<li class="shopLogo"><img src="<?php echo $strLogFile;?>" alt="shop logo" class="shopLogo"/></li>
							<li class="info">
								<p class="txt_info"><strong>Carly and Aubree Ng</strong></p>
								<p class="txt_address">Portland, Oregon</p>
							</li>
							<li class="customer1">
								<p class="txt_question"><strong>Have a Question?</strong></p>
								<p class="txt">Contact the shop owner.</p>
								<div class="clr"></div>
							</li>
							<li class="customer2">
								<p class="txt_customer"><strong>Need a custom order?</strong></p>
								<p class="txt"><a href="#" class="btnOrder">Request Custom Order</a></p>
								<div class="clr"></div>
							</li>
						</ul>
					</div>
					<div class="map" id="shopMap" style="width:200px;height:200px"></div>
					<!-- div class="map" id="map"><img src="/upload/images/img_map.gif" alt="shop Map" class="shopMap"/></div //-->
				</div><!--//shopInfoBox -->
			</div><!--// shopInfoWrap -->

		</div><!--//brandRightBody -->
		<div class="clr"></div>
	</div><!--//brandBodyWrap -->
</div>