<? 
	## 설정
	$tableName				= "DataMgr"; 
?>

<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/talk/comment.1.0/write.skin.php" ?>
</div>

<br>

<div class="tableList">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/talk/comment.1.0/list.skin.php" ?>
</div>

<div class="paginate">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/common/page.1.0/list.page.skin.php" ?>
</div>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
