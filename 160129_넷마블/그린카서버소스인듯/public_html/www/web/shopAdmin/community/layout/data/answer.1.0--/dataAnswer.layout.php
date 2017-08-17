<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/write.skin.php" ?>
</div>

<br>

<div class="btnCenter">
	<a class="btn_new_big" href="javascript:goDataAnswerAct();" id="menu_auth_w"><strong>등록</strong></a>
	<?if($_REQUEST['BOARD_INFO']['bi_datalist_use']):	// 리스트 권한이 있는 경우.?>
	<a class="btn_new_big" href="javascript:goDataListMove();"   id="menu_auth_w"><strong>취소</strong></a>
	<?endif;?>
</div>


<input type="hidden" name="b_code"    id="b_code"    value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"     id="ub_no"     value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">