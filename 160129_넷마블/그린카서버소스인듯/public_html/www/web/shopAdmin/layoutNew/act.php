<?

	/* 페이지 분류 */
	$aryIncludeFolder = array(  "popHtmlMakeFile"				=> "html",

							 );
	
	/* 페이지 분류 */
	include "{$aryIncludeFolder[$strAct]}/act.inc.php";

	goUrl($strMsg,$strUrl);
?>