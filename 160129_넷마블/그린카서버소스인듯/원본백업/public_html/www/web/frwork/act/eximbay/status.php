<?	
    require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/paypal_conf_inc.php";      

	$mid		= $_POST['mid'];
	$ref		= $_POST['ref'];
	$cur		= $_POST['cur'];
	$amt		= $_POST['amt'];
	$param1		= $_POST['param1']; //cartNo;
	$param2		= $_POST['param2']; //couponUseList
	$param3		= $_POST['param3'];
	$lang		= $_POST['lang'];
	
	$transid	= $_POST['transid'];
	$rescode	= $_POST['rescode'];
	$resmsg		= $_POST['resmsg'];
	$authcode	= $_POST['authcode'];
	$cardco		= $_POST['cardco'];
	$resdt		= $_POST['resdt'];
	$fgkey		= $_POST['fgkey'];


	if($rescode == "0000"){
		
		if ($lang == "EN") {
			$strEximbayLinkBuf	= $S_EXIMBAY_EN_SECRET_KEY. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt."&rescode=" .$rescode ."&transid=" .$transid;
		} else if ($lang == "CN"){
			$strEximbayLinkBuf	= $S_EXIMBAY_CN_SECRET_KEY. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt."&rescode=" .$rescode ."&transid=" .$transid;
		} else if ($lang == "JP"){
			$strEximbayLinkBuf	= $S_EXIMBAY_JP_SECRET_KEY. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt."&rescode=" .$rescode ."&transid=" .$transid;
		} else if ($lang == "KR"){
			$strEximbayLinkBuf	= $S_EXIMBAY_KR_SECRET_KEY. "?mid=" . $mid ."&ref=" . $ref ."&cur=" .$cur ."&amt=" .$amt."&rescode=" .$rescode ."&transid=" .$transid;
		}
		$strEximbayFgKey	= md5($strEximbayLinkBuf);

		if(strtolower($fgkey) != $strEximbayFgKey){
			$rescode = "ERROR";
			$resmsg = "Invalid transaction";
		} else {
			$orderMgr->setO_KEY($ref);
			$intO_NO = $orderMgr->getOrderNo($db);
		}
	}

	/* DB 처리 */		
	if($rescode == "0000"){

		if ($intO_NO > 0){
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
		
			if ($orderRow){
				
				$S_SITE_LNG = $orderRow['O_USE_LNG'];

				/* 삭제할 장바구니 번호 */
				if ($param1){
					$aryCartNo = explode(",",$param1);
					$_SESSION["ORDER_DEL_BASKET"] = $aryCartNo;
				}
				/* 삭제할 장바구니 번호 */

				/* 사용한 쿠폰 번호 */
				if ($param2){
					$aryCouponUseNo = explode(",",SUBSTR($param2,0,STRLEN($param2)-1));
					$_SESSION["ORDER_COUPON_UPDATE"] = $aryCouponUseNo;
				}
				/* 사용한 쿠폰 번호 */

				$tno = $transid;
				$escw_yn = "N";

				include MALL_HOME."/web/frwork/act/payApproval.php";
			}
		}
	}
	/* DB 처리 */		

?>