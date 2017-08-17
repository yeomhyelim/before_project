<?
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once "_functionBoard.lib.inc.php";

	$boardMgr			= new BoardMgr();
	$memberMgr		= new MemberMgr();
	$productMgr			= new ProductMgr();

	$intB_NO					= $_POST["bNo"]					? $_POST["bNo"]						: $_REQUEST["bNo"];
	$intBG_NO					= $_POST["bg_no"]					? $_POST["bg_no"]						: $_REQUEST["bg_no"];
	$intPage					= $_POST["page"]					? $_POST["page"]						: $_REQUEST["page"];
	$strB_CODE				= $_POST["bCode"]				? $_POST["bCode"]						: $_REQUEST["bCode"];
	$strP_CODE				= $_POST["pCode"]				? $_POST["pCode"]						: $_REQUEST["pCode"];
	$strReturnMenu			= $_POST["returnMenu"]		? $_POST["returnMenu"]				: $_REQUEST["returnMenu"];
	$strReturnMode		= $_POST["returnMode"]		? $_POST["returnMode"]				: $_REQUEST["returnMode"];
	$strReturnParam		= $_POST["returnParam"]		? $_POST["returnParam"]			: $_REQUEST["returnParam"];
	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchCat1			= $_POST["searchCat1"]			? $_POST["searchCat1"]				: $_REQUEST["searchCat1"];
	$strB_TMP5				= $_POST["b_tmp5"]				? $_POST["b_tmp5"]					: $_REQUEST["b_tmp5"];
	$aryMemberGroup		= $memberMgr->getGroupList($db);

	if ( !$strB_CODE ) :
		goErrMsg("게시판 ID가 없습니다.");
		exit;
	endif;

	$boardMgr->setB_CODE($strB_CODE);
	$aryBoardSet			= $boardMgr->getBoardData($db);

	/*-- topHtml & bottomHtml --*/
	$strTopHtml			= strConvertCut($aryBoardSet[0][B_TOP_HTML],0,'Y');
	$strBottomHtml		= strConvertCut($aryBoardSet[0][B_BOTTOM_HTML],0,'Y');
	/*-- topHtml & bottomHtml --*/

	/* you can see menu in the boardList */
	if ( $intBG_NO ) :
		$boardMgr->setBG_NO($intBG_NO);
		$arrBG_Left					= $boardMgr->getBoardGroupSelect( $db, "JUST" );
		$aryBoardList				= $boardMgr->getBoardList( $db );	
	elseif ( $aryBoardSet[0][B_GRP_NO] ) :
			$boardMgr->setBG_NO( $aryBoardSet[0][B_GRP_NO] );
			$arrBG_Left					= $boardMgr->getBoardGroupSelect( $db, "JUST" );
			$aryBoardList				= $boardMgr->getBoardList( $db );	
	endif;
	/* you can see menu in the boardList */


	$strReplyAuth		= 	getUserAuth( $aryBoardSet[0][B_REPLY], $aryBoardSet[0][B_REPLY_GROUP] );			/* 답변글 권한 */
	$strListAuth			=	getUserAuth( $aryBoardSet[0][B_LIST], $aryBoardSet[0][B_LIST_GROUP] );				/* 리스트 권한 */
	$strWriteAuth		= 	getUserAuth( $aryBoardSet[0][B_WRITE], $aryBoardSet[0][B_WRITE_GROUP] );		/* 글쓰기 권한 */		
	$strViewAuth			=	getUserAuth( $aryBoardSet[0][B_VIEW], $aryBoardSet[0][B_VIEW_GROUP] );			/* 글보기 권한 */

	/* 카테고리 리스트 */
	$boardMgr->setCG_CODE($strB_CODE);
	$commCodeRow	= $boardMgr->getCommCodeListEx($db);

	$productMgr->setP_LNG($S_SITE_LNG);

	switch ($strMode) :
		case "openWin":
				switch ($strAct) :
					case "reviewWrite":
						$productMgr->setP_CODE($strP_CODE);
						$row					= $productMgr->getProdView($db);
						$strM_ID			= $g_member_id;
						$strM_NAME		= $g_member_name;
					break;
					case "prodViewWrite":
						/* 상품 정보 */
						$productMgr->setP_CODE($strP_CODE);
						$prodRusult				= $productMgr->getProdView($db);
						/* 상품 정보 */
					break;
					case "prodViewModify":
			
						/* 상품 정보 */
						$productMgr->setP_CODE($strP_CODE);
						$prodRusult				= $productMgr->getProdView($db);
						/* 상품 정보 */

						/* 선택된 게시글 정보 불러오기 */
						$boardMgr->setB_NO($intB_NO);
						$boardMgr->setTable($aryBoardSet[0][B_NO]);
						$dataRow			= $boardMgr->getDataView($db);
						/* 선택된 게시글 정보 불러오기 */
			
						if ( $boardRow['B_W_NO'] == 0 ) :
							// 비회원이 작성한 글
							if ( !$_SESSION[SESS_GUEST_PASS] ) :
								// 등록된 비밀번호가 없는 경우, 정상적으로 접속한 사람이 아닙니다.
								goErrMsg("게시글을 수정하실 권한이 없습니다.");
								exit;
							endif;

							$boardMgr->setB_PASS($_SESSION[SESS_GUEST_PASS]);
							if ( $boardMgr->getB_PASS() == $dataRow['B_PASS'] ) :
								// 비밀번호가 일치 하는 경우
								$aryFileList = $boardMgr->getDataViewFile($db, $intB_NO);		// 첨부파일
							else :
								// 비밀번호가 틀린 경우
								goErrMsg("비밀번호가 틀립니다.");
								exit;
							endif;
						else :
							// 회원이 작성한 글
						endif;
					break;
					default;
				endswitch;
			break;
		case "list":
			if ( $strListAuth == "N" ) :		// 리스트(목록) 보기 권한이 없는 경우
				$strReplyAuth	=	$strWriteAuth	= $strViewAuth	 = "N";
				break;
			endif;
			$intPageBlock	= $aryBoardSet[0][B_PAGE_CNT];
			$intPageLine		= $aryBoardSet[0][B_LINE_CNT];

			$boardMgr->setTable( $aryBoardSet[0][B_NO] );
			$boardMgr->setSearchField( $strSearchField );
			$boardMgr->setSearchKey( $strSearchKey );
			$boardMgr->setSearchCat1( $strSearchCat1 );
			$boardMgr->setB_TMP5( $strB_TMP5 );
			$boardMgr->setPageLine( $intPageLine );

			$intTotal			= $boardMgr->getDataTotal( $db );
			$intTotPage		= ceil( $intTotal / $boardMgr->getPageLine ( ) );
			$intPage			=	( $intPage ) ? $intPage : 1;
			$intFirst				= ( $intTotal == 0 ) ? 1 : $intPageLine * ( $intPage - 1 );
			$intLast				= ( $intTotal == 0 ) ? 1 : $intPageLine * $intPage;

			$boardMgr->setLimitFirst($intFirst);
			$result				= $boardMgr->getDataList( $db );		
			$intListNum		= $intTotal - ( $intPageLine * ( $intPage - 1 ) );		
			$linkPage			= "$S_PHP_SELF?menuType=$strMenuType&bCode=$strB_CODE&searchCat1=$strSearchCat1&searchField=$strSearchField&searchKey=$strSearchKey&page=";	
		break;

		case "replyWrite":			// 답변글 쓰기
		case "view":					// 작성글 보기
			if ( $strViewAuth == "N" ) :
				$strReplyAuth	=	$strWriteAuth	= $strListAuth	 = "N";
				// 뷰 보기 권한이 없는 경우
				break;
			endif;			
			$boardMgr->setTable($aryBoardSet[0][B_NO]);

			$boardMgr->setB_NO($intB_NO);
			$dataViewRow = $boardMgr->getDataView($db);
	
			$dataViewRow[B_TITLE]	= strConvertCut($dataViewRow[B_TITLE],0,'N');
			if ($dataViewRow[B_MAIL]) $dataViewRow[B_NAME] = "<a href=\"mailto:$dataViewRow[B_MAIL]\">".$dataViewRow[B_NAME]."</a>";
//			$dataViewRow[B_TEXT]	= strConvertCut($dataViewRow[B_TEXT],"0",$dataViewRow[B_HTML]);

			/************************************** 이전글 다음글 **************************************/
			$nextRow = $boardMgr->getDataViewNext($db,$intB_NO);
			if($nextRow[B_NO]){ 
				$nextData = "<a href=\"javascript:goDataView('$nextRow[B_NO]')\">$nextRow[B_TITLE]</a>";
			}
			
			$preRow = $boardMgr->getDataViewPre($db,$intB_NO);
			if($preRow[B_NO]){
				
				$preData = "<a href=\"javascript:goDataView('$preRow[B_NO]')\">$preRow[B_TITLE]</a>";
			}
			/************************************** 이전글 다음글 **************************************/

			/************************************** 첨부파일 **************************************/
			$strFileHTML = $strFileViewHTML = "";
			$aryFileList = $boardMgr->getDataViewFile($db,$intB_NO);


			foreach ( $aryFileList as $file ) :
				if ( $file[F_SAVE_NAME] ) :
					$strFileHTML	.= "<a href='./?menuType=etc&mode=download&no=".$file[F_NO]."'>".$file[F_ORG_NAME]."</a><br>";
					if(substr($aryBoardSet[0]['B_SKIN'], 0, 2) == "BG") :
						$strImgHTML		= sprintf("%s<img src=\"%s\"><br>\r\n", $strImgHTML, $file['F_FILE_PATH']);
					endif;
				endif;				
			endforeach;

			if($strImgHTML) :
				$strImgHTML = sprintf("<center>%s</center>", $strImgHTML);
			endif;
			/************************************** 첨부파일 **************************************/	
			$boardMgr->setB_COUNT($dataViewRow[B_COUNT]);
			$boardMgr->setB_STEP($dataViewRow[B_STEP]);
			$boardMgr->setB_LEVEL($dataViewRow[B_LEVEL]);


		
		break;

		case "modify":
			$boardMgr->setTable($aryBoardSet[0][B_NO]);
			$boardMgr->setB_NO($intB_NO);

			$row = $boardMgr->getDataView($db);
			$row[B_TEXT]	= stripslashes($row[B_TEXT]);

			
			$aryFileList = $boardMgr->getDataViewFile($db,$intB_NO);
			
		break;

		case "write":

			if ($strWriteAuth == "N"){
				goErrMsg("게시글을 작성하실 권한이 없습니다.");
				exit;
			}

		break;
	endswitch;
?>
<script type="text/javascript">
<!--
	var intMemberNo		= "<?=$g_member_no?>";
	var strWirteAuth	= "<?=$strWriteAuth?>";
	var strListAuth		= "<?=$strListAuth?>";
	var strReplyeAuth	= "<?=$strReplyAuth?>";
	var strLockYN		= "<?=$aryBoardSet[0][B_LOCK]?>";

	$(document).ready(function(){
	
	});

	/* 게시판 글쓰기,수정.삭제 */
	function goMoveUrl(mode)
	{
		if (mode == "delete") {
			var x = confirm("게시글을 삭제하시겠습니까?");
			if (x == true) {
				C_getAction("delete","<?=$PHP_SELF?>")
			}
		} else {
			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
		}
	}

	function goMoveUrlCate(mode, no)
	{
			document.form.b_tmp5.value = no;
			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");		
	}

	function goView(no) {
		var doc = document.form;
		doc.bNo.value = no;

		C_getMoveUrl("view","get","<?=$PHP_SELF?>");		
	}

	function goAct(mode)
	{
		if (mode == "lockLogin") {
			if(!C_chkInput("pass",true,"비밀번호",true)) return;
			if (document.form.returnMode.value == "delete") {
				C_getAction("delete","<?=$PHP_SELF?>");
			} else {
				C_getAction(mode,"<?=$PHP_SELF?>")
			}
		} else {
			<? if ( ($strMode == "write" || $strMode == "modify") && $aryBoardSet[0][B_CAT_TYPE] != "N" ) : ?>
			if ( document.form.tmp5.selectedIndex == 0) {
				alert( "카테고리를 선택해주세요.");
				return;
			}
			<? endif; ?>
			<? if ( $strMode == "replyWrite" && $aryBoardSet[0][B_CAT_TYPE] != "N") : ?>
			document.form.tmp5.disabled = false;
			<? endif; ?>

			if(!C_chkInput("name",true,"작성자",true)) return;
			if(!C_chkInput("title",true,"제목",true)) return;
			if(!C_chkInput("contents",true,"내용",true)) return;
			
			if (C_isNull(intMemberNo) || (C_isNull(intMemberNo) && strLockYN == "Y"))
			{
				if(!C_chkInput("pass",true,"비밀번호",true)) return;
			}
						
			document.form.encoding = "multipart/form-data";
			C_getAction(mode,"<?=$PHP_SELF?>")
		}
				
	}



	function goMemberLogin(no){
		
		var doc = document.form;

		doc.menuType.value = "member";

		C_getMoveUrl("login","get","<?=$PHP_SELF?>");
	}

	function goLockLogin(no,mode) {
		var doc								= document.form;
		doc.bNo.value					= no;
		doc.returnMode.value			= mode;
		C_getMoveUrl("lockLogin","get","<?=$PHP_SELF?>");		
	}

	<?// 첨부파일 삭제 ?>
	function goDeletefile(no, fileNo) {
		var x = confirm("첨부 파일을 삭제하시겠습니까?");
		if ( x == true ) {

		}
	}

	function goDataView(no) {
		var doc = document.form;
		doc.bNo.value = no;

		C_getMoveUrl("view","get","<?=$PHP_SELF?>");		
	}


	/* 게시판 검색 */
	function goSearch(mode){
		var doc = document.form;
		doc.page.value = "";

		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

//-->
</script>