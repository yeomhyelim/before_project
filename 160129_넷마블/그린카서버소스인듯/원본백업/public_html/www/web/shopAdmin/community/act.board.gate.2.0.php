<?
/** 2013.04.06 모듈 안으로 변경 **/
	require_once MALL_HOME . "/modules/community/board/basic.2.0/community.board.controller.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.2.0/community.boardInfo.controller.php";
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.controller.php";

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.controller.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.controller.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.controller.php";

//	echo $strAct;

	switch($strAct) :
		case "boardWrite":
			// 커뮤니티 추가

			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getWrite();	
		break;

		case "boardModifyBasic":
			// 커뮤니티 기본설정 변경

			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getModifyProcess();			

		break;

		case "boardModifyCategory":
			// 커뮤니티 카테고리 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getWriteModify();	
		break;

		case "boardModifyPoint":
			// 커뮤니티 포인트/쿠폰 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getWriteModifyPoint();	
		break;

		case "boardModifyScript":
			// 커뮤니티 스크립트 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getSaveScriptFile();	
			$boardInfoController->getWriteModify();	

		break;
		case "boardModifyScriptWidget":
			// 커뮤니티 스크립트 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getSaveScriptFile();	
			$boardInfoController->getWriteModify();	

		break;
		case "boardTableCreate":	
			// 커뮤니티 테이블 생성
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getCreateTable();
		break;

		case "boardTableDrop":
			// 커뮤니티 테이블 삭제
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getDropTable();
		break;

		case "boardProcedureCreate":
			// 커뮤니티 프로시저 생성
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getCreateProcedure();
		break;

		case "boardProcedureDrop":
			// 커뮤니티 프로시저 삭제
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getDropProcedure();
		break;
		case "boardStop":
			// 커뮤니티 정지
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getStop();	
		break;

		case "boardUse":
			// 커뮤니티 사용
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getUse();	
		break;

		case "boardDrop":
			// 커뮤니티 삭제
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getDropProcess();		
		break;

		case "boardModifyUserfield":
			// 커뮤니티 추가필드 설정 변경

			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getUserfieldModify();
//			$boardInfoController->getUserfieldSet();	
//			$boardInfoController->getWriteModify();	

			$userfieldController		= new CommunityUserfieldController($db, $_POST);
			$userfieldController->getCreateTable();	
		break;
	endswitch;

	function getCommunityView() {
		global $db;
		if     ($_REQUEST['BOARD_INFO']['b_kind'] =="data")		{ return  new CommunityDataController($db,  $_REQUEST); }
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "event")	{ return  new CommunityEventController($db, $_REQUEST); }
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "talk")	{ return  new CommunityTalkController($db,  $_REQUEST); }
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityDataController($db,  $_REQUEST); }
	}
?>