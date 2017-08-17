<?
	# 전체쪽지발송관리 - 상세보기
	# postPaperView.skin.php
?>

<input type="hidden" name="pp_no" id="pp_no" value="<?=$intPP_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>쪽지내용보기</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>제목</th>
			<td><?=$postPaperRow['PP_TITLE']?></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><?=$postPaperRow['PP_TEXT']?><br></td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:postPaperModifyMoveClickEvent()" id="menu_auth_m" style=""><strong>수정</strong></a>
	<a class="btn_blue_big" href="javascript:postPaperListMoveClickEvent()" id="menu_auth_m" style=""><strong>목록</strong></a>
	<a class="btn_blue_big" href="javascript:postPaperShotMoveClickEvent()" id="menu_auth_m" style=""><strong>대량 쪽지 보내기</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->