<div class="contentTop">
	<h2>
		리스트
	</h2>
</div>

<br>

<div class="tableList">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/answer.1.0/list.skin.php" ?>
</div>

<div class="button">
	<a class="btn_big" href="javascript:goDataWriteMove();" id="menu_auth_w"><strong>글쓰기</strong></a>
</div>

<div class="paginate">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/list.page.skin.php" ?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">