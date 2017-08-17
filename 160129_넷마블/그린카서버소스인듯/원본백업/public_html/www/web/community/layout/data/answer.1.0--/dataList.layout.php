<div class="tableList">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/answer.1.0/list.skin.php" ?>
</div>

<?if($_REQUEST['buttonLock'][2]): //글쓰기권한 ?>
<div class="btnRight">
	<a class="btn_new_big" href="javascript:goDataWriteMove();" id="menu_auth_w"><strong>글쓰기</strong></a>
</div>
<?endif;?>

<div class="paginate">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/list.page.skin.php" ?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">