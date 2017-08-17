<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode			= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	$strProdCateCode		= $_POST["cateCode"]		? $_POST["cateCode"]		: $_REQUEST["cateCode"];

	if (!$strSubPageCode){
		exit;
	}

	$strDS_TYPE = sprintf("SKIN_%s", substr($strSubPageCode,0,2));
	$ds			= substr($strSubPageCode,0,2);

	$designSetMgr->setDS_TYPE($strDS_TYPE);
	$designSetMgr->setDS_CODE("{$ds}_TOP_USE_CATE_IMG");
	if ($strProdCateCode) {
		$designSetMgr->setDS_CODE("{$ds}_TOP_USE_CATE_".$strProdCateCode."_IMG");
	}
	$strProdListTopImg = $designSetMgr->getCodeVal($db);

	$designSetMgr->setDHS_TYPE("SKIN_{$ds}");
	$designSetMgr->setDHS_CODE("{$ds}_TOP_USE_CATE_HTML");
	if ($strProdCateCode) {
		$designSetMgr->setDHS_CODE("{$ds}_TOP_USE_CATE_".$strProdCateCode."_HTML");
	}
	$strProdListTopHtml = $designSetMgr->getCodeHtmlVal($db);				

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goTopImageView() { topImagView(); }													// 탑 이미지 보기


	function topImagView() {

		var strIrl = "http://<?=$S_HTTP_HOST?><?=$strProdListTopImg?>";
		window.open(strIrl,'new');		

	}

	function goAct(){
		var doc = document.form;
		doc.menuType.value = "layout";
		
		document.form.encoding = "multipart/form-data";
		C_getAction("skinProdListTopImgHtml","<?=$PHP_SELF?>");				
		return;

		doc.mode.value		= "act";
		doc.act.value		= "skinProdListTopImgHtml";
		var formData		= $("#form").serialize();

		C_AjaxPost("skinProdListTopImgHtml", "./index.php", formData, "post");
	}
	
	function goAjaxRet(name,result){
		if (name == "skinProdListTopImgHtml") {			
			var data = eval(result);
			if (data[0].RET == "Y") {
				alert(data[0].MSG);				
			}
		}
	}


	function goTopImgDel(){
		var x = confirm("이미지를 삭제하시겠습니까?");
		if (x == true)
		{
			var doc = document.form;
			doc.menuType.value = "layout";

			C_getAction("skinProdListTopImgDel","<?=$PHP_SELF?>");		
		}
	}


	function goClose() {
		parent.goClose();
	}

//-->
</script>
<script language="JavaScript" type="text/javascript" src="../common/eumEditor/highgardenEditor.js"></script>
<script type="text/javascript">
//<![CDATA[
	 /** 자바 스크립트 전역변수 설정 **/
	var rootDir 	= "../../common/eumEditor/highgardenEditor";
	var uploadImg 	= "/upload/editor";
	var uploadFile 	= "../index.php";
	var htmlYN		= "Y";
//]]>
</script>
	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
		<input type="hidden" name="prodCateCode" value="<?=$strProdCateCode?>">
			<div class="layerPopWrap">
				<div class="popTop">
				<h2>상품리스트 Top Img/Html관리</h2>
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clear"></div>
			</div>
			<!-- ******** 컨텐츠 ********* -->
				<div class="tableList" style="margin-top:10px;">
				<table>
					<tr>
						<th>상단영역 이미지</th>
						<td>
							<input type="file" name="pl_top_img" <?=$nBox?>  style="width:300px;height:20px"/>
							<?if ($strProdListTopImg){?>
								<a class="btn_sml" href="javascript:goTopImageView();"><strong>V</strong></a>
								<a class="btn_sml" href="javascript:goTopImgDel();"><strong>X</strong></a>
							<?}?>
						</td>
					</tr>
					<tr>
						<th>HTML</th>
						<td><textarea name="pl_top_html" id="pl_top_html" title="higheditor_full" style="width:100%;height:200px;"><?=$strProdListTopHtml?></textarea></td>
					</tr>
				</table>
			</div><!-- tableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
				<a class="btn_blue_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</div>
	</form>
</body>
</html>