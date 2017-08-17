<!DOCTYPE HTML>
<head>
<title><?=$S_SITE_TITLE?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="ROBOTS" content="no" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<META NAME="GOOGLEBOT" CONTENT= "NOINDEX, NOFOLLOW">
  <!-- CSS Area -->
  <!-- Common CSS -->
  <link rel="stylesheet" type="text/css" href="./common/css/layout.css"/>
  <link rel="stylesheet" type="text/css" href="./common/css/design.css"/>
  <link rel="stylesheet" type="text/css" href="./common/css/jquery.smartPop.css"/>
  <link rel="stylesheet" type="text/css" href="./common/css/calendar.css"/>
<?if($strAdmSiteLng!="KR"){?>
  <link rel="stylesheet" type="text/css" href="./common/css/style_<?=strtolower($strAdmSiteLng)?>.css" />
<?}?>
  <!-- CSS Area -->
  <noscript>
    <!-- noscript Area -->

    <!-- noscript Area -->
  </noscript>
</head>
<body>

  <!-- javascript Area -->
  <? include "index.js.php" ?>
  <!-- javascript Area -->

  <!-- ******************** topArea ********************** -->
  <? include "./include/top.inc.php"?>
  <!-- ******************** topArea ********************** -->

  <!-- body Area -->
  <div id="contentArea">
	<table style="width:100%;">
	<tr>
		<td class="leftWrap">
		<!-- ******************** leftArea ********************** -->
		<? include "./include/left.inc.php" ?>
		<!-- ******************** leftArea ********************** -->
		</td>
		<td class="contentWrap">
		<!-- ******************** skinArea ********************** -->
		<div class="layoutWrap">
		<form name="form" id="form">
		<input type="hidden" name="menuType" id="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" id="act" value="<?=$strAct?>">
		<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
		<input type="hidden" name="myTarget" id="myTarget" value="">
		<input type="hidden" name="excelType" id="excelType" value="">
		<? include $includeFile; ?>
		</form>
		</div>
		<!-- ******************** skinArea ********************** -->
		</td>
	</tr>
	</table>
  </div>
  <!-- body Area -->

  <!-- ******************** footerArea ******************* -->
  <? include "./include/bottom.inc.php" ?>
  <!-- ******************** footerArea ******************* -->

</body>
</html>