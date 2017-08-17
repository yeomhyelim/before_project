<div class="contentTop">
	<h2>
		글수정
	</h2>
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/event/basic.1.0/modify.skin.php" ?>
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/event/basic.1.0/pointModify.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goDataModifyAct();" id="menu_auth_w" style=""><strong>수정</strong></a>
	<a class="btn_big" href="javascript:goDataListMove();" id="menu_auth_w" style=""><strong>취소</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no" value="<?=$_REQUEST['ub_no']?>">
