<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/data/basic.1.0/modify.skin.php" ?>
</div>


<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataModify']): //수정권한 ?>
	<a href="javascript:goDataModifyAct();" id="menu_auth_w" class="btn_board_modify"><strong><?=$LNG_TRANS_CHAR["OW00072"] //글쓰기?></strong></a>
	<?endif;?>
	<a href="javascript:goDataModifyCancelMoveEvent();"   id="menu_auth_w" class="btn_board_cancel"><strong><?=$LNG_TRANS_CHAR["MW00044"] //취소?></strong></a>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="attached_filetemp_del" id="attached_filetemp_del" value="">
