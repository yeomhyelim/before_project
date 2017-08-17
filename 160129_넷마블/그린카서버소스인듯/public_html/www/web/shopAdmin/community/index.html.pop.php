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
  <link rel="stylesheet" type="text/css" href="./common/css/layout.css"/>
  <link rel="stylesheet" type="text/css" href="./common/css/design.css"/>
  <!-- CSS Area -->
  <noscript>
  <!-- noscript Area -->
  <!-- noscript Area -->
  </noscript>
  <!-- javascript Area -->
<? include "index.js.php" ?>
  <!-- javascript Area -->
</head>
<body>

  <!-- body Area -->
<form name="form" id="form">
<input type="hidden" name="menuType" id="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
<input type="hidden" name="act" id="act" value="<?=$strAct?>">
<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
<input type="hidden" name="myTarget" id="myTarget" value="<?=$strTarget?>">

<div id="contentArea">
	<div id="contentWrap" style="width:100%;">
		<div class="contentWrap">
<? include $includeFile; ?>
		</div>
	</div>
</div>
</form>
  <!-- body Area -->

</body>
</html>