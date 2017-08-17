<?

	require_once MALL_HOME . "/modules/community/comment/basic.1.0/community.comment.view.php";
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.view.php";
	require_once MALL_HOME . "/modules/community/userfield/basic.1.0/community.userfield.view.php";

	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";
	require_once MALL_HOME . "/modules/community/event/basic.1.0/community.event.view.php";
	require_once MALL_HOME . "/modules/community/talk/basic.1.0/community.talk.view.php";
	require_once MALL_HOME . "/modules/community/product/basic.1.0/community.product.view.php";

	switch($strAct) :
		
		case "dataList":	
			// 커뮤니티 글 리스트
			$dataView						= getCommunityView();
			$dataListResult					= $dataView->getList();	
		break;
	endswitch;

	function getCommunityView() {
		global $db;
		if     ($_POST['BOARD_INFO']['b_kind'] =="data")		{ return  new CommunityDataView($db,  $_POST);				}
		else if($_POST['BOARD_INFO']['b_kind'] == "event")		{ return  new CommunityEventView($db, $_POST);					}
		else if($_POST['BOARD_INFO']['b_kind'] == "talk")		{ return  new CommunityTalkView($db, $_POST);					}
		else if($_POST['BOARD_INFO']['b_kind'] == "product")	{ return  new CommunityProductView($db, $_POST);			}
	}
?>
