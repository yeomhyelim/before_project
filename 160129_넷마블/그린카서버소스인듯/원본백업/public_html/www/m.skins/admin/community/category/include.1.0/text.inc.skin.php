<?
	## 설정
	include_once "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
?>
	
<a href="javascript:goCategoryMoveEvent('')">전체</a>
<?foreach($CATEGORY_LIST as $key => $category):?>
<a href="javascript:goCategoryMoveEvent('<?=$key?>')"><?=$category['bc_name']?></a>
<?endforeach;?>
