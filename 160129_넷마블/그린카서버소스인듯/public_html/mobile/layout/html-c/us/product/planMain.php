<?php
	## helper 설정
	include_once WEB_FRWORK_HELP."product.php";

	## 카테고리 설정
	$strCate1 = $_GET['lcate'];
	$strCate2 = $_GET['mcate'];
	$strCate3 = $_GET['scate'];
	$strCate4 = $_GET['fcate'];
	$strCate = $strCate1 . $strCate2 . $strCate3 . $strCate4;
	$strCate = str_pad($strCate, 12, '0');

	## 스크립트 설정
	$aryScriptEx[]				= "/mobile/layout/common/js/product.planMain.js";
?>
<div class="prodList prodThumbList">
<?php
	## 기획전 리스트
	include_once MALL_HOME . "/mobile/product/planMain.inc.php";
?>
</div>