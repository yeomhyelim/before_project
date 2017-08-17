<?
	if($S_IS_POPUP2):
		if(in_array($strMode, array("popupList","popupModify","popupWrite"))):
			include_once MALL_HOME . "/web/shopAdmin/oper2/index.php";
			exit;
		endif;
	endif;
	
	require_once MALL_CONF_LIB."PopupMgr.php";
	require_once MALL_CONF_LIB."BannerMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
 	require_once MALL_CONF_LIB."BoardMgr.php";
	require_once "_function.lib.inc.php";

	$boardMgr = new BoardMgr();
	$popupMgr = new PopupMgr();
	$bannerMgr = new BannerMgr();
	$pointMgr = new PointMgr();
	$orderMgr = new OrderMgr();
	$memberMgr = new MemberMgr();

	/*##################################### Operate Parameter 셋팅 ##########################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$intPO_NO		= $_POST["po_no"]			? $_POST["po_no"]			: $_REQUEST["po_no"];
	$intB_NO		= $_POST["b_no"]			? $_POST["b_no"]			: $_REQUEST["b_no"];
	$intA_NO		= $_POST["a_no"]			? $_POST["a_no"]			: $_REQUEST["a_no"];
	$intM_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	$strSearchStatusY	= $_POST["searchStatusY"]	? $_POST["searchStatusY"]	: $_REQUEST["searchStatusY"];
	$strSearchStatusN	= $_POST["searchStatusN"]	? $_POST["searchStatusN"]	: $_REQUEST["searchStatusN"];


	// 상세 검색
	$strSearchSex			= $_POST["searchSex"]			? $_POST["searchSex"]			: $_REQUEST["searchSex"];				// 성별
	$strSearchPointType		= $_POST["searchPointType"]		? $_POST["searchPointType"]		: $_REQUEST["searchPointType"];			// 포인트 종류
	$strSearchRegStartDt	= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];
	$strSearchExpStartDt	= $_POST["searchExpStartDt"]	? $_POST["searchExpStartDt"]	: $_REQUEST["searchExpStartDt"];
	$strSearchExpEndDt		= $_POST["searchExpEndDt"]		? $_POST["searchExpEndDt"]		: $_REQUEST["searchExpEndDt"];
	$strSearchPointStart	= $_POST["searchPointStart"]	? $_POST["searchPointStart"]	: $_REQUEST["searchPointStart"];
	$strSearchPointEnd		= $_POST["searchPointEnd"]		? $_POST["searchPointEnd"]		: $_REQUEST["searchPointEnd"];
	$strSearchBirthMonth	= $_POST["searchBirthMonth"]	? $_POST["searchBirthMonth"]	: $_REQUEST["searchBirthMonth"];
	$strSearchBirthDay		= $_POST["searchBirthDay"]		? $_POST["searchBirthDay"]		: $_REQUEST["searchBirthDay"];

	if(!$strSearchSex) { $strSearchSex = "T"; }

	/*##################################### Operate Parameter 셋팅 ##########################################*/

	/*##################################### Act Page 이동 ###################################################*/
	if ($strMode == "act" || $strMode == "json"){
		include $strIncludePath.$strMode.".php";
		exit;
	}
	/*##################################### Act Page 이동 ###################################################*/

	/* 관리자 Top 메뉴 권한 설정 */
	$strTopMenuCode = "007";
	/* 관리자 권한 설정 */

?>
<? include "./include/header.inc.php"?>
<?
	switch($strMode){
		case "adverList":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */


			$intPageBlock = 10;
			$intPageLine  = 10;

			$bannerMgr->setPageLine($intPageLine);
			$bannerMgr->setSearchStatusY($strSearchStatusY);
			$bannerMgr->setSearchStatusN($strSearchStatusN);
			$bannerMgr->setSearchKey($strSearchKey);

			$intTotal	= $bannerMgr->getAdvertiseTotal($db);
			
			$intTotPage	= ceil($intTotal / $bannerMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$bannerMgr->setLimitFirst($intFirst);

			$result = $bannerMgr->getAdvertiseList($db);		
		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";

			break;
		
		case "adverModify":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "003";
			/* 관리자 Sub Menu 권한 설정 */

			$bannerMgr->setA_NO($intA_NO);
			$row = $bannerMgr->getAdvertiseView($db);

		break;

		case "popupList":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$intPageBlock = 10;
			$intPageLine  = 10;

			$popupMgr->setPageLine($intPageLine);
			$popupMgr->setSearchStatusY($strSearchStatusY);
			$popupMgr->setSearchStatusN($strSearchStatusN);
			$popupMgr->setSearchKey($strSearchKey);

			$intTotal	= $popupMgr->getTotal($db);
			
			$intTotPage	= ceil($intTotal / $popupMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$popupMgr->setLimitFirst($intFirst);

			$result = $popupMgr->getList($db);		
		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";

		break;

		case "popupModify":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$popupMgr->setPO_NO($intPO_NO);
			$row = $popupMgr->getView($db);
		break;

		case "bannerWrite":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			/* 배너 그룹 관리(광고 관리) 위치 정보 리스트 가져오기 */
			$arrAdvertiseListRow = $bannerMgr->getAdvertiseListAll($db);
			
			while($alRow = mysql_fetch_array($arrAdvertiseListRow))
			{
				$arrGrp[$alRow[A_NO]] = $alRow[A_NAME];
				
			} // while

			$sboxBannerGrp = drawSelectBoxMore("a_no",$arrGrp,"","","","","선택");
			/* 배너 그룹 관리(광고 관리) 위치 정보 리스트 가져오기 */

		break;

		case "bannerList":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			$intPageBlock = 10;
			$intPageLine  = 30;

			$bannerMgr->setLng($S_ST_LNG);
			$bannerMgr->setPageLine($intPageLine);
			$bannerMgr->setSearchStatusY($strSearchStatusY);
			$bannerMgr->setSearchStatusN($strSearchStatusN);
			$bannerMgr->setSearchKey($strSearchKey);
			$bannerMgr->setA_NO($intA_NO);

			$intTotal	= $bannerMgr->getTotal($db);

			$intTotPage	= ceil($intTotal / $bannerMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$bannerMgr->setLimitFirst($intFirst);

			$result = $bannerMgr->getList($db);		
		
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		

			/* 배너 그룹 리스트 */
			$bannerMgr->setSearchStatusY("");
			$bannerMgr->setSearchStatusN("");
			$bannerMgr->setSearchKey("");
			$bannerMgr->setSearchKey("");
			$bannerGrpResult = $bannerMgr->getAdvertiseList($db);
			/* 배너 그룹 리스트 */
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchStatusY=$strSearchStatusY&searchStatusN=$strSearchStatusN";
			$linkPage .= "&page=";

		break;
		
		case "bannerModify":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			$bannerMgr->setB_NO($intB_NO);
			$row = $bannerMgr->getView($db);

			/* 배너 그룹 관리(광고 관리) 위치 정보 리스트 가져오기 */
			$arrAdvertiseListRow = $bannerMgr->getAdvertiseListAll($db);
			
			while($alRow = mysql_fetch_array($arrAdvertiseListRow))
			{
				$arrGrp[$alRow[A_NO]] = $alRow[A_NAME];
				
			} // while

			$sboxBannerGrp = drawSelectBoxMore("a_no",$arrGrp,$row[A_NO],"","","","선택");
			/* 배너 그룹 관리(광고 관리) 위치 정보 리스트 가져오기 */

/** 2013.04.26 다국어 버전으로 변경하면서 삭제 **/
//			if($row[B_FILE] && $row[B_TYPE] == "F") {
//				$bImage		= "<script type='text/javascript'>insertFlash('../upload/banner/".$row[B_FILE]."', '100', '50', '', '', '');</script>";
//			}
//			else if($row[B_FILE]) {
//				$bImage = "<img style='width:78px;margin-top:0px;display:block;' src='../upload/banner/".$row[B_FILE]."' alt='배너이미지'/>";
//			}

		break;
		
		case "pointList":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			$pointMgr->setSearchKey($strSearchKey);
			$pointMgr->setSearchField($strSearchField);
			$pointMgr->setSearchPointType($strSearchPointType);
			$pointMgr->setSearchSex($strSearchSex);
			$pointMgr->setSearchRegStartDt($strSearchRegStartDt);
			$pointMgr->setSearchRegEndDt($strSearchRegEndDt);
			$pointMgr->setSearchExpStartDt($strSearchExpStartDt);
			$pointMgr->setSearchExpEndDt($strSearchExpEndDt);
			$pointMgr->setSearchPointStart($strSearchPointStart);
			$pointMgr->setSearchPointEnd($strSearchPointEnd);
			$pointMgr->setSearchBirthMonth($strSearchBirthMonth);
			$pointMgr->setSearchBirthDay($strSearchBirthDay);

			/* 데이터 리스트 */
			$intTotal								= $pointMgr->getPointList( $db, "OP_COUNT" );								// 데이터 전체 개수 

			$intPageLine							= ( $intPageLine )			? $intPageLine	: 10;																		// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );
			$pointMgr->setLimitFirst($intFirst);
			$pointMgr->setPageLine($intPageLine);

			$result									= $pointMgr->getPointList( $db, "OP_LIST" );

			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );
			/* 데이터 리스트 */	
				
			$pointSumRow							= $pointMgr->getPointList( $db, "OP_SUM" );
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchPointType=$strSearchPointType&pageLine=$intPageLine";
			$linkPage .= "&page=";

			/* 포인트 종류 배열 */
			$aryPointTypeList = getCommCodeList('point');

		break;

//		case "pointList":
//			
//			/* 관리자 Sub Menu 권한 설정 */
//			$strLeftMenuCode01 = "003";
//			$strLeftMenuCode02 = "001";
//			/* 관리자 Sub Menu 권한 설정 */
//
//			$intPageBlock = 10;
//			$intPageLine  = 10;
//			$pointMgr->setPageLine($intPageLine);
//			$pointMgr->setSearchKey($strSearchKey);
//			$pointMgr->setSearchField($strSearchField);
//			$pointMgr->setSearchPointType($strSearchPointType);
//
//			$intTotal	= $pointMgr->getPointTotal($db);
//			
//			$intTotPage	= ceil($intTotal / $pointMgr->getPageLine());
//
//			if(!$intPage)	$intPage =1;
//
//			if ($intTotal==0) {
//				$intFirst	= 1;
//				$intLast	= 0;			
//			} else {
//				$intFirst	= $intPageLine *($intPage -1);
//				$intLast	= $intPageLine * $intPage;
//			}
//			$pointMgr->setLimitFirst($intFirst);
//
//			$result = $pointMgr->getPointList($db);		
//		
//			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
//			
//			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
//			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
//			$linkPage .= "&searchPointType=$strSearchPointType";
//			$linkPage .= "&page=";
//
//			/* 포인트 종류 배열 */
//			$aryPointTypeList = getCommCodeList('point');
//
//		break;
	}

	if (!$includeFile){
		$includeFile = $strIncludePath.$strMode.".php";
	}

?>
<script type="text/javascript">
<!--
	/** 이벤트 정의 **/
	function goBannderMoveEvent(lng) { goBannderMove(lng); }


	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		
		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
		$('input[name=searchExpStartDt]').simpleDatepicker();
		$('input[name=searchExpEndDt]').simpleDatepicker();

	});

	/* 팝업관리 */
	function goMoveUrl(mode,no)
	{
		
		if (mode == "popupModify" || mode == "popupDelete" || mode == "bannerModify" || mode == "bannerDelete" || mode == "adverModify" || mode == "adverDelete" || mode == "bannerDesignWrite") 
		{
			if (mode == "popupModify" || mode == "popupDelete")
			{
				document.form.po_no.value = no;
			} else if (mode == "adverModify" || mode == "adverDelete") {
				document.form.a_no.value = no;
			} else {
				document.form.b_no.value = no;
			}

			if (mode == "popupDelete" || mode == "bannerDelete" || mode == "adverDelete")
			{
				var  x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 데이타를 삭제하시겠습니까?
				if (x == true)
				{
					C_getAction(mode,"<?=$PHP_SELF?>")
				}
			}else if (mode == "bannerDesignWrite")
			{
				C_getAction(mode,"<?=$PHP_SELF?>")
			} else {
				C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
			}

		
		} else {

			C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
		}
	}

	function goPopupAct(mode)
	{
		if(!C_chkInput("po_title", true, "<?=$LNG_TRANS_CHAR['EW00005']?>")) return; //팝업제목
		if(!C_chkInput("po_start_dt", true, "<?=$LNG_TRANS_CHAR['EW00007']?>")) return; //팝업시작
		if(!C_chkInput("po_end_dt", true, "<?=$LNG_TRANS_CHAR['EW00007']?>")) return; //팝업종료
		if(!C_chkInput("po_top", true, "<?=$LNG_TRANS_CHAR['EW00013']?>")) return; //TOP위치
		if(!C_chkInput("po_left", true, "<?=$LNG_TRANS_CHAR['EW00014']?>")) return; //LEFT위치
		
		var strPopImg = document.form.b_file.value;
		if (!C_isNull(strPopImg))
		{
			if(!strPopImg.toLowerCase().match(/(.jpg|.jpeg|.gif|.png|.swf)/)) { 
				alert("<?=$LNG_TRANS_CHAR['ES00013']?>"); //팝업이미지는 이미지 파일만 등록하실 수 있습니다.
				return;
			}
		}
		
		document.form.encoding = "multipart/form-data";

		C_getAction(mode,"<?=$PHP_SELF?>");
	}


	function goBannerAct(mode)
	{

		if(!C_chkInput("b_title", true, "<?=$LNG_TRANS_CHAR['EW00005']?>")) return; //베너제목
//		if(!C_chkInput("b_start_dt", true, "<?=$LNG_TRANS_CHAR['EW00007']?>")) return; //베너시작일
//		if(!C_chkInput("b_end_dt", true, "<?=$LNG_TRANS_CHAR['EW00007']?>")) return; //베너종료일
		if(!C_chkInput("b_link_url", true, "<?=$LNG_TRANS_CHAR['EW00008']?>")) return; //링크페이지
//		if(!C_chkInput("b_file", true, "배너이미지")) return;

/** 2013.04.27 플래시 사용 안함 **/
//		var flashOn = document.form.b_type[1].checked;
//		if(flashOn)
//		{
//			if(!C_chkInput("b_width", true, "<?=$LNG_TRANS_CHAR['EW00041']?>")) return; //플래시 가로 사이즈
//			if(!C_chkInput("b_height", true, "<?=$LNG_TRANS_CHAR['EW00042']?>")) return; //플래시 세로 사이즈
//		}

/** 2013.04.27 다국어 버전으로 변경 **/
//		var strBannerImg = document.form.b_file.value;
//		if (!C_isNull(strBannerImg))
//		{
//			if(!strBannerImg.toLowerCase().match(/(.jpg|.jpeg|.gif|.png|.swf)/)) { 
//				alert("<?=$LNG_TRANS_CHAR['ES00013']?>"); //배너이미지는 이미지 파일만 등록하실 수 있습니다.
//				return;
//			}
//		}

		document.form.encoding = "multipart/form-data";

		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goAdverAct(mode)
	{
		if(!C_chkInput("a_name", true, "<?=$LNG_TRANS_CHAR['EW00028']?>")) return; //배너명

		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goSearch()
	{
		C_getMoveUrl("<?=$strMode?>","get","<?=$PHP_SELF?>");
	}

	function eventBType()
	{
		var temp = 		$(":radio[name='b_type']:checked").val();
		
		if(temp == "F")
		{
			$("#flashOptionDiv").css("display","block");	
		}
		else
		{
			$("#flashOptionDiv").css("display","none");
		}
	}

	function goBannerList(no) {
		window.location = "?menuType=oper&mode=bannerList&a_no=" + no;
	}

	/* 포인트 관리 팝업 창 */
	function goMemberOrderView(no){
		C_openWindow("./?menuType=popup&mode=orderView&no="+no,"<?=$LNG_TRANS_CHAR['OW00012']?>","600","600"); //주문정보 상세보기
	}

	/* 회원정보수정 */
	function goMemberModify(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=member&mode=popMemberModify&memberNo='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	/* 레이어창 닫기 */
	function goPopClose()
	{		
		$.smartPop.close();
	}
	
	function goBannderMove(lng) {
		$("#attachImg_"+lng).html("");
		$("#b_file_"+lng.toLowerCase()+"_del").val("Y");
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