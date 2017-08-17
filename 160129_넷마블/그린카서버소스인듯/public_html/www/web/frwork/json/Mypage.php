<?
	require_once MALL_CONF_LIB."OrderMgr.php";

	$orderMgr = new OrderMgr();

	/* 비회원 주문정보 로그인 */
	$strSearchOrderKey		= $_POST["searchOrderKey"]		? $_POST["searchOrderKey"]		: $_REQUEST["searchOrderKey"];
	$strSearchOrderName		= $_POST["searchOrderName"]		? $_POST["searchOrderName"]		: $_REQUEST["searchOrderName"];

	switch ($strAct){

		case "buyNonList":

			$orderMgr->setSearchOrderKey($strSearchOrderKey);
			$orderMgr->setSearchOrderName($strSearchOrderName);

			$orderMgr->setSearchField($strSearchField);
			$orderMgr->setSearchKey($strSearchKey);
			
			$intTotal	= $orderMgr->getOrderTotal($db);
			
			$result[0]["RET"] = "N";
			if ($intTotal > 0){
				$result[0]["RET"] = "Y";
			} 
			
			$result_array = json_encode($result);
		break;

	}
	$db->disConnect();	
	echo $result_array;

	function rand_code($nc, $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
		 $l = strlen($a) - 1; $r = '';
		 while($nc-->0) $r .= $a{mt_rand(0,$l)};
		 return $r;
	}
?>