<?
	$D_LAYOUT_HIMG			= $D_LAYOUT.$D_SKIN;
	$strSubSkinName			= STRTOUPPER($strMenuType)."_".STRTOUPPER($strMode);
?>
	<div class="cartWrap mt20">
		<div class="titleWrap">
			<h3><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/tit_cart_baguni.gif"/></h3>
			<div class="locationWrap mt10">
				<?=$LNG_TRANS_CHAR["CW0002"] //HOME?> / <strong><?=$LNG_TRANS_CHAR["CW0002"] //장바구니?></strong>
			</div>
			<div class="clear"></div>
		</div>
		<!-- 장바구니 시작 -->
		<?include sprintf("%s%s/%s_%s_list.inc.php", MALL_WEB_PATH, $strMenuType, $strMenuType, $S_SKIN[$strSubSkinName] ); ?>
		<div class="btnCenter">
			<a href="javascript:goOrderJumun();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_buy.gif"/></a>
			<a href="javascript:goCartAllDel();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_del.gif"/></a>
			<a href="javascript:goWishAll();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_wish.gif"/></a>
			<a href="javascript:goProdList();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_cart_list.gif"/></a>
		</div>
		<!-- 장바구니 끝 -->


		<!-- 나중에 주문할 상품(Wish list) -->
		<div class="mt100">
			<?include sprintf("%s%s/%s_%s_wishlist.inc.php", MALL_WEB_PATH, $strMenuType, $strMenuType, $S_SKIN[$strSubSkinName] );?>
		</div>
		<!-- 나중에 주문할 상품(Wish list) -->
	</div>
	