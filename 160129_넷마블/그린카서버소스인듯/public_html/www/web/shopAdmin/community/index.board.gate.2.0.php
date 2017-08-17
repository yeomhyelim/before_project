<?

	require_once MALL_HOME . "/modules/community/board/basic.1.0/community.board.view.php";
	require_once MALL_HOME . "/modules/community/boardInfo/basic.1.0/community.boardInfo.view.php";
	require_once MALL_HOME . "/modules/community/group/basic.1.0/community.group.view.php";
	require_once MALL_HOME . "/modules/community/category/basic.1.0/community.category.view.php";

	switch($strMode) :
		case "boardNonList":
			// 커뮤니티 리스트(사용정지된 게시판)
			$_REQUEST['b_use']  = "N";
		case "boardList":	
			// 커뮤니티 리스트
			$boardView			= new CommunityBoardView($db, $_REQUEST);
			$boardListResult	= $boardView->getList();
		break;
		
		case "boardWrite":
			// 커뮤니티 생성
			$groupView			= new CommunityGroupView($db, $_REQUEST);
			$groupList2			= $groupView->getAryList();
		break;

		case "boardModifyPoint":
			// 포인트/쿠폰 설정
			$boardInfoView		= new CommunityBoardInfoView($db, $_REQUEST);
			$boardInfoView->getModifyPoint();	
		break;
		case "boardModifyScript":
		case "boardModifyBasic":
		case "boardModifyUserfield":  // 2013.11.21 kim hee sung 소스 정리를 하면서 해당 스킨에서 처리함.
		case "boardModifyScriptWidget":
			// 커뮤니티 설정

			$boardView			= new CommunityBoardView($db, $_REQUEST);
			$boardSelectRow		= $boardView->getSelect();	

			$boardInfoView		= new CommunityBoardInfoView($db, $_REQUEST);
			$boardInfoAry		= $boardInfoView->getAryList();	

/** 2013.04.16 첨부파일에서 호출하도록 변경 
 *			$groupView			= new CommunityGroupView($db, $_REQUEST);
 *			$groupList2			= $groupView->getAryList();
 **/
		break;

		case "boardModifyCategory":
			// 커뮤니티 카테고리 설정
			$boardView			= new CommunityBoardView($db, $_REQUEST);
			$boardSelectRow		= $boardView->getSelect();	

			$boardInfoView		= new CommunityBoardInfoView($db, $_REQUEST);
			$boardInfoAry		= $boardInfoView->getAryList();	

			$groupView			= new CommunityGroupView($db, $_REQUEST);
			$groupList2			= $groupView->getAryList();

			$categoryView		= new CommunityCategoryView($db, $_REQUEST);
			$categoryListResult	= $categoryView->getList();
			$categoryListRow	= $categoryView->getSelect();
	endswitch;

?>
