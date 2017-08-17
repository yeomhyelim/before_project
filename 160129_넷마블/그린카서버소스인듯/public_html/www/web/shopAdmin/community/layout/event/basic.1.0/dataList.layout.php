<? 
	## 설정
	$tableName				= "DataMgr"; 
?>

<div class="contentTop">
	<h2>
		<?=$_REQUEST['BOARD_INFO']['b_name']?> 게시판
	</h2>
	<a class="btn_sml" href="javascript:goBoardModifyMoveEvent();" id="menu_auth_w" style=""><strong>기능설정</strong></a>
</div>

<br>


<div class="tableList">
<strong><?=NUMBER_FORMAT($_REQUEST['list_total'][$tableName])// 총 데이터 수?></strong>(<?=$_REQUEST['page'] // 현재 페이지?>/<?=$_REQUEST['page_total'][$tableName] // 총 페이지 수?>Page)
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/search.1.0/dataSearch.skin.php" ?>
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/listCnt.1.0/dataListCnt.skin.php" ?>
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/event/basic.1.0/list.skin.php" ?>
</div>

<br>

<div class="paginate">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/common/page.1.0/list.page.skin.php" ?>
</div>


<div class="button">
	<a class="btn_big" href="javascript:goDataDeleteMultiActEvent();" id="menu_auth_w" style=""><strong>선택항목 삭제</strong></a>	
	<a class="btn_big" href="javascript:goDataWriteMove();" id="menu_auth_w" style=""><strong>등록</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">

