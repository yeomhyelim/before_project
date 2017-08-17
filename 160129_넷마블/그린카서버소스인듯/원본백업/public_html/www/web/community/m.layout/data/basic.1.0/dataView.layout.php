<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/data/basic.1.0/view.skin.php" ?>
</div>

<div class="btnRight">
	<?if($_REQUEST['buttonLock']['dataAnswer']==1): //답변권한 ?>
	<a href="javascript:goDataAnswerMoveEvent();"    id="menu_auth_w" class="btn_board_reply"><strong><?=$LNG_TRANS_CHAR["CW00060"] //답변?></strong></a>
	<?endif;?>

	<?if($_REQUEST['buttonLock']['dataModify']==1): //수정권한 ?>
	<a href="javascript:goDataModifyMoveEvent();"    id="menu_auth_w" class="btn_board_modify"><strong><?=$LNG_TRANS_CHAR["OW00072"] //수정?></strong></a>
	<?endif;?>

	<?if($_REQUEST['buttonLock']['dataDelete']): //수정권한 ?>

	<a href="javascript:goDataDeleteActEvent('<?=$dataSelectRow['UB_M_NO']?>');"    id="menu_auth_w" class="btn_board_delete"><strong><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></strong></a>
	<?endif;?>
	
	<?if($_REQUEST['buttonLock']['dataList']): //리스트권한 ?>
	<a href="javascript:goDataListMoveEvent();"      id="menu_auth_w" class="btn_board_list"><strong><?=$LNG_TRANS_CHAR["CW00059"] //목록?></strong></a>
	<?endif;?>
</div>

<div class="nextPrve">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/data/basic.1.0/nextPrveList.skin.php" ?>
</div>

<?if($_REQUEST['BOARD_INFO']['bi_comment_use'] != "N"): // 코멘트 사용 하는 경우.?>
	<?include "dataView.comment.layout.php";?>
<?endif;?>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="cm_no"  id="cm_no"  value="">