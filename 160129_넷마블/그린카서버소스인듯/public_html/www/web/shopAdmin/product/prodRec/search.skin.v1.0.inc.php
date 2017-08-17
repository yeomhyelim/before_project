<script type="text/javascript">
<!--

	$(document).ready(function(){

		callCateList(1,"","","searchCateHCode1","<?=$strSearchHCode1?>");
	
		<?if ($strSearchHCode1){?>
		callCateList(2,"<?=$strSearchHCode1?>","","searchCateHCode2","<?=$strSearchHCode2?>");
		<?}?>
		<?if ($strSearchHCode2){?>
		callCateList(3,"<?=$strSearchHCode1.$strSearchHCode2?>","","searchCateHCode3","<?=$strSearchHCode3?>");
		<?}?>
		<?if ($strSearchHCode3){?>
		callCateList(4,"<?=$strSearchHCode1.$strSearchHCode2.$strSearchHCode3?>","","searchCateHCode4","<?=$strSearchHCode4?>");
		<?}?>

		var strHCode = "";
		$("#searchCateHCode1").change(function() {			
			if ($(this).val())
			{
				callCateList(2,$(this).val(),"","searchCateHCode2","");
			}
		});

		$("#searchCateHCode2").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$(this).val();
				callCateList(3,strHCode,"","searchCateHCode3","");
			}
		});

		$("#searchCateHCode3").change(function() {			
			if ($(this).val())
			{
				strHCode = $("#searchCateHCode1 option:selected").val()+$("#searchCateHCode2 option:selected").val()+$(this).val();
				callCateList(4,strHCode,"","searchCateHCode4","");
			}
		});
	});

	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strStLng?>";
		
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

	function goSearch(order){
		var data							= new Array(20);
		data['searchField']					= $("#searchField").myVal();
		data['searchKey']					= $("#searchKey").myVal();
		data['searchCateHCode1']			= $("select[name=searchCateHCode1]").myVal();
		data['searchCateHCode2']			= $("select[name=searchCateHCode2]").myVal();
		data['searchCateHCode3']			= $("select[name=searchCateHCode3]").myVal();
		data['searchCateHCode4']			= $("select[name=searchCateHCode4]").myVal();
		data['searchWebView']				= $("input:checkbox[id=searchWebView]:checked").myCheckVal();
		data['searchMobileView']			= $("input:checkbox[id=searchMobileView]:checked").myCheckVal();

		$("input:checkbox[id^=searchIcon]").each(function(i){
			var objIconId		= $(this).attr("id");
			data[objIconId]		= "";
			if($(this).is(":checked")){
				data[objIconId]	= $(this).val();
			}
		});

		data['page']						= 1;
		data['pageLine']					= ($("select[name=pageLine]").val()) ? $("select[name=pageLine]").val() : 50;
		data['order']						= (!C_isNull(order)) ? order : "";
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
			<select name="searchField" id="searchField">
				<option value="N" <?=($strSearchField=="N")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00002"] //상품명?></option>
				<option value="C" <?=($strSearchField=="C")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00003"] //상품코드?></option>
				<option value="M" <?=($strSearchField=="M")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00004"] //제조사?></option>
				<option value="O" <?=($strSearchField=="O")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00005"] //원산지?></option>
				<option value="D" <?=($strSearchField=="D")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" <?=$nBox?> value="<?=$strSearchKey?>"/>
			<a class="btn_blue_big" href="javascript:goSearch('prodRecList');"><strong><?=$LNG_TRANS_CHAR["CW00027"] //검색?></strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00027"] //카테고리선택?></th>
				<td>
					<select id="searchCateHCode1" name="searchCateHCode1">
						<option value=""><?=$LNG_TRANS_CHAR["PW00013"] //1차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode2" name="searchCateHCode2" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00014"] //2차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode3" name="searchCateHCode3" >
						<option value=""><?=$LNG_TRANS_CHAR["PW00015"] //3차 카테고리 선택?></option>
					</select>
					<select id="searchCateHCode4" name="searchCateHCode4">
						<option value=""><?=$LNG_TRANS_CHAR["PW00016"] //4차 카테고리 선택?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력여부?></th>
				<td>
					<input type="checkbox" id="searchWebView" name="searchWebView" value="Y" <?=($strSearchWebView=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00011"] //웹사용?>
					<input type="checkbox" id="searchMobileView" name="searchMobileView" value="Y" <?=($strSearchMobileView=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00012"] //웹사용안함?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00027"] //메인 진열정보?></th>
				<td>
					<?for($i=0;$i<sizeof($aryProdMainDisplayList);$i++){
						if ($aryProdMainDisplayList[$i][IC_USE] == "Y"){
							$strSearchIconName = "searchIcon".($i+1);
							$strSearchIconChecked = (${"strSearchIcon".($i+1)} == "Y") ? "checked":""; 
						?>
						<input type="checkbox" id="<?=$strSearchIconName?>" name="<?=$strSearchIconName?>" value="Y" <?=$strSearchIconChecked?>><?=$aryProdMainDisplayList[$i][IC_NAME]?>
					<?}}?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00028"] //서브 진열정보?></th>
				<td>
					<?for($i=0;$i<sizeof($aryProdSubDisplayList);$i++){
						if ($aryProdSubDisplayList[$i][IC_USE] == "Y"){
							$strSearchIconName = "searchIcon".($i+6);
							$strSearchIconChecked = (${"strSearchIcon".($i+6)} == "Y") ? "checked":""; 
						?>
						<input type="checkbox" id="<?=$strSearchIconName?>" name="<?=$strSearchIconName?>" value="Y" <?=$strSearchIconChecked?>><?=$aryProdSubDisplayList[$i][IC_NAME]?>
					<?}}?>
				</td>
			</tr>
		</table>