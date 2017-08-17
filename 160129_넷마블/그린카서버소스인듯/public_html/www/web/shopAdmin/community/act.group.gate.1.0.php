<?

	require_once MALL_HOME . "/modules/community/group/basic.1.0/community.group.controller.php";

	switch($strAct) :

		case "groupWrite":	
			// 커뮤니티 그룹 등록
			$groupController			= new CommunityGroupController($db, $_POST);
			$groupController->getWrite();
		break;

		case "groupModify":
			// 커뮤니티 그룹 수정
			$groupController			= new CommunityGroupController($db, $_POST);
			$groupController->getModify();
		break;

		case "groupDelete":
			// 커뮤니티 그룹 삭제
			$groupController			= new CommunityGroupController($db, $_POST);
			$groupController->getDelete();		
		break;

		case "groupTableCreate":	
			// 커뮤니티 그룹 테이블 생성
			$groupController			= new CommunityGroupController($db, $_POST);
			$groupController->getCreateTable();
		break;

		case "groupTableDrop":
			// 커뮤니티 그룹 테이블 삭제
			$groupController			= new CommunityGroupController($db, $_POST);
			$groupController->getDropTable();
		break;

		case "groupProcedureCreate":
			// 커뮤니티 그룹 프로시저 생성
			$groupController			= new CommunityGroupController($db, $_POST);
			$groupController->getCreateProcedure();
		break;

		case "groupProcedureDrop":
			// 커뮤니티 그룹 프로시저 삭제
			$groupController			= new CommunityGroupController($db, $_POST);
			$groupController->getDropProcedure();
		break;
	endswitch;

?>
