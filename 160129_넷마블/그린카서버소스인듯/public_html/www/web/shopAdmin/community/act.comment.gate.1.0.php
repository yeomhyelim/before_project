<?
	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.controller.php";
	require_once MALL_HOME . "/modules/community/eventComment/basic.1.0/community.eventComment.controller.php";

	switch($strAct) :
//	2013.05.14 사용 하지 않음. commentCouponGive 으로 변경
//		case "dataCPointGive":
//			// 커뮤니티 코멘트 포인트 지급
//			$commentController			= new CommunityCommentController($db, $_POST);
//			$commentController->getPointGiveProcess();
//	
//		break;
//
//		case "dataCCouponGive":
//			// 커뮤니티 코멘트 쿠폰 지급
//			$commentController			= new CommunityCommentController($db, $_POST);
//			$commentController->getCouponGiveProcess();
//		break;
//
//		case "commentPointGive":
//			// 커뮤니티 코멘트 포인트 수동 지급
//			if($_POST['BOARD_INFO']['b_kind'] == "event"):
//			$commentController			= new CommunityEventCommentController($db, $_POST);
//			$result						= $commentController->getPointGiveProcess();	
//			else:
//			$commentController			= new CommunityCommentController($db, $_POST);
//			$result						= $commentController->getPointGive();	
//			endif;
//		break;
		case "commentPointGive":
			// 커뮤니티 코멘트 포인트 수동 지급
			$commentController			= new CommunityEventCommentController($db, $_POST);
			$result						= $commentController->getPointGiveProcess();	
		break;
		case "commentCouponGive":
			// 커뮤니티 코멘트 쿠폰 수동 지급
			$commentController			= new CommunityEventCommentController($db, $_POST);
			$result						= $commentController->getCouponGiveProcess();	
		break;
		case "commentPointCancel":
			// 커뮤니티 코멘트 포인트 발급 취소
			$commentController			= new CommunityEventCommentController($db, $_POST);
			$result						= $commentController->getPointCancelProcess();	
		break;
		case "commentCouponCancel":
			// 커뮤니티 코멘트 쿠폰 발급 취소
			$commentController			= new CommunityEventCommentController($db, $_POST);
			$result						= $commentController->getCouponCancelProcess();	
		break;
		case "commentDeleteMulti":
			// 커뮤니티 코멘트 삭제
			$commentController			= new CommunityEventCommentController($db, $_POST);
			$result						= $commentController->geDeleteMultiProcess();	
		break;
	endswitch;


?>