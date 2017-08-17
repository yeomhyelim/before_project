<?
	
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";

	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$pointMgr = new PointMgr();	

	require_once "basic.param.inc.php";
	
	/*##################################### Parameter 셋팅 #####################################*/
	/*##################################### Parameter 셋팅 #####################################*/


			
	switch ($strAct) {
		case "memberPointWrite":
			// 포인트 엑셀(CSV) 일괄지급
			
			$_FILE		= $_FILES['file1'];
			
			if($_FILE['error'] > 0) :
				// error 처리
				echo "업로드 오류 처리 하세요...";
				break;
			endif;
			
			if(!$_FILE['name']):
				// 파일명이 없을 때 처리.
				echo "파일명 설정이 안되어 있습니다. 처리하세요...";
				break;
			endif;

			// 파일 업로드
			$uid	 			= "memberPointExcel_".date("YmdHis");	// 파일업로드명의 구분자
			$upload_dir			= WEB_UPLOAD_PATH . "/temp" ;			// 업로드할 폴더명
			$file_name			= $_FILE['name'];						// 파일명
			$file_tmp_name		= $_FILE['tmp_name'];					// 업로드할 임시 파일명
			$file_size			= $_FILE['size'];						// 업로드할 파일 크기
			$file_type			= $_FILE['type'];						// 업로드할 파일 타입

			$fres 				= $fh->doUpload($uid, $upload_dir, $file_name, $file_tmp_name, $file_size, $file_type);
			
			if(!$fres) :
				// 업로드 실패 처리
				echo "업로드 실패 영역 처리 하세요...";
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
			
			$strPT_START_DT = date("Y-m-d");
			$strPT_END_DT	= date("Y-m-d", strtotime ("+1 years"));
			$strPT_TYPE		= "006";
			for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) :

				/* 회원 검색 */
				$strMember		= $data->sheets[0]['cells'][$i][1];		//아이디
				if($_POST["pt_member_op"] == "id") :
					// id로 회원 검색
					$memberMgr->setM_ID($strMember);		
				elseif($_POST["pt_member_op"] == "mail") :
					// email로 회원 검색
					$memberMgr->setM_MAIL($strMember);
				endif;
				$memberInfoRow = $memberMgr->getMemberInfo($db);
				if(!$memberInfoRow):
					// 회원 정보가 없을 때
					continue;
				endif;
				$intM_NO = $memberInfoRow['M_NO'];
				/* 회원 검색 */

				if($_POST["pt_point_op"] == "A"):
					// 엑셀 내용에서 저장 (포인트)
					$intPT_POINT	= $data->sheets[0]['cells'][$i][2];		//현지통화포인트
				endif;

				if($_POST["pt_point_op"] == "A"):
					// 엑셀 내용에서 저장 (메모)
					$strPT_MEMO		= $data->sheets[0]['cells'][$i][3];		//포인트메모
				endif;
				
				$intPT_POINT_TEMP	= $intPT_POINT;


				if($_POST['pt_sum_op'] == "-") :
					// 포인트 차감
					$intPT_POINT_TEMP	= 0 - $intPT_POINT_TEMP;
					$strPT_TYPE			= "007";
				endif;
// 2013.08.22 kim hee sung 차감이 안됩니다.
//				if($strPT_SUM_OP == "-") :
//					// 포인트 차감
//					$intPT_POINT_TEMP	= sprintf("%s%d", $strPT_SUM_OP, $intPT_POINT_TEMP);
//					$strPT_TYPE		= "007";
//				endif;
				
				if ($intPT_POINT > 0) {

					$memberMgr->setM_NO($intM_NO);
					$memberMgr->setM_POINT($intPT_POINT_TEMP);
					$result = $memberMgr->getMemberPointUpdate($db);
					
					if ($result) {
						$pointMgr->setM_NO($intM_NO);					//회원번호
						$pointMgr->setB_NO($intB_NO);					//게시판번호	
						$pointMgr->setO_NO($intO_NO);					//주문번호
						$pointMgr->setPT_TYPE($strPT_TYPE);				//포인트종류
						$pointMgr->setPT_POINT($intPT_POINT_TEMP);		//현지통화포인트
						$pointMgr->setPT_CUR_POINT($intPT_POINT_TEMP);	//기준통화포인트
						$pointMgr->setPT_MEMO($strPT_MEMO);				//포인트메모
						$pointMgr->setPT_START_DT($strPT_START_DT);		//시작일
						$pointMgr->setPT_END_DT($strPT_END_DT);			//종료일
						$pointMgr->setPT_REG_IP(getClientIP());			//등록IP
						$pointMgr->setPT_ETC("포인트엑셀일괄등록");		//기타메모
						$pointMgr->setPT_REG_NO($a_admin_no);	//작성자NO
						$pointMgr->getPointInsert($db);
					}
				}

			endfor;
			/* Excel 영역 */

			// 파일 삭제
			$fh->fileDelete($strFileInServer);
			/* HISTORY 남기기 */
			$pointMgr->setM_NO(0);
			$pointMgr->setH_TAB("POINT_MGR");
			$pointMgr->setH_KEY(0);
			$pointMgr->setH_CODE("001");
			$pointMgr->setH_MEMO("포인트엑셀일괄등록");
			$pointMgr->setH_TEXT("");
			$pointMgr->setH_REG_NO($a_admin_no);
			$pointMgr->setH_ADM_NO($a_admin_no);
			$pointMgr->getHistoryInsert($db);
			/* HISTORY 남기기 */
						
			$strUrl = "./?menuType=".$strMenuType."&mode=memberPointExcelWrite";
			$strMsg = "등록되었습니다.";
		break;
	}

?>