<?
	# 전체메일발송관리 - 상세보기
	# postMailView.skin.php
?>

<input type="hidden" name="pm_no" id="pm_no" value="<?=$intPM_NO?>" />
<input type="hidden" name="memberNo" id="memberNo" value="<?=$intM_NO?>">

<div class="contentTop">
	<h2>메일보내기</h2>
	<div class="clr"></div>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>보내는 사람 이름</th>
			<td><input type="text" name="send_name" style="width:100%" value="<?=$strSEND_NAME?>"/></td>
		</tr>
		<tr>
			<th>보내는 사람 메일</th>
			<td><input type="text" name="send_email" style="width:100%" value="<?=$strSEND_EMAIL?>"/></td>
		</tr>
		<tr>
			<th>받는사람 이름</th>
			<td><input type="text" name="receive_name" style="width:100%" value="<?=$strRECEIVE_NAME?>"/></td>
		</tr>
		<tr>
			<th>받는사람 메일</th>
			<td><input type="text" name="receive_mail" style="width:100%" value="<?=$strRECEIVE_MAIL?>"/></td>
		</tr>
		<tr>
			<th>제목</th>
			<td><input type="text" name="pm_title" style="width:100%" value="<?=$postMailRow['PM_TITLE']?>" /></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea name="pm_text" id="pm_text" title=""  style="width:100%;height:300px" ><?=$postMailRow['PM_TEXT']?></textarea><br></td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:postMailTestSendActClickEvent()" id="menu_auth_m" style=""><strong>보내기</strong></a>
	<? if($strTarget == "pop") : // 팝업인경우 ?>
	<a class="btn_big" href="javascript:postMailCloseClickEvent()"><strong>닫기</strong></a>
	<? else : // 일반 ?>
	<a class="btn_big" href="javascript:postMailViewMoveClickEvent()"><strong>취소</strong></a>
	<? endif; ?>
</div>
<!-- ******** 컨텐츠 ********* -->