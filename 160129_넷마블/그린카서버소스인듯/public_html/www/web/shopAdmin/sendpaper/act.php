<?	

	switch($strAct):
		case "sendPaperWrite":
			// 쪽지 보내기

			$param						= "";
			$param['MP_PP_NO']			= 0;
			$param['MP_TO_M_NO']		= $_POST['mp_to_m_no'];
			$param['MP_FROM_M_NO']		= $_SESSION["ADMIN_NO"];
			$param['MP_TITLE']			= $_POST["mp_title"];
			$param['MP_TEXT']			= $_POST["mp_text"];
			$param['MP_REG_NO']			= $_SESSION["ADMIN_NO"];

			$re							= $memberPaperMgr->getMemberPaperInsertEx($db, $param);

			if($re == 1):
				if($_POST['myTarget'] == "pop"):
					goClose("쪽지를 성공적으로 보냈습니다.");
					exit;
				else:
					echo "처리하세요...";
					exit;
				endif;
			else:
				echo "쪽지를 보낼수 없습니다.";
				exit;
			endif;

		break;

		case "receivePaperMultiDelete":
			// 쪽지 멀티 삭제

			if(!is_array($_POST['selfCheck'])):
				echo "삭제할 쪽지가 없습니다.";
				exit;
			endif;

			foreach($_POST['selfCheck'] as $no => $mp_no):
				$param['MP_NO']		= $mp_no;
				$result[$no]		= $memberPaperMgr->getMemberPaperDeleteUpdate($db, $param);
			endforeach;

			foreach($result as $re):
				if($re != 1):
					echo "삭제되지 않은 데이터가 있습니다.{$_POST['selfCheck'][$re]}";
					exit;
				endif;
			endforeach;

		break;

		case "receivePaperDelete":
			// 쪽지 삭제
			if(!$_POST['mp_no']):
				echo "삭제할 쪽지가 없습니다.";
				exit;
			endif;

			$param['MP_NO'] = $_POST['mp_no'];

			$re = $memberPaperMgr->getMemberPaperDeleteUpdate($db, $param);

			if($re != 1):
				echo "삭제 할 수 없습니다.";
				exit;
			endif;

		break;

		case "postPaperWrite":
			// 글등록
			
			$postPaperMgr->setPP_M_ID($_SESSION["ADMIN_ID"]);
			$postPaperMgr->setPP_REG_NO($_SESSION["ADMIN_NO"]);
			$postPaperMgr->setPP_MOD_NO($_SESSION["ADMIN_NO"]);
			$postPaperMgr->getPostPaperInsert($db);

		break;

		case "postPaperModify":
			// 글수정
			$postPaperMgr->getPostPaperUpdate($db);
		break;

		case "postPaperShotSendFromMember":
			// 회원 목록에서 쪽지 보내기
			$intPP_NO = -1;

		case "postPaperShotSend":
			// 쪽지 보내기

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


			/* 대량 쪽지 보내기 */
			$postPaperRow							= $postPaperMgr->getPostPaperSelect( $db, "OP_SELECT" );
			$strMP_TITLE							= strConvertCut2($postPaperRow['PP_TITLE']);
			$strMP_TEXT								= strConvertCut2($postPaperRow['PP_TEXT']);
			$strMP_FROM_M_ID						= $a_admin_no;
//			$strMP_TO_M_ID							= 'test';
			$intMP_REG_NO							= $a_admin_no;

			$memberPaperMgr->setMP_PP_NO($intPP_NO);
//			$memberPaperMgr->setMP_TO_M_ID($strMP_TO_M_ID);
			$memberPaperMgr->setMP_FROM_M_ID($strMP_FROM_M_ID);
			$memberPaperMgr->setMP_TITLE($strPP_TITLE);
			$memberPaperMgr->setMP_TEXT($strPP_TEXT);
			$memberPaperMgr->setMP_REG_NO($intMP_REG_NO);


			while($row = mysql_fetch_array($memberListResult)) : 

				if(!$row['M_NO']) { continue; }

				if($strSendType == "A") :
					// 선택된 회원에게 쪽지보내기.
					if(!in_array($row['M_NO'], $arySelfCheck)) :
						// 선택된 회원이 아니라면, 
						continue;
					endif;
				endif;

				$strMP_TO_M_ID						= $row['M_NO'];
				$memberPaperMgr->setMP_TO_M_ID($strMP_TO_M_ID);
				$memberPaperMgr->getMemberPaperInsert($db);

			endwhile;
			/* 대량 쪽지 보내기 */
			
		break;

		case "postPaperDelete":
			// 쪽지글 삭제

			$postPaperMgr->getPostPaperDelete($db);
		break;
	endswitch;

	$db->disConnect();

	$STR_MSG['postPaperWrite']				= "등록되었습니다.";
	$STR_MSG['postPaperModify']				= "수정되었습니다.";
	$STR_MSG['postPaperDelete']				= "삭제되었습니다.";
	$STR_MSG['postPaperShotSend']			= "쪽지발송되었습니다.";
	$STR_MSG['postPaperShotSendFromMember']	= "쪽지발송되었습니다.";
	$STR_MSG['receivePaperDelete']			= "삭제되었습니다.";
	$STR_MSG['receivePaperMultiDelete']		= "삭제되었습니다.";

	$strLinkPage							= "target=$strTarget&page=$intPage";

	$STR_URL['postPaperWrite']				= "./?menuType=$strMenuType&mode=postPaperList&$strLinkPage";
	$STR_URL['postPaperModify']				= "./?menuType=$strMenuType&mode=postPaperView&pp_no=$intPP_NO&$strLinkPage";
	$STR_URL['postPaperDelete']				= "./?menuType=$strMenuType&mode=postPaperList&$strLinkPage";
	$STR_URL['postPaperShotSend']			= "./?menuType=$strMenuType&mode=postPaperList&$strLinkPage";
	$STR_URL['postPaperShotSendFromMember']	= "./?menuType=member&mode=memberList&$strLinkPage";
	$STR_URL['receivePaperDelete']			= "./?menuType=sendpaper&mode=receivePaperList&$strLinkPage";
	$STR_URL['receivePaperMultiDelete']		= "./?menuType=sendpaper&mode=receivePaperList&$strLinkPage";

	goUrl($STR_MSG[$strAct],$STR_URL[$strAct]);
?>