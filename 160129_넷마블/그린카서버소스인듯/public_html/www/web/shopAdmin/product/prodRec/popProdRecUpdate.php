<?
	## 클래스 설정
	$objProductListModule		= new ProductAdmListModule($db);

	$param						= "";
	## 메인진열관리 불러오기
	$param['IC_TYPE']		= "MAIN";
	$aryProdMainDisplayList = $objProductListModule->getProductDisplayListSelectEx("OP_ARYTOTAL",$param);

	## 서브진열관리 불러오기
	$param['IC_TYPE']		= "SUB";
	$aryProdSubDisplayList	= $objProductListModule->getProductDisplayListSelectEx("OP_ARYTOTAL",$param);

?>
<? include "./include/header.inc.php"?>
<style type="text/css">
	#contentArea{position:relative;min-width:500px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		
	});
	
	function goProdRecItemCheck()
	{
		var x = confirm("선택하신 항목으로 상품진열정보를 변경하시겠습니까?");
		
		if (x == true)
		{		
			if ($(":checkbox[name^=prodIcon]:checked").length == 0)
			{
				alert("변경하실 상품진열정보항목을 선택해주세요.");
			}
			
			var strRecItem = "";
			$(":checkbox[name^=prodIcon]:checked").each(function(){			
				strRecItem += $(this).val()+",";
			});
			var strRecStatus = $(":radio[name=recStatus]:checked").val();

			parent.goProdRecUpdateAct(strRecItem,strRecStatus);
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
		<h2><?=$LNG_TRANS_CHAR["PW00192"]//상품진열정보변경?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
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
			<?
				if (is_array($aryProdMainDisplayList)){
			?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00027"] //메인 진열정보?></th>
				<td>
				<?	
					for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "prodIcon".($i+1);
					?>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="<?=($i+1)?>"><?=$aryProdMainDisplayList[$i][IC_NAME]?>
				<?}}?>
				</td>
			</tr>
			<?}?>
			<?
				if (is_array($aryProdSubDisplayList)){
			?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00028"] //서브 진열정보?></th>
				<td>
				<?	
					for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
							$strIconName = "prodIcon".($i+1);
					?>
						<input type="checkbox" id="<?=$strIconName?>" name="<?=$strIconName?>" value="<?=($i+6)?>"><?=$aryProdSubDisplayList[$i][IC_NAME]?>
				<?}}?>
				</td>
			</tr>
			<?}?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00193"]?></th>
				<td>
					<input type="radio" name="recStatus" id="recStatus" value="Y" checked>Yes
					<input type="radio" name="recStatus" id="recStatus" value="N" >No
				</td>
			</tr>
		</table>
		<div class="buttonWrap">
			<a class="btn_blue_big" href="javascript:goProdRecItemCheck();"><strong><?=$LNG_TRANS_CHAR["CW00079"]?></strong></a>
			<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["PW00091"] //닫기?></strong></a>
		</div>
	</div>


</form>
</div>
</body>
</html>