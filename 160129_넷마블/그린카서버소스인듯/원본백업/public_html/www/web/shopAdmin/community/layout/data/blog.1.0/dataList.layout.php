<div class="contentTop">
	<h2>
		리스트
	</h2>
</div>

<br>

<div class="tableList">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/list.skin.php" ?>
</div>

<br>

<div class="paginate">
<? $tableName = "DataMgr";  include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.1.0/list.page.skin.php" ?>
</div>


<div class="button">
	<a class="btn_big" href="javascript:goDataDeleteMultiActEvent();" id="menu_auth_w" style=""><strong>선택항목 삭제</strong></a>	
	<a class="btn_big" href="javascript:goDataWriteMove();" id="menu_auth_w" style=""><strong>등록</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="">