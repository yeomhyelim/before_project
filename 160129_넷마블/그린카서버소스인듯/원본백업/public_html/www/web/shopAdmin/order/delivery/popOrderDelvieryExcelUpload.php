<? include "./include/header.inc.php"?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goExcelUpload()
	{
		if(!C_chkInput("excelFile",true,"<?=$LNG_TRANS_CHAR['OS00015']?>",false)) return; 
		
		$("#menu_auth_u").css("display","none");
		$("#close").css("display","none");

		$("#loading").css("display","block");


		document.charset = "UTF-8";
		document.form.encoding = "multipart/form-data";
		document.form.menuType.value = "order";
		C_getAction("orderDeliveryExcelUpdate","./index.php");	
	}

//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["OW00092"] //엑셀업로드?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form" method="post">
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm" style="margin-top:10px;">
		<table>
			<tr>
				<td>
					<input type="file" name="excelFile" id="excelFile" style="width:440px">
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<div id="loading" style="display:none"><img src='../himg/etc/icon_loading_4.gif'></div>
		<a class="btn_blue_big" href="javascript:goExcelUpload();" id="menu_auth_u"><strong>Upload</strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();" id="close"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</div>
</body>
</html>