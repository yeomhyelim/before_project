<?php

	## 설정 불러오기

	## 모듈 설정
	$objIconMgrModule = new IconMgrModule($db);
	$objDesignSetModule = new DesignSetModule($db);

	## MAIN 불러오기
	$param = "";
	$param['IC_TYPE'] = "MAIN";
	$param['ORDER_BY'] = "icCodeAsc";
	$aryMainList = $objIconMgrModule->getIconMgrSelectEx("OP_ARYTOTAL", $param);
	$aryMainInfo = "";
	foreach($aryMainList as $key => $data):
		## 기본설정
		$intIC_NO = $data['IC_NO'];
		$intIC_CODE = $data['IC_CODE'];
		$strIC_NAME = $data['IC_NAME'];
		$strIC_IMG = $data['IC_IMG'];
		$strIC_USE = $data['IC_USE'];

		## 사용유무 설정
		if(!$strIC_USE) { $strIC_USE = "N"; }

		## 만들기	
		$aryMainInfo[$intIC_CODE]['NAME'] = $strIC_NAME;
		$aryMainInfo[$intIC_CODE]['IMG'] = $strIC_IMG;
		$aryMainInfo[$intIC_CODE]['USE'] = $strIC_USE;
	endforeach;

	// 샵메인 정보 로드
	$designSetMgr->setDS_TYPE("SKIN_ZL");
	$skinRow			= $designSetMgr->getCodeView($db);
//	echo $db->query;

	## 디자인 설정 불러오기
	$param = "";
	$param['DS_TYPE'] = "SKIN_ZL";
	$aryDesignSetList = $objDesignSetModule->getDesignSetSelectEx("OP_ARYTOTAL", $param);
	$aryDesignSetInfo = "";
	foreach($aryDesignSetList as $key => $data):
		## 기본설정
		$strDS_CODE = $data['DS_CODE'];
		$strDS_VAL = $data['DS_VAL'];

		$aryDesignSetInfo[$strDS_CODE] = $strDS_VAL;
	endforeach;
	$strZL_SLIDER_USE = $aryDesignSetInfo['ZL_SLIDER_USE'];
	$strZL_BEST_LIST1_DESIGN = $aryDesignSetInfo['ZL_BEST_LIST1_DESIGN'];
	$strZL_BEST_LIST2_DESIGN = $aryDesignSetInfo['ZL_BEST_LIST2_DESIGN'];
	$strZL_BEST_LIST3_DESIGN = $aryDesignSetInfo['ZL_BEST_LIST3_DESIGN'];
	$strZL_BEST_LIST4_DESIGN = $aryDesignSetInfo['ZL_BEST_LIST4_DESIGN'];
	$strZL_BEST_LIST5_DESIGN = $aryDesignSetInfo['ZL_BEST_LIST5_DESIGN'];
	$strZL_LAYERPOP_LOGIN_USE = $aryDesignSetInfo['ZL_LAYERPOP_LOGIN_USE']; // 레이어 팝업(로그인) 사용 유무 설정
	$strZL_LAYERPOP_JOIN_USE = $aryDesignSetInfo['ZL_LAYERPOP_JOIN_USE']; // 레이어 팝업(회원가입) 사용 유무 설정	
?>
<script type="text/javascript">

	// 전역 변수 설정
	var strSubPageCode = '<?php echo $strSubPageCode;?>';

	// 시작
	$(function() {

		// 기본설정
		var objTarget = $('.layoutSettingInfo');

		// check 값 변경시 이벤트 발생
		objTarget.find('[type=checkbox]').change(function() {

			// 기본 설정
			var strName = $(this).attr('name');
			var strChecked = $(this).attr('checked');
			if(!strChecked) { strChecked = ''; }
			
			if(strChecked) { 
				$('.' + strName).show();
			} else {
				$('.' + strName).hide();
			}
		});
	});

	// 쇼핑몰에 적용
	function goLayoutSettingActEvent() {
		
		// 기본설정
		var objTarget = $('form[name=form]');

		// 설정
		var strZL_SLIDER_USE = objTarget.find('[name=zl_slider_use]:checked').val();
		var strUse1 = objTarget.find('[name=use_1]:checked').val();
		var strUse2 = objTarget.find('[name=use_2]:checked').val();
		var strUse3 = objTarget.find('[name=use_3]:checked').val();
		var strUse4 = objTarget.find('[name=use_4]:checked').val();
		var strUse5 = objTarget.find('[name=use_5]:checked').val();
		if(!strZL_SLIDER_USE) { strZL_SLIDER_USE = "N"; }
		if(!strUse1) { strUse1 = "N"; }
		if(!strUse2) { strUse2 = "N"; }
		if(!strUse3) { strUse3 = "N"; }
		if(!strUse4) { strUse4 = "N"; }
		if(!strUse5) { strUse5 = "N"; }

		// 전달
		var data = new Object();
		data['menuType'] = 'layout';
		data['mode'] = 'json';
		data['act'] = 'skinSaveZL';
		data['ZL_SLIDER_USE'] = strZL_SLIDER_USE;
		data['use_1'] = strUse1;
		data['use_2'] = strUse2;
		data['use_3'] = strUse3;
		data['use_4'] = strUse4;
		data['use_5'] = strUse5;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
					if(data['__STATE__'] == "SUCCESS") {

						var strSubPageCode		= $("#subPageCode").val();
						$.getJSON("./?menuType=layout&mode=json&jsonMode=makeSkinConfFile&subPageCode="+strSubPageCode, function(data) {
							alert(data[0]["MSG"]);
						});

//						alert("수정되었습니다.");
//						location.reload();
						
					} else {
						var strMsg = data['__MSG__'];
						if(!strMsg) { strMsg = data; }
						alert(data);
					}
			   }
		});
	}

	// 추천아이템 아이템명을 변경하시려면 여기를 클릭 하세요.
	function goLayoutProdDisplayModifyMoveEvent() {

		// ./?menuType=popup&mode=skinProdDisplay&subPageCode=ZL0001
		var strUrl = './?menuType=layout&mode=popSkinProdDisplay&subPageCode=' + strSubPageCode;

		$.smartPop.open({	url: strUrl,
							bodyClose: false, 
							width: 800, 
							height: 300,			
		});
	}

	// Top Image 수정 페이지로 이동
	function goLayoutTopImageModifyMoveEvent() {

		// ./?menuType=popup&mode=skinMainListTopImg&subPageCode=ZL0001
		var strUrl = './?menuType=popup&mode=skinMainListTopImg&subPageCode=' + strSubPageCode;

		$.smartPop.open({	url: strUrl,
							bodyClose: false, 
							width: 800, 
							height: 300,			
		});

	}

	// 메인 상품 베스트 수정
	function goLayoutProdDisplySkinModifyMoveEvent(be_no, ds_code) {

		// ./?menuType=popup&mode=skinMainListTopImg&subPageCode=ZL0001
		var strUrl = './?menuType=popup&mode=skinProdListDesignSet&ic_type=main&be_no=' + be_no + '&ds_code=' + ds_code + '&subPageCode=' + strSubPageCode;

		$.smartPop.open({	url: strUrl,
							bodyClose: false, 
							width: 635, 
							height: 800,			
		});
	}

	// 메인 상품 베스트 수정이 이루어지면 자동 호출
	function goBestChangeValueParentEvent(be_no, ds_code) {

		goLayoutPopCloseEvent();

	}

	// 팝업 닫고 다시 로드
	function goLayoutPopCloseEvent() {

		$.smartPop.close();
		goSkinSampleHtml(strSubPageCode);

	}

</script>
<!-- view //-->
<div class="detailLayoutSample">
	<ul>
		<li><img src="/shopAdmin/himg/layout/layout_top_off.gif"/></li>
		<li class="zl_slider_use" style="<?php if($strZL_SLIDER_USE!="Y"){echo "display:none";}?>">
			<a href="javascript:void(0);" onclick="goLayoutTopImageModifyMoveEvent();"><img src="/shopAdmin/himg/layout/prod_list/top_img.gif"/></a>
		</li>
		<?php foreach($aryMainInfo as $key => $data):
			
				## 기본설정
				$strDsCode = ${"strZL_BEST_LIST{$key}_DESIGN"};
				
				## 체크
				if(!$strDsCode) { $strDsCode = "PB0001"; }
		
		?>
		<li class="use_<?php echo $key;?>" style="<?php if($data['USE']!="Y"){echo "display:none;";}?>">
			<a href="javascript:void(0);" onclick="goLayoutProdDisplySkinModifyMoveEvent(<?php echo $key;?>, '<?php echo $strDsCode;?>');">
				<img src="http://www.eumshop.com/upload/shopDesign/subDesign/sub_prodlist_<?php echo $strDsCode;?>.jpg"/>
			</a>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<!-- view //-->
<!-- setting //-->
<div class="layoutSettingInfo">
	<h5><strong>STEP1</strong> 기능영역 사용여부 설정</h5>
	<div class="textInfo">
		* 메인페이지 상품추천 기능 및 추가 기능을 설정합니다.<br/>
		* 사용할 기능은 체크해 주세요.
	</div>
	<ul>
		<li><input type="checkbox" name="zl_slider_use" value="Y"<?php if($strZL_SLIDER_USE=="Y"){echo " checked";}?> /> 메인 이미지 사용</li>
		<?php foreach($aryMainInfo as $key => $data):				
				## 기본설정
				$strUSE = $data['USE'];
				$strNAME = $data['NAME'];

				## 추천아이템 이름이 없으면 화면에 출력을 하지 않습니다.
				if(!$strNAME) { continue; }
		?>
		<li><input type="checkbox" name="use_<?php echo $key;?>" value="Y"<?php if($strUSE=="Y"){echo " checked";}?> /> <?php echo $strNAME;?></li>
		<?php endforeach;?>
		<li><span>* 추천아이템 아이템명(名)을 변경 하시려면 <a href="javascript:void(0);" onclick="goLayoutProdDisplayModifyMoveEvent();">여기를 클릭</a> 하세요. </span></li>
	</ul>
	<?php if($MEMBER_LAYER_LOGIN_USE == "Y"):?>
	<ul>
		<div class="textInfo">+ 레이어팝업 사용 여부</div>
		<li><input type="checkbox" name="zl_layerpop_login_use" value="Y"<?php if($strZL_LAYERPOP_LOGIN_USE=="Y"){echo " checked";}?> /> 로그인 폼</li>
		<li><input type="checkbox" name="zl_layerpop_join_use" value="Y"<?php if($strZL_LAYERPOP_JOIN_USE=="Y"){echo " checked";}?> /> 회원가입 폼</li>
	</ul>
	<?php endif;?>
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
		<li><a href="javascript:void(0);" onclick="goLayoutSettingActEvent();" class="btn_Big_Blue"><strong>쇼핑몰에 적용</strong></a></li>
	</ul>
</div>
<!-- setting //-->
<div class="clear"></div>