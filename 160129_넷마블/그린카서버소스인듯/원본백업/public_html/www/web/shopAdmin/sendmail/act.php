<?	
	switch($strAct):
		case "postMailWrite":
			// 글등록
			
			$postMailMgr->getPostMailInsert($db);
			
		break;

		case "postMailModify":
			// 글수정
			
			$postMailMgr->getPostMailUpdate($db);
		break;

		case "postMailDelete":
			// 글삭제
		
			$postMailMgr->getPostMailDelete($db);
		break;
		
		case "postMailTestSend":
			// 테스트 메일 보내기

			/* 메일 전송 */
			$strMailFromName		= $setSEND_NAME;				// 보내는 사람 이름
			$strMailFromAddr		= $setSEND_EMAIL;				// 보내는 사람 메일
			$strMailTitle			= $strPM_TITLE;					// 메일 제목
			$strContents			= $strPM_TEXT;					// 메일 내용
			$strMailToName			= $setRECEIVE_NAME;				// 받는 사람 이름
			$strMailToAddr			= $setRECEIVE_MAIL;				// 받는 사람 메일

			/* 회원목록에서 메일 보내기를 할때 메일 발송내역 데이터 INSERT */
			if (!$intPM_NO || $intPM_NO == 0){
				$postMailMgr->setPM_TITLE($strPM_TITLE);
				$postMailMgr->setPM_TEXT($strPM_TEXT);
				$postMailMgr->setPM_REG_DT($intPM_REG_DT);
				$postMailMgr->setPM_REG_NO($a_admin_no);
				$postMailMgr->setPM_TOTAL_CNT(1);
				$postMailMgr->getPostMailInsert($db);
				$intPM_NO = $db->getLastInsertID();

			}
			/* 회원목록에서 메일 보내기를 할때 메일 발송내역 데이터 INSERT */			
			$sendMailResult			= sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");
			$sendMailResult			= ($sendMailResult) ? $sendMailResult : 0;
			/* 메일 전송 */
			
			/* 로그 기록 */
			$postMailLogMgr->setPL_PM_NO($intPM_NO);
			$postMailLogMgr->setPL_TO_M_MAIL($strMailToAddr);
			$postMailLogMgr->setPL_TO_M_NAME($strMailToName);
			$postMailLogMgr->setPL_TO_M_NO($intM_NO);
			$postMailLogMgr->setPL_FROM_M_MAIL($strMailFromAddr);
			$postMailLogMgr->setPL_FROM_M_NAME($strMailFromName);
			$postMailLogMgr->setPL_FROM_M_NO($a_admin_no);
			$postMailLogMgr->setPL_IP(getClientIP());
			$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);
			$postMailLogMgr->setPL_REG_NO($a_admin_no);		
			$postMailLogMgr->getPostMailLogInsert($db);
			/* 로그 기록 */

			$postMailMgr->setPM_NO($intPM_NO);
			$postMailMgr->setPM_TOTAL_CNT(1);
			$postMailMgr->getPostMailCntUpdate($db);


		break;

		case "postMailShotSend":
			//메일보내기
	
			/* 회원검색(2013.08.13) */
			$strLinkPageStr		= "";
			$_POST['pageLine']	= "50";	//50개씩 돌림
			include MALL_WEB_PATH."shopAdmin/member/member/memberList.helper.inc.php";
			$memberListResult = $result;
			/* 회원검색(2013.08.13) */

			/* 대량 메일 보내기 */
			// PL_SEND_RESULT 옵션 (sendMailResult)
			//	0		:		발송실패
			//	1		:		발송성공
			//	9		:		받는사람 이름 없음.
			//	8		:		받는사람 이메일 없음.
			//	7		:		보내는사람 이름 없음.
			//	6		:		보내는사람 이메일 없음.
			//	5		:		제목없음
			//	4		:		내용없음

			$postMailRow							= $postMailMgr->getPostMailSelect( $db, "OP_SELECT" );
			$postMailRow['PM_TEXT']					= strConvertCut2($postMailRow['PM_TEXT']);

			// 메일 기본 정보
			$strMailFromName		= $setSEND_NAME;				// 보내는 사람 이름
			$strMailFromAddr		= $setSEND_EMAIL;				// 보내는 사람 메일
			$strMailTitle			= $postMailRow['PM_TITLE'];		// 메일 제목
			$strContents			= $postMailRow['PM_TEXT'];		// 메일 내용

			// // 메일 로그 정보
			$postMailLogMgr->setPL_PM_NO($intPM_NO);				// 메일번호(로그용)
			$postMailLogMgr->setPL_FROM_M_MAIL($strMailFromAddr);	// 보내는사람 메일(로그용)
			$postMailLogMgr->setPL_FROM_M_NAME($strMailFromName);	// 보내는사람 이름(로그용)
			$postMailLogMgr->setPL_FROM_M_NO($a_admin_no);
			$postMailLogMgr->setPL_IP(getClientIP());				// 클라이언트 IP
			$postMailLogMgr->setPL_REG_NO($a_admin_no);				// 로그인 회원 번호(로그용)
			
			$incCnt = 0;
			while($row = mysql_fetch_array($memberListResult)) : 
				$strMailToName			= $row['M_F_NAME'] . " " . $row['M_L_NAME'];			// 받는 사람 이름
				$strMailToAddr			= $row['M_MAIL'];										// 받는 사람 메일

				$postMailLogMgr->setPL_TO_M_MAIL($strMailToAddr);								// 받는사람 메일(로그용)
				$postMailLogMgr->setPL_TO_M_NAME($strMailToName);
				$postMailLogMgr->setPL_TO_M_NO($row['M_NO']);
				// 받는사람 이름(로그용)
				
				if($strSendType == "A") :
					// 선택된 회원에게 메일보내기.
					if(!in_array($row['M_NO'], $aryChkMemberNoList)) :
						// 선택된 회원이 아니라면, 
						continue;
					endif;
				endif;

				if($row['M_MAILYN'] != "Y") :
					// 메일수신거부 처리
					continue;
				endif;

				if(!$strMailToName) :
					// 받는사람 이름 없음
					$sendMailResult = "9";
					$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);	// 결과(로그용)
					$postMailLogMgr->getPostMailLogInsert($db);
					continue;
				endif;

				if(!$strMailToAddr) :
					// 받는사람 이메일 없음
					$sendMailResult = "8";
					$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);	// 결과(로그용)
					$postMailLogMgr->getPostMailLogInsert($db);
					continue;
				endif;

// 성능테스트 10개 보내는데 6초 차후 수정 필요함.
//				$startTime = C_GetMicrotime();
//				for($i=0;$i<10;$i++) :
				/* 메일 전송 및 로그 등록 */
				$sendMailResult			= sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");
				$sendMailResult			= ($sendMailResult) ? $sendMailResult : 0;
				$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);	// 결과(로그용)
				$postMailLogMgr->getPostMailLogInsert($db);
				/* 메일 전송 및 로그 등록 */
//				endfor;
//				$endTime = C_GetMicrotime();
//				$time = $endTime - $startTime;
//				echo $time;
//				exit;
				
				$intCnt++;
				if($intCnt >= $intMemPageLine && $intMemPage != $intMemTotPage) { 
					sleep(1); $intCnt = 0; 
					/* 페이징에서 새로 불러옴 */
					$_POST["page"] = $intMemPage + 1;
					drawPageRedirect("submitForm","./index.php",$_POST);
					exit;
				}
				
			endwhile;
			/* 대량 메일 보내기 */

			/* 발송내역건수 update */
			$postMailMgr->setPM_TOTAL_CNT($intCnt);
			$postMailMgr->getPostMailCntUpdate($db);
			/* 발송내역건수 update */
		break;

		case "postMailExcelUpload":

			$_FILE		= $_FILES['excelFile'];
			
			if($_FILE['error'] > 0) :
				// error 처리
				goErrMsg("업로드 파일이 존재하지 않거나 업로드 오류처리를 해주세요.");
				exit;
			endif;
			
			if(!$_FILE['name']):
				// 파일명이 없을 때 처리.
				echo "파일명 설정이 안되어 있습니다. 처리하세요...";
				break;
			endif;

			// 파일 업로드
			$uid	 			= "mailInsertExcel_".date("YmdHis");	// 파일업로드명의 구분자
			$upload_dir			= WEB_UPLOAD_PATH . "/temp" ;			// 업로드할 폴더명
			$file_name			= $_FILE['name'];						// 파일명
			$file_tmp_name		= $_FILE['tmp_name'];					// 업로드할 임시 파일명
			$file_size			= $_FILE['size'];						// 업로드할 파일 크기
			$file_type			= $_FILE['type'];						// 업로드할 파일 타입

			$fres 				= $fh->doUpload($uid, $upload_dir, $file_name, $file_tmp_name, $file_size, $file_type);
			
			if(!$fres) :
				// 업로드 실패 처리
				goErrMsg("업로드가 실패되었습니다.");
				exit;
			endif;
			
			$strFileInServer	= $fres['upload_dir'] . "/" . $fres['file_real_name'];
			@chmod($strFileInServer , 0707);	// 권한 변경
			
			/* Excel 영역 */
			require_once MALL_EXCEL_READER;
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8');
			$data->read($strFileInServer);
			error_reporting(E_ALL ^ E_NOTICE);
			
			$postMailLogMgr->setPL_PM_NO($intPM_NO);					// 문자번호(로그용)			
			$postMailLogMgr->setPL_FROM_M_MAIL("");						// 보내는사람 문자(로그용)
			$postMailLogMgr->setPL_FROM_M_NAME("");						// 보내는사람 이름(로그용)
			$postMailLogMgr->setPL_FROM_M_NO("");						// 보내는사람 회원번호(로그용)
			$postMailLogMgr->setPL_IP("");								// 클라이언트 IP
			$postMailLogMgr->setPL_SEND_RESULT("2");
			$postMailLogMgr->setPL_REG_NO($a_admin_no);			   // 로그인 회원 번호(로그용)
			
			$intTotalCnt = $intSucCnt = $intErrCnt = 0;
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) :
				$intTotalCnt++;

				$strCol1	= $data->sheets[0]['cells'][$i][1];			//받는사람
				$strCol2	= $data->sheets[0]['cells'][$i][2];			//받는사람메일
				
				$postMailLogMgr->setPL_TO_M_MAIL($strCol2);				// 받는사람 문자(로그용)
				$postMailLogMgr->setPL_TO_M_NAME($strCol1);				// 받는사람 이름(로그용)
				$postMailLogMgr->setPL_TO_M_NO(0);						// 보내는사람 회원번호(로그용)
				$intDupCnt = $postMailLogMgr->getPostMailLogDup($db);
				if ($intDupCnt > 0) {
					$intErrCnt++;
					continue;
				}
				
				$postMailLogMgr->getPostMailLogInsert($db);
				$intSucCnt++;
			endfor;
			/* Excel 영역 */

			// 파일 삭제
			$fh->fileDelete($strFileInServer);
			
			$strErrMsg = "총 ".$intTotalCnt."건 중 ".$intSucCnt."건 성공/".$intErrCnt."건 중복";
			
//			$strUrl = "./?menuType=".$strMenuType."&mode=memberInsertExcelWrite";
//			$strMsg = "등록되었습니다.";			
						
		break;
		case "postMailLogSend":
			
			$strMailFromName		= $setSEND_NAME;					// 보내는 사람 이름
			$strMailFromAddr		= $setSEND_EMAIL;					// 보내는 사람 메일
			
			$postMailLogMgr->setPL_FROM_M_MAIL($strMailFromAddr);		// 보내는사람 메일(로그용)
			$postMailLogMgr->setPL_FROM_M_NAME($strMailFromName);		// 보내는사람 이름(로그용)
			$postMailLogMgr->setPL_FROM_M_NO($a_admin_no);				// 보내는사람 회원번호(로그용)
			$postMailLogMgr->setPL_IP(getClientIP());					// 클라이언트 IP
			$postMailLogMgr->setPL_SEND_RESULT("2");
			$postMailLogMgr->setPL_PM_NO($intPM_NO);
			
			$intTotal				= $postMailLogMgr->getPostMailLogSelect( $db, "OP_COUNT" );	// 데이터 전체 개수 
			$postMailLogResult		= $postMailLogMgr->getPostMailLogSelect( $db, "OP_LIST" );	
			
			if ($intTotal > 0){
				
				$postMailMgr->setPM_NO($intPM_NO);
				$mailInfoRow = $postMailMgr->getPostMailSelect($db,"OP_SELECT");
				$strMailTitle	= $mailInfoRow['PM_TITLE'];
				$strContents	= $mailInfoRow['PM_TEXT'];
				
				$incCnt = 0;
				while($row = mysql_fetch_array($postMailLogResult)) : 
					$strMailToName			= $row['PL_TO_M_NAME'];			// 받는 사람 이름
					$strMailToAddr			= $row['PL_TO_M_MAIL'];			// 받는 사람 메일
					
					$postMailLogMgr->setPL_TO_M_MAIL($strMailToAddr);								// 받는사람 메일(로그용)
					$postMailLogMgr->setPL_TO_M_NAME($strMailToName);
					$postMailLogMgr->setPL_TO_M_NO($row['PL_TO_M_NO']);
					// 받는사람 이름(로그용)
					
					if($strMailToName && $strMailToAddr) :
						$postMailLogMgr->setPL_NO($row['PL_NO']);
						$sendMailResult	= sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");
						$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);	// 결과(로그용)
						$postMailLogMgr->getPostMailLogUpdate($db);
					
						$intCnt++;
					endif;
					
					if($intCnt >= 500) { sleep(1); $intCnt = 0; }					
					
				endwhile;
				/* 대량 메일 보내기 */
			
			}

		break;
	endswitch;

	$db->disConnect();

	$STR_MSG['postMailWrite']		= "등록되었습니다.";
	$STR_MSG['postMailModify']		= "수정되었습니다.";
	$STR_MSG['postMailDelete']		= "삭제되었습니다.";
	$STR_MSG['postMailTestSend']	= "전송되었습니다.";
	$STR_MSG['postMailShotSend']	= "메일발송되었습니다.";
	$STR_MSG['postMailExcelUpload']	= "발송내역이 등록되었습니다.";
	$STR_MSG['postMailLogSend']		= "메일이 전송되었습니다";

	$strLinkPage					= "&target=$strTarget&page=$intPage";

	$STR_URL['postMailWrite']		= "./?menuType=$strMenuType&mode=postMailList&$strLinkPage";
	$STR_URL['postMailModify']		= "./?menuType=$strMenuType&mode=postMailView&pm_no=$intPM_NO&$strLinkPage";
	$STR_URL['postMailDelete']		= "./?menuType=$strMenuType&mode=postMailList&$strLinkPage";
	$STR_URL['postMailTestSend']	= "./?menuType=$strMenuType&mode=postMailTestSend&pm_no=$intPM_NO&$strLinkPage";
	$STR_URL['postMailShotSend']	= "./?menuType=$strMenuType&mode=postMailList&$strLinkPage";
	$STR_URL['postMailExcelUpload']	= "./?menuType=$strMenuType&mode=postMailLogList&pm_no=$intPM_NO&$strLinkPage";
	$STR_URL['postMailLogSend']		= "./?menuType=$strMenuType&mode=postMailLogList&pm_no=$intPM_NO&$strLinkPage";

	
	if($strTarget == "pop") {
		echo "<script language=\"javascript\">alert('".$STR_MSG[$strAct]."');parent.goPopClose();</script>";
	} else {
		goUrl($STR_MSG[$strAct],$STR_URL[$strAct]);
	}
?>