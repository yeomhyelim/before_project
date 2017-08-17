<?
	## 설정

	## 답변 버튼 설정
	$answer_btn_use = "";
	if($_REQUEST['BOARD_INFO']['bi_dataanswer_use'] != "N") { $answer_btn_use = "Y"; }

?>
<div class="contentTop">
	<h2><?=$_REQUEST['BOARD_INFO']['b_name']?></h2>
	<div class="clr"></div>
</div>



<div class="tabImgWrap">
<?php include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/board/basic.2.0/modify.tabMenu.skin.php" ?>
</div>


<?if($point_field_use == "Y"):?>
<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/eventInfo/include.1.0/pointView.inc.skin.php" ?>
</div>
<?endif;?><br>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/view.skin.php" ?>
</div><br>


<div class="tableForm">
	<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/writeAnswer.skin.php" ?>
</div>

<br>

<div class="btnCenter">
	<?if($answer_btn_use == "Y"):?>
	<a class="btn_new_big" href="javascript:goDataAnswerAct();" id="menu_auth_e1" style="display:none"><strong>답변 등록</strong></a>
	<?endif;?>
	<a class="btn_new_big" href="javascript:goDataListMove();"><strong>취소</strong></a>
</div>


<input type="hidden" name="b_code"    id="b_code"    value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"     id="ub_no"     value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_ans_no" id="ub_ans_no" value="<?=$_REQUEST['ub_no']?>">
<input type="hidden" name="ub_p_code" id="ub_p_code" value="<?=$dataSelectRow['UB_P_CODE']?>">