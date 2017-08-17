<div class="contentTop">
	<h2>
		커뮤니티 리스트
	</h2>
</div>

<br>

<div class="tableList">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/list.skin.php" ?>
</div>

<br>

<div class="paginate">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/list.page.skin.php" ?>
</div>


<div class="button">
	<a class="btn_big" href="javascript:goBoardWriteMove();" id="menu_auth_w" style=""><strong>커뮤니티  추가</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$strB_CODE?>">
