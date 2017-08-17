<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		

	/* 1차 카테고리 불러오기 */
	$cateMgr->setCL_LNG($strStLng);
	$cateMgr->setC_LEVEL(1);
	$cateMgr->setC_HCODE("");
	$cateMgr->setC_VIEW_YN("");
	$aryCate01 = $cateMgr->getCateLevelAry($db);
	
	
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
		
		var strChkVal = C_getCheckedCode(parent.document.form["chkNo[]"]);
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :"menuType=product&mode=json&jsonMode=cateUpdateProdList&prodCode="+strChkVal,
			dataType:"html", 
			success:function(data){	
				$("#tabProdList").html(data);
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
	
	function goProdCateUpdate()
	{
		
		var strHCode = $("#cateHCode1 option:selected").val()
		if (C_isNull(strHCode))
		{
			alert("<?=$LNG_TRANS_CHAR['PS00030']?>"); //카테고리 하나 이상은 선택하셔야 합니다.
			return;
		}

		var x = confirm("<?=$LNG_TRANS_CHAR['PS00031']?>"); //선택한 카테고리로 적용하시겠습니까?
		if (x ==true)
		{
			C_getAjax("prodCateUpdate","act");
		}
	}

	function goClose()
	{
		parent.location.reload();
		parent.goPopClose();
	}

	function goAjaxRet(name,result){

		if (name == "prodCateUpdate")
		{			
			var doc = document.form;
			var data = eval(result);
			
			if (data[0].RET == "N")
			{
				alert("<?=$LNG_TRANS_CHAR['CS00019']?>"); //카테고리 변경 중 에러가 발생하였습니다.
				return;
			}

			if (data[0].RET == "Y")
			{
				alert("<?=$LNG_TRANS_CHAR['PS00032']?>"); //카테고리가 변경 되었습니다.
				goClose();
			}
		}
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>상품 카테고리 일괄변경</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
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

	<div class="tableList mt20">
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