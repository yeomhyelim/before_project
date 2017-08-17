<?

	## 검색 카테고리		
	$strStLngLower			= strtolower($strStLng);	
	include_once SHOP_HOME."/conf/category.{$strStLngLower}.inc.php";
	
	$strSearchProdCateKey1			= "";
	$strSearchProdCateKey2			= "";
	$strSearchProdCateKey3			= "";
	$strSearchProdCateKey4			= "";
	
	$strSearchProdCateOptionList1	 = "";
	$strSearchProdCateOptionList2	= "";
	$strSearchProdCateOptionList3	= "";
	$strSearchProdCateOptionList4	= "";

	$strSearchProdCate1				= $_REQUEST['searchCateHCode1'];
	$strSearchProdCate2				= $_REQUEST['searchCateHCode2'];
	$strSearchProdCate3				= $_REQUEST['searchCateHCode3'];
	$strSearchProdCate4				= $_REQUEST['searchCateHCode4'];
	
	foreach($S_ARY_CATE1 as $cateKey1 => $cateData1){
		$strSearchProdCateCodeSelected = "";
		if ($cateData1['CODE'] == $strSearchProdCate1) {
			$strSearchProdCateKey1			= $cateKey1;
			$strSearchProdCateCodeSelected	= "selected";
		}
		$strSearchProdCateOptionList1 .= "<option value='{$cateData1['CODE']}' {$strSearchProdCateCodeSelected}>{$cateData1['NAME']}</option>";	
	}

	## 2차 카테고리
	if ($strSearchProdCate1 && $strSearchProdCateKey1 >=0){
		foreach($S_ARY_CATE2[$strSearchProdCateKey1] as $cateKey2 => $cateData2){
			$strSearchProdCateCodeSelected = "";
			if ($cateData2['CODE'] == $strSearchProdCate2) {
				$strSearchProdCateKey2			= $cateKey2;
				$strSearchProdCateCodeSelected	= "selected";
			}
			$strSearchProdCateOptionList2 .= "<option value='{$cateData2['CODE']}' {$strSearchProdCateCodeSelected}>{$cateData2['NAME']}</option>";
		}
	}

	## 3차 카테고리
	if ($strSearchProdCate2 && $strSearchProdCateKey2 >=0){
		foreach($S_ARY_CATE3[$strSearchProdCateKey1][$strSearchProdCateKey2] as $cateKey3 => $cateData3){
			$strSearchProdCateCodeSelected = "";
			if ($cateData3['CODE'] == $strSearchProdCate3) {
				$strSearchProdCateKey3			= $cateKey3;
				$strSearchProdCateCodeSelected	= "selected";
			}
			$strSearchProdCateOptionList3 .= "<option value='{$cateData3['CODE']}' {$strSearchProdCateCodeSelected}>{$cateData3['NAME']}</option>";
		}
	}

	## 4차 카테고리
	if ($strSearchProdCate3 && $strSearchProdCateKey3 >=0){
		foreach($S_ARY_CATE4[$strSearchProdCateKey1][$strSearchProdCateKey2][$strSearchProdCateKey3] as $cateKey4 => $cateData4){
			$strSearchProdCateCodeSelected = "";
			if ($cateData4['CODE'] == $strSearchProdCate4) {
				$strSearchProdCateKey4			= $cateKey4;
				$strSearchProdCateCodeSelected	= "selected";
			}
			$strSearchProdCateOptionList4 .= "<option value='{$cateData4['CODE']}' {$strSearchProdCateCodeSelected}>{$cateData4['NAME']}</option>";
		}
	}

?>
<script type="text/javascript">
<!--

	$(document).ready(function(){

		/** 백업후 삭제 **/
		$("select[id^=searchCateHCode]").each(function(index) {
			if(index <= 3) {
				$(this).change(function() {
					var no = $(this).attr("no");
					productCateMake(no);
				});
			}
		});
	});

	function productCateMake(no){
		var no			= Number(no);
		var code		= $("select[id=searchCateHCode"+no+"][no="+no+"]").val();
		var nextObj		= $("select[id=searchCateHCode"+(no+1)+"][no="+(no+1)+"]");
		
		for(var i=2;i<=4;i++){
			if (i >= (no+1))
			{
				var strDefaultValue = "<option value=''>"+i+"<?=$LNG_TRANS_CHAR['PW00021']?></option>";
				$("select[id=searchCateHCode"+i+"][no="+i+"]").find("option").remove();
				$("select[id=searchCateHCode"+i+"][no="+i+"]").append(strDefaultValue);
			}
		}

		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+(no+1)+"&cateHCode="+code;
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"html", 
			success:function(data){	
				nextObj.find("option").remove();
				nextObj.append(data);	
			}
		});
	}
	
	function goSearchDataSet(data)
	{
		data['searchField']					= $("#searchField").myVal();
		data['searchKey']					= $("#searchKey").myVal();
		data['searchCateHCode1']			= $("select[name=searchCateHCode1]").myVal();
		data['searchCateHCode2']			= $("select[name=searchCateHCode2]").myVal();
		data['searchCateHCode3']			= $("select[name=searchCateHCode3]").myVal();
		data['searchCateHCode4']			= $("select[name=searchCateHCode4]").myVal();
		data['searchWebView']				= $(":radio[name=searchWebView]:checked").myVal();

		data['pageLine']					= ($("select[name=pageLine]").val()) ? $("select[name=pageLine]").val() : 50;
		
		return data;
	}

	function goSearch(){
		var data							= new Array(20);
		data								= goSearchDataSet(data);
		data['page']						= 1;
	
//		alert(data['searchProductView']);
		C_getAddLocationUrl(data);	
	}

	$.fn.myVal = function() {
		if($(this).length <= 0) { return ""; }
		return $(this).val();
	}

	$.fn.myCheckVal = function() {
		var data = "";
		$(this).each(function() {
			if(data) { data = data + ","; }
			data = data + $(this).myVal();
		});
		return data;
	}
//-->
</script>
<div class="searchFormWrap">
	<select id="searchField" style="width:133px">
		<option value=""		<?if($strSearchField == "")			{echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
		<option value="name"	<?if($strSearchField == "name")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
		<option value="code"	<?if($strSearchField == "code")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>/<?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
		<option value="maker"	<?if($strSearchField == "maker")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
		<option value="orgin"	<?if($strSearchField == "orgin")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
		<option value="model"	<?if($strSearchField == "model")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
		<option value="search"	<?if($strSearchField == "search")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00167"] //검색어?></option>
	</select>
	<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" data-auto-focus/>
</div>
<table>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?></th>
		<td  colspan="3">
			<select id="searchCateHCode1" no="1" name="searchCateHCode1">
				<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
				<?=$strSearchProdCateOptionList1?>
			</select>
			<select id="searchCateHCode2" no="2" name="searchCateHCode2" >
				<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
				<?=$strSearchProdCateOptionList2?>
			</select>
			<select id="searchCateHCode3" no="3" name="searchCateHCode3" >
				<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
				<?=$strSearchProdCateOptionList3?>
			</select>
			<select id="searchCateHCode4" no="4" name="searchCateHCode4">
				<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
				<?=$strSearchProdCateOptionList4?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
		<td>
			<input type="radio" id="searchWebView" name="searchWebView" value="A"<?if($strSearchWebView == "A" || !$strSearchWebView){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00022"]//전체?>
			<input type="radio" id="searchWebView" name="searchWebView" value="Y"<?if($strSearchWebView == "Y"){echo " checked";}?>><?=$LNG_TRANS_CHAR["CW00010"] //보임?>
			<input type="radio" id="searchWebView" name="searchWebView" value="N"<?if($strSearchWebView == "N"){echo " checked";}?>><?=$LNG_TRANS_CHAR["CW00011"] //안보임?>
		</td>
	</tr>
	<tr>
		<td colspan="2" style="text-align:center">
			<a class="btn_search" href="javascript:goSearch();" style="width:400px;text-align:center"><strong class="ico_search"><?=$LNG_TRANS_CHAR["CW00027"]//검색?></strong></a>
			<a class="btn_big_reset" href="./?menuType=product&mode=<?=$strMode?>&lang=<?=$strStLng?>"><strong><?=$LNG_TRANS_CHAR["CW00085"]//초기화?></strong></a>
		</td>
	</tr>
</table>


