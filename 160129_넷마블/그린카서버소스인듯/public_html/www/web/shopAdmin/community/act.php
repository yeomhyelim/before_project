<?
	## STEP 1.
	## 버전 설정
	$S_VERSION['board']			= "2.0";
	$S_VERSION['boardInfo']		= "1.0";
	$S_VERSION['category']		= "1.0";
	$S_VERSION['group']			= "1.0";
	$S_VERSION['main']			= "1.0";
	$S_VERSION['data']			= "1.0";
	$S_VERSION['attachedfile']	= "1.0";
	$S_VERSION['comment']		= "1.0";

	## STEP 2.
	## BOARD_INFO 정보
	$infoFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$_POST['b_code']}.info.php";
	if(is_file($infoFile)):
		include $infoFile;
		$_POST['BOARD_INFO']		= $BOARD_INFO[$_POST['b_code']];

		if($_POST['BOARD_INFO']):
			$_POST['b_kind']		= $_POST['BOARD_INFO']['b_kind'];
		endif;
	endif;
	if(!$_POST['b_kind']) { $_POST['b_kind'] = "data"; }

	## STEP 3.
	## 요청한 페이지의 모듈, 액션별 폴더 설정.
	$aryActFolder						= array(			"boardWrite"					=> "board",
															"boardModifyBasic"				=> "board",
															"boardModifyScript"				=> "board",
															"boardModifyCategory"			=> "board",
															"boardModifyPoint"				=> "board",
															"boardModifyList"				=> "board",
															"boardModifyView"				=> "board",
															"boardModifyWrite"				=> "board",
															"boardModifyDelete"				=> "board",
															"boardModifyComment"			=> "board",
															"boardModifyAttachedfile"		=> "board",
															"boardModifyUserfield"			=> "board",
															"boardStop"						=> "board",
															"boardUse"						=> "board",
															"boardDrop"						=> "board",
															"boardTableCreate"				=> "board",
															"boardTableDrop"				=> "board",
															"boardProcedureCreate"			=> "board",
															"boardProcedureDrop"			=> "board",
															"boardModifyScriptWidget"		=> "board",
															"boardInfoTableCreate"			=> "boardInfo",
															"boardInfoTableDrop"			=> "boardInfo",
															"boardInfoProcedureCreate"		=> "boardInfo",
															"boardInfoProcedureDrop"		=> "boardInfo",
															"groupWrite"					=> "group",
															"groupModify"					=> "group",
															"groupDelete"					=> "group",
															"groupTableCreate"				=> "group",
															"groupTableDrop"				=> "group",
															"groupProcedureCreate"			=> "group",
															"groupProcedureDrop"			=> "group",
															"dataAnswer"					=> "data",
															"dataWrite"						=> "data",
															"dataModify"					=> "data",
															"dataDelete"					=> "data",
															"dataDeleteMulti"				=> "data",
															"dataProcedureCreate"			=> "data",
															"dataProcedureDrop"				=> "data",
															"dataWPointGive"				=> "data",
															"dataWCouponGive"				=> "data",
															"dataTransfer"					=> "data",
															"categoryWrite"					=> "category",
															"categoryDelete"				=> "category",
															"categoryModify"				=> "category",
															"attachedfileTempFileUpload"	=> "attachedfile",
															"attachedfileTempFileDelete"	=> "attachedfile",
															"commentPointGive"				=> "comment",
															"commentPointCancel"			=> "comment",
															"commentCouponGive"				=> "comment",
															"commentCouponCancel"			=> "comment",
															"commentDeleteMulti"			=> "comment",
															"dataCPointGive"				=> "comment",
															"dataCCouponGive"				=> "comment",
															"boardIconWrite"				=> "board",
															"boardIconDelete"				=> "board",
															);


	## STEP 4.
	## 기본 설정 정보 등록
	$I_ACT							= $aryActFolder[$strAct];
	$_POST['S_DOCUMENT_ROOT']		= $S_DOCUMENT_ROOT;
	$_POST['S_SHOP_HOME']			= $S_SHOP_HOME;
	$_POST['S_MEMBER_GROUP']		= $S_MEMBER_GROUP;
	$_POST['S_SITE_LNG']			= $S_SITE_LNG;
	$_POST['S_PAGE_AREA']			= "adminPage";
//	if(!$_POST['policyLng']) { $_POST['policyLng'] = $S_SITE_LNG; }
	if(!$_POST['lang']) { $_POST['lang'] = $S_SITE_LNG; } /** 관리자 페이지 관련 언어 세팅 **/
//	if(!$_POST['lang']) { $_POST['lang'] = $S_ST_LNG; } /** 사이트 페이지 관련 언어 세팅 **/

	## 2.0 으로 변경 리스트
	if(in_array($strAct, array("boardIconWrite","boardIconDelete"))) { $S_VERSION[$I_ACT] = "3.0"; }

	## STEP 5.
	## ACT별 INDEX 파일 호출
	include "act.{$I_ACT}.{$S_VERSION[$I_ACT]}.php";

	## STEP 6.
	## ACT별 GATE 파일 호출
	include "act.{$I_ACT}.gate.{$S_VERSION[$I_ACT]}.php";

	## STEP 7.
	## 수행을 종료하고 해당 페이지로 이동.
	if($_POST['mode'] == "json"):
		$db->disConnect();
		if($_POST['result']):
			$result			= $_POST['result'];
		endif;
		if(!$result):
			$result			= print_r($_POST, true);
		endif;
		$result_array		= array();
		$result_array		= json_encode($result);
		echo $result_array;
		exit;
	endif;
	$db->disConnect();

	## STEP 8.
	## 링크
	include "act.{$I_ACT}.link.{$S_VERSION[$I_ACT]}.php";
	## STEP 9.
	## 이동
	goUrl($STR_MSG[$_POST['act']],$STR_URL[$_POST['act']]);

?>
