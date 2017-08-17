<div class="contentTop">
	<h2>
		커뮤니티 설정
	</h2>
</div>

<br>

<div class="tabImgWrap">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.tabMenu.skin.php" ?>
</div>

<br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.category.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goBoardModifyCategoryAct();" id="menu_auth_w" style=""><strong>설정 변경</strong></a>
	<a class="btn_big" href="javascript:goBoardListMove();" id="menu_auth_w" style=""><strong>목록</strong></a>
</div>

<br>

<div class="tableForm">
<?if(is_array($categoryListRow)): // 수정?>
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.category.modify.skin.php" ?>
<?else: // 신규등록?>
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.category.write.skin.php" ?>
<?endif;?>
</div>

<br>

<div class="button">
	<?if(is_array($categoryListRow)): // 수정?>
	<a class="btn_big" href="javascript:goCategoryModifyActEvent();" id="menu_auth_w" style=""><strong>카테고리 수정</strong></a>
	<a class="btn_big" href="javascript:goCategoryMoveEvent();" id="menu_auth_w" style=""><strong>카테고리 취소</strong></a>
	<?else: // 신규등록?>
	<a class="btn_big" href="javascript:goCategoryWriteActEvent();" id="menu_auth_w" style=""><strong>카테고리 등록</strong></a>
	<?endif;?>
</div>

<br>

<div class="tableList">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/modify.category.list.skin.php" ?>
</div>

<br>




<input type="hidden" id="b_code" name="b_code" value="<?=$boardSelectRow['B_CODE']?>"/>
<input type="hidden" id="bc_no" name="bc_no" value="<?=$_REQUEST['bc_no']?>"/>
<input type="hidden" id="bc_b_code" name="bc_b_code" value="<?=$boardSelectRow['B_CODE']?>"/>

