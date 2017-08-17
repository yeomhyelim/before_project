<?
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.controller.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.controller.php";

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.controller.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.controller.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.controller.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.controller.php";
	require_once MALL_HOME . "/modules/community/mypage/basic.1.0/community.mypage.controller.php";

	switch($strAct) :

		case "dataTransfer":
			// 데이터 이동
			$dataController			= getCommunityController();
			$dataController->getDataTransferProcess();
		break;

		case "dataWPointGive":
			// 커뮤니티 글 포인트 지급
			$dataController			= getCommunityController();
			$dataController->getPointGiveProcess();
		break;

		case "dataWCouponGive":
			// 커뮤니티 글 쿠폰 지급
			$dataController			= getCommunityController();
			$dataController->getCouponGiveProcess();
		break;

		case "dataWrite":
			// 커뮤니티 글 등록
			$dataController			= getCommunityController();
			$dataController->getWrite();

			$userfieldController	= new CommunityUserfieldController($db, $_POST);
			$userfieldController->getWrite();

			$attachedfileController	= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getWrite();

			$eventInfoController	= new CommunityEventInfoController($db, $_POST);
			$eventInfoController->getWrite();
		break;

		case "dataModify":
			// 커뮤니티 글 수정

			$dataController			= getCommunityController();
			$dataController->getModifyProcess();

			/** 2013.04.10 프로세스 형식으로 변경
			$dataController			= getCommunityController();
			$dataController->getModify();

			$eventInfoController	= new CommunityEventInfoController($db, $_POST);
			$eventInfoController->getWriteModify();
			**/

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

		case "dataDeleteMulti":
			// 커뮤니티 글 다중 삭제
			$dataController			= getCommunityController();
			$dataController->getDeleteMulti();
		break;

		case "dataProcedureCreate":
			// 커뮤니티 글 프로시저 생성
			$dataController			= getCommunityController();
			$dataController->getCreateProcedure();
		break;

		case "dataProcedureDrop":
			// 커뮤니티 그룹 프로시저 삭제
			$dataController			= getCommunityController();
			$dataController->getDropProcedure();
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
		if     ($_POST['BOARD_INFO']['b_kind'] =="data")		{ return  new CommunityDataController($db,  $_POST); }
		else if($_POST['BOARD_INFO']['b_kind'] == "event")		{ return  new CommunityEventController($db, $_POST); }
		else if($_POST['BOARD_INFO']['b_kind'] == "talk")		{ return  new CommunityTalkController($db, $_POST); }
		else if($_POST['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityProductController($db, $_POST); }
		else if($_POST['BOARD_INFO']['b_kind'] == "mypage")		{ return  new CommunityMypageController($db, $_POST); }
	}
?>