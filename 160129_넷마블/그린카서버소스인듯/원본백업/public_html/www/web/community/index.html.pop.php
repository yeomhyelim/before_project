<?
	## body class 정의
	if($_REQUEST['bodyClass']) { $bodyClass = " class='{$_REQUEST['bodyClass']}'"; }

?>
<!DOCTYPE HTML>
<!--
/*
 *
 * Copyright 2013, eumshop
 * https://www.eumshop.co.kr
 *
 */
-->
<html lang="en">
<head>
  <meta charset="utf-8">
   <title><?=$S_SITE_TITLE?></title>
  <meta name="description" content="communuty">
  <meta name="viewport" content="width=device-width">
	<!-- CSS Area -->
<? include "index.css.php" ?>
	<!-- CSS Area -->
  <noscript>
    <!-- noscript Area -->

    <!-- noscript Area -->
  </noscript>
<!-- javascript Area -->
<? include "index.js.php" ?>
<!-- javascript Area -->
</head>
<body<?=$bodyClass?>>
	<div class="attachedFileWrap">
		<form name="form" id="form">
		<input type="hidden" name="menuType" id="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" id="act" value="<?=$strAct?>">
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<input type="hidden" name="myTarget" id="myTarget" value="<?=$_REQUEST['myTarget']?>">
		<input type="hidden" name="searchField" value="" alt="상품 검색">
		<input type="hidden" name="searchKey" value="" alt="상품 검색">
		<input type="hidden" name="bodyClass" id="bodyClass" value="<?=$_REQUEST['bodyClass']?>" alt="bodt 클래스">

			<? include $includeFile; ?>
		
		</form>
	</div>
</body>
</html>