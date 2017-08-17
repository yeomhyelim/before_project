<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/event/basic.1.0/view.m.skins.php" ?>
</div>

<div class="btnRight">
	<?if($_REQUEST['BOARD_INFO']['bi_datamodify_use']):	// 수정 권한이 있는 경우.?>
	<!--<a class="btn_new_big" href="javascript:goDataModifyMove();"    id="menu_auth_w"><strong>수정</strong></a>//-->
	<?endif;?>
	<?if($_REQUEST['BOARD_INFO']['bi_datadelete_use']):	// 삭제 권한이 있는 경우.?>
	<!--<a class="btn_new_big" href="javascript:goDataDeleteAct();" id="menu_auth_w"><strong>삭제</strong></a>//-->
	<?endif;?>
	<?if($_REQUEST['BOARD_INFO']['bi_datalist_use']):	// 리스트 권한이 있는 경우.?>
	<a href="javascript:goDataListMove();" id="menu_auth_w" class="btn_board_list"><strong>목록</strong></a>
	<?endif;?>
</div>

<?if($_REQUEST['BOARD_INFP']['bi_comment_use'] == "Y"): // 코멘트 사용 하는 경우.?>
	<div class="tableForm">
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/comment/basic.1.0/write.m.skins.php" ?>
	</div>

	<div class="tableForm">
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/comment/basic.1.0/list.m.skins.php" ?>
	</div>
<?endif;?>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="cm_no"  id="cm_no"  value="">