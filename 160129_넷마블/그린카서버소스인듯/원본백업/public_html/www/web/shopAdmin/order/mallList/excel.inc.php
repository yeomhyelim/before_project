<?
	require_once MALL_CONF_LIB."ShopOrderMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$orderMgr = new ShopOrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();

	switch($strAct){
		case "excelOrderList":
		case "excelOrderList2":
		case "excelOrderMallList":
		case "excelOrderMallList2":

			if (!$_REQUEST['searchRegStartDt']) $_REQUEST['searchRegStartDt'] = date("Y-m-")."01";
			if (!$_REQUEST['searchRegEndDt']) $_REQUEST['searchRegEndDt'] = date("Y-m-d");

			$param									= "";
			$param['searchField']					= $_REQUEST['searchField'];
			$param['searchKey']						= $_REQUEST['searchKey'];
			$param['searchMemberType']				= $_REQUEST['searchMemberType'];
			$param['searchRegStartDt']				= $_REQUEST['searchRegStartDt'];
			$param['searchRegEndDt']				= $_REQUEST['searchRegEndDt'];
			$param['searchSettleType']				= $_REQUEST['searchSettleType'];
			$param['searchDeliveryCom']				= $_REQUEST['searchDeliveryCom'];
			$param['searchDeliveryStatus']			= $_REQUEST['searchDeliveryStatus'];
			
			$param['searchOrderStatus']				= $_REQUEST['searchOrderStatus'];
			$strSearchOrderStatus					= $_REQUEST['searchOrderStatus'];
			$param['searchOrderMemo']				= $_REQUEST['searchOrderMemo'];


			$strOrderInfoDisplayYN	= "Y"; //입점사이거나 영업사원이면서 관리몰이 있을 경우는 주문에 대한 상세정보를 알 수 없게 처리
			if ($a_admin_type == "S" && $a_admin_shop_no){
				$param['searchShopNo']	= $a_admin_shop_no;
				$strOrderInfoDisplayYN	= "N";
				$strOrderInfoShopNo		= $a_admin_shop_no;
			} else {
				if ($ADMIN_SHOP_SELECT_USE == "Y"){
					
					if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
						$param['searchShopNo'] = $_REQUEST['searchShop'];
					}
					
					if ($a_admin_tm == "Y" && $a_admin_shop_list) {
						/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
						$param['searchShopList'] = $a_admin_shop_list;
						$strOrderInfoDisplayYN	 = "N";
						$strOrderInfoShopNo		 = $a_admin_shop_list;
					}

					if ($_REQUEST['searchShop']  && $_REQUEST['searchShop'] != "undefined"){
						$param['searchShopList'] = "";
					}
				}
			}
			
			if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){

				## 회원소속관리 불러오기
				$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
				//include_once $fileName;
				//member.cate.inc.php 파일 자체가 아예 없음.
				if(is_file($fileName)):
					require_once "$fileName";
				endif;

				## 설정
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();

				## 소속 검색
				$strSearchNation						= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
				$strSearchCate1							= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
				$strSearchCate2							= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
				$strSearchCate3							= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
				$strSearchCate4							= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
				if($strSearchNation || $strSearchCate1 || $strSearchCate2 || $strSearchCate3 || $strSearchCate4):
					
					## 검색 카테고리 설정
					$cateCode				= "";
					if($strSearchCate1) { $cateCode = $strSearchCate1; }
					if($strSearchCate2) { $cateCode = $strSearchCate2; }
					if($strSearchCate3) { $cateCode = $strSearchCate3; }
					if($strSearchCate4) { $cateCode = $strSearchCate4; }

					## 데이터
//					$param								= "";
					$param['MEMBER_CATE_MGR_JOIN']		= "Y";
					$param['searchMemberNation']		= $strSearchNation;
					$param['M_CATE']					= $cateCode;
				
				elseif ($a_admin_level > 0): 
				
					## 차수별 회원 소속 설정
					$param2								= "";
					$param2['C_CODE_COLUMN_ARYLIST']	= "Y";
					$param2['M_NO']						= $a_admin_no;
					$cateCode							= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param2);
					
					$param['M_CATE']					= $cateCode;
				endif;
			}

			$intTotal								= $orderMgr->getOrderListEx($db, "OP_COUNT", $param);							// 데이터 전체 개수 
			$intPageLine							= 10;																			// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

			$param['order_by']						= "A.O_NO DESC";
			$orderListResult						= $orderMgr->getOrderListEx($db, "OP_LIST", $param);

			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );

			## STEP 3.
			## 페이징 링크 주소			
			$aryDeliveryCom = getCommCodeList("DELIVERY");
			$siteRow = $siteMgr->getSiteInfo($db);

			/*배송회사*/
			$aryDeliveryComAll = getCommCodeList("DELIVERY","Y");

			/*국가/주*/
			$aryCountryList		= getCountryList();			
			$aryCountryState	= getCommCodeList("STATE","");

			## 추가로 작업을 해야 하는 부분
			##		-> 주문시, 배송비가 DB에 등록되지 않음.

			## 배송비 지급 타입 설정
			$deliveryType[1]		= $LNG_TRANS_CHAR["OW00129"]; //"선불"
			$deliveryType[2]		= $LNG_TRANS_CHAR["OW00130"]; //"후불"

			## 설정
			## 배송회사 리스트
			$aryDeliveryCom		= "";
			$temp				= explode(",", $S_DELIVERY_KR_COM);
			foreach($temp as $key):
				$aryDeliveryCom[$key] = $aryDeliveryComAll[$key];
			endforeach;

			## 금액 표시
			$moneyMarkL		= getCurMark($S_ST_CUR);
			$moneyMarkR		= getCurMark2($S_ST_CUR);

			$aryBank1 = getCommCodeList("BANK"); //입금은행
			$aryBank2 = getCommCodeList("BANK2"); //가상계좌은행

			$arySiteSettleBank = explode("/",$S_BANK);

			$strExcelFileName					= iconv("utf-8","euc-kr",date("Ymd")."_주문리스트");

		break;

	}
?>