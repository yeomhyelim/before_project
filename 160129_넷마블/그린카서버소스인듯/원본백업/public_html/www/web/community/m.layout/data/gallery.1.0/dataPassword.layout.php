
<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/password.skin.php" ?>
</div>


<div class="button">
	<?if($_REQUEST['mode']=="dataMPassword"): //수정모드 ?>
	<a class="btn_new_big" href="javascript:goDataMPasswordJson();"    id="menu_auth_w"><strong>확인(수정)</strong></a>
	<?elseif($_REQUEST['mode']=="dataDPassword"): //삭제모드 ?>
	<a class="btn_new_big" href="javascript:goDataDPasswordJson();"    id="menu_auth_w"><strong>확인(삭제)</strong></a>
	<?endif;?>
	<a class="btn_new_big" href="javascript:goDataListMove();"		 id="menu_auth_w"><strong>취소</strong></a>
</div>

<input type="hidden" name="b_code"   id="b_code"   value="<?=$_REQUEST['b_code']?>"/>
<input type="hidden" name="ub_no"    id="ub_no"    value="<?=$_REQUEST['ub_no']?>"/>