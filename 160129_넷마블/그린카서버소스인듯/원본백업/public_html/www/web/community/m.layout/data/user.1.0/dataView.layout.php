<?
	$skinFile = "{$_REQUEST['S_DOCUMENT_ROOT']}{$_REQUEST['S_SHOP_HOME']}/html/community/{$_REQUEST['BOARD_INFO']['b_code']}/{$_REQUEST['mode']}.layout.php";
	if(is_file($skinFile)):
		include $skinFile;
	endif;
?>
