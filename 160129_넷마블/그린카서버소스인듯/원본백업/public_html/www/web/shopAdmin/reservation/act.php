<?

	/* 페이지 분류 */
	$aryIncludeFolder = array(			 "basicSetSave"				=> "setting/basicSet",
										 "roomSetEtcWrite"			=> "roomSetEtc/roomSetEtc",
										 "roomTypeSetWrite"			=> "roomSetEtc/roomSetEtc",
										 "roomSetEtcModify"			=> "roomSetEtc/roomSetEtc",
										 "poproomTypeSetModify"		=> "roomSetEtc/roomSetEtc",
										 "addsetDelete"				=> "roomSetEtc/roomSetEtc",
										 "roomSetFixWrite"			=> "roomSetFix/roomSetFix",
										 "roomSetFixModify"			=> "roomSetFix/roomSetFix",
										 "FixDelete"				=> "roomSetFix/roomSetFix",
										 "roomSetFixWrite2"			=> "roomSetFix/roomSetFix",
										 "roomSetFixModify2"		=> "roomSetFix/roomSetFix",
										 "FixDelete2"				=> "roomSetFix/roomSetFix",
										 "roomSetPolicyWrite"		=> "roomSetPolicy/roomSetPolicy",
										 "timeDelete"				=> "setting/basicSet",
										 "roomDataWrite"			=> "roomList/roomList",
										 "roomWrite"				=> "roomList/roomList",
										 "roomDataModify"			=> "roomList/roomList",
										 "roomModify"				=> "roomList/roomList",
										 "roomBasicDelete"			=> "roomList/roomList",
										 "reservWrite2"				=> "adm_revList",
										 "admRsvWrite"				=> "adm_revConfirm",

							 );
	/* 페이지 분류 */

	include $strIncludePath.$aryIncludeFolder[$strAct].".act.inc.php";

	goUrl($strMsg,$strUrl);
?>