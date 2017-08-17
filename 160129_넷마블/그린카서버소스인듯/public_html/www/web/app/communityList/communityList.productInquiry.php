<?php
	/**
	 * eumshop app - communityList - mobileSkin
	 *
	 * 커뮤니티 리스트를 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/communityList/communityList.mobileSkin.php
	 * @manual		menuType=app&mode=communityList&skin=mobileSkin&b_code=PROD_REVIEW
	 * @history
	 *				2014.06.08 kim hee sung - 개발 완료
	 */

	## app ID
	if(!$strAppID):
		$intAppID = $intAppID + 1; 
		$strAppID = "COMMUNITY_LIST_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[] = "/common/js/app/communityList/communityList.mobileSkin.js";

	## 기본 설정
	$strAppBCode = $EUMSHOP_APP_INFO['bCode'];
	$aryAppBoardInfo = $EUMSHOP_APP_INFO['boardInfo'];
	$intAppPageLine = $EUMSHOP_APP_INFO['pageLine'];

	## 리스트 기본 
	$EUMSHOP_APP_INFO = "";
	$EUMSHOP_APP_INFO['name'] = "커뮤니티_리스트";
	$EUMSHOP_APP_INFO['mode'] = "communityList";
	$EUMSHOP_APP_INFO['appID'] = $strAppID;
	$EUMSHOP_APP_INFO['skin'] = "dataBasicSkin";
	$EUMSHOP_APP_INFO['view'] = "N";
	$EUMSHOP_APP_INFO['bCode'] = $strAppBCode;
	$EUMSHOP_APP_INFO['boardInfo'] = $aryAppBoardInfo;
	$EUMSHOP_APP_INFO['pageLine'] = $intAppPageLine;
	include MALL_HOME . "/web/app/index.php";

	## 기본설정
	$strAppB_NAME				=  $aryBoardInfo['B_NAME'];
	list($strKind, $strSkin)	= explode("_", $strB_KIND_SKIN);

	## 스크립트 설정
	$aryAppParam['SKIN'] = "mobileSkin";
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

?>
<!-- eumshop app - communityList - mobileSkin (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<div class="<?php echo $strSkin;?>BbsList">
	<?php if($intAppTotal): ?>
		<ul>
			<?php while($row = mysql_fetch_array($resAppResult)):

						## 기본 설정
						$intUB_NO = $row['UB_NO'];
						$intUB_BC_NO = $row['UB_BC_NO'];
						$strUB_NAME = $row['UB_NAME'];
						$intUB_M_NO = $row['UB_M_NO'];
						$strUB_M_ID = $row['UB_M_ID'];
						$strMM_NICK_NAME = $row['MM_NICK_NAME'];
						$strUB_TITLE = $row['UB_TITLE'];
						$strUB_REG_DT = $row['UB_REG_DT'];
						$intUB_READ = $row['UB_READ'];
						$intUB_P_GRADE = $row['UB_P_GRADE'];
						$strUB_DEL = $row['UB_DEL'];
						$strFL_DIR = $row['FL_DIR'];
						$strFL_NAME = $row['FL_NAME'];
						$intUB_ANS_NO = $row['UB_ANS_NO'];
						$intUB_ANS_DEPTH = $row['UB_ANS_DEPTH'];
						$strUB_ANS_STEP = $row['UB_ANS_STEP'];
						$intUB_ANS_M_NO = $row['UB_ANS_M_NO'];
						$strUB_FUNC = $row['UB_FUNC'];
						$strPM_REAL_NAME = $row['PM_REAL_NAME'];
						$strUB_P_CODE = $row['UB_P_CODE'];

						## 제목 설정
						if($intBI_DATALIST_TITLE_LEN):
							$strUB_TITLE = strHanCutUtf2($strUB_TITLE, $intBI_DATALIST_TITLE_LEN);
						endif;

						## 카테고리 설정
						$strCategoryName = $aryCategoryList[$intUB_BC_NO]['bc_name'];

						## 작성자(성명) 설정
						if($intBI_DATALIST_WRITER_HIDDEN):		
							$strUB_NAME = strHanCutUtf2($strUB_NAME, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
						endif;					

						## 아이디 설정
						if($intBI_DATALIST_WRITER_HIDDEN):
							$strUB_M_ID = strHanCutUtf2($strUB_M_ID, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
						endif;	

						## 닉네임 설정
						if(!$strMM_NICK_NAME) { $strMM_NICK_NAME = $LNG_TRANS_CHAR["MW00100"]; /* 손님 */ }
						if($intBI_DATALIST_WRITER_HIDDEN):
							$strMM_NICK_NAME = strHanCutUtf2($strMM_NICK_NAME, $intBI_DATALIST_WRITER_HIDDEN, false, "***");
						endif;	

						## 작성일 설정
						$strUB_REG_DT = date("Y.m.d", strtotime($strUB_REG_DT));

						## 리스트이미지 설정
						$strListImage = "";
						if($strFL_DIR && $strFL_NAME) { $strListImage = "{$strFL_DIR}/{$strFL_NAME}"; }

						## 삭제글 설정
						if($strUB_DEL == "Y"):
							$strCategoryName = "";
							$strListImage = "";
							$intUB_NO = "";
							$strUB_TITLE = "삭제된 글입니다.";
							$strUB_NAME = "";
							$strUB_M_ID = "";
							$strMM_NICK_NAME = "";
							$intUB_P_GRADE = 0;
							$strUB_REG_DT = "";
							$intUB_READ = "";
						endif;

						## 답변 표시
						$strAnsHtml = ""; 
						$isAnswer = false; // 답변글인경우 true 변경됩니다.
						$isPGrade = true; // 평점은 답변인경우 출력하지 않습니다.
						if($intUB_ANS_DEPTH > 1):
							$strAnsHtml = str_pad("", $intUB_ANS_DEPTH, " "); 
							$strAnsHtml = str_replace(" ", "&nbsp;", $strAnsHtml);
							$strAnsHtml = "{$strAnsHtml}<img src='/himg/community/comment/ico_reply.png'> "; 

							$isPGrade = false;
							$isAnswer = true;
						endif;

						## UB_FUNC 설정
						$aryFunc = "";
						$strFuncNotice = $strUB_FUNC[0]; // 공지글
						$strFuncLock = $strUB_FUNC[1]; // 비밀글
//						$aryFunc[] = $strUB_FUNC[3]; // 대기
//						$aryFunc[] = $strUB_FUNC[4]; // 대기
//						$aryFunc[] = $strUB_FUNC[5]; // 대기
//						$aryFunc[] = $strUB_FUNC[6]; // 대기
//						$aryFunc[] = $strUB_FUNC[7]; // 대기
//						$aryFunc[] = $strUB_FUNC[8]; // 대기
//						$aryFunc[] = $strUB_FUNC[9]; // 대기

						## 공지글 설정
						$strAppListNum = $intAppListNum;
						if($strFuncNotice == "Y"):
							$strAppListNum = "공지";
						endif;

						## 무조건 비밀글 설정인경우
						if($strBI_DATAWRITE_LOCK_USE == "E") { $strFuncLock = "Y"; }

						## 비밀글 설정
						$strLockHtml = "";
						$strLockAuth = "";
						if($strFuncLock == "Y"):
							$strLockHtml = "<img src='/himg/board/icon/icon_bbs_lock.png'> "; 

							if($intUB_M_NO): 
							## 회원글

								## 비회원 || 자신의 글이 아닌 경우
								if(!$intMemberNo || $intUB_M_NO != $intMemberNo) { $strLockAuth = "memberLock"; };
			
							else:
							## 비회원글

								$strLockAuth = "lock";

							endif;

							## 답변글인경우, 질문자 회원도 체크 합니다.
							if($strLockAuth && $isAnswer):
		
								## 다시 정의 합니다.
								$strLockAuth = "";
								
								if($intUB_ANS_M_NO): 
								## 회원글

									## 비회원 || 자신의 글이 아닌 경우
									if(!$intMemberNo || $intUB_ANS_M_NO != $intMemberNo) { $strLockAuth = "memberLock"; };
									
								else:
								## 비회원글

									$strLockAuth = "lock";

								endif;
							endif;

							## 관리자 그룹(001) 은 모든 내용을 볼수 있습니다.
							if(in_array($strMemberGroup, array("001"))) { $strLockAuth = ""; }
						endif;
			?>
			<li class="data depth<?php echo $intDepth;?>" idx="<?php echo $intUBNo;?>" onclick="goCommunityListMobileSkinViewMoveEvent('<?php echo $strAppID;?>', <?php echo $intUB_NO;?>, '<?php echo $strLockAuth;?>')">
				<?php if(in_array("상품이미지", $aryAppColumn)):?>
					<div class="listImg"><img src="<?php echo $strPM_REAL_NAME?>"></div>
				<?php endif;?>
				<?php if(in_array("리스트이미지", $aryAppColumn)):?>
					<div class="listImg"><img src="<?php echo $strListImage?>"></div>
				<?php endif;?>
				<div class="dataListWrap">
					<?php if(in_array("번호", $aryAppColumn)):?>
						<span class="no"><?php echo $intAppListNum--;?></span>
					<?php endif;?>
					<?php if(in_array("카테고리", $aryAppColumn)):?>
						<span class="category"><?php echo $strCategoryName?></span>
					<?php endif;?>
					<?php if(in_array("제목", $aryAppColumn)):?>
						<span class="title">
							<?php echo $strLockHtml;?>
							<?php echo $strUB_TITLE;?>
						</span>
					<?php endif;?>
					<?php if(in_array("작성자", $aryAppColumn)):?>
						<?php if(in_array("이름", $aryAppWriterColumn)):?>
						<span class="writer"><?php echo $strWriterName?></span>
						<?php endif;?>
						<?php if(in_array("아이디", $aryAppWriterColumn)):?>
						<span class="writer"><?php echo $strWriteID?></span>
						<?php endif;?>
						<?php if(in_array("닉네임", $aryAppWriterColumn)):?>
						<span class="writer"><?php echo $strMM_NICK_NAME?></span>
						<?php endif;?>
					<?php endif;?>
					<?php if(in_array("작성일", $aryAppColumn)):?>
						<span class="date"><?php echo $strUB_REG_DT?></span>
					<?php endif;?>
					<?php if(in_array("조회수", $aryAppColumn)):?>
						<span class="read"><?php echo $intUB_READ?></span>
					<?php endif;?>
				</div>
				<div class="clr"></div>
				<?php if(in_array("내용", $aryAppColumn) && !$strLockAuth):?>
				<div class="dataContents">
				<?php echo $strUB_TEXT;?>
				</div>
				<?php endif;?>
			</li>
			<?php endwhile; ?>
		</ul>
		<div class="clr"></div>
	<?php  endif; ?>
	</div>
	<?php if($intAppTotal):?>
	<div class="app-paginate" id="pagenate">
		<div class="paginate_left">
			<a href="javascript:goCommunityListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $intAppPrevBlock;?>)" class="btn_board_prev direction"><span><?php echo $LNG_TRANS_CHAR['MW00052'];?></span></a>
			<?php for($i=$intAppFirstBlock;$i<=$intAppLastBlock;$i++):?>
			<?php if($i == $intAppPage):?>
			<strong><span class="chkPage"><?php echo $i;?></span></strong>
			<?php else:?>
			<a href="javascript:goCommunityListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $i;?>)" ><span class="pageCnt"><?php echo $i;?></span></a>
			<?php endif;?>
			<?php endfor;?>
			<a href="javascript:goCommunityListDataBasicSkinListMoveEvent('<?php echo $strAppID;?>', <?php echo $intAppNextBlock;?>)" class="btn_board_next direction"><span><?php echo $LNG_TRANS_CHAR['MW00043'];?></span></a>
		</div>
	</div>
	<?php endif;?>
	<?php if($isWriteBtn):?>
	<div class="btnRight right">
		<a href="javascript:void(0);" onclick="goCommunityListDataBasicSkinWriteMoveEvent('<?php echo $strAppID;?>');" id="menu_auth_w" class="btn_board_write"><strong><?php echo $LNG_TRANS_CHAR["CW00052"]; // 글쓰기?></strong></a>
	</div>
	<?php endif;?>
	<div class="clr"></div>
</div>
<!-- eumshop app - communityList - mobileSkin (<?php echo $strAppID?>) -->