<?



	## STEP 8.
	## HTML 파일 호출
	include ($_REQUEST['target']) ? "index.html.{$_REQUEST['target']}.php" : "index.html.php";	


?>