<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "excelOrderList"			=> "list"
								,"excelOrderDeliveryDown"	=> "delivery"
								,"excelOrderDeliveryList"	=> "delivery"
								,"excelAccList"				=> "account"

							 );
	/* 페이지 분류 */

	$includeFile	= "{$strIncludePath}{$aryIncludeFolder[$strAct]}/{$strAct}.php";

	include $strIncludePath.$aryIncludeFolder[$strAct]."/excel.inc.php";
	
	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=utf-8");
	header("Content-Disposition: attachment; filename=".$strExcelFileName.".xls");
	Header("Content-Description: PHP4 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");

	print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel;charset=utf-8\">");

	include $includeFile;

	$db->disConnect();

	exit;
?>