<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		

	$intCG_NO = $_POST["no"]					? $_POST["no"]				: $_REQUEST["no"];

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];

	$strC_HCODE1	= $_POST["cateHCode1"]				? $_POST["cateHCode1"]				: $_REQUEST["cateHCode1"];
	$strC_HCODE2	= $_POST["cateHCode2"]				? $_POST["cateHCode2"]				: $_REQUEST["cateHCode2"];
	$strC_HCODE3	= $_POST["cateHCode3"]				? $_POST["cateHCode3"]				: $_REQUEST["cateHCode3"];
	$strC_HCODE4	= $_POST["cateHCode4"]				? $_POST["cateHCode4"]				: $_REQUEST["cateHCode4"];

	/* 1차 카테고리 불러오기 */
	$cateMgr->setCL_LNG($strStLng);
	$cateMgr->setC_LEVEL(1);
	$cateMgr->setC_HCODE("");
	$cateMgr->setC_VIEW_YN("");
	$aryCate01 = $cateMgr->getCateLevelAry($db);

	/* 언어 선택 */
	$productMgr->setP_LNG($strStLng);

	/* 검색부분 */
	if (($strSearchField && $strSearchKey) || $strC_HCODE1) {
		$productMgr->setSearchHCode1($strC_HCODE1);
		$productMgr->setSearchHCode2($strC_HCODE2);
		$productMgr->setSearchHCode3($strC_HCODE3);
		$productMgr->setSearchHCode4($strC_HCODE4);

		$productMgr->setSearchField($strSearchField);
		$productMgr->setSearchKey($strSearchKey);
		/* 검색부분 */

		$intPageBlock	= 10;
		$intPageLine	= 10;
		$productMgr->setPageLine($intPageLine);

		$intTotal	= $productMgr->getProdTotal($db);
		$intTotPage	= ceil($intTotal / $productMgr->getPageLine());

		if(!$intPage)	$intPage =1;

		if ($intTotal==0) {
			$intFirst	= 1;
			$intLast	= 0;			
		} else {
			$intFirst	= $intPageLine *($intPage -1);
			$intLast	= $intPageLine * $intPage;
		}
		$productMgr->setLimitFirst($intFirst);

		$result = $productMgr->getProdList($db);

		$linkPage  = "?menuType=$strMenuType&mode=$strMode&cateHCode1=$strC_HCODE1&cateHCode2=$strC_HCODE2";
		$linkPage .= "&cateHCode3=$strC_HCODE3&cateHCode4=$strC_HCODE4";
		$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&no=$intCG_NO&page=";
	}
			
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		callCateList(1,"","","cateHCode1","<?=$strC_HCODE1?>");

		$("#cateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","cateHCode2","<?=$strC_HCODE2?>");
			}
		});

		$("#cateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","cateHCode3","<?=$strC_HCODE3?>");
			}
		});

		$("#cateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","cateHCode4","<?=$strC_HCODE4?>",cateSelected);
			}
		});	
		
	});


	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
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
					var strCateSelected = "";
					if (data[i].CATE_CODE == cateSelected)
					{
						strCateSelected = "selected";
					}
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"' "+strCateSelected+">"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}

	function goClose()
	{
		parent.location.reload();
		parent.goPopClose();
	}

	/* 상품목록 검색*/
	function goSearch(mode){
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goProdCateAllInsert()
	{
		if (!$("#prodCateAll").is(":checked"))
		{
			alert("카테고리별 전체 적용하기를 클릭해주세요.");
			return;
		}

		if (!$("#cateHCode1 option:selected").val())
		{
			alert("카테고리를 하나이상은 선택하셔야 합니다.");
			return;
		}
		
		C_getAjax("prodGiftCateAllReg","act");
	}

	function goProdAllInsert()
	{
		var strChkVal = C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}
		C_getAjax("prodGiftProductReg","act");
	}

	function goAjaxRet(name,result){

		if (name == "prodGiftCateAllReg" || name == "prodGiftProductReg")
		{			
			var doc = document.form;
			var data = eval(result);
			
			if (data[0].RET == "N")
			{
				alert("<?=$LNG_TRANS_CHAR['PS00034']?>"); //카테고리별로 상품 등록중 오류가 발생하였습니다.
				return;
			}

			if (data[0].RET == "Y")
			{
				alert("<?=$LNG_TRANS_CHAR['PS00033']?>");	//카테고리별로 상품이 등록되었습니다.		
				parent.location.reload();
				return;
			}
		}
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>고객사은품 상품적용하기</h2>			
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
<input type="hidden" name="no" id="no" value="<?=$intCG_NO?>">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
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
				</th>
			</tr>
			<tr>
				<th>
					<select name="searchField" id="searchField">
						<option value="N"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
						<option value="C"><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
						<option value="M"><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
						<option value="O"><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
						<option value="D"><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
					</select>
					<input type="text" id="searchKey" name="searchKey" <?=$nBox?>/>
					<a class="btn_sml" href="javascript:goSearch('popGiftProdSearch');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
				</th>
			</tr>
			<tr>
				<th>
					<BR>
					<input type="radio" name="prodCateAll" id="prodCateAll" value="Y"> 카테고리 전체 일괄등록
					<a class="btn_blue_big" href="javascript:goProdCateAllInsert();"><strong><?=$LNG_TRANS_CHAR["PW00129"]?></strong></a>
				</th>
			</tr>
		</table>
	</div>
	<?if ($intTotal > 0){?>
	<div class="tableList">
		<table>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></th>
				<th><?=$LNG_TRANS_CHAR["BW00054"] //판매가?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="3"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?	
				/* PHP CODE */
				}else{				
					while($row = mysql_fetch_array($result))		{	

				/* PHP CODE */
			?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[P_CODE]?>"></td>
				<td style="width:50px;"><a href="javascript:goOpenWindow('<?=$row[P_CODE]?>')"><img src="<?=$row[PM_REAL_NAME]?>" class="prodPhoto"></a></td>
				<td class="prodListInfo">					
					<ul>
						<li class="title"><?=$row[P_NAME]?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?>:</span><?=getCateName($row[P_CATE],$strStLng)?></li>
						<li><span><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?>:</span><?=$row[P_NUM]?></li>
					</ul>
					<div class="clr"></div>
				</td>
				<td><?=getFormatPrice($row[P_SALE_PRICE],2)?></td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<div class="paginate mt20">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goProdAllInsert();"><strong><?=$LNG_TRANS_CHAR["PW00130"] //상품별적용?></strong></a>
	</div>
	<?}?>
</form>
</div>
</body>
</html>