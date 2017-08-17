<?
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.view.php";
	require_once MALL_HOME . "/modules/community/eventInfo/basic.1.0/community.eventInfo.view.php";

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.view.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.view.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.view.php";
	require_once MALL_HOME . "/modules/community/mypage/basic.1.0/community.mypage.view.php";

//	echo $strMode;

	switch($strMode) :
		case "boardMain":
			// 커뮤니티 메뉴
			$dataView			= new CommunityDataView($db, $_REQUEST);
			$dataView->getMainList();
		break;

		case "dataList":	
			// 커뮤니티 글 리스트
			$dataView						= getCommunityView();
			$dataView->getListProcess();

			/**
			# 2013.04.09 프로세스 형식으로 변경 
			$dataView						= getCommunityView();
			$dataListResult					= $dataView->getList();
			**/
		break;

		case "dataView":
			// 커뮤니티 글 보기

			$dataView						= getCommunityView();
			$dataView->getViewProcess();

			/**
			# 2013.04.09 프로세스 형식으로 변경 
			$dataView						= getCommunityView();
			$dataSelectRow					= $dataView->getView();

			$userfieldView					= new CommunityUserfieldView($db, $_REQUEST);
			$userfieldViewRow				= $userfieldView->getView();
		
			$commentView					= new CommunityCommentView($db, $_REQUEST);
			$commentListResult				= $commentView->getList();

			$attachedfileView				= new CommunityAttachedfileView($db, $_REQUEST);
			$attachedfileViewListResult		= $attachedfileView->getList();

			$eventInfoView					= new CommunityEventInfoView($db, $_REQUEST);
			$boardEventInfoAry				= $eventInfoView->getAryList();	
			**/

		break;
		case "dataWrite":
			// 커뮤니티 글 쓰기
			$dataView						= getCommunityView();
			$dataView->getWriteProcess();

			/**
			# 2013.05.13 프로세스 형식으로 변경 
			$dataView						= getCommunityView();
			$dataView->getWrite();
			**/
		break;
		case "dataModify":
			// 커뮤니티 글 수정
			$dataView						= getCommunityView();
			$dataView->getModifyProcess();

			/**
			# 2013.05.13 프로세스 형식으로 변경 
			$dataView						= getCommunityView();
			$dataView->getDataAuthCheck();	
			$dataSelectRow					= $dataView->getModify();

			$userfieldView					= new CommunityUserfieldView($db, $_REQUEST);
			$userfieldViewRow				= $userfieldView->getView();

			$attachedfileView				= new CommunityAttachedfileView($db, $_REQUEST);
			$attachedfileViewListResult		= $attachedfileView->getList();

			$eventInfoView					= new CommunityEventInfoView($db, $_REQUEST);
			$boardEventInfoAry				= $eventInfoView->getAryList();	
			**/
		break;
		case "dataAnswer":
			// 커뮤니티 글 답변
//			$dataView			= getCommunityView();
//			$dataSelectRow		= $dataView->getSelect();
			$dataView						= getCommunityView();
			$dataView->getViewProcess();
		break;
	endswitch;

	function getCommunityView() {
		global $db;
		if     ($_REQUEST['BOARD_INFO']['b_kind'] =="data")		{ return  new CommunityDataView($db,  $_REQUEST); }
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "event")	{ return  new CommunityEventView($db, $_REQUEST); }
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "talk")	{ return  new CommunityTalkView($db, $_REQUEST); }
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityProductView($db, $_REQUEST); }
		else if($_REQUEST['BOARD_INFO']['b_kind'] == "mypage")	{ return  new CommunityMypageView($db, $_REQUEST); }
	}
?>
