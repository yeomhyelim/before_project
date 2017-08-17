<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode	= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	if (!$strSubPageCode){
		exit;
	}

	$designSetMgr->setDS_TYPE("SKIN_PV");
	$row = $designSetMgr->getCodeView($db);
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/
	});

	/*-- 이벤트 액션 --*/
	function goAct(){
		var doc = document.form;
		doc.menuType.value = "layout";
		
		//document.form.encoding = "multipart/form-data";
//		C_getAction("skinProdViewImg","<?=$PHP_SELF?>");				

		doc.mode.value	= "act";
		doc.act.value	= "skinProdViewImg";
		var formData	= $("#form").serialize();

		C_AjaxPost("skinProdListImgAct", "./index.php", formData, "post");
	}

	function goAjaxRet(name,result){
		if (name == "skinProdListImgAct") {			
			var data = eval(result);
			if (data[0].RET == "Y") {
				alert(data[0].MSG);				
			}
		}
	}
	function goPageMove(mode) {
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
		<h2>사이즈</h2>
		<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>

	<!-- ******** 텝 메뉴 ********* -->
	<div class="adminTabBtnWrap mt10">
		<a href="javascript:goPageMove('skinProdViewImg')" class="selected">사이즈</a>
		<a href="javascript:goPageMove('skinProdViewImgMulty')" style="margin-left:200px">다중이미지</a>
		<a href="javascript:goPageMove('skinProdViewImgZoom')" style="margin-left:400px">팝업이미지뷰어</a>
		<a href="javascript:goPageMove('skinProdViewDesign')" style="margin-left:600px">디자인선택</a>
	</div>

	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">					

			<!-- ******** 컨텐츠 ********* -->
				<div class="tableList" style="margin-top:10px;">
				<table>
					<tr>
						<th>이미지사이즈</th>
						<td>
							<span class="spanTitle">가로사이즈</span> <input type="text" name="imgSizeW" id="imgSizeW" value="<?=$row[PV_IMG_SIZE_W]?>" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
							<span class="spanTitle">세로사이즈</span> <input type="text" name="imgSizeH" id="imgSizeH" value="<?=$row[PV_IMG_SIZE_H]?>" <?=$nBox?>  style="width:40px;"/> px
						</td>
					</tr>
					<tr>
						<th>이미지사이즈(팝업)</th>
						<td>
							<span class="spanTitle">가로사이즈</span> <input type="text" name="popImgSizeW" id="popImgSizeW" value="<?=$row['PV_POP_IMG_SIZE_W']?>" <?=$nBox?>  style="width:40px;"/> px <span class="blank ml20"></span>
							<span class="spanTitle">세로사이즈</span> <input type="text" name="popImgSizeH" id="popImgSizeH" value="<?=$row['PV_POP_IMG_SIZE_H']?>" <?=$nBox?>  style="width:40px;"/> px
						</td>
					</tr>
				</table>
			</div><!-- tableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
				<a class="btn_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</div>
	</form>
</body>
</html>