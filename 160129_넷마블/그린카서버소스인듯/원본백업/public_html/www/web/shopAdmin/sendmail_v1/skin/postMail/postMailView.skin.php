<?
	# 전체메일발송관리 - 상세보기
	# postMailView.skin.php
?>

<input type="hidden" name="pm_no" id="pm_no" value="<?=$intPM_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>메일내용보기</h2>
	<div class="clr"></div>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>제목</th>
			<td><?=$postMailRow['PM_TITLE']?></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><?=$postMailRow['PM_TEXT']?><br></td>
		</tr>
	</table>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_gray" href="javascript:postMailModifyMoveClickEvent()" id="menu_auth_m"><strong class="ico_modify">수정</strong></a>
	<a class="btn_new_gray" href="javascript:postMailListMoveClickEvent()" id="menu_auth_m"><strong class="ico_list">목록</strong></a>
	<a class="btn_new_blue" href="javascript:postMailTestSendMoveClickEvent()" id="menu_auth_m"><strong class="ico_mail">1. 테스트 메일 보내기</strong></a>
	<a class="btn_new_blue" href="javascript:postMailShotMoveClickEvent()" id="menu_auth_m"><strong class="ico_mail">2. 대량 메일 보내기</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->