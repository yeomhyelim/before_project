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
		<meta name="description" content="임대형, 독립형, 몰인몰, 입점형 쇼핑몰 솔루션, 영어,일어,중국어 및 다국어 지원, 환율 자동설정 쇼핑몰 구축 전문 회사 이음샵">
		<meta name="keywords" content="쇼핑몰, 쇼핑몰 제작, 독립형 쇼핑몰, 입점형 쇼핑몰, 몰인몰 쇼핑몰, 영어, 일어, 중국어외 기타 다국어 쇼핑몰">

		<link rel="stylesheet" type="text/css" href="/common/css/mobile/mobile_master.css" />
		<link rel="stylesheet" type="text/css" href="/common/css/mobile/mobile_layout_style.css"/>
		<link rel="stylesheet" type="text/css" href="/common/css/mobile/mobile_media_style.css"/>
		<link rel="stylesheet" type="text/css" href="/common/css/mobile/jquery.mmenu.css" />
		<link rel="stylesheet" type="text/css" href="/mobile/layout/common/css/style-default.css" />
		<!-- jquery -->
		<script language="javascript" type="text/javascript" src="/common/js/jquery-1.7.2.min.js"></script>
		<script language="javascript" type="text/javascript" src="/common/jQuery.mmenu-master/src/js/jquery.mmenu.js"></script>
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
		<?php $e='';$e['mode']='include';$e['include']='contents';include MALL_HOME . '/web/app/engin.php'; ?>
	</body>
</html>