<?
	require_once MALL_CONF_LIB."ShopOrderNewMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$shopOrderMgr = new ShopOrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	
	$siteRow = $siteMgr->getSiteInfo($db);
	switch($strAct){
		case "excelOrderList":
			
			if ($S_FIX_MEMBER_CATE_USE_YN  == "Y")
			{		
				## 회원소속관리 불러오기
				$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
				//include_once $fileName;
				//member.cate.inc.php 파일 자체가 아예 없음.
				if(is_file($fileName)):
					require_once "$fileName";
				endif;
			}

			## STEP 1.
			## 선언
			if (!$_REQUEST['searchRegStartDt'] && $_REQUEST["searchYN"] != "Y") {
				$_REQUEST['searchRegStartDt'] = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
			}

			if (!$_REQUEST['searchRegEndDt'] && $_REQUEST["searchYN"] != "Y") {
				$_REQUEST['searchRegEndDt'] = date("Y-m-d");
			}

			## 소속 국가 설정
			$strSearchNation						= $_REQUEST['searchNation'];

			## STEP 2.
			## 주문 리스트
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
			if (!$param['searchOrderStatus'] && in_array($param['searchDeliveryStatus'],array('B','I','D'))){
				$param['searchOrderStatus']			= $param['searchDeliveryStatus'];
			}

			$param['searchOrderMemo']				= $_REQUEST['searchOrderMemo'];

			## 입점사 검색
			if ($a_admin_type == "S" && $a_admin_shop_no){
				$param['searchShopNo']		= $a_admin_shop_no;
			} else {
				if ($S_MALL_TYPE != "R")
				{
					if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
						$param['searchShopNo'] = $_REQUEST['searchShop'];
					}
					
					## 영업사용/관리 입점몰 사용여부
					if ($ADMIN_SHOP_SELECT_USE == "Y")
					{
						if ($a_admin_tm == "Y" && $a_admin_shop_list) {
							/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
							$param['searchShopList'] = $a_admin_shop_list;
						}

						if ($_REQUEST['searchShop']  && $_REQUEST['searchShop'] != "undefined"){
							$param['searchShopList'] = "";
						}
					}
				}
			}
			
			## 소속 검색
			if ($S_FIX_MEMBER_CATE_USE_YN  == "Y")
			{
				## 설정
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();
				
				$strSearchNation						= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
				$strSearchCate1							= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
				$strSearchCate2							= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
				$strSearchCate3							= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
				$strSearchCate4							= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
				
				if($strSearchNation || $strSearchCate1 || $strSearchCate2 || $strSearchCate3 || $strSearchCate4):
					
					## 검색 카테고리 설정
					$strSearchCateCode	= "";
					if($strSearchCate1) { $strSearchCateCode = $strSearchCate1; }
					if($strSearchCate2) { $strSearchCateCode = $strSearchCate2; }
					if($strSearchCate3) { $strSearchCateCode = $strSearchCate3; }
					if($strSearchCate4) { $strSearchCateCode = $strSearchCate4; }
				endif;

				if ($a_admin_level > 0): 
				
					$param2								= "";
					$param2['C_CODE_COLUMN_ARYLIST']	= "Y";
					$param2['M_NO']						= $a_admin_no;
					$arrSearchMemberCate				= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param2);
				
				endif;
			}
			
			$param['searchMemberCate']				= $strSearchCateCode;
			$param['searchMemberNation']			= $strSearchNation;
			$param['searchMemberCateList']			= $arrSearchMemberCate;
		
			$param['order_by']						= "O.O_NO DESC";
			$orderListResult						= $shopOrderMgr->getOrderListEx($db, "OP_LIST", $param);
			/*배송회사*/
			$aryDeliveryComAll  = getCommCodeList("DELIVERY","Y");
			
			/*입금은행*/
			$arySiteSettleBank = explode("/",$S_BANK);
			$aryBank1			= getCommCodeList("BANK"); //입금은행
			$aryBank2			= getCommCodeList("BANK2"); //가상계좌은행

			$strExcelFileName						= iconv("utf-8","euc-kr",date("Ymd")."_주문리스트");

	
		break;
	}

?>