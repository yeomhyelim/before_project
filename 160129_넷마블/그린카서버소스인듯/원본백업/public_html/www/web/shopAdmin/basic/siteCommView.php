<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/upload/editor";
	var uploadFile 	= "../kr/index.php";
	var htmlYN		= "Y";
//]]>
</script>
<div id="contentArea">
<div class="contentTop">
	<h2>공통관리</h2>
</div>


<!-- ******** 컨텐츠 ********* -->

	<div class="tableForm" style="margin-top:10px;">
		<table>
			<tr>
				<th>제목</th>
				<td >
					<?=$row["SC_TITLE"]?>
				</td>
			</tr>
			<tr>
				<th>내용</th>
				<td ">
					<?=$row["SC_TEXT"]?>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<a class="btn_big" href="javascript:goMoveUrl('siteCommList','')"><strong>목록</strong></a>
		<a class="btn_big" href="javascript:goMoveUrl('siteCommModify','<?=$row[SC_NO]?>')" id="menu_auth_m" ><strong>수정</strong></a> 
		<a class="btn_big" href="javascript:goMoveUrl('siteCommDelete','<?=$row[SC_NO]?>');" id="menu_auth_d"><strong>삭제</strong></a> 
	</div>
<!-- ******** 컨텐츠 ********* -->
