<?

	require_once MALL_HOME . "/modules/community/menu/basic.1.0/community.menu.view.php";

	switch($strMode) :
		
		case "dataMenuList":	
			// 커뮤니티 글 리스트
			$dataMenu			= new CommunityMenuView($db, $_REQUEST);
			$dataMenu->getDataMenuList();								  
		break;

	endswitch;

?>
