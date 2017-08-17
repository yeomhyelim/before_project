<div id="contentWrap" class="prodSearchBodyWrap">
	<div class="subNavWrap">
		<div class="navTit">
			<strong>Product</strong>
			<p>상품카테고리</p>
		</div>
		<?
  $EUMSHOP_APP_INFO = "";
  $EUMSHOP_APP_INFO['name'] = "상품카테고리메뉴";
  $EUMSHOP_APP_INFO['mode'] = "productCateMenu";
  $EUMSHOP_APP_INFO['display'] = "YNNN";
  $EUMSHOP_APP_INFO['event'] = "OONN";
  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
?>
		<div class="commNavInfo">
			<a href="#" class="btn_cus_1"><span class="ico_cus_1"></span><?= $LNG_TRANS_CHAR["CW00134"]; //고객센터 ?></a>
			<a href="#" class="btn_cus_2"><span class="ico_cus_2"></span><?= $LNG_TRANS_CHAR["CW00135"]; //통역서비스 ?></a>
			<a href="#" class="btn_cus_3"><span class="ico_cus_3"></span><?= $LNG_TRANS_CHAR["CW00136"]; //번역서비스 ?></a>
			<a href="#" class="btn_cus_4"><span class="ico_cus_4"></span><?= $LNG_TRANS_CHAR["CW00137"]; //구매대행 ?></a>
			<a href="#" class="btn_cus_5"><span class="ico_cus_5"></span><?= $LNG_TRANS_CHAR["CW00138"]; //해외배송 ?></a>
			<a href="#" class="btn_cus_6"><span class="ico_cus_6"></span><?= $LNG_TRANS_CHAR["CW00139"]; //통관자문 ?></a>
			<div class="clr"></div>
		</div>
	</div>
	<div class="rightContentWrap">		
		<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
		<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>
		<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
	</div>
	<div class="clr"></div>
</div>