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

	switch($strAct){

		case "excelPointList":
			// 포인트관리(리스트)
			
			if ($S_FIX_MEMBER_CATE_USE_YN  == "Y")
			{		
				## 회원소속관리 불러오기
				$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
				//include_once $fileName;
				//member.cate.inc.php 파일 자체가 아예 없음.
				if(is_file($fileName)):
					require_once "$fileName";
				endif;
			}

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

			
			$param['ORDER_BY']					= "PT.PT_NO DESC";
			$result								= $pointMgr->getPointListEx($db, "OP_LIST", $param);
			
			## 포인트 종류 배열
			$aryPointTypeList = getCommCodeList('point');

			$strExcelFileName = date("Ymd")."_포인트리스트.xls"; 


		break;
	}
?>