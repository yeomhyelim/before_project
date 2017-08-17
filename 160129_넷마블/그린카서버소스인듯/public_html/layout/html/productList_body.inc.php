<div id="contentWrap" class="prodListBodyWrap">
	<div class="subNavWrap">
		<div class="navTit">
			<strong>Product</strong>
			<p><?= $LNG_TRANS_CHAR["CW00111"]; //상품카테고리 ?></p>
		</div>
		<?
		  $EUMSHOP_APP_INFO = "";
		  $EUMSHOP_APP_INFO['name'] = "상품카테고리메뉴";
		  $EUMSHOP_APP_INFO['mode'] = "productCateMenu";
		  $EUMSHOP_APP_INFO['display'] = "YNYN";
		  $EUMSHOP_APP_INFO['event'] = "OONN";
		  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
	<? include sprintf ( "%s%s/layout/html/customer_ico.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
	</div>
	<div class="rightContentWrap">
		<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
		<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>
		<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
	</div>
	<div class="clr"></div>
</div>