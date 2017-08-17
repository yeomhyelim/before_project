<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$pointMgr = new PointMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	require_once "basic.param.inc.php";

	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){

		case "memberPointExcelWrite":
			// 포인트 엑셀일괄지급

		break;

		case "pointList":
			// 포인트관리(리스트)
			
			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$_REQUEST['pageLine']){
				$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_POINT_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_POINT_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_POINT_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */

			## 관리자 서브 메뉴 권한 설정
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			if($strSearchOut == "Y") { $strLeftMenuCode02 = ""; }

			## 검색
			$strSearchQuery					= "";
			$strSearchField					= $_REQUEST['searchField'];
			$strSearchKey					= $_REQUEST['searchKey'];

			if($strSearchKey):
				// 검색어
				$arySearchField['id']			= "M.M_ID LIKE ('%{$strSearchKey}%')";														// 아이디
				$arySearchField['name']			= "(M.M_F_NAME LIKE ('%{$strSearchKey}%') OR M.M_L_NAME LIKE ('%{$strSearchKey}%'))";		// 이름
				
				$strSearchQuery					= "";
				foreach($arySearchField as $key => $val):
					if($strSearchQuery) { $strSearchQuery .= " OR "; }
					$strSearchQuery				.= $val;
				endforeach;
				if($arySearchField[$strSearchField]) { $strSearchQuery = $arySearchField[$strSearchField]; }
			endif;

			## 포인트 시작일
			$strSearchStartStartDt				= $_REQUEST['searchStartStartDt'];
			$strSearchEndStartDt				= $_REQUEST['searchEndStartDt'];
			if($strSearchRegStartDt || $strSearchRegEndDt):
				if(!$strSearchRegStartDt)	{ $strSearchRegStartDt	= "1900-01-01"; }
				if(!$strSearchRegEndDt)		{ $strSearchRegEndDt	= "2200-01-01"; }
			endif;

			## 포인트 종료일
			$strSearchExpStartDt				= $_REQUEST['searchExpStartDt'];
			$strSearchExpEndDt					= $_REQUEST['searchExpEndDt'];
			if($strSearchExpStartDt || $strSearchExpEndDt):
				if(!$strSearchExpStartDt)	{ $strSearchExpStartDt	= "1900-01-01"; }
				if(!$strSearchExpEndDt)		{ $strSearchExpEndDt	= "2200-01-01"; }
			endif;

			if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
				## 소속 검색
				if($_REQUEST['searchNation'] || $_REQUEST['searchCate1'] || $_REQUEST['searchCate2'] || $_REQUEST['searchCate3'] || $_REQUEST['searchCate4']):
					
					## 설정
					require_once MALL_CONF_LIB."memberCateMgr.php";
					$memberCateMgr			= new MemberCateMgr();

					## 검색 카테고리 설정
					$cateCode				= "";
					if($_REQUEST['searchCate1']) { $cateCode = $_REQUEST['searchCate1']; };
					if($_REQUEST['searchCate2']) { $cateCode = $_REQUEST['searchCate2']; };
					if($_REQUEST['searchCate3']) { $cateCode = $_REQUEST['searchCate3']; };
					if($_REQUEST['searchCate4']) { $cateCode = $_REQUEST['searchCate4']; };

					## 데이터
	//				$param								= "";
	//				$param['MEMBER_CATE_MGR_JOIN']		= "Y";
	//				$param['C_NATION']					= $_REQUEST['searchNation'];
	//				$param['C_CODE']					= $cateCode;
	//				$aryMemberCate						= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);		
	//				$searchMemberCate					= implode(",", $aryMemberCate);				
				endif;

				if ($a_admin_level > 0): 
				
					## 차수별 회원 소속 설정
					$searchCateCode						= $cateCode;
						
					## 설정
					require_once MALL_CONF_LIB."memberCateMgr.php";
					$memberCateMgr			= new MemberCateMgr();

					$param								= "";
					$param['C_CODE_COLUMN_ARYLIST']		= "Y";
					$param['M_NO']						= $a_admin_no;
					$cateCode							= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);
					
				endif;
			}

			## 남여 검색
			$strSearchSex						= $_REQUEST['searchSex'];

			## 적립금
			$strSearchPointStart				= $_REQUEST['searchPointStart'];
			$strSearchPointEnd					= $_REQUEST['searchPointEnd'];

			## 생년월일
			$strSearchBirthMonth				= $_REQUEST['searchBirthMonth'];
			$strSearchBirthDay					= $_REQUEST['searchBirthDay'];
			
			## 포인트 종류 검색
			$strSearchPointType					= $_REQUEST['searchPointType'];

			## 소속 국가 설정
			$strSearchNation					= $_REQUEST['searchNation'];

			## 리스트
			$param								= "";
			$param['MEMBER_MGR_JOIN']			= "Y";
			$param['COLUMN_DETAIL']				= "Y";
			$param['SEARCH_QUERY']				= $strSearchQuery;
			$param['SEARCH_CATE']				= $searchCateCode;
			$param['SEARCH_NATION']				= $strSearchNation;
			$param['PT_START_DT_BETWEEN'][0]	= $strSearchRegStartDt;
			$param['PT_START_DT_BETWEEN'][1]	= $strSearchRegEndDt;
			$param['PT_END_DT_BETWEEN'][0]		= $strSearchExpStartDt;
			$param['PT_END_DT_BETWEEN'][1]		= $strSearchExpEndDt;
			$param['M_NO_IN']					= $searchMemberCate;
			$param['M_SEX']						= $strSearchSex;
			$param['PT_POINT_BETWEEN'][0]		= $strSearchPointStart;
			$param['PT_POINT_BETWEEN'][1]		= $strSearchPointEnd;
			$param['M_BIRTH_M']					= $strSearchBirthMonth;
			$param['M_BIRTH_D']					= $strSearchBirthDay;
			$param['PT_TYPE']					= $strSearchPointType;
			$param['M_CATE']					= $cateCode;

			$intPage							= $_REQUEST['page'];
			$intTotal							= $pointMgr->getPointListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수 
			$intPageLine						= ($_REQUEST['pageLine'])	? $_REQUEST['pageLine']	: 50;																	// 리스트 개수 
			$intPage							= ( $intPage )				? $intPage		: 1;
			$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
//			$param['TE_WRITE_TOTAL_COLUMN']		= "Y";
			$param['ORDER_BY']					= "PT.PT_NO DESC";
			$param['LIMIT']						= "{$intFirst},{$intPageLine}";
			$result								= $pointMgr->getPointListEx($db, "OP_LIST", $param);
			$intPageBlock						= 10;																		// 블럭 개수 
			$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage							= ceil( $intTotal / $intPageLine );

			## 포인트 종류 배열
			$aryPointTypeList = getCommCodeList('point');

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

			## 포인트 총합 리스트
			$param['ORDER_BY']					= "";
			$param['LIMIT']						= "";
			$pointSumRow = $pointMgr->getPointSumListEx($db, "OP_SELECT", $param);
			//echo $db->query;
			
			## 소속 포인트 총합 리스트
			if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
				if ($param['M_CATE']){
					$pointCateSumRow = $pointMgr->getPointCateSum($db,"OP_SELECT",$param);
				}
			}
		break;

// 2013.08.08 kim hee sung 소속 추가 하면서, 소스 정리.
//		case "pointList":
//			
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "";
//			$strLeftMenuCode02 = "";
//			/* 관리자 Sub Menu 권한 설정 */
//
//			$pointMgr->setSearchKey($strSearchKey);
//			$pointMgr->setSearchField($strSearchField);
//			$pointMgr->setSearchPointType($strSearchPointType);
//			$pointMgr->setSearchSex($strSearchSex);
//			$pointMgr->setSearchRegStartDt($strSearchRegStartDt);
//			$pointMgr->setSearchRegEndDt($strSearchRegEndDt);
//			$pointMgr->setSearchExpStartDt($strSearchExpStartDt);
//			$pointMgr->setSearchExpEndDt($strSearchExpEndDt);
//			$pointMgr->setSearchPointStart($strSearchPointStart);
//			$pointMgr->setSearchPointEnd($strSearchPointEnd);
//			$pointMgr->setSearchBirthMonth($strSearchBirthMonth);
//			$pointMgr->setSearchBirthDay($strSearchBirthDay);
//
//			/* 데이터 리스트 */
//			$intTotal								= $pointMgr->getPointList( $db, "OP_COUNT" );										// 데이터 전체 개수 
//
//			$intPageLine							= ( $intPageLine )			? $intPageLine	: 10;									// 리스트 개수 
//			$intPage								= ( $intPage )				? $intPage		: 1;
//			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
//			$pointMgr->setLimitFirst($intFirst);
//			$pointMgr->setPageLine($intPageLine);
//
//			$result									= $pointMgr->getPointList( $db, "OP_LIST" );
//
//			$intPageBlock							= 10;																		// 블럭 개수 
//			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
//			$intTotPage								= ceil( $intTotal / $intPageLine );
//			/* 데이터 리스트 */	
//				
//			$pointSumRow							= $pointMgr->getPointList( $db, "OP_SUM" );
//			
//			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
//			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
//			$linkPage .= "&searchPointType=$strSearchPointType&pageLine=$intPageLine";
//			$linkPage .= "&page=";
//
//			/* 포인트 종류 배열 */
//			$aryPointTypeList = getCommCodeList('point');
//
//		break;


	}
?>