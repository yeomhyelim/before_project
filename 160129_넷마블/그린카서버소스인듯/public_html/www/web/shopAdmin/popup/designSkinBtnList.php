<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode		= $_POST["subPageCode"]	? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];	
	$strBtnCode			= $_POST["btnCode"]		? $_POST["btnCode"]		: $_REQUEST["btnCode"];	

	if ($strBtnCode){
		$designSetMgr->setDS_TYPE("SKIN_".SUBSTR($strSubPageCode,0,2));
		
		if ($strBtnCode == "T"){
			$designSetMgr->setDS_CODE("ZL_TOP_MENU");
			$strBtnCodeVal = $designSetMgr->getCodeVal($db);
		} else if ($strBtnCode == "C"){
		
			$designSetMgr->setDS_CODE("PL_SUB_CATE_DESIGN");
			$strBtnCodeVal = $designSetMgr->getCodeVal($db);			
		}

		if ($strBtnCodeVal) $strBtnCode = $strBtnCodeVal;
		
	} else {
		$designSetMgr->setDS_TYPE("SKIN");
		$designSetMgr->setDS_CODE("P_BTN");
		$strBtnCode = $designSetMgr->getCodeVal($db);
	}


?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getShopSkinBtnPageListHtml&im_code=<?=$strBtnCode?>&callback=?", function(data) {
			$("#designSkinList").html(data[0]["DESIGN_SKIN_LIST"]);
		});
	});

	var strNo = null;
	function changeLayoutType(no, strDsCode) {
		// 샘플 이미지 클릭시, 선택 표시
		strNo									= no;
		document.form.ds_code.value				= strDsCode;
		
		$("#designSkinList a").css( "border", "5px solid #fff" );
		$("#designSkinList a").hover ( function() {
			if( strNo != $(this).index() ) {
				$(this).css( "border"		, "5px solid #e5e5e5" );
			}
		}, function() {
			if( strNo != $(this).index() ) {
				$(this).css( "border"		, "5px solid #fff" );
			}
		} );
		$("#designSkinList a").eq(no).css("border", "5px solid #ff0000");		
	}

	<? // 기본 act.php 페이지로 이동 ?>
	function goAction(mode){	
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goDesignSelect()
	{
		parent.goSubCateDesignSubmit(document.form.ds_code.value);
		parent.goSelfClose();
	}

//-->
</script>
<form name="form" id="form">
<input type="hidden" name="menuType" value="layout">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
<input type="hidden" name="btnCode" value="<?=SUBSTR($strBtnCode,0,1)?>">
<input type="hidden" name="ds_code" value="">
	<div id="contentArea">
		<table style="width:100%;">
			<tr>
				<td class="contentWrap">
					<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
						<div id="designSkinList"  class="designListWrap">
							스킨리스트
						</div>
					</div>
					<?if ($strBtnCode == "C"){?>
					<div class="buttonWrap">
						<a class="btn_blue_big" href="javascript:goDesignSelect();"><strong>디자인선택</strong></a>
						<a class="btn_blue_big" href="javascript:parent.goSelfClose();"><strong>닫기</strong></a>
					</div>
					<?}else{?>
					<div class="buttonWrap">
						<a class="btn_blue_big" href="javascript:goAction('designSkinBtnModify');"><strong>디자인변경</strong></a>
						<a class="btn_blue_big" href="javascript:parent.goClose();"><strong>닫기</strong></a>
					</div>
					<?}?>
		
					<!-- ******************** contentsArea ********************** -->
				</td>
			</tr>
		</table>
	</div>
</form>
</body>
</html>