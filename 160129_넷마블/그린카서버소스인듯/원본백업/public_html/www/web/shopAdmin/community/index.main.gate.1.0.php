<?

	require_once MALL_HOME . "/modules/community/main/basic.1.0/community.main.view.php";


	switch($strMode) :

		case "boardMain":
			// 커뮤니티 메뉴
			$mainView = new CommunityMainView($db, $_REQUEST);
			$mainView->getMainProcess();
		break;


	endswitch;

?>
