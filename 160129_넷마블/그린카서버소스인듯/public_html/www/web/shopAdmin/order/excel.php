<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "excelOrderList"			=> "list"
								,"excelOrderList_008"		=> "list"
								,"excelOrderList_012"		=> "list"
								,"excelDeliveryFastList"	=> "delivery"
								,"excelAccList"				=> "account"
							 );
	/* 페이지 분류 */
	if ($S_SHOP_HOME == "demo2" || $S_SHOP_HOME2 == "ahyeop"  || $S_SHOP_ORDER_VERSION == "V2.0"){
		$aryIncludeFolder = array(   
								 "excelOrderList"			=> "list_v2.0"
								,"excelOrderDeliveryDown"	=> "delivery_v2.0"
								,"excelOrderDeliveryList"	=> "delivery_v2.0"
								,"excelAccList"				=> "account"
								,"excelAccPeriodList"		=> "account"
								,"excelAccDateList"			=> "account"
								,"excelAccList2"			=> "account"

							 );		
	}
	
	
	$includeFile	= "{$strIncludePath}{$aryIncludeFolder[$strAct]}/{$strAct}.php";

	include $strIncludePath.$aryIncludeFolder[$strAct]."/excel.inc.php";
	
	if (($S_SHOP_HOME == "demo2" || $S_SHOP_HOME2 == "ahyeop"  || $S_SHOP_ORDER_VERSION == "V2.0") && (!in_array($strAct,array("excelAccList","excelAccPeriodList","excelAccList2")))){
		
		
		Header("Content-type: application/vnd.ms-excel");
		Header("Content-type: charset=utf-8");
		header("Content-Disposition: attachment; filename=".$strExcelFileName.".xls");
		Header("Content-Description: PHP4 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");

		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel;charset=utf-8\">");
	} else {
		Header("Content-type: application/vnd.ms-excel");
		Header("Content-type: charset=euc-kr");
		header("Content-Disposition: attachment; filename=".$strExcelFileName.".xls");
		Header("Content-Description: PHP4 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");

		print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel;charset=euc-kr\">");
	}

	
	include $includeFile;

	$db->disConnect();

	exit;
?>