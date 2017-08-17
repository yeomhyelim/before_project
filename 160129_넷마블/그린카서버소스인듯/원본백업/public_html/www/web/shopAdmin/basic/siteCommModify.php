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
					<input type="text" <?=$nBox?> name="sc_title" id="sc_title" style="width:98%;" value="<?=$row["SC_TITLE"]?>">
				</td>
			</tr>
			<tr>
				<th>내용</th>
				<td ">
					<textarea name="sc_text" id="sc_text" title="higheditor_full" style="width:100%;height:250px"><?=$row["SC_TEXT"]?></textarea>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goMoveUrl('siteCommModifyOK','<?=$row["SC_NO"]?>');" id="menu_auth_w"><strong>등록</strong></a>
		<a class="btn_big" href="javascript:goMoveUrl('siteCommList');"><strong>취소</strong></a>
	</div>
<!-- ******** 컨텐츠 ********* -->
