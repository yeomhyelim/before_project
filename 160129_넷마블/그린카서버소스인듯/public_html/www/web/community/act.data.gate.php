<?

	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.controller.php";

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.controller.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.controller.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.controller.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.controller.php";
	require_once MALL_HOME . "/modules/community/mypage/basic.1.0/community.mypage.controller.php";


	switch($strAct) :
		case "dataWrite":
			// 커뮤니티 글 등록
			$dataController			= getCommunityController();
			$dataController->getWriteProcess();

			/** 2013.04.09 프로세스 형으로 변경 
			$dataController			= getCommunityController();
			$dataController->getWrite();	

			$userfieldController	= new CommunityUserfieldController($db, $_POST);
			$userfieldController->getWrite();	

			$attachedfileController	= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getWrite();
			**/

		break;
		case "dataModify":
			// 커뮤니티 글 수정
			$dataController			= getCommunityController();
			$dataController->getModifyProcess();

//			$dataController			= getCommunityController();
//			$dataController->getModify();
//
//			$userfieldController	= new CommunityUserfieldController($db, $_POST);
//			$userfieldController->getModify();	
//
//			$attachedfileController	= new CommunityAttachedfileController($db, $_POST);
//			$attachedfileController->getModify();
		break;
//		case "dataMPassword":
//		case "dataDPassword":
		case "dataPassword":
			// 커뮤니티 글 비밀번호 확인(작성자 체크)
			$dataController			= getCommunityController();
			$dataController->getPassword();	
		break;
		case "dataDelete":

			// 커뮤니티 글 삭제
			$dataController			= getCommunityController();
			$dataController->getDataAuthCheck();	

			$attachedfileController	= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getDelete();

			$userfieldController	= new CommunityUserfieldController($db, $_POST);
			$userfieldController->getDelete();	

			$commentController		= new CommunityCommentController($db, $_POST);
			$commentController->getDeleteToUB_NO();	

			$dataController->getDelete();	

		break;
		case "dataAnswer":
			$dataController			= getCommunityController();
			$dataController->getAnswer();	

			$attachedfileController	= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getWrite();
		break;
	endswitch;

	function getCommunityController() {
		global $db;
		if     ($_POST['BOARD_INFO']['b_kind'] == "data")		{ return  new CommunityDataController($db,  $_POST);		}
		else if($_POST['BOARD_INFO']['b_kind'] == "event")		{ return  new CommunityEventController($db, $_POST);		}
		else if($_POST['BOARD_INFO']['b_kind'] == "talk")		{ return  new CommunityTalkController($db, $_POST);			}
		else if($_POST['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityProductController($db,  $_POST);	}
		else if($_POST['BOARD_INFO']['b_kind'] == "mypage")		{ return  new CommunityMypageController($db,  $_POST);	}
	}
?>