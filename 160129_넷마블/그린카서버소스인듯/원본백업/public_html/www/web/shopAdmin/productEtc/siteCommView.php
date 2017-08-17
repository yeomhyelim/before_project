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
<div id="contentArea">
<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["PW00105"] //공통관리?></h2>
	<div class="clr"></div>
</div>


<!-- ******** 컨텐츠 ********* -->

	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00106"] //제목?></th>
				<td >
					<?=$row["SC_TITLE"]?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00107"] //내용?></th>
				<td>
					<?=$row["SC_TEXT"]?>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonBoxWrap">
		<a class="btn_new_gray" href="javascript:goMoveUrl('siteCommList','')"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
		<a class="btn_new_blue" href="javascript:goMoveUrl('siteCommModify','<?=$row[SC_NO]?>')" id="menu_auth_m" style="display:none:"><strong class="ico_modify"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a> 
		<a class="btn_new_gray" href="javascript:goMoveUrl('siteCommDelete','<?=$row[SC_NO]?>');" id="menu_auth_d" style="display:none:"><strong class="ico_del"><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a> 
	</div>
<!-- ******** 컨텐츠 ********* -->
