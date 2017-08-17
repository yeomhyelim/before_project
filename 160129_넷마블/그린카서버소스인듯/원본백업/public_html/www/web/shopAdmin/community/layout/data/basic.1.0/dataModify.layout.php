<?php
	## 설정
	$isBtnAnswer = true;
	$isBtnModify = true;
	$isBtnDelete = true;
	$isBtnList = true;

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
//			$isBtnModify = false;
//			$isBtnDelete = false;
			goErrMsg("수정할수 없습니다.");
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

<br>

<div class="button">
	<?php if($isBtnModify):?>
	<a class="btn_big" href="javascript:goDataModifyAct();" id="menu_auth_m" style="display:none"><strong>수정</strong></a>
	<?php endif;?>
	<?php if($isBtnDelete):?>
	<a class="btn_big" href="javascript:goDataViewMove1('<?=$_REQUEST['b_code']?>','<?=$_REQUEST['ub_no']?>');"><strong>취소</strong></a>
	<?php endif;?>
</div>

<div class="tableForm">
<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/admin/community/data/basic.1.0/modify.skin.php" ?>
</div>

<br>

<div class="button">
	<?php if($isBtnModify):?>
	<a class="btn_big" href="javascript:goDataModifyAct();" id="menu_auth_m" style="display:none"><strong>수정</strong></a>
	<?php endif;?>
	<?php if($isBtnDelete):?>
	<a class="btn_big" href="javascript:goDataViewMove1('<?=$_REQUEST['b_code']?>','<?=$_REQUEST['ub_no']?>');"><strong>취소</strong></a>
	<?php endif;?>
</div>

<input type="hidden" name="b_code" id="b_code" value="<?=$_REQUEST['b_code']?>">
<input type="hidden" name="ub_no"  id="ub_no" value="<?=$_REQUEST['ub_no']?>">
