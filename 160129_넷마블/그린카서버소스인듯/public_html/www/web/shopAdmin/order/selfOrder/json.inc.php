<?
	require_once MALL_CONF_LIB."MemberMgr.php";
	
	$memberMgr					= new MemberMgr();

	$intM_NO					= $_POST["memberNo"]			? $_POST["memberNo"]			: $_REQUEST["memberNo"];

	switch($strJsonMode):
	case "memberSelect":
			$memberMgr->setM_NO($intM_NO);
			$row = $memberMgr->getMemberView($db);
			$result[0] = $row;
			$result_array = json_encode($result);
			echo $result_array;	
			$db->disConnect();
			exit;			
	break;
	endswitch;


?>