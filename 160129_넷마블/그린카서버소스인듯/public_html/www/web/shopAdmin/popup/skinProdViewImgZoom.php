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
		$("#imgViewW").bind("change", function() {imgViewWChangeEvent(this);});							// 상품리스트 관리 - 이미지 설정 '가로' SELECT BOX 변경
		$("#imgViewH").bind("change", function() {imgViewHChangeEvent(this);});							// 상품리스트 관리 - 이미지 설정 '세로' SELECT BOX 변경
	});


	/*-- 이벤트 액션 --*/
	function imgViewWChangeEvent(data) {
		var imgViewW	= $(data).val();
		    imgViewW	= (15 * imgViewW) + 'px'; 
		$("#imageViewCnt").css({'width':imgViewW});
	}

	function imgViewHChangeEvent(data) {
		var imgViewH	= $(data).val();
		    imgViewH	= (15 * imgViewH) + 'px'; 
		$("#imageViewCnt").css({'height':imgViewH});
	}

	function goAct(){
		var doc = document.form;
		doc.menuType.value = "layout";
		
		//document.form.encoding = "multipart/form-data";
//		C_getAction("skinProdViewImgZoom","<?=$PHP_SELF?>");				
		doc.mode.value	= "act";
		doc.act.value	= "skinProdViewImgZoom";
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
		<h2>확대줌</h2>
		<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>

	<!-- ******** 텝 메뉴 ********* -->
	<div class="adminTabBtnWrap mt10">
		<a href="javascript:goPageMove('skinProdViewImg')" >사이즈</a>
		<a href="javascript:goPageMove('skinProdViewImgMulty')" style="margin-left:200px">다중이미지</a>
		<a href="javascript:goPageMove('skinProdViewImgZoom')" class="selected" style="margin-left:400px">팝업이미지뷰어</a>
		<a href="javascript:goPageMove('skinProdViewDesign')" style="margin-left:600px">디자인선택</a>
	</div>

	<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">					

			<!-- ******** 컨텐츠 ********* -->
			<div class="newTableList mt10" id="aatest">
				<table>
					<colgroup>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th>
							<div class="inBorderFFF">
								<ul>
									<li>네비게시연 이미지 사이즈를</li>
									<li>
										<strong>가로</strong> <input type="text" name="pv_img_zoom_size_w" id="imgSizeW" value="<?=$row['PV_IMG_ZOOM_SIZE_W']?>" <?=$nBox?>  style="width:25px;padding-right:5px;text-align:right;"/> px, 
										<strong>세로</strong> <input type="text" name="pv_img_zoom_size_h" id="imgSizeH" value="<?=$row['PV_IMG_ZOOM_SIZE_H']?>" <?=$nBox?>  style="width:25px;padding-right:5px;text-align:right;"/> px로 설정.</li>
								</ul>
							</div><!-- inBorderFFF -->
						</th>
						<th>
							<div class="inBorderFFF">
								<ul>
									<li>네비게이션 이미지 배치를</li>
									<li>
										<strong>가로</strong> 
										<select style="width:50px" name="pv_img_zoom_view_w" id="imgViewW">
											<? for($i=1;$i<10;$i++) : ?>
											<option value="<?=$i?>"<?=($i==$row['PV_IMG_ZOOM_VIEW_W'])?" selected":"";?>><?=$i?></option>
											<? endfor; ?>
										</select> 개, 
										<strong>세로</strong> 
										<select style="width:50px"  name="pv_img_zoom_view_h" id="imgViewH">
											<? for($i=1;$i<15;$i++) : ?>
											<option value="<?=$i?>"<?=($i==$row['PV_IMG_ZOOM_VIEW_H'])?" selected":"";?>><?=$i?></option>
											<? endfor; ?>
										</select> 줄로 설정.</li>
								</ul>
							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<td class="vTop"><img src="/shopAdmin/himg/layout/prod_list/list_detail_img.gif"/></td>
						<td class="vTop">
							<div class="listBoxPreviewWrap">
								<div id="imageViewCnt" style="width:<?=$row['PV_IMG_ZOOM_VIEW_W']*15?>px;height:<?=$row['PV_IMG_ZOOM_VIEW_H']*15?>px;margin-top:-1px;margin-left:1px;background: url(./himg/layout/prod_list/list_dot_box.gif)"></div>
							</div>
						</td>
					</tr>
				</table>
			</div><!-- newTableList -->


			<div class="newTableList mt10">
				<table>
					<colgroup>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">네비게이션 배치</strong>
								<strong class="">
									<input type="radio" value="Right" name="pv_img_zoom_position"<?=($row['PV_IMG_ZOOM_POSITION']=="Right")?" checked":"";?>> 우측
									<input type="radio" value="Bottom" name="pv_img_zoom_position"<?=($row['PV_IMG_ZOOM_POSITION']=="Bottom")?" checked":"";?>> 아래
									<input type="radio" value="no" name="pv_img_zoom_position"<?=($row['PV_IMG_ZOOM_POSITION']=="no")?" checked":"";?>> 사용안함
								</strong>
							</div><!-- inBorderFFF -->
						</th>
					</tr>
				</table>
			</div><!-- newTableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
				<a class="btn_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</div>
	</form>
</body>
</html>