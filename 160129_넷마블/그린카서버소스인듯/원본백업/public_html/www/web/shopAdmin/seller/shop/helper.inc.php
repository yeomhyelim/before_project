<?
	require_once MALL_CONF_LIB."ShopMgr.php";
	require_once MALL_CONF_LIB."AdminMenu.php";
	
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."ShopOrderMgr.php";

	require_once MALL_CONF_LIB."EumMgr.php";

	require_once "../conf/site_skin_product.conf.inc.php";
	require_once "../conf/category.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/member.inc.php";
	include_once MALL_HOME."/include/shopCom.conf.inc.php";

	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	$shopMgr = new ShopMgr();
	$adminMenu = new AdminMenu();				
	$orderMgr = new ShopOrderMgr();
	$eumMgr = new EumMgr();

	/* 2015.06.23 add 기본 설정 언어가 한국일때  입점사 나라 영어로 셋팅 */
	if($S_SITE_LNG == "KR"){
		$S_SITE_LNG = "US";
		$S_SITE_LNG_P = "KR";
	}
	
	$aryCountryList		= getCountryList();	
	
	if($S_SITE_LNG_P == "KR"){
		$S_SITE_LNG = "KR";
		$S_SITE_LNG_P = "";
	}
			
	$aryCountryState	= getCommCodeList("STATE","");

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField		= $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey		= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$strSearchComAuth	= $_POST["searchComAuth"]	? $_POST["searchComAuth"]	: $_REQUEST["searchComAuth"];

	$intPage			= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine		= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$intSH_NO			= $_POST["shopNo"]			? $_POST["shopNo"]			: $_REQUEST["shopNo"];	
	$intSU_NO			= $_POST["shopUserNo"]		? $_POST["shopUserNo"]		: $_REQUEST["shopUserNo"];	

	$strShopType		= $_POST["shopType"]		? $_POST["shopType"]		: $_REQUEST["shopType"];
	
	/* 상품 목록 */
	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];
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

	$strSearchProdBrand		= $_POST["searchProdBrand"]			? $_POST["searchProdBrand"]			: $_REQUEST["searchProdBrand"];

	$strC_HCODE1			= $_POST["cateHCode1"]				? $_POST["cateHCode1"]				: $_REQUEST["cateHCode1"];
	$strC_HCODE2			= $_POST["cateHCode2"]				? $_POST["cateHCode2"]				: $_REQUEST["cateHCode2"];
	$strC_HCODE3			= $_POST["cateHCode3"]				? $_POST["cateHCode3"]				: $_REQUEST["cateHCode3"];
	$strC_HCODE4			= $_POST["cateHCode4"]				? $_POST["cateHCode4"]				: $_REQUEST["cateHCode4"];


	$aryUseLng = explode("/", $S_USE_LNG);
	for($i=0;$i<sizeof($aryUseLng);$i++){
		if ($aryUseLng[$i] == "KR") $strUseLngKr = "Y";
		if ($aryUseLng[$i] == "US") $strUseLngUs = "Y";
		if ($aryUseLng[$i] == "ID") $strUseLngId = "Y";
		if ($aryUseLng[$i] == "CN") $strUseLngCn = "Y";
		if ($aryUseLng[$i] == "JP") $strUseLngJp = "Y";
		if ($aryUseLng[$i] == "FR") $strUseLngFr = "Y";
	}


	/* 상품 목록 */

	/*##################################### Parameter 셋팅 #####################################*/

	/* 샵관리자로 로그인한 경우 */
	if ($a_admin_type == "S" && $a_admin_shop_no > 0){
		$intSH_NO = $a_admin_shop_no;
		$shopMgr->setSH_NO($a_admin_shop_no);
	}
	/* 데이터 리스트 */
	if(!$strStLng){
		$strStLng = $S_SITE_LNG;
	}
	$shopMgr->setP_LNG($strStLng);
	switch ($strMode){
		case "shopPolicy":
			// 입점사 약관관리

			## 모듈 설정
			$objSiteTextModule = new SiteTextModule($db);

			## 스크립트 설정
			$aryScriptEx[] = "/common/eumEditor/highgardenEditor.js";
			$aryScriptEx[] = "./common/js/seller/shop/shopPolicy.js";
			
			## 기본 설정
			$strLang = $_GET['lang']; if(!$strLang) { $strLang = $S_ST_LNG; }
			$strLang = strtoupper($strLang);
			$strLangLower = strtolower($strLang);
			$strCountryName = $S_ARY_COUNTRY[$strLang];
			$strCOL_NAME = "S_SHOP_POLICY_{$strLang}";

			## editor 사용 폴더 체크 및 생성
			$strEditorDir = MALL_SHOP . "/upload/editor/seller/shop";
			FileDevice::makeFolder($strEditorDir);

			## 약관 불러오기
			$param = "";
			$param['COL'] = $strCOL_NAME;
			$arySiteRow = $objSiteTextModule->getSiteTextSelectEx("OP_SELECT", $param);
			$strVAL = $arySiteRow['VAL'];

			## 마무리
			$strPolicy = $strVAL;

		break;

		case "shopList":
			## 2013.08.06 kim hee sung 소스 정리
			## 입점업체관리 리스트

			## 관리자 SUB MENU 권한 설정
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if($a_admin_type == "S"):
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";			
			endif;

			## 관리자 정보
			require_once MALL_CONF_LIB."AdminMgr.php";
			$adminMgr				= new AdminMgr();
			if($ADMIN_SHOP_SELECT_USE == "Y"):
				// "관리자 페이지 > 기본설정 > 관리자리스트 > 등록 에서, 영업사원, 관리입점몰 선택"을 사용 하는 경우.
				$param					= "";
				$param['M_NO']			= $a_admin_no;
				$adminRow				= $adminMgr->getAdminListEx($db, "OP_SELECT", $param);
				if($adminRow['A_TM_YN'] == "Y"):
					$shopList			= $adminRow['A_SHOP_LIST'];
					if(!$shopList) { $shopList = "-1"; }
				endif;
			endif;
//			print_r($adminRow);

			$eumMgr = new EumMgr();


			## 키워드 검색
			$strSearchQuery					= "";
			$strSearchField					= $_REQUEST['searchField'];
			$strSearchKey					= $_REQUEST['searchKey'];
			$strSearchCountry				= $_REQUEST['searchCountry'];

			$strSearchComAuth1				= $_REQUEST['searchComAuth1'];
			$strSearchComAuth2				= $_REQUEST['searchComAuth2'];
			$strSearchComAuth3				= $_REQUEST['searchComAuth3'];

			$strSearchCategory1				= $_REQUEST['searchCategory1'];
			$strSearchCategory2				= $_REQUEST['searchCategory2'];
			$strSearchCategory3				= $_REQUEST['searchCategory3'];
			$strSearchCreditGrade1			= $_REQUEST['searchCreditGrade1'];
			$strSearchCreditGrade2			= $_REQUEST['searchCreditGrade2'];
			$strSearchCreditGrade3			= $_REQUEST['searchCreditGrade3'];
			$strSearchSaleGrade1			= $_REQUEST['searchSaleGrade1'];
			$strSearchSaleGrade2			= $_REQUEST['searchSaleGrade2'];
			$strSearchSaleGrade3			= $_REQUEST['searchSaleGrade3'];
			$strSearchLocusGrade1			= $_REQUEST['searchLocusGrade1'];
			$strSearchLocusGrade2			= $_REQUEST['searchLocusGrade2'];
			$strOrder						= $_REQUEST['order'];


			if($strSearchKey):
				// 검색어
				$arySearchField['company']		= "SH.SH_COM_NAME LIKE ('%{$strSearchKey}%')";		// 회사명
				$arySearchField['shop']			= "(ST.ST_NAME LIKE ('%{$strSearchKey}%') OR ST.ST_NAME_ENG LIKE ('%{$strSearchKey}%'))";	// 상점명
				$arySearchField['boss']			= "SH.SH_COM_REP_NM LIKE ('%{$strSearchKey}%')";	// 대표자
				$arySearchField['bnumber']		= "SH.SH_COM_NUM LIKE ('%{$strSearchKey}%')";		// 사업자번호
				$arySearchField['email']		= "SH.SH_COM_MAIL LIKE ('%{$strSearchKey}%')";		// 이메일
				$strSearchQuery					= "({$arySearchField['company']} OR {$arySearchField['shop']} OR {$arySearchField['boss']} OR {$arySearchField['bnumber']} OR {$arySearchField['email']})";
				if($arySearchField[$strSearchField]) { $strSearchQuery = $arySearchField[$strSearchField]; }
			endif;

			## 검색 조건
			$param							= "";
			$strSearchComAuth				= $_REQUEST['searchComAuth'];
			if($strSearchComAuth):
				$param['SH_APPR']			= $strSearchComAuth;
			endif;
			if($strSearchCountry):
				$param['SH_COM_COUNTRY']			= $strSearchCountry;
			endif;
		

			if($strSearchCategory1 == 'M'):
				$aryCategory[]			= "SH.SH_COM_CATEGORY = 'M'";
			endif;
			if($strSearchCategory2 == 'S'):
				$aryCategory[]			= "SH.SH_COM_CATEGORY = 'S'";
			endif;
			if($strSearchCategory3 == 'B'):
				$aryCategory[]			= "SH.SH_COM_CATEGORY = 'B'";
			endif;

			$intCategory	=	count($aryCategory);
			if($intCategory > 0):
				foreach($aryCategory as $key => $val ){
					if($key == 0):
						if($strSearchQuery){
							$strCategory .= ' AND ';
						}
						$strCategory .= ' (';
					endif;
					if($key == 1):
						$strCategory .= ' OR ';
					endif;
					if($key == 2):
						$strCategory .= ' OR ';
					endif;

					$strCategory .= $val;

					if($key == $intCategory -1):
						$strCategory .= ' ) ';
					endif;
				}
				$strSearchQuery .= $strCategory;
			endif;


			if($strSearchCreditGrade1 == 'G'):
				$aryCreditGrade[]			= "SH.SH_COM_CREDIT_GRADE = 'G'";
			endif;
			if($strSearchCreditGrade2 == 'S'):
				$aryCreditGrade[]			= "SH.SH_COM_CREDIT_GRADE = 'S'";
			endif;
			if($strSearchCreditGrade3 == 'B'):
				$aryCreditGrade[]			= "SH.SH_COM_CREDIT_GRADE = 'B'";
			endif;

			$intCreditGrade	=	count($aryCreditGrade);
			if($intCreditGrade > 0){
				foreach($aryCreditGrade as $key => $val ){
					if($key == 0){
						if($strSearchQuery){
							$strCreditGrade .= ' AND ';
						}
						$strCreditGrade .= ' (';
					}
					if($key == 1){
						$strCreditGrade .= ' OR ';
					}
					if($key == 2){
						$strCreditGrade .= ' OR ';
					}

					$strCreditGrade .= $val;

					if($key == $intCreditGrade -1){
						$strCreditGrade .= ' ) ';
					}
				}
				$strSearchQuery .= $strCreditGrade;
			}


			if($strSearchSaleGrade1 == 'B'):
				$arySaleGrade[]				= "SH.SH_COM_SALE_GRADE = 'B'";
			endif;
			if($strSearchSaleGrade2 == 'E'):
				$arySaleGrade[]				= "SH.SH_COM_SALE_GRADE = 'E'";
			endif;
			if($strSearchSaleGrade3 == 'G'):
				$arySaleGrade[]				= "SH.SH_COM_SALE_GRADE = 'G'";
			endif;

			$intSaleGrade	=	count($arySaleGrade);
			if($intSaleGrade > 0):
				foreach($arySaleGrade as $key => $val ){
					if($key == 0):
						if($strSearchQuery){
							$strSaleGrade .= ' AND ';
						}
						$strSaleGrade .= ' (';
					endif;
					if($key == 1):
						$strSaleGrade .= ' OR ';
					endif;
					if($key == 2):
						$strSaleGrade .= ' OR ';
					endif;

					$strSaleGrade .= $val;

					if($key == $intSaleGrade -1):
						$strSaleGrade .= ' ) ';
					endif;
				}
				$strSearchQuery .= $strSaleGrade;
			endif;


			if($strSearchLocusGrade1 == 'N'):
				$aryLocusGrade[]			= "SH.SH_COM_LOCUS_GRADE = 'N'";
			endif;
			if($strSearchLocusGrade2 == 'Y'):
				$aryLocusGrade[]			= "SH.SH_COM_LOCUS_GRADE = 'Y'";
			endif;

			$intLocusGrade	=	count($aryLocusGrade);
			if($intLocusGrade > 0):
				foreach($aryLocusGrade as $key => $val ){
					if($key == 0):
						if($strSearchQuery){
							$strLocusGrade .= ' AND ';
						}
						$strLocusGrade .= ' (';
					endif;
					if($key == 1):
						$strLocusGrade .= ' OR ';
					endif;

					$strLocusGrade .= $val;

					if($key == $intLocusGrade -1):
						$strLocusGrade .= ' ) ';
					endif;
				}
				$strSearchQuery .= $strLocusGrade;
			endif;

			if($strSearchComAuth1 == 'Y'):
				$aryComAuth[]			= "SH.SH_APPR = 'Y'";
			endif;
			if($strSearchComAuth2 == 'N'):
				$aryComAuth[]			= "SH.SH_APPR = 'N'";
			endif;
			if($strSearchComAuth3 == 'R'):
				$aryComAuth[]			= "SH.SH_APPR = 'R'";
			endif;

			$intComAuth	=	count($aryComAuth);
			if($intComAuth > 0):
				foreach($aryComAuth as $key => $val ){
					if($key == 0):
						if($strSearchQuery){
							$strComAuth .= ' AND ';
						}
						$strComAuth .= ' (';
					endif;
					if($key == 1):
						$strComAuth .= ' OR ';
					endif;
					if($key == 2):
						$strComAuth .= ' OR ';
					endif;

					$strComAuth .= $val;

					if($key == $intComAuth -1):
						$strComAuth .= ' ) ';
					endif;
				}
				$strSearchQuery .= $strComAuth;
			endif;
//ECHO $strComAuth;

//exit;

			## 리스트
//			$param					= "";
			$param['SH_NO_IN']		= $shopList;
			$param['SEARCH_QUERY']	= $strSearchQuery;
			$param['SHOP_SITE_JOIN']= "Y";

			$intTotal				= $shopMgr->getShopListEx($db, "OP_COUNT", $param);							// 데이터 전체 개수 
			$intPageLine			= 10;																		// 리스트 개수 
			$intPage				= ( $intPage )				? $intPage		: 1;
			$intFirst				= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

			$arySortType['ProdCntDesc'] = 'SH_PROD_CNT DESC';
			$arySortType['ProdCntAsc'] = 'SH_PROD_CNT ASC';
			$arySortType['RegDesc'] = 'SH_REG_DT DESC';
			$arySortType['RegAsc'] = 'SH_REG_DT ASC';
			$arySortType['AdmissionDesc'] = 'SH_ADMISSION_DT DESC';
			$arySortType['AdmissionAsc'] = 'SH_ADMISSION_DT ASC';

//			$param							= "";
			if(!$strOrder) $strOrder = 'RegDesc';
			$param['ORDER_BY']				= $arySortType[$strOrder];
//			$param['ORDER_BY']				= "SH.SH_NO DESC";
			$param['SH_PROD_CNT_COLUML']	= "Y";
			$param['LIMIT']					= "{$intFirst},{$intPageLine}";

			$result							= $shopMgr->getShopListEx($db, "OP_LIST", $param);

			$intPageBlock					= 10;																		// 블럭 개수 
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );

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
// 영업사원 입점업체 관리를 위하여 소스 정리
// 2013.08.06 kim hee sung
//		case "shopList":
//
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "002";
//			$strLeftMenuCode02 = "001";
//			if ($a_admin_type == "S"){
//				$strLeftMenuCode01 = "001";
//				$strLeftMenuCode02 = "001";
//			}
//			/* 관리자 Sub Menu 권한 설정 */
//			
//			$shopMgr->setSearchField($strSearchField);
//			$shopMgr->setSearchKey($strSearchKey);
//			$shopMgr->setSearchComAuth($strSearchComAuth);
//			$intTotal								= $shopMgr->getShopTotal( $db );
//
//			$intPageLine							= 10;																				// 리스트 개수 
//			$intPage								= ( $intPage )				? $intPage		: 1;
//			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
//			$shopMgr->setLimitFirst($intFirst);
//			$shopMgr->setPageLine($intPageLine);
//
//			$result									= $shopMgr->getShopList( $db );
//			$intPageBlock							= 10;																		// 블럭 개수 
//			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
//			$intTotPage								= ceil( $intTotal / $intPageLine );
//			/* 데이터 리스트 */
//
//			$linkPage  = "?menuType=seller&mode=shopList&searchField=$strSearchField&searchKey=$strSearchKey&searchComAuth=$strSearchComAuth&page=";
//		break;

		case "shopWrite":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if ($a_admin_type == "S"){
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */

			if (!$strShopType) $strShopType = "C";

		break;

		case "shopOkCheck":

		break;

		case "shopModify":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if ($a_admin_type == "S"){
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */
			$shopMgr->setSH_NO($intSH_NO);
			
			$shopRow =$shopMgr->getShopView($db);

			/* 사업자등록번호 */
			$aryComNum1 = explode("-",$shopRow['SH_COM_NUM']);
			$strComNum1_1 = $strComNum1_2 = $strComNum1_3 = "";
			if (is_array($aryComNum1)){
				$strComNum1_1 = $aryComNum1[0];
				$strComNum1_2 = $aryComNum1[1];
				$strComNum1_3 = $aryComNum1[2];
			}

			/* 통신판매업신고번호 */
			$aryComNum2 = explode("-",$shopRow['SH_COM_NUM2']);
			$strComNum2_1 = $strComNum2_2 = $strComNum2_3 = "";
			if (is_array($aryComNum2)){
				$strComNum2_1 = $aryComNum2[0];
				$strComNum2_2 = $aryComNum2[1];
				$strComNum2_3 = $aryComNum2[2];
			}

			/* 전화번호 */
			$aryComPhone = explode("-",$shopRow['SH_COM_PHONE']);
			$strComPhone1 = $strComPhone2 = $strComPhone3 = "";
			if (is_array($aryComPhone)){
				$strComPhone1 = $aryComPhone[0];
				$strComPhone2 = $aryComPhone[1];
				$strComPhone3 = $aryComPhone[2];
			}

			/* 팩스번호 */
			$aryComFax = explode("-",$shopRow['SH_COM_FAX']);
			$strComFax1 = $strComFax2 = $strComFax3 = "";
			if (is_array($aryComFax)){
				$strComFax1 = $aryComFax[0];
				$strComFax2 = $aryComFax[1];
				$strComFax3 = $aryComFax[2];
			}

			$strComPhone=$shopRow['SH_COM_PHONE'];
			$strComFax=$shopRow['SH_COM_FAX'];


			/* 우편번호 */
			$aryComZip = explode("-",$shopRow['SH_COM_ZIP']);
			$strComZip1 = $strComZip2 = "";
			if (is_array($aryComZip)){
				$strComZip1 = $aryComZip[0];
				$strComZip2 = $aryComZip[1];
			}

			$strShopType = $shopRow['SH_TYPE'];
			
			$strComType = $shopRow['SH_COM_CATEGORY'];


		break;
		
		case "shopSite":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if ($a_admin_type == "S"){
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */
			
			$shopMgr->setSH_NO($intSH_NO);
			$storeRow = $shopMgr->getStoreView($db);			
					
		break;

		case "shopSetting":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if ($a_admin_type == "S"){
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */
			
			$shopMgr->setSH_NO($intSH_NO);
			$shopRow =$shopMgr->getShopView($db);
			
			$storeRow = $shopMgr->getStoreView($db);			
					
			$aryBank = getCommCodeList("BANK");
			$aryDeliveryCom = getCommCodeList("DELIVERY_All","Y");
			
			/* 상점별 등록된 배송사 배열 */
			$aryShopDeliveryComAll = explode(",",$shopRow[SH_COM_DELIVERY_COR]);
			foreach($aryShopDeliveryComAll as $key => $val){
				$aryShopDeliveryCom[$val] = "Y";
			}
			/* 해외배송사 배열*/
			$aryShopDeliveryForComAll = explode(",",$shopRow[SH_COM_DELIVERY_FOR_COR]);
			foreach($aryShopDeliveryForComAll as $keya => $vala){
				$aryShopDeliveryForComAll[$vala] = "Y";
			}
		break;


		case "shopUser":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if ($a_admin_type == "S"){
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */
			
			$shopMgr->setSH_NO($intSH_NO);
			$aryShopUserList =$shopMgr->getShopUserList($db);
			
		break;


		case "shopUserWrite":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if ($a_admin_type == "S"){
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */

			$aryHp		= getCommCodeList("HP");
			$aryPhone	= getCommCodeList("PHONE");
			$aryJob		= getCommCodeList("JOB");
			$aryConcern	= getCommCodeList("CONCERN");

			/* 국가 리스트 */
			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
			}		
		break;

		case "shopUserModify":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			if ($a_admin_type == "S"){
				$strLeftMenuCode01 = "001";
				$strLeftMenuCode02 = "001";
			}
			/* 관리자 Sub Menu 권한 설정 */

			$aryHp		= getCommCodeList("HP");
			
			$shopMgr->setSH_NO($intSH_NO);
			$shopMgr->setSU_NO($intSU_NO);
			$row = $shopMgr->getShopUserView($db);
			
			$adminMenu->setM_NO($row[M_NO]);
			$adminMenu->setAM_TYPE("S");
			
			$authRet = $adminMenu->getMemAuthList($db);
			while($authRow = mysql_fetch_array($authRet[result])){
				$memberAuthRow[$authRow[MN_NO]] = $authRow;
			}
			
			$xml_string = file_get_contents("http://www.eumshop.com/api/xml/shop.lang.menu.store.xml.php?extMenuYN={$SELLER_PAPER_USE}");
			/*www.eumshop.com 에서 xml 데이터 못가져올 경우, 아래 값 사용.(미리 다운)
			 *$xml_string = '<?xml version="1.0" encoding="UTF-8"?><data><ITEM><MN_NO>167</MN_NO><MN_CODE>012</MN_CODE><MN_NAME_KR><![CDATA[메인화면]]></MN_NAME_KR><MN_NAME_US><![CDATA[Main]]></MN_NAME_US><MN_NAME_CN><![CDATA[메인화면]]></MN_NAME_CN><MN_NAME_JP><![CDATA[메인화면]]></MN_NAME_JP><MN_NAME_ID><![CDATA[메인화면]]></MN_NAME_ID><MN_NAME_FR><![CDATA[메인화면]]></MN_NAME_FR><MN_LEVEL>1</MN_LEVEL><MN_HIGH_01 /><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=main&mode=memberList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>168</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[메인화면]]></MN_NAME_KR><MN_NAME_US><![CDATA[Main]]></MN_NAME_US><MN_NAME_CN><![CDATA[메인화면]]></MN_NAME_CN><MN_NAME_JP><![CDATA[메인화면]]></MN_NAME_JP><MN_NAME_ID><![CDATA[메인화면]]></MN_NAME_ID><MN_NAME_FR><![CDATA[메인화면]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>012</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=main&mode=memberList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>148</MN_NO><MN_CODE>011</MN_CODE><MN_NAME_KR><![CDATA[입점사정보]]></MN_NAME_KR><MN_NAME_US><![CDATA[입점사정보]]></MN_NAME_US><MN_NAME_CN><![CDATA[입점사정보]]></MN_NAME_CN><MN_NAME_JP><![CDATA[입점사정보]]></MN_NAME_JP><MN_NAME_ID><![CDATA[입점사정보]]></MN_NAME_ID><MN_NAME_FR><![CDATA[입점사정보]]></MN_NAME_FR><MN_LEVEL>1</MN_LEVEL><MN_HIGH_01 /><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=seller&mode=shopList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>149</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[입점사정보]]></MN_NAME_KR><MN_NAME_US><![CDATA[입점사정보]]></MN_NAME_US><MN_NAME_CN><![CDATA[입점사정보]]></MN_NAME_CN><MN_NAME_JP><![CDATA[입점사정보]]></MN_NAME_JP><MN_NAME_ID><![CDATA[입점사정보]]></MN_NAME_ID><MN_NAME_FR><![CDATA[입점사정보]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>011</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=seller&mode=shopList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>150</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[입점사정보]]></MN_NAME_KR><MN_NAME_US><![CDATA[입점사정보]]></MN_NAME_US><MN_NAME_CN><![CDATA[입점사정보]]></MN_NAME_CN><MN_NAME_JP><![CDATA[입점사정보]]></MN_NAME_JP><MN_NAME_ID><![CDATA[입점사정보]]></MN_NAME_ID><MN_NAME_FR><![CDATA[입점사정보]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>011</MN_HIGH_01><MN_HIGH_02>001</MN_HIGH_02><MN_URL><![CDATA[./?menuType=seller&mode=shopList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>4</MN_NO><MN_CODE>004</MN_CODE><MN_NAME_KR><![CDATA[상품관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[Product Management]]></MN_NAME_US><MN_NAME_CN><![CDATA[商品管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[商品管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Product Management]]></MN_NAME_ID><MN_NAME_FR><![CDATA[상품관리]]></MN_NAME_FR><MN_LEVEL>1</MN_LEVEL><MN_HIGH_01 /><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=product&mode=prodList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>5</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>34</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[상품관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[Product Management]]></MN_NAME_US><MN_NAME_CN><![CDATA[商品管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[商品管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Product Management]]></MN_NAME_ID><MN_NAME_FR><![CDATA[상품관리]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=product&mode=prodList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>35</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[판매상품목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[Product List]]></MN_NAME_US><MN_NAME_CN><![CDATA[出售中商品目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[販売商品目録]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Product List]]></MN_NAME_ID><MN_NAME_FR><![CDATA[판매상품목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02>001</MN_HIGH_02><MN_URL><![CDATA[./?menuType=product&mode=prodList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>36</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[상품신규등록]]></MN_NAME_KR><MN_NAME_US><![CDATA[Product Registration]]></MN_NAME_US><MN_NAME_CN><![CDATA[发布商品]]></MN_NAME_CN><MN_NAME_JP><![CDATA[商品新規登録]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Product Registration]]></MN_NAME_ID><MN_NAME_FR><![CDATA[상품신규등록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02>001</MN_HIGH_02><MN_URL><![CDATA[./?menuType=product&mode=prodWrite]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>Y</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>37</MN_NO><MN_CODE>003</MN_CODE><MN_NAME_KR><![CDATA[일시/품절상품관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[진열장관리]]></MN_NAME_US><MN_NAME_CN><![CDATA[仓库商品]]></MN_NAME_CN><MN_NAME_JP><![CDATA[日時/品切れ商品管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[진열장관리]]></MN_NAME_ID><MN_NAME_FR><![CDATA[일시/품절상품관리]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02>001</MN_HIGH_02><MN_URL><![CDATA[./?menuType=product&mode=prodStockList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>3</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>38</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[상품부가관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[Wish List Management]]></MN_NAME_US><MN_NAME_CN><![CDATA[商品附加管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[商品付加管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Wish List Management]]></MN_NAME_ID><MN_NAME_FR><![CDATA[관련상품관리]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=product&mode=prodDisplay]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>3</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>Y</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>165</MN_NO><MN_CODE>003</MN_CODE><MN_NAME_KR><![CDATA[상품대량등록/수정]]></MN_NAME_KR><MN_NAME_US><![CDATA[상품대량등록/수정]]></MN_NAME_US><MN_NAME_CN><![CDATA[商品批量上传管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[商品大量登録/修正]]></MN_NAME_JP><MN_NAME_ID><![CDATA[상품대량등록/수정]]></MN_NAME_ID><MN_NAME_FR><![CDATA[상품대량등록/수정]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02>002</MN_HIGH_02><MN_URL><![CDATA[./?menuType=product&mode=prodAtOneTimeWrite]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>3</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>Y</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>40</MN_NO><MN_CODE>003</MN_CODE><MN_NAME_KR><![CDATA[카테고리관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[Category Management]]></MN_NAME_US><MN_NAME_CN><![CDATA[分类管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[カテゴリー管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Category Management]]></MN_NAME_ID><MN_NAME_FR><![CDATA[카테고리관리]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=product&mode=cateList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>4</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>Y</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>41</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[카테고리관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[Category Management]]></MN_NAME_US><MN_NAME_CN><![CDATA[分类管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[カテゴリー管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Category Management]]></MN_NAME_ID><MN_NAME_FR><![CDATA[카테고리관리]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>004</MN_HIGH_01><MN_HIGH_02>003</MN_HIGH_02><MN_URL><![CDATA[./?menuType=product&mode=cateList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>Y</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>5</MN_NO><MN_CODE>005</MN_CODE><MN_NAME_KR><![CDATA[주문관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[Order Management]]></MN_NAME_US><MN_NAME_CN><![CDATA[订单管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[注文管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Order Management]]></MN_NAME_ID><MN_NAME_FR><![CDATA[주문관리]]></MN_NAME_FR><MN_LEVEL>1</MN_LEVEL><MN_HIGH_01 /><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=order&mode=list]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>6</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>47</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[주문관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[Order Management]]></MN_NAME_US><MN_NAME_CN><![CDATA[订单管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[注文管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[Order Management]]></MN_NAME_ID><MN_NAME_FR><![CDATA[주문관리]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=order&mode=list]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>48</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[주문리스트]]></MN_NAME_KR><MN_NAME_US><![CDATA[주문리스트]]></MN_NAME_US><MN_NAME_CN><![CDATA[订单列表]]></MN_NAME_CN><MN_NAME_JP><![CDATA[注文リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[주문리스트]]></MN_NAME_ID><MN_NAME_FR><![CDATA[주문리스트]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>001</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=list]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>49</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[무통장입금 관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[무통장입금 관리]]></MN_NAME_US><MN_NAME_CN><![CDATA[银行收款管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[振込み管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[무통장입금 관리]]></MN_NAME_ID><MN_NAME_FR><![CDATA[무통장입금 관리]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>001</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=list&searchOrderStatus=J]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>50</MN_NO><MN_CODE>003</MN_CODE><MN_NAME_KR><![CDATA[취소신청목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[취소신청목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[退单目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[キャンセル申請リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[취소신청목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[취소신청목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>001</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=list&searchOrderStatus=C]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>3</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>153</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[배송관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[배송관리]]></MN_NAME_US><MN_NAME_CN><![CDATA[订单管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[配送管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[배송관리]]></MN_NAME_ID><MN_NAME_FR><![CDATA[배송관리]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=order&mode=deliveryFastInput]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>155</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[송장입력목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[송장입력목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[发货单号目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[請求書の入力リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[송장입력목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[송장입력목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>002</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=deliveryList]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>156</MN_NO><MN_CODE>003</MN_CODE><MN_NAME_KR><![CDATA[배송중목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[배송중목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[已发货目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[配送中リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[배송중목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[배송중목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>002</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=deliveryList&searchOrderStatus=I]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>3</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>157</MN_NO><MN_CODE>004</MN_CODE><MN_NAME_KR><![CDATA[배송완료목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[배송완료목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[发货成功目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[配送完了リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[배송완료목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[배송완료목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>002</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=deliveryList&searchOrderStatus=D]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>4</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>158</MN_NO><MN_CODE>003</MN_CODE><MN_NAME_KR><![CDATA[정산관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[정산관리]]></MN_NAME_US><MN_NAME_CN><![CDATA[结算管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[決済管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[정산관리]]></MN_NAME_ID><MN_NAME_FR><![CDATA[정산관리]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=order&mode=accList&searchAccStatus=N]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>54</MN_NO><MN_CODE>007</MN_CODE><MN_NAME_KR><![CDATA[구매확정목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[Order Completed List]]></MN_NAME_US><MN_NAME_CN><![CDATA[购货确定目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[購入確定リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[구매확정목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[구매확정목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>003</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=list&searchOrderStatus=E]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>159</MN_NO><MN_CODE>008</MN_CODE><MN_NAME_KR><![CDATA[정산예정목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[정산예정목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[结算预计目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[決済予定リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[정산예정목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[정산예정목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>003</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=accList&searchAccStatus=N]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>160</MN_NO><MN_CODE>009</MN_CODE><MN_NAME_KR><![CDATA[정산완료목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[정산완료목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[结算成功目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[決済完了リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[정산완료목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[정산완료목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>003</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=accList&searchAccStatus=Y]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>3</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>Y</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>169</MN_NO><MN_CODE>004</MN_CODE><MN_NAME_KR><![CDATA[반품관리]]></MN_NAME_KR><MN_NAME_US><![CDATA[반품관리]]></MN_NAME_US><MN_NAME_CN><![CDATA[退换管理]]></MN_NAME_CN><MN_NAME_JP><![CDATA[返品管理]]></MN_NAME_JP><MN_NAME_ID><![CDATA[반품관리]]></MN_NAME_ID><MN_NAME_FR><![CDATA[반품관리]]></MN_NAME_FR><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=order&mode=list&searchOrderStatus=R]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>4</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>53</MN_NO><MN_CODE>006</MN_CODE><MN_NAME_KR><![CDATA[반품/교환신청목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[반품/교환신청목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[退换货目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[返品/交換申請リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[반품/교환신청목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[반품/교환신청목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>004</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=list&searchOrderStatus=R]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>51</MN_NO><MN_CODE>004</MN_CODE><MN_NAME_KR><![CDATA[환불신청목록]]></MN_NAME_KR><MN_NAME_US><![CDATA[환불신청목록]]></MN_NAME_US><MN_NAME_CN><![CDATA[退换金额目录]]></MN_NAME_CN><MN_NAME_JP><![CDATA[払い戻しの申請リスト]]></MN_NAME_JP><MN_NAME_ID><![CDATA[환불신청목록]]></MN_NAME_ID><MN_NAME_FR><![CDATA[환불신청목록]]></MN_NAME_FR><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>005</MN_HIGH_01><MN_HIGH_02>004</MN_HIGH_02><MN_URL><![CDATA[./?menuType=order&mode=list&searchOrderStatus=T]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>6</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>Y</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>Y</MN_AUTH_E1><MN_AUTH_E2>Y</MN_AUTH_E2><MN_AUTH_E3>Y</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>8</MN_NO><MN_CODE>008</MN_CODE><MN_NAME_KR><![CDATA[통계관리]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>1</MN_LEVEL><MN_HIGH_01 /><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=weblog&mode=visitYear]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>10</MN_ORDER><MN_AUTH_L>Y</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>83</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[매출분석]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>008</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=weblog&mode=orderMonthStatics]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>85</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[월별매출분석]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>008</MN_HIGH_01><MN_HIGH_02>002</MN_HIGH_02><MN_URL><![CDATA[./?menuType=weblog&mode=orderMonthStatics]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>84</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[일별매출통계]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>008</MN_HIGH_01><MN_HIGH_02>002</MN_HIGH_02><MN_URL><![CDATA[./?menuType=weblog&mode=orderDayStatics]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>92</MN_NO><MN_CODE>004</MN_CODE><MN_NAME_KR><![CDATA[주문분석]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>2</MN_LEVEL><MN_HIGH_01>008</MN_HIGH_01><MN_HIGH_02 /><MN_URL><![CDATA[./?menuType=weblog&mode=orderDayStatics2]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>4</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>93</MN_NO><MN_CODE>001</MN_CODE><MN_NAME_KR><![CDATA[일별 주문통계]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>008</MN_HIGH_01><MN_HIGH_02>004</MN_HIGH_02><MN_URL><![CDATA[./?menuType=weblog&mode=orderDayStatics2]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>1</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>94</MN_NO><MN_CODE>002</MN_CODE><MN_NAME_KR><![CDATA[월별 주문통계]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>008</MN_HIGH_01><MN_HIGH_02>004</MN_HIGH_02><MN_URL><![CDATA[./?menuType=weblog&mode=orderMonthStatics2]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>2</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM><ITEM><MN_NO>95</MN_NO><MN_CODE>003</MN_CODE><MN_NAME_KR><![CDATA[상품별 주문통계]]></MN_NAME_KR><MN_NAME_US /><MN_NAME_CN /><MN_NAME_JP /><MN_NAME_ID /><MN_NAME_FR /><MN_LEVEL>3</MN_LEVEL><MN_HIGH_01>008</MN_HIGH_01><MN_HIGH_02>004</MN_HIGH_02><MN_URL><![CDATA[./?menuType=weblog&mode=orderProdStatusStatics]]></MN_URL><MN_USE><![CDATA[Y]]></MN_USE><MN_ORDER>3</MN_ORDER><MN_AUTH_L>N</MN_AUTH_L><MN_AUTH_W>N</MN_AUTH_W><MN_AUTH_M>N</MN_AUTH_M><MN_AUTH_D>N</MN_AUTH_D><MN_AUTH_E>N</MN_AUTH_E><MN_AUTH_C>N</MN_AUTH_C><MN_AUTH_S>N</MN_AUTH_S><MN_AUTH_U>N</MN_AUTH_U><MN_AUTH_P>N</MN_AUTH_P><MN_AUTH_E1>N</MN_AUTH_E1><MN_AUTH_E2>N</MN_AUTH_E2><MN_AUTH_E3>N</MN_AUTH_E3><MN_AUTH_E4>N</MN_AUTH_E4><MN_AUTH_E5>N</MN_AUTH_E5></ITEM></data>'; 
			 */
			
			$xml = simplexml_load_string($xml_string);

			/* 게시판 관리자 메뉴 가지고 오기 */
			$aryCommunityAdmList = $adminMenu->getCommunityAdmList($db);

			/* 게시판 리스트 메뉴 가지고 오기 */
			$aryCommunityList = $adminMenu->getCommunityList($db);

		break;

		case "shopProdList":
			/* 언어 선택 */
			$productMgr->setP_LNG($S_SITE_LNG);

			/* 검색부분 */
			$productMgr->setSearchHCode1($strSearchHCode1);
			$productMgr->setSearchHCode2($strSearchHCode2);
			$productMgr->setSearchHCode3($strSearchHCode3);
			$productMgr->setSearchHCode4($strSearchHCode4);

			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setSearchLaunchStartDt($strSearchLaunchStartDt);
			$productMgr->setSearchLaunchEndDt($strSearchLaunchEndDt);
			$productMgr->setSearchRepStartDt($strSearchRepStartDt);
			$productMgr->setSearchRepEndDt($strSearchRepEndDt);
			$productMgr->setSearchWebView($strSearchWebView);
			$productMgr->setSearchMobileView($strSearchMobileView);
			$productMgr->setSearchIcon1($strSearchIcon1);
			$productMgr->setSearchIcon2($strSearchIcon2);
			$productMgr->setSearchIcon3($strSearchIcon3);
			$productMgr->setSearchIcon4($strSearchIcon4);
			$productMgr->setSearchIcon5($strSearchIcon5);
			$productMgr->setSearchIcon6($strSearchIcon6);
			$productMgr->setSearchIcon7($strSearchIcon7);
			$productMgr->setSearchIcon8($strSearchIcon8);
			$productMgr->setSearchIcon9($strSearchIcon9);
			$productMgr->setSearchIcon10($strSearchIcon10);
			$productMgr->setSearchProdBrand($strSearchProdBrand);
			$productMgr->setSearchShopNo($intSH_NO);
			
			/* 검색부분 */

			$intPageBlock	= 10;
			if(!$intPageLine) $intPageLine = 10;			
			$productMgr->setPageLine($intPageLine);
	
			$intTotal	= $productMgr->getProdTotal($db);
			$intTotPage	= ceil($intTotal / $productMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$productMgr->setLimitFirst($intFirst);

			$result = $productMgr->getProdList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
			
			/* 진열장 */
			$cateMgr->setIC_TYPE("MAIN");
			$aryProdMainDisplayList = $cateMgr->getProdDisplayList($db);

			$cateMgr->setIC_TYPE("SUB");
			$aryProdSubDisplayList = $cateMgr->getProdDisplayList($db);

			$linkPage  = "?menuType=$strMenuType&mode=$strMode&searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
			$linkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$linkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$linkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$linkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$linkPage .= "&searchIcon1=$strSearchIcon1";
			$linkPage .= "&searchIcon2=$strSearchIcon2";
			$linkPage .= "&searchIcon3=$strSearchIcon3";
			$linkPage .= "&searchIcon4=$strSearchIcon4";
			$linkPage .= "&searchIcon5=$strSearchIcon5";
			$linkPage .= "&searchIcon6=$strSearchIcon6";
			$linkPage .= "&searchIcon7=$strSearchIcon7";
			$linkPage .= "&searchIcon8=$strSearchIcon8";
			$linkPage .= "&searchIcon9=$strSearchIcon9";
			$linkPage .= "&searchIcon10=$strSearchIcon10&lang=$strStLng&shopNo=$intSH_NO&page=";
		
			/*브랜드*/
			$aryProdBrandList = $productMgr->getProdBrandList($db, "OP_ARYTOTAL");

		break;

		case "shopOrderList":
			
			## STEP 1.
			## 선언

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

			$param['searchOrderStatus']				= $strSearchOrderStatus;
			$param['searchShopNo']					= $intSH_NO;
			
			## 소속 검색
			$strSearchNation						= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
			$strSearchCate1							= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
			$strSearchCate2							= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
			$strSearchCate3							= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
			$strSearchCate4							= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
			if($strSearchNation || $strSearchCate1 || $strSearchCate2 || $strSearchCate3 || $strSearchCate4):
				
				## 설정
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();

				## 검색 카테고리 설정
				$cateCode				= "";
				if($strSearchCate1) { $cateCode = $strSearchCate1; }
				if($strSearchCate2) { $cateCode = $strSearchCate2; }
				if($strSearchCate3) { $cateCode = $strSearchCate3; }
				if($strSearchCate4) { $cateCode = $strSearchCate4; }

				## 데이터
				$param								= "";
				$param['MEMBER_CATE_MGR_JOIN']		= "Y";
				$param['searchMemberNation']		= $strSearchNation;
				$param['M_CATE']					= $cateCode;
			
			elseif ($a_admin_level > 0): 
			
				## 차수별 회원 소속 설정
					
				## 설정
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();

				$param								= "";
				$param['C_CODE_COLUMN_ARYLIST']		= "Y";
				$param['M_NO']						= $a_admin_no;
				$cateCode							= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);
				
				$param['M_CATE']					= $cateCode;
			endif;
			
			$intTotal								= $orderMgr->getOrderListEx($db, "OP_COUNT", $param);							// 데이터 전체 개수 
			$intPageLine							= 10;																			// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

			$param['order_by']						= "A.O_NO DESC";
			$param['limit']							= "{$intFirst},{$intPageLine}";
			$orderListResult						= $orderMgr->getOrderListEx($db, "OP_LIST", $param);

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

			$aryDeliveryCom = getCommCodeList("DELIVERY");

			If ($S_SETTLE){
			$arySiteSettle = explode("/",$S_SETTLE);
			if (is_array($arySiteSettle)){
				$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
				for($z=0;$z<sizeof($arySiteSettle);$z++){
					if ($arySiteSettle[$z] == "B"){
						$intSiteSettleB = "Y";
					}

					if ($arySiteSettle[$z] == "C"){
						$intSiteSettleC = "Y";
					}

					if ($arySiteSettle[$z] == "A"){
						$intSiteSettleA = "Y";
					}

					if ($arySiteSettle[$z] == "T"){
						$intSiteSettleT = "Y";
					}
				}
			}
			}

			/*배송회사*/
			$aryDeliveryComAll  = getCommCodeList("DELIVERY","Y");
			$aryDeliveryUrl		= getDeliveryUrlList();

			/*국가/주*/
			$aryCountryList		= getCountryList();			
			$aryCountryState	= getCommCodeList("STATE","");

		break;
		case "shopGrade":
			$shopMgr->setSH_NO($intSH_NO);
			//$storeRow = $shopMgr->getStoreView($db);
			$shopRow = $shopMgr->getShopView($db);
			$shopGradePoint = $shopMgr->getShopGradePointView($db);
			$strSH_WORK_CHECK			= $shopGradePoint[SH_WORK_CHECK];
			$strSH_WORK_POINT			= $shopGradePoint[SH_WORK_POINT];
			$strSH_GRADE_UNTRUTH		= $shopGradePoint[SH_GRADE_UNTRUTH];
			$strSH_GRADE_UNTRUTH_POINT	= $shopGradePoint[SH_GRADE_UNTRUTH_POINT];
			$strSH_PROD_UNTRUTH			= $shopGradePoint[SH_PROD_UNTRUTH];
			$strSH_PROD_UNTRUTH_POINT	= $shopGradePoint[SH_PROD_UNTRUTH_POINT];

			$strComProdAuth = $shopRow["SH_COM_PROD_AUTH"];		// 상점노출
			$strComCreditGrade = $shopRow["SH_COM_CREDIT_GRADE"];	// 신용등급
			$strComSaleGrade = $shopRow["SH_COM_SALE_GRADE"];	// 판매등급
			$strComLocusGrade = $shopRow["SH_COM_LOCUS_GRADE"];	// 현장확인

		break;

		case "shopProduct":
			//echo 11;
		break;
	}
?>