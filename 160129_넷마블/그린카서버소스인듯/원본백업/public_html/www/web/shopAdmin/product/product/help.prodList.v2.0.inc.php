<?

	## 클래스 설정
	$objProductListModule		= new ProductAdmListModule($db);

	## 상품리스트

	## 1. 상품리스트 페이지 라인 쿠키 설정
	if (!$_REQUEST['pageLine']){
		$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_PROD_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_PROD_LIST_LINE"] : 50;
	} else {
		setCookie("COOKIE_ADM_PROD_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
	}

	## 2. 검색 설정
	$param								= "";
	$param["P_LNG"]						= $strStLng;
	$strStLngLower						= strtolower($strStLng);

	## 2.1 검색어
	$strSearchField						= $_REQUEST['searchField'];
	$strSearchKey						= $_REQUEST['searchKey'];

	$param['P_SEARCH_FIELD']			= $strSearchField;
	$param['P_SEARCH_KEY']				= $strSearchKey;

	## 2.2 카테고리 검색
	$strSearchProdCate					= "";
	$strSearchProdCate1					= "";
	$strSearchProdCate2					= "";
	$strSearchProdCate3					= "";
	$strSearchProdCate4					= "";
	if($_REQUEST['searchCate1']) {  $param['P_CATE'] = $_REQUEST['searchCate1']; }
	if($_REQUEST['searchCate2']) {  $param['P_CATE'] = $_REQUEST['searchCate2']; }
	if($_REQUEST['searchCate3']) {  $param['P_CATE'] = $_REQUEST['searchCate3']; }
	if($_REQUEST['searchCate4']) {  $param['P_CATE'] = $_REQUEST['searchCate4']; }
	$strSearchProdCate					= $param['P_CATE'];
	if ($strSearchProdCate){
		$strSearchProdCate1				= substr($strSearchProdCate,0,3);
		$strSearchProdCate2				= (strlen($strSearchProdCate)>3) ? substr($strSearchProdCate,0,6) : "";
		$strSearchProdCate3				= (strlen($strSearchProdCate)>6) ? substr($strSearchProdCate,0,9) : "";
		$strSearchProdCate4				= (strlen($strSearchProdCate)>9) ? $strSearchProdCate : "";
	}

	## 2.3 상품출시일
	$strSearchLaunchStartDt				= $_REQUEST['searchLaunchStartDt'];
	$strSearchLaunchEndDt				= $_REQUEST['searchLaunchEndDt'];
	$param['P_LAUNCH_START_DT']			= $strSearchLaunchStartDt;
	$param['P_LAUNCH_END_DT']			= $strSearchLaunchEndDt;

	## 2.4 상품등록일
	$strSearchRegStartDt				= $_REQUEST['searchRegStartDt'];
	$strSearchRegEndDt					= $_REQUEST['searchRegEndDt'];
	$param['P_REP_START_DT']			= $strSearchRegStartDt;
	$param['P_REP_END_DT']				= $strSearchRegEndDt;

	## 2.5 브랜드
	$strSearchBrand						= $_REQUEST['searchBrand'];
	$param['P_BRAND']					= $strSearchBrand;

	## 2.6 상품출력
	$strSearchProdView					= $_REQUEST['searchProductView'];
	$param['P_VIEW']					= $strSearchProdView;

	## 2.7 메인진열관리/서브진열관리
	$param['P_ICON']					= "";
	$strSearchProdMainDisplay			= $_REQUEST['searchMainDisplay'];
	$arrSearchProdMainDisplay			= explode(",",$strSearchProdMainDisplay);
	if ($strSearchProdMainDisplay){
		foreach($arrSearchProdMainDisplay as $key => $data):
			$param['P_ICON'][] = $data;
		endforeach;
	}

	$strSearchProdSubDisplay			= $_REQUEST['searchSubDisplay'];
	$arrSearchProdSubnDisplay			= explode(",",$strSearchProdSubDisplay);
	if ($strSearchProdSubDisplay){
		foreach($arrSearchProdSubnDisplay as $key => $data):
			$param['P_ICON'][] = $data;
		endforeach;
	}

	## 2.8.1 입점사
	$strSearchShop						= $_REQUEST['searchShop'];
	if($a_admin_type == "S")											{ $param['P_SHOP_NO'] = $a_admin_shop_no;			}
	else if($a_admin_type != "S" && $_REQUEST['searchShop'])			{ $param['P_SHOP_NO'] = $strSearchShop;	}
	else if($a_admin_type != "S" && $_REQUEST['searchShop'] == "0")		{ $param['P_SHOP_NO'] = $strSearchShop;	}

	## 2.8.2 일반관리자로 로그인시 영업관리자이면 관리입점사가 있을 경우 관리 입점사만 보이게 처리
	if($a_admin_type == "A" && $a_admin_tm == "Y" && $a_admin_shop_list):
		$param['P_SHOP_NO_IN']			= $a_admin_shop_list;
	endif;

	## 2.9 입점몰일 경우 입점사 정보 쿼리 여부
	if( $S_MALL_TYPE == "M"):
		$param['P_SHOP_SITE_SHOW']		= "Y";
	endif;

	## 2.10 상품 출력(다국어)사용 여부
	if ($S_PROD_MANY_LANG_VIEW == "Y"){
		$param['P_MANY_LNG_VIEW']		= "Y";
	}

	//모든 언어별
	//$arrTopSiteUseLng = explode("/",$S_USE_LNG); 
	//$param['P_USE_LNG'] = $arrTopSiteUseLng;
	$param['P_USE_LNG'] = array($param["P_LNG"]);
	

	## 3. 총 검색 total/페이징
	$intPage							= $_REQUEST['page'];
	$intPageLine						= $_REQUEST['pageLine'];
	$intTotal							= $objProductListModule->getProductListSelectEx("OP_COUNT",$param);
//	echo $db->query;

	$intPageLine						= ( $intPageLine )			? $intPageLine	: 10;
	$intPage							= ( $intPage )				? $intPage		: 1;
	$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

	$intPageBlock						= 10;																		// 블럭 개수
	$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
	$intTotPage							= ceil( $intTotal / $intPageLine );


	## 4. 상품리스트 정렬
	$param['P_SEARCH_SORT']				= $_REQUEST['order'];

	if( $S_MALL_TYPE == "M"):
		$param['SHOP_SITE_JOIN']			= "Y";
	endif;
	
	$param['P_SEARCH_SORT']				= "TD";
	$param['P_IMG_SHOW']				= "Y";
	$param['LIMIT_LINE']				= $intPageLine;
	$param['LIMIT']						= $intFirst;
	$result								= $objProductListModule->getProductListSelectEx("OP_LIST",$param);
//	echo $db->query;


	## 5. 페이징 링크 주소
	$queryString	= explode("&", $_SERVER['QUERY_STRING']);
	$linkPage		= "";
	foreach($queryString as $string):
		list($key,$val)		= explode("=", $string);
		if($key == "page")	{ continue; }
		if($linkPage)		{ $linkPage .= "&"; }
		$linkPage		   .= $string;
	endforeach;
	$linkPage		= "./?{$linkPage}&page=";
?>