<? include "./include/header.inc.php"?>
<style type="text/css">
	#contentArea{position:relative;min-width:500px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		
	});
	
	function goProdStockItemCheck()
	{
		var x = confirm("선택하신 항목으로 상태를 변경하시겠습니까?");
		
		
		if (x == true)
		{		
			var strStockStatus	= $(":radio[name=stockStatus]:checked").val();
			var strViewStatus	= $(":radio[name=viewStatus]:checked").val();
		
			parent.goProdStockUpdateAct(strStockStatus,strViewStatus);
			return;
		}
	}

	function goClose()
	{
		parent.goPopClose();
	}

//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>재고상태</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<colgroup>
				<col style="width:90px;"/>
				<col />
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00159"] //재고상태?></th>
				<td>
					<input type="radio" name="stockStatus" id="stockStatus" value="1" checked><?=$LNG_TRANS_CHAR["PW00041"]//품절?>
					<input type="radio" name="stockStatus" id="stockStatus" value="2"><?=$LNG_TRANS_CHAR["PW00042"]//재입고?>
					<input type="radio" name="stockStatus" id="stockStatus" value="3"><?=$LNG_TRANS_CHAR["PW00043"]//무제한?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"]?></th>
				<td>
					<input type="radio" name="viewStatus" id="viewStatus" value="Y">Yes
					<input type="radio" name="viewStatus" id="viewStatus" value="N" checked>No
				</td>
			</tr>
		</table>
		<div class="buttonWrap">
			<a class="btn_blue_big" href="javascript:goProdStockItemCheck();"><strong><?=$LNG_TRANS_CHAR["CW00079"]?></strong></a>
			<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["PW00091"] //닫기?></strong></a>
		</div>
	</div>


</form>
</div>
</body>
</html>