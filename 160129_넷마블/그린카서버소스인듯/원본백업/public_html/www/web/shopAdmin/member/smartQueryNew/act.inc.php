<?
			
	switch ($strAct) {
		case "dataEditEmail":
			// 회원간편검색 EMAIL 전송
		case "dataEditSms":
			// 회원간편검색 SMS 전송


			if($_POST['num'] == "001"):
				$_POST['de_select'] = "A.M_NO, A.M_ID, A.M_HP, A.M_MAIL, A.M_F_NAME, A.M_L_NAME, A.M_SMSYN, A.M_MAILYN";
			elseif($_POST['num'] == "002"):
				if($_POST['send_type'] == "order"): // 주문자 연락처
					$_POST['de_select'] = "B.M_NO, C.M_ID, B.O_J_HP as M_HP, B.O_J_MAIL as M_MAIL, B.O_J_NAME as M_L_NAME, C.M_SMSYN, C.M_MAILYN";
				elseif($_POST['send_type'] == "delivery"): // 배송지 연락처
					$_POST['de_select'] = "B.M_NO, C.M_ID, B.O_B_HP as M_HP, B.O_B_MAIL as M_MAIL, B.O_B_NAME as M_L_NAME, C.M_SMSYN, C.M_MAILYN";
				endif;
			endif;

			## STEP 1. 
			## 검색 컬럼이 없으면 break.
			if(!$_POST['de_select'] && !$_POST['de_where']) { break; }

			## STEP 2.
			## 설정 파일 불러오기
			include_once "dataEdit_{$_POST['num']}.inc.php";
			include_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEdit/dataEdit_{$_POST['num']}.inc.php";

			
			## STEP 3
			## 설정
			require_once MALL_CONF_LIB."DataEditMgr.php";
			$dataEditModule = new DataEditModule($db, $_POST);

			## STEP 4.
			## 쿼리 만들기
			if(!$_POST['de_select']) { break; }
//			$query		= "SELECT {$_POST['de_select']} FROM MEMBER_MGR AS a LEFT OUTER JOIN MEMBER_ADD AS b ON a.M_NO = b.M_NO ";
//			$query		= sprintf($query_data, $_POST['de_select']); /** 2013.05.02 문자열크키가 큰경우 실행 안되는 버그 있음. **/
			$query		= $query_data;
			
			if($_POST['de_where_join']) :
//				if($_POST['de_where_join'] == "{code_1}"):
//					$where_join			= "WHERE A.O_STATUS = 'E'"; 
//				else:
//					$where_join			= "WHERE {$_POST['de_where_join']}"; 
//				endif;
				
				$where_join			= "WHERE {$_POST['de_where_join']}"; 

				if(eregi("B.P_CODE", $where_join)):
					$where_join			= str_replace("{de_where_join}", $where_join, $query_join_data2);
				else:
					$where_join			= str_replace("{de_where_join}", $where_join, $query_join_data1);
				endif;
			endif;
			$query		= str_replace("{query_join_data}", $where_join, $query);

			if($_POST['de_where']) { $where	 = "WHERE {$_POST['de_where']}"; }
			$query		= str_replace("{de_where}", $where, $query);

			if($_POST['de_order']) { $order	 = "ORDER BY {$_POST['de_order']}"; }
			$query		 = str_replace("{de_order}", $order, $query);
	
			$query		 = str_replace("{de_select}", $_POST['de_select'], $query);

//			$query		.= "LIMIT 0, 1 ";
			$result		 = $db->getExecSql("SET @RANK := 0, @PREV := ''");
			$result		 = $db->getExecSqlNoErrorMsg($query);

			if($strAct == "dataEditEmail"):
				/* 메일 전송 */

				## TEST 메일 리스트
//				$testMailList = array( "shimtot@naver.com", "shimtot@nate.com", "shimtot@eumshop.co.kr", "shimtot@gamil.com", "rje55@naver.com", "airahn@naver.com", 
//										"airahn76@hanmail.net", "jyd@eumshop.co.kr", "airahn76@gmail.com", "khs@eumshop.co.kr", "khs@nate.co.kr");

				## STEP 1.
				## 설정
				require_once MALL_CONF_LIB."PostMailMgr.php";
				require_once MALL_CONF_LIB."PostMailLogMgr.php";
				$postMailMgr			= new PostMailMgr();
				$postMailLogMgr			= new PostMailLogMgr();
			
				## STEP 2.
				## 메일 정보 설정
				$strMailFromName		= $_POST['send_name'];			// 보내는 사람 이름
				$strMailFromAddr		= $_POST['send_email'];			// 보내는 사람 메일
				$strMailTitle			= $_POST['pm_title'];			// 메일 제목
				$strContents			= $_POST['pm_text'];			// 메일 내용
				$postCnt				= 0;

				/** 메일 내용 필터링 **/
//				$strContents			= strConvertCut2($strContents);
				$strContents			= str_replace("\n", "<br>", $strContents);	

				## STEP 3.
				## post_mail 메일 발송 메시지 기록
				$postMailMgr->setPM_TITLE($strMailTitle);
				$postMailMgr->setPM_TEXT($strContents);
				$postMailMgr->setPM_REG_NO($_SESSION['ADMIN_NO']);
				$postMailMgr->setPM_MOD_NO($_SESSION['ADMIN_NO']);
				$re = $postMailMgr->getPostMailInsert($db);
				if($re != 1):
					// 메일 발송 메시지 기록 오류...
					echo "관리자에게 문의하세요..";
					exit;
				endif;
				$intPM_NO = $db->getLastInsertID();

				## STEP 4.
				## 메일 전송			
				while($row = mysql_fetch_array($result)):
					
					$strMailToName			= $row['M_L_NAME'] . " " . $row['M_F_NAME'];
					$strMailToAddr			= $row['M_MAIL'];
//					$strMailToName			= "김희성";					// 받는 사람 이름
//					$strMailToAddr			= "khs@eumshop.co.kr";		// 받는 사람 메일

					/* 로그 기록 */
					$postMailLogMgr->setPL_PM_NO($intPM_NO);
					$postMailLogMgr->setPL_FROM_M_MAIL($strMailFromAddr);
					$postMailLogMgr->setPL_FROM_M_NAME($strMailFromName);
					$postMailLogMgr->setPL_FROM_M_NO($_SESSION['ADMIN_NO']);
					$postMailLogMgr->setPL_TO_M_MAIL($strMailToAddr);
					$postMailLogMgr->setPL_TO_M_NAME($strMailToName);
					$postMailLogMgr->setPL_TO_M_NO($row['M_NO']);
					$postMailLogMgr->setPL_IP(getClientIP());
					$postMailLogMgr->setPL_REG_NO($_SESSION['ADMIN_NO']);		
					/* 로그 기록 */

					if($_POST['non_member'] != "Y" && $row['M_NO'] == 0):
						// 비회원 체크
						$sendMailResult = 12;
						$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);			// 결과(로그용)
						$postMailLogMgr->getPostMailLogInsert($db);
						continue;
					endif;

					if($_POST['member_type'] == "sms_y" && $row['M_MAILYN'] != "Y"):
						// 메일 수신 여부 체크
						$sendMailResult = 11;
						$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);			// 결과(로그용)
						$postMailLogMgr->getPostMailLogInsert($db);
						continue;
					endif;


					/* 메일 발송 로그 */
					$sendMailResult			= sendMail($strMailFromName, $strMailFromAddr, $strMailTitle, $strContents,"Y", $strMailToName, $strMailToAddr,"UTF-8");
					$sendMailResult			= ($sendMailResult) ? $sendMailResult : 0;
					$postMailLogMgr->setPL_SEND_RESULT($sendMailResult);
					$postMailLogMgr->getPostMailLogInsert($db);
					if($sendMailResult == 1):
						$postCnt++;
						if(($postCnt / 100) == 99) { sleep(2); }
					endif;
					/* 메일 발송 */

				endwhile;

				## STEP 5.
				## post_mail 카운터 업데이트
				$postMailMgr->setPM_NO($intPM_NO);
				$postMailMgr->setPM_TOTAL_CNT($postCnt);
				$postMailMgr->getPostMailCntUpdate($db);

				$strUrl = "./?menuType={$_POST['menuType']}&mode=popDataEditEmail&num={$_POST['num']}";
			endif;

			if($strAct == "dataEditSms"):
				/** 문자 발송 **/

				## STEP 1.
				## 설정
				require_once MALL_CONF_LIB."PostSmsLogMgr.php"; /** 로그 관련 **/
				require_once MALL_CONF_LIB."PostSmsMgr.php";
				$postSmsMgr			= new PostSmsMgr();
				$postSmsLogMgr		= new PostSmsLogMgr();

				$fromHp				= $_POST['send_hp']; /** 보내는 사람 휴대폰 번호 **/
				if(!$fromHp) { $fromHp = $S_COM_PHONE; }

				## STEP 2.
				## post_sms 문자 발송 메시지 기록
				if(!$intPS_NO) :
					// 신규 문자인 경우
//					$postSmsMgr->setPS_NO();
					$postSmsMgr->setPS_TEXT($_POST['ps_text']);
					$postSmsMgr->setPS_TOTAL_CNT(0);
//					$postSmsMgr->setPS_REG_DT();
					$postSmsMgr->setPS_REG_NO($_SESSION["ADMIN_NO"]);
//					$postSmsMgr->setPS_MOD_DT();
					$postSmsMgr->setPS_MOD_NO($_SESSION["ADMIN_NO"]);
					$postSmsMgr->getPostSmsInsert($db);
					$intPS_NO = $db->getLastInsertID();
				endif;

				

				## STEP 3.
				## 문자 전송
				$postCnt			= 0;
				while($row = mysql_fetch_array($result)):

					$row['M_HP']	= str_replace("-","", $row['M_HP']);

					$postSmsLogMgr->setPL_PS_NO($intPS_NO);							// 문자번호(로그용)			
					$postSmsLogMgr->setPL_FROM_M_HP($fromHp);					// 보내는사람 휴대폰 번호(로그용)
					$postSmsLogMgr->setPL_FROM_M_NAME($_SESSION['ADMIN_NAME']);		// 보내는사람 이름(로그용)
					$postSmsLogMgr->setPL_FROM_M_NO($_SESSION['ADMIN_NO']);			// 보내는사람 회원번호(로그용)
					$postSmsLogMgr->setPL_TEXT($_POST['ps_text']);					// 문자내용
					$postSmsLogMgr->setPL_IP(getClientIP());						// 클라이언트 IP
					$postSmsLogMgr->setPL_REG_NO($_SESSION["ADMIN_NO"]);			// 로그인 회원 번호(로그용)
					$postSmsLogMgr->setPL_TO_M_HP($row['M_HP']);					// 받는사람 문자(로그용)
					$postSmsLogMgr->setPL_TO_M_NAME($row['M_F_NAME']);				// 받는사람 이름(로그용)
					$postSmsLogMgr->setPL_TO_M_NO($row['M_NO']);					// 보내는사람 회원번호(로그용)

					if(!$row['M_HP']):
						// 휴대폰 체크
						$sendSmsResult = 8;
						$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);				// 결과(로그용)
						$postSmsLogMgr->getPostSmsLogInsert($db);
						continue; 
					endif; 

					if($S_SITE_LNG != "KR"):
						// 언어 체크
						$sendSmsResult = 4;
						$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);				// 결과(로그용)
						$postSmsLogMgr->getPostSmsLogInsert($db);
						continue; 
					endif;

					if($_POST['non_member'] != "Y" && $row['M_NO'] == 0):
						// 비회원 체크
						$sendSmsResult = 12;
						$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);				// 결과(로그용)
						$postSmsLogMgr->getPostSmsLogInsert($db);
						continue; 
					endif;

					if($_POST['member_type'] == "sms_y" && $row['M_SMSYN'] != "Y"):
						// sms 수신 여부 체크
						$sendSmsResult = 11;
						$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);				// 결과(로그용)
						$postSmsLogMgr->getPostSmsLogInsert($db);
						continue;
					endif;

					/** 2013.04.18 SMS 전송 모듈 추가 **/
					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
					if($smsMoney['VAL'] > 0):
						$smsPhone			= $row['M_HP'];		
//						$smsPhone			= "01044736700";		
						$smsCallBackPhone	= $fromHp;
						$smsMsg				= $_POST['ps_text'];
						$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
						$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
						$sendSmsResult	= 1;
					else:
						// sms 머니 부족.. 부분 처리..
						$sendSmsResult	= 5;
					endif;

					/* 문자 발송 로그 */
	//				$sendSmsResult	= 1;
					$postSmsLogMgr->setPL_SEND_RESULT($sendSmsResult);				// 결과(로그용)
					$postSmsLogMgr->getPostSmsLogInsert($db);
					if($sendSmsResult == 1) { $postCnt++; }
					/* 문자 발송 로그 */
					/** 2013.04.18 SMS 전송 모듈 추가 **/
				endwhile;

				## STEP 4.
				## post_sms 카운터 업데이트
				$postSmsMgr->setPS_NO($intPS_NO);
				$postSmsMgr->setPS_TOTAL_CNT($postCnt);
				$postSmsMgr->getPostSmsCntUpdate($db);
				
				$strUrl = "./?menuType={$_POST['menuType']}&mode=popDataEditSms&num={$_POST['num']}&send_hp={$_POST['send_hp']}";
			endif;
			
		break;
		case "dataEditDelete":
			// 회원간편검색 설정 정보 삭제

			## STEP 1.
			## 설정 리스트 불러오기
			$dataEditSetConfigFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/dataEditSet_{$_POST['num']}.config.info.php";
			include_once $dataEditSetConfigFile;

			## STEP 2.
			## 기존에 설정된 설정 정보 불러오기
			$dataEditSetName	= $dataEditSet[$_REQUEST['setNo']]['FILE'];
			$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/{$dataEditSetName}";

			## STEP 3.
			## 설정 파일 삭제
			unlink($fileName);

			## STEP 4.
			## 설정 파일 재기록
			$data		= "";
			$cnt		= sizeof($dataEditSet);
			for($i=0;$i<$cnt;$i++):
				if($i == $_REQUEST['setNo']) { continue; }
				$dataTemp	= "\$dataEditSet[$i]['NAME']";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $dataEditSet[$i]['NAME']); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$dataEditSet[$i]['FILE']";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $dataEditSet[$i]['FILE']); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;
			endfor;		
			include_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
			$file			= new FileHandler();
			$file->getMadeInfo($dataEditSetConfigFile, $data, "/*@ config @*/");

			$strUrl = "./?menuType=".$strMenuType."&mode=dataEdit&&num={$_POST['num']}&".$strLinkPage;
		break;
		case "dataEditModify":
			// 회원간편검색 설정 정보 수정

			## STEP 1.
			## 설정 리스트 불러오기
			$dataEditSetInfoFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/dataEditSet_{$_POST['num']}.config.info.php";
			include_once $dataEditSetInfoFile;

			## STEP 2.
			## 기존에 설정된 설정 정보 불러오기
			$dataEditSetName	= $dataEditSet[$_REQUEST['setNo']]['FILE'];
			$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/{$dataEditSetName}";

			## STEP 3.
			## 파일 클레스 선언
			include_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
			$file				= new FileHandler();

//		break; /** dataEditWrite 통합 **/
		case "dataEditWrite":
			// 회원간편검색 설정 정보 저장

			## STEP 1.
			## 설정 파일 불러오기
//			$dataEditInfoFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEdit/dataEdit_{$_POST['num']}.inc.php";
//			if(!is_file($dataEditInfoFile)):
//				echo "no file";
//				exit;
//			endif;
//			include_once $dataEditInfoFile;

			## STEP 3.
			## 파일 저장
			if($strAct == "dataEditWrite"):
				include_once "{$S_DOCUMENT_ROOT}www/classes/file/file.handler.class.php";
				$file				= new FileHandler();
				$rand				= rand(1000,9999);//난수(4자리)
				$dataEditSetName	= date("YmdHis") . "_dataEditSet_" . $rand;
				$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/{$dataEditSetName}.info.php";
			endif;

			$data				= "";
			$cnt = sizeof($_POST['selectColumn']);
			for($i=0;$i<$cnt;$i++):
				$dataTemp	= "";
				$dataTemp	= "\$selectColumn[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['selectColumn'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;
			endfor;
			$file->getMadeInfo($fileName, $data, "/*@ selectColumn @*/");

			$data				= "";
			$cnt = sizeof($_POST['whereWordColumn']);
			for($i=0;$i<$cnt;$i++):
				$dataTemp	= "";
				$dataTemp	= "\$whereWordLink[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereWordLink'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$whereWordColumn[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereWordColumn'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$whereWordText[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereWordText'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$whereWordType[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereWordType'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;
			endfor;
			$file->getMadeInfo($fileName, $data, "/*@ whereWord @*/");

			$data				= "";
			$cnt = sizeof($_POST['whereDateColumn']);
			for($i=0;$i<$cnt;$i++):
				$dataTemp	= "";
				$dataTemp	= "\$whereDateLink[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereDateLink'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$whereDateColumn[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereDateColumn'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$whereDateStart[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereDateStart'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$whereDateEnd[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereDateEnd'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$whereDateType[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['whereDateType'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;
			endfor;
			$file->getMadeInfo($fileName, $data, "/*@ whereDate @*/");


			$data				= "";
			$cnt = sizeof($_POST['orderColumn']);
			for($i=0;$i<$cnt;$i++):
				$dataTemp	= "";
				$dataTemp	= "\$orderColumn[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['orderColumn'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$orderType[$i]";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['orderType'][$i]); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;
			endfor;
			$file->getMadeInfo($fileName, $data, "/*@ order @*/");

			/** dataEditModify 종료 **/
			if($strAct == "dataEditModify"):
				$strUrl = "./?menuType=".$strMenuType."&mode=popDataEditSearch&num={$_POST['num']}&setNo={$_REQUEST['setNo']}&{$strLinkPage}";
				break;
			endif; 
			/** dataEditModify 종료 **/

 			## STEP 4.
			## 파일 저장(dataEditSet.config.info.php)
			$configFile		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/dataEditSet/dataEditSet_{$_POST['num']}.config.info.php";
			include_once $configFile;

			/** 기존 데이터 **/
			$data		= "";
			$cnt		= sizeof($dataEditSet);
			for($i=0;$i<$cnt;$i++):
				$dataTemp	= "\$dataEditSet[$i]['NAME']";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $dataEditSet[$i]['NAME']); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;

				$dataTemp	= "\$dataEditSet[$i]['FILE']";
				$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
				$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $dataEditSet[$i]['FILE']); 
				$data	   .= ($data) ? "\r\n" : "";
				$data	   .= $dataTemp;
			endfor;
			
			/** 신규 **/
			$dataTemp	= "\$dataEditSet[$i]['NAME']";
			$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
			$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, $_POST['saveName']); 
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			$dataTemp	= "\$dataEditSet[$i]['FILE']";
			$dataTemp	= str_pad($dataTemp, 70, " ", STR_PAD_RIGHT);
			$dataTemp	= sprintf("%s = \"%s\";", $dataTemp, "{$dataEditSetName}.info.php"); 
			$data	   .= ($data) ? "\r\n" : "";
			$data	   .= $dataTemp;

			$file->getMadeInfo($configFile, $data, "/*@ config @*/");

			$strUrl = "./?menuType=".$strMenuType."&mode=popDataEditSearch&num={$_POST['num']}&".$strLinkPage;
		break;
	}

?>