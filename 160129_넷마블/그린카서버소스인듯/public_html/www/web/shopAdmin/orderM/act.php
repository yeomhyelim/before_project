<?
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "orderSettleStatus"			=> "list"		//결제상태변경
								,"orderDelvieryIinput"			=> "list"
								,"orderCancel"					=> "list"		//주문취소(배송전)
								,"orderCancelUpdate"			=> "list"		//주문취소(배송후)
								,"orderDelete"					=> "list"		//주문삭제
								,"shopOrderReturnStatusUpdate"	=> "list"

								,"deliveryAddrUpdate"			=> "list"		//배송지정보변경
						
								,"orderDeliveryUpdate"			=> "delivery"
								,"orderDeliveryExcelUpdate"		=> "delivery"	//엑셀업로드
								,"orderDeliveryStatusUpdate"	=> "delivery"

								,"addressWrite"					=> "selfOrder"
								,"addressModify"				=> "selfOrder"
								,"addressDelete"				=> "selfOrder"
								,"prodOrderWrite"				=> "selfOrder"

								,"accStatusUpdate"				=> "account"
								,"accPeriodStatusUpdate"		=> "account"

							 );
	/* 페이지 분류 */


	include $strIncludePath.$aryIncludeFolder[$strAct]."/act.inc.php";
	goUrl($strMsg,$strUrl);
?>