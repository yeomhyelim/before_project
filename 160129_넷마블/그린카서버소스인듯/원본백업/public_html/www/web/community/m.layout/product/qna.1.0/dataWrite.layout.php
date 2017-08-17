<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/product/qna.1.0/write.skin.php" ?>
</div>

<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataWrite']): //글쓰기권한 ?>
	<a class="btn_new_big" href="javascript:goDataWriteActEvent();" id="menu_auth_w"><strong>등록</strong></a>
	<?endif;?>
	<a class="btn_new_big" href="javascript:goDataListMoveEvent();" id="menu_auth_w"><strong>취소</strong></a>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="attached_filetemp_del" id="attached_filetemp_del" value="">
<input type="hidden" name="ub_p_code" id="ub_p_code" value="<?=$_REQUEST['ub_p_code']?>">
