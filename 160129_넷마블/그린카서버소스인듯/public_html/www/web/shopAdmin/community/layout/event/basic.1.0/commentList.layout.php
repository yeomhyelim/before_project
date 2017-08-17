<? 
	## 설정
	$tableName		= "EventCommentMgr"; 
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$page			= $_REQUEST['result'][$tableName]['pageResult']['page'];
	$page_total		= $_REQUEST['result'][$tableName]['pageResult']['page_total'];

?>

<div class="contentTop">
	<h2>
		이벤트 참여자
	</h2>
</div>

<br>

<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/comment/basic.1.0/eventType.skin.php" ?>

<a href="javascript:goCommentExcelDownMoveEvent();">[엑셀]</a>
<a href="javascript:goCommentDeleteMultiActEvent();">[선택항목 삭제]</a>

<div class="tableList" alt="코멘트 리스트 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/event/basic.1.0/eventCommentList.skin.php" ?>
</div>

<div class="button" alt="코멘트 설정">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/event/basic.1.0/eventCommentEventSet.skin.php" ?>
</div>

<div class="paginate" alt="코멘트 페이징 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/page.1.0/list.page.skin.php" ?>
</div>

<div class="button">
	<a class="btn_big" href="javascript:goDataViewMove2('<?=$_REQUEST['ub_no']?>');" id="menu_auth_w" style=""><strong>뒤로</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">