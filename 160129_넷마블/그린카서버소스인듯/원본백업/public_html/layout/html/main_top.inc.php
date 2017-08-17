<div id="topArea" class="topArea">
	<div id="topWrap">
		<div class="glbArea">
			<div class="btnBox">
				<a href="JavaScript:bookmarksite('Fingbook','www.fingbook.com');" class="btnBookmark"><?= $LNG_TRANS_CHAR["CW00084"]; //즐겨찾기 ?></a>
				<? if($g_member_no): // 회원 모드?>
					<a href="./?menuType=mypage&mode=cartMyList" class="btnCart"><?= $LNG_TRANS_CHAR["PW00022"]; //장바구니 ?></a>
					<a href="./?menuType=mypage&mode=buyList" class="btnMy"><?= $LNG_TRANS_CHAR["MW00048"]; //장바구니 ?></a>
				<?else:?>
					<a href="javascript:void(0);" onclick="javascript:needLogin('<?=$LNG_TRANS_CHAR["OS00014"]?>' , '' );" class="btnCart"><?= $LNG_TRANS_CHAR["PW00022"]; //장바구니 ?></a>
					<a href="javascript:void(0);" onclick="javascript:needLogin('<?=$LNG_TRANS_CHAR["OS00014"]?>' , '' );" class="btnMy"><?= $LNG_TRANS_CHAR["MW00048"]; //장바구니 ?></a>
				<? endif; ?>				
			</div>

			<div class="glbWrap"><? include sprintf ( "%s%s/layout/menu/globalMenu2.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME  ); ?></div>
			<div class="clr"></div>
		</div>

		<div class="logoWrap">
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
			<div class="clr"></div>
		</div>

		<div class="topNaviWrap">
			<?
  $EUMSHOP_APP_INFO = "";
  $EUMSHOP_APP_INFO['name'] = "상품카테고리메뉴";
  $EUMSHOP_APP_INFO['mode'] = "productCateMenu";
  $EUMSHOP_APP_INFO['display'] = "YNNN";
  $EUMSHOP_APP_INFO['event'] = "NNNN";
  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
?>
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

function needLogin ( msg , nextUrl )
	{
		alert ( msg ) ;
		location.href= "./?menuType=member&mode=login" ;
	}
/*
function bookmarksite(title,url) {
   // Internet Explorer
   if(document.external)
   {
       window.external.AddFavorite(url, title); 
   }
   // Google Chrome
   else if(window.chrome){
      alert("Ctrl+D키를 누르시면 즐겨찾기에 추가하실 수 있습니다.");
   }
   // Firefox
   else if (window.sidebar) // firefox 
   {
       window.sidebar.addPanel(title, url, ""); 
   }
   // Opera
   else if(window.opera && window.print)
   { // opera 
      var elem = document.createElement('a'); 
      elem.setAttribute('href',url); 
      elem.setAttribute('title',title); 
      elem.setAttribute('rel','sidebar'); 
      elem.click(); 
   }
} 
*/
function bookmarksite(title,url) {
    var bookmarkURL = window.location.href;
    var bookmarkTitle = document.title;
    var triggerDefault = false;

    if (window.sidebar && window.sidebar.addPanel) {
        // Firefox version < 23
        window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
    } else if ((window.sidebar && (navigator.userAgent.toLowerCase().indexOf('firefox') > -1)) || (window.opera && window.print)) {
        // Firefox version >= 23 and Opera Hotlist
        var $this = $(this);
        $this.attr('href', bookmarkURL);
        $this.attr('title', bookmarkTitle);
        $this.attr('rel', 'sidebar');
        $this.off(e);
        triggerDefault = true;
    } else if (window.external && ('AddFavorite' in window.external)) {
        // IE Favorite
        window.external.AddFavorite(bookmarkURL, bookmarkTitle);
    } else {
        // WebKit - Safari/Chrome
        //alert('Press ' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D to bookmark this page.');
        alert('' + (navigator.userAgent.toLowerCase().indexOf('mac') != -1 ? 'Cmd' : 'Ctrl') + '+D 를 누르시면 즐겨찾기에 추가하실 수 있습니다.');
    }

   // return triggerDefault;
}
</script>
