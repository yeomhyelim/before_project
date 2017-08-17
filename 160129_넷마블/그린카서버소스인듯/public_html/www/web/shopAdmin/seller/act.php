<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "shopWrite"			=> "shop"
								,"shopModify"			=> "shop"
								,"shopDelete"			=> "shop"
								,"shopSettingUpdate"	=> "shop"
								,"storeFileDelete"		=> "shop"
								,"shopFileDelete"		=> "shop"
								,"shopUserAdd"			=> "shop"
								,"shopUserWrite"		=> "shop"
								,"shopUserModify"		=> "shop"
								,"shopUserDelete"		=> "shop"
								,"shopSiteUpdate"		=> "shop"
								,"shopGrade"			=> "shop"
								,"shopNotOk"			=> "shop"
								,"shopOkCheck"			=> "shop"
								,"prodAllAppr"			=> "shop"
								,"orderStatusUpdate"	=> "order"
								,"orderUpdate"			=> "order"
								,"deliveryStatusUpdate"	=> "order"
								,"deliveryUpdate"		=> "order"
								,"deliverySave"			=> "order"
								,"orderStatusSave"		=> "order"
							 );
	/* 페이지 분류 */

	include $strIncludePath.$aryIncludeFolder[$strAct]."/act.inc.php";
	goUrl($strMsg,$strUrl);
?>