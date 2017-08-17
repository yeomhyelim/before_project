<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/view.skin.php" ?>
</div>

<div class="btnRight">
	<?if($_REQUEST['buttonLock'][5]==1): //답변권한(회원글) ?>
	<a class="btn_new_big" href="javascript:goDataAnswerMove();"    id="menu_auth_w"><strong>답변</strong></a>
	<?elseif($_REQUEST['buttonLock'][5]==2): //답변권한(비회원글) ?>
	<a class="btn_new_big" href="javascript:goDataAPasswordMove();" id="menu_auth_w"><strong>답변</strong></a>
	<?endif;?>

	<?if($_REQUEST['buttonLock'][3]==1): //수정권한(회원글) ?>
	<a class="btn_new_big" href="javascript:goDataModifyMove();"    id="menu_auth_w"><strong>수정</strong></a>
	<?elseif($_REQUEST['buttonLock'][3]==2): //수정권한(비회원글) ?>
	<a class="btn_new_big" href="javascript:goDataMPasswordMove();" id="menu_auth_w"><strong>수정</strong></a>
	<?endif;?>

	<?if($_REQUEST['buttonLock'][4]==1): //수정권한(회원글) ?>
	<a class="btn_new_big" href="javascript:goDataDeleteAct();"    id="menu_auth_w"><strong>삭제</strong></a>
	<?elseif($_REQUEST['buttonLock'][4]==2): //삭제권한(비회원글) ?>
	<a class="btn_new_big" href="javascript:goDataDPasswordMove();" id="menu_auth_w"><strong>삭제</strong></a>
	<?endif;?>
	
	<?if($_REQUEST['buttonLock'][0]): //리스트권한 ?>
	<a class="btn_new_big" href="javascript:goDataListMove();"      id="menu_auth_w"><strong>목록</strong></a>
	<?endif;?>
</div>

<?if($_REQUEST['BOARD_INFP']['bi_comment_use'] == "Y"): // 코멘트 사용 하는 경우.?>
	<div class="tableForm">
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/comment/basic.1.0/write.skin.php" ?>
	</div>

	<div class="tableForm">
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/comment/basic.1.0/list.skin.php" ?>
	</div>
<?endif;?>

<input type="hidden" name="b_code"    id="b_code"    value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"     id="ub_no"     value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="cm_no"     id="cm_no"     value="">
