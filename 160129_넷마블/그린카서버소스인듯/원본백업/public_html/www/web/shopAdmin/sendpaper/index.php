<?
	require_once "_function.lib.inc.php";
	require_once "_postPaperField.inc.php";
	require_once "_postPaperSetting.inc.php";

	## 1차 메뉴 설정(관리자 Top 메뉴 권한 설정)
	$strTopMenuCode = "003"; // 임시 메뉴 차후 변경이 필요합니다.


	switch($strMode) :
		case "sendPaperMultiWrite":
			// 쪽지 쓰기
			$param['MP_NO_IN']		= $_REQUEST["mp_no"];
			$paperRow				= $memberPaperMgr->getMemberPaperSelectEx($db, "OP_ARRY_TOTAL", $param);
		break;

		case "sendPaperWrite":
			// 쪽지 쓰기
			$param['MP_NO']			= $_REQUEST["mp_no"];
			$paperRow				= $memberPaperMgr->getMemberPaperSelectEx($db, "OP_SELECT", $param);


		break;

		case "receivePaperView":
			// 받은 쪽지 보기
			
			## STEP 1
			## 2,3차 메뉴 설정(관리자 Sub Menu 권한 설정)
			$strLeftMenuCode01 = "001";		// 임시 메뉴 차후 변경이 필요합니다.
			$strLeftMenuCode02 = "";		// 임시 메뉴 차후 변경이 필요합니다.

			## STEP 2
			## 데이터 불러오기
			$param['MP_NO']			= $_REQUEST["mp_no"];
			$paperRow				= $memberPaperMgr->getMemberPaperSelectEx($db, "OP_SELECT", $param);

		break;

		case "receivePaperList":
			// 받은 쪽지 리스트

			## 설정
			$m_no = $_SESSION["ADMIN_NO"];

			## 입점몰 회원이 접속한 경우, 최고 관리자 회원 번호를 가져온다.
			if($a_admin_type == "S" && $a_admin_shop_no):
				require_once MALL_CONF_LIB."ShopMgr.php";
				$shopMgr				= new ShopMgr();

				$param					= "";
				$param['sh_no']			= $a_admin_shop_no;
				$param['su_type']		= "A";
				$shopUserRow			= $shopMgr->getShopUserListEx($db, "OP_SELECT", $param);
				$m_no					= $shopUserRow['M_NO'];
			endif;

			## 받은 쪽지 리스트
			$param['MP_TO_M_NO']	= $m_no;
			$param['MP_DEL_YN']		= "N";
			$param['ORDER_BY']		= "MP_REG_DT DESC";
//			$paperResult			= $memberPaperMgr->getMemberPaperSelectEx($db, "OP_LIST", $param);
//			print_r($db->query);

			## 리스트
			$intTotal				= $memberPaperMgr->getMemberPaperSelectEx($db, "OP_COUNT", $param);			// 데이터 전체 개수 
			$intPageLine			= 10;																		// 리스트 개수 
			$intPage				= ( $intPage )				? $intPage		: 1;
			$intFirst				= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

//			$param					= "";
			$param['ORDER_BY']		= $arySortType[$sortType];
			$param['LIMIT']			= "{$intFirst},{$intPageLine}";
			$paperResult			= $memberPaperMgr->getMemberPaperSelectEx($db, "OP_LIST", $param);

			$intPageBlock			= 10;																		// 블럭 개수 
			$intListNum				= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage				= ceil( $intTotal / $intPageLine );

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
		break;
	
		case "postPaperList":
			// 쪽지 리스트

			/* 데이터 리스트 */
			$intTotal								= $postPaperMgr->getPostPaperSelect( $db, "OP_COUNT" );								// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$postPaperMgr->setLimitFirst($intFirst);
			$postPaperMgr->setPageLine($intPageLine);

			$postPaperResult						= $postPaperMgr->getPostPaperSelect( $db, "OP_LIST" );
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			$linkPage = "$S_PHP_SELF?menuType=$strMenuType&mode=$strMode&target=$strTarget&page=";
		break;

		case "postPaperView":
			// 쪽지 내용보기
			$postPaperRow							= $postPaperMgr->getPostPaperSelect( $db, "OP_SELECT" );
			$postPaperRow['PP_TEXT']				= strConvertCut2($postPaperRow['PP_TEXT'], "0", "N");
		break;

		case "postPaperModify":
			// 쪽지 수정하기
			$postPaperRow							= $postPaperMgr->getPostPaperSelect( $db, "OP_SELECT" );
		break;

		case "postPaperShot":
			// 전체쪽지발송관리 - 대량 쪽지 보내기
			$postPaperRow							= $postPaperMgr->getPostPaperSelect( $db, "OP_SELECT" );

	
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			if ($strSearchOut == "Y") { $strLeftMenuCode02 = "002";		}
			/* 관리자 Sub Menu 권한 설정 */	
				
			/* 검색부분 */
			if (!$strSearchOrderSortCol) $strSearchOrderSortCol = "N";
			if (!$strSearchOrderSort) $strSearchOrderSort = "desc";
			
			$memberMgr->setSearchOrderSortCol($strSearchOrderSortCol);
			$memberMgr->setSearchOrderSort($strSearchOrderSort);

			$memberMgr->setSearchOut($strSearchOut);
			$memberMgr->setSearchField($strSearchField);
			$memberMgr->setSearchKey($strSearchKey);
			$memberMgr->setSearchRegStartDt($strSearchRegStartDt);
			$memberMgr->setSearchRegEndDt($strSearchRegEndDt);
			$memberMgr->setSearchLastLoginStartDt($strSearchLastLoginStartDt);
			$memberMgr->setSearchLastLoginEndDt($strSearchLastLoginEndDt);
			$memberMgr->setSearchVisitStartCnt($strSearchVisitStartCnt);
			$memberMgr->setSearchVisitEndCnt($strSearchVisitEndCnt);
			$memberMgr->setSearchSex($strSearchSex);
			$memberMgr->setSearchMailYN($strSearchMailYN);
			$memberMgr->setSearchSmsYN($strSearchSmsYN);
			$memberMgr->setSearchBirth($strSearchBirth);
			$memberMgr->setSearchRecId($strSearchRecId);
			$memberMgr->setSearchOutStartDt($strSearchOutStartDt);
			$memberMgr->setSearchOutEndDt($strSearchOutEndDt);			
			$memberMgr->setSearchGroup($strSearchGroup);
			/* 검색부분 */

			/* 데이터 리스트 */
			$intTotal								= $memberMgr->getMemberTotal( $db );												// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
			$memberMgr->setLimitFirst($intFirst);
			$memberMgr->setPageLine($intPageLine);

			$memberListResult						= $memberMgr->getMemberList( $db );

			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	
		
			$linkPage  = "?menuType=$strMenuType&mode=$strMode&target=$strTarget&pm_no=$intPM_NO";
			$linkPage .= "&searchOut=$strSearchOut&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$linkPage .= "&searchOutStartDt=$strSearchOutStartDt&searchOutEndDt=$strSearchOutEndDt";
			$linkPage .= "&searchGroup=$strSearchGroup&page=";

		break;

		case "postPaperLogList":

			/* 데이터 리스트 */
			$memberPaperMgr->setMP_PP_NO($intPP_NO);
			$intTotal								= $memberPaperMgr->getMemberPaperSelect( $db, "OP_COUNT" );								// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$memberPaperMgr->setLimitFirst($intFirst);
			$memberPaperMgr->setPageLine($intPageLine);

			$memberPaperResult						= $memberPaperMgr->getMemberPaperSelect( $db, "OP_LIST" );
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			$linkPage = "$S_PHP_SELF?menuType=$strMenuType&mode=$strMode&target=$strTarget&pp_no=$intPP_NO&page=";

		break;
		
		case "postPaperSend":
			$includeJsFile	= sprintf("%sskin/%s/%s.js.php", $strIncludePath, $arySkinFolder['postPaperSend'], 'postPaperSend');
		break;

	endswitch;

	include ($strTarget == "pop") ? "index.html.pop.php" : "index.html.php";	

?>
