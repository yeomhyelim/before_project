<?php
/******************************************************
DoVoidReceipt.php

Sends a DoVoid NVP API request to PayPal.

The code retrieves the authorization ID and constructs the
NVP API request string to send to the PayPal server. The
request to PayPal uses an API Signature.

After receiving the response from the PayPal server, the
code displays the request and response in the browser. If
the response was a success, it displays the response
parameters. If the response was an error, it displays the
errors received.

Called by DoVoid.html.

Calls CallerService.php and APIError.php.

******************************************************/
// clearing the session before starting new API Call
    require_once MALL_SHOP."/conf/paypal_conf_inc.php";      
	require_once MALL_HOME."/web/frwork/pay/paypal/CallerService.php";

	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);

	if ($orderRow[O_SETTLE] == "Y"){
		
		$authorizationID=urlencode($orderRow['O_APPR_NO']);
		$note=urlencode($_POST['mod_desc']);
		
		if ($_POST["userType"] == "A"){
			$_SESSION['curl_user_type'] = "A"; 
		}

		/* Construct the request string that will be sent to PayPal.
		   The variable $nvpstr contains all the variables and is a
		   name value pair string with & as a delimiter */
		$nvpStr="&AUTHORIZATIONID=$authorizationID&NOTE=$note";

		/* Make the API call to PayPal, using API signature.
		   The API response is stored in an associative array called $resArray */
		$resArray=hash_call("DOVoid",$nvpStr);

		/* Next, collect the API request in the associative array $reqArray
		   as well to display back to the browser.
		   Normally you wouldnt not need to do this, but its shown for testing */

		$reqArray=$_SESSION['nvpReqArray'];

		/* Display the API response back to the browser.
		   If the response from PayPal was a success, display the response parameters'
		   If the response was an error, display the errors received using APIError.php.
		   */
		$ack = strtoupper($resArray["ACK"]);
	}

if($ack!="SUCCESS"){
		$_SESSION['reshash']=$resArray;
	
		if ($resArray['L_ERRORCODE0'] && $resArray['L_SHORTMESSAGE0']){
			$errorCode= $resArray['L_ERRORCODE0'] ;
			$errorMessage=$resArray['L_SHORTMESSAGE0'] ;	
		}

		if(isset($_SESSION['curl_error_no'])) { 
			if (!$errorCode) $errorCode = $_SESSION['curl_error_no'] ;
			if (!$errorMessage) $errorMessage=$_SESSION['curl_error_msg'] ;	
		}

		goErrMsg("[".$errorCode."]:".$errorMessage);

		$_SESSION['curl_error_no'] = "";
		$_SESSION['curl_error_msg'] = "";
		$_SESSION['reshash'] = "";
		$_SESSION['curl_user_type'] = "";
		
		$db->disConnect();
		exit;
  
  } else {
	
	include MALL_HOME."/web/frwork/act/payCancel.php";
	
	$db->disConnect();
	$strMsg = $LNG_TRANS_CHAR["OS00045"]; //주문이 취소 되었습니다.
	if ($_SESSION['curl_user_type'] == "A") {
		goLayerPopClose($strMsg);
	} else {
		goPopReflash($strMsg);
	}
	exit;
  }

?>

