<?
	## 받은 쪽지 함(보기)
	## /home/shop_eng/www/web/shopAdmin/sendpaper/skin/receivePaper/receivePaperView.skin.php

	## 설정

	## 보낸사람 아이디 설정
	$from_id			= $paperRow['FROM_M_ID'];
	if(!$from_id)	{ $from_id		= $paperRow['FROM_M_MAIL'];		}

	## 내용 설정
	$contents_text		= strConvertCut($paperRow['MP_TEXT'],0,"N");
?>

<div id="contentArea">
<div class="contentTop">
	<h2>받은쪽지 함</h2>
</div>
<br>

<!-- ******** 컨텐츠(쪽지보기) ********* -->

<!-- 버튼 -->
<div style="text-align:left;margin-top:3px;">
	<a class="btn_big" href="javascript:goReceivePaperDeleteActEvent()" id="menu_auth_w" style=""><strong>삭제</strong></a>
	<a class="btn_big" href="javascript:goSendPaperWriteMoveEvent()" id="menu_auth_w" style=""><strong>답장</strong></a>
	<a class="btn_big" href="javascript:goReceivePaperListMoveEvent()" id="menu_auth_w" style=""><strong>목록</strong></a>
</div>

<!-- 쪽지 보기 -->
제목 : <?=$paperRow['MP_TITLE']?>
보낸사람 : <?=$paperRow['FROM_M_L_NAME']?> <?=$paperRow['FROM_M_F_NAME']?>(<?=$from_id?>)
받은시간 : <?=date("Y.m.d H:i", strtotime($paperRow['MP_REG_DT']))?>

<?=$contents_text?>
<!-- ******** 컨텐츠(쪽지보기) ********* -->
<input type="hidden" name="mp_no" id="mp_no" value="<?=$_REQUEST['mp_no']?>"/>
