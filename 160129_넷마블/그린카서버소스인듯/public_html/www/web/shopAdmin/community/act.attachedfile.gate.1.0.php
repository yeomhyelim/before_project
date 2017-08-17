<?
	require_once MALL_HOME . "/modules/community/attachedfile/basic.1.0/community.attachedfile.controller.php";

	switch($strAct) :
		case "attachedfileTempFileUpload":
			// 커뮤니티 첨부파일 쓰기
			$attachedfileController		= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getTempFileUpload();	

		break;

		case "attachedfileTempFileDelete":
			// 커뮤니티 임스 첨부파일 삭제
			$attachedfileController		= new CommunityAttachedfileController($db, $_POST);
			$attachedfileController->getTempFileDelete();	
		break;
	endswitch;
?>

