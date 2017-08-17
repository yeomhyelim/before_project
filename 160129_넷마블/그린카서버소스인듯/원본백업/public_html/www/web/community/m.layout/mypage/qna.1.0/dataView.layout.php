<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/data/basic.1.0/view.m.skins.php" ?>
</div>


<div class="btnRight">
	<?if($_REQUEST['buttonLock']['dataAnswer']=="X"): //답변권한, 1:1질문에서는 사용자단에서 답변 권한 사용 안함 ?>
	<a class="btn_new_big" href="javascript:goDataAnswerMove();"    id="menu_auth_w"><strong>답변</strong></a>
	<?endif;?>

	<?if($_REQUEST['buttonLock']['dataModify']==1): //수정권한 ?>
	<a class="btn_new_big" href="javascript:goDataModifyMove();"    id="menu_auth_w"><strong>수정</strong></a>
	<?endif;?>

	<?if($_REQUEST['buttonLock']['dataDelete']): //수정권한 ?>
	<a class="btn_new_big" href="javascript:goDataDeleteAct();"    id="menu_auth_w"><strong>삭제</strong></a>
	<?endif;?>
	
	<?if($_REQUEST['buttonLock']['dataList']): //리스트권한 ?>
	<a class="btn_new_big" href="javascript:goDataListMove();"      id="menu_auth_w"><strong>목록</strong></a>
	<?endif;?>
</div>

<?if($_REQUEST['BOARD_INFO']['bi_comment_use'] == "Y"): // 코멘트 사용 하는 경우.?>
<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/comment/basic.1.0/write.m.skins.php" ?>
</div>

<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/comment/basic.1.0/list.m.skins.php" ?>
</div>

<div class="paginate">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/comment/basic.1.0/list.page.m.skins.php" ?>
</div>
<?endif;?>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="cm_no"  id="cm_no"  value="">