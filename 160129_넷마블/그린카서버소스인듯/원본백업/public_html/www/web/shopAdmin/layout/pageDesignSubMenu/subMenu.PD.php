<div class="tabSubNaviWrap">
	<a href="./?menuType=layout&mode=pageDesignSave&pageDesign=PD" <?if($strSubPageDesign == "") { echo "class='selected'"; } ?>>상품리스트</a>
	| <a href="./?menuType=layout&mode=pageDesignSave&pageDesign=PD&subPageDesign=searchList" <?if($strSubPageDesign == "searchList") { echo "class='selected'"; } ?>>검색리스트</a>
	<?if($PRODUCT_CATEGORY_MAIN_USE == "Y"):?>
	| <a href="./?menuType=layout&mode=pageDesignSave&pageDesign=PD&subPageDesign=categoryMain" <?if($strSubPageDesign == "categoryMain") { echo "class='selected'"; } ?>>카테고리메인</a>
	<?endif;?>
	| <a href="./?menuType=layout&mode=pageDesignSave&pageDesign=PD&subPageDesign=planMain" <?if($strSubPageDesign == "planMain") { echo "class='selected'"; } ?>>기획전</a>

</div>