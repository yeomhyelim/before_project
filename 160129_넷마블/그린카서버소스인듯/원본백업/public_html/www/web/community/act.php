<?
	$_POST = $_REQUEST;

	## STEP 1.
	## BOARD_INFO 정보
	require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/board.{$_POST['b_code']}.info.php";
	$_POST['BOARD_INFO']	 = $BOARD_INFO[$_POST['b_code']]; 

	## STEP 2.
	## 요청한 페이지의 모듈, 액션별 폴더 설정.
	$aryActFolder	= array(	"dataList"						=> "dataView",
								"dataWrite"						=> "data",
								"dataModify"					=> "data",
								"dataPassword"					=> "data",
//								"dataMPassword"					=> "data",
//								"dataDPassword"					=> "data",
								"dataDelete"					=> "data",
								"dataAnswer"					=> "data",
								"talkWrite"						=> "talk",
								"talkSelect"					=> "talk",
								"talkModify"					=> "talk",
								"talkDelete"					=> "talk",
								"commentSelect"					=> "comment",
								"commentWrite"					=> "comment",
								"commentModify"					=> "comment",
								"commentModifyEdit"				=> "comment",
								"commentDelete"					=> "comment",
								"commentModifyPass"				=> "comment",
								"attachedfileTempFileUpload"	=> "attachedfile",
								"attachedfileTempFileDelete"	=> "attachedfile",					);

	## STEP 3.
	## 기본 설정 정보 등록
	$I_ACT							= $aryActFolder[$_POST['act']];
	$_POST['S_DOCUMENT_ROOT']		= $S_DOCUMENT_ROOT;
	$_POST['S_SHOP_HOME']			= $S_SHOP_HOME;
	$_POST['S_SITE_LNG']			= $S_SITE_LNG;
	$_POST['S_PAGE_AREA']			= "userPage";

//	## STEP 4.
//	## 게시판 종류에 따른 분류.
//	include "act.kind.php";

	## STEP 5.
	## ACT별 INDEX 파일 호출
	include "act.{$I_ACT}.php";

	## STEP 6.
	## ACT별 GATE 파일 호출
	include "act.{$I_ACT}.gate.php";

	## STEP 7.
	## 링크
	include "act.{$I_ACT}.link.php";


	## STEP 8.
	## 수행을 종료하고 Json 메시지를 출력, 혹은 해당 페이지로 이동.
	if($_POST['mode'] == "json"):
		$db->disConnect();
		if($_POST['result']):
			$result			= $_POST['result'];
		endif;
		$result_array		= array();
		$result_array		= json_encode($result);
		echo $result_array;	
		exit;
	elseif($_POST['mode'] == "act"):
		if($_POST['myTarget']=="pop"):
			echo "<script>opener.location.reload();self.close();</script>";
			$db->disConnect();
			exit;
		endif;
		$db->disConnect();
		goUrl($STR_MSG[$_POST['act']],$STR_URL[$_POST['act']]);
		exit;
	endif;

	## STEP 9.
	## 페이지를 바로 호출시, act 삭제
	$_POST['act'] = "";
?>
