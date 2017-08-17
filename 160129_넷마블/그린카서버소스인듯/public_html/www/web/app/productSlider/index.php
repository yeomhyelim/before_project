<?php
	## 테스트 URL			= http://demo2.eumshop.co.kr/kr/?menuType=app&mode=productSlider&iconNo=1&itemCnt=4

	## 기본설정
	$intAppItemCnt			= $_GET['itemCnt'];
	$intAppIconNo			= $_GET['iconNo'];
	$strAppPlay				= $_GET['play'];

	## 스타일시트 설정
	$aryCss					= "";
	$aryCss[]				= "/common/css/slider/jcarousel.responsive.css";

	## 스크립트 리스트 설정
	$aryScript				= "";
	$aryScript[]			= "/common/js/app/productSlider/jquery.jcarousel-core.js";
	$aryScript[]			= "/common/js/app/productSlider/jquery.jcarousel-eum.js";

	## 해더 include
	include MALL_HOME . "/include/header.inc.php";
?>

<body>

<?	include MALL_HOME . "/web/app/{$strAppMode}/productSlider.php";	?>



</body>

</html>




