<?
	# 쪽지전송폼
	# postPaperWrite.skin.php
?>

<div class="contentTop">
	<h2>쪽지글작성</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>제목</th>
			<td><input type="text" name="pp_title" id="pp_title" style="width:100%"/></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea name="pp_text" id="pp_text" id="pp_text" title=""  style="width:100%;height:400px" ></textarea></td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:postPaperSendParentGoClickEvent()" id="menu_auth_m" style=""><strong>쪽지 보내기</strong></a>
	<a class="btn_big" href="javascript:postPaperCloseClickEvent()"><strong>닫기</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->