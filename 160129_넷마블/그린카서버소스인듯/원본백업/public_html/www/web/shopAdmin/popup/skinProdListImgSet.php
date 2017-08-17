<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode		= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];
	$intIC_CODE			= $_POST["ic_code"]			? $_POST["ic_code"]			: $_REQUEST["ic_code"];
	$strIC_TYPE			= $_POST["ic_type"]			? $_POST["ic_type"]			: $_REQUEST["ic_type"];

	if (!$strSubPageCode){
		exit;
	}

	$strDS_TYPE = sprintf("SKIN_%s", substr($strSubPageCode,0,2));
	$designSetMgr->setDS_TYPE($strDS_TYPE);
	$row		= $designSetMgr->getCodeView($db);
	$ds			= substr($strSubPageCode,0,2);
	if($intIC_CODE && $strIC_TYPE) :
		$ds			= $ds . "_" . STRTOUPPER($strIC_TYPE) . $intIC_CODE;
	endif;
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/
		$("#imgViewW").bind("change", function() {imgViewWChangeEvent(this);});							// 상품리스트 관리 - 이미지 설정 '가로' SELECT BOX 변경
		$("#imgViewH").bind("change", function() {imgViewHChangeEvent(this);});							// 상품리스트 관리 - 이미지 설정 '세로' SELECT BOX 변경
		$("#prod_name_color_code").bind('click',function() {colorSelectBoxShowEvent(this);});		// 상품명 색상 텍스트 박스 선택시
		$("#prod_intro_color_code").bind('click',function() {colorSelectBoxShowEvent(this);});		// 상품설명 색상 텍스트 박스 선택시
		$("#prod_point_color_code").bind('click',function() {colorSelectBoxShowEvent(this);});		// 적립금 색상 텍스트 박스 선택시
		$("#prod_price_color_code").bind('click',function() {colorSelectBoxShowEvent(this);});		// 원가격 색상 텍스트 박스 선택시
		$("#prod_sale_color_code").bind('click',function() {colorSelectBoxShowEvent(this);});		// 판매가격 색상 텍스트 박스 선택시
		$("#prod_name_color_code").focusout(function() {colorCloseBoxShowEvent(this);});				// 상품명 색상 텍스트 박스 선택시
		$("#prod_intro_color_code").focusout(function() {colorCloseBoxShowEvent(this);});			// 상품설명 색상 텍스트 박스 선택시
		$("#prod_point_color_code").focusout(function() {colorCloseBoxShowEvent(this);});			// 적립금 색상 텍스트 박스 선택시
		$("#prod_price_color_code").focusout(function() {colorCloseBoxShowEvent(this);});			// 원가격 색상 텍스트 박스 선택시
		$("#prod_sale_color_code").focusout(function() {colorCloseBoxShowEvent(this);});				// 판매가격 색상 텍스트 박스 선택시
		$("#prodMoneyIcon").bind('click', function() {prodMoneyIconClickEvent(this);});					// 통화표시방법 라디오 박스 선택시
		$("#prodMoneySign").bind('click', function() {prodMoneyIconClickEvent(this);});					// 통화표시방법 라디오 박스 선택시
		$("#prodMoneyWon").bind('click', function() {prodMoneyIconClickEvent(this);});					// 통화표시방법 라디오 박스 선택시
	});


	/*-- 이벤트 정의 --*/
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

	function colorSelectBoxShowEvent(data) {
		$("#colorpicker").farbtastic("#" + $(data).attr('id'));
		$("#colorpicker").css('display','');
		if($(data).val() == "") {
			$(data).val("#");
		}
		var myStyle = $(data).attr("pickerPosition");
		$("#colorpicker").attr("style",myStyle);
	}

	function colorCloseBoxShowEvent(data) {
		$("#colorpicker").css('display','inline').fadeOut(1000);
	}

	function prodMoneyIconClickEvent(data) {
		var strVal = $(data).val();
		if(strVal == "icon") {
			$(".prodMoneyIconWrap").css({'display':''});
		} else {
			$(".prodMoneyIconWrap").css({'display':'none'});
		}
	}


	function goAct(){
		
		var doc = document.form;
		doc.menuType.value = "layout";
		
		document.form.encoding = "multipart/form-data";
//		C_getAction("skinProdListImg","<?=$PHP_SELF?>");		
//		return;
		
		doc.mode.value	= "act";
		doc.act.value	= "skinProdListImg";
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

	function goClose()
	{
		parent.goClose();
	}

//-->
</script>  

	<div class="layerPopWrap">
		<div class="popTop">
					<h2>상품리스트 관리</h2>
			<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
			<div class="clear"></div>
		</div>
		
		<div class="popBoxWrap">
			<!-- ******** 텝 메뉴 ********* -->
			<div class="adminTabBtnWrap mt10">
			<a href="./?menuType=popup&mode=skinProdListDesign&ic_code=<?=$intIC_CODE?>&ic_type=<?=$strIC_TYPE?>&subPageCode=<?=$strSubPageCode?>" class="selected">디자인 선택</a>
			<a href="./?menuType=popup&mode=skinProdListImg&ic_code=<?=$intIC_CODE?>&ic_type=<?=$strIC_TYPE?>&subPageCode=<?=$strSubPageCode?>" style="margin-left:200px">이미지 설정</a>
			</div>

		<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">	
		<input type="hidden" name="ds_code" value="">
		<input type="hidden" name="ic_code" value="<?=$intIC_CODE?>"/>
		<input type="hidden" name="ic_type" value="<?=$strIC_TYPE?>"/>
			<!-- ******** 컨텐츠 ********* -->
			<div class="newTableList mt10">
				<table>
					<colgroup>
						<col/>
						<col/>
					</colgroup>
					<tr>
						<th>
							<div class="inBorderFFF">
								<ul>
									<li>목록이미지 사이즈를</li>
									<li>
										<strong>가로</strong> <input type="text" name="imgSizeW" id="imgSizeW" value="<?=$row[$ds.'_IMG_SIZE_W']?>" <?=$nBox?>  style="width:25px;padding-right:5px;text-align:right;"/> px, 
										<strong>세로</strong> <input type="text" name="imgSizeH" id="imgSizeH" value="<?=$row[$ds.'_IMG_SIZE_H']?>" <?=$nBox?>  style="width:25px;padding-right:5px;text-align:right;"/> px로 설정.</li>
								</ul>
							</div><!-- inBorderFFF -->
						</th>
						<th>
							<div class="inBorderFFF">
								<ul>
									<li>상품목록에 이미지 배치를</li>
									<li>
										<strong>가로</strong> 
										<select style="width:50px" name="imgViewW" id="imgViewW">
											<? for($i=1;$i<10;$i++) : ?>
											<option value="<?=$i?>"<?=($i==$row[$ds.'_IMG_VIEW_W'])?" selected":"";?>><?=$i?></option>
											<? endfor; ?>
										</select> 개, 
										<strong>세로</strong> 
										<select style="width:50px"  name="imgViewH" id="imgViewH">
											<? for($i=1;$i<15;$i++) : ?>
											<option value="<?=$i?>"<?=($i==$row[$ds.'_IMG_VIEW_H'])?" selected":"";?>><?=$i?></option>
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
								<div id="imageViewCnt" style="width:<?=$row[$ds.'_IMG_VIEW_W']*15?>px;height:<?=$row[$ds.'_IMG_VIEW_H']*15?>px;margin-top:-1px;margin-left:1px;background: url(./himg/layout/prod_list/list_dot_box.gif)"></div>
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
								<strong class="block1">상품명</strong>
								<strong class="block2"><input type="checkbox" value="Y" name="prod_name_color"<?=($row[$ds.'_PROD_NAME_COLOR']=="Y")?" checked":""?>/></strong>
								<strong class="colorPickerWrap">
									<input type="text" name="prod_name_color_code" id="prod_name_color_code" value="<?=$row[$ds.'_PROD_NAME_COLOR_CODE']?>" style="background:<?=$row[$ds.'_PROD_NAME_COLOR_CODE']?>" pickerPosition="top:0px"/>
								<div id="colorpicker" style="display:none"></div>
							</div>
							</div><!-- inBorderFFF -->
						</th>
						<th>
							<div class="inBorderFFF" style="height:18px;padding-top:10px;">
								<strong class="block1">상품문구 배치</strong>
								<input type="radio" value="left" name="prod_text_align"<?=($row[$ds.'_PROD_TEXT_ALIGN']=="left")?" checked":""?>/>좌측
								<input type="radio" value="center" name="prod_text_align"<?=($row[$ds.'_PROD_TEXT_ALIGN']=="center")?" checked":""?>/>중앙
								<input type="radio" value="right" name="prod_text_align"<?=($row[$ds.'_PROD_TEXT_ALIGN']=="right")?" checked":""?>/>우측
							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">상품설명</strong>
								<strong class="block2"><input type="checkbox" value="Y" name="prod_intro_color"<?=($row[$ds.'_PROD_INTRO_COLOR']=="Y")?" checked":""?>/></strong>
								<input type="text" name="prod_intro_color_code" id="prod_intro_color_code" value="<?=$row[$ds.'_PROD_INTRO_COLOR_CODE']?>" style="background:<?=$row[$ds.'_PROD_INTRO_COLOR_CODE']?>" pickerPosition="top:30px"/>
							</div><!-- inBorderFFF -->
						</th>
						<th>
							<div class="inBorderFFF" style="height:18px;padding-top:10px;">
								<strong class="block1">통화 표시 방법</strong>								
								<input type="radio" value="sign" name="prod_print_type" id="prodMoneySign"<?=($row[$ds.'_PROD_PRINT_TYPE']=="sign")?" checked":""?>/>￦
								<input type="radio" value="won"  name="prod_print_type" id="prodMoneyWon"<?=($row[$ds.'_PROD_PRINT_TYPE']=="won")?" checked":""?>/>원
								<input type="radio" value="icon" name="prod_print_type" id="prodMoneyIcon"<?=($row[$ds.'_PROD_PRINT_TYPE']=="icon")?" checked":""?>/>아이콘
								<input typy="hidden" value="" name="prod_print_type_icon_file"/>
								<strong class="prodMoneyIconWrap" style="display:none"><div class="prodMoneyIcon">1231321313</div></div>
							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">적립금</strong>
								<strong class="block2"><input type="checkbox" value="Y" name="prod_point_color"<?=($row[$ds.'_PROD_POINT_COLOR']=="Y")?" checked":""?>/></strong>
								<input type="text" name="prod_point_color_code" id="prod_point_color_code"value="<?=$row[$ds.'_PROD_POINT_COLOR_CODE']?>" style="background:<?=$row[$ds.'_PROD_POINT_COLOR_CODE']?>" pickerPosition="top:60px"/>
							</div><!-- inBorderFFF -->
						</th>
						<th class="vTop">
							<div class="inBorderFFF">
							<!-- 리스트 이미지 -->
								<strong class="block1">상품 이미지</strong>
								<input type="checkbox" value="Y" name="prod_over_image_use"<?=($row[$ds.'_PROD_OVER_IMAGE_USE']=="Y")?" checked":""?>/>
							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">소비자가격</strong>
								<strong class="block2"><input type="checkbox" value="Y" name="prod_price_color"<?=($row[$ds.'_PROD_PRICE_COLOR']=="Y")?" checked":""?>/></strong>
								<input type="text" name="prod_price_color_code" id="prod_price_color_code" value="<?=$row[$ds.'_PROD_PRICE_COLOR_CODE']?>" style="background:<?=$row[$ds.'_PROD_PRICE_COLOR_CODE']?>" pickerPosition="top:90px"/>
							</div><!-- inBorderFFF -->
						</th>
						<th class="vTop">
							<div class="inBorderFFF">
							</div><!-- inBorderFFF -->
						</th>
					</tr>
					<tr>
						<th class="pickerStyle">
							<div class="inBorderFFF">
								<strong class="block1">판매가격</strong>
								<strong class="block2"><input type="checkbox" value="Y" name="prod_sale_color"<?=($row[$ds.'_PROD_SALE_COLOR']=="Y")?" checked":""?>/></strong>
								<input type="text" name="prod_sale_color_code" id="prod_sale_color_code" value="<?=$row[$ds.'_PROD_SALE_COLOR_CODE']?>" style="background:<?=$row[$ds.'_PROD_SALE_COLOR_CODE']?>" pickerPosition="top:120px"/>	
							</div><!-- inBorderFFF -->
						</th>
						<th class="vTop">
							<div class="inBorderFFF">
							</div><!-- inBorderFFF -->
						</th>
					</tr>
				</table>
			</div><!-- newTableList -->

			<div class="buttonWrap">
				<a class="btn_blue_big" href="javascript:goAct();" id="menu_auth_w"><strong>저장</strong></a>
				<a class="btn_big" href="javascript:goClose();"><strong>닫기</strong></a>
			</div>
		</form>
		</div>
	</div>
</body>
</html>