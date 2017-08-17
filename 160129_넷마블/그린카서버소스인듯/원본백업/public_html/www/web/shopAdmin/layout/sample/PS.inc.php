<?
	// 아이콘 관리
	$cateMgr->setIC_TYPE("SUB");
	$aryProdMainList = $cateMgr->getProdDisplayList($db);

	// 샵메인 정보 로드
	$designSetMgr->setDS_TYPE("SKIN_PS");
	$skinRow			= $designSetMgr->getCodeView($db);
	$strSliderUseCss	= ($skinRow['PS_SLIDER_USE']!="Y") ? "display:none" : "" ;

	for($i=1;$i<=5;$i++) :
		$skinRow['PS_BEST_LIST'.$i.'_DESIGN'] = ($skinRow['PS_BEST_LIST'.$i.'_DESIGN']) ? $skinRow['PS_BEST_LIST'.$i.'_DESIGN'] : "PB0001"; 
	endfor;
	$skinRow['PS_BEST_LIST1000_DESIGN'] = ($skinRow['PS_BEST_LIST1000_DESIGN']) ? $skinRow['PS_BEST_LIST1000_DESIGN'] : "PL0001";
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		/*-- 이벤트 --*/
		onPageLoadEvent();																				// 페이지 로드
		$("#btnTopImageUse").bind("click", function() {btnTopImageUseEvent(this);});					// 탑이미지 사용
		$("#btnSubCategoryUse").bind("click", function() {btnSubCategoryUseEvent(this);});				// 서브 카테고리 사용
		$("#btnHitProdAreaUse").bind("click", function() {btnHitProdAreaUseEvent(this);});				// '추천상품 영역 사용' 체크박스 클릭시
		$("#btnSkinProdListTop").bind("click", function() {btnSkinProdListTopEvent(this);});			// '탑이미지' 클릭시
//		$("input[name^=displayUseYN]").bind("click", function() {displayUseClickEvent(this);});			// '추천 아이템' 체크박스 클릭시
		$("input[name^=pl_best_list]").bind("click", function() {imageOnOff(this);});					// '추천 아이템' 체크박스 클릭시

	});

	/*-- 이벤트 --*/
	function goProdDisplay()					{selfProdDisplayPopup();}								//커뮤니티 리스트
//	function goSubBestImg(ic_code)				{selfSubBestImgPopup(ic_code);}							//추천상품 이미지 클릭
	function goMainBestImg(be_no, ds_code)		{selfMainBestImgPopup(be_no, ds_code);}					//추천상품 이미지 클릭
	function goLayoutSkinSaveActClickEvent()	{layoutSkinSaveAct();}									//쇼핑몰에 적용 버튼 클릭 할 때


	/*-- 이벤트 액션 --*/
	function onPageLoadEvent() {
		// 페이지 로드
		btnTopImageUseEvent($("#btnTopImageUse"));
		btnSubCategoryUseEvent($("#btnSubCategoryUse"));
		$("input[name^=pl_best_list]").each(function() {
			imageOnOff(this);
		});
	}

	function btnTopImageUseEvent(data) {
		if(document.form.pl_top_use_op_y.checked){
			$("#liTopImage").css({'display':''});
			$(":input[name=pl_top_use_op]").each(function() {
				$(this).attr('disabled',false);
			});
		}else{
			$("#liTopImage").css({'display':'none'});
			$(":input[name=pl_top_use_op]").each(function() {
				$(this).attr('disabled',true);
			});
		}
	}

	function layoutSkinSaveAct() {


//		C_getAction("skin_ps_InfoSave", "<?=$PHP_SELF?>");
//		return;	

		var doc = document.form;
		doc.mode.value		= "act";
		doc.act.value		= "skin_ps_InfoSave";
		var formData		= $("#form").serialize();
		C_AjaxPost("skin_ps_InfoSave", "./index.php", formData, "post");
	}


	function btnSubCategoryUseEvent(data) {
		if(document.form.pl_sub_cate_use.checked){
			$("#liSubCategoryImage").css({'display':''});
		}else{
			$("#liSubCategoryImage").css({'display':'none'});
		}

	}

	function selfMainBestImgPopup(be_no, ds_code) {

		var strUrl = './?menuType=popup&mode=skinProdListDesign&ic_type=sub&be_no='+be_no+'&ds_code='+ds_code+'&subPageCode=<?=$strSubPageCode?>';
		$.smartPop.open({  bodyClose: false, width: 635, height: 800, url: strUrl});
	
	}

	function btnHitProdAreaUseEvent(data) {
		alert("a");
		if(document.form.pl_top_use_op_y.checked){
			$("#liTopImage").css({'display':''});
		}else{
			$("#liTopImage").css({'display':'none'});
		}
	}

	function btnSkinProdListTopEvent(data) {
		var intLen				= document.form.pl_top_use_op.length;
		var objPL_TOP_USE_OP	= document.form.pl_top_use_op;
		var strType				= "A";
		for(var i=0;i<intLen;i++){
			if(objPL_TOP_USE_OP[i].checked == true){
				strType = objPL_TOP_USE_OP[i].value;
				break;
			}
		}

		if(strType == "A") {
			var strUrl = "./?menuType=popup&mode=skinProdListTopHtml&subPageCode=<?=$strSubPageCode ?>";
			$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: strUrl });
		} else if(strType == "B") {
			var strUrl = "./?menuType=popup&mode=skinProdListTop&subPageCode=<?=$strSubPageCode ?>";
			$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: strUrl });
		}
	}

	function displayUseClickEvent(data) {
		if($(data).attr("checked") == "checked"){
			$("#" + $(data).attr("linkImgID")).css({"display":""});
		} else {
			$("#" + $(data).attr("linkImgID")).css({"display":"none"});
		}
	}

	function selfSubBestImgPopup(ic_code) {
//		$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinSubProdListHtml&prodListOrder='+ic_code+'&subPageCode=<?=$strSubPageCode?>' });
		$.smartPop.open({  bodyClose: false, width: 635, height: 800, url: './?menuType=popup&mode=skinProdListDesign&ic_type=sub&ic_code='+ic_code+'&subPageCode=<?=$strSubPageCode?>'});
	}

	function goBestChangeValue(be_no, ds_code) {
		var strVal1 = "javascript:goMainBestImg('"+be_no+"', '"+ds_code+"')";
		var strVal2 = "http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_"+ds_code+".jpg";
		$("#pl_best_list"+be_no+"_use > a").attr("href",strVal1);
		$("#pl_best_list"+be_no+"_use > a > img").attr("src",strVal2);
	}

	/* 팝업 이벤트 액션 --*/
	function selfProdDisplayPopup() {
//		$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinProdDisplay&ic_type=sub' });
		$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinProdDisplay&subPageCode=<?=$strSubPageCode?>' });
	}

	/* 팝업 닫기 후, 액션 --*/
	function popProdDisplayCloseEvent() {
		goSkinSampleHtml("<?=$strSubPageCode?>");
	}

	function imageOnOff(data) {
		if($(data).attr("checked") == "checked"){
			$("#" + $(data).attr("name")).css({"display":""});
		} else {
			$("#" + $(data).attr("name")).css({"display":"none"});
		}
	}
//-->
</script>

<div class="detailLayoutSample">
	<ul>
		<li><img src="/shopAdmin/himg/layout/layout_top_off.gif"/></li>
		<li id="liTopImage"><a href="#" id="btnSkinProdListTop"><img src="/shopAdmin/himg/layout/prod_list/top_img.gif"/></a></li>
		<li id="liSubCategoryImage"><a href="#" id="btnSkinProdListSubCate"><img src="/shopAdmin/himg/layout/prod_list/list_navi.gif"/></a></li>
		<? for($i=1;$i<=5;$i++): 
				$strCss = ($skinRow['PS_BEST_LIST'.$i.'_NAME'] == "" || $skinRow['PS_BEST_LIST'.$i.'_USE']!="Y") ? "display:none" : "";				?>
		<li id="pl_best_list<?=$i?>_use" style="<?=$strCss?>">
			<a href="javascript:goMainBestImg('<?=$i?>', '<?=$skinRow['PS_BEST_LIST'.$i.'_DESIGN']?>')">
				<img src="http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_<?=$skinRow['PS_BEST_LIST'.$i.'_DESIGN']?>.jpg" id="imgProdListDesign"/>
			</a>
		</li>
		<? endfor; ?>
		<li id="pl_best_list1000_use"><a href="javascript:goMainBestImg('1000', '<?=$skinRow['PS_BEST_LIST1000_DESIGN']?>')" id="btnSkinProdListDesign">
			<img src="http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_<?=$skinRow['PS_BEST_LIST1000_DESIGN']?>.jpg" id="imgProdListDesign" style="width:412px"/>
		</a></li>
	</ul>
</div>
<div class="layoutSettingInfo">
	<h5><strong>STEP1</strong> 기능영역 사용여부 설정</h5>
	<div class="textInfo">
		* 목록페이지의 상세 기능과 레이아웃을 설정합니다.<br/>
		* 사용할 기능은 체크해 주세요.
	</div>
	<ul>
		<li><input type="checkbox" name="pl_top_use_op_y" id="btnTopImageUse" value="Y"<?if(in_array($skinRow['PS_TOP_USE_OP'], array("A","B"))) { echo " checked"; }?>> 탑이미지 사용</li>
			<div class="subChk">
				<input type="radio" name="pl_top_use_op" value="A"<?=($skinRow['PS_TOP_USE_OP']=="A") ? " checked" : "" ?>> 모든 상품페이지에 한개의 이미지만 적용<br>
				<input type="radio" name="pl_top_use_op" value="B"<?=($skinRow['PS_TOP_USE_OP']=="B") ? " checked" : "" ?>> 카테고리별 이미지 업로드 적용
			</div>
		<li><input type="checkbox" name="pl_sub_cate_use" id="btnSubCategoryUse" value = "Y"<?=($skinRow['PS_SUB_CATE_USE']=="Y") ? " checked" : "" ?>> 서브 카테고리 사용</li>

		<!--div id="displayUseArea">
			<? for($i=1;$i<=5;$i++): 
					$strCss = ($skinRow['PS_BEST_LIST'.$i.'_NAME'] == "") ? "display:none" : "";				?>
			<li style="<?=$strCss?>">
				<input	type="checkbox" name="pl_best_list<?=$i?>_use" id="pl_best_list<?=$i?>_use" value="Y" "<?=($skinRow['PS_BEST_LIST'.$i.'_USE']=="Y") ? " checked" : "" ?>/><?=$skinRow['PS_BEST_LIST'.$i.'_NAME']?>
			</li>
			<? endfor; ?>
		</div-->


		<!--li>
			<span>* 추천영역은 "상품관리 > 진열장 관리"에서 사용여부를 먼저 설정해 주세요.   </span>
			<span>&nbsp;&nbsp;&nbsp;진열장 관리에서 먼저 설정하시려면 <a href="javascript:goProdDisplay()">여기를 클릭</a> 하세요. </span>
		</li-->
	</ul>

	<h5 class="mt60"><strong>STEP2</strong> 상품목록 페이지 설정</h5>
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

