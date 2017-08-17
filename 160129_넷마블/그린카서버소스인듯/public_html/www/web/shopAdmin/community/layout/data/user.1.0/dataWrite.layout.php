<div class="contentTop">
	<h2>
		글쓰기
	</h2>
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/write.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goDataWriteAct();" id="menu_auth_w" style=""><strong>등록</strong></a>
	<a class="btn_big" href="javascript:goDataListMove();" id="menu_auth_w" style=""><strong>취소</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
