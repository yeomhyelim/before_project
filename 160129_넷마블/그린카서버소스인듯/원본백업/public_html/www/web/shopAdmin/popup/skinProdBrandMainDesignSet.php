<?
	require_once MALL_CONF_LIB."DesignSetMgr.php";
	$designSetMgr = new DesignSetMgr();	

	$strSubPageCode		= $_POST["subPageCode"]		? $_POST["subPageCode"]		: $_REQUEST["subPageCode"];
	$intIC_CODE			= $_POST["ic_code"]			? $_POST["ic_code"]			: $_REQUEST["ic_code"];
	$strIC_TYPE			= $_POST["ic_type"]			? $_POST["ic_type"]			: $_REQUEST["ic_type"];
 	$strDS_CODE			= $_POST["ds_code"]			? $_POST["ds_code"]			: $_REQUEST["ds_code"];	
	$intBE_NO			= $_POST["be_no"]			? $_POST["be_no"]			: $_REQUEST["be_no"];	



	$intIC_CODE			= $intBE_NO;
	if (!$strSubPageCode){
		exit;
	}

	$strDS_TYPE = sprintf("SKIN_%s", substr($strSubPageCode,0,2));
	$designSetMgr->setDS_TYPE($strDS_TYPE);
	$row		= $designSetMgr->getCodeView($db);
	$ds			= substr($strSubPageCode,0,2);
	if($intIC_CODE && $strIC_TYPE) :
		$ds1	= $ds . "_BEST_LIST" . $intBE_NO;
		$ds2	= strtolower($ds1);
	endif;
		
?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/
		$("#imgViewW").bind("change", function() {imgViewWChangeEvent(this);});							// 상품리스트 관리 - 이미지 설정 '가로' SELECT BOX 변경
		$("#imgViewH").bind("change", function() {imgViewHChangeEvent(this);});							// 상품리스트 관리 - 이미지 설정 '세로' SELECT BOX 변경
		$("#prod_name_color_code").focusin(function() {colorSelectBoxShowEvent(this);});		// 상품명 색상 텍스트 박스 선택시
		$("#prod_intro_color_code").focusin(function() {colorSelectBoxShowEvent(this);});		// 상품설명 색상 텍스트 박스 선택시
		$("#prod_point_color_code").focusin(function() {colorSelectBoxShowEvent(this);});		// 적립금 색상 텍스트 박스 선택시
		$("#prod_price_color_code").focusin(function() {colorSelectBoxShowEvent(this);});		// 원가격 색상 텍스트 박스 선택시
		$("#prod_sale_color_code").focusin(function() {colorSelectBoxShowEvent(this);});		// 판매가격 색상 텍스트 박스 선택시

		$("#prod_name_color_code").focusout(function() {colorCloseBoxShowEvent(this);});				// 상품명 색상 텍스트 박스 선택시
		$("#prod_intro_color_code").focusout(function() {colorCloseBoxShowEvent(this);});			// 상품설명 색상 텍스트 박스 선택시
		$("#prod_point_color_code").focusout(function() {colorCloseBoxShowEvent(this);});			// 적립금 색상 텍스트 박스 선택시
		$("#prod_price_color_code").focusout(function() {colorCloseBoxShowEvent(this);});			// 원가격 색상 텍스트 박스 선택시
		$("#prod_sale_color_code").focusout(function() {colorCloseBoxShowEvent(this);});				// 판매가격 색상 텍스트 박스 선택시

		$("#prodMoneyIcon").bind('click', function() {prodMoneyIconClickEvent(this);});					// 통화표시방법 라디오 박스 선택시
		$("#prodMoneySign").bind('click', function() {prodMoneyIconClickEvent(this);});					// 통화표시방법 라디오 박스 선택시
		$("#prodMoneyWon").bind('click', function() {prodMoneyIconClickEvent(this);});					// 통화표시방법 라디오 박스 선택시
	});

	function goProdMoneyIconChange(no)	{ prodMoneyIconChange(no);}										// 통화 아이콘 선택시
	function goTitleImageDelete() { titleImageDelete(); }												// 타이틀 이미지 삭제
	function goTitleImageView() { titleImagView(); }													// 타티을 이미지 보기

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
		$("#colorpicker").css('display','none');
//		$("#colorpicker").css('display','inline').fadeOut(1000);
	}

	function prodMoneyIconClickEvent(data) {
		var strVal = $(data).val();
		if(strVal == "icon") {
			$(".prodMoneyIconWrap").css({'display':''});
		} else {
			$(".prodMoneyIconWrap").css({'display':'none'});
		}
	}
	
	function prodMoneyIconChange(no) {
		$(".prodMoneyIconWrap").css({'display':'none'});
		$("#iconImg").html("<img src='/shopAdmin/himg/common/icon_w_" + no + ".gif'>");
		$("input:[name=<?=$ds2?>_money_icon]").val("icon_w_" + no + ".gif");
	}

	function titleImageDelete() {
		// 타이틀 이미지 삭제
		var  x = confirm("타이틀 이미지를 삭제하시겠습니까?");
		if (x != true) {
			return;
		}
		var doc					= document.form;
		doc.menuType.value		= "layout";
		doc.mode.value			= "act";
		doc.act.value			= "skinProdListTitleImageDelete";

//		C_getAction("skinProdListTitleImageDelete","<?=$PHP_SELF?>");		
//		return;

		var formData			= $("#form").serialize();
		C_AjaxPost("titleImageDelete", "./index.php", formData, "post");
	}

	function titleImagView() {
		var strIrl = "http://<?=$S_HTTP_HOST?><?=$row[$ds1.'_TITLE_FILE_NAME']?>";
		window.open(strIrl,'new');		
	}

	function goAct(){

		var doc = document.form;
		doc.menuType.value = "layout";
		
		document.form.encoding = "multipart/form-data";
		C_getAction("skinProdBrandMainDesignSet","<?=$PHP_SELF?>");		
		return;
		
//		doc.mode.value	= "act";
//		doc.act.value	= "skinProdListImg";
//		var formData	= $("#form").serialize();
//
//		C_AjaxPost("skinProdListImgAct", "./index.php", formData, "post");
		
	}

	function goAjaxRet(name,result){
		
		if (name == "skinProdListImgAct") {	
			var data = eval(result);
			if (data[0].RET == "Y") {
				alert(data[0].MSG);				
			}
		}
		
		/* 타이틀 이미지 삭제 */
		if (name == "titleImageDelete") {
			var data = eval(result);
			alert(data[0]["MSG"]);
			$("#titleImageView").css({'display':'none'});
			$("#titleImageDelete").css({'display':'none'});
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


		<form name="form" id="form">
		<input type="hidden" name="menuType" value="<?=$strMenuType?>">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="subPageCode" value="<?=$strSubPageCode?>">	
		<input type="hidden" name="ds_code" value="">
		<input type="hidden" name="ic_code" value="<?=$intIC_CODE?>"/>
		<input type="hidden" name="ic_type" value="<?=$strIC_TYPE?>"/>
		<input type="hidden" name="be_no" value="<?=$intBE_NO?>">
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
									<li>목록이미지 사이즈를</li>
									<li>
										<strong>가로</strong> <input type="text" name="<?=$ds2?>_size_w" id="imgSizeW" value="<?=$row[$ds1.'_SIZE_W']?>" <?=$nBox?>  style="width:25px;padding-right:5px;text-align:right;"/> px, 
										<strong>세로</strong> <input type="text" name="<?=$ds2?>_size_h" id="imgSizeH" value="<?=$row[$ds1.'_SIZE_H']?>" <?=$nBox?>  style="width:25px;padding-right:5px;text-align:right;"/> px로 설정.</li>
								</ul>
							</div><!-- inBorderFFF -->
						</th>
						<th>
							<div class="inBorderFFF">
								<ul>
									<li>상품목록에 이미지 배치를</li>
									<li>
										<strong>가로</strong> 
										<select style="width:50px" name="<?=$ds2?>_view_w" id="imgViewW">
											<? for($i=1;$i<10;$i++) : ?>
											<option value="<?=$i?>"<?=($i==$row[$ds1.'_VIEW_W'])?" selected":"";?>><?=$i?></option>
											<? endfor; ?>
										</select> 개, 
										<strong>세로</strong> 
										<select style="width:50px"  name="<?=$ds2?>_view_h" id="imgViewH">
											<? for($i=1;$i<15;$i++) : ?>
											<option value="<?=$i?>"<?=($i==$row[$ds1.'_VIEW_H'])?" selected":"";?>><?=$i?></option>
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
								<div id="imageViewCnt" style="width:<?=$row[$ds1.'_VIEW_W']*15?>px;height:<?=$row[$ds1.'_VIEW_H']*15?>px;margin-top:-1px;margin-left:1px;background: url(./himg/layout/prod_list/list_dot_box.gif)"></div>
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
								<strong class="block1">브랜드명</strong>
								<strong class="block2">
									<span class="on_off"><input type="checkbox" value="Y" name="<?=$ds2?>_show_1"<?=($row[$ds1.'_SHOW_1']=="Y")?" checked":""?> id="on_off"/></span>
								</strong>
								<strong class="colorPickerWrap">
									<input type="text" name="<?=$ds2?>_color_1" id="prod_name_color_code" value="<?=$row[$ds1.'_COLOR_1']?>" style="background:<?=$row[$ds1.'_COLOR_1']?>" pickerPosition="top:0px"/>
								<div id="colorpicker" style="display:none"></div>
								</strong>
							</div><!-- inBorderFFF -->
						</th>
						<th>
							<div class="inBorderFFF" style="height:18px;padding-top:10px;">
								<strong class="block1">브랜드명 배치</strong>
								<input type="radio" value="left" name="<?=$ds2?>_word_align"<?=($row[$ds1.'_WORD_ALIGN']=="left")?" checked":""?>/>좌측
								<input type="radio" value="center" name="<?=$ds2?>_word_align"<?=($row[$ds1.'_WORD_ALIGN']=="center")?" checked":""?>/>중앙
								<input type="radio" value="right" name="<?=$ds2?>_word_align"<?=($row[$ds1.'_WORD_ALIGN']=="right")?" checked":""?>/>우측
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