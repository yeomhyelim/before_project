<div class="contentTop">
	<h2>
		첨부파일 업로드
	</h2>
	<div class="clr"></div>
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/attachedfile/basic.1.0/write.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goAttachedfileTempFileUploadAct();" id="menu_auth_w" style=""><strong>파일업로드</strong></a>
	<a class="btn_big" href="javascript:goAttachedfileClose();" id="menu_auth_w" style=""><strong>닫기</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">