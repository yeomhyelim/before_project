<?
	/*-- *********** Header Area *********** --*/

	if($strMode == "act"):
		include WEB_FRWORK_ACT."minishop.php";
		exit;
	endif;
	
	include sprintf( "%s/www/include/header.inc.php", $S_DOCUMENT_ROOT); 
	
	include WEB_FRWORK_HELP."minishop.php";

	$includeFile = "{$strMode}.php";

	include "script.php";
	/*-- *********** Header Area *********** --*/	
?>
	<link rel="stylesheet" type="text/css" href="/layout/css/minishop.css"/>	
	<link rel="stylesheet" type="text/css" href="/common/css/product/product_0001.css"/>
	<link rel="stylesheet" type="text/css" href="/common/css/community/community.basicCss1.css"/>
	<body>
		<div id="">
			<div class="bodyWrap">
				<form name="form" method="post" id="form">
				<input type="hidden" name="menuType" value="<?=$strMenuType?>">
				<input type="hidden" name="mode" value="<?=$strMode?>">
				<input type="hidden" name="act" value="<?=$strMode?>">
				<input type="hidden" name="sh_no" value="<?=$_REQUEST['sh_no']?>">
				<!-- (1) 서브메인영역 -->
				<?include $includeFile; ?>
				<!-- (1) 서브메인영역 -->
				</form>
			</div>
			<div class="clr"></div>
		</div><!-- 본문영역 -->
		<!-- ********* Bottom Area ********* -->
		<? include sprintf ( "%s%s/layout/html/%s/main_bottom.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH  ); ?>
		<!-- ********* Bottom Area ********* -->
	</body>
</html>


