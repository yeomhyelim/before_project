<div class="chkPasswdWrap">
	<div class="tableForm">
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/data/basic.1.0/password.m.skins.php" ?>
	</div>

	<div class="btnCenter">
		<?if($_REQUEST['buttonLock']['dataDelete']):?>
		<a href="javascript:goDataPasswordActEvent();" id="menu_auth_w"  class="btn_board_ok"><strong>확인</strong></a>
		<?endif;?>
		<a href="javascript:goDataPasswordCancelMoveEvent();" id="menu_auth_w" class="btn_board_cancel"><strong>취소</strong></a>
	</div>
</div>
<input type="hidden" name="b_code"			 id="b_code"		value="<?=$_REQUEST['b_code']?>"/>
<input type="hidden" name="ub_no"			 id="ub_no"			value="<?=$_REQUEST['ub_no']?>"/>
<input type="hidden" name="password_mode"    id="password_mode"	value="<?=$_REQUEST['password_mode']?>"/>
<input type="hidden" name="password_act"     id="password_act"	value="<?=$_REQUEST['password_act']?>"/>
