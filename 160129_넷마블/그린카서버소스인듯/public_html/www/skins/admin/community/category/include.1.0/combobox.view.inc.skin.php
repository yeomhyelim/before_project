<?
	## 설정
	include_once "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
	$key = $dataSelectRow['UB_BC_NO'];
?>
<?=$CATEGORY_LIST[$key]['bc_name']?>

