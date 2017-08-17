<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/modify.skin.php" ?>
</div>

<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataModify']):	// 수정 권한이 있는 경우.?>
	<a href="javascript:goDataModifyAct();" id="menu_auth_w" class="btn_board_modify"><strong><?=$LNG_TRANS_CHAR["OW00072"] //수정?></strong></a>
	<?endif;?>
	<?if($_REQUEST['buttonLock']['dataList']):	// 리스트 권한이 있는 경우.?>
	<a href="javascript:goDataListMove();" id="menu_auth_w" class="btn_board_cancel"><strong>취소</strong></a>
	<?endif;?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
