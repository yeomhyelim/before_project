<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/write.skin.php" ?>
</div>

<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataWrite']): //글쓰기권한 ?>
	<a href="javascript:goDataWriteActEvent();" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"] //글쓰기?></strong></a>
	<?endif;?>
	<?if($_REQUEST['BOARD_INFO']['bi_start_mode'] == "dataWrite" && $_REQUEST['BOARD_INFO']['bi_datawrite_end_move'] == "dataWrite"):?>
	<?else:?>
	<a href="javascript:goDataCancelMoveEvent();" id="menu_auth_w" class="btn_board_cancel"><strong><?=$LNG_TRANS_CHAR["MW00044"] //취소?></strong></a>
	<?endif;?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="attached_filetemp_del" id="attached_filetemp_del" value="">
