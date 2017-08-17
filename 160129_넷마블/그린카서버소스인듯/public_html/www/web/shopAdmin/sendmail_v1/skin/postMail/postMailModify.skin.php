<?
	# 메일전송폼 - 수정
	# postMailModify.skin.php
?>

<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/postMail";
	var uploadFile 	= "../kr/index.php";
	var htmlYN		= "Y";
//]]>
</script>

<input type="hidden" name="pm_no" id="pm_no" value="<?=$intPM_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>메일작성</h2>
	<div class="clr"></div>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>제목</th>
			<td><input type="text" name="pm_title" style="width:100%" value="<?=$postMailRow['PM_TITLE']?>"/></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea name="pm_text" id="pm_text" title=""  style="width:100%;height:400px" ><?=$postMailRow['PM_TEXT']?></textarea></td>
		</tr>
	</table>
</div>

<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:postMailModifyActClickEvent()" id="menu_auth_m"><strong>수정</strong></a>
	<a class="btn_new_gray" href="javascript:postMailViewMoveClickEvent()"><strong class="ico_cancel">취소</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->