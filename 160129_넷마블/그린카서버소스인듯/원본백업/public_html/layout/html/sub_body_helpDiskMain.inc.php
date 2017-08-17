<div id="contentWrap">
	<div class="subNavWrap">
		<div class="navTit"><a href="#">전체카테고리</a></div>
		<?
  $EUMSHOP_APP_INFO = "";
  $EUMSHOP_APP_INFO['name'] = "상품카테고리메뉴";
  $EUMSHOP_APP_INFO['mode'] = "productCateMenu";
  $EUMSHOP_APP_INFO['display'] = "YYYY";
  $EUMSHOP_APP_INFO['event'] = "NNNN";
  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
?>
	</div>
	<div class="rightContentWrap">
		<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
		<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>
		<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
	</div>
	<div class="clr"></div>
</div>