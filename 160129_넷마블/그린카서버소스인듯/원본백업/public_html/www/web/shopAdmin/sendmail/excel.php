<?php
	
	$strExcelFileName = date("Y-m-d") . ".xls";

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=utf-8");
	header("Content-Disposition: attachment; filename={$strExcelFileName}");
	Header("Content-Description: PHP4 Generated Data");
	Header("Pragma: public");
	Header("Expires: 0");

	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
	
	include sprintf("%sskin/%s/%s.skin.php", $strIncludePath, $arySkinFolder[$strAct], $strAct);

	$db->disConnect();

	exit;
?>