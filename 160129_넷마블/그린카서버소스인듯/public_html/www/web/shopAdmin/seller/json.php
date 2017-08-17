<?
	$result_array		= array();
	
	$strJsonMode		= $_POST["jsonMode"]		? $_POST["jsonMode"]		: $_REQUEST["jsonMode"];
	
	/* 페이지 분류 */
	$aryIncludeFolder = array(  
									"shopPolicyModify"	=> "shop",
									"orderSave"			=> "order",
									"deliverySave"		=> "order",
									"orderStatusSave"	=> "order",
							 );
	/* 페이지 분류 */
	include $strIncludePath.$aryIncludeFolder[$strJsonMode]."/json.inc.php";

	$db->disConnect();

?>