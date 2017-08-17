<?php

	## 페이지 분류
	$aryIncludeFolder			= array(	"popupWrite"			=> "popup",
											"popupModify"			=> "popup",
											"popupDelete"			=> "popup",
								  );

	include "{$strIncludePath}{$aryIncludeFolder[$strAct]}/json.inc.php";



	$db->disConnect();

	if(!$result):
		$result = print_r($_POST, true);
	endif;

	echo json_encode($result);