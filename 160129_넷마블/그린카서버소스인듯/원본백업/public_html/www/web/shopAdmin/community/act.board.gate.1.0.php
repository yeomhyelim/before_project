<?

	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.controller.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.1.0/community.boardInfo.controller.php";
	require_once MALL_HOME . "/modules/community/{$_POST['b_kind']}/basic.1.0/community.{$_POST['b_kind']}.controller.php";
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.controller.php";


	switch($strAct) :
		case "boardWrite":
			// 커뮤니티 추가

			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getWrite();	

			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getWrite();	

			$dataController				= new CommunityDataController($db, $_POST);
			$dataController->getCreateTable();

			$attachedfileController		= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getCreateTable();	

		break;

		case "boardModifyBasic":
			// 커뮤니티 기본설정 변경
			$boardController			= new CommunityBoardController($db, $_POST);
			$boardController->getModify();	

			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getWriteModify();	
		break;

		case "boardModifyCategory":
			// 커뮤니티 카테고리 설정 변경
		case "boardModifyList":
			// 커뮤니티 리스트 설정 변경
		case "boardModifyView":
			// 커뮤니티 보기 설정 변경
		case "boardModifyWrite":
			// 커뮤니티 쓰기 설정 변경
		case "boardModifyDelete":
			// 커뮤니티 삭제/기타 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getWriteModify();	
		break;

		case "boardModifyScript":
		case "boardModifyScriptWidget":
			// 커뮤니티 스크립트 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getSaveScriptFile();	
			$boardInfoController->getWriteModify();	

		break;

		case "boardModifyComment":
			// 커뮤니티 코멘트 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getWriteModify();		
			
			$commentController		= new CommunityCommentController($db, $_POST);
			$commentController->getCreateTable();	
		break;
		
		case "boardModifyAttachedfile":
			// 커뮤니티 첨부파일 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getWriteModify();	

			$attachedfileController		= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getCreateTable();	
		break;

		case "boardModifyUserfield":
			// 커뮤니티 추가필드 설정 변경
			$boardInfoController		= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getUserfieldSet();	
			$boardInfoController->getWriteModify();	

			$userfieldController		= new CommunityUserfieldController($db, $_POST);
			$userfieldController->getCreateTable();	
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
	endswitch;

?>