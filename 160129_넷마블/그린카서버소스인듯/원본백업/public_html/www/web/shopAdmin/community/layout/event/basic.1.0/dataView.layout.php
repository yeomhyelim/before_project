<div class="contentTop">
	<h2>
		내용
	</h2>
	
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/event/basic.1.0/view.skin.php" ?>
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/event/basic.1.0/pointView.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goDataModifyMove();" id="menu_auth_w" style=""><strong>수정</strong></a>
	<a class="btn_big" href="javascript:goDataDeleteAct();"  id="menu_auth_w" style=""><strong>삭제</strong></a>
	<a class="btn_big" href="javascript:goDataListMove();"   id="menu_auth_w" style=""><strong>목록</strong></a>
	<a class="btn_big" href="javascript:goCommentListMoveEvent();" id="menu_auth_w" style=""><strong>이벤트 참여자 목록</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">