<?
	## 설정
	$isBtnAnswer = true;
	$isBtnModify = true;
	$isBtnDelete = true;
	$isBtnList = true;

	## 포인트 필드 설정
	$point_field_use = "";
	if($_REQUEST['BOARD_INFO']['bi_point_use'] == "Y") { $point_field_use = true; }

	## 코멘트 필드 설정
	$comment_field_use = "";
	if($_REQUEST['BOARD_INFO']['bi_comment_use'] != "N") { $comment_field_use = true; }

	## 답변 버튼 설정
	if($_REQUEST['BOARD_INFO']['bi_dataanswer_use'] != "N") { $isBtnAnswer = true; }

	## 입점사 로그인일때 설정
	## 2014.04.28 kim hee sung 입점사업체문의사항(S_REQ) 게시판은 등록수정삭제 기능이 되도록 변경함
	if($_REQUEST['member_type'] == "S" && $_REQUEST['b_code'] == "S_REQ" && $_REQUEST['member_no'] != $_REQUEST['result']['DataMgr']['UB_M_NO']):
		$isBtnAnswer = false;
		$isBtnModify = false;
		$isBtnDelete = false;
//		$isBtnList = false;
	endif;

	## 2014.08.28 kim hee sung 
	## 입점사 로그인을 했을때는 자신의 글만 수정할수 있습니다.
	if($isBtnModify && $a_admin_type == "S"):
		if($_REQUEST['result']['DataMgr']['UB_M_NO'] != $_REQUEST['member_no']):
			$isBtnModify = false;
			$isBtnDelete = false;
		endif;
	endif;
?>
<div class="contentTop">
	<h2><?=$_REQUEST['BOARD_INFO']['b_name']?></h2>
	<div class="clr"></div>
</div>


<div class="tabImgWrap">
<?php include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>


<?if($point_field_use):?>
<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/eventInfo/include.1.0/pointView.inc.skin.php" ?>
</div>
<?endif;?><br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/view.skin.php" ?>
</div><br>

<div class="button">
	<?php if($isBtnAnswer):?>
	<a class="btn_big" href="javascript:goDataAnswerMove();" id="menu_auth_e1" style="display:none"><strong>답변</strong></a>
	<?php endif;?>
	<?php if($isBtnModify):?>
	<a class="btn_big" href="javascript:goDataModifyMove();" id="menu_auth_m" style="display:none"><strong>수정</strong></a>
	<?php endif;?>
	<?php if($isBtnDelete):?>
	<a class="btn_big" href="javascript:goDataDeleteAct();"  id="menu_auth_d" style="display:none"><strong>삭제</strong></a>
	<?php endif;?>
	<?php if($isBtnList):?>
	<a class="btn_big" href="javascript:goDataListMove();" ><strong>목록</strong></a>
	<?php endif;?>
</div><br>

<?if($comment_field_use):?>
<div class="tableList">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/comment/basic.1.0/list.skin.php" ?>
</div><br>

<?if($point_field_use):?>
<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/eventInfo/include.1.0/pointSet.inc.skin.php" ?>
</div>
<?endif;?>

<br>

<div class="button">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/comment/basic.1.0/eventSet.skin.php" ?>
</div>

<div class="paginate">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/comment/basic.1.0/list.page.skin.php" ?>
</div>
<?endif;?>


<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no"  value="<?=$_REQUEST['ub_no']?>">