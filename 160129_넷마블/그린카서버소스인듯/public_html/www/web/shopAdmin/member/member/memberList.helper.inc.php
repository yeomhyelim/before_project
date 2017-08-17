<?
			## 키워드 검색
			$strSearchQuery					= "";
			$strSearchField					= $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
			$strSearchKey					= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
			
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
				
				$strSearchQuery					= "";
				foreach($arySearchField as $key => $val):
					if($strSearchQuery) { $strSearchQuery .= " OR "; }
					$strSearchQuery				.= $val;
				endforeach;
				if($arySearchField[$strSearchField]) { $strSearchQuery = $arySearchField[$strSearchField]; }
			endif;
			
			## 기간 설정
			$strSearchRegStartOption			= $_POST["searchRegStartOption"]	? $_POST["searchRegStartOption"]	: $_REQUEST["searchRegStartOption"];
			$strSearchRegStartDt				= $_POST["searchRegStartDt"]		? $_POST["searchRegStartDt"]		: $_REQUEST["searchRegStartDt"];
			$strSearchRegEndDt					= $_POST["searchRegEndDt"]			? $_POST["searchRegEndDt"]			: $_REQUEST["searchRegEndDt"];
			if($strSearchRegStartOption == "editDay"):
				if($strSearchRegStartDt || $strSearchRegEndDt):
					if(!$strSearchRegStartDt)	{ $strSearchRegStartDt	= "1900-01-01"; }
					if(!$strSearchRegEndDt)		{ $strSearchRegEndDt	= "2200-01-01"; }
				endif;
			endif;

			## 최종 로그인 설정
			$strSearchLastLoginOption			= $_POST["searchLastLoginOption"]	? $_POST["searchLastLoginOption"]	: $_REQUEST["searchLastLoginOption"];
			$strSearchLastLoginStartDt			= $_POST["searchLastLoginStartDt"]	? $_POST["searchLastLoginStartDt"]	: $_REQUEST["searchLastLoginStartDt"];
			$strSearchLastLoginEndDt			= $_POST["searchLastLoginEndDt"]	? $_POST["searchLastLoginEndDt"]	: $_REQUEST["searchLastLoginEndDt"];
			if($strSearchLastLoginOption == "editDay"):
				if($strSearchLastLoginStartDt || $strSearchLastLoginEndDt):
					if(!$strSearchLastLoginStartDt)		{ $strSearchLastLoginStartDt	= "1900-01-01"; }
					if(!$strSearchLastLoginEndDt)		{ $strSearchLastLoginEndDt	= "2200-01-01"; }
				endif;
			endif;

			## 방문횟수
			$strSearchVisitStartCnt				= $_POST["searchVisitStartCnt"]	? $_POST["searchVisitStartCnt"]	: $_REQUEST["searchVisitStartCnt"];
			$strSearchVisitEndCnt				= $_POST["searchVisitEndCnt"]	? $_POST["searchVisitEndCnt"]	: $_REQUEST["searchVisitEndCnt"];
			if($strSearchVisitStartCnt || $strSearchVisitEndCnt):
				if(!$strSearchVisitStartCnt)		{ $strSearchVisitStartCnt		= "0";				}
				if(!$strSearchVisitEndCnt)			{ $strSearchVisitEndCnt			= "99999999999";	}
			endif;

			## 남여 검색
			$strSearchSex						= $_POST["searchSex"]	? $_POST["searchSex"]		: $_REQUEST["searchSex"];

			## 메일수신여부 검색
			$strSearchMailYN					= $_POST["searchMailYN"]? $_POST["searchMailYN"]	: $_REQUEST["searchMailYN"];

			## SMS수신여부 검색
			$strSearchSmsYN						= $_POST["searchSmsYN"]	? $_POST["searchSmsYN"]		: $_REQUEST["searchSmsYN"];

			## 회원그룹 검색
			$strSearchGroup						= $_POST["searchGroup"]	? $_POST["searchGroup"]		: $_REQUEST["searchGroup"];
			
			## 추천인 검색
			$strSearchRecId						= $_POST["searchRecId"]	? $_POST["searchRecId"]		: $_REQUEST["searchRecId"];
			if($strSearchRecId):
				$param							= "";
				$param['M_ID']					= $strSearchRecId;
				$row							= $memberMgr->getMemberListEx($db, "OP_SELECT", $param);
				$strSearchRecId					= $row['M_NO'];
			endif;

			## 생년월일
			$strSearchBirthMonth				= $_POST["searchBirthMonth"]	? $_POST["searchBirthMonth"]	: $_REQUEST["searchBirthMonth"];
			$strSearchBirthDay					= $_POST["searchBirthDay"]		? $_POST["searchBirthDay"]		: $_REQUEST["searchBirthDay"];

			## 소속 검색
			$strSearchNation					= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
			$strSearchCate1						= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
			$strSearchCate2						= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
			$strSearchCate3						= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
			$strSearchCate4						= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
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
				$param['C_NATION']					= $strSearchNation;
				$param['C_CODE']					= $cateCode;
			
			elseif ($a_admin_level > 0): 
			
				## 차수별 회원 소속 설정
					
				## 설정
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();

				$param								= "";
				$param['C_CODE_COLUMN_ARYLIST']		= "Y";
				$param['M_NO']						= $a_admin_no;
				$cateCode							= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);
				
			endif;
			
			## 체크된 회원 리스트
			$aryChkMemberNoList						= $_POST["chkNo"]			? $_POST["chkNo"]			: $_REQUEST["chkNo"];
			if (is_array($aryChkMemberNoList)){
				$strChkMemberNoList					= "";
				foreach($aryChkMemberNoList as $value){
					$strChkMemberNoList	= $value.",";
				}

				if ($strChkMemberNoList) {$strChkMemberNoList = substr($strChkMemberNoList,0,strlen($strChkMemberNoList)-1);}
			}

			## 리스트
			$param								= "";
			$param['MEMBER_COLUMN_DETAIL']		= "Y";
			$param['MEMBER_GROUP_JOIN']			= "Y";
			$param['MEMBER_MGR_SELF_JOIN']		= "Y";
			$param['SEARCH_QUERY']				= $strSearchQuery;
			$param['M_REG_DT_BETWEEN'][0]		= $strSearchRegStartDt;
			$param['M_REG_DT_BETWEEN'][1]		= $strSearchRegEndDt;
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
			$param['M_NO']						= $strChkMemberNoList;
			
			if (!$strLinkPageStr) $strLinkPageStr = "page";
			$intMemPage							= ($_POST[$strLinkPageStr])	? $_POST[$strLinkPageStr]	: $_REQUEST[$strLinkPageStr];
			$intMemPage							= ($intMemPage)				? $intMemPage				: 1;
			$intMemPageLine						= ($_POST["pageLine"])		? $_POST["pageLine"]		: $_REQUEST["pageLine"];	// 리스트 개수 
			if (!$intMemPageLine) $intMemPageLine = 10;

			$intMemTotal						= $memberMgr->getMemberListEx($db, "OP_COUNT", $param);						// 데이터 전체 개수 
			
			$intMemFirst						= ($intMemTotal == 0)		? 0						: $intMemPageLine * ( $intMemPage - 1 );

			$param['ORDER_BY']					= $arySortType[$sortType];

			## 검색시 전체 검색
			if (!$strSearchTotalLimitYN || $strSearchTotalLimitYN != "Y"){
				$param['LIMIT']					= "{$intMemFirst},{$intMemPageLine}";
			}

			$result								= $memberMgr->getMemberListEx($db, "OP_LIST", $param);

			$intPageBlock						= 10;																		// 블럭 개수 
			$intMemListNum						= $intMemTotal - ( $intMemPageLine * ( $intMemPage - 1 ) );							// 번호
			$intMemTotPage						= ceil( $intMemTotal / $intMemPageLine );
			
			## 회원그룹
			$param								= "";
			$param['S_MALL_TYPE ']				= $S_MALL_TYPE;
			$aryMemberGroup						= $memberMgr->getGroupListEx($db, "OP_ARYTOTAL", $param);

			## 페이징 링크 주소
			$queryString		= explode("&", $_SERVER['QUERY_STRING']);
			$memLinkPage		= "";
			$strMemLinkStr		= ($strLinkPageStr) ? $strLinkPageStr : "page";	
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == $strMemLinkStr)	{ continue; }
				if($memLinkPage)		{ $memLinkPage .= "&"; }
				$memLinkPage	.= $string;
			endforeach;
			$memLinkPage		= "./?{$memLinkPage}&".$strMemLinkStr."=";
	//		echo $db->query;
?>