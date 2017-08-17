<?

	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.controller.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.controller.php";

	switch($strAct) :
		case "talkWrite":
			// 커뮤니티 글 등록
			$dataController			= new CommunityTalkController($db, $_POST);
			$dataController->getWrite();	

			$userfieldController	= new CommunityUserfieldController($db, $_POST);
			$userfieldController->getWrite();	

			$attachedfileController	= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getWrite();
		break;
		case "talkSelect":
			// 커뮤니티 토크 글 선택
			$dataController			= new CommunityTalkController($db, $_POST);
			$result					= $dataController->getSelectForModify();	
		break;
		case "talkModify":
			// 커뮤니티 토크 글 수정
			$dataController			= new CommunityTalkController($db, $_POST);
			$result					= $dataController->getModify();	
		break;
		case "talkDelete":
			// 커뮤니티 토크 글 삭제
			$dataController			= new CommunityTalkController($db, $_POST);
			$result						= $dataController->getDelete();	
		break;
	endswitch;

?>
