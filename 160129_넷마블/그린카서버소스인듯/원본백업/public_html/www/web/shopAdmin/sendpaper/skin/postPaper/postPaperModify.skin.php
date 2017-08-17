<?
	# 쪽지전송폼
	# postPaperPaper.skin.php
?>

<input type="hidden" name="pp_no" id="pp_no" value="<?=$intPP_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>쪽지글수정</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>제목</th>
			<td><input type="text" name="pp_title" style="width:100%" value="<?=$postPaperRow['PP_TITLE']?>"/></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea name="pp_text" id="pp_text" title=""  style="width:100%;height:400px" ><?=$postPaperRow['PP_TEXT']?></textarea></td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:postPaperModifyActClickEvent()" id="menu_auth_m" style=""><strong>저장</strong></a>
	<a class="btn_big" href="javascript:postPaperViewMoveClickEvent()"><strong>취소</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->