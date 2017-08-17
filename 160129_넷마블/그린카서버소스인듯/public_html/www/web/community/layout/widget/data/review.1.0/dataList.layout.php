<? 
	## 설정
	$tableName				= "DataMgr"; 
?>
<div class="">
	<div class="tableList">
		<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/widget/product/review.1.0/list.skin.php" ?>
	</div>
</div>

<?if($_REQUEST['buttonLock']['dataWrite']==1): //글쓰기 옵션이 있고, 로그인 한 경우. ?>
<div class="btnRight">
	<a href="javascript:goDataWriteMoveEvent('<?=$_REQUEST['b_code']?>');" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
</div>
<?elseif($_REQUEST['buttonLock']['dataWrite']==2): //글쓰기 옵션이 있으나 로그인을 하지 않는 경우. ?>
<div class="btnRight">
	<a href="javascript:alert('로그인이 필요합니다.')" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
</div>
<?endif;?>


<div class="paginate">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/common/page.1.0/list.page.json.skin.php" ?>
</div>


<? include_once "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/widget/product/common.1.0/formTag.skin.php" ?>