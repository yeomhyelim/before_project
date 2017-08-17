<?
	## 설정
	include_once "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
	$key = str_pad($row['UB_BC_NO'], 3, "0", STR_PAD_LEFT);
?>
<?=$CATEGORY_LIST[$key]['bc_name']?>

