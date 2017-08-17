<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	$productMgr = new ProductAdmMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchDay				= $_POST["searchDay"]				? $_POST["searchDay"]				: $_REQUEST["searchDay"];

	$strSearchOrderStatus		= $_POST["searchOrderStatus"]		? $_POST["searchOrderStatus"]		: $_REQUEST["searchOrderStatus"];
	$strSearchSettleType		= $_POST["searchSettleType"]		? $_POST["searchSettleType"]		: $_REQUEST["searchSettleType"];			// 결제방법
	$strSearchMemberType		= $_POST["searchMemberType"]		? $_POST["searchMemberType"]		: $_REQUEST["searchMemberType"];			// 회원구분(전체, 회원, 비회원)
	$strSearchDeliveryCom		= $_POST["searchDeliveryCom"]		? $_POST["searchDeliveryCom"]		: $_REQUEST["searchDeliveryCom"];			// 택배회사
	$strSearchDeliveryStatus	= $_POST["searchDeliveryStatus"]	? $_POST["searchDeliveryStatus"]	: $_REQUEST["searchDeliveryStatus"];		// 택배회사

	
	$strSearchRegStartDt		= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt			= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchSettleType		= $_POST["searchSettleType"]	? $_POST["searchSettleType"]	: $_REQUEST["searchSettleType"];
	
	$intPage					= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	/*##################################### Parameter 셋팅 #####################################*/


	switch($strMode){
		case "deliveryFastInput":
		case "deliveryList":
			
			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$_REQUEST['pageLine']){
				$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_ORDER_DELIVERY_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_ORDER_DELIVERY_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_ORDER_DELIVERY_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */		
		
			// 빠른송장입력
			// 2013.06.24 kim hee sung 빠른송장입력, 입점몰 버전
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */

			switch($strMode){
				case "deliveryList":
					switch($_REQUEST['searchOrderStatus']){
						case "I":
							$strMenuTitle		= "배송중목록"; 
						break;
						case "D":
							$strMenuTitle		= "배송완료목록"; 
						break;
						default:
							$strMenuTitle		= "송장입력목록"; 
						break;
					}
					
				break;
				case "deliveryFastInput":
					$strMenuTitle		= "배송준비중목록";
				break;
				default:
					$strMenuTitle		= "배송준비중목록";
				break;
			}


			## STEP 1.
			## 선언
			require_once MALL_CONF_LIB."ShopOrderMgr.php";
			$shopOrderMgr = new ShopOrderMgr();

			## STEP 2.
			## 배송 리스트
			$intPage								= $_REQUEST['page'];
			$param['searchField']					= $_REQUEST['searchField'];
			$param['searchKey']						= $_REQUEST['searchKey'];
			$param['searchMemberType']				= $_REQUEST['searchMemberType'];
			$param['searchRegStartDt']				= $_REQUEST['searchRegStartDt'];
			$param['searchRegEndDt']				= $_REQUEST['searchRegEndDt'];
			$param['searchSettleType']				= $_REQUEST['searchSettleType'];
			$param['searchDeliveryCom']				= $_REQUEST['searchDeliveryCom'];
			$param['searchDeliveryStatus']			= $_REQUEST['searchDeliveryStatus'];
			$param['o_status']						= "A,B,I,D,E";
			
			$param['so_delivery_status_in']			= "B";
			$param['so_delivery_status_null']		= "Y";
			$param['so_order_status_in']			= "J,A";
			$param['so_order_status_null']			= "Y";

			if($_SESSION['ADMIN_TYPE'] == "S"):
				// 입점몰인 경우
				$param['sh_no']						= $_SESSION['ADMIN_SHOP_NO'];
				if(!$param['sh_no']):
					echo "입점몰 정보가 없습니다.";
					exit;
				endif;
			endif;

			$strOrderInfoDisplayYN					= "Y"; //입점사이거나 영업사원이면서 관리몰이 있을 경우는 주문에 대한 상세정보를 알 수 없게 처리
			if ($a_admin_type == "S" && $a_admin_shop_no){
				$param['sh_no']	= $a_admin_shop_no;
				$strOrderInfoDisplayYN	= "N";
				$strOrderInfoShopNo		= $a_admin_shop_no;
			} else {
				if ($ADMIN_SHOP_SELECT_USE == "Y"){
					
					if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
						$param['sh_no'] = $_REQUEST['searchShop'];
					}
					
					if ($a_admin_tm == "Y" && $a_admin_shop_list) {
						/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
						$param['sh_no'] = $a_admin_shop_list;
						$strOrderInfoDisplayYN	 = "N";
						$strOrderInfoShopNo		 = $a_admin_shop_list;
					}
				}
			}

			/** 2013.06.26 kim hee sung 배송중목록,배송완료목록을 위한 변수, 단, 추구 변수값 변경이 필요함 **/
			if($_REQUEST['searchOrderStatus']):
				$param['o_status']				= "";
				$param['so_delivery_status_in'] = $_REQUEST['searchOrderStatus'];
			endif;

			$intTotal								= $shopOrderMgr->getDeliveryListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수

//			echo $db->query;
//			echo "<br>";
			
			$intPageLine							= $_REQUEST['pageLine'] ? $_REQUEST['pageLine'] : 50; //리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

			$param['order_by']						= "A.O_NO DESC";
			$param['limit']							= "{$intFirst},{$intPageLine}";
			$deliveryResult							= $shopOrderMgr->getDeliveryListEx($db, "OP_LIST", $param);
//			echo $db->query;

			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			
			## STEP 3.
			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);
			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;
			$linkPage		= "./?{$linkPage}&page=";

			break;
		break;

	}
?>