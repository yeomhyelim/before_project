<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/mypage/qna.1.0/modify.m.skins.php" ?>
</div>


<div class="btnCenter">
	<?if($_REQUEST['buttonLock']['dataModify']): //수정권한 ?>
	<a class="btn_new_big" href="javascript:goDataModifyAct();" id="menu_auth_w"><strong>수정</strong></a>
	<?endif;?>
	<a class="btn_new_big" href="javascript:goDataViewMove(<?=$_REQUEST['ub_no']?>);"   id="menu_auth_w"><strong>취소</strong></a>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="attached_filetemp_del" id="attached_filetemp_del" value="">
