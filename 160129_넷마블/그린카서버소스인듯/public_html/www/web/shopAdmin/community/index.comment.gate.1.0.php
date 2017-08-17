<?
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.view.php";
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.view.php";

//	echo $strMode;


	switch($strMode) :
		case "commentExcelDown":
			// 커뮤니티 메뉴
			$commentView			= getCommunityCommentView($db,  $_REQUEST);
			$commentView->getExcelDownProcess();
		break;
		case "commentList":
			// 코멘트 리스트
			$commentView			= getCommunityCommentView($db,  $_REQUEST);
			$commentView->getListProcess();
		break;
	endswitch;

	function getCommunityCommentView($db,  $_REQUEST) {
		if      ($_REQUEST['BOARD_INFO']['b_kind'] =="data")		{ return  new CommunityCommentView($db,  $_REQUEST); }
		else if ($_REQUEST['BOARD_INFO']['b_kind'] == "event")		{ return  new CommunityEventCommentView($db, $_REQUEST); }
		else														{ return  new CommunityCommentView($db,  $_REQUEST); }
	}

?>
