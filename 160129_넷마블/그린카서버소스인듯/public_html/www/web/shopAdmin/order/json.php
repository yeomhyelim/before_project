<?

	$result_array = array();
	
	$strJsonMode		= $_POST["jsonMode"]		? $_POST["jsonMode"]		: $_REQUEST["jsonMode"];
	
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "deliverySave"			=> "list"
								,"settleSave"			=> "list"
								,"ceritySave"			=> "list"
							 );
	/* 페이지 분류 */
	if ($S_SHOP_HOME == "demo2" || $S_SHOP_HOME2 == "ahyeop"  || $S_SHOP_ORDER_VERSION == "V2.0")
	{
		$aryIncludeFolder = array(   
			 "orderCartStatusSave"				=> "list_v2.0"	//구매상태변경(상품)
			,"orderCartDeliverySave"			=> "list_v2.0"	//배송정보변경(상품)
			,"orderInfoDisplay"					=> "list_v2.0"	//주문정보(상품)펼치기
			,"orderCartNoSelect"				=> "list_v2.0"	//주문정보에 속한 상품카트번호
			,"partCancelCal"					=> "list_v2.0"	//부분취소잔액계산
			,"orderMemoWrite"					=> "orderMemo"
			,"orderMemoModify"					=> "orderMemo"
			,"orderMemoDelete"					=> "orderMemo"
		 );	
	}

	if($strJsonMode):
		include $strIncludePath.$aryIncludeFolder[$strJsonMode]."/json.inc.php";
	else:
		include $strIncludePath.$aryIncludeFolder[$strAct]."/json.inc.php";
	endif;

	$db->disConnect();

?>