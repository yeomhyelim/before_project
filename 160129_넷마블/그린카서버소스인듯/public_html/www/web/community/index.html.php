<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

  <title><?=$S_SITE_TITLE?></title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="imagetoolbar" content="no" />
	<meta name="ROBOTS" content="ALL" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<!-- CSS Area -->
<? include "index.css.php" ?>
<? include sprintf ( "%s%s/layout/web/community/index.css.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
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

<form name="form" id="form">
<input type="hidden" name="menuType" id="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
<input type="hidden" name="act" id="act" value="<?=$strAct?>">
<input type="hidden" name="page" id="page" value="<?=$_REQUEST['page']?>">
<input type="hidden" name="myTarget" id="myTarget" value="<?=$strTarget?>">
<input type="hidden" name="searchField" value="" alt="상품 검색">
<input type="hidden" name="searchKey" value="" alt="상품 검색">

<!-- body html Area -->
<? include sprintf ( "%s%s/layout/html/community_html.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
<!-- body html Area -->

</form>


</body>
</html>

