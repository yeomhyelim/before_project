<?php
	## 페이지 분류
	$aryIncludeFolder = array(	 "fileList"			=> "html"
								,"fileRead"			=> "html"
								,"fileDelete"		=> "html"
								,"htmlModify"		=> "html"
								,"bakFileRead"		=> "html"
							 );

	include_once $strIncludePath . $aryIncludeFolder[$strAct] . "/json.inc.php";

	$db->disConnect();

	if(!$result) { $result = print_r($_POST, true); }

	echo json_encode($result);