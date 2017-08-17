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
	<h2>배송/반품교환 안내</h2>
	<div class="clr"></div>
</div>
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableForm">
	<h3>배송 안내</h3>
	<table>
		<tr>
			<td>
				<textarea name="s_prod_delivery" id="s_prod_delivery" style="width:100%;height:250px" title="higheditor_full"><?=$row[S_PROD_DELIVERY]?></textarea>
			</td>
		</tr>
	</table>
	<br>
	<h3>반품교환 안내</h3>
	<table>
		<tr>
			<td>
				<textarea name="s_prod_return" id="s_prod_return" title="higheditor_full" style="width:100%;height:250px"><?=$row[S_PROD_RETURN]?></textarea>
			</td>
		</tr>
	</table>
</div>

<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goDelRetHelp();" id="menu_auth_w"><strong>등록</strong></a>
	<a class="btn_big" href="javascript:history.back();"><strong>취소</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->