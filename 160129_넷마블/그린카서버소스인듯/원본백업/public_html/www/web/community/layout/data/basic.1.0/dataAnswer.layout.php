<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/write.skin.php" ?>
</div>

<br>

<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataAnswer']): //답변권한 ?>
	<a href="javascript:goDataAnswerActEvent();" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"] //글쓰기?></strong></a>
	<?endif;?>
	<a href="javascript:goDataAnswerCancelEvent();"   id="menu_auth_w" class="btn_board_cancel"><strong><?=$LNG_TRANS_CHAR["MW00044"] //취소?></strong></a>
</div>


<input type="hidden" name="b_code"    id="b_code"    value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"     id="ub_no"     value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">