<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "orderStatus"					=> "list"
								,"orderDelvieryIinput"			=> "list"
								,"orderCancel"					=> "list"
								,"orderCancelUpdate"			=> "list"
								,"orderDelete"					=> "list"
								,"shopOrderReturnStatusUpdate"	=> "list"
						
								,"orderDeliveryUpdate"			=> "delivery"
								,"orderDeliveryExcelUpdate"		=> "delivery"
								,"orderDeliveryStatusUpdate"	=> "delivery"

								,"addressWrite"					=> "selfOrder"
								,"addressModify"				=> "selfOrder"
								,"addressDelete"				=> "selfOrder"
								,"prodOrderWrite"				=> "selfOrder"

								,"accStatusUpdate"				=> "account"
								,"accPeriodStatusUpdate"		=> "account"

							 );
	
	/* 페이지 분류 */
	if ($S_SHOP_HOME == "demo2" || $S_SHOP_HOME2 == "ahyeop"  || $S_SHOP_ORDER_VERSION == "V2.0"){
		$aryIncludeFolder = array(   
			 "orderSettleStatus"			=> "list_v2.0"		//결제상태변경
			,"orderDelvieryIinput"			=> "list_v2.0"
			,"orderCancel"					=> "list_v2.0"		//주문취소(배송전)
			,"orderCancelUpdate"			=> "list_v2.0"		//주문취소(배송후)
			,"orderDelete"					=> "list_v2.0"		//주문삭제
			,"shopOrderReturnStatusUpdate"	=> "list_v2.0"

			,"deliveryAddrUpdate"			=> "list_v2.0"		//배송지정보변경
	
			,"orderDeliveryUpdate"			=> "delivery_v2.0"
			,"orderDeliveryExcelUpdate"		=> "delivery_v2.0"	//엑셀업로드
			,"orderDeliveryStatusUpdate"	=> "delivery_v2.0"

			,"accStatusUpdate"				=> "account"
			,"accPeriodStatusUpdate"		=> "account"
		 );		
	}



	include $strIncludePath.$aryIncludeFolder[$strAct]."/act.inc.php";
	goUrl($strMsg,$strUrl);
?>