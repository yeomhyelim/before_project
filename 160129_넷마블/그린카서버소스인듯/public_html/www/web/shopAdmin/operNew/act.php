<?

	/* 페이지 분류 */
	$aryIncludeFolder = array(  "popupWrite"				=> "popup",
								"popupModify"				=> "popup",
								"popupDelete"				=> "popup",

							 );
	
	/* 페이지 분류 */
	include "{$aryIncludeFolder[$strAct]}/act.inc.php";

	goUrl($strMsg,$strUrl);
?>