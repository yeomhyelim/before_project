<?
	require_once MALL_CONF_LIB."OrderAdmMgr2.php";
	
	$orderMgr = new OrderMgr2();
	
	
	switch($strJsonMode):
	case "settleSave":
		// 결제상태 수정
		// ./?menuType=order&mode=json&jsonMode=settleSave&o_no=31&settleStatus=J

		## STEP 1.
		## 입력값 체크
		if(!$_REQUEST['o_no']):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "입점사_주문관리번호가 없습니다.";
			getJsonExit($result);
		endif;

		## STEP 2.
		## 결제 정보 업데이트
		$param['o_no']					= $_REQUEST['o_no'];
		$param['o_status']				= $_REQUEST['settleStatus'];
		$re								= $orderMgr->getOrderStatusUpdateEx($db, $param);

		if($re != 1):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "결제 정보를 업데이트 할수 없습니다.";
			getJsonExit($result);
		endif;

		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= "변경되었습니다.";
		getJsonExit($result);	
	break;

	case "ceritySave":
		/* 입점사별 구매확정 상태 변경 */
		$intOC_NO = $_REQUEST["ocNo"];
		
		if ($intOC_NO > 0){

			$param["OC_NO"]			= $intOC_NO;
			$param["OC_STATUS1"]	= "E";
			$param["OC_STATUS2"]	= "";
			$param["OC_REQ_DT"]		= "";
			$param["OC_REG_DT"]		= "";
			$param["OC_REG_NO"]		= $a_admin_no;
			
			$orderMgr->getOrderMallCerityUpdate($db,$param);

			$result['mode']		= "__SUCCESS__";
			$result['text']		= "구매확정 되었습니다.";

			getJsonExit($result);
		}

	break;
	endswitch;


	$result				= "";
	$result['mode']		= "__ERROR__";
	$result['text']		= "JSON MODE 값이 없습니다.";
	getJsonExit($result);	

?>