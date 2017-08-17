<?
	$result_array = array();
	
	
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "prodBrandImgDelete"	=> "brand"
							 );


	/* 페이지 분류 */
	if($strAct)		{ include "{$strIncludePath}{$aryIncludeFolder[$strAct]}/".$strAct.".json.inc.php"; }

	$db->disConnect();
?>