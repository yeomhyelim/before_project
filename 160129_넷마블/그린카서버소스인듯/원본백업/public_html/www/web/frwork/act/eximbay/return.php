<?
    require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/paypal_conf_inc.php";      

	$mid		= $_POST['mid'];
	$ref		= $_POST['ref'];
	$cur		= $_POST['cur'];
	$amt		= $_POST['amt'];
	$param1		= $_POST['param1'];
	$lang		= $_POST['lang'];
				
	$transid	= $_POST['transid'];
	$rescode	= $_POST['rescode'];
	$resmsg		= $_POST['resmsg'];
	$authcode	= $_POST['authcode'];
	$cardco		= $_POST['cardco'];
	$resdt		= $_POST['resdt'];
	$fgkey		= $_POST['fgkey'];
	$strPayFlag = "fail";

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
			
			$strPayFlag = "success";
			$orderMgr->setO_KEY($ref);
			$intO_NO = $orderMgr->getOrderNo($db);
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			$strOrderSiteUseLng = $orderRow['O_USE_LNG'];
		}
	}
	
	if($rescode != "0000"){
		$strMsg = "[".$rescode."]:".$resmsg;
	}
	
?>
<html>
<head>
<script language="JavaScript">
<!--
	function loadForm(){
		if(opener && opener.document.regForm){
			<?
				if ($rescode != "0000")
				{
					if ($rescode != "XXXX") {
						?>
						//alert("<?=$strMsg?>");
						<?
					}
				} else {
			?>
			var frm = opener.document.regForm;
			
			frm.rescode.value	= "<?php echo $rescode; ?>";
			frm.resmsg.value	= "<?php echo $resmsg; ?>";
			frm.authcode.value	= "<?php echo $authcode; ?>";
			frm.cardco.value	= "<?php echo $cardco; ?>";
			
			frm.payFlag.value	= "<?=$strPayFlag?>";
			frm.order_no.value	= "<?=$intO_NO?>";
			
			frm.menuType.value	= "order";
			frm.mode.value		= "orderEnd";
			
			frm.target = "";
			frm.action = "./index.php";
			
			frm.submit();
			<?}?>

			opener.goInitLoading("");
		}
		
		self.close();
	}
//-->
</script>
</head>
<body onload="javascript:loadForm();">
</body>
</html>