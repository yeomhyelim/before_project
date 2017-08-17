<?php

	## helper 설정
	include_once WEB_FRWORK_HELP."product.php";

	## 기본설정	
	$strCate1 = substr($prodRow['P_CATE'], 0, 3);
	$strCate2 = substr($prodRow['P_CATE'], 3, 3);
	$strCate3 = substr($prodRow['P_CATE'], 6, 3);
	$strCate4 = substr($prodRow['P_CATE'], 9, 3);
	
?>

	<div class="prodInquiryMBox">
		<?php
		/*$EUMSHOP_APP_INFO				= "";
		$EUMSHOP_APP_INFO['name']		= "상품네비게이션";
		$EUMSHOP_APP_INFO['mode']		= "communityWrite";
		$EUMSHOP_APP_INFO['skin']		= "productInquiry";//productInquiry
		$EUMSHOP_APP_INFO['view']		="";
		$strMenuType= 'communityWrite';
		$strMode = .$strMenuType'productInquiry';

		//$strMenuType = "app";
		//exit;
		//echo "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	*/
		?>

		<?php
		## 상품문의
		//$S_PRODUCT_VIEW_IMAGE_SHOW_TYPE = "B";
		//include_once MALL_HOME . "/mobile/product/productView.inc.php";
		//include_once MALL_HOME . "/mobile/product/productInquiry.php";
		include_once MALL_HOME . "/web/product/productInquiry.popup.inc.php";
		?>
	</div>