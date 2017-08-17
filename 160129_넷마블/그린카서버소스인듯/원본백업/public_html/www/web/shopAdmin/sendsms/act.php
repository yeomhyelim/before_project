<?
	switch ($strAct) :

		case "smsModify":

			$data = "";
			for($i=0; $i<count($arrSM_NO); $i++)
			{
				$strSM_AUTO = "N";

				for($j=0; $j<count($arrSM_AUTO); $j++)
				{
					if($arrSM_NO[$i] == $arrSM_AUTO[$j])
					{
						$strSM_AUTO = "Y";
						break;
					} // if

				} // for

				$smsMgr->setSM_NO($arrSM_NO[$i]);
				$smsMgr->setSM_TEXT($arrSM_TEXT[$i]);
				$smsMgr->setSM_AUTO($strSM_AUTO);

				$smsMgr->getSmsUpdate($db);

	//			echo $i . "-" . $arrSM_NO[$i] . "-" . $strSM_AUTO . "-" . $arrSM_TEXT[$i] . "<br>";

				/** 2013.04.18 SMS 문자 파일 생성 추가 **/
				## STEP 1.
				## 데이터 만들기
				/* 전송코드 */
				$dataTemp	= "";
				$dataTemp	= sprintf("\$SMS_TEXT_LIST['%s']['%s']", $_POST['sm_send_code'][$i], "SM_SEND_CODE");
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['sm_send_code'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				/* 자동 전송 여부 */
				$dataTemp	= "";
				$dataTemp	= sprintf("\$SMS_TEXT_LIST['%s']['%s']", $_POST['sm_send_code'][$i], "SM_AUTO");
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $strSM_AUTO); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				/* 내용 */
				$sm_text	= $_POST['sm_text'][$i];
				$sm_text	= str_replace("\"", "\\\"", $sm_text);
				$dataTemp	= "";
				$dataTemp	= sprintf("\$SMS_TEXT_LIST['%s']['%s']", $_POST['sm_send_code'][$i], "SM_TEXT");
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['sm_text'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;
				/** 2013.04.18 SMS 문자 파일 생성 추가 **/
			} // for


			## STEP 2.
			## 파일 만들기(기존 데이터 업데이트 형)
			require_once		"{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
			$smsConfName		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
			$file				= new FileHandler();	
			$file->getMadeInfo($smsConfName, $data, "/*@ SMS_TEXT_LIST @*/");
			/** 2013.04.18 상품 브랜드 파일 생성 **/

		break;

		case "smsUseType":

			$siteMgr->getSmsUseUpdate($db);

			/** 2013.04.18 SMS 문자 파일 생성 추가 **/
			## STEP 1.
			## 데이터 만들기
			/* 전송코드 */
			$dataTemp	= "";
			$dataTemp	= sprintf("\$SMS_INFO['%s']", "S_SMS_USE");
			$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
			$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['s_smsUse']); 
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			## STEP 2.
			## 파일 만들기(기존 데이터 업데이트 형)
			require_once		"{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
			$smsConfName		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
			$file				= new FileHandler();	
			$file->getMadeInfo($smsConfName, $data, "/*@ SMS_USE_INFO @*/");
			/** 2013.04.18 상품 브랜드 파일 생성 **/
		break;

		case "postSmsWrite":
			// 문자신규등록
		
			$postSmsMgr->setPS_REG_NO($_SESSION["ADMIN_NO"]);
			$postSmsMgr->setPS_MOD_NO($_SESSION["ADMIN_NO"]);
			$postSmsMgr->getPostSmsInsert($db);
		break;

		case "postSmsModify":
			// 문자수정

			$postSmsMgr->setPS_MOD_NO($_SESSION["ADMIN_NO"]);
			$postSmsMgr->getPostSmsUpdate($db);
		
		break;

		case "postSmsDelete":
			// 문자삭제

			$postSmsMgr->getPostSmsDelete($db);
		break;

		case "postSmsSend":
			// 문자 보내기

			/* 문자 발송 */
			$emTranMgr->setTRAN_PHONE($setRECEIVE_HP);			// 받는사람 연락처
			$emTranMgr->setTRAN_CALLBACK($setSEND_HP);			// 보내는사람 연락처
			$emTranMgr->setTRAN_STATUS(1);						// 전송요구(1), 나머지 값은 메뉴얼 참고
			$emTranMgr->setTRAN_DATE("sysdate()");				// 전송시간
			$emTranMgr->setTRAN_MSG($strPS_TEXT);				// 메시지
			$emTranMgr->setTRAN_TYPE(4);						// SMS(4), 나머지 값은 메뉴얼 참고		
			$emTranMgr->getEmTranInsert($smsDB);
			/* 문자 발송 */

			/* 문자 발송 로그 */
			$sendSmsResult = 1;
			$postSmsLogMgr->setPL_PS_NO("-1");						// 문자번호(로그용)			
			$postSmsLogMgr->setPL_FROM_M_HP($setSEND_HP);			// 보내는사람 문자(로그용)
			$postSmsLogMgr->setPL_FROM_M_NAME($setSEND_NAME);		// 보내는사람 이름(로그용)
			$postSmsLogMgr->setPL_FROM_M_NO($setSEND_NO);			// 보내는사람 회원번호(로그용)
			$postSmsLogMgr->setPL_TEXT($strPS_TEXT);				// 문자내용
			$postSmsLogMgr->setPL_IP(getClientIP());				// 클라이언트 IP
			$postSmsLogMgr->setPL_REG_NO($_SESSION["ADMIN_NO"]);	// 로그인 회원 번호(로그용)
			$postSmsLogMgr->setPL_TO_M_HP($setRECEIVE_HP);			// 받는사람 문자(로그용)
			$postSmsLogMgr->setPL_TO_M_NAME($setRECEIVE_NAME);		// 받는사람 이름(로그용)
			$postSmsLogMgr->setPL_TO_M_NO($setRECEIVE_NO);			// 보내는사람 회원번호(로그용)
			$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);		// 결과(로그용)
			$postSmsLogMgr->getPostSmsLogInsert($db);
			/* 문자 발송 로그 */
		break;

		case "postSmsShotSend":
			// 대량문자 보내기

			## 모듈 설정
			$siteInfo					= new SiteInfoModule($db);

			## 문자 발송 가능 여부 체크
			$param						= "";
			$param['COL']				= "S_SMS_USE";
			$siteInfoRow				= $siteInfo->getSiteInfoSelectEx("OP_SELECT", $param);
			$strSmsUse					= $siteInfoRow['VAL'];
			if($strSmsUse != "Y"):
				goErrMsg("문자 발송 설정이 비활성화 되어있습니다.");
				break;
			endif;

			## 문자 발송 남은 개수 체크
			$param						= "";
			$param['COL']				= "S_SMS_MONEY";
			$siteInfoRow				= $siteInfo->getSiteInfoSelectEx("OP_SELECT", $param);
			$intSmsMoney				= $siteInfoRow['VAL'];
			$intSmsView					= $siteInfoRow['VIEW'];
			$intSmsMemo					= $siteInfoRow['MEMO'];
			if($intSmsMoney <= 0):
				goErrMsg("문자발송 금액이 부족합니다.!");
				break;
			endif;

			if(!$intPS_NO) :
				// 신규 문자인 경우
				$postSmsMgr->setPS_REG_NO($_SESSION["ADMIN_NO"]);
				$postSmsMgr->setPS_MOD_NO($_SESSION["ADMIN_NO"]);
				$postSmsMgr->getPostSmsInsert($db);
				$intPS_NO = $db->getLastInsertID();
			endif;
			
			/* 회원검색(2013.08.13) */
			$strLinkPageStr			= "memPage";
			$strSearchTotalLimitYN	= "Y";	//전체검색

			include MALL_WEB_PATH."shopAdmin/member/member/memberList.helper.inc.php";
			$memberListResult = $result;
			/* 회원검색(2013.08.13) */

			if(!$S_COM_PHONE):
				goErrMsg("보내는 사람 연락처 정보가 없습니다. 관리자에게 문의하세요.");
				exit;
			endif;
				
//			$emTranMgr->setTRAN_PHONE("010-4473-6700");			// 받는사람 연락처
//			$emTranMgr->setTRAN_CALLBACK("010-4473-6700");		// 보내는사람 연락처
			$emTranMgr->setTRAN_CALLBACK($S_COM_PHONE);		// 보내는사람 연락처
			$emTranMgr->setTRAN_STATUS(1);						// 전송요구(1), 나머지 값은 메뉴얼 참고
			$emTranMgr->setTRAN_DATE("sysdate()");				// 전송시간
			$emTranMgr->setTRAN_MSG($strPS_TEXT);				// 메시지
			$emTranMgr->setTRAN_TYPE(4);						// SMS(4), 나머지 값은 메뉴얼 참고		

			$strSmsFromHP		= $S_COM_PHONE;
			$strSmsFromName		= $S_SITE_NM;
			$strSmsFromNo		= -1;

			// // 문자 로그 정보
			$postSmsLogMgr->setPL_PS_NO($intPS_NO);					// 문자번호(로그용)			
			$postSmsLogMgr->setPL_FROM_M_HP($strSmsFromHP);			// 보내는사람 문자(로그용)
			$postSmsLogMgr->setPL_FROM_M_NAME($strSmsFromName);		// 보내는사람 이름(로그용)
			$postSmsLogMgr->setPL_FROM_M_NO($strSmsFromNo);			// 보내는사람 회원번호(로그용)
			$postSmsLogMgr->setPL_TEXT($strPS_TEXT);				// 문자내용
			$postSmsLogMgr->setPL_IP(getClientIP());				// 클라이언트 IP
			$postSmsLogMgr->setPL_REG_NO($_SESSION["ADMIN_NO"]);	// 로그인 회원 번호(로그용)

			$smsDB->connect();	
			
			while($row = mysql_fetch_array($memberListResult)) : 
			
				if($intSmsMoney <= 0):

					## 문자 발송 건수 차감.
					$param						= "";
					$param['COL']				= "S_SMS_MONEY";
					$param['VAL']				= $intSmsMoney;
					$param['VIEW']				= $intSmsView;
					$param['MEMO']				= $intSmsMemo;
					$param['MOD_DT']			= "NOW()";
					$param['MOD_NO']			= $memberNo;
					$siteInfoRow				= $siteInfo->getSiteInfoUpdateEx($param);

					goErrMsg("문자발송 금액이 부족합니다.");
					exit;
				endif;

				$strSmsToName			= $row['M_F_NAME'] . " " . $row['M_L_NAME'];			// 받는 사람 이름
				$strSmsToHp				= $row['M_HP'];	
				$strSmsToNo				= $row['M_NO'];

				// 받는 사람 연락처
				$postSmsLogMgr->setPL_TO_M_HP($strSmsToHp);				// 받는사람 문자(로그용)
				$postSmsLogMgr->setPL_TO_M_NAME($strSmsToName);			// 받는사람 이름(로그용)
				$postSmsLogMgr->setPL_TO_M_NO($strSmsToNo);				// 보내는사람 회원번호(로그용)

				if($strSendType == "A") :
					// 선택된 회원에게 메일보내기.
					if(!in_array($row['M_NO'], $_POST["chkNo"])) :
						// 선택된 회원이 아니라면, 
						continue;
					endif;
				endif;

				if($row['M_SMSYN'] != "Y") :
					// 문자수신거부 처리
				endif;		

				if(!$strSmsToName) :
					// 받는사람 이름 없음
					$sendSmsResult = "9";
					$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);	// 결과(로그용)
					$postSmsLogMgr->getPostSmsLogInsert($db);
					continue;
				endif;

				if(!$strSmsToHp) :
					// 받는사람 연락처 없음
					$sendSmsResult = "8";
					$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);	// 결과(로그용)
					$postSmsLogMgr->getPostSmsLogInsert($db);
					continue;
				endif;

				/* SMS */
				$emTranMgr->setTRAN_PHONE($strSmsToHp);		// 받는사람 연락처		
				$emTranMgr->getEmTranInsert($smsDB);
//				echo $smsDB->query;

				/* 로그 */
				$sendSmsResult = 1;
				$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);		// 결과(로그용)
				$postSmsLogMgr->getPostSmsLogInsert($db);

				$intSmsMoney--;
			endwhile;

			## 문자 발송 건수 차감.
			$param						= "";
			$param['COL']				= "S_SMS_MONEY";
			$param['VAL']				= $intSmsMoney;
			$param['VIEW']				= $intSmsView;
			$param['MEMO']				= $intSmsMemo;
			$param['MOD_DT']			= "NOW()";
			$param['MOD_NO']			= $memberNo;
			$siteInfoRow				= $siteInfo->getSiteInfoUpdateEx($param);

			$smsDB->disConnect();
			/* 문자 보내기 */
		break;

		case "postSmsExcelUpload":

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
			$uid	 			= "smsInsertExcel_".date("YmdHis");		// 파일업로드명의 구분자
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
			
			$postSmsLogMgr->setPL_PS_NO($intPS_NO);					// 문자번호(로그용)			
			$postSmsLogMgr->setPL_FROM_M_HP("");					// 보내는사람 문자(로그용)
			$postSmsLogMgr->setPL_FROM_M_NAME("");					// 보내는사람 이름(로그용)
			$postSmsLogMgr->setPL_FROM_M_NO("");					// 보내는사람 회원번호(로그용)
			$postSmsLogMgr->setPL_TEXT("");							// 문자내용
			$postSmsLogMgr->setPL_IP("");							// 클라이언트 IP
			$postSmsLogMgr->setPL_SEND_RESULT("2");
			$postSmsLogMgr->setPL_REG_NO($a_admin_no);			   // 로그인 회원 번호(로그용)

			$intTotalCnt = $intSucCnt = $intErrCnt = 0;
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) :
				$intTotalCnt++;

				$strCol1	= $data->sheets[0]['cells'][$i][1];			//받는사람
				$strCol2	= $data->sheets[0]['cells'][$i][2];			//받는사람연락처
				
				$postSmsLogMgr->setPL_TO_M_HP($strCol2);				// 받는사람 문자(로그용)
				$postSmsLogMgr->setPL_TO_M_NAME($strCol1);				// 받는사람 이름(로그용)
				$postSmsLogMgr->setPL_TO_M_NO(0);						// 보내는사람 회원번호(로그용)
				$intDupCnt = $postSmsLogMgr->getPostSmsLogDup($db);
				if ($intDupCnt > 0) {
					$intErrCnt++;
					continue;
				}
				
				$postSmsLogMgr->getPostSmsLogInsert($db);
				$intSucCnt++;
			endfor;
			/* Excel 영역 */

			// 파일 삭제
			$fh->fileDelete($strFileInServer);
			
			$strErrMsg = "총 ".$intTotalCnt."건 중 ".$intSucCnt."건 성공/".$intErrCnt."건 중복";
			
//			$strUrl = "./?menuType=".$strMenuType."&mode=memberInsertExcelWrite";
//			$strMsg = "등록되었습니다.";			
						
		break;

		case "postSmsLogSend":

			$strSmsFromHP		= $S_COM_PHONE;
			$strSmsFromName		= $S_SITE_NM;
			$strSmsFromNo		= -1;
			
			$postSmsLogMgr->setPL_FROM_M_HP($strSmsFromHP);			// 보내는사람 문자(로그용)
			$postSmsLogMgr->setPL_FROM_M_NAME($strSmsFromName);		// 보내는사람 이름(로그용)
			$postSmsLogMgr->setPL_FROM_M_NO($strSmsFromNo);			// 보내는사람 회원번호(로그용)
			$postSmsLogMgr->setPL_IP(getClientIP());				// 클라이언트 IP
			$postSmsLogMgr->setPL_SEND_RESULT("2");
			$postSmsLogMgr->setPL_PS_NO($intPS_NO);

			$intTotal								= $postSmsLogMgr->getPostSmsLogSelect( $db, "OP_COUNT" );							// 데이터 전체 개수 
			$postSmsLogResult						= $postSmsLogMgr->getPostSmsLogSelect( $db, "OP_LIST" );
			
			$smsDB->connect();
			if ($intTotal > 0){
				
				$postSmsMgr->setPS_NO($intPS_NO);
				$smsInfoRow = $postSmsMgr->getPostSmsSelect($db,"OP_SELECT");
				
				$postSmsLogMgr->setPL_TEXT($smsInfoRow["PS_TEXT"]);	// 문자내용			

				/* 문자 발송 */
				$emTranMgr->setTRAN_STATUS(1);						// 전송요구(1), 나머지 값은 메뉴얼 참고
				$emTranMgr->setTRAN_DATE("sysdate()");				// 전송시간
				$emTranMgr->setTRAN_MSG($smsInfoRow["PS_TEXT"]);	// 메시지
				$emTranMgr->setTRAN_TYPE(4);						// SMS(4), 나머지 값은 메뉴얼 참고		
				$emTranMgr->setTRAN_CALLBACK($strSmsFromHP);		// 보내는사람 연락처				
				/* 문자 발송 */

				while($row = mysql_fetch_array($postSmsLogResult)) : 
					$postSmsLogMgr->setPL_NO($row['PL_NO']);
					
					if ($row['PL_TO_M_HP']){
						$emTranMgr->setTRAN_PHONE($row['PL_TO_M_HP']);			// 받는사람 연락처
						$emTranMgr->getEmTranInsert($smsDB);

						$postSmsLogMgr->setPL_SEND_RESULT("1");		// 결과(로그용)
						$postSmsLogMgr->getPostSmsLogUpdate($db);
					}
				endwhile;
			}

			$smsDB->disConnect();


		break;
		
	endswitch;

	$db->disConnect();

	$STR_MSG['smsModify']			= "내용이 수정 되었습니다.";
	$STR_MSG['smsUseType']			= "내용이 수정 되었습니다.";
	$STR_MSG['postSmsWrite']		= "내용이 등록 되었습니다.";
	$STR_MSG['postSmsModify']		= "내용이 수정 되었습니다.";
	$STR_MSG['postSmsDelete']		= "내용이 삭제 되었습니다.";
	$STR_MSG['postSmsShotSend']		= "문자발송되었습니다.";
	$STR_MSG['postSmsExcelUpload']	= "발송내역이 업로드되었습니다.";
	$STR_MSG['postSmsLogSend']		= "문자발송되었습니다.";

	$strLinkPage					= "&target=$strTarget&page=$intPage";

	$STR_URL['smsModify']			= "./?menuType=$strMenuType&mode=autosms";
	$STR_URL['smsUseType']			= "./?menuType=$strMenuType&mode=autosms";
	$STR_URL['postSmsWrite']		= "./?menuType=$strMenuType&mode=postSmsList";
	$STR_URL['postSmsModify']		= "./?menuType=$strMenuType&mode=postSmsList&ps_no=$intPS_NO";
	$STR_URL['postSmsDelete']		= "./?menuType=$strMenuType&mode=postSmsList";
	$STR_URL['postSmsShotSend']		= "./?menuType=$strMenuType&mode=postSmsList&ps_no=$intPS_NO";
	$STR_URL['postSmsExcelUpload']	= "./?menuType=$strMenuType&mode=postSmsLogList&ps_no=$intPS_NO";
	$STR_URL['postSmsLogSend']	= "./?menuType=$strMenuType&mode=postSmsLogList&ps_no=$intPS_NO";

	goUrl($STR_MSG[$strAct],$STR_URL[$strAct]);

?>