<?
		## 기본 설정
		$strAdminType		= $_SESSION['ADMIN_TYPE'];
		$strAdminTm			= $_SESSION['ADMIN_TM'];
		$strAdminShopList	= $_SESSION['ADMIN_SHOP_LIST'];

		## 언어 설정
		$lang				= strtolower($strStLng);

		## 카테고리 불러오기
		$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/category.{$lang}.inc.php";
		include_once $fileName;

		## 브랜드
		$productMgr->setPageLine("");
		$productMgr->setLimitFirst("");
		$aryProdBrandList = $productMgr->getProdBrandList($db, "OP_ARYTOTAL");

		## 메인진열관리 불러오기
		$cateMgr->setIC_TYPE("MAIN");
		$aryProdMainDisplayList = $cateMgr->getProdDisplayList($db);

		## 서브진열관리 불러오기
		$cateMgr->setIC_TYPE("SUB");
		$aryProdSubDisplayList = $cateMgr->getProdDisplayList($db);

		## 메인진열관리 사용 유무
		$bProdMainDisplayUse		= false;
		foreach($aryProdMainDisplayList as $key => $data):
			if($data['IC_USE'] != "Y") { continue; }
			if(!$data['IC_NAME']) { continue; }
			$bProdMainDisplayUse	= true;
			break;
		endforeach;

		## 서브진열관리 사용 유무
		$bProdSubDisplayUse		= false;
		foreach($aryProdSubDisplayList as $key => $data):
			if($data['IC_USE'] != "Y") { continue; }
			if(!$data['IC_NAME']) { continue; }
			$bProdSubDisplayUse	= true;
			break;
		endforeach;

		## 메인진열관리 현재 선택된 값.
		if($_REQUEST['searchMainDisplay']):
			$arySearchMainDisplay = explode(",", $_REQUEST['searchMainDisplay']);
		endif;

		## 서브진열관리 현재 선택된 값.
		if($_REQUEST['searchSubDisplay']):
			$arySearchSubDisplay = explode(",", $_REQUEST['searchSubDisplay']);
		endif;

		## 입점사 사용 유무
		$bShopUse				= false;
		if($a_admin_type == "A" && $S_MALL_TYPE == "M"):
			$bShopUse			= true;
		endif;

		## 관리자 로그인, 영업사원, 관리 입점사가 있는 경우 관리 입점사만 출력한다.
		$aryShopList						= "";
		if($strAdminType == "A" && $strAdminTm == "Y" && $strAdminShopList):
			$aryShopList					= $strAdminShopList;
		endif;

		## 입점업체 리스트
		$param								= "";
		$param['SHOP_LIST']					= $aryShopList;
		if($bShopUse):
			$aryShopList					= $productMgr->getShopList($db,$param);
		endif;

//		if ($a_admin_type == "A" && $S_MALL_TYPE == "M"){
//			if ($ADMIN_SHOP_SELECT_USE == "Y"){
//				if ($a_admin_tm == "Y") {
//					if ($a_admin_shop_list){
//						$param["SHOP_LIST"] = $a_admin_shop_list;
//					}
//				}
//			}
//
//			if ($a_admin_level == "0" || ($a_admin_level > 0 && $a_admin_shop_list)) {
//				$aryShopList = $productMgr->getShopList($db,$param);
//			}
//		}
?>
<script type="text/javascript">
<!--

	var productCate = new Array(4);
	$(document).ready(function(){

		/** 백업후 삭제 **/
		var defaultValue			= new Array(4);
		$("select[id=searchCate]").each(function(index) {
			productCate[index+1]	= $(this).find("option");
			defaultValue[index+1]	= $(this).val();
			if(index <= 3) {
				$(this).change(function() {
					var no = $(this).attr("no");
					productCateMake(no);
				});
			}
		});

		for(var no in defaultValue){
			$("select[id=searchCate][no="+no+"]").val(defaultValue[no]);
			productCateMake(no);
		}
	});

	function productCateMake(no){
		no			= Number(no);
		var code	= $("select[id=searchCate][no="+no+"]").val();
		var length	= 0;
		if(code) { length = code.length; }

		for(var i=(no+1);i<=4;i++){
			$("select[id=searchCate][no="+i+"]").find("option").remove();
			$("select[id=searchCate][no="+i+"]").append(productCate[i].eq(0));
		}
		$(productCate[no+1]).each(function() {
			if(length == 0 || code == $(this).val().substr(0,length)){
				$("select[id=searchCate][no="+(no+1)+"]").append($(this));
			}
			$("select[id=searchCate][no="+(no+1)+"]").val("");
		});
	}

	function goSearchDataSet(data)
	{
		data['searchField']					= $("#searchField").myVal();
		data['searchKey']					= $("#searchKey").myVal();
		data['searchCate1']					= $("select[name=searchCate1]").myVal();
		data['searchCate2']					= $("select[name=searchCate2]").myVal();
		data['searchCate3']					= $("select[name=searchCate3]").myVal();
		data['searchCate4']					= $("select[name=searchCate4]").myVal();
		data['searchLaunchStartDt']			= $("#searchLaunchStartDt").myVal();
		data['searchLaunchEndDt']			= $("#searchLaunchEndDt").myVal();
		data['searchRegStartDt']			= $("#searchRegStartDt").myVal();
		data['searchRegEndDt']				= $("#searchRegEndDt").myVal();
		data['searchBrand']					= $("select[name=searchBrand]").myVal();
//		data['searchWebView']				= $("#searchWebView:checked").myVal();
//		data['searchMobileView']			= $("#searchMobileView:checked").myVal();
		data['searchProductView']			= $(":radio[name=searchProductView]:checked").myVal();
		data['searchMainDisplay']			= $("input:checkbox[id=searchMainDisplay]:checked").myCheckVal();
		data['searchSubDisplay']			= $("input:checkbox[id=searchSubDisplay]:checked").myCheckVal();
		data['searchShop']					= $("select[name=searchShop]").myVal();
		data['pageLine']					= ($("select[name=pageLine]").val()) ? $("select[name=pageLine]").val() : 50;

		return data;
	}

	function goSearch(){
		var data							= new Object();

		data								= goSearchDataSet(data);
		data['page']						= 1;

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
		<option value="brand"	<?if($strSearchField == "brand")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00006"] //모델명?></option>
		<option value="search"	<?if($strSearchField == "search")	{echo " selected";}?>><?=$LNG_TRANS_CHAR["PW00167"] //검색어?></option>
		<option value="memo"	<?if($strSearchField == "memo")		{echo " selected";}?>><?=$LNG_TRANS_CHAR["OW00047"] //메모?></option>
	</select>
	<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?> data-enter-event="goSearch" data-auto-focus/>
</div>
<table>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00021"] //카테고리?></th>
		<td  colspan="3">
			<?for($i=1;$i<=4;$i++):?>
			<select name="searchCate<?=$i?>" id="searchCate" no="<?=$i?>" style="width:100px">
				<option value=""<?if($_REQUEST["searchCate{$i}"] == ""){ echo " selected";}?>><?=$i?> <?=$LNG_TRANS_CHAR["PW00021"] // 카테고리?></option>
				<?foreach($S_ARY_CATE_NAME as $code => $data):
					if(strlen($code) != (3*$i)) { continue; } ?>
				<option value="<?=$code?>"<?if($_REQUEST["searchCate{$i}"] == $code){ echo " selected";}?>><?=$data['CATE_NM']?></option>
				<?endforeach;?>
			</select>
			<?endfor;?>
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
				<option value=""<?if($_REQUEST["searchBrand"] == ""){ echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
				<?foreach($aryProdBrandList as $key => $data): ?>
				<option value="<?=$data['PR_NO']?>"<?if($_REQUEST["searchBrand"] == $data['PR_NO']){ echo " selected";}?>><?=$data['PR_NAME']?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00010"] //상품출력?></th>
		<td>
			<input type="radio" id="searchProductView" name="searchProductView" value=""<?if($_REQUEST['searchProductView'] == ""){echo " checked";}?>> <?=$LNG_TRANS_CHAR["CW00022"]//전체?>
			<input type="radio" id="searchProductView" name="searchProductView" value="webYes"<?if($_REQUEST['searchProductView'] == "webYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00169"] //웹 사용?>
			<input type="radio" id="searchProductView" name="searchProductView" value="webNo"<?if($_REQUEST['searchProductView'] == "webNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00170"] //웹 사용안함?>
			<input type="radio" id="searchProductView" name="searchProductView" value="mobileYes"<?if($_REQUEST['searchProductView'] == "mobileYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00171"] //모바일 사용?>
			<input type="radio" id="searchProductView" name="searchProductView" value="mobileNo"<?if($_REQUEST['searchProductView'] == "mobileNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00172"] //모바일 사용안함?> <br>
			<input type="radio" id="searchProductView" name="searchProductView" value="webMobileYes"<?if($_REQUEST['searchProductView'] == "webMobileYes"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00173"] //웹/모바일 사용?>
			<input type="radio" id="searchProductView" name="searchProductView" value="webMobileNo"<?if($_REQUEST['searchProductView'] == "webMobileNo"){echo " checked";}?>> <?=$LNG_TRANS_CHAR["PW00174"] //웹/모바일 사용안함?>
		</td>
	</tr>
	<?if($bProdMainDisplayUse):?>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00027"] //메인 진열정보?></th>
		<td>
			<?foreach($aryProdMainDisplayList as $key => $data):
				if($data['IC_USE'] != "Y") { continue; }
				if(!$data['IC_NAME']) { continue; } ?>
				<input type="checkbox" id="searchMainDisplay" name="searchMainDisplay[]" value="<?=$data['IC_CODE']?>"<?if(in_array($data['IC_CODE'], $arySearchMainDisplay)){echo "checked";}?>><?=$data['IC_NAME']?>
			<?endforeach;?>
		</td>
	</tr>
	<?endif;?>
	<?if($bProdSubDisplayUse):?>
	<tr>
		<th><?=$LNG_TRANS_CHAR["PW00028"] //서브 진열정보?></th>
		<td>
			<?foreach($aryProdSubDisplayList as $key => $data):
				if($data['IC_USE'] != "Y") { continue; }
				if(!$data['IC_NAME']) { continue; } ?>
				<input type="checkbox" id="searchSubDisplay" name="searchSubDisplay[]" value="<?=$data['IC_CODE']?>"<?if(in_array($data['IC_CODE'], $arySearchSubDisplay)){echo "checked";}?>><?=$data['IC_NAME']?>
			<?endforeach;?>
		</td>
	</tr>
	<?endif;?>
	<?if($bShopUse):?>
	<tr>
		<th><?=$LNG_TRANS_CHAR["SW00080"]//입점사?></th>
		<td>
			<select name="searchShop" id="searchShop" style="width:200px">
				<option value=""<?if($_REQUEST["searchShop"] == ""){ echo " selected";}?>><?=$LNG_TRANS_CHAR["CW00022"]//전체?></option>
				<?foreach($aryShopList as $key => $data): ?>
				<option value="<?=$key?>"<?if($_REQUEST["searchShop"] == "{$key}"){ echo " selected";}?>><?=$data?></option>
				<?endforeach;?>
			</select>
		</td>
	</tr>
	<?endif;?>
	<tr>
		<td colspan="2" style="text-align:center">
			<a class="btn_search" href="javascript:goSearch();" style="width:400px;text-align:center"><strong class="ico_search"><?=$LNG_TRANS_CHAR["CW00027"]//검색?></strong></a>
			<a class="btn_big_reset" href="./?menuType=product&mode=<?=$strMode?>&lang=<?=$strStLng?>"><strong><?=$LNG_TRANS_CHAR["CW00085"]//초기화?></strong></a>
			<a href="javascript:goProdListExcelMoveEvent()" class="btn_excel_big"><strong><?=$LNG_TRANS_CHAR["PW00168"] //엑셀 다운로드?></strong></a>
		</td>
	</tr>
</table>


