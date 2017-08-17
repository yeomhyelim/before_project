<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/view.skin.php" ?>
</div>


<div class="btnRight">
	<?if($_REQUEST['buttonLock']['dataModify']==1): //수정권한(회원글) ?>
	<a class="btn_board_modify" href="javascript:goDataModifyMove();"    id="menu_auth_w"><strong>수정</strong></a>
	<?elseif($_REQUEST['buttonLock']['dataModify']==2): //수정권한(비회원글) ?>
	<a class="btn_board_modify" href="javascript:goDataMPasswordMove();" id="menu_auth_w"><strong>수정</strong></a>
	<?endif;?>

	<?if($_REQUEST['buttonLock']['dataDelete']==1): //수정권한(회원글) ?>
	<a class="btn_board_delete" href="javascript:goDataDeleteAct();"    id="menu_auth_w"><strong>삭제</strong></a>
	<?elseif($_REQUEST['buttonLock']['dataDelete']==2): //삭제권한(비회원글) ?>
	<a class="btn_board_delete" href="javascript:goDataDPasswordMove();" id="menu_auth_w"><strong>삭제</strong></a>
	<?endif;?>
	
	<?if($_REQUEST['buttonLock']['dataList']): //리스트권한 ?>
	<a class="btn_board_list" href="javascript:goDataListMove();"      id="menu_auth_w"><strong>목록</strong></a>
	<?endif;?>
</div>

<?if($_REQUEST['BOARD_INFO']['bi_comment_use'] != "N"): // 코멘트 사용 하는 경우.?>
<div class="commentTableForm" alt="코멘트 글쓰기 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/comment/basic.1.0/write.skin.php" ?>
</div>

<div class="tableForm" alt="코멘트 리스트 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/comment/basic.1.0/list.skin.php" ?>
</div>

<div class="paginate" alt="코멘트 페이징 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/comment/basic.1.0/list.page.skin.php" ?>
</div>
<?endif;?>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="cm_no"  id="cm_no"  value="">