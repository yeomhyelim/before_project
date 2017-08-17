<?

	require_once MALL_HOME . "/modules/community/group/basic.1.0/community.group.view.php";

	switch($strMode) :

		case "groupWrite":	
			// 커뮤니티 그룹 등록
			$groupView			= new CommunityGroupView($db, $_REQUEST);
			$groupListResult	= $groupView->getList();
			$link				= "./?menuType={$strMenuType}&mode={$strMode}&page=";
		break;

		case "groupModify":
			// 커뮤니티 그룹 수정
			$groupView			= new CommunityGroupView($db, $_REQUEST);
			$groupSelectRow		= $groupView->getSelect();
			$groupListResult	= $groupView->getList();
			$link				= "./?menuType={$_REQUEST['menuType']}&mode={$_REQUEST['mode']}&bg_no={$_REQUEST['bg_no']}&page=";
		break;
	endswitch;

?>
