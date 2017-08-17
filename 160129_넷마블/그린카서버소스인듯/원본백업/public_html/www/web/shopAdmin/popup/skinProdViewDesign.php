<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode		= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];
	$strDS_CODE			= $_POST["ds_code"]			? $_POST["ds_code"]			: $_REQUEST["ds_code"];	
	$intBE_NO			= $_POST["be_no"]			? $_POST["be_no"]			: $_REQUEST["be_no"];	
	$intIC_CODE			= $_POST["ic_code"]			? $_POST["ic_code"]			: $_REQUEST["ic_code"];
	$strIC_TYPE			= $_POST["ic_type"]			? $_POST["ic_type"]			: $_REQUEST["ic_type"];

	$designSetMgr->setDS_TYPE("SKIN_PV");
	$designSetMgr->setDS_CODE("PV_IMAGE_DESIGN");
	$strDS_CODE = $designSetMgr->getCodeVal($db);

	$strDS_CODE			= ($strDS_CODE) ? $strDS_CODE : "PI0001";
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getShopSkinPageListHtml&ds_code=<?=$strDS_CODE?>&callback=?", function(data) {
			objData = data;
			$("#designSkinList").html(data[0]["DESIGN_SKIN_LIST"]);
			$("#choseDesign").html("<img src='" + objData[0]['DESIGN_IMG2_LIST']['<?=$strDS_CODE?>'] + "' style='width:400px'>");
			$("#designCommend").html(objData[0]['DESIGN_TEXT_LIST']['<?=$strDS_CODE?>']);
		});
	});

	var strNo = null;
	function changeLayoutType(no, strImCode) {
		// 샘플 이미지 클릭시, 선택 표시
		strNo									= no;
		document.form.ds_code.value				= strImCode;
		document.form.im_img2.value				= objData[0]['DESIGN_IMG2_LIST'][strImCode];
		
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
		$("#designSkinList a").eq(no).css("border", "5px solid #69cbfd");
		$("#choseDesign").html("<img src='" + objData[0]['DESIGN_IMG2_LIST'][strImCode] + "' style='width:400px'>");
		$("#designCommend").html(objData[0]['DESIGN_TEXT_LIST'][strImCode]);
	}

	<? // 기본 act.php 페이지로 이동 ?>
	function goAction(){	
		var doc = document.form;
		doc.menuType.value = "layout";
//		C_getAction("skinBestCodeModify","<?=$PHP_SELF?>");
//		return;

		doc.mode.value		= "act";
		doc.act.value		= "skinPordViewDesign";
		var formData		= $("#form").serialize();

		C_AjaxPost("designskinModify", "./index.php", formData, "post");
	}
	
	function goAjaxRet(name,result){
		if (name == "designskinModify") {			
			var data = eval(result);
			if (data[0].RET == "Y") {
				var ds_code		= $("input[name=ds_code]").val();
				var be_no		= $("input[name=be_no]").val();
//				parent.goBestChangeValueParentEvent(be_no,ds_code);
				alert(data[0].MSG);				
			}
		}
	}

	function goPageMove(mode) {
		var doc = document.form;
		doc.menuType.value = "popup";
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goClose()
	{
		parent.goClose();
	}
//-->
</script>
	<div class="layerPopWrap">
		<div class="popTop">
			<h2>상품리스트 디자인</h2>			
			<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
			<div class="clear"></div>
		</div>
		
		<div class="popBoxWrap">
		<!-- ******** 텝 메뉴 ********* -->
		<div class="adminTabBtnWrap mt10">
			<a href="javascript:goPageMove('skinProdViewImg')" >사이즈</a>
			<a href="javascript:goPageMove('skinProdViewImgMulty')" style="margin-left:200px">다중이미지</a>
			<a href="javascript:goPageMove('skinProdViewImgZoom')" style="margin-left:400px">팝업이미지뷰어</a>
			<a href="javascript:goPageMove('skinProdViewDesign')" class="selected" style="margin-left:600px">디자인선택</a>
		</div>

		<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
		<input type="hidden" name="ds_code" value="<?=$strDS_CODE?>"/>
		<input type="hidden" name="be_no" value="<?=$intBE_NO?>">
		<input type="hidden" name="im_img2" value="">
		<input type="hidden" name="ic_code" value="<?=$intIC_CODE?>"/>
		<input type="hidden" name="ic_type" value="<?=$strIC_TYPE?>"/>		

			<!-- ******** 컨텐츠 ********* -->
			<div style="margin-top:10px;text-align:center;">
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
						<div id="designSkinList"  class="designListPopWrap">
						<img src="/himg/etc/icon_loading.gif"/>
						</div>
					</div><br>
					<div id="choseDesign"></div>
					<div id="designCommend"></div>
				<!-- ******************** contentsArea ********************** -->
			</div><!-- tableList -->
			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAction();"><strong>디자인변경</strong></a>
				<a class="btn_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</form>
		</div>
	</div>
</body>
</html>


