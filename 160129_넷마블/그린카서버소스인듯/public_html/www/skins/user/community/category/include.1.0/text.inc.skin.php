<?
	## 설정
	include_once "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
?>
	
<a href="javascript:goCategoryMoveEvent('')"<?if($_REQUEST['ub_bc_no'] == ""){ echo " class='selected'";}?>>All</a>
<?foreach($CATEGORY_LIST as $key => $category):?>
<a href="javascript:goCategoryMoveEvent('<?=$key?>')"<?if($_REQUEST['ub_bc_no'] == $key){ echo " class='selected'";}?>><?=$category['bc_name']?></a>
<?endforeach;?>
