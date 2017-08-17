<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/write.skin.php" ?>
</div>

<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataWrite']): //글쓰기권한 ?>
	<a class="btn_new_big" href="javascript:goDataWriteAct();" id="menu_auth_w"><strong>등록</strong></a>
	<?endif;?>
	<a class="btn_new_big" href="javascript:goDataListMove();" id="menu_auth_w"><strong>취소</strong></a>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
