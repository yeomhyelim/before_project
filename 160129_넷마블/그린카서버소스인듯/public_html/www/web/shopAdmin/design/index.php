<?

	require_once MALL_CONF_LIB."MemberMgr.php";
 	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once MALL_CONF_LIB."ContentMgr.php";
	require_once MALL_CONF_LIB."ProdpageMgr.php";
	require_once MALL_CONF_LIB."SliderbannerMgr.php";
	require_once MALL_CONF_LIB."SubtopMgr.php";
	require_once MALL_CONF_LIB."MaindesignMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";
	
	require_once MALL_CONF_LIB."DesignsampleMgr.php";
	require_once MALL_CONF_LIB."DesignlayoutMgr.php";
	require_once MALL_CONF_LIB."DesignfirstMgr.php";
	require_once MALL_CONF_LIB."DesignMgr.php";					// 디자인 모듈 통합 진행중...
	
	require_once MALL_CONF_LIB."BtnimagesMgr.php";
	require_once MALL_HOME."/scraping/HS_Trace.class.php";

	$cateMgr 				= new CateMgr();							// 카테고리
	$boardMgr				= new BoardMgr();
	$memberMgr			= new MemberMgr();
	$contentMgr				= new ContentMgr();
	$prodpageMgr			= new ProdpageMgr();
	$sliderbannerMgr		= new SliderbannerMgr();
	$subtopMgr				= new SubtopMgr();
	$maindesignMgr		= new MaindesignMgr();
	$designlayoutMgr		= new DesignlayoutMgr();
	$designfirstMgr			= new DesignfirstMgr();
	$designsampleMgr	= new DesignsampleMgr();
	$designMgr				= new DesignMgr();
	$btnimagesMgr			= new BtnimagesMgr();
	$hs							= new HS_Trace();

	/*##################################### Operate Parameter 셋팅 ##########################################*/
	$strSearchField		= $_POST["searchField"]		? $_POST["searchField"]			: $_REQUEST["searchField"];
	$strSearchKey		= $_POST["searchKey"]			? $_POST["searchKey"]			: $_REQUEST["searchKey"];
	$intPage			= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];
	$strLayoutPage		= $_POST["layoutPage"]		? $_POST["layoutPage"]			: $_REQUEST["layoutPage"];			// 레이아웃 페이지 ( main / sub ) 
	$strEditPage		= $_POST["editPage"]			? $_POST["editPage"]			: $_REQUEST["editPage"];			// 레이아웃 에디터 페이지 ( top / body / bottom ... )
	$strLayoutView		= $_POST["layoutView"]		? $_POST["layoutView"]			: $_REQUEST["layoutView"];			// 레이아웃 에디터 편집화면 or 원본화면 설정 (edit, original)

	$intDL_NO			= $_POST["dl_no"]			? $_POST["dl_no"]			: $_REQUEST["dl_no"];
	$intPO_NO			= $_POST["po_no"]			? $_POST["po_no"]			: $_REQUEST["po_no"];
	$intB_NO			= $_POST["b_no"]			? $_POST["b_no"]			: $_REQUEST["b_no"];
	$intA_NO			= $_POST["a_no"]			? $_POST["a_no"]			: $_REQUEST["a_no"];
	$intM_NO			= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	$intCP_NO			= $_POST["cp_no"]			? $_POST["cp_no"]			: $_REQUEST["cp_no"];
	$intPV_NO			= $_POST["pv_no"]			? $_POST["pv_no"]			: $_REQUEST["pv_no"];
	$intSB_NO			= $_POST["sb_no"]			? $_POST["sb_no"]			: $_REQUEST["sb_no"];
	$intTI_NO			= $_POST["ti_no"]			? $_POST["ti_no"]			: $_REQUEST["ti_no"];

	$intDE_NO			= $_POST["de_no"]			? $_POST["de_no"]			: $_REQUEST["de_no"];
	$intDM_NO			= $_POST["dm_no"]			? $_POST["dm_no"]			: $_REQUEST["dm_no"];
	$intBI_NO			= $_POST["bi_no"]				? $_POST["bi_no"]					: $_REQUEST["bi_no"];
	$strBI_GROUP			= $_POST["bi_group"]			? $_POST["bi_group"]				: $_REQUEST["bi_group"];			// 디자인관리 / 이미지관리 / 커뮤니티 등록 => 글쓰기 버튼을 누르면 그룹 번호 받음
	$strPV_PAGE			= $_POST["pv_page"]			? $_POST["pv_page"]			: $_REQUEST["pv_page"];				// 디자인관리 / 상품진열방식 (메인추천,서부추천,카테고리메인,상품목록,상품상세..)
	$strBI_IMAGE_CATE		= $_POST["bi_image_cate"]		? $_POST["bi_image_cate"]			: $_REQUEST["bi_image_cate"];		// 디자인관리 / 이미지관리 / 카테고리 정보
	
	$strSearchStatusY	= $_POST["searchStatusY"]	? $_POST["searchStatusY"]	: $_REQUEST["searchStatusY"];
	$strSearchStatusN	= $_POST["searchStatusN"]	? $_POST["searchStatusN"]	: $_REQUEST["searchStatusN"];

	$strSearchPointType	= $_POST["searchPointType"]	? $_POST["searchPointType"]	: $_REQUEST["searchPointType"];	
	
	$strC_HCODE1			= $_POST["cateHCode1"]			? $_POST["cateHCode1"]			: $_REQUEST["cateHCode1"];
	$strC_HCODE2			= $_POST["cateHCode2"]			? $_POST["cateHCode2"]			: $_REQUEST["cateHCode2"];
	$strC_HCODE3			= $_POST["cateHCode3"]			? $_POST["cateHCode3"]			: $_REQUEST["cateHCode3"];
	$strC_HCODE4			= $_POST["cateHCode4"]			? $_POST["cateHCode4"]			: $_REQUEST["cateHCode4"];
	
	$strBI_IMAGE_CATE 	= strTrim($strBI_IMAGE_CATE,10);

	$designMgr->setBI_IMAGE_CATE($strBI_IMAGE_CATE);	
	/*##################################### Operate Parameter 셋팅 ##########################################*/

	 include "_function.lib.inc.php";
	
	/*##################################### Act Page 이동 ###################################################*/
	if ($strMode == "act" || $strMode == "json"  || SUBSTR($strMode,0,3) == "pop"){
		include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 ###################################################*/

?>
<? include "./include/header.inc.php"?>
<?

	switch($strMode){
		case "designlayoutModify":	
		// 디자인 관리 / 레이아웃 설정

			/* 현재 사용중인 레이아웃 가져오기 */
			$myDesignRow = $designMgr->getDesignLayoutView($db);
	
			/* 샘플 레이아웃 리스트 가져오기 */
			$designMgr->setDM_DESIGN_GROUP("main");
			$designMgr->setDM_DESIGN_TYPE($myDesignRow[DL_CODE]);
			$sampleRow = $designMgr->getDesignMgrList($db);		

			while($row = mysql_fetch_array($sampleRow)) :		
				if ( $row[DM_SAMPLE_IMAGE_1] ) :
					if ( $row[DM_DESIGN_TYPE] == $myDesignRow[DL_CODE] && $row[DM_DESIGN_CODE] == $myDesignRow[DL_DESIGN_CODE] ) :
						$myDesignUrl	= $row[DM_SAMPLE_IMAGE_1];
						break;
					endif;
				endif;
			endwhile;

			/* mysql_fetch_array() 사용후 row 처음 위치로 이동 */
			mysql_data_seek($sampleRow, 0);	

		break;

		case "designfirstModify":	
			// 디자인 관리 / 첫화면 설정
			$row = $designMgr->getDesignLayoutView($db);
		break;
		
		case "logoModify":
			// 디자인 관리 / 이미지 관리  => 메뉴 클릭시
			$designMgr->setBI_NO($intBI_NO);
			$row = $designMgr->getDesignBtnImagesView($db);
			
			
		break;

		//(1) 컨텐츠 추가페이지 
		case "contentList":
			$intPageBlock = 10;
			$intPageLine  = 10;

			$contentMgr->setPageLine($intPageLine);
			$contentMgr->setSearchStatusY($strSearchStatusY);
			$contentMgr->setSearchStatusN($strSearchStatusN);
			$contentMgr->setSearchKey($strSearchKey);

			$intTotal	= $contentMgr->getContentTotal($db);			
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
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";
			
		break;
		
		case "contentModify":
			$contentMgr->setCP_NO($intCP_NO);
			$row = $contentMgr->getContentView($db);
		break;

		//(2) 메인,목록,상세페이지 구성요서 정의
		case "prodpageList":
			
		
			/* 페이지 시작 시점 지정 및 리스트 개수 지정  */
			$intPageBlock				= 10;
			$intPageLine				= 20;
			
			$designMgr->setPageLine($intPageLine);
			
			$designMgr->setPV_PAGE($strPV_PAGE);
			
			$intTotal 					= $designMgr->getProdPageTotal($db);
	
			$intTotPage				= ceil($intTotal / $designMgr->getPageLine());
			
			$intPage					= (!$intPage) ? 1 : $intPage;
			
			if ($intTotal==0) :
				$intFirst				= 1;
				$intLast				= 0;
			else :
				$intFirst				= $intPageLine * ($intPage - 1);
				$intLast				= $intPageLine * $intPage;
			endif;
			
			$designMgr->setLimitFirst($intFirst);
			/* 페이지 시작 시점 지정 및 리스트 개수 지정  */
			
			$result 						= $designMgr->getProdPageList($db);
			$intListNum 				= $intTotal - ($intPageLine *($intPage-1));

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";
			
		break;

		case "prodpageModify":
			$designMgr->setPV_NO($intPV_NO); 
			$row = $designMgr->getProdPageView($db);
		break;

		//(3) 슬라이딩배너
		case "sliderbannerList":
			
			$intPageBlock = 10;
			$intPageLine  = 20;

			$sliderbannerMgr->setPageLine($intPageLine);
			$sliderbannerMgr->setSearchStatusY($strSearchStatusY);
			$sliderbannerMgr->setSearchStatusN($strSearchStatusN);
			$sliderbannerMgr->setSearchKey($strSearchKey);

			$intTotal	= $sliderbannerMgr->getSliderTotal($db);			
			$intTotPage	= ceil($intTotal / $prodpageMgr->getPageLine());

			if(!$intPage)	$intPage =1;
			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$sliderbannerMgr->setLimitFirst($intFirst);
			$result = $sliderbannerMgr->getSliderList($db);		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";
			
		break;

		case "sliderbannerModify":
			$designMgr->setSB_NO($intSB_NO);
			$row = $designMgr->getSliderView($db);
	
		break;

		//(4) 서브탑 이미지관리
		case "subtopList":
			
			$intPageBlock = 10;
			$intPageLine  = 20;

			$subtopMgr->setPageLine($intPageLine);
			$subtopMgr->setSearchStatusY($strSearchStatusY);
			$subtopMgr->setSearchStatusN($strSearchStatusN);
			$subtopMgr->setSearchKey($strSearchKey);

			$intTotal		= $subtopMgr->getSubtopTotal($db);			
			$intTotPage	= ceil($intTotal / $subtopMgr->getPageLine());

			if(!$intPage)	$intPage =1;
			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$subtopMgr->setLimitFirst($intFirst);
			$result = $subtopMgr->getSubtopList($db);		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";
			
		break;

		case "subtopModify":
			$designMgr->setTI_NO($intTI_NO);
			$row = $designMgr->getDesignTopImageView($db);
		break;

 		/* 메인 디자인 직접 편집 */
		case "maindesignModify":
			
			/* 등록된 레이아웃 코드 및 디자인번호 호출 */
			$layoutRow = $designMgr->getDesignLayoutView($db);
			
			$maindesignMgr->setDE_NO($intDE_NO);
			$row = $maindesignMgr->getMaindesignView($db);
		break;

		// 디자인 샘플 관리
		case "DesignsampleWrite":
			$designsampleMgr->getDesignsampleInsert($db);
			$strMsg="디자인 샘플을 등록하였습니다.";
			$strUrl = "./?menuType=".$strMenuType."&mode=designsampleList&".$strLinkPage;
		break;
		case "designsampleList":			
			$intPageBlock = 10;
			$intPageLine  = 20;

			$designsampleMgr->setPageLine($intPageLine);
			$designsampleMgr->setSearchStatusY($strSearchStatusY);
			$designsampleMgr->setSearchStatusN($strSearchStatusN);
			$designsampleMgr->setSearchKey($strSearchKey);

			$intTotal	= $designsampleMgr->getDesignsampleTotal($db);			
			$intTotPage	= ceil($intTotal / $designsampleMgr->getPageLine());

			if(!$intPage)	$intPage =1;
			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$designsampleMgr->setLimitFirst($intFirst);
			$result = $designsampleMgr->getDesignsampleList($db);		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";			
		break;

		case "designsampleModify":
			$designsampleMgr->setDM_NO($intDM_NO);
			$row = $designsampleMgr->getDesignsampleView($db);
		break;
		
		case "imgstyle2":
			
			if( !$strBI_GROUP ) :
				$layoutRow 				= $designMgr->getDesignLayoutView($db);
				if ( $strBI_IMAGE_CATE == "common") :
					$strBI_GROUP_COL_NAME = "DL_COMMON_ID";
				elseif ( $strBI_IMAGE_CATE == "product") :
					$strBI_GROUP_COL_NAME = "DL_PRODUCT_ID";
				elseif ( $strBI_IMAGE_CATE == "member") :
					$strBI_GROUP_COL_NAME = "DL_MEMBER_ID";
				elseif ( $strBI_IMAGE_CATE == "community") :
					$strBI_GROUP_COL_NAME = "DL_COMMUNITY_ID";
				endif;
				$strBI_GROUP 				= $layoutRow[$strBI_GROUP_COL_NAME];
			endif;
			
			$designMgr->setBI_GROUP($strBI_GROUP);
			
			$designMgr->setDM_NO($strBI_GROUP);
			$designRow 					= $designMgr->getDesignMgrView($db);
			
			/* 페이지 시작 시점 지정 및 리스트 개수 지정  */
			$intPageBlock				= 10;
			$intPageLine				= 20;
				
			$designMgr->setPageLine($intPageLine);
				
			$designMgr->setPV_PAGE($strPV_PAGE);
				
			$intTotal 					= $designMgr->getDesignBtnImageTotal($db);
			
			$intTotPage				= ceil($intTotal / $designMgr->getPageLine());
				
			$intPage					= (!$intPage) ? 1 : $intPage;
				
			if ($intTotal==0) :
				$intFirst				= 1;
				$intLast				= 0;
			else :
				$intFirst				= $intPageLine * ($intPage - 1);
				$intLast				= $intPageLine * $intPage;
			endif;
				
			$designMgr->setLimitFirst($intFirst);
			/* 페이지 시작 시점 지정 및 리스트 개수 지정  */
				
			$result 						= $designMgr->getDesignBtnImageList($db);
			$intListNum 				= $intTotal - ($intPageLine *($intPage-1));
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";
			
		break;
		
		case "imgStyle2Write":

			$designMgr->setDM_NO($strBI_GROUP);
			$designRow = $designMgr->getDesignMgrView($db);

		break;
		
		case "imgStyle2Modify":
			$designMgr->setDM_NO($strBI_GROUP);
			$designRow 	= $designMgr->getDesignMgrView($db);
			$designMgr->setBI_NO($intBI_NO);
			$row			= $designMgr->getDesignBtnImagesView($db);
	
		break;
		
	}

	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}

?>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";
	$(document).ready(function(){

		designLayoutModify();	

		category();

		
	});

	function category ( ) {
		// 카테고리 정의
		<?		if ( $strMode == "subtopWrite" || $strMode == "subtopModify" )		{		?>

			var cateHCode1 = "<?= SUBSTR($row['TI_CATE_CODE'],0,3) ?>";
			var cateHCode2 = "<?= SUBSTR($row['TI_CATE_CODE'],3,3) ?>";
			var cateHCode3 = "<?= SUBSTR($row['TI_CATE_CODE'],6,3) ?>";
			var cateHCode4 = "<?= SUBSTR($row['TI_CATE_CODE'],9,3) ?>";

			callCateList(1,"","","cateHCode1",cateHCode1);
			if(cateHCode1) {
				callCateList(2,cateHCode1,"","cateHCode2",cateHCode2);
				callCateList(3,cateHCode2,"","cateHCode3",cateHCode3);
				callCateList(4,cateHCode3,"","cateHCode4",cateHCode4);
			}
			
			var strHCode = "";
			
			$("#cateHCode1").change(function() {			
				if ($(this).val())
				{
					callCateList(2,$(this).val(),"","cateHCode2","");
				}
			});
	
			$("#cateHCode2").change(function() {			
				if ($(this).val())
				{
					strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
					callCateList(3,strHCode,"","cateHCode3","");
				}
			});
	
			$("#cateHCode3").change(function() {			
				if ($(this).val())
				{
					strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
					callCateList(4,strHCode,"","cateHCode4","");
				}
			});	
		
		<?		}	?>
	}

	function designLayoutModify ( ) {
		// 레이아웃 타입 변경시 해당 샘플 이미지 로드

		<?		if ( $strMode == "designlayoutModify" )		{		?>

			$("#dl_codeTemp").live("click",function()	{
				var strDesignType		= $(this).val();
				var strDesignGroup		= "main";
				var strJsonParam		= "menuType=<?=$strMenuType?>&mode=json&jsonMode=designTypeChange&dm_design_type=" + strDesignType;
					 strJsonParam		= strJsonParam + "&dm_design_group=" + strDesignGroup;
				var strCode				= document.form.dl_code.value;
				var strDesignCode		= document.form.dl_design_code.value;
				$.ajax ( {	 type:"POST", url:"./index.php", data :strJsonParam, dataType:"json",  success:function(data) {	
						if ( data[0].RET == "Y" ) {
							var html = "";
							for ( var i = 0 ; i < data.length ; i++ ) {
								if ( strCode == data[i].DM_DESIGN_TYPE && strDesignCode == data[i].DM_DESIGN_CODE ) {
									html += "<a href=\"javascript:changeLayoutType('" + i + "','" + data[i].DM_DESIGN_TYPE + "','" + data[i].DM_DESIGN_CODE + "')\"  class=\"imgSelected\"><img src='" + data[i].DM_SAMPLE_IMAGE_1 + "' /></a>";
								} else {
									html += "<a href=\"javascript:changeLayoutType('" + i + "','" + data[i].DM_DESIGN_TYPE + "','" + data[i].DM_DESIGN_CODE + "')\"><img src='" + data[i].DM_SAMPLE_IMAGE_1 + "' /></a>";
								}
							}
							$( "#designSample" ).html( html );
						} else {
							alert ("등록된 레이아웃이 없습니다.");
						}
					} // success function
				}); // ajax function
			});	// click function

		<?		}	?>
	}

	var strNo = null;
	function changeLayoutType(no, strCode, strDesignCode) {
		// 샘플 이미지 클릭시, 선택 표시
		strNo												= no;
		document.form.dl_code.value				= strCode;
		document.form.dl_design_code.value	= strDesignCode;
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

	function goContentAct(mode){
		if(!C_chkInput("cp_page_name", true, "제목")) return;
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goProdpageAct(mode){	
		if(!C_chkInput("pv_image_size_w", true, "가로사이즈")) return;
		if(!C_chkInput("pv_image_size_h", true, "세로사이즈")) return;
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goSliderbannerAct(mode){	
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goSubtopAct(mode){	
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goDesignlayoutAct(mode){	
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
	function goDesignfirstAct(mode){	
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goMaindesignAct(mode){	
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	// 디자인관리 / 레이아웃 / 페이지 디자인 설정 / 바로 적용하기 버튼 클릭시
	function goAction(mode){	

		if ( mode == "maindesignModify") {
			var  x = confirm("편집 화면에 등록된 내용이 아래외 같이 변경됩니다. \r\n계속 진행하시겠습니까?");
			if (x != true) {
				return;
			}
		}
				
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
	
	// 디자인관리 / 이미지 관리 / 커뮤니티 / 글쓰기 =>  등록 버튼 클긱시
	function goImgStyle2Act(mode) {
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");		
	}

	/* 디자인샘플 관리 */
	function goDesignsampleAct(mode){	
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	// 디자인관리 / 레이아웃 / 이미지관리 => 설정 저장 버튼 클릭시
	function goLogoModifyAct(mode) {
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	/* 카테고리 */
	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView;
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				$("#"+cateObj).html("<option value=''>"+cateLevel+"차 카테고리 선택</option>");
				for(var i=0;i<data.length;i++){
					var strCateSelected = "";
					if (data[i].CATE_CODE == cateSelected)
					{
						strCateSelected = "selected";
					}
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"' "+strCateSelected+">"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}
	
	function goMoveUrl(mode,no){		
		switch (mode){

			//(1) 컨텐츠 
			case "contentModify":				
				document.form.cp_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			case "contentDelete":
				var  x = confirm("선택한 데이타를 삭제하시겠습니까?");
				if (x == true)
				{
					document.form.cp_no.value = no;	
					C_getAction(mode,"<?=$PHP_SELF?>")
				}				
			break;

			case "contentList":
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			//(3) 상품 페이지설정
			case "prodpageModify":				
				document.form.pv_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			case "prodpageMake":	 //설정파일 만들기		
				C_getAction(mode,"<?=$PHP_SELF?>")
			break;

			//(4) 음직이는 배너
			case "sliderbannerModify":	
				document.form.sb_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			case "sliderbannerList":
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			case "sliderbannerDelete":
				var  x = confirm("선택한 데이타를 삭제하시겠습니까?");
				if (x == true)
				{
					document.form.sb_no.value = no;	
					C_getAction(mode,"<?=$PHP_SELF?>")
				}				
			break;

			//(5) 메인디자인 레이아웃
			case "maindesignModify":	
				document.form.de_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;


			//(6) 샘플 디자인 관리
			case "designsampleModify":	
				document.form.dm_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			// 디자인관리 / 서브탑이미지 / 수정
			case "subtopModify":
				document.form.ti_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
			break;

			case "subtopDelete":
				var  x = confirm("선택한 데이타를 삭제하시겠습니까?");
				if (x == true)
				{
					document.form.ti_no.value = no;	
					C_getAction(mode,"<?=$PHP_SELF?>")
				}
			break;

			case "imgStyle2Write":
				// 디자인관리 / 이미지 관리 / 커뮤니티 =>  등록 버튼 클릭시
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");					
			break;

			case "imgStyle2Modify" :
				// 디자인관리 / 이미지 관리 / 커뮤니티 => 수정 버튼 클릭시
				document.form.bi_no.value = no;	
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");	
				

			break;

			case "imgStyle2Delete" :
				var  x = confirm("선택한 데이타를 삭제하시겠습니까?");
				if (x == true)
				{
					document.form.bi_no.value = no;	
					C_getAction(mode,"<?=$PHP_SELF?>")
				}
			break;


		} // switch
		return;		
	}
	/* 디자인타입 선택 팝업 */
	function goDesignSample(page){
		var url = "?menuType=popup&mode=sampleDesign&pv_page=" + page;
		window.open(url,'new','width=1000px,height=700px,top=100px,left=100px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	function goImageGroupPopup(group)
	{
		var url = "?menuType=<?=$strMenuType?>&mode=popImageGroup&dm_design_group=" + group;
		window.open(url,'new','width=1000px,height=700px,top=100px,left=100px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');		
	} 

	function goOpenWin(mode)
	{
		var url = "?menuType=<?=$strMenuType?>&mode=popDesignTagList";
		window.open(url,'new','width=600px,height=600px,top=100px,left=100px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');			
	}
	
	function getParamInput(aryInfo){
		
		if (aryInfo[0] == "SAMPLE")
		{
			$("#pv_design_no").val(aryInfo[1]);
			$("#design_group").text(aryInfo[2]);
			$("#design_type").text(aryInfo[3]);
			$("#design_code").text(aryInfo[4]);
			$("#design_title").text(aryInfo[5]);
			document.form.pv_design_no.value = aryInfo[1];

		}
	}

	// 디자인관리 / 이미지관리 / 커뮤니티 	=> 디자인선택 버튼 클릭으로 새창 뛰어서 선택된 값 리턴시 수행
	// 디자인관리 / 움직이는베너 			=> 디자인 선택
	// 리턴받은 값(버튼 그룹)에 해당하는 이미지 리스트 그리기
	function getImageGroup(aryInfo)
	{
		if ( aryInfo[2] == "slider" ||  aryInfo[2] == "recommend"  ||  aryInfo[2] == "prodview"   ||  aryInfo[2] == "prodlist" ) {
			$("#pv_design_no").val(aryInfo[1]);
			$("#design_group").text(aryInfo[2]);
			$("#design_type").text(aryInfo[3]);
			$("#design_code").text(aryInfo[4]);
			$("#design_title").text(aryInfo[5]);
			if( aryInfo[2] == "slider" ) {
				$("#userTag").text("{{__"+aryInfo[5]+"__}}");
				document.form.sb_banner_name.value = aryInfo[5];
				document.form.sb_design_code.value = aryInfo[4];
			}
			document.form.pv_design_no.value = aryInfo[1];	
			document.form.dm_design_type.value = aryInfo[3];
			document.form.dm_design_code.value = aryInfo[4];		
			return;
		}
		
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&jsonMode=imageListRefresh";
		strJsonParam += "&dm_design_group=" + aryInfo[2] + "&bi_group="+aryInfo[1];
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data) {	
				document.form.bi_group.value = data[0].BI_GROUP_TEMP;
				$("#dataList").html(data[0].DATA_LIST);
			}
		});
		$("#design_title").text(aryInfo[5]);
	}

	function goAddSlideBanner()
	{
		var objCopyRow = $("#tabSlideBanner tr:eq(4)").clone();
		var intTrCnt = $("#tabSlideBanner tr").length -	4;
		
		if (intTrCnt > 9)
		{
			alert("적용이미지는 10개이하만 등록 가능합니다.");
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
		
		objCopyRow.find("th:eq(0)").html("<span class=\"numberOrange_"+intTrCnt+" mr5\"></span> 적용이미지 ");
		objCopyRow.find("input[type=text]").val("");
		objCopyRow.find("img").remove();
		objCopyRow.find("p").remove();
		objCopyRow.find("input[type^=hidden]").val("");
		objCopyRow.find("input[type^=radio]").remove();	

		$("#tabSlideBanner").append(objCopyRow);		
		$("#sb_images_cnt").val(intTrCnt);
	}
//-->
</script>
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
			<td class="contentWrap">
				<div class="bodyTopLine"></div>
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="page" value="<?=$intPage?>">
						<input type="hidden" name="po_no" value="<?=$intPO_NO?>">
						<input type="hidden" name="b_no" value="<?=$intB_NO?>">
						<input type="hidden" name="a_no" value="<?=$intA_NO?>">
						<input type="hidden" name="cp_no" value="<?=$intCP_NO?>">
						<input type="hidden" name="pv_no" value="<?=$intPV_NO?>">
						<input type="hidden" name="sb_no" value="<?=$intSB_NO?>">
						<input type="hidden" name="ti_no" value="<?=$intTI_NO?>">
						<input type="hidden" name="de_no" value="<?=$intDE_NO?>">
						<input type="hidden" name="dm_no" value="<?=$intDM_NO?>">
						<input type="hidden" name="bi_no" value="<?=$intBI_NO?>">
						<input type="hidden" name="dl_no" value="1">
						<input type="hidden" name="dl_code" value="<?=$myDesignRow[DL_CODE]?>">
						<input type="hidden" name="dl_design_code" value="<?=$myDesignRow[DL_DESIGN_CODE]?>">
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