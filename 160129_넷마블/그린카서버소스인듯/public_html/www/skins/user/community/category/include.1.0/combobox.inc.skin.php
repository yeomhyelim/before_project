<?
	## 설정
	include_once "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
?>

<select name="ub_bc_no" style="width:200px;" onChange="goCategoryMoveEvent($(this).val())">
	<option value=""><?=$LNG_TRANS_CHAR["CW00064"] //Category ?></option>
	<?foreach($CATEGORY_LIST as $key => $category):?>
	<option value="<?=$key?>"<?if($_REQUEST['ub_bc_no']==$key){echo " selected";}?>><?=$category['bc_name']?></option>
	<?endforeach;?>
</select>