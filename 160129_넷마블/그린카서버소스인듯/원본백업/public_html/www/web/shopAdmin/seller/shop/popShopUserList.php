<? include "./include/header.inc.php"?>
<?
	
	
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
	});


	function goClose()
	{
		parent.location.reload();
		parent.goPopClose();
	}


//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["SW00046"]?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">	
<input type="hidden" name="prodCode" id="prodCode" value="<?=$strP_CODE?>">	
<input type="hidden" name="ps_no" id="ps_no" value="">	
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm mt20">
		<table>
			<tr>
				<th>
					<select id="cateHCode1" name="cateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"]?></option>
					</select>
					<select id="cateHCode2" name="cateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"]?></option>
					</select>
					<select id="cateHCode3" name="cateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"]?></option>
					</select>
					<select id="cateHCode4" name="cateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"]?></option>
					</select>
					<a class="btn_sml" href="javascript:goProdCateUpdate();"><strong>적용</strong></a>
				</th>
			</tr>
		</table>
	</div>

	<div class="tableList">
		<div class="tableList">
			<table id="tabProdList">
				<tr>
					<th>번호</th>
					<th>상품명</th>
				</tr>
				
			</table>
		</div>
	</div>
</form>
</div>
</body>
</html>