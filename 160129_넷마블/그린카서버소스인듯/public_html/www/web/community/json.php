<?php

	## 페이지 분류
	$aryIncludeFolder		= array(	"commentList"			=> "data",
										"commentWrite"			=> "data",
										"commentModify"			=> "data",
										"commentDelete"			=> "data",
										"commentReplyWrite"		=> "data",
										"commentReplyData"		=> "data",
							 );

	## 페이지 분류 설정
	$strIncludeFolder		= $aryIncludeFolder[$strAct];

	## json include
	include "{$strIncludeFolder}/json.inc.php";

	if(!$result):
		$result			= print_r($_POST, true);
	endif;

	echo json_encode($result);
