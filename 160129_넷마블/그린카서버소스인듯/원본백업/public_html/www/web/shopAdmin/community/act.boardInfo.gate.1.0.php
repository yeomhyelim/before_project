<?

	require_once MALL_HOME . "/modules/community/boardInfo/basic.1.0/community.boardInfo.controller.php";


	switch($strAct) :
		case "boardInfoTableCreate":	
			// 커뮤니티 정보 테이블 생성
			$boardInfoController			= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getCreateTable();
		break;

		case "boardInfoTableDrop":
			// 커뮤니티 정보 테이블 삭제
			$boardInfoController			= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getDropTable();
		break;

		case "boardInfoProcedureCreate":
			// 커뮤니티 정보 프로시저 생성
			$boardInfoController			= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getCreateProcedure();
		break;

		case "boardInfoProcedureDrop":
			// 커뮤니티 정보 프로시저 삭제
			$boardInfoController			= new CommunityBoardInfoController($db, $_POST);
			$boardInfoController->getDropProcedure();
		break;
	endswitch;

?>