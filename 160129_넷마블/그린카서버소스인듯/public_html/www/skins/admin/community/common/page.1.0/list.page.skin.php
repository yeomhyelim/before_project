<?php

	## 기본설정
	$intPage		= $_REQUEST['result'][$tableName]['pageResult']['page'];
	$intPageLine	= $_REQUEST['result'][$tableName]['pageResult']['page_line'];
	$intPageBlock	= 10;
	$intTotal		= $_REQUEST['result'][$tableName]['pageResult']['page_total'];	
	$intTotPage		= $_REQUEST['result'][$tableName]['pageResult']['last_page'];	
	$linkPage		= $_REQUEST['result'][$tableName]['pageResult']['link'];	

?>

<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
