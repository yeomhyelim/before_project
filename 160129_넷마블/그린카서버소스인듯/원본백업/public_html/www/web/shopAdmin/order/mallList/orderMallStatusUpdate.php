<?
	if ($intO_NO > 0){
		
		$orderMgr->setO_NO($intO_NO);
		$orderRow			= $orderMgr->getOrderView($db);
		$strOrderStatus		= $orderRow["O_STATUS"];
		
		if (!$strPreOrderStatus || ($strPreOrderStatus && $strOrderStatus != $strPreOrderStatus)){
			include MALL_WEB_PATH."shopAdmin/order/mallList/orderStatusUpdate.php";
		}		
	}
?>