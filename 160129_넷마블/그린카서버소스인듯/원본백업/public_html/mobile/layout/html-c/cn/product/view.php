<?php

	//$mobie_view = 'Y';
	## helper 설정
	include_once WEB_FRWORK_HELP."product.php";

	## 기본설정	
	$strCate1 = substr($prodRow['P_CATE'], 0, 3);
	$strCate2 = substr($prodRow['P_CATE'], 3, 3);
	$strCate3 = substr($prodRow['P_CATE'], 6, 3);
	$strCate4 = substr($prodRow['P_CATE'], 9, 3);
?>

<div class="prodViewBodyWrap">
	<div class="prodTitWrap">
		<div><?php echo $strP_NAME;?></div>
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

	<form name="form" method="post" id="form">
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="page" value="<?=$intPage?>">
	<input type="hidden" name="searchField" value="<?=$strSearchField?>">
	<input type="hidden" name="searchKey" value="<?=$strSearchKey?>">
	<input type="hidden" name="lcate" value="<?=$strSearchHCode1?>">
	<input type="hidden" name="mcate" value="<?=$strSearchHCode2?>">
	<input type="hidden" name="scate" value="<?=$strSearchHCode3?>">
	<input type="hidden" name="fcate" value="<?=$strSearchHCode4?>">
	<input type="hidden" name="sort" value="<?=$strSearchSort?>">
	<input type="hidden" name="prodCode" value="<?=$strP_CODE?>">
		<?php
		## 상품 뷰페이지
		$S_PRODUCT_VIEW_IMAGE_SHOW_TYPE = "B";
		include_once MALL_HOME . "/mobile/product/productView.inc.php";
		?>
	</form>
</div>