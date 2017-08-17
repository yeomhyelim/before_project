<?
	## 국가 설정
	$strLeng				= $_GET['leng'];		
	
	## 국가 설정 체크
	if(!$strLeng):
		$strLeng			= $S_SITE_LNG;			
	endif;

	## 기본설정
	$strLengLower			= strtolower($strLeng);
	$categoryFile			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/category.{$strLengLower}.inc.php";

	## 기본설정 체크
	if(!is_file($categoryFile)):
		echo "설정된 카테고리가 없습니다.";
		exit;	
	endif;

	## 가테고리 불러오기
	require_once $categoryFile;
	
?>

<? include "./include/header.inc.php"?>

<link rel="stylesheet" href="./common/css/jquery.treeview.css" />
<script src="../common/js/jquery.treeview.js"></script>

<script type="text/javascript">
<!--
	var G_PHP_SELF		= "./";

	$(document).ready(function(){
		$("#skinList").treeview({
			collapsed		: true,
			animated		: "medium",
			control			:"#sidetreecontrol",
			persist			: "location"
		});

		var obj = parent.getProdRelatedList();
		if(obj){
			var len				= obj.length;
			var code			= $("#prodListSampleCode").val();
			var area			= $("#proChooseArea");
			for(var i=0; i<len; i++) {
				var p_code		= "p_code_" + obj[i].P_CODE;
				$(area).append(code).find("dl:last").attr("id", p_code);
				$("#"+p_code).find("#prodSelect").val(obj[i].P_CODE);
				$("#"+p_code).find("#pm_real_name").attr("src", obj[i].PM_REAL_NAME);
				$("#"+p_code).find("#p_code").text(obj[i].P_CODE);
				$("#"+p_code).find("#p_brand").text(obj[i].P_BRAND);
				$("#"+p_code).find("#p_name").text(obj[i].P_NAME);
				$("#"+p_code).find("#p_sale_price").text(obj[i].P_SALE_PRICE);	
			}
		}

		$("#prodListAllSelect").change( function() {
			if($("#prodListAllSelect").attr("checked") == "checked") {
				$("#prodListArea").find("input[name=prodSelect]").each( function() {
					$(this).attr("checked", true);
				});
			} else {
				$("#prodListArea").find("input[name=prodSelect]").each( function() {
					$(this).attr("checked", false);
				})
			}
		});

	});
	
	function goProdList(lcate, mcate, scate, fcate) {
		var doc = document.form;
		doc.lcate.value			= lcate;
		doc.mcate.value			= mcate;
		doc.scate.value			= scate;
		doc.fcate.value			= fcate;

//		goAct("popProdList");
//		C_getJsonTest("popProdList", G_PHP_SELF);
//		C_getJsonTest("popProdList", G_PHP_SELF);
//		goJson("popProdList", "goProdListCallBack");
	}

	function goProdListSearch() {
		var strAppID = "PRODUCT_RELATED";
		var strSearchKey = $("#searchKey").val();
		var strStyle = G_APP_PARAM[strAppID]['STYLE'];
		var objTarget = $("#" + strAppID).find('.'+strStyle);
		G_APP_PARAM[strAppID]['SEARCH_KEY'] = strSearchKey;
		objTarget.html("");
		goProductListRelatedSkinListMoveEvent(strAppID);
	}

	function goProdListCallBack(obj) {
		if(obj.mode == 1){
			var len				= obj.data.length;
			var code			= $("#prodListSampleCode").val();
			var area			= $("#prodListArea");
			$(area).empty();
			for(var i=0; i<len; i++) {
				var p_code		= "p_code_" + obj.data[i].P_CODE;
				$(area).append(code).find("dl:last").attr("id", p_code);
				$("#"+p_code).find("#prodSelect").val(obj.data[i].P_CODE);
				$("#"+p_code).find("#pm_real_name").attr("src", obj.data[i].PM_REAL_NAME);
				$("#"+p_code).find("#p_code").text(obj.data[i].P_CODE);
				if(obj.data[i].P_BRAND_NAME){ $("#"+p_code).find("#p_brand").text(obj.data[i].P_BRAND_NAME); }
				else{ $("#"+p_code).find("#p_brand").remove(); }
				$("#"+p_code).find("#p_name").text(obj.data[i].P_NAME);
				$("#"+p_code).find("#p_sale_price").text(obj.data[i].P_SALE_PRICE);
			}
		}
	}

	function goProdInsert() {
		var area			= $("#prodListArea");
		var areaChoose		= $("#proChooseArea");
		var parentArray		= new Object();

		$(area).find("#prodSelect").each( function() { 
			if($(this).attr("checked") == "checked") {
				var p_code			= "p_code_" + $(this).val();
				var useCheck		= $(areaChoose).find("dl").is("#"+p_code);
				var code			= $(area).find("#"+p_code).clone();
				if(!useCheck){
					parentArray['P_CODE']				= $(this).val();
					parentArray['PM_REAL_NAME']			= code.find("#pm_real_name").attr("src");
					parentArray['P_BRAND']				= $("#p_brand").text();
					parentArray['P_NAME']				= $("#p_name").text();
					parentArray['P_SALE_PRICE']			= $("#p_sale_price").text();

					code.find("#prodSelect").attr("checked", false);
					$(areaChoose).append(code);
					parent.goProdRelatedCallback(parentArray);
				}
			}
		});
	}

	function gpProdListChooseDelete() {
		$("#proChooseArea").find("#prodSelect").each( function() {
			if($(this).attr("checked") == "checked"){
				var p_code = $(this).val();
				$(this).parent().parent().remove();			
				parent.getProdRelatedDelete(p_code);
			}
		});
	}

	function goProdListChooseAllDelete() {
		$("#proChooseArea").find("#prodSelect").each( function() {
			var p_code = $(this).val();
			$(this).parent().parent().remove();			
			parent.getProdRelatedDelete(p_code);
		});
	}

//-->
</script>
<form name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="jsonMode" value="">
<input type="hidden" name="cateLng"	value="<?=$strLeng?>">
<input type="hidden" name="lcate" value="">
<input type="hidden" name="mcate" value="">
<input type="hidden" name="scate" value="">
<input type="hidden" name="fcate" value="">
<input type="hidden" name="searchField" id="searchField" value="N" />
  <div class="popTop">
	   <h2>관련상품 관리</h2>   
	   <a  href="javascript:parent.TINY.box.hide()"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
	   <div class="clear"></div>
  </div>

<div class="popRelatedWrap">
		<table>
			<tr>
				<td>
					<div class="prodSearch">
						<input type="text" id="searchKey" data-enter-event="goProdListSearch" /> <a href="javascript:goProdListSearch()" class="btn_sml"><span>검색</span></a>
					</div>
				</td>
				<td>
					<div class="prodSearch">
						<!--input type="checkbox" name="prodListAllSelect" id="prodListAllSelect"/--> <a href="javascript:goProdInsert()" class="btn_blue_sml"><strong>선택한 항목등록</strong></a>
					</div>
					<div id="prodListArea" class="prodListWrap" style="height:433px">					
					<?php	
					$EUMSHOP_APP_INFO = "";
					$EUMSHOP_APP_INFO['name'] = "관련상품 리스트";
					$EUMSHOP_APP_INFO['appID'] = "PRODUCT_RELATED";
					$EUMSHOP_APP_INFO['mode'] = "productList";
					$EUMSHOP_APP_INFO['skin'] = "relatedSkin";
					$EUMSHOP_APP_INFO['pageLine'] = "4";
					$EUMSHOP_APP_INFO['linkType'] = "self";
					$EUMSHOP_APP_INFO['lang'] = $strStLng;
					$EUMSHOP_APP_INFO['mouseHoverEvent'] = "N";
					include "{$S_DOCUMENT_ROOT}www/web/app/index.php"
					?>		
					</div>
				</td>
				<td>
					<div class="prodSearch">
						<a href="javascript:gpProdListChooseDelete()" class="btn_sml"><span>선택항목 삭제</span></a> 
						<a href="javascript:goProdListChooseAllDelete()" class="btn_sml"><span>전체삭제</span></a>
						<a href="javascript:parent.TINY.box.hide()" class="btn_sml"><span>닫기</span></a>
					</div>
					<div id="proChooseArea" class="prodListWrap" style="height:420px"></div>
				</td>
			</tr>
		</table>
	</div>
</form>

<!-- prodListArea Form -->
<textarea id="prodListSampleCode" style="display:none">
	<dl id="" class="prodlist">
		<dt>
			<input type="checkbox" name="prodSelect" id="prodSelect" value=""/>
			<img id="pm_real_name" src="" style="width:70px;height:70px">
		</dt>
		<dd id="p_code"></dd>
		<dd id="p_brand"></dd>
		<dd id="p_name"></dd>
		<dd id="p_sale_price"></dd>
	</dl>
</textarea>
<!-- prodListArea Form -->

<? include "./include/footer.inc.php"?>