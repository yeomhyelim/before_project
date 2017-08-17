<?
    require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/paypal_conf_inc.php";      

	$mid		= $_POST['mid'];
	$ref		= $_POST['ref'];
	$cur		= $_POST['cur'];
	$amt		= $_POST['amt'];
	$param1		= $_POST['param1']; //주문번호
	$param2		= $_POST['param2'];	//이유
	$param3		= $_POST['param3'];	//국가_사용자/관리자
	$voidamt	= $_POST['voidamt'];
	$lang		= $_POST['lang'];
				
	$transid		= $_POST['transid'];
	$rescode		= $_POST['rescode'];
	$resmsg			= $_POST['resmsg'];
	$authcode		= $_POST['authcode'];
	$resdt			= $_POST['resdt'];
	$fgkey			= $_POST['fgkey'];
	$voidtransid	= $_POST['voidtransid'];
	$newtransid		= $_POST['newtransid'];
	$newamt			= $_POST['newamt'];

	$aryParam3		= explode("_",$param3);
	$intO_NO		= $param1;

	require_once MALL_HOME."/lang/lang.".strtolower($aryParam3[0]).".inc.php";
	
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
		}	
	}
	
	if($rescode != "0000"){
		$strMsg = "[".$rescode."]:".$resmsg;
	}
	
	/* DB 처리 */		
	if($rescode == "0000"){
		
		
		if ($intO_NO > 0){
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			include MALL_HOME."/web/frwork/act/payCancel.php";

			$strMsg = $LNG_TRANS_CHAR["OS00045"]; //주문이 취소 되었습니다.
			
			if ($aryParam3[1] == "U"){
				goPopReflash($strMsg);
			} else {
				echo "<script language='javascript'>alert('".$strMsg."');parent.location.reload();</script>";
			}
		}
	} else {
		$strUrl = "../../".strtolower($aryParam3[0])."/?menuType=etc&mode=orderCancel&no=".$intO_NO;
		if ($aryParam3[1] == "A"){
			$strUrl = "/shopAdmin/?menuType=order&mode=popOrderCancel&no=".$intO_NO;
		}
		goUrl($strMsg,$strUrl);
	}
	/* DB 처리 */
	$db->disConnect();	
	exit;
?>
