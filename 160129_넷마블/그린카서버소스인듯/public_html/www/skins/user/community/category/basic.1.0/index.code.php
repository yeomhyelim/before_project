<?
	## STEP 1.
	## CATEGORY_INFO 정보
	if($_REQUEST['BOARD_INFO']['bi_category_use']=="Y"):
		$categoryInfo = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
		if(is_file($categoryInfo)):
			include $categoryInfo;
			include "{$_REQUEST['BOARD_INFO']['bi_category_skin']}.inc.skin.php";
		endif;
	endif;
?>

