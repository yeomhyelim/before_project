<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $S_SITE_TITLE;?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="viewport" id="viewport" content="user-scalable=yes, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, width=device-width"/>
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="format-detection" content="telephone=no" />

		<!-- 메뉴별 메타 키워드 설정 -->
		<meta name="ROBOTS" content="ALL" />
		<META NAME="ROBOTS" CONTENT="INDEX,FOLLOW">
		<meta name="description" content="">
		<meta name="keywords" content="">

		<link rel="stylesheet" type="text/css" href="/common/css/mobile/mobile_master.css" />
		<link rel="stylesheet" type="text/css" href="/common/css/mobile/mobile_layout_style.css"/>
		<link rel="stylesheet" type="text/css" href="/common/css/mobile/mobile_media_style.css"/>
		<link rel="stylesheet" type="text/css" href="/common/css/mobile/jquery.mmenu.css" />
		<link rel="stylesheet" type="text/css" href="/mobile/layout/common/css/style-default.css" />
		<link rel="stylesheet" type="text/css" href="/common/css/jquery.smartPop.css" />

		<!-- jquery -->
		<script language="javascript" type="text/javascript" src="/common/js/jquery-1.7.2.min.js"></script>
		<script language="javascript" type="text/javascript" src="/common/jQuery.mmenu-master/src/js/jquery.mmenu.js"></script>
		<script language="javascript" type="text/javascript" src="../common/js/jquery.smartPop.js"></script>
		<!--유효성 체크-->
		<script language="javascript" type="text/javascript" src="/common/js/jquery.alphanumeric.pack.js"></script>
		<script language="javascript" type="text/javascript" src="/common/js/jquery.validate.js"></script>
		<!-- 국가별 통화 단위 표시 -->
		<script language="javascript" type="text/javascript" src="/common/js/jquery.formatCurrency-1.4.0.min.js"></script>
		<!-- eumshop 공통 코드 -->
		<script language="javascript" type="text/javascript" src="/common/js/common.js"></script>
		<script language="javascript" type="text/javascript" src="/common/js/commonReady.js"></script>
		<script language="javascript" type="text/javascript" src="/mobile/layout/common/js/layout.default.js"></script>

		<script type="text/javascript">
		<!--
		var strSiteJsLng		= "<?=($S_JS_LNG)?$S_JS_LNG:$S_SITE_LNG;?>";
		var G_PHP_PARAM			= "<?=$_SERVER['QUERY_STRING']?>";
		var G_APP_PARAM			= new Object();
		var strMemberLogin		= "<?=$g_member_login?>";
		//-->
		</script>
	</head>
	<body>
		<div class="contents" id="page">
			<div role="main" class="ui-content">
				<?
				if($strMenuType == 'main')
				{
				}
				else
				{
				?>
				<div id="topWrap">
					<div class="titleWrap">
						<a href="#menu-left" class="cateOpen"><img src="/upload/images/btn_m_menu.png" alt="Category"></a>
						<h1><a href="/"><img src="<?php echo $S_MOB_LOGO_IMG;?>" alt="136601"></a></h1>
						<a href="javascript:goLayoutDefaultSearchFormShowEvent()" class="searchBtn"><img src="/upload/images/btn_m_search.png" alt="Search"></a>
						
						<div class="clr"></div>
					</div>
					<div class="searchWrap hide">
						<div class="searchTop">
							<div class="searchBox">
								<input type="text" name="searchText" value="<?php echo $_GET['searchKey'];?>" data-enter-event="goLayoutDefaultSearchMoveEvent" /><a href="javascript:goLayoutDefaultSearchMoveEvent()" class="btnSearch"><img src="/himg/mobile/ico_search.png" alt="Search" class="icoSearch"></a>
							</div>
							<a href="javascript:goLayoutDefaultSearchFormShowEvent()" class="btnCancle"><?=$LNG_TRANS_CHAR["MW00044"]//취소?></a>
							<div class="clr"></div>
						</div><!--// searchTop -->
					</div><!--// searchWrap -->
				</div>
				<?}?>

				<?php $e='';$e['mode']='include';$e['include']='contents';include MALL_HOME . '/web/app/engin.php'; ?>

				<div id="bottomWraper">
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
			</div><!-- ui-content -->

			<!-- ** 카테고리메뉴 **//-->
			<div data-role="panel" id="menu-left">
				<div class="mnListWrap ">
				<?php include_once MALL_SHOP . "/mobile/layout/html-c/kr/inc/menu.php";?>
				<?php// include_once MALL_SHOP . "/mobile/layout/html-c/{$S_SITE_LNG_PATH}/inc/menu.php";?>
				</div>
			</div>
		</div>
		<?php include_once MALL_HOME . "/include/footer.inc.php";?>
		<?php include_once MALL_HOME . "/include/ace_counter_js.php";?>
		<?php include_once MALL_HOME . "/include/naver_counter_js.php";?>
	</body>
</html>