<div class="contentTop">
	<h2>커뮤니티 설정 (<?=$_REQUEST['BOARD_INFO']['b_name']?>)</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tabImgWrap">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>

<br>

<div class="tableFormWrap">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.userfield.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goBoardModifyUserfieldAct();" id="menu_auth_m" style="display:none"><strong>설정 변경</strong></a>
	<a class="btn_big" href="javascript:goBoardListMoveEvent();"><strong>목록</strong></a>
</div>

<input type="hidden" id="b_code" name="b_code" value="<?=$boardSelectRow['B_CODE']?>"/>
