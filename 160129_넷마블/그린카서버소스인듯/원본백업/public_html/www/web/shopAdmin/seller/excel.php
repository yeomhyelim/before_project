<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "excelOrderList"			=> "order"
							 );
	/* 페이지 분류 */

	include $strIncludePath.$aryIncludeFolder[$strAct]."/excel.inc.php";

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=euc-kr");
	header("Content-Disposition: attachment; filename=".$strExcelFileName.".xls");
	Header("Content-Description: PHP4 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	
	include $strIncludePath.$aryIncludeFolder[$strAct]."/".$strAct.".php";

	$db->disConnect();

	exit;
?>