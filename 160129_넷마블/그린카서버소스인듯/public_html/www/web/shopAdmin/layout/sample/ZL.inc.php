<?
	// 아이콘 관리
	$cateMgr->setIC_TYPE("MAIN");
	$aryProdMainList = $cateMgr->getProdDisplayList($db);

	// 샵메인 정보 로드
	$designSetMgr->setDS_TYPE("SKIN_ZL");
	$skinRow			= $designSetMgr->getCodeView($db);
	$strSliderUseCss	= ($skinRow['ZL_SLIDER_USE']!="Y") ? "display:none" : "" ;

	for($i=1;$i<=5;$i++) :
		$skinRow['ZL_BEST_LIST'.$i.'_DESIGN'] = ($skinRow['ZL_BEST_LIST'.$i.'_DESIGN']) ? $skinRow['ZL_BEST_LIST'.$i.'_DESIGN'] : "PB0001"; 
	endfor;

?>

<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/
		$("input[name=zl_slider_use]").bind("click", function() {imageOnOff(this);});					// '메인 이미지 사용' 체크박스 클릭시
		$("input[name^=zl_best_list]").bind("click", function() {imageOnOff(this);});					// '추천 아이템' 체크박스 클릭시
		$("#btnSkinMainListTopImg").bind("click", function() {btnSkinMainListTopImgClickEvent(this);});	// '이미지 탑' 이미지 클릭
	});

	/*-- 이벤트 --*/
	function goProdDisplay()									{selfProdDisplayPopup();}					//커뮤니티 리스트
	function goMainBestImg(be_no, ds_code)						{selfMainBestImgPopup(be_no, ds_code);}		//추천상품 이미지 클릭
	function goLayoutSkinSaveActClickEvent()					{layoutSkinSaveAct();}						//쇼핑몰에 적용 버튼 클릭 할 때
	function goBestChangeValueParentEvent(be_no, ds_code)		{goBestChangeValue(be_no, ds_code);}		//skinProdListDesign.php 에서 받은 이벤트(디자인 변경)
	function goAllBestChangeValueParentEvent(data)				{goAllBestChangeValue(data);}				//skinProdListDesign.php 에서 받은 이벤트(디자인 변경) 전체 변경
	/*-- 이벤트 액션 --*/


	function selfMainBestImgPopup(be_no, ds_code) {
//		$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinMainProdListHtml&prodListOrder='+ic_code+'&subPageCode=<?=$strSubPageCode?>' });
//		var strSubPageCode = $("#subPageCode").val();
//		$.smartPop.open({  bodyClose: false, width: 635, height: 800, url: './?menuType=popup&mode=skinProdListDesign&ic_type=main&ic_code='+ic_code+'&subPageCode='+strSubPageCode});

		var strUrl = './?menuType=popup&mode=skinProdListDesign&ic_type=main&be_no='+be_no+'&ds_code='+ds_code+'&subPageCode=<?=$strSubPageCode?>';
		$.smartPop.open({  bodyClose: false, width: 635, height: 800, url: strUrl});
	}


	function layoutSkinSaveAct() {

		var doc = document.form;
		doc.mode.value		= "act";
		doc.act.value		= "skinMainInfoSave";
		var formData		= $("#form").serialize();
		C_AjaxPost("skinMainInfoSave", "./index.php", formData, "post");

//		C_getAction("skinMainInfoSave", "<?=$PHP_SELF?>");
//		return;

//		var strSubPageCode = $("#subPageCode").val();

//		$.getJSON("./?menuType=layout&mode=json&jsonMode=makeSkinConfFile&subPageCode="+strSubPageCode, function(data) {
//			alert(data[0]["MSG"]);
//		});		
	}


	function btnSkinMainListTopImgClickEvent() {
		$.smartPop.open({  bodyClose: false, width: 800, height: 300, url: './?menuType=popup&mode=skinMainListTopImg&subPageCode=<?=$strSubPageCode?>' });
	}

	function goBestChangeValue(be_no, ds_code) {
		var strVal1 = "javascript:goMainBestImg('"+be_no+"', '"+ds_code+"')";
		var strVal2 = "http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_"+ds_code+".jpg";
		$("#zl_best_list"+be_no+"_use_img > a").attr("href",strVal1);
		$("#zl_best_list"+be_no+"_use_img > a > img").attr("src",strVal2);
	}

	function goAllBestChangeValue(data) {
		$(data).each( function(i){
			var strName		= $(this).val();
			var strObjName1	= "#zl_best_list"+(i+1)+"_use_img";
			var strObjName2 = "#zl_best_list"+(i+1)+"_use";
			if(strName) {
				$(strObjName1).css({'display':''});	
//				$(strObjName2).parent().css({'display':''});	
			} else {
				$(strObjName1).css({'display':'none'});
//				$(strObjName2).parent().css({'display':'none'});
			}
		});
	}


	/* 팝업 이벤트 액션 --*/
	function selfProdDisplayPopup() {
		$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinProdDisplay&subPageCode=<?=$strSubPageCode?>' });
	}

	/* 팝업 닫기 후, 액션 --*/
	function popProdDisplayCloseEvent() {
		goSkinSampleHtml("<?=$strSubPageCode?>");
	}

	function imageOnOff(data) {
		if($(data).attr("checked") == "checked"){
			$("#" + $(data).attr("name") + "_img").css({"display":""});
		} else {
			$("#" + $(data).attr("name") + "_img").css({"display":"none"});
		}
	}

//-->
</script>

<div class="detailLayoutSample">
	<ul>
		<li><img src="/shopAdmin/himg/layout/layout_top_off.gif"/></li>
		<li id="zl_slider_use_img" style="<?=$strSliderUseCss?>"><a href="#" id="btnSkinMainListTopImg"><img src="/shopAdmin/himg/layout/prod_list/top_img.gif"/></a></li>
		<? for($i=1;$i<=5;$i++): 
				$strCss = ($skinRow['ZL_BEST_LIST'.$i.'_NAME'] == "" || $skinRow['ZL_BEST_LIST'.$i.'_USE']!="Y") ? "display:none" : "";				?>
		<li id="zl_best_list<?=$i?>_use_img" style="<?=$strCss?>">
			<a href="javascript:goMainBestImg('<?=$i?>', '<?=$skinRow['ZL_BEST_LIST'.$i.'_DESIGN']?>')">
				<img src="http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_<?=$skinRow['ZL_BEST_LIST'.$i.'_DESIGN']?>.jpg" id="imgProdListDesign"/>
			</a>
		</li>
		<? endfor; ?>
	</ul>
</div>
<div class="layoutSettingInfo">
	<h5><strong>STEP1</strong> 기능영역 사용여부 설정</h5>
	<div class="textInfo">
		* 메인페이지 상품추천 기능 및 추가 기능을 설정합니다.<br/>
		* 사용할 기능은 체크해 주세요.
	</div>
	<ul>
		<li><input type="checkbox" name="zl_slider_use" id="zl_slider_use" value="Y"<?= ($skinRow['ZL_SLIDER_USE']=="Y") ? " checked" : "" ?>> 메인 이미지 사용</li>
		<div id="displayUseArea">
			<? for($i=1;$i<=5;$i++): 
					$strCss = ($skinRow['ZL_BEST_LIST'.$i.'_NAME'] == "") ? "display:none" : "";				?>
			<li style="<?=$strCss?>">
				<input	type="checkbox" name="zl_best_list<?=$i?>_use" id="zl_best_list<?=$i?>_use" value="Y" "<?=($skinRow['ZL_BEST_LIST'.$i.'_USE']=="Y") ? " checked" : "" ?>/><?=$skinRow['ZL_BEST_LIST'.$i.'_NAME']?>
			</li>
			<? endfor; ?>
		</div>
		<li><span>* 추천아이템 아이템명(名)을 변경 하시려면 <a href="javascript:goProdDisplay()">여기를 클릭</a> 하세요. </span>
		</li>
	</ul>
	<?if($MEMBER_LAYER_LOGIN_USE == "Y"):?>
	<ul>
		<div class="textInfo">+ 레이어팝업 사용 여부</div>
		<li><input type="checkbox" name="zl_layerpop_login_use" value="Y"<?=($skinRow['ZL_LAYERPOP_LOGIN_USE']=="Y") ? " checked" : "";?>> 로그인 폼</li>
		<li><input type="checkbox" name="zl_layerpop_join_use" value="Y"<?=($skinRow['ZL_LAYERPOP_JOIN_USE']=="Y") ? " checked" : "";?>> 회원가입 폼</li>

	</ul>
	<?endif;?>
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

