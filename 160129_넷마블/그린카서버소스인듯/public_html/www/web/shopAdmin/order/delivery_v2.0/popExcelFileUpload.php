<? include "./include/header.inc.php"?>
<body>
<?

?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goExcelFileUploadAct()
	{
		$("input[name=menuType]").val("order");
		$("input[name=mode]").val("act");
		$("input[name=act]").val("orderDeliveryExcelUpdate");
		$("#form").submit();
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>엑셀파일 일괄수정</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form" method="post" action="./" enctype="multipart/form-data">
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="page" value="<?=$intPage?>">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm" style="margin-top:10px;">
		<table>
			<tr>
				<th>파일</th>
				<td>
					<input type='file' name='excelFile'/>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goExcelFileUploadAct();" id="menu_auth_w"><strong>적용</strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
</body>
</html>