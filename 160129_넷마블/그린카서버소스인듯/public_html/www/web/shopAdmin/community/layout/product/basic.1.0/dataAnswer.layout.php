<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/write.skin.php" ?>
</div>

<br>

<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataAnswer']): //답변권한 ?>
	<a class="btn_new_big" href="javascript:goDataAnswerAct();" id="menu_auth_w"><strong>답변 등록</strong></a>
	<?endif;?>
	<a class="btn_new_big" href="javascript:goDataListMove();"   id="menu_auth_w"><strong>취소</strong></a>
</div>


<input type="hidden" name="b_code"    id="b_code"    value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"     id="ub_no"     value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">