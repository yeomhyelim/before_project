<?
	/** 2013.04.17 이벤트 기능 페이지 추가 */
	$viewFile			= "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/event/basic.1.0/view.skin.php";
	$eventScriptFile	= "{$_REQUEST['S_DOCUMENT_ROOT']}{$_REQUEST['S_SHOP_HOME']}/html/event/eventScript.{$_REQUEST['ub_no']}.php";
	if(is_file($eventScriptFile)) { $viewFile = $eventScriptFile; }
?>

<div <?=(!is_file($eventScriptFile))?"class=\"tableForm\"":"";?>>
<? include $viewFile; ?>
</div>


<div class="btnRight">
	<?if($_REQUEST['BOARD_INFO']['bi_datamodify_use']):	// 수정 권한이 있는 경우.?>
	<!--<a class="btn_new_big" href="javascript:goDataModifyMove();"    id="menu_auth_w"><strong>수정</strong></a>//-->
	<?endif;?>
	<?if($_REQUEST['BOARD_INFO']['bi_datadelete_use']):	// 삭제 권한이 있는 경우.?>
	<!--<a class="btn_new_big" href="javascript:goDataDeleteAct();" id="menu_auth_w"><strong>삭제</strong></a>//-->
	<?endif;?>
	<?if($_REQUEST['BOARD_INFO']['bi_datalist_use']):	// 리스트 권한이 있는 경우.?>
	<a class="btn_new_big" href="javascript:goDataListMove();"      id="menu_auth_w"><strong>목록</strong></a>
	<?endif;?>
</div>

<?if($_REQUEST['BOARD_INFO']['bi_comment_use'] != "N"): // 코멘트 사용 하는 경우.?>
<?//include "dataView.comment.layout.php"; // 2013.04.26 코멘트 사용 안함 ?>
<?endif;?>
<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="cm_no"  id="cm_no"  value="">