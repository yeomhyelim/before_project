<?php
	/**
	 * eumshop app - communityCommentList - defaultSkin
	 *
	 * 커뮤니티 댓글 앱입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityCommentList/communityCommentList.defaultSkin.php
	 * @manual		&mode=communityCommentList&skin=defaultSkin&b_code=TEST001&ub_no=17
	 * @history
	 *				2014.06.13 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "COMMUNITY_COMMENT_LIST_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScript[] = "/common/js/app/communityCommentList/communityCommentList.defaultSkin.js";
	$aryScriptEx[] = "/common/js/app/communityCommentList/communityCommentList.defaultSkin.js";

	## 기본 설정
	$strAppBCode			= $EUMSHOP_APP_INFO['bCode'];
	$intAppUbNo				= $EUMSHOP_APP_INFO['ubNo'];
	$strAppPageLineOption	= $EUMSHOP_APP_INFO['pageLineOption'];
	$intAppPageLine			= $EUMSHOP_APP_INFO['pageLine'];
	$intAppMemberNo			= $_SESSION['member_no'];
	$strAppMemberGroup		= $_SESSION['member_group'];
	$intAppCommunityCommentListPageLine =  $_COOKIE['COMMUNITY_COMMENT_LIST_PAGE_LINE'];
	$strAppCommunityCommentListDisplay =  $_COOKIE['COMMUNITY_COMMENT_LIST_DISPLAY'];
	$strAppOrderBy			= "newAsc";
	$strAppImageDir			= "/upload/member/";
	if(!$strAppBCode) { return; }
	if(!$intAppUbNo) { return; }
	if(!$strAppPageLineOption) { $strAppPageLineOption = "10,20,30,40,50"; }
	$aryAppPageLineOption = explode(",", $strAppPageLineOption);

	## 체크
	if(!$strAppBCode) { return; }
	if(!$intAppUbNo) { return; }

	## 설정 파일 설정
	include_once MALL_SHOP . "/conf/community/{$strLangLower}/board.{$strAppBCode}.info.php";
	$aryBoardInfo = $BOARD_INFO[$strAppBCode];
	$strBI_COMMENT_USE = $aryBoardInfo['BI_COMMENT_USE'];
	$aryBI_COMMENT_MEMBER_AUTH = $aryBoardInfo['BI_COMMENT_MEMBER_AUTH'];

	## 댓글 쓰기 권한 설정
	$isWriteAuth = false; // 글쓰기 권한
	$isWriteBtnShow = false; // 댓글 버튼 권한
	if($strBI_COMMENT_USE == 'A' || in_array($strAppMemberGroup, $aryBI_COMMENT_MEMBER_AUTH)): // BI_COMMENT_USE(A:모든회원), 권한이 있는 회원그룹
		$isWriteAuth = true;
		$isWriteBtnShow = true;	
	endif;

	## 페이지 출력 개수 설정
	if($intAppCommunityCommentListPageLine) { $intAppPageLine = $intAppCommunityCommentListPageLine; }

	## 댓글창 닫기 체크
	$strDisplayClass = "";
	if($strAppCommunityCommentListDisplay == "none") { $strDisplayClass = " hide"; }

	## 모듈 설정
	$objBoardComment					= new BoardCommentModule($db);

	## 데이터 불러오기
	$param								= "";
	$param['B_CODE']					= $strAppBCode;
	$param['CM_UB_NO']					= $intAppUbNo;
	$intAppTotal						= $objBoardComment->getBoardCommentSelectEx("OP_COUNT", $param);					// 데이터 전체 개수 
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10;								// 리스트 개수 
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$param['JOIN_M']					= "Y";
	$param['JOIN_MA']					= "Y";
	$param['ORDER_BY']					= $strAppOrderBy;
	$param['LIMIT']						= "{$intAppFirst},{$intAppPageLine}";
	$resAppResult						= $objBoardComment->getBoardCommentSelectEx("OP_LIST", $param);
	$intAppPageBlock					= 10;																				// 블럭 개수 
	$intAppListNum						= $intAppTotal - ( $intAppPageLine * ( $intAppPage - 1 ) );							// 번호
	$intAppTotPage						= ceil( $intAppTotal / $intAppPageLine );

	## paging 설정
	$intAppPage				= $intAppPage;									// 현재 페이지
	$intAppTotPage			= $intAppTotPage;								// 전체 페이지 수
	$intAppTotBlock			= ceil($intAppTotPage / $intAppPageBlock);		// 전체 블럭 수
	$intAppBlock			= ceil($intAppPage / $intAppPageBlock);			// 현재 블럭
	$intAppPrevBlock		= (($intAppBlock - 2) * $intAppPageBlock) + 1;	// 이전 블럭
	$intAppNextBlock		= ($intAppBlock * $intAppPageBlock) + 1;		// 다음 블럭
	$intAppFirstBlock		= (($intAppBlock - 1) * $intAppPageBlock) + 1;	// 현재 블럭 시작 시저
	$intAppLastBlock		= $intAppBlock * $intAppPageBlock;				// 현재 블럭 종료 시점
	if($intAppFirstBlock <= 0) { $intAppFirstBlock	= 1; }
	if($intAppPrevBlock  <= 0) { $intAppPrevBlock		= 1; }
	if($intAppNextBlock >= $intAppTotPage) { $intAppNextBlock	= $intAppTotPage; }
	if($intAppLastBlock >= $intAppTotPage) { $intAppLastBlock	= $intAppTotPage; }

	## 페이지 시작/마지막 번호 설정
	$intAppFirstNo			= ($intAppPage <= 1) ? $intAppPage : (($intAppPage - 1) * $intAppPageLine);
	$intAppLastNo			= $intAppPage * $intAppPageLine;
	if(!$intAppFirstNo) { $intAppFirstNo = ""; }
	if($intAppLastNo > $intAppTotal) { $intAppLastNo = $intAppTotal; }

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['OS00013']	= $LNG_TRANS_CHAR['OS00013'];
	$aryLanguage['PW00010']	= $LNG_TRANS_CHAR['PW00010'];
	$aryLanguage['PW00009']	= $LNG_TRANS_CHAR['PW00009'];
	$aryLanguage['OS00029']	= $LNG_TRANS_CHAR['OS00029'];

	$aryLanguage['CW00034']	= $LNG_TRANS_CHAR['CW00034'];
	$aryLanguage['CW00001']	= $LNG_TRANS_CHAR['CW00001'];
	
	$aryLanguage['MW00043']	= $LNG_TRANS_CHAR['MW00043']; // 다음
	$aryLanguage['MW00052']	= $LNG_TRANS_CHAR['MW00052']; // 이전
	$aryLanguage['MW00112']	= $LNG_TRANS_CHAR['MW00112']; // 등록
	$aryLanguage['MW00113']	= $LNG_TRANS_CHAR["MW00113"]; // 방문객
	$aryLanguage['MW00114']	= $LNG_TRANS_CHAR["MW00114"]; // 댓글
	$aryLanguage['OW00072']	= $LNG_TRANS_CHAR["OW00072"]; // 수정
	$aryLanguage['CW00036']	= $LNG_TRANS_CHAR["CW00036"]; // 삭제
	
	$aryLanguage['PW00033']	= $LNG_TRANS_CHAR['PW00033']; // new arrivals
	$aryLanguage['PW00030']	= $LNG_TRANS_CHAR['PW00030']; // best sellers
	$aryLanguage['PW00031']	= $LNG_TRANS_CHAR['PW00031']; // accumulated sales
	$aryLanguage['PW00034']	= $LNG_TRANS_CHAR['PW00034']; // price:low to high
	$aryLanguage['PW00035']	= $LNG_TRANS_CHAR['PW00035']; // price:high to low
	$aryLanguage['MS00112']	= $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.
	$aryLanguage['MS00130']	= $LNG_TRANS_CHAR["MS00130"]; // 사용 권한이 없습니다.
	$aryLanguage['MS00131']	= $LNG_TRANS_CHAR["MS00131"]; // 삭제된 글입니다.
	$aryLanguage['MS00132']	= $LNG_TRANS_CHAR["MS00132"]; // 댓글을 입력하세요.
	$aryLanguage['MS00133']	= $LNG_TRANS_CHAR["MS00133"]; // 게시판 정보가 없습니다. 관리자에게 문의하세요.
	$aryLanguage['MS00134']	= $LNG_TRANS_CHAR["MS00134"]; // 권한이 없습니다.
	$aryLanguage['MS00135']	= $LNG_TRANS_CHAR["MS00135"]; // 로그인 페이지로 이동하시겠습니까?
	$aryLanguage['PS00018']	= $LNG_TRANS_CHAR["PS00018"]; // 삭제하시겠습니까?




	## 회원 체크
	## 로그인한 회원만 글을 작성할 수 있습니다.
	## 비회원은 추후 개발 예정입니다.

?>
<!-- eumshop app - communityCommentList - defaultSkin (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']								= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['LANGUAGE']					= <?php echo json_encode($aryLanguage);?>; 
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']						= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']						= "<?php echo $strAppSkin;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['B_CODE']					= "<?php echo $strAppBCode;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['UB_NO']						= "<?php echo $intAppUbNo;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['MEMBER_NO']					= "<?php echo $intAppMemberNo;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PAGE_LINE_OPTION']			= <?php echo json_encode($aryAppPageLineOption);?>;

	G_APP_PARAM['<?php echo $strAppID;?>']['TOTAL']				= "<?php echo $intAppTotal;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['NO_FIRST']			= "<?php echo $intAppFirstNo;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['NO_LAST']			= "<?php echo $intAppLastNo;?>"; 

	G_APP_PARAM['<?php echo $strAppID;?>']['PAGE']					= "<?php echo $intAppPage;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PREV_BLOCK']		= "<?php echo $intAppPrevBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['NEXT_BLOCK']		= "<?php echo $intAppNextBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['FIRST_BLOCK']	= "<?php echo $intAppFirstBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['LAST_BLOCK']		= "<?php echo $intAppLastBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['ORDER_BY']			= "<?php echo $strAppOrderBy;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PAGE_LINE']		= "<?php echo $intAppPageLine;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['WRITE_AUTH']		= "<?php echo $isWriteAuth;?>"; 

</script>
<?php if($strMenuType == "app"):?>
전체 개수 : <span class="list-total" appID="<?php echo $strAppID;?>"></span>
시작 번호 : <span class="list-no-first" appID="<?php echo $strAppID;?>"></span>
종료 번호 : <span class="list-no-last" appID="<?php echo $strAppID;?>"></span>
페이지 : <span class="list-paginate" appID="<?php echo $strAppID;?>"></span>
정렬 : <span class="list-sort" appID="<?php echo $strAppID;?>"></span>
출력개수 : <span class="list-pageline" appID="<?php echo $strAppID;?>"></span>
<a class="list-close" appID="<?php echo $strAppID;?>" toggleText="댓글창 열기">댓글창 닫기</a>
<a class="list-refresh" appID="<?php echo $strAppID;?>">새로고침</a>
<a class="comment-write-link" appID="<?php echo $strAppID;?>">댓글쓰기</a>
<div class="comment-write-form" appID="<?php echo $strAppID;?>"></div>
<?php endif;?>
<div id="<?php echo $strAppID?>">

	<!-- 로딩 폼 -->
	<div class="loading center" style="margin-top:50px;display:none">
		<img src="/himg/community/comment/loader.gif">
	</div>
	<!-- 로딩 폼 -->

	<!-- 댓글 폼 -->
	<div class="comtListForm<?php echo $strDisplayClass;?>">
	<?php if(!$intAppTotal):?>
	<div class="comtNoDataWrap">
		<p><?php echo $LNG_TRANS_CHAR["MS00129"]; //첫 댓글을 남겨보세요.?></p>
	</div>
	<?php else:?>
	<?php while($row = mysql_fetch_array($resAppResult)):
	
			## 기본설정
			$intCM_NO = $row['CM_NO'];
			$intCM_M_NO = $row['CM_M_NO'];
			$strCM_NAME = $row['CM_NAME'];
			$strCM_M_ID = $row['CM_M_ID'];
			$strCM_TEXT = $row['CM_TEXT'];
			$intCM_ANS_DEPTH = $row['CM_ANS_DEPTH'];
			$strCM_REG_DT = $row['CM_REG_DT'];
			$strCM_DEL = $row['CM_DEL'];
			$strM_PHOTO = $row['M_PHOTO'];
			
//			print_r($row);

			
			## 작성자 설정
			$strName = $LNG_TRANS_CHAR["MW00113"]; // 방문객
			if($strName) { $strName = $strCM_NAME; }

			## 작성일 설정
			$strCM_REG_DT = date("Y-m-d H:i", strtotime($strCM_REG_DT));

			## 리플 설정
			$strReplyClass = "";
			if($intCM_ANS_DEPTH > 1) { $strReplyClass = " comtListWrap"; }

			## 사진 설정
			$strPhotoFile = "/himg/community/comment/img_user.jpg";
			if($strM_PHOTO) { $strPhotoFile = $strAppImageDir . $strM_PHOTO; }

			## 자신글만 수정,삭제 버튼이 보입니다.
			$isModifyBtnShow = false; // 수정 버튼
			$isDeleteBtnShow = false; // 삭제 버튼
			if($intAppMemberNo && $intCM_M_NO && $intAppMemberNo == $intCM_M_NO):
				$isModifyBtnShow = true;
				$isDeleteBtnShow = true;
			endif;

			## 내용 설정
			$strCM_TEXT = strConvertCut($strCM_TEXT);

	?>
	<div idx="<?php echo $intCM_NO;?>">
		<?php if($strCM_DEL == "Y"):?>
		<!-- 댓글 삭제 -->
		<div class="comtViewWrap<?php echo $strReplyClass;?>">
			<p><?php echo $LNG_TRANS_CHAR["MS00131"]; // 삭제된 글입니다.?></p>
		</div><!--// comtViewWrap-->
		<!-- 댓글 삭제 -->
		<?php else:?>
		<!-- 댓글 보기 -->
		<div class="comtViewWrap<?php echo $strReplyClass;?>">
			<div class="imgBox"><img src="<?php echo $strPhotoFile;?>" alt="프로필 사진" class="userImg"/></div>
			<div class="comtBox">
				<div class="info"><span class="userId"><?php echo $strName;?></span> <span class="date"><?php echo $strCM_REG_DT;?></span></div>
				<div class="comt"><?php echo $strCM_TEXT;?></div>
				<div class="btnWrap">
					<div class="btnLeftWrap">
						<?php if($intCM_ANS_DEPTH == 1 && $isWriteBtnShow):?>
						<a href="javascript:goCommunityCommentListDefaultSkinReplyWriteMoveEvent('<?php echo $strAppID;?>', '<?php echo $intCM_NO;?>')" class="btnComtWrite"><?php echo $LNG_TRANS_CHAR["MW00114"]; //댓글?></a>
						<?php endif;?>
						<?php if($isModifyBtnShow):?>
						<a href="javascript:goCommunityCommentListDefaultSkinModifyMoveEvent('<?php echo $strAppID;?>', '<?php echo $intCM_NO;?>')" class="btnModify"><?php echo $LNG_TRANS_CHAR["OW00072"]; //수정?></a>
						<?php endif;?>
						<?php if($isDeleteBtnShow):?>
						<a href="javascript:goCommunityCommentListDefaultSkinDeleteActEvent('<?php echo $strAppID;?>', '<?php echo $intCM_NO;?>')" class="btnDelete"><?php echo $LNG_TRANS_CHAR["CW00036"]; //삭제?></a>
						<?php endif;?>
					</div>
					<?php if($intCM_ANS_DEPTH == 1):?>
					<!-- div class="btnRightWrap">
						<a href="#" class="btnLike">추천 <span>0</span></a>
						<a href="#" class="btnBad">반대 <span>0</span></a>
					</div //-->
					<?php endif;?>
					<div class="clr"></div>
				</div>			
				<div class="clr"></div>
			</div>
			<div class="clr"></div>
		</div><!--// comtViewWrap-->
		<!-- 댓글 보기 -->
		<?php endif;?>
	</div>
	<?php endwhile;?>
	<?php endif;?>
	</div><!--// comtListForm -->
	<!-- 댓글 폼 -->

	
</div>
<!-- eumshop app - communityCommentList - defaultSkin (<?php echo $strAppID?>) -->