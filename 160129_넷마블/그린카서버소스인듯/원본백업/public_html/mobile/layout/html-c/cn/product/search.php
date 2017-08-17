<?php
	## helper 설정
	include_once WEB_FRWORK_HELP."product.php";

	## 카테고리 설정
	$strCate1 = $_GET['lcate'];
	$strCate2 = $_GET['mcate'];
	$strCate3 = $_GET['scate'];
	$strCate4 = $_GET['fcate'];
	$strCate = $strCate1 . $strCate2 . $strCate3 . $strCate4;
	$strCate = str_pad($strCate, 12, '0');

	## 스크립트 설정
	$aryScriptEx[]				= "/mobile/layout/common/js/product.list.js";
?>
<div class="prodListBodyWrap">
	<div class="prodTitWrap">
		<h2>
		<?php
		$EUMSHOP_APP_INFO					= "";
		$EUMSHOP_APP_INFO['name']			= "상품이름";
		$EUMSHOP_APP_INFO['mode']			= "productLocation";
		$EUMSHOP_APP_INFO['skin']			= "lastNameSkin";
		$EUMSHOP_APP_INFO['cate1']			= $strCate1;
		$EUMSHOP_APP_INFO['cate2']			= $strCate2;
		$EUMSHOP_APP_INFO['cate3']			= $strCate3;
		$EUMSHOP_APP_INFO['cate4']			= $strCate4;
		$EUMSHOP_APP_INFO['lang']			= $S_SITE_LNG;
		$EUMSHOP_APP_INFO['prodCntShow']	= true;
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
		?>		
		</h2>
	</div>
	<div class="locationNavWrap">
		<?php
		$EUMSHOP_APP_INFO				= "";
		$EUMSHOP_APP_INFO['name']		= "상품네비게이션";
		$EUMSHOP_APP_INFO['mode']		= "productLocation";
		$EUMSHOP_APP_INFO['cate1']		= $strCate1;
		$EUMSHOP_APP_INFO['cate2']		= $strCate2;
		$EUMSHOP_APP_INFO['cate3']		= $strCate3;
		$EUMSHOP_APP_INFO['cate4']		= $strCate4;
		$EUMSHOP_APP_INFO['location']	= "home;cate1;cate2;cate3;cate4";
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
		?>
	</div>
	<div class="subNaviWrap">
		<?php
		$EUMSHOP_APP_INFO				= "";
		$EUMSHOP_APP_INFO['name']		= "상품카테고리";
		$EUMSHOP_APP_INFO['mode']		= "productCateMenu";
		$EUMSHOP_APP_INFO['skin']		= "styleFixed2Skin";
		$EUMSHOP_APP_INFO['selectCate']	= $strCate;
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
		?>
	</div>

	<?php
	$EUMSHOP_APP_INFO				= "";
	$EUMSHOP_APP_INFO['name']		= "상품탑이미지";
	$EUMSHOP_APP_INFO['mode']		= "productTopImage";
	include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
	?>

	<div class="sortWrap">
		<div class="selectSort">
			<select onChange="goProductListSortChangeMoveEvent(this)">
				<option value="TD"><?php echo $LNG_TRANS_CHAR['PW00033']; // 신규등록순?></option>
				<option value="BD"><?php echo $LNG_TRANS_CHAR['PW00030']; // 판매인기도순?></option>
				<option value="SD"><?php echo $LNG_TRANS_CHAR['PW00031']; // 누적판매순?></option>
				<option value="RA"><?php echo $LNG_TRANS_CHAR['PW00034']; // 낮은가격순?></option>
				<option value="RD"><?php echo $LNG_TRANS_CHAR['PW00035']; // 높은가격순?></option>
			</select>
		</div>
		<div class="listType">
			<?php if($strProdListSkin == "prodThumbList"):?>
			<a href="javascript:goProductListClassChangeMoveEvent('prodThumbList')" data-mouseenter-show2="prod1" class="open"><img src="/upload/images/ico_m_thumbList.png" group="img1"></a>
			<a href="javascript:goProductListClassChangeMoveEvent('prodLineList')"  data-mouseenter-show2="prod2" class="close"><img src="/upload/images/ico_m_lineLine.png" group="img1"></a>
			<div id="prod1" group="prod"></div>
			<div id="prod2" group="prod" style="display:none"></div>
			<?php else:?>
			<a href="javascript:goProductListClassChangeMoveEvent('prodThumbList')" data-mouseenter-show2="prod1" class="close"><img src="/upload/images/ico_m_thumbList.png" group="img1"></a>
			<a href="javascript:goProductListClassChangeMoveEvent('prodLineList')"  data-mouseenter-show2="prod2" class="open"><img src="/upload/images/ico_m_lineLine.png" group="img1"></a>
			<div id="prod1" group="prod" style="display:none"></div>
			<div id="prod2" group="prod"></div>
			<?php endif;?>
		</div>
		<div class="clr"></div>
	</div>

	<div class="prodList prodThumbList">
	<?php
		## 상품 리스트
		include_once MALL_HOME . "/mobile/product/productList.inc.php";
	?>
	</div>
</div>