<?php
	/**
	 * eumshop app - communityCommentList - dataBasicSkin
	 *
	 * 커뮤니티 댓글 앱입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/home/shop_eng/www/web/app/communityCommentList/communityCommentList.dataBasicSkin.php
	 * @manual		&mode=communityCommentList&skin=dataBasicSkin&b_code=TEST001&ub_no=17
	 * @history
	 *				2014.07.29 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1; 
		$strAppID = "COMMUNITY_COMMENT_LIST_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[] = "/common/js/app/communityCommentList/communityCommentList.dataBasicSkin.js";

	## 모듈 설정
	$objBoardComment		= new BoardCommentModule($db);

	## 기본 설정
	$strAppBCode			= $EUMSHOP_APP_INFO['bCode'];
	$intAppUbNo				= $EUMSHOP_APP_INFO['ubNo'];
	$aryAppBoardInfo		= $EUMSHOP_APP_INFO['boardInfo'];
	$intAppMemberNo			= $_SESSION['member_no']; // 회원번호
	$strAppMemberGroup		= $_SESSION['member_group']; // 회원 그룹 번호
	$intAppPageLine			= $EUMSHOP_APP_INFO['pageLine'];

	## 체크
	if(!$strAppBCode):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "b_code가 없습니다.";
		getDebug($param);
		return;		
	endif;
	if(!$intAppUbNo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "ub_no가 없습니다.";
		getDebug($param);
		return;		
	endif;
	if(!$aryAppBoardInfo):
		$param = "";
		$param['file'] = __FILE__;
		$param['msg'] = "boardInfo가 없습니다.";
		getDebug($param);
		return;		
	endif;

	## 커뮤니티 설정
	$strBI_COMMENT_USE = $aryAppBoardInfo['BI_COMMENT_USE']; 
	$aryBI_COMMENT_MEMBER_AUTH = $aryBoardInfo['BI_COMMENT_MEMBER_AUTH'];
	
	## 페이지 개수 설정
	if(!$intAppPageLine) { $intAppPageLine = 10; }

	## 체크
	if($strBI_COMMENT_USE == "N") { return; } // 사용안함

	## 회원 전용 댓글
	$strWriteAuth = "";
	if($strBI_COMMENT_USE == "M"): 
		if(!$intAppMemberNo) { $strWriteAuth = "로그인이 필요합니다."; }
		if(!in_array($strAppMemberGroup, $aryBI_COMMENT_MEMBER_AUTH)) { $strWriteAuth = "댓글 권한이 없습니다."; }
	endif;

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
	
	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['B_CODE'] = $strAppBCode;
	$aryAppParam['UB_NO'] = $intAppUbNo;
	$aryAppParam['PAGE'] = $intAppPage;
	$aryAppParam['PAGE_LINE'] = $intAppPageLine;
	$aryAppParam['LANGUAGE'] = $aryLanguage;
	$aryAppParam['WRITE_AUTH'] = $strWriteAuth;
	$aryAppParam['MEMBER_NO'] = $intAppMemberNo;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;
?>

<!-- eumshop app - communityCommentList - defaultSkin (<?php echo $strAppID?>) -->
<style>
	div.comtTabWrap{margin-top:10px;padding:10px;border:1px solid #d9d9d9;}
	div.comtTabWrap .array{float:right;}
	div.comtTabWrap a.btnComtClose,
	div.comtTabWrap a.btnRefresh,
	div.comtTabWrap a.btnComtWrite{padding:3px 8px 2px;letter-spacing:-1px;color:#777;border:1px solid #d9d9d9;}

	div.comtWriteWrap{margin-top:30px;}
	div.comtWriteWrap textarea.comtWriteForm{float:left;width:85%;height:80px;overflow:hidden;border:1px solid #CCC;}
	div.comtWriteWrap a.comtWriteOk{float:left;padding-top:35px;width:13%;height:50px;text-align:center;font-weight:bold;color:#FFF;background:#BBB;border:1px solid #CCC;}

	div.comtModifyWrap{margin-top:30px;}
	div.comtModifyWrap textarea.comtModifyForm{float:left;width:85%;height:80px;overflow:hidden;border:1px solid #CCC;}
	div.comtModifyWrap a.comtModifyOk{float:left;padding-top:35px;width:13%;height:50px;text-align:center;font-weight:bold;color:#FFF;background:#BBB;border:1px solid #CCC;}

	div.comtListForm{margin-top:30px;padding-bottom:30px;border-bottom:1px solid #dfdfdf;}
	div.comtViewWrap{padding:20px 10px;}
	div.comtViewWrap .imgBox{float:left;width:40px;}
	div.comtViewWrap .imgBox img.userImg{vertical-align:top;width:40px;height:40px;border:1px solid #dfdfdf;}
	div.comtViewWrap .comtBox{float:left;margin-left:10px;}
	div.comtViewWrap .comtBox .info span{display:inline-block;*display:inline;*zoom:1;}
	div.comtViewWrap .comtBox .info span.userId{font-weight:bold;}
	div.comtViewWrap .comtBox .info span.date{margin-left:5px;vertical-align:middle;font-size:11px;color:#858585;}
	div.comtViewWrap .comtBox .comt{margin-top:10px;}
	div.comtViewWrap .comtBox .btnWrap{margin-top:15px;}
	div.comtViewWrap .comtBox .btnWrap a.btnComtWrite,
	div.comtViewWrap .comtBox .btnWrap a.btnLike,
	div.comtViewWrap .comtBox .btnWrap a.btnBad,
	div.comtViewWrap .comtBox .btnWrap a.btnModify,
	div.comtViewWrap .comtBox .btnWrap a.btnDelete{padding:3px 8px 2px;font-size:11px;letter-spacing:-1px;color:#777;border:1px solid #d9d9d9;}
	div.comtViewWrap .comtBox .btnWrap a.btnLike span{color:#ff0000;}
	div.comtViewWrap .comtBox .btnWrap a.btnBed span{color:#0054ff;}
	div.comtViewWrap .comtBox .btnWrap .btnLeftWrap{float:left;}
	div.comtViewWrap .comtBox .btnWrap .btnRightWrap{float:right;}

	div.comtWriteBox{margin:0 0 20px 60px;}
	div.comtModifyBox{margin:0 0 20px 60px;}

	div.comtListWrap{margin:0 15px 0 60px;padding:20px;background:#f9f9f9;border-bottom:1px solid #d9d9d9;}
	div.comtListWrap .imgBox{padding-left:15px;background:url(/himg/community/comment/ico_reply.png) left top no-repeat;}

	div.popLoginForm{padding:20px 10px;width:280px;border:1px solid #d9d9d9;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;}
	div.popLoginForm h3.title{font-size:18px;text-align:center;}
	div.popLoginForm .loginForm{margin-top:15px;padding:20px 10px 10px;border-top:1px solid #e1e1e1;}
	div.popLoginForm .loginForm .inputBox{float:left;}
	div.popLoginForm .loginForm .inputBox ul li.memPw{margin-top:7px;}
	div.popLoginForm .loginForm .inputBox ul li input{padding:2px;width:160px;}
	div.popLoginForm .loginForm .btnWrap{float:left;}
	div.popLoginForm .loginForm .btnWrap a.btnLogin{display:inline-block;*display:inline;*zoom:1;margin-left:10px;padding-top:20px;width:75px;height:30px;text-align:center;font-weight:bold;color:#FFF;background:#BBB;border:1px solid #CCC;}
	div.popLoginForm .loginForm .memBtnWrap{margin-top:15px;text-align:center;}

	div.popComtChkForm{padding:20px 10px;width:130px;border:1px solid #d9d9d9;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;}
	div.popComtChkForm .chkTxtBox{text-align:center;letter-spacing:-0.8px;line-height:18px;}
	div.popComtChkForm .btnWrap{margin-top:10px;text-align:center;}
	div.popComtChkForm .btnWrap a.btnLike,
	div.popComtChkForm .btnWrap a.btnBad,
	div.popComtChkForm .btnWrap a.btnCancel{display:inline-block;*display:inline;*zoom:1;padding:3px 8px 2px;letter-spacing:-1px;color:#777;border:1px solid #d9d9d9;}
	div.popComtChkForm .btnWrap a.btnCancel{margin-left:6px;}
	
</style>
<div id="<?php echo $strAppID?>">
	<!-- 기능 //-->
	<div class="comtTabWrap">
		<a href="javascript:void(0)" class="btnComtClose" toggletext="댓글창 열기">댓글창 닫기</a>
		<a href="javascript:void(0)" class="btnRefresh">새로고침</a>
		<a href="javascript:void(0)" class="btnComtWrite">댓글쓰기</a>
		<div class="right">
			정렬
			<select onchange="goCommentListdataBasicSkinPageLineChangeMoveEvent('<?php echo $strAppID;?>', this)">
				<option value="10" selected="selected">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
			</select>
		</div>
		<div class="clr"></div>
	</div>
	<!-- 기능 //-->
	<!-- 댓글 쓰기 //-->
	<div class="comtWriteWrap">
		<div>
			<textarea name="commentText" class="comtWriteForm"<?php if($strWriteAuth){echo " readonly";}?>><?php echo $strWriteAuth;?></textarea>
			<a href="javascript:void(0);" onclick="goCommunityCommentListDataBasicSkinWriteActEvent('<?php echo $strAppID;?>');" class="comtWriteOk">등록</a>
			<div class="clr"></div>
		</div>
	</div>
	<!-- 댓글 쓰기 //-->
	<!-- 로딩 폼 //-->
	<div class="loading center" style="margin-top:50px;display:none">
		<img src="/himg/community/comment/loader.gif">
	</div>
	<!-- 로딩 폼 //-->
	<!-- 댓글 폼 //-->
	<div class="comtListForm<?php echo $strDisplayClass;?>">
	<?php if(!$intAppTotal):?>
	<div class="comtNoDataWrap">
		<p>첫 댓글을 남겨보세요.</p>
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
			$strName = "방문객";
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
			$strCM_TEXT = strConvertCut2($strCM_TEXT);

	?>
	<div idx="<?php echo $intCM_NO;?>">
		<?php if($strCM_DEL == "Y"):?>
		<!-- 댓글 삭제 -->
		<div class="comtViewWrap<?php echo $strReplyClass;?>">
			<p>삭제된 글입니다.</p>
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
						<a href="javascript:goCommunityCommentListDataBasicSkinReplyWriteMoveEvent('<?php echo $strAppID;?>', '<?php echo $intCM_NO;?>')" class="btnComtWrite">댓글</a>
						<?php endif;?>
						<?php if($isModifyBtnShow):?>
						<a href="javascript:goCommunityCommentListDataBasicSkinModifyMoveEvent('<?php echo $strAppID;?>', '<?php echo $intCM_NO;?>')" class="btnModify">수정</a>
						<?php endif;?>
						<?php if($isDeleteBtnShow):?>
						<a href="javascript:goCommunityCommentListDataBasicSkinDeleteActEvent('<?php echo $strAppID;?>', '<?php echo $intCM_NO;?>')" class="btnDelete">삭제</a>
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
	<!-- 페이징 //-->
	<div class="paginate_left list-paginate">
		<a href="javascript:void(0);" onclick="goCommunityCommentListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $intAppPrevBlock;?>)" class="btn_board_prev direction"><span><?php echo $LNG_TRANS_CHAR['MW00052'];?></span></a>
		<?php for($i=$intAppFirstBlock;$i<=$intAppLastBlock;$i++):?>
		<?php if($i == $intAppPage):?>
		<strong><span class="chkPage"><?php echo $i;?></span></strong>
		<?php else:?>
		<a href="javascript:void(0);" onclick="goCommunityCommentListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $i;?>)" ><span class="pageCnt"><?php echo $i;?></span></a>
		<?php endif;?>
		<?php endfor;?>
		<a href="javascript:void(0);" onclick="goCommunityCommentListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $intAppNextBlock;?>)" class="btn_board_next direction"><span><?php echo $LNG_TRANS_CHAR['MW00043'];?></span></a>
	</div>
	<!-- 페이징 //-->
	<?php endif;?>
	</div><!--// comtListForm -->
	<!-- 댓글 폼 //-->
	<!-- 기능 //-->
	<div class="comtTabWrap">
		<a href="javascript:void(0)" class="btnComtClose" toggletext="댓글창 열기">댓글창 닫기</a>
		<a href="javascript:void(0)" class="btnRefresh">새로고침</a>
		<a href="javascript:void(0)" class="btnComtWrite">댓글쓰기</a>
		<div class="right">
			정렬
			<select onchange="goCommentListdataBasicSkinPageLineChangeMoveEvent('<?php echo $strAppID;?>', this)">
				<option value="10" selected="selected">10</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
			</select>
		</div>
		<div class="clr"></div>
	</div>
	<!-- 기능 //-->	
</div>
<!-- eumshop app - communityCommentList - defaultSkin (<?php echo $strAppID?>) -->