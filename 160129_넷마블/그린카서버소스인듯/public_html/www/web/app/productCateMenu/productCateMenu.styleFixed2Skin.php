<?php
	/**
	 * eumshop app - productCateMenu - styleFixed2Skin
	 *
	 * 3차 카테고리 기본 표시
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productCateMenu/productCateMenu.styleFixed2Skin.php
	 * @manual		menuType=app&mode=productCateMenu&skin=styleFixed2Skin
	 * @history
	 *				2014.06.07 kim hee sung - 개발 완료
	 */

	## 모듈 설정
	$objProductMgrModule		= new ProductMgrModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productCateMenu/productCateMenu.styleFixed2Skin.js";

	## appID 설정
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_CATE_MENU_{$intAppID}";
	endif;

	## 기본 설정  
	## lcate=002&mcate=001&scate=&fcate=
	$strAppLng						= $EUMSHOP_APP_INFO['lng'];
	$strAppSelectCate			= $EUMSHOP_APP_INFO['selectCate'];
	$strAppHost						= $EUMSHOP_APP_INFO['host'];
	if(!$strAppSelectCate) { $strAppSelectCate = "{$_GET['lcate']}{$_GET['mcate']}{$_GET['scate']}{$_GET['fcate']}"; }
	$strAppSelectCate1			= substr($strAppSelectCate, 0, 3);
	$strAppSelectCate2			= substr($strAppSelectCate, 3, 3);
	$strAppSelectCate3			= substr($strAppSelectCate, 6, 3);
	$strAppSelectCate4			= substr($strAppSelectCate, 9, 3);
	if(!$strAppSelectCate1) { return; }
	if(!$strAppSelectCate2) { return; }
	if(!$strAppLng) { $strAppLng = $S_SITE_LNG; }
	if(!$strAppHost) { $strAppHost = $strHostType; }
	$strAppLngLower				= strtolower($strAppLng);

	## 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.{$strAppLngLower}.inc.php";

	## 3차 카테고리 찾기
	$aryAppCate3List			= "";
	foreach($S_ARY_CATE1 as $key1 => $data1):
		## 기본설정
		$strCODE = $data1['CODE'];
		$strSHARE = $data1['SHARE'];
		$strVIEW= $data1['VIEW'];
		if($strCODE != $strAppSelectCate1) {continue; }
		if($strSHARE == "Y") { continue; }
		if($strVIEW != "Y") { continue; }

		foreach($S_ARY_CATE2[$key1] as $key2 => $data2):
			## 기본설정
			$strCODE = $data2['CODE'];
			$strSHARE = $data2['SHARE'];
			$strVIEW= $data2['VIEW'];
			$strCODE1 = substr($strCODE, 0, 3);
			$strCODE2 = substr($strCODE, 3, 3); 
			if($strCODE1 != $strAppSelectCate1) {continue; }
			if($strCODE2 != $strAppSelectCate2) {continue; }
			if($strSHARE == "Y") { continue; }
			if($strVIEW != "Y") { continue; }

			## 3차 카티고리 찾지 완료
			$aryAppCate3List = $S_ARY_CATE3[$key1][$key2];
			break;

		endforeach;

	endforeach;

	## 3차 카테고리 정보가 없으면.
	if(!$aryAppCate3List) { return; }
	
?>
<!-- eumshop app - productCateMenu - styleFixed2Skin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID;?>">
	<div class="cate3-wrap">
		<ul class="cateList">
		<?php foreach($aryAppCate3List as $key => $data):

				## 기본설정
				$strCODE = $data['CODE'];
				$strNAME = $data['NAME'];
				$strSHARE = $data['SHARE'];
				$strVIEW= $data['VIEW'];
				$intLOW_CNT = $data['LOW_CNT'];
				$strOnClass = "";
				$strCODE1 = substr($strCODE, 0, 3);
				$strCODE2 = substr($strCODE, 3, 3);
				$strCODE3 = substr($strCODE, 6, 3);

				if($strSHARE == "Y") { continue; }
				if($strVIEW != "Y") { continue; }
				if($strAppSelectCate1 == $strCODE1 && $strAppSelectCate2 == $strCODE2 && $strAppSelectCate3 == $strCODE3):
					$strOnClass = " on"; 
				endif;

				## 상품 개수 구하기
				$param = "";
				$param['LNG'] = $strAppLng;

				if($strAppHost == "mobile"):
					$param['P_MOB_VIEW'] = "Y";
				else:
					$param['P_WEB_VIEW'] = "Y"; 
				endif;

				$param['P_CATE_LIKE'] = $strCODE;
				$intProdCnt = $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);
		?>
			<li class="cate3<?php echo $strOnClass;?>">
				<a href="javascript:goProductCateMenuStyleFixed2SkinListMoveEvent('<?php echo $strCODE1;?>','<?php echo $strCODE2;?>','<?php echo $strCODE3;?>','')">
					<?php echo $strNAME;?><span>(<?php echo $intProdCnt;?>)</span>
				</a>
			</li>
		<?php endforeach;?>
		</ul>
		<div class="clr"></div>
	</div>
</div>
<!-- eumshop app - productCateMenu - styleFixed2Skin (<?php echo $strAppID?>) -->