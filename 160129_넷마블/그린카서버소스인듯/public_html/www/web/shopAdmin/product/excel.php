<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "excelProdList"		=> "product"
								,"prodAtOneTimeWrite"	=> "prodAtOneTime"
								,"excelCateList"		=> "cate"
							 );
	/* 페이지 분류 */

	include $strIncludePath.$aryIncludeFolder[$strAct]."/excel.inc.php";


//	Header("Content-type: application/vnd.ms-excel");
//	Header("Content-type: charset=euc-kr");
//	header("Content-Disposition: attachment; filename=".$strExcelFileName.".xls");
//	Header("Content-Description: PHP4 Generated Data");
//	Header("Pragma: no-cache");
//	Header("Expires: 0");

	$strExcelFileName = iconv("utf-8", "euc-kr", $strExcelFileName);
	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=utf-8");
	header("Content-Disposition: attachment; filename=".$strExcelFileName);
	Header("Content-Description: PHP4 Generated Data");
	Header("Pragma: public");
	Header("Expires: 0");

	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";

	include "{$strIncludePath}{$aryIncludeFolder[$strAct]}/{$strAct}.php";

	$db->disConnect();

	exit;
?>