	<?if($_REQUEST['buttonLock']['dataWrite']):	// 사용 권한이 없을 때?>
		<div id="talkWrite_Table">
			<textarea id="ub_talk" name="ub_talk" alt="내용" check="Y"></textarea>
			<a href="javascript:goTalkWriteEvent();" id="menu_auth_w" class="btnTalkFormWrite"><span>글쓰기</span></a>
		</div>
	<?else:  // 사용 권한이 있을 때?>
		<div id="talkWrite_Table">
			<textarea id="ub_talk" name="ub_talk" onClick="goLoginLayerpop()" readOnly alt="내용"></textarea>
			<a class="btn_big" href="javascript:goLoginLayerpop();" id="menu_auth_w" class="btnTalkFormWrite"><span>글쓰기</span></a>
		</div>
	<?endif;?>