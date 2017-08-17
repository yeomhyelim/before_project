<?
	## 설정
	## 쓰기 권한 설정
	## 댓글권한이 회원 전용이고, 로그인 한 사람이 회원이라면, 쓰기 가능한 그룹이라면 $commentWriteAuth = 1
	$commentWriteAuth = 0;
	if($_REQUEST['member_login'] && $_REQUEST['BOARD_INFO']['bi_comment_use'] == "M"):
		foreach($_REQUEST['BOARD_INFO']['bi_comment_member_auth'] as $key => $group):
			if($_REQUEST['member_group'] == $group):
				$commentWriteAuth = 1;
			endif;
		endforeach;
	endif;
?>
	
	<div id="commentWrite" alt="코멘트쓰기">
		<? if(!$_REQUEST['member_login'] && $_REQUEST['BOARD_INFO']['bi_comment_use'] == "A"):	// 비회원   ?>
			<div class="nonMemForm">
				<ul>
					<li><span>이름</span><input type="text" name="cm_name" id="cm_name" value="" alt="이름" check="write"/></li>
					<li><span>비밀번호</span><input type="password" name="cm_pass" id="cm_pass" value="" alt="비밀번호" check="write"/></li>
				</ul>
		</div>
		<? endif; ?>

		<?if($commentWriteAuth == 1): // 글쓰기 권한이 있으면?>
			<textarea id="cm_text" name="cm_text" alt="내용" check="write" class="commentWriteForm"></textarea>
			<a id="commentWriteOk" href="javascript:goCommentWriteActEvent();" class="btnWriteComment"><strong>등록</strong></a>
			<div class="clear"></div>
		<?else:?>
			<?if($_REQUEST['member_login']): // 로그인 하였으나 권한이 없는 경우. ?>
			<textarea id="cm_text" name="cm_text" alt="내용" check="write" class="commentWriteForm" onClick="alert('사용권한이 없습니다.');" readOnly></textarea>
			<a id="commentWriteOk" href="javascript:alert('사용권한이 없습니다.');" class="btnWriteComment"><strong>등록</strong></a>
			<div class="clear"></div>
			<?else:?>
			<textarea id="cm_text" name="cm_text" alt="내용" check="write" class="commentWriteForm" onClick="goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')" readOnly></textarea>
			<a id="commentWriteOk" href="javascript:goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')" class="btnWriteComment"><strong>등록</strong></a>
			<div class="clear"></div>
			<?endif;?>
		<?endif;?>
	</div>
