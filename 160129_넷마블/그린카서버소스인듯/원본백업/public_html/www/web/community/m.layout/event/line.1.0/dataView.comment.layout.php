<? 
	## 설정
	$tableName		= "CommentMgr"; 
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$page			= $_REQUEST['result'][$tableName]['pageResult']['page'];
	$page_total		= $_REQUEST['result'][$tableName]['pageResult']['page_total'];
?>

<div class="commentTableForm" alt="코멘트 글쓰기 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/comment/basic.1.0/write.skin.php" ?>
</div>

<div class="tableForm" alt="코멘트 리스트 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/comment/basic.1.0/list.skin.php" ?>
</div>

<div class="paginate" alt="코멘트 페이징 스킨">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/common/page.1.0/list.page.skin.php" ?>
</div>