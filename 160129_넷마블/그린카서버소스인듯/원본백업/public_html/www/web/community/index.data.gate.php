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
		
		case "dataList":	
			// 커뮤니티 글 리스트

			$dataView						= getCommunityView();
			$dataView->getListProcess();
			
		break;

		case "dataView":
			// 커뮤니티 글 보기
			$dataView						= getCommunityView();
			$dataView->getViewProcess();

		break;

		case "dataWrite":
			// 커뮤니티 글 쓰기
			$dataView						= getCommunityView();
			$dataView->getWriteProcess();

		break;

		case "dataModify":
			// 커뮤니티 글 수정
			$dataView						= getCommunityView();
			$dataView->getModifyProcess();

		break;

		case "dataPassword":
			// 커뮤니티 글 비밀번호
			$dataView						= getCommunityView();
		break;
		
		case "dataAnswer":
			// 커뮤니티 글 답변
			$dataView						= getCommunityView();
			$dataView->getDataAuthCheck();	
			$dataSelectRow					= $dataView->getSelect();
		break;
	endswitch;

?>
