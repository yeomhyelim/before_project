<?
	// 회원 로그인 정보
	$designSetMgr->setDS_TYPE("SKIN_ML");
	$skinRow			= $designSetMgr->getCodeView($db);
	$ds_code			= ($skinRow['ML_IMAGE_DESIGN']) ? $skinRow['ML_IMAGE_DESIGN'] : "ML0001";
?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/

	});

	/*-- 이벤트 --*/
	function goMemberLoginForm(ds_code)					{ openSmartPopup(ds_code);	}
	function goLayoutSkinSaveActClickEvent()			{layoutSkinSaveAct();}						//쇼핑몰에 적용 버튼 클릭 할 때

	/*-- 이벤트 액션 --*/
	function openSmartPopup(ds_code) {
		var strUrl = './?menuType=popup&mode=skinMemberLoginFormDesign&subPageCode=<?=$strSubPageCode?>&ds_code=' + ds_code;
		$.smartPop.open({  bodyClose: false, width: 635, height: 800, url: strUrl});
	}

	/* 팝업 닫기 후, 액션 --*/
	function goDesignSkinModify(ds_code) {
		var strVal1 = "javascript:goMemberLoginForm('"+ds_code+"')";
		var strVal2 = "http://www.eumshop.com/upload/shopDesign/subDesign/sub_memberList_"+ds_code+".jpg";
		$("#ml_member_login_form > a").attr("href",strVal1);
		$("#ml_member_login_form > a > img").attr("src",strVal2);
	}

	function layoutSkinSaveAct() {

		var doc = document.form;
		doc.mode.value		= "act";
		doc.act.value		= "skinMainInfoSave";
		var formData		= $("#form").serialize();
		C_AjaxPost("skinMainInfoSave", "./index.php", formData, "post");	
	}

//-->
</script>

<div class="detailLayoutSample">
	<ul>
		<li><img src="/shopAdmin/himg/layout/layout_top_off.gif"/></li>
		<li id="ml_member_login_form" style="<?=$strSliderUseCss?>"><a href="javascript:goMemberLoginForm('<?=$ds_code?>');" id="btnMemberLoginForm"><img src="/shopAdmin/himg/layout/prod_list/top_img.gif"/></a></li>
		<li id="ml_nonmember_login_form" style="<?=$strSliderUseCss?>"><a href="#" id="btnNonmemberLoginForm"><img src="/shopAdmin/himg/layout/prod_list/top_img.gif"/></a></li>
	</ul>
</div>

<div class="layoutSettingInfo">
	<h5><strong>STEP1</strong> 기능영역 사용여부 설정</h5>
	<div class="textInfo">
		* 메인페이지 상품추천 기능 및 추가 기능을 설정합니다.<br/>
		* 사용할 기능은 체크해 주세요.
	</div>
	<ul>
		<li><input type="checkbox" name="zl_slider_use" id="zl_slider_use" value="Y"<?= ($skinRow['ZL_SLIDER_USE']=="Y") ? " checked" : "" ?>> 비회원 로그인 사용</li>
	</ul>

	<h5 class="mt60"><strong>STEP2</strong> 기능 상세 설정</h5>
	<div class="textInfo">
		* STEP1 에서 사용 여부를 결정하셨다면 각 영역의 디자인 및 배열을 설정 하실 수 있습니다<br/>
		* 좌측 <strong>샘플이미지에 마우스를 클릭</strong> 하시면 각 영역의 세부 설정이 가능합니다.
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

<!-- a class="btn_blue_big" href="#" id="btnSkinMainTopMenu"><strong>메뉴관리</strong></a -->

