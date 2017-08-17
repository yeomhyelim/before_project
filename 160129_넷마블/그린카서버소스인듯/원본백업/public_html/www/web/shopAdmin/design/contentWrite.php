<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/upload/editor";
	var uploadFile 	= "../index.php";
	var htmlYN		= "Y";
//]]>
</script>

<div class="contentTop">
	<h2>추가페이지 관리</h2>
</div>
<br/>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<table>
		<colgroup>
			<col/>
			<col/>
		</colgroup>
		<tr>
			<th>메뉴그룹</th>
			<td>
				<select id="cp_group" name="cp_group">
					<option>모든그룹 접근 권한</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>페이지명</th>
			<td><input type="text" name="cp_page_name" id="cp_page_name" <?=$nBox?>  style="width:600px;"/></td>
		</tr>
		<tr>
			<th>링크</th>
			<td><input type="text" name="cp_page_url" id="cp_page_url" <?=$nBox?>  style="width:600px;"/></td>
		</tr>
		<tr>
			<th>내용</th>
			<td><textarea style="width:100%;height:250px;" name="cp_page_text" id="cp_page_text" title="higheditor_full"></textarea></td>
		</tr>
	</table>
	
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goContentAct('contentWrite');" id="menu_auth_w"><strong>추가 컨텐츠 저장</strong></a>
		<a class="btn_big" href="javascript:C_getMoveUrl('contentList','get','<?=$PHP_SELF?>');"><strong>취소</strong></a>
	</div>
</div><!-- tableForm -->
