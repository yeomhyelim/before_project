<?
	if ($intO_NO > 0){
		
		$orderMgr->setO_NO($intO_NO);
		$orderRow				= $orderMgr->getOrderView($db);
		$strOrderNowStatus		= $orderRow["O_STATUS"];
		
		/* 배송완료/구매완료일때 */
		if (in_array($strOrderNowStatus,array("I","D","E"))){
			if ($strOrderPrevStatus != $strOrderNowStatus)
			{	
				$strOrderStatus = $strOrderNowStatus;

				include_once "../conf/site_conf_inc.php";       // 환경설정 파일 include
				require_once MALL_HOME."/web/frwork/act/pp_ax_hub_lib.php";              // library [수정불가]
				
				include MALL_WEB_PATH."shopAdmin/order/list_v2.0/orderStatusUpdate.php";			
			}
		}
	}
?>