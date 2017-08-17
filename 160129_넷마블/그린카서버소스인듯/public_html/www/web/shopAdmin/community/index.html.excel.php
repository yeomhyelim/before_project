<?

	switch($_REQUEST['excelType']){
		case "commentList":
		
			$strExcelFileName		= "comment.list.".date("Ymd");
			$result					= $_REQUEST['result']['CommentMgr'];
			$list_num				= $_REQUEST['result']['CommentMgrCount'];

		break;
	}

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=euc-kr");
	header("Content-Disposition: attachment; filename=".$strExcelFileName.".xls");
	Header("Content-Description: PHP4 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	
	include "excel/".$_REQUEST['excelType'].".excel.php";
?>