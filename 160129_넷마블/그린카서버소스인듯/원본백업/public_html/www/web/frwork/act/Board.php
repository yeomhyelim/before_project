<?
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";

	$boardMgr = new BoardMgr();
	$memberMgr = new MemberMgr();

	$intPOPUP			= $_POST["popUp"]			? $_POST["popUp"]			: $_REQUEST["popUp"];
	$strP_CODE			= $_POST["pCode"]			? $_POST["pCode"]			: $_REQUEST["pCode"];
	$strFile1			= $_POST["userfile"]		? $_POST["userfile"]		: $_REQUEST["userfile"];


	/*##################################### Parameter 셋팅 #####################################*/
	$strReturnMenu		= $_POST["returnMenu"]		? $_POST["returnMenu"]		: $_REQUEST["returnMenu"];
	$strReturnMode		= $_POST["returnMode"]		? $_POST["returnMode"]		: $_REQUEST["returnMode"];
	$strReturnParam		= $_POST["returnParam"]		? $_POST["returnParam"]		: $_REQUEST["returnParam"];

	$strSearchField		= $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey		= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$strSearchCat1		= $_POST["searchCat1"]		? $_POST["searchCat1"]		: $_REQUEST["searchCat1"];
	$intPage			= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];

	$strB_CODE			= $_POST["bCode"]			? $_POST["bCode"]			: $_REQUEST["bCode"];
	$intB_NO			= $_POST["bNo"]				? $_POST["bNo"]				: $_REQUEST["bNo"];

	$strB_NAME			= $_POST["name"]			? $_POST["name"]			: $_REQUEST["name"];
	$strB_PASS			= $_POST["pass"]			? $_POST["pass"]			: $_REQUEST["pass"];
	$strB_TITLE			= $_POST["title"]			? $_POST["title"]			: $_REQUEST["title"];
	$strB_MAIL			= $_POST["mail"]			? $_POST["mail"]			: $_REQUEST["mail"];
	$strB_NOTICE		= $_POST["noticeYN"]		? $_POST["noticeYN"]		: $_REQUEST["noticeYN"];
	$strB_TEXT			= $_POST["contents"]		? $_POST["contents"]		: $_REQUEST["contents"];
	$strB_HTML			= $_POST["html"]			? $_POST["html"]			: $_REQUEST["html"];
	$strB_LINK			= $_POST["link"]			? $_POST["link"]			: $_REQUEST["link"];
	$intB_CAT1			= $_POST["cat1"]			? $_POST["cat1"]			: $_REQUEST["cat1"];
	$intB_CAT2			= $_POST["cat2"]			? $_POST["cat2"]			: $_REQUEST["cat2"];
	$intB_CAT3			= $_POST["cat3"]			? $_POST["cat3"]			: $_REQUEST["cat3"];
	$strB_TMP1			= $_POST["tmp1"]			? $_POST["tmp1"]			: $_REQUEST["tmp1"];
	$strB_TMP2			= $_POST["tmp2"]			? $_POST["tmp2"]			: $_REQUEST["tmp2"];
	$strB_TMP3			= $_POST["tmp3"]			? $_POST["tmp3"]			: $_REQUEST["tmp3"];
	$strB_TMP4			= $_POST["tmp4"]			? $_POST["tmp4"]			: $_REQUEST["tmp4"];
	$strB_TMP5			= $_POST["tmp5"]			? $_POST["tmp5"]			: $_REQUEST["tmp5"];
	$strB_LOCK			= $_POST["lockYN"]			? $_POST["lockYN"]			: $_REQUEST["lockYN"];

	$intB_FILE_CNT		= $_POST["b_file_cnt"]			? $_POST["b_file_cnt"]			: $_REQUEST["b_file_cnt"];
	$strB_EDIT_USE		= $_POST["b_edit_use"]			? $_POST["b_edit_use"]		: $_REQUEST["b_edit_use"];

	/*##################################### Parameter 셋팅 #####################################*/

	$strB_CODE			= strTrim($strB_CODE,10);

	$strB_TITLE			= strTrim($strB_TITLE,100);
	$strB_NAME			= strTrim($strB_NAME,20);
	$strB_PASS			= strTrim($strB_PASS,20);
	$strB_MAIL			= strTrim($strB_MAIL,50);
	$strB_NOTICE		= strTrim($strB_NOTICE,1);
	$strB_TEXT			= strTrim($strB_TEXT,"");
	$strB_HTML			= strTrim($strB_HTML,1);
	$strB_LINK			= strTrim($strB_LINK,50);
	$strB_TMP1			= strTrim($strB_TMP1,50);
	$strB_TMP2			= strTrim($strB_TMP2,50);
	$strB_TMP3			= strTrim($strB_TMP3,50);
	$strB_TMP4			= strTrim($strB_TMP4,50);
	$strB_TMP5			= strTrim($strB_TMP5,50);
	$strB_IP			= strTrim($strB_IP,20);
	$strB_LOCK			= strTrim($strB_LOCK,1);
	$strB_EDIT_USE = strTrim($strB_EDIT_USE,1);


	if (!$strB_NOTICE) $strB_NOTICE = "N";
	if (!$strB_LOCK) $strB_LOCK = "N";
	if (!$strB_HTML) $strB_HTML = "N";
	if (!$strB_HTML) $strB_IP = $_SERVER["REMOTE_ADDR"];

	if (!$intB_CAT1) $intB_CAT1 = 0;
	if (!$intB_CAT2) $intB_CAT2 = 0;
	if (!$intB_CAT3) $intB_CAT3 = 0;


	$boardMgr->setB_CODE($strB_CODE);
	$boardMgr->setB_TITLE($strB_TITLE);
	$boardMgr->setB_NAME($strB_NAME);
	$boardMgr->setB_PASS($strB_PASS);
	$boardMgr->setB_MAIL($strB_MAIL);
	$boardMgr->setB_NOTICE($strB_NOTICE);
	$boardMgr->setB_TEXT($strB_TEXT);
	$boardMgr->setB_LOCK($strB_LOCK);
	$boardMgr->setB_HTML($strB_HTML);
	$boardMgr->setB_LINK($strB_LINK);
	$boardMgr->setB_CAT1($intB_CAT1);
	$boardMgr->setB_CAT2($intB_CAT2);
	$boardMgr->setB_CAT3($intB_CAT3);
	$boardMgr->setB_TMP1($strB_TMP1);
	$boardMgr->setB_TMP2($strB_TMP2);
	$boardMgr->setB_TMP3($strB_TMP3);
	$boardMgr->setB_TMP4($strB_TMP4);
	$boardMgr->setB_TMP5($strB_TMP5);
	$boardMgr->setB_IP($strB_IP);
	$boardMgr->setB_C_NO(0);

	if (!$g_member_no) $boardMgr->setB_W_NO(0);
	else $boardMgr->setB_W_NO($g_member_no);

	if (!$g_member_no) $boardMgr->setB_R_NO(0);
	else $boardMgr->setB_R_NO($g_member_no);

	$boardMgr->setB_CODE($strB_CODE);
	$boardMgr->setB_TMP1($strP_CODE);
	$boardMgr->setB_TMP2($strB_TMP2);

	$boardMgr->setB_FILE_CNT($intB_FILE_CNT);
	$boardMgr->setB_EDIT_USE($strB_EDIT_USE);

	$strLinkPage = "&searchCat1=$strSearchCat1&searchField=$strSearchField&searchKey=$strSearchKey";

	switch ($strAct) {
		case "prodViewWrite":

			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet			= $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */

			/* 데이터 Insert */
			$intB_NO = $boardMgr->getDataInsert($db);
			/* 데이터 Insert */

			/* 파일 업로드 */
			$tableName			= $boardMgr->getTable();
			 for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) :
				$fileName			= sprintf( "file%d", $i );
				$uploadPath		= sprintf("/upload/data/%s/file%d", strtolower($tableName), $i + 1 );
				uploadFileModule( $tableName , $intB_NO, $i + 1, $fileName, ".", $uploadPath , $i );
			 endfor;
			/* 파일 업로드 */

			/* 페이지 이동 */
//			$strMsg	= "게시글이 등록되었습니다.";
//			$strUrl		= "./?menuType=".$strMenuType."&mode=closeWin&bCode=".$strB_CODE.$strLinkPage;
			/* 페이지 이동 */

			/* 부모 창으로 데이터 전달값 정의 */
			$result[0][B_CODE]			= $strB_CODE;
			$result[0][RET]				= "Y";
			$result[0][MSG]				= "내용이 등록 되었습니다.";
			$result_array					= json_encode($result);
			/* 부모 창으로 데이터 전달값 정의 */

			/* 페이지 닫기 */
			$db->disConnect();
			echo "<script>";
			echo "opener.goOpenWinRet('$strAct', '$result_array');";
			echo "self.close();";
			echo "</script>";
			exit;
			/* 페이지 닫기 */
		break;
		case "prodViewModify":

			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet			= $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */

			/* 데이터 Update */
			$boardMgr->setB_NO($intB_NO);
			$intRet = $boardMgr->getDataUpdate($db);
			if ( $intRet <= 0 ) :
				// 데이터 베이스 등록 오류가 난 경우.
				goClose("예상치 못한 오류입니다. 담당자에게 문의바랍니다.");
				$db->disConnect();
				exit;
			endif;
			/* 데이터 Update */

			/* 파일 업로드 */
			$tableName			= $boardMgr->getTable();
			for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) :
				/* 사용자가 기존에 등록된 파일을 삭제 했다면...*/
				$strName		= "file_delete_" . $i;
				$intF_NO		= $_POST[$strName] ? $_POST[$strName] : $_REQUEST[$strName];
				if ( $intF_NO ) :
					uploadFileMultiDel($tableName,"","",".","",$intF_NO);
				endif;
				/* 사용자가 기존에 등록된 파일을 삭제 했다면...*/
				$fileName			= sprintf( "file%d", $i );
				$uploadPath		= sprintf("/upload/data/%s/file%d", strtolower($tableName), $i + 1 );
				uploadFileModule( $tableName , $intB_NO, $i + 1, $fileName, ".", $uploadPath , $i );
			endfor;
			/* 파일 업로드 */

			/* 부모 창으로 데이터 전달값 정의 */
			$result[0][B_CODE]			= $strB_CODE;
			$result[0][RET]				= "Y";
			$result[0][MSG]				= "내용이 수정 되었습니다.";
			$result_array					= json_encode($result);
			/* 부모 창으로 데이터 전달값 정의 */

			/* 페이지 닫기 */
			$db->disConnect();
			echo "<script>";
			echo "opener.goOpenWinRet('$strAct', '$result_array');";
			echo "self.close();";
			echo "</script>";
			exit;
			/* 페이지 닫기 */
		break;
		case "write":

			$aryBoardSet = $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);

			$intB_NO = $boardMgr->getDataInsert($db);

			/* 파일 업로드 */
			$tableName		= $boardMgr->getTable();
			 for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) :
				$fileName		= sprintf( "file%d", $i );
				$uploadPath		= sprintf("/upload/data/%s/file%d", strtolower($tableName), $i + 1 );
				uploadFileModule( $tableName , $intB_NO, $i + 1, $fileName, ".", $uploadPath , $i );
//				echo  $fileName . "<br>";
			endfor;
			/* 파일 업로드 */

			$strMsg = "게시글이 등록되었습니다.";

			if(!$intPOPUP) {
				$strUrl = "./?menuType=".$strMenuType."&mode=list&bCode=".$strB_CODE.$strLinkPage;
			}
			else
			{
				$db->disConnect();
				goClose($strMsg);
				exit;
			}
		break;

		case "replyWrite":
			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet			= $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			$boardMgr->setB_NO($intB_NO);
			$intB_NO				= $boardMgr->getDataReply($db);

			/* 파일 업로드 */
			$tableName		= $boardMgr->getTable();
			 for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) :
				$fileName			= sprintf( "file%d", $i );
				$uploadPath		= sprintf("/upload/data/%s/file%d", strtolower($tableName), $i + 1 );
				uploadFileModule( $tableName , $intB_NO, $i + 1, $fileName, ".", $uploadPath , $i );
//				echo  $uploadPath;
			endfor;
			/* 파일 업로드 */

			$strMsg = "게시글에 대한 답변글이 등록되었습니다.";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&page=$intPage";
			$strUrl = "./?menuType=".$strMenuType."&mode=list&bCode=".$strB_CODE.$strLinkPage;
		break;


		case "modify":

			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet = $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);

			$boardMgr->setB_NO($intB_NO);
			$row = $boardMgr->getDataView($db);

			if ($row[B_W_NO]){
				if ($row[B_W_NO] != $g_member_no){
					goErrMsg("게시글을 수정하실 권한이 없습니다.");
					$db->disConnect();
					exit;
				}
			} else {
				$boardMgr->setB_PASS($strB_PASS);
				if ($row[B_PASS] != $boardMgr->getB_PASS()){
					goErrMsg("비밀번호가 일치하지 않습니다.");
					$db->disConnect();
					exit;
				}
			}
			$boardMgr->getDataUpdate($db);

			/* 파일 업로드 */
			$tableName		= $boardMgr->getTable();
			 for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) :
				$fileName			= sprintf( "file%d", $i );
				$uploadPath		= sprintf("/upload/data/%s/file%d", strtolower($tableName), $i + 1 );
				uploadFileModule( $tableName , $intB_NO, $i + 1, $fileName, ".", $uploadPath , $i );
//				echo  $uploadPath;
			endfor;
			/* 파일 업로드 */

			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&page=$intPage";

			$strMsg = "게시글이 수정되었습니다.";

			if(!$intPOPUP) {
				$strUrl = "./?menuType=".$strMenuType."&mode=view&bCode=".$strB_CODE."&bNo=".$intB_NO.$strLinkPage;
			}
			else
			{
				$db->disConnect();
				goClose($strMsg);
				exit;
			}

		break;

		case "delete":
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&page=$intPage";

			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet = $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);

			$boardMgr->setB_NO($intB_NO);
			$row = $boardMgr->getDataView($db);

			if ($row[B_W_NO]){
				if ($row[B_W_NO] != $g_member_no){
					goErrMsg("게시글을 삭제하실 권한이 없습니다.");
					$db->disConnect();
					exit;
				}
			} else {
				$boardMgr->setB_PASS($strB_PASS);
				if ($row[B_PASS] != $boardMgr->getB_PASS()){
					goErrMsg("비밀번호가 일치하지 않습니다.");
					$db->disConnect();
					exit;
				}
			}

			$result = $boardMgr->getDataDelete($db);


			if (!$result) { goErrMsg("답변글이 존재하여 삭제하실 수 없습니다.");exit;}
			else {
				uploadFileMultiDel($boardMgr->getTable(),$intB_NO,"",".","","");
				$strMsg = "삭제되었습니다.";

				$strMsg = "게시글이 삭제되었습니다.";
				$strUrl = "./?menuType=".$strMenuType."&mode=list&bCode=".$strB_CODE.$strLinkPage;
			}
		break;


		case "lockLogin":

			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet = $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);

			$boardMgr->setB_NO($intB_NO);
			$row = $boardMgr->getDataView($db);
			$boardMgr->setB_PASS($strB_PASS);

			/*원본글 비밀번호 확인*/
			$boardMgr->setB_COUNT($row[B_COUNT]);
			$boardMgr->setB_STEP($row[B_STEP]);
			$boardMgr->setB_LEVEL($row[B_LEVEL]);
			$aryOrgData = $boardMgr->getDataOrgView($db);
			$strOrgPassYN = "N";
			if (is_array($aryOrgData)){
				for($i=0;$i<sizeof($aryOrgData);$i++){

					if ($boardMgr->getB_PASS() == $aryOrgData[$i][B_PASS]){
						$strOrgPassYN = "Y";
						break;
					}
				}
			}
			/*원본글 비밀번호 확인*/
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$strLinkPage .= "&page=$intPage&returnMode=$strReturnMode";

			if ($strReturnMode == "view"){
				if ($row[B_PASS] == $boardMgr->getB_PASS() || $strOrgPassYN == "Y"){
					$strUrl = "./?menuType=".$strMenuType."&mode=".$strReturnMode."&bCode=".$strB_CODE."&bNo=".$intB_NO.$strLinkPage;
				} else {
					$db->disConnect();
					goErrMsg("비밀번호가 일치하지 않습니다." );
					exit;
				}
			} else {
				if ($row[B_PASS] == $boardMgr->getB_PASS()){
					if ($strReturnMode == "delete"){
						$strUrl = "./?menuType=".$strMenuType."&mode=act&act=delete&bCode=".$strB_CODE."&bNo=".$intB_NO.$strLinkPage;
					} else {
						$strUrl = "./?menuType=".$strMenuType."&mode=".$strReturnMode."&bCode=".$strB_CODE."&bNo=".$intB_NO.$strLinkPage;
					}
				} else {
					$db->disConnect();
					goErrMsg("비밀번호가 일치하지 않습니다." );
					exit;
				}
			}
		break;

	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);
?>