<?include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	function goHtmlEditMakeFileActEvent() { goHtmlEditMakeFileAct(); }

	function goHtmlEditMakeFileAct() {
		var mode = "popHtmlMakeFile";
		C_getAction(mode, "./");
	}
//-->
</script>


						

<div id="contentArea">
	<form name="form" id="form">
	<input type="hidden" name="menuType"	value="<?=$strMenuType?>">
	<input type="hidden" name="mode"		value="<?=$strMode?>">
	<input type="hidden" name="act"			value="<?=$strMode?>">
	<input type="hidden" name="lang"		value="<?=$strStLng?>">
	<div class="tableForm" style="margin-top:10px;">
		<table>
			<tr>
				<th>파일명</th>
				<td><input type="text" name="fileName" value="" style="width:500px;" data-auto-focus/></td>
			</tr>
		</table>
	</div>
	</form>
	<a class="btn_blue_sml" href="javascript:goHtmlEditMakeFileActEvent();"><strong>생성</strong></a>
	<a class="btn_blue_sml" href="javascript:self.close();"><strong>닫기</strong></a>
</div>
</body>
</html>