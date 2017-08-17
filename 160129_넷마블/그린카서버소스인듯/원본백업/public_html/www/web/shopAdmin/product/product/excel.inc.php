<?
//	require_once MALL_CONF_LIB."CateMgr.php";
//	require_once MALL_CONF_LIB."ProductAdmMgr.php";
//	
//	$cateMgr = new CateMgr();		
//	$productMgr = new ProductAdmMgr();		

	switch($strAct){
		case "excelProdList":
			// 상품리스트 엑셀 파일로 저장

			## product class 선언
			require_once MALL_CONF_LIB."ProductAdmMgr.php";	
			$productMgr = new ProductAdmMgr();	
			
			## 검색 조건
			$param['searchField']				= $_REQUEST['searchField'];
			$param['searchKey']					= $_REQUEST['searchKey'];

			## 카테고리
			if($_REQUEST['searchCate1']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate1']; }
			if($_REQUEST['searchCate2']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate2']; }
			if($_REQUEST['searchCate3']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate3']; }
			if($_REQUEST['searchCate4']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate4']; }

			## 상품출시일
			$startDt							= $_REQUEST['searchLaunchStartDt'];
			$endDt								= $_REQUEST['searchLaunchEndDt'];
			if($startDt || $endDt):
				if(!$startDt)	{ $startDt		= "1900-01-01"; }
				if(!$endDt)		{ $endDt		= "2200-01-01"; }
			endif;
			$param['P_LAUNCH_DT_BETWEEN'][0]	= $startDt;
			$param['P_LAUNCH_DT_BETWEEN'][1]	= $endDt;

			## 상품등록일
			$startDt							= $_REQUEST['searchRegStartDt'];
			$endDt								= $_REQUEST['searchRegEndDt'];
			if($startDt || $endDt):
				if(!$startDt)	{ $startDt		= "1900-01-01"; }
				if(!$endDt)		{ $endDt		= "2200-01-01"; }
			endif;
			$param['P_REP_DT_BETWEEN'][0]		= $startDt;
			$param['P_REP_DT_BETWEEN'][1]		= $endDt;

			## 브랜드
			$param['P_BRAND']					= $_REQUEST['searchBrand'];

//			## 상품출력(웹)
//			$param['P_WEB_VIEW']				= $_REQUEST['searchWebView'];
//
//			## 상품출력(모바일)
//			$param['P_MOB_VIEW']				= $_REQUEST['searchMobileView'];
//			
//			if($param['P_WEB_VIEW'] && $param['P_MOB_VIEW']):
//				$param['P_WEB_VIEW'] = "";
//				$param['P_MOB_VIEW'] = "";
//			endif;

			## 상품출력(웹, 모바일)
			$param['P_WEB_VIEW']				= "";
			$param['P_MOB_VIEW']				= "";
			if($_REQUEST['searchProductView'] == "webYes")				{ $param['P_WEB_VIEW'] = "Y";		}
			else if($_REQUEST['searchProductView'] == "webNo")			{ $param['P_WEB_VIEW'] = "N";		}
			else if($_REQUEST['searchProductView'] == "mobileYes")		{ $param['P_MOBILE_VIEW'] = "Y";	}
			else if($_REQUEST['searchProductView'] == "mobileNo")		{ $param['P_MOBILE_VIEW'] = "N";	}
			else if($_REQUEST['searchProductView'] == "webMobileYes")	{ $param['P_WEB_VIEW'] = $param['P_MOBILE_VIEW'] = "Y"; }
			else if($_REQUEST['searchProductView'] == "webMobileNo")	{ $param['P_WEB_VIEW'] = $param['P_MOBILE_VIEW'] = "N"; }

			## 메인전열관리
			if($_REQUEST['searchMainDisplay']):
				$aryTemp	= explode(",", $_REQUEST['searchMainDisplay']);
				foreach($aryTemp as $key => $data):
					$param['P_ICON'][] = $data;
				endforeach;
			endif;

			## 서브전열관리
			if($_REQUEST['searchSubDisplay']):
				$aryTemp	= explode(",", $_REQUEST['searchSubDisplay']);
				foreach($aryTemp as $key => $data):
					$param['P_ICON'][] = $data + 5;
				endforeach;
			endif;

			## 입점사			
			if($a_admin_type == "S")									{ $param['P_SHOP_NO']= $a_admin_shop_no;			}
			else if($a_admin_type != "S" && $_REQUEST['searchShop'])	{ $param['P_SHOP_NO'] = $_REQUEST['searchShop'];	}
			else if($a_admin_type != "S" && $_REQUEST['searchShop'] == "0")		{ $param['P_SHOP_NO'] = $_REQUEST['searchShop'];	}

			## 리스트
			$param['PRODUCT_INFO_LNG_JOIN']		= $strStLng;
			$intPage							= $_REQUEST['page'];
			$intTotal							= $productMgr->getProdListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수

			$intPageLine						= $_REQUEST['pageLine'];
			$intPageLine						= ( $intPageLine )			? $intPageLine	: 10;							// 리스트 개수 
			$intPage							= ( $intPage )				? $intPage		: 1;
			$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );


			$param['ORDER_BY']					= $_GET['order'];
//			$param['ORDER_BY']					= "P.P_CODE DESC";
			
			if($S_MALL_TYPE == "M"):
				$param['SHOP_SITE_JOIN']		= "Y";
			endif;

			$param['PRODUCT_IMG_JOIN']			= "Y";
//			$param['LIMIT']						= "2,10";
			$result								= $productMgr->getProdListEx($db, "OP_LIST", $param);
//			echo $db->query;
			$intPageBlock						= 10;																		// 블럭 개수 
			$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage							= ceil( $intTotal / $intPageLine );

			$dateYMD			= date("Ymd");
			$strExcelFileName	= "{$dateYMD}_상품리스트.xls"; 

		break;

// 2013.09.04 kim hee sung 검색 부분 추가
//		case "excelProdList":
//			// 상품리스트 엑셀 파일로 저장
//
//			## 선언
//			require_once MALL_CONF_LIB."ProductAdmMgr.php";
//			$productMgr					= new ProductAdmMgr();		
//
//			## 언어 컬럼 사용 유무
//			$productInfoLngColumnList				= "";
//			if($_REQUEST['lang']) { $productInfoLngColumnList = "Y"; }
//
//			## 상품리스트
//			$param									= "";
//			$param['PRODUCT_INFO_LNG_COLUMN_LIST']	= $productInfoLngColumnList;
//			$param['PRODUCT_INFO_LNG_JOIN']			= $_REQUEST['lang'];
//			$param['ORDER_BY']						= "P.P_CODE DESC";
//
//			if ($a_admin_type == "S") $param['P_SHOP_NO'] = $a_admin_shop_no;
//
//			$intTotal								= $productMgr->getProdListEx($db, "OP_COUNT", $param);
//			$prodListResult							= $productMgr->getProdListEx($db, "OP_LIST", $param);
//
//			$dateYMD			= date("Ymd");
//			$strExcelFileName	= "{$dateYMD}_상품리스트.xls"; 
//		break;

// 2013.08.09 kim hee sung 소스 정리
//		case "excelProdList":
//			/* 검색부분 */
//			if ($a_admin_level == "3"){
//				$strSearchSiteBrand = $a_admin_brand_no;
//			}
//
//			/* 검색부분 */
//			$productMgr->setSearchHCode1($strSearchHCode1);
//			$productMgr->setSearchHCode2($strSearchHCode2);
//			$productMgr->setSearchHCode3($strSearchHCode3);
//			$productMgr->setSearchHCode4($strSearchHCode4);
//
//			$productMgr->setSearchField($strSearchField);
//			$productMgr->setSearchKey($strSearchKey);
//			$productMgr->setSearchLaunchStartDt($strSearchLaunchStartDt);
//			$productMgr->setSearchLaunchEndDt($strSearchLaunchEndDt);
//			$productMgr->setSearchRepStartDt($strSearchRepStartDt);
//			$productMgr->setSearchRepEndDt($strSearchRepEndDt);
//			$productMgr->setSearchWebView($strSearchWebView);
//			$productMgr->setSearchMobileView($strSearchMobileView);
////			$productMgr->setSearchSiteBrand($strSearchSiteBrand);
////			$productMgr->setSearchPrice($strSearchPrice);
//
//			$productMgr->setSearchIcon1($strSearchIcon1);
//			$productMgr->setSearchIcon2($strSearchIcon2);
//			$productMgr->setSearchIcon3($strSearchIcon3);
//			$productMgr->setSearchIcon4($strSearchIcon4);
//			$productMgr->setSearchIcon5($strSearchIcon5);
//			$productMgr->setSearchIcon6($strSearchIcon6);
//			$productMgr->setSearchIcon7($strSearchIcon7);
//			$productMgr->setSearchIcon8($strSearchIcon8);
//			$productMgr->setSearchIcon9($strSearchIcon9);
//			$productMgr->setSearchIcon10($strSearchIcon10);
//			$productMgr->setSearchProdBrand($strSearchProdBrand);
//
//			if ($a_admin_type == "S") $productMgr->setSearchShopNo($a_admin_shop_no);
//			else $productMgr->setSearchShopNo($strSearchShopNo);
//
//			/* 검색부분 */
//
//			$intTotal	= $productMgr->getProdTotal($db);
//			$productMgr->setPageLine($intTotal);
//			$productMgr->setLimitFirst(0);
//			$result = $productMgr->getProdList($db);
//			
//
//			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_상품목록");
//
//		break;

	}

?>