<?
	## 설정
	$listImg		= "";
	$result			= $_REQUEST['result'][$tableName]['listResult'];
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$list_num		= $_REQUEST['result'][$tableName]['pageResult']['list_num'];
	$commentView	= new CommunityCommentView($db, $field);

?>
	<div id="commentListArea">
	<? if($list_total > 0) : // 코멘트 리스트 ?>
	<?	 while($row = mysql_fetch_array($result)) : 
			$aryFunc		= $commentView->getCM_FUNC_DECODER($row); 

// 2014.02.04 kim hee sung 권한 설정이 잘못되어서 수정함.
//			$lock			= $commentView->getLockAuthCheck($row);

			## 삭제/수정 가능 여부 설정
			$isLock			= false;
			if(!$row['CM_M_NO'])		{ $isLock	= true;	}		// 비회원글
			else { // 회원글
				if($_SESSION['member_login']):
					// 로그인을 했다면
					if($_SESSION['member_no'] == $row['CM_M_NO']) { $isLock = true; } // 회원이 작성한 글
				endif;
			}

			$intHidden		= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden'];
			if($intHidden):
				$row['CM_NAME']	= mb_substr($row['CM_NAME'], 0, $intHidden, "UTF-8");
				$row['CM_NAME']	= str_pad($row['CM_NAME'], ($intHidden+3), "*");
				$row['CM_M_ID']	= mb_substr($row['CM_M_ID'], 0, $intHidden, "UTF-8");
				$row['CM_M_ID']	= str_pad($row['CM_M_ID'], ($intHidden+3), "*");
			endif;

			/* 회원이 작성한 글인데 로그인 안된 경우 삭제/수정 버튼 숨김 */
			if($row['CM_M_NO'] > 0 && !$_REQUEST['member_no']) { $buttonLock = "lock"; }
	?>
	<div id="commentList_<?=$row['CM_NO']?>" cm_m_no="<?=$row['CM_M_NO']?>" class="commentListView">
			<div id="commentListDiv" cm_m_no="" class="commlistView">
			<ul>
				<li class="commentWriter">
					<strong id="cm_name" alt="이름"><?=$row['CM_NAME']?></strong>
					<span class="date"><?=date("Y-m-d", strtotime($row['CM_REG_DT']))?></span>
				</li>
				<li class="commentTitle">
					<span id="cm_text" alt="코멘트"><?=strConvertCut($row['CM_TEXT'],0,'N')?></span>
					<div class="commentBtnWrap">
						<?if($isLock):?>
							<a href="javascript:goCommentModifyMoveEvent('<?=$row['CM_NO']?>')" id="commentModify"  class="btnCommentModify"><span>수정</span></a>
							<a href="javascript:goCommentDeleteActEvent('<?=$row['CM_NO']?>')" id="commentDelete" class="btnCommentDel"><span>삭제</span></a>
						<?endif;?>
					</div>
				</li>
			</ul>
		</div>
	</div><!--commentList-->
	<?   endwhile; ?>
	<? endif; ?>
	</div><!--commentListArea-->

	<textarea id="commentListForm" style="display:none" alt="리스트 추가 폼">
		<div id="commentListDiv" cm_m_no="" class="commentListView">
			<ul>
				<li class="commentWriter">
					<strong id="cm_name" class="writer" alt="이름"></strong>
					<span class="date">2013-04-05</span>
				</li>
				<li class="commentTitle">
					<span id="cm_text" alt="코멘트"></span>
					<div class="commentBtnWrap">
						<a href="" id="commentModify" class="btnCommentModify"><span>수정</span></a>
						<a href="" id="commentDelete" class="btnCommentDel"><span>삭제</span></a>
					</div>
				</li>
			</ul>
		</div>
	</textarea>

	<textarea id="commentPasswordForm" style="display:none" alt="비회원 비밀번호 폼">
		<div id="commentPasswordDiv">
			비밀번호 : <input type="password" name="cm_pass_check" id="cm_pass_check" alt="비밀번호" />
			<a id="commentPasswordOK" alt="확인">확인</a>
			<a id="commentPasswordCancel" alt="취소">취소</a>
		</div>
	</textarea>

	<textarea id="commentModifyForm" style="display:none" alt="수정 폼">
		<div id="commentModifyDiv">
			<span id="cm_name">이름:<input type="text" name="cm_name_modify" id="cm_name_modify" value="" alt="이름" check="modify"/></span>
			<span id="cm_pass">비밀번호:<input type="password" name="cm_pass_modify" id="cm_pass_modify" value="" alt="비밀번호" check="modify"/></span>
			내용:<textarea name="cm_text_modify" id="cm_text_modify" alt="내용" check="modify">&lt;/textarea>
			<a id="commentModifyOk" alt="등록">수정</a>
			<a id="commentModifyCancel" alt="취소">취소</a>
		</div>
	</textarea>