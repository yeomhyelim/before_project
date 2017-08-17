<div class="contentTop">
	<h2>
		커뮤니티 설정
	</h2>
</div>

<br>

<div class="tabImgWrap">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.tabMenu.skin.php" ?>
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.delete.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goBoardModifyDeleteAct();" id="menu_auth_w" style=""><strong>설정 변경</strong></a>
	<a class="btn_big" href="javascript:goBoardListMove();" id="menu_auth_w" style=""><strong>목록</strong></a>
</div>

<input type="hidden" id="b_code" name="b_code" value="<?=$boardSelectRow['B_CODE']?>"/>
