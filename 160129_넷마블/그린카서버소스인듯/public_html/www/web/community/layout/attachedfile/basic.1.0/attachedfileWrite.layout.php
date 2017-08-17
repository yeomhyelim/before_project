<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["CW00074"] //첨부파일 업로드?></h2>
</div>


<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/attachedfile/basic.1.0/write.skin.php" ?>
</div>


<div class="btnCenter">
	<a href="javascript:goAttachedfileTempFileUploadAct();" id="menu_auth_w" class="btnLayerOk"><strong><?=$LNG_TRANS_CHAR["CW00075"] //파일업로드?></strong></a>
	<a href="javascript:goAttachedfileClose();" id="menu_auth_w"  class="btnLayerClose"><strong><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></strong></a>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">