<?
	## 페이지 분류
	$aryIncludeFolder			= array(	"memberCrmSearch"		=> "member",
											"idChk"					=> "member",
											"memberPointMove"		=> "member",
											"memberReportWrite"		=> "member",
											"memberSendSms"			=> "member",
											"memberSendEmail"		=> "member",
											"memberSendEmail2"		=> "member",
											"dataModify"			=> "member",
											"dataDelete"			=> "member",
											"dataAnswerWrite"		=> "member",
											"resultStateChange"		=> "member",
											"nickNameChk"			=> "memberInsert",
								  );

	include "{$strIncludePath}{$aryIncludeFolder[$strAct]}/json.inc.php";

	$db->disConnect();

	if(!$result):
		$result = print_r($_POST, true);
	endif;

	echo json_encode($result);

?>