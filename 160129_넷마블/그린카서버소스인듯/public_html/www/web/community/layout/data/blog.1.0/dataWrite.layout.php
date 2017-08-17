<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/write.skin.php" ?>
</div>


<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataModify']): //수정권한 ?>
	<a class="btn_new_big" href="javascript:goDataWriteAct();" id="menu_auth_w"><strong>등록</strong></a>
	<?endif;?>
	<?if($_REQUEST['buttonLock']['dataList']):	// 리스트 권한이 있는 경우.?>
	<a class="btn_new_big" href="javascript:goDataListMove();"   id="menu_auth_w"><strong>취소</strong></a>
	<?endif;?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
