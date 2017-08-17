<?
	$result_array = array();
	
	$strJsonMode		= $_POST["jsonMode"]		? $_POST["jsonMode"]		: $_REQUEST["jsonMode"];
	/* 페이지 분류 */
	$aryIncludeFolder = array(   "orderCartStatusSave"				=> "list"	//구매상태변경(상품)
								,"orderCartDeliverySave"			=> "list"	//배송정보변경(상품)
								,"orderInfoDisplay"					=> "list"	//주문정보(상품)펼치기
								,"orderCartNoSelect"				=> "list"	//주문정보에 속한 상품카트번호
								,"partCancelCal"					=> "list"	//부분취소잔액계산
							 );
	/* 페이지 분류 */

	include $strIncludePath.$aryIncludeFolder[$strJsonMode]."/json.inc.php";

	$db->disConnect();

?>