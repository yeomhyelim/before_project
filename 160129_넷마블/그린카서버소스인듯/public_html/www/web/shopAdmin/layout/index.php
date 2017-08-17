<?
	if($S_LAYOUT_VERSION):
		if(in_array($strMode, array("sliderBannerList","sliderBannerWrite","sliderBannerModify","skinList"))):
			$strLayoutVersion = $S_LAYOUT_VERSION;
			$strLayoutVersionLower = strtolower($strLayoutVersion);
			include_once MALL_HOME . "/web/shopAdmin/layout_{$strLayoutVersionLower}/index.php";
//			header("Location:./?menuType=layout_{$strLayoutVersionLower}&mode={$strMode}");
			exit;
		endif;
	endif;
	if($strMode == "json" && in_array($strAct, array("skinSave","skinSaveZL","prodDisplayModify","skinSavePL"))):
		include "json2.php";
		exit;
	endif;

	require_once MALL_CONF_LIB."DesignSetMgr.php";
	require_once MALL_CONF_LIB."SliderBannerMgr.php";
	require_once MALL_CONF_LIB."ContentMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";
	
	
	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once "_function.lib.inc.php";
	require_once "_conf.inc.php";
	
	$boardMgr			= new BoardMgr();	
	$designSetMgr		= new DesignSetMgr();	
	$sliderBannerMgr	= new SliderBannerMgr();
	$contentMgr			= new ContentMgr();
	$cateMgr			= new CateMgr();	


//	require_once MALL_CONF_LIB."MemberMgr.php";
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField					= $_POST["searchField"]		? $_POST["searchField"]					: $_REQUEST["searchField"];
	$strSearchKey					= $_POST["searchKey"]		? $_POST["searchKey"]					: $_REQUEST["searchKey"];
	$intPage						= $_POST["page"]			? $_POST["page"]						: $_REQUEST["page"];

	$strSubPageCode					= $_POST["subPageCode"]		? $_POST["subPageCode"]					: $_REQUEST["subPageCode"];
	$strPageDesign					= $_POST["pageDesign"]		? $_POST["pageDesign"]					: $_REQUEST["pageDesign"];
	$strSubPageDesign				= $_POST["subPageDesign"]	? $_POST["subPageDesign"]				: $_REQUEST["subPageDesign"];

	$strOrg							= $_POST["org"]				? $_POST["org"]							: $_REQUEST["org"];			
		
	$intSB_NO						= $_POST["sb_no"]			? $_POST["sb_no"]						: $_REQUEST["sb_no"];
	$intCP_NO						= $_POST["cp_no"]			? $_POST["cp_no"]						: $_REQUEST["cp_no"];
	$intCP_GROUP					= $_POST["cp_group"]		? $_POST["cp_group"]					: $_REQUEST["cp_group"];
//	$strPolicyLng					= $_POST['policyLng']		? $_POST['policyLng']					: $_REQUEST['policyLng'];
	$intSB_NO						= $_POST["sb_no"]			? $_POST["sb_no"]						: $_REQUEST["sb_no"];		// 움직이는 배너

	/*##################################### Parameter 셋팅 #####################################*/

	/*##################################### Act Page 이동 #####################################*/

	if ($strMode == "act" || $strMode == "json" || SUBSTR($strMode,0,3) == "pop"){
		include $strIncludePath.$strMode.".php";
		exit;
	}

	if ($strMode == "skinSample"){
		include $strIncludePath."sample/".$strSubPageCode.".inc.php";
		exit;
	}

	/*##################################### Act Page 이동 #####################################*/

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "002";
	/* 관리자 권한 설정 */


?>
<? include "./include/header.inc.php"?>

<?
	
	switch($strMode){
		case "cssFileEdit":
			// CSS 파일 설정
			$cssFile	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/css/{$S_SHOP_HOME}_style.css";
		break;
		case "jsFileEdit":
			// JS 파일 설정
			$jsFile		= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/js/{$S_SHOP_HOME}_script.js";
		break;
		case "layoutSave":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */
			
//			$designSetMgr->setDS_TYPE("MAIN_INTRO");
//			$aryDesignInfo = $designSetMgr->getCodeView($db);

			$designSetMgr->setDS_TYPE("LAYOUT");
			$layoutRow = $designSetMgr->getCodeView($db);
			
			$layoutRow['TYPE']			= substr($layoutRow['DM_CODE'],0,1);
			$layoutRow['CODE']		= substr($layoutRow['DM_CODE'],1,4);

		break;
	
		case "introSave":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */

			$designSetMgr->setDS_TYPE("INTRO");
			$row = $designSetMgr->getCodeView($db);

			if($row['WEB_LOGO_IMG']) {
				if($row['WEB_LOGO_TYPE'] == "I"){
					$strWebLogoImg = "<img src='"  .$row['WEB_LOGO_IMG'] . "' style=\"width:200px;height:50px\" />";
				} else if ($row['WEB_LOGO_TYPE'] == "F"){
					$strWebLogoImg = "<script type=\"text/javascript\">insertFlash(\"".$row['WEB_LOGO_IMG']."\", '174', '76', \"#FFFFFF\", \"\");</script>";
				}
			}

			if($row['MOB_LOGO_IMG']) :
				$strMobLogoImg = "<img src='"  .  $row['MOB_LOGO_IMG'] . "' style=\"width:200px;height:50px\" />";
			endif;	

		break;	
		
		case "pageDesignSave":
			// 페이지디자인설정
			//	- M		-> main
			//	- S		-> sub
			//	- P		-> product
			//	- O		-> order
			//	- E		-> member
			//	- B		-> community
			//  - H		-> 입점사

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			$designSetMgr->setDS_TYPE("LAYOUT");
			$layoutRow			= $designSetMgr->getCodeView($db);
			$strLayoutType		= substr($layoutRow['DM_CODE'],0,1);

			$strPageDesign		= (!$strPageDesign) ? "MH" : $strPageDesign;
			$aryPageDesignName1	= array("M" => "main", "S" => "sub", "P" => "productList", "O" => "order", "E" => "member", "B" => "community", "R" => "brand", "V" => "productView", "Y" => "mypage", "C" => "myCommunity","H" => "shop");
			$aryPageDesignName2	= array("H" => "html", "T" => "top", "D" => "body", "B" => "bottom", "L" => "left", "R" => "right");
			
			/* 레이아웃 include 파일 경로 */
			$incFile			= sprintf("%spageDesignLayout/layout_%s_%s.inc.php", $strIncludePath, $strLayoutType, substr($strPageDesign,0,1));		
			
			if($strSubPageDesign) { $strSubPageName = "_{$strSubPageDesign}"; }

			// 현재 적용된 소스, 수정되어진 소스
			$userEditFile		= sprintf( "%s%s/layout/html/tag_%s_%s%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, 
												$aryPageDesignName1[substr($strPageDesign,0,1)], $aryPageDesignName2[substr($strPageDesign,1,1)], $strSubPageName );

			## 2013.05.29
			## 메인 하단 영역 다국어 파일로 변경
			if($strPageDesign == "MB"):
				// 변환된 소스코드 저장 경로
				$userEditFile		= sprintf( "%s%s/layout/html/%s/tag_%s_%s%s.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, strtolower($strStLng), 
												$aryPageDesignName1[substr($strPageDesign,0,1)], $aryPageDesignName2[substr($strPageDesign,1,1)], $strSubPageName );
			endif;
			if($strOrg == "Y") :
				// 오리지널 소스. 최초 소스.
				$userEditFile	= sprintf( "%spageDesignCode/%s/%s_%s%s.inc.php", $strIncludePath, $layoutRow['DM_CODE'],
												$aryPageDesignName1[substr($strPageDesign,0,1)], $aryPageDesignName2[substr($strPageDesign,1,1)], $strSubPageName );
			endif;
			
		break;

		case "sliderBannerList":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "005";
			/* 관리자 Sub Menu 권한 설정 */

			/* 데이터 리스트 */
			$intTotal								= $designSetMgr->getDesignSliderBannerList( $db, "COUNT" );							// 데이터 전체 개수 

			$intPageLine							= 10;																				// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
			$designSetMgr->setLimitFirst( $intFirst );
			$designSetMgr->setPageLine( $intPageLine );
			

			$result							= $designSetMgr->getDesignSliderBannerList( $db );	

			$intPageBlock					= 10;																// 블럭 개수 
			$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );					// 번호
			$intTotPage						= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */

			/*
			$intPageBlock = 10;
			$intPageLine  = 20;

			$sliderBannerMgr->setPageLine($intPageLine);
			$sliderBannerMgr->setSearchStatusY($strSearchStatusY);
			$sliderBannerMgr->setSearchStatusN($strSearchStatusN);
			$sliderBannerMgr->setSearchKey($strSearchKey);

			$intTotal	= $sliderBannerMgr->getSliderTotal($db);			
			$intTotPage	= ceil($intTotal / $intPageLine);

			if(!$intPage)	$intPage =1;
			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$sliderBannerMgr->setLimitFirst($intFirst);
			$result = $sliderBannerMgr->getSliderList($db);		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			*/

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";
			
		break;

		case "sliderBannerModify":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "005";
			/* 관리자 Sub Menu 권한 설정 */

			$designSetMgr->setSB_NO($intSB_NO);	
			$bannerRow				= $designSetMgr->getDesignSliderBannerView($db);
			$bannerImgResult		= $designSetMgr->getDesignSliderBannerImgList($db);
		
		break;

		case "skinSave":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "004";
			/* 관리자 Sub Menu 권한 설정 */

			$designSetMgr->setDS_TYPE("LAYOUT");
			$layoutRow = $designSetMgr->getCodeView($db);
		break;

		case "contentList":
			

			## STEP 1.
			## 설정
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			$intPageBlock = 10;
			$intPageLine  = 10;

			## STEP 2.
			## 전체 개수
			if(!$strStLng) { $strStLng = $S_SITE_LNG; }
			$contentMgr->setCP_LNG($strStLng);
			$contentMgr->setSearchStatusY($strSearchStatusY);
			$contentMgr->setSearchStatusN($strSearchStatusN);
			$contentMgr->setSearchKey($strSearchKey);
			$intTotal	= $contentMgr->getContentList($db, "OP_COUNT");			




			$contentMgr->setPageLine($intPageLine);
			$intTotPage	= ceil($intTotal / $contentMgr->getPageLine());

			if(!$intPage)	$intPage =1;
			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}

			$contentMgr->setLimitFirst($intFirst);
			$result = $contentMgr->getContentList($db);		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&page=";
			
		break;
		
		case "contentModify":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "002";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			if(!$strStLng) { $strStLng = $S_SITE_LNG; }
			$contentMgr->setCP_GROUP($intCP_GROUP);
			$contentMgr->setCP_LNG($strStLng);
			$row = $contentMgr->getContentList($db, "OP_SELECT");

			## editor 파일 저장 경로 설정
			$strEditorDir = "layout/content";

		break;
	}
	
	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}
?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();	
	
		$('input[name=searchOutStartDt]').simpleDatepicker();
		$('input[name=searchOutEndDt]').simpleDatepicker();
		<? /* 레이아웃 설정 - 타입 선택 이벤트 */ 
			
			if ($strMode == "layoutSave"){
		?>
		$("#dl_codeTemp").live("click",function()	{
			var strDmCode		= document.form.dm_code.value;
			var strDmType		= $(this).val();
			$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getMainDesignListHtml&dm_type=" + strDmType + "&dm_code=" + strDmCode + "&callback=?", function(data) {
				
				$("#useDesign").html(data[0]["USE_DESIGN"]);
				$("#designSample").html(data[0]["DESIGN_SAMPLE"]);
			});
		} );

		$.getJSON("http://www.eumshop.com/api/json/shopDesign.json.php?act=getMainDesignListHtml&dm_code=<?=$layoutRow['DM_CODE']?>&callback=?", function(data) {
			
			$("#useDesign").html(data[0]["USE_DESIGN"]);
			$("#designSample").html(data[0]["DESIGN_SAMPLE"]);
		});
		<?}?>

		<?if ($strMode == "sliderBannerWrite" || $strMode == "sliderBannerModify"){?>
		$("#btnSkinSliderBanner").bind("click", function() {

			var strSubPageCode = "B0001";
			$.smartPop.open({  bodyClose: false, width: 600, height: 700, url: './?menuType=popup&mode=skinSliderBanner&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
		});
		<?}?>

		<? if($strMode == "layoutSave" && $S_LAYOUT_SETUP_USE != "Y" ): ?>
		$(".contentWrap").attr("style","background:#efefef;opacity:1");
		<? endif; ?>
	});	
	
	var strNo = null;
	function changeLayoutType(no, strDmCode) {
		// 샘플 이미지 클릭시, 선택 표시
		strNo												= no;
		document.form.dm_code.value			= strDmCode;

		$("#designSample a").css( "border", "5px solid #fff" );
		$("#designSample a").hover ( function() {
			if( strNo != $(this).index() ) {
				$(this).css( "border"		, "5px solid #e5e5e5" );
			}
		}, function() {
			if( strNo != $(this).index() ) {
				$(this).css( "border"		, "5px solid #fff" );
			}
		} );
		$("#designSample a").eq(no).css("border", "5px solid #ff0000");		
	}

	function goDesignlayoutAct(mode){	
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	// 세부페이지 카테고리 클릭 이벤트
	function goSkinSampleHtml(code)
	{
		var url = './?menuType=layout&mode=json&jsonMode=subPageCodeVal&subPageCode=' + code;
		$.getJSON(url, function(data) {
			var strSubPageCode = data[0]["RET"];
			$("#subPageCode").val(strSubPageCode);
			C_AjaxPost("SAMPLE_HTML","./?menuType=layout&mode=skinSample&subPageCode="+strSubPageCode,"","post");
		});
	}

	function goSkinSampleHtmlReturn(code, img)
	{
		$("#imgProdListDesign").attr("src",img);
	}

	function goAjaxRet(name,result){
		if (name == "SAMPLE_HTML")
		{
			var html = result;
			$("#skinSampleView").html("");
			$("#skinSampleView").html(html);

			
			/* 샘플 페이지의 팝업창은 여기서 선언 */
			/* 상품관련 링크 */
//			$("#btnSkinProdListDesign").bind("click", function() {
//				var strSubPageCode = $("#subPageCode").val();
//				$.smartPop.open({  bodyClose: false, width: 635, height: 800, url: './?menuType=popup&mode=skinProdListDesign&subPageCode='+strSubPageCode});
//			});

//			$("#btnSkinProdListTop").bind("click", function() {
//				var strSubPageCode = $("#subPageCode").val();
//				$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinProdListTop&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
//			});
			/* 상품관련 링크 */

			/* 메뉴관련 링크 */
			$("#btnSkinMenuTopImg").bind("click", function() {
				var strSubPageCode		= $("#subPageCode").val();
				var strDmCode			= $("#dm_code").val();
				$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinMenuTop&dm_code='+ strDmCode +'&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
			});
			/* 메뉴관련 링크 */

			/* 메인상품 진열관리 */
//			$("#btnSkinMainProdList").bind("click", function() {
//				var strSubPageCode = $("#subPageCode").val();
//				$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinMainProdList&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
//			});
			/* 메인상품 진열관리 */

			/* 상품관련 / 상품상세보기 / 버튼 */
			$("#btnSkinProdViewBtn").bind("click", function() {
				var strSubPageCode = $("#subPageCode").val();
				$.smartPop.open({  bodyClose: false, width: 600, height: 700, url: './?menuType=popup&mode=designSkinBtnList&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
			});
			/* 상품관련 / 상품상세보기 / 버튼 */

			/* 상품관련 / 상품상세보기 / 이미지 */
			$("#btnSkinProdViewImg").bind("click", function() {
				var strSubPageCode = $("#subPageCode").val();
				$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinProdViewImg&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
			});
			/* 상품관련 / 상품상세보기 / 이미지 */
			
			/* 상품관련 / 상품상세보기 / 사용후기,상품Qna관리 */
			$("#btnSkinProdReview").bind("click", function() {
				var strSubPageCode = $("#subPageCode").val();
				$.smartPop.open({  bodyClose: false, width: 800, height: 700, url: './?menuType=popup&mode=skinProdViewReview&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
			});
			/* 상품관련 / 상품상세보기 / 사용후기,상품Qna관리 */

			/* 메인 / 움직이는 배너 / 이미지 */
//			$("#btnSkinSliderBannerList").bind("click", function() {
//				var strSubPageCode = $("#subPageCode").val();
//				$.smartPop.open({  bodyClose: false, width: 600, height: 700, url: './?menuType=popup&mode=skinSliderBanner&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
//			});
			/* 메인 / 움직이는 배너 / 이미지 */

			/* 메인화면 Top Menu 관리 */
			$("#btnSkinMainTopMenu").bind("click", function() {
				var strSubPageCode = $("#subPageCode").val();
				$.smartPop.open({  bodyClose: false, width: 600, height: 700, url: './?menuType=popup&mode=designSkinBtnList&subPageCode='+strSubPageCode+'&btnCode=T', closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
			});
			
			/* 상품리스트 서브 카테고리창 사용여부 */
			$("#btnSkinProdListSubCate").bind("click", function() {
				var strSubPageCode = $("#subPageCode").val();
				$.smartPop.open({  bodyClose: false, width: 600, height: 700, url: './?menuType=popup&mode=skinProdListSubCate&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
			});

			/* 퀵메뉴 / 진열관리 */
			$("#btnSkinQuickMenuSet").bind("click", function() {
				var strSubPageCode = $("#subPageCode").val();
				$.smartPop.open({  bodyClose: false, width: 600, height: 700, url: './?menuType=popup&mode=skinQuickMenuList&subPageCode='+strSubPageCode, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
			});
		}

		/* 생성 */
		if(name == "skinMainInfoSave" || name == "skin_pl_InfoSave" || name == "skin_ps_InfoSave" || name == "skin_pj_InfoSave" || name == "skin_ph_InfoSave") {
			var strSubPageCode		= $("#subPageCode").val();
			$.getJSON("./?menuType=layout&mode=json&jsonMode=makeSkinConfFile&subPageCode="+strSubPageCode, function(data) {
				alert(data[0]["MSG"]);
			});	
		}
		
	}

	function goClose() {
		$.smartPop.close();
	}

	function goIntroAct()
	{
		document.form.encoding = "multipart/form-data";
		C_getAction("introSave","<?=$PHP_SELF?>");				
	}


	function goMoveUrl(mode,no){		
		switch (mode){

			case "sliderBannerModify":	
				document.form.sb_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			case "sliderBannerList":
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			case "sliderBannerDelete":
				var  x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 데이타를 삭제하시겠습니까? 
				if (x == true)
				{
					document.form.sb_no.value = no;	
					C_getAction(mode,"<?=$PHP_SELF?>")
				}				
			break;
			case "contentList":
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;
			case "contentModify":	
				document.form.cp_group.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;
			case "contentDelete":
				var  x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>");
				if (x == true)
				{
					document.form.cp_group.value = no;	
					C_getAction(mode,"<?=$PHP_SELF?>")
				}				
			break;

		} // switch
		return;		
	}

	function goAddSlideBanner()
	{
		var objCopyRow = $("#tabSlideBanner tr:eq(4)").clone();
		var intTrCnt = $("#tabSlideBanner tr").length -	4;
		
		if (intTrCnt > 9)
		{
			alert("<?=$LNG_TRANS_CHAR['BS00068']?>"); //적용이미지는 10개이하만 등록 가능합니다.
			return;
		}

		intTrCnt = intTrCnt + 1;
		
		objCopyRow.find("input[id=sb_image_file_1]").each(function(i){
			$(this).attr("id",$(this).attr("id").replace("sb_image_file_1","sb_image_file_"+intTrCnt));
			$(this).attr("name",$(this).attr("name").replace("sb_image_file_1","sb_image_file_"+intTrCnt));	
		});

		objCopyRow.find("input[id=sb_image_file_1_bak]").each(function(i){
			$(this).attr("id",$(this).attr("id").replace("sb_image_file_1_bak","sb_image_file_"+intTrCnt + "_bak"));
			$(this).attr("name",$(this).attr("name").replace("sb_image_file_1_bak","sb_image_file_"+intTrCnt + "_bak"));		
		});
		
		objCopyRow.find("input[id^=sb_image_link_]").each(function(i){
			$(this).attr("id",$(this).attr("id").replace("sb_image_link_1","sb_image_link_"+intTrCnt));
			$(this).attr("name",$(this).attr("name").replace("sb_image_link_1","sb_image_link_"+intTrCnt));
		});

		objCopyRow.find("input[id^=sb_images_txt_]").each(function(i){
			$(this).attr("id",$(this).attr("id").replace("sb_images_txt_1","sb_images_txt_"+intTrCnt));
			$(this).attr("name",$(this).attr("name").replace("sb_images_txt_1","sb_images_txt_"+intTrCnt));
		});

		objCopyRow.find(".tdListUl dd:eq(3)").remove();
		
		objCopyRow.find("th:eq(0)").html("<span class=\"numberOrange_"+intTrCnt+" mr5\"></span> <?=$LNG_TRANS_CHAR['BW00115']?>"); //적용이미지 
		objCopyRow.find("input[type=text]").val("");
		objCopyRow.find("img").remove();
		objCopyRow.find("p").remove();
		objCopyRow.find("input[type^=hidden]").val("");
		objCopyRow.find("input[type^=radio]").remove();	

		$("#tabSlideBanner").append(objCopyRow);		
		$("#sb_images_cnt").val(intTrCnt);
	}


	function goContentAct(mode){	
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goPageDesignSaveAct(mode){
		var  x = confirm("<?=$LNG_TRANS_CHAR['BS00069']?>"); //편집 화면에 등록된 내용이 아래외 같이 변경됩니다. \r\n계속 진행하시겠습니까?
		if (x != true) {
			return;
		}
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
	function goOpenWin(mode)
	{
		var url = "./?menuType=<?=$strMenuType?>&mode=" + mode;
		window.open(url,'new','width=600px,height=600px,top=100px,left=100px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');			
	}

	/* 이벤트 정의 */
	function goCssFileEditActEvent() { goCssFileEditAct("cssFileEdit"); }

	function goJsFileEditActEvent() { goJsFileEditAct("jsFileEdit"); }

	function goJsFileEditAct(mode) {
		var  x = confirm("<?=$LNG_TRANS_CHAR['BS00069']?>");
		if (x != true) {return; }
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goCssFileEditAct(mode) {
		var  x = confirm("<?=$LNG_TRANS_CHAR['BS00069']?>");
		if (x != true) {return; }
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	/* 이벤트 정의 */
	function goKrTabPageMove() { goTabPage("<?=$strMode?>", "KR"); }
	function goUsTabPageMove() { goTabPage("<?=$strMode?>", "US"); }
	function goJpTabPageMove() { goTabPage("<?=$strMode?>", "JP"); }
	function goCnTabPageMove() { goTabPage("<?=$strMode?>", "CN"); }
	function goIdTabPageMove() { goTabPage("<?=$strMode?>", "ID"); }
	function goFrTabPageMove() { goTabPage("<?=$strMode?>", "FR"); }

	/* 함수 정의 */
	function goTabPage(mode, lng) {
		location.href = "./?menuType=layout&mode="+mode+"&lang="+lng;
	}

//-->
</script>


<? if($strMode == "layoutSave" && $S_LAYOUT_SETUP_USE != "Y" ): ?>

<div style="position:absolute;width:300px;height:100px;left:300px;top:200px;background:#FFFFFF;border:5px solid #42434c;z-index:1001;text-align:center;">
<br><br><br><?=$LNG_TRANS_CHAR["BS00070"] //디자인 별도타입이므로 수정할 수 없습니다.?></div>
<!--div style="position:absolute;width:100%;height:667px;left:175px;top:75px;background:#000000;filter:alpha(opacity=90);opacity: 0.1;-moz-opacity:0.3;"></div-->
	
<? endif; ?>


<!-- ******************** TopArea ********************** -->
	<? include "./include/top.inc.php"?>
<!-- ******************** TopArea ********************** -->
	<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="leftWrap">
				<!-- ******************** leftArea ********************** -->
					<?include "./include/left.inc.php"?>
				<!-- ******************** leftArea ********************** -->
			</td>
			<td class="contentWrap" style="min-width:1200px;">
				<div class="bodyTopLine"></div>
				<!-- ******************** contentsArea ********************** -->
				<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="">
						<input type="hidden" name="jsonMode" value="">
						<input type="hidden" name="page" value="<?=$intPage?>">
						<input type="hidden" name="dm_code" id="dm_code" value="<?=$layoutRow['DM_CODE']?>">
						<input type="hidden" name="subPageCode" id="subPageCode" value="">
						<input type="hidden" name="sb_no" value="<?=$intSB_NO?>">
						<input type="hidden" name="cp_group" value="<?=$intCP_GROUP?>">
						<input type="hidden" name="lang" value="<?=$strStLng?>">
						<?
							include $includeFile;
						?>
					</form>
				</div>
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
	</div>
<!-- ******************** footerArea ********************** -->
	<?include "./include/bottom.inc.php"?>
<!-- ******************** footerArea ********************** -->
</body>
</html>

