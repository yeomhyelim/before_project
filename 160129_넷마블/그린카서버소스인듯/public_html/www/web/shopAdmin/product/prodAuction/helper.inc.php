<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";

	require_once "../conf/site_skin_product.conf.inc.php";
	require_once "../conf/category.inc.php";

	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	$siteMgr = new SiteMgr();		
	$memberMgr = new MemberMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	$intPM_NO		= $_POST["prodImgNo"]		? $_POST["prodImgNo"]		: $_REQUEST["prodImgNo"];
	
	$strSearchHCode1		= $_POST["searchCate1"]				? $_POST["searchCate1"]				: $_REQUEST["searchCate1"];
	$strSearchHCode2		= $_POST["searchCate2"]				? $_POST["searchCate2"]				: $_REQUEST["searchCate2"];
	$strSearchHCode3		= $_POST["searchCate3"]				? $_POST["searchCate3"]				: $_REQUEST["searchCate3"];
	$strSearchHCode4		= $_POST["searchCate4"]				? $_POST["searchCate4"]				: $_REQUEST["searchCate4"];
	$strSearchLaunchStartDt = $_POST["searchLaunchStartDt"]		? $_POST["searchLaunchStartDt"]		: $_REQUEST["searchLaunchStartDt"];
	$strSearchLaunchEndDt	= $_POST["searchLaunchEndDt"]		? $_POST["searchLaunchEndDt"]		: $_REQUEST["searchLaunchEndDt"];
	$strSearchRepStartDt	= $_POST["searchRepStartDt"]		? $_POST["searchRepStartDt"]		: $_REQUEST["searchRepStartDt"];
	$strSearchRepEndDt		= $_POST["searchRepEndDt"]			? $_POST["searchRepEndDt"]			: $_REQUEST["searchRepEndDt"];
	$strSearchWebView		= $_POST["searchWebView"]			? $_POST["searchWebView"]			: $_REQUEST["searchWebView"];	
	$strSearchMobileView	= $_POST["searchMobileView"]		? $_POST["searchMobileView"]		: $_REQUEST["searchMobileView"];	
	
	$strSearchIcon1			= $_POST["searchIcon1"]				? $_POST["searchIcon1"]				: $_REQUEST["searchIcon1"];	
	$strSearchIcon2			= $_POST["searchIcon2"]				? $_POST["searchIcon2"]				: $_REQUEST["searchIcon2"];	
	$strSearchIcon3			= $_POST["searchIcon3"]				? $_POST["searchIcon3"]				: $_REQUEST["searchIcon3"];	
	$strSearchIcon4			= $_POST["searchIcon4"]				? $_POST["searchIcon4"]				: $_REQUEST["searchIcon4"];	
	$strSearchIcon5			= $_POST["searchIcon5"]				? $_POST["searchIcon5"]				: $_REQUEST["searchIcon5"];	
	$strSearchIcon6			= $_POST["searchIcon6"]				? $_POST["searchIcon6"]				: $_REQUEST["searchIcon6"];	
	$strSearchIcon7			= $_POST["searchIcon7"]				? $_POST["searchIcon7"]				: $_REQUEST["searchIcon7"];	
	$strSearchIcon8			= $_POST["searchIcon8"]				? $_POST["searchIcon8"]				: $_REQUEST["searchIcon8"];	
	$strSearchIcon9			= $_POST["searchIcon9"]				? $_POST["searchIcon9"]				: $_REQUEST["searchIcon9"];	
	$strSearchIcon10		= $_POST["searchIcon10"]			? $_POST["searchIcon10"]			: $_REQUEST["searchIcon10"];	
	
	$strSearchShopNo		= $_POST["searchShopNo"]			? $_POST["searchShopNo"]			: $_REQUEST["searchShopNo"];	

	$strC_HCODE1			= $_POST["cateHCode1"]				? $_POST["cateHCode1"]				: $_REQUEST["cateHCode1"];
	$strC_HCODE2			= $_POST["cateHCode2"]				? $_POST["cateHCode2"]				: $_REQUEST["cateHCode2"];
	$strC_HCODE3			= $_POST["cateHCode3"]				? $_POST["cateHCode3"]				: $_REQUEST["cateHCode3"];
	$strC_HCODE4			= $_POST["cateHCode4"]				? $_POST["cateHCode4"]				: $_REQUEST["cateHCode4"];

	// 2013.07.15 브랜드 검색 추가
	$strSearchProdBrand		= $_POST["searchProdBrand"]			? $_POST["searchProdBrand"]			: $_REQUEST["searchProdBrand"];


	if ($strSearchShopNo == "") $strSearchShopNo = "-1"; 

	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "prodAuctionList":
			
			## 클래스 설정
			$objProductListModule				= new ProductAdmListModule($db);
			
			## 상품리스트

			## 1. 상품리스트 페이지 라인 쿠키 설정
			if (!$_REQUEST['pageLine']){
				$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_PROD_AUCTION_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_PROD_AUCTION_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_PROD_AUCTION_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
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
			
			## 2.3 상품등록일
			$strSearchRegStartDt				= $_REQUEST['searchRegStartDt'];
			$strSearchRegEndDt					= $_REQUEST['searchRegEndDt'];
			$param['P_REP_START_DT']			= $strSearchRegStartDt;
			$param['P_REP_END_DT']				= $strSearchRegEndDt;
			
			## 2.4 상품출력
			$strSearchProdView					= $_REQUEST['searchProductView'];
			$param['P_VIEW']					= $strSearchProdView;
		
			## 2.5 경매기간
			$strSearchAucStartDt				= $_REQUEST['searchAucStartDt'];
			$strSearchAucEndDt					= $_REQUEST['searchAucEndDt'];
			$param['P_AUC_START_DT']			= $strSearchAucStartDt;
			$param['P_AUC_END_DT']				= $strSearchAucEndDt;
			
			## 2.5 경매상태			
			$strSearchAucStatus					= $_REQUEST['searchAucStatus'];
			$param['P_AUC_STATUS']				= $strSearchAucStatus;
						
			## 2.6 경매관리
			$param['P_AUCTION_SHOW']			= $S_PRODUCT_AUCTION_USE;
			
			## 3. 총 검색 total/페이징
			$intPage							= $_REQUEST['page'];
			$intPageLine						= $_REQUEST['pageLine'];	
			$intTotal							= $objProductListModule->getProductListSelectEx("OP_COUNT",$param);					
			
			$intPageLine						= ( $intPageLine )			? $intPageLine	: 10;							
			$intPage							= ( $intPage )				? $intPage		: 1;
			$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			
			$intPageBlock						= 10;																		// 블럭 개수 
			$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage							= ceil( $intTotal / $intPageLine );

			
			## 4. 상품리스트 정렬
			$param['P_SEARCH_SORT']				= $_REQUEST['order'];


			$param['P_IMG_SHOW']				= "Y";
			$param['LIMIT_LINE']				= $intPageLine;
			$param['LIMIT']						= $intFirst;
			$result								= $objProductListModule->getProductListSelectEx("OP_LIST",$param);	
//			echo $db->query;
			

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


		break;

	
	}

?>
