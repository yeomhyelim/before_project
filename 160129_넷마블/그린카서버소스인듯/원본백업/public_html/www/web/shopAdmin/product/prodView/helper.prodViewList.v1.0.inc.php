<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	$productMgr = new ProductAdmMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	
	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];

	$strSearchWebView		= $_POST["searchWebView"]			? $_POST["searchWebView"]			: $_REQUEST["searchWebView"];	
	$strSearchMobileView	= $_POST["searchMobileView"]		? $_POST["searchMobileView"]		: $_REQUEST["searchMobileView"];	
	/*##################################### Parameter 셋팅 #####################################*/


	## 상품 출력 리스트
	## 상품 리스트 소스와 같습니다. 함께 수정하세요.

	## product class 선언
//			require_once MALL_CONF_LIB."ProductAdmMgr.php";	
//			$productMgr = new ProductAdmMgr();	
	



	## 검색 조건
	$param								= "";
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

	## 상품출력(웹, 모바일)
	$param['P_WEB_VIEW']				= "";
	$param['P_MOB_VIEW']				= "";
	if($_REQUEST['searchProductView'] == "webYes")				{ $param['P_WEB_VIEW'] = "Y";		}
	else if($_REQUEST['searchProductView'] == "webNo")			{ $param['P_WEB_VIEW'] = "N";		}
	else if($_REQUEST['searchProductView'] == "mobileYes")		{ $param['P_MOB_VIEW'] = "Y";	}
	else if($_REQUEST['searchProductView'] == "mobileNo")		{ $param['P_MOB_VIEW'] = "N";	}
	else if($_REQUEST['searchProductView'] == "webMobileYes")	{ $param['P_WEB_VIEW'] = $param['P_MOB_VIEW'] = "Y"; }
	else if($_REQUEST['searchProductView'] == "webMobileNo")	{ $param['P_WEB_VIEW'] = $param['P_MOB_VIEW'] = "N"; }
	else if($_REQUEST['searchProductView'] == "webYesMobileNo")	{ $param['P_WEB_VIEW'] = "Y"; $param['P_MOB_VIEW'] = "N"; }

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
	if($a_admin_type == "S")											{ $param['P_SHOP_NO']= $a_admin_shop_no;			}
	else if($a_admin_type != "S" && $_REQUEST['searchShop'])			{ $param['P_SHOP_NO'] = $_REQUEST['searchShop'];	}
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
//			$param['ORDER_BY']					= $strSearchOrderSortCol;													// 정렬 컬럼
//			$param['ORDER_SORT']				= $strSearchOrderSort;														// 정렬 방법

	if( $S_MALL_TYPE == "M"):
	$param['SHOP_SITE_JOIN']			= "Y";
	endif;

	$param['PRODUCT_IMG_JOIN']			= "Y";
	$param['LIMIT']						= "{$intFirst},{$intPageLine}";
	$result								= $productMgr->getProdListEx($db, "OP_LIST", $param);
//			echo $db->query;
	$intPageBlock						= 10;																		// 블럭 개수 
	$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage							= ceil( $intTotal / $intPageLine );

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
//			echo $linkPage;
?>