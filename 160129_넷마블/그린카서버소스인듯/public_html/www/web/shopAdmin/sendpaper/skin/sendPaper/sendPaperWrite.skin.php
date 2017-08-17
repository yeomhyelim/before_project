<?
	# 쪽지전송폼
	# postPaperWrite.skin.php
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

<div id="contentArea">
<div class="contentTop">
	<h2>쪽지글작성</h2>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>제목</th>
			<td><input type="text" name="mp_title" style="width:100%" data-auto-focus data-empty-check="제목을 입력하세요"/></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea name="mp_text" style="width:100%;height:400px" data-empty-check="내용을 입력하세요" ></textarea></td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goSendPaperWriteActEvent()" id="menu_auth_m" style=""><strong>저장</strong></a>
	<a class="btn_big" href="javascript:goSendPaperWriteCancelEvent()"><strong>취소</strong></a>
</div>

<input type="hidden" name="mp_to_m_no" value="<?=$paperRow['MP_FROM_M_NO']?>"/>
<!-- ******** 컨텐츠 ********* -->