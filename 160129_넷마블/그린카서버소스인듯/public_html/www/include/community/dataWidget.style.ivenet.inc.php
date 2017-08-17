<?
	require_once MALL_HOME . "/modules/community/data/basic.1.0/community.data.view.php";

	$_REQUEST['b_code']		= "NOTICE";
	$_REQUEST['page_line']	= 3;
	$dataView				= new CommunityDataView($db, $_REQUEST);	
	$dataSelectRow			= $dataView->getList();
?>