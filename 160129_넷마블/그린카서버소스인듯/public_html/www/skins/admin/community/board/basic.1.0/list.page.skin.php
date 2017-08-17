<?php

	## 기본설정
	$intPage		= $_REQUEST['page'];
	$intPageLine	= $_REQUEST['page_line'];
	$intPageBlock	= 10;
	$intTotal		= $_REQUEST['page_total'][$tableName];	
	$intTotPage		= $_REQUEST['last_page'][$tableName];	
	$linkPage		= $_REQUEST['link'][$tableName];	

?>

<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
