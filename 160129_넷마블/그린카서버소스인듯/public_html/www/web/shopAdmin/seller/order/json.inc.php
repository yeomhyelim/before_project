<?
	require_once MALL_CONF_LIB."ShopMgr.php";
	
	$shopMgr = new ShopMgr();

	switch($strJsonMode):
	case "orderStatusSave":
		// 구매상태 변경
		// ./?menuType=seller&mode=json&jsonMode=orderStatusSave&so_no=31&orderStatus=E
		if(!$_REQUEST['so_no']):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "입점사_주문관리번호가 없습니다.";
			getJsonExit($result);
		endif;

		## STEP 2.
		## 구매상태 업데이트
		$param							= "";
		$param['so_no']					= $_REQUEST['so_no'];
		$param['so_order_status']		= $_REQUEST['orderStatus'];
		$re								= $shopMgr->getOrderStatusUpdateEx($db, $param);

		if($re != 1):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "구매상태를 업데이트 할수 없습니다.";
			getJsonExit($result);
		endif;

		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= "변경되었습니다.";
		getJsonExit($result);	
	break;
	case "deliverySave":
		// 배송정보 수정
		// ./?menuType=seller&mode=json&jsonMode=deliverySave&so_no=22&deliveryCom=&deliveryNum=&deliveryStatus=

		## STEP 1.
		## 입력값 체크
		if(!$_REQUEST['so_no']):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "입점사_주문관리번호가 없습니다.";
			getJsonExit($result);
		endif;

		## STEP 2.
		## 배송관련 정보 업데이트
		$param['so_no']					= $_REQUEST['so_no'];
		$param['so_delivery_com']		= $_REQUEST['deliveryCom'];
		$param['so_delivery_num']		= $_REQUEST['deliveryNum'];
		$param['so_delivery_status']	= $_REQUEST['deliveryStatus'];
		$re								= $shopMgr->getDeliveryUpdateEx($db, $param);

		if($re != 1):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "배송관련 정보를 업데이트 할수 없습니다.";
			getJsonExit($result);
		endif;

		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= "변경되었습니다.";
		getJsonExit($result);	
	break;
	endswitch;


	$result				= "";
	$result['mode']		= "__ERROR__";
	$result['text']		= "JSON MODE 값이 없습니다.";
	getJsonExit($result);	

?>