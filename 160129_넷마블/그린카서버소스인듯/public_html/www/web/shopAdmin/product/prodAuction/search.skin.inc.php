<?
	## 검색 카테고리
	include_once SHOP_HOME."/conf/category.{$strStLngLower}.inc.php";
	
	$strSearchProdCateKey1	= "";
	$strSearchProdCateKey2	= "";
	$strSearchProdCateKey3	= "";
	$strSearchProdCateKey4			= "";
	
	$strSearchProdCateOptionList1 = "";
	$strSearchProdCateOptionList2 = "";
	$strSearchProdCateOptionList3 = "";
	$strSearchProdCateOptionList4 = "";
	
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

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();

		$('input[name=searchAucStartDt]').simpleDatepicker();
		$('input[name=searchAucEndDt]').simpleDatepicker();

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
		strJsonParam += "&cateLevel="+(no+1)+"&cateHCode="+code+"&version=2";
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
		data['searchCate1']					= $("select[name=searchCateHCode1]").myVal();
		data['searchCate2']					= $("select[name=searchCateHCode2]").myVal();
		data['searchCate3']					= $("select[name=searchCateHCode3]").myVal();
		data['searchCate4']					= $("select[name=searchCateHCode4]").myVal();
		data['searchAucStartDt']			= $("#searchAucStartDt").myVal();
		data['searchAucEndDt']				= $("#searchAucEndDt").myVal();
		data['searchRegStartDt']			= $("#searchRegStartDt").myVal();
		data['searchRegEndDt']				= $("#searchRegEndDt").myVal();
		data['searchProductView']			= $(":radio[name=searchProductView]:checked").myVal();
		data['searchAucStatus']				= $(":radio[name=searchAucStatus]:checked").myVal();
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
		<option value="all"		<?if($strSearchField == "all")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
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
		<th><?=$LNG_TRANS_CHAR["PW00009"] //상품등록일?></th>
		<td  colspan="3">
			<input type="text" id="searchRegStartDt" value="<?=$_REQUEST['searchRegStartDt']?>" data-simple-datepicker readOnly style="width:80px"> -
			<input type="text" id="searchRegEndDt"   value="<?=$_REQUEST['searchRegEndDt']?>" data-simple-datepicker readOnly  style="width:80px">
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]//오늘?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]//일주일?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]//15일?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]//한달?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]//두달?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]//전체?></strong></a>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00208"] //경매기간?></th>
		<td  colspan="3">
			<input type="text" id="searchAucStartDt" value="<?=$_REQUEST['searchAucStartDt']?>" data-simple-datepicker readOnly style="width:80px"> -
			<input type="text" id="searchAucEndDt"   value="<?=$_REQUEST['searchAucEndDt']?>" data-simple-datepicker readOnly  style="width:80px">
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchAucStartDt','searchAucEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]//오늘?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchAucStartDt','searchAucEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]//1주일?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchAucStartDt','searchAucEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]//15일?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchAucStartDt','searchAucEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]//한달?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchAucStartDt','searchAucEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]//두달?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchAucStartDt','searchAucEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]//전체?></strong></a>
		</td>
	</tr>	
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00211"] //경매상태?></th>
		<td  colspan="3">
			<input type="radio" id="searchAucStatus" name="searchAucStatus" value=""<?if($strSearchAucStatus == ""){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00022"]//전체?>
			<input type="radio"  value="1" name="searchAucStatus" id="searchAucStatus" <?=($strSearchAucStatus=="1")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00212"] //경매시작전?>
			<input type="radio"  value="2" name="searchAucStatus" id="searchAucStatus" <?=($strSearchAucStatus=="2")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00213"] //경매중?>
			<input type="radio"  value="3" name="searchAucStatus" id="searchAucStatus" <?=($strSearchAucStatus=="3")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00214"] //경매중지?>
			<input type="radio"  value="4" name="searchAucStatus" id="searchAucStatus" <?=($strSearchAucStatus=="4")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00215"] //경매완료?>
			<input type="radio"  value="5" name="searchAucStatus" id="searchAucStatus" <?=($strSearchAucStatus=="5")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00216"] //경매종료?>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
		<td>
			<ul>
				<li>
					<input type="radio" id="searchProductView" name="searchProductView" value=""<?if($strSearchProdView == ""){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00022"]//전체?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webYes"<?if($strSearchProdView == "webYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00010"] //웹 사용?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webNo"<?if($strSearchProdView == "webNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00011"] //웹 사용안함?> 
				</li>
			</ul>
		</td>
	</tr>

	
	<tr>
		<td colspan="2" style="text-align:center">
			<a class="btn_blue_big" href="javascript:goSearch();" style="width:400px;text-align:center"><strong><?=$LNG_TRANS_CHAR["CW00027"]//검색?></strong></a>
			<a class="btn_big" href="./?menuType=product&mode=<?=$strMode?>&lang=<?=$strStLng?>"><strong><?=$LNG_TRANS_CHAR["CW00085"]//초기화?></strong></a>
		</td>
	</tr>
</table>


