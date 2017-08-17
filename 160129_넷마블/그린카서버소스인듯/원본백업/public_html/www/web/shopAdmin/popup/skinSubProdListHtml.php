<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode			= $_POST["subPageCode"]			? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	$strProdListOrder		= $_POST["prodListOrder"]		? $_POST["prodListOrder"]		: $_REQUEST["prodListOrder"];

	if (!$strSubPageCode){
		exit;
	}

	$designSetMgr->setDS_TYPE("SKIN_SL");
	$row = $designSetMgr->getCodeView($db);
	
	$strTitImg = $row["SL_PRODLIST_TIT_".$strProdListOrder];
	
	$strProdImgSizeW = $row["SL_PRODLIST_IMG_SIZE_W_".$strProdListOrder];
	$strProdImgSizeH = $row["SL_PRODLIST_IMG_SIZE_H_".$strProdListOrder];
	$strProdImgViewW = $row["SL_PRODLIST_IMG_VIEW_W_".$strProdListOrder];
	$strProdImgViewH = $row["SL_PRODLIST_IMG_VIEW_H_".$strProdListOrder];

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goAct(){
		var doc = document.form;
		doc.menuType.value = "layout";
		
		document.form.encoding = "multipart/form-data";
//		C_getAction("skinSubProdListHtml","<?=$PHP_SELF?>");	
		
		doc.mode.value	= "act";
		doc.act.value	= "skinSubProdListHtml";
		var formData	= $("#form").serialize();

		C_AjaxPost("skinSubProdListHtmlAct", "./index.php", formData, "post");

	}

	function goAjaxRet(name,result){
		if (name == "skinSubProdListHtmlAct") {			
			var data = eval(result);
			if (data[0].RET == "Y") {
				alert(data[0].MSG);				
			}
		}
	}

	function goMainProdListTitImgDel(){
		var x = confirm("이미지를 삭제하시겠습니까?");
		if (x == true)
		{
			var doc = document.form;
			doc.menuType.value = "layout";

			C_getAction("skinSubProdListTitImgDel","<?=$PHP_SELF?>");		
		}
	}
	
	function goClose() {
		parent.goClose();
	}
//-->
</script>

		<form name="form" id="form">
			<input type="hidden" name="menuType" value="<?=$strMenuType?>">
			<input type="hidden" name="mode" value="<?=$strMode?>">
			<input type="hidden" name="act" value="<?=$strMode?>">
			<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">
			<input type="hidden" name="prodListOrder" value="<?=$strProdListOrder?>">
			<div class="layerPopWrap">
				<div class="popTop">
					<h2>상품리스트 진열관리</h2>
					<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
					<div class="clear"></div>
				</div>
				<!-- ******** 컨텐츠 ********* -->
				<div class="tableList" style="margin-top:10px;">
					<table>
						<tr>
							<th>타이틀 이미지</th>
							<td>
								<input type="file" name="tit_img" <?=$nBox?>  style="width:300px;height:20px"/>
								<?if ($strTitImg){?>
									<a class="btn_sml" href="javascript:goMainProdListTitImgDel();"><strong>X</strong></a>
								<?}?>
							</td>
						</tr>
						<tr>
							<th>이미지사이즈</th>
							<td>
								<span class="spanTitle">가로사이즈</span> <input type="text" name="imgSizeW" id="imgSizeW" value="<?=$strProdImgSizeW?>" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
								<span class="spanTitle">세로사이즈</span> <input type="text" name="imgSizeH" id="imgSizeH" value="<?=$strProdImgSizeH?>" <?=$nBox?>  style="width:40px;"/> px
							</td>
						</tr>
						<tr>
							<th>이미지 노출수량</th>
							<td>
								<span class="spanTitle">가로</span> <input type="text" name="imgViewW" id="imgViewW" value="<?=$strProdImgViewW?>" <?=$nBox?>  style="width:40px;"/> 개 <span class="blank ml20"></span>
								<span class="spanTitle">세로</span> <input type="text" name="imgViewH" id="imgViewH" value="<?=$strProdImgViewH?>" <?=$nBox?>  style="width:40px;"/> 줄
							</td>
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