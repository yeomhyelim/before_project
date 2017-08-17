<?

	require_once MALL_HOME . "/modules/community/category/basic.1.0/community.category.controller.php";

	switch($strAct) :

		case "categoryWrite":	
			// 카테고리 등록
			$categoryController			= new CommunityCategoryController($db, $_POST);
			$categoryController->getWrite();
		break;

		case "categoryDelete":
			// 카테고리 삭제
			$categoryController			= new CommunityCategoryController($db, $_POST);
			$categoryController->getDelete();
		break;

		case "categoryModify":
			// 카테고리 수정
			$categoryController			= new CommunityCategoryController($db, $_POST);
			$categoryController->getModify();
		break;
	endswitch;
?>
