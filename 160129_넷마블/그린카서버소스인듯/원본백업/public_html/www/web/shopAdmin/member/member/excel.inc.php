<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."memberCateMgr.php";

	$orderMgr = new OrderMgr();
	$siteMgr = new SiteMgr();
	$memberMgr = new MemberMgr();
	$memberCateMgr = new MemberCateMgr();

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
	endif;	

	/*##################################### Parameter 셋팅 #####################################*/
	require_once "basic.param.inc.php";
	
	if (!$strSearchSex) $strSearchSex = "T";
	if (!$strSearchMailYN) $strSearchMailYN = "T";
	if (!$strSearchSmsYN) $strSearchSmsYN = "T";
	if ($strSearchBirthMonth && $strSearchBirthDay) $strSearchBirth = $strSearchBirthMonth."-".$strSearchBirthDay;
	if (is_array($arySearchGroup)){
		$strSearchGroup = "";
		for($i=0;$i<sizeof($arySearchGroup);$i++){
			$strSearchGroup .= "'".$arySearchGroup[$i]."',";
		}

		if ($strSearchGroup) $strSearchGroup = SUBSTR($strSearchGroup,0,STRLEN($strSearchGroup)-1);		
	}

	$siteRow = $siteMgr->getSiteInfo($db);

	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strAct){

		case "excelMemberProdReportList":

			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_관리자상담관리"); 

		break;

		case "excelMemberList":
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
			$strSearchGroup						= $_REQUEST['searchGroup'];

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
			$param['M_GROUP_IN']				= $strSearchGroup;
			$param['M_REC_ID']					= $strSearchRecId;
			$param['M_BIRTH_M']					= $strSearchBirthMonth;
			$param['M_BIRTH_D']					= $strSearchBirthDay;
			$param['M_CATE']					= $cateCode;
			$param['M_OUT']						= $strSearchOut;
			$param['O_STATUS']					= $strOStatus;

			/* 추가옵션을 검색에서 사용하고 싶을때 */
			if ($S_JOIN_TMP_1["USE"] == "Y"){
				$param['MEMBER_ADD_MGR_JOIN']	= "Y";
			}
			
			$intPage							= $_REQUEST['page'];
			$intTotal							= $memberMgr->getMemberListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수
//			echo $db->query;

			$param['TE_WRITE_TOTAL_COLUMN']		= "Y";
			$param['ORDER_BY']					= $strSearchOrderSortCol;													// 정렬 컬럼
			$param['ORDER_SORT']				= $strSearchOrderSort;														// 정렬 방법
			
			$result								= $memberMgr->getMemberListEx($db, "OP_LIST", $param);
//			echo $db->query;

			## 회원그룹
			$param								= "";
			$param['S_MALL_TYPE ']				= $S_MALL_TYPE;
			$aryMemberGroup						= $memberMgr->getGroupListEx($db, "OP_ARYTOTAL", $param);		
		
			/* 사용자 항목 */
			$memberMgr->setJI_GB("U");
			$aryUserItemList = $memberMgr->getJoinItemList($db);
						
			/* 사업자 항목 */
			$memberMgr->setJI_GB("S");
			$aryBusiItemList = $memberMgr->getJoinItemList($db);

			/* 추가 항목 */
			$memberMgr->setJI_GB("A");
			$aryAddItemList = $memberMgr->getJoinItemList($db);

			/* 사용자생성 임시 항목 */
			$memberMgr->setJI_GB("T");
			$aryTempItemList = $memberMgr->getJoinItemList($db);

			/* 외국인 항목 */
			$memberMgr->setJI_GB("F");
			$aryForItemList = $memberMgr->getJoinItemList($db);
			
//			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_회원리스트"); 
			$strExcelFileName = date("Ymd")."_회원리스트.xls"; 
		break;

	}
?>