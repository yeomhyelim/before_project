<?
		$aryImageShowType['A'] = "<img src='/shopAdmin/himg/layout/prod_list/zoom_img_icon.gif'/>";
		$aryImageShowType['B'] = "<img src='/shopAdmin/himg/layout/prod_list/zoom_img_list.gif'/>";
	
	// 샵메인 정보 로드
	$designSetMgr->setDS_TYPE("SKIN_PV");
	$skinRow						= $designSetMgr->getCodeView($db);		
	$skinRow['PV_IMAGE_SHOW_TYPE']	= ($skinRow['PV_IMAGE_SHOW_TYPE']) ? $skinRow['PV_IMAGE_SHOW_TYPE'] : "A";
	$skinRow['PV_BEST_LIST1_USE']	= ($skinRow['PV_BEST_LIST1_USE'])  ? $skinRow['PV_BEST_LIST1_USE']  : "A";
	$skinRow['PV_BEST_LIST1_DESIGN']	= ($skinRow['PV_BEST_LIST1_DESIGN'])  ? $skinRow['PV_BEST_LIST1_DESIGN']  : "PB0001";
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/
		onPageLoadEvent();																						// 페이지 로드
		$("#pv_image_show_type_y").bind("click", function() {imageShowTypeYClickEvent(this);});					// 다중이미지 사용
		$("#pv_image_show_type_c").bind("click", function() {imageShowTypeCClickEvent(this);});					// 마우스 오버시 우측에 확대이미지 보이기
		$("input[name=pv_image_show_type]").bind("click", function() {imageShowTypeClickEvent(this);});			// 상품 다중이미지 아이콘으로 표시, 상품 다중이미지로 표시 
		$("#pv_best_list1_use_y").bind("click", function() {bestList1UseYClickEvent(this);});					// 관련상품 진열
		$("#pv_bbs_review_use").bind("click", function() {bbsReviewUseClickEvent(this);});						// 상품후기 사용
		$("#pv_sns_use").bind("click", function() { snsUseClickEvent(this); });									// SNS 사용 
		$("#pv_bbs_qna_use").bind("click", function() {bbsQnaUseClickEvent(this);});							// 상품문의 사용
		$("input[name=pv_best_list1_use]").bind("click", function() {bestList1UseClickEvent(this);});			// 상품설명 위에 진열, 상품상세설명 하단에 진열, 상품상세설명 우측에 진역
	});

	/*-- 이벤트 --*/
	function goProdBestImg(be_no, ds_code)			{selfProdBestImgPopup(be_no, ds_code);}			// 관련상품 이미지 크릭
	function goLayoutSkinSaveActClickEvent()		{layoutSkinSaveAct();}							//쇼핑몰에 적용 버튼 클릭 할 때

	/*-- 이벤트 액션 --*/
	function onPageLoadEvent() {
		// 페이지 로드
//		imageShowTypeClickEvent($("input[name=pv_image_show_type]"));
		imageShowTypeYClickEvent($("#pv_image_show_type_y"));
		imageShowTypeCClickEvent($("#pv_image_show_type_c"));	
		bestList1UseYClickEvent($("#pv_best_list1_use_y"));
		bbsReviewUseClickEvent($("#pv_bbs_review_use"));
		bbsQnaUseClickEvent($("#pv_bbs_qna_use"));
		snsUseClickEvent($("#pv_sns_use"));
//		bestList1UseClickEvent($("input[name=pv_best_list1_use]"));
	}

	function imageShowTypeYClickEvent(data) {
		// 다중이미지 사용
		if($(data).attr("checked") == "checked"){
			$("input[name=pv_image_show_type]").each(function() {
				$(this).attr('disabled',false);
				if($(this).val() == "A" && $(this).attr('checked') == "checked"){
					$("input[name=pv_image_zoom_use]").attr('checked',true);
					$("input[name=pv_image_zoom_use]").attr('disabled',true);
					$("#imageShowTypeImgSrc").html("<?=$aryImageShowType['A']?>");
				}else if($(this).val() == "B" && $(this).attr('checked') == "checked"){
					$("#imageShowTypeImgSrc").html("<?=$aryImageShowType['B']?>");
				}
			});
			$("input[name=pv_image_show_type_c]").attr('checked',false);
		}else{
			$("input[name=pv_image_show_type]").each(function() {
				$(this).attr('disabled',true);
			});
			$("input[name=pv_image_show_type_c]").attr('disabled',false);
			$("input[name=pv_image_zoom_use]").attr('disabled',false);
			$("#imageShowTypeImgSrc").html("");
		}
	}

	function imageShowTypeCClickEvent(data) {
		// 마우스 오버시 우측에 확대이미지 보이기
		$("#imageShowTypeImgSrc").html("");
		if($(data).attr("checked") == "checked"){
			$("input[name=pv_image_zoom_use]").attr('checked',false);
			$("input[name=pv_image_zoom_use]").attr('disabled',true);
			$("input[name=pv_image_show_type_y]").attr('checked',false);
			$("input[name=pv_image_show_type]").each(function() {
				$(this).attr('disabled',true);
			});
		}else{
			$("input[name=pv_image_zoom_use]").attr('disabled',false);
			$("input[name=pv_image_show_type]").each(function() {
				$(this).attr('disabled',false);
			});
		}
	}

	function imageShowTypeClickEvent(data) {
		// 상품다중이미지 아이콘으로 표시, 상품다중이미지로 표시 클릭
		$("input[name=pv_image_zoom_use]").attr('disabled',false);
		$(data).each(function() {
			if($(this).val() == "A" && $(this).attr('checked') == "checked"){
				$("input[name=pv_image_zoom_use]").attr('checked',true);
				$("input[name=pv_image_zoom_use]").attr('disabled',true);
				$("#imageShowTypeImgSrc").html("<?=$aryImageShowType['A']?>");
			}else if($(this).val() == "B" && $(this).attr('checked') == "checked"){
				$("#imageShowTypeImgSrc").html("<?=$aryImageShowType['B']?>");
			}
		});
		$("input[name=pv_image_show_type_y]").attr('checked',true);
	}

	function bestList1UseYClickEvent(data) {
		// 관련상품 진열
		if($(data).attr("checked") == "checked"){
			$("input[name=pv_best_list1_use]").each(function() {
				$(this).attr('disabled',false);
				if($(this).attr("checked") == "checked") {
					bestList1UseClickEvent($(this));
				}
			});
		}else{
			$("input[name=pv_best_list1_use]").each(function() {
				$(this).attr('disabled',true);
			});
			$("#bestList1UseShowTypeImgSrc_a").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_b").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_c").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_ab").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_d").css({'display':''});
		}
	}

	function bbsReviewUseClickEvent(data) {
		// 상품후기 사용
		if($(data).attr("checked") == "checked"){
			$("#bbsReviewUseImgSrc").css({'display':''});
		}else{
			$("#bbsReviewUseImgSrc").css({'display':'none'});
		}		
	}

	function bbsQnaUseClickEvent(data) {
		// 상품문의 사용
		if($(data).attr("checked") == "checked"){
			$("#bbsQnaUseImgSrc").css({'display':''});
		}else{
			$("#bbsQnaUseImgSrc").css({'display':'none'});
		}		
	}

	function bestList1UseClickEvent(data) {
		// 상품설명 위에 진열, 상품상세설명 하단에 진열, 상품상세설명 우측에 진역
		if($(data).val() == "A") {
			$("#bestList1UseShowTypeImgSrc_a").css({'display':''});
			$("#bestList1UseShowTypeImgSrc_b").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_c").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_ab").css({'display':''});
			$("#bestList1UseShowTypeImgSrc_d").css({'display':'none'});
		}else if($(data).val() == "B") {
			$("#bestList1UseShowTypeImgSrc_a").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_b").css({'display':''});
			$("#bestList1UseShowTypeImgSrc_c").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_ab").css({'display':''});
			$("#bestList1UseShowTypeImgSrc_d").css({'display':'none'});
		}else if($(data).val() == "C") {
			$("#bestList1UseShowTypeImgSrc_a").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_b").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_c").css({'display':''});
			$("#bestList1UseShowTypeImgSrc_ab").css({'display':'none'});
			$("#bestList1UseShowTypeImgSrc_d").css({'display':'none'});
		}
	}

	function selfProdBestImgPopup(be_no, ds_code) {
		// 관련 상품 설정 팝업
		var strUrl = './?menuType=popup&mode=skinProdListDesign&ic_type=sub&be_no='+be_no+'&ds_code='+ds_code+'&subPageCode=<?=$strSubPageCode?>';
		$.smartPop.open({  bodyClose: false, width: 635, height: 800, url: strUrl});
	
	}
	
	function goBestChangeValue(be_no, ds_code) {
		// 관련 상품 설정 팝업 설정 후 상태 변경
		$("input[name=pv_best_list1_use]").each(function() {
			if($(this).attr('checked') == "checked") {
				var s = "";
				if($("#pv_best_list1_use[value=C]").attr("checked")){  s = "h"; }
				var strId	= $(this).val().toLowerCase();
				var strVal1 = "javascript:goProdBestImg('"+be_no+"', '"+ds_code+"')";
				var strVal2 = "http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_"+ds_code+s+".jpg";	
				$("#bestList1UseShowTypeImgSrc_"+strId+" > a").attr("href", strVal1);		
				$("#bestList1UseShowTypeImgSrc_"+strId+" > a > img").attr("src", strVal2);
			}
		});
	}

	function layoutSkinSaveAct() {
//		C_getAction("skin_pv_InfoSave", "<?=$PHP_SELF?>");
//		return;	

		var doc = document.form;
		doc.mode.value		= "act";
		doc.act.value		= "skin_pv_InfoSave";
		var formData		= $("#form").serialize();
		C_AjaxPost("skin_pl_InfoSave", "./index.php", formData, "post");
	}

	function snsUseClickEvent(data) {
		// SNS 사용
		if($(data).attr("checked") == "checked"){
			$("#pv_sns_facebook").attr("disabled",false);
			$("#pv_sns_twitter").attr("disabled",false);
			$("#pv_sns_m2day").attr("disabled",false);
		}else{
			$("#pv_sns_facebook").attr("disabled",true);
			$("#pv_sns_twitter").attr("disabled",true);
			$("#pv_sns_m2day").attr("disabled",true);
		}
	}
	/*-- 기능 함수 --*/

//-->
</script>

<div class="detailLayoutSample">
	<ul>
		<li><img src="/shopAdmin/himg/layout/layout_top_off.gif"/></li>
		<li class="viewImgWrap">
			<table>
				<tr>
					<td style="padding:0px;border:none;">
					<a href="#" id="btnSkinProdViewImg"><img src="/shopAdmin/himg/layout/prod_list/view_img.gif"/></a><br>
					<!-- 다중이미지아이콘표시 영역 --><span id='imageShowTypeImgSrc'><?=$aryImageShowType['A']?></span>
					</td>
					<td style="padding:0px;border:none;vertical-align:top;"><img src="/shopAdmin/himg/layout/prod_list/view_info_2.gif"/></td>
				</tr>
			</table>
			<!-- img src="/shopAdmin/himg/layout/prod_list/view_info_3.gif"/ -->
			
		</li>
		<!--관련상품 진열A--><li id="bestList1UseShowTypeImgSrc_a" style="padding-top:20px;"><a href="javascript:goProdBestImg('1','<?=$skinRow['PV_BEST_LIST1_DESIGN']?>')">
									<img src="http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_<?=$skinRow['PV_BEST_LIST1_DESIGN']?>.jpg"/></a></li>
		<!--관련상품 진열C--><li id="bestList1UseShowTypeImgSrc_c" style="padding-top:20px;">
								<img src="/shopAdmin/himg/layout/prod_list/view_prod_exp_v.gif"/>
								<a href="javascript:goProdBestImg('1','<?=$skinRow['PV_BEST_LIST1_DESIGN']?>')"><img src="http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_<?=$skinRow['PV_BEST_LIST1_DESIGN']?>h.jpg"/></a>
								<!-- a href="#"><img src="/shopAdmin/himg/layout/prod_list/view_prod_relative_h.jpg"/></a -->
							  </li>
	   <!--관련상품 진열A,B--><li id="bestList1UseShowTypeImgSrc_ab" style="padding-top:20px;">
								<img src="/shopAdmin/himg/layout/prod_list/view_prod_exp_h.gif"/>
								<!-- a href="#"><img src="/shopAdmin/himg/layout/prod_list/view_prod_relative_h.jpg"/></a -->
								</li>
		<!--관련상품 진열B--><li id="bestList1UseShowTypeImgSrc_b" style="padding-top:20px;"><a href="javascript:goProdBestImg('1','<?=$skinRow['PV_BEST_LIST1_DESIGN']?>')">
									<img src="http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_<?=$skinRow['PV_BEST_LIST1_DESIGN']?>.jpg"/></a></li>
	   <!--관련상품 진열D--> <li id="bestList1UseShowTypeImgSrc_d" style="padding-top:20px;">
								<img src="/shopAdmin/himg/layout/prod_list/view_prod_exp_h.gif"/>
								<!-- a href="#"><img src="/shopAdmin/himg/layout/prod_list/view_prod_relative_h.jpg"/></a -->
								</li>
							 <li style="padding-top:10px;" id="bbsReviewUseImgSrc"><img src="/shopAdmin/himg/layout/prod_list/view_prod_review.gif"/></li>
							 <li style="padding-top:10px;" id="bbsQnaUseImgSrc"><img src="/shopAdmin/himg/layout/prod_list/view_prod_qna.gif"/></li>
	</ul>
	
</div>
<div class="layoutSettingInfo">
	<h5><strong>STEP1</strong> 기능영역 사용여부 설정</h5>
	<div class="textInfo">
		* 상세페이지의 상세 기능과 레이아웃을 설정합니다.<br/>
		* 사용할 기능은 체크해 주세요.
	</div>
	<ul>
		<li>
			<input type="checkbox" value="Y" name="pv_image_show_type_y" id="pv_image_show_type_y"<? if(in_array($skinRow['PV_IMAGE_SHOW_TYPE'], array("A","B"))) { echo "checked"; } ?>> 다중이미지 사용
			<div class="subChk">
				<input type="radio" value="A" name="pv_image_show_type" id="pv_image_show_type"<?=($skinRow['PV_IMAGE_SHOW_TYPE'] != "B") ? " checked" : "";?>> 상품 다중이미지 아이콘으로 표시<br>
				<input type="radio" value="B" name="pv_image_show_type" id="pv_image_show_type"<?=($skinRow['PV_IMAGE_SHOW_TYPE'] == "B") ? " checked" : "";?>> 상품 다중이미지로 표시<br>
				<!--span>* 다중이미지가 궁금하신가요? <a href="#">여기를 클릭</a> 하세요.</span-->
			</div>
		</li>
		<li><input type="checkbox" value="C" name="pv_image_show_type_c" id="pv_image_show_type_c" <?=($skinRow['PV_IMAGE_SHOW_TYPE'] == "C") ? " checked" : "";?> > 마우스 오버시 돋보기 기능</li>
		<li><input type="checkbox" value="Y" name="pv_image_zoom_use" id="pv_image_zoom_use"<?=($skinRow['PV_IMAGE_ZOOM_USE'] == "Y") ? " checked" : "";?>> 상품확대창 사용</li>
		<li><input type="checkbox" value="Y" name="pv_sns_use" id="pv_sns_use"<?=($skinRow['PV_SNS_USE'] == "Y") ? " checked" : "";?>> SNS 사용</li>
			<div class="subChk">
				<input type="checkbox" value="Y" name="pv_sns_facebook" id="pv_sns_facebook"<?=($skinRow['PV_SNS_FACEBOOK'] == "Y") ? " checked" : "";?>> facebook<br>
				<input type="checkbox" value="Y" name="pv_sns_twitter" id="pv_sns_twitter"<?=($skinRow['PV_SNS_TWITTER'] == "Y") ? " checked" : "";?>> twitter<br>
				<input type="checkbox" value="Y" name="pv_sns_m2day" id="pv_sns_m2day"<?=($skinRow['PV_SNS_M2DAY'] == "Y") ? " checked" : "";?>> m2day<br>
			</div>
		<li><input type="checkbox" value="Y" name="pv_bbs_review_use" id="pv_bbs_review_use"<?=($skinRow['PV_BBS_REVIEW_USE'] == "Y") ? " checked" : "";?>> 상품후기 사용</li>
		<li><input type="checkbox" value="Y" name="pv_bbs_qna_use" id="pv_bbs_qna_use"<?=($skinRow['PV_BBS_QNA_USE'] == "Y") ? " checked" : "";?>> 상품문의 사용</li>
		<li><input type="checkbox" value="Y" name="pv_best_list1_use_y" id="pv_best_list1_use_y"<?if(in_array($skinRow['PV_BEST_LIST1_USE'], array("A","B","C"))) { echo "checked"; }?>> 관련상품 진열
			<div class="subChk">
				<input type="radio" value="A" name="pv_best_list1_use" id="pv_best_list1_use"<?if(!in_array($skinRow['PV_BEST_LIST1_USE'], array("B","C"))) { echo "checked"; }?>> 상품설명 위에 진열<br>
				<input type="radio" value="B" name="pv_best_list1_use" id="pv_best_list1_use"<?=($skinRow['PV_BEST_LIST1_USE'] == "B") ? " checked" : "";?>> 상품상세설명 하단에 진열<br>
				<input type="radio" value="C" name="pv_best_list1_use" id="pv_best_list1_use"<?=($skinRow['PV_BEST_LIST1_USE'] == "C") ? " checked" : "";?>> 상품상세설명 우측에 진열<br>
			</div>
		</li>
	</ul>

	<h5 class="mt60"><strong>STEP2</strong> 기타 설정</h5>
	<div class="textInfo">
		* 상세페이지의 레이아웃(디자인)을 선택 설정합니다.
	</div>

	<h5 class="mt60"><strong>STEP3</strong> 설정 정보 사이트 적용</h5>
	<div class="textInfo">
		* 각 스텝별 설정을 마무리 하셨다면 최종적으로 "쇼핑몰에 적용" 하기 버튼을 클릭해 주세요.
	</div>
	<ul>
		<li><a href="javascript:goLayoutSkinSaveActClickEvent()" class="btn_Big_Blue"><strong>쇼핑몰에 적용</strong></a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- a class="btn_blue_big" href="#" id="btnSkinProdViewBtn"><strong>버튼</strong></a>
<a class="btn_blue_big" href="#" id="btnSkinProdViewImg"><strong>이미지</strong></a>
<a class="btn_blue_big" href="#" id="btnSkinProdReview"><strong>사용후기/상품후기관리</strong></a -->