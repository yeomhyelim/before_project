<?
//	require_once "_function.lib.inc.php";
	require_once "_postSmsField.inc.php";
	require_once "_postSmsSetting.inc.php";

	switch($strMode) :
		case "autosms":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */


			/* 각 그룹 NO 값 가져오기 */
			$smsMgr->setCG_CODE("SMS");
			$arrGrpNo = $smsMgr->getCommGrpList($db);

			$smsMgr->setCG_CODE("SEND");
			$arrSendNo = $smsMgr->getCommGrpList($db);
			/* 각 그룹 NO 값 가져오기 */

			$smsMgr->setCG_NO_GRP($arrGrpNo[0][CG_NO]);
			$smsMgr->setCG_NO_SEND($arrSendNo[0][CG_NO]);
			
			$smsListRow = $smsMgr->getSmsList($db);
			$grpListRow = $smsMgr->getSmsGrpList($db);
			

			
			
			$siteInfoRow = $siteMgr->getSiteInfo($db);
			$arySettle = explode("/",$row[S_SETTLE]);	
		break;
		case "postSmsMemberList":
			// 회원 리스트

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
			$intMemberTotal								= $memberMgr->getMemberTotal( $db );												// 데이터 전체 개수 

			$intMemberPageLine							= 10;																				// 리스트 개수 
			$intMemberPage								= ( $intMemberPage )				? $intMemberPage		: 1;
			$intMemberFirst								= ( $intMemberTotal == 0 )			? 0						: $intMemberPageLine * ( $intMemberPage - 1 );
			$memberMgr->setLimitFirst($intMemberFirst);
			$memberMgr->setPageLine($intMemberPageLine);

			$memberListResult							= $memberMgr->getMemberList( $db );
	
			$intMemberPageBlock							= 10;																		// 블럭 개수 
			$intMemberListNum							= $intMemberTotal - ( $intMemberPageLine * ( $intMemberPage - 1 ) );							// 번호
			$intMemberTotPage							= ceil( $intMemberTotal / $intMemberPageLine );
			/* 데이터 리스트 */	
		
			$linkMemberPage  = "?menuType=$strMenuType&mode=$strMode&target=$strTarget&pm_no=$intPM_NO";
			$linkMemberPage .= "&searchOut=$strSearchOut&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkMemberPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$linkMemberPage .= "&searchOutStartDt=$strSearchOutStartDt&searchOutEndDt=$strSearchOutEndDt";
			$linkMemberPage .= "&searchGroup=$strSearchGroup&page=";

			/* 링크 변경 */
			$includeFile	= sprintf("%sskin/%s/%s.skin.php", $strIncludePath, $arySkinFolder[$strMode], "postSmsList");
			$includeJSFile	= sprintf("%sskin/%s/%s.js.php", $strIncludePath, $arySkinFolder[$strMode], "postSmsList");
		break;

		case "postSmsList":
			/* 전체 문자 발송 리스트 */

			## 관리자 서브 메뉴 권한 설정
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";

			/* 데이터 리스트 */
			$intTotal								= $postSmsMgr->getPostSmsSelect( $db, "OP_COUNT" );								// 데이터 전체 개수 
	
			$intPageLine							= 5;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$postSmsMgr->setLimitFirst($intFirst);
			$postSmsMgr->setPageLine($intPageLine);

			$postSmsResult							= $postSmsMgr->getPostSmsSelect( $db, "OP_LIST" );
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			$linkPage								= "$S_PHP_SELF?menuType=$strMenuType&mode=$strMode&target=$strTarget&page=";
			
			/* 회원검색(2013.08.13) */
			$strLinkPageStr	= "memPage";
			include MALL_WEB_PATH."shopAdmin/member/member/memberList.helper.inc.php";
			$memberListResult = $result;
			/* 회원검색(2013.08.13) */

		break;

		case "postSmsLogList":
			// 전체문자발송관리 - 발송내역

			/* 데이터 리스트 */
			$postSmsLogMgr->setPL_PS_NO($intPS_NO);
			$intTotal								= $postSmsLogMgr->getPostSmsLogSelect( $db, "OP_COUNT" );							// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
			$postSmsLogMgr->setLimitFirst($intFirst);
			$postSmsLogMgr->setPageLine($intPageLine);

			$postSmsLogResult						= $postSmsLogMgr->getPostSmsLogSelect( $db, "OP_LIST" );
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			$linkPage = "$S_PHP_SELF?menuType=$strMenuType&mode=$strMode&target=$strTarget&pm_no=$intPM_NO&page=";		
			
		
		break;
		case "postSmsSend":
			// 회원목록에서 휴대폰번호 클릭으로 문자보내기
			
			$memberMgr->setM_NO($intM_NO);
			$row				= $memberMgr->getMemberView($db);

			$strRECEIVE_HP		= $row['M_HP'];
			$strRECEIVE_NAME	= $row['M_F_NAME'] . $row['M_L_NAME'];
			$strRECEIVE_NO		= $row['M_NO'];
			$strSEND_HP			= $S_COM_PHONE;
			$strSEND_NAME		= $S_SITE_NM;
			$strSEND_NO			= -1;
		break;
	endswitch;

	include ($strTarget == "pop") ? "index.html.pop.php" : "index.html.php";	

?>
