<div id="topWrap">
	<div class="titleWrap">
		<a href="#menu-left" class="cateOpen"><img src="/himg/mobile/ico_cate.png" alt="Category"></a>
		<h1><a href="/"><img src="<?php echo $S_MOB_LOGO_IMG;?>" alt=""></a></h1>
		<a href="javascript:goLayoutDefaultSearchFormShowEvent()" class="searchBtn"><img src="/himg/mobile/ico_search.png" alt="Search"></a>
		<div class="clr"></div>
	</div>
	<div class="searchWrap hide">
		<div class="searchTop">
			<div class="searchBox">
				<input type="text" name="searchText" value="<?php echo $_GET['searchKey'];?>" data-enter-event="goLayoutDefaultSearchMoveEvent" /><a href="javascript:goLayoutDefaultSearchMoveEvent()" class="btnSearch"><img src="/himg/mobile/ico_search.png" alt="Search" class="icoSearch"></a>
			</div>
			<a href="javascript:goLayoutDefaultSearchFormShowEvent()" class="btnCancle"><?=$LNG_TRANS_CHAR["MW00044"]//취소?></a>
			<div class="clr"></div>
		</div><!--// searchTop -->
	</div><!--// searchWrap -->
</div>