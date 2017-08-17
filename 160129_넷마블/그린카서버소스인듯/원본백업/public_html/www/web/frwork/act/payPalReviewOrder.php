<?php

/********************************************
ReviewOrder.php

This file is called after the user clicks on a button during
the checkout process to use PayPal's Express Checkout. The
user logs in to their PayPal account.

This file is called twice.

On the first pass, the code executes the if statement:

if (! isset ($token))

The code collects transaction parameters from the form
displayed by SetExpressCheckout.html then constructs and
sends a SetExpressCheckout request string to the PayPal
server. The paymentType variable becomes the PAYMENTACTION
parameter of the request string. The RETURNURL parameter
is set to this file; this is how ReviewOrder.php is called
twice.

On the second pass, the code executes the else statement.

On the first pass, the buyer completed the authorization in
their PayPal account; now the code gets the payer details
by sending a GetExpressCheckoutDetails request to the PayPal
server. Then the code calls GetExpressCheckoutDetails.php.

Note: Be sure to check the value of PAYPAL_URL. The buyer is
sent to this URL to authorize payment with their PayPal
account. For testing purposes, this should be set to the
PayPal sandbox.

Called by SetExpressCheckout.html.

Calls GetExpressCheckoutDetails.php, CallerService.php,
and APIError.php.

********************************************/

    require_once MALL_SHOP."/conf/paypal_conf_inc.php";      

	require_once MALL_HOME."/web/frwork/pay/paypal/CallerService.php";

/* An express checkout transaction starts with a token, that
   identifies to PayPal your transaction
   In this example, when the script sees a token, the script
   knows that the buyer has already authorized payment through
   paypal.  If no token was found, the action is to send the buyer
   to PayPal to first authorize payment
   */



if(! isset($_REQUEST['token'])) {
	/* The servername and serverport tells PayPal where the buyer
   should be directed back to after authorizing payment.
   In this case, its the local webserver that is running this script
   Using the servername and serverport, the return URL is the first
   portion of the URL that buyers will return to after authorizing payment
   */
	$serverName = $_SERVER['SERVER_NAME'];
	$serverPort = $_SERVER['SERVER_PORT'];
	$url=dirname('http://'.$serverName.':'.$serverPort.$_SERVER['REQUEST_URI']);


   //$currencyCodeType	= $_REQUEST['currencyCodeType'];
   //$paymentType			= $_REQUEST['paymentType'];

	$currencyCodeType	= $S_SITE_CUR;
	$paymentType		= "Authorization";
	if ($S_PAYPAL_PAYMENT_MTH) $paymentType = $S_PAYPAL_PAYMENT_MTH;

	if ($S_SITE_CUR == "IDR" || $S_SITE_CUR == "CNY" || $S_SITE_CUR == "RUB") $currencyCodeType = "USD";
	
	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);
	
	$personName			= $orderRow[O_J_NAME];
	$SHIPTOSTREET		= $orderRow[O_B_ADDR1].",".$orderRow[O_B_ADDR2];
	$SHIPTOCITY			= $orderRow[O_B_CITY];
	$SHIPTOSTATE	    = $orderRow[O_B_STATE];
	$SHIPTOCOUNTRYCODE	= $orderRow[O_B_COUNTRY];
	$SHIPTOZIP			= $orderRow[O_B_ZIP];
	$L_NAME0			= $orderRow[O_J_TITLE];
	
	if ($S_SITE_CUR == "IDR" || $S_SITE_CUR == "CNY" || $S_SITE_CUR == "RUB"){
		//$L_AMT0				= $orderRow[O_TOT_CUR_SPRICE] - $orderRow[O_TOT_DELIVERY_CUR_PRICE]; //결제금액 - 배송금액
		$L_AMT0				= getPriceToUsd($orderRow[O_TOT_CUR_SPRICE]); //결제금액 - 배송금액
	} else {
		//$L_AMT0				= $orderRow[O_TOT_SPRICE] - $orderRow[O_TOT_DELIVERY_PRICE]; //결제금액 - 배송금액
		$L_AMT0				= $orderRow[O_TOT_SPRICE]; //결제금액 - 배송금액
	}
	
	$L_QTY0				= 1;
	$L_NAME1			= "";
	$L_AMT1				= "";
	$L_QTY1				= "";

 /* The returnURL is the location where buyers return when a
	payment has been succesfully authorized.
	The cancelURL is the location buyers are sent to when they hit the
	cancel button during authorization of payment during the PayPal flow
	*/
	
	$returnURL			= urlencode($url.'/?menuType=order&mode=pg&act=pg&payPg=Y&currencyCodeType='.$currencyCodeType.'&paymentType='.$paymentType);
	$cancelURL			= urlencode("$url/?menuType=order&mode=cart");
	
 /* Construct the parameter string that describes the PayPal payment
	the varialbes were set in the web form, and the resulting string
	is stored in $nvpstr
	*/
	if ($S_SITE_CUR == "IDR"  || $S_SITE_CUR == "CNY" || $S_SITE_CUR == "RUB"){
		$itemamt = 0.00;
		//$itemamt = $orderRow[O_TOT_CUR_SPRICE] - $orderRow[O_TOT_DELIVERY_CUR_PRICE];
		$itemamt	= getPriceToUsd($orderRow[O_TOT_CUR_SPRICE]);
		$amt		= getPriceToUsd($orderRow[O_TOT_CUR_SPRICE]);
		$maxamt		= getPriceToUsd($orderRow[O_TOT_CUR_SPRICE]);
		$nvpstr		= "";

		//$intDeliveryTotalPrice = $orderRow[O_TOT_DELIVERY_CUR_PRICE];
		$intDeliveryTotalPrice = 0;
	} else {


		$itemamt = 0.00;
		//$itemamt = $orderRow[O_TOT_SPRICE] - $orderRow[O_TOT_DELIVERY_PRICE];
		$itemamt = $orderRow[O_TOT_SPRICE];
		$amt = $orderRow[O_TOT_SPRICE];
		$maxamt= $orderRow[O_TOT_SPRICE];
		$nvpstr="";

		//$intDeliveryTotalPrice = $orderRow[O_TOT_DELIVERY_PRICE];
		$intDeliveryTotalPrice = 0;
	}
   /*
	* Setting up the Shipping address details
	*/
   $shiptoAddress = "&SHIPTONAME=$personName&SHIPTOSTREET=$SHIPTOSTREET&SHIPTOCITY=$SHIPTOCITY&SHIPTOSTATE=$SHIPTOSTATE&SHIPTOCOUNTRYCODE=$SHIPTOCOUNTRYCODE&SHIPTOZIP=$SHIPTOZIP";
   
   $nvpstr="&ADDRESSOVERRIDE=1$shiptoAddress&L_NAME0=".$L_NAME0."&L_NAME1=".$L_NAME1."&L_AMT0=".$L_AMT0."&L_AMT1=".$L_AMT1."&L_QTY0=".$L_QTY0."&L_QTY1=".$L_QTY1."&MAXAMT=".(string)$maxamt."&AMT=".(string)$amt."&ITEMAMT=".(string)$itemamt."&ReturnUrl=".$returnURL."&CANCELURL=".$cancelURL ."&CURRENCYCODE=".$currencyCodeType."&PAYMENTACTION=".$paymentType;
   //$nvpstr .= "&SOLUTIONTYPE=Sole&LANDINGPAGE=Billing"; //->이부분을 추가하면 바로 입력페이지가 나옴

   //$nvpstr .="&SHIPPINGAMT=".$intDeliveryTotalPrice;

   /* Make the call to PayPal to set the Express Checkout token
	If the API call succeded, then redirect the buyer to PayPal
	to begin to authorize payment.  If an error occured, show the
	resulting errors*/
		
	$resArray=hash_call("SetExpressCheckout",$nvpstr);
	$_SESSION['reshash']=$resArray;

	$ack = strtoupper($resArray["ACK"]);
	if($ack=="SUCCESS"){

		// Redirect to paypal.com here
		/* tocken update */
		$token = urldecode($resArray["TOKEN"]);
		$orderMgr->setO_PAYPAL_TOKEN($token);
		$orderMgr->getOrderPayPalTokenUpdate($db);
		/* tocken update */
		
		$_SESSION["ORDER_DEL_BASKET"]		= $_POST[  "cartNo"		   ]; // 주문상품정보 지워야 함.
		$_SESSION["ORDER_COUPON_UPDATE"]	= $_POST[  "couponUseIssueNo"		   ]; // 주문상품정보 지워야 함.

		$payPalURL = PAYPAL_URL.$token;
		header("Location: ".$payPalURL);
	
	} else  {
		//Redirecting to APIError.php to display errors.
		
		if(isset($_SESSION['curl_error_no'])) { 
			$errorCode= $_SESSION['curl_error_no'] ;
			$errorMessage=$_SESSION['curl_error_msg'] ;	
			
			$_SESSION['curl_error_no'] = "";
			$_SESSION['curl_error_msg'] = "";
			$_SESSION['reshash'] = "";
		
			goUrl("[".$errorCode."]:".$errorMessage,"./?menuType=order&mode=cart");
		}
		$db->disConnect();
		exit;

	}
} else {
	/* At this point, the buyer has completed in authorizing payment
	at PayPal.  The script will now call PayPal with the details
	of the authorization, incuding any shipping information of the
	buyer.  Remember, the authorization is not a completed transaction
	at this state - the buyer still needs an additional step to finalize
	the transaction
	*/

	$token =urlencode( $_REQUEST['token']);

	/* Build a second API request to PayPal, using the token as the
	ID to get the details on the payment authorization
	*/
	$nvpstr="&TOKEN=".$token;

	/* Make the API call and store the results in an array.  If the
	call was a success, show the authorization details, and provide
	an action to complete the payment.  If failed, show the error
	*/
	$resArray=hash_call("GetExpressCheckoutDetails",$nvpstr);
	$_SESSION['reshash']=$resArray;
	$ack = strtoupper($resArray["ACK"]);

	if($ack == 'SUCCESS' || $ack == 'SUCCESSWITHWARNING'){
		
		$intOrderTotal = $resArray['AMT'] + $resArray['SHIPDISCAMT'];
		
		$orderMgr->setO_PAYPAL_TOKEN($token);
		$orderRow = $orderMgr->getOrderTokenView($db);
		$orderMgr->setO_NO($orderRow[O_NO]);
		$intSettleOrderTotal = $orderRow[O_TOT_SPRICE]; //저장된 결제금액
		if ($S_SITE_CUR == "IDR" || $S_SITE_CUR == "CNY" || $S_SITE_CUR == "RUB") $intSettleOrderTotal = getPriceToUsd($orderRow[O_TOT_CUR_SPRICE]);
		
		
		if ($orderRow && $intSettleOrderTotal == $intOrderTotal){
		
			$strPayerId			= urlencode ($_REQUEST['PayerID']);
			$intPaymentAmount	= urlencode (isset($_REQUEST['paymentAmount'])?$_REQUEST['paymentAmount']:null);
			$strCurrCodeType	= urlencode ($_REQUEST['currencyCodeType']);
			$strPaymentType		= urlencode ($_REQUEST['paymentType']);
			
			ini_set('session.bug_compat_42',0);
			ini_set('session.bug_compat_warn',0);

			
			$nvpstr='&TOKEN='.$token.'&PAYERID='.$strPayerId.'&PAYMENTACTION='.$strPaymentType.'&AMT='.$intOrderTotal.'&CURRENCYCODE='.$strCurrCodeType.'&IPADDRESS='.$serverName ;

			/* Make the call to PayPal to finalize payment
				If an error occured, show the resulting errors2012-08-30
				*/
			$resArray=hash_call("DoExpressCheckoutPayment",$nvpstr);

			/* Display the API response back to the browser.
			   If the response from PayPal was a success, display the response parameters'
			   If the response was an error, display the errors received using APIError.php.
			   */
			$ack = strtoupper($resArray["ACK"]);

			if($ack != 'SUCCESS' && $ack != 'SUCCESSWITHWARNING'){
				if(isset($_SESSION['curl_error_no'])) { 
					
					$_SESSION['reshash'] = "";
					goUrl("[".$errorCode."]:".$errorMessage,"./?menuType=order&mode=orderEnd&order_no=".$orderRow[O_NO]."&payFlag=fail");
				}
				$db->disConnect();
				exit;
			} else {
			
				/* 정상 승인 시작 */
				$tno = $resArray['TRANSACTIONID'];
				$escw_yn = "N";
				/* 정상 승인 종료 */
				
				include MALL_HOME."/web/frwork/act/payApproval.php";
				
				if ($S_WINDOW_FRAME_USE == "Y"){
					
					$arrayParam["menuType"] = "order";
					$arrayParam["mode"]		= "orderEnd";
					$arrayParam["order_no"] = $orderRow[O_NO];
					$arrayParam["payFlag"]	= "success";
					$arrayParam["siteLng"]	= $S_SITE_LNG;
					
					drawPageRedirect("form","../index.php",$arrayParam,$paramList=""); 
					
					//goUrl("","../?menuType=order&mode=orderEnd&order_no=".$orderRow[O_NO]."&payFlag=success&siteLng=".$S_SITE_LNG);
				} else {
					goUrl("","./?menuType=order&mode=orderEnd&order_no=".$orderRow[O_NO]."&payFlag=success");
				}

				$db->disConnect();
				exit;
			}
			
		
		} else {
			goUrl("[99999]:".$LNG_RES_MSG["03081"],"./?menuType=order&mode=cart");
			$db->disConnect();
			exit;
		}		
		exit;
	} else  {
	   if(isset($_SESSION['curl_error_no'])) { 
			$errorCode= $_SESSION['curl_error_no'] ;
			$errorMessage=$_SESSION['curl_error_msg'] ;	
			
			$_SESSION['curl_error_no'] = "";
			$_SESSION['curl_error_msg'] = "";
			$_SESSION['reshash'] = "";
		}

		goUrl("[".$errorCode."]:".$errorMessage,"./?menuType=order&mode=order");
		$db->disConnect();
		exit;
	}
}
?>