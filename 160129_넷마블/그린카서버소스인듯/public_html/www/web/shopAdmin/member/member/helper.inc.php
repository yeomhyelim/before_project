<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	require_once "basic.param.inc.php";

	if (!$strSearchSex) $strSearchSex = "T";
	if (!$strSearchMailYN) $strSearchMailYN = "T";
	if (!$strSearchSmsYN) $strSearchSmsYN = "T";
	if ($strSearchBirthMonth && $strSearchBirthDay) $strSearchBirth = $strSearchBirthMonth."-".$strSearchBirthDay;
	if ($strSearchGroup){
		$arySearchGroup = explode(",",str_replace("'","",$strSearchGroup));
	}

	/* 리스트 페이지 라인 쿠키 설정 */
	if (!$intPageLine){
		$intPageLine = $_COOKIE["COOKIE_ADM_MEM_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_MEM_LIST_LINE"] : 10;
	} else {
		setCookie("COOKIE_ADM_MEM_LIST_LINE",$intPageLine,time()+(86400 * 30),"/shopAdmin");
	}
	/* 리스트 페이지 라인 쿠키 설정 */

	$siteRow = $siteMgr->getSiteInfo($db);
	/*##################################### Parameter 셋팅 #####################################*/

	## 국가 LIST
	$aryCountryList		= getCountryList();
	$aryCountryState	= getCommCodeList("STATE","");

	
	## 언어 설정
	$aryUseLng			= explode("/", $S_USE_LNG);


	switch($strMode){
		case "memberList":
			// 회원 리스트

			## 관리자 서브 메뉴 권한 설정
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			if($strSearchOut == "Y") { $strLeftMenuCode02 = "002"; }

			## 메뉴 타이틀 설정
			$strMenuTitle	   = $LNG_TRANS_CHAR["MW00001"];
			if($strSearchOut == "Y") { 	$strMenuTitle  = $LNG_TRANS_CHAR["MW00099"]; }

			## 키워드 검색
			$strSearchQuery					= "";
			$strSearchField					= $_REQUEST['searchField'];
			$strSearchKey					= $_REQUEST['searchKey'];
			
			if($strSearchKey):
				// 검색어
				$arySearchField['id']			= "M.M_ID LIKE ('%{$strSearchKey}%')";														// 아이디
				$arySearchField['name']			= "(M.M_F_NAME LIKE ('%{$strSearchKey}%') OR M.M_L_NAME LIKE ('%{$strSearchKey}%'))";		// 이름
				$arySearchField['nick']			= "M.M_NICK_NAME LIKE ('%{$strSearchKey}%')";												// 닉네임
				$arySearchField['email']		= "M.M_MAIL LIKE ('%{$strSearchKey}%')";													// 이메일
				$arySearchField['phone']		= "M.M_PHONE LIKE ('%{$strSearchKey}%')";													// 전화번호
				$arySearchField['fax']			= "M.M_FAX LIKE ('%{$strSearchKey}%')";														// 팩스번호
				$arySearchField['hp']			= "M.M_HP LIKE ('%{$strSearchKey}%')";														// 휴대폰
				$arySearchField['zip']			= "M.M_ZIP LIKE ('%{$strSearchKey}%')";														// 우편번호
				$arySearchField['address']		= "(M.M_ADDR LIKE ('%{$strSearchKey}%') OR M.M_ADDR2 LIKE ('%{$strSearchKey}%'))";			// 주소
				if ($S_JOIN_TMP_1["USE"] == "Y"){
					$arySearchField['tmp1']		= "MA.M_TMP1 LIKE ('%{$strSearchKey}%')";													// 임시컬럼
				}

				$strSearchQuery					= "";
				foreach($arySearchField as $key => $val):
					if($strSearchQuery) { $strSearchQuery .= " OR "; }
					$strSearchQuery				.= $val;
				endforeach;
				if($arySearchField[$strSearchField]) { $strSearchQuery = $arySearchField[$strSearchField]; }
			endif;
			
			## 기간 설정
			$strSearchRegStartOption			= $_REQUEST['searchRegStartOption'];
			$strSearchRegStartDt				= $_REQUEST['searchRegStartDt'];
			$strSearchRegEndDt					= $_REQUEST['searchRegEndDt'];
			if($strSearchRegStartOption == "editDay"):
				if($strSearchRegStartDt || $strSearchRegEndDt):
					if(!$strSearchRegStartDt)	{ $strSearchRegStartDt	= "1900-01-01"; }
					if(!$strSearchRegEndDt)		{ $strSearchRegEndDt	= "2200-01-01"; }
				endif;
			endif;

			## 구매기간 설정
			$strSearchOrderRegStartDt				= $_REQUEST['searchOrderRegStartDt'];
			$strSearchOrderRegEndDt					= $_REQUEST['searchOrderRegEndDt'];
			if($strSearchOrderRegStartDt || $strSearchOrderRegEndDt):
				$strOStatus						= "E";
				$strOrderMgrJoin				= "Y";
				if(!$strSearchOrderRegStartDt)		{ $strSearchOrderRegStartDt		= "1900-01-01"; }
				if(!$strSearchOrderRegEndDt)		{ $strSearchOrderRegEndDt		= "2200-01-01"; }
			endif;


//			## 기간 설정
//			$strSearchRegStartOption			= $_REQUEST['searchRegStartOption'];
//			$strSearchRegStartDt				= $_REQUEST['searchRegStartDt'];
//			$strSearchRegEndDt					= $_REQUEST['searchRegEndDt'];
//			if($strSearchRegStartOption == "editDay"):
//				if($strSearchRegStartDt || $strSearchRegEndDt):
//					if(!$strSearchRegStartDt)	{ $strSearchRegStartDt	= "1900-01-01"; }
//					if(!$strSearchRegEndDt)		{ $strSearchRegEndDt	= "2200-01-01"; }
//				endif;
//			endif;

			## 최종 로그인 설정
			$strSearchLastLoginOption			= $_REQUEST['searchLastLoginOption'];
			$strSearchLastLoginStartDt			= $_REQUEST['searchLastLoginStartDt'];
			$strSearchLastLoginEndDt			= $_REQUEST['searchLastLoginEndDt'];
			if($strSearchLastLoginOption == "editDay"):
				if($strSearchLastLoginStartDt || $strSearchLastLoginEndDt):
					if(!$strSearchLastLoginStartDt)		{ $strSearchLastLoginStartDt	= "1900-01-01"; }
					if(!$strSearchLastLoginEndDt)		{ $strSearchLastLoginEndDt	= "2200-01-01"; }
				endif;
			endif;

			## 방문횟수
			$strSearchVisitStartCnt				= $_REQUEST['searchVisitStartCnt'];
			$strSearchVisitEndCnt				= $_REQUEST['searchVisitEndCnt'];
			if($strSearchVisitStartCnt || $strSearchVisitEndCnt):
				if(!$strSearchVisitStartCnt)		{ $strSearchVisitStartCnt		= "0";				}
				if(!$strSearchVisitEndCnt)			{ $strSearchVisitEndCnt			= "99999999999";	}
			endif;

			## 남여 검색
			$strSearchSex						= $_REQUEST['searchSex'];

			## 메일수신여부 검색
			$strSearchMailYN					= $_REQUEST['searchMailYN'];

			## SMS수신여부 검색
			$strSearchSmsYN						= $_REQUEST['searchSmsYN'];

			## 회원그룹 검색
			//$strSearchGroup					= $_REQUEST['searchGroup'];
			$searchMemberGroup1					= $_REQUEST['searchMemberGroup1'];
			$searchMemberGroup2					= $_REQUEST['searchMemberGroup2'];
			$searchMemberGroupWhere = "";
			$k=0;
			for($i=1; $i <= 2; $i++)
			{
				${"searchMemberGroup".$i}				= $_REQUEST['searchMemberGroup'.$i];
				if(${"searchMemberGroup".$i})
				{
					if($k != 0 ) $searchMemberGroupWhere .= ","; 
					$searchMemberGroupWhere .= "'"; 
					$searchMemberGroupWhere .= ${"searchMemberGroup".$i}; 
					$searchMemberGroupWhere .= "'"; 
					$k++;
				}
			}


			## 접속 사이트 검색
			$aryUseLngCnt = sizeof($aryUseLng);
			$searchLangWhere = "";
			$k=0;
			for($i=0; $i < $aryUseLngCnt; $i++)
			{
				${"searchLang".$i}				= $_REQUEST['searchLang'.$i];
				if(${"searchLang".$i})
				{
					if($k != 0 ) $searchLangWhere .= ","; 
					$searchLangWhere .= "'"; 
					$searchLangWhere .= ${"searchLang".$i}; 
					$searchLangWhere .= "'"; 
					$k++;
				}
			}

			## 소속 국가 설정
			$strSearchNation					= $_REQUEST['searchNation'];

			## 추천인 검색
			if($_REQUEST['searchRecId']):
				$param							= "";
				$param['M_ID']					= $_REQUEST['searchRecId'];
				$row							= $memberMgr->getMemberListEx($db, "OP_SELECT", $param);
				$strSearchRecId					= $row['M_NO'];
			endif;

			## 생년월일
			$strSearchBirthMonth				= $_REQUEST['searchBirthMonth'];
			$strSearchBirthDay					= $_REQUEST['searchBirthDay'];

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

			## 리스트
			$param								= "";
			$param['MEMBER_COLUMN_DETAIL']		= "Y";
			$param['MEMBER_GROUP_JOIN']			= "Y";
			$param['MEMBER_MGR_SELF_JOIN']		= "Y";
			$param['ORDER_MGR_JOIN']			=  $strOrderMgrJoin;

			$param['SEARCH_QUERY']				= $strSearchQuery;
			$param['SEARCH_CATE']				= $searchCateCode;
			$param['SEARCH_NATION']				= $strSearchNation;
			$param['M_REG_DT_BETWEEN'][0]		= $strSearchRegStartDt;
			$param['M_REG_DT_BETWEEN'][1]		= $strSearchRegEndDt;
			$param['O_REG_DT_BETWEEN'][0]		= $strSearchOrderRegStartDt;
			$param['O_REG_DT_BETWEEN'][1]		= $strSearchOrderRegEndDt;
			$param['M_LOGIN_DT_BETWEEN'][0]		= $strSearchLastLoginStartDt;
			$param['M_LOGIN_DT_BETWEEN'][1]		= $strSearchLastLoginEndDt;
			$param['M_VISIT_CNT_BETWEEN'][0]	= $strSearchVisitStartCnt;
			$param['M_VISIT_CNT_BETWEEN'][1]	= $strSearchVisitEndCnt; 
			$param['M_SEX']						= $strSearchSex;
			$param['M_MAILYN']					= $strSearchMailYN;
			$param['M_SMSYN']					= $strSearchSmsYN;
			$param['M_GROUP_IN']				= $searchMemberGroupWhere;
			$param['M_REC_ID']					= $strSearchRecId;
			$param['M_BIRTH_M']					= $strSearchBirthMonth;
			$param['M_BIRTH_D']					= $strSearchBirthDay;
			$param['M_CATE']					= $cateCode;
			$param['M_OUT']						= $strSearchOut;
			$param['O_STATUS']					= $strOStatus;
			$param['M_LNG_IN']						= $searchLangWhere;
			//$param['M_GROUP']					= $searchMemberGroupWhere;

			/* 추가옵션을 검색에서 사용하고 싶을때 */
			if ($S_JOIN_TMP_1["USE"] == "Y"){
				$param['MEMBER_ADD_MGR_JOIN']	= "Y";
			}
			
			$intPage							= $_REQUEST['page'];
			$intTotal							= $memberMgr->getMemberListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수
			//echo $db->query;
			$intPageLine						= $_REQUEST['pageLine'];
			$intPageLine						= ( $intPageLine )			? $intPageLine	: 10;							// 리스트 개수 
			$intPage							= ( $intPage )				? $intPage		: 1;
			$intFirst							= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$param['TE_WRITE_TOTAL_COLUMN']		= "Y";
			$param['ORDER_BY']					= $strSearchOrderSortCol;													// 정렬 컬럼
			$param['ORDER_SORT']				= $strSearchOrderSort;														// 정렬 방법
			
			$param['LIMIT']						= "{$intFirst},{$intPageLine}";
			$result								= $memberMgr->getMemberListEx($db, "OP_LIST", $param);
//			echo $db->query;

			$intPageBlock						= 10;																		// 블럭 개수 
			$intListNum							= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage							= ceil( $intTotal / $intPageLine );

			## 회원그룹
			$param								= "";
			$param['S_MALL_TYPE ']				= $S_MALL_TYPE;
			$aryMemberGroup						= $memberMgr->getGroupListEx($db, "OP_ARYTOTAL", $param);

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

			//회원등급목록
			$aryGroupList = $memberMgr->getGroupList($db);
			if($aryGroupList){
				for($i=0; $i < sizeof($aryGroupList);$i++){
					$aryGroupName[$aryGroupList[$i][G_CODE]] = $aryGroupList[$i][G_NAME];
				}
			}
			
			//국가목록
			$aryCountryListTotalAry		= getCountryListTotalAry();

			for($i=0;$i< sizeof($aryCountryListTotalAry) ; $i++){
					$aryCountryList[$aryCountryListTotalAry[$i][CT_CODE]] = $aryCountryListTotalAry[$i]["CT_NAME_{$strAdmSiteLng}"];
			}

//			/* 회원수 */
			$memberTotRow = $memberMgr->getMemberTotalCnt($db);
			
			/* 회원가입기본정보 */
			$settingRow = $memberMgr->getSettingView($db);

		break;
//		2013.08.07 kim hee sung 소속 검색 추가하면서 소스 정리
//		case "memberList":
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "001";
//			$strLeftMenuCode02 = "001";
//			$strMenuTitle	   = $LNG_TRANS_CHAR["MW00001"];
//			if ($strSearchOut == "Y"){
//				$strLeftMenuCode02 = "002";
//				$strMenuTitle  = $LNG_TRANS_CHAR["MW00099"];
//			}
//			/* 관리자 Sub Menu 권한 설정 */
//
//
//			/* 검색부분 */
//			if (!$strSearchOrderSortCol) $strSearchOrderSortCol = "";
//			if (!$strSearchOrderSort) $strSearchOrderSort = "desc";
//			
//			$memberMgr->setSearchOrderSortCol($strSearchOrderSortCol);
//			$memberMgr->setSearchOrderSort($strSearchOrderSort);
//
//			$memberMgr->setSearchOut($strSearchOut);
//			$memberMgr->setSearchField($strSearchField);
//			$memberMgr->setSearchKey($strSearchKey);
//			$memberMgr->setSearchRegStartDt($strSearchRegStartDt);
//			$memberMgr->setSearchRegEndDt($strSearchRegEndDt);
//			$memberMgr->setSearchLastLoginStartDt($strSearchLastLoginStartDt);
//			$memberMgr->setSearchLastLoginEndDt($strSearchLastLoginEndDt);
//			$memberMgr->setSearchVisitStartCnt($strSearchVisitStartCnt);
//			$memberMgr->setSearchVisitEndCnt($strSearchVisitEndCnt);
//			$memberMgr->setSearchSex($strSearchSex);
//			$memberMgr->setSearchMailYN($strSearchMailYN);
//			$memberMgr->setSearchSmsYN($strSearchSmsYN);
//			$memberMgr->setSearchBirth($strSearchBirth);
//			$memberMgr->setSearchRecId($strSearchRecId);
//			$memberMgr->setSearchOutStartDt($strSearchOutStartDt);
//			$memberMgr->setSearchOutEndDt($strSearchOutEndDt);			
//			$memberMgr->setSearchGroup($strSearchGroup);
//
//			if ($a_admin_tm == "Y"){
//				$memberMgr->setSearchTmId($a_admin_id);
//			}
//
//			/* 검색부분 */
//
//			$intPageBlock	= 10;
//			//$intPageLine	= 10;
//			if(!$intPageLine) $intPageLine = 10;	
//			$memberMgr->setPageLine($intPageLine);
//	
//			$intTotal	= $memberMgr->getMemberTotal($db);
//			$intTotPage	= ceil($intTotal / $memberMgr->getPageLine());
//
//			if(!$intPage)	$intPage =1;
//
//			if ($intTotal==0) {
//				$intFirst	= 1;
//				$intLast	= 0;			
//			} else {
//				$intFirst	= $intPageLine *($intPage -1);
//				$intLast	= $intPageLine * $intPage;
//			}
//			$memberMgr->setLimitFirst($intFirst);
//
//			$result = $memberMgr->getMemberList($db);
//			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
//			
//			/* 회원가입관리 설정 */
//			$settingRow = $memberMgr->getSettingView($db);
//		
//			/* 회원그룹 */
//			$aryMemberGroup = $memberMgr->getGroupList($db);
//			
//			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
//			$linkPage .= "&searchOut=$strSearchOut&searchField=$strSearchField&searchKey=$strSearchKey";
//			$linkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
//			$linkPage .= "&searchOutStartDt=$strSearchOutStartDt&searchOutEndDt=$strSearchOutEndDt";
//			$linkPage .= "&searchLastLoginStartDt=$strSearchLastLoginStartDt&searchLastLoginEndDt=$strSearchLastLoginEndDt";
//			$linkPage .= "&searchVisitStartCnt=$strSearchVisitStartCnt&searchVisitEndCnt=$strSearchVisitEndCnt";
//			$linkPage .= "&searchSex=$strSearchSex&searchMailYN=$strSearchMailYN";
//			$linkPage .= "&searchSmsYN=$strSearchSmsYN&searchBirthMonth=$strSearchBirthMonth";
//			$linkPage .= "&searchBirthDay=$strSearchBirthDay&searchRecId=$strSearchRecId";			
//			/** 2013.05.30 배열 파라미터 추가 **/
//			foreach($_REQUEST['searchGroup'] as $searchGroup):
//				$linkPage .= "&searchGroup[]={$searchGroup}";	
//			endforeach;
//			
//			$linkPage .= "&page=";
//			
//			/* 회원수 */
//			$memberTotRow = $memberMgr->getMemberTotalCnt($db);
//
//		break;

	}

	
?>