<?
	## 2013.04.22 내용 추가
	## prodCode 값이 없으면 다중 등록
?>
<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		

	$strP_CODE			= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	$strP_CODE_MULTI	= $_POST["prodCodeMulti"]	? $_POST["prodCodeMulti"]	: $_REQUEST["prodCodeMulti"];

	/* 1차 카테고리 불러오기 */
	$cateMgr->setCL_LNG($strStLng);
	$cateMgr->setC_LEVEL(1);
	$cateMgr->setC_HCODE("");
	$cateMgr->setC_VIEW_YN("");
	$aryCate01 = $cateMgr->getCateLevelAry($db);
	
	
	/* 공유 카테고리 리스트 */
	$productMgr->setP_LNG($strStLng);
	$productMgr->setP_CODE($strP_CODE);
	$prodRow = $productMgr->getProdView($db);

	$aryProdList  = $productMgr->getProdShareList($db);

?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		callCateList(1,"","","cateHCode1");

		$("#cateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","cateHCode2");
			}
		});

		$("#cateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","cateHCode3");
			}
		});

		$("#cateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","cateHCode4");
			}
		});	
		
	});


	function callCateList(cateLevel,cateHCode,cateView,cateObj)
	{
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strAdmSiteLng?>";

		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				
				var strCateSelectedText = "";
				if (cateLevel == "1")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00013']?>";
				} else if (cateLevel == "2")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00014']?>";
				} else if (cateLevel == "3")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00015']?>";
				} else if (cateLevel == "4")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00016']?>";
				}

				$("#"+cateObj).html("<option value=''>"+strCateSelectedText+"</option>");
				for(var i=0;i<data.length;i++){
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"'>"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}

	function goProdShareMultiInsert() {
		var strHCode = $("#cateHCode1 option:selected").val()
		if (C_isNull(strHCode))
		{
			alert("공유카테고리 하나 이상은 선택하셔야 합니다.");
			return;
		}

		var x = confirm("선택한 공유카테고리로 적용하시겠습니까?");
		if (x ==true)
		{
//			C_getAction("prodShareMultiInsert","<?=$PHP_SELF?>");	
			C_getAjax("prodShareMultiInsert","act");
		}
	}
	
	function goProdShareInsert()
	{
		
		var strHCode = $("#cateHCode1 option:selected").val()
		if (C_isNull(strHCode))
		{
			alert("공유카테고리 하나 이상은 선택하셔야 합니다.");
			return;
		}

		var x = confirm("선택한 공유카테고리로 적용하시겠습니까?");
		if (x ==true)
		{
			C_getAjax("prodShareInsert","act");
		}
	}

	function goProdShareDelete(no){
		var x = confirm("선택한 공유카테고리를 삭제하시겠습니까?");
		if (x ==true)
		{
			document.form.ps_no.value = no;
			C_getAjax("prodShareDelete","act");
		}
	}

	function goClose()
	{
		parent.location.reload();
		parent.goPopClose();
	}

	function goAjaxRet(name,result){

		if (name == "prodShareMultiInsert"){
			var doc = document.form;
			var data = eval(result);
			
			if (data[0].RET == "Y")
			{
				alert("공유카테고리가 설정되었습니다.");			
//				parent.goProdShareHtml(document.form.prodCode.value,data[0].MSG);
				parent.location.reload();
				return;
			}
		}

		if (name == "prodShareInsert")
		{			
			var doc = document.form;
			var data = eval(result);
			
			if (data[0].RET == "N")
			{
				alert(data[0].MSG);
				return;
			}

			if (data[0].RET == "Y")
			{
				alert("공유카테고리가 설정되었습니다.");			
				parent.goProdShareHtml(document.form.prodCode.value,data[0].MSG);
				location.reload();
				return;
			}
		}

		if (name == "prodShareDelete")
		{
			var data = eval(result);
			if (data[0].RET == "Y")
			{
				alert("공유카테고리가 설정이 삭제되었습니다.");
				parent.goProdShareHtml(document.form.prodCode.value,data[0].MSG);
				location.reload();
				return;
			}
		}
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>[<?=strHanCutUtf($prodRow[P_NAME], 50);?>] <?= $LNG_TRANS_CHAR["PW00291"]; //공유카테고리 관리 ?></h2>			
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
<input type="hidden" name="prodCodeMulti" id="prodCodeMulti" value="<?=$strP_CODE_MULTI?>">	
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
					<!--
					<select id="cateHCode4" name="cateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"]?></option>
					</select>
					-->
					<?if($strP_CODE): // 한개 상품을 공유?>
					<a class="btn_sml" href="javascript:goProdShareInsert();"><strong><?= $LNG_TRANS_CHAR["PW00290"]; //적용 ?></strong></a>
					<?else: // 다중 상품을 공유 ?>
					<a class="btn_sml" href="javascript:goProdShareMultiInsert();"><strong><?= $LNG_TRANS_CHAR["PW00290"]; //적용 ?></strong></a>
					<?endif;?>
				</th>
			</tr>
		</table>
	</div>

	<div class="tableList">
		<div>
			<table>
				<tr>
					<th><?= $LNG_TRANS_CHAR["CW00009"]; //번호 ?></th>
					<th><?= $LNG_TRANS_CHAR["PW00021"]; //카테고리 ?></th>
					<th><?= $LNG_TRANS_CHAR["SW00025"]; //설정 ?></th>
				</tr>
				<?if (is_array($aryProdList)){
					for($i=0;$i<sizeof($aryProdList);$i++){
					?>
				<tr>
					<td><?=$i+1?></td>
					<td><?=getCateName($aryProdList[$i][PS_P_CATE],$strStLng)?></td>
					<td><a class="btn_sml" href="javascript:goProdShareDelete('<?=$aryProdList[$i][PS_NO]?>');"><strong>삭제</strong></a></td>
				</tr>

				<?}}?>
			</table>
		</div>
	</div>
</form>
</div>
</body>
</html>