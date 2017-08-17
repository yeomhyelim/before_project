<?
	if(in_array($strAct, array("sendmailModify", "sendmailUseModify"))):
		if($strMode == "json"):
			include "json.php";

			if(!$result):
				$result = print_r($_POST, true);
			endif;
			echo json_encode($result);
			exit;
		endif;
	endif;

	require_once "_function.lib.inc.php";
	require_once "_postMailField.inc.php";
	require_once "_postMailSetting.inc.php";

	switch($strMode){
		case "sendmail":
			## 자동메일 설정

			## 관리자 Sub Menu 권한 설정
			$strLeftMenuCode01		= "002";
			$strLeftMenuCode02		= "002";

			## 자동메일설정 정보
			$siteInfoRow			= $siteMgr->getSiteInfoView($db);
			
		break;
// 2013.12.24 kim hee sung old style
//		case "sendmail":
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "002";
//			$strLeftMenuCode02 = "002";
//			/* 관리자 Sub Menu 권한 설정 */
//
//			/* 각 그룹 NO 값 가져오기 */
//			$boardMgr->setCG_CODE("EMAIL");
//			$arrGrpNo = $boardMgr->getCommGrpList($db);
//
//			$boardMgr->setCG_CODE("EMAIL_SEND");
//			$arrSendNo = $boardMgr->getCommGrpList($db);
//			/* 각 그룹 NO 값 가져오기 */
//
//			$emailMgr->setCG_NO_GRP($arrGrpNo[0][CG_NO]);
//			$emailMgr->setCG_NO_SEND($arrSendNo[0][CG_NO]);
//	
//			$emailListRow = $emailMgr->getEmailList($db);
//			$grpListRow = $emailMgr->getEmailGrpList($db);
//			
//			$siteInfoRow = $siteMgr->getSiteInfoView($db);
//
////			$siteInfoRow = $siteMgr->getSiteInfo($db);
////			$arySettle = explode("/",$siteInfoRow[S_SETTLE]);
//
//			/* 사용언어 셋팅 */
//			$arySiteUseLng = explode("/",$siteInfoRow[S_USE_LNG]);
//			for($i=0;$i<sizeof($arySiteUseLng);$i++){
//				if ($arySiteUseLng[$i]){
//					$S_ARY_USE_COUNTRY[$arySiteUseLng[$i]] = $S_ARY_COUNTRY[$arySiteUseLng[$i]];
//				}
//			}
//			/* 사용언어 셋팅 */
//		break;

		case "postMailList":
			// 전체메일발송관리 - 리스트

			/* 데이터 리스트 */
			$intTotal								= $postMailMgr->getPostMailSelect( $db, "OP_COUNT" );								// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
			$postMailMgr->setLimitFirst($intFirst);
			$postMailMgr->setPageLine($intPageLine);

			$postMailResult							= $postMailMgr->getPostMailSelect( $db, "OP_LIST" );
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			$linkPage = "$S_PHP_SELF?menuType=$strMenuType&mode=$strMode&target=$strTarget&page=";
			
		break;

		case "postMailView":
			// 전체메일발송관리 - 보기
			$postMailRow							= $postMailMgr->getPostMailSelect( $db, "OP_SELECT" );
			$postMailRow['PM_TEXT']					= strConvertCut2($postMailRow['PM_TEXT'], "0", "N");
		break;

		case "postMailModify":
			// 전체메일발송관리 - 수정
			$postMailRow							= $postMailMgr->getPostMailSelect( $db, "OP_SELECT" );
		break;

		case "postMailSend":
			// 회원목록에서 이메일 클릭으로 메일 보내기

			$memberMgr->setM_NO($intM_NO);
			$row				= $memberMgr->getMemberView($db);	
			
			$strRECEIVE_NAME	= $row['M_F_NAME'] . $row['M_L_NAME'];
			$strRECEIVE_MAIL	= $row['M_MAIL'];
			$strSEND_NAME		= $S_SITE_NM;
			$strSEND_EMAIL		= $S_SITE_MAIL;
			
			/* 링크 변경 */
			$includeFile	= sprintf("%sskin/%s/%s.skin.php", $strIncludePath, $arySkinFolder['postMailTestSend'], 'postMailTestSend');
			$includeJsFile	= sprintf("%sskin/%s/%s.js.php", $strIncludePath, $arySkinFolder['postMailTestSend'], 'postMailTestSend');
			
		break;
		case "postMailTestSend":
			// 전체메일발송관리 - 테스트 메일 보내기
			$postMailRow							= $postMailMgr->getPostMailSelect( $db, "OP_SELECT" );
			$postMailRow['PM_TEXT']					= strConvertCut2($postMailRow['PM_TEXT'],"0", "Y");
			$strSEND_NAME							= $S_SITE_NM;
			$strSEND_EMAIL							= $S_SITE_MAIL;
		break;

		case "postMailShot":
			// 전체메일발송관리 - 대량 메일 보내기
			$postMailRow							= $postMailMgr->getPostMailSelect( $db, "OP_SELECT" );
//			$postMailRow['PM_TEXT']					= strConvertCut2($postMailRow['PM_TEXT']);
	
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			if ($strSearchOut == "Y") { $strLeftMenuCode02 = "002";		}
			/* 관리자 Sub Menu 권한 설정 */	
				
			/* 회원검색(2013.08.13) */
			$strLinkPageStr	= "";
			include MALL_WEB_PATH."shopAdmin/member/member/memberList.helper.inc.php";
			$memberListResult = $result;
			/* 회원검색(2013.08.13) */

		break;

		case "postMailLogList":
			
			$strSEND_NAME							= $S_SITE_NM;
			$strSEND_EMAIL							= $S_SITE_MAIL;
		
			// 전체메일발송관리 - 발신내역

			/* 데이터 리스트 */
			$postMailLogMgr->setPL_PM_NO($intPM_NO);
			$intTotal								= $postMailLogMgr->getPostMailLogSelect( $db, "OP_COUNT" );							// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
			$postMailLogMgr->setLimitFirst($intFirst);
			$postMailLogMgr->setPageLine($intPageLine);

			$postMailLogResult						= $postMailLogMgr->getPostMailLogSelect( $db, "OP_LIST" );
			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	

			$linkPage = "$S_PHP_SELF?menuType=$strMenuType&mode=$strMode&target=$strTarget&pm_no=$intPM_NO&page=";

		break;

		case "echo $strMode":
			// 메일 수집 리스트


		break;
	}


	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}

	include ($strTarget == "pop") ? "index.html.pop.php" : "index.html.php";	

?>
