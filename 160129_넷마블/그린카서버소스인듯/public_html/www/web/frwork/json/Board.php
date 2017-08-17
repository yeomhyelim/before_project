<?
	/*
	 *		작성자 : 김희성(thav@naver.com)
	 *		작성일 : 2012년10월21일
	 *		내   용 : 게시판 글 삭제 및 글 등록, 글 수정
	 *		부   모 : product_BBSList.inc.php
	 *
	 */

	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once "_functionBoard.lib.inc.php";

	$boardMgr						= new BoardMgr();
	$memberMgr						= new MemberMgr();

	$strJsonMode					= $_POST["jsonMode"]							? $_POST["jsonMode"]						: $_REQUEST["jsonMode"];
	$strB_CODE						= $_POST["bCode"]								? $_POST["bCode"]							: $_REQUEST["bCode"];
	$strP_CODE						= $_POST["pCode"]								? $_POST["pCode"]							: $_REQUEST["pCode"];
	$intB_NO						= $_POST["bNo"]									? $_POST["bNo"]								: $_REQUEST["bNo"];
	$strB_PASS						= $_POST["pass"]								? $_POST["pass"]							: $_REQUEST["pass"];
	$intPage						= $_POST["page"]								? $_POST["page"]							: $_REQUEST["page"];
	$intF_NO						= $_POST["f_no"]								? $_POST["f_no"]							: $_REQUEST["f_no"];

	$result_array					= array();	

	switch ($strJsonMode) :	
		case "bbsDataReload":
			// 게시판 JSON 으로 호출
			if($strB_CODE == "REVIEW") :
				$aryBBSFrame['colName']			= array ( '번호', '사용후기', '작성자', '작성일', '평점' );
				$aryBBSFrame['tableStyle']			= array ( 'style=\'width:50px\'', '', 'style=\'width:100px\'', 'style=\'width:90px\'', 'style=\'width:100px\'' );
				$aryBBSFrame['row']					= array ( '{{__NO__}}', '{{__TITLE__}}', 'B_NAME', '{{__REG_DT__}}', 'B_TMP2' );
				$aryBBSFrame['rowStyle']			= array ( 'style=\'text-align:center;\'', 'style=\'text-align:left;\'', 'style=\'text-align:center;\'', 'style=\'text-align:center;\'', 'style=\'text-align:center;\'' );
				$aryBBSFrame['BTextStyle']			= "style=\"text-align:left;padding-left:70px;\"";
			elseif($strB_CODE == "QA"):
				$aryBBSFrame['colName']			= array ( '번호', '문의종류', '문의내용', '작성자', '작성일' );
				$aryBBSFrame['tableStyle']			= array ( 'style=\'width:50px\'', 'style=\'width:100px\'', '', 'style=\'width:90px\'', 'style=\'width:100px\'' );
				$aryBBSFrame['row']					= array ( '{{__NO__}}', '{{__QUESTION_KIND__}}', '{{__TITLE__}}', 'B_NAME', '{{__REG_DT__}}' );
				$aryBBSFrame['rowStyle']			= array ( 'style=\'text-align:center;\'', 'style=\'text-align:center;\'', 'style=\'text-align:left;\'', 'style=\'text-align:center;\'', 'style=\'text-align:center;\'' );
				$aryBBSFrame['kind']					= array ( "001" => "상품", "002" => "배송", "003" => "반품", "004" => "교환", "005" => "기타" );
				$aryBBSFrame['BTextStyle']			= "style=\"text-align:left;padding-left:165px;\"";
			endif;
			$imgReply								= "<img src=\"/himg/board/A0001/icon_re.gif\"/>";
			/* 게시판 정보 체크 */
			if ( !$strB_CODE || !$strP_CODE ) :
				$result[0][RET]					= "SUCCESS_MSG";
				$result[0][MSG]					= "게시판 및 상품 정보가 없습니다.";
				break;
			endif;
			/* 게시판 정보 체크 */

			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet			= $boardMgr->getBoardData($db);

			if(!$aryBoardSet) :
				// 테이블 정보가  없을 때.
				$result[0][RET]					= "SUCCESS_MSG";
				$result[0][MSG]					= "게시판 및 상품 정보가 없습니다.";
				break;
			endif;

			/* 게시판 데이터 리스트 */
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			$boardMgr->setB_TMP1($strP_CODE);
			$boardMgr->setB_REPLY($aryBoardSet[0][B_REPLY]);												// 댓글 기능 사용 하지 않는 경우, B_LEVEL 값이 0인 값만 호출
			$intTotal							= $boardMgr->getDataTotal( $db );								// 데이터 전체 개수 

			$intPageLine						= $aryBoardSet[0]['B_LINE_CNT']	;									// 리스트 개수 
			$intPage							= ( $intPage )				? $intPage				: 1;
			$intFirst								= ( $intTotal == 0 )		? 1						: $intPageLine * ( $intPage - 1 );
			$boardMgr->setLimitFirst( $intFirst );
			$boardMgr->setPageLine( $intPageLine );
			

			$bbsResult						= $boardMgr->getDataList( $db );	

			$intPageBlock					= $aryBoardSet[0]['B_PAGE_CNT'];									// 블럭 개수 
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );					// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );
			/* 게시판 데이터 리스트 */

			/* HTML 코드 */
			$strTableStyle					= sprintf("style=\"width:%d%s\"", $aryBoardSet[0]['B_WIDTH'], $aryBoardSet[0]['B_WIDTH_TYPE']);
			$strTable							= "<table %s>%s</table>";
			$strTr								= "<tr %s>%s</tr>";
			$strTh								= "<th %s>%s</th>";
			$strTd								= "<td %s>%s</td>";
			$responseText					= "";
			$responseHead					= "";
			$responseBody					= "";

			for ( $i = 0 ; $i < sizeof ( $aryBBSFrame['colName'] ) ; $i++ ) :	
				$name					= $aryBBSFrame['colName'][$i];
				$style					= $aryBBSFrame['tableStyle'][$i];	
				$responseHead		= $responseHead . $strTh;
				$responseHead		= sprintf($responseHead, $style, $name);
			endfor;
			$responseHead			= sprintf($strTr, "", $responseHead);

			/*글목록 권한이 없는 경우*/
			if($aryBoardSet[0]['B_LIST'] == 2):
				$responseBody			= sprintf($strTd, "colspan=\"$i\"", "글목록 보기 권한이 없습니다.");
				$responseBody			= sprintf($strTr, "", $responseBody);
				$responseText			=	$responseHead . $responseBody;
				$responseText			= sprintf($strTable, $strTableStyle, $responseText);
				$result[0][RET]			= "SUCCESS_MSG";
				$result[0][MSG]			= $responseText;
				break;
			endif;
			/*글목록 권한이 없는 경우*/

			/* 게시글이 없는 경우 */
			if ( $intTotal == "0" ) : 
				$responseBody			= sprintf($strTd, "colspan=\"$i\"", "등록된 글이 없습니다.");
				$responseBody			= sprintf($strTr, "", $responseBody);
				$responseText			=	$responseHead . $responseBody;
				$responseText			= sprintf($strTable, $strTableStyle, $responseText);
			endif;
			/* 게시글이 없는 경우 */

			while ( $row = mysql_fetch_array ( $bbsResult ) ) :
				$intRowSize			= sizeof ( $aryBBSFrame['row'] );
				$strTempBody		= "";
				for ( $i = 0 ; $i < $intRowSize; $i++ ) :	
					$style				= $aryBBSFrame['rowStyle'][$i];	
					$strTag				= $aryBBSFrame['row'][$i];
					$strVal				= $row[$strTag];
					if ( !$strVal ) :	
						$strTitle		= $row['B_TITLE'];
						/* 내용 보기 권한 */
						if($aryBoardSet[0]['B_VIEW'] == 2):
							$strTitle					= sprintf("<a href=\"javascript:alert('보기 권한이 없습니다.')\">%s</a>", $strTitle);
						else:
							/* 비밀글 */
							if($row['B_LOCK'] == "Y") : 
								$strLockSign			= " [비밀글]";
								$strTitle				= sprintf("<a href=\"javascript:goOpenDialogPassWrite('%s',%d,'%s',%d)\">%s</a>", $strB_CODE, $row['B_NO'], "bbsDataLock", $intPage, $strTitle);
								$strTitle				= $strTitle . $strLockSign;
							else : 
								$strTitle				= sprintf( "<a href=\"javascript:goTextView('%s',%d)\">%s</a>", $strB_CODE, $row['B_NO'], $strTitle );
							endif;
							/* 비밀글 */
						endif;
						/* 내용 보기 권한 */
						if ( $row['B_LEVEL'] > 0 ) :
							$strTitle	= sprintf("%s%s&nbsp;%s", str_repeat ( "&nbsp;", $row['B_LEVEL'] ) , $imgReply, $strTitle );
						endif;
						$strVal			= $strTag;
						$strVal			= str_replace ( "{{__NO__}}",  $intListNum, $strVal );	
						$strVal			= str_replace ( "{{__REG_DT__}}",  date ( "Y.m.d" , strtotime ( $row['B_REG_DT'] ) ), $strVal );	
						$strVal			= str_replace ( "{{__TITLE__}}",  $strTitle, $strVal );	
						$strVal			= str_replace ( "{{__QUESTION_KIND__}}", $aryBBSFrame['kind'][$row['B_TMP2']], $strVal );
					endif;
					$strVal					= ( $strVal == $strTag ) ? "" : $strVal;
					$strTempBody		=	$strTempBody . $strTd;
					$strTempBody		= sprintf($strTempBody, $style, $strVal);
				endfor;
				$responseBody			= $responseBody . $strTr;
				$responseBody			= sprintf($responseBody, "", $strTempBody);

				$responseBody			= $responseBody . $strTr;
				$trId							= sprintf("style=\"display:none\" id=\"text_%s_%d\"", $strB_CODE, $row['B_NO']);
				$trStyle						= sprintf("%s %s" , $aryBBSFrame['BTextStyle'], "colspan=\"$i\"");
				/* 수정 */
				$strModifyBtn			= "[수정]";
				if ( $g_member_no && $g_member_no == $row['B_W_NO'] ):
					// 회원이 작성한 글
				else :
					// 비회원이 작성한 글
					$strModifyBtn		= sprintf("<a href=\"javascript:goOpenDialogPassWrite('%s',%d,'%s',%d)\">%s</a>", $strB_CODE, $row['B_NO'], "bbsDataModify", $intPage, $strModifyBtn);
				endif;
				/* 수정 */
				/* 삭제 */
				$strDeleteBtn			= "[삭제]";
				if ( $g_member_no && $g_member_no == $row['B_W_NO'] ):
					// 회원이 작성한 글
				else :
					// 비회원이 작성한 글
					$strDeleteBtn		= sprintf("<a href=\"javascript:goOpenDialogPassWrite('%s',%d,'%s',%d)\">%s</a>", $strB_CODE, $row['B_NO'], "bbsDataDelete", $intPage, $strDeleteBtn);
				endif;
				/* 삭제 */
				/* 댓글 */
				$strCommendBtn		="[댓글]";
				if ( $g_member_no && $g_member_no == $row['B_W_NO'] ):
					// 회원이 작성한 글
				else :
					// 비회원이 작성한 글
					$strCommendBtn	= sprintf("<a href=\"javascript:goOpenWrite('%s')\">%s</a>", $strB_CODE, $strCommendBtn);
				endif;
				/* 댓글 */
				/* 첨부 파일 */
				$aryFileList			= $boardMgr->getDataViewFile($db, $row['B_NO']);
				foreach($aryFileList as $fileList) :
					$strFileTag		= "<a href=\"./?menuType=api&mode=download&no=%d\">%s</a>";
					$strFile				= $strFile . $strFileTag;
					$strFile				= sprintf($strFile, $fileList['F_NO'], $fileList['F_ORG_NAME']);
				endforeach;
				/* 첨부 파일 */

				/* 내용, 비밀글 & 내용 보기 권한*/
				if($row['B_LOCK'] == "Y" || $aryBoardSet[0]['B_VIEW'] == 2) : 
				$strBText					= "";
				else :
				$strBText					= sprintf("%s %s %s %s %s" , $row['B_TEXT'], $strFile, $strModifyBtn, $strDeleteBtn, $strCommendBtn);
				endif;
				/* 내용, 비밀글 & 내용 보기 권한*/

				$strTempBody			= sprintf($strTd, $trStyle, $strBText);
				$responseBody			= sprintf($responseBody, $trId, $strTempBody);
				$intListNum--;
			endwhile;

			$responseText			=	$responseHead . $responseBody;
			$responseText			= sprintf($strTable,$strTableStyle, $responseText);
			/* HTML 코드 */

			/* 글쓰기 */
			$intBWrite					= $aryBoardSet[0]['B_WRITE'];	
			if($intBWrite!=2):
				$strWriteBtn				= sprintf("<img src=\"/himg/board/A0001/btn_prod_%s_write.png\"/>", strtolower($strB_CODE));
				$strWriteBtn				= sprintf("<a href=\"javascript:goOpenWrite('%s')\">%s</a>", $strB_CODE, $strWriteBtn);
				$responseText			=	$responseText . $strWriteBtn;
			endif;
			/* 글쓰기 */

			/* 게시판 페이지 */
			$pageText					= drawUserJsonPagingRet($intPage, $intPageLine, $intPageBlock, $intTotal, $intTotPage, $linkPage, "", "");
			$pageText					= sprintf("<div id=\"pagenate\">%s</div>", $pageText);
			$responseText			=	$responseText . $pageText;
			/* 게시판 페이지 */
			
			/* 게시판 상단 하단 html */
		//	$strTopHtml				= $aryBoardSet[0]['B_TOP_HTML'];
		//	$strBottomHtml			= $aryBoardSet[0]['B_BOTTOM_HTML'];
		//	$responseText			= $strTopHtml . $responseText . $strBottomHtml	;
			/* 게시판 상단 하단 html */

			$result[0][RET]			= "SUCCESS_MSG";
			$result[0][MSG]			= $responseText;
		break;
		case "bbsDataModify":
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet			= $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
			
			/* 선택된 게시글 정보 불러오기 */
			$boardMgr->setB_NO($intB_NO);
			$boardRow			= $boardMgr->getDataView($db);
			/* 선택된 게시글 정보 불러오기 */
			
			if ( $boardRow['B_W_NO'] == 0 ) :
			// 비회원이 작성한 글
				$boardMgr->setB_PASS($strB_PASS);
				if ( $boardMgr->getB_PASS() == $boardRow['B_PASS'] ) :
					// 비밀번호가 일치 하는 경우
					$_SESSION[SESS_GUEST_PASS]			= $strB_PASS;
					$result[0][RET]								= "SUCCESS_MODIFY_OPEN_WINDOWS";		
					$result[0][MSG]								= "비밀번호가 일치합니다.";	
				else :
					// 비밀번호가 틀린 경우
					$result[0][RET]					= "FAIL_MSG";
					$result[0][MSG]					= "비밀번호가 틀립니다.";	
				endif;
			else :
			// 회원이 작성한 글
			endif;
		break;
		case "bbsDataDelete":
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet			= $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
	
			/* 선택된 게시글 정보 불러오기 */
			$boardMgr->setB_NO($intB_NO);
			$boardRow			= $boardMgr->getDataView($db);
			/* 선택된 게시글 정보 불러오기 */

			if ( $boardRow['B_W_NO'] == 0 ) :
			// 비회원이 작성한 글
				$boardMgr->setB_PASS($strB_PASS);
				if ( $boardMgr->getB_PASS() == $boardRow['B_PASS'] ) :
					// 비밀번호가 일치 하는 경우
					if ( $boardMgr->getDataDelete($db) == 1 ) :
						// 데이터가 삭제된 경우
						/* 파일 삭제 & 데이터 삭제 */
						$tableName			= $boardMgr->getTable(); 
						 for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) : 
							uploadFileMultiDel( $tableName , $intB_NO, $i + 1, ".", $i, "" );
						 endfor;	
						 /* 파일 삭제 & 데이터 삭제 */
						 $result[0][PAGE]		= $intPage;
						 $result[0][B_CODE]	= $strB_CODE;
						 $result[0][RET]			= "SUCCESS_MSG";
						 $result[0][MSG]			= "등록된 글이 삭제되었습니다.";		
					else :
						// 데이터가 삭제되지 못한 경우 ( 답변글이 있는 경우 삭제 북가. )
						$result[0][RET]					= "FAIL_MSG";
						$result[0][MSG]					= "답변글이 있는 경우 삭제가 불가능 합니다.";	
					endif;
				else :
					// 비밀번호가 틀린 경우
					$result[0][RET]					= "FAIL_MSG";
					$result[0][MSG]					= "비밀번호가 틀립니다.";	
				endif;
			else :
			// 회원이 작성한 글
				if ( $g_member_no ) :
					// 회원인 경우
					if (  $boardRow['B_W_NO'] == $g_member_no ) :
						// 작성글 회원과 로그인 회원이 같은 경우.
						if ( $boardMgr->getDataDelete($db) == 1 ) :
							// 데이터가 삭제된 경우
							/* 파일 삭제 & 데이터 삭제 */
							$tableName			= $boardMgr->getTable(); 
							 for ( $i=0; $i < $aryBoardSet[0][B_FILE_CNT]; $i++ ) : 
								uploadFileMultiDel( $tableName , $intB_NO, $i + 1, ".", $i, "" );
							 endfor;	
							 /* 파일 삭제 & 데이터 삭제 */
							$result[0][PAGE]			= $intPage;
							$result[0][B_CODE]		= $strB_CODE;
							$result[0][RET]			= "SUCCESS_MSG";
							$result[0][MSG]			= "등록된 글이 삭제되었습니다.";		
						else :
							// 데이터가 삭제되지 못한 경우 ( 답변글이 있는 경우 삭제 북가. )
							$result[0][RET]					= "FAIL_MSG";
							$result[0][MSG]					= "답변글이 있는 경우 삭제가 불가능 합니다.";	
						endif;
					else :
						// 작성글 회원과 로그인 회원이 다른 경우.
						$result[0][RET]					= "FAIL_MSG";
						$result[0][MSG]					= "회원님께서 작성하신 글이 아닙니다.";	
					endif;
				else :
					// 비회원인 경우
					$result[0][RET]					= "FAIL_MSG";
					$result[0][MSG]					= "로그인이 필요합니다.";	
				endif;
			endif;
		break;
		case "bbsDataLock":
			// 비밀글 비밀번호
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
			$boardMgr->setB_CODE($strB_CODE);
			$aryBoardSet			= $boardMgr->getBoardData($db);
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			/* 게시판 정보 가져오기 및 데이터베이스 이름 설정 */
			
			/* 선택된 게시글 정보 불러오기 */
			$boardMgr->setB_NO($intB_NO);
			$boardRow			= $boardMgr->getDataView($db);
			/* 선택된 게시글 정보 불러오기 */

			/* 수정 */
			$strModifyBtn			= "[수정]";
			if ( $g_member_no && $g_member_no == $boardRow['B_W_NO'] ):
				// 회원이 작성한 글
			else :
				// 비회원이 작성한 글
				$strModifyBtn		= sprintf("<a href=\"javascript:goOpenDialogPassWrite('%s',%d,'%s',%d)\">%s</a>", $strB_CODE, $boardRow['B_NO'], "bbsDataModify", $intPage, $strModifyBtn);
			endif;
			/* 수정 */
			/* 삭제 */
			$strDeleteBtn			= "[삭제]";
			if ( $g_member_no && $g_member_no == $row['B_W_NO'] ):
				// 회원이 작성한 글
			else :
				// 비회원이 작성한 글
				$strDeleteBtn		= sprintf("<a href=\"javascript:goOpenDialogPassWrite('%s',%d,'%s',%d)\">%s</a>", $strB_CODE, $boardRow['B_NO'], "bbsDataDelete", $intPage, $strDeleteBtn);
			endif;
			/* 삭제 */
			/* 댓글 */
			$strCommendBtn		="[댓글]";
			if ( $g_member_no && $g_member_no == $boardRow['B_W_NO'] ):
				// 회원이 작성한 글
			else :
				// 비회원이 작성한 글
				$strCommendBtn	= sprintf("<a href=\"javascript:goOpenWrite('%s')\">%s</a>", $strB_CODE, $strCommendBtn);
			endif;
			/* 댓글 */
			/* 첨부 파일 */
			$aryFileList			= $boardMgr->getDataViewFile($db, $boardRow['B_NO']);
			foreach($aryFileList as $fileList) :
				$strFileTag		= "<a href=\"./?menuType=api&mode=download&no=%d\">%s</a>";
				$strFile				= $strFile . $strFileTag;
				$strFile				= sprintf($strFile, $fileList['F_NO'], $fileList['F_ORG_NAME']);
			endforeach;
			/* 첨부 파일 */
			/* 내용, 비밀글 */
			$strBText					= sprintf("%s %s %s %s %s" , $boardRow['B_TEXT'], $strFile, $strModifyBtn, $strDeleteBtn, $strCommendBtn);
			/* 내용, 비밀글 */

			if ( $boardRow['B_W_NO'] == 0 ) :
			// 비회원이 작성한 글
				$boardMgr->setB_PASS($strB_PASS);
				if ( $boardMgr->getB_PASS() == $boardRow['B_PASS'] ) :
					// 비밀번호가 일치 하는 경우
					$result[0][B_CODE]							= $strB_CODE;
					$result[0][B_TEXT]							= $strBText;
					$result[0][RET]								= "SUCCESS_TEXT";		
					$result[0][MSG]								= "비밀번호가 일치합니다.";	
				else :
					// 비밀번호가 틀린 경우
					$result[0][RET]					= "FAIL_MSG";
					$result[0][MSG]					= "비밀번호가 틀립니다.";	
				endif;
			else :
			// 회원이 작성한 글
				$result[0][RET]			= "FAIL_MSG";
				$result[0][MSG]			= $boardMgr->getB_PASS();
			endif;
		break;
		case "dataFileDelete":
			/* 서버에 저장된 파일 삭제 */
			$boardMgr->setF_NO( $intF_NO );
			$aryFileList = $boardMgr->getCommFileView( $db );
			if ( $aryFileList[F_FILE_PATH] ) :
				$filePath	= sprintf("%s%s%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $aryFileList['F_FILE_PATH']);
				$fh->fileDelete($filePath , "" );
			endif;
			/* 서버에 저장된 파일 삭제 */

			/* 데이터페이스 삭제 */
			$boardMgr->getCommFileDelete($db);
			/* 데이터페이스 삭제 */

			$result[0][RET]			= "N";
			$result[0][MSG]			= "파일이 삭제 되었습니다..";		
		break;
		default:
			$result[0][RET]			= "FAIL_MSG";
			$result[0][MSG]			= "등록된 jsonMode 값이 없습니다.";		
		break;
	endswitch;
	
	$result_array						= json_encode($result);
	$db->disConnect();
	echo $result_array;		
?>