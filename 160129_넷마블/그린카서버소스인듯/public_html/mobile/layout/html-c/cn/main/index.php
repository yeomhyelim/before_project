<script>

	function goProdView(no)
	{		
		location.href = "./?menuType=product&mode=view&prodCode="+no;
	}

	function goProdComView(no)
	{		
		location.href = "./?menuType=product&mode=view&comView=Y&prodCode="+no;
	}

</script>

<div class="mainContents">

	<div id="topWrap">
			<a href="#menu-left" class="cateOpen"><img src="/upload/images/btn_m_menu.png" alt="Category"></a>
			<?if(!$g_member_no){?>
			<a href="./?menuType=member&mode=login" class="searchBtn"><img src="/upload/images/btn_m_login.png" alt="login"></a>			
			<?}?>
			<div class="clr"></div>
	</div>

	<div class="logo">
		<h1><? include sprintf ( "%s%s/layout/banner/%s/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "banner_9.html.php" ); ?></h1>
	</div>

	<div class="topSearchWrap">
		<input type="input" id="topSearchKeyword" name="topSearchKeyword" maxlength="50" tabindex="100" onkeydown="if(event.keyCode==13) C_topProdSearch();" onfocus="this.className='input_focus'" onblur="if ( this.value == '' ) { this.className='input_blur' }" class="input_blur">
		<a href="javascript:C_topProdSearch();" class="btnSearch"></a>
	</div>

	<div class="mainBannerWrap">
		<div class="mainEventBanner">
			<?php
			$EUMSHOP_APP_INFO					= "";
			$EUMSHOP_APP_INFO['name']			= "메인슬라이드배너";
			$EUMSHOP_APP_INFO['mode']			= "bannerSlider";
			$EUMSHOP_APP_INFO['skin']			= "default3Skin";
			$EUMSHOP_APP_INFO['code']			= "MOBILE_MAIN_BANNER";
			include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
			?>
		</div>
	</div>
	<div class="bannerBox"><? include sprintf ( "%s%s/layout/banner/%s/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "banner_3.html.php" ); ?></div>
	
	<style>
/*div.menuWrap .bx-wrapper .bx-viewport {
	-moz-box-shadow: 0 0 5px #ccc;
	-webkit-box-shadow: 0 0 5px #ccc;
	box-shadow: 0 0 5px #ccc;
	border:  5px solid #fff;
	left: -5px;
	height:60px;
	background: #ccc;*/
	/*fix other elements on the page moving (on Chrome)*/
	/*-webkit-transform: translatez(0);
	-moz-transform: translatez(0);
    	-ms-transform: translatez(0);
    	-o-transform: translatez(0);
    	transform: translatez(0);
}*/
/*div.menuWrap .bx-wrapper .bx-viewport li{width:30px;background-color:yellow;}
	div.menuWrap .ca-container{width:100%;height:50px;margin:0 auto;}
	div.menuWrap .ca-wrapper{position:relative;width:100%;height:100%;}*/
	</style>
	<!--link rel="stylesheet" type="text/css" href="/common/bxslider-4-master/jquery.bxslider.css" /-->

	<style>
	/* 모바일 카테고리 css*/
	#topMenu{position:relative;height:40px;overflow:hidden}
	#scroller{position:absolute;padding:0 20px;white-space:nowrap}
	#topMenu li{display:inline-block;text-align:center}
	#topMenu li a{
							display:inline-block;
							min-width:79px;
							height:40px;padding:0 5px;							
							font-weight:bold;color:#FFF;
							letter-spacing:-1px;line-height:38px;
							margin:0 -1px -1px -1px;
							
							}
	#topMenu li a.on{background:#0096e4;border:#000 solid 1px;color:#fff;border-radius:4px}
	.scroller-arr-left,
	.scroller-arr-right{
								position:absolute;display:none;								
								top:0;
								width:20px;
								height:40px;								
								text-indent:-999em;
								}
	.scroller-arr-left{left:0;background:#d53119 url(/upload/images/btn_m_prev.png) center center no-repeat;background-size:8px;}
	.scroller-arr-right{right:0;background:#d53119 url(/upload/images/btn_m_next.png) center center no-repeat;background-size:8px;}
	.scroller-arr-left.active,.scroller-arr-right.active{display:block}	
	/* 모바일 카테고리 css*/
	</style>

	<div class="menuWrap">
			<?php
			$EUMSHOP_APP_INFO					= "";
			$EUMSHOP_APP_INFO['name']			= "메인슬라이드배너";
			$EUMSHOP_APP_INFO['mode']			= "bannerSlider";
			$EUMSHOP_APP_INFO['skin']			= "categorySkin";
			$EUMSHOP_APP_INFO['code']			= "MOBILE_MAIN_BANNER";
			include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
			?>
		<?// include sprintf ( "%s%s/mobile/layout/html-c/kr/main/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME,  "category.inc.php" ); ?>
		<?// include sprintf ( "%s%s/mobile/layout/html-c/%s/main/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "category.inc.php" ); ?>
	</div>
	
	

	<div class="prodListArea">
		<div class="prodListBox">
			<h3>BEST PRODUCT</h3>
			<div class="prodListWrap">
				<div class="prodList prodListBodyWrap ">					
					<div class="prodThumbList">
						<div class="prodMobileList">
							<ul>
								<?php
								$EUMSHOP_APP_INFO					= "";
								$EUMSHOP_APP_INFO['name']			= "BEST ITEM";
								$EUMSHOP_APP_INFO['mode']			= "productList";
								$EUMSHOP_APP_INFO['skin']			= "mobileNewSkin";
								$EUMSHOP_APP_INFO['type']			= "main";
								$EUMSHOP_APP_INFO['no']				= "1";
								include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
								?>
							</ul>		
						</div><!--// prodMobileList -->
					</div><!--// prodThumbList -->
				</div><!--// prodList -->
			</div>
		</div>

		<div class="prodListBox">
			<h3>BEST COMPANY</h3>
			<div class="prodListWrap">
				<div class="prodList prodListBodyWrap ">					
					<div class="prodThumbList">
						<div class="prodMobileList">
							<ul>
								<?php
								$EUMSHOP_APP_INFO					= "";
								$EUMSHOP_APP_INFO['name']			= "BEST ITEM";
								$EUMSHOP_APP_INFO['mode']			= "shopMain";
								$EUMSHOP_APP_INFO['skin']			= "mobileBestSkin";
								$EUMSHOP_APP_INFO['type']			= "main";
								$EUMSHOP_APP_INFO['no']				= "2";
								include "{$S_DOCUMENT_ROOT}www/web/app/index.php";	
								?>
							</ul>		
						</div><!--// prodMobileList -->
					</div><!--// prodThumbList -->
				</div><!--// prodList -->
			</div>
		</div>
	</div>

	<div class="noticeListWrap">
		<?
		  $EUMSHOP_APP_INFO = "";
		  $EUMSHOP_APP_INFO['name'] = "공지사항";
		  $EUMSHOP_APP_INFO['mode'] = "communityWidget";
		  $EUMSHOP_APP_INFO['b_code'] = "NOTICE";
		  $EUMSHOP_APP_INFO['limitStart'] = "0";
		  $EUMSHOP_APP_INFO['limitEnd'] = "1";
		  $EUMSHOP_APP_INFO['column'] = "제목";
		  $EUMSHOP_APP_INFO['titleMaxLeng'] = "50";
		  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
	</div>

	<div id="bottomWraper" style="display:none;">
		<div class="copyright">
			<?php
			$EUMSHOP_APP_INFO					= "";
			$EUMSHOP_APP_INFO['name']			= "언어별 카피라이트 페이지 include";
			$EUMSHOP_APP_INFO['mode']			= "include";
			$EUMSHOP_APP_INFO['home']			= "mobile";
			$EUMSHOP_APP_INFO['siteLang']		= $S_SITE_LNG;
			$EUMSHOP_APP_INFO['homeLang']		= "KR";
			$EUMSHOP_APP_INFO['path']			= "/inc/copyright.{@siteLang@}.php";
			include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
			?>
		</div>
	</div>
</div>
<script language="javascript" type="text/javascript" src="/common/js/app/communityWidget/communityWidget.js"></script>