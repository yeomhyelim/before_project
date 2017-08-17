<?

	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.view.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.1.0/community.boardInfo.view.php";
	require_once MALL_HOME . "/modules/community/group/basic.1.0/community.group.view.php";
	require_once MALL_HOME . "/modules/community/category/basic.1.0/community.category.view.php";

	switch($strMode) :
	
		case "boardList":	
			// 커뮤니티 리스트
			$boardView			= new CommunityBoardView($db, $_REQUEST);
			$boardListResult	= $boardView->getList();
		break;

		case "boardStopList":
			// 커뮤니티 리스트(정지된)
			$boardView			= new CommunityBoardView($db, $_REQUEST);
			$boardListResult	= $boardView->getStopList();
		break;
		
		case "boardWrite":
			// 커뮤니티 생성
			$groupView			= new CommunityGroupView($db, $_REQUEST);
			$groupList2			= $groupView->getAryList();
		break;

		case "boardModifyBasic":
		case "boardModifyScript":
		case "boardModifyList":
		case "boardModifyView":
		case "boardModifyWrite":
		case "boardModifyDelete":
		case "boardModifyComment":
		case "boardModifyAttachedfile":
		case "boardModifyUserfield":
			// 커뮤니티 설정
			$boardView			= new CommunityBoardView($db, $_REQUEST);
			$boardSelectRow		= $boardView->getSelect();	

			$boardInfoView		= new CommunityBoardInfoView($db, $_REQUEST);
			$boardInfoAry		= $boardInfoView->getAryList();	

			$groupView			= new CommunityGroupView($db, $_REQUEST);
			$groupList2			= $groupView->getAryList();
		break;
		case "boardModifyCategory":
			// 커뮤니티 설정
			$boardView			= new CommunityBoardView($db, $_REQUEST);
			$boardSelectRow		= $boardView->getSelect();	

			$boardInfoView		= new CommunityBoardInfoView($db, $_REQUEST);
			$boardInfoAry		= $boardInfoView->getAryList();	

			$groupView			= new CommunityGroupView($db, $_REQUEST);
			$groupList2			= $groupView->getAryList();

			$categoryView		= new CommunityCategoryView($db, $_REQUEST);
			$categoryListResult	= $categoryView->getList();
			$categoryListRow	= $categoryView->getSelect();
		break;
	endswitch;

?>
