<?
	#/conf/shop.manual.inc.php에 설정되어 있음.
	if($S_COMMUNITY_VERSION):
		if(in_array($strMode, array("boardWrite","groupList","boardModifyBasic","boardModifyUserfield","boardModifyCategory","boardModifyScript","dataList","dataWrite","boardList","dataView","dataModify","dataAnswer","boardMain","boardNonList"))):
			$strCommunityVersion = $S_COMMUNITY_VERSION;
			$strCommunityVersionLower = strtolower($strCommunityVersion);
			include_once MALL_HOME . "/web/shopAdmin/community_{$strCommunityVersionLower}/index.php";
			exit;
		endif;
	endif;

	## STEP 1.
	## 액션 실행 영역
	## mode 값이 act 인 경우 act*.php 실행.
	if($strMode == "act" || $strMode == "json"):
		include dirname(__FILE__) . "/act.php";
		exit;
	endif;

	## STEP 2.
	## 버전 설정
	$S_VERSION['board']			= "2.0";
	$S_VERSION['boardInfo']		= "1.0";
	$S_VERSION['comment']		= "1.0";
	$S_VERSION['group']			= "1.0";
	$S_VERSION['main']			= "1.0";
	$S_VERSION['data']			= "1.0";
	$S_VERSION['attachedfile']	= "1.0";

	## STEP 3.
	## BOARD_INFO 정보
	if(!in_array($_REQUEST['mode'], array("boardList","boardNonList","boardTable","boardWrite","groupWrite","groupModify","groupTable","boardInfoTable", "boardMain","boardIconList"))):
		$boardInfo = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$_REQUEST['b_code']}.info.php";
		if(!is_file($boardInfo)) { echo "설정 파일이 없습니다.", exit; }
		require_once $boardInfo;
		if(!$strMode) { $strMode = $BOARD_INFO[$_REQUEST['b_code']]['bi_start_mode']; } /* 첫 페이지 설정 */
		$_REQUEST['BOARD_INFO']	 = $BOARD_INFO[$_REQUEST['b_code']]; 
	endif;

	## STEP 4.
	## 요청한 페이지의 모듈, 모드별 폴더 설정.
	$aryModeFolder	= array(	"boardList"					=> "board",
								"boardNonList"				=> "board",
								"boardStopList"				=> "board",
								"boardWrite"				=> "board",
								"boardTable"				=> "board",
								"boardModifyBasic"			=> "board",
								"boardModifyScript"			=> "board",
								"boardModifyCategory"		=> "board",
								"boardModifyPoint"			=> "board",
								"boardModifyList"			=> "board",
								"boardModifyView"			=> "board",
								"boardModifyWrite"			=> "board",
								"boardModifyDelete"			=> "board",
								"boardModifyComment"		=> "board",
								"boardModifyAttachedfile"	=> "board",
								"boardModifyUserfield"		=> "board",
								"boardModifyScriptWidget"	=> "board",
								"sampleSkin"				=> "board",	
								"boardInfoTable"			=> "boardInfo",
								"commentTable"				=> "comment",
								"groupWrite"				=> "group",
								"groupModify"				=> "group",	
								"groupTable"				=> "group",
								"boardMain"					=> "main",
								"dataList"					=> "data",
								"dataView"					=> "data",
								"dataWrite"					=> "data",
								"dataModify"				=> "data",
								"dataTable"					=> "data",
								"dataAnswer"				=> "data",
								"attachedfileWrite"			=> "attachedfile",
								"commentExcelDown"			=> "comment",
								"commentList"				=> "comment",
								"boardIconList"				=> "board",
								);

	## STEP 7.
	## 버튼 권한
	## 1차 - 006 : 커뮤니티
	## 2차 - 001 : 커뮤니티 관리, 002 : 커뮤니티 게시판	
	## 3차 - 901 : 게시판관리, 902 : 정지된 게시판, 903 : 그룹관리	
	$aryTopMenuCode['community']						= "006";
	
	$aryLeftMenuCode01['boardList']						= "001";	
	$aryLeftMenuCode01['boardWrite']					= "001";
	$aryLeftMenuCode01['boardModifyBasic']				= "001";
	$aryLeftMenuCode01['boardModifyCategory']			= "001";
	$aryLeftMenuCode01['boardModifyPoint']				= "001";
	$aryLeftMenuCode01['boardModifyUserfield']			= "001";
	$aryLeftMenuCode01['boardModifyScript']				= "001";
	$aryLeftMenuCode01['boardModifyScriptWidget']		= "001";
	$aryLeftMenuCode01['boardNonList']					= "001";
	$aryLeftMenuCode01['groupWrite']					= "001";
	$aryLeftMenuCode01['groupModify']					= "001";
	$aryLeftMenuCode01['dataList']						= "002";
	$aryLeftMenuCode01['dataView']						= "002";
	$aryLeftMenuCode01['dataWrite']						= "002";
	$aryLeftMenuCode01['dataModify']					= "002";
	$aryLeftMenuCode01['dataAnswer']					= "002";

	$aryLeftMenuCode02['boardList']						= "901";
	$aryLeftMenuCode02['boardWrite']					= "901";
	$aryLeftMenuCode02['boardModifyBasic']				= "901";
	$aryLeftMenuCode02['boardModifyCategory']			= "901";
	$aryLeftMenuCode02['boardModifyPoint']				= "901";
	$aryLeftMenuCode02['boardModifyUserfield']			= "901";
	$aryLeftMenuCode02['boardModifyScript']				= "901";
	$aryLeftMenuCode02['boardModifyScriptWidget']		= "901";
	$aryLeftMenuCode02['boardNonList']					= "902";
	$aryLeftMenuCode02['groupWrite']					= "903";
	$aryLeftMenuCode02['groupModify']					= "903";
	$aryLeftMenuCode02['dataList']						= str_pad($_REQUEST['BOARD_INFO']['b_no'], 3, "0", STR_PAD_LEFT);
	$aryLeftMenuCode02['dataView']						= str_pad($_REQUEST['BOARD_INFO']['b_no'], 3, "0", STR_PAD_LEFT);
	$aryLeftMenuCode02['dataWrite']						= str_pad($_REQUEST['BOARD_INFO']['b_no'], 3, "0", STR_PAD_LEFT);
	$aryLeftMenuCode02['dataModify']					= str_pad($_REQUEST['BOARD_INFO']['b_no'], 3, "0", STR_PAD_LEFT);
	$aryLeftMenuCode02['dataAnswer']					= str_pad($_REQUEST['BOARD_INFO']['b_no'], 3, "0", STR_PAD_LEFT);

	$strTopMenuCode		= $aryTopMenuCode[$_REQUEST['menuType']];		
	$strLeftMenuCode01	= $aryLeftMenuCode01[$_REQUEST['mode']];		
	$strLeftMenuCode02	= $aryLeftMenuCode02[$_REQUEST['mode']];	
	
//	echo $strTopMenuCode . "-" . $strLeftMenuCode01 . "-" . $strLeftMenuCode02;

	## STEP 5.
	## 기본 설정 정보 등록
	$I_MODE								= $aryModeFolder[$strMode];
	$_REQUEST['S_DOCUMENT_ROOT']		= $S_DOCUMENT_ROOT;
	$_REQUEST['S_SHOP_HOME']			= $S_SHOP_HOME;
	$_REQUEST['mode']					= &$strMode;
	$_REQUEST['S_PAGE_AREA']			= "adminPage";
//	if(!$_REQUEST['lang']) { $_REQUEST['lang'] = $S_ST_LNG; }		// 2014.03.14 기준 언어 코드를 설정해야 하는데 잘못 적용함
	if(!$_REQUEST['lang']) { $_REQUEST['lang'] = $S_SITE_LNG; }
	
	## STEP 6.
	## MODE별 INDEX 파일 호출
	include "index.{$I_MODE}.{$S_VERSION[$I_MODE]}.php";
	## STEP 7.
	## MODE별 GATE 파일 호출
//	echo "index.{$I_MODE}.gate.{$S_VERSION[$I_MODE]}.php";;
	include "index.{$I_MODE}.gate.{$S_VERSION[$I_MODE]}.php";

	## STEP 8.
	## 수행을 종료하고 해당 페이지로 이동.
	$db->disConnect();
	if($_REQUEST['act']):
		echo $_REQUEST['act'];
		goUrl($STR_MSG[$_REQUEST['act']],$STR_URL[$_REQUEST['act']]);
		exit;
	endif;

	## STEP 9.
	## link 설정
	include "index.{$I_MODE}.link.{$S_VERSION[$I_MODE]}.php";
//	echo $includeFile;

	## STEP 9.
	## HTML 파일 호출
	include ($_REQUEST['myTarget']) ? "index.html.{$_REQUEST['myTarget']}.php" : "index.html.php";	


?>

