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

	## 브랜드
	$aryProdBrandList		= $objProductListModule->getProductBrandListSelectEx("OP_ARYTOTAL",$param);

	## 메인진열관리 불러오기
	$param['IC_TYPE']		= "MAIN";
	$aryProdMainDisplayList = $objProductListModule->getProductDisplayListSelectEx("OP_ARYTOTAL",$param);

	## 서브진열관리 불러오기
	$param['IC_TYPE']		= "SUB";
	$aryProdSubDisplayList	= $objProductListModule->getProductDisplayListSelectEx("OP_ARYTOTAL",$param);

	
	## 입점사
	## 관리자 로그인, 영업사원, 관리 입점사가 있는 경우 관리 입점사만 출력한다.
	$aryShopList			= "";
	if($a_admin_type == "A" && $a_admin_tm == "Y" && $strAdminShopList):
		$aryShopList		= $strAdminShopList;
	endif;

	## 입점업체 리스트 
	$searchProdShopParam				= "";
	$searchProdShopParam['SHOP_LIST']	= $aryShopList;
	if($a_admin_type == "A" && $S_MALL_TYPE == "M"):
		$aryShopList		= $objProductListModule->getProductShopList("OP_ARYLIST",$searchProdShopParam);
	endif;

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
				var strDefaultValue = "<option =''>"+i+"<?=$LNG_TRANS_CHAR['PW00021']?></option>";
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
		data['searchCate1']					= $("select[name=searchCateHCode1]").myVal();
		data['searchCate2']					= $("select[name=searchCateHCode2]").myVal();
		data['searchCate3']					= $("select[name=searchCateHCode3]").myVal();
		data['searchCate4']					= $("select[name=searchCateHCode4]").myVal();
		data['searchLaunchStartDt']			= $("#searchLaunchStartDt").myVal();
		data['searchLaunchEndDt']			= $("#searchLaunchEndDt").myVal();
		data['searchRegStartDt']			= $("#searchRegStartDt").myVal();
		data['searchRegEndDt']				= $("#searchRegEndDt").myVal();
		data['searchBrand']					= $("select[name=searchBrand]").myVal();
		data['searchProductView']			= $(":radio[name=searchProductView]:checked").myVal();
		data['searchMainDisplay']			= $("input:checkbox[id=searchMainDisplay]:checked").myCheckVal();
		data['searchSubDisplay']			= $("input:checkbox[id=searchSubDisplay]:checked").myCheckVal();
		data['searchShop']					= $("select[name=searchShop]").myVal();
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
		<option value="memo"	<?if($strSearchField == "memo")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00047"] //메모?></option>
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
		<th><?=$LNG_TRANS_CHAR["PW00008"] //상품출시일?></th>
		<td  colspan="3">
			<input type="text" id="searchLaunchStartDt" value="<?=$_REQUEST['searchLaunchStartDt']?>" data-simple-datepicker readOnly style="width:80px"> -
			<input type="text" id="searchLaunchEndDt"   value="<?=$_REQUEST['searchLaunchEndDt']?>" data-simple-datepicker readOnly  style="width:80px">
			<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchLaunchStartDt','searchLaunchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]//오늘?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchLaunchStartDt','searchLaunchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]//1주일?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchLaunchStartDt','searchLaunchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]//15일?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchLaunchStartDt','searchLaunchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]//한달?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchLaunchStartDt','searchLaunchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]//두달?></strong></a>
			<a class="btn_sml" href="javascript:C_getSearchDay('A','<?=$strMode?>','','searchLaunchStartDt','searchLaunchEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00022"]//전체?></strong></a>
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
		<th><?=$LNG_TRANS_CHAR["PW00025"] //브랜?></th>
		<td  colspan="3">
			<select name="searchBrand" id="searchBrand" style="width:200px">
				<option value=""<?if($strSearchBrand == ""){ echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
				<?foreach($aryProdBrandList as $key => $data): ?>
				<option value="<?=$data['P_BRAND']?>"<?if($strSearchBrand == $data['P_BRAND']){ echo " selected";}?>><?=$data['P_BRAND_NAME']?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
		<td>
			<ul>
				<li>
					<input type="radio" id="searchProductView" name="searchProductView" value=""<?if($strSearchProdView == ""){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00022"]//전체?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webYes"<?if($strSearchProdView == "webYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00169"] //웹 사용?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webNo"<?if($strSearchProdView == "webNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00170"] //웹 사용안함?> 
				</li>
				<li>
					<input type="radio" id="searchProductView" name="searchProductView" value="mobileYes"<?if($strSearchProdView == "mobileYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00171"] //모바일 사용?>
					<input type="radio" id="searchProductView" name="searchProductView" value="mobileNo"<?if($strSearchProdView == "mobileNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00172"] //모바일 사용안함?>
				</li>
				<li>
					<input type="radio" id="searchProductView" name="searchProductView" value="webMobileYes"<?if($strSearchProdView == "webMobileYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00173"] //웹/모바일 사용?>
					<input type="radio" id="searchProductView" name="searchProductView" value="webMobileNo"<?if($strSearchProdView == "webMobileNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00174"] //웹/모바일 사용안함?>
				</li>
			</ul>
		</td>
	</tr>
	<?if(is_array($aryProdMainDisplayList)):?>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00027"] //메인 진열정보?></th>
		<td>
			<?foreach($aryProdMainDisplayList as $key => $data):
				if($data['IC_USE'] != "Y") { continue; }
				if(!$data['IC_NAME']) { continue; } ?>
				<input type="checkbox" id="searchMainDisplay" name="searchMainDisplay[]" value="<?=$data['IC_CODE']?>"<?if(in_array($data['IC_CODE'], $arrSearchProdMainDisplay)){echo "checked";}?>><?=$data['IC_NAME']?>
			<?endforeach;?>
		</td>
	</tr>
	<?endif;?>
	<?if(is_array($aryProdSubDisplayList)):?>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00028"] //서브 진열정보?></th>
		<td>
			<?foreach($aryProdSubDisplayList as $key => $data):
				if($data['IC_USE'] != "Y") { continue; }
				if(!$data['IC_NAME']) { continue; } ?>
				<input type="checkbox" id="searchSubDisplay" name="searchSubDisplay[]" value="<?=$data['IC_CODE']?>"<?if(in_array($data['IC_CODE'], $arrSearchProdSubnDisplay)){echo "checked";}?>><?=$data['IC_NAME']?>
			<?endforeach;?>
		</td>
	</tr>
	<?endif;?>
	<?if($a_admin_type == "A" && $S_MALL_TYPE == "M"):?>
	<tr>
		<th>입점사</th>
		<td>
			<select name="searchShop" id="searchShop" style="width:200px">
				<option value=""<?if($_REQUEST["searchShop"] == ""){ echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
				<?foreach($aryShopList as $key => $data): ?>
				<option value="<?=$key?>"<?if($strSearchShop == "{$key}"){ echo " selected";}?>><?=$data?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<?endif;?>
	<tr>
		<td colspan="2" style="text-align:center">
			<a class="btn_blue_big" href="javascript:goSearch();" style="width:400px;text-align:center"><strong><?=$LNG_TRANS_CHAR["CW00027"]//검색?></strong></a>
			<a class="btn_big" href="./?menuType=product&mode=<?=$strMode?>&lang=<?=$strStLng?>"><strong><?=$LNG_TRANS_CHAR["CW00085"]//초기화?></strong></a>
		</td>
	</tr>
</table>


