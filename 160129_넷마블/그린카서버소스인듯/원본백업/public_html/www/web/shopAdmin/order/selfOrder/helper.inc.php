<?
	require_once MALL_CONF_LIB."OrderHandAddrAdmMgr.php";
	require_once MALL_CONF_LIB."OrderAdmMgr.php";

	$orderHandAddrMgr		= new OrderHandAddrAdmMgr();
	$orderMgr				= new OrderMgr();


	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchDay				= $_POST["searchDay"]				? $_POST["searchDay"]				: $_REQUEST["searchDay"];
	$intPage					= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];
	$intPageLine				= $_POST["pageLine"]				? $_POST["pageLine"]				: $_REQUEST["pageLine"];

	$intHA_NO				= $_POST["ha_no"]						? $_POST["ha_no"]					: $_REQUEST["ha_no"];
	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strMode):
		case "addressWrite":
			// 주소록 쓰기

			/* 주소록 그룹 리스트 */
			$aryOrderHandAddrGrpList				= $orderHandAddrMgr->getOrderHandAddrGrpList( $db, "OP_ARYTOTAL" );					

		break;
		case "addressList":
			// 주소록 관리

			/* 데이터 리스트 */
			$intTotal								= $orderHandAddrMgr->getOrderHandAddrList( $db, "OP_COUNT" );						// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
			$orderHandAddrMgr->setLimitFirst( $intFirst );
			$orderHandAddrMgr->setPageLine( $intPageLine );
			

			$orderHandAddrResult			= $orderHandAddrMgr->getOrderHandAddrList( $db );	

			$intPageBlock					= 10;																// 블럭 개수 
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );					// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&page=";
		break;

		case "addressModify":
			// 주소록 수정

			/* 주소록 수정 데이터 */
			$orderHandAddrRow						= $orderHandAddrMgr->getOrderHandAddrList( $db, "OP_SELECT" );
			if($orderHandAddrRow):
				$orderHandAddrRow['HA_ZIP']			= explode("-", $orderHandAddrRow['HA_ZIP']);
				$orderHandAddrRow['HA_EMAIL']		= explode("@", $orderHandAddrRow['HA_EMAIL']);
				$orderHandAddrRow['HA_PHONE1']		= explode("-", $orderHandAddrRow['HA_PHONE1']);
				$orderHandAddrRow['HA_PHONE2']		= explode("-", $orderHandAddrRow['HA_PHONE2']);
			endif;

			/* 주소록 그룹 리스트 */
			$aryOrderHandAddrGrpList				= $orderHandAddrMgr->getOrderHandAddrGrpList( $db, "OP_ARYTOTAL" );	
		break;

		case "addressDelete":
			// 주소록 삭제
			$orderHandAddrRow						= $orderHandAddrMgr->getOrderHandAddrDelete( $db );
		break;
		
		case "selfOrderWrite":
			// 수기주문 등록

			/* 무통장 입금시 입금은행 */
			$arySiteSettleBank = explode("/",$S_BANK);
		break;

		case "selfOrderList":
			// 수기주문목록
			
			$orderMgr->setO_SELF_WRITE("Y");

			/* 데이터 리스트 */
			$intTotal								= $orderMgr->getOrderTotal( $db );													// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
			$orderMgr->setLimitFirst( $intFirst );
			$orderMgr->setPageLine( $intPageLine );
			

			$orderListResult				= $orderMgr->getOrderList( $db );	

			$intPageBlock					= 10;																// 블럭 개수 
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );					// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&page=";
		break;
	endswitch;
?>