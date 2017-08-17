<? 
	## 설정
	$tableName		= "DataMgr"; 
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$page			= $_REQUEST['result'][$tableName]['pageResult']['page'];
	$page_total		= $_REQUEST['result'][$tableName]['pageResult']['page_total'];
?>

<?if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"):?>
<div class="tableList" alt="카테고리">
<?include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/category/include.1.0/{$_REQUEST['BOARD_INFO']['bi_category_m.skins']}.inc.m.skins.php";?>
</div>
<?endif;?>

<div class="tableList" alt="리스트">
	<div class="boardTopWrap"alt="리스트상단">
		<div class="boardCntWrap"><strong><?=NUMBER_FORMAT($list_total)// 총 데이터 수?></strong>(<?=$page // 현재 페이지?>/<?=$page_total // 총 페이지 수?>Page)</div>
		<div class="boardTopSearchWrap"><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/common/search.1.0/search.m.skins.php" ?></div>
		<div class="clear"></div>
	</div>
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skinss/user/community/data/blog.1.0/list.m.skins.php" ?>
</div>


<?if($_REQUEST['buttonLock']['dataWrite']==1): //글쓰기권한 ?>
<div class="btnRight">
	<a class="btn_new_big" href="javascript:goDataWriteMove();" id="menu_auth_w"><strong>글쓰기</strong></a>
</div>
<?elseif($_REQUEST['buttonLock']['dataWrite']==2):?>
<div class="btnRight">
	<a href="javascript:goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')" id="menu_auth_w" class="btn_board_write"><strong>글쓰기</strong></a>
</div>
<?endif;?>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">