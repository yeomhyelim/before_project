<?
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";

	switch($strAct) :
		case "commentSelect":
			// 커뮤니티 코멘트 선택
			$commentController			= new CommunityCommentController($db, $_POST);
			$result						= $commentController->getSelectForModify();	
		break;
		case "commentWrite":
			// 커뮤니티 코멘트 등록

			$commentController			= new CommunityCommentController($db, $_POST);
			$commentController->getWriteProcess();	

			/** 2013.04.10 프로세스 형식으로 변경 
			$commentController			= new CommunityCommentController($db, $_POST);
			$commentController->getWrite();	
			**/
		break;
		
		case "commentModify":
			// 커뮤니티 코멘트 수정
			$commentController			= new CommunityCommentController($db, $_POST);
			$commentController->getDataAuthCheck();
			$commentController->getModify();	
		break;
		case "commentModifyEdit":
			// 커뮤니티 코멘트 선택
			$commentController			= new CommunityCommentController($db, $_POST);
			$commentController->getDataAuthCheck();
			$commentController->getModifyEdit();	
		break;
		case "commentDelete":
			// 커뮤니티 코멘트 삭제
			$commentController			= new CommunityCommentController($db, $_POST);
			$commentController->getDataAuthCheck();
			$commentController->getDelete();		
		break;
		case "commentModifyPass":
			// 커뮤니티 코멘트 비밀번호 체크
			$commentController			= new CommunityCommentController($db, $_POST);
			$commentController->getPassword();	
		break;
	endswitch;

?>
