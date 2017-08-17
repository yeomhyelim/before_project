<?
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];

	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];

	$strSearchSettleC		= $_POST["searchSettleC"]			? $_POST["searchSettleC"]	: $_REQUEST["searchSettleC"];
	$strSearchSettleA		= $_POST["searchSettleA"]			? $_POST["searchSettleA"]	: $_REQUEST["searchSettleA"];
	$strSearchSettleT		= $_POST["searchSettleT"]			? $_POST["searchSettleT"]	: $_REQUEST["searchSettleT"];
	$strSearchSettleB		= $_POST["searchSettleB"]			? $_POST["searchSettleB"]	: $_REQUEST["searchSettleB"];
	$strSearchSettleY		= $_POST["searchSettleY"]			? $_POST["searchSettleY"]	: $_REQUEST["searchSettleY"];
	$strSearchSettleX		= $_POST["searchSettleX"]			? $_POST["searchSettleX"]	: $_REQUEST["searchSettleX"];

	$strSearchRegStartDt	= $_POST["searchRegStartDt"]		? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]			? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchStartYear		= $_POST["searchStartYear"]			? $_POST["searchStartYear"]			: $_REQUEST["searchStartYear"];
	$strSearchStartMonth	= $_POST["searchStartMonth"]		? $_POST["searchStartMonth"]		: $_REQUEST["searchStartMonth"];
	$strSearchStartDay		= $_POST["searchStartDay"]			? $_POST["searchStartDay"]			: $_REQUEST["searchStartDay"];

	$strSearchEndYear		= $_POST["searchEndYear"]			? $_POST["searchEndYear"]			: $_REQUEST["searchEndYear"];
	$strSearchEndMonth		= $_POST["searchEndMonth"]			? $_POST["searchEndMonth"]			: $_REQUEST["searchEndMonth"];
	$strSearchEndDay		= $_POST["searchEndDay"]			? $_POST["searchEndDay"]			: $_REQUEST["searchEndDay"];
	$strSearchShop			= $_POST["searchShop"]				? $_POST["searchShop"]			: $_REQUEST["searchShop"];

	$strOrderBySort			= $_POST["orderBySort"]			? $_POST["orderBySort"]			: $_REQUEST["orderBySort"];	

	/*##################################### Parameter 셋팅 #####################################*/
	
	$webLogMgr->setLogLng($strAdmSiteLng);


	## 검색시 소속 사용
	if ($a_admin_type != "S")
	{
		if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){
			## 설정
			## 언어 설정
			$aryUseLng			= explode("/", $S_USE_LNG);

			## 회원소속관리 불러오기
			$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
			//include_once $fileName;
			//member.cate.inc.php 파일 자체가 아예 없음.
			if(is_file($fileName)):
				require_once "$fileName";
			endif;

			## 해당 회원 소속 가져오기
			if(!$memberCateMgr):
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();
			endif;

			## 차수별 회원 소속 설정
			if (!is_array($aryMemberCateList)):
				$param								= "";
				$param['C_CODE_COLUMN_ARYLIST']		= "Y";
				$param['M_NO']						= $a_admin_no;
				$aryMemberCateList					= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);
			endif;

			//		echo $db->query;
			$aryMemberCate						= "";
			
			## 소속 검색
			$strSearchNation	= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
			$strSearchCate1		= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
			$strSearchCate2		= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
			$strSearchCate3		= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
			$strSearchCate4		= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
			
			if($strSearchNation || $strSearchCate1 || $strSearchCate2 || $strSearchCate3 || $strSearchCate4):
				
				## 검색 카테고리 설정
				$cateCode				= "";
				if($strSearchCate1) { $cateCode = $strSearchCate1; }
				if($strSearchCate2) { $cateCode = $strSearchCate2; }
				if($strSearchCate3) { $cateCode = $strSearchCate3; }
				if($strSearchCate4) { $cateCode = $strSearchCate4; }

				## 데이터
				$param								= "";
				$param['M_CATE']					= $cateCode;
							
			endif;

			if ($a_admin_level > 0 && (!$strSearchCate2)):
				
				## 차수별 회원 소속 설정
				$param								= "";
				$param['C_CODE_COLUMN_ARYLIST']		= "Y";
				$param['M_NO']						= $a_admin_no;
				$aryMemberCateJoinList				= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYTOTAL", $param);
//				$cateCode							= $aryMemberCateJoinList[0]['C_CODE'];
//				$param['M_CATE']					= substr($cateCode,0,6);
				## 국가를 선택하였을때 소속관리자가 자기소속만 데이터만 보이도록 설정
				if (is_array($aryMemberCateJoinList)){
					$param['M_CATE_LIST']			= "Y";
					$param['M_CATE_LIST_DATA']		= "";
					
					$strMemberCateListData			= "";
					foreach($aryMemberCateJoinList as $key => $memberCateRow){
						if ($memberCateRow['C_CODE']){
							$strMemberCateListData .= "C_CODE LIKE '".$memberCateRow['C_CODE']."%',";
						}
					}

					if ($strMemberCateListData) {
						$strMemberCateListData		= substr($strMemberCateListData,0,strlen($strMemberCateListData)-1);
						$param['M_CATE_LIST_DATA']  = $strMemberCateListData;
					}
				}
			
			endif;
		}
	}
	
	## 입점업체 리스트 
	if ($a_admin_type == "A"){
		if ($ADMIN_SHOP_SELECT_USE == "Y"){
			if ($a_admin_tm == "Y" && $a_admin_shop_list) {
				/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
				$param['SHOP_LIST'] = $a_admin_shop_list;
				if (!$strSearchShop) $strSearchShop = $a_admin_shop_list;
			}
		}
		$aryShopList = $webLogMgr->getShopList($db,$param);
	} else {
		$strSearchShop = $a_admin_shop_no;
	}

	## 컬럼별 정렬
	if ($strOrderBySort) $param["orderBySort"] = $strOrderBySort;

	switch($strAct):
	case "excelVisitHostKeyWord";
		// 2013.07.10 kim hee sung 소스 정리
		// SELECT  * FROM LOG_REFERER_2013 WHERE DATE_FORMAT(CONCAT(Y,'-', M,'-',D), '%Y-%m-%d')  BETWEEN DATE_FORMAT('2013-05-30', '%Y-%m-%d') AND DATE_FORMAT('2013-06-02', '%Y-%m-%d')

		require_once MALL_CONF_LIB."WebLogMgr.php";
		$webLogMgr = new WebLogMgr();

		## 설정
		$serchStartDate		= $_REQUEST['serchStartDate'];			
		$serchEndDate		= $_REQUEST['serchEndDate'];
		if(!$serchStartDate)	{ $serchStartDate = date("y-m-d");		}
		if(!$serchEndDate)		{ $serchEndDate = date("y-m-d");		}

		## 정렬 설정
		if($_REQUEST['sortType'] == "HOST_DESC")			{ $orderBy ="HOST DESC";		}
		else if($_REQUEST['sortType'] == "HOST_ASC")		{ $orderBy ="HOST ASC";			}
		else if($_REQUEST['sortType'] == "RATE_DESC")		{ $orderBy ="CNT DESC";			}
		else if($_REQUEST['sortType'] == "RATE_ASC")		{ $orderBy ="CNT ASC";			}
		else if($_REQUEST['sortType'] == "VISITCNT_DESC")	{ $orderBy ="CNT DESC";			}
		else if($_REQUEST['sortType'] == "VISITCNT_ASC")	{ $orderBy ="CNT ASC";			}
		else												{ $orderBy ="HOST DESC";		}

		## 리스트
		$param							= "";
//		$param['KEYWORD_IS_NOT_NULL']	= "Y";
		$param['YMD_START']				= $serchStartDate; 
		$param['YMD_END']				= $serchEndDate;
		$param['GROUP_BY']				= "HOST";
		$param['ORDER_BY']				= $orderBy;
		$logRefererResult				= $webLogMgr->getLogRefererList($db, "OP_LIST", $param);	

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_호스트별 방문자 분석.xls";
	break;
	case "excelVisitRefer":
		// 2013.07.10 kim hee sung 소스 정리
		// SELECT  * FROM LOG_REFERER_2013 WHERE DATE_FORMAT(CONCAT(Y,'-', M,'-',D), '%Y-%m-%d')  BETWEEN DATE_FORMAT('2013-05-30', '%Y-%m-%d') AND DATE_FORMAT('2013-06-02', '%Y-%m-%d')

		require_once MALL_CONF_LIB."WebLogMgr.php";
		$webLogMgr = new WebLogMgr();

		## 설정
		$serchStartDate		= $_REQUEST['serchStartDate'];			
		$serchEndDate		= $_REQUEST['serchEndDate'];
		if(!$serchStartDate)	{ $serchStartDate = date("y-m-d");		}
		if(!$serchEndDate)		{ $serchEndDate = date("y-m-d");		}

		## 정렬 설정
		if($_REQUEST['sortType'] == "KEYWORD_DESC")			{ $orderBy ="KEYWORD DESC";		}
		else if($_REQUEST['sortType'] == "KEYWORD_ASC")		{ $orderBy ="KEYWORD ASC";		}
		else if($_REQUEST['sortType'] == "RATE_DESC")		{ $orderBy ="CNT DESC";			}
		else if($_REQUEST['sortType'] == "RATE_ASC")		{ $orderBy ="CNT ASC";			}
		else if($_REQUEST['sortType'] == "VISITCNT_DESC")	{ $orderBy ="CNT DESC";			}
		else if($_REQUEST['sortType'] == "VISITCNT_ASC")	{ $orderBy ="CNT ASC";			}
		else												{ $orderBy ="KEYWORD DESC";		}

		## 리스트
		$param							= "";
		$param['KEYWORD_IS_NOT_NULL']	= "Y";
		$param['YMD_START']				= $serchStartDate; 
		$param['YMD_END']				= $serchEndDate;
		$param['GROUP_BY']				= "KEYWORD";
		$param['ORDER_BY']				= $orderBy;
		$logRefererResult				=	$webLogMgr->getLogRefererList($db, "OP_LIST", $param);	

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_질의어별 방문자 분석.xls";
	break;
	case "excelOrderMonthStatics":
		
		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

		$siteRow = $siteMgr->getSiteInfo($db);

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
//		$webLogMgr->setSearchSettleC($strSearchSettleC);
//		$webLogMgr->setSearchSettleA($strSearchSettleA);
//		$webLogMgr->setSearchSettleT($strSearchSettleT);
//		$webLogMgr->setSearchSettleB($strSearchSettleB);
//		$webLogMgr->setSearchSettleY($strSearchSettleY);
//		$webLogMgr->setSearchSettleX($strSearchSettleX);

		$webLogMgr->setSearchGroupMode("M");
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderSaleList = $webLogMgr->getOrderYearMonthDayList($db,$param);

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","월별매출분석").".xls";

	break;
	case "excelOrderDayStatics":
		if (!$strSearchRegStartDt) {
			$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
			$strLastWeek = strtotime("-1 week",$strTimeStamp); 
			$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
		}
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
		
		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		$webLogMgr->setSearchSettleC($strSearchSettleC);
		$webLogMgr->setSearchSettleA($strSearchSettleA);
		$webLogMgr->setSearchSettleT($strSearchSettleT);
		$webLogMgr->setSearchSettleB($strSearchSettleB);
		$webLogMgr->setSearchSettleY($strSearchSettleY);
		$webLogMgr->setSearchSettleX($strSearchSettleX);

		$webLogMgr->setSearchGroupMode("D");
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);
				
		$aryOrderSaleList = $webLogMgr->getOrderYearMonthDayList($db,$param);

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","일별매출분석").".xls";

	break;
	case "excelOrderQuarterStatics":
		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		$webLogMgr->setSearchSettleC($strSearchSettleC);
		$webLogMgr->setSearchSettleA($strSearchSettleA);
		$webLogMgr->setSearchSettleT($strSearchSettleT);
		$webLogMgr->setSearchSettleB($strSearchSettleB);
		$webLogMgr->setSearchSettleY($strSearchSettleY);
		$webLogMgr->setSearchSettleX($strSearchSettleX);
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderSaleList = $webLogMgr->getOrderYearQuarterList($db,$param);

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","분기별매출통계").".xls";


	break;

	case "excelOrderProdCateStatics":
		

		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

		$webLogMgr->setSearchGroupMode("1");
		if ($strSearchHCode1){
			$webLogMgr->setSearchGroupMode("2");
		}
		
		if ($strSearchHCode2){
			$webLogMgr->setSearchGroupMode("3");
		}
		
		if ($strSearchHCode3){
			$webLogMgr->setSearchGroupMode("4");
		}
		
		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		$webLogMgr->setSearchHCode1($strSearchHCode1);
		$webLogMgr->setSearchHCode2($strSearchHCode2);
		$webLogMgr->setSearchHCode3($strSearchHCode3);
		$webLogMgr->setSearchHCode4($strSearchHCode4);
		
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderProdCateList = $webLogMgr->getOrderProdCateList($db,$param);

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","카테고리분석").".xls";


	break;

	case "excelOrderProdStatics":
	

		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y-m-d");
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		$strProdCate = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
		$webLogMgr->setSearchProductCate($strProdCate);
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderProdList = $webLogMgr->getOrderProdList($db,$param);
		
		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","판매순위분석").".xls";

	break;

	case "excelProdBasketStatics":
	
		if (!$strSearchRegStartDt) {
			$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
			$strLastWeek = strtotime("-1 week",$strTimeStamp); 
			$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
		}
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);

		$strProdCate = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
		$webLogMgr->setSearchProductCate($strProdCate);
		
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderProdList = $webLogMgr->getProductBasketList($db,$param);		
	
		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","장바구니분석").".xls";

	break;
	case "excelProdWishStatics":
		
		if (!$strSearchRegStartDt) {
			$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
			$strLastWeek = strtotime("-1 week",$strTimeStamp); 
			$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
		}
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);

		$strProdCate = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
		$webLogMgr->setSearchProductCate($strProdCate);
		
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderProdList = $webLogMgr->getProductWishList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","상품보관함분석").".xls";

	break;
	case "excelOrderDayStatics2":
	case "excelOrderMonthStatics2":	
		
		if ($strAct == "excelOrderDayStatics2"){
			if (!$strSearchRegStartDt) {
				$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
				$strLastWeek = strtotime("-1 week",$strTimeStamp); 
				$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
			}
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
		} else {

			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";
		}

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		$webLogMgr->setSearchSettleC($strSearchSettleC);
		$webLogMgr->setSearchSettleA($strSearchSettleA);
		$webLogMgr->setSearchSettleT($strSearchSettleT);
		$webLogMgr->setSearchSettleB($strSearchSettleB);
		$webLogMgr->setSearchSettleY($strSearchSettleY);
		$webLogMgr->setSearchSettleX($strSearchSettleX);
		
		if ($strAct == "excelOrderDayStatics2") $webLogMgr->setSearchGroupMode("D");
		else $webLogMgr->setSearchGroupMode("M");

		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderSaleList = $webLogMgr->getOrderDayList($db,$param);		
		
		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","일별주문통계").".xls";
		if ($strAct == "excelOrderMonthStatics2") $strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","월별주문통계").".xls";


	break;
	case "excelOrderProdStatusStatics":	

		if (!$strSearchRegStartDt) {
			$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
			$strLastWeek = strtotime("-1 week",$strTimeStamp); 
			$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
		}
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
		$siteRow = $siteMgr->getSiteInfo($db);
		
		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		$webLogMgr->setSearchSettleC($strSearchSettleC);
		$webLogMgr->setSearchSettleA($strSearchSettleA);
		$webLogMgr->setSearchSettleT($strSearchSettleT);
		$webLogMgr->setSearchSettleB($strSearchSettleB);
		$webLogMgr->setSearchSettleY($strSearchSettleY);
		$webLogMgr->setSearchSettleX($strSearchSettleX);
		
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		if ($strSearchHCode1 || $strSearchHCode2 || $strSearchHCode3 || $strSearchHCode4){
			$param['PROD_CATE']			= "Y";
			$param['SEARCH_PROD_CATE']	= $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
		}

		$aryOrderSaleList = $webLogMgr->getOrderProdStatusList($db,$param);		
		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","상품별주문통계").".xls";

	break;
	case "excelOrderAgeStatics":	

		if (!$strSearchRegStartDt) {
			$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
			$strLastWeek = strtotime("-1 week",$strTimeStamp); 
			$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
		}
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
		$siteRow = $siteMgr->getSiteInfo($db);
		
		
		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderSaleList = $webLogMgr->getOrderAgeList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","연령별주문통계").".xls";

	break;

	case "excelOrderAreaStatics":	

		if (!$strSearchRegStartDt) {
			$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
			$strLastWeek = strtotime("-1 week",$strTimeStamp); 
			$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
		}
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
		$siteRow = $siteMgr->getSiteInfo($db);
		
		
		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderSaleList = $webLogMgr->getOrderAreaList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","지역별주문통계").".xls";

	break;

	case "excelOrderSexStatics":	

		if (!$strSearchRegStartDt) {
			$strTimeStamp = mktime(0,0,0,date("m"),date("d"),date("Y")); 
			$strLastWeek = strtotime("-1 week",$strTimeStamp); 
			$strSearchRegStartDt = date("Y-m-d",$strLastWeek);
		}
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
		$siteRow = $siteMgr->getSiteInfo($db);
		
		
		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderSaleList = $webLogMgr->getOrderSexList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","성별주문통계").".xls";

	break;

	case "excelMemberRegStatics":

		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		$aryMemberList = $webLogMgr->getMemberRegList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","회원통계").".xls";

	break;

	case "excelMemberAgeStatics":

		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		$aryMemberList = $webLogMgr->getMemberAgeList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","연령별회원통계").".xls";

	break;

	case "excelMemberAreaStatics":

		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";

		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		$aryMemberList = $webLogMgr->getMemberAreaList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","지역별통계").".xls";

	break;

	case "excelMemberSexStatics":

		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";


		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		
		$aryMemberList = $webLogMgr->getMemberSexList($db,$param);		

		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","성별통계").".xls";

	break;

	case "excelOrderMemberCateList":	
		
		if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y")."-01-01";
		if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y")."-12-31";
		
	
		$webLogMgr->setSearchRegStartDt($strSearchRegStartDt);
		$webLogMgr->setSearchRegEndDt($strSearchRegEndDt);
		$webLogMgr->setSearchSettleC($strSearchSettleC);
		$webLogMgr->setSearchSettleA($strSearchSettleA);
		$webLogMgr->setSearchSettleT($strSearchSettleT);
		$webLogMgr->setSearchSettleB($strSearchSettleB);
		$webLogMgr->setSearchSettleY($strSearchSettleY);
		$webLogMgr->setSearchSettleX($strSearchSettleX);
		
//			if ($strSearchShop) $webLogMgr->setSearchShop($strSearchShop);

		$aryOrderSaleList = $webLogMgr->getOrderMemberCateList($db,$param);	
		
		$dateYMD			= date("Ymd");
		$strExcelFileName	= "{$dateYMD}_".iconv("utf-8","euc-kr","소속별주문통계").".xls";
	break;

	endswitch;

	Header("Content-type: application/vnd.ms-excel");
	Header("Content-type: charset=utf-8");
	header("Content-Disposition: attachment; filename=".$strExcelFileName);
	Header("Content-Description: PHP4 Generated Data");
	Header("Pragma: no-cache");
	Header("Expires: 0");
	
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";

	include "{$strAct}.inc.php";

	$db->disConnect();

	exit;
?>