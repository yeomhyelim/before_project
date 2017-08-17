<div class="contentTop">
	<h2><?=$_REQUEST['BOARD_INFO']['b_name']?></h2>
	<div class="clr"></div>
</div>



<div class="tabImgWrap">
<?php include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>


<br>

<div class="buttonWrap">
	<a class="btn_big" href="javascript:goDataWriteAct();" id="menu_auth_w" style="display:none"><strong>등록</strong></a>
	<a class="btn_big" href="javascript:goDataListMove();" ><strong>취소</strong></a>
</div>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/write.skin.php" ?>
</div>

<br>

<div class="button">
	<a class="btn_big" href="javascript:goDataWriteAct();" id="menu_auth_w" style="display:none"><strong>등록</strong></a>
	<a class="btn_big" href="javascript:goDataListMove();" ><strong>취소</strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="attached_filetemp_del" id="attached_filetemp_del" value="">
