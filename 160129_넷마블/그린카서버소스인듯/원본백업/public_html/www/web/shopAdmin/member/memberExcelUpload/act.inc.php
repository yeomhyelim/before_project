<?	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	$memberMgr = new MemberMgr();
		
	switch ($strAct) {
		case "memberInsertWrite":
			// 회원등록 엑셀(CSV) 일괄지급
			
			$_FILE		= $_FILES['excelFile'];
			
			if($_FILE['error'] > 0) :
				// error 처리
				goErrMsg($LNG_TRANS_CHAR["CS00025"]); //업로드 실패
				break;
			endif;
			
			if(!$_FILE['name']):
				// 파일명이 없을 때 처리.
				goErrMsg($LNG_TRANS_CHAR["CS00012"]); //파일명 설정 오류
				break;
			endif;

			// 파일 업로드
			$uid	 			= "memberInsertExcel_".date("YmdHis");	// 파일업로드명의 구분자
			$upload_dir			= WEB_UPLOAD_PATH . "/temp" ;			// 업로드할 폴더명
			$file_name			= $_FILE['name'];						// 파일명
			$file_tmp_name		= $_FILE['tmp_name'];					// 업로드할 임시 파일명
			$file_size			= $_FILE['size'];						// 업로드할 파일 크기
			$file_type			= $_FILE['type'];						// 업로드할 파일 타입

			$fres 				= $fh->doUpload($uid, $upload_dir, $file_name, $file_tmp_name, $file_size, $file_type);
			
			if(!$fres) :
				// 업로드 실패 처리
				goErrMsg($LNG_TRANS_CHAR["CS00025"]); //업로드 실패
				exit;
				break;
			endif;
			
			$strFileInServer	= $fres['upload_dir'] . "/" . $fres['file_real_name'];
			@chmod($strFileInServer , 0707);	// 권한 변경
			

			/* Excel 영역 */
			require_once MALL_EXCEL_READER;
			$data = new Spreadsheet_Excel_Reader();
			$data->setOutputEncoding('utf-8');
			$data->read($strFileInServer);
			error_reporting(E_ALL ^ E_NOTICE);
			
			$intTotalCnt = $intSucCnt = $intErrCnt = 0;
			for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) :

				$strCol1	= $data->sheets[0]['cells'][$i][1];		//회원그룹
				$strCol2	= $data->sheets[0]['cells'][$i][2];		//아이디
				$strCol3	= $data->sheets[0]['cells'][$i][3];		//비밀번호
				$strCol4	= $data->sheets[0]['cells'][$i][4];		//이름
				$strCol5	= $data->sheets[0]['cells'][$i][5];		//닉네임
				$strCol6	= $data->sheets[0]['cells'][$i][6];		//양력/음력
				$strCol7	= $data->sheets[0]['cells'][$i][7];		//생년월일
				$strCol8	= $data->sheets[0]['cells'][$i][8];		//성별
				$strCol9	= $data->sheets[0]['cells'][$i][9];		//메일
				$strCol10	= $data->sheets[0]['cells'][$i][10];	//전화번호
				$strCol11	= $data->sheets[0]['cells'][$i][11];	//팩스
				$strCol12	= $data->sheets[0]['cells'][$i][12];	//휴대폰
				$strCol13	= $data->sheets[0]['cells'][$i][13];	//우편번호
				$strCol14	= $data->sheets[0]['cells'][$i][14];	//주소
				$strCol15	= $data->sheets[0]['cells'][$i][15];	//상세주소
				$strCol16	= $data->sheets[0]['cells'][$i][16];	//SMS수신여부
				$strCol17	= $data->sheets[0]['cells'][$i][17];	//이메일수신여부
				$strCol18	= $data->sheets[0]['cells'][$i][18];	//남기는글
				$strCol18	= $data->sheets[0]['cells'][$i][19];	//추천인
				$strCol20	= $data->sheets[0]['cells'][$i][20];	//결혼여부
				$strCol21	= $data->sheets[0]['cells'][$i][21];	//결혼일자
				$strCol22	= $data->sheets[0]['cells'][$i][22];	//직업
				$strCol23	= $data->sheets[0]['cells'][$i][23];	//자녀수
				$strCol24	= $data->sheets[0]['cells'][$i][24];	//회사명
				$strCol25	= $data->sheets[0]['cells'][$i][25];	//사업자상호
				$strCol26	= $data->sheets[0]['cells'][$i][26];	//사업자번호
				$strCol27	= $data->sheets[0]['cells'][$i][27];	//업종
				$strCol28	= $data->sheets[0]['cells'][$i][28];	//업태
				$strCol29	= $data->sheets[0]['cells'][$i][29];	//사업자우편번호
				$strCol30	= $data->sheets[0]['cells'][$i][30];	//사업자주소1
				$strCol31	= $data->sheets[0]['cells'][$i][31];	//사업자주소2
				$strCol32	= $data->sheets[0]['cells'][$i][32];	//관심분야
				$strCol33	= $data->sheets[0]['cells'][$i][33];	//임시컬럼1
				$strCol34	= $data->sheets[0]['cells'][$i][34];	//임시컬럼2
				$strCol35	= $data->sheets[0]['cells'][$i][35];	//임시컬럼3
				$strCol36	= $data->sheets[0]['cells'][$i][36];	//임시컬럼4
				$strCol37	= $data->sheets[0]['cells'][$i][37];	//임시컬럼5
				$strCol38	= $data->sheets[0]['cells'][$i][38];	//TM_ID

				$strErrMsg = "";
				/* 회원그룹검색 */
				$memberMgr->setG_NAME($strCol1);
				$strM_GROUP = $memberMgr->getGroupCodeSearch($db);				
				if (!$strM_GROUP) {
					$strErrMsg .= $LNG_TRANS_CHAR["MS00056"]."<br>"; //"회원그룹이 존재하지 않습니다.<br>";
				}
				/* 회원그룹검색 */

				/* 회원ID검색*/
				if ($S_MEM_CERITY == "1") {
					$memberMgr->setM_ID($strCol2);
					$intCnt = $memberMgr->getMemberIdCheck($db);
					if ($intCnt > 0){
						$strErrMsg .= $LNG_TRANS_CHAR["MS00024"]."<br>";
					}
				}
				/* 회원ID검색*/

				/* 회원이메일검색*/
				if ($S_MEM_CERITY == "2") {
					$memberMgr->setM_MAIL($strCol9);
					$intCnt = $memberMgr->getMemberMailCheck($db);
					if ($intCnt > 0){
						$strErrMsg .= $LNG_TRANS_CHAR["MS00027"]."<br>";
					}
				}
				/* 회원이메일검색*/
				

				/* 추천인 검색 */
				if ($strCol19){
					if ($S_MEM_CERITY == "1"){
						$memberMgr->setM_ID($strM_REC_ID);
					} else {
						$memberMgr->setM_MAIL($strM_REC_ID);
					}
					$intRecNo = $memberMgr->getMemberRecNo($db);
					
					if ($intRecNo == 0){
						$strErrMsg .= $LNG_TRANS_CHAR["MS00057"]."<br>";
					}
				}
				/* 추천인 검색 */
				$memberMgr->setM_ID($strCol2);
				$memberMgr->setM_PASS($strCol3);
				$memberMgr->setM_F_NAME("");
				$memberMgr->setM_L_NAME($strCol4);
				$memberMgr->setM_NICK_NAME($strCol5);
				$memberMgr->setM_BIRTH($strCol7);
				$memberMgr->setM_BIRTH_CAL($strCol6);
				$memberMgr->setM_SEX($strCol8);
				$memberMgr->setM_MAIL($strCol9);
				$memberMgr->setM_PHONE($strCol10);
				$memberMgr->setM_HP($strCol12);
				$memberMgr->setM_WED_DAY($strCol21);
				$memberMgr->setM_WED($strCol20);
				$memberMgr->setM_ZIP($strCol13);
				$memberMgr->setM_ADDR($strCol14);
				$memberMgr->setM_ADDR2($strCol15);
				$memberMgr->setM_SMSYN($strCol16);
				$memberMgr->setM_MAILYN($strCol17);
				$memberMgr->setM_TEXT($strCol18);
				$memberMgr->setM_REC_ID("");
				$memberMgr->setM_CONCERN($strCol32);
				$memberMgr->setM_JOB($strCol22);
				$memberMgr->setM_FAX($strCol11);
				$memberMgr->setM_COUNTRY("");
				$memberMgr->setM_CITY("");
				$memberMgr->setM_STATE("");
				$memberMgr->setM_AUTH("Y");
				$memberMgr->setM_GROUP($strM_GROUP);

				$memberMgr->setM_CHILD($strCol23);
				$memberMgr->setM_COM_NM($strCol24);
				$memberMgr->setM_TM_ID($strCol38);
				$memberMgr->setM_BUSI_NM($strCol25);
				$memberMgr->setM_BUSI_NUM($strCol26);
				$memberMgr->setM_BUSI_UPJ($strCol27);
				$memberMgr->setM_BUSI_UTE($strCol28);
				$memberMgr->setM_BUSI_ZIP($strCol29);
				$memberMgr->setM_BUSI_ADDR1($strCol30);
				$memberMgr->setM_BUSI_ADDR2($strCol31);
				$memberMgr->setM_FOREIGN("");
				$memberMgr->setM_FOREIGN_NUM("");
				$memberMgr->setM_PASSPORT("");
				$memberMgr->setM_DRIVE_NUM("");
				$memberMgr->setM_NATION("");
				$memberMgr->setM_PHOTO("");
				$memberMgr->setM_TMP1($strCol33);	
				$memberMgr->setM_TMP2($strCol34);
				$memberMgr->setM_TMP3($strCol35);
				$memberMgr->setM_TMP4($strCol36);
				$memberMgr->setM_TMP5($strCol37);
				$memberMgr->setM_POINT(0);
				
				
				if (!$strErrMsg){
					$memberMgr->getMemberInsert($db);
					$intM_NO = $db->getLastInsertID();
					$memberMgr->setM_NO($intM_NO);
					$memberMgr->getMemberAddInsert($db);
				
					if ($S_MEM_PASS_RECOVERY){
						$memberMgr->setM_NO($intM_NO);
						$memberMgr->getMemberVisitUpdate($db);
					}

					if ($intRecNo > 0){
						$memberMgr->setM_REC_ID($intRecNo);
						$memberMgr->getMemberRecNoUpdate($db);
					}

					$memberMgr->setM_LNG("KR");
					$memberMgr->getMemberLngUpdate($db);
					
					$intSucCnt++;
				} else {
					$intErrCnt++;
					$strErrMsg = callLangTrans($LNG_TRANS_CHAR["MS00058"],array($i,$strErrMsg))."<br>"; //i번째 에러메세지
				}
				
				$intTotalCnt++;
			endfor;
			/* Excel 영역 */

			// 파일 삭제
			$fh->fileDelete($strFileInServer);
			
			$strErrMsg = callLangTrans($LNG_TRANS_CHAR["MS00059"],array($intTotalCnt,$intSucCnt,$intErrCnt))."<br>".$strErrMsg; //총 ".$intTotalCnt."건 중 ".$intSucCnt."건 성공/".$intErrCnt."건 실패
			
			$aryParam["menuType"] = "member";
			$aryParam["mode"] = "memberInsertExcelWrite";
			$aryParam["errMsg"] = $strErrMsg;

			drawPageRedirect("frmAct","./index.php",$aryParam);
			exit;
//			$strUrl = "./?menuType=".$strMenuType."&mode=memberInsertExcelWrite";
//			$strMsg = "등록되었습니다.";
		break;
	}

?>