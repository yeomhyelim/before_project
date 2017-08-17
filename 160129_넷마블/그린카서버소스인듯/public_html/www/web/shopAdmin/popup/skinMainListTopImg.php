<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode		= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];

	if (!$strSubPageCode){
		exit;
	}

	$strDS_TYPE = sprintf("SKIN_%s", substr($strSubPageCode,0,2));
	$designSetMgr->setDS_TYPE($strDS_TYPE);
	$row		= $designSetMgr->getCodeView($db);


?>

<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/
		pageLoad();
		$("#zl_slider_motion_effect").change(function () { motionEffectChangeEvent(this)	});
	});


	function pageLoad() {
		motionEffectChangeEvent($("#zl_slider_motion_effect"));
	}

	function motionEffectChangeEvent(data) {
		$("#zl_slider_motion_type_tr").css({'display':''});
		if($(data).val() == "effect2"){
			$("#zl_slider_motion_type_tr").css({'display':'none'});
		}
	}

	function goAct(){
		
		var doc = document.form;
		doc.menuType.value = "layout";
		
//		document.form.encoding = "multipart/form-data";
//		C_getAction("skinMainListTopImg","<?=$PHP_SELF?>");		
//		return;
		
		doc.mode.value	= "act";
		doc.act.value	= "skinMainListTopImg";
		var formData	= $("#form").serialize();

		C_AjaxPost("skinMainListTopImg", "./index.php", formData, "post");
		
	}

	function goAjaxRet(name,result){
		if (name == "skinMainListTopImg") {			
			var data = eval(result);
			if (data[0].RET == "Y") {
				alert(data[0].MSG);				
			}
		}
	}

	/*-- 이벤트 정의 --*/

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


		<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="ds_code" value="<?=$strSubPageCode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">	
			<!-- ******** 컨텐츠 ********* -->
			<div class="newTableList mt10">
				<br><br>
				<center>
				<table style="width:600px">
					<colgroup>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">모션사용여부</strong>
								<strong class="block2">
									<span class="on_off"><input type="checkbox" value="Y" name="zl_slider_motion_use"<?=($row['ZL_SLIDER_MOTION_USE']=="Y")?" checked":""?> id="on_off"/></span>
								</strong>
							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">모션효과</strong>
								<select name="zl_slider_motion_effect" id="zl_slider_motion_effect">
									<option value="effect1"<?=($row['ZL_SLIDER_MOTION_EFFECT']=="effect1")?" selected":""?>>효과1</option>
									<option value="effect2"<?=($row['ZL_SLIDER_MOTION_EFFECT']=="effect2")?" selected":""?>>효과2</option>
									<option value="effect3"<?=($row['ZL_SLIDER_MOTION_EFFECT']=="effect3")?" selected":""?>>효과3</option>
								</select>
							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr id="zl_slider_motion_type_tr">
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">모션방법</strong>
								<input type="radio" name="zl_slider_motion_type" value="right"<?=($row['ZL_SLIDER_MOTION_TYPE']=="right")?" checked":""?>> 좌에서 우로
								<input type="radio" name="zl_slider_motion_type" value="left"<?=($row['ZL_SLIDER_MOTION_TYPE']=="left")?" checked":""?>> 우에서 좌로
								<input type="radio" name="zl_slider_motion_type" value="down"<?=($row['ZL_SLIDER_MOTION_TYPE']=="down")?" checked":""?>> 위에서 아래로
								<input type="radio" name="zl_slider_motion_type" value="up"<?=($row['ZL_SLIDER_MOTION_TYPE']=="up")?" checked":""?>> 아래서 위로
								<input type="radio" name="zl_slider_motion_type" value="fade"<?=($row['ZL_SLIDER_MOTION_TYPE']=="fade")?" checked":""?>> 페이드인,페이드아웃

							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">이미지 사이즈</strong>
								가로 : <input type="text" style="width:50px" name="zl_slider_image_size_w" value="<?=$row['ZL_SLIDER_IMAGE_SIZE_W']?>"> px 
								세로 : <input type="text" style="width:50px" name="zl_slider_image_size_h" value="<?=$row['ZL_SLIDER_IMAGE_SIZE_H']?>"> px

							</div><!-- inBorderFFF -->
						</th>
					</tr>
				</table>
				</center>
			</div><!-- newTableList --><br><br>
			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();"><strong>디자인변경</strong></a>
				<a class="btn_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</form>
		</div>
	</div>
</body>
</html>