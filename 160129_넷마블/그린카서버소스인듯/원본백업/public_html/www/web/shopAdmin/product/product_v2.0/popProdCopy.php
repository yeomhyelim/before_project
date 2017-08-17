<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";	
	$productMgr = new ProductAdmMgr();		
	
	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	
	$productMgr->setP_LNG($strStLng);
	$productMgr->setP_CODE($strP_CODE);
	$prodRow = $productMgr->getProdView($db);
	
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--

	$(document).ready(function(){
		callCateList(1,"","","cateHCode1");
		var strHCode = "";

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
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&jsonMode=cateLevelList";
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

	function goProdCopyAct()
	{
		if(!C_chkInput("cateHCode1",true,"<?=$LNG_TRANS_CHAR['PW00087']?>",true)) return; //복사할 대상 1차 카테고리
		
		C_getAction("prodCopy",'<?=$PHP_SELF?>');
	}
	
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>[<?=$prodRow[P_NAME]?>] <?=$LNG_TRANS_CHAR["PW00088"] //상품복사?></h2>			
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
		
		<div class="tableForm mt20">
			<!-- ******** 컨텐츠 ********* -->
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00089"] //복사 대상 상품명?></th>
					<td colspan="3">
						<?=$prodRow[P_NAME]?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["PW00090"] //복사할 카테고리 선택?></th>
					<td colspan="3">
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
					</td>
				</tr>
			</table>
			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goProdCopyAct();" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["PW00018"]?></strong></a>
				<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["PW00091"] //닫기?></strong></a>
			</div>
		</div>
	</form>
</div>
</body>
</html>