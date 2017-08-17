<?
	if($S_COMMUNITY_VERSION):
		if(in_array($strMode, array("prodInquiry"))):
			$strCommunityVersion = $S_COMMUNITY_VERSION;
			$strCommunityVersionLower = strtolower($strCommunityVersion);
			//include_once MALL_HOME . "/web/product/productInquiry.popup.inc.php";
			//$strMode = $_POST["mode"] ? $_POST["mode"] : $_REQUEST["mode"];
			//$strMode = $_POST["prodCode"] ? $_POST["prodCode"] : $_REQUEST["prodCode"];
			//&mode=prodInquiry&prodCode=2015042900001
			
			include_once MALL_HOME . "/web/product/index.php";
			exit;
		endif;
		if(in_array($strMode, array("list","dataList","dataWrite","dataWriteProd","dataView","dataModify","dataPassword","dataAnswer"))):
			$strCommunityVersion = $S_COMMUNITY_VERSION;
			$strCommunityVersionLower = strtolower($strCommunityVersion);
			include_once MALL_HOME . "/web/community_{$strCommunityVersionLower}/index.php";
			exit;
		endif;
		if(in_array($strAct, array("dataWrite","dataModify","dataDelete","dataPasswordCheck","atcWrite","atcDelete","dataAnswer"))):
			$strCommunityVersion = $S_COMMUNITY_VERSION;
			$strCommunityVersionLower = strtolower($strCommunityVersion);
			include_once MALL_HOME . "/web/community_{$strCommunityVersionLower}/index.php";
			exit;
		endif;
	endif;


	## 2014.06.13 kim hee sung version 2.0
	if(in_array($strAct, array("commentList","commentWrite","commentModify","commentDelete","commentReplyWrite", "commentReplyData"))):
		include_once "{$strMode}.php";
		exit;
	endif;

	## 예외사항 include
	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;

	## STEP 1.
	## mode 값 가져오기
	if($strMenuType == "community") :
		$strMode = $_POST["mode"] ? $_POST["mode"] : $_REQUEST["mode"];
	endif;


	## STEP 2.
	## 액션 실행 영역
	## mode 값이 act 인 경우 act.php 실행.
	if($strMode == "act" || $strMode == "json"):
		include "act.php";
		$strMode = $_POST['mode'];
		if($strMode == "act" || $strMode == "json") {  exit; }
	endif;

	## STEP 3.
	## 비밀번호 입력후 처리 하는 경우 $_POST 방식으로 전송됨.
	if($_POST) { $_REQUEST = $_POST; }

	## STEP 4.
	## BOARD_INFO 정보
	$boardInfo = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$_REQUEST['b_code']}.info.php";

	if(!is_file($boardInfo)) { echo "설정 파일이 없습니다.", exit; }
	require_once $boardInfo;

	/* 첫 페이지 설정 */
	if(!$strMode):
		$strMode = "dataList";
		if($_REQUEST['myTarget'] != "mypage"):
			$strMode = $BOARD_INFO[$_REQUEST['b_code']]['bi_start_mode'];
		endif;
	endif;

	$_REQUEST['BOARD_INFO']									= $BOARD_INFO[$_REQUEST['b_code']];
	$_REQUEST['S_FIX_PROD_LIST_USER_FLAG']					= $S_FIX_PROD_LIST_USER_FLAG;
	$_REQUEST['S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST']		= $S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST;

	## 사용자 정의 변수 선언
	$USER_REQUEST['ub_bc_no']		= $_REQUEST['ub_bc_no'];	// 현제 페이지 카테고리 번호
	$USER_REQUEST['b_code']			= $_REQUEST['b_code'];		// 현제 페이지 카테고리 번호


	## STEP 5.
	## 사용자 스킨인경우 해당 사이트 커뮤니티 index 로 이동.
	if($_REQUEST['BOARD_INFO']['b_skin'] == "user"):
		if($strDevice == "m"):
			include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/mobile/html/community/index.php";
		else:
			include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/html/community/index.php";
		endif;
		exit;
	endif;
	if($strDevice) {
		if($_REQUEST['BOARD_INFO']['b_skin']=="user") { $_REQUEST['BOARD_INFO']['b_skin'] = "basic"; }
	}



	## STEP 6.
	## 요청한 페이지의 모듈, 모드별 폴더 설정.
	$aryModeFolder	= array(	"dataList"				=> "data",
								"dataView"				=> "data",
								"dataWrite"				=> "data",
								"dataModify"			=> "data",
								"dataTable"				=> "data",
								"dataPassword"			=> "data",
								"dataMPassword"			=> "data",
								"dataDPassword"			=> "data",
								"dataAnswer"			=> "data",
								"commentModifyEdit"		=> "comment",
								"dataMenuList"			=> "menu",
								"attachedfileWrite"		=> "attachedfile",							);

	## STEP 7.
	## 기본 설정 정보 등록
	$I_MODE								= $aryModeFolder[$strMode];
	$_REQUEST['device']					= $strDevice;
	$_REQUEST['S_DOCUMENT_ROOT']		= $S_DOCUMENT_ROOT;
	$_REQUEST['S_SHOP_HOME']			= $S_SHOP_HOME;
	$_REQUEST['S_SITE_LNG']				= $S_SITE_LNG;
	$_REQUEST['mode']					= &$strMode;
	$_REQUEST['S_PAGE_AREA']			= "userPage";

	## STEP 8.
	## MODE별 INDEX 파일 호출
	include_once "index.{$I_MODE}.php";

	## STEP 9.
	## MODE별 GATE 파일 호출
	include "index.{$I_MODE}.gate.php";

	## STEP 7.
	## 링크
	include "index.{$I_MODE}.link.php";

	## STEP 7.
	## 수행을 종료하고 해당 페이지로 이동.
	$db->disConnect();
	## STEP 8.
	## 수행을 종료하고 Json 메시지를 출력, 혹은 해당 페이지로 이동.
	if($_REQUEST['act'] == "json"):
		$result				= $_REQUEST['result'];
		$result_array		= array();
		$result_array		= json_encode($result);
		echo $result_array;
		exit;
	elseif($_REQUEST['act']):
		goUrl($STR_MSG[$_REQUEST['act']],$STR_URL[$_REQUEST['act']]);
		exit;
	endif;


	## STEP 9.
	## includeFile 설정.
	if(!getPageLock()) { $_REQUEST['includeFile'] = "lock"; }	// 권한체크
	$includeFile = ($_REQUEST['includeFile']) ? $aryIncludeFile[$_REQUEST['includeFile']] : $aryIncludeFile['basic'];
	//echo $includeFile;

	## STEP 10.
	## HTML 파일 호출
	if($strDevice):
		include ($_REQUEST['myTarget']) ? "{$strDevice}.index.html.{$_REQUEST['myTarget']}.php" : "{$strDevice}.index.html.php";
	else:
		include ($_REQUEST['myTarget']) ? "index.html.{$_REQUEST['myTarget']}.php" : "index.html.php";
	endif;
?>
