<? if($S_QUICK_MENU_USE_1=="Y") : 

	$S_QUICK_MENU_WIDTH_MAX		= ($S_QUICK_MENU_WIDTH_MAX) ? $S_QUICK_MENU_WIDTH_MAX : 980;
	$S_QUICK_MENU_TOP_1			= ($S_QUICK_MENU_TOP_1) ? $S_QUICK_MENU_TOP_1 : 10; 
	$S_QUICK_MENU_LEF_1			= ($S_QUICK_MENU_LEF_1) ? $S_QUICK_MENU_LEF_1 : 0;
	$S_QUICK_MENU_SPE_1			= ($S_QUICK_MENU_SPE_1) ? $S_QUICK_MENU_SPE_1 : 500;
	$S_QUICK_MENU_PIMG_SIZ_1	= ($S_QUICK_MENU_PIMG_SIZ_1) ? $S_QUICK_MENU_PIMG_SIZ_1 : "60*90";
	$aryQuickMenuProdImg		= explode("*", $S_QUICK_MENU_PIMG_SIZ_1);	
	$intQuickMenuRightPos		= ($S_QUICK_MENU_WIDTH_MAX/2) + $aryQuickMenuProdImg[0] + $S_QUICK_MENU_LEF_1;
	$intQuickMenuLeftPos		= ($S_QUICK_MENU_WIDTH_MAX) + (($aryQuickMenuProdImg[0] + $S_QUICK_MENU_LEF_1)*2);	?>
	

	<style type="text/css">
		/*** 퀵 메뉴 ***/  
		div.quickMenuArea {position:absolute;float:center;margin:0 auto;text-align:right;z-index:1000}
		div.quickMenuArea {width:100%;top:<?=$S_QUICK_MENU_TOP_1?>px;border:0px solid #000;}
		div.quickMenuWrap {position:relative;}
		<? if($S_QUICK_MENU_ALIGN_1 == "left") : ?>
		div.quickMenuWrap {width:<?=$intQuickMenuLeftPos?>px;margin:0 auto;border:0px solid #000;}
		div.quickMenu {float:left;margin:0 auto;background: #79a75b;}
		<? else : ?>
		div.quickMenuWrap {width:<?=$intQuickMenuRightPos?>px;margin:0 50% auto;border:0px solid #000;}
		div.quickMenu {float:right;margin:0 auto;background: #79a75b;}
		<? endif; ?>
		
		div.quickMenu {padding: 5px 0;width:<?=$aryQuickMenuProdImg[0]?>px;}
		div.quickMenu div.quickTitle {display:block;text-align:center;}
		div.quickMenu div.quickTitle span {display:block;text-align:center;color:#fff;}
		div.quickMenu div.goTop {position:absolute;vertical-align:bottom;border:0px solid #000;}
		div.quickMenu img.quickProdImg {width:<?=$aryQuickMenuProdImg[0]?>px;height:<?=$aryQuickMenuProdImg[1]?>px;}
		div.quickMenu li.quickProdLi {border:0px solid #000;}
	</style>

	<script type="text/javascript">
		<!--
			var intWidMax			= <?=$S_QUICK_MENU_WIDTH_MAX?>;
			var intTopPos			= <?=$S_QUICK_MENU_TOP_1?>;
			var intLefPos			= <?=$S_QUICK_MENU_LEF_1?>;
			var intSpeed			= <?=$S_QUICK_MENU_SPE_1?>;
			var intProdImgW			= <?=$aryQuickMenuProdImg[0]?>;
			var strEffect			= "<?=$S_QUICK_MENU_EFFECT_1?>";

			$(document).ready(function() {

				$.getJSON("./?menuType=main&mode=json&act=quickProdList&callback=?", function(data) {
					$(".quickProduct").html(data[0].QUICK_PROD_LIST);
				});

				var quickMenu			= $(".quickMenuArea"); 

				if(strEffect == "F") {
					// 상단 메뉴 고정
				}else if(strEffect == "S") {
					// 퀵메뉴 항상 보임
					$(window).scroll(function() {
						var intQuickTopPos	= ($(document).scrollTop() < intTopPos - 10) ? intTopPos - $(document).scrollTop() : 10;
						$("div.quickMenuArea").css({'position':'fixed', 'top':intQuickTopPos + 'px'});
					});
				}else if(strEffect == "A") {
					// 퀵메뉴 효과 A
					$(window).scroll(function() {
						quickMenu.stop();
						var intQuickTopPos	= ($(document).scrollTop() < intTopPos) ? intTopPos : $(document).scrollTop() + 10;
						quickMenu.animate({ "top": intQuickTopPos + "px" }, intSpeed ); 
					});
				}

				$(window).resize(function() {
					if((intWidMax + (intProdImgW*2)) > $(window).width()) {
						quickMenu.css({'display':'none'});
					} else {
						quickMenu.css({'display':''});
					}
										
				});

			});

		//-->
	</script>

	<!-- *********** Quick Menu *********** -->
	<!--div class="quickMenuArea">
		<div class="quickMenuWrap">
			<div class="quickMenu">
				<div class="quickTitle">Recent<span>▼</span></div>
				<div class="quickProduct"></div>
				<div class="goTop"><a href="#top"><img src="/himg/quickMenu/EQ0001/btn_quick_top.png"/></a></div>
			</div>
		</div>
	</div-->
	<!-- *********** Quick Menu *********** -->

<? else : ?>

	<script type="text/javascript">
		<!--

			$(document).ready(function() {
				$(".quickMenu").remove();
			});

		//-->
	</script>

<? endif; ?>