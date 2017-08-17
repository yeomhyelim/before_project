<?if($_REQUEST['BOARD_INFO']['bi_widget_category_show'] == "Y"): // 카테고리 사용?>
<div class="tabListWrap">
	<?include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/category/include.1.0/{$_REQUEST['BOARD_INFO']['bi_category_skin']}.inc.skin.php";?>
</div>
<?endif;?>

<? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/widget/data/{$_REQUEST['BOARD_INFO']['bi_widget_skin']}.1.0/list.skin.php" ?>