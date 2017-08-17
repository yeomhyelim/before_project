<? 
	## 설정
	$tableName		= "DataMgr"; 
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$page			= $_REQUEST['result'][$tableName]['pageResult']['page'];
	$page_total		= $_REQUEST['result'][$tableName]['pageResult']['page_total'];
?>

<?if($_REQUEST['BOARD_INFO']['bi_category_list_use'] == "Y" && $_REQUEST['BOARD_INFO']['bi_category_use']=="Y"):?>
	<div class="tableList">
		<?include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/category/include.1.0/{$_REQUEST['BOARD_INFO']['bi_category_skin']}.inc.skin.php";?>
	</div>
<?endif;?>

<div class="tableList">
	<div class="boardTopWrap">
		<div class="boardCntWrap"><strong><?=NUMBER_FORMAT($list_total)// 총 데이터 수?></strong>(<?=$page // 현재 페이지?>/<?=$page_total // 총 페이지 수?>Page)</div>
		<div class="boardTopSearchWrap"><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/common/search.1.0/search.skin.php" ?></div>
		<div class="clear"></div>
	</div>
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/data/basic.1.0/list.skin.php" ?>
	<?// include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/data/basic.1.0/snsList.skin.php" ?>
</div>


<?if($_REQUEST['buttonLock']['dataWrite']==1): //글쓰기권한 ?>
	<div class="btnRight<?if(in_array($_REQUEST['buttonLock']['dataWrite'], array(1,2))){echo " right";}?>">
		<a href="javascript:goDataWriteMove();" id="menu_auth_w" class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
	</div>
<?elseif($_REQUEST['buttonLock']['dataWrite']==2):?>
	<div class="btnRight<?if(in_array($_REQUEST['buttonLock']['dataWrite'], array(1,2))){echo " right";}?>">
		<a href="javascript:goLoginPageMoveEvent('<?=$S_MAIN_LAYERPOP_LOGIN_USE?>')" id="menu_auth_w"  class="btn_board_write"><strong><?=$LNG_TRANS_CHAR["CW00052"]//글쓰기?></strong></a>
	</div>
<?endif;?>


<div class="paginate<?if(in_array($_REQUEST['buttonLock']['dataWrite'], array(1,2))){echo "_left";}?>">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/m.skins/user/community/common/page.1.0/list.page.skin.php" ?>
</div>



<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">

