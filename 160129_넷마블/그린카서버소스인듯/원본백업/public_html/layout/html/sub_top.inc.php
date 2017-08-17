<div id="topArea" class="topArea">
	<div class="glbArea">
		<div class="glbWrap"><? include sprintf ( "%s%s/layout/menu/globalMenu2.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  ); ?></div>
	</div>
	<div class="topContainer">
		<div id="topWrap">
			<h1><? include sprintf ( "%s%s/layout/banner/%s/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "banner_8.html.php" ); ?></h1>
			<div class="topSearchBox">
				<? include sprintf ( "%s%s/layout/menu/productSearch.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  ); ?>
				<a href="javascript:void(0);" eum-toggle="cateAllView" class="btnAllCate">카테고리</a>
				<div id="cateAllView" class="cateAllViewBox" style="display:none;">
					<div class="topTop"></div>
					<div class="btnClose"><a href="javascript:void(0);" eum-toggle="cateAllView"><img src="/upload/images/btn_close_g.png" alt="close"/></a></div>
					<?
  $EUMSHOP_APP_INFO = "";
  $EUMSHOP_APP_INFO['name'] = "상품카테고리메뉴1";
  $EUMSHOP_APP_INFO['mode'] = "productCateMenu";
  $EUMSHOP_APP_INFO['display'] = "YYNN";
  $EUMSHOP_APP_INFO['event'] = "NNNN";
  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
?>
				</div>
			</div>
			<div class="icoNavLeft">
				<a href="./?menuType=mypage&mode=wishMyList" class="btnWish"><img src="/upload/images/ico_glb_1.png"> <span>Wish</span></a>
				<a href="./?menuType=mypage&mode=cartMyList"><img src="/upload/images/ico_glb_2.png"> <span>Cart</span></a>
				<a href="./?menuType=mypage&mode=buyList"><img src="/upload/images/ico_glb_3.png"> <span>MyPage</span></a>
			</div>
			<div class="clr"></div>
		</div>
	</div>
</div>


<script>
$(document).ready(function () { 
	var top = $('#topArea').offset().top - parseFloat($('#topArea').css('marginTop').replace(/auto/, 0));
	$(window).scroll(function (event) {
		var y = $(this).scrollTop();
		if (y >= top) {
			$('#topArea').addClass('fixed');
		} else {
			$('#topArea').removeClass('fixed');
		}
	});
});
</script>