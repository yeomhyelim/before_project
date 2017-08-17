<?php
	## 테스트 URL			= 

	## 기본설정
//	$strAppDisplay			= $_GET['display'];
//	$strAppEvent			= $_GET['event'];

	## 스타일시트 설정
	$aryCss					= "";

	## 스크립트 리스트 설정
//	$aryScript[]			= "/common/js/app/productCateMenu/productCateMenu.js";

	## 해더 include
	include MALL_HOME . "/include/header.inc.php";

?>

<body>

<?	include MALL_HOME . "/web/app/{$strAppMode}/productAuto.php";	?>

</body>

</html>




