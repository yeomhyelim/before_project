<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$productMgr = new ProductAdmMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField			= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];
	$intPageLine			= $_POST["pageLine"]				? $_POST["pageLine"]				: $_REQUEST["pageLine"];
	
	$strP_CODE				= $_POST["prodCode"]				? $_POST["prodCode"]				: $_REQUEST["prodCode"];

	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];

	$strSearchStock1		= $_POST["searchStock1"]			? $_POST["searchStock1"]			: $_REQUEST["searchStock1"];
	$strSearchStock2		= $_POST["searchStock2"]			? $_POST["searchStock2"]			: $_REQUEST["searchStock2"];
	$strSearchStock3		= $_POST["searchStock3"]			? $_POST["searchStock3"]			: $_REQUEST["searchStock3"];
	/*##################################### Parameter 셋팅 #####################################*/	
			
	## 언어 설정
	$lang				= strtolower($strStLng);

	## 카테고리 불러오기
	$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/category.{$lang}.inc.php";
	include_once $fileName;

	## 기본 설정
	$param								= "";
	$strAdminType						= $_SESSION['ADMIN_TYPE'];
	$strAdminTm							= $_SESSION['ADMIN_TM'];
	$strAdminShopList					= $_SESSION['ADMIN_SHOP_LIST'];

	## 검색 조건
	$param['searchField']				= $_REQUEST['searchField'];
	$param['searchKey']					= $_REQUEST['searchKey'];

	## 카테고리
//			if($_REQUEST['searchCate1']) {  $strSearchHCode1 = $_REQUEST['searchCate1']; }
//			if($_REQUEST['searchCate2']) {  $strSearchHCode2 = $_REQUEST['searchCate2']; }
//			if($_REQUEST['searchCate3']) {  $strSearchHCode3 = $_REQUEST['searchCate3']; }
//			if($_REQUEST['searchCate4']) {  $strSearchHCode4 = $_REQUEST['searchCate4']; }
//			
//			if($_REQUEST['searchCate1'] || $_REQUEST['searchCate2'] || $_REQUEST['searchCate3'] || $_REQUEST['searchCate4']){  
//				$param['P_CATE_LIKE'] = $_REQUEST['searchCate1'].$_REQUEST['searchCate2'].$_REQUEST['searchCate3'].$_REQUEST['searchCate4']; 
//			}
//			
	## 카테고리
	if($_REQUEST['searchCate1']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate1']; }
	if($_REQUEST['searchCate2']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate2']; }
	if($_REQUEST['searchCate3']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate3']; }
	if($_REQUEST['searchCate4']) {  $param['P_CATE_LIKE'] = $_REQUEST['searchCate4']; }
	## 입점사
	if($a_admin_type == "S")											{ $param['P_SHOP_NO']= $a_admin_shop_no;			}
	else if($a_admin_type != "S" && $_REQUEST['searchShop'])			{ $param['P_SHOP_NO'] = $_REQUEST['searchShop'];	}
	else if($a_admin_type != "S" && $_REQUEST['searchShop'] == "0")		{ $param['P_SHOP_NO'] = $_REQUEST['searchShop'];	}

	## 관리자 로그인, 영업사원, 관리 입점사가 있는 경우 관리 입점사만 출력한다.
	if($strAdminType == "A" && $strAdminTm == "Y" && $strAdminShopList):
		$param['P_SHOP_NO_IN']			= $strAdminShopList;
	endif;
	
	## 재고품절
	$param['searchStock1']				= $_REQUEST['searchStock1'];
	
	## 재고재입고
	$param['searchStock2']				= $_REQUEST['searchStock2'];

	## 재고무제한
	$param['searchStock3']				= $_REQUEST['searchStock3'];

	## 상품출력(웹, 모바일)
	$param['P_WEB_VIEW']				= "";
	$param['P_MOB_VIEW']				= "";
	if($_REQUEST['searchProductView'] == "webYes")				{ $param['P_WEB_VIEW'] = "Y";		}
	else if($_REQUEST['searchProductView'] == "webNo")			{ $param['P_WEB_VIEW'] = "N";		}
	else if($_REQUEST['searchProductView'] == "mobileYes")		{ $param['P_MOBILE_VIEW'] = "Y";	}
	else if($_REQUEST['searchProductView'] == "mobileNo")		{ $param['P_MOBILE_VIEW'] = "N";	}
	else if($_REQUEST['searchProductView'] == "webMobileYes")	{ $param['P_WEB_VIEW'] = $param['P_MOBILE_VIEW'] = "Y"; }
	else if($_REQUEST['searchProductView'] == "webMobileNo")	{ $param['P_WEB_VIEW'] = $param['P_MOBILE_VIEW'] = "N"; }

	## 리스트
	$param['PRODUCT_INFO_LNG_JOIN']		= $strStLng;
	$intPage							= $_REQUEST['page'];
	$intTotal							= $productMgr->getProdListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수
//			echo $db->query;
	$intPageLine						= $_REQUEST['pageLine'];
	$intPageLine						= ( $intPageLine )			? $intPageLine	: 10;							// 리스트 개수 
	$intPage							= ( $intPage )				? $intPage		: 1;
	$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$param['ORDER_BY']					= $_GET['order'];
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

	## 입점사 사용 유무
	$bShopUse				= false;
	if($a_admin_type == "A" && $S_MALL_TYPE == "M"):
		$bShopUse			= true;
	endif;

	## 관리자 로그인, 영업사원, 관리 입점사가 있는 경우 관리 입점사만 출력한다.
	$aryShopList						= "";
	if($strAdminType == "A" && $strAdminTm == "Y" && $strAdminShopList):
		$aryShopList					= $strAdminShopList;
	endif;

	## 입점업체 리스트 
	$param								= "";
	$param['SHOP_LIST']					= $aryShopList;
	if($bShopUse):
		$aryShopList					= $productMgr->getShopList($db,$param);
	endif;



?>